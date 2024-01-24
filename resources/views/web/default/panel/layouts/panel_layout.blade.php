<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];

    $isRtl = ((in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages)) or (!empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1));
        $rand_no = rand(99,9999);
@endphp
<head>
    @include(getTemplate().'.includes.metas')
    <title>{{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? (' | '.$generalSettings['site_name']) : '' }}</title>

    <!-- General CSS File -->
    <link href="/assets/default/css/font.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/simplebar/simplebar.css">
    <link rel="stylesheet" href="/assets/default/css/app.css?ver={{$rand_no}}">
    <link rel="stylesheet" href="/assets/default/css/panel.css?ver={{$rand_no}}">
    <link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">

    @if($isRtl)
        <link rel="stylesheet" href="/assets/default/css/rtl-app.css">
    @endif

    @stack('styles_top')
    @stack('scripts_top')

    <style>
        {!! !empty(getCustomCssAndJs('css')) ? getCustomCssAndJs('css') : '' !!}

        {!! getThemeFontsSettings() !!}

        {!! getThemeColorsSettings() !!}
    </style>

    @if(!empty($generalSettings['preloading']) and $generalSettings['preloading'] == '1')
        @include('admin.includes.preloading')
    @endif

</head>
<body class="menu-closed @if($isRtl) rtl @endif">

@php
    $isPanel = true;
@endphp

