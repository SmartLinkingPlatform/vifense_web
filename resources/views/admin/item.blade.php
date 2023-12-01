@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">프로젝트 유형</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page">프로젝트 유형</li>
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
                            <h2 class="card-title" style="margin-left: 7px;">항목 목록</h2>
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
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">새 항목 추가</div>
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
                                <input type="text" id="input_name" class="form-control" name="example-text-input" placeholder="名称">
                            </div>
                        </div>
                        <div class="form-group d-flex row">
                            <div class="col-md-2 pl-3">
                                <label class="form-label">가격</label>
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
        let current_id = 0;
        let pstart=1;
        $(document).ready(function () {
            getCurrencyList();

            $('#button_add').click(function(){
                showAddDialog();
            });

            $('#modal_button_add').click(function(){
                if (current_id === 0) {
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
            $('#modal_title').text('새 항목 추가');
            $('#modal_button_add').text('추가');
            $('#input_name').val('');
            $('#input_value').val('');
        }
        function showEditDialog(id) {
            current_id = id;
            $('#addCurrencyModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('프로젝트 수정');
            $('#modal_button_add').text('추가');

            $.ajax({
                url: 'admin.getItemInformation',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        let list = data.lists;
                        let id = list.id;
                        let name = list.name;
                        let value = list.value;

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
                url: 'admin.getAllItemList',
                data: {
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_currency_list').html('');
                        let lists = data.lists;
                        let tags = '';
                        for (let i = 0; i < lists.length; i++) {
                            let list = lists[i];
                            let id = list.id;
                            let order = i + 1;
                            let name = list.name;
                            let value = list.value;
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
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
                            showEditDialog(id);
                        });

                        $('button[id^="button_delete_"]').click(function(){
                            let oid = $(this).attr("id");
                            let id = oid.split('_')[2];
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
            let name = $('#input_name').val();
            let value = $('#input_value').val();
            if (name === '' || name == null) {
                $('#dlgErr').text('이름을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (value === '' || value == null) {
                $('#dlgErr').text('가격을 입력해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.itemAdd',
                data: {
                    name: name,
                    value: value,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('성공적으로 추가되었습니다').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addCurrencyModal").modal('hide');
                            getCurrencyList();
                        },1000);
                    }
                    else if (data.msg ==='du'){
                        $('#dlgErr').text('이름이 이미 존재합니다').css({'display':'block','color':'#d41b11'});
                    }
                    else {
                        $('#dlgErr').text('추가 오류').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function editCurrency() {
            let name = $('#input_name').val();
            let value = $('#input_value').val();
            if (name === '' || name == null) {
                $('#dlgErr').text('이름을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (value === '' || value == null) {
                $('#dlgErr').text('가격을 입력해주세요').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.editItemInformation',
                data: {
                    id: current_id,
                    name: name,
                    value: value,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('수정되었습니다').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addCurrencyModal").modal('hide');
                            getCurrencyList();
                        },1000);
                    }
                    else {
                        $('#dlgErr').text('수정 오류').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function deleteCurrency(id) {
            if(confirm('삭제하시겠습니까？') == false)
                return;
            $.ajax({
                url: 'admin.itemDelete',
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
