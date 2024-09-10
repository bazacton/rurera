@php $rand_id = rand(999,99999); $layout_type = isset( $layout_type )? $layout_type : ''; @endphp

<meta name="csrf-token" content="{{ csrf_token() }}">


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

@php
$group_questions_layout  = isset( $group_questions_layout )? $group_questions_layout : '';
$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question->question_layout)))));
$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($newQuestionResult->quiz_layout)))));
$question_layout = str_replace('<div class="group_questions_data">Questions Group</div>', $group_questions_layout, $question_layout);
$question_unique_id = $question->id.$rand_id;
@endphp

<div class="question-area dis-arrows1 question-data-{{$question_unique_id}}">
    <div class="correct-appriciate" style="display:none"></div>
    <div class="question-step question-step-{{ $question->id }}" data-elapsed="0"
         data-qattempt="{{isset( $quizAttempt->id )? $quizAttempt->id : 0}}"
         data-start_time="0" data-qresult="{{isset( $newQuestionResult->id )? $newQuestionResult->id : 0}}"
         data-quiz_result_id="{{isset( $quizAttempt->quiz_result_id )? $quizAttempt->quiz_result_id : 0}}">
        <div class="question-layout-block">

            <form class="question-fields" action="javascript:;" data-question_id="{{ $question->id }}">
                <div class="left-content has-bg">
                    @php $classes = isset( $class )? $class : ''; @endphp
                    <div id="rureraform-form-1"
                         class="{{$classes}} rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable"
                         _data-parent="1"
                         _data-parent-col="0" style="display: block;">
						 <div class="question-layout-data">
						 </div>
                        <div class="question-layout rurera-hide">
                            
                            {!! $question_layout !!}

                            <div class="validation-error"></div>
                        </div>

                    </div>
                </div>





            </form>

        </div>
    </div>

</div>
<script>
var questionLabel = document.querySelector(".question-data-" + {{$question_unique_id}} + " .question-layout-block .question-label").innerHTML;
var questionAttemptElement = document.querySelector(".question-data-" + {{$question_unique_id}} + " .question-layout-block .question-count");
var questionAttempt = '';

if (questionAttemptElement) {
    questionAttempt = questionAttemptElement.innerHTML;
}

var embedded_html = '<div class="question-label">'+questionLabel+'</div>';

document.querySelector(".question-data-" + {{$question_unique_id}} + " .question-layout-data").innerHTML = embedded_html;
if (questionAttempt != '') {
	questionAttempt_html = '<div class="question-count">' + questionAttempt + '</div>';
    document.querySelector(".question-data-" + {{$question_unique_id}} + " .question-layout-data").innerHTML += questionAttempt_html;
}
document.querySelector(".question-data-" + {{$question_unique_id}} + " .question-layout").remove();
</script>
