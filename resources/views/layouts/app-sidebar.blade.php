<!--APP-SIDEBAR-->
                <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
                <aside class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="{{ url('/' . $page='admin.dashboard-view') }}">
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
                                    {{{ Session::get('user_name') }}}
                                </h6>
                                <span class="text-muted app-sidebar__user-name text-sm">
                                    {{{ Session::get('user_id') }}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <ul class="side-menu">

                        @if (Session::get('user_type') == '1')
                            <li>
                                <a class="side-menu__item" href="{{ url('/' . $page='admin.companyinfo') }}">
                                    <i class="side-menu__icon mdi mdi-account-key"></i><span class="side-menu__label">회사 정보</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="side-menu__item" href="{{ url('/' . $page='admin.personinfo') }}">
                                <i class="side-menu__icon mdi mdi-account-circle"></i><span class="side-menu__label">개인 정보</span>
                            </a>
                        </li>
                        <li>
                            <a class="side-menu__item" href="{{ url('/' . $page='admin.day-driver-info') }}">
                                <i class="side-menu__icon fa fa-list-alt"></i><span class="side-menu__label">일별 주행 정보</span>
                            </a>
                        </li>
                        <li>
                            {{$search = ""}}
                            <a class="side-menu__item" href="{{ url('/' . $page='admin.user-driver-info/'.$search) }}">
                                <i class="side-menu__icon fa fa-search"></i><span class="side-menu__label">사용자별 주행 정보</span>
                            </a>
                        </li>
                        <li>
                            <a class="side-menu__item" href="{{ url('/' . $page='user.notice') }}">
                                <i class="side-menu__icon mdi mdi-basket-unfill"></i><span class="side-menu__label">공지 사항</span>
                            </a>
                        </li>
                        <li>
                            <a class="side-menu__item" href="{{ url('/' . $page='admin.currency') }}">
                                <i class="side-menu__icon fa fa-yen"></i><span class="side-menu__label">업로드 html</span>
                            </a>
                        </li>
                    </ul>
                </aside>
<!--/APP-SIDEBAR-->
