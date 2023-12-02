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
    Route::get('admin.admin', function () {
        return view('admin.admin');
    });
    Route::get('admin.user', function () {
        return view('admin.user');
    });
    Route::get('admin.order-manage', function () {
        return view('admin.order-manage');
    });
    Route::get('admin.new-order', function () {
        return view('admin.new-order');
    });
    Route::get('admin.mod-order', function () {
        return view('admin.mod-order');
    });
    Route::get('admin.outcome', function () {
        return view('admin.outcome');
    });
    Route::get('admin.order-history', function () {
        return view('admin.order-history');
    });
    Route::get('admin.currency', function () {
        return view('admin.currency');
    });
    Route::get('admin.item', function () {
        return view('admin.item');
    });
});
Route::get('admin', function () { return redirect('admin.login');});
Route::post('admin.adminLogin', 'AdminController@adminLogin');
Route::post('admin.adminLogout', 'AdminController@adminLogout');
Route::post('admin.getAdminList', 'AdminController@getAdminList');

Route::post('admin.adminRegister', 'AdminController@adminRegister');
Route::post('admin.adminDelete', 'AdminController@adminDelete');
Route::post('admin.getAdminInformation', 'AdminController@getAdminInformation');
Route::post('admin.editAdminInformation', 'AdminController@editAdminInformation');

Route::post('admin.getUserList', 'AdminController@getUserList');
Route::post('admin.userRegister', 'AdminController@userRegister');
Route::post('admin.userDelete', 'AdminController@userDelete');
Route::post('admin.getUserInformation', 'AdminController@getUserInformation');
Route::post('admin.editUserInformation', 'AdminController@editUserInformation');


Route::post('admin.csvOrderList', 'AdminController@csvOrderList');
Route::post('admin.getOrderList', 'AdminController@getOrderList');
Route::post('admin.orderDelete', 'AdminController@orderDelete');
Route::post('admin.getOrderInformation', 'AdminController@getOrderInformation');
Route::post('admin.getOrderDetailInformation', 'AdminController@getOrderDetailInformation');
Route::post('admin.getAllUserList', 'AdminController@getAllUserList');
Route::post('admin.getAllCurrencyList', 'AdminController@getAllCurrencyList');
Route::post('admin.getAllItemList', 'AdminController@getAllItemList');
Route::post('admin.goOrderModPage', 'AdminController@goOrderModPage');
Route::post('admin.addNewOrder', 'AdminController@addNewOrder');
Route::post('admin.modOrderInfo', 'AdminController@modOrderInfo');

Route::post('admin.currencyDelete', 'AdminController@currencyDelete');
Route::post('admin.currencyAdd', 'AdminController@currencyAdd');
Route::post('admin.getCurrencyInformation', 'AdminController@getCurrencyInformation');
Route::post('admin.editCurrencyInformation', 'AdminController@editCurrencyInformation');

Route::post('admin.itemDelete', 'AdminController@itemDelete');
Route::post('admin.itemAdd', 'AdminController@itemAdd');
Route::post('admin.getItemInformation', 'AdminController@getItemInformation');
Route::post('admin.editItemInformation', 'AdminController@editItemInformation');

Route::post('admin.getOutcomeRequestList', 'AdminController@getOutcomeRequestList');
Route::post('admin.agreeOutcomeRequest', 'AdminController@agreeOutcomeRequest');
Route::post('admin.rejectOutcomeRequest', 'AdminController@rejectOutcomeRequest');

Route::post('admin.csvOrderHistoryList', 'AdminController@csvOrderHistoryList');
Route::post('admin.getOrderHistoryList', 'AdminController@getOrderHistoryList');



//---------------------------------------------------
// add part
//---------------------------------------------------
Route::view('admin.findPasswordView', 'admin.find-password-view');
Route::view('admin.signupCorporateView', 'admin.signup-corporate-view');
Route::post('admin.corporateSignup', 'AdminController@corporateSignup');

//-----------------------------------------------------
// User part
//-----------------------------------------------------
/*
Route::middleware('usersession')->group(function(){
    Route::get('user.user', function () {
        return view('user.user');
    });
    Route::get('user.order-history', function () {
        return view('user.order-history');
    });
    Route::get('user.new-outcome', function () {
        return view('user.new-outcome');
    });
    Route::get('user.mod-outcome', function () {
        return view('user.mod-outcome');
    });
});
Route::get('user', function () { return redirect('user.login');});
Route::post('user.userLogin', 'UserController@userLogin');
Route::post('user.userLogout', 'UserController@userLogout');
Route::post('user.getUserInformation', 'UserController@getUserInformation');
Route::post('user.changeUserPassword', 'UserController@changeUserPassword');
Route::post('user.getUserTotalAmount', 'UserController@getUserTotalAmount');

Route::post('user.csvOrderHistoryList', 'UserController@csvOrderHistoryList');
Route::post('user.getOrderHistoryList', 'UserController@getOrderHistoryList');
Route::post('user.getOrderInformation', 'UserController@getOrderInformation');
Route::post('user.getAllCurrencyList', 'UserController@getAllCurrencyList');
Route::post('user.getAllItemList', 'UserController@getAllItemList');
Route::post('user.addNewOutcomeOrder', 'UserController@addNewOutcomeOrder');
Route::post('user.goOutcomeModPage', 'UserController@goOutcomeModPage');
Route::post('user.getOrderDetailInformation', 'UserController@getOrderDetailInformation');
Route::post('user.modOutcomeOrderInfo', 'UserController@modOutcomeOrderInfo');
*/
include ('mobile.php');
Route::get('/{page}', 'AdminController@index'); // don't call this part for mobile.php route




