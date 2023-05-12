@php
$glossary_items = get_glossary_items($question->glossary_ids);
@endphp
<div class="question-fail-block container">
        <div class="row">
        <div class="col-12 col-lg-6">
            <div class="lms-radio-holder">
                <div class="lms-title">
                    <strong>sorry, incorrect...</strong>
                    <div class="lms-radio-lists">
                    <span class="list-title">The correct answer is:</span>
                    <div class="lms-radio-items">
                        <ul class="lms-radio-btn-group lms-correct-answer-block">
                            
                        </ul>
                    </div>
                     </div>
                </div>
            </div>
            <span class="field-sub-title">Explanation</span>
            <div class="lms-remember-holder mt-15">
                <span class="lms-ribbons">review</span>
                <div class="lms-radio-lists">
                        <div class="lms-radio-items lms-explanation-block">
                        </div>
                        <span class="list-title">You answered:</span>
                        <ul class="lms-radio-btn-group lms-user-answer-block"></ul>
                </div>
            </div>
             @if(!$glossary_items->isEmpty())
            <div class="lms-remember-holder mt-15">
                <span class="lms-ribbons">remember</span>
                 @foreach($glossary_items as $key => $glossaryData)
                    <span>{!! $glossaryData->description !!}</span><br><br>
                 @endforeach
            </div>
			@endif
        </div>
		
        <div class="col-12 col-lg-6">
			@if( strip_tags($question->question_solve) != '')
				<div class="lms-question-contant">
					<span class="lms-ribbons">solve</span>
					{!! $question->question_solve !!}
				</div>
			@endif
           
        </div>
    </div>
    </div>