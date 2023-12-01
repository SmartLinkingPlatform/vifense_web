@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">회원 계정 관리</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">관리 시스템</a></li>
            <li class="breadcrumb-item active" aria-current="page">회원 계정 관리</li>
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
                            <h2 class="card-title" style="margin-left: 7px;">회원목록</h2>
                            <div class="page-options d-flex float-right">
                                <div class="btn btn-success" id="button_add" style="width: 80px; margin-right: 10px;">
                                    <i class="icon icon-plus"></i>
                                    添加
                                </div>
                            </div>
                        </div>
                        <div class="e-table px-5 pb-5">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th >번호</th>
                                        <th >계정</th>
                                        <th >이름</th>
                                        <th >날자</th>
                                        <th class="text-center" style="width: 200px;">액션</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody_user_list">
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
    <div class="modal fade" id="addUserModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal_title" style="color: #5c6bc0; font-size: 20px; font-weight: 600;">新增会员</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row"  id="dlgErr" style="display: none; padding-left: 15px;">
                        <div class="col">
                            error;
                        </div>
                    </div>
                    <div >
                        <div class="form-group row d-flex">
                            <div class="col-md-2 pl-3">
                                <label class="form-label">계정</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="input_account" class="form-control" name="example-text-input" placeholder="계정">
                            </div>
                        </div>
                        <div class="form-group row d-flex">
                            <div class="col-md-2 pl-3">
                                <label class="form-label">이름</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="input_name" class="form-control" name="example-text-input" placeholder="이름">
                            </div>
                        </div>
                        <div class="form-group row d-flex">
                            <div class="col-md-2 pl-3">
                                <label class="form-label">비밀번호</label>
                            </div>
                            <div class="col-md-10">
                                <input type="password" id="input_password" class="form-control" name="example-text-input" placeholder="비밀번호">
                            </div>
                        </div>
                        <div class="form-group row d-flex">
                            <div class="col-md-2 pl-3">
                                <label class="form-label">비밀번호 확인</label>
                            </div>
                            <div class="col-md-10">
                                <input type="password" id="input_password_confirm" class="form-control" name="example-text-input" placeholder="비밀번호 확인">
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
        var pnum = pstart;
        var pcount=5;
        var numg = 5;
        $(document).ready(function () {
            getUserList();

            $('#button_add').click(function(){
                showAddDialog();
            });

            $('#modal_button_add').click(function(){
                if (current_id == 0) {
                    addUser();
                }
                else {
                    editUser();
                }
            });
        });
        function showAddDialog() {
            current_id = 0;
            $('#addUserModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('新增会员');
            $('#modal_button_add').text('添加');
            $('#input_name').val('');
            $('#input_account').val('').prop('readonly', false);
            $('#input_password').val('');
            $('#input_password_confirm').val('');
        }
        function showEditDialog(id) {
            current_id = id;
            $('#addUserModal').modal('show');
            $('#dlgErr').text('').css({'display':'none'});
            $('#modal_title').text('회원 수정');
            $('#modal_button_add').text('수정');
            $('#input_account').prop('readonly', true);

            $.ajax({
                url: 'admin.getUserInformation',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        var list = data.lists;
                        var id = list.id;
                        var account = list.account;
                        var password = data.pwd;
                        var name = list.name;

                        $('#input_name').val(name);
                        $('#input_account').val(account);
                        $('#input_password').val(password);
                        $('#input_password_confirm').val(password);
                    }
                    else {
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function getUserList() {
            $.ajax({
                url: 'admin.getUserList',
                data: {
                    start: pstart,
                    count:pcount,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === "ok") {
                        $('#tbody_user_list').html('');
                        $('#page_nav_container').html('');
                        var lists = data.lists;
                        var tags = '';
                        pstart=data.start;
                        var totalpage=data.totalpage;
                        for (var i = 0; i < lists.length; i++) {
                            var list = lists[i];
                            var id = list.id;
                            var order = i + 1;
                            var account = list.account;
                            var name = list.name;
                            var create_date = list.created_at;
                            var dateString = create_date.split(' ')[0];
                            var temp = dateString.split('-');
                            var create_string = temp[1] + '/' + temp[2] + '/' + temp[0];
                            tags += '<tr>';
                            tags += '<td class="text-nowrap align-middle">' + order + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + account + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + name + '</td>';
                            tags += '<td class="text-nowrap align-middle">' + create_string + '</td>';
                            tags += '<td class="text-center align-middle">';
                            tags += '<div class="btn-group align-top pr-3 col-md-6 pb-1 justify-content-center">';
                            tags += '<button class="btn btn-sm btn-primary badge p-3 " data-target="#user-form-modal" data-toggle="modal" type="button" id = "button_edit_'+id + '">수정<i class="fa fa-edit"></i></button>';
                            tags += '</div>';
                            tags += '<div class="btn-group align-top col-md-6 pb-1 justify-content-center">';
                            tags += '<button class="btn btn-sm btn-red badge p-3" data-target="#user-form-modal" data-toggle="modal" type="button" id="button_delete_' + id + '">삭제 <i class="fa fa-trash"></i></button>';
                            tags += '</div>';
                            tags += '</td>';
                            tags += '</tr>';
                        }
                        $('#tbody_user_list').html(tags);

                        var nav_tag='';
                        nav_tag+='<nav aria-label="..." class="mb-4">';
                        nav_tag+='<ul class="pagination float-right">';
                        var disble="";
                        if(pstart==1)
                            disble="disabled";
                        var prenum= parseInt(pstart) - 1;
                        nav_tag+='<li class="page-item  '+disble+' ">';
                        nav_tag+='<a class="page-link" href="#"  id="page_nav_number_' + prenum + '" >';
                        nav_tag+='<i class="ti-angle-left"></i>';
                        nav_tag+='</a>';
                        nav_tag+='</li>';
                        pnum = pstart <= numg ? 1 : parseInt(pstart) - 1;
                        for(var idx = 0; idx < numg; idx++)
                        {
                            var actv="";
                            var aria_current='';
                            var spantag='';
                            var oid='';

                            if(pnum==pstart)
                            {
                                actv='active';
                                aria_current='aria-current="page"';
                                spantag='<span class="sr-only">(current)</span>';
                            }
                            else
                                oid="page_nav_number_" + pnum;

                            nav_tag+='<li class="page-item ' + actv + '"  ' + aria_current + '>';
                            nav_tag+='<a class="page-link" id="' + oid + '"  href="#" >' + pnum + '  ' + spantag + '</a>';
                            nav_tag+='</li>';

                            if(pnum==totalpage) break;
                            pnum = pnum + 1;
                        }
                        var nextnum= parseInt(pstart) + 1;

                        var edisble="";
                        if(pstart==totalpage)
                            edisble="disabled"

                        nav_tag+='<li class="page-item '+edisble+' ">';
                        nav_tag+='<a class="page-link" id="page_nav_number_' + nextnum + '" href="#">';
                        nav_tag+='<i class="ti-angle-right"></i>';
                        nav_tag+='</a>';
                        nav_tag+='</li>';
                        nav_tag+='</ul>';
                        nav_tag+='</nav>';
                        $('#page_nav_container').html(nav_tag);

                        /* events { */
                        $('a[id^="page_nav_number_"]').click(function(){
                            var oid=$(this).attr("id");
                            pstart=oid.split('_')[3];
                            getUserList();
                        });

                        $('button[id^="button_edit_"]').click(function(){
                            var oid = $(this).attr("id");
                            var id = oid.split('_')[2];
                            showEditDialog(id);
                        });

                        $('button[id^="button_delete_"]').click(function(){
                            var oid = $(this).attr("id");
                            var id = oid.split('_')[2];
                            deleteUser(id);
                        });
                    }
                    else {
                        $('#tbody_user_list').html('');
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function addUser() {
            var name = $('#input_name').val();
            var account = $('#input_account').val();
            var password = $('#input_password').val();
            var password_confirm = $('#input_password_confirm').val();
            if (account == '' || account == null) {
                $('#dlgErr').text('계정을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (name == '' || name == null) {
                $('#dlgErr').text('이름을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password == '' || password == null) {
                $('#dlgErr').text('비밀번호를 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password_confirm == '' || password_confirm == null) {
                $('#dlgErr').text('확인비밀번호을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password != password_confirm) {
                $('#dlgErr').text('비밀번호와 확인비밀번호가 같아야 합니다').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.userRegister',
                data: {
                    account:account,
                    name: name,
                    password: password,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('성공적으로 추가되였습니다').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addUserModal").modal('hide');
                            getUserList();
                        },1000);
                    }
                    else if (data.msg ==='du'){
                        $('#dlgErr').text('계정이 이미 존재합니다').css({'display':'block','color':'#d41b11'});
                    }
                    else {
                        $('#dlgErr').text('오류가 발생하였습니다').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function editUser() {
            var name = $('#input_name').val();
            var account = $('#input_account').val();
            var password = $('#input_password').val();
            var password_confirm = $('#input_password_confirm').val();
            if (account == '' || account == null) {
                $('#dlgErr').text('사용자계정을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (name == '' || name == null) {
                $('#dlgErr').text('이름을 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password == '' || password == null) {
                $('#dlgErr').text('비밀번호를 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password_confirm == '' || password_confirm == null) {
                $('#dlgErr').text('확인비밀번호를 입력하세요').css({'display':'block','color':'#d41b11'});
                return;
            }
            if (password != password_confirm) {
                $('#dlgErr').text('비밀번호와 확인비밀번호가 같아야 합니다').css({'display':'block','color':'#d41b11'});
                return;
            }

            $.ajax({
                url: 'admin.editUserInformation',
                data: {
                    id: current_id,
                    account: account,
                    name: name,
                    password: password,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        $('#dlgErr').text('수정되였습니다').css({'display':'block','color':'#0BC334'});
                        setTimeout(function () {
                            $("#addUserModal").modal('hide');
                            getUserList();
                        },1000);
                    }
                    else {
                        $('#dlgErr').text('오류가 발생하였습니다').css({'display':'block','color':'#d41b11'});
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }

        function deleteUser(id) {
            if(confirm('삭제하시겠습니까？')==false)
                return;
            $.ajax({
                url: 'admin.userDelete',
                data: {
                    id:id,
                },
                type: 'POST',
                success: function (data) {
                    if (data.msg === 'ok') {
                        getUserList();
                    }
                },
                error: function (jqXHR, errdata, errorThrown) {
                    console.log(errdata);
                }
            });
        }
    </script>
@endsection
