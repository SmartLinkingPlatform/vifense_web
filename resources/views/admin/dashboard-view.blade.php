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
                                        <p class="card-text">총 30명</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">일 신규 유저</h5>
                                        <p class="card-text">10명</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">일 사용 유저</h5>
                                        <p class="card-text">5명</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">총 회사수</h5>
                                        <p class="card-text">15</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">기타 유저</h5>
                                        <p class="card-text">50명</p>
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
            // getAdminList();

            function getAdminList() {
                $.ajax({
                    url: 'admin.getAdminList',
                    data: {
                        start: pstart,
                        count: pcount,
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            $('#tbody_admin_list').html('');
                            $('#page_nav_container').html('');
                            let lists = data.lists;
                            pstart = data.start;
                            let totalpage = data.totalpage;
                            let tags = '';
                            for (let i = 0; i < lists.length; i++) {
                                let list = lists[i];
                                let user_num = list.user_num;
                                let order = i + 1;
                                let user_id = list.user_id;
                                let company_name = list.company_name || '';
                                let certifice_status = list.certifice_status || '';
                                let active = list.active || '';
                                let registe_date = list.registe_date || '';
                                let visit_date = list.visit_date || '';
                                //let create_date = list.created_at;
                                //let dateString = create_date.split(' ')[0];
                                //let temp = dateString.split('-');
                                //let create_string = temp[1] + '/' + temp[2] + '/' + temp[0];

                                tags += '<tr>';
                                tags += '<td class="text-nowrap align-middle">' + order + '</td>';
                                tags += '<td class="text-nowrap align-middle">' + user_id + '</td>';
                                tags += '<td class="text-nowrap align-middle">' + company_name + '</td>';
                                tags += '<td class="text-nowrap align-middle">' + certifice_status + '</td>';
                                tags += '<td class="text-nowrap align-middle">' + active + '</td>';
                                tags += '<td class="text-nowrap align-middle">' + registe_date + '</td>';
                                tags += '<td class="text-nowrap align-middle">' + visit_date + '</td>';
                                tags += '<td class="text-nowrap align-middle"> 로그 </td>';
                                tags += '<td class="text-center align-middle">';
                                tags += '<div class="btn-group align-top pr-3 col-md-6 pb-1 justify-content-center">';
                                tags += '<button class="btn btn-sm btn-primary badge p-3 " data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_' + user_num + '">수정<i class="fa fa-edit"></i></button>';
                                tags += '</div>';
                                tags += '<div class="btn-group align-top col-md-6 pb-1 justify-content-center">';
                                tags += '<button class="btn btn-sm btn-red badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id="button_delete_' + user_num + '">삭제<i class="fa fa-trash"></i></button>';
                                tags += '</div>';
                                tags += '</td>';
                                tags += '</tr>';
                            }
                            $('#tbody_admin_list').html(tags);

                            let nav_tag = '';
                            nav_tag += '<nav aria-label="..." class="mb-4">';
                            nav_tag += '<ul class="pagination float-right">';

                            let disble = "";
                            if (pstart === 1)
                                disble = "disabled"

                            let prenum = parseInt(pstart) - 1;

                            nav_tag += '<li class="page-item  ' + disble + ' ">';
                            nav_tag += '<a class="page-link" href="#"  id="page_nav_number_' + prenum + '" >';
                            nav_tag += '<i class="ti-angle-left"></i>';
                            nav_tag += '</a>';
                            nav_tag += '</li>';

                            pnum = pstart <= numg ? 1 : parseInt(pstart) - 1;

                            for (let idx = 0; idx < numg; idx++) {
                                let actv = "";
                                let aria_current = '';
                                let spantag = '';
                                let oid = '';

                                if (pnum === pstart) {
                                    actv = 'active';
                                    aria_current = 'aria-current="page"';
                                    spantag = '<span class="sr-only">(current)</span>';
                                } else
                                    oid = "page_nav_number_" + pnum;

                                nav_tag += '<li class="page-item ' + actv + '"  ' + aria_current + '>';
                                nav_tag += '<a class="page-link" id="' + oid + '"  href="#" >' + pnum + '  ' + spantag + '</a>';
                                nav_tag += '</li>';

                                if (pnum === totalpage) break;
                                pnum = pnum + 1;
                            }
                            let nextnum = parseInt(pstart) + 1;

                            let edisble = "";
                            if (pstart === totalpage)
                                edisble = "disabled";

                            nav_tag += '<li class="page-item ' + edisble + ' ">';
                            nav_tag += '<a class="page-link" id="page_nav_number_' + nextnum + '" href="#">';
                            nav_tag += '<i class="ti-angle-right"></i>';
                            nav_tag += '</a>';
                            nav_tag += '</li>';

                            nav_tag += '</ul>';
                            nav_tag += '</nav>';

                            $('#page_nav_container').html(nav_tag);

                            /* events { */
                            $('a[id^="page_nav_number_"]').click(function () {
                                let oid = $(this).attr("id");
                                pstart = oid.split('_')[3];
                                getAdminList();
                            });

                            $('button[id^="button_edit_"]').click(function () {
                                let oid = $(this).attr("id");
                                let id = oid.split('_')[2];
                                showEditDialog(id);
                            });

                            $('button[id^="button_delete_"]').click(function () {
                                let oid = $(this).attr("id");
                                let id = oid.split('_')[2];
                                deleteAdmin(id);
                            });

                        } else {
                            $('#tbody_admin_list').html('');
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
