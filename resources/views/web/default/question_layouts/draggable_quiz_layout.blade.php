@php $hasImage = !empty(array_filter($elementObj->options, fn($options) => isset($options) && !empty($options->image))); 
$has_image_class = ($hasImage == 1)? 'lms-radio-img' : '';
@endphp
@php $randomID = rand(0,9999); @endphp



<div id="rureraform-element-{{$element_id}}" class="quiz-group draggable3 rureraform-element-{{$element_id}} rureraform-element rureraform-element-label-undefined rureraform-element-description-undefined ui-sortable-handle" data-type="draggable_quiz">


	<div class="rureraform-column-label"><label class="rureraform-label rureraform-ta-undefined">{{$elementObj->label}}</label></div>
	   {!! $content !!}
	   
	   @if( !empty( $elementObj->options ))
		   <ul class="draggable-items">
			@foreach( $elementObj->options as $option_index => $optionObj)
				@if( !isset( $optionObj->label ))
					@php continue; @endphp
				@endif
				<li><span class="draggable-option">{{$optionObj->label}}</span></li>
			@endforeach
			</ul>
		@endif
    <div class="rureraform-element-cover"></div>
</div>
