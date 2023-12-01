<!--APP-SIDEBAR-->
                <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
                <aside class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="{{ url('/' . $page='admin.admin') }}">
                            <img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
                            <img src="{{URL::asset('assets/images/brand/logo-1.png')}}"  class="header-brand-img toggle-logo" alt="logo">
                            <img src="{{URL::asset('assets/images/brand/logo-2.png')}}" class="header-brand-img light-logo" alt="logo">
                            <img src="{{URL::asset('assets/images/brand/logo-3.png')}}" class="header-brand-img light-logo1" alt="logo">
                        </a><!-- LOGO -->
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
                    </div>
                    <div class="app-sidebar__user">
                        <div class="dropdown user-pro-body text-center">
                            <div class="user-pic">
                                <img src="{{URL::asset('assets/images/users/admin.png')}}" alt="user-img" class="avatar-xl rounded-circle">
                            </div>
                            <div class="user-info">
                                <h6 class=" mb-0 text-dark">
                                    @if (Session::get('user') == 'admin')
                                        {{{ Session::get('admin_name') }}}
                                    @elseif (Session::get('user') == 'user')
                                        {{{ Session::get('user_name') }}}
                                    @else
                                        관리자
                                    @endif
                                </h6>
                                <span class="text-muted app-sidebar__user-name text-sm">
                                    @if (Session::get('user') == 'admin')
                                        {{{ Session::get('admin_account') }}}
                                    @elseif (Session::get('user') == 'user')
                                        {{{ Session::get('user_account') }}}
                                    @else
                                        Administrator
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <ul class="side-menu">

                        @if (Session::get('user') == 'admin')
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.admin') }}"><i class="side-menu__icon mdi mdi-account-key"></i><span class="side-menu__label">관리자 관리</span></a>
                            </li>
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.user') }}"><i class="side-menu__icon mdi mdi-account-circle"></i><span class="side-menu__label">회원 계정 관리</span></a>
                            </li>
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.order-manage') }}"><i class="side-menu__icon fa fa-list-alt"></i><span class="side-menu__label">회원 청구서 관리</span></a>
                            </li>
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.order-history') }}"><i class="side-menu__icon fa fa-search"></i><span class="side-menu__label">회원 청구서 요약 조회</span></a>
                            </li>
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.outcome') }}"><i class="side-menu__icon mdi mdi-basket-unfill"></i><span class="side-menu__label">지출 관리</span></a>
                            </li>
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.currency') }}"><i class="side-menu__icon fa fa-yen"></i><span class="side-menu__label">자금 관리</span></a>
                            </li>
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.item') }}"><i class="fe fe-file-text mr-2 fs-20 text-primary-shadow"></i><span class="side-menu__label">프로젝트 유형</span></a>
                            </li>
                        @elseif (Session::get('user') == 'user')
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='user.user') }}"><i class="side-menu__icon mdi mdi-account-circle"></i><span class="side-menu__label">정보 관리</span></a>
                            </li>
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='user.order-history') }}"><i class="side-menu__icon fa fa-search"></i><span class="side-menu__label">결제 세부 정보</span></a>
                            </li>
                        @else

                        @endif
                    </ul>
                </aside>
<!--/APP-SIDEBAR-->
