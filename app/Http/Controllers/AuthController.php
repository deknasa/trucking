<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Token;

class AuthController extends MyController
{
    public function index()
    {
        $title = 'Login';

        $parametercabang = DB::table('parameter')->where('grp', 'CABANG')->where('subgrp', 'CABANG')->first();
        return view('login', compact('title', 'parametercabang'));
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

        // dd($credentialsEmkl);

        $dataIp = $credentials;
        // $dataIp['ipclient'] = "192.168.12.3";
        $dataIp['ipclient'] = $request->clientippublic;
        $cekIp = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => true])
            ->get(config('app.api_url') . 'cekIp', $dataIp);

        $isLocal = $cekIp['data']['status'];
        $user = User::where('user', $request->user)->first();
        // $cabang = DB::table('cabang')->where('kodecabang', 'PST')->first();

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

                // dd($token->getBody()->getContents());
            $tokenUrlTas = '';
            if ($parametercabang->text == "PUSAT") {
                // $credentialsAdmin = [
                //     'user' => 'admin',
                //     'password' => '123456'
                // ];
                // // $tokenMedan = Http::withHeaders([
                // //     'Content-Type' => 'application/json',
                // //     'Accept' => 'application/json'
                // // ])->post('https://tasmdn.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);
                // // if($tokenMedan->getStatusCode() != 200){
                // //     $tokenMdn = '';
                // // }else{
                // //     $tokenMdn = $tokenMedan['access_token'];
                // // }

                // $tokenJakarta = Http::withHeaders([
                //     'Content-Type' => 'application/json',
                //     'Accept' => 'application/json'
                // ])->post('http://tasjkt.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);

                // $tokenJakartaTnl = Http::withHeaders([
                //     'Content-Type' => 'application/json',
                //     'Accept' => 'application/json'
                // ])->post('http://tasjkt.kozow.com:8074/truckingtnl-api/public/api/token', $credentialsAdmin);

                // $tokenMakassar = Http::withHeaders([
                //     'Content-Type' => 'application/json',
                //     'Accept' => 'application/json'
                // ])->post('http://tasmks.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);

                // $tokenSurabaya = Http::withHeaders([
                //     'Content-Type' => 'application/json',
                //     'Accept' => 'application/json'
                // ])->post('http://tassby.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);

                // $tokenBitung = Http::withHeaders([
                //     'Content-Type' => 'application/json',
                //     'Accept' => 'application/json'
                // ])->post('http://tasbtg.kozow.com:8074/trucking-api/public/api/token', $credentialsAdmin);
                $linkUrl =  DB::table('parameter')->where('grp', 'LINK URL')->where('subgrp', 'LINK URL')->first();

            } else {
                $linkUrl =  DB::table('parameter')->where('grp', 'LINK URL')->where('subgrp', 'LINK URL')->first();
                $linkUrlTas = strtolower($linkUrl->text); //http://tasjkt.kozow.com:8074/trucking-api/public/api/
                if ($linkUrlTas != '') {
                    $tokenUrlTas = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->post($linkUrlTas . 'token', [
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

            $isPostingTNL = DB::table('parameter')->where('grp', 'STATUS POSTING TNL')->where('text', 'POSTING TNL')->first();
            $tokenTNL = '';
            if ($isPostingTNL->default == 'YA') {

                $credentials['user'] = 'ADMIN';
                $credentials['password'] = config('app.password_tnl');
                $getTokenTNL = Http::withHeaders([
                    'Accept' => 'application/json'
                ])->withOptions(['verify' => false])
                    ->post(config('app.trucking_api_tnl') . 'token', $credentials);

                $tokenTNL = $getTokenTNL['access_token'];
            }
            // dd($credentialsEmkl);
            // dd(config('app.emkl_api_url'));
            // dump(config('app.emkl_api_url') . 'oauth/token');
            // dd($credentialsEmkl);
            // $tokenEmkl = Http::withHeaders([
            //     'Accept' => 'application/json'
            // ])->withOptions(['verify' => false])
            //     ->post(config('app.emkl_api_url') . 'oauth/token', $credentialsEmkl);

                // dd($tokenEmkl

            // dd($tokenEmkl->getBody()->getContents());
            // dd($tokenEmkl->Json());
            

            session(['access_token' => $token['access_token']]);
            session(['access_token_tnl' => $tokenTNL]);
            session(['cabang' =>  $parametercabang->text]);

            session(['info' => $token['info']]);
            session(['link_url' => strtolower($linkUrl->text)]);

            // session(['access_token_emkl' => $tokenEmkl['access_token']]);

            session(['access_token_emkl' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YjJhNDU1My1mYWZkLTQ4MDQtOTYxNy03MTNlNmZmYWU5MGUiLCJqdGkiOiJhMTQ2MjRiYjNhZjYwNmRjYmZjZDFiZDIzNWNiN2E0NzliYzU1YmVjMzc5YzFiMWRiMDI0Yjg1YjczZWQ2ODBhNmJhMTc4NTAwNTcwNmI5MiIsImlhdCI6MTcwNjA1OTE3OCwibmJmIjoxNzA2MDU5MTc4LCJleHAiOjE3Mzc2ODE1NzgsInN1YiI6IiIsInNjb3BlcyI6W119.B0QcamQLB6vEi2VAGZ0OfP4MsCgt9_eSOwqB1ukkFa98SKgkfdHBt0eZ-vNhGJeNTQu69y-qImaIAzh-SgL2uQvueDF6sF7bJzRygO16gP_1aDv6L5VckbkSboqazVqZ62AMO5JYAyc8x4LNKEbKEqmg14yFd8rUg4ce8TQ0HhmshquJR_3jCqO-NkrLtQKVS65ZvF-RAVUnZ9Yujh6SDbqhLKQ8Q9hO6n3YKwaMzqbJoPY3yiM3AzeCSitD0cL3zYRSiSSHmuBUuoinAUybN3QDVpdEad7jb5QLbQQmL7UAW2EPk8-DUMkVRkx6aDjwYoPNrz7CURuNFezWKBDBuWNcLJLwdkJ0tQqj-nDGsb5XFGdPRZovx3RSoxb3Mn7hwafkGhZycDZ739X2odSP3z2_7i9MvIB8WIr-zSn_i6hYXz-t-Fxtn3_fyP2d0OA8MqRLC7niKsXyJEcADFO_nECZL0OpJ5AqGBfDqr1ochKOnro4Y8gEgZb2uok9G1oaeGLr_gWtOgb8xPsU7DED6CCyQESKjSuv031WdD_HCReYuzK1bgaGxaIAV3cPhPF83MYXIMkb5tv8A_ldahQfLAzrCN2840kgISbVKSg22xnRZo8SD2Zb-P86hIOTpeFdTuQfxW7RL9Jh1lTPC15CB-BKQ-CMvbMSRH0emSIt1L4']);
            
            session(['menus' => (new Menu())->getMenu()]);
            if ($parametercabang->text == "PUSAT") {
                // session(['access_token_mdn' => $tokenMdn]);
                // session(['access_token_jkt' => $tokenJakarta['access_token']]);
                // session(['access_token_jkttnl' => $tokenJakartaTnl['access_token']]);
                // session(['access_token_mks' => $tokenMakassar['access_token']]);
                // session(['access_token_sby' => $tokenSurabaya['access_token']]);
                // session(['access_token_btg' => $tokenBitung['access_token']]);
            } else {
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
    private function get_client_browser()
    {
        $browser = '';
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
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
        // Auth::user()->tokens->each(function($token, $key) {
        //     $token->delete();
        // });
        // $user = Auth::user()->id;
        // Token::where('user_id', $user)
        // ->update(['revoked' => true]);
        Auth::logout();

        session()->forget('menus');
        session()->forget('cabang');
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
