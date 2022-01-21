<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoggedIn
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
        session_start();

        // dd(isset($_SESSION['user']));

        if (isset($_SESSION['user']) && $_SESSION['user'] !== null) {
            return $next($request);
        }
        
        return redirect()->route('login');
    }
}
