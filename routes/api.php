<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAdminAuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//$requestURL = $_SERVER['REQUEST_URI'];
//var_dump($requestURL );

Route::post('register', '\App\Http\Controllers\JWTAdminAuthController@register'); // /apiw/register
Route::post('login', '\App\Http\Controllers\JWTAdminAuthController@login');// /apiw/login

Route::group([
    'middleware' => 'jwt.verify',
    'prefix'=>'admin'
    ], function() {
    Route::post('logout', [JWTAdminAuthController::class, 'logout']);
    Route::post('get_user', [JWTAdminAuthController::class, 'get_user']);
    Route::post('refresh', [JWTAdminAuthController::class, 'refresh']);
    Route::get('profile', [JWTAdminAuthController::class, 'profile']);
});

