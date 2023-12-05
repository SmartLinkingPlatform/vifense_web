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
Route::post('mobile.userLogin', 'CallAPIController@requestUserLogin');
Route::post('mobile.userSignup', 'CallAPIController@requestUserSignup');
Route::post('mobile.userInfoModify', 'CallAPIController@requestUserInfoModify');
Route::post('mobile.userFindPassword', 'CallAPIController@requestUserFindPassword');
Route::post('mobile.regCarInfo', 'CallAPIController@requestRegCarInfo');
Route::post('mobile.modCarInfo', 'CallAPIController@requestModCarInfo');
Route::post('mobile.delCarInfo', 'CallAPIController@requestDelCarInfo');
Route::post('mobile.readDriving', 'CallAPIController@requestReadDrivingInfo');
Route::post('mobile.saveDriving', 'CallAPIController@requestSaveDrivingInfo');




