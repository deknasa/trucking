<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Login';

        return view('login', compact('title'));
    }

    /**
     * To proccess login
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return void
     */
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required'
        ], [
            'user.required' => 'USERNAME WAJIB DIISI',
            'password.required' => 'PASSWORD WAJIB DIISI',
        ]);

        $credentials = [
            'user' => $request->user,
            'password' => $request->password
        ];

        $credentialsEmkl = [
            'grant_type' => 'client_credentials',
            'client_id' => config('app.emkl_client_id'),
            'client_secret' => config('app.emkl_client_secret')
        ];

        $dataIp = $credentials;
        // $dataIp['ipclient'] = "192.168.12.3";
        $dataIp['ipclient'] = $request->clientippublic;
        $cekIp = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => true])
            ->get(config('app.api_url') . 'cekIp', $dataIp);

        $isLocal = $cekIp['data']['status'];
        $user = User::where('user', $request->user)->first();
        $cabang = DB::table('cabang')->where('kodecabang', 'PST')->first();

        if (!$isLocal) {


            User::where('user', $request->user)->first();
            if (!$user) {
                return redirect()->back()->withErrors([
                    'user_not_found' => 'Autentikasi Gagal'
                ]);
            }
            $statusaktif = [
                "grp" => "STATUS AKSES",
                "subgrp" => "STATUS AKSES",
                "text" => "PUBLIC"
            ];

            $parameter = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . 'parameter/getparamrequest', $statusaktif);

            if ($user->statusakses != $parameter['id']) {
                return redirect()->back()->withErrors([
                    'user_not_found' => 'User out Of network'
                ]);
            }
        }
        // Auth::user()

        $parametercabang = DB::table('parameter')->where('grp', 'CABANG')->where('subgrp', 'CABANG')->first();
        // dd($parametercabang->text);

        if (Auth::attempt($credentials)) {

            $lat = $request->latitude;
            $long = $request->longitude;
            $credentials['ipclient'] = $request->ip();
            $credentials['ipserver'] = $cekIp['data']['ipserver'];
            $credentials['latitude'] = $lat;
            $credentials['longitude'] = $long;
            $credentials['browser'] = $this->get_client_browser();
            $credentials['os'] = $_SERVER['HTTP_USER_AGENT'];

            $token = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
                ->post(config('app.api_url') . 'token', $credentials);

            $tokenUrlTas ='';
            if ($parametercabang->text == "PUSAT") {
                $credentialsAdmin = [
                    'user' => 'admin',
                    'password' => '123456'
                ];
                $tokenMedan = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post('https://tasmdn.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);

                $tokenJakarta = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post('http://tasjkt.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);

                $tokenJakartaTnl = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post('http://tasjkt.kozow.com:8074/truckingtnl-api/public/api/token', $credentialsAdmin);

                $tokenMakassar = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post('http://tasmks.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);

                $tokenSurabaya = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post('http://tassby.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);

                $tokenBitung = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post('http://tasbtg.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);
            }else{
                $linkUrl =  DB::table('parameter')->where('grp', 'LINK URL')->where('subgrp', 'LINK URL')->first();
                $linkUrlTas = strtolower($linkUrl->text);//http://tasjkt.kozow.com:8074/trucking-api/public/api/
                if ($linkUrlTas != '') {
                     $tokenUrlTas = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->post($linkUrlTas.'token', [
                        'user' => 'ADMIN',
                        'password' => getenv('PASSWORD_TNL'),
                        'ipclient' => '',
                        'ipserver' => '',
                        'latitude' => '',
                        'longitude' => '',
                        'browser' => '',
                        'os' => '',
                    ]);
                }
            }

            $tokenEmkl = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
                ->post(config('app.emkl_api_url') . 'oauth/token', $credentialsEmkl);

            // dd($tokenEmkl->getBody()->getContents());

            session(['access_token' => $token['access_token']]);

            session(['info' => $token['info']]);
            session(['link_url' => strtolower($linkUrl->text)]);

            session(['access_token_emkl' => $tokenEmkl['access_token']]);
            session(['menus' => (new Menu())->getMenu()]);

            if ($parametercabang->text == "PUSAT") {
                session(['access_token_mdn' => $tokenMedan['access_token']]);
                session(['access_token_jkt' => $tokenJakarta['access_token']]);
                session(['access_token_jkttnl' => $tokenJakartaTnl['access_token']]);
                session(['access_token_mks' => $tokenMakassar['access_token']]);
                session(['access_token_sby' => $tokenSurabaya['access_token']]);
                session(['access_token_btg' => $tokenBitung['access_token']]);
            }else{
                if ($linkUrlTas != '') {
                    session(['access_token_url_tas' => $tokenUrlTas['access_token']]);
                }
            }

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors([
                'user_not_found' => 'User not registered'
            ]);
        }
    }

    // Mendapatkan jenis web browser pengunjung
    private function get_client_browser() {
        $browser = '';
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
            $browser = 'Netscape';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
            $browser = 'Firefox';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
            $browser = 'Chrome';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
            $browser = 'Opera';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
            $browser = 'Internet Explorer';
        else
            $browser = 'Other';
        return $browser;
    }

    public function logout()
    {
        Auth::logout();

        session()->forget('menus');
        session()->forget('access_token_mdn');
        session()->forget('access_token_jkt');
        session()->forget('access_token_jkttnl');
        session()->forget('access_token_mks');
        session()->forget('access_token_sby');
        session()->forget('access_token_btg');

        return redirect()->route('login');
    }

    public function cekIp(Request $request)
    {
        $credentials = [
            'user' => $request->user,
            'password' => $request->password,
        ];
        $dataIp = $credentials;
        $dataIp['ipclient'] = $request->ip();
        $cekIp = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => true])
            // ->get("https://tasmdn.kozow.com:8074/trucking-api/public/api/" . 'cekIp', $credentials);
            ->get(config('app.api_url') . 'cekIp', $dataIp);
        dd($cekIp['data']);
    }

    public function cek_param()
    {
        $statusaktif = [
            "grp" => "STATUS AKSES",
            "subgrp" => "STATUS AKSES",
            "text" => "PUBLIC"
        ];
        $parameter = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/getparamrequest', $statusaktif);

        dd($parameter);
    }
}
