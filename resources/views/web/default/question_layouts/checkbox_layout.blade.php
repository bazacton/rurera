@php $randomID = rand(0,9999); $image_position = isset( $elementObj->image_position )? $elementObj->image_position : 'left'; 
$options = isset( $elementObj->options )? $elementObj->options : array();
$correctCount = count(array_filter($options, function ($option) {
    return isset($option->default) && $option->default === 'on';
}));
$element_unique_id = isset( $element_unique_id )? $element_unique_id : $element_id; 
@endphp
<div id="rureraform-element-{{$element_unique_id}}" class="quiz-group rureraform-element-{{$element_unique_id}} rureraform-element rureraform-element-label-undefined ui-sortable-handle" data-type="checkbox">
    <div class="rureraform-column-label"><label class="rureraform-label rureraform-ta-undefined">{{$elementObj->label}}</label></div>
    <div class="rureraform-column-input">
        <div class="rureraform-input rureraform-cr-layout-undefined rureraform-cr-layout-undefined">
            <div class="form-box {{$elementObj->template_style}} {{isset( $elementObj->template_alignment )? $elementObj->template_alignment : ''}} {{isset( $elementObj->image_size )? $elementObj->image_size : ''}}">
			
			
				@if( !empty( $elementObj->options ))
					@foreach( $elementObj->options as $option_index => $optionObj)
						@php $option_index .= $option_index.'-'.$randomID;  $image_path = '';
						@endphp
						@if( !isset( $optionObj->label ))
							@php continue; @endphp
						@endif
						@if( isset( $optionObj->image ) && $optionObj->image != '')
							@php $image_path = '<img src="'.$optionObj->image.'" alt="">'; @endphp
						@endif
						<div class="form-field rureraform-cr-container-medium rureraform-cr-container-undefined">
							<input class="editor-field rureraform-checkbox-medium" data-min="{{$correctCount}}" type="checkbox" name="field-{{$element_unique_id}}" id="field-{{$element_unique_id}}-{{$option_index}}" value="{{$optionObj->value}}" /><label for="field-{{$element_unique_id}}-{{$option_index}}">
							@if( $image_position == 'left' ){!! $image_path !!} @endif
							{{$optionObj->label}}
							@if( $image_position == 'right' ){!! $image_path !!} @endif
							</label>
						</div>
					@endforeach
				@endif
            </div>
        </div>
        @if( isset( $elementObj->description ) && $elementObj->description != '')
			<label class="rureraform-description">{{$elementObj->description}}</label>
        @endif
    </div>
    <div class="rureraform-element-cover"></div>
</div>
