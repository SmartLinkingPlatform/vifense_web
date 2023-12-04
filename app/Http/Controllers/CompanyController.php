<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use mysql_xdevapi\Exception;

class CompanyController extends BaseController
{

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
        $user_phone = $request->post('user_phone') ?? null;
        $company_name = $request->post('company_name') ?? null;
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;

        $company = 'tb_admin_info';

        $sql = 'SELECT * from '.$company. ' ';
        $sql .= ' WHERE user_type < 1 ';

        if(!is_null($user_phone))
            $sql .= ' AND user_phone = '.$user_phone.' ';
        if(!is_null($company_name))
            $sql .= ' AND company_name = '.$company_name.' ';

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

        $enc_password = $this->encrypt_decrypt('encrypt', $password);

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


}
