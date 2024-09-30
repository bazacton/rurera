@php $randomID = rand(0,9999); @endphp
<div id="rureraform-element-{{$element_id}}" class="quiz-group rureraform-element-{{$element_id}} rureraform-element rureraform-element-label-undefined ui-sortable-handle" data-type="checkbox">
    <div class="rureraform-column-label"><label class="rureraform-label rureraform-ta-undefined">{{$elementObj->label}}</label></div>
    <div class="rureraform-column-input">
        <div class="rureraform-input rureraform-cr-layout-undefined rureraform-cr-layout-undefined">
            <div class="form-box {{$elementObj->template_style}} {{isset( $elementObj->template_alignment )? $elementObj->template_alignment : ''}} {{isset( $elementObj->image_size )? $elementObj->image_size : ''}}">
			
				@if( !empty( $elementObj->options ))
					@foreach( $elementObj->options as $option_index => $optionObj)
						@php $option_index .= $option_index.'-'.$randomID; @endphp
						@if( !isset( $optionObj->label ))
							@php continue; @endphp
						@endif
						<div class="form-field rureraform-cr-container-medium rureraform-cr-container-undefined">
							<input class="editor-field rureraform-checkbox-medium" type="checkbox" name="field-{{$element_id}}" id="field-{{$element_id}}-{{$option_index}}" value="{{$optionObj->value}}" /><label for="field-{{$element_id}}-{{$option_index}}">{{$optionObj->label}}</label>
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
