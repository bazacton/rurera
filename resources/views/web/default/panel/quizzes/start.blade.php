@php namespace App\Http\Controllers\Web; @endphp
@extends(getTemplate().'.layouts.appstart')
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
<script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
<style>
    .ui-state-highlight {
        margin: 0px 10px;
    }
</style>

@section('content')
<div class="content-section">
    <section class="quiz-topbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="quiz-top-info"><p>{{$question->title}} ( {{$question_no}}/
                            {{count($questions_list)}}
                            Questions )</p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                    <div class="topbar-right">
                        <div class="quiz-pagination">
                            <ul>
                                @if( !empty( $questions_list ) )
                                @php $question_count = 1; @endphp
                                @foreach( $questions_list as $question_id)
                                @php $is_flagged = false;
                                $flagged_questions = ($newQuizStart->flagged_questions != '')? json_decode
                                ($newQuizStart->flagged_questions) : array();
                                @endphp
                                @if( is_array( $flagged_questions ) && in_array( $question_id,
                                $flagged_questions))
                                @php $is_flagged = true; @endphp
                                @endif
                                <li data-question_id="{{$question_id}}" class="{{ ( $is_flagged == true)?
                                        'has-flag' : ''}}"><a
                                        href="#">
                                        @if( $is_flagged == true)
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt"
                                             height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                                             preserveAspectRatio="xMidYMid meet">
                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                               fill="#000000" stroke="none">
                                                <path
                                                    d="M1620 4674 c-46 -20 -77 -50 -103 -99 l-22 -40 -3 -1842 -2 -1843 -134 0 c-120 0 -137 -2 -177 -23 -24 -13 -57 -43 -74 -66 -27 -39 -30 -50 -30 -120 0 -66 4 -83 25 -114 14 -21 43 -50 64 -65 l39 -27 503 0 502 0 44 30 c138 97 118 306 -34 370 -27 11 -73 15 -168 15 l-130 0 0 750 0 750 1318 2 1319 3 40 28 c83 57 118 184 75 267 -10 19 -140 198 -290 398 -170 225 -270 367 -265 375 4 7 128 174 276 372 149 197 276 374 283 392 19 45 17 120 -5 168 -23 51 -79 101 -128 114 -26 7 -459 11 -1330 11 l-1293 0 0 20 c0 58 -56 137 -122 171 -45 23 -128 25 -178 3z"
                                                ></path>
                                            </g>
                                        </svg>
                                        @endif
                                        {{$question_count}}</a></li>
                                @php $question_count++; @endphp
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="quiz-timer">
                            <span class="timer-number">4<em>m</em></span> <span
                                class="timer-number">50<em>s</em></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-quiz-section">

        @if( $quiz->quiz_pdf != '')
        <div class="read-quiz-info quiz-show"></div>
        <script>

            $(".read-quiz-info").flipBook({
                pdfUrl: '{{$quiz->quiz_pdf}}',
                btnZoomIn: {enabled: true},
                btnZoomOut: {enabled: true},
                btnToc: {enabled: false},
                btnShare: {enabled: false},
                btnDownloadPages: {enabled: false},
                btnDownloadPdf: {enabled: false},
                btnSound: {enabled: false},
                btnAutoplay: {enabled: false},
                btnSelect: {enabled: false},
                btnBookmark: {enabled: false},
                btnThumbs: {enabled: false},
                btnPrint: {enabled: false},
                currentPage: {enabled: false},
                viewMode: "swipe",
                singlePageMode: true,
                skin: 'dark',
                menuMargin: 10,
                menuBackground: 'none',
                menuShadow: 'none',
                menuAlignHorizontal: 'right',
                menuOverBook: true,
                btnRadius: 40,
                btnMargin: 4,
                btnSize: 14,
                btnPaddingV: 16,
                btnPaddingH: 16,
                btnBorder: '2px solid rgba(255,255,255,.7)',
                btnBackground: "rgba(0,0,0,.3)",
                btnColor: 'rgb(255,120,60)',
                sideBtnRadius: 60,
                sideBtnSize: 60,
                sideBtnBackground: "rgba(0,0,0,.7)",
                sideBtnColor: 'rgb(255,120,60)',
            });
        </script>
        @endif

        <div class="container-fluid questions-data-block read-quiz-content"
             data-total_questions="{{$quizQuestions->count()}}">

            <div class="question-step quiz-complete" style="display:none">
                <div class="question-layout-block">
                    <div class="left-content has-bg">
                        <h2>&nbsp;</h2>
                        <div id="leform-form-1"
                             class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable"
                             _data-parent="1"
                             _data-parent-col="0" style="display: block;">
                            <div class="question-layout">

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="question-area-block">
                @if( is_array( $question ))
                @php $question_no = 1; @endphp
                @foreach( $question as $questionObj)
                @include('web.default.panel.questions.question_layout',['question'=> $questionObj,'prev_question' =>
                0, 'next_question' => 0, 'question_no' =>
                $question_no, 'quizAttempt' => $quizAttempt, 'newQuestionResult',
                $newQuestionResult])
                @php $question_no++; @endphp
                @endforeach
                @else
                @include('web.default.panel.questions.question_layout',['question'=> $question, 'question_no' =>
                $question_no, 'prev_question' => $prev_question, 'next_question' => $next_question , 'quizAttempt' =>
                $quizAttempt, 'newQuestionResult',
                $newQuestionResult])
                @endif
            </div>

            <div class="question-area-temp hide"></div>

        </div>
    </section>


</div>

@endsection

@push('scripts_bottom')

<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_id}}"></script>
<script>
    $('body').addClass('quiz-show');
    var header = document.getElementById("navbar");
    var headerOffset = (header != null) ? header.offsetHeight : 100;
    var header_height = parseInt(headerOffset) + parseInt(85) + "px";
    if (jQuery('.read-quiz-info, .read-quiz-content').length > 0) {
        $('.read-quiz-info, .read-quiz-content').css({
            'padding-top': header_height
        });
    }
</script>
@endpush
