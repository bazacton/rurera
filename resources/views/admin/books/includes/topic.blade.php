@php $data_values = json_decode($pageInfoLink->data_values);  @endphp
<div style="{{$pageInfoLink->info_style}}" data-is_new="no"
     class="drop-item form-group draggablecl field_settings draggable_field_{{$pageInfoLink->id}}"
     data-id="{{$pageInfoLink->id}}" data-field_type="topic"
     data-trigger_class="infobox-topic-fields"
     data-topic_title="{{isset($data_values->topic_title)? $data_values->topic_title : ''}}">
    <div class="field-data">{{isset($data_values->topic_title)? $data_values->topic_title : '<img src="/assets/default/img/book-icons/quiz.png">'}}
    </div>
    <a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>
</div>

