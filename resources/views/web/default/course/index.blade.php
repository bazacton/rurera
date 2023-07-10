@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush


@section('content')
<section class="cart-banner position-relative text-center pages-sub-header">
        <div class="container h-100">
            <div class="row h-100 align-items-center text-left">
                <div class="col-12 col-md-9 col-lg-9">
                    <p class="lms-subtitle">Start Learning with confidence</p>
                    <h1 class="font-30 font-weight-bold">{{ $course->category->title }}</h1>
                    {!!$course->description!!}
                </div>
                <div class="col-12 col-md-3 col-lg-3 sub-header-img">
                    <figure><img src="../assets/default/img/sub-header-icon.png" alt="#">
                        <figcaption>
                            <div class="header-img-title">
                                <strong>Want to read this book again?</strong>
                            </div>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </section>

























<section class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="post-show" style="overflow:hidden;">


<section class="categories-wrapp">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="categories-boxes row">

                    @if( !empty( $courses_list ) )
                        @foreach( $courses_list as $courseObj)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                <div class="categories-card">
                                    <div class="categories-icon" style="background:{{$courseObj->background_color}}">
                                        {!! $courseObj->icon_code !!}
                                    </div>
                                    <h4 class="categories-title">{{$courseObj->getTitleAttribute()}}</h4>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section class="count-number-wrapp mt-30" style="display:none">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="section-title">
                    <h2>{{ $course->title }}</h2>
                </div>
                <ul class="count-number-boxes row">
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="edit-2" width="20" height="20" class="" style="color:#8cc811"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>answered</h5>
                            <strong>1,355</strong>
                            <h5>questions</h5>
                        </div>
                    </li>
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="clock" width="20" height="20" class="" style="color:#00aeef"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>spent</h5>
                            <strong>11 hr 32 min</strong>
                            <h5>practising</h5>
                        </div>
                    </li>
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>Made progress in</h5>
                            <strong>73</strong>
                            <h5>skills</h5>
                        </div>
                    </li>
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>Made progress in</h5>
                            <strong>73</strong>
                            <h5>skills</h5>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="lms-chapter-section mt-20">
    <div class="container">
        <div class="row">
            <div class="col-12 lms-chapter-area">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="sidebar-nav">
                            <h3 class="sidebar-title">Course topics</h3>
                            <ul>
                                @foreach($course->chapters as $chapter)
                                    @if((!empty($chapter->chapterItems) and count($chapter->chapterItems)) or (!empty($chapter->quizzes) and count($chapter->quizzes)))
                                        <li><a href="#subject_{{$chapter->id}}">{{ $chapter->title}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="accordion-content-wrapper" id="chaptersAccordion" role="tablist"
                            aria-multiselectable="true">


                            <ul class="lms-chapter-ul">
                                @foreach($course->chapters as $chapter)

                                @if((!empty($chapter->chapterItems) and count($chapter->chapterItems)) or (!empty($chapter->quizzes) and count($chapter->quizzes)))
                                <li id="subject_{{$chapter->id}}"><div class="element-title"><h2>{{ $chapter->title }}</h2></div>

                                    @if(!empty($sub_chapters[$chapter->id]) and count($sub_chapters[$chapter->id]))
                                    <div class="lms-chapter-ul-outer"><ul>
                                        @foreach($sub_chapters[$chapter->id] as $sub_chapter)
                                        @if(!empty($sub_chapter))
                                            <li><a href="/course/learning/{{$course->slug}}?webinar={{$chapter->id}}&chapter={{$sub_chapter['id']}}">{{ $sub_chapter['title'] }}</a></li>
                                        @endif
                                        @endforeach
                                        </ul>
                                        <div class="lms-chapter-footer lms-chapter-bg-blue">
                                            <span class="lms-chapter-icon">
                                                <figure>
                                                    <img src="../assets/default/img/lms-chapter-img2.png" alt="#" />
                                                </figure>
                                            </span>
                                            <div class="lms-chapter-widget">
                                                <h5 class="lms-widget-title">
                                                    Learn and Earn With Fun
                                                </h5>
                                                <ul class="row">
                                                    <li class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                        Challege Quiz # 1(150 Coins)
                                                    </li>
                                                    <li class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                        Challege Quiz # 2(200 Coins)
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
</div>
</section>





























    <div id="webinarReportModal" class="d-none">
        <h3 class="section-title after-line font-20 text-dark-blue">{{ trans('product.report_the_course') }}</h3>

        <form action="/course/{{ $course->id }}/report" method="post" class="mt-25">

            <div class="form-group">
                <label class="text-dark-blue font-14">{{ trans('product.reason') }}</label>
                <select id="reason" name="reason" class="form-control">
                    <option value="" selected disabled>{{ trans('product.select_reason') }}</option>

                    @foreach(getReportReasons() as $reason)
                        <option value="{{ $reason }}">{{ $reason }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label class="text-dark-blue font-14" for="message_to_reviewer">{{ trans('public.message_to_reviewer') }}</label>
                <textarea name="message" id="message_to_reviewer" class="form-control" rows="10"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <p class="text-gray font-16">{{ trans('product.report_modal_hint') }}</p>

            <div class="mt-30 d-flex align-items-center justify-content-end">
                <button type="button" class="js-course-report-submit btn btn-sm btn-primary">{{ trans('panel.report') }}</button>
                <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>

    @include('web.default.course.share_modal')
    @include('web.default.course.buy_with_point_modal')
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>

    <script>
        var webinarDemoLang = '{{ trans('webinars.webinar_demo') }}';
        var replyLang = '{{ trans('panel.reply') }}';
        var closeLang = '{{ trans('public.close') }}';
        var saveLang = '{{ trans('public.save') }}';
        var reportLang = '{{ trans('panel.report') }}';
        var reportSuccessLang = '{{ trans('panel.report_success') }}';
        var reportFailLang = '{{ trans('panel.report_fail') }}';
        var messageToReviewerLang = '{{ trans('public.message_to_reviewer') }}';
        var copyLang = '{{ trans('public.copy') }}';
        var copiedLang = '{{ trans('public.copied') }}';
        var learningToggleLangSuccess = '{{ trans('public.course_learning_change_status_success') }}';
        var learningToggleLangError = '{{ trans('public.course_learning_change_status_error') }}';
        var notLoginToastTitleLang = '{{ trans('public.not_login_toast_lang') }}';
        var notLoginToastMsgLang = '{{ trans('public.not_login_toast_msg_lang') }}';
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
        var canNotTryAgainQuizToastTitleLang = '{{ trans('public.can_not_try_again_quiz_toast_lang') }}';
        var canNotTryAgainQuizToastMsgLang = '{{ trans('public.can_not_try_again_quiz_toast_msg_lang') }}';
        var canNotDownloadCertificateToastTitleLang = '{{ trans('public.can_not_download_certificate_toast_lang') }}';
        var canNotDownloadCertificateToastMsgLang = '{{ trans('public.can_not_download_certificate_toast_msg_lang') }}';
        var sessionFinishedToastTitleLang = '{{ trans('public.session_finished_toast_title_lang') }}';
        var sessionFinishedToastMsgLang = '{{ trans('public.session_finished_toast_msg_lang') }}';
        var sequenceContentErrorModalTitle = '{{ trans('update.sequence_content_error_modal_title') }}';
        var courseHasBoughtStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasBoughtStatusToastMsgLang = '{{ trans('site.you_bought_webinar') }}';
        var courseNotCapacityStatusToastTitleLang = '{{ trans('public.request_failed') }}';
        var courseNotCapacityStatusToastMsgLang = '{{ trans('cart.course_not_capacity') }}';
        var courseHasStartedStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasStartedStatusToastMsgLang = '{{ trans('update.class_has_started') }}';

    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/webinar_show.min.js"></script>
    <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script>
      feather.replace()
    </script>
@endpush
