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
                                    관리자 로그인
								</span>
                                <div class="form-group" style="display:none; margin-bottom: 0px; color: red; height: 1.5rem" id="valid_id">
                                    Error name!
                                </div>
								<div class="wrap-input100 validate-input" data-validate = "Valid id is required: number">
									<input class="input100" type="text" name="input_id" id="input_id" placeholder="아이디/폰번호">
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

                                <div class="row text-center">
                                    <div class="col-6 btn changehover find-password"><a href="admin.findPasswordView">비밀번호 찾기</a></div>
                                    <div class="col-6 btn changehover reg-user"><a href="admin.signupCorporateView">회원가입</a></div>
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
                let userid = $('#input_id').val().replace(/ /g, '');
                let password = $('#input_pass').val().replace(/ /g, '');
                if(userid === ""){
                    $('#valid_id').text("사용자 아이디를 입력해주세요").css('display','block');
                    setTimeout(function () {
                        $('#valid_id').text("사용자 아이디를 입력해주세요").css('display','none');
                        $('#text_id').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }
                if(password === "") {
                    $('#valid_pass').text("비밀번호를 입력 해주세요").css('display', 'block');
                    setTimeout(function () {
                        $('#valid_pass').text("비밀번호를 입력 해주세요").css('display','none');
                        $('#text_pass').css('margin-bottom','1.5rem');
                    },1000);
                    return;
                }

                $.ajax({
                    url:'/apiw/login',
                    data: {
                        user_phone: userid,
                        user_pwd: password,
                    },
                    type: 'POST',
                    cache: false,
                    dataType : 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.msg === "ok") {
                            let access_token = data.access_token;
                            let token_type = data.token_type;
                            let expires_in = data.expires_in;
                            window.localStorage.authToken = access_token;
                            $.ajax({
                                url:'/apiw/admin/get_user',
                                headers: {'Authorization': `Bearer ${access_token}`},
                                data: {
                                    'token': `${access_token}`
                                },
                                type: 'POST',
                                success: function (data) {
                                    if (data.msg !== "ok")
                                    {
                                        alert(data.cont);
                                    }
                                    else{
                                        window.location.href = 'admin.dashboard-view';
                                    }
                                }, error: function (jqXHR, errdata, errorThrown) {
                                    console.log(jqXHR['responseText'] ?? errdata);
                                }
                            });
                        }
                        else if (data.msg === 'nonuser') {
                            const message = '아이디가 존재하지 않습니다';
                            alert(message);
                        } else if (data.msg === 'nonpwd') {
                            const message = '비밀번호 오류';
                            alert(message);
                        }
                        else if (data.msg === 'err') {
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
                        }
                        else{
                            let errdata = data.msg;
                            if(Array.isArray(errdata)){
                                let phone = errdata['user_phone'];
                                let pwd = errdata['user_pwd'];
                                console.log("err >>>", phone ? phone[0] : pwd ? pwd[0] : ' error can not know err ');
                                alert(phone ? phone[0] : pwd ? pwd[0] : ' error can not know err ');
                            }
                            else{
                                alert(errdata);
                            }

                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(jqXHR['responseText'] ?? errdata);
                    }
                });
            });

        });
    </script>
@endsection
