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

    <!-- company info modal part -->
    <div class="modal fade" id="showMoreModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">상세 정보 보기</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div >
                        <div class="form-group row d-flex">
                            <div class="col-md-4 pl-3">
                                <label class="form-label">과속시간</label>
                            </div>
                            <div class="col-md-8">
                                <div id="fast_speed_time" class="form-control"></div>
                            </div>
                        </div>

                        <div class="form-group row d-flex">
                            <div class="col-md-4 pl-3">
                                <label class="form-label">주행속도(110km이상)</label>
                            </div>
                            <div class="col-md-8">
                                <div id="fast_speed_cnt" class="form-control"></div>
                            </div>
                        </div>

                        <div class="form-group row d-flex">
                            <div class="col-md-4 pl-3">
                                <label class="form-label">급가속</label>
                            </div>
                            <div class="col-md-8">
                                <div id="quick_speed_cnt" class="form-control"></div>
                            </div>
                        </div>

                        <div class="form-group row d-flex">
                            <div class="col-md-4 pl-3">
                                <label class="form-label">급제동</label>
                            </div>
                            <div class="col-md-8">
                                <div id="brake_speed_cnt" class="form-control"></div>
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
        let from_date = '';
        let to_date = '';

        $(document).ready(function () {
            $( "#input_from_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $( "#input_to_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            getDayDrivingList();


            $('#button_search').click(function(){
                pstart = 1;
                let sval = $('#input_search_name').val();
                search_val = sval.replace(/\s/g, '');
                from_date = $('#input_from_date').val().replace(/ /g, '');
                to_date = $('#input_to_date').val().replace(/ /g, '');

                getDayDrivingList();
            });
        });

        function getSecToTime(time_sec) {
            let str_h = "";
            let str_m = "";
            let str_s = "";
            let hour = Math.floor(time_sec / 3600);
            if (hour <= 9) {
                str_h = "0" + hour + ":"
            } else {
                str_h = hour + ":"
            }
            let min = Math.floor((time_sec % 3600) / 60);
            if (min <= 9) {
                str_m = "0" + min + ":";
            } else {
                str_m = min + ":";
            }
            let sec = (time_sec % 3600) % 60;
            if (sec <= 9) {
                str_s = "0" + sec;
            } else {
                str_s = sec;
            }

            return str_h + str_m + str_s;
        }

        function showEveryUserDrivingInfo(name) {
            window.location.href = "admin.user-driver-info/"+name;
        }

        function showDrivingDetailInfo(fast_time, fast_cnt, quick_cnt, brake_cnt) {
            $('#showMoreModal').modal('show');
            $('#modal_title').text('상세 정보 보기');
            $('#fast_speed_time').text(fast_time);
            $('#fast_speed_cnt').text(fast_cnt);
            $('#quick_speed_cnt').text(quick_cnt);
            $('#brake_speed_cnt').text(brake_cnt);
        }

        function getDayDrivingList() {
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
                    if (data.msg === "ok") {
                        $('#tbody_day_driving_list').html('');
                        $('#page_nav_container').html('');
                        let lists = data.lists;
                        pstart=data.start;
                        let totalpage=data.totalpage;
                        let tags = '';
                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let order = i + 1;
                            let phone = list.phone;
                            let company = list.company || '';
                            let name = list.name || '';
                            let max_speed = list.max_speed || '0';
                            let avr_speed = list.avr_speed || '0';
                            let mileage = list.mileage || '0';
                            let drv_time = getSecToTime(parseInt(list.drv_time));
                            let idl_time = getSecToTime(parseInt(list.idl_time));
                            let score = list.score || '';

                            let quick_cnt = list.quick_cnt || '0';
                            let brake_cnt = list.brake_cnt || '0';
                            let fast_cnt = list.fast_cnt || '0';
                            let fast_time = getSecToTime(parseInt(list.fast_time));

                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle">' + order + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + phone + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + company + '</td>';
                            tags += '<td class="text-nowrap align-middle" onclick="showEveryUserDrivingInfo(\''+name+'\');" style="text-decoration: underline; cursor: pointer">' + name + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + max_speed + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + avr_speed + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + mileage + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + drv_time + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + idl_time + '</td>';
                            tags += '<td class="text-nowrap align-middle" onclick="showDrivingDetailInfo(';
                            tags += "'"+fast_time+"'";
                            tags += ','+fast_cnt;
                            tags += ','+quick_cnt;
                            tags += ','+brake_cnt;
                            tags += ');" ';
                            tags += 'style="text-decoration: underline; cursor: pointer">' + score + '</td>';
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
                            getDayDrivingList();
                        });

                    }
                    else {
                        $('#tbody_day_driving_list').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
    </script>
@endsection
