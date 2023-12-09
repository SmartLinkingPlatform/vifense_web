<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dotenv\Validator;
use mysql_xdevapi\Exception;

class UserController extends BaseController
{
    protected $tb_user_info ='tb_user_info';

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

    public function getUserList(Request $request){
        $search_val = $request->post('search_val');
        $start  = $request->post('start');
        $count    = $request->post('count');
        $start_from = ($start-1) * $count;
        $admin_id = $request->session()->get('admin_id');
        $user_type = $request->session()->get('user_type');

        $sql = "SELECT a.admin_id, a.user_phone, b.company_name, a.user_name, a.certifice_status, a.active, a.create_date, a.update_date ";
        $sql .= "FROM tb_user_info AS a LEFT JOIN tb_admin_info AS b ON a.admin_id = b.admin_id ";
        $sql .= "WHERE 1 ";

        if ($user_type == 0) {
            $sql .= " AND a.admin_id = ".$admin_id;
        }

        if(!is_null($search_val))
            $sql .= ' AND (a.user_name like "%'.$search_val.'%" OR a.user_phone like "%'.$search_val.'%") ';
        $lim_sql = $sql.'LIMIT '.$start_from.', '.$count;

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

}
