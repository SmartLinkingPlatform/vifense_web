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

    Route::group([
        'middleware' => 'jwt.verify',
    ], function() {
        Route::post('admin.logout', 'JWTAdminAuthController@logout');
        Route::post('admin.refresh', 'JWTAdminAuthController@refresh');
        Route::get('admin.profile', 'JWTAdminAuthController@profile');

        Route::post('admin.getDayDrivingList', 'CompanyController@getDayDrivingList');
        Route::post('admin.getUserList', 'UserController@getUserList');
        Route::post('admin.getCompanyName', 'UserController@getCompanyName');
        Route::post('admin.getUserinInfo', 'UserController@getUserinInfo');
        Route::post('admin.everyInfo', 'CompanyController@getEveryDrivingInfo');

        Route::post('admin.sendMessage', 'NoticeController@sendMessageUsers');
        Route::post('admin.messageUser', 'NoticeController@getMessageUserList');
        Route::post('admin.messageList', 'NoticeController@getAllMessageList');

    });
}); // end adminsession

//-----------------------------------------------------
// Admin part without adminsession
//-----------------------------------------------------
Route::view('admin.findPasswordView', 'admin.find-password-view');
Route::view('admin.signupCorporateView', 'admin.signup-corporate-view');

Route::get('admin', function () { return redirect('admin.login');});
Route::post('admin.register', 'JWTAdminAuthController@Register');
Route::post('admin.adminLogin', 'JWTAdminAuthController@login');

Route::post('admin.getUserRegNum', 'AdminController@getUserRegisterNumber');
Route::post('admin.regNewPwd', 'AdminController@registerNewPassword');

Route::post('admin.htmlFile', 'NoticeController@uploadHtmlFile');

Route::get('admin.day-driver-info', function () {
    return view('admin.day-driver-info');
});

Route::view('admin.notice', 'admin.notice-view');
Route::view('admin.fileupload', 'admin.file-upload');

Route::group([
    'middleware' => 'jwt.verify'
], function() {
    /***
     * admin part
     */
    Route::post('admin.get_user', 'JWTAdminAuthController@get_user');

    Route::post('admin.getDashboardInfo', 'AdminController@getDashboardInfo');
    Route::post('admin.getCompanyList', 'CompanyController@getCompanyList');
    Route::post('admin.addNewCompany', 'CompanyController@addNewCompany');
    Route::post('admin.getCompanyinInfo', 'CompanyController@getCompanyinInfo');
    Route::post('admin.editCompanyInfo', 'CompanyController@editCompanyInfo');
    Route::post('admin.companyDelete', 'CompanyController@companyDelete');
    Route::post('admin.companyActive', 'CompanyController@companyActive');
    Route::post('admin.companyCertify', 'CompanyController@companyCertify');
    Route::post('admin.showCompanyInfo', 'CompanyController@showCompanyInfo');

    // person part
    Route::post('admin.addNewUserInfo', 'UserController@addNewUserInfo');
    Route::post('admin.editUserInfo', 'UserController@editUserInfo');
    Route::post('admin.userDelete', 'UserController@userDelete');
    Route::post('admin.showUserInfo', 'UserController@showUserInfo');
    Route::post('admin.userActive', 'UserController@setUserActive');
    Route::post('admin.userCertify', 'UserController@setUserCertify');

});
Route::get('admin.user-driver-info', 'CompanyController@getSearchUserDriverInfo');
Route::get('admin.user-driver-info/{search}', 'CompanyController@getSearchUserDriverInfo');

/********************************************************************************************************************/


/***
 * mobile
*/
Route::post('mobile.register', 'JWTMobileAuthController@register'); //  /mobile/auth/register
Route::post('mobile.login', 'JWTMobileAuthController@login');
Route::post('mobile.companyInfo', 'CallAPIController@requestCompanyInfo');

Route::group([
    'middleware' => 'jwt.verify'
], function() {
    Route::post('mobile.get_user', 'JWTMobileAuthController@get_user');
    Route::post('mobile.userSignup', 'CallAPIController@requestUserSignup');
    Route::post('mobile.userInfoModify', 'CallAPIController@requestUserInfoModify');
    Route::post('mobile.regCarInfo', 'CallAPIController@requestRegCarInfo');
    Route::post('mobile.listCarInfo', 'CallAPIController@requestListCarInfo');
    Route::post('mobile.modCarInfo', 'CallAPIController@requestModCarInfo');
    Route::post('mobile.delCarInfo', 'CallAPIController@requestDelCarInfo');
    Route::post('mobile.readDriving', 'CallAPIController@requestReadDrivingInfo');
    Route::post('mobile.saveDriving', 'CallAPIController@requestSaveDrivingInfo');
    Route::post('mobile.ranking', 'CallAPIController@requestRankingInfo');
    Route::post('mobile.drivingRanking', 'CallAPIController@requestDrivingRankingInfo');
    Route::post('mobile.messageList', 'CallAPIController@requestMessageListInfo');
    Route::post('mobile.newpassword', 'CallAPIController@requestNewPasswordInfo');

});
/********************************************************************************************************************/



//include ('mobile.php');
Route::get('/{page}', 'AdminController@index'); // don't call this part for mobile.php route
// Route::get('/{page}', 'AdminController@index')->where('page', '!(^[mobile.]?)');

