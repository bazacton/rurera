<div id="rureraform-element-{{$element_unique_id}}" class="rureraform-element-{{$element_unique_id}} rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="{{$elementObj->type}}">
	
	<span class="input-holder {{isset( $elementObj->style_format ) ? $elementObj->style_format : ''}} {{isset( $elementObj->field_size ) ? $elementObj->field_size : ''}}">
		<span class="input-label" contenteditable="false"></span>
		<textarea data-field_type="textarea" placeholder="{{isset( $elementObj->placeholder ) ? $elementObj->placeholder : ''}}" rows="{{isset( $elementObj->rows ) ? $elementObj->rows : 5}}" class="editor-field input-simple" data-id="{{isset( $elementObj->field_id ) ? $elementObj->field_id : 0}}" id="field-{{isset( $elementObj->field_id ) ? $elementObj->field_id : 0}}"></textarea>
		</span>
	
</div>
