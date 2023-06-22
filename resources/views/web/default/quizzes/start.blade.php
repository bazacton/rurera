@extends('web.default.layouts.appstart',['appFooter' => false, 'appHeader' => false])
@php
$rand_id = rand(99,9999);
@endphp
@push('styles_top')
<link rel="stylesheet" href="/assets/default/learning_page/styles.css?var={{$rand_id}}"/>
<link rel="stylesheet" href="/assets/default/css/panel.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

@section('content')

<div class="learning-page">


    <div class="d-flex position-relative">


        <div class="learning-page-content flex-grow-1 bg-info-light p-15">
            <div class="learning-content" id="learningPageContent">
                <div class="learning-title">
                    <h3 class="mb-5">{{$quiz->getTitleAttribute()}}</h3>
                    <span class="font-12 font-weight-400 text-gray">Go to the quiz page for more information</span>
                </div>
                <div class="d-flex align-items-center justify-content-center w-100">
                    <button id="collapseBtn" type="button" class="btn-transparent ml-auto ml-lg-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div
                            class="learning-content-box d-flex align-items-center justify-content-center flex-column p-15 p-lg-30 rounded-lg">
                        <div class="learning-content-box-icon">
                            <img src="/assets/default/img/learning/quiz.svg" alt="downloadable icon">
                        </div>

                        <a href="javascript:;" data-quiz_url="/panel/quizzes/{{$quiz->id}}/start"
                           class="quiz-start-btn btn btn-primary btn-sm mt-15">Start Quiz</a>
                        <div class="learning-content-quiz"></div>

                    </div>
                </div>

                @if( !empty( $resultData ) )
                <section class="lms-data-table my-80">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-bordered dataTable" style="width: 100%;"
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
                                        <td>2008-11-28 2:30pm</td>
                                        <td>{{$resultObj->time_consumed}} / {{$resultObj->average_time}}</td>
                                        <td>{{$resultObj->attempted}} / {{$resultObj->total_questions}}</td>
                                        <td>{{$resultObj->correct}}</td>
                                        <td>{{$resultObj->incorrect}}</td>
                                        <td>{{$resultObj->unanswered}}</td>
                                        <td>{{$resultObj->percentage}}%</td>
                                        @if( $resultObj->status == 'waiting')
                                            <td><a href="javascript:;" class="quiz-start-btn" data-quiz_url="/panel/quizzes/{{$quiz->id}}/start">Resume</a></td>
                                        @else
                                            <td>Progress</td>
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
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/video/youtube.min.js"></script>
<script src="/assets/default/vendors/video/vimeo.js"></script>


<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs"
        data-app-key="v5gxvm7qj1ku9la"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
<script src="/assets/learning_page/scripts.min.js?var={{$rand_id}}"></script>

@if((!empty($isForumPage) and $isForumPage) or (!empty($isForumAnswersPage) and $isForumAnswersPage))
<script src="/assets/learning_page/forum.min.js"></script>
@endif
@endpush
