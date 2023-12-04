<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use mysql_xdevapi\Exception;

class CallAPIController extends BaseController
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
        if (view()->exists($id)) {
            return view($id);
        } else {
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //모바일 유저 로그인
    public function userLogin(Request $request)
    {
        $userid = $request->post('user_id');
        $password = $request->post('user_pwd');

        $tb_user_info = 'tb_user_info';
        $updated_at = @date("Y-m-d h:i:s", time());

        $row = DB::table($tb_user_info)->where('user_id', $userid)->where('user_pwd', $password)->first();

        if ($row == null) {
            return \Response::json([
                'msg' => 'nonuser'
            ]);
        } else {
            DB::table($tb_user_info)->where('user_id', $userid)
                ->update(
                    [
                        'visit_date' => $updated_at,
                        'active' => 1
                    ]
                );
            return \Response::json([
                'msg' => 'ok',
                'user_num' => $row->user_num,
                'user_id' => $row->user_id,
                'user_pwd' => $row->user_pwd,
                'user_name' => $row->user_name,
                'company_name' => $row->company_name
            ]);
        }
        exit();
    }

    //회사 정보 요청
    public function requestCompanyInfo()
    {
        $table_info = 'tb_user_info';
        $rows = DB::table($table_info)->where('user_class', '0')->get();

        if ($rows == null) {
            return \Response::json([
                'msg' => 'err'
            ]);
        } else {
            return \Response::json([
                'msg' => 'ok',
                'lists' => $rows,
            ]);
        }
        exit();
    }

    //모바일 회원 정보 수정
    public function userInfoModify(Request $request)
    {
        $userid = $request->post('user_id');
        $password = $request->post('user_pwd');
        $company_name = $request->post('company_name');

        $tb_user_info = 'tb_user_info';
        $user = DB::table($tb_user_info)->where('user_id', $userid)->first();

        if ($user == null) {
            return \Response::json([
                'msg' => 'nonuser'
            ]);
        } else {
            DB::table($tb_user_info)->where('user_id', $userid)
                ->update(
                    [
                        'user_pwd' => $password,
                        'company_name' => $company_name
                    ]
                );
            return \Response::json([
                'msg' => 'ok'
            ]);
        }
        exit();
    }

    //모바일 회원 가입
    public function userSignup(Request $request)
    {
        $user_name = $request->post('user_name');
        $user_id = $request->post('user_id');
        $user_pwd = $request->post('user_pwd');
        $user_type = $request->post('user_type');
        $user_class = $request->post('user_class');
        $company_name = $request->post('company_name');
        $updated_at = @date("Y-m-d h:i:s", time());

        $table_user_info = 'tb_user_info';
        try {
            $cnt = DB::table($table_user_info)->where('user_id', $user_id)->doesntExist();
            if (!$cnt) { // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $success = DB::table($table_user_info)
                ->insert(
                    [
                        'user_id' => $user_id, // 아이디
                        'user_pwd' => $user_pwd, // 암호
                        'user_type' => $user_type, // 1 어드민 | 0 사업자
                        'user_class' => $user_class, // 0 회사 | 1 개인
                        'user_name' => $user_name, // 대표자 성명
                        'company_name' => $company_name, // 상호(회사이름)
                        'registe_date' => $updated_at, // 가입일시
                        'visit_date' => '', // 방문시간
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
        } catch (Exception $e) {
            return \Response::json([
                'msg' => $e->getMessage()
            ]);
        }
        exit();
    }

    //비밀번호 찾기 및 변화
    public function userFindPassword(Request $request)
    {

        exit();
    }

    //차량 등록 정보
    public function regCarInfo(Request $request)
    {
        $number = $request->post('number');
        $manufacturer = $request->post('manufacturer');
        $car_model = $request->post('car_model');
        $car_date = $request->post('car_date');
        $car_fuel = $request->post('car_fuel');
        $car_gas = $request->post('car_gas');
        $user_id = $request->post('user_id');
        $company = $request->post('company');

        $current_time = date("Y-m-d h:i:s", time());

        $tb_car_info = 'tb_car_info';
        $table_user_info = 'tb_user_info';
        $tb_user_car = 'tb_user_car';
        try {
            $cnt = DB::table($tb_car_info)->where('number', $number)->doesntExist();
            if (!$cnt) { // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $success = DB::table($tb_car_info)
                ->insert(
                    [
                        'in_date' => $current_time,
                        'number' => $number,
                        'manufacturer' => $manufacturer,
                        'car_model' => $car_model,
                        'car_date' => $car_date,
                        'car_fuel' => $car_fuel,
                        'car_gas' => $car_gas
                    ]
                );
            if ($success) {
                $user_rows = DB::table($table_user_info)->where('user_id', $user_id)->first();
                if ($user_rows == null) {
                    return \Response::json([
                        'msg' => 'err'
                    ]);
                    exit();
                }
                $car_rows = DB::table($tb_car_info)->where('number', $number)->first();
                $success = DB::table($tb_user_car)
                    ->insert(
                        [
                            'time' => $current_time,
                            'company' => $company,
                            'user_num' => $user_rows->user_num,
                            'car_num' => $car_rows->car_num,
                            'job' => ''
                        ]
                    );
                if ($success) {
                    return \Response::json([
                        'msg' => 'ok',
                        'car_num' => $car_rows->car_num
                    ]);
                } else {
                    return \Response::json([
                        'msg' => 'err'
                    ]);
                }
            } else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        } catch (Exception $e) {
            return \Response::json([
                'msg' => $e->getMessage()
            ]);
        }

        exit();
    }

    //차량 수정 정보
    public function modCarInfo(Request $request)
    {
        $c_num = $request->post('c_num');
        $number = $request->post('number');
        $manufacturer = $request->post('manufacturer');
        $car_model = $request->post('car_model');
        $car_date = $request->post('car_date');
        $car_fuel = $request->post('car_fuel');
        $car_gas = $request->post('car_gas');

        $tb_car_info = 'tb_car_info';
        $cnt = DB::table($tb_car_info)->where('car_num', $c_num)->doesntExist();
        if (!$cnt) { // exist
            $success =  DB::table($tb_car_info)->where('car_num', $c_num)
                ->update(
                    [
                        'number' => $number,
                        'manufacturer' => $manufacturer,
                        'car_model' => $car_model,
                        'car_date' => $car_date,
                        'car_fuel' => $car_fuel,
                        'car_gas' => $car_gas
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
        } else {
            return \Response::json([
                'msg' => 'noExist'
            ]);
        }
        exit();
    }
    //차량 삭제 정보
    public function delCarInfo(Request $request)
    {
        $c_num = $request->post('c_num');
        $number = $request->post('number');
        $user_num = $request->post('user_num');

        $tb_car_info = 'tb_car_info';
        $tb_user_car = 'tb_user_car';

        $success = DB::table($tb_car_info)->where('car_num', $c_num)->where('number', $number)->delete();
        if ($success) {
            DB::table($tb_user_car)->where('car_num', $c_num)->where('user_num', $user_num)->delete();
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

    //모바일에서 서버로 오는 차량 주행 정보
    public function mtsDrivingInfo(Request $request)
    {

        exit();
    }

    //서버에서 모바일로 보내는 주행 기록 정보
    public function stmDrivingRecord(Request $request)
    {

        exit();
    }

} // area of class
