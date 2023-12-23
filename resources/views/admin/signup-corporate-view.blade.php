@extends('layouts.master2')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet">
@endsection
@section('content')
		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="{{URL::asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
			</div>
			<!-- /GLOABAL LOADER -->

			<!-- PAGE -->
			<div class="page" style="margin-top:calc(100vh/2 - 48vh);">
				<div class="">
				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto">
						<div class="text-center">
							<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img" alt="">
						</div>
					</div>
					<div class="container-login100">
						<div class="wrap-login100 p-6">
							<form class="login100-form signup-corporate validate-form">

								<span class="login100-form-title">
                                    법인회원 가입
								</span>
                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_smart_phone">
                                    Error smart phone!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">아이디</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_smart_phone" id="input_smart_phone" placeholder="휴대폰 번호">
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
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="password" name="input_password" id="input_password" placeholder="비밀번호">
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
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="password" name="input_check_password" id="input_check_password" placeholder="비밀번호 확인">
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
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_corporate_company_name" id="input_corporate_company_name" placeholder="ABC 주식회사">
                                    </div>
                                </div>

                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_phone">
                                    Error corporate phone!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">사업자 등록번호</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_corporate_phone" id="input_corporate_phone" placeholder="888-88-88888">
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
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_corporate_address" id="input_corporate_address" placeholder="주소">
                                    </div>
                                </div>

                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_name">
                                    Error corporate name!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">대표자 성명</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_corporate_name" id="input_corporate_name" placeholder="대표자 성명">
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
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_company_phone" id="input_company_phone" placeholder="회사 전화번호">
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
                                       {{-- <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_create_date" id="input_create_date" placeholder="설립일자">--}}
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
                                        <input class="form-control" style="padding: 0 22px 0 22px" type="text" name="input_company_manager" id="input_company_manager" placeholder="담당자">
                                    </div>
                                </div>

                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_car_count">
                                    Error car count!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">차량 수량</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" style="padding: 0 10px 0 22px" type="number" name="input_car_count" id="input_car_count" placeholder="차량 수량">
                                    </div>
                                </div>

                                {{--<div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_photo">
                                    Error corporate photo!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">사업자 등록사진</label>
                                    </div>
                                    <div class="col-md-8  d-flex flex-row">
                                        <input type="file" name="corporate_photo" id="corporate_photo" value="" style="display: none">
                                        <div id="corporate_photo_btn" class="btn form-control d-flex justify-content-center align-items-center" style="padding: 0 20px 0 20px" type="text" >파일 찾기</div>
                                    </div>
                                </div>--}}

                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_uploadcorporate_doc">
                                    Error corporate doc!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">사업자 등록증사본</label>
                                    </div>
                                    <div class="col-md-8 d-flex flex-row">
                                        <input type="file" name="uploadcorporate_doc" id="uploadcorporate_doc" value="" style="display: none">
                                        <div id="uploadcorporate_btn" class="btn form-control d-flex justify-content-center align-items-center" style="padding: 0 20px 0 20px" type="text" >파일 찾기</div>
                                       {{-- <div id="upload_corporate_doc" class="d-flex btn btn-primary align-items-center" style="width: 100px; margin-left: 10px; ">업로드</div>--}}
                                    </div>
                                </div>

								<div class="container-login100-form-btn mb-4" style="cursor: pointer;">
									<div id="button_corporate_signup" class="login100-form-btn btn-primary">
                                        가&nbsp;&nbsp;&nbsp;입&nbsp;&nbsp;&nbsp;신&nbsp;&nbsp;청
									</div>
								</div>

							</form>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
			<!-- End PAGE -->

		</div>
		<!-- BACKGROUND-IMAGE CLOSED -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script> --}}
    <script src="{{ URL::asset('assets/js/popover.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    {{-- <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script> --}}
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/my-common.js') }}"></script>

    <script>

        $(document).ready(function () {

            $( "#input_create_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

            /*$('div[id="corporate_photo_btn"]').on('mouseup', function () {
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
            });*/

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

            $('#button_corporate_signup').click(function () {
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
                //let corporate_photo_file =  $('#corporate_photo').prop('files')[0];
                let corporate_doc_file =  $('#uploadcorporate_doc').prop('files')[0];

                let form_data = new FormData();
                form_data.append('user_phone', smart_phone);
                form_data.append('user_pwd', password);
                form_data.append('corporate_company_name', corporate_company_name);
                form_data.append('corporate_phone', corporate_phone);
                form_data.append('corporate_address', corporate_address);
                form_data.append('corporate_name', corporate_name);
                form_data.append('company_phone', company_phone);
                form_data.append('create_date', create_date);
                form_data.append('company_manager', company_manager);
                form_data.append('car_count', car_count);
                //form_data.append('corporate_photo_file', corporate_photo_file);
                form_data.append('corporate_doc_file', corporate_doc_file);

                $.ajax({
                    url: 'admin.register',
                    //url: 'admin.corporateSignup',
                    // dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            window.location.href = 'admin';
                        }else if (data.msg === 'err') {
                            //const message = '회원가입에 실패하였습니다.';
                            //alert(message);
                            let errdata = data.cont;
                            if(Array.isArray(errdata)){
                                let phone = errdata['user_phone'];
                                let pwd = errdata['user_pwd'];
                                console.log("err >>>", phone ? phone[0] : pwd ? pwd[0] : ' error can not know err ');
                                alert(phone ? phone[0] : pwd ? pwd[0] : ' error can not know err ');
                            }
                            else{
                                alert(errdata);
                            }
                        } else if (data.msg === 'du') {
                            //const message = '이미 같은 아이디로 회원가입이 되여있습니다.';
                            //alert(message);
                            $('#valid_smart_phone').text("이미 같은 아이디로 회원가입이 되여있습니다.").css('display','block');
                            setTimeout(function () {
                                $('#valid_smart_phone').text("이미 같은 아이디로 회원가입이 되여있습니다.").css('display','none');
                                $('#text_smart_phone').css('margin-bottom','1.5rem');
                            },1000);
                        }
                        else{
                            alert(" don't know -> " + data);
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
