<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
//use Illuminate\Auth\Middleware\Authenticate as Middleware;

class MobileAuthenticate extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            //$request_all = $request->all();
            $pathinfo = $request->getPathInfo();
            $path_arr = explode("/", $pathinfo);
            $mobile = array_search('mobile', $path_arr);
            if($mobile !== false){
                $register = array_search('register', $path_arr);
                $login = array_search('login', $path_arr);
                if($register !== false && $login !== false) {
                    $user = JWTAuth::parseToken()->authenticate();
                    if(!$user){
                        //return route('/mobile/auth/login');
                        return \Response::json([
                            'msg' => 'err',
                            'cont' => 'user is not authention'
                        ]);
                    }
                }
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['msg' => 'err','cont' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['msg' => 'err', 'cont' => 'Token is Expired']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return response()->json(['msg' => 'err', 'cont' => 'Token is Blacklisted']);
            } else {
                return response()->json(['msg' => 'err', 'cont' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }

}
