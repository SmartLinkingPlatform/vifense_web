<?php

namespace App;

use Illuminate\Notifications\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'tb_user_info';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_phone', 'user_pwd'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pwd',
    ];

    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
    /*
    public function user()
    {
        $this->belongsTo(User::class);
        //
    }
    */
    public function create_raw(Request $request)
    {
        $user_name = $request->post('user_name');
        $user_phone = $request->post('user_phone');
        $user_pwd = $request->post('user_pwd');
        $user_birthday = $request->post('user_birthday');
        $admin_id = $request->post('admin_id');
        $certifice_status = $request->post('certifice_status');
        $active = $request->post('active');
        $create_date = $request->post('create_date');

        $table_info = 'tb_user_info';
        try {
            $success = DB::table($table_info)
                ->insert(
                    [
                        'user_phone' => $user_phone, // 아이디
                        'user_name' => $user_name, // 성명
                        'user_pwd' => $user_pwd, // 암호
                        'user_birthday' => $user_birthday, //생년월일
                        'admin_id' => $admin_id, // 회사 아이디
                        'certifice_status' => $certifice_status,
                        'actived' => $active,
                        'create_date' => $create_date, // 가입일시
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

}
