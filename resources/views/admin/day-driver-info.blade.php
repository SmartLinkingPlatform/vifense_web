@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
   <link href="{{ URL::asset('assets/css/components.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">일별 주행 정보</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page">일별 주행 정보</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW OPEN -->
            <div class="row row-cards">
                <div class="col-lg-12 col-xl-12">
                    <div class="input-group mb-5" style="display: none;">
                        <input type="text" class="form-control" placeholder="">
                        <div class="input-group-append ">
                            <button type="button" class="btn btn-secondary">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card mt-2">

                        <div class="row px-5 py-5">
                            <div class="row w-100 m-0 pl-3 pr-3 justify-content-around">
                                <div class="col-md-3 pb-md-0 pb-sm-2">
                                    <input type="text" id="input_search_name" class="form-control" placeholder="검색">
                                </div>
                                <div class="col-md-4 pb-md-0 pb-sm-2">
                                    <div class="input-group" >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input id="input_from_date" class="form-control fc-datepicker" placeholder="YYYY-MM-DD" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4 pb-md-0 pb-sm-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input id="input_to_date" class="form-control fc-datepicker-2" placeholder="YYYY-MM-DD" type="text">
                                    </div>
                                </div>
                                <div class="col-md-1 pb-md-0 pb-sm-2 text-right">
                                    <span class="col-auto pl-2">
                                        <button id="button_search" class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="e-table px-5 pb-5">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th >번호</th>
                                        <th >아이디</th>
                                        <th >소속사</th>
                                        <th >성명</th>
                                        <th >최고속도</th>
                                        <th >평균속도</th>
                                        <th >주행거리</th>
                                        <th >주행시간</th>
                                        <th >공회전</th>
                                        <th >주행점수</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody_day_driving_list">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5" id="page_nav_container">

                    </div>
                </div><!-- COL-END -->
            </div>
    <!-- ROW CLOSED -->
        </div>
    </div>
    <!-- CONTAINER CLOSED -->

    <!-- modal part -->
    <div class="modal fade" id="showMoreModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <!-- Modal content-->
            <div class="modal-content mt-7">
                <div class="modal-header">
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">상세 정보 보기</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row"  id="dlgErr" style="display: none; padding-left: 15px;">
                        <div class="col">
                            error;
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group d-flex align">
                                        <div class="col-md-4 align-content-center">
                                            <label class="form-label">회원 계정</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="minput_user_account" placeholder="" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group d-flex">
                                        <div class="col-md-4">
                                            <label class="form-label">회원 이름</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="minput_user_name" placeholder="" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group d-flex align">
                                        <div class="col-md-4 align-content-center">
                                            <label class="form-label">통화</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="minput_currency_name" placeholder="" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group d-flex">
                                        <div class="col-md-4">
                                            <label class="form-label">수량</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="minput_amount" placeholder="" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group d-flex align">
                                        <div class="col-md-4 align-content-center">
                                            <label class="form-label">프로젝트 유형</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="minput_item_name" placeholder="" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group d-flex align">
                                        <div class="col-md-4 align-content-center">
                                            <label class="form-label">날짜</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="minput_date" placeholder="" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="col-md-2">
                                    <label class="form-label">상세 정보 입력</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" rows="6" id="mtext_detail" readonly></textarea>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="col-md-2">
                                    <label class="form-label">상세 사진</label>
                                </div>
                                <div class="col-md-10 text-center" id="chooseicon-container">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/js/popover.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        let pstart=1;
        let pnum = pstart;
        let pcount=5;
        let numg = 5;
        let search_val = '';

        $(document).ready(function () {
            $( "#input_from_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $( "#input_to_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            getDayDrivingList();
        });

        function getDayDrivingList() {
            let from_date = $('#input_from_date').val().replace(/ /g, '');
            let to_date = $('#input_to_date').val().replace(/ /g, '');

            $.ajax({
                url: 'admin.getDayDrivingList',
                data: {
                    start: pstart,
                    count:pcount,
                    search_val:search_val,
                    from_date:from_date,
                    to_date:to_date
                },
                type: 'POST',
                success: function (data) {
                    console.log(data.msg);
                    console.log(data.sql);
                    return;

                    if (data.msg === "ok") {
                        $('#tbody_day_driving_list').html('');
                        $('#page_nav_container').html('');
                        let lists = data.lists;
                        pstart=data.start;
                        let totalpage=data.totalpage;
                        let tags = '';
                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let admin_id = list.admin_id;
                            let order = i + 1;
                            let user_phone = list.user_phone;
                            let company_name = list.company_name || '';
                            let certifice_status = list.certifice_status || '0';
                            let active = list.active || '0';
                            let registe_date = list.registe_date || '';
                            let visit_date = list.visit_date || '';
                            let cert_check = parseInt(certifice_status) > 0 ? 'checked' : '';
                            let act_check = parseInt(active) > 0 ? 'checked' : '';
                            //let create_date = list.create_date;
                            //let dateString = create_date.split(' ')[0];
                            //let temp = dateString.split('-');
                            //let create_string = temp[1] + '/' + temp[2] + '/' + temp[0];
                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle">' + order + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + user_phone + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + company_name + '</td>';

                            tags += '<td class="text-nowrap align-middle">';
                            tags += '<div class="d-flex justify-content-center">';
                            tags += '<input aria-disabled="true" type="checkbox" value="'+certifice_status+'" id="certiChecked_'+admin_id+'" '+cert_check+' >';
                            tags += '</div>';
                            tags += '</td>';

                            tags += '<td class="text-nowrap align-middle">';
                            tags += '<div class="d-flex justify-content-center">';
                            tags += '<input  type="checkbox" value="'+active+'" id="actiChecked_'+admin_id+'" '+act_check+' >';
                            tags += '</div>';
                            tags += '</td>';

                            tags += '<td class="text-nowrap align-middle">' + registe_date + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + visit_date + '</td>';
                            tags += '<td class="text-nowrap align-middle"> 로그 </td>';
                            tags += '<td class="text-center align-middle">';
                            tags += '<div class="btn-group align-top pr-3 col-md-6 pb-1 justify-content-center">';
                            tags += '<button class="btn btn-sm btn-primary badge p-3 " data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_'+admin_id + '">수정<i class="fa fa-edit"></i></button>';
                            tags += '</div>';
                            tags += '<div class="btn-group align-top col-md-6 pb-1 justify-content-center">';
                            tags += '<button class="btn btn-sm btn-red badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id="button_delete_' + admin_id + '">삭제<i class="fa fa-trash"></i></button>';
                            tags += '</div>';
                            tags += '</td>';
                            tags += '</tr>';
                        }
                        $('#tbody_day_driving_list').html(tags);

                        let nav_tag='';
                        nav_tag+='<nav aria-label="..." class="mb-4">';
                        nav_tag+='<ul class="pagination float-right">';

                        let disble="";
                        if(pstart===1)
                            disble="disabled"

                        let prenum= parseInt(pstart) - 1;

                        nav_tag+='<li class="page-item  '+disble+' ">';
                        nav_tag+='<a class="page-link" href="#"  id="page_nav_number_' + prenum + '" >';
                        nav_tag+='<i class="ti-angle-left"></i>';
                        nav_tag+='</a>';
                        nav_tag+='</li>';

                        pnum = pstart <= numg ? 1 : parseInt(pstart) - 1;

                        for(let idx = 0; idx < numg; idx++)
                        {
                            let actv="";
                            let aria_current='';
                            let spantag='';
                            let oid='';

                            if(pnum===pstart)
                            {
                                actv='active';
                                aria_current='aria-current="page"';
                                spantag='<span class="sr-only">(current)</span>';
                            }
                            else
                                oid="page_nav_number_" + pnum;

                            nav_tag+='<li class="page-item ' + actv + '"  ' + aria_current + '>';
                            nav_tag+='<a class="page-link" id="' + oid + '"  href="#" >' + pnum + '  ' + spantag + '</a>';
                            nav_tag+='</li>';

                            if(pnum===totalpage) break;
                            pnum = pnum + 1;
                        }
                        let nextnum= parseInt(pstart) + 1;

                        let edisble="";
                        if(pstart===totalpage)
                            edisble="disabled";

                        nav_tag+='<li class="page-item '+edisble+' ">';
                        nav_tag+='<a class="page-link" id="page_nav_number_' + nextnum + '" href="#">';
                        nav_tag+='<i class="ti-angle-right"></i>';
                        nav_tag+='</a>';
                        nav_tag+='</li>';

                        nav_tag+='</ul>';
                        nav_tag+='</nav>';

                        $('#page_nav_container').html(nav_tag);

                        /* events { */
                        $('a[id^="page_nav_number_"]').click(function(){
                            let oid=$(this).attr("id");
                            pstart=oid.split('_')[3];
                            getCompanyList();
                        });

                        $('button[id^="button_edit_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
                            showEditDialog(id);
                        });

                        $('button[id^="button_delete_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
                            deleteCompany(id);
                        });

                        $('input[id^="actiChecked_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[1];
                            let cks = $('#actiChecked_' + id).prop('checked');
                            let act = cks ? 1 : 0;
                            //console.log(act);
                            activeCompany(id, act);
                        });

                    }
                    else {
                        $('#tbody_admin_list').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
    </script>
@endsection
