@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/css/app.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">업로드 HTML</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page">이용약관 HTML파일 업로드</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="col-sm-3 "></div>
                    <div class="card notice-card">
                        <div class="card-body notice-card-body-all " style="width: 50%; margin: 0 auto">
                            <div class="form-group row d-flex">
                                <div class="col-md-4 pl-3">
                                    <label class="form-label">이용약관</label>
                                </div>
                                <div class="col-md-8 d-flex flex-row">
                                    <input type="file" name="uploadfile_html" id="uploadfile_html" accept="text/html" value="" style="display: none">
                                    <input type="hidden" name="old_uploadfile_url" id="old_uploadfile_url" value="">
                                    <div id="uploadfile_btn" class="btn form-control d-flex justify-content-center align-items-center" style="padding: 0 20px 0 20px" type="text" >파일 찾기</div>
                                </div>
                            </div>
                            <div class="form-group row d-flex">
                                <div class="col-md-4 pl-3"></div>
                                <div class="col-md-8 d-flex flex-row">
                                    <div id="uploadfile_name" class="d-flex justify-content-center align-items-center" type="text" ></div>
                                </div>
                            </div>
                            <div class="modal-footer text-center" style="height: auto; justify-content: center;">
                                <div class="">
                                    <div class="btn btn-success text-center" id="button_upload" style="width: 80px;">
                                        확인
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 "></div>
                </div>
            </div>
    <!-- ROW-1 CLOSED -->
        </div>
    </div>

    <!--CONTAINER CLOSED -->
    </div>
@endsection
@section('js')

    <script>
        let html_file_name = "";

        function get_uploaded_file() {
            $.ajax({
                url: 'admin.uploadedFile',
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#uploadfile_name').text(data.orig_file);
                    } else {
                        $('#uploadfile_name').text('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        $(document).ready(function () {
            get_uploaded_file();

            $('#button_upload').click(function(){
                let uploadfile_html =  $('#uploadfile_html').prop('files')[0];
                let form_data = new FormData();
                form_data.append('uploadfile_html', uploadfile_html);
                form_data.append('orig_file', html_file_name);

                $.ajax({
                    url: 'admin.htmlFile',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === 'ok') {
                            $('#uploadfile_html').val('');
                            $('#uploadfile_btn').text('파일 찾기');
                            $('#old_uploadfile_url').val('');
                            $('#uploadfile_name').text(html_file_name);
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });

            });

            $('div[id="uploadfile_btn"]').on('mouseup', function () {
                $('#uploadfile_html').trigger('click');
            });
            $('input[id="uploadfile_html"]').change(function(){
                if (this.files && this.files[0])
                {
                    html_file_name = this.files[0].name;
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#uploadfile_btn').text(html_file_name);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });
        });

    </script>
@endsection
