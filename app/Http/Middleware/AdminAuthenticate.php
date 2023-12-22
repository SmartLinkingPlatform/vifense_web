<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
//use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuthenticate extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            //$request_all = $request->all();
            $user = auth()->guard('admin')->authenticate();
            /*
            $pathinfo = $request->getPathInfo();
            $path_arr = explode("/", $pathinfo);
            $admin = array_search('admin', $path_arr);
            if($admin !== false){
                $register = array_search('register', $path_arr);
                $login = array_search('login', $path_arr);
                if($register === false && $login === false) {
                    $authorization = $request->header('authorization', null);
                    //$user = auth()->guard('admin')->authenticate();
                    if(!$authorization){
                        return \Response::json([
                            'msg' => 'err',
                            'cont' => 'request must to do not empty authorization'
                        ]);
                    }
                }
            }
            */
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
