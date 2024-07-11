@extends('web.default.layouts.appstart',['appFooter' => false, 'appHeader' => false])
@php
$rand_id = rand(99,9999);
@endphp
@push('styles_top')
<link rel="stylesheet" href="/assets/default/learning_page/styles.css?var={{$rand_id}}"/>
<link rel="stylesheet" href="/assets/default/css/panel.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">

<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">

<style>
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate{display:none !important;}
</style>
@endpush

@section('content')

<div class="learning-page type-sats">


    <div class="d-flex position-relative">


        <div class="learning-page-content flex-grow-1 bg-info-light p-15">
            <div class="default-loaded-data rurera-hide"></div>
            <div class="learning-content read-quiz-content" id="learningPageContent">


                <section class="quiz-topbar start-landing-page">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            @if( isset( $assignmentObj->StudentAssignmentData->assignment_type ))
                            <img class="quiz-type-icon" src="/assets/default/img/assignment-logo/{{$assignmentObj->StudentAssignmentData->assignment_type}}.png">
                        @endif
                            <div class="quiz-top-info"><p>{{$title}}</p>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                            <div class="topbar-right">
                                <div class="quiz-timer">

                                    <span class="timer-number"><div class="quiz-timer-counter {{isset( $timer_hide )? $timer_hide : ''}}" data-time_counter="{{isset( $timer_counter )? $timer_counter : ''}}">{{getTime(isset( $timer_counter )? $timer_counter : 0)}}</div></span>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                <div class="row justify-content-center">
                <div class="d-flex align-items-center justify-content-center w-100">


                    <div class="learning-content-box d-flex align-items-center justify-content-center flex-column p-15 p-lg-30 rounded-lg">

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

                        <a href="javascript:;" data-id="{{$assignmentObj->id}}" data-quiz_url="/assignment/{{$assignmentObj->id}}/start"
                           class="quiz-start-btn start-spell-quiz btn btn-primary btn-sm mt-15">Start Quiz</a>
                        <div class="learning-content-quiz">
                            @if( isset( $assignmentObj->StudentAssignmentData->description ) && $assignmentObj->StudentAssignmentData->description != '')
                                   <h3>Instructions:</h3>
                               {!! $assignmentObj->StudentAssignmentData->description !!}
                           @endif
                        </div>




                    </div>
                </div>

                @if( !empty( $resultData ) && !empty((array) $resultData)  )

                <section class="lms-data-table my-80">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">

                                <h3>Summary of your previous attempts </h3>
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
                                            <td><a href="javascript:;" data-id="{{$assignmentObj->id}}" class="quiz-start-btn" data-quiz_url="/assignment/{{$assignmentObj->id}}/start">Resume</a></td>
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
<div class="quiz-question-status-modal">
  <div class="modal fade quiz_question_status_modal" id="quiz_question_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            <a href="javascript:;" class="confirm-btn quiz-question-confirm-btn" data-dismiss="modal" aria-label="Close">Okay</a>
          </div>
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
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
<script src="/assets/learning_page/scripts.min.js?var={{$rand_id}}"></script>

@if((!empty($isForumPage) and $isForumPage) or (!empty($isForumAnswersPage) and $isForumAnswersPage))
<script src="/assets/learning_page/forum.min.js"></script>
<script>
	function afterQuestionValidation(return_data, thisForm, question_id) {
		console.log('afterQuestionValidation');
		var question_status_class = (return_data.incorrect_flag == true) ? 'incorrect' : 'correct';
		var total_points = $(".lms-quiz-section").attr('data-total_points');
		if( question_status_class == 'correct' ){
			total_points = parseInt(total_points)+1;
			$(".total-points").attr('data-total-points', total_points);
			$(".lms-quiz-section").attr('data-total_points', total_points);
			$(".total-points span").html(total_points);
		}
    }
</script>
@endif
@endpush
