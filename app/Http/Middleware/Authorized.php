<?php

namespace App\Http\Middleware;

use App\Libraries\Myauth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authorized
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
        $class = $this->getClass(Route::current()->uri);
        $method = Route::current()->getActionMethod();
        $myAuth = new Myauth;

        if ($myAuth->hasPermission($class, $method)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }

    public function getClass(string $uri): string
    {
        $class = explode('/', $uri)[0];

        return $class;
    }
}
