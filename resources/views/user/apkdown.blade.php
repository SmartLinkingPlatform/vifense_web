@extends('layouts.master3')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('content')
		<!-- BACKGROUND-IMAGE -->
		<div class="login-img" style="background-color: #fff">
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
					{{--<div class="text-center">
                           <h1 style="margin-bottom:0">Vifense.com</h1>
					</div>--}}
					</div>
					<div class="container-login100">
						<div class="position-relative">
                            <img src="{{URL::asset('assets/images/pngs/bg_appdown_1.png')}}" alt="">
                            <a href="/apk/vifense_240203.1.apk" download>
                                <img src="{{URL::asset('assets/images/pngs/btn_appdown.png')}}" alt="appdown" style="position: absolute;left: 50%;top: 40%;transform: translate(-50%, -50%); width: 60%">
                            </a>
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
