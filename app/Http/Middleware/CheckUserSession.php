<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;

use Closure;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('user_id')){
            return $next($request);
        } else {
            return redirect('/user');
        }
    }
}
