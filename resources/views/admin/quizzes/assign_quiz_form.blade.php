<style>
    .hide-class {
        display: none;
    }

    .questions-list ul li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .questions-list ul li a.parent-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }
</style>

<div data-action="{{ getAdminPanelUrl() }}/webinars/{{ !empty($chapter_item_id) ? $chapter_item_id .'/store_quiz_selection' : 'store_quiz_selection' }}" class="js-content-form quiz-form webinar-form">
    {{ csrf_field() }}
    <section>

        <div class="row">
            <div class="col-12 col-md-4">

                <div class="form-group mt-15 ">
                    <label class="input-label d-block">Quiz</label>
                    <select name="quiz_id" class="form-control search-quiz-select2" data-placeholder="Select Quiz">
                        @if(!empty($quizInfo))
                        <option value="{{ $quizInfo->id }}" selected>{{ $quizInfo->title }}</option>
                        @endif
                    </select>
                </div>
                <input type="hidden" name="chapter_id" class="chapter_id_field">
                <input type="hidden" name="sub_chapter_id" class="sub_chapter_id_field">

                <input type="hidden" name="webinar_id" value="{{$selectedWebinar->id}}">


            </div>
        </div>
    </section>


    <input type="hidden" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][is_webinar_page]" value="@if(!empty($inWebinarPage) and $inWebinarPage) 1 @else 0 @endif">

    <div class="mt-20 mb-20">
        <button type="button" class="js-submit-quiz-form btn btn-sm btn-primary">{{ !empty($quiz) ? trans('public.save_change') : trans('public.create') }}</button>

        @if(empty($quiz) and !empty($inWebinarPage))
        <button type="button" class="btn btn-sm btn-danger ml-10 cancel-accordion">{{ trans('public.close') }}</button>
        @endif
    </div>
</div>

@if(!empty($quiz))
@include('admin.quizzes.modals.multiple_question')
@include('admin.quizzes.modals.descriptive_question')
@endif
@push('scripts_bottom')
@php
$quiz_add_edit = !empty($quiz) ? $quiz->id : 'new';
@endphp
<script type="text/javascript">
    $(document).ready(function () {
        //handleMultiSelect2('search-questions-select2', '/admin/questions_bank/search', ['class', 'course', 'subject', 'title']);

        $(document).on('change', '.quiz-type', function (e) {
            var quiz_type = $(this).val();
            $(".conditional-fields").addClass('hide-class');
            $('.' + quiz_type + "-fields").removeClass('hide-class');
        });

        $(document).on('change', '.search-questions-select2', function (e) {
            var field_value = $(this).val();
            var field_label = $(this).text();
            $(".questions-list ul").append('<li data-id="' + field_value + '">' + field_label + '  <input type="hidden" name="ajax[{{ $quiz_add_edit }}][question_list_ids][]" ' +
                'value="' + field_value + '"><a href="javascript:;"' +
                ' ' +
                'class="parent-remove"><span class="fas ' +
                'fa-trash"></span></a></li>');
            $(".questions-list ul").sortable();
            $(this).html('');
        });

        $(".questions-list ul").sortable();


    });
</script>
@endpush
