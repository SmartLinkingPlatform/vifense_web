@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">공지 사항</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page" id="notice_selected_tab"></li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="col-sm-3 "></div>
                    <div class="card notice-card">
                        <div class="card-header d-flex justify-content-center notice-card-header">
                            <ul class="nav nav-underline" style="font-size: 16px">
                                <li class="nav-item">
                                    <a class="nav-link active" data-set="all" href="#">전체</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-set="company" href="#">회사</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-set="persion" href="#">개인</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-set="noticeinner" href="#">공지 내역</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col"  id="dlgErr" style="display: none;text-align:center">오류</div>
                        <div class="card-body notice-card-body-all " style="width: 50%; margin: 0 auto">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">제목</div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="input_title_all" placeholder="" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">알림 내용</div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" rows="6" id="text_detail_all"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body notice-card-body-company" style="display: none; border-top: 0; width: 50%; margin: 0 auto">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">제목</div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="input_title_company" placeholder="" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">알림 내용</div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" rows="6" id="text_detail_company"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body notice-card-body-persion" style="display: none; border-top: 0; width: 50%; margin: 0 auto">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row justify-content-center">
                                            <div class="col-md-4 pb-md-0 pb-sm-2">
                                                <input type="text" id="input_search_name" class="form-control" placeholder="검색">
                                            </div>
                                            <div class="col-md-2 pb-md-0 pb-sm-2 text-right">
                                                <span class="col-auto pl-2">
                                                    <button id="button_search" class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="e-table">
                                            <div class="table-responsive table-lg">
                                                <table class="table table-bordered mb-0 text-center">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 20%" >유저번호</th>
                                                        <th style="width: 40%" >휴대폰</th>
                                                        <th style="width: 40%" >이름</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody_user_list">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row justify-content-end">
                                    <div class="mb-5" id="page_nav_container">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">제목</div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="input_title_persion" placeholder="" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">알림 내용</div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" rows="6" id="text_detail_persion"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body notice-card-body-noticeinner" style="display: none; border-top: 0; width: 80%; margin: 0 auto">
                            <div class="e-table">
                                <div class="table-responsive table-lg">
                                    <table class="table table-bordered mb-0 text-center">
                                        <thead>
                                        <tr>
                                            <th style="width: 15%">일자</th>
                                            <th style="width: 15%">대상</th>
                                            <th style="width: 25%">제목</th>
                                            <th style="width: 35%">내용</th>
                                            <th style="width: 10%">비고</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody_notice_list">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mb-5" id="page_nav_container_list">

                            </div>
                        </div>


                        <div class="card-footer text-center card-notice-add-btn">
                            <div id="send_message_button" class="btn btn-success mt-1" style="width: 80px; margin-right: 30px;">보내기</div>
                        </div>

                    </div>
                    <div class="col-sm-3 "></div>
                </div>
            </div>
    <!-- ROW-1 CLOSED -->
        </div>
    </div>

    <!-- company info modal part -->
    <div class="modal fade" id="showModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">공지사항을 받을 사용자를 선택하십시오.</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
        </div>
    </div>
    <!--CONTAINER CLOSED -->
    </div>
