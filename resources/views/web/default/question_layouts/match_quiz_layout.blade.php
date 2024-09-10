@php $hasImage = !empty(array_filter($elementObj->options, fn($options) => isset($options) && !empty($options->image))); 
$has_image_class = ($hasImage == 1)? 'lms-radio-img' : '';
@endphp

<div id="rureraform-element-{{$element_id}}" class="quiz-group draggable3 rureraform-element-{{$element_id}} rureraform-element rureraform-element-label-undefined rureraform-element-description-undefined ui-sortable-handle" data-type="checkbox">
    <div class="rureraform-column-label"><label class="rureraform-label rureraform-ta-undefined">{{$elementObj->label}}</label></div>
    <div class="rureraform-column-input">
        <div class="rureraform-input rureraform-cr-layout-undefined rureraform-cr-layout-undefined">
		
            <div class="form-box {{$elementObj->template_style}} {{$elementObj->list_style}} {{$elementObj->image_size}} {{$has_image_class}} {{$elementObj->template_alignment}}">
			
			
			
				<div class="lms-sorting-fields" id="lmssort{{$element_id}}">
					<div class="match-question">
					  <div class="stems">
						<ol>
						
						@if( !empty( $elementObj->options ))
							@foreach( $elementObj->options as $option_index => $optionObj)
								@if( !isset( $optionObj->label ))
									@php continue; @endphp
								@endif
								<li id="{{$optionObj->label}}" scope="col" data-id="field-{{$element_id}}-{{$option_index}}">
								@if( isset( $optionObj->image ) && $optionObj->image != '')
									<img src="{{$optionObj->image}}" alt="">
								@endif
								{{$optionObj->label}}</li>
							@endforeach
						@endif
						</ol>
					  </div>
					  <div class="options">
						<ol start="a">
						
						@if( !empty( $elementObj->options2 ))
							@foreach( $elementObj->options2 as $option_index => $optionObj)
								@if( !isset( $optionObj->label ))
									@php continue; @endphp
								@endif
								<li data-id="field-{{$element_id}}-{{$option_index}}" id="{{$optionObj->label}}">
								@if( isset( $optionObj->image ) && $optionObj->image != '')
									<img src="{{$optionObj->image}}" alt="">
								@endif
								{{$optionObj->label}}<input type="text" class="hide editor-field" name="field-{{$element_id}}" id="field-{{$element_id}}-{{$option_index}}"></li>
							@endforeach
						@endif
						</ol>
					  </div>
					</div>
				</div>
			
			
			
			
            </div>
        </div>
        <label class="rureraform-description"></label>
    </div>
    <div class="rureraform-element-cover"></div>
</div>
