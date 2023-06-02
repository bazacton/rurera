@php $data_values = json_decode($pageInfoLink->data_values);  @endphp
<div style="{{$pageInfoLink->info_style}}" data-is_new="no"
     class="drop-item form-group draggablecl field_settings draggable_field_{{$pageInfoLink->id}}"
     data-id="{{$pageInfoLink->id}}" data-field_type="highlighter" data-trigger_class="highlighter-fields"
     data-background="">
    <div class="field-data">
        <div class="stage-shapes resizeable data_style_field" data-style_id="highlighter_size" style="{{isset($data_values->highlighter_size)? $data_values->highlighter_size : ''}}">
            <div class="customizable-field text-highlighter data_style_field"
                 data-style_id="highlighter_background" style="{{isset($data_values->highlighter_background)? $data_values->highlighter_background : ''}}"></div>
        </div>
    </div>
    <span class="field-handle fas fa-arrows-alt"></span>
    <a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>
</div>
