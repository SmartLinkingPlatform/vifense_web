@extends('layouts.master2')
@section('css')
@endsection
@section('content')
	    <!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- End GLOBAL-LOADER -->

		<!-- PAGE -->
		<div class="page">
		   <!-- PAGE-CONTENT OPEN -->
			<div class="page-content error-page">
				<div class="container text-center">
					<div class="error-template">
						<h1 class="display-1 text-white mb-2">404<span class="text-transparent fs-20">错误</span></h1>
						<h5 class="error-details text-white">
                            抱歉，发生错误，找不到请求的页面！
						</h5>
						<div class="text-center">
							<a class="btn btn-secondary mt-5 mb-5" href="{{ url('/' . $page='admin') }}"> <i class="fa fa-long-arrow-left"></i> 登录页面 </a>
						</div>
                    </div>
				</div>
			</div>
			<!-- PAGE-CONTENT OPEN CLOSED -->
		</div>
		<!-- End PAGE -->
@endsection
@section('js')
@endsection
