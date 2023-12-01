@extends('layouts.master2')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
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
                                    회원 로그인
								</span>
                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_email">
                                    Error name!
                                </div>
								<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="text" name="input_email" id="input_email" placeholder="아이디">
									<span class="symbol-input100">
										<i class="zmdi zmdi-account" aria-hidden="true"></i>
									</span>
								</div>
                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_pass">
                                    Error password!
                                </div>
								<div class="wrap-input100 validate-input" data-validate = "Password is required">
									<input class="input100" type="password" name="input_pass" id="input_pass" placeholder="비밀번호">
									<span class="symbol-input100">
										<i class="zmdi zmdi-lock" aria-hidden="true"></i>
									</span>
								</div>
								<div class="container-login100-form-btn mb-4" style="cursor: pointer;">
									<div id="button_login" class="login100-form-btn btn-primary">
										로&nbsp;&nbsp;&nbsp;그&nbsp;&nbsp;&nbsp;인
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
                    $('#valid_email').text("계정을 입력하세요").css('display','block');
                    setTimeout(function () {
                        $('#valid_email').text("이름을 입력하세요").css('display','none');
                        $('#text_name').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }
                if(password === "") {
                    $('#valid_pass').text("비밀번호를 입력하세요").css('display', 'block');
                    setTimeout(function () {
                        $('#valid_pass').text("비밀번호를 입력하세요").css('display','none');
                        $('#text_pwd').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }

                $.ajax({
                    url: 'user.userLogin',
                    data: {
                        username: username,
                        password: password,
                    },
                    type: 'POST',
                    success: function (data) {
                        console.log(data.msg);
                        if (data.msg === "ok") {
                            window.location.href = 'user.user';

                        } else if (data.msg === 'nonuser') {
                            let message = '계정이 존재하지 않습니다';
                            alert(message);

                        } else if (data.msg === 'nonpwd') {
                            let message = '비밀번호가 잘못되였습니다';
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