<div id="panel_app">

    
    <div class="panel-page-section">
        @include(getTemplate(). '.includes.navbar')
        @if(auth()->check() && auth()->user()->isUser())
            @include(getTemplate(). '.panel.includes.sidebar')
        @endif
        <div class="panel-content">
            <div class="container">
                <div class="row"> 
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                        @yield('content')
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                        <div class="panel-right-sidebar">
                            <div class="row">
                            <div class="col-12 col-lg-12 mt-10">
                                <div class="user-profile-icons">
                                    <ul>
                                        <li class="dropdown dropdown-list-toggle">
                                            <strong>
                                                <img src="/assets/default/img/panel-sidebar/1.png" alt="">
                                            @if(!empty($unReadNotifications) and count($unReadNotifications))
                                              {{ count($unReadNotifications) }}
                                           @else
                                           0
                                           @endif
                                            </strong>

                                            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                                <div class="dropdown-header">{{ trans('admin/main.notifications') }}
                                                    <div class="float-right">
                                                        @can('admin_notifications_markAllRead')
                                                            <a href="{{ getAdminPanelUrl() }}/notifications/mark_all_read">{{ trans('admin/main.mark_all_read') }}</a>
                                                        @endcan
                                                    </div>
                                                </div>

                                                <div class="dropdown-list-content dropdown-list-icons">
                                                    @foreach($unReadNotifications as $unreadNotification)
                                                        <a href="{{ getAdminPanelUrl() }}/notifications" class="dropdown-item">
                                                            <div class="dropdown-item-icon bg-info text-white d-flex align-items-center justify-content-center">
                                                                <i class="far fa-user"></i>
                                                            </div>
                                                            <div class="dropdown-item-desc">
                                                                {{ $unreadNotification->title }}
                                                                <div class="time text-primary">{{ dateTimeFormat($unreadNotification->created_at,'Y M j | H:i') }}</div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                                <div class="dropdown-footer text-center">
                                                    <a href="{{ getAdminPanelUrl() }}/notifications">{{ trans('admin/main.view_all') }} <i class="fas fa-chevron-right"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="assignments">
                                               <strong>
                                                   <img src="/assets/default/img/panel-sidebar/2.png" alt="">
                                                  0
                                               </strong>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="coin-counts">
                                               <strong>
                                                   <img src="/assets/default/img/panel-sidebar/heart-red.png" alt="">
                                                   {{$authUser->user_life_lines}}
                                               </strong>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="levels">
                                               <strong>
                                                   <img src="/assets/default/img/panel-sidebar/3.png" alt="">
                                                   {{$authUser->getRewardPoints()}}
                                               </strong>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="xs-w-100 d-flex align-items-center justify-content-between">
                                                @if(!empty($authUser))
                                                <!-- <div class="d-flex">
                                                    <div class="border-left mx-5 mx-lg-15"></div>
                                                </div> -->
                                                @endif

                                                @if(!empty($authUser))


                                                <div class="dropdown">
                                                    <a href="#!" class="navbar-user d-flex align-items-center dropdown-toggle" type="button"
                                                       id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <img src="{{ $authUser->getAvatar() }}" class="rounded-circle"
                                                             alt="{{ $authUser->full_name }}" width="100%" height="auto" itemprop="image"
                                                             alt="rounded circle" loading="eager" title="rounded circle">
                                                    </a>

                                                    <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                                                        <div class="dropdown-item user-nav-detail">
                                                            <img src="{{ $authUser->getAvatar() }}" class="rounded-circle" alt="{{ $authUser->full_name }}" width="100%" height="auto" itemprop="image"
                                                             alt="rounded circle" loading="eager" title="rounded circle">
                                                            <span class="font-14 text-dark-blue user-name">{{ $authUser->full_name }}</span>
                                                            <span class="font-14 text-dark-blue user-email">{{ $authUser->email }}</span>
                                                            <a href="/panel" class="font-14 text-dark-blue user-manage-btn">Manage Account</a>
                                                        </div>
                                                        <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                                                            <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
                                                        </div>


                                                        @if( !empty( $profile_navs ) )
                                                        <div class="user-nav-list">
                                                        @foreach( $profile_navs as $profile_nav)

                                                        <a class="dropdown-item " href="/panel/switch_user/{{$profile_nav['id']}}">
                                                            <img src="{{ $profile_nav->getAvatar() }}" class="rounded-circle" alt="{{ $profile_nav['full_name'] }}" width="100%" height="auto" itemprop="image"
                                                             alt="rounded circle" loading="eager" title="rounded circle">
                                                            @php $full_name = (isset( $navData['is_parent'] ) && $navData['is_parent'] == true)? 'Parent' :  $profile_nav['full_name']; @endphp
                                                            <span class="font-14 text-dark-blue user-list-name">{{ $full_name }}</span>
                                                            <span class="font-14 text-dark-blue user-list-email">{{ $profile_nav['email'] }}</span>
                                                        </a>

                                                        @endforeach
                                                        </div>
                                                        @endif

                                                        <a class="dropdown-item nav-logout" href="/logout">
                                                            <img src="/assets/default/img/icons/sidebar/logout.svg" height="auto" itemprop="image"
                                                                 width="25" alt="nav-icon" title="nav-icon" loading="eager">
                                                            <span class="font-14 text-dark-blue">{{ trans('panel.log_out') }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="d-flex align-items-center ml-md-50">
                                                    <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-14 login-btn">Log in</a>
                                                    <a href="/register" class="py-5 px-15 text-dark-blue font-14 register-btn">Try for free</a>
                                                </div>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="panel-rightside-menu">
                                    <div class="user-info">
                                        <a href="#">

                                            <img src="{{ $authUser->getAvatar() }}" alt="{{ $authUser->full_name }}" width="100%" height="auto" itemprop="image"
                                                                                                         alt="User Avatar" loading="eager" title="User Avatar">
                                            <span>
                                                <strong>{{ $authUser->full_name }}</strong>
                                                <span>View Your Profile</span>
                                            </span>
                                        </a>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="/panel/setting"><span class="nav-icon"><img src="/assets/default/svgs/account-nav.svg" alt=""></span>Account Setting</a>
                                        </li>
                                        <li>
                                            <a href="/panel/rewards"><span class="nav-icon"><img src="/assets/default/svgs/reward-nav2.svg" alt=""></span>Reward Points</a>
                                        </li>
                                        <li>
                                            <a href="/panel/marketing/affiliates"><span class="nav-icon"><img src="/assets/default/svgs/affiliate-nav.svg" alt=""></span>Affiliations</a>
                                        </li>
                                        <li>
                                            <a href="/panel/store/purchases"><span class="nav-icon"><img src="/assets/default/svgs/shop-nav.svg" alt=""></span>Shop Orders</a>
                                        </li>
                                        <li>
                                            <a href="/panel/notifications"><span class="nav-icon"><img src="/assets/default/svgs/notifications-nav.svg" alt=""></span>Notification</a>
                                        </li>
                                        <li>
                                            <a href="#"><span class="nav-icon"><img src="/assets/default/svgs/school-nav.svg" alt=""></span>School link</a>
                                        </li>
                                        <li>
                                            <a href="/panel/support"><span class="nav-icon"><img src="/assets/default/svgs/support-nav.svg" alt=""></span>Support Desk</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 mt-35">
                                <div class="bg-white noticeboard rounded-sm panel-shadow panel-border py-10 py-md-20 px-15 px-md-30">
                                    <h3 class="font-19 font-weight-bold">{{ trans('panel.noticeboard') }}</h3>

                                    @foreach($authUser->getUnreadNoticeboards() as $getUnreadNoticeboard)
                                        <div class="noticeboard-item py-15">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h4 class="js-noticeboard-title font-weight-500">{!! truncate($getUnreadNoticeboard->title,150) !!}</h4>
                                                    <div class="font-12 text-gray mt-5">
                                                        <span class="mr-5">{{ trans('public.created_by') }} {{ $getUnreadNoticeboard->sender }}</span>
                                                        |
                                                        <span class="js-noticeboard-time ml-5">{{ dateTimeFormat($getUnreadNoticeboard->created_at,'j M Y | H:i') }}</span>
                                                    </div>
                                                </div>

                                                <div>
                                                    <button type="button" data-id="{{ $getUnreadNoticeboard->id }}" class="js-noticeboard-info btn btn-sm btn-border-white">{{ trans('panel.more_info') }}</button>
                                                    <input type="hidden" class="js-noticeboard-message" value="{{ $getUnreadNoticeboard->message }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-12 col-lg-12 mt-35">
                                <div class="referrals panel-border panel-shadow rounded-sm">
                                    <div class="referral-card">
                                        <h3 class="font-19 font-weight-bold">Link your students and <br /> start earning!</h3>
                                        <p>
                                            To link your clients, enter their email below. <br />
                                            If they don't yet use Atom, they'll get 10% <br />
                                            off their first month, and <strong>you will earn 15% <br /> of their subscription payment every month. </strong>
                                        </p>
                                        <div class="referral-form">
                                            <form>
                                                <label>Parent's email</label>
                                                <div class="form-feild">
                                                    <input type="text" placeholder="parent@mail.com">
                                                    <button type="submit">Invite</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="referral-invites">
                                            <div class="heading">
                                                <h3 class="font-19 font-weight-bold">Track your invites</h3>
                                                <a href="#">See all <span>&#8594;</span></a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <strong>0</strong>
                                                    <span>Total users earning</span>
                                                </li>
                                                <li>
                                                    <strong>1</strong>
                                                    <span>Pending invites</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="referral-payment">
                                            <div class="heading">
                                                <h3 class="font-19 font-weight-bold">Your wallet</h3>
                                                <a href="#">Go to referrals <span>&#8594;</span></a>
                                            </div>
                                            <p>
                                                <span class="icon-box">
                                                    <img src="/assets/default/svgs/wallet.svg" alt="">
                                                </span>
                                                <strong>
                                                    £0.00
                                                    <em>Pending payment</em>
                                                </strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="mobile-app-card panel-shadow mt-35">
                                    <div class="card h-md-100" dir="ltr"> 
                                        <div class="card-body d-flex flex-column flex-center">  
                                            <div class="mb-2">
                                                <h3 class="fw-semibold text-center">           
                                                    Have you tried <br> new
                                                    <span> Mobile Application ?</span>
                                                </h3>
                                                <div class="py-10 text-center">
                                                    <img src="/assets/default/svgs/panel-app.svg" class="theme-dark-show w-200px" alt="">
                                                </div>
                                            </div>
                                            <div class="button-controls"> 
                                                <a class="btn btn-sm btn-primary" data-target="#modal_create_app" data-toggle="modal">Try now</a>
                                                <a class="btn btn-sm btn-light" href="#">Learn more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12">
                                <div class="facebook-card mt-35">
                                    <div class="card card-flush border-0 h-lg-100" data-theme="light" style="background-color: #7239EA">
                                        <div class="card-header">
                                            <h3 class="card-title">            
                                                <span class="card-label text-white">Facebook Campaign</span>
                                                <span class="badge badge-success">Active</span>
                                            </h3>       
                                            <div class="card-toolbar">            
                                                <button class="btn" id="sidebar-dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&#8594;</button>
                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown1">
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                                                    </div>
                                                    <div class="separator mb-3 opacity-75"></div>
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">
                                                            New Ticket
                                                        </a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">
                                                            New Customer
                                                        </a>
                                                    </div>
                                                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                                        <a href="#" class="menu-link px-3">
                                                            <span class="menu-title">New Group</span>
                                                            <span class="menu-arrow"></span>
                                                        </a>
                                                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                            <div class="menu-item px-3">
                                                                <a href="#" class="menu-link px-3">
                                                                    Admin Group
                                                                </a>
                                                            </div>
                                                            <div class="menu-item px-3">
                                                                <a href="#" class="menu-link px-3">
                                                                    Staff Group
                                                                </a>
                                                            </div>           
                                                            <div class="menu-item px-3">
                                                                <a href="#" class="menu-link px-3">
                                                                    Member Group
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">
                                                            New Contact
                                                        </a>
                                                    </div>
                                                    <div class="separator mt-3 opacity-75"></div>
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content px-3 py-3">
                                                            <a class="btn btn-primary  btn-sm px-4" href="#">
                                                                Generate Reports
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>            
                                            </div>
                                        </div>
                                    <div class="card-body">  
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex counted">                    
                                                <strong class="text-white">$4,368</strong>
                                                <span>New Followers</span>
                                            </div>
                                            <div class="d-flex counted">                    
                                                <strong class="text-white">120,000</strong>
                                                <span>Followers Goal</span>
                                            </div>
                                            </div>
                                            <div id="kt_card_widget_1_chart" data-kt-chart-color="#8F5FF4" style="height: 105px; min-height: 105px;">
                                                <div id="apexchartshpc8vvpyj" class="apexcharts-canvas apexchartshpc8vvpyj apexcharts-theme-light" style="height: 105px;">
                                                    <svg id="SvgjsSvg1310" width="100%" height="105" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="100%" height="105"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 52.5px;"></div></foreignObject><g id="SvgjsG1358" class="apexcharts-yaxis" rel="0" transform="translate(0, 0)"></g><g id="SvgjsG1312" class="apexcharts-inner apexcharts-graphical" transform="translate(22, 10)"><defs id="SvgjsDefs1311"><clipPath id="gridRectMaskhpc8vvpyj"><rect id="SvgjsRect1314" width="372.8" height="113" x="-31" y="-10" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskhpc8vvpyj"></clipPath><clipPath id="nonForecastMaskhpc8vvpyj"></clipPath><clipPath id="gridRectMarkerMaskhpc8vvpyj"><rect id="SvgjsRect1315" width="318.8" height="97" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1337" class="apexcharts-grid"><g id="SvgjsG1338" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1341" x1="-16.6" y1="0" x2="331.40000000000003" y2="0" stroke="false" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1342" x1="-16.6" y1="23.25" x2="331.40000000000003" y2="23.25" stroke="false" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1343" x1="-16.6" y1="46.5" x2="331.40000000000003" y2="46.5" stroke="false" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1344" x1="-16.6" y1="69.75" x2="331.40000000000003" y2="69.75" stroke="false" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1345" x1="-16.6" y1="93" x2="331.40000000000003" y2="93" stroke="false" stroke-dasharray="4" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1339" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1347" x1="0" y1="93" x2="314.8" y2="93" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1346" x1="0" y1="1" x2="0" y2="93" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1340" class="apexcharts-grid-borders" style="display: none;"></g><g id="SvgjsG1316" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1317" class="apexcharts-series" rel="1" seriesName="Sales" data:realIndex="0"><path id="SvgjsPath1322" d="M -7.870000000000001 87.001 L -7.870000000000001 64.126 C -7.870000000000001 61.126000000000005 -4.870000000000001 58.126 -1.87 58.126 L -1.87 58.126 C 1.0000000000000004 58.126 3.870000000000001 61.126000000000005 3.870000000000001 64.126 L 3.870000000000001 87.001 C 3.870000000000001 90.001 0.8700000000000006 93.001 -2.13 93.001 L -2.13 93.001 C -5 93.001 -7.870000000000001 90.001 -7.870000000000001 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M -7.870000000000001 87.001 L -7.870000000000001 64.126 C -7.870000000000001 61.126000000000005 -4.870000000000001 58.126 -1.87 58.126 L -1.87 58.126 C 1.0000000000000004 58.126 3.870000000000001 61.126000000000005 3.870000000000001 64.126 L 3.870000000000001 87.001 C 3.870000000000001 90.001 0.8700000000000006 93.001 -2.13 93.001 L -2.13 93.001 C -5 93.001 -7.870000000000001 90.001 -7.870000000000001 87.001 Z " pathFrom="M -7.870000000000001 93.001 L -7.870000000000001 93.001 L 3.870000000000001 93.001 L 3.870000000000001 93.001 L 3.870000000000001 93.001 L 3.870000000000001 93.001 L 3.870000000000001 93.001 L -7.870000000000001 93.001 Z" cy="58.125" cx="5.870000000000001" j="0" val="30" barHeight="34.875" barWidth="15.740000000000002"></path><path id="SvgjsPath1324" d="M 37.10142857142857 87.001 L 37.10142857142857 11.813500000000001 C 37.10142857142857 8.813500000000001 40.10142857142857 5.8135 43.10142857142857 5.8135 L 43.10142857142857 5.8135 C 45.971428571428575 5.8135 48.84142857142857 8.813500000000001 48.84142857142857 11.813500000000001 L 48.84142857142857 87.001 C 48.84142857142857 90.001 45.84142857142857 93.001 42.84142857142857 93.001 L 42.84142857142857 93.001 C 39.971428571428575 93.001 37.10142857142857 90.001 37.10142857142857 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M 37.10142857142857 87.001 L 37.10142857142857 11.813500000000001 C 37.10142857142857 8.813500000000001 40.10142857142857 5.8135 43.10142857142857 5.8135 L 43.10142857142857 5.8135 C 45.971428571428575 5.8135 48.84142857142857 8.813500000000001 48.84142857142857 11.813500000000001 L 48.84142857142857 87.001 C 48.84142857142857 90.001 45.84142857142857 93.001 42.84142857142857 93.001 L 42.84142857142857 93.001 C 39.971428571428575 93.001 37.10142857142857 90.001 37.10142857142857 87.001 Z " pathFrom="M 37.10142857142857 93.001 L 37.10142857142857 93.001 L 48.84142857142857 93.001 L 48.84142857142857 93.001 L 48.84142857142857 93.001 L 48.84142857142857 93.001 L 48.84142857142857 93.001 L 37.10142857142857 93.001 Z" cy="5.8125" cx="50.84142857142857" j="1" val="75" barHeight="87.1875" barWidth="15.740000000000002"></path><path id="SvgjsPath1326" d="M 82.07285714285715 87.001 L 82.07285714285715 35.063500000000005 C 82.07285714285715 32.063500000000005 85.07285714285715 29.0635 88.07285714285715 29.0635 L 88.07285714285715 29.0635 C 90.94285714285715 29.0635 93.81285714285715 32.063500000000005 93.81285714285715 35.063500000000005 L 93.81285714285715 87.001 C 93.81285714285715 90.001 90.81285714285715 93.001 87.81285714285715 93.001 L 87.81285714285715 93.001 C 84.94285714285715 93.001 82.07285714285715 90.001 82.07285714285715 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M 82.07285714285715 87.001 L 82.07285714285715 35.063500000000005 C 82.07285714285715 32.063500000000005 85.07285714285715 29.0635 88.07285714285715 29.0635 L 88.07285714285715 29.0635 C 90.94285714285715 29.0635 93.81285714285715 32.063500000000005 93.81285714285715 35.063500000000005 L 93.81285714285715 87.001 C 93.81285714285715 90.001 90.81285714285715 93.001 87.81285714285715 93.001 L 87.81285714285715 93.001 C 84.94285714285715 93.001 82.07285714285715 90.001 82.07285714285715 87.001 Z " pathFrom="M 82.07285714285715 93.001 L 82.07285714285715 93.001 L 93.81285714285715 93.001 L 93.81285714285715 93.001 L 93.81285714285715 93.001 L 93.81285714285715 93.001 L 93.81285714285715 93.001 L 82.07285714285715 93.001 Z" cy="29.0625" cx="95.81285714285715" j="2" val="55" barHeight="63.9375" barWidth="15.740000000000002"></path><path id="SvgjsPath1328" d="M 127.0442857142857 87.001 L 127.0442857142857 46.6885 C 127.0442857142857 43.6885 130.0442857142857 40.6885 133.0442857142857 40.6885 L 133.0442857142857 40.6885 C 135.9142857142857 40.6885 138.78428571428572 43.6885 138.78428571428572 46.6885 L 138.78428571428572 87.001 C 138.78428571428572 90.001 135.78428571428572 93.001 132.78428571428572 93.001 L 132.78428571428572 93.001 C 129.9142857142857 93.001 127.0442857142857 90.001 127.0442857142857 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M 127.0442857142857 87.001 L 127.0442857142857 46.6885 C 127.0442857142857 43.6885 130.0442857142857 40.6885 133.0442857142857 40.6885 L 133.0442857142857 40.6885 C 135.9142857142857 40.6885 138.78428571428572 43.6885 138.78428571428572 46.6885 L 138.78428571428572 87.001 C 138.78428571428572 90.001 135.78428571428572 93.001 132.78428571428572 93.001 L 132.78428571428572 93.001 C 129.9142857142857 93.001 127.0442857142857 90.001 127.0442857142857 87.001 Z " pathFrom="M 127.0442857142857 93.001 L 127.0442857142857 93.001 L 138.78428571428572 93.001 L 138.78428571428572 93.001 L 138.78428571428572 93.001 L 138.78428571428572 93.001 L 138.78428571428572 93.001 L 127.0442857142857 93.001 Z" cy="40.6875" cx="140.78428571428572" j="3" val="45" barHeight="52.3125" barWidth="15.740000000000002"></path><path id="SvgjsPath1330" d="M 172.0157142857143 87.001 L 172.0157142857143 64.126 C 172.0157142857143 61.126000000000005 175.0157142857143 58.126 178.0157142857143 58.126 L 178.0157142857143 58.126 C 180.8857142857143 58.126 183.7557142857143 61.126000000000005 183.7557142857143 64.126 L 183.7557142857143 87.001 C 183.7557142857143 90.001 180.7557142857143 93.001 177.7557142857143 93.001 L 177.7557142857143 93.001 C 174.8857142857143 93.001 172.0157142857143 90.001 172.0157142857143 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M 172.0157142857143 87.001 L 172.0157142857143 64.126 C 172.0157142857143 61.126000000000005 175.0157142857143 58.126 178.0157142857143 58.126 L 178.0157142857143 58.126 C 180.8857142857143 58.126 183.7557142857143 61.126000000000005 183.7557142857143 64.126 L 183.7557142857143 87.001 C 183.7557142857143 90.001 180.7557142857143 93.001 177.7557142857143 93.001 L 177.7557142857143 93.001 C 174.8857142857143 93.001 172.0157142857143 90.001 172.0157142857143 87.001 Z " pathFrom="M 172.0157142857143 93.001 L 172.0157142857143 93.001 L 183.7557142857143 93.001 L 183.7557142857143 93.001 L 183.7557142857143 93.001 L 183.7557142857143 93.001 L 183.7557142857143 93.001 L 172.0157142857143 93.001 Z" cy="58.125" cx="185.7557142857143" j="4" val="30" barHeight="34.875" barWidth="15.740000000000002"></path><path id="SvgjsPath1332" d="M 216.98714285714286 87.001 L 216.98714285714286 29.251 C 216.98714285714286 26.251 219.98714285714286 23.251 222.98714285714286 23.251 L 222.98714285714286 23.251 C 225.85714285714286 23.251 228.72714285714287 26.251 228.72714285714287 29.251 L 228.72714285714287 87.001 C 228.72714285714287 90.001 225.72714285714287 93.001 222.72714285714287 93.001 L 222.72714285714287 93.001 C 219.85714285714286 93.001 216.98714285714286 90.001 216.98714285714286 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M 216.98714285714286 87.001 L 216.98714285714286 29.251 C 216.98714285714286 26.251 219.98714285714286 23.251 222.98714285714286 23.251 L 222.98714285714286 23.251 C 225.85714285714286 23.251 228.72714285714287 26.251 228.72714285714287 29.251 L 228.72714285714287 87.001 C 228.72714285714287 90.001 225.72714285714287 93.001 222.72714285714287 93.001 L 222.72714285714287 93.001 C 219.85714285714286 93.001 216.98714285714286 90.001 216.98714285714286 87.001 Z " pathFrom="M 216.98714285714286 93.001 L 216.98714285714286 93.001 L 228.72714285714287 93.001 L 228.72714285714287 93.001 L 228.72714285714287 93.001 L 228.72714285714287 93.001 L 228.72714285714287 93.001 L 216.98714285714286 93.001 Z" cy="23.25" cx="230.72714285714287" j="5" val="60" barHeight="69.75" barWidth="15.740000000000002"></path><path id="SvgjsPath1334" d="M 261.9585714285714 87.001 L 261.9585714285714 11.813500000000001 C 261.9585714285714 8.813500000000001 264.9585714285714 5.8135 267.9585714285714 5.8135 L 267.9585714285714 5.8135 C 270.8285714285714 5.8135 273.6985714285714 8.813500000000001 273.6985714285714 11.813500000000001 L 273.6985714285714 87.001 C 273.6985714285714 90.001 270.6985714285714 93.001 267.6985714285714 93.001 L 267.6985714285714 93.001 C 264.8285714285714 93.001 261.9585714285714 90.001 261.9585714285714 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M 261.9585714285714 87.001 L 261.9585714285714 11.813500000000001 C 261.9585714285714 8.813500000000001 264.9585714285714 5.8135 267.9585714285714 5.8135 L 267.9585714285714 5.8135 C 270.8285714285714 5.8135 273.6985714285714 8.813500000000001 273.6985714285714 11.813500000000001 L 273.6985714285714 87.001 C 273.6985714285714 90.001 270.6985714285714 93.001 267.6985714285714 93.001 L 267.6985714285714 93.001 C 264.8285714285714 93.001 261.9585714285714 90.001 261.9585714285714 87.001 Z " pathFrom="M 261.9585714285714 93.001 L 261.9585714285714 93.001 L 273.6985714285714 93.001 L 273.6985714285714 93.001 L 273.6985714285714 93.001 L 273.6985714285714 93.001 L 273.6985714285714 93.001 L 261.9585714285714 93.001 Z" cy="5.8125" cx="275.6985714285714" j="6" val="75" barHeight="87.1875" barWidth="15.740000000000002"></path><path id="SvgjsPath1336" d="M 306.93 87.001 L 306.93 40.876 C 306.93 37.876 309.93 34.876 312.93 34.876 L 312.93 34.876 C 315.8 34.876 318.67 37.876 318.67 40.876 L 318.67 87.001 C 318.67 90.001 315.67 93.001 312.67 93.001 L 312.67 93.001 C 309.8 93.001 306.93 90.001 306.93 87.001 Z " fill="rgba(143,95,244,0.85)" fill-opacity="1" stroke="transparent" stroke-opacity="1" stroke-linecap="round" stroke-width="4" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskhpc8vvpyj)" pathTo="M 306.93 87.001 L 306.93 40.876 C 306.93 37.876 309.93 34.876 312.93 34.876 L 312.93 34.876 C 315.8 34.876 318.67 37.876 318.67 40.876 L 318.67 87.001 C 318.67 90.001 315.67 93.001 312.67 93.001 L 312.67 93.001 C 309.8 93.001 306.93 90.001 306.93 87.001 Z " pathFrom="M 306.93 93.001 L 306.93 93.001 L 318.67 93.001 L 318.67 93.001 L 318.67 93.001 L 318.67 93.001 L 318.67 93.001 L 306.93 93.001 Z" cy="34.875" cx="320.67" j="7" val="50" barHeight="58.125" barWidth="15.740000000000002"></path><g id="SvgjsG1319" class="apexcharts-bar-goals-markers"><g id="SvgjsG1321" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g><g id="SvgjsG1323" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g><g id="SvgjsG1325" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g><g id="SvgjsG1327" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g><g id="SvgjsG1329" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g><g id="SvgjsG1331" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g><g id="SvgjsG1333" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g><g id="SvgjsG1335" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskhpc8vvpyj)"></g></g><g id="SvgjsG1320" class="apexcharts-bar-shadows apexcharts-hidden-element-shown"></g></g><g id="SvgjsG1318" class="apexcharts-datalabels apexcharts-hidden-element-shown" data:realIndex="0"></g></g><g id="SvgjsG1350" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1351" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1359" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1360" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1361" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: inherit; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(143, 95, 244);"></span><div class="apexcharts-tooltip-text" style="font-family: inherit; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                                        <div class="apexcharts-yaxistooltip-text"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12">
                                <div class="key-statistics panel-shadow panel-border mt-35">
                                    <div class="key-header">
                                        <h3 class="card-title align-items-start flex-column">            
                                            <span class="card-label fw-bold text-gray-900">Key Statistics</span>
                                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Social activities overview</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <button class="btn" id="sidebar-dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="sidebar-dropdown2">
                                                <ul>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="key-body">
                                        <div class="swiper">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>3.4k</strong>
                                                            <span>Avarage <br> Comments</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <a href="#">Jul 22 - Aug 22</a>
                                                                <button class="btn" id="sidebar-dropdown4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span></span>
                                                                    <span></span>
                                                                    <span></span>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown4">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>650</strong>
                                                            <span>Avarage <br> Share</span>
                                                        </div>
                                                        <div class="key-progress">
                                                        <div class="key-date-select">
                                                                <a href="#">Jul 22 - Aug 22</a>
                                                                <button class="btn" id="sidebar-dropdown5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span></span>
                                                                    <span></span>
                                                                    <span></span>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown5">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>7.5k</strong>
                                                            <span>Avarage <br> Likes</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <button class="btn" id="sidebar-dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Jul 22 - Aug 22
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown6">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>3.4k</strong>
                                                            <span>Avarage <br> Comments</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <button class="btn" id="sidebar-dropdown7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Jul 22 - Aug 22
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown7">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>650</strong>
                                                            <span>Avarage <br> Share</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <button class="btn" id="sidebar-dropdown8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Jul 22 - Aug 22
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown8">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>7.5k</strong>
                                                            <span>Avarage <br> Likes</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <button class="btn" id="sidebar-dropdown9" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Jul 22 - Aug 22
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown9">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>3.4k</strong>
                                                            <span>Avarage <br> Comments</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <button class="btn" id="sidebar-dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Jul 22 - Aug 22
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown6">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>650</strong>
                                                            <span>Avarage <br> Share</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <button class="btn" id="sidebar-dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Jul 22 - Aug 22
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown6">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="key-item">
                                                        <div class="key-social-info">
                                                            <strong>7.5k</strong>
                                                            <span>Avarage <br> Likes</span>
                                                        </div>
                                                        <div class="key-progress">
                                                            <div class="key-date-select">
                                                                <button class="btn" id="sidebar-dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Jul 22 - Aug 22
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="sidebar-dropdown6">
                                                                    <ul>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                        <li><a href="#">Jul 22 - Aug 22</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="levels-progress horizontal">
                                                                <span class="progress-box bg-success">
                                                                    <span class="progress-count" style="width: 65%;"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12">
                                <div class="notable-card panel-shadow panel-border">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">            
                                            <span class="card-label">Notable Channels</span>
                                            <span>Social networks overview</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <button class="btn" id="sidebar-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="sidebar-dropdown">
                                                <ul>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                    <li><a href="#">New Ticket</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="social-list">
                                            <li>
                                                <div class="social-item">
                                                    <div class="item-left">
                                                        <img src="/assets/default/svgs/dribbble-icon-1.svg" class="me-3 w-30px" alt="">
                                                        <p>
                                                            <a href="#">Dribbble</a>
                                                            <span>Community</span>
                                                        </p>
                                                    </div>
                                                    <div class="item-right">
                                                        <div class="levels-progress horizontal">
                                                            <span class="progress-box bg-success">
                                                                <span class="progress-count" style="width: 65%;"></span>
                                                            </span>
                                                            <span class="progress-numbers">65%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="social-item">
                                                    <div class="item-left">
                                                        <img src="/assets/default/svgs/instagram1.svg" class="me-3 w-30px" alt="">
                                                        <p>
                                                            <a href="#">Linked In</a>
                                                            <span>Social Media</span>
                                                        </p>
                                                    </div>
                                                    <div class="item-right">
                                                        <div class="levels-progress horizontal">
                                                            <span class="progress-box bg-success">
                                                                <span class="progress-count" style="width: 87%;"></span>
                                                            </span>
                                                            <span class="progress-numbers">87%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                <div class="col-12 col-lg-12">
                                                                @include('web.default.includes.footer')
                                                            </div>
                        </div>

                        </div>

                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden-footer"></div>


    @include('web.default.includes.advertise_modal.index')
