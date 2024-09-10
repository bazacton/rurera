@php namespace App\Http\Controllers\Web; @endphp
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp


<style>
    .ui-state-highlight {
        margin: 0px 10px;
    }

    .field-holder.wrong, .form-field.wrong, .form-field.wrong label {
        background: #ff4a4a;
        color: #fff;
    }

    .rurera-hide {
        display: none;
    }

</style>
@php $quiz_type = isset( $quiz->quiz_type )? $quiz->quiz_type : ''; @endphp
@php $timer_counter = 0;
if( $duration_type == 'per_question'){
$timer_counter = $time_interval;
}
if( $duration_type == 'total_practice'){
$timer_counter = $practice_time;
}
$section_class = 'lms-quiz-section';
$section_class = ($quiz->quiz_type == 'vocabulary')? 'lms-quiz-section1' : $section_class;
@endphp
<div class="content-section">

    <section class="lms-quiz-section">

        @if( $quiz->quiz_pdf != '')
        <script type="text/javascript">
            $(document).ready(function () {
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
            });

        </script>
        <div class="read-quiz-info quiz-show"></div>
        <script>


        </script>
        @endif

        <div class="container-fluid questions-data-block read-quiz-content"
             data-total_questions="{{$quizQuestions->count()}}">
            @php $top_bar_class = ($quiz->quiz_type == 'vocabulary')? 'rurera-hide' : ''; @endphp

            <section class="quiz-topbar {{$top_bar_class}}">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            @if( isset( $quiz->quiz_type ))
                               <img class="quiz-type-icon" src="/assets/default/img/assignment-logo/{{$quiz->quiz_type}}.png">
                           @endif
                            <div class="quiz-top-info"><p>{{$quiz->getTitleAttribute()}} - assignment_start</p>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                            <div class="topbar-right">
                                @if( isset( $show_pagination) && $show_pagination == 'yes')
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
                                @endif
                                <div class="quiz-timer">
                                    <span class="timer-number"><div class="quiz-timer-counter {{$timer_hide}}" data-time_counter="{{$timer_counter}}">{{getTime($timer_counter)}}</div></span>
                                </div>
                                <div class="instruction-controls">
                                    <div class="font-setting">
                                        <button class="font-btn">
                                            <img src="/assets/default/svgs/settings.svg" alt="#">
                                        </button>
                                        <div class="instruction-dropdown">
                                            <div class="font-controls">
                                                <a href="#" class="decreasetext">
                                                    <img src="/assets/default/svgs/small-font.svg" alt="#">
                                                </a>
                                                <a href="#" class="resettext">
                                                    <img src="/assets/default/svgs/reset-text.svg" alt="#">
                                                </a>
                                                <a href="#" class="increasetext">
                                                    <img src="/assets/default/svgs/big-text.svg" alt="#">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="color-setting">
                                        <button class="color-btn">
                                            <img src="/assets/default/svgs/color-setting.svg" alt="#">
                                        </button>
                                        <div class="instruction-dropdown">
                                            <div class="color-controls">
                                                <a href="#" class="cr-aquaBlue-btn"></a>
                                                <a href="#" class="cr-celery-btn"></a>
                                                <a href="#" class="cr-grass-btn"></a>
                                                <a href="#" class="cr-jade-btn"></a>
                                                <a href="#" class="cr-magenta-btn"></a>
                                                <a href="#" class="cr-orange-btn"></a>
                                                <a href="#" class="cr-purple-btn"></a>
                                                <a href="#" class="cr-skyBlue-btn"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-setting">
                                        <button class="info-btn">
                                            <img src="/assets/default/svgs/info-icon.svg" alt="#">
                                        </button>
                                        <div class="instruction-dropdown">
                                            <div class="instruction-text">
                                                            <h3>INSTRUCTIONS</h3>
                                                            <h4>Setting Up Your Page</h4>
                                                            <p>Before you start the test you can use the buttons on the top right of the screen to choose:</p>
                                                            <ul>
                                                                <li>a coloured overlay (this will change the background colour and may help you read the questions better)</li>
                                                            </ul>
                                                            <img src="/assets/default/img/overlay.png" alt="#">
                                                            <ul>
                                                                <li>the font size</li>
                                                            </ul>
                                                            <img src="/assets/default/img/font-size.png">
                                                            <p>We recommend you setup your page BEFORE the test starts.</p>
                                                            <p>Changing these features during the test will reduce the amount of time you have to answer the questions.</p>
                                                            <hr style="border-color:rgba(130, 80, 232, 0.15)">
                                                            <h4>Navigating The Test</h4>
                                                            <p>Read the instructions for each question carefully.</p>
                                                            <p>Choose your answer by clicking on it. If you want to change your mind, click on a different answer.</p>
                                                            <p>Once you are sure of your answer click ‘Submit Answer’. You will not be able to go back to change your answer.</p>
                                                            <img src="/assets/default/img/answer.png" alt="#">
                                                            <p>You can use a pen/pencil and paper to make notes if you wish. Your working and notes will not be marked.</p>
                                                            <hr style="border-color:rgba(130, 80, 232, 0.15)">
                                                            <h4>About The Test</h4>
                                                            <p>The Verbal Reasoning Test assesses a range of English language skills including:</p>
                                                            <ul>
                                                                <li>Comprehension</li>
                                                                <li>Reasoning</li>
                                                                <li>Logic</li>
                                                            </ul>
                                                            <p>The questions you see in this Walkthrough are examples of these types.</p>
                                                            <p>Some of these types may appear in the test, while others may not.</p>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="justify-content-center">
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
                    @php $timer_hide = (isset( $timer_hide) && $timer_hide == true)? 'rurera-hide' : ''; @endphp
                    <div class="quiz-timer-counter {{$timer_hide}}" data-time_counter="{{$timer_counter}}">{{getTime($timer_counter)}}</div>
                    <div class="question-area-block" data-duration_type="{{$duration_type}}" data-time_interval="{{$time_interval}}" data-practice_time="{{$practice_time}}"
                                             data-active_question_id="{{$active_question_id}}" data-questions_layout="{{json_encode($questions_layout)}}">

                        @if( is_array( $question ))
                        @php $question_no = 1; @endphp

                        @foreach( $question as $questionObj)
                        @include('web.default.panel.questions.question_layout',[
                        'question'=> $questionObj,
                        'prev_question' => 0,
                        'next_question' => 0,
                        'question_no' => $question_no,
                        'quizAttempt' => $quizAttempt,
                        'newQuestionResult' => $newQuestionResult,
                        'quizResultObj' => $newQuizStart
                        ])
                        @php $question_no++; @endphp
                        @endforeach
                        @else
                        @php $first_question = rurera_decode($questions_layout[$first_question_id]);
                        echo $first_question;
                        @endphp

                        @endif
                    </div>

                    <div class="question-area-temp hide"></div>

                </div>
            </div>
        </div>
    </section>


