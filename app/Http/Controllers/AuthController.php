<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

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


        if (Auth::attempt($credentials)) {
            $token = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
            ->post(config('app.api_url') . 'token', $credentials);
            
            session(['access_token' => $token['access_token']]);

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

        return redirect()->route('login');
    }

}
