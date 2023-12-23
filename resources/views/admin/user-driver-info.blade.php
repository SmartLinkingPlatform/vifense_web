@extends('layouts.master')
@section('css')
     <link href="{{ URL::asset('assets/css/components.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker3.standalone.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">사용자별 주행 정보</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page">사용자별 주행 정보</li>
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
                        <div class="col-md-4 pb-md-0 pb-sm-2">
                            <input type="text" id="input_search_name" class="form-control" value="{{ $search }}" placeholder="검색">
                        </div>
                        <div class="col-md-3 pb-md-0 pb-sm-2">
                            <div class="input-group justify-content-end d-flex p-2" >
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_1" value="option1" checked>
                                    <label class="form-check-label" for="inlineRadio1">일별</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">월별</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_3" value="option3">
                                    <label class="form-check-label" for="inlineRadio3">년별</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pb-md-0 pb-sm-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>

                                <input id="input_user_driver_date_1" class="form-control" placeholder="YYYY-MM-DD" type="text" style="display: block">
                                <input id="input_user_driver_date_2" class="form-control" placeholder="YYYY-MM" type="text" style="display: none">
                                <input id="input_user_driver_date_3" class="form-control" placeholder="YYYY" type="text" style="display: none">

                            </div>
                        </div>
                        <div class="col-md-2 pb-md-0 pb-sm-2 text-right">
                            <span class="col-auto pl-2">
                                <button id="button_search" class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row px-5 py-5">
                    <div class="row w-100 m-0 pl-3 pr-3 justify-content-around">
                        <div class="col-md-5 p-2" id="finded_user_name" style="border: solid 1px #cdcbcb; text-align: center;">

                        </div>
                    </div>
                </div>
                <div class="e-table px-5 pb-5">
                    <div class="table-responsive table-lg" id="user_driving_info">
                        <table class="table table-bordered mb-0 text-center">
                            <thead>
                            <tr>
                                <th >날짜</th>
                                <th >소속사</th>
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
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/js/popover.js') }}"></script>
       <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js') }}"></script>
       <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker-1.9.0-dist/locales/bootstrap-datepicker.ko.min.js') }}"></script>
    <script>
        let pstart=1;
        let pnum = pstart;
        let pcount=5;
        let numg = 5;
        let search_val = '{{$search}}';
        let search_date = '';
        let radio_idx = 1;

        let now = new Date();
        $(document).ready(function () {

            $("#input_user_driver_date_1").datepicker( {
                language: "ko",
                format: "yyyy-mm-dd",
                autoclose: true,
                orientation: "bottom auto"
            });
            $("#input_user_driver_date_2").datepicker( {
                minViewMode: 1,
                maxViewMode: 2,
                autoclose: true,
                language: "ko",
                format: "yyyy-mm",
                orientation: "bottom auto"
            });
            $("#input_user_driver_date_3").datepicker( {
                minViewMode: 2,
                maxViewMode: 2,
                autoclose: true,
                language: "ko",
                format: "yyyy",
                orientation: "bottom auto"
            });

            $('input[id^="radio_"]').click(function(){

                let oid=$(this).attr("id");
                radio_idx = oid.split('_')[1];

                $('input[id^="input_user_driver_date_"]').css("display","none");
                $('input[id^="input_user_driver_date_"]').val();

                $('input[id^="input_user_driver_date_'+radio_idx+'"]').css("display","block");

            });

            $('#finded_user_name').css({'display':'none'});
            $('#user_driving_info').css({'display':'none'});


            $('#button_search').click(function(){
                $('#user_driving_info').css({'display':'none'});
                $('#tbody_day_driving_list').html('');

                let sval = $('#input_search_name').val();
                search_val = sval.replace(/\s/g, '');
                if (parseInt(radio_idx) === 1) {
                    search_date = $('#input_user_driver_date_1').val().replace(/-/g, '');
                } else if (parseInt(radio_idx) === 2) {
                    search_date = $('#input_user_driver_date_2').val().replace(/-/g, '');
                } else {
                    search_date = $('#input_user_driver_date_3').val().replace(/-/g, '');
                }

                searchUserName();
            });

            if(search_val!=null && search_val.toString().trim().length > 0) {
                radio_idx = 1;
                let date = dataFormat();
                $('#input_user_driver_date_1').val(date);
                //let sval = $('#input_search_name').val();
                search_val = $('#input_search_name').val();
                search_date = $('#input_user_driver_date_1').val().replace(/-/g, '');
                searchUserName();
            }
        });

        function dataFormat() {
            return new Date(+new Date() + 3240 * 10000).toISOString().split("T")[0];
        }

        function showEveryUserDrivingInfo(drv_date, company, max_speed, avr_speed, mileage, drv_time, idl_time, score) {
            $('#user_driving_info').css({'display':'block'});
            let driving_date = "";
            if (parseInt(radio_idx) === 1) {
                driving_date = drv_date.substring(0, 4) + '.' + drv_date.substring(4, 6) + '.' + drv_date.substring(6, 8)
            } else if (parseInt(radio_idx) === 2) {
                driving_date = drv_date.substring(0, 4) + '.' + drv_date.substring(4, 6)
            } else {
                driving_date = drv_date.substring(0, 4)
            }

            $('#tbody_day_driving_list').html('');
            let tags = '';
            tags += '<tr>';
            tags += '<td class="text-nowrap align-middle">' + driving_date + '</td>';
            tags += '<td class="text-nowrap align-middle">' + company + '</td>';
            tags += '<td class="text-nowrap align-middle">' + max_speed + '</td>';
            tags += '<td class="text-nowrap align-middle">' + avr_speed + '</td>';
            tags += '<td class="text-nowrap align-middle">' + mileage + '</td>';
            tags += '<td class="text-nowrap align-middle">' + drv_time + '</td>';
            tags += '<td class="text-nowrap align-middle">' + idl_time + '</td>';
            tags += '<td class="text-nowrap align-middle">' + score + '</td>';
            tags += '</tr>';
            $('#tbody_day_driving_list').html(tags);
        }

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

        function searchUserName() {
            $.ajax({
                url: '/admin.everyInfo',
                headers: {'Authorization': `Bearer ${window.localStorage.authToken}`},
                data: {
                    start: pstart,
                    count:pcount,
                    search_val:search_val,
                    search_date:search_date,
                    radio_idx:radio_idx
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#finded_user_name').css({'display':'block'});
                        $('#finded_user_name').html('');

                        let lists = data.lists;
                        pstart = parseInt(data.start);
                        let totalpage = parseInt(data.totalpage);
                        let names = '';

                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let drv_date = list.drv_date;
                            let company = list.company || '';
                            let c_name = company + " " + list.name + ", ";
                            let max_speed = list.max_speed || '0';
                            let avr_speed = list.avr_speed || '0';
                            let mileage = list.mileage || '0';
                            let drv_time = getSecToTime(parseInt(list.drv_time));
                            let idl_time = getSecToTime(parseInt(list.idl_time));
                            let score = list.score || '';

                            names += "<p style='float: left;'>";
                            names += "<u onclick=\"showEveryUserDrivingInfo(";
                            names += "'" + drv_date+"',";
                            names += "'" + company+"',";
                            names += "'" + max_speed+"',";
                            names += "'" + avr_speed+"',";
                            names += "'" + mileage+"',";
                            names += "'" + drv_time+"',";
                            names += "'" + idl_time+"',";
                            names += "'" + score+"')\"";
                            names += " style='padding-right:10px; cursor: pointer'>";

                            names += c_name;
                            names += '</u></p>';
                        }
                        $('#finded_user_name').html(names);

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
                    }
                    else {
                        $('#finded_user_name').css({'display':'none'});
                        $('#finded_user_name').html('');
                        $('#tbody_day_driving_list').html('');
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
