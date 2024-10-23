@php $label_before = isset( $elementObj->label_before ) ? $elementObj->label_before : '';
$label_after = isset( $elementObj->label_after ) ? $elementObj->label_after : '';
@endphp

<div id="rureraform-element-{{$element_unique_id}}" class="rureraform-element-{{$element_unique_id}} rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="{{$elementObj->type}}">
	
	<span class="input-holder {{isset( $elementObj->style_format ) ? $elementObj->style_format : ''}}">
		@if($label_before != '')
			<span class="input-label" contenteditable="false">{{$label_before}}</span>
		@endif
		<input type="{{isset( $elementObj->text_format ) ? $elementObj->text_format : 'text'}}" data-field_type="text" maxlenghth="{{isset( $elementObj->maxlength ) ? $elementObj->maxlength : ''}}" placeholder="{{isset( $elementObj->placeholder ) ? $elementObj->placeholder : ''}}" class="editor-field input-simple  {{isset( $elementObj->style_format ) ? $elementObj->style_format : ''}}" data-field_id="{{isset( $elementObj->field_id ) ? $elementObj->field_id : 0}}" data-id="{{isset( $elementObj->field_id ) ? $elementObj->field_id : 0}}" id="field-{{isset( $elementObj->field_id ) ? $elementObj->field_id : 0}}">
		@if($label_after != '')
			<span class="input-label" contenteditable="false">{{$label_after}}</span>
		@endif
	</span>
</div>
