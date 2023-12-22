<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use Exception;
//use phpseclib3\Crypt\PublicKeyLoader;

class AdminController extends BaseController
{
    protected $tb_admin_info='tb_admin_info';
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
        date_default_timezone_set('Asia/Seoul');
        $updated_at = @date("Y-m-d h:i:s", time());

        $user = DB::table($this->tb_admin_info)->where('user_phone', $userid)->first();

        if($user == null){
            return \Response::json([
                'msg' => 'nonuser'
            ]);
        }
        else{
            $md5pwd = $this->encrypt($password);
            $pwd = DB::table($this->tb_admin_info)->where('user_phone', $userid)->where('user_pwd', $md5pwd)->first();
            if($pwd == null){
                return \Response::json([
                    'msg' => 'nonpwd'
                ]);
            }
            else{
                DB::table($this->tb_admin_info)->where('admin_id', $userid)
                    ->update(
                        [
                            'visit_date' => $updated_at,
                            'actived' => 1
                        ]
                    );
                $request->session()->put('user', 'admin');
                $request->session()->put('admin_id', $user->admin_id);
                $request->session()->put('user_phone', $user->user_phone);
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
        $user_phone = session('user_phone',null);
        if(!is_null($user_phone))
            DB::table($this->tb_admin_info)->where('user_phone', $user_phone)->update(['actived' => 0]);

        session()->forget('user');
        session()->forget('admin_id');
        session()->forget('user_phone');
        session()->forget('user_type');
        session()->forget('user_name');
        session()->forget('logintime');
        session()->forget('checktime');
    }

    public function getUserRegisterNumber(Request $request){
        $user_phone = $request->post('user_phone');
        $row = DB::table($this->tb_admin_info)->where('user_phone', $user_phone)->first();

        if($row == null){
            return \Response::json([
                'msg' => 'nonuser'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'userRegNum' => $row->user_regnum
            ]);
        }
    }

    public function registerNewPassword(Request $request){
        $user_phone = $request->post('user_phone');
        $new_pwd = $request->post('new_pwd');
        $enc_password = $this->encrypt($new_pwd);

        $success = DB::table($this->tb_admin_info)->where('user_phone', $user_phone)
            ->update(
                [
                    'user_pwd' => $enc_password
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
    // Admin management part
    //-----------------------------------------------------
    public function getAdminList(Request $request){
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;

        $user_type = $request->session()->get('user_type', 0);

        $sql = 'SELECT * from '. $this->tb_admin_info. ' ';
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

    public function editAdminInformation(Request $request){
        $admin_id = $request->post('admin_id');
        $user_phone = $request->post('user_phone');
        $password = $request->post('password');
        $name = $request->post('name');
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($this->tb_admin_info)->where('admin_id', $admin_id)->doesntExist();
        if (!$cnt){
            $enc_password = $this->encrypt($password);
            $success =  DB::table($this->tb_admin_info)->where('admin_id', $admin_id)
                ->update(
                    [
                        'user_phone' => $user_phone,
                        'user_name' => $name,
                        'user_pwd' => $enc_password,
                        'update_date' => $current_time,
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
        $user_phone = $request->post('user_phone');
        $password = $request->post('password');
        $name = $request->post('name');
        $current_time = date("Y-m-d h:i:s", time());

        $cnt = DB::table($this->tb_admin_info)->where('user_phone', $user_phone)->doesntExist();
        if ($cnt){
            $enc_password = $this->encrypt($password);
            $success =  DB::table($this->tb_admin_info)
                ->insert(
                    [
                        'user_phone' => $user_phone,
                        'user_name' => $name,
                        'user_pwd' => $enc_password,
                        'registe_date' => $current_time,
                        'update_date' => $current_time,
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
        $id = $request->post('admin_id');
        $success = false;

        $cnt = DB::table($this->tb_admin_info)->where('admin_id', $id)->doesntExist();
        if (!$cnt){
            $success = DB::table($this->tb_admin_info)->delete($id);
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

    public function getCompanyList(Request $request){
        $search_val = $request->post('search_val');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;

        $company = 'tb_admin_info';

        $sql = 'SELECT * from '.$company. ' ';
        $sql .= ' WHERE user_type < 1 '; // to not admin

        if(!is_null($search_val))
            $sql .= ' AND (user_phone like "%'.$search_val.'%" OR company_name like "%'.$search_val.'%") ';

        $lim_sql = $sql.'LIMIT '.$start_from.', '.$count;
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

    /* This function equal corporateSignup of AdminController */
    public function addNewCompany(Request $request){
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
        $corporate_photo_file = $request->file('corporate_photo_file');
        $corporate_doc_file = $request->file('corporate_doc_file');
        $corporate_photo_name = '';
        $corporate_doc_name = '';

        if ($date_string === null || $date_string ==='') {
            $create_date = $current_time;
        }
        else {
            $date_string = strtotime($date_string);
            $create_date = date('Y-m-d h:i:s',$date_string);
        }

        $corporate_photo_url='';
        $file_currentTime = date("YmdHis");
        $randNump= rand(1, 9);
        $order_numberp = $file_currentTime.$randNump;
        if($corporate_photo_file != null && $corporate_photo_file != ''){
            $new_namep = $order_numberp.'.'.$corporate_photo_file->getClientOriginalExtension();
            $corporate_photo_file->move(public_path('images/uploads'), $new_namep);
            $corporate_photo_url = 'images/uploads/'.$new_namep;
            $corporate_photo_name = $corporate_photo_file->getClientOriginalName();
        }

        $corporate_doc_url='';
        $randNum = rand(1, 9);
        $order_number = $file_currentTime.$randNum;
        if($corporate_doc_file != null && $corporate_doc_file != ''){
            $new_name = $order_number.'.'.$corporate_doc_file->getClientOriginalExtension();
            $corporate_doc_file->move(public_path('docs/uploads'), $new_name);
            $corporate_doc_url = 'docs/uploads/'.$new_name;
            $corporate_doc_name = $corporate_doc_file->getClientOriginalName();
        }

        $enc_password = $this->encrypt($password);

        $tb_admin_info = 'tb_admin_info';
        try {
            $cnt = DB::table($tb_admin_info)->where('user_phone', $smart_phone)->doesntExist();
            if (!$cnt){ // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $success = DB::table($tb_admin_info)
                ->insert(
                    [
                        'user_phone' => $smart_phone, // 아이디
                        'user_pwd' => $enc_password, // 암호
                        'user_name' => $corporate_name, // 대표자 성명
                        'user_email' => '', // 이메일
                        'user_birthday' => '',
                        'user_address' => $corporate_address, // 주소
                        'user_photo' => $corporate_photo_name, // 사용자사진 이름
                        'user_photo_url' => $corporate_photo_url, // 사용자사진 경로
                        'user_type' => 0, // 1 어드민 | 0 사업자
                        'user_regnum' => $corporate_phone, // 사업자 등록번호
                        'company_name' => $corporate_company_name, // 상호(회사이름)
                        'company_phone' => $company_phone, // 회사 전화번호
                        'manager_name' => $company_manager, // 담당자 이름
                        'manager_phone' => '', // 담당자 전화번호
                        'certified_copy' => $corporate_doc_url, // 등록증 사본
                        'certifice_status' => 0, // 인증여부 1: 인증됨, 0: 안됨
                        'certified_name' => $corporate_doc_name, // 등록증 사본 실지 이름
                        'car_count' => (int)$car_count, // 차량수량
                        'create_date' => $create_date, // 설립일자
                        'registe_date' => $current_time, // 가입일시
                        'visit_date' => '', // 방문시간
                        'website' => '',
                        'actived' => 0, // 1 이면 액티브 , 0 이면 디액티브
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

    public function dashborad(Request $request){
        return \Response::json([
            'msg' => 'ok',
            'lists' => [],
        ]);
    }

    public function corporateSignup(Request $request){
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');
        $corporate_company_name = $request->post('corporate_company_name');
        $corporate_phone = $request->post('corporate_phone');
        $corporate_address = $request->post('corporate_address');
        $corporate_name = $request->post('corporate_name');
        $company_phone = $request->post('company_phone');
        $date_string = $request->post('create_date');
        $current_time = date("Y-m-d h:i:s", time());
        $company_manager = $request->post('company_manager');
        $car_count = $request->post('car_count');
        //$corporate_photo_file = $request->file('corporate_photo_file');
        $corporate_doc_file = $request->file('corporate_doc_file');
        //$corporate_photo_name = '';
        $corporate_doc_name = '';

        if ($date_string === null || $date_string ==='') {
            $create_date = $current_time;
        }
        else {
            $date_string = strtotime($date_string);
            $create_date = date('Y-m-d h:i:s',$date_string);
        }

        $corporate_photo_url='';
        $file_currentTime = date("YmdHis");
        $randNump= rand(1, 9);
        $order_numberp = $file_currentTime.$randNump;
        /*if($corporate_photo_file != null && $corporate_photo_file != ''){
            $new_namep = $order_numberp.'.'.$corporate_photo_file->getClientOriginalExtension();
            $corporate_photo_file->move(public_path('images/uploads'), $new_namep);
            $corporate_photo_url = 'images/uploads/'.$new_namep;
            $corporate_photo_name = $corporate_photo_file->getClientOriginalName();
        }*/

        $corporate_doc_url='';
        $randNum = rand(1, 9);
        $order_number = $file_currentTime.$randNum;
        if($corporate_doc_file != null && $corporate_doc_file != ''){
            $new_name = $order_number.'.'.$corporate_doc_file->getClientOriginalExtension();
            $corporate_doc_file->move(public_path('docs/uploads'), $new_name);
            $corporate_doc_url = 'docs/uploads/'.$new_name;
            $corporate_doc_name = $corporate_doc_file->getClientOriginalName();
        }

        $enc_password = $this->encrypt($user_pwd);

        try {
            $cnt = DB::table($this->tb_admin_info)->where('user_phone', $user_phone)->doesntExist();
            if (!$cnt){ // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $success = DB::table($this->tb_admin_info)
                ->insert(
                    [
                        'user_phone' => $user_phone, // 아이디
                        'user_pwd' => $enc_password, // 암호
                        'user_name' => $corporate_name, // 대표자 성명
                        'user_email' => '', // 이메일
                        'user_birthday' => '',
                        'user_address' => $corporate_address, // 주소
                        //'user_photo' => $corporate_photo_name, // 사용자사진 이름
                        'user_photo_url' => $corporate_photo_url, // 사용자사진 경로
                        'user_type' => 0, // 1 어드민 | 0 사업자
                        'user_regnum' => $corporate_phone, // 사업자 등록번호
                        'company_name' => $corporate_company_name, // 상호(회사이름)
                        'company_phone' => $company_phone, // 회사 전화번호
                        'manager_name' => $company_manager, // 담당자 이름
                        'manager_phone' => '', // 담당자 전화번호
                        'certified_copy' => $corporate_doc_url, // 등록증 사본
                        'certifice_status' => 0, // 인증여부 1: 인증됨, 0: 안됨
                        'certified_name' => $corporate_doc_name, // 등록증 사본 실지 이름
                        'car_count' => (int)$car_count, // 차량수량
                        'create_date' => $create_date, // 설립일자
                        'registe_date' => $current_time, // 가입일시
                        'visit_date' => '', // 방문시간
                        'website' => '',
                        'actived' => 0, // 1 이면 액티브 , 0 이면 디액티브
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
        }catch(\Exception $e) {
            return \Response::json([
                'msg' => $e->getMessage()
            ]);
        }
    }


    /***** auth part  *****/
    public function getSignNumber(Request $request)
    {
        $smart_phone = $request->post('smart_phone');
        $user_regnum = $request->post('user_regnum');
        try {
            $cnt = DB::table($this->tb_admin_info)->where([
                'user_phone'=>$smart_phone,
                'user_regnum'=>$user_regnum
            ])->doesntExist();
            if ($cnt){ // exist
                return \Response::json([
                    'msg' => 'nonuser'
                ]);
                exit();
            }
            else{
                return \Response::json([
                    'msg' => 'errauth'
                ]);
                exit();
            }

        }catch(Exception $e) {
            return \Response::json([
                'msg' => $e->getMessage()
            ]);
        }

    }

    public function getDashboardInfo(Request $request){
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');
        $now_date = date("Y-m-d", time());

        //총유저수
        $sql = "SELECT COUNT(user_id) AS cnt FROM tb_user_info ";
        if ($user_type == 0) {
            $sql .= " WHERE admin_id = ".$admin_id;
        }
        $total_users = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        //신규 유저수
        $sql = "SELECT COUNT(user_id) AS cnt FROM tb_user_info ";
        $sql .= " WHERE SUBSTRING(create_date, 1, 6) = '".$now_date."'";
        if ($user_type == 0) {
            $sql .= " AND admin_id = ".$admin_id;
        }
        $new_users = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        //일 사용 유저수
        $sql = "SELECT COUNT(user_id) AS cnt FROM tb_user_info ";
        $sql .= " WHERE SUBSTRING(visit_date, 1, 6) = '".$now_date."'";
        if ($user_type == 0) {
            $sql .= " AND admin_id = ".$admin_id;
        }
        $visit_users = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        //총 회사수
        $sql = "SELECT COUNT(admin_id) AS cnt FROM tb_admin_info ";
        $sql .= " WHERE user_type = 0 ";
        if ($user_type == 0) {
            $sql .= " AND admin_id = ".$admin_id;
        }
        $total_companys = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));

        return \Response::json([
            'msg' => 'ok',
            'total_users' => $total_users[0]->cnt,
            'new_users' => $new_users[0]->cnt,
            'visit_users' => $visit_users[0]->cnt,
            'total_companys' => $total_companys[0]->cnt
        ]);

    }

} // area of class
