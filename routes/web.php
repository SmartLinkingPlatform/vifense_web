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
		//echo '<br>  strstr >>>  '.$_SERVER['HTTP_HOST'];
        return view('user.apkdown');
    }
	else if(Str::startsWith($_SERVER['HTTP_HOST'],'vifense.com')){
		//echo '<br>  stristr >>>  '.$_SERVER['HTTP_HOST'];
        return view('user.apkdown');
    }
    else{
		//echo '<br> else strstr >>>  '.$_SERVER['HTTP_HOST'];
        return view('admin.login');
	}
});

//-----------------------------------------------------
// Admin part
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

    Route::post('admin.getDashboardInfo', 'AdminController@getDashboardInfo');

    Route::post('admin.getDayDrivingList', 'CompanyController@getDayDrivingList');

    Route::post('admin.getUserList', 'UserController@getUserList');
    Route::post('admin.getCompanyName', 'UserController@getCompanyName');
    Route::post('admin.getUserinInfo', 'UserController@getUserinInfo');

    Route::post('admin.everyInfo', 'CompanyController@getEveryDrivingInfo');

//----------------------------------------------------
// driver info
//----------------------------------------------------


//-----------------------------------------------------
// Notice part
//-----------------------------------------------------
    Route::post('user.noticeAdd', 'NoticeController@noticeAdd');

});
Route::get('admin', function () { return redirect('admin.login');});
Route::post('admin.adminLogin', 'AdminController@adminLogin');
Route::post('admin.adminLogout', 'AdminController@adminLogout');
Route::post('admin.getUserRegNum', 'AdminController@getUserRegisterNumber');
Route::post('admin.regNewPwd', 'AdminController@registerNewPassword');


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

/*
Route::middleware('usersession')->group(function(){
    Route::get('user.user', function () {
        return view('user.user');
    });
});
Route::get('user', function () { return redirect('user.login');});
Route::post('user.userLogin', 'UserController@userLogin');
Route::post('user.userLogout', 'UserController@userLogout');
Route::post('user.getUserInformation', 'UserController@getUserInformation');
Route::post('user.changeUserPassword', 'UserController@changeUserPassword');
Route::post('user.getUserTotalAmount', 'UserController@getUserTotalAmount');
*/

include ('mobile.php');
Route::get('/{page}', 'AdminController@index'); // don't call this part for mobile.php route
// Route::get('/{page}', 'AdminController@index')->where('page', '!(^[mobile.]?)');

