@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">会员信息</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">会员系统</a></li>
            <li class="breadcrumb-item active" aria-current="page">会员信息</li>
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
                    <h3 class="card-title">회원 정보</h3>
                    <div class="page-options d-flex float-right">
                        <div id="button_mod_password" class="btn btn-success mt-1" style="width: 100px; margin-right: 30px;">비밀번호 수정</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">회원 계정</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="input_user_account" placeholder="">
                            </div>
                        </div>
                        <label class="form-label">회원 이름</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="input_user_name" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="exampleInputname">수익</label>
                                <div class="">
                                    <div class="grid-margin">
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table card-table table-vcenter text-nowrap table-primary align-items-center">
                                                    <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="text-white">통화</th>
                                                        <th class="text-white">임시금</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody_income_list">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="exampleInputname">支出</label>
                                <div class="">
                                    <div class="grid-margin">
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table card-table table-vcenter text-nowrap table-primary align-items-center">
                                                    <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="text-white">币种</th>
                                                        <th class="text-white">总金额</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbody_outcome_list">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
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
    <!-- modal part -->
    <div class="modal fade" id="modPasswordModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">비밀번호 수정</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row"  id="dlgErr" style="display: none; padding-left: 15px;">
                        <div class="col">
                            error;
                        </div>
                    </div>
                    <div >
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-3 text-right">
                                <label class="form-label">비밀번호</label>
                            </div>
                            <div class="col-md-9">
                                <input type="password" id="input_password" class="form-control" name="example-text-input" placeholder="비밀번호">
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-3 text-right">
                                <label class="form-label">새 비밀번호</label>
                            </div>
                            <div class="col-md-9">
                                <input type="password" id="input_new_password" class="form-control" name="example-text-input" placeholder="새 비밀번호">
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="col-md-3 text-right">
                                <label class="form-label">비밀번호 확인</label>
                            </div>
                            <div class="col-md-9">
                                <input type="password" id="input_password_confirm" class="form-control" name="example-text-input" placeholder="비밀번호 확인">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center" style="height: auto; justify-content: center;">
                    <div class="">
                        <div class="btn btn-success text-center" id="modal_button_mod" style="width: 80px;">
                            수정
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/sweet-alert.js') }}"></script>
    <script>
        var user_id;
        var user_password;
        $(document).ready(function () {
            user_id = $('#input_current_user_id').val();
            $('#input_user_name').prop('readonly', true);
            $('#input_user_account').prop('readonly', true);

            $('#button_mod_password').click(function () {
                $('#modPasswordModal').modal('show');
                $('#dlgErr').text('').css({'display':'none'});
                $('#input_password').val('');
                $('#input_new_password').val('');
                $('#input_password_confirm').val('');
            });
            $('#modal_button_mod').click(function () {
                changeUserPassword();
            });
            getUserInformation();
        });

        function getUserInformation() {
            $.ajax({
                url: 'user.getUserInformation',
                data: {
                    user_id: user_id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        var list = data.lists;
                        var id = list.id;
                        var account = list.account;
                        user_password = data.pwd;
                        var name = list.name;

                        $('#input_user_account').val(account);
                        $('#input_user_name').val(name);
                        getUserTotalAmount();
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function getUserTotalAmount() {
            $('#tbody_income_list').html('');
            $('#tbody_outcome_list').html('');
            $.ajax({
                url: 'user.getUserTotalAmount',
                data: {
                    id: user_id,
                },
                type: 'POST',
                success: function (data) {
                    var income_tag = '';
                    var outcome_tag = '';
                    if (data.msg === "ok") {
                        var list = data.lists;
                        for (var i = 0; i < list.length; i++) {
                            var item = list[i];
                            var type = item.order_type;
                            if (type == 0) {
                                income_tag += '<tr>';
                                income_tag += '<td>' + item.cname + '</td>';
                                income_tag += '<td class="text-sm font-weight-600">' + item.tamount + '</td>';
                                income_tag += '</tr>';
                            }
                            else if (type == 1) {
                                outcome_tag += '<tr>';
                                outcome_tag += '<td>' + item.cname + '</td>';
                                outcome_tag += '<td class="text-sm font-weight-600">' + item.tamount + '</td>';
                                outcome_tag += '</tr>';
                            }
                        }
                        $('#tbody_income_list').html(income_tag);
                        $('#tbody_outcome_list').html(outcome_tag);
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function changeUserPassword() {
            var password = $('#input_password').val();
            var new_password = $('#input_new_password').val();
            var password_confirm = $('#input_password_confirm').val();
            if (password == '' || password == null) {
                $('#dlgErr').text('请输入密码').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (new_password == '' || new_password == null) {
                $('#dlgErr').text('请输入新密码').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password_confirm == '' || password_confirm == null) {
                $('#dlgErr').text('请输入确认密码').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password != user_password) {
                $('#dlgErr').text('密码不正确').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (new_password != password_confirm) {
                $('#dlgErr').text('新密码不正确').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'user.changeUserPassword',
                data: {
                    id: user_id,
                    password: new_password,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('수정 성공').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#modPasswordModal").modal('hide');
                            getUserInformation();
                        },1000);
                    }
                    else {
                        $('#dlgErr').text('수정 실패').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function showNotice(message) {
            var ok_text = '确认';
            swal({
                confirmButtonText: ok_text,
                title: message
            });
        }
        function showSuccessNotice() {
            swal('账单添加成功!', '', 'success');
        }
    </script>
@endsection
