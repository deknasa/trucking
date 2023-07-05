<?php

namespace App\Http\Middleware;

use App\Models\Passwordreset;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class VerifyJwtToken
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
        try {
            $passwordReset = Passwordreset::where('token', $request->token)->first();

            if ($passwordReset !== null) {
            
            $payload = JWT::decode($request->token, new Key(config('app.jwt_key'), config('app.jwt_alg')));
             
                
                $request->email = $payload->email;
            } else {
                throw new ExpiredException('Invalid Token');
            }
        } catch (ExpiredException $expiredException) {
            return redirect()->route('reset-password.expired');
        } catch (\Throwable $th) {
            throw $th;
        }

        return $next($request);
    }
}
