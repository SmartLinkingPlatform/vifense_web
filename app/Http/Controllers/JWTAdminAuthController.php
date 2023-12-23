<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAdminAuthController extends BaseController
{
    //
    public function __construct(){
       // $this->middleware('jwt.verify', ['except'=>['login', 'register']]);
    }

    /**
     * Register4 a user.
     *  * @endpointe /apiw/register
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request  $request){
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');

        $credentials['user_phone'] = $user_phone;
        $credentials['password'] = $user_pwd;

        $validator = Validator::make($credentials, [
            'user_phone' =>'required|between:6,13',
            'password' =>'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg'=>'err',
                'cont'=>$validator->errors(),
                ]);
            exit();
        }

        //$user_phone = $request->post('user_phone');
        //$user_pwd = $request->post('user_pwd');

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

            //where('email', $email)->first();
            $cnt = User::where('user_phone', $user_phone)->doesntExist();
            if (!$cnt){ // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $pass = Hash::make($user_pwd);

            $new_user = [
                'user_phone' => $user_phone, // 아이디
                'password' => Hash::make($user_pwd), // 암호
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
            ];

            $tb_admin = 'tb_admin_info';
            $success = DB::table($tb_admin)->insert($new_user);
            //$user = User::create($new_user);

            if ($success) {
                return \Response::json([
                    'msg' => 'ok',
                    'cont' => 'created user'
                ]);
            } else {
                return \Response::json([
                    'msg' => 'err',
                    'cont' => 'user is not created'
                ]);
            }
        } catch(\Exception $e) {
            return \Response::json([
                'msg' => 'err',
                'cont'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * get a JWT via given credentials.
     * @endpointe /apiw/login
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');
        $md5pwd = $this->encrypt($user_pwd); // after using...
        $validator = Validator::make(
            ['user_phone'=>$user_phone,             'password'=>$user_pwd],
            ['user_phone' =>'required|between:6,13','password' =>'required|string|min:3',]
        );

        if($validator->fails()){
            return response()->json([
                'msg'=>'err',
                'cont'=>$validator->errors(),
            ]);
        }

        try {
            if(!$token = auth('admin')->attempt($validator->validated())){
                return response()->json(['msg'=>'Unauthorized user login attempt']);
            }
        } catch (JWTException $e) {
            return response()->json([
                'msg' => 'err',
                'cont' => $e->getMessage(),
            ]);
        }
        return $this->createNewToken($token);
    }

    /**
     *  @endpointe /apiw/admin/profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(){
        return response()->json(auth('admin')->user());
    }

    /**
     * @endpointe /apiw/admin/logout
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        auth()->guard('admin')->logout();
        return response()->json(['msg'=>'ok', 'cont'=>'Successfully logged out']);
    }

    /**
     * Refresh a token
     * @endpointe /apiw/admin/refresh
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(){
        return $this->createNewToken(auth('admin')->refresh());
    }


    public function createNewToken($token){
        //auth()->guard('admin')->factory()->setTTL(60*60*12);
        return \Response::json([
            'msg'=>'ok',
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth('admin')->factory()->getTTL()
        ]);
    }

    /*
     *@endpointe /apiw/admin/get_user
     * */
    public function get_user(Request $request)
    {
        $this->validate($request,[
            'token' => 'required'
        ]);
        try {
            $user = auth('admin')->authenticate($request->token);
            if($user){
                $updated_at = @date("Y-m-d h:i:s", time());

                session()->forget('user');
                session()->forget('admin_id');
                session()->forget('user_phone');
                session()->forget('user_type');
                session()->forget('user_name');
                session()->forget('logintime');
                session()->forget('checktime');

                session()->put('user', 'admin');
                session()->put('admin_id', $user->admin_id);
                session()->put('user_phone', $user->user_phone);
                session()->put('user_type', $user->user_type);
                session()->put('user_name', $user->user_name);
                session()->put('logintime', $updated_at);
                session()->put('checktime', $updated_at);

                $tb_info = 'tb_admin_info';
                $success = DB::table($tb_info)->where('user_phone', $user->user_phone)
                    ->update(
                        [
                            'visit_date' => $updated_at,
                            'actived' => 1
                        ]
                    );

                return response()->json([
                    'msg' => 'ok'
                ]);
            }
            else{
                return response()->json([
                    'msg' => 'err',
                    'cont' => 'non user with authenticate',
                ]);
            }

        }
        catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['msg' => 'err','cont' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['msg' => 'err', 'cont' => 'Token is Expired']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return response()->json(['msg' => 'err', 'cont' => 'Token is Blacklisted']);
            }
            else if ($e instanceof JWTException){
                return response()->json(['msg' => 'err', 'cont' => $e->getMessage()]);
            }
            else {
                return response()->json(['msg' => 'err', 'cont' => 'we can not about this error']);
            }
        }

        return response()->json(['msg' => 'err', 'cont' => 'can not error']);
    }

}
