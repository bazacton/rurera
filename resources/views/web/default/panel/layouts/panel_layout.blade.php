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
                                        <li>
                                            <div class="notifications">
                                               <strong>
                                                   <img src="/assets/default/img/panel-sidebar/1.png" alt="">
                                                   @if(!empty($unReadNotifications) and count($unReadNotifications))
                                                      {{ count($unReadNotifications) }}
                                                   @else
                                                   0
                                                   @endif
                                               </strong>
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
                                                   <img src="/assets/default/img/panel-sidebar/4.png" alt="">
                                                   0
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
                                        <li><a href="/panel/setting">Account Setting</a></li>
                                        <li><a href="/panel/rewards">Reward Points</a></li>
                                        <li><a href="/panel/store/purchases">Shop Orders</a></li>
                                        <li><a href="/panel/notifications">Notification</a></li>
                                        <li><a href="#">School link</a></li>
                                        <li><a href="/panel/support">Support Desk</a></li>
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
                                    </div>
                            @include('web.default.includes.footer')
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
