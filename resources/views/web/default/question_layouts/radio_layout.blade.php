@php $hasImage = !empty(array_filter($elementObj->options, fn($options) => isset($options) && !empty($options->image))); 
$has_image_class = ($hasImage == 1)? 'lms-radio-img' : '';
@endphp
@php $randomID = rand(0,9999); @endphp
<div id="rureraform-element-{{$element_id}}" class="quiz-group draggable3 rureraform-element-{{$element_id}} rureraform-element rureraform-element-label-undefined rureraform-element-description-undefined ui-sortable-handle" data-type="checkbox">
    <div class="rureraform-column-label"><label class="rureraform-label rureraform-ta-undefined">{{$elementObj->label}}</label></div>
    <div class="rureraform-column-input">
        <div class="rureraform-input rureraform-cr-layout-undefined rureraform-cr-layout-undefined">
            <div class="form-box {{$elementObj->template_style}} {{$elementObj->list_style}} {{$has_image_class}}">
				<div class="lms-radio-select {{$elementObj->template_style}} undefined ">
			
				@if( !empty( $elementObj->options ))
					@foreach( $elementObj->options as $option_index => $optionObj)
						@php $option_index .= $option_index.'-'.$randomID; @endphp
						@if( !isset( $optionObj->label ))
							@php continue; @endphp
						@endif
						<div class="form-field rureraform-cr-container-medium rureraform-cr-container-undefined">
							<input class="editor-field" type="radio" name="field-{{$element_id}}" id="field-{{$element_id}}-{{$option_index}}" value="{{$optionObj->value}}" />
							<label for="field-{{$element_id}}-{{$option_index}}">
							@if( isset( $optionObj->image ) && $optionObj->image != '')
								<img src="{{$optionObj->image}}" alt="">
							@endif
							<span class="inner-label">{{$optionObj->label}}</span></label>
						</div>
					@endforeach
				@endif
				</div>
            </div>
        </div>
        <label class="rureraform-description"></label>
    </div>
    <div class="rureraform-element-cover"></div>
</div>
