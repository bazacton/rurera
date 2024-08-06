@extends(getTemplate().'.layouts.app')

@section('content')
<div class="container">
    <section class="mt-40">
        <h2 class="font-weight-bold font-16 text-dark-blue">Result</h2>

        <div class="activities-container shadow-sm rounded-lg mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">Passing Marks/{{ $questionsSumGrade }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('public.min') }} {{ trans('quiz.grade') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/88.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $numberOfAttempt }}/Total Attempts Allowed</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('quiz.attempts') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/45.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-secondary mt-5">{{ $quizResult->user_grade }}/{{  $questionsSumGrade }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('quiz.your_grade') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/44.svg" width="64" height="64" alt="">
                        <strong class="font-30 font-weight-bold text-{{ ($quizResult->status == 'passed') ? 'primary' : ($quizResult->status == 'waiting' ? 'warning' : 'danger') }} mt-5">
                            {{ trans('quiz.'.$quizResult->status) }}
                        </strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('public.status') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-30 quiz-form">
        <form action="" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="quiz_result_id" value="{{ !empty($newQuizStart) ? $newQuizStart->id : ''}}" class="form-control" placeholder=""/>
            <input type="hidden" name="attempt_number" value="{{  $numberOfAttempt }}" class="form-control" placeholder=""/>
            <input type="hidden" class="js-quiz-question-count" value="0"/>

            @foreach($quizResultQuestions as $key => $question)
            @php

            $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question->quiz_layout)))));
            $correct_answer_array = json_decode($question->correct_answer);

            $user_answer_array = json_decode($question->user_answer);

            @endphp


            <fieldset class="question-step question-step-{{ $key + 1 }}">
                <div class="rounded-lg shadow-sm py-25 px-20">
                    <div class="quiz-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="font-weight-bold font-16 text-secondary">{{ $question->question_title }}</h3>
                                <p class="text-gray font-16 mt-5">
                                    <span>{{ trans('quiz.question_grade') }} : {{ $question->grade }}</span> | <span>{{ trans('quiz.your_grade') }} : {{ (!empty($userAnswers[$question->id]) and !empty($userAnswers[$question->id]["grade"])) ? $userAnswers[$question->id]["grade"] : 0 }}</span>
                                </p>
                                {!! $question_layout !!}
                            </div>


                            <div class="rounded-sm border border-gray200 p-15 text-gray">{{ $key + 1 }}/Total Counts</div>
                        </div>



                        <div class="form-group mt-35">
                            <label class="input-label text-secondary">{{ trans('quiz.correct_answer') }}</label>
                            <ul class="lms-radio-btn-group lms-user-answer-block">
                                @foreach($correct_answer_array as $quiz_fields)
                                @foreach($quiz_fields as $correct_answer)
                                <li><label class="lms-question-label correct" for="radio2"><span>{{$correct_answer}}</span></label></li>
                                @endforeach
                                @endforeach

                            </ul>
                            <div class="d-flex flex-column align-items-center text-center" style="float: right;">
                                <img src="/assets/default/img/activity/58.svg" width="64" height="64" alt="" title="Time Consumed">
                                <strong class="font-30 font-weight-bold text-secondary mt-5">{{$question->time_consumed}}</strong>
                            </div>

                        </div>

                        <div class="form-group mt-35">
                            <label class="input-label text-secondary">{{ trans('quiz.student_answer') }}</label>
                            <ul class="lms-radio-btn-group lms-user-answer-block">
                                @if(!empty($user_answer_array))
                                    @foreach($user_answer_array as $quiz_fields)
                                        @foreach($quiz_fields as $user_answer)
                                            <li><label class="lms-question-label" for="radio2"><span>{{$user_answer}}</span></label></li>
                                        @endforeach
                                    @endforeach
                                @endif
                            </ul>

                        </div>

                        @if(!empty($newQuizStart) and $newQuizStart->quiz->creator_id == $authUser->id)
                        <div class="form-group mt-35">
                            <label class="font-16 text-secondary">{{ trans('quiz.grade') }}</label>
                            <input type="text" name="question[{{ $question->id }}][grade]" value="{{ (!empty($userAnswers[$question->id]) and !empty($userAnswers[$question->id]["grade"])) ? $userAnswers[$question->id]["grade"] : 0 }}" class="form-control">
                        </div>
                        @endif
                    </div>
                </div>
            </fieldset>

            @endforeach

            <div class="d-flex align-items-center mt-30">
                <button type="button" disabled class="previous btn btn-sm btn-primary mr-20">{{ trans('quiz.previous_question') }}</button>
                <button type="button" class="next btn btn-primary btn-sm mr-auto">{{ trans('quiz.next_question') }}</button>

                @if(!empty($newQuizStart))
                <button type="submit" class="finish btn btn-sm btn-danger">{{ trans('public.finish') }}</button>
                @endif
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
@endpush
