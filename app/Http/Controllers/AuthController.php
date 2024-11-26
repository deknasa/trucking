<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Parameter;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
        $cekIp = $this->cekIp($request->clientippublic);
        $isLocal = $cekIp->original['data']['status'];
        $user = User::where('user', $request->user)->first();
        // dd($request, $request->user, $request->password, $credentials, $dataIp, $isLocal, $user);

        if (!$isLocal) {


            User::where('user', $request->user)->first();
            if (!$user) {
                return redirect()->back()->withErrors([
                    'user_not_found' => 'Autentikasi Gagal'
                ]);
            }

            $parameter = DB::table("parameter")->from(DB::raw("parameter with (readuncommitted)"))->where('grp','STATUS AKSES')->where('subgrp','STATUS AKSES')->where('text', 'PUBLIC')->first();
            if ($user->statusakses != $parameter->id) {
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
            $credentials['ipserver'] = $cekIp->original['data']['ipserver'];
            $credentials['latitude'] = $lat;
            $credentials['longitude'] = $long;
            $credentials['browser'] = $this->get_client_browser();
            $credentials['os'] = $_SERVER['HTTP_USER_AGENT'];
            // dd(env('TRUCKINGAPI_CLIENT_ID'),env('TRUCKINGAPI_CLIENT_SECRET'),config('app.api_url'),env('TRUCKINGAPI_OUTH_URL').'oauth/token', $credentials['user'], $credentials['password']);
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withOptions(['verify' => false])->post(env('TRUCKINGAPI_OUTH_URL').'oauth/token',[
                    'grant_type'=>'password',
                    'client_id'=>env('TRUCKINGAPI_CLIENT_ID'),
                    'client_secret'=>env('TRUCKINGAPI_CLIENT_SECRET'),
                    'username'=>$credentials['user'],
                    'password'=>$credentials['password'],
                    'scope'=>''
            ]);
            // dd($response->json());
            if ($response->getStatusCode() > 200) {
                return redirect()->back()->withErrors([
                    'user_not_found' => 'Autentikasi token Gagal'
                ]);
            }
            
            $token = json_decode((string) $response->getBody(),true);

            $location = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withOptions(['verify' => false])->get(config('app.api_url').'location',$credentials);
            $info = json_decode((string) $location->getBody(),true);
            // dd($info);

            $tokenUrlTas = '';
            if ($parametercabang->text == "PUSAT") {
                $linkUrl =  DB::table('parameter')->where('grp', 'LINK URL')->where('subgrp', 'LINK URL')->first();
            } else {
                $linkUrl =  DB::table('parameter')->where('grp', 'LINK URL')->where('subgrp', 'LINK URL')->first();
                $linkUrlTas = strtolower($linkUrl->text); //http://tasjkt.kozow.com:8074/trucking-api/public/api/
                // if ($linkUrlTas != '') {
                //     $tokenUrlTas = Http::withHeaders([
                //         'Content-Type' => 'application/json',
                //         'Accept' => 'application/json'
                //     ])->post($linkUrlTas . 'token', [
                //         'user' => 'ADMIN',
                //         'password' => getenv('PASSWORD_TNL'),
                //         'ipclient' => '',
                //         'ipserver' => '',
                //         'latitude' => '',
                //         'longitude' => '',
                //         'browser' => '',
                //         'os' => '',
                //     ]);
                // }
            }

            // $isPostingTNL = DB::table('parameter')->where('grp', 'STATUS POSTING TNL')->where('text', 'POSTING TNL')->first();
            // $tokenTNL = '';
            // dd(config('app.trucking_api_tnl') . 'token');
            // if ($isPostingTNL->default == 'YA') {

            //     // dd(config('app.trucking_api_tnl') . 'token');
            //     $credentials['user'] = 'ADMIN';
            //     $credentials['password'] = config('app.password_tnl');
            //     $credentials['ipclient'] = $request->ip();
            //     $credentials['ipserver'] = $cekIp['data']['ipserver'];
            //     $credentials['latitude'] = $lat;
            //     $credentials['longitude'] = $long;
            //     $credentials['browser'] = $this->get_client_browser();
            //     $credentials['os'] = $_SERVER['HTTP_USER_AGENT'];
            //     $getTokenTNL = Http::withHeaders([
            //         'Accept' => 'application/json'
            //     ])->withOptions(['verify' => false])
            //         ->post(config('app.trucking_api_tnl') . 'token', $credentials);
            //     // dd($getTokenTNL->json());

            //     $tokenTNL = $getTokenTNL['access_token'];
            // }
            // dd($credentialsEmkl);
            // dd(config('app.emkl_api_url'));
            // dump(config('app.emkl_api_url') . 'oauth/token');
            // dd($credentialsEmkl);

            // $tokenEmkl = Http::withHeaders([
            //     'Accept' => 'application/json'
            // ])->withOptions(['verify' => false])
            //     ->post(config('app.emkl_api_url') . 'oauth/token', $credentialsEmkl);

            // dd(config('app.emkl_api_url') . 'token');

            // $credentials['user'] = 'ADMIN';
            // $credentials['password'] = config('app.password_emkl');
            // $credentials['ipclient'] = $request->ip();
            // $credentials['ipserver'] = $cekIp['data']['ipserver'];
            // $credentials['latitude'] = $lat;
            // $credentials['longitude'] = $long;
            // $credentials['browser'] = $this->get_client_browser();
            // $credentials['os'] = $_SERVER['HTTP_USER_AGENT'];
            // $tokenEmkl = Http::withHeaders([
            //     'Accept' => 'application/json'
            // ])->withOptions(['verify' => false])
            //     ->post(config('app.emkl_api_url') . 'token', $credentials);



            session(['access_token' => $token['access_token']]);
            session(['refresh_token' => $token['refresh_token']]);
            session(['expires_at' => now()->addSeconds($token['expires_in'])]);            
            // session(['access_token_tnl' => $tokenTNL]);
            session(['cabang' =>  $parametercabang->text]);
            session(['tnl' =>  $parametertnl->text]);

            session(['info' =>$info['info']]);
            session(['link_url' => strtolower($linkUrl->text)]);

            if ($parametercabang->text != 'PUSAT') {
                // session(['access_token_emkl' => $tokenEmkl['access_token']]);
            }

            // dd($tokenEmkl['access_token']);
            // session(['access_token_emkl' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YjJhNDU1My1mYWZkLTQ4MDQtOTYxNy03MTNlNmZmYWU5MGUiLCJqdGkiOiI5MmEwNzBkY2I4NGE1ZjY4MjBjYzgxZWMzM2E2Mzg1YjM0ZGNlNTc5MjYzYTRhYzI0ZGEzZjJkYWZhNmVkYTRkODQzZGY0MGEyZTZiMjU5MiIsImlhdCI6MTcwNjE3ODA4OSwibmJmIjoxNzA2MTc4MDg5LCJleHAiOjE3Mzc4MDA0ODksInN1YiI6IiIsInNjb3BlcyI6W119.k1AM705wPDHCnC89oVn2HE_lPJc0Se347ikE3gJM-ibwd-yKSHngz_2qFG3Nlc1KyzuY6nhU3IKiGAudKg-1E3yc6og0sLmrmJ_3HQta3Lp4NMAHK6St_1Gx-RrspEUC1777KMv3kIZBm3sbrWPUWpb08RIH3m0LPvMErJKDLFAMM9HAAJscHeyqumA1Q5OyUTmS6hx4tGuYE-POiWcq-hEmP_TBcjvuPYWSAOO0PPHCxV88PRjN1E73dnn3hCQ3ZGnJvYFmgSn_YOUWqQ8YH95pc6hto8VTFuTwSIUzwzL1A02M5wvIfXJLlY6q8ebWQecHNmLtL1DBZN7y8JgG4Mm2VeUu7Gymv8rRgjMR_C6mV4lKzvTpA23GdbM2OOYWqSm8nZPXw689NEMakaK6aKRwkXe5xba2EK8OuxtzoDQ-_l5GzNcC-r2gwRZya0S-NzpWmuaLYA8iOIdp26511AqO05mSdr0_1qvMQz0BJK6PiSu4r0Qx4eREojkTUCtSbz-Ynh74kde4fQtXsONabdry2bfUNIUcDfU0hY3uTMLMcIA8Zds0Dy7S_y_y7za3BUFapU5_UiUNc4IpoJ5t6VkH2Xy46d0riSG_1bzzxaDo8YxaryMR4QJAK5Mn0K4GfgH7n2YmxmPiBcixAIM-oV5C3YvFtIm8YjfoyR2rWC8']);

            // session(['menus' => (new Menu())->getMenu()]);
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

    public function refreshToken()
    {

    
        $refreshToken = Session::get('refresh_token');

        if (!$refreshToken) {
            return null;
        }

        try {
            $response =  $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withOptions(['verify' => false])->post(env('TRUCKINGAPI_OUTH_URL').'oauth/token',[
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id'=>env('TRUCKINGAPI_CLIENT_ID'),
                    'client_secret'=>env('TRUCKINGAPI_CLIENT_SECRET'),
                    'scope' => '',
            ]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
                
                // Simpan token baru dalam session
                Session::put('access_token', $data['access_token']);
                Session::put('refresh_token', $data['refresh_token']); // Simpan refresh token jika diperlukan
                
                return response([
                        'access_token' => session('access_token'),
                        'refresh_token' => session('refresh_token'),
                    ], 200);
            }

            return response([
                 'access_token' => null,
                 'refresh_token' => null,
             ], 404);
        } catch (\Exception $e) {
            return response([
                 'access_token' => null,
                 'refresh_token' => null,
             ], 404);
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

        session()->forget('access_token');
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

    public function cekIp($ipClient)
    {

        $ipclient = $this->get_client_ip();
        if ($ipClient) {
            $ipclient = $ipClient;
            if ($ipclient == '::1') {
                $ipclient = getHostByName(getHostName());
                // $ipclient = gethostbyname('tasmdn.kozow.com');
            }
        }

        $ipserver = $this->get_server_ip();
        if (env('APP_HOSTNAME') != request()->getHost()) {
            return response([
                'data' => [
                    'status' => true,
                    'message' => 'test',
                    'errors' => '',
                    'ipclient' => $ipclient,
                    'ipserver' =>  $ipserver,
                ]
            ]);
        }
        if ($this->ipToCheck($ipClient)) {
            $data = [
                'status' => true,
                'message' => 'test',
                'errors' => '',
                'ipclient' => $ipclient,
                'ipserver' =>  $ipserver,
            ];
        } else {
            $data = [
                'status' => false,
                'message' => '',
                'errors' => '',
                'ipclient' => $ipclient,
                'ipserver' =>  $ipserver,
            ];
        }

        // $data = [
        //     'status' => false,
        //     'message' => 'tests ',
        //     'APP_HOSTNAME' => env('APP_HOSTNAME'),
        //     'tasmdn' => $ipclient,
        //     'request' => request()->ip(),
        //     'REMOTE_ADDR' => getenv('REMOTE_ADDR'),
        //     'SERVER_ADDR' => getenv('SERVER_ADDR'),
        //     'ipserver' =>  $ipserver,
        // ];
        return response([
            'data' => $data,
        ]);
    }

    // public function cekIp(Request $request)
    // {
    //     $credentials = [
    //         'user' => $request->user,
    //         'password' => $request->password,
    //     ];
    //     $dataIp = $credentials;
    //     $dataIp['ipclient'] = $request->ip();
    //     $cekIp = Http::withHeaders([
    //         'Accept' => 'application/json'
    //     ])->withOptions(['verify' => true])
    //         // ->get("https://tasmdn.kozow.com:8074/trucking-api/public/api/" . 'cekIp', $credentials);
    //         ->get(config('app.api_url') . 'cekIp', $dataIp);
    //     dd($cekIp['data']);
    // }

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
    function get_client_ip()
    {


        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'IP tidak dikenali';
        if ($ipaddress == '::1') {
            $ipaddress = gethostbyname(env('APP_HOSTNAME'));
        }
        return $ipaddress;
    }

    function get_server_ip()
    {

        // $ipaddress = gethostbyname(strtolower($query->text));
        $ipaddress = gethostbyname(env('APP_HOSTNAME'));
        // $ipaddress = file_get_contents('https://api.ipify.org');

        return $ipaddress;
    }

    function ipToCheck($ipRequest)
    {
        $ipArray = [
            env('LOCAL_IP_LIST_1'),
            env('LOCAL_IP_LIST_2'),
            env('LOCAL_IP_LIST_3'),
        ];
        return in_array($ipRequest, $ipArray);
    }
}
