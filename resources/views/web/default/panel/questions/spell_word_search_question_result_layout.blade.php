<style>
.empty-field {
    background: #aeaaaa !important;
}
</style>
@php
$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($newQuestionResult->quiz_layout)))));
$random_id = rand(999,999999);
@endphp
<div class="result-question-layout-{{$random_id}}">
	{{$user_answer}}
{!! $question_layout !!}
</div>