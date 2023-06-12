@php $data_values = json_decode($pageInfoLink->data_values);  @endphp
<div style="{{$pageInfoLink->info_style}}" data-is_new="no"
     class="drop-item form-group draggablecl field_settings draggable_field_{{$pageInfoLink->id}}"
     data-id="{{$pageInfoLink->id}}" data-field_type="try_do_it_yourself"
     data-trigger_class="infobox-try_do_it_yourself-fields" data-infobox_title="{{$pageInfoLink->info_title}}"
     data-infobox_value="{{isset($data_values->infobox_value)? $data_values->infobox_value : ''}}">
    <div class="field-data"><img src="/assets/default/img/book-icons/try_do_it_yourself.png">
    </div>
    <a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>
</div>

