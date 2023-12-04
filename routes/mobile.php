<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Auth::routes();
Route::post('mobile.companyInfo', 'CallAPIController@requestCompanyInfo');
Route::post('mobile.userLogin', 'CallAPIController@userLogin');
Route::post('mobile.userSignup', 'CallAPIController@userSignup');
Route::post('mobile.userInfoModify', 'CallAPIController@userInfoModify');
Route::post('mobile.userFindPassword', 'CallAPIController@userFindPassword');
Route::post('mobile.regCarInfo', 'CallAPIController@regCarInfo');
Route::post('mobile.modCarInfo', 'CallAPIController@modCarInfo');
Route::post('mobile.delCarInfo', 'CallAPIController@delCarInfo');
Route::post('mobile.mtsDrivingInfo', 'CallAPIController@mtsDrivingInfo');
Route::post('mobile.stmDrivingRecord', 'CallAPIController@stmDrivingRecord');




