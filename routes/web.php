<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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

Route::get('/', function () {
   if(Str::startsWith($_SERVER['HTTP_HOST'],'www.vifense.com')){
        return view('user.apkdown');
    }
	else if(Str::startsWith($_SERVER['HTTP_HOST'],'vifense.com')){
        return view('user.apkdown');
    }
    else{
        return view('admin.login');
	}
});

//-----------------------------------------------------
// Admin part with adminsession
//-----------------------------------------------------

Route::middleware('adminsession')->group(function(){
    Route::get('admin.dashboard', function () {
        return view('admin.dashborad-view');
    });
    Route::get('admin.companyinfo', function () {
        return view('admin.companyinfo');
    });
    Route::get('admin.personinfo', function () {
        return view('admin.personinfo');
    });

    Route::post('admin.getDayDrivingList', 'CompanyController@getDayDrivingList');
    Route::post('admin.getUserList', 'UserController@getUserList');
    Route::post('admin.getCompanyName', 'UserController@getCompanyName');
    Route::post('admin.getUserinInfo', 'UserController@getUserinInfo');
    Route::post('admin.everyInfo', 'CompanyController@getEveryDrivingInfo');

    Route::group([
        'middleware' => 'jwt.verify',
    ], function() {
        Route::post('admin.logout', [JWTAdminAuthController::class, 'logout']);
        Route::post('admin.refresh', [JWTAdminAuthController::class, 'refresh']);
        Route::get('admin.profile', [JWTAdminAuthController::class, 'profile']);

        Route::post('admin.getDashboardInfo', 'AdminController@getDashboardInfo');
    });
//----------------------------------------------------
// driver info
//----------------------------------------------------


//-----------------------------------------------------
// Notice part
//-----------------------------------------------------
    Route::post('user.sendMessage', 'NoticeController@sendMessageUsers');
    Route::post('admin.messageUser', 'NoticeController@getMessageUserList');

}); // end adminsession

//-----------------------------------------------------
// Admin part without adminsession
//-----------------------------------------------------

Route::get('admin', function () { return redirect('admin.login');});
Route::post('admin.register', 'JWTAdminAuthController@Register');
Route::post('admin.adminLogin', 'JWTAdminAuthController@login');

//Route::post('admin.adminLogout', 'AdminController@adminLogout');
Route::post('admin.getUserRegNum', 'AdminController@getUserRegisterNumber');
Route::post('admin.regNewPwd', 'AdminController@registerNewPassword');

Route::group([
    'middleware' => 'jwt.verify'
], function() {
    Route::post('admin.get_user', 'JWTAdminAuthController@get_user');
});


//Route::post('admin.adminRegister', 'AdminController@adminRegister');
//Route::post('admin.adminDelete', 'AdminController@adminDelete');
//Route::post('admin.getAdminInformation', 'AdminController@getAdminInformation');
//Route::post('admin.editAdminInformation', 'AdminController@editAdminInformation');


//---------------------------------------------------
// admin part
//---------------------------------------------------
Route::view('admin.findPasswordView', 'admin.find-password-view');
Route::post('admin.getSignNumber', 'AdminController@getSignNumber');
Route::view('admin.signupCorporateView', 'admin.signup-corporate-view');
Route::post('admin.corporateSignup', 'AdminController@corporateSignup');

//---------------------------------------------------
// company part
//---------------------------------------------------
Route::post('admin.getCompanyList', 'CompanyController@getCompanyList');
Route::post('admin.addNewCompany', 'CompanyController@addNewCompany');
Route::post('admin.getCompanyinInfo', 'CompanyController@getCompanyinInfo');
Route::post('admin.editCompanyInfo', 'CompanyController@editCompanyInfo');
Route::post('admin.companyDelete', 'CompanyController@companyDelete');
Route::post('admin.companyActive', 'CompanyController@companyActive');
Route::post('admin.companyCertify', 'CompanyController@companyCertify');
Route::post('admin.showCompanyInfo', 'CompanyController@showCompanyInfo');
//---------------------------------------------------
// person part
//---------------------------------------------------
Route::post('admin.addNewUserInfo', 'UserController@addNewUserInfo');
Route::post('admin.editUserInfo', 'UserController@editUserInfo');
Route::post('admin.userDelete', 'UserController@userDelete');
Route::post('admin.showUserInfo', 'UserController@showUserInfo');
Route::post('admin.userActive', 'UserController@setUserActive');
Route::post('admin.userCertify', 'UserController@setUserCertify');

//----------------------------------------------------
// driver info
//----------------------------------------------------
Route::get('admin.day-driver-info', function () {
    return view('admin.day-driver-info');
});
/*
Route::get('admin.user-driver-info', function () {
    return view('admin.user-driver-info');
});
*/
Route::get('admin.user-driver-info', 'CompanyController@getSearchUserDriverInfo');
Route::get('admin.user-driver-info/{search}', 'CompanyController@getSearchUserDriverInfo');



//-----------------------------------------------------
// Notice part
//-----------------------------------------------------
Route::view('user.notice', 'user.notice-view');


include ('mobile.php');
Route::get('/{page}', 'AdminController@index'); // don't call this part for mobile.php route
// Route::get('/{page}', 'AdminController@index')->where('page', '!(^[mobile.]?)');

