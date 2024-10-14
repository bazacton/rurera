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
	<link rel="stylesheet" href="/assets/default/css/panel-pages/left-menu.css?ver={{$rand_no}}">
	<link rel="stylesheet" href="/assets/default/css/common.css?ver={{$rand_no}}">
    <link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
    <link rel="stylesheet" href="/assets/default/css/responsive.css">

	@if(auth()->check() && auth()->user()->isParent())
		<link rel="stylesheet" href="/assets/default/css/panel-pages/parent.css?ver={{$rand_no}}">
	@endif
	
	@if (isset( $cssFiles ) && !empty($cssFiles))
        @foreach ($cssFiles as $cssFile)
            <link rel="stylesheet" href="{{ asset($cssFile) }}">
        @endforeach
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
@php $bodyClass = ''; @endphp
@if(auth()->check() && (auth()->user()->isParent() || auth()->user()->isTutor()))
    @php $bodyClass = 'parent-panel'; @endphp
@endif
<body class="menu-closed @if($isRtl) rtl @endif {{$bodyClass}}">

@php
    $isPanel = true;
@endphp

<div id="panel_app">

    
    <div class="panel-page-section">
        @if(auth()->check() && (auth()->user()->isUser()))
            @include(getTemplate(). '.includes.navbar')
        @endif
        @if(auth()->check() && (auth()->user()->isUser() || auth()->user()->isParent() || auth()->user()->isTutor()))
            @include(getTemplate(). '.panel.includes.sidebar')
        @endif
        <div class="panel-content">
            <div class="container ">
                <div class="row"> 
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        @yield('content')
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 panel-right-sidebar full-width-sidebar">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            @include(getTemplate(). '.panel.includes.user_top_bar')
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('web.default.includes.advertise_modal.index')
</div>
<div class="modal fade rurera-confirm-delete" id="rurera-confirm-delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-body">
      <div class="modal-box">
        <span class="icon-box d-block mb-15">
            <img src="../assets/default/img/clock-modal-img.png" alt="">
        </span>
        <h3 class="font-24 font-weight-normal mb-10">Are you sure you want to remove?</h3>
        <p class="mb-15 font-16">
            You've been inactive for a while, and your session was paused. You can continue learning by using the following links
        </p>
        <div class="inactivity-controls">
            <a href="javascript:;" class="continue-btn" data-dismiss="modal" aria-label="Continue">No</a>
            <a href="javascript:;" class="rurera-delete-btn">Yes to Delete</a>
        </div>
      </div>
    </div>
  </div>
</div>
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
