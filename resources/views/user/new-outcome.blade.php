@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinSimple.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">비용 신청</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">회원 체계</a></li>
            <li class="breadcrumb-item"><a href="user.order-history">결제 상세 정보</a></li>
            <li class="breadcrumb-item active" aria-current="page">비용 신청</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">청구서 내용</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" id="form_upload" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="form-label">회원 계정</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="input_user_account" placeholder="" value="{{{ Session::get('user_account') }}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">회원 이름</label>
                                            <input type="text" class="form-control" id="input_user_name" placeholder="" value="{{{ Session::get('user_name') }}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">프로젝트 유형</label>
                                            <select class="form-control" id="select_item_type">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputname">유형</label>
                                            <input type="text" class="form-control" id="input_order_type" placeholder="" value="지출">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputname">통화 선택</label>
                                            <select class="form-control" id="select_currency_type">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputname">금액 입력</label>
                                            <input type="number" class="form-control" id="input_currency_amount" placeholder="금액을 입력해주세요">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">상세 정보</label>
                                    <textarea class="form-control" rows="6" id="text_detail"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">사진 선택</label>
{{--
                                    <div class="col-md-6" style="padding: 0px;">
                                        <input id="input_image" type="file" class="dropify"  data-height="300"  accept="image/*"/>
                                    </div>
--}}
                                    <div class="col-md-10 img-content" id="chooseicon-container">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">날짜 선택</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div><input id="input_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <div id="button_add" class="btn btn-success mt-1" style="width: 80px; margin-right: 30px;">추가</div>
                            <div id="button_cancel" class="btn btn-danger mt-1" style="width: 80px;">취소</div>
                            <input id="input_current_user_id"  type="hidden" value="
                                        {{{ Session::get('user_id') }}}">
                        </div>
                    </div>
                </div>
            </div>
    <!-- ROW-1 CLOSED -->
        </div>
    </div>

    <!--CONTAINER CLOSED -->
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/sweet-alert.js') }}"></script>
    <script src="{{ URL::asset('assets/js/popover.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        var user_id;
        $(document).ready(function () {
            user_id = $('#input_current_user_id').val();
            $('#input_user_account').prop('readonly', true);
            $('#input_user_name').prop('readonly', true);
            $('#input_order_type').prop('readonly', true);
            uploadImageLists();
            getAllCurrencyList();
            $('#button_add').click(function(){
                addNewOutcomeOrder();
            });
            $('#button_cancel').click(function(){
                initialPage();
                window.location.href = 'user.order-history';
            });
        });

        function uploadImageLists(){
            $('#chooseicon-container').html('');
            var tags = "";
            tags += '<div class="row page2_row">';
            for(var i = 0; i < 4; i++){
                tags += '<div class="col-md-2">';
                tags += '   <div style="display: none">';
                tags += '       <input type="hidden" name="uploadiconpre_'+i+'" id="uploadiconpre_'+i+'" value="">';
                tags += '       <input type="file" name="uploadicon_'+i+'" id="uploadicon_'+i+'" value="">';
                tags += '   </div>';
                tags += '   <div>';
                tags += '       <div class="image_chooseicons" id="imagechooseicons_'+i+'">';
                tags += '           <img src="/images/img_add_icon_btn.png" id="seletedIconImage_'+i+'" class="seletedIconImage" >';
                tags += '           <span class="image_chooseicons_add_txt" id="addIcontext_'+i+'">추가</span>';
                tags += '       </div>';
                tags += '       <img class="image_chooseicons_close_btn" src="/images/img_close_icon_btn.png" id="closeIconImage_'+i+'" >';
                tags += '   </div>';
                tags += '</div>';
            }
            tags += '</div>';
            tags += '<div class="row page2_row">';
            for(var i = 4; i < 8; i++){
                tags += '<div class="col-md-2">';
                tags += '   <div style="display: none">';
                tags += '       <input type="hidden" name="uploadiconpre_'+i+'" id="uploadiconpre_'+i+'" value="">';
                tags += '       <input type="file" name="uploadicon_'+i+'" id="uploadicon_'+i+'" value="">';
                tags += '   </div>';
                tags += '   <div>';
                tags += '       <div class="image_chooseicons" id="imagechooseicons_'+i+'">';
                tags += '           <img src="/images/img_add_icon_btn.png" id="seletedIconImage_'+i+'" class="seletedIconImage" >';
                tags += '           <span class="image_chooseicons_add_txt" id="addIcontext_'+i+'">추가</span>';
                tags += '       </div>';
                tags += '       <img class="image_chooseicons_close_btn" src="/images/img_close_icon_btn.png" id="closeIconImage_'+i+'" >';
                tags += '   </div>';
                tags += '</div>';
            }
            tags += '</div>';
            $('#chooseicon-container').html(tags);

            pageEventFunc();
        }

        function pageEventFunc() {
            $('div[id^="imagechooseicons_"]').on('mouseup', function () {
                var id= $(this).attr('id');
                var index = id.split("_");
                $('#uploadicon_'+index[1]).trigger('click');
            });

            $('img[id^="closeIconImage_"]').click(function(){
                var id = $(this).attr('id');
                var index = id.split("_")[1];
                $('#closeIconImage_'+index).css('display', 'none');
                $('#uploadiconpre_'+index).val('');
                $('#addIcontext_'+index).css('display', 'flex');
                $('#seletedIconImage_'+index).attr('src', '/images/img_add_icon_btn.png');
                $('#imagechooseicons_'+index).css('padding', '20px');
                $('#imagechooseicons_'+index).css('line-height', '40px');
                $('#uploadicon_'+index).val('');
            });

            $('input[name^="uploadicon_"]').change(function(){
                var id = $(this).attr('id');
                var index = id.split("_")[1];
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#uploadiconpre_'+index).val(e.target.result);
                        $('#seletedIconImage_'+index).attr('src', e.target.result);
                        $('#addIcontext_'+index).css('display', 'none');
                        $('#closeIconImage_'+index).css('display', 'block');
                        $('#imagechooseicons_'+index).css('padding', '0px');
                        $('#imagechooseicons_'+index).css('line-height', '100px');
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });
        }

        function getAllCurrencyList() {
            $.ajax({
                url: 'user.getAllCurrencyList',
                data: {
                },
                type: 'POST',
                success: function (data) {
                    $('#select_currency_type').html('');
                    $('#select_item_type').html('');
                    var tag1 = '';
                    var tag2 = '';
                    tag1 += '<option value="0">통화를 선택하세요</option>';
                    tag2 += '<option value="0">항목을 선택하세요</option>';
                    if (data.msg === "ok") {
                        var c_lists = data.c_lists;
                        if(c_lists != null) {
                            for (var i = 0; i < c_lists.length; i++) {
                                var currency = c_lists[i];
                                tag1 += '<option value="' + currency.id + '">' + currency.name + '</option>'
                            }
                            $('#select_currency_type').html(tag1);
                        }
                        else{
                            $('#select_currency_type').html(tag1);
                        }
                        var i_lists = data.i_lists;
                        if(i_lists != null) {
                            for (var i = 0; i < i_lists.length; i++) {
                                var item = i_lists[i];
                                tag2 += '<option value="' + item.id + '">' + item.name + '</option>'
                            }
                            $('#select_item_type').html(tag2);
                        }
                        else{
                            $('#select_item_type').html(tag2);
                        }
                    }
                    else {
                        $('#select_currency_type').html(tag1);
                        $('#select_item_type').html(tag2);
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function addNewOutcomeOrder() {
            var type = 1;
            var currency_id = $('#select_currency_type').val();
            if (currency_id == null || currency_id =='0'){
                showNotice('통화 선택');
                return;
            }
            var amount = $('#input_currency_amount').val();
            if (amount == null || amount =='0' || amount ==''){
                showNotice('금액 선택');
                return;
            }
            var description = $('#text_detail').val();
            if (description == null || description ==''){
                showNotice('상세 정보 입력');
                return;
            }
            var item_id = $('#select_item_type').val();
            if (item_id == null || item_id =='0'){
                showNotice('상품을 선택하세요');
                return;
            }
            /*var img_url = $('#input_image').val();
            if (img_url == null || img_url ==''){
                showNotice('选择图片');
                return;
            }*/
            var create_date = $('#input_date').val();
            // if (create_date == null || create_date ==''){
            //     showNotice('选择日期');
            //     return;
            // }
            //var image_file =  $('#input_image').prop('files')[0];
            var image_0 =  $('#uploadicon_0').prop('files')[0];
            var image_1 =  $('#uploadicon_1').prop('files')[0];
            var image_2 =  $('#uploadicon_2').prop('files')[0];
            var image_3 =  $('#uploadicon_3').prop('files')[0];
            var image_4 =  $('#uploadicon_4').prop('files')[0];
            var image_5 =  $('#uploadicon_5').prop('files')[0];
            var image_6 =  $('#uploadicon_6').prop('files')[0];
            var image_7 =  $('#uploadicon_7').prop('files')[0];
            var form_data = new FormData();
            form_data.append('user_id', user_id);
            //form_data.append('image_file', image_file);
            form_data.append('image_0', image_0);
            form_data.append('image_1', image_1);
            form_data.append('image_2', image_2);
            form_data.append('image_3', image_3);
            form_data.append('image_4', image_4);
            form_data.append('image_5', image_5);
            form_data.append('image_6', image_6);
            form_data.append('image_7', image_7);
            form_data.append('type', type);
            form_data.append('currency_id', currency_id);
            form_data.append('item_id', item_id);
            form_data.append('amount', amount);
            form_data.append('description', description);
            form_data.append('create_date', create_date);
            $.ajax({
                url: 'user.addNewOutcomeOrder', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response){
                    var data = JSON.parse(response);
                    if (data.msg === "ok") {
                        showSuccessNotice();
                        initialPage();
                    }
                    else if (data.msg === "noval") {
                        showNotice('사진 오류');
                    }
                    else {
                        showNotice('오류 발생');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
        function initialPage() {
            $('#select_currency_type').val('0');
            $('#input_currency_amount').val('');
            $('#text_detail').val('');
            $('#input_image').val('');
            var imagenUrl = "";
            /*var drEvent = $('#input_image').dropify(
                {
                    defaultFile: imagenUrl
                });
            drEvent = drEvent.data('dropify');
            drEvent.clearElement();*/
            $('#input_date').val('');
        }
        function showNotice(message) {
            var ok_text = '확인';
            swal({
                confirmButtonText: ok_text,
                title: message
            });
        }
        function showSuccessNotice() {
            swal('청구서가 추가되었습니다!', '', 'success');
            window.location.href = 'user.order-history';
        }
    </script>
@endsection
