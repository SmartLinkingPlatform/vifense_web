<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Client;

class JWTMobileAuthController extends BaseController
{
    //
    public function __construct(){
        $this->middleware('auth:mobile', ['except'=>['login', 'register']]);
    }

    /**
     * Register4 a user.
     *  * @endpointe /api/auth/register
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request  $request){
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');

        $credentials['user_phone'] = $user_phone;
        $credentials['password'] = $user_pwd;

        $validator = Validator::make($credentials, [
            'user_phone' =>'required|between:8,13',
            'password' =>'required|string|min:3',
        ]);

        if ($validator->fails()) {
            /* return response()->json([
                 'msg'=>'아이디 혹은 암호가 정확하지 않습니다.',
             ]);*/
            return response()->json(['msg'=>$validator->errors()]);
             exit();
        }

        $user_name = $request->post('user_name');
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');
        $user_birthday = $request->post('user_birthday');
        $admin_id = $request->post('admin_id');
        $certifice_status = $request->post('certifice_status');
        $active = $request->post('active');
        $create_date = $request->post('create_date');

       $new_user = [
           'user_phone' => $user_phone, // 아이디
           'user_name' => $user_name, // 성명
           'password' => Hash::make($user_pwd), // 암호, // 암호
           'user_birthday' => $user_birthday, //생년월일
           'admin_id' => $admin_id, // 회사 아이디
           'certifice_status' => $certifice_status,
           'actived' => $active,
           'create_date' => $create_date, // 가입일시
           'visit_date' => '', // 방문시간
       ];

        $user = Client::create($new_user);

       return response()->json([
           'message'=>'Successfully registered',
           'user'=>$user
       ], 201);
    }

    /**
     * get a JWT via given credentials.
     * @endpointe /api/user/login
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');

        $validator = Validator::make(
            ['user_phone'=>$user_phone,             'password'=>$user_pwd],
            ['user_phone' =>'required|between:6,13','password' =>'required|string|min:3',]
        );

        if($validator->fails()){
            return response()->json([
                'msg'=>'err',
                'cont'=>$validator->errors(),
            ]);
            exit();
        }

        if(!$token = auth()->guard('mobile')->attempt($validator->validated())){
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
        return response()->json(auth()->guard('mobile')->client());
    }

    /**
     * log the user out (Invalidate the token)
     * @endpointe /api/auth/logout
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        auth()->guard('mobile')->logout();
        return response()->json(['msg'=>'Successfully logged out']);
    }


    /**
     * Refresh a token
     * @endpointe /api/auth/refresh
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(){
        return $this->createNewToken(auth()->guard('mobile')->refresh());
    }


    /**
    * @param sring $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->guard('mobile')->factory()->getTTL() * 60 * 24
        ]);
    }


}
