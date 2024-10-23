@php $label_type = isset( $elementObj->label_type ) ? $elementObj->label_type : 'question_label'; @endphp
<div id="rureraform-element-{{$element_id}}" class="rureraform-element-{{$element_id}} rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="{{$elementObj->type}}">
	@if($label_type == 'h1' || $label_type == 'h2' || $label_type == 'h3')
		<{{$label_type}}>{!! $elementObj->content !!}</{{$label_type}}>
	@else
		<div class="question-label {{$label_type}}"><span>{!! $elementObj->content !!}</span></div>
	@endif
</div>
