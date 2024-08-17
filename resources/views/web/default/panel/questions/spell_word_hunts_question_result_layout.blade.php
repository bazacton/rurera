<style>
.empty-field {
    background: #aeaaaa !important;
}
</style>
@php
$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($newQuestionResult->quiz_layout)))));
$random_id = rand(999,999999);
@endphp
<div class="result-question-layout-{{$random_id}} {{isset( $class )? $class : ''}}">
{!! $question_layout !!}
</div>
<script>

// User answer
var userAnswer = "{{$user_answer}}";
// Convert userAnswer to an array of characters
var answerArray = userAnswer.split('');

var parentElement = document.querySelector('.result-question-layout-{{$random_id}}');
// Get all elements with the class 'empty-field'
var emptyFields = parentElement.querySelectorAll('.editor-field-inputs');

// Loop through empty fields and set the value
emptyFields.forEach((field, index) => {
	if (index < answerArray.length) {
		field.value = answerArray[index];
	}
});
</script>