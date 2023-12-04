<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;

use Closure;

class CheckAdminSession
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
        if($request->session()->has('admin_id')){
            return $next($request);
        } else {
            return redirect('/admin');
        }
    }
}
