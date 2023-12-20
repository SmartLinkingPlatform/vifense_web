<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
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

        $lim_sql = $sql.' ORDER BY admin_id DESC LIMIT '.$start_from.', '.$count;
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
        //$corporate_photo_file = $request->file('corporate_photo_file');
        $corporate_doc_file = $request->file('corporate_doc_file');
        //$corporate_photo_name = '';
        $corporate_doc_name = '';

        if ($date_string === null || $date_string ==='') {
            $create_date = date('Y-m-d',$current_time);
        }
        else {
            $date_string = strtotime($date_string);
            $create_date = date('Y-m-d',$date_string);
        }

        $file_currentTime = date("YmdHis");
        /*$corporate_photo_url='';
        $randNump= rand(1, 9);
        $order_numberp = $file_currentTime.$randNump;
        if($corporate_photo_file != null && $corporate_photo_file != ''){
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

        $enc_password = $this->encrypt($password);

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
                        //'user_photo' => $corporate_photo_name, // 사용자사진 이름
                        //'user_photo_url' => $corporate_photo_url, // 사용자사진 경로
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

    public function getCompanyinInfo(Request $request){
        $admin_id = $request->post('admin_id');
        $rows =DB::table($this->tb_company)->where('admin_id', $admin_id)->first();
        $password = $rows->user_pwd;
        $dec_password = $this->decrypt($password);
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
        //$corporate_photo_file = $request->file('corporate_photo_file');
        //$old_corporate_photo_url = $request->post('old_corporate_photo_url');

        $corporate_doc_file = $request->file('corporate_doc_file');
        $old_uploadcorporate_doc_url = $request->post('old_uploadcorporate_doc_url');

        $corporate_photo_name = '';
        $corporate_doc_name = '';

        if ($date_string === null || $date_string ==='') {
            $create_date = date('Y-m-d',$current_time);;
        }
        else {
            $date_string = strtotime($date_string);
            $create_date = date('Y-m-d',$date_string);
        }

        $file_currentTime = date("YmdHis");
        /*$corporate_photo_url='';
        $randNump= rand(1, 9);
        $order_numberp = $file_currentTime.$randNump;
        if($corporate_photo_file != null && $corporate_photo_file != ''){
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

        $cnt = DB::table($this->tb_company)->where('admin_id', $admin_id)->doesntExist();
        if (!$cnt){
            $enc_password = $this->encrypt($password);

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

            /*if($corporate_photo_name != '' && $corporate_photo_url != '') {
                $upValues['user_photo'] = $corporate_photo_name;
                $upValues['user_photo_url'] = $corporate_photo_url;
            }*/
            if($corporate_doc_name != '' && $corporate_doc_url != '') {
                $upValues['certified_name'] = $corporate_doc_name;
                $upValues['certified_copy'] = $corporate_doc_url;
            }

            $success =  DB::table($this->tb_company)->where('admin_id', $admin_id)->update($upValues);
            if ($success) {
                /*if ($corporate_photo_url != '' && !is_null($old_corporate_photo_url)){
                    unlink($old_corporate_photo_url);
                }*/
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
                    'actived' => $act,
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

    public function companyCertify(Request $request){
        $admin_id = $request->post('admin_id');
        $certify = $request->post('certify');
        $success = false;
        $act = 0;
        if((int)$certify> 0)
            $act = 1;

        $cnt = DB::table($this->tb_company)->where('admin_id', $admin_id)->doesntExist();
        if (!$cnt){
            $success =  DB::table($this->tb_company)->where('admin_id', $admin_id)->update(
                [
                    'certifice_status' => $act,
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

    public function getDayDrivingList(Request $request){
        $search_val = $request->post('search_val');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $from_date    = str_replace("-", "", $request->post('from_date'));
        $to_date    = str_replace("-", "", $request->post('to_date'));
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');

        $start_from = ($start-1) * $count;
        date_default_timezone_set('Asia/Seoul');
        $current_date = @date("Y-m-d", time());
        $current_date = str_replace("-", "", $current_date);

        $tb_driving_info = "tb_driving_info";
        $sql = "SELECT ";
        $sql .= "a.user_id, a.max_speed, a.average_speed, a.mileage, a.driving_time, a.idling_time, ";
        $sql .= "a.driving_date, a.driving_score, b.admin_id, b.user_phone, b.user_name, c.company_name, ";
        $sql .= "a.quick_speed_cnt, a.brake_speed_cnt, a.fast_speed_cnt, a.fast_speed_time ";
        $sql .= "FROM ".$tb_driving_info." AS a ";
        $sql .= "LEFT JOIN tb_user_info AS b ON a.user_id = b.user_id ";
        $sql .= "LEFT JOIN tb_admin_info AS c ON b.admin_id = c.admin_id ";
        $sql .= "WHERE 1 ";

        if($from_date !== "" && $to_date !== "") {
            $sql .= "AND a.driving_date >= '" . substr($from_date, 0, 8) . "' AND a.driving_date <= '" . substr($to_date, 0, 8) . "' ";
        } else {
            $sql .= "AND a.driving_date = '" . $current_date . "' ";
        }

        if ($user_type == 0) {
            $sql .= "AND b.admin_id = '" . $admin_id . "' ";
        }

        if(!is_null($search_val)) {
            $sql .= " AND (b.user_phone like '%" . $search_val . "%' OR b.user_name like '%" . $search_val . "%' OR ";
            $sql .= " c.company_name like '%" . $search_val . "%') ";
        }

        $sql .= " ORDER BY a.user_id ASC ";
        //$lim_sql = $sql." LIMIT ".$start_from.", ".$count;

        try{
            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            if($rows == null){
                return \Response::json([
                    'msg' => 'nouser'
                ]);
            } else {
                $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
                $items = array();
                $temp_id = "";
                $temp_phone = "";
                $temp_company = "";
                $temp_name = "";
                $temp_max = "";
                $max_speed = 0;
                $avr_speed = 0;
                $mileage = 0;
                $driving_time = 0;
                $idling_time = 0;
                $driving_score = 0;
                $quick_cnt = 0;
                $brake_cnt = 0;
                $fast_cnt = 0;
                $fast_time = 0;

                $cnt = 0;
                $i = 1;
                foreach($rows as $row) {
                    $user_id = $row->user_id;
                    if ($temp_id != $user_id) {
                        if ($cnt > 0) {
                            $item = array(
                                'phone' => $temp_phone,
                                'company' => $temp_company,
                                'name' => $temp_name,
                                'max_speed' => $max_speed,
                                'avr_speed' => round($avr_speed / $i),
                                'mileage' => round($mileage, 1),
                                'drv_time' => $driving_time,
                                'idl_time' => $idling_time,
                                'score' => round($driving_score / $i),
                                'quick_cnt' => $quick_cnt,
                                'brake_cnt' => $brake_cnt,
                                'fast_cnt' => $fast_cnt,
                                'fast_time' => $fast_time
                            );
                            array_push($items, $item);
                        }
                        $max_speed = $row->max_speed;
                        $avr_speed = $row->average_speed;
                        $mileage = $row->mileage;
                        $times = explode(":", $row->driving_time);
                        if (count($times) > 2) {
                            $driving_time = $times[0] * 3600 + $times[1] * 60 + $times[2];
                        } else {
                            $driving_time = $times[0] * 60 + $times[1] ;
                        }
                        $idling_time = $row->idling_time;
                        $driving_score = $row->driving_score;
                        $quick_cnt = $row->quick_speed_cnt;
                        $brake_cnt = $row->brake_speed_cnt;
                        $fast_cnt = $row->fast_speed_cnt;
                        $fast_time = $row->fast_speed_time;

                        $i = 1;
                    } else {
                        $i++;
                        if ($temp_max > $row->max_speed)
                            $max_speed = $temp_max;
                        else
                            $max_speed = $row->max_speed;
                        $avr_speed += $row->average_speed;
                        $mileage += $row->mileage;
                        $times = explode(":", $row->driving_time);
                        if (count($times) > 2) {
                            $driving_time += $times[0] * 3600 + $times[1] * 60 + $times[2];
                        } else {
                            $driving_time += $times[0] * 60 + $times[1] ;
                        }
                        $idling_time += $row->idling_time;
                        $driving_score += $row->driving_score;
                        $quick_cnt += $row->quick_speed_cnt;
                        $brake_cnt += $row->brake_speed_cnt;
                        $fast_cnt += $row->fast_speed_cnt;
                        $fast_time += $row->fast_speed_time;
                    }
                    if ($cnt == count($total_rows) - 1) {
                        $item = array(
                            'phone' => $row->user_phone,
                            'company' => $row->company_name,
                            'name' => $row->user_name,
                            'max_speed' => $max_speed,
                            'avr_speed' => round($avr_speed / $i, 1),
                            'mileage' => round($mileage, 1),
                            'drv_time' => $driving_time,
                            'idl_time' => $idling_time,
                            'score' => round($driving_score / $i),
                            'quick_cnt' => $quick_cnt,
                            'brake_cnt' => $brake_cnt,
                            'fast_cnt' => $fast_cnt,
                            'fast_time' => $fast_time
                        );
                        array_push($items, $item);
                    }
                    $cnt++;
                    $temp_id = $user_id;
                    $temp_name = $row->user_name;
                    $temp_company = $row->company_name;
                    $temp_phone = $row->user_phone;
                    $temp_max = $row->max_speed;
                }

                $total = count($items);
                $total_page = ceil($total / $count);

                $lists = array();
                for ($i = $start_from ; $i < $start_from + $count; $i++) {
                    array_push($lists, $items[$i]);
                }


                return \Response::json([
                    'msg' => 'ok',
                    'total'    =>  $total,
                    'start'    =>  $start,
                    'totalpage'    =>  $total_page,
                    'lists' => $lists
                ]);
            }

        }catch (Exception $e){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }

    public function showCompanyInfo(Request $request){
        $admin_id = $request->post('admin_id');

        $row = DB::table($this->tb_company)->where('admin_id', $admin_id)->first();
        if($row == null){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
        else{
            return \Response::json([
                'msg' => 'ok',
                'user_regnum' => $row->user_regnum,
                'user_address' => $row->user_address,
                'user_name' => $row->user_name,
                'company_phone' => $row->company_phone,
                'create_date' => $row->create_date,
                'website' => $row->website,
                'user_email' => $row->user_email
            ]);
        }
    }

    public function getSearchUserDriverInfo(Request $request, $search=null) {
        $data = array(
            'search' => $search
        );
        return view('admin.user-driver-info')->with($data);
    }

    public function getEveryDrivingInfo(Request $request){
        $search_val = $request->post('search_val');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $search_date = $request->post('search_date');
        $radio_idx = $request->post('radio_idx');
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');

        if(is_null($search_val)) {
            return \Response::json([
                'msg' => 'nouser'
            ]);
        }

        $start_from = ($start-1) * $count;

        $tb_driving_info = "tb_driving_info";
        $sql = "SELECT ";
        $sql .= "a.user_id, a.max_speed, a.average_speed, a.mileage, a.driving_time, a.idling_time, ";
        $sql .= "a.driving_date, a.driving_score, b.admin_id, b.user_name, c.company_name ";
        $sql .= "FROM ".$tb_driving_info." AS a ";
        $sql .= "LEFT JOIN tb_user_info AS b ON a.user_id = b.user_id ";
        $sql .= "LEFT JOIN tb_admin_info AS c ON b.admin_id = c.admin_id ";
        $sql .= "WHERE 1 ";

        if($search_date !== "") {
            if ($radio_idx == 1) {
                $sql .= "AND a.driving_date = '".$search_date."' ";
            }
            else if ($radio_idx == 2) {
                $sql .= "AND SUBSTRING(a.driving_date, 1, 6) = '".$search_date."' ";
            }
            else if ($radio_idx == 3) {
                $sql .= "AND SUBSTRING(a.driving_date, 1, 4) = '".$search_date."' ";
            }
        }

        if ($user_type == 0) {
            $sql .= "AND b.admin_id = '" . $admin_id . "' ";
        }

        if(!is_null($search_val)) {
            $sql .= " AND (b.user_name like '%" . $search_val . "%' OR ";
            $sql .= " c.company_name like '%" . $search_val . "%') ";
        }

        $sql .= " ORDER BY a.user_id ASC ";
        //$lim_sql = $sql." LIMIT ".$start_from.", ".$count;

        try{
            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            if($rows == null){
                return \Response::json([
                    'msg' => 'nouser'
                ]);
            } else {
                $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
                $items = array();
                $temp_id = "";
                $temp_company = "";
                $temp_name = "";
                $temp_max = "";
                $max_speed = 0;
                $avr_speed = 0;
                $mileage = 0;
                $driving_time = 0;
                $idling_time = 0;
                $driving_score = 0;

                $cnt = 0;
                $i = 1;
                foreach($rows as $row) {
                    $user_id = $row->user_id;
                    if ($temp_id != $user_id) {
                        if ($cnt > 0) {
                            $item = array(
                                'drv_date' => $search_date,
                                'company' => $temp_company,
                                'name' => $temp_name,
                                'max_speed' => $max_speed,
                                'avr_speed' => round($avr_speed / $i),
                                'mileage' => round($mileage, 1),
                                'drv_time' => $driving_time,
                                'idl_time' => $idling_time,
                                'score' => round($driving_score / $i)
                            );
                            array_push($items, $item);
                        }
                        $max_speed = $row->max_speed;
                        $avr_speed = $row->average_speed;
                        $mileage = $row->mileage;
                        $times = explode(":", $row->driving_time);
                        if (count($times) > 2) {
                            $driving_time = $times[0] * 3600 + $times[1] * 60 + $times[2];
                        } else {
                            $driving_time = $times[0] * 60 + $times[1] ;
                        }
                        $idling_time = $row->idling_time;
                        $driving_score = $row->driving_score;

                        $i = 1;
                    } else {
                        $i++;
                        if ($temp_max > $row->max_speed)
                            $max_speed = $temp_max;
                        else
                            $max_speed = $row->max_speed;
                        $avr_speed += $row->average_speed;
                        $mileage += $row->mileage;
                        $times = explode(":", $row->driving_time);
                        if (count($times) > 2) {
                            $driving_time += $times[0] * 3600 + $times[1] * 60 + $times[2];
                        } else {
                            $driving_time += $times[0] * 60 + $times[1] ;
                        }
                        $idling_time += $row->idling_time;
                        $driving_score += $row->driving_score;
                    }
                    if ($cnt == count($total_rows) - 1) {
                        $item = array(
                            'drv_date' => $search_date,
                            'company' => $row->company_name,
                            'name' => $row->user_name,
                            'max_speed' => $max_speed,
                            'avr_speed' => round($avr_speed / $i, 1),
                            'mileage' => round($mileage, 1),
                            'drv_time' => $driving_time,
                            'idl_time' => $idling_time,
                            'score' => round($driving_score / $i)
                        );
                        array_push($items, $item);
                    }
                    $cnt++;
                    $temp_id = $user_id;
                    $temp_name = $row->user_name;
                    $temp_company = $row->company_name;
                    $temp_max = $row->max_speed;
                }

                $total = count($items);
                $total_page = ceil($total / $count);

                return \Response::json([
                    'msg' => 'ok',
                    'total'    =>  $total,
                    'start'    =>  $start,
                    'totalpage'    =>  $total_page,
                    'lists' => $items
                ]);
            }

        }catch (Exception $e){
            return \Response::json([
                'msg' => 'err'
            ]);
        }
    }
}
