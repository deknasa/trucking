<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CekTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($this->checkToken()){
            return $next($request);
        }
        return redirect('logout');

    }

    public function checkToken() {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'checkuser');
         // Cek jika status 401 (Unauthorized)
         if ($response->status() === 401) {
            // Panggil fungsi refresh token
            $this->refreshToken();
            $newResponse = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'checkuser');

            if ($newResponse->status() > 200) {
                return false;
            }
            return true;
        }
        
        if ($response->status() > 200) {
            return false;
        }
        return true;

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
                
                return $data['access_token'];
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
