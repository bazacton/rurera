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
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-left mb-30">
                        <h2 class="mt-0 mb-10 font-22">Spelling word lists</h2>
                        <p class="font-16"> Work through a variety of practice questions to improve your skills and become familiar with
                            the types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>


                <div class="col-12">
                    <div class="listing-search lms-jobs-form mb-20">
                        <a href="#." class="filter-mobile-btn">Filters Dropdown</a>
                        <ul class="inline-filters">
                            @php $active = ($quiz_category == '')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells"><span class="icon-box">
                                                                    <img src="/assets/default/svgs/filter-all.svg">
                                                                </span>All Word Lists</a></li>
                            @php $active = ($quiz_category == 'Word Lists')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells?quiz_category=Word+Lists"><span class="icon-box">
                                                                                                <img src="/assets/default/svgs/filter-letters.svg">
                                                                                            </span>Word Lists
                                </a></li>
                            @php $active = ($quiz_category == 'Spelling Bee')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells?quiz_category=Spelling+Bee"><span class="icon-box">
                                                                    <img src="/assets/default/svgs/filter-words.svg">
                                                                </span>Spelling Bee
                                </a></li>
                        </ul>
                    </div>
                </div>

                @if( !empty( $data))

                <div class="col-12">
                    <section class="lms-data-table mt-0 mb-30 spells elevenplus-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">


                                    @php $total_questions_all = $total_attempts_all = $total_questions_attempt_all = $correct_questions_all =
                                    $incorrect_questions_all = $pending_questions_all = $not_used_words_all = 0;
                                    @endphp

                                    @foreach( $data as $dataObj)
                                    @php
									$vocabulary_words = $dataObj->vocabulary_words();
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

                                    $level_easy_in_progress = false;
                                    $level_medium_in_progress = false;
                                    $level_hard_in_progress = false;

                                    $easy_progress_percentage = $medium_progress_percentage = $hard_progress_percentage = 0;
                                    $overall_attempted_questions = 0;
                                    $total_attempted_questions = $dataObj->parentResultsQuestions->where('quiz_level', 'easy')->groupBy('question_id')->count();
                                    $overall_attempted_questions += $total_attempted_questions;
                                    if( $level_easy == 0){
                                        $total_results_count  = $dataObj->parentResults->where('quiz_level', 'easy')->count();
                                        $level_easy_in_progress = ($total_results_count > 0)? true : false;

                                        if( $level_easy_in_progress == true){
                                            $easy_progress_percentage = ($total_attempted_questions > 0)? round(($total_attempted_questions *100) / $total_questions) : 0;
                                        }
                                    }
                                    $total_attempted_questions = $dataObj->parentResultsQuestions->where('quiz_level', 'medium')->groupBy('question_id')->count();
                                    $overall_attempted_questions += $total_attempted_questions;
                                    if( $level_medium == 0){
                                        $total_results_count  = $dataObj->parentResults->where('quiz_level', 'medium')->count();
                                        $level_medium_in_progress = ($total_results_count > 0)? true : false;

                                        if( $level_medium_in_progress == true){
                                            $medium_progress_percentage = ($total_attempted_questions > 0)? round(($total_attempted_questions *100) / $total_questions) : 0;
                                        }
                                    }
                                    $total_attempted_questions = $dataObj->parentResultsQuestions->where('quiz_level', 'hard')->groupBy('question_id')->count();
                                    $overall_attempted_questions += $total_attempted_questions;
                                    if( $level_hard == 0){
                                        $total_results_count  = $dataObj->parentResults->where('quiz_level', 'hard')->count();
                                        $level_hard_in_progress = ($total_results_count > 0)? true : false;
                                        if( $level_hard_in_progress == true){
                                            $hard_progress_percentage = ($total_attempted_questions > 0)? round(($total_attempted_questions *100) / $total_questions) : 0;
                                        }
                                    }

                                    $overall_percentage = ($overall_attempted_questions > 0)? round(($overall_attempted_questions *100) / ($total_questions*3)) : 0;
                                    $level_easy_in_progress_class = ($level_easy_in_progress == true)? 'circle' : '';
                                    $level_medium_in_progress_class = ($level_medium_in_progress == true)? 'circle' : '';
                                    $level_hard_in_progress_class = ($level_hard_in_progress == true)? 'circle' : '';

                                    $in_progress = false;
                                    $in_progress_class = ($in_progress == true)? 'circle' : '';

                                    $spell_quiz_completed = '';
                                    if( $level_easy == 1 && $level_medium == 1 && $level_hard == 1){
                                        $spell_quiz_completed = 'spell-completed';
                                    }

                                    $treasure_box_closed = '<li class="treasure">
                                                        <a href="#">
                                                            <span class="thumb-box">
                                                                <img src="/assets/default/img/treasure2.png" alt="">
                                                            </span>
                                                        </a>
                                                    </li>';
                                    $treasure_box_opened = '<li class="treasure">
                                                                <a href="#">
                                                                    <span class="thumb-box">
                                                                        <img src="/assets/default/img/treasure.png" alt="">
                                                                    </span>
                                                                </a>
                                                            </li>';
                                    @endphp

                                    <div class="spell-levels {{$spell_quiz_completed}}">
                                        <div class="spell-levels-top">
                                            <div class="spell-top-left">
                                                <h3 class="font-18 font-weight-bold">{{$dataObj->getTitleAttribute()}}</h3>
												<div class="spell-links">
												<a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-hunts/exercise">Word Hunts</a>
												<a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-search/exercise">Word Search</a>
												<a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-cloud/exercise">Word Cloud</a>
												<a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-missing/exercise">Complete the Sentence</a>
												<a href="javascript:;">Flashcards</a>
												</div>
                                                @if($overall_percentage > 0 && $overall_percentage != 100)
                                                <div class="levels-progress horizontal">
                                                    <span class="progress-box">
                                                        <span class="progress-count" style="width: {{$overall_percentage}}%;"></span>
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="spell-top-right">
                                                <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling-list" class="words-count"><img src="/assets/default/img/skills-icon.png" alt=""><span>{{$total_questions}}</span>word(s)</a>
                                            </div>
                                        </div>
                                        <ul class="justify-content-start">


                                            <li class="easy {{($level_easy == 1)? 'completed' : 'completed'}}" data-id="{{$dataObj->id}}" data-quiz_level="easy">
                                                @if($easy_progress_percentage > 0)
                                                    <div class="levels-progress {{$level_easy_in_progress_class}}" data-percent="{{$easy_progress_percentage}}">
                                                        <span class="progress-box">
                                                            <span class="progress-count"></span>
                                                        </span>
                                                    </div>
                                                @endif
                                                <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling/exercise">
                                                    @if($level_easy == 1 || $level_easy_in_progress_class != '')
                                                        <img src="/assets/default/img/flag-complete.png" alt="">
                                                    @else
                                                        <img src="/assets/default/img/stepon.png" alt="">
                                                    @endif

                                                </a>
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <h4 class="font-19 font-weight-bold">Level # 1</h4>
                                                        <span>No time limit, Discover Word Meanings, Word Sentence.</span>
                                                    </div>
                                                </div>
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
                                                    @if($medium_progress_percentage > 0)
                                                        <div class="levels-progress {{$level_medium_in_progress_class}}" data-percent="{{$medium_progress_percentage}}">
                                                            <span class="progress-box">
                                                                <span class="progress-count"></span>
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling/exercise">
                                                        @if($level_medium == 1 || $level_medium_in_progress_class != '')
                                                            <img src="/assets/default/img/flag-complete.png" alt="">
                                                        @else
                                                            <img src="/assets/default/img/stepon.png" alt="">
                                                        @endif
                                                    </a>
                                                @else
                                                    <a href="#">
                                                        <img src="/assets/default/img/panel-lock.png" alt="">
                                                    </a>
                                                @endif
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <h4 class="font-19 font-weight-bold">Level # 2</h4>
                                                        <span>Beat the Clock, Discover Word Meanings.</span>
                                                    </div>
                                                </div>
                                            </li>
                                            @if($treasure_after == 'after_medium')
                                                @if($level_medium == 1)
                                                    {!! $treasure_box_opened !!}
                                                @else
                                                    {!! $treasure_box_closed !!}
                                                @endif
                                            @endif
                                            <li class="Hard {{($level_medium == 1)? 'completed' : ''}}" data-id="{{$dataObj->id}}" data-quiz_level="hard">
                                                @if($level_medium == 1)
                                                    @if($hard_progress_percentage > 0)
                                                        <div class="levels-progress {{$level_hard_in_progress_class}}" data-percent="{{$hard_progress_percentage}}">
                                                            <span class="progress-box">
                                                                <span class="progress-count"></span>
                                                            </span>
                                                        </div>
                                                    @endif
                                                <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling/exercise">
                                                    @if($level_hard == 1 || $level_hard_in_progress_class != '')
                                                        <img src="/assets/default/img/flag-complete.png" alt="">
                                                    @else
                                                        <img src="/assets/default/img/stepon.png" alt="">
                                                    @endif
                                                </a>
                                                @else
                                                    <a href="#">
                                                        <img src="/assets/default/img/panel-lock.png" alt="">
                                                    </a>
                                                @endif
                                                <div class="spell-tooltip">
                                                    <div class="spell-tooltip-text">
                                                        <h4 class="font-19 font-weight-bold">Level # 3</h4>
                                                        <span>Race Against the Clock, Master the Challenge!</span>
                                                    </div>
                                                </div>
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
        $('.spell-levels ul').slideUp();
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


    $(document).on('click', '.spell-levels-top', function (e) {
        if (!$(e.target).closest('.spell-top-right').length) {
            $(this).closest('.spell-levels').find('ul').slideToggle();
        }

    });







</script>
@endpush
