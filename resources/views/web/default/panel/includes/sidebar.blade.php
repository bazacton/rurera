@php
    $getPanelSidebarSettings = getPanelSidebarSettings();
@endphp


<div class="panel-sidebar px-25 pt-15" id="panelSidebar" style="position: inherit;top: 0px;">
    <div class="container">
    <div class="nav-icons-or-start-live navbar-order">
        <div class="xs-w-100 d-flex align-items-center justify-content-between ">
            @if(!empty($authUser))
            <div class="d-flex">
                <div class="border-left mx-5 mx-lg-15"></div>
            </div>
            @endif

            @if(!empty($authUser))

            <div class="dropdown">

                <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                    <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                        <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
                    </div>

                    <a class="dropdown-item" href="{{ $authUser->isAdmin() ? '/admin' : '/panel' }}">
                        <img src="/assets/default/img/icons/sidebar/dashboard.svg" width="25" height="auto" itemprop="image" alt="nav-icon" title="nav-icon" loading="eager">
                        <span class="font-16 text-dark-blue">{{ trans('public.my_panel') }}</span>
                    </a>
                    @if($authUser->isTeacher() or $authUser->isOrganization())
                    <a class="dropdown-item" href="{{ $authUser->getProfileUrl() }}">
                        <img src="/assets/default/img/icons/profile.svg" width="25" height="auto" itemprop="image" alt="nav-icon"  title="nav-icon" loading="eager">
                        <span class="font-16 text-dark-blue">{{ trans('publimc.y_profile') }}</span>
                    </a>
                    @endif
                    <a class="dropdown-item" href="/logout">
                        <img src="/assets/default/img/icons/sidebar/logout.svg" height="auto" itemprop="image" width="25" alt="nav-icon"  title="nav-icon" loading="eager">
                        <span class="font-16 text-dark-blue">{{ trans('panel.log_out') }}</span>
                    </a>
                </div>
            </div>
            @else
            <div class="d-flex align-items-center ml-md-50">
                <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-16 login-btn">{{ trans('auth.login') }}</a>
                <a href="/register" class="py-5 px-15 text-dark-blue font-16 register-btn">Get Started</a>
            </div>
            @endif
        </div>
    </div>
    <a class="sidebar-logo"
       href="{{url('/')}}/" itemprop="url">
        <img src="/assets/default/img/sidebar/logo.svg"><span class="sidebar-logo-text">Rurera</span>
    </a>
    <div class="sidebar-menu-holder">
        <div class="sidebar-menu-top">
        <a class="sidebar-logo"
              href="{{url('/')}}/" itemprop="url">
               <img src="/assets/default/img/sidebar/logo.svg"><span class="sidebar-logo-text">Rurera</span>
         </a>
        <button class="navbar-toggler navbar-order" type="button" id="navbarToggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        </div>
        <ul class="sidebar-menu pt-10 @if(!empty($authUser->userGroup)) has-user-group @endif @if(empty($getPanelSidebarSettings) or empty($getPanelSidebarSettings['background'])) without-bottom-image @endif" @if((!empty($isRtl) and $isRtl)) data-simplebar-direction="rtl" @endif>
                <li class="sidenav-item {{ (request()->is('panel')) ? 'sidenav-item-active' : '' }}">
                    <a href="/{{panelRoute()}}" class="d-flex align-items-center font-16">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/home.svg">
                        </span>
                        <span class="nav-sub-title font-16">Home</span>
                    </a>
                </li>
            @if(auth()->user()->isParent() || auth()->user()->isTutor())
                <li class="sidenav-item {{ (request()->is('panel/set-work') or request()->is('panel/set-work/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center" href="/{{panelRoute()}}/set-work">
                        <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/set-work.svg">
                        </span>
                    </a>
                    <a href="/{{panelRoute()}}/set-work/create" class="font-16 nav-sub-title">Set Work</a>
                </li>

            @endif
            @if(auth()->user()->isUser())
                    <li class="sidenav-item {{ (request()->is('learn') or request()->is('learn/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center" href="/learn">
                            <span class="sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/learn.svg">
                            </span>
                        </a>
                            <a href="/learn" class="font-16 nav-sub-title">Learn @if(!auth()->subscription('courses'))<img src="/assets/default/svgs/crown.svg" class="crown-icon">@endif</a>
                    </li>
					@if(auth()->user()->show_timestables == 1)
						<li class="sidenav-item {{ (request()->is('timestables-practice') or request()->is('timestables-practice/*')) ? 'sidenav-item-active' : '' }}">
							<a class="d-flex align-items-center" href="/timestables-practice">
								<span class="sidenav-item-icon mr-20">
									<img src="/assets/default/img/sidebar/timestable.svg">
								</span>
							</a>
							<a href="/timestables-practice" class="font-16 nav-sub-title">TimesTable</a>
						</li>
					@endif
					@if(auth()->user()->show_spellings == 1)
                    <li class="sidenav-item {{ (request()->is('spells') or request()->is('spells/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center" href="/spells">
                            <span class="sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/spell.svg">
                            </span>
                        </a>
                        <a href="/spells" class="font-16 nav-sub-title">Word Lists</a>
                    </li>
					@endif
					@if(auth()->user()->show_books == 1)
                    <li class="sidenav-item {{ (request()->is('books') or request()->is('books/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center" href="/books">
                            <span class="sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/books.svg">
                            </span>
                        </a>
                            <a href="/books" class="font-16 nav-sub-title">Books @if(!auth()->subscription('bookshelf'))<img src="/assets/default/svgs/crown.svg" class="crown-icon">@endif</a>
                    </li>
					@endif
                
				@if(auth()->user()->show_sats == 1)
				<li class="sidenav-item {{ (request()->is('tests') or request()->is('tests/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center" href="/tests">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/test.svg">
                        </span>
                    </a>

                    <a href="/tests" class="font-16 nav-sub-title">Test @if(!auth()->subscription('sats'))<img src="/assets/default/svgs/crown.svg" class="crown-icon">@endif</a>

                </li>
				@endif

             <li class="sidenav-item {{ (request()->is('quests') or request()->is('quests/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center" href="/quests">
                    <span class="sidenav-item-icon mr-20">
                        <img src="/assets/default/img/sidebar/quests.svg">
                    </span>
                </a>
                <a href="/quests" class="font-16 nav-sub-title">Quests</a>
            </li>
            @endif

                @if(auth()->user()->isUser())
					
				@if(auth()->user()->hide_games == 0)
                <li class="sidenav-item {{ (request()->is('games') or request()->is('games/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center" href="/games">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/games.svg">
                        </span>
                    </a>
                    <a href="/games" class="font-16 nav-sub-title">Games</a>
                </li>
				@endif
                <li class="sidenav-item {{ (request()->is('shop') or request()->is('shop/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center" href="/shop">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/shop.svg">
                        </span>
                    </a>
                    <a href="/shop" class="font-16 nav-sub-title">Shop</a>
                </li>
                @endif
                <li class="sidenav-item {{ (request()->is('panel/analytics') or request()->is('panel/analytics/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center" href="/{{panelRoute()}}/analytics">
                        <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/grarph.svg">
                        </span>
                    </a>
                    <a href="/{{panelRoute()}}/analytics" class="font-16 nav-sub-title">Analytics</a>
                </li>

            @if(auth()->user()->isUser())
                <li class="sidenav-item {{ (request()->is('school-zone') or request()->is('school-zone/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center" href="/school-zone">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/svgs/school-zone.svg">
                        </span>
                    </a>
                    <a href="/school-zone" class="font-16 nav-sub-title">School Zone</a>
                </li>
            @endif
            <li class="sidenav-item {{ (request()->is('panel/marketing/affiliates') or request()->is('panel/marketing/affiliates/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center" href="/{{panelRoute()}}/marketing/affiliates">
                    <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                        <img src="/assets/default/img/sidebar/referrals.png">
                    </span>
                </a>
                <a href="/{{panelRoute()}}/marketing/affiliates" class="font-16 nav-sub-title">Referrals</a>
            </li>


            @if(auth()->user()->isParent() || auth()->user()->isTutor())
                <li class="sidenav-item {{ (request()->is('panel/students') or request()->is('panel/students/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center" href="/{{panelRoute()}}/students">
                        <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/members.png">
                        </span>
                    </a>
                    <a href="/{{panelRoute()}}/students" class="font-16 nav-sub-title">Students</a>
                </li>
                

            @endif

            <li class="sidenav-item {{ (request()->is('panel/setting') or request()->is('panel/setting/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center" href="/{{panelRoute()}}/setting">
                    <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                        <img src="{{ $authUser->getAvatar() }}" alt="{{ $authUser->get_full_name() }}" class="img-circle">
                    </span>
                </a>
                <a href="/{{panelRoute()}}/setting" class="font-16 nav-sub-title">Profile</a>
            </li>

            <li class="sidenav-item {{ (request()->is('logout') or request()->is('logout/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center" href="/logout">
                    <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                        <img src="/assets/default/img/sidebar/logout.svg">
                    </span>
                </a>
                <a href="/logout" class="font-16 nav-sub-title">Logout</a>
            </li>
                @if(getFeaturesSettings('forums_status'))
                    <li class="sidenav-item {{ (request()->is('panel/forums') or request()->is('panel/forums/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-fill mr-10">
                            @include('web.default.panel.includes.sidebar_icons.forums')
                        </span>
                            <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.forums') }}</span>
                        </a>

                        <div class="sidenav-dropdown {{ (request()->is('panel/forums') or request()->is('panel/forums/*')) ? 'show' : '' }}" id="forumsCollapse">
                            <ul class="sidenav-item-collapse">
                                <li class="mt-5 {{ (request()->is('panel/forums/topics')) ? 'active' : '' }}">
                                    <a href="/forums/create-topic">{{ trans('update.new_topic') }}</a>
                                </li>
                                <li class="mt-5 {{ (request()->is('panel/forums/topics')) ? 'active' : '' }}">
                                    <a href="/panel/forums/topics">{{ trans('update.my_topics') }}</a>
                                </li>

                                <li class="mt-5 {{ (request()->is('panel/forums/posts')) ? 'active' : '' }}">
                                    <a href="/panel/forums/posts">{{ trans('update.my_posts') }}</a>
                                </li>

                                <li class="mt-5 {{ (request()->is('panel/forums/bookmarks')) ? 'active' : '' }}">
                                    <a href="/panel/forums/bookmarks">{{ trans('update.bookmarks') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif


                @if($authUser->isTeacher())
                    <li class="sidenav-item {{ (request()->is('panel/blog') or request()->is('panel/blog/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-fill mr-10">
                            @include('web.default.panel.includes.sidebar_icons.blog')
                        </span>
                            <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.articles') }}</span>
                        </a>
                        <div class="sidenav-dropdown {{ (request()->is('panel/blog') or request()->is('panel/blog/*')) ? 'show' : '' }}" id="blogCollapse">
                            <ul class="sidenav-item-collapse">
                                <li class="mt-5 {{ (request()->is('panel/blog/posts/new')) ? 'active' : '' }}">
                                    <a href="/panel/blog/posts/new">{{ trans('update.new_article') }}</a>
                                </li>

                                <li class="mt-5 {{ (request()->is('panel/blog/posts')) ? 'active' : '' }}">
                                    <a href="/panel/blog/posts">{{ trans('update.my_articles') }}</a>
                                </li>

                                <li class="mt-5 {{ (request()->is('panel/blog/comments')) ? 'active' : '' }}">
                                    <a href="/panel/blog/comments">{{ trans('panel.comments') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if($authUser->isOrganization() || $authUser->isTeacher())
                    <li class="sidenav-item {{ (request()->is('panel/noticeboard*') or request()->is('panel/course-noticeboard*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon mr-10">
                            @include('web.default.panel.includes.sidebar_icons.noticeboard')
                        </span>

                            <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.noticeboard') }}</span>
                        </a>

                        <div class="sidenav-dropdown {{ (request()->is('panel/noticeboard*') or request()->is('panel/course-noticeboard*')) ? 'show' : '' }}" id="noticeboardCollapse">
                            <ul class="sidenav-item-collapse">
                                <li class="mt-5 {{ (request()->is('panel/noticeboard')) ? 'active' : '' }}">
                                    <a href="/panel/noticeboard">{{ trans('public.history') }}</a>
                                </li>

                                <li class="mt-5 {{ (request()->is('panel/noticeboard/new')) ? 'active' : '' }}">
                                    <a href="/panel/noticeboard/new">{{ trans('public.new') }}</a>
                                </li>

                                <li class="mt-5 {{ (request()->is('panel/course-noticeboard')) ? 'active' : '' }}">
                                    <a href="/panel/course-noticeboard">{{ trans('update.course_notices') }}</a>
                                </li>

                                <li class="mt-5 {{ (request()->is('panel/course-noticeboard/new')) ? 'active' : '' }}">
                                    <a href="/panel/course-noticeboard/new">{{ trans('update.new_course_notices') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @php
                    $rewardSetting = getRewardsSettings();
                @endphp

                @if($authUser->isTeacher() or $authUser->isOrganization())
                    <li class="sidenav-item ">
                        <a href="{{ $authUser->getProfileUrl() }}" class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-strock mr-10">
                            <i data-feather="user" stroke="#1f3b64" stroke-width="1.5" width="24" height="24" class="mr-10 webinar-icon"></i>
                        </span>
                            <span class="font-16 text-dark-blue font-weight-500">{{ trans('public.my_profile') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
    </div>
</div>
</div>
<div class="modal fade subscription-modal" id="subscription-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        @include('web.default.panel.unauthorized_modal', array(
            'title'             => 'Unauthorized',
            'unauthorized_text' => 'You are not authorize for this page',
            'unauthorized_link' => '/panel',
        ))
      </div>
    </div>
  </div>
</div>