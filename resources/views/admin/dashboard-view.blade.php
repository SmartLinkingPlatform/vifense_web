@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">데쉬보드</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
									<li class="breadcrumb-item active" aria-current="page">데쉬보드</li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')
						<!-- ROW OPEN -->
						<div class="row row-cards-dash">
							<div class="col-lg-12 col-xl-12 flex-wrap">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">총 유저수</h5>
                                        <p class="card-text" id="total_users"></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">일 신규 유저</h5>
                                        <p class="card-text" id="day_new_users"></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">일 사용 유저</h5>
                                        <p class="card-text" id="day_visit_users"></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">총 회사수</h5>
                                        <p class="card-text" id="total_companys"></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">기타</h5>
                                        <p class="card-text" id="other_users"></p>
                                    </div>
                                </div>


							</div> <!-- COL-END -->

						</div>
						<!-- ROW CLOSED -->
					</div>
				</div>
				<!-- CONTAINER CLOSED -->

			</div>
@endsection
@section('js')
    <script>
        let current_id = 0;
        let pstart=1;
        let pnum = pstart;
        let pcount=5;
        let numg = 5;
        $(document).ready(function () {
            getDashboardInfo();

            function getDashboardInfo() {
                $.ajax({
                    url: 'admin.getDashboardInfo',
                    type: 'POST',
                    success: function (data) {
                        $('#total_users').text('');
                        $('#day_new_users').text('');
                        $('#day_visit_users').text('');
                        $('#total_companys').text('');
                        $('#other_users').text('');

                        console.log(data.msg);
                        if (data.msg === "ok") {
                            $('#total_users').text(data.total_users);
                            $('#day_new_users').text(data.new_users);
                            $('#day_visit_users').text(data.visit_users);
                            $('#total_companys').text(data.total_companys);
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            }

        });

    </script>
@endsection
