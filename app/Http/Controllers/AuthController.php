<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $dataIp['ipclient'] = $request->ip();

        $cekIp = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => true])
        ->get(config('app.api_url') . 'cekIp', $dataIp);

        $isLocal = $cekIp['data']['status'];
        $user = User::where('user',$request->user)->first();
        if (!$isLocal) {
            
            
            User::where('user',$request->user)->first();
            if (!$user) {
                return redirect()->back()->withErrors([
                    'user_not_found' => 'Autentikasi Gagal'
                ]);
            }
            $statusaktif = [
                "grp"=>"STATUS AKSES",
                "subgrp"=>"STATUS AKSES",
                "text"=>"PUBLIC"
            ];
    
            $parameter = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . 'parameter/getparamrequest',$statusaktif);
            
            if($user->statusakses != $parameter['id']){
                return redirect()->back()->withErrors([
                    'user_not_found' => 'User out Of network'
                ]);
            }

        }
        // Auth::user()

        if (Auth::attempt($credentials)) {
            
            $token = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
            ->post(config('app.api_url') . 'token', $credentials);

            $tokenMedan = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]) ->post('https://tasmdn.kozow.com:8074/trucking-api/public/api/token', $credentials);

            $tokenEmkl = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
            ->post(config('app.emkl_api_url') . 'oauth/token', $credentialsEmkl);

            // dd($tokenEmkl->getBody()->getContents());
            
            session(['access_token' => $token['access_token']]);
            session(['access_token_mdn' => $tokenMedan['access_token']]);
            session(['access_token_emkl' => $tokenEmkl['access_token']]);
            session(['menus' => (new Menu())->getMenu()]);

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors([
                'user_not_found' => 'User not registered'
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();

        session()->forget('menus');
        
        return redirect()->route('login');
    }

    public function cekIp(Request $request){
        $credentials = [
            'user' => $request->user,
            'password' => $request->password,
        ];
        $dataIp = $credentials;
        $dataIp['ipclient'] = $request->ip();
        dd($dataIp);
        $cekIp = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => true])
        // ->get("https://tasmdn.kozow.com:8074/trucking-api/public/api/" . 'cekIp', $credentials);
        ->get(config('app.api_url') . 'cekIp', $dataIp);
        dd($cekIp['data']);
    }

    public function cek_param(){
        $statusaktif = [
            "grp"=>"STATUS AKSES",
            "subgrp"=>"STATUS AKSES",
            "text"=>"PUBLIC"
        ];
        $parameter = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/getparamrequest',$statusaktif);
       
        dd($parameter);
    }

}
