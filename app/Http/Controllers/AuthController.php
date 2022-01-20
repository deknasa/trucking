<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index() {
        $title = 'Login';
        
        return view('login', compact('title'));
    }

    public function process(Request $request) {
        return response($request);
        $response = Http::withHeaders($request->header())
                ->get(config('app.api_url') . 'api/auth/login', $request);
    }
}
