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
        $parametertnl = DB::table('parameter')->where('grp', 'TNL')->where('subgrp', 'TNL')->first();
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
            // dd(config('app.trucking_api_tnl') . 'token');
            if ($isPostingTNL->default == 'YA') {

                // dd(config('app.trucking_api_tnl') . 'token');
                $credentials['user'] = 'ADMIN';
                $credentials['password'] = config('app.password_tnl');
                $credentials['ipclient'] = $request->ip();
                $credentials['ipserver'] = $cekIp['data']['ipserver'];
                $credentials['latitude'] = $lat;
                $credentials['longitude'] = $long;
                $credentials['browser'] = $this->get_client_browser();
                $credentials['os'] = $_SERVER['HTTP_USER_AGENT'];
                $getTokenTNL = Http::withHeaders([
                    'Accept' => 'application/json'
                ])->withOptions(['verify' => false])
                    ->post(config('app.trucking_api_tnl') . 'token', $credentials);
                // dd($getTokenTNL->json());

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

            // dd(config('app.emkl_api_url') . 'token');

            $credentials['user'] = 'ADMIN';
            $credentials['password'] = config('app.password_emkl');
            $credentials['ipclient'] = $request->ip();
            $credentials['ipserver'] = $cekIp['data']['ipserver'];
            $credentials['latitude'] = $lat;
            $credentials['longitude'] = $long;
            $credentials['browser'] = $this->get_client_browser();
            $credentials['os'] = $_SERVER['HTTP_USER_AGENT'];
            $tokenEmkl = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
                ->post(config('app.emkl_api_url') . 'token', $credentials);



            session(['access_token' => $token['access_token']]);
            session(['access_token_tnl' => $tokenTNL]);
            session(['cabang' =>  $parametercabang->text]);
            session(['tnl' =>  $parametertnl->text]);

            session(['info' => $token['info']]);
            session(['link_url' => strtolower($linkUrl->text)]);

            // if ($parametercabang->text != 'PUSAT') {
            //     session(['access_token_emkl' => $tokenEmkl['access_token']]);
            // }

            // dd($tokenEmkl['access_token']);
            // session(['access_token_emkl' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YjJhNDU1My1mYWZkLTQ4MDQtOTYxNy03MTNlNmZmYWU5MGUiLCJqdGkiOiI5MmEwNzBkY2I4NGE1ZjY4MjBjYzgxZWMzM2E2Mzg1YjM0ZGNlNTc5MjYzYTRhYzI0ZGEzZjJkYWZhNmVkYTRkODQzZGY0MGEyZTZiMjU5MiIsImlhdCI6MTcwNjE3ODA4OSwibmJmIjoxNzA2MTc4MDg5LCJleHAiOjE3Mzc4MDA0ODksInN1YiI6IiIsInNjb3BlcyI6W119.k1AM705wPDHCnC89oVn2HE_lPJc0Se347ikE3gJM-ibwd-yKSHngz_2qFG3Nlc1KyzuY6nhU3IKiGAudKg-1E3yc6og0sLmrmJ_3HQta3Lp4NMAHK6St_1Gx-RrspEUC1777KMv3kIZBm3sbrWPUWpb08RIH3m0LPvMErJKDLFAMM9HAAJscHeyqumA1Q5OyUTmS6hx4tGuYE-POiWcq-hEmP_TBcjvuPYWSAOO0PPHCxV88PRjN1E73dnn3hCQ3ZGnJvYFmgSn_YOUWqQ8YH95pc6hto8VTFuTwSIUzwzL1A02M5wvIfXJLlY6q8ebWQecHNmLtL1DBZN7y8JgG4Mm2VeUu7Gymv8rRgjMR_C6mV4lKzvTpA23GdbM2OOYWqSm8nZPXw689NEMakaK6aKRwkXe5xba2EK8OuxtzoDQ-_l5GzNcC-r2gwRZya0S-NzpWmuaLYA8iOIdp26511AqO05mSdr0_1qvMQz0BJK6PiSu4r0Qx4eREojkTUCtSbz-Ynh74kde4fQtXsONabdry2bfUNIUcDfU0hY3uTMLMcIA8Zds0Dy7S_y_y7za3BUFapU5_UiUNc4IpoJ5t6VkH2Xy46d0riSG_1bzzxaDo8YxaryMR4QJAK5Mn0K4GfgH7n2YmxmPiBcixAIM-oV5C3YvFtIm8YjfoyR2rWC8']);

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

            return redirect()->route('dashboard')->with(['from_login' => true]);
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