</div>

@if($quiz->quiz_type == 'vocabulary')
<div class="question-status-modal">
    <div class="modal fade question_status_modal" id="question_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-box">
                        <div class="modal-title">
                            <h3>Incorrect!</h3>
                            <span class="inc" style="text-decoration: line-through;">are</span>
                            <span class="cor">are</span>
                        </div>
                        <p>
                            <span>verb</span> when more than one person is being something
                        </p>
                        <a href="javascript:;" class="confirm-btn" data-dismiss="modal" aria-label="Close">Okay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="modal fade review_submit" id="review_submit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div class="modal-body">
                <p></p>
                <a href="javascript:;" class="submit_quiz_final nav-link mt-20 btn-primary rounded-pill" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab"
                   aria-controls="home" aria-selected="true"> Submit </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade validation_error" id="validation_error" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div class="modal-body">
                <p>Please fill all the required fields before submitting.</p>
            </div>
        </div>
    </div>
</div>
<a href="#" data-toggle="modal" class="hide review_submit_btn" data-target="#review_submit">modal button</a>


<script>
    //init_question_functions();
    $('body').addClass('quiz-show');
    var header = document.getElementById("navbar");
    var headerOffset = (header != null) ? header.offsetHeight : 100;
    var header_height = parseInt(headerOffset) + parseInt(85) + "px";

    var Quizintervals = null;

    var duration_type = $(".question-area-block").attr('data-duration_type');
    var time_interval = $(".question-area-block").attr('data-time_interval');
    var practice_time = $(".question-area-block").attr('data-practice_time');


        function quiz_default_functions() {
            $("body").on("click", ".question-submit-btn", function (e) {
                if (duration_type == 'per_question') {
                    clearInterval(Quizintervals);
                }
            });

            Quizintervals = setInterval(function () {
                var quiz_timer_counter = $('.quiz-timer-counter').attr('data-time_counter');
                if (duration_type == 'no_time_limit') {
                    quiz_timer_counter = parseInt(quiz_timer_counter) + parseInt(1);
                } else {
                    quiz_timer_counter = parseInt(quiz_timer_counter) - parseInt(1);
                }
                $('.quiz-timer-counter').html(getTime(quiz_timer_counter));
                if ($('.nub-of-sec').length > 0) {
                    $('.nub-of-sec').html(getTime(quiz_timer_counter));
                }
                $('.quiz-timer-counter').attr('data-time_counter', quiz_timer_counter);
                if (duration_type == 'per_question') {
                    if (parseInt(quiz_timer_counter) == 0) {
                        clearInterval(Quizintervals);
                        $('.question-submit-btn').attr('data-bypass_validation', 'yes');
                        $('#question-submit-btn')[0].click();
                    }
                }
                if (duration_type == 'total_practice') {
                    if (parseInt(quiz_timer_counter) == 0) {
                        clearInterval(Quizintervals);
                        $(".review-btn").click();
                        if ($('.question-review-btn').length > 0) {
                            $('.question-review-btn').click();
                        }
                    }
                }

            }, 1000);

            $("body").on("click", ".increasetext", function (e) {
                curSize = parseInt($('.learning-page').css('font-size')) + 2;
                if (curSize <= 32)
                    $('.learning-page').css('font-size', curSize);
            });

            $("body").on("click", ".resettext", function (e) {
                if (curSize != 16)
                $('.learning-page').css('font-size', 18);
            });

            $("body").on("click", ".decreasetext", function (e) {
                curSize = parseInt($('.learning-page').css('font-size')) - 2;
                if (curSize >= 16)
                $('.learning-page').css('font-size', curSize);
            });

        }

    function getTime(secondsString) {
        var h = Math.floor(secondsString / 3600); //Get whole hours
        secondsString -= h * 3600;
        var m = Math.floor(secondsString / 60); //Get remaining minutes
        secondsString -= m * 60;

        
        var return_string = '';
        if( h > 0) {
            var return_string = return_string + h + "h ";
        }
        var quiz_type = '{{$quiz_type}}';
        if( (m > 0 || h > 0) || quiz_type != 'vocabulary') {
            var return_string = return_string + (m < 10 ? '0' + m : m) + "m ";
        }
        var return_string = return_string + (secondsString < 10 ? '0' + secondsString : secondsString);
        return_string = return_string + 's';

        return return_string;
    }

</script>
