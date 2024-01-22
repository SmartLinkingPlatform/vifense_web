<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use mysql_xdevapi\Exception;

class NoticeController extends BaseController
{
    protected $tb_notice='tb_notice'; //공지
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


    /* This function equal corporateSignup of AdminController */
    public function sendMessageUsers(Request $request){

        $selectedTab = $request->post('selectedTab');
        $title_val = $request->post('title_val');
        $text_val = $request->post('text_val');
        $to_notices = $request->post('to_notices') ?? '';
        $type_id = $request->post('type_id') ?? '';
        date_default_timezone_set('Asia/Seoul');
        $create_date = date("Y-m-d h:i:s", time());
        $admin_id = $request->session()->get('admin_id');

        try {
            $success = DB::table($this->tb_notice)
                ->insert(
                    [
                        'title' => $title_val, // 공지제목
                        'content' => $text_val, // 공지내용
                        'type' => $selectedTab, // 공지타입   all/company/persion/noticeinner 전체/회사/개인/공지내역
                        'type_id' => $type_id,
                        'to_notices' => $to_notices, // 공지를 받을 유저/회사  '1, 2, 3' :: 앞으로 모든 회사나 개인이 아니고 선택하여 보내야 할때 필요
                        'from_user_id' => $admin_id, // 공지를 낸 유저 아이디
                        'create_date' => $create_date, // 공지 창조 일자
                        'actived' => 1, // 1 이면 공지발송 , 0 이면 지연
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

    public function getMessageUserList(Request  $request) {
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');
        $search_val = $request->post('search_val');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;

        if(is_null($search_val)) {
            return \Response::json([
                'msg' => 'nouser'
            ]);
        }

        $sql = "SELECT user_id, user_phone, user_name FROM tb_user_info ";
        $sql .= " WHERE 1 ";
        if ($user_type == 0) {
            $sql .= " AND admin_id = ".$admin_id;
        }
        if(!is_null($search_val)) {
            $sql .= " AND (user_name like '%" . $search_val . "%' OR ";
            $sql .= " user_phone like '%" . $search_val . "%') ";
        }
        $lim_sql = $sql.' ORDER BY user_id ASC LIMIT '.$start_from.', '.$count;

        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));
        $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
        $total = count($total_rows);
        $total_page = ceil($total / $count);

        if($rows != null){
            return \Response::json([
                'msg' => 'ok',
                'total' => $total,
                'start' => $start,
                'totalpage' => $total_page,
                'lists' => $rows
            ]);
        }
        exit();
    }

    public function getAllMessageList(Request  $request) {
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;

        $sql = "SELECT a.create_date, a.type, b.user_type, b.company_name, c.user_name, a.title, a.content ";
        $sql .= "FROM tb_notice AS a ";
        $sql .= "LEFT JOIN tb_admin_info AS b ON a.from_user_id = b.admin_id ";
        $sql .= "LEFT JOIN tb_user_info AS c ON a.type_id = c.user_id ORDER BY a.notice_id DESC ";

        $lim_sql = $sql.' LIMIT '.$start_from.', '.$count;

        $rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($lim_sql));
        $total_rows = DB::connection($this->dgt_db)->select(DB::connection($this->dgt_db)->raw($sql));
        $total = count($total_rows);
        $total_page = ceil($total / $count);

        if($rows != null){
            return \Response::json([
                'msg' => 'ok',
                'total' => $total,
                'start' => $start,
                'totalpage' => $total_page,
                'lists' => $rows
            ]);
        }
        exit();
    }

    public function uploadHtmlFile(Request $request){
        $uploadfile_html = $request->file('uploadfile_html');
        $url = $_SERVER[ "HTTP_HOST" ];
        if($uploadfile_html != null && $uploadfile_html != ''){
            $new_name = 'terms.'.$uploadfile_html->getClientOriginalExtension();
            $uploadfile_html->move(public_path(''), $new_name);
        }
        $url .= '/'.$new_name;
        $rows =DB::table('tb_upload_file')->first();
        if($rows == null){
            $success = DB::table('tb_upload_file')
                ->insert(
                    [
                        'path' => $url
                    ]
                );
        }
        else{
            $success = DB::table('tb_upload_file')
                ->update(
                    [
                        'path' => $url
                    ]
                );
        }

        return \Response::json([
            'msg' => 'ok'
        ]);
    }
}
