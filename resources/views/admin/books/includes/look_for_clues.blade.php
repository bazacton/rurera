@php $data_values = json_decode($pageInfoLink->data_values);  @endphp
<div style="{{$pageInfoLink->info_style}}" data-is_new="no"
     class="drop-item form-group draggablecl field_settings draggable_field_{{$pageInfoLink->id}}"
     data-id="{{$pageInfoLink->id}}" data-field_type="look_for_clues"
     data-trigger_class="infobox-look_for_clues-fields" data-infobox_title="{{$pageInfoLink->info_title}}"
     data-infobox_value="{{isset($data_values->infobox_value)? $data_values->infobox_value : ''}}">
    <div class="field-data"><img src="/assets/default/img/book-icons/look_for_clues.png">
    </div>
    <a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>
</div>

