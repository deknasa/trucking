<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        // dd(route('parameter.index'));
        $title = 'Login';

        return view('login', compact('title'));
    }

    public function login(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->post(config('app.api_url') . 'api/auth/login', $request->all());

        if (@$response['status'] && @$response['data'] !== null) {
            $_SESSION['userpk'] = $response['data']['id'];
            $_SESSION['userid'] = $response['data']['user'];
            $_SESSION['username'] = $response['data']['name'];
            $_SESSION['logged_in'] = 1;

            return redirect()->route('dashboard');
        } else {
            $errors = [
                'user_not_found' => 'User not registered'
            ];

            return redirect()->route('login')->withErrors($errors);
        }

        return redirect()->route('login')->withErrors($response['errors']);
    }

    public function logout()
    {
        unset($_SESSION['user']);

        return redirect()->route('login');
    }
}
