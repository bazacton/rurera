@php namespace App\Http\Controllers\Web; @endphp
@extends(getTemplate().'.layouts.appstart')
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">


<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
<script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .ui-state-highlight {
        margin: 0px 10px;
    }
    .field-holder.wrong, .form-field.wrong, .form-field.wrong label {
        background: #ff4a4a;
        color: #fff;
    }

</style>
@endpush
@section('content')
<div class="content-section">

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

            <section class="quiz-topbar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <div class="quiz-top-info"><p>{{$question->title}}</p>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                                <div class="topbar-right">
                                    <div class="quiz-pagination">
                                        <div class="swiper-container">
                                        <ul class="swiper-wrapper">
                                            @if( !empty( $questions_list ) )
                                            @php $question_count = 1; @endphp
                                            @foreach( $questions_list as $question_id)
                                            @php $is_flagged = false;
                                            $flagged_questions = ($newQuizStart->flagged_questions != '')? json_decode
                                            ($newQuizStart->flagged_questions) : array();
                                            @endphp
                                            @if( is_array( $flagged_questions ) && in_array( $question_id,
                                            $flagged_questions))
                                            @php $is_flagged = true;
                                            @endphp
                                            @endif
                                            @php $question_status_class = isset( $questions_status_array[$question_id] )? $questions_status_array[$question_id] : 'waiting'; @endphp
                                            <li data-question_id="{{$question_id}}" class="swiper-slide {{ ( $is_flagged == true)?
                                                    'has-flag' : ''}} {{$question_status_class}}"><a
                                                    href="javascript:;">
                                                    {{$question_count}}</a></li>
                                            @php $question_count++; @endphp
                                            @endforeach
                                            @endif
                                        </ul>
                                        </div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
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


<div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 col-sm-12 mt-50">
            <div class="question-step quiz-complete" style="display:none">
                <div class="question-layout-block">
                    <div class="left-content has-bg">
                        <h2>&nbsp;</h2>
                        <div id="rureraform-form-1"
                             class="rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable"
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
                $question_no, 'quizAttempt' => $quizAttempt, 'newQuestionResult' => $newQuestionResult, 'quizResultObj' => $newQuizStart
                ])
                @php $question_no++; @endphp
                @endforeach
                @else
                @include('web.default.panel.questions.question_layout',['question'=> $question, 'question_no' =>
                $question_no, 'prev_question' => $prev_question, 'next_question' => $next_question , 'quizAttempt' =>
                $quizAttempt, 'newQuestionResult' => $newQuestionResult, 'quizResultObj' => $newQuizStart
                ])
                @endif
            </div>

            <div class="question-area-temp hide"></div>

        </div>
    </div>
</div>
    </section>


</div>

@endsection

@push('scripts_bottom')

<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_id}}"></script>
<script>
    init_question_functions();
    $('body').addClass('quiz-show');
    var header = document.getElementById("navbar");
    var headerOffset = (header != null) ? header.offsetHeight : 100;
    var header_height = parseInt(headerOffset) + parseInt(85) + "px";


    if(jQuery('.quiz-pagination .swiper-container').length > 0){
              console.log('slides-count');
              console.log($(".quiz-pagination ul li").length);
            const swiper = new Swiper('.quiz-pagination .swiper-container', {
              slidesPerView: ($(".quiz-pagination ul li").length > 20)? 20 : $(".quiz-pagination ul li").length,
              spaceBetween: 0,
              slidesPerGroup: 5,
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
                  slidesPerView: ($(".quiz-pagination ul li").length > 20)? 20 : $(".quiz-pagination ul li").length,
                  spaceBetween: 5
                },

                640: {
                  slidesPerView: ($(".quiz-pagination ul li").length > 20)? 20 : $(".quiz-pagination ul li").length,
                  spaceBetween: 5
                }
              }
            })
          }
</script>
@endpush