</div>
<!-- Template JS File -->
<script src="/assets/default/js/app.js"></script>
<script src="/assets/default/vendors/moment.min.js"></script>
<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
<script type="text/javascript" src="/assets/default/vendors/simplebar/simplebar.min.js"></script>

<script>
    var deleteAlertTitle = '{{ trans('public.are_you_sure') }}';
    var deleteAlertHint = '{{ trans('public.deleteAlertHint') }}';
    var deleteAlertConfirm = '{{ trans('public.deleteAlertConfirm') }}';
    var deleteAlertCancel = '{{ trans('public.cancel') }}';
    var deleteAlertSuccess = '{{ trans('public.success') }}';
    var deleteAlertFail = '{{ trans('public.fail') }}';
    var deleteAlertFailHint = '{{ trans('public.deleteAlertFailHint') }}';
    var deleteAlertSuccessHint = '{{ trans('public.deleteAlertSuccessHint') }}';
    var forbiddenRequestToastTitleLang = '{{ trans('public.forbidden_request_toast_lang') }}';
    var forbiddenRequestToastMsgLang = '{{ trans('public.forbidden_request_toast_msg_lang') }}';
</script>

@if(session()->has('toast'))
    <script>
        (function () {
            "use strict";

            $.toast({
                heading: '{{ session()->get('toast')['title'] ?? '' }}',
                text: '{{ session()->get('toast')['msg'] ?? '' }}',
                bgColor: '@if(session()->get('toast')['status'] == 'success') #43d477 @else #f63c3c @endif',
                textColor: 'white',
                hideAfter: 10000,
                position: 'bottom-right',
                icon: '{{ session()->get('toast')['status'] }}'
            });
        })(jQuery)
    </script>
