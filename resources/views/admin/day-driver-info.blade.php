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
                                        <input id="input_from_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4 pb-md-0 pb-sm-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input id="input_to_date" class="form-control fc-datepicker-2" placeholder="MM/DD/YYYY" type="text">
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
                                    <tbody id="tbody_order_list">
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
        $(document).ready(function () {

        });
    </script>
@endsection
