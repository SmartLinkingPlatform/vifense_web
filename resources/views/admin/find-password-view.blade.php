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
                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_user_regnum">
                                    Error corporate phone!
                                </div>
								<div class="wrap-input100 validate-input" data-validate = "corporate number is required:888-88-88888">
									<input class="form-control" style="padding-left: 2.5rem" type="text" name="input_user_regnum" id="input_user_regnum" placeholder="사업자 등록번호">
									<span class="symbol-input100" style="padding-left: 0.9rem">
										<i class="zmdi zmdi-phone" aria-hidden="true"></i>
									</span>
								</div>

								<div class="container-login100-form-btn mb-5" style="cursor: pointer;">
									<div id="mok_popup" class="login100-form-btn btn-primary">
                                        실명인증
									</div>
								</div>
                                <div id="new_pwd_area" style="display: none">
                                    <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_sign_number">
                                        Error sign number!
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
    {{-- dev --}}
    <script src='https://scert.mobile-ok.com/resources/js/index.js'></script>
    {{-- product --}}
    {{-- <script src="https://cert.mobile-ok.com/resources/js/index.js"></script> --}}
    <script>
        let sign_time_counter = null;
        let sign_time_num = 0;
        function signCounter() {
            clearInterval(sign_time_counter); // reset;
            sign_time_counter = setInterval(() => {
                $('#sign_num_counter').text(`(${sign_time_num}s)`);
                if (sign_time_num === 0) {
                    clearInterval(sign_time_counter); // reset;
                    sign_time_num = 60;
                } else
                    --sign_time_num;
            }, 1000);

        }

        function resultFunc(result) {
            try {
                let jsresult = JSON.parse(result);
                if (parseInt(jsresult.resultCode) == 2000) {
                    let smart_phone = $('#input_smart_phone').val().replace(/\s/g, '');
                    smart_phone = smart_phone.replace(/[-_]/g, '');
                    if (smart_phone === jsresult.userPhone) {
                        $('#new_pwd_area').css('display','block');
                        $('#input_smart_phone').attr("readonly",true);
                        $('#input_user_regnum').attr("readonly",true);
                    } else {
                        $('#new_pwd_area').css('display','none');
                    }
                }
                console.log('resultFunc >>>', jsresult);
            } catch (error) {
                console.log('err >>>', error.message);
            }
        }

        $(document).ready(function () {
            $('#mok_popup').click(function () {
                let smart_phone = $('#input_smart_phone').val().replace(/\s/g, '');
                smart_phone = smart_phone.replace(/[-_]/g, '');
                let user_regnum = $('#input_user_regnum').val().replace(/\s/g, '');
                user_regnum = user_regnum.replace(/_/g, '');

                if(smart_phone === ""){
                    $('#valid_smart_phone').text("휴대폰 번호를 입력해주세요").css('display','block');
                    setTimeout(function () {
                        $('#valid_smart_phone').text("휴대폰 번호를 입력해주세요").css('display','none');
                        $('#text_smart_phone').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }
                if(user_regnum === "") {
                    $('#valid_user_regnum').text("사업자 등록번호를 입력 해주세요").css('display', 'block');
                    setTimeout(function () {
                        $('#valid_user_regnum').text("사업자 등록번호를 입력 해주세요").css('display','none');
                        $('#text_user_regnum').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }
                MOBILEOK.process("https://dgt.vifense.com/mok/mok_std_request.php?code='01004'", "WB", "resultFunc");
            })

            $('#button_changepassword').click(function () {
                let new_pwd = $('#input_new_password').val().replace(/\s/g, '');
                new_pwd = new_pwd.replace(/[-_]/g, '');
                let check_pwd = $('#input_check_new_password').val().replace(/\s/g, '');
                check_pwd = check_pwd.replace(/_/g, '');
                let user_phone = $('#input_smart_phone').val().replace(/\s/g, '');
                user_phone = user_phone.replace(/[-_]/g, '');

                if(new_pwd === ""){
                    $('#valid_smart_phone').text("신규 비밀번호를 입력해주세요").css('display','block');
                    setTimeout(function () {
                        $('#valid_smart_phone').text("신규 비밀번호를 입력해주세요").css('display','none');
                        $('#text_smart_phone').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }
                if(new_pwd !== check_pwd) {
                    $('#valid_user_regnum').text("비밀번호가 일치하지 않습니다.").css('display', 'block');
                    setTimeout(function () {
                        $('#valid_user_regnum').text("비밀번호가 일치하지 않습니다.").css('display','none');
                        $('#text_user_regnum').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }

                $.ajax({
                    url: 'admin.regNewPwd',
                    data: {
                        user_phone: user_phone,
                        new_pwd: new_pwd,
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            window.location.href = 'admin.login';
                        } else if (data.msg === 'nonuser') {
                            const message = '신규 비밀번호 등록이 실패하였습니다.';
                            alert(message);
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            });

            /** check auth */
            $('#button_sign_check').click(function () {
                let input_sign_number = $('#input_sign_number').val().replace(/ /g, '');
                if(input_sign_number === ""){
                    $('#valid_sign_number').text("인증번호를 입력해주세요").css('display','block');
                    setTimeout(function () {
                        $('#valid_sign_number').text("인증번호를 입력해주세요").css('display','none');
                        $('#text_sign_number').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }

                $.ajax({
                    url: 'admin.signnumberCheck',
                    data: {
                        signnumber: input_sign_number,
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            // alert('ok');
                            window.location.href = 'admin.admin';

                        } else if (data.msg === 'non') {
                            const message = '인증번호가 맞지 않습니다.';
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
