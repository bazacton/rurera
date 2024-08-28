<div id="leform-element-{{$element_id}}" class="quiz-group leform-element-0 leform-element leform-element-label-undefined ui-sortable-handle" data-type="checkbox">
    <div class="leform-column-label"><label class="leform-label leform-ta-undefined">{{$elementObj->label}}</label></div>
    <div class="leform-column-input">
        <div class="leform-input leform-cr-layout-undefined leform-cr-layout-undefined">
            <div class="form-box rurera-in-cols {{$elementObj->template_alignment}} {{$elementObj->image_size}}">
			
				@if( !empty( $elementObj->options ))
					@foreach( $elementObj->options as $option_index => $optionObj)
						@if( !isset( $optionObj->label ))
							@php continue; @endphp
						@endif
						<div class="form-field leform-cr-container-medium leform-cr-container-undefined">
							<input class="editor-field leform-checkbox-medium" type="checkbox" name="field-{{$element_id}}" id="field-{{$element_id}}-{{$option_index}}" value="{{$optionObj->value}}" /><label for="field-{{$element_id}}-{{$option_index}}">{{$optionObj->label}}</label>
						</div>
					@endforeach
				@endif
            </div>
        </div>
        <label class="leform-description"></label>
    </div>
    <div class="leform-element-cover"></div>
</div>
