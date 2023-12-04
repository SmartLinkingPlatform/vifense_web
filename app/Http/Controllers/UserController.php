<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use mysql_xdevapi\Exception;

class UserController extends BaseController
{
    protected $tb_user_info ='tb_user_info';

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
    // User login part
    //-----------------------------------------------------
    public function userLogin(Request $request){
        $account = $request->post('username');
        $password = $request->post('password');
        $table_user = 'user';
        $updated_at = date("Y-m-d h:i:s", time());

        $user = DB::table($table_user)->where('account', $account)->first();

        if($user == null){
            return \Response::json([
                'msg' => 'nonuser'
            ]);
        }
        else{
            $md5pwd = $this->encrypt_decrypt('encrypt', $password);
            $pwd = DB::table($table_user)->where('account', $account)->where('password', $md5pwd)->first();
            if($pwd == null){
                return \Response::json([
                    'msg' => 'nonpwd'
                ]);
            }
            else{
                $request->session()->put('user', 'user');
                $request->session()->put('user_id', $user->id);
                $request->session()->put('user_name', $user->name);
                $request->session()->put('user_account', $user->account);
                $request->session()->put('logintime', $updated_at);
                $request->session()->put('checktime', $updated_at);
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
        }
    }

    public function userLogout(Request $request){
        $this->logout();

        return \Response::json([
            'msg' => 'ok'
        ]);
        exit();
    }

    public function logout()
    {
        session()->forget('user');
        session()->forget('user_id');
        session()->forget('user_name');
        session()->forget('user_account');
        session()->forget('logintime');
        session()->forget('checktime');
    }

    //-----------------------------------------------------
    // User information part
    //-----------------------------------------------------
    public function getUserInformation(Request $request){
        $id = $request->post('user_id');
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

    public function changeUserPassword(Request $request){
        $id = $request->post('id');
        $password = $request->post('password');
        $table_user = 'user';
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($table_user)->where('id', $id)->doesntExist();
        if (!$cnt){
            $enc_password = $this->encrypt_decrypt('encrypt', $password);
            $success =  DB::table($table_user)->where('id', $id)
                ->update(
                    [
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

    public function getUserTotalAmount(Request $request){
        $id = $request->post('id');
        $sql = 'Select o.order_type , sum(o.amount) as tamount, c.name as cname
                From order_history as o
                Left join currency as c
                on o.currency_id = c.id ';
        $sql.= 'Where o.user_id = '.$id.' ';
        $sql.= 'and o.status = 1 ';
        $sql.='group by o.order_type, o.currency_id
order by o.order_type ';
        $rows = DB::select( DB::raw($sql));
        if ($rows){
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
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

    //-----------------------------------------------------
    // Order history management part
    //-----------------------------------------------------
    public function csvOrderHistoryList(Request $request){
        $user_id = $request->post('id');
        $search_name    = $request->post('sname');
        $search_item    = $request->post('sitem');
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
        $sql .= 'where o.user_id = '.$user_id.' ';
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
        $lim_sql = $sql.'  ORDER BY id desc ';
        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));

        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows
            ]);
        }
    }
    public function getOrderHistoryList(Request $request){
        $user_id = $request->post('id');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $search_name    = $request->post('sname');
        $search_item    = $request->post('sitem');
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
        $sql .= 'where o.user_id = '.$user_id.' ';
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
        $lim_sql = $sql.'  ORDER BY id desc LIMIT '.$start_from.', '.$count.'';
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
    public function getAllCurrencyList(Request $request){
        $currencys = DB::table('currency')->get();
        $items = DB::table('item')->get();

        return \Response::json([
            'msg' => 'ok',
            'c_lists' => $currencys,
            'i_lists' => $items
        ]);
    }

    public function addNewOutcomeOrder(Request $request){
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
            array_push($image_urls, $image_url);
        }
        $success =  DB::table($table_order)
            ->insert(
                [
                    'order_no' => $order_number,
                    'order_type' => $type,
                    'user_id' => $user_id,
                    'currency_id' => $currency_id,
                    'item_id' => $item_id,
                    'status' => 0,
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
    public function goOutcomeModPage(Request $request){
        $id = $request->post('id');

        $request->session()->put('order_id', $id);
        return \Response::json([
            'msg' => 'ok'
        ]);
    }

    public function getOrderDetailInformation(Request $request){
        $id = $request->post('id');

        $sql = 'select o.*, u.name, u.account, c.name as cname, i.name as iname ';
        $sql .= 'from order_history as o ';
        $sql .= 'Left join user as u ';
        $sql .= 'on o.user_id = u.id ';
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

    public function modOutcomeOrderInfo(Request $request){
        $order_id = $request->post('order_id');
        $currency_id = $request->post('currency_id');
        $item_id = $request->post('item_id');
        $amount = $request->post('amount');
        $description = $request->post('description');
        $date_string = $request->post('create_date');
        //$image_file = $request->post('image_file');

        $image = $request->file('image_file');
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
                    'status' => 0,
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


}
