<?php

namespace App\Http\Controllers;

use App\Models\Menu;
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



        if (Auth::attempt($credentials)) {
            $token = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
            ->post(config('app.api_url') . 'token', $credentials);

           
            $tokenEmkl = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
            ->post(config('app.emkl_api_url') . 'oauth/token', $credentialsEmkl);

            // dd($tokenEmkl->getBody()->getContents());
            
            session(['access_token' => $token['access_token']]);
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

}
