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
        <h1 class="page-title">청구서 수정</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item"><a href="admin.order-manage">회원 청구서 관리</a></li>
            <li class="breadcrumb-item active" aria-current="page">청구서 수정</li>
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
                    <h3 class="card-title">账单内容</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">订单编码</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="input_order_no" placeholder="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">회원 이름</label>
                                    <input type="text" class="form-control" id="input_user_name" placeholder="">
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
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="exampleInputname">账单类型</label>
                                <input type="text" class="form-control" id="input_order_type" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="exampleInputname">币种选择</label>
                                <select class="form-control" id="select_currency_type">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label for="exampleInputname">金额输入</label>
                                <input type="number" class="form-control" id="input_currency_amount" placeholder="请输入金额">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">明细填写</label>
                        <textarea class="form-control" rows="6" id="text_detail"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">图片选择</label>
{{--
                        <div class="col-md-6" style="padding: 0px;">
                            <input id="input_image" type="file" accept="image/*"/>
                        </div>
--}}
                        <div class="col-md-10 img-content" id="chooseicon-container">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">日期选择</label>
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
                </div>
                <div class="card-footer text-center">
                    <input id="input_current_order_id"  type="hidden" value="
                                        {{{ Session::get('order_id') }}}">
                    <div id="button_mod" class="btn btn-success mt-1" style="width: 80px; margin-right: 30px;">수정</div>
                    <div id="button_cancel" class="btn btn-danger mt-1" style="width: 80px;">취소</div>
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
        var current_order_id;
        $(document).ready(function () {
            current_order_id = $('#input_current_order_id').val();
            $('#input_user_name').prop('readonly', true);
            $('#input_order_type').prop('readonly', true);
            $('#input_order_no').prop('readonly', true);
            uploadImageLists();
            getAllCurrencyList();
            $('#button_mod').click(function(){
                modOrderInfo();
            });
            $('#button_cancel').click(function(){
                window.location.href = 'admin.order-manage';
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
                tags += '           <span class="image_chooseicons_add_txt" id="addIcontext_'+i+'">添加</span>';
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
                tags += '           <span class="image_chooseicons_add_txt" id="addIcontext_'+i+'">添加</span>';
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

        function selectedImage(img_url, index) {
            if(img_url != null && img_url != '')
            {
                $('#uploadiconpre_'+index).val(img_url);
                $('#seletedIconImage_'+index).attr('src', img_url);
                $('#addIcontext_'+index).css('display', 'none');
                $('#closeIconImage_'+index).css('display', 'block');
                $('#imagechooseicons_'+index).css('padding', '0px');
                $('#imagechooseicons_'+index).css('line-height', '100px');
            }
            else{
                $('#closeIconImage_'+index).css('display', 'none');
                $('#uploadiconpre_'+index).val('');
                $('#addIcontext_'+index).css('display', 'flex');
                $('#seletedIconImage_'+index).attr('src', '/images/img_add_icon_btn.png');
                $('#imagechooseicons_'+index).css('padding', '20px');
                $('#imagechooseicons_'+index).css('line-height', '40px');
                $('#uploadicon_'+index).val('');
            }
        }

        function getAllCurrencyList() {
            $.ajax({
                url: 'admin.getAllCurrencyList',
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
                        getOrderInformation();
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

        function getOrderInformation() {
            $.ajax({
                url: 'admin.getOrderDetailInformation',
                data: {
                    id: current_order_id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        var order = data.lists[0];
                        var user_id = order.user_id;
                        var order_no = order.order_no;
                        $('#input_order_no').val(order_no);
                        var user_name = order.name;
                        $('#input_user_name').val(user_name);
                        var type = order.order_type;
                        var type_string = '';
                        if (type == 0) {
                            type_string = '收入';
                        }
                        else {
                            type_string = '支出';
                        }
                        $('#input_order_type').val(type_string);
                        var currency_id = order.currency_id;
                        $('#select_currency_type').val(currency_id);
                        var item_id = order.item_id;
                        $('#select_item_type').val(item_id);
                        var amount = order.amount;
                        $('#input_currency_amount').val(amount);
                        var description = order.description;
                        $('#text_detail').val(description);
                        /*var img_url = order.img_url;
                        $("#input_image").addClass('dropify');
                        $("#input_image").attr("data-height", 300);
                        $("#input_image").attr("data-default-file",  img_url);
                        $('.dropify').dropify();*/
                        selectedImage(order.img_0, 0);
                        selectedImage(order.img_1, 1);
                        selectedImage(order.img_2, 2);
                        selectedImage(order.img_3, 3);
                        selectedImage(order.img_4, 4);
                        selectedImage(order.img_5, 5);
                        selectedImage(order.img_6, 6);
                        selectedImage(order.img_7, 7);

                        var create_date = order.created_at;
                        var dateString = create_date.split(' ')[0];
                        var temp = dateString.split('-');
                        var create_string = temp[1] + '/' + temp[2] + '/' + temp[0];
                        $('#input_date').val(create_string);
                    }
                    else {

                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function modOrderInfo() {
            var currency_id = $('#select_currency_type').val();
            if (currency_id == null || currency_id =='0'){
                showNotice('选择币种');
                return;
            }
            var item_id = $('#select_item_type').val();
            if (item_id == null || item_id =='0'){
                showNotice('选择项目');
                return;
            }
            var amount = $('#input_currency_amount').val();
            if (amount == null || amount =='0' || amount ==''){
                showNotice('选择金额');
                return;
            }
            var description = $('#text_detail').val();
            if (description == null || description ==''){
                showNotice('输入明细');
                return;
            }
            //var img_url = $('#input_image').val();
            var image_0 =  $('#uploadicon_0').prop('files')[0];
            var pre_0 = $('#uploadiconpre_0').val();
            var image_1 =  $('#uploadicon_1').prop('files')[0];
            var pre_1 = $('#uploadiconpre_1').val();
            var image_2 =  $('#uploadicon_2').prop('files')[0];
            var pre_2 = $('#uploadiconpre_3').val();
            var image_3 =  $('#uploadicon_3').prop('files')[0];
            var pre_3 = $('#uploadiconpre_3').val();
            var image_4 =  $('#uploadicon_4').prop('files')[0];
            var pre_4 = $('#uploadiconpre_4').val();
            var image_5 =  $('#uploadicon_5').prop('files')[0];
            var pre_5 = $('#uploadiconpre_5').val();
            var image_6 =  $('#uploadicon_6').prop('files')[0];
            var pre_6 = $('#uploadiconpre_6').val();
            var image_7 =  $('#uploadicon_7').prop('files')[0];
            var pre_7 = $('#uploadiconpre_7').val();
            var create_date = $('#input_date').val();
            //var image_file =  $('#input_image').prop('files')[0];

            var form_data = new FormData();
            form_data.append('order_id', current_order_id);
            //form_data.append('image_file', image_file);
            form_data.append('image_0', image_0);
            form_data.append('image_1', image_1);
            form_data.append('image_2', image_2);
            form_data.append('image_3', image_3);
            form_data.append('image_4', image_4);
            form_data.append('image_5', image_5);
            form_data.append('image_6', image_6);
            form_data.append('image_7', image_7);
            form_data.append('pre_0', pre_0);
            form_data.append('pre_1', pre_1);
            form_data.append('pre_2', pre_2);
            form_data.append('pre_3', pre_3);
            form_data.append('pre_4', pre_4);
            form_data.append('pre_5', pre_5);
            form_data.append('pre_6', pre_6);
            form_data.append('pre_7', pre_7);
            form_data.append('currency_id', currency_id);
            form_data.append('item_id', item_id);
            form_data.append('amount', amount);
            form_data.append('description', description);
            form_data.append('create_date', create_date);
            $.ajax({
                url: 'admin.modOrderInfo', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response){
                    let data = JSON.parse(response);
                    if (data.msg === "ok") {
                        showSuccessNotice();
                        getOrderInformation();
                    }
                    else if (data.msg === "noval") {
                        showNotice('옳바른 사진을 선택하세요');
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
        function showNotice(message) {
            let ok_text = '확인';
            swal({
                confirmButtonText: ok_text,
                title: message
            });
        }
        function showSuccessNotice() {
            swal('청구서가 수정되었습니다!', '', 'success');
            window.location.href = 'admin.order-manage';
        }
    </script>
@endsection
