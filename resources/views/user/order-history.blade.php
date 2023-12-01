@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
    <style>
        @media print
        {
            body * { visibility: visible; }
            .not-show-print * {display: none !important; }
        }
    </style>
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">결제 상세 정보</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">회원 체계</a></li>
            <li class="breadcrumb-item active" aria-current="page">결제 상세 정보</li>
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
                <div class="card-header border-bottom-0 p-4" style="padding-bottom: 30px;">
                    <h2 class="card-title" style="margin-left: 7px;">결제 상세 정보</h2>
                    <div class="page-options d-flex float-right">
                        <div class="btn btn-success" id="button_add" style="width: 80px; margin-right: 10px;">
                            비용신청
                        </div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <div class="row pl-1 pr-1">
                            <div class="col-md-2 d-flex pb-1">
                                <label class="form-label" style="width: 80px;">프로젝트</label>
                                <select class="form-control" id="select_item_type">
                                </select>
                            </div>
                            <div class="col-md-3 d-flex pb-1">
                                <label class="form-label text-right pr-3" style="width: 80px;">시작</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="input_from_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex pb-1">
                                <label class="form-label text-right pr-3" style="width: 80px;">마감</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="input_to_date" class="form-control fc-datepicker-2" placeholder="MM/DD/YYYY" type="text">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex pb-1">
                                <span class="col-auto pl-2">
                                    <button id="button_search" class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>
                                </span>
                                <div class="page-options d-print-none float-right" style="height: 30px;">
                                    <button type="button" class="btn btn-info mb-1" id='download_csv'><i class="si si-printer"></i> 인 </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>

                </div>
                <div class="e-table px-5 pb-5">
                    <div class="table-responsive table-lg">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr style="height: 30px;">
                                <th >번호</th>
                                <th >청구서 코드</th>
                                <th >이름</th>
                                <th >수입/지출</th>
                                <th >프로젝트 유형</th>
                                <th >통화</th>
                                <th >수량</th>
                                <th >날짜</th>
                                <th class="text-center">청구서 상태</th>
                                <th  class="text-center d-print-none">상세 정보</th>
                            </tr>
                            </thead>
                            <tbody id="tbody_order_list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mb-5" id="page_nav_container">

            </div>

            <div class="card-footer text-right">
                <input id="input_current_user_id"  type="hidden" value="
                                        {{{ Session::get('user_id') }}}">
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
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">새 회원 추가</div>
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
                                    <label class="form-label">상세 정보</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" rows="6" id="mtext_detail" readonly></textarea>
                                </div>
                            </div>
                            <div class="form-group" style="display: flex; height: 230px;">
                                <div class="col-md-2">
                                    <label class="form-label">사진</label>
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
        var user_id;
        var current_order_id = 0;
        var pstart=1;
        var pnum = pstart;
        var pcount=5;
        var numg = 5;
        var sname = '';
        var sfdate = '';
        var stdate = '';
        var sitem = 0;
        $(document).ready(function () {
            user_id = $('#input_current_user_id').val();
            getOrderHistoryList();
            getAllItemList();

            $('#button_add').click(function(){
                goNewOrderPage();
            });

            $('#button_search').click(function(){
                pstart = 1;
                sfdate = $('#input_from_date').val();
                stdate = $('#input_to_date').val();
                sitem = $('#select_item_type').val();
                getOrderHistoryList();
            });

            $('#download_csv').click(function (){
                $.ajax({
                    url: 'user.csvOrderHistoryList',
                    data: {
                        id: user_id,
                        sname: sname,
                        sitem: sitem,
                        start_date: sfdate,
                        end_date: stdate,
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            var lists = data.lists;
                            var csv = [];
                            var table_title = new Array();
                            table_title.push('번호');
                            table_title.push('청구서 코드');
                            table_title.push('이름');
                            table_title.push('수입/지출');
                            table_title.push('프로젝트 유형');
                            table_title.push('통화');
                            table_title.push('수량');
                            table_title.push('날짜');
                            table_title.push('청구서 상태');
                            csv.push(table_title.join(","));
                            for (var i = 0; i < lists.length; i++) {
                                var table_row = new Array();
                                var list = lists[i];
                                var id = list.id;
                                var order = i + 1;
                                var order_no = list.order_no;
                                var order_status = list.status;
                                var status_string = '';
                                if (order_status == 0) {
                                    status_string = '대기중';
                                } else if (order_status == 1) {
                                    status_string = '완료';
                                } else if (order_status == 2) {
                                    status_string = '취소됨';
                                }
                                var user_name = list.name;
                                var type = list.order_type;
                                var type_string = '';
                                if (type == 0) {
                                    type_string = '소득';
                                } else {
                                    type_string = '지출';
                                }
                                var item_name = list.iname;
                                if (item_name == null)
                                    item_name = '';
                                var currency_name = list.cname;
                                var amount = list.amount;
                                var create_date = list.created_at;
                                var dateString = create_date.split(' ')[0];
                                var temp = dateString.split('-');
                                var create_string = temp[1] + '/' + temp[2] + '/' + temp[0];
                                table_row.push(order);
                                table_row.push(order_no);
                                table_row.push(user_name);
                                table_row.push(type_string);
                                table_row.push(item_name);
                                table_row.push(currency_name);
                                table_row.push(amount);
                                table_row.push(create_string);
                                table_row.push(status_string);
                                csv.push(table_row.join(","));
                            }
                            downloadCSV(csv.join("\n"), '账单明细.csv');
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            });

        });

        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob(["\ufeff"+csv], {type: 'text/csv; charset=utf-8'});

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }

        function getAllItemList() {
            $.ajax({
                url: 'user.getAllItemList',
                data: {
                },
                type: 'POST',
                success: function (data) {
                    $('#select_item_type').html('');
                    var tag = '';
                    tag += '<option value="0">항목을 선택하세요</option>';
                    if (data.msg === "ok") {
                        var lists = data.lists;
                        for (var i = 0; i < lists.length; i++) {
                            var item = lists[i];
                            tag += '<option value="' + item.id + '">'+ item.name +'</option>'
                        }
                        $('#select_item_type').html(tag);
                    }
                    else {
                        $('#select_item_type').html(tag2);
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function selectedImageFunc(images) {
            $('#chooseicon-container').html('');
            var tags = "";
            if(images.length > 4)
            {
                tags += '<div class="row page2_row">';
                for(var i = 0; i < 4; i++){
                    tags += '<div class="col-md-3">';
                    tags += '   <div class="image_selected" id="imagechooseicons_'+i+'">';
                    tags += '       <img src="'+images[i]+'" id="seletedIconImage_'+i+'" class="seletedIconImage" >';
                    tags += '   </div>';
                    tags += '</div>';
                }
                tags += '</div>';
                tags += '<div class="row page2_row">';
                for(var i = 4; i < images.length; i++){
                    tags += '<div class="col-md-3">';
                    tags += '   <div class="image_selected" id="imagechooseicons_'+i+'">';
                    tags += '       <img src="'+images[i]+'" id="seletedIconImage_'+i+'" class="seletedIconImage" >';
                    tags += '   </div>';
                    tags += '</div>';
                }
                tags += '</div>';
            }
            else{
                tags += '<div class="row page2_row">';
                for(var i = 0; i < images.length; i++){
                    tags += '<div class="col-md-3">';
                    tags += '   <div class="image_selected" id="imagechooseicons_'+i+'">';
                    tags += '       <img src="'+images[i]+'" id="seletedIconImage_'+i+'" class="seletedIconImage" >';
                    tags += '   </div>';
                    tags += '</div>';
                }
                tags += '</div>';
            }

            $('#chooseicon-container').html(tags);
        }

        function showMoreDialog(id) {
            current_order_id = id;
            $('#showMoreModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('결제 상세 정보');
            $('#minput_user_account').val('');
            $('#minput_user_name').val('');
            $('#minput_currency_name').val('');
            $('#minput_amount').val('');
            $('#minput_item_name').val('');
            $('#minput_date').val('');
            $('#mtext_detail').text('');
            //$('#mimage_order').attr('src', '');

            $.ajax({
                url: 'user.getOrderDetailInformation',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        var list = data.lists[0];
                        var user_account = list.account;
                        var user_name = list.name;
                        var currency_name = list.cname;
                        var item_name = list.iname;
                        var amount = list.amount;
                        var description = list.description;
                        var create_date = list.created_at;
                        var dateString = create_date.split(' ')[0];
                        var temp = dateString.split('-');
                        var create_string = temp[1] + '/' + temp[2] + '/' + temp[0];
                        //var img_url = list.img_url;
                        $('#minput_user_account').val(user_account);
                        $('#minput_user_name').val(user_name);
                        $('#minput_currency_name').val(currency_name);
                        $('#minput_item_name').val(item_name);
                        $('#minput_amount').val(amount);
                        $('#minput_date').val(create_string);
                        $('#mtext_detail').text(description);
                        //$('#mimage_order').attr('src', img_url);
                        var images = new Array();
                        if(list.img_0 !== null && list.img_0 !== "")
                            images.push(list.img_0);
                        if(list.img_1 !== null && list.img_1 !== "")
                            images.push(list.img_1);
                        if(list.img_2 !== null && list.img_2 !== "")
                            images.push(list.img_2);
                        if(list.img_3 !== null && list.img_3 !== "")
                            images.push(list.img_3);
                        if(list.img_4 !== null && list.img_4 !== "")
                            images.push(list.img_4);
                        if(list.img_5 !== null && list.img_5 !== "")
                            images.push(list.img_5);
                        if(list.img_6 !== null && list.img_6 !== "")
                            images.push(list.img_6);
                        if(list.img_7 !== null && list.img_7 !== "")
                            images.push(list.img_7);

                        selectedImageFunc(images);
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function getOrderHistoryList() {
            $.ajax({
                url: 'user.getOrderHistoryList',
                data: {
                    id: user_id,
                    start: pstart,
                    count: pcount,
                    sname: sname,
                    sitem: sitem,
                    start_date: sfdate,
                    end_date: stdate,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_order_list').html('');
                        $('#page_nav_container').html('');
                        var lists = data.lists;
                        var tags = '';
                        pstart=data.start;
                        var totalpage=data.totalpage;
                        for (var i = 0; i < lists.length; i++) {
                            var list = lists[i];
                            var id = list.id;
                            var order = i + 1;
                            var order_no = list.order_no;
                            var order_status = list.status;
                            var status_string = '';
                            if (order_status == 0) {
                                status_string = '확인 중';
                            }
                            else if (order_status == 1) {
                                status_string = '완료됨';
                            }
                            else if (order_status == 2) {
                                status_string = '거절됨';
                            }
                            var user_name = list.name;
                            var type = list.order_type;
                            var type_string = '';
                            if (type == 0){
                                type_string = '수입';
                            }
                            else {
                                type_string = '지출';
                            }
                            var item_name = list.iname;
                            if(item_name == null)
                                item_name = '';
                            var currency_name = list.cname;
                            var amount = list.amount;
                            var create_date = list.created_at;
                            var dateString = create_date.split(' ')[0];
                            var temp = dateString.split('-');
                            var create_string = temp[1] + '/' + temp[2] + '/' + temp[0];
                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle">' + order + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + order_no + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + user_name + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + type_string + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + item_name + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + currency_name + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + amount + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + create_string + '</td>';
                            if (order_status == 2) {
                                tags += '<td class="text-center align-middle">';
                                tags += '<span>' + status_string+ '</span>';
                                tags += '<div class="btn-group pr-3 align-middle ml-2">';
                                tags += '<button class="btn btn-sm btn-primary badge p-2" data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_'+id + '">수정<i class="fa fa-edit"></i></button>';
                                tags += '</div>';
                                tags += '</td>';
                            }
                            else {
                                tags += '<td class="text-nowrap align-middle text-center">' + status_string + '</td>';
                            }
                            tags += '<td class="text-center align-middle d-print-none">';
                            tags += '<div class="btn-group align-top pr-3">';
                            tags += '<button class="btn btn-sm btn-outline-success badge p-1" data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_more_'+id + '">상세 정보<i class="fa fa-eye"></i></button>';
                            tags += '</div>';
                            tags += '</td>';
                            tags += '</tr>';
                        }
                        $('#tbody_order_list').html(tags);

                        var nav_tag='';
                        nav_tag+='<nav aria-label="..." class="mb-4">';
                        nav_tag+='<ul class="pagination float-right">';
                        var disble="";
                        if(pstart==1)
                            disble="disabled";
                        var prenum= parseInt(pstart) - 1;
                        nav_tag+='<li class="page-item  '+disble+' ">';
                        nav_tag+='<a class="page-link" href="#"  id="page_nav_number_' + prenum + '" >';
                        nav_tag+='<i class="ti-angle-left"></i>';
                        nav_tag+='</a>';
                        nav_tag+='</li>';
                        pnum = pstart <= numg ? 1 : parseInt(pstart) - 1;
                        for(var idx = 0; idx < numg; idx++)
                        {
                            var actv="";
                            var aria_current='';
                            var spantag='';
                            var oid='';

                            if(pnum==pstart)
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

                            if(pnum==totalpage) break;
                            pnum = pnum + 1;
                        }
                        var nextnum= parseInt(pstart) + 1;

                        var edisble="";
                        if(pstart==totalpage)
                            edisble="disabled"

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
                            var oid=$(this).attr("id");
                            pstart=oid.split('_')[3];
                            getOrderHistoryList();
                        });

                        $('button[id^="button_more_"]').click(function(){
                            var oid = $(this).attr("id");
                            var id = oid.split('_')[2];
                            showMoreDialog(id);
                        });
                        $('button[id^="button_edit_"]').click(function(){
                            var oid = $(this).attr("id");
                            var id = oid.split('_')[2];
                            goModOrderPage(id);
                        });
                    }
                    else {
                        $('#tbody_order_list').html('');
                        $('#page_nav_container').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function goNewOrderPage() {
            window.location.href = 'user.new-outcome';
        }
        function goModOrderPage(id) {
            $.ajax({
                url: 'user.goOutcomeModPage',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        window.location.href = 'user.mod-outcome';
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
    </script>
@endsection
