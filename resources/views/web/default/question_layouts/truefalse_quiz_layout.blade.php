@php $randomID = rand(0,9999); @endphp
<div id="rureraform-element-{{$element_id}}" class="quiz-group draggable3 rureraform-element-{{$element_id}} rureraform-element rureraform-element-label-undefined rureraform-element-description-undefined ui-sortable-handle" data-type="checkbox">
    <div class="rureraform-column-input">
        <div class="rureraform-input rureraform-cr-layout rureraform-cr-layout">
            <div class="form-box ">
				<div class="lms-radio-select rurera-in-row">
			
				<div class="form-field rureraform-cr-container-medium rureraform-cr-container-undefined">
					<input class="editor-field" type="radio" name="field-{{$element_id}}" id="field-{{$element_id}}-0" value="True" />
					<label for="field-{{$element_id}}-0">
					<span class="inner-label">True</span></label>
				</div>
				
				<div class="form-field rureraform-cr-container-medium rureraform-cr-container-undefined">
					<input class="editor-field" type="radio" name="field-{{$element_id}}" id="field-{{$element_id}}-1" value="False" />
					<label for="field-{{$element_id}}-1">
					<span class="inner-label">False</span></label>
				</div>
				
				</div>
            </div>
        </div>
        <label class="rureraform-description"></label>
    </div>
    <div class="rureraform-element-cover"></div>
</div>
