<!-- /Notification -->
							<div class="d-flex  ml-auto header-right-icons header-search-icon">
								<div class="dropdown d-md-flex">
									<a class="nav-link icon full-screen-link nav-link-bg">
										<i class="fe fe-maximize fullscreen-button"></i>
									</a>
								</div><!-- FULL-SCREEN -->
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
										<div class="dropdown-divider m-0"></div>
										<div class="dropdown-item btn" id="notification_logout_{{ Session::get('user') }}">
											<i class="dropdown-icon mdi  mdi-logout-variant"></i> 로그아웃
										</div>
									</div>
								</div>
							</div>
<!-- /Notification Ends -->

