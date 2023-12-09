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

                <!-- modal part -->
                <div class="modal fade" id="addCompanyModal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">회사 추가</div>
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
                                            <label class="form-label">상호</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_corporate_company_name" class="form-control" name="input_corporate_company_name" placeholder="상호">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_phone">
                                        Error corporate phone!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">사업자등록번호</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_corporate_phone" class="form-control" name="input_corporate_phone" placeholder="사업자등록번호">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_address">
                                        Error corporate address!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">주소</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_corporate_address" class="form-control" name="input_corporate_address" placeholder="주소">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_name">
                                        Error corporate name!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">대리인</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_corporate_name" class="form-control" name="input_corporate_name" placeholder="대리인">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_company_phone">
                                        Error company phone!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">회사 전화번호</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_company_phone" class="form-control" name="input_company_phone" placeholder="전화번호">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_create_date">
                                        Error create date!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">설립일자</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div><input id="input_create_date" name="input_create_date" class="form-control fc-datepicker" placeholder="YYYY/MM/DD" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_company_manager">
                                        Error company manager!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">담당자</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="input_company_manager" class="form-control" name="input_company_manager" placeholder="담당자">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_car_count">
                                        Error car count!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">차량수량</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" id="input_car_count" class="form-control" name="input_car_count" placeholder="차량수량">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_photo">
                                        Error corporate photo!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">사업자등록사진</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="file" name="corporate_photo" id="corporate_photo" value="" style="display: none">
                                            <input type="hidden" name="old_corporate_photo_url" id="old_corporate_photo_url" value="">
                                            <div id="corporate_photo_btn" class="btn form-control d-flex justify-content-center align-items-center" style="padding: 0 20px 0 20px" type="text" >파일 찾기</div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_uploadcorporate_doc">
                                        Error corporate doc!
                                    </div>
                                    <div class="form-group row d-flex">
                                        <div class="col-md-4 pl-3">
                                            <label class="form-label">사업자등록증사본</label>
                                        </div>
                                        <div class="col-md-8 d-flex flex-row">
                                            <input type="file" name="uploadcorporate_doc" id="uploadcorporate_doc" value="" style="display: none">
                                            <input type="hidden" name="old_uploadcorporate_doc_url" id="old_uploadcorporate_doc_url" value="">
                                            <div id="uploadcorporate_btn" class="btn form-control d-flex justify-content-center align-items-center" style="padding: 0 20px 0 20px" type="text" >파일 찾기</div>
                                            {{-- <div id="upload_corporate_doc" class="d-flex btn btn-primary align-items-center" style="width: 100px; margin-left: 10px; ">업로드</div>--}}
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
                    addCompany();
                }
                else {
                    editCompany();
                }
            });

            $('div[id="corporate_photo_btn"]').on('mouseup', function () {
                $('#corporate_photo').trigger('click');
            });
            $('input[id="corporate_photo"]').change(function(){
                if (this.files && this.files[0])
                {
                    //console.log(this.files[0].name);
                    let corporate_photo_name = this.files[0].name;
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#corporate_photo_btn').text(corporate_photo_name);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });

            $('div[id="uploadcorporate_btn"]').on('mouseup', function () {
                $('#uploadcorporate_doc').trigger('click');
            });
            $('input[id="uploadcorporate_doc"]').change(function(){
                if (this.files && this.files[0])
                {
                    //console.log(this.files[0].name);
                    let corporate_doc_name = this.files[0].name;
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#uploadcorporate_btn').text(corporate_doc_name);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });

        });
        function showAddDialog() {
            current_id = 0;
            $('#addCompanyModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('회사 추가');
            $('#modal_button_add').text('추가');
            $('#input_smart_phone').val('');
            //$('#input_password').val('').prop('readonly', false);
            $('#input_password').val('');
            $('#input_check_password').val('');
            $('#input_corporate_company_name').val('');
            $('#input_corporate_phone').val('');
            $('#input_corporate_address').val('');
            $('#input_corporate_name').val('');
            $('#input_company_phone').val('');
            $('#input_create_date').val('');
            $('#input_company_manager').val('');
            $('#input_car_count').val('');

            $('#corporate_photo').val('');
            $('#corporate_photo_btn').text('파일 찾기');
            $('#old_corporate_photo_url').val('');

            $('#uploadcorporate_doc').val('');
            $('#uploadcorporate_btn').text('파일 찾기');
            $('#old_uploadcorporate_doc_url').val('');
        }
        function showEditDialog(id) {
            current_id = id;
            $('#addCompanyModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('회사 정보 수정');
            $('#modal_button_add').text('수정');
            //$('#input_company').prop('readonly', true);

            $.ajax({
                url: 'admin.getCompanyinInfo',
                data: {
                    admin_id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        let list = data.lists;
                        let id = list.admin_id;
                        let password = data.pwd;

                        $('#input_smart_phone').val(list.user_phone);
                        $('#input_password').val(password);
                        $('#input_check_password').val(password);
                        $('#input_corporate_company_name').val(list.company_name);
                        $('#input_corporate_phone').val(list.user_regnum);
                        $('#input_corporate_address').val(list.user_address);
                        $('#input_corporate_name').val(list.user_name);
                        $('#input_company_phone').val(list.company_phone);
                        $('#input_create_date').val(list.create_date);
                        $('#input_company_manager').val(list.manager_name);
                        $('#input_car_count').val(list.car_count);

                        $('#corporate_photo').val('');
                        $('#corporate_photo_btn').text(list.user_photo);
                        $('#old_corporate_photo_url').val(list.user_photo_url);

                        $('#uploadcorporate_doc').val('');
                        $('#uploadcorporate_btn').text(list.certified_name);
                        $('#old_uploadcorporate_doc_url').val(list.certified_copy);
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
                            let order = i + 1;
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
                            tags += '<td class="text-nowrap align-middle">' + user_name + '</td>';
                            tags += '<td class="text-nowrap align-middle">';
                            tags += '<div class="d-flex justify-content-center">';
                            tags += '<input aria-disabled="true" type="checkbox" value="'+certifice_status+'" id="certiChecked_'+admin_id+'" '+cert_check+' >';
                            tags += '</div>';
                            tags += '</td>';

                            tags += '<td class="text-nowrap align-middle">';
                            tags += '<div class="d-flex justify-content-center">';
                            tags += '<input  type="checkbox" value="'+active+'" id="actiChecked_'+admin_id+'" '+act_check+' >';
                            tags += '</div>';
                            tags += '</td>';

                            tags += '<td class="text-nowrap align-middle">' + create_date + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + update_date + '</td>';
                            tags += '<td class="text-nowrap align-middle"> 로그 </td>';
                            tags += '<td class="text-center align-middle">';
                                tags += '<div class="btn-group align-top pr-3 col-md-6 pb-1 justify-content-center">';
                                tags += '<button class="btn btn-sm btn-primary badge p-3 " data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_'+admin_id + '">수정<i class="fa fa-edit"></i></button>';
                                tags += '</div>';
                                tags += '<div class="btn-group align-top col-md-6 pb-1 justify-content-center">';
                                tags += '<button class="btn btn-sm btn-red badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id="button_delete_' + admin_id + '">삭제<i class="fa fa-trash"></i></button>';
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
                            let id = oid.split('_')[2];
                            showEditDialog(id);
                        });

                        $('button[id^="button_delete_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
                            deleteCompany(id);
                        });

                        $('input[id^="actiChecked_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[1];
                            let cks = $('#actiChecked_' + id).prop('checked');
                            let act = cks ? 1 : 0;
                            //console.log(act);
                            activeCompany(id, act);
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

        function addCompany() {
            let smart_phone = $('#input_smart_phone').val().replace(/ /g, '');
            smart_phone = smart_phone.replace(/-/g, '');
            smart_phone = smart_phone.replace(/_/g, '');
            let password = $('#input_password').val().replace(/ /g, '');
            let check_password = $('#input_check_password').val().replace(/ /g, '');
            let corporate_company_name = $('#input_corporate_company_name').val().replace(/ /g, '');
            let corporate_phone = $('#input_corporate_phone').val().replace(/ /g, '');
            let corporate_address = $('#input_corporate_address').val().replace(/ /g, '');
            let corporate_name = $('#input_corporate_name').val().replace(/ /g, '');
            let company_phone = $('#input_company_phone').val().replace(/ /g, '');
            let create_date = $('#input_create_date').val().replace(/ /g, '');
            let company_manager = $('#input_company_manager').val().replace(/ /g, '');
            let car_count = $('#input_car_count').val().replace(/ /g, '');

            if(smart_phone === ""){
                $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','none');
                    $('#text_smart_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(!isNumeric(smart_phone))
            {
                $('#valid_smart_phone').text("휴대폰 번호를 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_smart_phone').text("휴대폰 번호를 입력해주세요").css('display','none');
                    $('#text_smart_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
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

            if(corporate_company_name === "") {
                $('#valid_corporate_company_name').text("상호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_company_name').text("상호를 입력 해주세요").css('display','none');
                    $('#text_corporate_company_name').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(corporate_phone === "") {
                $('#valid_corporate_phone').text("사업자 등록번호 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_phone').text("사업자 등록번호 입력 해주세요").css('display','none');
                    $('#text_corporate_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(corporate_address === "") {
                $('#valid_corporate_address').text("주소를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_address').text("주소를 입력 해주세요").css('display','none');
                    $('#text_corporate_address').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(corporate_name === "") {
                $('#valid_corporate_name').text("대표자 성명을 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_name').text("대표자 성명을 입력 해주세요").css('display','none');
                    $('#text_corporate_name').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(company_phone === "") {
                $('#valid_company_phone').text("회사 전화번호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_company_phone').text("회사 전화번호를 입력 해주세요").css('display','none');
                    $('#text_company_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(create_date === "") {
                $('#valid_create_date').text("설립일자를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_create_date').text("설립일자를 입력 해주세요").css('display','none');
                    $('#text_create_date').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(company_manager === "") {
                $('#valid_company_manager').text("담당자를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_company_manager').text("담당자를 입력 해주세요").css('display','none');
                    $('#text_company_manager').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(!isNumeric(car_count)){
                $('#valid_car_count').text("차량 수량을 정확히 숫자로 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_car_count').text("차량 수량을 정확히 숫자로 입력 해주세요").css('display','none');
                    $('#text_car_count').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(parseInt(car_count) <= 0){
                $('#valid_car_count').text("차량 수량을 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_car_count').text("차량 수량을 입력 해주세요").css('display','none');
                    $('#text_car_count').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            let corporate_photo_file =  $('#corporate_photo').prop('files')[0];
            let corporate_doc_file =  $('#uploadcorporate_doc').prop('files')[0];

            let form_data = new FormData();
            form_data.append('smart_phone', smart_phone);
            form_data.append('password', password);
            form_data.append('corporate_company_name', corporate_company_name);
            form_data.append('corporate_phone', corporate_phone);
            form_data.append('corporate_address', corporate_address);
            form_data.append('corporate_name', corporate_name);
            form_data.append('company_phone', company_phone);
            form_data.append('create_date', create_date);
            form_data.append('company_manager', company_manager);
            form_data.append('car_count', car_count);
            form_data.append('corporate_photo_file', corporate_photo_file);
            form_data.append('corporate_doc_file', corporate_doc_file);

            $.ajax({
                url: 'admin.addNewCompany',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('성공적으로 추가되었습니다').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addCompanyModal").modal('hide');
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

        function editCompany() {
            let smart_phone = $('#input_smart_phone').val().replace(/ /g, '');
            smart_phone = smart_phone.replace(/-/g, '');
            smart_phone = smart_phone.replace(/_/g, '');
            let password = $('#input_password').val().replace(/ /g, '');
            let check_password = $('#input_check_password').val().replace(/ /g, '');
            let corporate_company_name = $('#input_corporate_company_name').val().replace(/ /g, '');
            let corporate_phone = $('#input_corporate_phone').val().replace(/ /g, '');
            let corporate_address = $('#input_corporate_address').val().replace(/ /g, '');
            let corporate_name = $('#input_corporate_name').val().replace(/ /g, '');
            let company_phone = $('#input_company_phone').val().replace(/ /g, '');
            let create_date = $('#input_create_date').val().replace(/ /g, '');
            let company_manager = $('#input_company_manager').val().replace(/ /g, '');
            let car_count = $('#input_car_count').val().replace(/ /g, '');

            if(smart_phone === ""){
                $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_smart_phone').text("사용자 아이디를 입력해주세요").css('display','none');
                    $('#text_smart_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(!isNumeric(smart_phone))
            {
                $('#valid_smart_phone').text("휴대폰 번호를 입력해주세요").css('display','block');
                setTimeout(function () {
                    $('#valid_smart_phone').text("휴대폰 번호를 입력해주세요").css('display','none');
                    $('#text_smart_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
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

            if(corporate_company_name === "") {
                $('#valid_corporate_company_name').text("상호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_company_name').text("상호를 입력 해주세요").css('display','none');
                    $('#text_corporate_company_name').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(corporate_phone === "") {
                $('#valid_corporate_phone').text("사업자 등록번호 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_phone').text("사업자 등록번호 입력 해주세요").css('display','none');
                    $('#text_corporate_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(corporate_address === "") {
                $('#valid_corporate_address').text("주소를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_address').text("주소를 입력 해주세요").css('display','none');
                    $('#text_corporate_address').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(corporate_name === "") {
                $('#valid_corporate_name').text("대표자 성명을 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_corporate_name').text("대표자 성명을 입력 해주세요").css('display','none');
                    $('#text_corporate_name').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(company_phone === "") {
                $('#valid_company_phone').text("회사 전화번호를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_company_phone').text("회사 전화번호를 입력 해주세요").css('display','none');
                    $('#text_company_phone').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(create_date === "") {
                $('#valid_create_date').text("설립일자를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_create_date').text("설립일자를 입력 해주세요").css('display','none');
                    $('#text_create_date').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(company_manager === "") {
                $('#valid_company_manager').text("담당자를 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_company_manager').text("담당자를 입력 해주세요").css('display','none');
                    $('#text_company_manager').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(!isNumeric(car_count)){
                $('#valid_car_count').text("차량 수량을 정확히 숫자로 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_car_count').text("차량 수량을 정확히 숫자로 입력 해주세요").css('display','none');
                    $('#text_car_count').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            if(parseInt(car_count) <= 0){
                $('#valid_car_count').text("차량 수량을 입력 해주세요").css('display', 'block');
                setTimeout(function () {
                    $('#valid_car_count').text("차량 수량을 입력 해주세요").css('display','none');
                    $('#text_car_count').css('margin-bottom','1.5rem');
                },1000);
                return;
            }

            let corporate_photo_file =  $('#corporate_photo').prop('files')[0];
            let corporate_doc_file =  $('#uploadcorporate_doc').prop('files')[0];

            let form_data = new FormData();
            form_data.append('admin_id', current_id);
            form_data.append('smart_phone', smart_phone);
            form_data.append('password', password);
            form_data.append('corporate_company_name', corporate_company_name);
            form_data.append('corporate_phone', corporate_phone);
            form_data.append('corporate_address', corporate_address);
            form_data.append('corporate_name', corporate_name);
            form_data.append('company_phone', company_phone);
            form_data.append('create_date', create_date);
            form_data.append('company_manager', company_manager);
            form_data.append('car_count', car_count);

            form_data.append('corporate_photo_file', corporate_photo_file);
            let old_corporate_photo_url = $('#old_corporate_photo_url').val();
            form_data.append('old_corporate_photo_url', old_corporate_photo_url);

            form_data.append('corporate_doc_file', corporate_doc_file);
            let old_uploadcorporate_doc_url = $('#old_uploadcorporate_doc_url').val();
            form_data.append('old_uploadcorporate_doc_url', old_uploadcorporate_doc_url);

            $.ajax({
                url: 'admin.editCompanyInfo',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('수정되었습니다.').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addCompanyModal").modal('hide');
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

        function deleteCompany(id) {
            if(confirm('삭제하시겠습니까？')===false)
                return;
            $.ajax({
                url: 'admin.companyDelete',
                data: {
                    admin_id:id,
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

        function activeCompany(id, status) {
            $.ajax({
                url: 'admin.companyActive',
                data: {
                    admin_id:id,
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
