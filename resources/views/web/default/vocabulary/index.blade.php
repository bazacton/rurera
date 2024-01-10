@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<script src="/assets/default/vendors/charts/chart.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style>
    .hide {
        display: none !important;
    }
</style>
@endpush

@section('content')

<section class="content-section">
    <section class="pt-80" style="background-color: #fff;">
        <div class="container">
            <div class="row pt-80">

                <div class="col-12">
                    <div class="section-title text-left mb-50">
                        <h2 class="mt-0 mb-10 font-40">11Plus Online 10-Minutes test practices</h2>
                        <p class="font-19"> Work through a variety of practice questions to improve your skills and become familiar with
                            the <br> types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>



                @if( !empty( $data))

                <div class="col-12">
                    <section class="pb-70">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="master-list">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="master-card master">
                                                    <strong>Mastered Words</strong> <span>{{count($user_mastered_words)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="master-card non-master">
                                                    <strong>Troubled Words</strong> <span>{{count($user_non_mastered_words)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="master-card non-use">
                                                    <strong>Not Used Words</strong> <span class="rurera-processing"><div class="rurera-button-loader" style="display: block;"><div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div></div></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="lms-data-table my-30 spells elevenplus-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">


                                    <div class="spell-levels levels-grouping">
                                        <div class="spell-levels-top">
                                            <strong>Unite 3 : Grouping and identifying organisms</strong>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <div class="levels-progress circle" data-percent="85">
                                                        <span class="progress-box">
                                                            <span class="progress-count"></span>
                                                      </span>
                                                    </div>
                                                    <span class="thumb-box">
                                                        <img src="/assets/default/img/thumb1.png" alt="">
                                                    </span>
                                                </a>
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <strong>Hello!</strong>
                                                        <span>Learn greetings for meeting people</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="levels-progress circle" data-percent="55">
                                                        <span class="progress-box">
                                                            <span class="progress-count"></span>
                                                      </span>
                                                    </div>
                                                    <span class="thumb-box">
                                                        <img src="/assets/default/img/thumb1.png" alt="">
                                                    </span>
                                                </a>
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <strong>Introducing yourself</strong>
                                                        <span>Say your name</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="treasure">
                                                <a href="#">
                                                    <span class="thumb-box">
                                                        <img src="/assets/default/img/treasure.png" alt="">
                                                    </span>
                                                </a>
                                            </li>

                                            <li>

                                                <a href="#">
                                                    <div class="levels-progress circle" data-percent="75">
                                                        <span class="progress-box">
                                                            <span class="progress-count"></span>
                                                      </span>
                                                    </div>
                                                    <span class="thumb-box">
                                                        <img src="/assets/default/img/thumb1.png" alt="">
                                                    </span>
                                                </a>
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <strong>Saying how you are</strong>
                                                        <span>Complete all Topics above to unlock this!</span>
                                                    </div>
                                                </div>
                                            </li><li>
                                                <a href="#">
                                                    <div class="levels-progress circle" data-percent="30">
                                                        <span class="progress-box">
                                                            <span class="progress-count"></span>
                                                      </span>
                                                    </div>
                                                    <span class="thumb-box">
                                                        <img src="/assets/default/img/thumb1.png" alt="">
                                                    </span>
                                                </a>
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <strong>Developing fluency</strong>
                                                        <span>Complete all Topics above to unlock this!</span>
                                                    </div>
                                                </div>
                                            </li>
                                    </ul>
                                    </div>


                                    @php $total_questions_all = $total_attempts_all = $total_questions_attempt_all = $correct_questions_all =
                                    $incorrect_questions_all = $pending_questions_all = $not_used_words_all = 0;
                                    @endphp

                                    @foreach( $data as $dataObj)
                                    @php
                                    $treasure_after = isset( $dataObj->treasure_after)? $dataObj->treasure_after : 'no_treasure';
                                    $resultData = $QuestionsAttemptController->get_result_data($dataObj->id);
                                    $total_attempts = $total_questions_attempt = $correct_questions =
                                    $incorrect_questions = 0;
                                    $mastered_words = $non_mastered_words = $in_progress_words = 0;
                                    $total_questions = isset( $dataObj->quizQuestionsList )? count(
                                    $dataObj->quizQuestionsList) : 0;

                                    $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
                                    $is_passed = isset( $resultData->is_passed )? $resultData->is_passed : false;
                                    $in_progress = isset( $resultData->in_progress )? $resultData->in_progress :
                                    false;
                                    $current_status = isset( $resultData->current_status )?
                                    $resultData->current_status
                                    : '';
                                    $button_label = ($in_progress == true)? 'Resume' :'Practice Now';
                                    $button_label = ($is_passed == true) ? 'Practice Again' : $button_label;

                                    @endphp


                                    @if( !empty( $resultData ) )

                                    @php $attempt_count = 1; @endphp
                                    @foreach( $resultData as $resultObj)
                                        @php

                                        $mastered_words += $resultObj->mastered_words;
                                        $non_mastered_words += $resultObj->non_mastered_words;
                                        $in_progress_words += $resultObj->in_progress_words;
                                        $total_questions_attempt += $resultObj->attempted;
                                        $total_questions_attempt += $resultObj->attempted;
                                        $correct_questions += $resultObj->correct;
                                        $incorrect_questions += $resultObj->incorrect;
                                        $total_attempts++;
                                        @endphp

                                        @php $attempt_count++; @endphp
                                    @endforeach

                                    @endif

                                    @php
                                    $total_percentage = 0;
                                    if( $total_questions_attempt > 0 && $correct_questions > 0){
                                    $total_percentage = ($correct_questions * 100) / $total_questions_attempt;
                                    }
                                    @endphp

                                    @php $total_questions_all += $total_questions;
                                    $total_questions_attempt_all += $total_questions_attempt;
                                    $correct_questions_all += $correct_questions;
                                    $incorrect_questions_all += $incorrect_questions;
                                    $pending_questions_all += ($total_questions - $total_questions_attempt);
                                    $not_used_words_all += ($total_questions - $mastered_words - $non_mastered_words - $in_progress_words);


                                    $level_easy = isset( $dataObj->vocabulary_achieved_levels->level_easy )? $dataObj->vocabulary_achieved_levels->level_easy : 0;
                                    $level_medium = isset( $dataObj->vocabulary_achieved_levels->level_medium )? $dataObj->vocabulary_achieved_levels->level_medium : 0;
                                    $level_hard = isset( $dataObj->vocabulary_achieved_levels->level_hard )? $dataObj->vocabulary_achieved_levels->level_hard : 0;



                                    $treasure_box_closed = '<li class="treasure">
                                                        <a href="#">
                                                            <span class="thumb-box">
                                                                <img src="/assets/default/img/treasure3.png" alt="">
                                                            </span>
                                                        </a>
                                                    </li>';
                                    $treasure_box_opened = '<li class="treasure">
                                                                <a href="#">
                                                                    <span class="thumb-box">
                                                                        <img src="/assets/default/img/treasure2.png" alt="">
                                                                    </span>
                                                                </a>
                                                            </li>';
                                    @endphp

                                    <div class="spell-levels">
                                        <div class="spell-levels-top">
                                            <div class="spell-top-left">
                                                <strong>{{$dataObj->getTitleAttribute()}} - {{$treasure_after}} -- {{$level_easy}}</strong>
                                            </div>
                                            <div class="spell-top-right">
                                                <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling-list" class="words-count"><img src="/assets/default/img/skills-icon.png" alt=""><span>{{$total_questions}}</span>word(s)</a>
                                            </div>
                                        </div>
                                        <ul class="justify-content-start">
                                            <li class="easy {{($level_easy == 1)? 'completed' : ''}}" data-id="{{$dataObj->id}}" data-quiz_level="easy">
                                                <div class="levels-progress {{($level_easy == 0)? 'circle' : ''}}" data-percent="75">
                                                    <span class="progress-box">
                                                        <span class="progress-count"></span>
                                                    </span>
                                                </div>
                                                <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling/exercise">1</a>
                                            </li>
                                            @if($treasure_after == 'after_easy')
                                                @if($level_easy == 1)
                                                    {!! $treasure_box_opened !!}
                                                @else
                                                    {!! $treasure_box_closed !!}
                                                @endif
                                            @endif
                                            <li class="intermediate {{($level_easy == 1)? 'completed' : ''}}" data-id="{{$dataObj->id}}" data-quiz_level="medium">
                                                @if($level_easy == 1)
                                                    <div class="levels-progress {{($level_medium == 0)? 'circle' : ''}}" data-percent="75">
                                                        <span class="progress-box">
                                                            <span class="progress-count"></span>
                                                        </span>
                                                    </div>
                                                    <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling/exercise">2</a>
                                                @else
                                                    <a href="#">
                                                        <img src="/assets/default/img/panel-lock.png" alt="">
                                                    </a>
                                                @endif
                                            </li>
                                            @if($treasure_after == 'after_medium')
                                                @if($level_medium == 1)
                                                    {!! $treasure_box_opened !!}
                                                @else
                                                    {!! $treasure_box_closed !!}
                                                @endif
                                            @endif
                                            <li class="Hard {{($level_easy == 1)? 'completed' : ''}}" data-id="{{$dataObj->id}}" quiz_level="hard">
                                                @if($level_medium == 1)
                                                    <div class="levels-progress {{($level_hard == 0)? 'circle' : ''}}" data-percent="75">
                                                        <span class="progress-box">
                                                            <span class="progress-count"></span>
                                                        </span>
                                                    </div>
                                                <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling/exercise">3</a>
                                                @else
                                                    <a href="#">
                                                        <img src="/assets/default/img/panel-lock.png" alt="">
                                                    </a>
                                                @endif
                                            </li>
                                            @if($treasure_after == 'after_hard')
                                                @if($level_hard == 1)
                                                    {!! $treasure_box_opened !!}
                                                @else
                                                    {!! $treasure_box_closed !!}
                                                @endif
                                            @endif
                                    </ul>
                                    </div>
                                    @endforeach





                                    <div class="spell-levels">
                                        <div class="spell-levels-top">
                                            <div class="spell-top-left">
                                                <strong>Unit 3 : Grouping and identifying organisms</strong>
                                                <a href="#" class="words-count simple"><img src="/assets/default/img/skills-icon.png" alt=""><span>80</span>skills</a>
                                                <div class="levels-progress horizontal">
                                                    <span class="progress-box">
                                                        <span class="progress-count" style="width: 40%;"></span>
                                                    </span>
                                                    <span class="progress-numbers">04 / 08</span>
                                                </div>
                                            </div>
                                            <div class="spell-top-right">
                                                <span class="spell-top-img">
                                                    <img src="/assets/default/img/spell-lelvel-top-img.png" alt="#">
                                                </span>
                                            </div>
                                        </div>
                                        <ul>
                                            <li class="easy">
                                                <div class="levels-progress circle">
                                                    <span class="progress-box">
                                                        <span class="progress-count"></span>
                                                    </span>
                                                </div>
                                                <a href="#"><img src="/assets/default/img/panel-star.png" alt=""></a>
                                            </li>
                                            <li class="intermediate">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                            </li>
                                            <li class="treasure">
                                                <a href="#"><img src="/assets/default/img/treasure3.png" alt=""></a>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <strong>Atoms, elements and the Periodic Table</strong>
                                                        <span>Complete all Topics above to unlock this!</span>
                                                        <a href="#" class="locked-btn">Locked</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                            </li>
                                            <li class="treasure">
                                                <a href="#"><img src="/assets/default/img/treasure3.png" alt=""></a>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <strong>Atoms, elements and the Periodic Table</strong>
                                                        <span>Complete all Topics above to unlock this!</span>
                                                        <a href="#" class="locked-btn">Locked</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/panel-lock.png" alt=""></a>
                                            </li>
                                            <li class="Hard">
                                                <a href="#"><img src="/assets/default/img/treasure4.png" alt=""></a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                @endif

            </div>
        </div>
    </section>



    <a href="#" class="scroll-btn" style="display: block;">
        <div class="round">
            <div id="cta"><span class="arrow primera next"></span> <span class="arrow segunda next"></span></div>
        </div>
    </a>

</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.graph-data-ul li a', function (e) {
            $('.graph-data-ul li a').removeClass('active');
            $(this).addClass('active');
            var graph_id = $(this).attr('data-graph_id');
            $('.graph_div').addClass('hide');
            $('.' + graph_id).removeClass('hide');
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.graph-data-ul li a', function (e) {
            $('.graph-data-ul li a').removeClass('active');
            $(this).addClass('active');
            var graph_id = $(this).attr('data-graph_id');
            $('.graph_div').addClass('hide');
            $('.' + graph_id).removeClass('hide');
        });

        $('body').on('change', '.analytics_graph_type', function (e) {
            var thisObj = $('.chart-summary-fields');
            rurera_loader(thisObj, 'div');
            var graph_type = $(this).val();
            jQuery.ajax({
                type: "GET",
                url: '/panel/analytics/graph_data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"graph_type": graph_type},
                success: function (return_data) {
                    rurera_remove_loader(thisObj, 'div');
                    if (return_data != '') {
                        $(".analytics-graph-data").html(return_data);
                    }
                }
            });

        });


        //$(".master-card.master span").html('{{$correct_questions_all}}');
        //$(".master-card.non-master span").html('{{$incorrect_questions_all}}');
        $(".master-card.non-use span").html('{{$not_used_words_all}}');

    });
    $(document).on('click', '.play-btn', function (e) {
        var player_id = $(this).attr('data-id');

        $(this).toggleClass("pause");
        if($(this).hasClass('pause')) {
            document.getElementById(player_id).play();
        }else{
            document.getElementById(player_id).pause();
        }
    });

    $(document).on('click', '.spell-levels ul li a', function (e) {

        var quiz_id = $(this).closest('li').attr('data-id');
        var quiz_level = $(this).closest('li').attr('data-quiz_level');
        localStorage.setItem('quiz_level_'+quiz_id, quiz_level);
    });





</script>
@endpush
