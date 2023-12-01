@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">통화 관리</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page">통화 관리</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW OPEN -->
            <div class="row row-cards">
                <div class="col-lg-12 col-xl-12">
                    <div class="input-group mb-5" style="display: none;">
                        <input type="text" class="form-control" placeholder="">
                        <div class="input-group-append ">
                            <button type="button" class="btn btn-secondary">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header border-bottom-0 p-4">
                            <h2 class="card-title" style="margin-left: 7px;">통화 목록</h2>
                            <div class="page-options d-flex float-right">
                                <div class="btn btn-success" id="button_add" style="width: 80px; margin-right: 10px;">
                                    <i class="icon icon-plus"></i>
                                    추가
                                </div>
                            </div>
                        </div>
                        <div class="e-table px-5 pb-5">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th >번호</th>
                                        <th >이름</th>
                                        <th >가격</th>
                                        <th class="text-center" style="width: 300px;">액션</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody_currency_list">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5" id="page_nav_container">

                    </div>
                </div><!-- COL-END -->
            </div>
    <!-- ROW CLOSED -->
        </div>
    </div>

    <!-- CONTAINER CLOSED -->

    <!-- modal part -->
    <div class="modal fade" id="addCurrencyModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">새 통화 추가</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row"  id="dlgErr" style="display: none; padding-left: 15px;">
                        <div class="col">
                            error;
                        </div>
                    </div>
                    <div >
                        <div class="form-group d-flex row">
                            <div class="col-md-2 pl-3">
                                <label class="form-label">이름</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="input_name" class="form-control" name="example-text-input" placeholder="이름">
                            </div>
                        </div>
                        <div class="form-group d-flex row">
                            <div class="col-md-2 pl-3">
                                <label class="form-label">각격</label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" id="input_value" class="form-control" name="example-text-input" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center" style="height: auto; justify-content: center;">
                    <div class="">
                        <div class="btn btn-success text-center" id="modal_button_add" style="width: 80px;">
                            추가
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        var current_id = 0;
        var pstart=1;
        $(document).ready(function () {
            getCurrencyList();

            $('#button_add').click(function(){
                showAddDialog();
            });

            $('#modal_button_add').click(function(){
                if (current_id == 0) {
                    addCurrency();
                }
                else {
                    editCurrency();
                }
            });
        });
        function showAddDialog() {
            current_id = 0;
            $('#addCurrencyModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('통화 추가');
            $('#modal_button_add').text('추가');
            $('#input_name').val('');
            $('#input_value').val('');
        }
        function showEditDialog(id) {
            current_id = id;
            $('#addCurrencyModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('통화 수정');
            $('#modal_button_add').text('수정');

            $.ajax({
                url: 'admin.getCurrencyInformation',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        var list = data.lists;
                        var id = list.id;
                        var name = list.name;
                        var value = list.value;

                        $('#input_name').val(name);
                        $('#input_value').val(value);
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function getCurrencyList() {
            $.ajax({
                url: 'admin.getAllCurrencyList',
                data: {
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_currency_list').html('');
                        var lists = data.c_lists;
                        var tags = '';
                        for (var i = 0; i < lists.length; i++) {
                            var list = lists[i];
                            var id = list.id;
                            var order = i + 1;
                            var name = list.name;
                            var value = list.value;
                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle">' + order + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + name + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + value + '</td>';
                            tags += '<td class="text-center align-middle">';
                            tags += '<div class="btn-group align-top pr-3">';
                            tags += '<button class="btn btn-sm btn-primary badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_'+id + '">수정<i class="fa fa-edit"></i></button>';
                            tags += '</div>';
                            tags += '<div class="btn-group align-top">';
                            tags += '<button class="btn btn-sm btn-red badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id="button_delete_' + id + '">삭제 <i class="fa fa-trash"></i></button>';
                            tags += '</div>';
                            tags += '</td>';
                            tags += '</tr>';
                        }
                        $('#tbody_currency_list').html(tags);

                        $('button[id^="button_edit_"]').click(function(){
                            var oid = $(this).attr("id");
                            var id = oid.split('_')[2];
                            showEditDialog(id);
                        });

                        $('button[id^="button_delete_"]').click(function(){
                            var oid = $(this).attr("id");
                            var id = oid.split('_')[2];
                            deleteCurrency(id);
                        });
                    }
                    else {
                        $('#tbody_currency_list').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function addCurrency() {
            var name = $('#input_name').val();
            var value = $('#input_value').val();
            if (name == '' || name == null) {
                $('#dlgErr').text('请输入名称').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (value == '' || value == null) {
                $('#dlgErr').text('请输入价格').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.currencyAdd',
                data: {
                    name: name,
                    value: value,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('추가성공').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addCurrencyModal").modal('hide');
                            getCurrencyList();
                        },1000);
                    }
                    else if (data.msg ==='du'){
                        $('#dlgErr').text('이름이 이미 존재합니다').css({'display':'block','color':'#d41b11'});
                    }
                    else {
                        $('#dlgErr').text('추가오류').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function editCurrency() {
            var name = $('#input_name').val();
            var value = $('#input_value').val();
            if (name == '' || name == null) {
                $('#dlgErr').text('请输入名称').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (value == '' || value == null) {
                $('#dlgErr').text('请输入价格').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.editCurrencyInformation',
                data: {
                    id: current_id,
                    name: name,
                    value: value,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('수정 성공').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addCurrencyModal").modal('hide');
                            getCurrencyList();
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

        function deleteCurrency(id) {
            if(confirm('真的删除？')==false)
                return;
            $.ajax({
                url: 'admin.currencyDelete',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        getCurrencyList();
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
    </script>
@endsection
