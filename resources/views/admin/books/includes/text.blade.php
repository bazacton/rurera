@php $data_values = json_decode($pageInfoLink->data_values);
$data_color = isset($data_values->text_color)? str_replace('color: ','', $data_values->text_color) : ''
@endphp
<div style="{{$pageInfoLink->info_style}} {{isset($data_values->text_color)? $data_values->text_color : ''}}" data-is_new="no"
     class="drop-item form-group draggablecl field_settings draggable_field_{{$pageInfoLink->id}}"
     data-id="{{$pageInfoLink->id}}" data-field_type="text" data-trigger_class="p-fields"
     data-paragraph_value="{{isset($data_values->text_html)? $data_values->text_html : ''}}" data-color="{{$data_color}}">
    <div class="field-data customizable-field data_style_field data_html_field" data-html_id="text_html"
         data-style_id="text_color" contenteditable="true">{{isset($data_values->text_html)? $data_values->text_html : ''}}
    </div>
    <span class="field-handle fas fa-arrows-alt"></span>
    <a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>
</div>

