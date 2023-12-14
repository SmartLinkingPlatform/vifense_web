@extends('layouts.master')
@section('css')
  <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">개인 정보</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
									<li class="breadcrumb-item active" aria-current="page">개인 정보</li>
								</ol>
							</div>

                            <div class="row header-search-block">
                                <div class="col-sm-8">
                                    <input type="text" id="input_search" class="form-control" name="input_search" placeholder="아이디/성명">
                                </div>
                                <div class="col-sm-4 pl-3 header-search-block-btn">
                                    <div class="btn btn-custom" id="button_search" style="width: 80px; border: 1px solid #e3e3e3">
                                        <i class="icon fa fa-search"></i>
                                        검색
                                    </div>
                                </div>
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
										<h2 class="card-title" style="margin-left: 7px;">개인정보 리스트</h2>
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
														<th >소속사</th>
                                                        <th >성명</th>
                                                        <th >인증</th>
                                                        <th >Active</th>
                                                        <th >가입일시</th>
														<th >마지막 업로드</th>
                                                        <th >로그</th>
														<th class="text-center" style="width: 200px;" >수정삭제</th>
													</tr>
												</thead>
												<tbody id="tbody_person_list">
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
                <!-- user info modal part -->
                <div class="modal fade" id="showUserInfoModal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <div id="user_modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">개인 정보 보기</div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div >
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">생년월일</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div id="info_user_birthday" class="form-control"></div>
                                        </div>
                                    </div>

                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">이메일</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div id="info_user_email" class="form-control"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal part -->
                <div class="modal fade" id="addUserModal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">개인 추가</div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="col"  id="dlgErr" style="display: none;"></div>
                                <div >
                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_smart_phone">
                                        Error id!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">아이디</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_smart_phone" class="form-control" name="input_smart_phone" placeholder="폰 번호">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_user_name">
                                        Error password!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">성명</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_user_name" class="form-control" name="input_user_name" placeholder="성명">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_user_email">
                                        Error check email!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">이메일</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_user_email" class="form-control" name="input_user_email" placeholder="이메일">
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_password">
                                        Error password!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">비밀번호</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" id="input_password" class="form-control" name="input_password" placeholder="비밀번호">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_check_password">
                                        Error check password!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">비밀번호 확인</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" id="input_check_password" class="form-control" name="input_check_password" placeholder="비밀번호 확인">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_company_name">
                                        Error corporate company!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">소속사</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="company_name" id="company_name">

                                            </select>
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
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/popover.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/my-common.js') }}"></script>

    <script>
        let current_id = 0;
        let pstart=1;
        let pnum = pstart;
        let pcount=5;
        let numg = 5;
        let search_val = '';
        $(document).ready(function () {
            $( "#input_create_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            getUserList();

            $('#button_search').click(function(){
               let sval = $('#input_search').val();
                search_val = sval.replace(/\s/g, '');
                getUserList();
            });

            $('#button_add').click(function(){
                showAddDialog();
            });

            $('#modal_button_add').click(function(){
                if (current_id === 0) {
                    addUser();
                }
                else {
                    editUser();
                }
            });

        });
        function showAddDialog() {
            $.ajax({
                url: 'admin.getCompanyName',
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#company_name').html('');
                        let tags = '';
                        let lists = data.lists;
                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            tags += '<option value="'+list.admin_id+'">'+list.company_name+'</option>';
                        }
                        $('#company_name').html(tags);
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });

            current_id = 0;
            $('#addUserModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('개인 추가');
            $('#modal_button_add').text('추가');
            $('#input_smart_phone').val('');
            $('#input_user_name').val('');
            $('#input_user_email').val('');
            $('#input_password').val('');
            $('#input_check_password').val('');
            $('#company_name').val('');
        }
        function showEditDialog(admin_id, userid) {
            current_id = userid;
            $('#addUserModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('개인 정보 수정');
            $('#modal_button_add').text('수정');

            $.ajax({
                url: 'admin.getUserinInfo',
                data: {
                    user_id:userid
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        let c_list = data.c_list;
                        let user_phone = data.user_phone;
                        let user_name = data.user_name;
                        let user_email = data.user_email;
                        let user_pwd = data.user_pwd;

                        $('#input_smart_phone').val(user_phone);
                        $('#input_user_name').val(user_name);
                        $('#input_user_email').val(user_email);
                        $('#input_password').val(user_pwd);
                        $('#input_check_password').val(user_pwd);

                        $('#company_name').html('');
                        let tags = '';
                        for (let i = 0; i < c_list.length; i++) {
                            let list = c_list[i];
                            if (parseInt(admin_id) == parseInt(list.admin_id)) {
                                tags += '<option value="'+list.admin_id+'" selected>'+list.company_name+'</option>';
                            } else {
                                tags += '<option value="'+list.admin_id+'">'+list.company_name+'</option>';
                            }
                        }
                        $('#company_name').html(tags);
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
        function showUserInfoDialog(userid) {
            $('#showUserInfoModal').modal('show');
            $('#user_modal_title').text('개인 정보 보기');
            $('#info_user_birthday').text('');
            $('#info_user_email').text('');
            $.ajax({
                url: 'admin.showUserInfo',
                data: {
                    user_id:userid
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#info_user_birthday').text(data.user_birthday);
                        $('#info_user_email').text(data.user_email);
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function getUserList() {
            $.ajax({
                url: 'admin.getUserList',
                data: {
                    start: pstart,
                    count:pcount,
                    search_val:search_val,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_person_list').html('');
                        $('#page_nav_container').html('');
                        let lists = data.lists;
                        pstart=data.start;
                        let totalpage=data.totalpage;
                        let tags = '';
                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let admin_id = list.admin_id;
                            let user_id = list.user_id;
                            let order = i + (pstart - 1) * pcount + 1;
                            let user_phone = list.user_phone;
                            let company_name = list.company_name || '';
                            let user_name = list.user_name;
                            let certifice_status = list.certifice_status || '0';
                            let active = list.active || '0';
                            let create_date = list.create_date || '';
                            let update_date = list.update_date || '';
                            let cert_check = parseInt(certifice_status) > 0 ? 'checked' : '';
                            let act_check = parseInt(active) > 0 ? 'checked' : '';
                            //let create_date = list.create_date;
                            //let dateString = create_date.split(' ')[0];
                            //let temp = dateString.split('-');
                            //let create_string = temp[1] + '/' + temp[2] + '/' + temp[0];
                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle">' + order + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + user_phone + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + company_name + '</td>';
                            tags += '<td class="text-nowrap align-middle" onclick="showUserInfoDialog('+user_id+');" style="text-decoration: underline; cursor: pointer">' + user_name + '</td>';
                            tags += '<td class="text-nowrap align-middle">';
                            tags += '<div class="d-flex justify-content-center">';
                            tags += '<input type="checkbox" value="'+certifice_status+'" id="certiChecked_'+user_id+'" '+cert_check+' >';
                            tags += '</div>';
                            tags += '</td>';

                            tags += '<td class="text-nowrap align-middle">';
                            tags += '<div class="d-flex justify-content-center">';
                            tags += '<input  type="checkbox" value="'+active+'" id="actiChecked_'+user_id+'" '+act_check+' >';
                            tags += '</div>';
                            tags += '</td>';

                            tags += '<td class="text-nowrap align-middle">' + create_date + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + update_date + '</td>';
                            tags += '<td class="text-nowrap align-middle"> 로그 </td>';
                            tags += '<td class="text-center align-middle">';
                                tags += '<div class="btn-group align-top pr-3 col-md-6 pb-1 justify-content-center">';
                                tags += '<button class="btn btn-sm btn-primary badge p-3 " data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_'+admin_id+'_'+user_id + '">수정<i class="fa fa-edit"></i></button>';
                                tags += '</div>';
                                tags += '<div class="btn-group align-top col-md-6 pb-1 justify-content-center">';
                                tags += '<button class="btn btn-sm btn-red badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id="button_delete_' + user_id + '">삭제<i class="fa fa-trash"></i></button>';
                                tags += '</div>';
                            tags += '</td>';
                            tags += '</tr>';
                        }
                        $('#tbody_person_list').html(tags);

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
                            getUserList();
                        });

                        $('button[id^="button_edit_"]').click(function(){
                            let oid = $(this).attr("id");
                            let admin_id = oid.split('_')[2];
                            let user_id = oid.split('_')[3];
                            showEditDialog(admin_id, user_id);
                        });

                        $('button[id^="button_delete_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
                            deleteUser(id);
                        });

                        $('input[id^="actiChecked_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[1];
                            let cks = $('#actiChecked_' + id).prop('checked');
                            let act = cks ? 1 : 0;
                            activeUser(id, act);
                        });

                        $('input[id^="certiChecked_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[1];
                            let cks = $('#certiChecked_' + id).prop('checked');
                            let act = cks ? 1 : 0;
                            certifyUser(id, act);
                        });

                    }
                    else {
                        $('#tbody_person_list').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function addUser() {
            let smart_phone = $('#input_smart_phone').val().replace(/ /g, '');
            smart_phone = smart_phone.replace(/-/g, '');
            smart_phone = smart_phone.replace(/_/g, '');
            let user_name = $('#input_user_name').val();
            let user_email = $('#input_user_email').val().replace(/ /g, '');
            let password = $('#input_password').val().replace(/ /g, '');
            let check_password = $('#input_check_password').val().replace(/ /g, '');
            let admin_id = $('#company_name').val();

            if(smart_phone === ""){
                $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','none');
                    $('#text_smart_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(user_name === ""){
                $('#valid_user_name').text("사용자 이름을 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_user_name').text("사용자 이름을 입력해주세요").css('display','none');
                    $('#text_user_name').css('margin-bottom','1.5rem');
                },1000);
                return;
            }
            if(user_email !== "") {
                if (!user_email.includes('@') || !user_email.endsWith('.com')) {
                    $('#valid_user_email').text("이메일 형식이 맞지 않습니다.").css('display', 'block');
                    setTimeout(function () {
                        $('#valid_user_email').text("이메일 형식이 맞지 않습니다.").css('display', 'none');
                        $('#text_user_email').css('margin-bottom', '1.5rem');
                    }, 1000);
                    return;
                }
            }

            if(password === "") {
                $('#valid_password').text("비밀번호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_password').text("비밀번호를 입력 해주세요").css('display','none');
                    $('#text_password').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(check_password === "") {
                $('#valid_check_password').text("확인 비밀번호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_check_password').text("확인 비밀번호를 입력 해주세요").css('display','none');
                    $('#text_check_password').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(password !== check_password){
                $('#valid_check_password').text("비밀번호가 서로 다릅니다.").css('display', 'block');
                setTimeout(function () {
                    $('#valid_check_password').text("비밀번호가 서로 다릅니다.").css('display','none');
                    $('#text_check_password').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            let form_data = new FormData();
            form_data.append('smart_phone', smart_phone);
            form_data.append('user_name', user_name);
            form_data.append('user_email', user_email);
            form_data.append('password', password);
            form_data.append('admin_id', admin_id);

            $.ajax({
                url: 'admin.addNewUserInfo',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('성공적으로 추가되었습니다').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addUserModal").modal('hide');
                            getUserList();
                        },1000);
                    }
                    else if (data.msg ==='du'){
                        $('#dlgErr').text('계정이 이미 존재합니다.').css({'display':'block','color':'#d41b11'});

                    }
                    else {
                        $('#dlgErr').text('오류 발생').css({'display':'block','color':'#d41b11'});
                    }

                    setTimeout(function () {
                        $('#dlgErr').text('').css({'display':'none','color':'#1a1a1a'});
                    },900);
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function editUser() {
            let smart_phone = $('#input_smart_phone').val().replace(/ /g, '');
            smart_phone = smart_phone.replace(/-/g, '');
            smart_phone = smart_phone.replace(/_/g, '');
            let user_name = $('#input_user_name').val();
            let user_email = $('#input_user_email').val().replace(/ /g, '');
            let password = $('#input_password').val().replace(/ /g, '');
            let check_password = $('#input_check_password').val().replace(/ /g, '');
            let admin_id = $('#company_name').val();

            if(smart_phone === ""){
                $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','none');
                    $('#text_smart_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(user_name === ""){
                $('#valid_user_name').text("사용자 이름을 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_user_name').text("사용자 이름을 입력해주세요").css('display','none');
                    $('#text_user_name').css('margin-bottom','1.5rem');
                },1000);
                return;
            }
            if(user_email !== "") {
                if (!user_email.includes('@') || !user_email.endsWith('.com')) {
                    $('#valid_user_email').text("이메일 형식이 맞지 않습니다.").css('display', 'block');
                    setTimeout(function () {
                        $('#valid_user_email').text("이메일 형식이 맞지 않습니다.").css('display', 'none');
                        $('#text_user_email').css('margin-bottom', '1.5rem');
                    }, 1000);
                    return;
                }
            }

            if(password === "") {
                $('#valid_password').text("비밀번호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_password').text("비밀번호를 입력 해주세요").css('display','none');
                    $('#text_password').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(check_password === "") {
                $('#valid_check_password').text("확인 비밀번호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_check_password').text("확인 비밀번호를 입력 해주세요").css('display','none');
                    $('#text_check_password').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(password !== check_password){
                $('#valid_check_password').text("비밀번호가 서로 다릅니다.").css('display', 'block');
                setTimeout(function () {
                    $('#valid_check_password').text("비밀번호가 서로 다릅니다.").css('display','none');
                    $('#text_check_password').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            let form_data = new FormData();
            form_data.append('smart_phone', smart_phone);
            form_data.append('user_name', user_name);
            form_data.append('user_email', user_email);
            form_data.append('password', password);
            form_data.append('admin_id', admin_id);
            form_data.append('user_id', current_id);

            $.ajax({
                url: 'admin.editUserInfo',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('수정되었습니다.').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addUserModal").modal('hide');
                            getUserList();
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

        function deleteUser(id) {
            if(confirm('삭제하시겠습니까？')===false)
                return;
            $.ajax({
                url: 'admin.userDelete',
                data: {
                    user_id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        getUserList();
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function certifyUser(id, status) {
            $.ajax({
                url: 'admin.userCertify',
                data: {
                    user_id:id,
                    certify : status
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                    }
                    else{
                        console.log("error certification");
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function activeUser(id, status) {
            $.ajax({
                url: 'admin.userActive',
                data: {
                    user_id:id,
                    active : status
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                    }
                    else{
                        console.log("error active");
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
    </script>
    <style>
        #ui-datepicker-div {
            z-index: 1600 !important; /* has to be larger than 1050 */
        }
        input[type="checkbox"][aria-disabled="true"] {
            background-color: blue !important;
            pointer-events: none;
        }
    </style>
@endsection
