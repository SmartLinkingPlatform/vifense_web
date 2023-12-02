@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">회사 정보</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
									<li class="breadcrumb-item active" aria-current="page">회사 정보</li>
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
										<h2 class="card-title" style="margin-left: 7px;">회사정보 리스트</h2>
										<div class="page-options d-flex float-right">
                                            <div class="btn btn-success" id="button_add" style="width: 80px; margin-right: 10px;">
                                                <i class="icon icon-plus"></i>
                                                 추가
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
														<th >상호</th>
                                                        <th >인증</th>
                                                        <th >Active</th>
                                                        <th >가입일시</th>
														<th >마지막 방문</th>
                                                        <th >로그</th>
														<th class="text-center" style="width: 200px;" >수정삭제</th>
													</tr>
												</thead>
												<tbody id="tbody_admin_list">
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
                <div class="modal fade" id="addAdminModal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">회사 추가</div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="row"  id="dlgErr" style="display: none; padding-left: 15px;">
                                    <div class="col">
                                        error;
                                    </div>
                                </div>
                                <div >
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">아이디</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" id="input_id" class="form-control" name="example-text-input" placeholder="아이디">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">비밀번호</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" id="input_password" class="form-control" name="example-text-input" placeholder="비밀번호">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">비밀번호 확인</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" id="input_password_confirm" class="form-control" name="example-text-input" placeholder="비밀번호 확인">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">상호</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_company" class="form-control" name="example-text-input" placeholder="상호">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">사업자등록번호</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_business_number" class="form-control" name="example-text-input" placeholder="사업자등록번호">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">주소</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_company_address" class="form-control" name="example-text-input" placeholder="주소">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">대리인</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_agent" class="form-control" name="example-text-input" placeholder="대리인">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">전화번호</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_company_phone" class="form-control" name="example-text-input" placeholder="전화번호">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">설립일자</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_create_date" class="form-control" name="example-text-input" placeholder="설립일자">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">담당자</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_person" class="form-control" name="example-text-input" placeholder="담당자">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">차량수량</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" id="input_car_count" class="form-control" name="example-text-input" placeholder="차량수량">
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-3 pl-3">
                                            <label class="form-label">사업자등록사진</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="file" name="upload_user_img" id="upload_user_img" value="" style="display: none">
                                            <div id="uploaduserimg_btn" class="btn form-control d-flex justify-content-center align-items-center" style="padding: 0 20px 0 20px" type="text" >파일 찾기</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer text-center" style="height: auto; justify-content: center;">
                                <div class="">
                                    <div class="btn btn-success text-center" id="modal_button_add" style="width: 80px;">
                                        추가
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            getAdminList();

            $('#button_add').click(function(){
                showAddDialog();
            });

            $('#modal_button_add').click(function(){
                if (current_id === 0) {
                    addAdmin();
                }
                else {
                    editAdmin();
                }
            });

            $('div[id="uploaduserimg_btn"]').on('mouseup', function () {
                $('#uploadcorporate_doc').trigger('click');
            });
            $('input[id="upload_user_img"]').change(function(){
                if (this.files && this.files[0])
                {
                    //console.log(this.files[0].name);
                    let img_file_name = this.files[0].name;
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#uploaduserimg_btn').text(img_file_name);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });
        });
        function showAddDialog() {
            current_id = 0;
            $('#addAdminModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('회사 추가');
            $('#modal_button_add').text('추가');
            $('#input_id').val('');
            $('#input_company').val('').prop('readonly', false);
            $('#input_password').val('');
            $('#input_password_confirm').val('');
            $('#input_company').val('');
            $('#input_business_number').val('');
            $('#input_company_address').val('');
            $('#input_agent').val('');
            $('#input_company_phone').val('');
            $('#input_create_date').val('');
            $('#input_person').val('');
            $('#input_car_count').val('');
            $('#input_create_date').val('');
        }
        function showEditDialog(id) {
            current_id = id;
            $('#addAdminModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('회사 정보 수정');
            $('#modal_button_add').text('수정');
            $('#input_company').prop('readonly', true);

            $.ajax({
                url: 'admin.getAdminInformation',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        let list = data.lists;
                        let id = list.id;
                        let account = list.account;
                        let password = data.pwd;
                        let name = list.name;

                        $('#input_id').val(name);
                        $('#input_company').val(account);
                        $('#input_password').val(password);
                        $('#input_password_confirm').val(password);
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function getAdminList() {
            $.ajax({
                url: 'admin.getAdminList',
                data: {
                    start: pstart,
                    count:pcount,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_admin_list').html('');
                        $('#page_nav_container').html('');
                        let lists = data.lists;
                        pstart=data.start;
                        let totalpage=data.totalpage;
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
                                tags += '<button class="btn btn-sm btn-primary badge p-3 " data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_'+user_num + '">수정<i class="fa fa-edit"></i></button>';
                                tags += '</div>';
                                tags += '<div class="btn-group align-top col-md-6 pb-1 justify-content-center">';
                                tags += '<button class="btn btn-sm btn-red badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id="button_delete_' + user_num + '">삭제<i class="fa fa-trash"></i></button>';
                                tags += '</div>';
                            tags += '</td>';
                            tags += '</tr>';
                        }
                        $('#tbody_admin_list').html(tags);

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
                            getAdminList();
                        });

                        $('button[id^="button_edit_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
                            showEditDialog(id);
                        });

                        $('button[id^="button_delete_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
                            deleteAdmin(id);
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

        function addAdmin() {
            let name = $('#input_id').val();
            let account = $('#input_company').val();
            let password = $('#input_password').val();
            let password_confirm = $('#input_password_confirm').val();
            if (account === '' || account == null) {
                $('#dlgErr').text('사용자 이름을 입력해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (name === '' || name == null) {
                $('#dlgErr').text('이름을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password === '' || password == null) {
                $('#dlgErr').text('비밀번호를 입력 해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password_confirm === '' || password_confirm == null) {
                $('#dlgErr').text('확인 비밀번호를 입력해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password !== password_confirm) {
                $('#dlgErr').text('비밀번호 오류').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.adminRegister',
                data: {
                    account:account,
                    name: name,
                    password: password,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('성공적으로 추가되었습니다').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addAdminModal").modal('hide');
                            getAdminList();
                        },1000);
                    }
                    else if (data.msg ==='du'){
                        $('#dlgErr').text('계정이 이미 존재합니다.').css({'display':'block','color':'#d41b11'});
                    }
                    else {
                        $('#dlgErr').text('오류 발생').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function editAdmin() {
            let name = $('#input_id').val();
            let account = $('#input_company').val();
            let password = $('#input_password').val();
            let password_confirm = $('#input_password_confirm').val();
            if (account === '' || account == null) {
                $('#dlgErr').text('사용자 이름을 입력해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (name === '' || name == null) {
                $('#dlgErr').text('이름을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password === '' || password == null) {
                $('#dlgErr').text('비밀번호를 입력 해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password_confirm === '' || password_confirm == null) {
                $('#dlgErr').text('확인 비밀번호를 입력해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password !== password_confirm) {
                $('#dlgErr').text('비밀번호 오류').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.editAdminInformation',
                data: {
                    id: current_id,
                    account: account,
                    name: name,
                    password: password,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('수정되었습니다.').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addAdminModal").modal('hide');
                            getAdminList();
                        },1000);
                    }
                    else {
                        $('#dlgErr').text('오류 발생').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function deleteAdmin(id) {
            if(confirm('삭제하시겠습니까？')===false)
                return;
            $.ajax({
                url: 'admin.adminDelete',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        getAdminList();
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
    </script>
@endsection
