<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use Illuminate\Support\Facades\Hash;
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

    //회사 정보 요청
    public function requestCompanyInfo()
    {
        $table_info = 'tb_admin_info';
        $rows = DB::table($table_info)->where('user_type', '0')->where('actived', '1')->get();

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

    //약관 파일 경로
    public function requestTermsUrl()
    {
        $table_info = 'tb_upload_file';
        $row = DB::table($table_info)->first();

        if ($row == null) {
            return \Response::json([
                'msg' => 'err'
            ]);
        } else {
            return \Response::json([
                'msg' => 'ok',
                'path' => $row->path,
            ]);
        }
        exit();
    }

    //모바일 회원 정보 수정
    public function requestUserInfoModify(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $userid = $request->post('user_id');
            $user_pwd = $request->post('user_pwd');
            $password = $this->decrypt($user_pwd);
            $admin_id = $request->post('admin_id');
            $update_date = $request->post('update_date');

            $tb_info = 'tb_user_info';
            $user = DB::table($tb_info)->where('user_id', $userid)->first();

            if ($user == null) {
                return \Response::json([
                    'msg' => 'nonuser'
                ]);
            } else {
                $success = DB::table($tb_info)->where('user_id', $userid)
                    ->update(
                        [
                            'password' => Hash::make($password),
                            'admin_id' => $admin_id,
                            'update_date' => $update_date
                        ]
                    );
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }

        exit();
    }

    //차량 등록 정보
    public function requestRegCarInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $number = $request->post('number');
            $manufacturer = $request->post('manufacturer');
            $car_model = $request->post('car_model');
            $car_date = $request->post('car_date');
            $car_fuel = $request->post('car_fuel');
            $car_gas = $request->post('car_gas');
            $user_id = $request->post('user_id');
            $admin_id = $request->post('admin_id');

            $tb_car_info = 'tb_car_info';
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
                            'number' => $number,
                            'manufacturer' => $manufacturer,
                            'car_model' => $car_model,
                            'car_date' => $car_date,
                            'car_fuel' => $car_fuel,
                            'car_gas' => $car_gas
                        ]
                    );
                if ($success) {
                    $car_rows = DB::table($tb_car_info)->where('number', $number)->first();
                    $success = DB::table($tb_user_car)
                        ->insert(
                            [
                                'admin_id' => $admin_id,
                                'user_id' => $user_id,
                                'car_id' => $car_rows->car_id,
                                'job' => ''
                            ]
                        );
                    if ($success) {
                        return \Response::json([
                            'msg' => 'ok',
                            'car_id' => $car_rows->car_id
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
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }

        exit();
    }

    //차량 정보 조회
    public function requestListCarInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $user_id = $request->post('user_id');

            $tb_car_info = 'tb_car_info';
            $tb_user_car = 'tb_user_car';

            $sql = "SELECT car_id FROM " . $tb_user_car;
            $sql .= " WHERE user_id = " . $user_id;
            $sql .= " ORDER BY user_id DESC LIMIT 1";
            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            if ($rows != null) { // exist
                $car_rows = DB::table($tb_car_info)->where('car_id', $rows[0]->car_id)->first();
                if ($car_rows != null) {
                    return \Response::json([
                        'msg' => 'ok',
                        'car_id' => $car_rows->car_id,
                        'number' => $car_rows->number,
                        'manufacturer' => $car_rows->manufacturer,
                        'car_model' => $car_rows->car_model,
                        'car_date' => $car_rows->car_date,
                        'car_fuel' => $car_rows->car_fuel,
                        'car_gas' => $car_rows->car_gas
                    ]);
                }
            } else {
                return \Response::json([
                    'msg' => 'nocar'
                ]);
            }
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

    //차량 수정 정보
    public function requestModCarInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $car_id = $request->post('car_id');
            $number = $request->post('number');
            $manufacturer = $request->post('manufacturer');
            $car_model = $request->post('car_model');
            $car_date = $request->post('car_date');
            $car_fuel = $request->post('car_fuel');
            $car_gas = $request->post('car_gas');

            $tb_info = 'tb_car_info';
            $cnt = DB::table($tb_info)->where('car_id', $car_id)->doesntExist();
            if (!$cnt) { // exist
                $success = DB::table($tb_info)->where('car_id', $car_id)
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
                return \Response::json([
                    'msg' => 'ok'
                ]);
            } else {
                return \Response::json([
                    'msg' => 'noExist'
                ]);
            }
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }
    //차량 삭제 정보
    public function requestDelCarInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $car_id = $request->post('car_id');
            $number = $request->post('number');
            $user_id = $request->post('user_id');

            $tb_car_info = 'tb_car_info';
            $tb_user_car = 'tb_user_car';

            $success = DB::table($tb_car_info)->where('car_id', $car_id)->where('number', $number)->delete();
            if ($success) {
                DB::table($tb_user_car)->where('car_id', $car_id)->where('user_id', $user_id)->delete();
                return \Response::json([
                    'msg' => 'ok'
                ]);
            } else {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

    //모바일에서 서버로 오는 차량 주행 정보
    public function requestSaveDrivingInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $driving_date = $request->post('driving_date');
            $start_time = $request->post('start_time');
            $start_place = $request->post('start_place');
            $end_time = $request->post('end_time');
            $end_place = $request->post('end_place');
            $car_id = $request->post('car_id');
            $user_id = $request->post('user_id');
            $max_speed = $request->post('max_speed');
            $average_speed = $request->post('average_speed');
            $mileage = $request->post('mileage');
            $driving_time = $request->post('driving_time');
            $idling_time = $request->post('idling_time');
            $driving_score = $request->post('driving_score');
            $fast_speed_time = $request->post('fast_time');
            $fast_speed_cnt = $request->post('fast_cnt');
            $quick_speed_cnt = $request->post('quick_cnt');
            $brake_speed_cnt = $request->post('brake_cnt');

            if ($start_time == null || $start_time == "" ||
                $end_time == null || $end_time == "" ||
                $max_speed == null || $max_speed == "" ||
                $average_speed == null || $average_speed == "" ||
                $mileage == null || $mileage == "" ||
                $driving_time == null || $driving_time == "" ||
                $idling_time == null || $idling_time == "" ||
                $driving_score == null || $driving_score == "" ||
                $fast_speed_time == null || $fast_speed_time == "" ||
                $fast_speed_cnt == null || $fast_speed_cnt == "" ||
                $quick_speed_cnt == null || $quick_speed_cnt == "" ||
                $brake_speed_cnt == null || $brake_speed_cnt == "") {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }

            $tb_info = 'tb_driving_info';
            $success = DB::table($tb_info)
                ->insert(
                    [
                        'driving_date' => $driving_date,
                        'start_time' => $start_time,
                        'start_place' => $start_place,
                        'end_time' => $end_time,
                        'end_place' => $end_place,
                        'car_id' => $car_id,
                        'user_id' => $user_id,
                        'max_speed' => $max_speed,
                        'average_speed' => $average_speed,
                        'mileage' => $mileage,
                        'driving_time' => $driving_time,
                        'idling_time' => $idling_time,
                        'driving_score' => $driving_score,
                        'fast_speed_time' => $fast_speed_time,
                        'fast_speed_cnt' => $fast_speed_cnt,
                        'quick_speed_cnt' => $quick_speed_cnt,
                        'brake_speed_cnt' => $brake_speed_cnt
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
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }
    //저장되지 않은 주행 정보 저장하기
    public function requestNotSentDrivingInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $driving_date = $request->post('driving_date');
            $start_time = $request->post('start_time');
            $start_place = $request->post('start_place');
            $end_time = $request->post('end_time');
            $end_place = $request->post('end_place');
            $car_id = $request->post('car_id');
            $user_id = $request->post('user_id');
            $max_speed = $request->post('max_speed');
            $average_speed = $request->post('average_speed');
            $mileage = $request->post('mileage');
            $driving_time = $request->post('driving_time');
            $idling_time = $request->post('idling_time');
            $driving_score = $request->post('driving_score');
            $fast_speed_time = $request->post('fast_time');
            $fast_speed_cnt = $request->post('fast_cnt');
            $quick_speed_cnt = $request->post('quick_cnt');
            $brake_speed_cnt = $request->post('brake_cnt');

            if ($start_time == null || $start_time == "" ||
                $end_time == null || $end_time == "" ||
                $max_speed == null || $max_speed == "" ||
                $average_speed == null || $average_speed == "" ||
                $mileage == null || $mileage == "" ||
                $driving_time == null || $driving_time == "" ||
                $idling_time == null || $idling_time == "" ||
                $driving_score == null || $driving_score == "" ||
                $fast_speed_time == null || $fast_speed_time == "" ||
                $fast_speed_cnt == null || $fast_speed_cnt == "" ||
                $quick_speed_cnt == null || $quick_speed_cnt == "" ||
                $brake_speed_cnt == null || $brake_speed_cnt == "") {
                return \Response::json([
                    'msg' => 'err'
                ]);
            }

            $tb_info = 'tb_driving_info';
            $success = DB::table($tb_info)
                ->insert(
                    [
                        'driving_date' => $driving_date,
                        'start_time' => $start_time,
                        'start_place' => $start_place,
                        'end_time' => $end_time,
                        'end_place' => $end_place,
                        'car_id' => $car_id,
                        'user_id' => $user_id,
                        'max_speed' => $max_speed,
                        'average_speed' => $average_speed,
                        'mileage' => $mileage,
                        'driving_time' => $driving_time,
                        'idling_time' => $idling_time,
                        'driving_score' => $driving_score,
                        'fast_speed_time' => $fast_speed_time,
                        'fast_speed_cnt' => $fast_speed_cnt,
                        'quick_speed_cnt' => $quick_speed_cnt,
                        'brake_speed_cnt' => $brake_speed_cnt
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
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

    //서버에서 모바일로 보내는 주행 기록 정보
    public function requestReadDrivingInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $car_id = $request->post('car_id');
            $user_id = $request->post('user_id');
            $driving_date = $request->post('driving_date');

            $tb_driving_info = "tb_driving_info";
            $sql = "SELECT * FROM " . $tb_driving_info;
            $sql .= " WHERE car_id = " . $car_id . " AND user_id = " . $user_id . " AND SUBSTRING(driving_date, 1, 6) = '" . substr($driving_date, 0, 6) . "'";
            $sql .= " ORDER BY driv_id DESC";

            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            if ($rows == null) {
                return \Response::json([
                    'msg' => 'err'
                ]);
            } else {
                return \Response::json([
                    'msg' => 'ok',
                    'lists' => $rows
                ]);
            }
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

    //메세지
    public function requestMessageListInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $msg_id = $request->post('msg_id');
            $user_phone = $request->post('user_phone');

            $tb_user_info = "tb_user_info";
            $user_rows = DB::table($tb_user_info)->where('user_phone', $user_phone)->first();
            if ($user_rows != null) {
                $datas = array();
                $tb_notice = "tb_notice";
                $sql = "SELECT * FROM " . $tb_notice;
                $sql .= " WHERE (type = 'all' OR (type = 'company' AND from_user_id='" . $user_rows->admin_id . "')";
                $sql .= " OR (type = 'persion' AND type_id='" . $user_rows->user_id . "')) AND notice_id > " . $msg_id;
                $sql .= " ORDER BY notice_id DESC";

                $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
                if ($rows == null) {
                    return \Response::json([
                        'msg' => 'nomsg'
                    ]);
                } else {
                    foreach ($rows as $row) {
                        $adm_id = $row->from_user_id;
                        $tb_admin = "tb_admin_info";
                        $admin_row = DB::table($tb_admin)->where('admin_id', $adm_id)->first();
                        if ($admin_row != null) {
                            $data = array(
                                'notice_id' => $row->notice_id,
                                'msg_date' => $row->create_date,
                                'msg_user' => $admin_row->user_name,
                                'msg_title' => $row->title,
                                'msg_content' => $row->content
                            );
                            array_push($datas, $data);
                        }
                    }
                    return \Response::json([
                        'msg' => 'ok',
                        'lists' => $datas
                    ]);
                }
            } else {
                return \Response::json([
                    'msg' => 'nouser'
                ]);
            }
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

    //주행 랭킹 요청
    public function requestDrivingRankingInfo(Request $request) {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if($user) {
            $car_id = $request->post('car_id');
            $user_id = $request->post('user_id');
            $driving_date = $request->post('driving_date');

            $tb_driving_info = "tb_driving_info";

            //주행 거리 랭킹
            $idx_mieage = 0; //월 주행거리 순위
            $total_mileage = 0; //월 총 주행거리
            $sql = "SELECT ";
            $sql .= "user_id, SUM(mileage) AS mileage, car_id ";
            $sql .= "FROM " . $tb_driving_info . " ";
            $sql .= "WHERE SUBSTRING(driving_date, 1, 6) = '" . substr($driving_date, 0, 6) . "' ";
            $sql .= "GROUP BY user_id, car_id ORDER BY mileage DESC";

            $idx = 0;
            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            if ($rows == null) {
                return \Response::json([
                    'msg' => 'err1'
                ]);
            } else {
                foreach ($rows as $row) {
                    $idx++;
                    if ($row->user_id == $user_id && $row->car_id == $car_id) {
                        $idx_mieage = $idx;
                        $total_mileage = $row->mileage;
                        break;
                    }
                }
            }

            //안전 운전 랭킹
            $idx_safety = 0; //월 안전운전 순위
            $sql = "SELECT ";
            $sql .= "user_id, SUM(driving_score)/COUNT(user_id) AS driving_score, car_id ";
            $sql .= "FROM " . $tb_driving_info . " ";
            $sql .= "WHERE SUBSTRING(driving_date, 1, 6) = '" . substr($driving_date, 0, 6) . "' ";
            $sql .= "GROUP BY user_id, car_id ORDER BY driving_score DESC";

            $idx = 0;
            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            if ($rows == null) {
                return \Response::json([
                    'msg' => 'err2'
                ]);
            } else {
                foreach ($rows as $row) {
                    $idx++;
                    if ($row->user_id == $user_id && $row->car_id == $car_id) {
                        $idx_safety = $idx;
                        break;
                    }
                }
            }

            $sql = "SELECT * FROM " . $tb_driving_info;
            $sql .= " WHERE car_id = " . $car_id . " AND user_id = " . $user_id . " AND SUBSTRING(driving_date, 1, 6) = '" . substr($driving_date, 0, 6) . "'";
            $sql .= " ORDER BY driv_id DESC";
            $d_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            if ($d_rows == null) {
                return \Response::json([
                    'msg' => 'err3'
                ]);
            }

            return \Response::json([
                'msg' => 'ok',
                'mileage_score' => $idx_mieage,
                'safety_score' => $idx_safety,
                'total_mileage' => $total_mileage,
                'lists' => $d_rows
            ]);
        } else{
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

    //메인화면 랭킹 요청
    public function requestRankingInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if ($user) {
            $car_id = $request->post('car_id');
            $user_id = $request->post('user_id');
            $driving_date = $request->post('driving_date');

            $tb_driving_info = "tb_driving_info";

            //주행 거리 랭킹
            $idx_mieage = 0; //월 주행거리 순위
            $sql = "SELECT ";
            $sql .= "user_id, SUM(mileage) AS mileage ";
            $sql .= "FROM " . $tb_driving_info . " ";
            $sql .= "WHERE SUBSTRING(driving_date, 1, 6) = '" . substr($driving_date, 0, 6) . "' ";
            $sql .= "GROUP BY user_id ORDER BY mileage DESC";

            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            $idx = 0;
            if ($rows == null) {
                return \Response::json([
                    'msg' => 'err'
                ]);
            } else {
                foreach ($rows as $row) {
                    $idx++;
                    if ($row->user_id == $user_id) {
                        $idx_mieage = $idx;
                        break;
                    }
                }
            }

            //안전 운전 랭킹
            $idx_safety = 0; //월 안전운전 순위
            $sql = "SELECT ";
            $sql .= "user_id, SUM(driving_score)/COUNT(user_id) AS driving_score ";
            $sql .= "FROM " . $tb_driving_info . " ";
            $sql .= "WHERE SUBSTRING(driving_date, 1, 6) = '" . substr($driving_date, 0, 6) . "' ";
            $sql .= "GROUP BY user_id ORDER BY driving_score DESC";

            $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
            $idx = 0;
            if ($rows == null) {
                return \Response::json([
                    'msg' => 'err'
                ]);
            } else {
                foreach ($rows as $row) {
                    $idx++;
                    if ($row->user_id == $user_id) {
                        $idx_safety = $idx;
                        break;
                    }
                }
            }

            return \Response::json([
                'msg' => 'ok',
                'mileage_score' => $idx_mieage,
                'safety_score' => $idx_safety
            ]);
        } else {
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

    //새 비밀번호 설정
    public function requestNewPasswordInfo(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = auth('mobile')->authenticate($token);
        if ($user) {
            $user_id = $request->post('user_id');
            $user_pwd = $request->post('user_pwd');
            $update_date = $request->post('update_date');

            $tb_info = "tb_user_info";
            $success = DB::table($tb_info)->where('user_phone', $user_id)
                ->update(
                    [
                        'password' => $user_pwd,
                        'update_date' => $update_date
                    ]
                );

            return \Response::json([
                'msg' => 'ok'
            ]);
        } else {
            return response()->json([
                'msg' => 'err',
                'cont' => 'non user with authenticate',
            ]);
        }
        exit();
    }

} // area of class