@endsection
@section('js')

    <script>
        let setv='all';
        let search_val = '';
        let pstart=1;
        let pnum = pstart;
        let pcount=5;
        let numg = 5;
        let type_id = '';
        let click_cnt = 0;

        $(document).ready(function () {
            $('#notice_selected_tab').text('전체');

            $('.notice-card-header .nav-link').click(function(){
                setv = $(this).attr('data-set');
                let txt = '전체';
                if(setv==='all')
                    txt = '회사';
                if(setv==='company')
                    txt = '회사';
                if(setv==='persion')
                    txt = '개인';
                if(setv==='noticeinner')
                    txt = '공지내역';
                $('#notice_selected_tab').text(txt);

                $('.notice-card-header .nav-link').attr('class','nav-link');
                $(this).attr('class','nav-link active');

                $('.notice-card .card-body').css({'display':'none'});
                let showtab = 'notice-card-body-'+setv;
                $('.notice-card .'+showtab).css({'display':'block'});

                if(setv==='noticeinner'){
                    $('#send_message_button').css({'display':'none'});
                    getMessageList();
                }
                else{
                    $('#send_message_button').css({'display':'inline-block'});
                }
            });

            $('#send_message_button').click(function () {
                if(setv==='persion') {
                    if(type_id === '') {
                        $('#showModal').modal('show');
                    }
                }
                let input_title_id = 'input_title_'+setv;
                let text_id = 'text_detail_'+setv;
                let title_val = $('#'+input_title_id).val();
                let text_val = $('#'+text_id).val();

                title_val = title_val.replace(/\s/g, '');
                text_val = text_val.replace(/\s/g, '');
                if(title_val === ''){
                    $('#dlgErr').css({'display':'block','margin-top':'10px', 'color':'#d41b11'}).text('제목을 입력하세요.');
                    setTimeout(function () {
                        $('#dlgErr').text('').css({'display':'none', 'margin-top':'0'});
                    },1000);
                }
                else if(text_val === ''){
                    $('#dlgErr').css({'display':'block','margin-top':'10px', 'color':'#d41b11'}).text('알림 내용을 입력하세요.');
                    setTimeout(function () {
                        $('#dlgErr').text('').css({'display':'none', 'margin-top':'0'});
                    },1000);
                }

                $.ajax({
                    url: 'admin.sendMessage',
                    headers: {'Authorization': `Bearer ${window.localStorage.authToken}`},
                    data: {
                        selectedTab:setv,
                        title_val: title_val,
                        text_val: text_val,
                        to_notices:'',
                        type_id:type_id
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            $('#dlgErr').css({'display':'block','margin-top':'10px', 'color':'#0BC334'}).text('성공적으로 추가되었습니다');
                            setTimeout(function () {
                                $('#'+input_title_id).val('');
                                $('#'+text_id).val('');
                                $('#dlgErr').text('').css({'display':'none', 'margin-top':'0'});
                            },1000);
                        }else{
                            $('#dlgErr').css({'display':'block','margin-top':'10px', 'color':'#d41b11'}).text('오류가 발생하였습니다');
                            setTimeout(function () {
                                $('#dlgErr').text('').css({'display':'none', 'margin-top':'0'});
                            },1000);
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });

            });

            $('#button_search').click(function(){
                $('#tbody_user_list').html('');

                let sval = $('#input_search_name').val();
                search_val = sval.replace(/\s/g, '');

                searchUserInfo();
            });

        });

        function selectUser(id) {
            //$('tr[class="select_tr"]').css({'background-color':'transparent'});
            let objs = $('tr[class="select_tr"]');
            if(objs && objs.length > 0){
               for(let i=0;i<objs.length;i++){
                   let o = objs[i];
                   let o_id = o.getAttribute('data-id');
                   //console.log(o_id);
                   if(parseInt(id) === parseInt(o_id)){
                       o.style.backgroundColor="aliceblue";
                       type_id = id;
                   }
                   else{
                       o.style.backgroundColor="transparent";
                   }
               }
            }
        }

        function searchUserInfo() {
            $.ajax({
                url: '/admin.messageUser',
                headers: {'Authorization': `Bearer ${window.localStorage.authToken}`},
                data: {
                    start: pstart,
                    count:pcount,
                    search_val:search_val
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_user_list').html('');

                        let lists = data.lists;
                        pstart = parseInt(data.start);
                        let totalpage = parseInt(data.totalpage);
                        let tags = '';

                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let user_id = list.user_id;
                            let user_phone = list.user_phone || '';
                            let user_name = list.user_name || '';

                            tags += '<tr class="select_tr" data-id="'+user_id+'" style="cursor: pointer">';
                            tags += '<td class="text-nowrap align-middle">' + user_id + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + user_phone + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + user_name + '</td>';
                            tags += '</tr>';
                        }
                        $('#tbody_user_list').html(tags);

                        let nav_tag='';
                        nav_tag+='<nav aria-label="..." class="mb-4">';
                        nav_tag+='<ul class="pagination float-right">';

                        let disble="";
                        if(pstart===1)
                            disble="disabled"

                        let prenum= pstart - 1;

                        nav_tag+='<li class="page-item  '+disble+' ">';
                        nav_tag+='<a class="page-link" href="#"  id="page_nav_number_' + prenum + '" >';
                        nav_tag+='<i class="ti-angle-left"></i>';
                        nav_tag+='</a>';
                        nav_tag+='</li>';

                        pnum = pstart <= numg ? 1 : prenum;

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

                        $('tr[class="select_tr"]').click(function(){
                            let user_id = $(this).attr("data-id");
                            selectUser(user_id);
                        });


                        $('a[id^="page_nav_number_"]').click(function(){
                            let oid=$(this).attr("id");
                            pstart=oid.split('_')[3];
                            searchUserInfo();
                        });
                    }
                    else {
                        $('#tbody_user_list').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function getMessageList() {
            $.ajax({
                url: '/admin.messageList',
                headers: {'Authorization': `Bearer ${window.localStorage.authToken}`},
                data: {
                    start: pstart,
                    count:pcount
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_notice_list').html('');

                        let lists = data.lists;
                        pstart = parseInt(data.start);
                        let totalpage = parseInt(data.totalpage);
                        let tags = '';

                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let create_date = list.create_date;
                            let user_name = list.user_name || '전체';
                            let title = list.title || '';
                            let content = list.content || '';

                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle">' + create_date + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + user_name + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + title + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + content + '</td>';
                            tags += '<td class="text-nowrap align-middle"></td>';
                            tags += '</tr>';
                        }
                        $('#tbody_notice_list').html(tags);

                        let nav_tag='';
                        nav_tag+='<nav aria-label="..." class="mb-4">';
                        nav_tag+='<ul class="pagination float-right">';

                        let disble="";
                        if(pstart===1)
                            disble="disabled"

                        let prenum= pstart - 1;

                        nav_tag+='<li class="page-item  '+disble+' ">';
                        nav_tag+='<a class="page-link" href="#"  id="page_nav_number_' + prenum + '" >';
                        nav_tag+='<i class="ti-angle-left"></i>';
                        nav_tag+='</a>';
                        nav_tag+='</li>';

                        pnum = pstart <= numg ? 1 : prenum;

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

                        $('tr[class="select_tr"]').click(function(){
                            let user_id = $(this).attr("data-id");
                            selectUser(user_id);
                        });


                        $('a[id^="page_nav_number_"]').click(function(){
                            let oid=$(this).attr("id");
                            pstart=oid.split('_')[3];
                            searchUserInfo();
                        });
                    }
                    else {
                        $('#tbody_notice_list').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

    </script>
@endsection
