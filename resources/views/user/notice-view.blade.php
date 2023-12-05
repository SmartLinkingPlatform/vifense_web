@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">공지 사항</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리  체계</a></li>
            <li class="breadcrumb-item active" aria-current="page" id="notice_selected_tab"></li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
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
                        <div class="card-body notice-card-body-all">
                                <div class="form-group">
                                    <label class="form-label">제목</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" id="input_title_all" placeholder="" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">알림 내용</label>
                                    <textarea class="form-control" rows="6" id="text_detail_all"></textarea>
                                </div>
                        </div>

                        <div class="card-body notice-card-body-company" style="display: none; border-top: 0">
                                <div class="form-group">
                                    <label class="form-label">제목</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" id="input_title_company" placeholder="" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">알림 내용</label>
                                    <textarea class="form-control" rows="6" id="text_detail_company"></textarea>
                                </div>
                        </div>

                        <div class="card-body notice-card-body-persion" style="display: none; border-top: 0">
                            <div class="form-group">
                                <label class="form-label">제목</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="input_title_persion" placeholder="" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">알림 내용</label>
                                <textarea class="form-control" rows="6" id="text_detail_persion"></textarea>
                            </div>
                        </div>

                        <div class="card-body notice-card-body-noticeinner" style="display: none; margin: 0.75rem 1.3rem; border-top: 0; padding: 0">
                            <div class="e-table">
                                <div class="table-responsive table-lg">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th >일자</th>
                                            <th >대상</th>
                                            <th >제목</th>
                                            <th >내용</th>
                                            <th >비고</th>
                                           {{-- <th class="text-center" style="width: 200px;" >수정삭제</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody id="tbody_notice_list">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mb-5" id="page_nav_container">
                                <nav aria-label="..." class="mb-4">
                                    <ul class="pagination float-right">
                                        <li class="page-item">
                                            <a class="page-link" href="#"  id="page_nav_number_1" >1</a>
                                        </li>
                                    </ul>
                                </nav>

                            </div>
                        </div>


                        <div class="card-footer text-center card-notice-add-btn">
                            <div id="button_notice_add" class="btn btn-success mt-1" style="width: 80px; margin-right: 30px;">보내기</div>
                        </div>

                    </div>
                </div>
            </div>
    <!-- ROW-1 CLOSED -->
        </div>
    </div>

    <!--CONTAINER CLOSED -->
    </div>
@endsection
@section('js')

    <script>
        let setv='all';
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
                    txt = '공지';
                $('#notice_selected_tab').text(txt);

                $('.notice-card-header .nav-link').attr('class','nav-link');
                $(this).attr('class','nav-link active');

                $('.notice-card .card-body').css({'display':'none'});
                let showtab = 'notice-card-body-'+setv;
                $('.notice-card .'+showtab).css({'display':'block'});

                if(setv==='noticeinner'){
                    $('#button_notice_add').css({'display':'none'});
                }
                else{
                    $('#button_notice_add').css({'display':'inline-block'});
                }
            });

            $('#button_notice_add').click(function () {
                let input_title_id = 'input_title_'+setv;
                let text_id = 'text_detail_'+setv;
                let title_val = $('#'+input_title_id).val();
                let text_val = $('#'+text_id).val();

                title_val = title_val.replace(/\s/g, '');
                text_val = text_val.replace(/\s/g, '');
                if(title_val === ''){
                    $('#dlgErr').css({'display':'block','margin-top':'10px', 'color':'#d41b11'}).text('제목은 비지 말아야 합니다');
                    setTimeout(function () {
                        $('#dlgErr').text('').css({'display':'none', 'margin-top':'0'});
                    },1000);
                }
                else if(text_val === ''){
                    $('#dlgErr').css({'display':'block','margin-top':'10px', 'color':'#d41b11'}).text('내용은 비지 말아야 합니다');
                    setTimeout(function () {
                        $('#dlgErr').text('').css({'display':'none', 'margin-top':'0'});
                    },1000);
                }

                $.ajax({
                    url: 'user.noticeAdd',
                    data: {
                        selectedTab:setv,
                        title_val: title_val,
                        text_val: text_val,
                        to_notices:'',
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

        });

    </script>
@endsection
