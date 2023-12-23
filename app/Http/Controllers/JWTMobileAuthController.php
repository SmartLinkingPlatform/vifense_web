<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Client;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTMobileAuthController extends BaseController
{
    //
    public function __construct(){
        //$this->middleware('auth:mobile', ['except'=>['login', 'register']]);
    }

    /**
     * Register4 a user.
     *  * @endpointe /api/auth/register
     * @return \Illuminate\Http\JsonResponse
     */
    //모바일 회원가입
    public function register(Request  $request){
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');
        $password = $this->decrypt($user_pwd);

        $credentials['user_phone'] = $user_phone;
        $credentials['password'] = $password;

        $validator = Validator::make($credentials, [
            'user_phone' =>'required|between:6,13',
            'password' =>'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg'=>$validator->errors()]);
            exit();
        }

        $user_name = $request->post('user_name');
        $user_phone = $request->post('user_phone');
        $user_birthday = $request->post('user_birthday');
        $admin_id = $request->post('admin_id');
        $certifice_status = $request->post('certifice_status');
        $active = $request->post('active');
        $create_date = $request->post('create_date');

        $new_user = [
           'user_phone' => $user_phone, // 아이디
           'user_name' => $user_name, // 성명
           'password' => Hash::make($password), // 암호, // 암호
           'user_birthday' => $user_birthday, //생년월일
           'admin_id' => $admin_id, // 회사 아이디
           'certifice_status' => $certifice_status,
           'actived' => $active,
           'create_date' => $create_date, // 가입일시
           'visit_date' => '', // 방문시간
        ];

        try {
            $cnt = Client::where('user_phone', $user_phone)->doesntExist();
            if (!$cnt) { // exist
                return \Response::json([
                    'msg' => 'du'
                ]);

                exit();
            }

            $table_info = 'tb_user_info';
            $success = DB::table($table_info)->insert($new_user);
            if ($success) {
                return \Response::json([
                    'msg' => 'ok',
                    'cont' => 'created user',
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
     * @endpointe /api/user/login
     * @return \Illuminate\Http\JsonResponse
     */
    //모바일 로그인 토큰 얻기
    public function login(Request $request){
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');
        $password = $this->decrypt($user_pwd);

        $validator = Validator::make(
            ['user_phone'=>$user_phone,             'password'=>$password],
            ['user_phone' =>'required|between:6,13','password' =>'required|string|min:3',]
        );

        if($validator->fails()){
            return response()->json([
                'msg'=>'err',
                'cont'=>$validator->errors(),
            ]);
            exit();
        }

        if(!$token = auth('mobile')->attempt($validator->validated())){
            return response()->json(['msg'=>'Unauthorized user login attempt']);
            exit();
        }

        return $this->createNewToken($token);
    }


    /**
     * get the authenticated user.
     *  @endpointe /api/auth/profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(){
        return response()->json(auth('mobile')->client());
    }

    /**
     * log the user out (Invalidate the token)
     * @endpointe /api/auth/logout
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        auth('mobile')->logout();
        return response()->json(['msg'=>'Successfully logged out']);
    }


    /**
     * Refresh a token
     * @endpointe /api/auth/refresh
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(){
        return $this->createNewToken(auth('mobile')->refresh());
    }


    /**
    * @param sring $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewToken($token){
        return response()->json([
            'msg'=>'ok',
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth('mobile')->factory()->getTTL() * 60 * 24
        ]);
    }

    //모바일 토큰으로 로그인하기
    public function get_user(Request $request)
    {
        $this->validate($request,[
            'token' => 'required'
        ]);
        try {
            $user = auth('mobile')->authenticate($request->token);
            if($user){
                return response()->json([
                    'msg' => 'ok',
                    'user_id' => $user->user_id,
                    'user_phone' => $user->user_phone,
                    'user_name' => $user->user_name,
                    'user_pwd' => $user->password,
                    'admin_id' => $user->admin_id
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
