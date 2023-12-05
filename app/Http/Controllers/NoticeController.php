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
    public function noticeAdd(Request $request){

        $selectedTab = $request->post('selectedTab');
        $title_val = $request->post('title_val');
        $text_val = $request->post('text_val');
        $to_notices = $request->post('to_notices') ?? '';
        $create_date = date("Y-m-d h:i:s", time());
        $admin_id = $request->session()->get('admin_id');

        try {
            $success = DB::table($this->tb_notice)
                ->insert(
                    [
                        'title' => $title_val, // 공지제목
                        'content' => $text_val, // 공지내용
                        'type' => $selectedTab, // 공지타입   all/company/persion/noticeinner 전체/회사/개인/공지내역
                        'to_notices' => $to_notices, // 공지를 받을 유저/회사  '1, 2, 3' :: 앞으로 모든 회사나 개인이 아니고 선택하여 보내야 할때 필요
                        'from_user_id' => $admin_id, // 공지를 낸 유저 아이디
                        'create_date' => $create_date, // 공지 창조 일자
                        'active' => 1, // 1 이면 공지발송 , 0 이면 지연
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
