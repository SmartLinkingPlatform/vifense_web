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

    public function getUserList(Request $request){
        $search_val = $request->post('search_val');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');

        $sql = "SELECT a.admin_id, a.user_id, a.user_phone, b.company_name, a.user_name, a.certifice_status, a.active, a.create_date, a.update_date ";
        $sql .= "FROM tb_user_info AS a LEFT JOIN tb_admin_info AS b ON a.admin_id = b.admin_id ";
        $sql .= "WHERE 1 ";

        if ($user_type == 0) {
            $sql .= " AND a.admin_id = ".$admin_id;
        }

        if(!is_null($search_val))
            $sql .= ' AND (a.user_name like "%'.$search_val.'%" OR a.user_phone like "%'.$search_val.'%") ';
        $lim_sql = $sql.' ORDER BY user_id DESC LIMIT '.$start_from.', '.$count;

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

    public function getCompanyName(Request $request){
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');

        $sql = "SELECT admin_id, company_name FROM tb_admin_info ";
        $sql .= " WHERE user_type < 1 ";
        if ($user_type == 0) {
            $sql .= " AND admin_id = ".$admin_id;
        }
        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

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

    public function addNewUserInfo(Request $request){
        $smart_phone = $request->post('smart_phone');
        $user_name = $request->post('user_name');
        $user_email = $request->post('user_email');
        $password = $request->post('password');
        $admin_id = $request->post('admin_id');
        $create_date = date("Y-m-d h:i:s", time());

        $cnt = DB::table($this->tb_user_info)->where('user_phone', $smart_phone)->doesntExist();
        if (!$cnt){ // exist
            return \Response::json([
                'msg' => 'du'
            ]);

            exit();
        }
        $success = DB::table($this->tb_user_info)
            ->insert(
                [
                    'user_phone' => $smart_phone,
                    'user_name' => $user_name,
                    'user_email' => $user_email,
                    'user_pwd' => $password,
                    'admin_id' => $admin_id,
                    'create_date' => $create_date,
                    'update_date' => '',
                    'certifice_status' => '0',
                    'active' => '0'
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

    }

    public function getUserinInfo(Request $request){
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');
        $user_id = $request->post('user_id');

        $rows =DB::table($this->tb_user_info)->where('user_id', $user_id)->first();
        $user_phone = $rows->user_phone;
        $user_name = $rows->user_name;
        $user_email = $rows->user_email;
        $password = $rows->user_pwd;
        $dec_password = $this->encrypt_decrypt('decrypt', $password);


        $sql = "SELECT admin_id, company_name FROM tb_admin_info ";
        $sql .= " WHERE user_type < 1 ";
        if ($user_type == 0) {
            $sql .= " AND admin_id = ".$admin_id;
        }
        $c_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
        if($rows == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'user_phone' => $user_phone,
                'user_name' => $user_name,
                'user_email' => $user_email,
                'user_pwd' => $dec_password,
                'c_list' => $c_rows
            ]);
        }
    }

    public function editUserInfo(Request $request){
        $smart_phone = $request->post('smart_phone');
        $user_name = $request->post('user_name');
        $user_email = $request->post('user_email');
        $password = $request->post('password');
        $enc_password = $this->encrypt_decrypt('encrypt', $password);
        $admin_id = $request->post('admin_id');
        $user_id = $request->post('user_id');
        $update_date = date("Y-m-d h:i:s", time());

        $success = DB::table($this->tb_user_info)->where('user_id', $user_id)
            ->update(
                [
                    'user_phone' => $smart_phone,
                    'user_name' => $user_name,
                    'user_email' => $user_email,
                    'user_pwd' => $enc_password,
                    'admin_id' => $admin_id,
                    'update_date' => $update_date,
                    'certifice_status' => '1',
                    'active' => '0'
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
    }

    public function userDelete(Request $request){
        $user_id = $request->post('user_id');
        $success = false;

        $cnt = DB::table($this->tb_user_info)->where('user_id', $user_id)->doesntExist();
        if (!$cnt){
            $success = DB::table($this->tb_user_info)->where('user_id', $user_id)->delete();
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

    public function showUserInfo(Request $request){
        $user_id = $request->post('user_id');

        $row = DB::table($this->tb_user_info)->where('user_id', $user_id)->first();
        if($row == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            $birthday = "";
            if(!is_null($row->user_birthday)) {
                $birthday = substr($row->user_birthday, 0, 4).'년';
                $birthday .= substr($row->user_birthday, 4, 2).'월';
                $birthday .= substr($row->user_birthday, 6, 2).'일';
            }
            return \Response::json([
                'msg' => 'ok',
                'user_birthday' => $birthday,
                'user_email' => $row->user_email
            ]);
        }
    }
}
