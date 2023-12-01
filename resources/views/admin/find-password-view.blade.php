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
			<div class="page" style="margin-top:calc(100vh/2 - 30vh);">
				<div class="">
				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto">
						<div class="text-center">
							<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img" alt="">
						</div>
					</div>
					<div class="container-login100">
						<div class="wrap-login100 p-6">
							<form class="login100-form validate-form">
								<span class="login100-form-title">
                                    법인 비밀번호 찾기
								</span>
                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_smart_phone">
                                    Error smart phone!
                                </div>
								<div class="wrap-input100 validate-input" data-validate = "Valid phone number is required: 010 123 4567">
									<input class="form-control" style="padding-left: 2.5rem" type="text" name="input_smart_phone" id="input_smart_phone" placeholder="휴대폰 번호">
									<span class="symbol-input100" style="padding-left: 0.9rem">
										<i class="zmdi zmdi-smartphone" aria-hidden="true"></i>
									</span>
								</div>
                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_corporate_phone">
                                    Error corporate phone!
                                </div>
								<div class="wrap-input100 validate-input" data-validate = "corporate number is required:888-88-88888">
									<input class="form-control" style="padding-left: 2.5rem" type="text" name="input_corporate_phone" id="input_corporate_phone" placeholder="사업자 등록번호">
									<span class="symbol-input100" style="padding-left: 0.9rem">
										<i class="zmdi zmdi-phone" aria-hidden="true"></i>
									</span>
								</div>

								<div class="container-login100-form-btn mb-5" style="cursor: pointer;">
									<div id="button_getphonesign" class="login100-form-btn btn-primary">
                                        인증번호 받기
									</div>
								</div>

                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_sign_number">
                                    Error sign number!
                                </div>
                                <div class="form-group row d-flex mb-5">
                                    <div class="col-md-8 pl-3">
                                        <input class="form-control" style="padding: 0 55px 0 22px" type="text" name="input_sign_number" id="input_sign_number" placeholder="인증번호">
                                        <span class="symbol-right-input100">(60s)</span>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="button_signnumber" class="login100-form-btn btn-primary">
                                            완료
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_new_password">
                                    Error new password!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">신규 비밀번호</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" style="padding-left: 30px" type="text" name="input_new_password" id="input_new_password" placeholder="신규 비밀번호">
                                        <span class="symbol-input100">
										    <i class="zmdi zmdi-lock" aria-hidden="true"></i>
									    </span>
                                    </div>
                                </div>

                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_check_new_password">
                                    Error check new password!
                                </div>
                                <div class="form-group row d-flex">
                                    <div class="col-md-4 pl-3">
                                        <label class="form-label">비밀번호 확인</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" style="padding-left: 30px" type="text" name="input_check_new_password" id="input_check_new_password" placeholder="비밀번호 확인">
                                        <span class="symbol-input100">
										    <i class="zmdi zmdi-lock" aria-hidden="true"></i>
									    </span>
                                    </div>
                                </div>

                                <div class="container-login100-form-btn mb-4" style="cursor: pointer;">
                                    <div id="button_changepassword" class="login100-form-btn btn-primary">
                                        OK
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
    <script>
        $(document).ready(function () {
            $('#button_login').click(function () {
                let username = $('#input_email').val().replace(/ /g, '');
                let password = $('#input_pass').val().replace(/ /g, '');
                if(username === ""){
                    $('#valid_email').text("사용자 아이디를 입력해주세요").css('display','block');
                    setTimeout(function () {
                        $('#valid_email').text("사용자 아이디를 입력해주세요").css('display','none');
                        $('#text_name').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }
                if(password === "") {
                    $('#valid_pass').text("비밀번호를 입력 해주세요").css('display', 'block');
                    setTimeout(function () {
                        $('#valid_pass').text("비밀번호를 입력 해주세요").css('display','none');
                        $('#text_pwd').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }

                $.ajax({
                    url: 'admin.adminLogin',
                    data: {
                        username: username,
                        password: password,
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            // alert('ok');
                            window.location.href = 'admin.admin';
                            //gotoMainPage();

                        } else if (data.msg === 'nonuser') {
                            const message = '계정이 존재하지 않습니다';
                            alert(message);

                        } else if (data.msg === 'nonpwd') {
                            const message = '비밀번호 오류';
                            alert(message);
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
