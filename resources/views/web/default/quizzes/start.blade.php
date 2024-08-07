@extends('web.default.layouts.appstart',['appFooter' => false, 'appHeader' => false])
@php
$rand_id = rand(99,9999);
$learning_journey = (isset( $learning_journey ) && $learning_journey == 'yes')? 'yes' : 'no';
$test_type = isset( $test_type )? $test_type : '';
$question_ids = isset( $question_ids )? $question_ids : array();
$is_new = isset( $is_new )? $is_new : 'no';
@endphp
@push('styles_top')
<link rel="stylesheet" href="/assets/default/learning_page/styles.css?var={{$rand_id}}"/>
<link rel="stylesheet" href="/assets/default/css/panel.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>

<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">

<style>
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate{display:none !important;}
</style>
@endpush
@section('content')

<div class="learning-page type-{{$quiz->quiz_type}} type-sats" >


    <div class="d-flex position-relative">


        <div class="learning-page-content flex-grow-1 bg-info-light p-15">
            <div class="default-loaded-data rurera-hide" data-is_started_already="{{isset( $resultObj->id)? 'yes' : 'no' }}"></div>
            <div class="learning-content read-quiz-content {{isset( $resultObj->id)? 'rurera-hide' : '' }}" id="learningPageContent">

                @php $content_class = ''; @endphp
                @if( $quiz->quiz_type == 'vocabulary' || $quiz->quiz_type == 'practice')
                @php $content_class = 'hide'; @endphp
                @endif

                <section class="quiz-topbar start-landing-page {{$content_class}}">
                <div class="container-fluid">
                    <div class="row">


                        <div class="col-lg-5 col-md-6 col-sm-12">
                            @if( isset( $quiz->quiz_type ))
                                <img class="quiz-type-icon" src="/assets/default/img/assignment-logo/{{$quiz->quiz_type}}.png">
                            @endif
                            <div class="quiz-top-info"><p>{{$quiz->getTitleAttribute()}}</p>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">

                            <div class="topbar-right">
                                <div class="quiz-timer">
								
								@php 
								$remaining_time = 0;
									if(isset( $resultObj->total_time_consumed)){
										$remaining_time = ($quiz->time*60)-$resultObj->total_time_consumed;
										
									}
								@endphp

                                    <span class="timer-number"><div class="quiz-timer-counter {{isset( $timer_hide )? $timer_hide : ''}}" data-time_counter="{{isset( $timer_counter )? $timer_counter : ''}}">{{getTimeWithText($remaining_time, true, true)}}</div></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                <div class="row justify-content-center">
                <div class="d-flex align-items-center justify-content-center w-100">
                    @php $content_class = ''; @endphp
                    @if( $quiz->quiz_type == 'vocabulary' || $quiz->quiz_type == 'practice')
                    @php $content_class = 'hide'; @endphp
                        <div class="start-counter"></div>
                    @endif


                    <div class="learning-content-box {{$content_class}} d-flex align-items-center justify-content-center flex-column p-15 p-lg-30 rounded-lg">


						@if( isset( $quiz->quiz_instructions ) && $quiz->quiz_instructions != '')
							   <div class="instruction-text">
								<h3>INSTRUCTIONS</h3>
								{!! $quiz->quiz_instructions !!}
								</div>
					   @endif
                        <div class="instruction-text rurera-hide">
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

                        <div class="learning-content-box-icon">
                            <img src="/assets/default/img/learning/quiz.svg" alt="downloadable icon">
                        </div>

                        <a href="javascript:;" data-id="{{$quiz->id}}" data-is_new="{{$is_new}}" data-question_ids="{{json_encode($question_ids)}}" data-test_type="{{$test_type}}" data-learning_journey="{{$learning_journey}}" data-journey_item_id="{{isset( $journey_item_id )? $journey_item_id : 0}}"  data-quiz_url="/panel/quizzes/{{$quiz->id}}/start"
                           class="quiz-start-btn start-spell-quiz btn btn-primary btn-sm mt-15">{{isset( $button_label)? $button_label : 'Start Test'}}</a>
                        <div class="learning-content-quiz">
                           
                        </div>

                    </div>
                </div>

                @if( !empty( $resultData ) && !empty((array) $resultData)  )

                <section class="lms-data-table {{$content_class}} my-80">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <h3>Summary of your previous attempts</h3>
                                <table class="table table-striped table-bordered dataTable display responsive" style="width: 100%;"
                                       aria-describedby="example_info">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Date: activate to sort column descending">Attempt #
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Date: activate to sort column descending">Date
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Time: activate to sort column ascending">Time
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Questions: activate to sort column ascending">Questions
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Correct: activate to sort column ascending">Correct
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Incorrect: activate to sort column ascending">Incorrect
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Unanswered: activate to sort column ascending">Unanswered
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Percent: activate to sort column ascending">Accuracy
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Quiz: activate to sort column ascending">Quiz Status
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $attempt_count = 1; @endphp
                                    @foreach( $resultData as $resultObj)

                                    <tr class="odd">
                                        <td>{{$attempt_count}}</td>
                                        <td>{{ dateTimeFormat($resultObj->created_at, 'j M Y H:iA') }}</td>
                                        <td>{{ ($resultObj->status == 'waiting')? '-' : $resultObj->time_consumed .'/'. $resultObj->average_time }} </td>
                                        <td>{{$resultObj->attempted}} / {{$resultObj->total_questions}}</td>
                                        <td>{{ ($resultObj->status == 'waiting')? '-' : $resultObj->correct }} </td>
                                        <td>{{ ($resultObj->status == 'waiting')? '-' : $resultObj->incorrect }} </td>
                                        <td>{{ ($resultObj->status == 'waiting')? '-' : $resultObj->unanswered }} </td>
                                        <td>{{ ($resultObj->status == 'waiting')? '-' : $resultObj->percentage.'%'}} </td>
                                        @if( $resultObj->status == 'waiting')
                                            <td><a href="javascript:;" data-id="{{$quiz->id}}" class="quiz-start-btn" data-quiz_url="/panel/quizzes/{{$quiz->id}}/start">Resume</a></td>
                                        @else
                                        <td><a href="/panel/quizzes/{{$resultObj->result_id}}/check_answers">Check Answers</a></td>
                                        @endif

                                    </tr>
                                    @php $attempt_count++; @endphp
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                @endif
                </div>
            </div>


        </div>
    </div>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/video/youtube.min.js"></script>
<script src="/assets/default/vendors/video/vimeo.js"></script>


<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs"
        data-app-key="v5gxvm7qj1ku9la"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
<script src="/assets/default/js/question-layout.js?var={{$rand_id}}"></script>
<script src="/assets/learning_page/scripts.min.js?var={{$rand_id}}"></script>

@if((!empty($isForumPage) and $isForumPage) or (!empty($isForumAnswersPage) and $isForumAnswersPage))
<script src="/assets/learning_page/forum.min.js"></script>
@endif
@endpush
<script>
    //init_question_functions();

    if( "{{$quiz->quiz_type}}" == 'vocabulary' || "{{$quiz->quiz_type}}" == 'practice') {
        var start_counter = 6;

        var Startintervals = setInterval(function () {
            if (parseInt(start_counter) > 1) {
                start_counter = parseInt(start_counter) - parseInt(1);
                $(".start-counter").html(start_counter);
            } else {
                $(".start-counter").remove();
                clearInterval(Startintervals);
                $(".quiz-start-btn").click();
                $(".learning-content-box").removeClass('hide')
            }
        }, 1000);
    }
</script>
