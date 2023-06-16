@php $rand_id = rand(999,99999); @endphp
<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="question-step quiz-complete" style="display:none">
    <div class="question-layout-block">
        <div class="left-content has-bg">
            <h2>&nbsp;</h2>
            <div id="leform-form-1" class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable" _data-parent="1"
                 _data-parent-col="0" style="display: block;">
                <div class="question-layout">

                </div>
            </div>
        </div>

    </div>
</div>

@php
$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question->question_layout)))));
@endphp

<div class="question-area">
    <div class="question-step question-step-{{ $question->id }}" data-qattempt="{{$quizAttempt->id}}" data-start_time="0" data-qresult="{{$newQuestionResult->id}}"
         data-quiz_result_id="{{$quizAttempt->quiz_result_id}}">
        <div class="question-layout-block">
            <div class="correct-appriciate" style="display:none"></div>
            <form class="question-fields" action="javascript:;" data-question_id="{{ $question->id }}">
                <div class="left-content has-bg">
                    <span class="question-number-holder"> <span class="question-number">{{$question_no}}</span>  </span>
                    <div id="leform-form-1" class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable" _data-parent="1"
                         _data-parent-col="0" style="display: block;">
                        <div class="question-layout">
                            <span class="marks" data-marks="{{$question->question_score}}">{{$question->question_score}} marks</span>
                            {!! $question_layout !!}
                        </div>
                        <div class="form-btn">
                            <input class="question-submit-btn submit-btn" type="button" data-question_no="1" value="Submit">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
