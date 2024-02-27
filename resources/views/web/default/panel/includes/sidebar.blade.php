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
                                    <span class="font-14 text-dark-blue">{{ trans('public.my_panel') }}</span>
                                </a>
                                @if($authUser->isTeacher() or $authUser->isOrganization())
                                <a class="dropdown-item" href="{{ $authUser->getProfileUrl() }}">
                                    <img src="/assets/default/img/icons/profile.svg" width="25" height="auto" itemprop="image" alt="nav-icon"  title="nav-icon" loading="eager">
                                    <span class="font-14 text-dark-blue">{{ trans('publimc.y_profile') }}</span>
                                </a>
                                @endif
                                <a class="dropdown-item" href="/logout">
                                    <img src="/assets/default/img/icons/sidebar/logout.svg" height="auto" itemprop="image" width="25" alt="nav-icon"  title="nav-icon" loading="eager">
                                    <span class="font-14 text-dark-blue">{{ trans('panel.log_out') }}</span>
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center ml-md-50">
                            <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-14 login-btn">{{ trans('auth.login') }}</a>
                            <a href="/register" class="py-5 px-15 text-dark-blue font-14 register-btn">Get Started</a>
                        </div>
                        @endif
                    </div>

                </div>

    <a class="sidebar-logo"
       href="{{url('/')}}/" itemprop="url">
        <img src="/assets/default/img/sidebar/logo.svg"><span class="sidebar-logo-text">Rurera</span>
    </a>
    <button class="navbar-toggler navbar-order" type="button" id="navbarToggle">
        <span class="navbar-toggler-icon"></span>
    </button>
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
                    <a href="/panel" class="d-flex align-items-center font-15">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/home.svg">
                        </span>
                        <span>Home</span>
                    </a>
                </li>
                    <li class="sidenav-item {{ (request()->is('learn') or request()->is('learn/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                            <span class="sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/learn.svg">
                            </span>
                            <span><a href="/learn" class="font-15">Learn <img src="/assets/default/svgs/crown.svg" class="crown-icon"></a></span>
                        </a>
                    </li>
                    <li class="sidenav-item {{ (request()->is('timestables-practice') or request()->is('timestables-practice/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                            <span class="sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/timestable.svg">
                            </span>
                            <span><a href="/timestables-practice" class="font-15">TimesTable</a></span>
                        </a>
                    </li>
                    <li class="sidenav-item {{ (request()->is('spells') or request()->is('spells/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                            <span class="sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/spell.svg">
                            </span>
                            <span><a href="/spells" class="font-15">Word Lists</a></span>
                        </a>
                    </li>
                    <li class="sidenav-item {{ (request()->is('books') or request()->is('books/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                            <span class="sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/books.svg">
                            </span>
                            <span><a href="/books" class="font-15">Books <img src="/assets/default/svgs/crown.svg" class="crown-icon"></a></span>
                        </a>
                    </li>
                <li class="sidenav-item {{ (request()->is('tests') or request()->is('tests/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/test.svg">
                        </span>
                        <span><a href="/tests" class="font-15">Test <img src="/assets/default/svgs/crown.svg" class="crown-icon"></a></span>
                    </a>
                </li>

                @if(auth()->user()->isUser())
                <li class="sidenav-item {{ (request()->is('shop') or request()->is('shop/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/shop.svg">
                        </span>
                        <span><a href="/shop" class="font-15">Shop</a></span>
                    </a>
                </li>
                @endif
                <li class="sidenav-item {{ (request()->is('panel/analytics') or request()->is('panel/analytics/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/grarph.svg">
                        </span>
                        <span><a href="/panel/analytics" class="font-15">Analytics</a></span>
                    </a>
                </li>
                <li class="sidenav-item {{ (request()->is('panel/setting') or request()->is('panel/setting/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                            <img src="{{ $authUser->getAvatar() }}" alt="{{ $authUser->full_name }}" class="img-circle">
                        </span>
                        <span><a href="/panel/setting" class="font-15">Profile</a></span>
                    </a>
                </li>
                 <li class="sidenav-item {{ (request()->is('panel/marketing/affiliates') or request()->is('panel/marketing/affiliates/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                            <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                                <img src="/assets/default/img/sidebar/referrals.png">
                            </span>
                            <span><a href="/panel/marketing/affiliates" class="font-15">Referrals</a></span>
                        </a>
                    </li>
            @if(auth()->user()->isParent())
                <li class="sidenav-item {{ (request()->is('panel/members') or request()->is('panel/members/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-setting-icon sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/members.png">
                        </span>
                        <span><a href="/panel/members" class="font-15">Members</a></span>
                    </a>
                </li>
            @endif
            @if(!auth()->user()->isUser())
                <li class="sidenav-item {{ (request()->is('panel/analytics') or request()->is('panel/analytics/*')) ? 'sidenav-item-active' : '' }} dropdown show">

                    <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon mr-20">
                            <img src="/assets/default/img/sidebar/more.svg">
                        </span>
                        <a href="javascript:;" class="dropdown-toggle font-15" id="sub-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</a>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="sub-dropdown">
                        <ul>
                            <li><a class="font-15" href="/faqs">FAQs</a></li>
                            <li><a class="font-15" href="/custom_html">Custom HTML</a></li>
                            <li><a class="font-15" href="/logout">Logout</a></li>
                            <li><a class="font-15" href="#">More</a></li>
                        </ul>
                    </div>
                </li>
            @endif




                <!--
                <li class="sidenav-item {{ (request()->is('panel/analytics') or request()->is('panel/analytics/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon mr-10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none">
                                <path d="M3 3V21" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 21H3" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 16L12.25 10.75L15.75 14.25L21 9" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="font-14 text-dark-blue font-weight-500"><a href="/panel/analytics">Analytics</a></span>
                    </a>
                </li>-->


                <!--<li class=" sidenav-item {{ (request()->is('panel/certificates') or request()->is('panel/certificates/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon mr-10">
                            @include('web.default.panel.includes.sidebar_icons.certificate')
                        </span>
                        <span class="font-14 text-dark-blue font-weight-500"><a href="/panel/certificates/achievements">{{ trans('panel.certificates') }}</a></span>
                    </a>

                </li>-->
                <!--

                    <li class="sidenav-item {{ (request()->is('panel/store') or request()->is('panel/store/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-fill mr-10">
                            @include('web.default.panel.includes.sidebar_icons.store')
                        </span>
                            <span class="font-14 text-dark-blue font-weight-500"><a href="/panel/store/purchases">Purchases</a></span>
                        </a>
                    </li>

               <li class="rurera-hide sidenav-item {{ (request()->is('panel/support') or request()->is('panel/support/*')) ? 'sidenav-item-active' : '' }}">
                    <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-fill mr-10">
                            @include('web.default.panel.includes.sidebar_icons.support')
                        </span>
                        <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.support') }}</span>
                    </a>

                    <div class="sidenav-dropdown {{ (request()->is('panel/support') or request()->is('panel/support/*')) ? 'show' : '' }}" id="supportCollapse">
                        <ul class="sidenav-item-collapse">
                            <li class="mt-5 {{ (request()->is('panel/support/new')) ? 'active' : '' }}">
                                <a href="/panel/support/new">{{ trans('public.new') }}</a>
                            </li>
                            <li class="mt-5 {{ (request()->is('panel/support')) ? 'active' : '' }}">
                                <a href="/panel/support">{{ trans('panel.classes_support') }}</a>
                            </li>
                            <li class="mt-5 {{ (request()->is('panel/support/tickets')) ? 'active' : '' }}">
                                <a href="/panel/support/tickets">{{ trans('panel.support_tickets') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>-->

                @if(getFeaturesSettings('forums_status'))
                    <li class="sidenav-item {{ (request()->is('panel/forums') or request()->is('panel/forums/*')) ? 'sidenav-item-active' : '' }}">
                        <a class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-fill mr-10">
                            @include('web.default.panel.includes.sidebar_icons.forums')
                        </span>
                            <span class="font-14 text-dark-blue font-weight-500">{{ trans('update.forums') }}</span>
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
                            <span class="font-14 text-dark-blue font-weight-500">{{ trans('update.articles') }}</span>
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

                            <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.noticeboard') }}</span>
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
                <!--
                @if(!empty($rewardSetting) and $rewardSetting['status'] == '1')
                    <li class="sidenav-item {{ (request()->is('panel/rewards')) ? 'sidenav-item-active' : '' }}">
                        <a href="/panel/rewards" class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-strock mr-10">
                            @include('web.default.panel.includes.sidebar_icons.rewards')
                        </span>
                            <span class="font-14 text-dark-blue font-weight-500">{{ trans('update.rewards') }}</span>
                        </a>
                    </li>
                @endif-->

                <!--<li class="rurera-hide sidenav-item {{ (request()->is('panel/notifications')) ? 'sidenav-item-active' : '' }}">
                    <a href="/panel/notifications" class="d-flex align-items-center">
                    <span class="sidenav-notification-icon sidenav-item-icon mr-10">
                            @include('web.default.panel.includes.sidebar_icons.notifications')
                        </span>
                        <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.notifications') }}</span>
                    </a>
                </li>-->
                <!--
                <li class="sidenav-item {{ (request()->is('panel/setting')) ? 'sidenav-item-active' : '' }}">
                    <a href="/panel/setting" class="d-flex align-items-center">
                        <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                            @include('web.default.panel.includes.sidebar_icons.setting')
                        </span>
                        <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.settings') }}</span>
                    </a>
                </li>-->

                @if($authUser->isTeacher() or $authUser->isOrganization())
                    <li class="sidenav-item ">
                        <a href="{{ $authUser->getProfileUrl() }}" class="d-flex align-items-center">
                        <span class="sidenav-item-icon assign-strock mr-10">
                            <i data-feather="user" stroke="#1f3b64" stroke-width="1.5" width="24" height="24" class="mr-10 webinar-icon"></i>
                        </span>
                            <span class="font-14 text-dark-blue font-weight-500">{{ trans('public.my_profile') }}</span>
                        </a>
                    </li>
                @endif

                <!--<li class="sidenav-item rurera-hide">
                    <a href="/logout" class="d-flex align-items-center">
                        <span class="sidenav-logout-icon sidenav-item-icon mr-10">
                            @include('web.default.panel.includes.sidebar_icons.logout')
                        </span>
                        <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.log_out') }}</span>
                    </a>
                </li>-->
            </ul>
    </div>

</div>
</div>
