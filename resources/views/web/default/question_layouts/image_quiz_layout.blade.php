<div id="rureraform-element-{{$element_id}}" class="{{ isset( $elementObj->image_position ) ? $elementObj->image_position : ''}} {{ isset( $elementObj->image_size ) ? $elementObj->image_size : ''}} rureraform-element-{{$element_id}} rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="{{$elementObj->type}}">
	<span classname="block-holder image-field"><img data-field_type="image" data-id="{{$element_unique_id}}" id="field-{{$element_unique_id}}" class="image-editor-field" src="{{ isset( $elementObj->content ) ? $elementObj->content : ''}}"></span>
</div>
