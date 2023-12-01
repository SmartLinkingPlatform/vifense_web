<!-- Mobile Header -->
                <div class="mobile-header">
                    <div class="container-fluid">
                        <div class="d-flex">
                            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
                            <a class="header-brand" href="{{ url('/' . $page='index') }}">
                                <img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
                                <img src="{{URL::asset('assets/images/brand/logo-3.png')}}" class="header-brand-img desktop-logo mobile-light" alt="logo">
                            </a>
                            <div class="d-flex order-lg-2 ml-auto header-right-icons">
                                <div class="dropdown profile-1">
                                    <a href="#" data-toggle="dropdown" class="nav-link pr-2 leading-none d-flex">
                                        <span>
                                            <img src="{{URL::asset('assets/images/users/admin.png')}}" alt="profile-user" class="avatar  profile-user brround cover-image">
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <div class="drop-heading">
                                            <div class="text-center">
                                                <h5 class="text-dark mb-0">
                                                    {{{ Session::get('user_name') }}}
                                                </h5>
                                                <small class="text-muted">
                                                    {{{ Session::get('user_id') }}}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="dropdown-item btn"id="mobile_notification_logout_{{ Session::get('user') }}">
                                            <i class="dropdown-icon mdi  mdi-logout-variant"></i> 로그아웃
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-1 navbar navbar-expand-lg  responsive-navbar navbar-dark d-md-none bg-white">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2 ml-auto">
                            <div class="dropdown d-sm-flex">
                                <a href="#" class="nav-link icon" data-toggle="dropdown">
                                    <i class="fe fe-search"></i>
                                </a>
                                <div class="dropdown-menu header-search dropdown-menu-left">
                                    <div class="input-group w-100 p-2">
                                        <input type="text" class="form-control " placeholder="Search....">
                                        <div class="input-group-append ">
                                            <button type="button" class="btn btn-primary ">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- SEARCH -->
                            <div class="dropdown d-md-flex">
                                <a class="nav-link icon full-screen-link nav-link-bg">
                                    <i class="fe fe-maximize fullscreen-button"></i>
                                </a>
                            </div><!-- FULL-SCREEN -->
                            <div class="dropdown d-md-flex notifications">
                                <a class="nav-link icon" data-toggle="dropdown">
                                    <i class="fe fe-bell"></i>
                                </a>
                            </div><!-- NOTIFICATIONS -->
                        </div>
                    </div>
                </div>
<!-- /Mobile Header -->
