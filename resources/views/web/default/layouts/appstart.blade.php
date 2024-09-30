<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" itemscope itemtype="https://schema.org/FAQPage">

@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];
$rand_no = rand(99,9999);

    $isRtl = ((in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages)) or (!empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1));
@endphp

<head>
    @include('web.default.includes.metas')
    <title>{{ $page_title ?? '' }}{{ !empty($generalSettings['site_name']) ? (' | '.$generalSettings['site_name']) : '' }}</title>

    <!-- General CSS File -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>


    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap/bootstrap.min.css"/>


    <link rel="stylesheet" href="/assets/default/vendors/data-table/dataTables.min.css"/>
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/simplebar/simplebar.css">
	<link rel="stylesheet" href="/assets/default/css/common.min.css?ver={{$rand_no}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
    <link rel="stylesheet" href="/assets/default/css/responsive.min.css">


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

<body class="@if($isRtl) rtl @endif">

<div id="app">

    @yield('content')
</div>
<!-- Template JS File -->
<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script src="/assets/default/vendors/moment.min.js"></script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>

<script type="text/javascript" src="/assets/default/vendors/simplebar/simplebar.min.js"></script>


@if(empty($justMobileApp) and checkShowCookieSecurityDialog())
    @include('web.default.includes.cookie-security')
@endif


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

<script src="/assets/default/js/parts/navbar.min.js?ver={{$rand_no}}"></script>
<script src="/assets/default/js/parts/main.min.js?ver={{$rand_no}}"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/data-table/dataTables.min.js"></script>
<script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="/assets/admin/js/custom.js?ver={{$rand_no}}"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_no}}"></script>

<script>
    @if(session()->has('registration_package_limited'))
    (function () {
        "use strict";

        handleLimitedAccountModal('{!! session()->get('registration_package_limited') !!}')
    })(jQuery)

    {{ session()->forget('registration_package_limited') }}
    @endif

    {!! !empty(getCustomCssAndJs('js')) ? getCustomCssAndJs('js') : '' !!}

    if(jQuery('.lms-data-table table').length > 0){
        $('.lms-data-table table').DataTable();
      }
    if(jQuery('.quiz-pagination .swiper-container').length > 0){
                  console.log('slides-count');
                  console.log($(".quiz-pagination ul li").length);
                const swiper = new Swiper('.quiz-pagination .swiper-container', {
                  slidesPerView: ($(".quiz-pagination ul li").length > 10)? 10 : $(".quiz-pagination ul li").length,
                  spaceBetween: 0,
                  slidesPerGroup: 5,
                  observer: true,
                  observeParents: true,
                  navigation: {
                      nextEl: ".swiper-button-next",
                      prevEl: ".swiper-button-prev",
                  },
                  breakpoints: {
                    320: {
                      slidesPerView: 3,
                      spaceBetween: 5
                    },

                    480: {
                      slidesPerView: ($(".quiz-pagination ul li").length > 10)? 10 : $(".quiz-pagination ul li").length,
                      spaceBetween: 5
                    },

                    640: {
                      slidesPerView: ($(".quiz-pagination ul li").length > 10)? 10 : $(".quiz-pagination ul li").length,
                      spaceBetween: 5
                    }
                  }
                });
                $(document).on('click', '.quiz-pagination ul li, .questions-nav-controls .prev-btn, .questions-nav-controls .next-btn', function (e) {
                    var question_id = $(this).attr('data-question_id');
                    var li_index = $('.quiz-pagination ul li[data-question_id="'+question_id+'"]').index();
                    swiper.slideTo(li_index);
                });


                $(document).on('click', '.flag-question.notflaged', function (e) {
                    var question_id = $(this).attr('data-question_id');
                    var li_index = $('.quiz-pagination ul li[data-question_id="' + question_id + '"]').index();
                     swiper.slideTo(li_index);
                });


              }
    

</script>
<script type="text/javascript">
  window._mfq = window._mfq || [];
  (function() {
    var mf = document.createElement("script");
    mf.type = "text/javascript"; mf.defer = true;
    mf.src = "//cdn.mouseflow.com/projects/b545a93a-901f-443b-9f07-429206fd8fde.js";
    document.getElementsByTagName("head")[0].appendChild(mf);
  })();
</script>
</body>
</html>
