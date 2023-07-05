<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function index($token, Request $request)
    {   
       
        return view('auth.reset-password.index', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function expired()
    {
        return view('auth.reset-password.expired');
    }

    public function success()
    {
        return view('auth.reset-password.success');
    }
}