@endif

@stack('styles_bottom')
@stack('scripts_bottom')
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<script src="/assets/default/js/question-layout.js"></script>
<script src="/assets/default/js//parts/main.min.js?ver={{$rand_no}}"></script>
<script src="/assets/default/js/panel/public.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
<script src="/assets/default/js/admin/sticky-sidebar.js?ver={{$rand_no}}"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script>

    @if(session()->has('registration_package_limited'))
    (function () {
        "use strict";

        handleLimitedAccountModal('{!! session()->get('registration_package_limited') !!}')
    })(jQuery)

    {{ session()->forget('registration_package_limited') }}
    @endif

    {!! !empty(getCustomCssAndJs('js')) ? getCustomCssAndJs('js') : '' !!}

            var options = {
                type: 'bar',
                data: {
                    labels: ["Jul 2017", "Jan 2018", "Jul 2018", "Jan 2019", "Jul 2019"],
                    datasets: [
                        {
                            label: '# of Votes',
                            data: [10, 12, 5, 15, 20],
                            borderWidth: 0,
                            backgroundColor: '#417290',
                            borderColor: '#417290',
                        },  
                        {
                            label: '# of Points',
                            data: [20, 10, 5, 10, 10],
                            borderWidth: 0,
                            backgroundColor: '#417290',
                            borderColor: '#417290',
                        },
                        {
                            label: '# of Points',
                            data: [10, 5, 15, 20, 10],
                            borderWidth: 0,
                            backgroundColor: '#417290',
                            borderColor: '#417290'
                        },
                        {
                            label: '# of Points',
                            data: [5, 2, 2, 15, 5],
                            borderWidth: 0,
                            backgroundColor: '#417290',
                            borderColor: '#417290'
                        },
                        {
                            label: '# of Points',
                            data: [10, 2, 2, 10, 20],
                            borderWidth: 0,
                            backgroundColor: '#417290',
                            borderColor: '#417290'
                        },
                        {
                            label: '# of Points',
                            data: [20, 5, 10, 15, 20],
                            borderWidth: 0,
                            backgroundColor: '#417290',
                            borderColor: '#417290'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    categoryPercentage: 1,
                    scales: {
                        x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                        },
                        y: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            }
            //var ctx = document.getElementById('chartBarHorizontal2').getContext('2d');
            //new Chart(ctx, options);
        </script>
        <script>    
            /*var ctxPie = document.getElementById('pieChart');
            var pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Organic Se...', 'Direct', 'Social', 'Referral'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5],
                        backgroundColor: [
                            '#417290',
                            '#b0c6d3',
                            '#e6e6e6',
                            '#b6ecf7'
                        ],
                        borderColor: [
                            '#417290',
                            '#b0c6d3',
                            '#e6e6e6',
                            '#b6ecf7'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {}
            });*/
        </script>
</script>
</body>
</html>
