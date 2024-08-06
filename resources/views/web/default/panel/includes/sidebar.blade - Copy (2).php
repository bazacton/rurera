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


    <ul class="sidebar-menu pt-10 @if(!empty($authUser->userGroup)) has-user-group @endif @if(empty($getPanelSidebarSettings) or empty($getPanelSidebarSettings['background'])) without-bottom-image @endif" @if((!empty($isRtl) and $isRtl)) data-simplebar-direction="rtl" @endif>

        <li class="sidenav-item {{ (request()->is('panel')) ? 'sidenav-item-active' : '' }}">
            <a href="/panel" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.dashboard')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.dashboard') }}</span>
            </a>
        </li>

        <li class="sidenav-item {{ (request()->is('panel/analytics') or request()->is('panel/analytics/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none">
                        <path d="M3 3V21" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 21H3" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 16L12.25 10.75L15.75 14.25L21 9" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="font-16 text-dark-blue font-weight-500"><a href="/panel/analytics">Analytics</a></span>
            </a>
        </li>


        <!--<li class=" sidenav-item {{ (request()->is('panel/certificates') or request()->is('panel/certificates/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.certificate')
                </span>
                <span class="font-16 text-dark-blue font-weight-500"><a href="/panel/certificates/achievements">{{ trans('panel.certificates') }}</a></span>
            </a>

        </li>-->

            <li class="sidenav-item {{ (request()->is('panel/store') or request()->is('panel/store/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-fill mr-10">
                    @include('web.default.panel.includes.sidebar_icons.store')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500"><a href="/panel/store/purchases">Purchases</a></span>
                </a>
            </li>

       <li class="rurera-hide sidenav-item {{ (request()->is('panel/support') or request()->is('panel/support/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-fill mr-10">
                    @include('web.default.panel.includes.sidebar_icons.support')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.support') }}</span>
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
        </li>

        @if(!$authUser->isUser() or (!empty($referralSettings) and $referralSettings['status'] and $authUser->affiliate))
            <li class="sidenav-item {{ (request()->is('panel/marketing') or request()->is('panel/marketing/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.marketing')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.marketing') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/marketing') or request()->is('panel/marketing/*')) ? 'show' : '' }}" id="marketingCollapse">
                    <ul class="sidenav-item-collapse">
                        @if(!$authUser->isUser())
                            <li class="mt-5 {{ (request()->is('panel/marketing/special_offers')) ? 'active' : '' }}">
                                <a href="/panel/marketing/special_offers">{{ trans('panel.discounts') }}</a>
                            </li>
                            <li class="mt-5 {{ (request()->is('panel/marketing/promotions')) ? 'active' : '' }}">
                                <a href="/panel/marketing/promotions">{{ trans('panel.promotions') }}</a>
                            </li>
                        @endif

                        @if(!empty($referralSettings) and $referralSettings['status'] and $authUser->affiliate)
                            <li class="mt-5 {{ (request()->is('panel/marketing/affiliates')) ? 'active' : '' }}">
                                <a href="/panel/marketing/affiliates">{{ trans('panel.affiliates') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

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

        @if(!empty($rewardSetting) and $rewardSetting['status'] == '1')
            <li class="sidenav-item {{ (request()->is('panel/rewards')) ? 'sidenav-item-active' : '' }}">
                <a href="/panel/rewards" class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-strock mr-10">
                    @include('web.default.panel.includes.sidebar_icons.rewards')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.rewards') }}</span>
                </a>
            </li>
        @endif

        <!--<li class="rurera-hide sidenav-item {{ (request()->is('panel/notifications')) ? 'sidenav-item-active' : '' }}">
            <a href="/panel/notifications" class="d-flex align-items-center">
            <span class="sidenav-notification-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.notifications')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.notifications') }}</span>
            </a>
        </li>-->

        <li class="sidenav-item {{ (request()->is('panel/setting')) ? 'sidenav-item-active' : '' }}">
            <a href="/panel/setting" class="d-flex align-items-center">
                <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.setting')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.settings') }}</span>
            </a>
        </li>

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

        <!--<li class="sidenav-item rurera-hide">
            <a href="/logout" class="d-flex align-items-center">
                <span class="sidenav-logout-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.logout')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.log_out') }}</span>
            </a>
        </li>-->
    </ul>
</div>
</div>
