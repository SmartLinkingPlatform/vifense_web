@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
    <style>
        td:empty:after {
            content: "\00a0"; /* HTML entity of &nbsp; */
        }
        .th-not-border-bottom {
            border-bottom-width: 0px !important;
        }
    </style>
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">회원 청구서 요약 조회</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page">회원 청구서 요약 조회</li>
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
                <div class="card-header border-bottom-0 p-4">
                    <h2 class="card-title" style="margin-left: 7px;">회원 청구서 요약</h2>
                    <div class="page-options d-flex float-right d-print-none">
                        <button type="button" class="btn btn-info mb-1" id='download_csv'><i class="si si-printer"></i> 다운로드 </button>
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <div class="row pl-2 pr-2" >
                            <div class="col-md-2 d-flex pb-1">
                                <label class="form-label" style="width: 80px;">회원 이름</label>
                                <input type="text" id="input_search_name" class="form-control" placeholder="">
                            </div>
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
                            <div class="col-md-1 pb-1">
                                <div class="float-right">
                                    <span class="">
                                        <button id="button_search" class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>
                                    </span>
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
                            <tr>
                                <th id="th_number" class="text-center" rowspan="2">번호</th>
                                <th id="th_account" class="text-center" rowspan="2">회원 계정</th>
                                <th id="th_name" class="text-center" rowspan="2">회원 이름</th>
                                <th id="th_income" class="text-center">총 수입</th>
                                <th id="th_outcome" class="text-center">지출된 총 자금</th>
                            </tr>
                            <tr id="sub_header_tr" style="height: 20px;">
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

            </div>
        </div><!-- COL-END -->
    </div>
    <!-- ROW CLOSED -->
    </div>
    </div>
    <!-- CONTAINER CLOSED -->

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
        let sname = '';
        let sfdate = '';
        let stdate = '';
        let sitem = 0;
        let currency_ids = new Array();
        let currency_name = new Array();
        $(document).ready(function () {
            getAllCurrencyList();
            getAllItemList();

            $('#button_search').click(function(){
                pstart = 1;
                sname = $('#input_search_name').val();
                sfdate = $('#input_from_date').val();
                stdate = $('#input_to_date').val();
                sitem = $('#select_item_type').val();
                getOrderHistoryList();
            });

            $('#download_csv').click(function (){
                $.ajax({
                    url: 'admin.csvOrderHistoryList',
                    data: {
                        sname: sname,
                        start_date: sfdate,
                        end_date: stdate,
                        sitem: sitem,
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            let lists = data.lists;
                            let csv = [];
                            let table_title = new Array();
                            table_title.push('');
                            table_title.push('');
                            table_title.push('');
                            table_title.push('收入总资金');
                            for (let j = 0; j < currency_name.length - 1; j++) {
                                table_title.push('');
                            }
                            table_title.push('支出总资金');
                            csv.push(table_title.join(","));
                            table_title = new Array();
                            table_title.push('번호');
                            table_title.push('회원 계정');
                            table_title.push('회원 이름');
                            for (let j = 0; j < currency_name.length; j++) {
                                table_title.push(currency_name[j]);
                            }
                            for (let i = 0; i < currency_name.length; i++) {
                                table_title.push(currency_name[i]);
                            }
                            csv.push(table_title.join(","));
                            for (let i = 0; i < lists.length; i++) {
                                let table_row = new Array();
                                let list = lists[i];
                                let id = list.id;
                                let order = i + 1;
                                let user_account = list.account;
                                let user_name = list.name;
                                let amount = list.total_amount;
                                table_row.push(order);
                                table_row.push(user_account);
                                table_row.push(user_name);
                                for (let j = 0; j < currency_ids.length; j++) {
                                    let income_amount = 0;
                                    let item_name = '';
                                    let c_id = currency_ids[j];
                                    for (let k = 0; k < amount.length; k++) {
                                        let temp = amount[k];
                                        let t_type = temp.order_type;
                                        let t_cid = temp.cid;
                                        if (t_type === 0 && t_cid === c_id){
                                            income_amount = temp.tamount;
                                        }
                                    }
                                    table_row.push(income_amount);
                                }
                                for (let j = 0; j < currency_ids.length; j++) {
                                    let outcome_amount = 0;
                                    let item_name = '';
                                    let c_id = currency_ids[j];
                                    for (let k = 0; k < amount.length; k++) {
                                        let temp = amount[k];
                                        let t_type = temp.order_type;
                                        let t_cid = temp.cid;
                                        if (t_type === 1 && t_cid === c_id){
                                            outcome_amount = temp.tamount;
                                        }
                                    }
                                    table_row.push(outcome_amount);
                                }
                                csv.push(table_row.join(","));
                            }
                            downloadCSV(csv.join("\n"), '会员账单汇总查询.csv');
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            });
        });

        function downloadCSV(csv, filename) {
            let csvFile;
            let downloadLink;

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

        function getAllCurrencyList() {
            $.ajax({
                url: 'admin.getAllCurrencyList',
                data: {
                },
                type: 'POST',
                success: function (data) {
                    let tags = '';
                    if (data.msg === "ok") {
                        let lists = data.c_lists;
                        currency_ids = new Array();
                        if (lists.length > 0) {
                            $('#th_number').addClass('th-not-border-bottom');
                            $('#th_account').addClass('th-not-border-bottom');
                            $('#th_name').addClass('th-not-border-bottom');
                            $('#th_income').attr('colspan',lists.length);
                            $('#th_outcome').attr('colspan',lists.length);
                            for (let i = 0; i < lists.length; i++) {
                                let currency = lists[i];
                                currency_ids.push(currency.id);
                                currency_name.push(currency.name);
                                tags += '<td class="text-center">' + currency.name +'</td>';
                            }
                            for (let j = 0; j < lists.length; j++) {
                                let item = lists[j];
                                tags += '<td class="text-center">' + item.name +'</td >';
                            }
                        }
                        $('#sub_header_tr').html(tags);
                        getOrderHistoryList();
                    }
                    else {
                        $('#sub_header_tr').html(tags);
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
        function getAllItemList() {
            $.ajax({
                url: 'admin.getAllItemList',
                data: {
                },
                type: 'POST',
                success: function (data) {
                    $('#select_item_type').html('');
                    let tag = '';
                    tag += '<option value="0">항목을 선택하세요</option>';
                    if (data.msg === "ok") {
                        let lists = data.lists;
                        for (let i = 0; i < lists.length; i++) {
                            let item = lists[i];
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
        function getOrderHistoryList() {
            $.ajax({
                url: 'admin.getOrderHistoryList',
                data: {
                    start: pstart,
                    count: pcount,
                    sname: sname,
                    start_date: sfdate,
                    end_date: stdate,
                    sitem: sitem,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_order_list').html('');
                        $('#page_nav_container').html('');
                        let lists = data.lists;
                        let tags = '';
                        pstart=data.start;
                        let totalpage=data.totalpage;
                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let id = list.id;
                            let order = i + 1;
                            let user_account = list.account;
                            let user_name = list.name;
                            let amount = list.total_amount;
                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle text-center">' + order + '</td>';
                            tags += '<td class="text-nowrap align-middle text-center">' + user_account + '</td>';
                            tags += '<td class="text-nowrap align-middle text-center">' + user_name + '</td>';
                            for (let j = 0; j < currency_ids.length; j++) {
                                let income_amount = 0;
                                let item_name = '';
                                let c_id = currency_ids[j];
                                for (let k = 0; k < amount.length; k++) {
                                    let temp = amount[k];
                                    let t_type = temp.order_type;
                                    let t_cid = temp.cid;
                                    if (t_type === 0 && t_cid === c_id){
                                        income_amount = temp.tamount;
                                    }
                                }
                                tags += '<td class="text-nowrap align-middle text-center">' + income_amount + '</td>';
                            }
                            for (let j = 0; j < currency_ids.length; j++) {
                                let outcome_amount = 0;
                                let item_name = '';
                                let c_id = currency_ids[j];
                                for (let k = 0; k < amount.length; k++) {
                                    let temp = amount[k];
                                    let t_type = temp.order_type;
                                    let t_cid = temp.cid;
                                    if (t_type === 1 && t_cid === c_id){
                                        outcome_amount = temp.tamount;
                                    }
                                }
                                tags += '<td class="text-nowrap align-middle text-center">' + outcome_amount + '</td>';
                            }
                            tags += '</tr>';
                        }
                        $('#tbody_order_list').html(tags);

                        let nav_tag='';
                        nav_tag+='<nav aria-label="..." class="mb-4">';
                        nav_tag+='<ul class="pagination float-right">';
                        let disble="";
                        if(pstart===1)
                            disble="disabled";
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
                            let oid=$(this).attr("id");
                            pstart=oid.split('_')[3];
                            getOrderHistoryList();
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

    </script>
@endsection
