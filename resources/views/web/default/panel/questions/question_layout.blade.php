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
//$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question->question_layout)))));
//$question_layout = str_replace('<div class="group_questions_data">Questions Group</div>', $group_questions_layout, $question_layout);
$question_layout = $QuestionsAttemptController->get_question_layout($question);

$search_tags = ($question->search_tags != '')? explode(' | ', $question->search_tags) : array();
$is_development = (!empty( $search_tags ) && in_array('development', $search_tags))? true : false;
$total_questions = count(json_decode($quizAttempt->questions_list));

@endphp


				
					<form class="question-fields" action="javascript:;" data-question_id="{{ $question->id }}">
					<meta name="csrf-token" content="{{ csrf_token() }}">
                    @php $already_flagged = ($quizResultObj->flagged_questions != '') ? (array)
                    json_decode($quizResultObj->flagged_questions) : array();
                    $flag_class = (in_array($question->id, $already_flagged))? 'flaged' : 'notflaged';
                    @endphp
                    @if( $question->review_required == 1 || $is_development == true)
                    <div class="question-review-required">
                        @if( $question->review_required == 1)
                        <div class="question-label-tag">Review Required</div>
                        @endif
                        @if( $is_development == true)
                        <div class="question-label-tag">Developer Review Required</div>
                        @endif
                    </div>
                    @endif
                    <span class="questions-total-holder d-block mb-30"><span class="question-dev-details">({{ $question->id }}) ({{ $question->question_difficulty_level }}) ({{ $question->question_type }})</span></span>

                        @if($layout_type != 'results')
                        <span class="question-number-holder" style="z-index: 999999999;"> <span class="question-number">{{$question_no}}</span>
                            </span>
                        @endif

                    @php $classes = isset( $class )? $class : ''; @endphp
                    <div id="rureraform-form-1"
                         class="{{$classes}} rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable"
                         _data-parent="1"
                         _data-parent-col="0" style="display: block;">
                        <div class="question-layout">
                            @if( isset( $show_marks ) && $show_marks == true)
                                @if($layout_type != 'results')
                                <span class="marks" data-marks="{{$question->question_score}}">{{$question->question_score}} marks</span>
                                @endif
                            @endif
                            {!! $question_layout !!}

                            <div class="validation-error"></div>
                        </div>

                    </div>
					</form>
					
					
					
					
					
					
					
					

                
<script>
    function question_layout_functions() {
        var Questioninterval = setInterval(function () {
            var seconds_count = $(".question-step-{{ $question->id }}").attr('data-elapsed');
            seconds_count = parseInt(seconds_count) + parseInt(1);
            $(".question-step-{{ $question->id }}").attr('data-elapsed', seconds_count);
        }, 1000);
    }
</script>

