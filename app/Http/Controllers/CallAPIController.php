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

    public function postTest(Request $request){
        return \Response::json([
            'msg' => 'welcome mobile.postTest sucess!'
        ]);
    }

    //모바일 유저 로그인
    public function userLogin(Request $request){
        $userid = $request->post('userid');
        $password = $request->post('password');

        $tb_user_info = 'tb_user_info';
        $updated_at = @date("Y-m-d h:i:s", time());

        $user = DB::table($tb_user_info)->where('user_id', $userid)->first();

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
                return \Response::json([
                    'msg' => 'ok'
                ]);
            }
        }
    }

    //회사 정보 요청
    public function requestCompanyInfo(){
        $table_info = 'tb_user_info';
        //$rows = DB::table('tb_company')->get();
        $sql = 'SELECT * from '. $table_info. ' ';
        $rows =DB::table($table_info)->where('user_class', '0')->get();

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
        exit();
    }

    //모바일 회원 정보 수정
    public function userInfoModify(Request $request){

    }

    //모바일 회원 가입
    public function userSignup(Request $request){
        $user_name = $request->post('user_name');
        $user_id = $request->post('user_id');
        $user_pwd = $request->post('user_pwd');
        $user_type = $request->post('user_type');
        $user_class = $request->post('user_class');
        $company_name = $request->post('company_name');

        $table_user_info = 'tb_user_info';
        try {
            $cnt = DB::table($table_user_info)->where('user_id', $user_id)->doesntExist();
            if (!$cnt){ // exist
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
                        'registe_date' => '', // 가입일시
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
        }catch(Exception $e) {
            return \Response::json([
                'msg' => $e->getMessage()
            ]);
        }
        exit();
    }

    //차량 등록 정보
    public function regCarInfo(Request $request){

    }

    //모바일에서 서버로 오는 차량 주행 정보
    public function mtsDrivingInfo(Request $request){

    }

    //서버에서 모바일로 보내는 주행 기록 정보
    public function stmDrivingRecord(Request $request){

    }

} // area of class
