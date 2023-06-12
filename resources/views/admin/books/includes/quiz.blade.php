@php $data_values = json_decode($pageInfoLink->data_values);  @endphp
<div style="{{$pageInfoLink->info_style}}" data-is_new="no"
     class="drop-item form-group draggablecl field_settings draggable_field_{{$pageInfoLink->id}}"
     data-id="{{$pageInfoLink->id}}" data-field_type="quiz"
     data-trigger_class="infobox-quiz-fields"
     data-questions_ids="{{isset($data_values->questions_ids)? $data_values->questions_ids : ''}}" data-dependent_info="{{isset($data_values->dependent_info)? $data_values->dependent_info : ''}}">
    <div class="field-data"><img src="/assets/default/img/book-icons/quiz.png">
    </div>
    <a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>
</div>

