<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use mysql_xdevapi\Exception;

class AdminController extends BaseController
{

    public function __construct(Request $request)
    {
//        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(view()->exists($id)){
            return view($id);
        }
        else
        {
            return view('404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //-----------------------------------------------------
    // Admin login part
    //-----------------------------------------------------
    public function adminLogin(Request $request){
        $userid = $request->post('userid');
        $password = $request->post('password');
        $tb_user_info = 'tb_user_info';
        $updated_at = @date("Y-m-d h:i:s", time());


        $user = DB::table($tb_user_info)->where('user_id', $userid)->first();
        //$dec_password = $this->encrypt_decrypt('decrypt', "MVdWZVNKdkgrVzZRYk1MZ045V3NRdz09");

        if($user == null){
            return \Response::json([
                'msg' => 'nonuser'
            ]);
        }
        else{
            $md5pwd = $this->encrypt_decrypt('encrypt', $password);
            $pwd = DB::table($tb_user_info)->where('user_id', $userid)->where('user_pwd', $md5pwd)->first();
            if($pwd == null){
                return \Response::json([
                    'msg' => 'nonpwd'
                ]);
            }
            else{
                DB::table($tb_user_info)->where('user_id', $userid)->update(['active' => 1]);
                $request->session()->put('user', 'admin');
                $request->session()->put('user_num', $user->user_num);
                $request->session()->put('user_id', $user->user_id);
                $request->session()->put('user_type', $user->user_type);
                $request->session()->put('user_name', $user->user_name);
                $request->session()->put('logintime', $updated_at);
                $request->session()->put('checktime', $updated_at);
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
        }
    }

    public function adminLogout(Request $request){
        $this->logout();

        return \Response::json([
            'msg' => 'ok'
        ]);
        exit();
    }

    public function logout()
    {
        $userid = session('user_id',null);
        if(!is_null($userid))
            DB::table('tb_user_info')->where('user_id', $userid)->update(['active' => 0]);

        session()->forget('user');
        session()->forget('user_num');
        session()->forget('user_id');
        session()->forget('user_type');
        session()->forget('user_name');
        session()->forget('logintime');
        session()->forget('checktime');
    }

    //-----------------------------------------------------
    // Admin management part
    //-----------------------------------------------------
    public function getAdminList(Request $request){
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;
        $table_user_info = 'tb_user_info';

        $user_type = $request->session()->get('user_type', 0);

        $sql = 'SELECT * from '. $table_user_info. ' ';
        if((int)$user_type <= 0) // be geted user_type < 1 if not admin
            $sql .= ' WHERE user_type < 1 ';
        $lim_sql = $sql.'LIMIT '.$start_from.', '.$count.'';
        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));
        $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        $total = count($total_rows);
        $total_page = ceil($total / $count);
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'total'    =>  $total,
                'start'    =>  $start,
                'totalpage'    =>  $total_page,
                'lists' => $rows,
            ]);
        }
    }

    public function getAdminInformation(Request $request){
        $id = $request->post('id');
        $table_admin = 'admin';
        $rows =DB::table($table_admin)->where('id', $id)->first();
        $password = $rows->password;
        $dec_password = $this->encrypt_decrypt('decrypt', $password);

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
                'pwd' => $dec_password,
            ]);
        }
    }

    public function editAdminInformation(Request $request){
        $id = $request->post('id');
        $account = $request->post('account');
        $password = $request->post('password');
        $name = $request->post('name');
        $table_admin = 'admin';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_admin)->where('id', $id)->doesntExist();
        if (!$cnt){
            $enc_password = $this->encrypt_decrypt('encrypt', $password);
            $success =  DB::table($table_admin)->where('id', $id)
                ->update(
                    [
                        'account' => $account,
                        'name' => $name,
                        'password' => $enc_password,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    public function adminRegister(Request $request){
        $account = $request->post('account');
        $password = $request->post('password');
        $name = $request->post('name');
        $table_admin = 'admin';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_admin)->where('account', $account)->doesntExist();
        if ($cnt){
            $enc_password = $this->encrypt_decrypt('encrypt', $password);
            $success =  DB::table($table_admin)
                ->insert(
                    [
                        'account' => $account,
                        'name' => $name,
                        'password' => $enc_password,
                        'created_at' => $current_time,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'du'
            ]);
        }
    }

    public function adminDelete(Request $request){
        $id = $request->post('id');
        $table_admin = 'admin';
        $success = false;

        $cnt = DB::table($table_admin)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success = DB::table($table_admin)->delete($id);
        }
        if ($success) {
            return \Response::json([
                'msg' => 'ok'
            ]);
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    //-----------------------------------------------------
    // User management part
    //-----------------------------------------------------
    public function getUserList(Request $request){
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;
        $table_user = 'user';
        $sql = 'SELECT * from '. $table_user. ' ';
        $lim_sql = $sql.'LIMIT '.$start_from.', '.$count.'';
        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));
        $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        $total = count($total_rows);
        $total_page = ceil($total / $count);
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'total'    =>  $total,
                'start'    =>  $start,
                'totalpage'    =>  $total_page,
                'lists' => $rows,
            ]);
        }
    }

    public function userRegister(Request $request){
        $account = $request->post('account');
        $password = $request->post('password');
        $name = $request->post('name');
        $table_user = 'user';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_user)->where('account', $account)->doesntExist();
        if ($cnt){
            $enc_password = $this->encrypt_decrypt('encrypt', $password);
            $success =  DB::table($table_user)
                ->insert(
                    [
                        'account' => $account,
                        'name' => $name,
                        'password' => $enc_password,
                        'created_at' => $current_time,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'du'
            ]);
        }
    }

    public function userDelete(Request $request){
        $id = $request->post('id');
        $table_user = 'user';
        $table_order = 'order_history';
        $success = false;

        $cnt = DB::table($table_user)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success = DB::table($table_order)->where('user_id', $id)->delete();
            $success = DB::table($table_user)->delete($id);
        }
        if ($success) {
            return \Response::json([
                'msg' => 'ok'
            ]);
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    public function getUserInformation(Request $request){
        $id = $request->post('id');
        $table_user = 'user';
        $rows =DB::table($table_user)->where('id', $id)->first();
        $password = $rows->password;
        $dec_password = $this->encrypt_decrypt('decrypt', $password);

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
                'pwd' => $dec_password,
            ]);
        }
    }

    public function editUserInformation(Request $request){
        $id = $request->post('id');
        $account = $request->post('account');
        $password = $request->post('password');
        $name = $request->post('name');
        $table_user = 'user';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_user)->where('id', $id)->doesntExist();
        if (!$cnt){
            $enc_password = $this->encrypt_decrypt('encrypt', $password);
            $success =  DB::table($table_user)->where('id', $id)
                ->update(
                    [
                        'account' => $account,
                        'name' => $name,
                        'password' => $enc_password,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    //-----------------------------------------------------
    // Order management part
    //-----------------------------------------------------

    public function csvOrderList(Request $request){
        $search_name    = $request->post('sname');
        $search_item   = $request->post('sitem');
        $start_date    = $request->post('start_date');
        $end_date    = $request->post('end_date');
        $sql = 'select o.*, u.name, u.account, c.name as cname, i.name as iname ';
        $sql .= 'from order_history as o ';
        $sql .= 'Left join user as u ';
        $sql .= 'on o.user_id = u.id ';
        $sql .= 'left join currency as c ';
        $sql .= 'on o.currency_id = c.id ';
        $sql .= 'left join item as i ';
        $sql .= 'on o.item_id = i.id ';
        $sql.= "where o.status = 1 ";
        if ($search_name != null && $search_name != '') {
            $sql.="and u.name like '%" .$search_name."%' ";
        }
        if ($search_item != null && $search_item != 0) {
            $sql.="and o.item_id = ".$search_item." ";
        }
        if ($start_date != null && $start_date != '') {
            $start_date = strtotime($start_date);
            $start_date = date('Y-m-d h:i:s',$start_date);
            $sql.="and o.created_at >= '".$start_date."' ";
        }
        if ($end_date != null && $end_date != '') {
            $end_date = strtotime($end_date);
            $end_date = date('Y-m-d h:i:s',$end_date);
            $sql.="and o.created_at <= '".$end_date."' ";
        }
        $lim_sql = $sql.' ORDER BY id desc ';
        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }

    public function getOrderList(Request $request){
        $start  = $request->post('start');
        $count    = $request->post('count');
        $search_name    = $request->post('sname');
        $search_item   = $request->post('sitem');
        $start_date    = $request->post('start_date');
        $end_date    = $request->post('end_date');
        $start_from = ($start-1) * $count;
        $sql = 'select o.*, u.name, u.account, c.name as cname, i.name as iname ';
        $sql .= 'from order_history as o ';
        $sql .= 'Left join user as u ';
        $sql .= 'on o.user_id = u.id ';
        $sql .= 'left join currency as c ';
        $sql .= 'on o.currency_id = c.id ';
        $sql .= 'left join item as i ';
        $sql .= 'on o.item_id = i.id ';
        $sql.= "where o.status = 1 ";
        if ($search_name != null && $search_name != '') {
            $sql.="and u.name like '%" .$search_name."%' ";
        }
        if ($search_item != null && $search_item != 0) {
            $sql.="and o.item_id = ".$search_item." ";
        }
        if ($start_date != null && $start_date != '') {
            $start_date = strtotime($start_date);
            $start_date = date('Y-m-d h:i:s',$start_date);
            $sql.="and o.created_at >= '".$start_date."' ";
        }
        if ($end_date != null && $end_date != '') {
            $end_date = strtotime($end_date);
            $end_date = date('Y-m-d h:i:s',$end_date);
            $sql.="and o.created_at <= '".$end_date."' ";
        }
        $lim_sql = $sql.' ORDER BY id desc LIMIT '.$start_from.', '.$count.'';
        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));
        $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        $total = count($total_rows);
        $total_page = ceil($total / $count);
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'total'    =>  $total,
                'start'    =>  $start,
                'totalpage'    =>  $total_page,
                'lists' => $rows,
            ]);
        }
    }

    public function goOrderModPage(Request $request){
        $id = $request->post('id');

        $request->session()->put('order_id', $id);
        return \Response::json([
            'msg' => 'ok'
        ]);
    }

    public function orderDelete(Request $request){
        $id = $request->post('id');
        $table_order = 'order_history';
        $success = false;

        $cnt = DB::table($table_order)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success = DB::table($table_order)->delete($id);
        }
        if ($success) {
            return \Response::json([
                'msg' => 'ok'
            ]);
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    public function getOrderInformation(Request $request){
        $id = $request->post('id');
        $table_order = 'order_history';
        $rows =DB::table($table_order)->where('id', $id)->first();

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }

    public function getOrderDetailInformation(Request $request){
        $id = $request->post('id');

        $sql = 'select o.*, u.name, u.account, c.name as cname, i.name as iname ';
        $sql .= 'from order_history as o ';
        $sql .= 'Left join user as u ';
        $sql .= 'on o.user_id = u.id  ';
        $sql .= 'Left join currency as c ';
        $sql .= 'on o.currency_id = c.id ';
        $sql .= 'Left join item as i ';
        $sql .= 'on o.item_id = i.id ';
        $sql .= 'where o.id = '.$id.' ';

        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }

    public function getAllUserList(Request $request){
        $table_user = 'user';
        $rows = DB::table($table_user)->get();
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }
    public function getAllCurrencyList(Request $request){
        $currencys = DB::table('currency')->get();
        $items = DB::table('item')->get();

        return \Response::json([
            'msg' => 'ok',
            'c_lists' => $currencys,
            'i_lists' => $items
        ]);
    }

    public function addNewOrder(Request $request){
        $user_id = $request->post('user_id');
        $type = $request->post('type');
        $currency_id = $request->post('currency_id');
        $item_id = $request->post('item_id');
        $amount = $request->post('amount');
        $description = $request->post('description');
        $date_string = $request->post('create_date');
        $current_time = date("Y-m-d h:i:s", time());
        $table_order = 'order_history';
        if ($date_string == null || $date_string =='') {
            $create_date = $current_time;
        }
        else {
            $date_string = strtotime($date_string);
            $create_date = date('Y-m-d h:i:s',$date_string);
        }

        $image_urls = array();
        for ($i = 0; $i < 8; $i++) {
            $image = $request->file('image_'.$i);
            $image_url = "";
            $currentTime = date("YmdHis");
            $randNum = rand(1, 9);
            $order_number = $currentTime.$randNum.$i;
            if($image != null && $image != ''){
                $new_name = $order_number.'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/uploads'), $new_name);
                $image_url = 'images/uploads/'.$new_name;
            }
            //array_push($image_urls, $image_url);
            $image_urls[] = $image_url;
        }
        $success =  DB::table($table_order)
            ->insert(
                [
                    'order_no' => $order_number,
                    'order_type' => $type,
                    'user_id' => $user_id,
                    'currency_id' => $currency_id,
                    'item_id' => $item_id,
                    'status' => 1,
                    'amount' => $amount,
                    'description' => $description,
                    'img_0' => $image_urls[0],
                    'img_1' => $image_urls[1],
                    'img_2' => $image_urls[2],
                    'img_3' => $image_urls[3],
                    'img_4' => $image_urls[4],
                    'img_5' => $image_urls[5],
                    'img_6' => $image_urls[6],
                    'img_7' => $image_urls[7],
                    'created_at' => $create_date,
                    'updated_at' => $current_time,
                ]
            );
            if ($success) {
            return \Response::json([
                'msg' => 'ok'
            ]);
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    public function modOrderInfo(Request $request){
        $order_id = $request->post('order_id');
        $currency_id = $request->post('currency_id');
        $item_id = $request->post('item_id');
        $amount = $request->post('amount');
        $description = $request->post('description');
        $date_string = $request->post('create_date');

        $current_time = date("Y-m-d h:i:s", time());
        $table_order = 'order_history';
        if ($date_string == null || $date_string =='') {
            $create_date = $current_time;
        }
        else {
            $date_string = strtotime($date_string);
            $create_date = date('Y-m-d h:i:s',$date_string);
        }

        $image_urls = array();
        for ($i = 0; $i < 8; $i++) {
            $image = $request->file('image_'.$i);
            $image_url = "";
            $currentTime = date("YmdHis");
            $randNum = rand(1, 9);
            $order_number = $currentTime.$randNum.$i;
            if($image != null && $image != ''){
                $new_name = $order_number.'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/uploads'), $new_name);
                $image_url = 'images/uploads/'.$new_name;
            }
            else{
                $pre = $request->post('pre_'.$i);
                if($pre != null && $pre != '')
                {
                    $image_url = $pre;
                }
            }
            array_push($image_urls, $image_url);
        }
        $success =  DB::table($table_order)->where('id', $order_id)
            ->update(
                [
                    'currency_id' => $currency_id,
                    'item_id' => $item_id,
                    'status' => 1,
                    'amount' => $amount,
                    'description' => $description,
                    'img_0' => $image_urls[0],
                    'img_1' => $image_urls[1],
                    'img_2' => $image_urls[2],
                    'img_3' => $image_urls[3],
                    'img_4' => $image_urls[4],
                    'img_5' => $image_urls[5],
                    'img_6' => $image_urls[6],
                    'img_7' => $image_urls[7],
                    'created_at' => $create_date,
                    'updated_at' => $current_time,
                ]
            );
        if ($success) {
            return \Response::json([
                'msg' => 'ok'
            ]);
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }
    //-----------------------------------------------------
    // Order history management part
    //-----------------------------------------------------
    public function csvOrderHistoryList(Request $request){
        $search_name    = $request->post('sname');
        $search_item = $request->post('sitem');
        $start_date    = $request->post('start_date');
        $end_date    = $request->post('end_date');
        $sql = 'select * from user ';
        $sql.= "where 1 = 1 ";
        if ($search_name != null && $search_name != '') {
            $sql.="and name like '%" .$search_name."%' ";
        }
        $rows = DB::select( DB::raw($sql));
        foreach ($rows as $key => $row) {
            $user_id = $row -> id;
            $total_amount = $this -> getUserTotalAmount($user_id, $start_date, $end_date, $search_item);
            $rows[$key]->total_amount = $total_amount;
        }
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }

    public function getOrderHistoryList(Request $request){
        $start  = $request->post('start');
        $count    = $request->post('count');
        $search_name    = $request->post('sname');
        $search_item = $request->post('sitem');
        $start_date    = $request->post('start_date');
        $end_date    = $request->post('end_date');
        $start_from = ($start-1) * $count;
        $sql = 'select * from user ';
        $sql.= "where 1 = 1 ";
        if ($search_name != null && $search_name != '') {
            $sql.="and name like '%" .$search_name."%' ";
        }
        $lim_sql = $sql.' LIMIT '.$start_from.', '.$count.'';
        $rows = DB::select( DB::raw($lim_sql));
        foreach ($rows as $key => $row) {
            $user_id = $row -> id;
            $total_amount = $this -> getUserTotalAmount($user_id, $start_date, $end_date, $search_item);
            $rows[$key]->total_amount = $total_amount;
        }
        $total_rows = DB::select( DB::raw($sql));
        $total = count($total_rows);
        $total_page = ceil($total / $count);
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'total'    =>  $total,
                'start'    =>  $start,
                'totalpage'    =>  $total_page,
                'lists' => $rows,
            ]);
        }
    }

    function getUserTotalAmount($user_id, $start_date, $end_date, $search_item){
        $sql = 'Select o.order_type , sum(o.amount) as tamount, c.name as cname, i.name as iname, c.id as cid ';
        $sql .='From order_history as o ';
        $sql .='Left join currency as c ';
        $sql .='on o.currency_id = c.id ';
        $sql.= 'Left join item as i ';
        $sql .='on o.item_id = i.id ';
        $sql.= 'Where o.user_id = '.$user_id.' ';
        if ($start_date != null && $start_date != '') {
            $start_date = strtotime($start_date);
            $start_date = date('Y-m-d h:i:s',$start_date);
            $sql.="and o.created_at >= '".$start_date."' ";
        }
        if ($end_date != null && $end_date != '') {
            $end_date = strtotime($end_date);
            $end_date = date('Y-m-d h:i:s',$end_date);
            $sql.="and o.created_at <= '".$end_date."' ";
        }
        if ($search_item != null && $search_item != 0) {
            $sql.="and o.item_id = ".$search_item." ";
        }
        $sql.= 'and o.status = 1 ';
        $sql.='group by o.order_type, o.currency_id order by o.order_type ';
        $rows = DB::select( DB::raw($sql));
        return $rows;
    }

    //-----------------------------------------------------
    // Currency management part
    //-----------------------------------------------------
    public function currencyDelete(Request $request){
        $id = $request->post('id');
        $table_user = 'currency';
        $table_order = 'order_history';
        $success1 = false;
        $success2 = false;

        $cnt = DB::table($table_user)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success1 = DB::table($table_order)->where('currency_id', $id)->delete();
            $success2 = DB::table($table_user)->delete($id);
        }
        return \Response::json([
            'msg' => 'ok'
        ]);
    }

    public function currencyAdd(Request $request){
        $name = $request->post('name');
        $value = $request->post('value');
        $table_currency = 'currency';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_currency)->where('name', $name)->doesntExist();
        if ($cnt){
            $success =  DB::table($table_currency)
                ->insert(
                    [
                        'name' => $name,
                        'value' => $value,
                        'created_at' => $current_time,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'du'
            ]);
        }
    }

    public function getCurrencyInformation(Request $request){
        $id = $request->post('id');
        $table_currency = 'currency';
        $rows =DB::table($table_currency)->where('id', $id)->first();

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }

    public function editCurrencyInformation(Request $request){
        $id = $request->post('id');
        $name = $request->post('name');
        $value = $request->post('value');
        $table_currency = 'currency';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_currency)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success =  DB::table($table_currency)->where('id', $id)
                ->update(
                    [
                        'name' => $name,
                        'value' => $value,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    //-----------------------------------------------------
    // Outcome request management part
    //-----------------------------------------------------
    public function getOutcomeRequestList(Request $request){
        $start  = $request->post('start');
        $count    = $request->post('count');
        $search_name    = $request->post('sname');
        $start_date    = $request->post('start_date');
        $end_date    = $request->post('end_date');
        $start_from = ($start-1) * $count;
        $sql = 'select o.*, u.name, u.account, c.name as cname, i.name as iname ';
        $sql .= 'from order_history as o ';
        $sql .= 'Left join user as u ';
        $sql .= 'on o.user_id = u.id ';
        $sql .= 'left join currency as c ';
        $sql .= 'on o.currency_id = c.id ';
        $sql .= 'left join item as i ';
        $sql .= 'on o.item_id = i.id ';
        $sql .= 'where o.status = 0 ';
        if ($search_name != null && $search_name != '') {
            $sql.="and u.name like '%" .$search_name."%' ";
        }
        if ($start_date != null && $start_date != '') {
            $start_date = strtotime($start_date);
            $start_date = date('Y-m-d h:i:s',$start_date);
            $sql.="and o.created_at >= '".$start_date."' ";
        }
        if ($end_date != null && $end_date != '') {
            $end_date = strtotime($end_date);
            $end_date = date('Y-m-d h:i:s',$end_date);
            $sql.="and o.created_at <= '".$end_date."' ";
        }
        $lim_sql = $sql.' LIMIT '.$start_from.', '.$count.'';
        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));
        $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        $total = count($total_rows);
        $total_page = ceil($total / $count);
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'total'    =>  $total,
                'start'    =>  $start,
                'totalpage'    =>  $total_page,
                'lists' => $rows,
            ]);
        }
    }

    public function agreeOutcomeRequest(Request $request){
        $id = $request->post('id');
        $table_order_history = 'order_history';
        $cnt = DB::table($table_order_history)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success =  DB::table($table_order_history)->where('id', $id)
                ->update(
                    [
                        'status' => 1,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    public function rejectOutcomeRequest(Request $request){
        $id = $request->post('id');
        $table_order_history = 'order_history';
        $cnt = DB::table($table_order_history)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success =  DB::table($table_order_history)->where('id', $id)
                ->update(
                    [
                        'status' => 2,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    public function itemDelete(Request $request){
        $id = $request->post('id');
        $table_item = 'item';
        $table_order = 'order_history';
        $success1 = false;
        $success2 = false;

        $cnt = DB::table($table_item)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success1 = DB::table($table_order)->where('item_id', $id)->delete();
            $success2 = DB::table($table_item)->delete($id);
        }
        return \Response::json([
            'msg' => 'ok'
        ]);
    }

    public function itemAdd(Request $request){
        $name = $request->post('name');
        $value = $request->post('value');
        $table_item = 'item';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_item)->where('name', $name)->doesntExist();
        if ($cnt){
            $success =  DB::table($table_item)
                ->insert(
                    [
                        'name' => $name,
                        'value' => $value,
                        'created_at' => $current_time,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'du'
            ]);
        }
    }

    public function getItemInformation(Request $request){
        $id = $request->post('id');
        $table_item = 'item';
        $rows =DB::table($table_item)->where('id', $id)->first();

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }

    public function editItemInformation(Request $request){
        $id = $request->post('id');
        $name = $request->post('name');
        $value = $request->post('value');
        $table_item = 'item';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_item)->where('id', $id)->doesntExist();
        if (!$cnt){
            $success =  DB::table($table_item)->where('id', $id)
                ->update(
                    [
                        'name' => $name,
                        'value' => $value,
                        'updated_at' => $current_time,
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
            else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }
        else {
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }
    public function getAllItemList(Request $request){
        $table_currency = 'item';
        $rows = DB::table($table_currency)->get();
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
    }

    public function dashborad(Request $request){
        return \Response::json([
            'msg' => 'ok',
            'lists' => [],
        ]);
    }

    public function corporateSignup(Request $request){
        $smart_phone = $request->post('smart_phone');
        $password = $request->post('password');
        $corporate_company_name = $request->post('corporate_company_name');
        $corporate_phone = $request->post('corporate_phone');
        $corporate_address = $request->post('corporate_address');
        $corporate_name = $request->post('corporate_name');
        $company_phone = $request->post('company_phone');
        $date_string = $request->post('create_date');
        $current_time = date("Y-m-d h:i:s", time());
        $company_manager = $request->post('company_manager');
        $car_count = $request->post('car_count');
        $corporate_doc_file = $request->file('corporate_doc_file');
        $corporate_doc_name = '';

        if ($date_string === null || $date_string ==='') {
            $create_date = $current_time;
        }
        else {
            $date_string = strtotime($date_string);
            $create_date = date('Y-m-d h:i:s',$date_string);
        }

        $corporate_doc_url='';
        $doc_currentTime = date("YmdHis");
        $randNum = rand(1, 9);
        $order_number = $doc_currentTime.$randNum;
        if($corporate_doc_file != null && $corporate_doc_file != ''){
            $new_name = $order_number.'.'.$corporate_doc_file->getClientOriginalExtension();
            $corporate_doc_file->move(public_path('docs/uploads'), $new_name);
            $corporate_doc_url = 'docs/uploads/'.$new_name;
            $corporate_doc_name = $corporate_doc_file->getClientOriginalName();
        }

        $enc_password = $this->encrypt_decrypt('encrypt', $password);

        $table_user_info = 'tb_user_info';
        try {
            $cnt = DB::table($table_user_info)->where('user_id', $smart_phone)->doesntExist();
            if (!$cnt){ // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $success = DB::table($table_user_info)
                ->insert(
                    [
                        'user_id' => $smart_phone, // 아이디
                        'user_pwd' => $enc_password, // 암호
                        'user_type' => 0, // 1 어드민 | 0 사업자
                        'user_class' => 1, // 0 회사 | 1 개인
                        'user_regnum' => $corporate_phone, // 사업자 등록번호
                        'user_address' => $corporate_address, // 주소
                        'user_name' => $corporate_name, // 대표자 성명
                        'user_birthday' => '',
                        'user_email' => '',
                        'company_name' => $corporate_company_name, // 상호(회사이름)
                        'company_phone' => $company_phone, // 회사 전화번호
                        'person_name' => $company_manager, // 담당자 이름
                        'person_phone' => '', // 담당자 전화번호
                        'certified_copy' => $corporate_doc_url, // 등록증 사본
                        'certified_name' => $corporate_doc_name, // 등록증 사본 실지 이름
                        'certifice_status' => 0, // 인증여부 1: 인증됨, 0: 안됨
                        'car_count' => (int)$car_count, // 차량수량
                        'create_date' => $create_date, // 설립일자
                        'registe_date' => '', // 가입일시
                        'visit_date' => '', // 방문시간
                        'website' => '',
                        'active' => 0, // 1 이면 액티브 , 0 이면 디액티브
                    ]
                );
            if ($success) {
                return \Response::json([
                    'msg' => 'ok'
                ]);
            } else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        }catch(Exception $e) {
            return \Response::json([
                'msg' => $e->getMessage()
            ]);
        }
    }

} // area of class
