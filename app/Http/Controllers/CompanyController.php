<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use \Throwable;

class CompanyController extends BaseController
{
    protected $tb_company='tb_admin_info';
    public function __construct(Request $request)
    {
//        $this->middleware("auth");
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

    public function getCompanyList(Request $request){
        $search_val = $request->post('search_val');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;

        $sql = 'SELECT * from '.$this->tb_company. ' ';
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
        $user_address = $request->post('corporate_address');
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

        $enc_password = $this->encrypt_decrypt('encrypt', $password);

        try {
            $cnt = DB::table($this->tb_company)->where('user_phone', $smart_phone)->doesntExist();
            if (!$cnt){ // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $success = DB::table($this->tb_company)
                ->insert(
                    [
                        'user_phone' => $smart_phone, // 아이디
                        'user_pwd' => $enc_password, // 암호
                        'user_name' => $corporate_name, // 대표자 성명
                        'user_email' => '', // 이메일
                        'user_birthday' => '',

                        'user_address' => $user_address, // 사용자 주소
                        'user_photo' => $corporate_photo_name, // 사용자사진 이름
                        'user_photo_url' => $corporate_photo_url, // 사용자사진 경로
                        'user_type' => 0, // 1 어드민 | 0 사업자
                        'user_regnum' => $corporate_phone, // 사업자 등록번호

                        'company_name' => $corporate_company_name, // 상호(회사이름)
                        'company_phone' => $company_phone, // 회사 전화번호
                        'company_address' => '', // 회사 주소

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
        }catch(\Exception $e) {
            return \Response::json([
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getCompanyinInfo(Request $request){
        $admin_id = $request->post('admin_id');
        $rows =DB::table($this->tb_company)->where('admin_id', $admin_id)->first();
        $password = $rows->user_pwd;
        $dec_password = $this->encrypt_decrypt('decrypt', $password);
        $create_date = $rows->create_date ?? '';
        $eDate = explode(' ', $create_date);
        $rows->create_date = $eDate[0] ?? '';
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

    public function editCompanyInfo(Request $request){
        $admin_id = $request->post('admin_id');
        $smart_phone = $request->post('smart_phone');
        $password = $request->post('password');
        $corporate_company_name = $request->post('corporate_company_name');
        $corporate_phone = $request->post('corporate_phone');
        $user_address = $request->post('corporate_address');
        $corporate_name = $request->post('corporate_name');
        $company_phone = $request->post('company_phone');
        $date_string = $request->post('create_date');
        $current_time = date("Y-m-d h:i:s", time());
        $company_manager = $request->post('company_manager');
        $car_count = $request->post('car_count');
        $corporate_photo_file = $request->file('corporate_photo_file');
        $old_corporate_photo_url = $request->post('old_corporate_photo_url');

        $corporate_doc_file = $request->file('corporate_doc_file');
        $old_uploadcorporate_doc_url = $request->post('old_uploadcorporate_doc_url');

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

        $cnt = DB::table($this->tb_company)->where('admin_id', $admin_id)->doesntExist();
        if (!$cnt){
            $enc_password = $this->encrypt_decrypt('encrypt', $password);

            $upValues['user_phone'] = $smart_phone;
            $upValues['user_pwd'] = $enc_password;
            $upValues['user_name'] = $corporate_name;
            $upValues['user_address'] = $user_address;
            $upValues['user_regnum'] = $corporate_phone;
            $upValues['company_name'] = $corporate_company_name;
            $upValues['company_phone'] = $company_phone;
            $upValues['manager_name'] = $company_manager;
            $upValues['car_count'] = (int)$car_count;
            $upValues['create_date'] = $create_date;
            $upValues['update_date'] = $current_time;

            if($corporate_photo_name != '' && $corporate_photo_url != '') {
                $upValues['user_photo'] = $corporate_photo_name;
                $upValues['user_photo_url'] = $corporate_photo_url;
            }
            if($corporate_doc_name != '' && $corporate_doc_url != '') {
                $upValues['certified_name'] = $corporate_doc_name;
                $upValues['certified_copy'] = $corporate_doc_url;
            }

            $success =  DB::table($this->tb_company)->where('admin_id', $admin_id)->update($upValues);
            if ($success) {
                if ($corporate_photo_url != '' && !is_null($old_corporate_photo_url)){
                    unlink($old_corporate_photo_url);
                }
                if ($corporate_doc_url != '' && !is_null($old_uploadcorporate_doc_url)){
                    unlink($old_uploadcorporate_doc_url);
                }

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

    public function companyDelete(Request $request){
        $admin_id = $request->post('admin_id');
        $success = false;

        $cnt = DB::table($this->tb_company)->where('admin_id', $admin_id)->doesntExist();
        if (!$cnt){
            $success = DB::table($this->tb_company)->where('admin_id', $admin_id)->delete();
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

    public function companyActive(Request $request){
        $admin_id = $request->post('admin_id');
        $active = $request->post('active');
        $success = false;
        $act = 0;
        if((int)$active> 0)
           $act = 1;

        $cnt = DB::table($this->tb_company)->where('admin_id', $admin_id)->doesntExist();
        if (!$cnt){
            $success =  DB::table($this->tb_company)->where('admin_id', $admin_id)->update(
                [
                    'active' => $act,
                ]
            );
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


}
