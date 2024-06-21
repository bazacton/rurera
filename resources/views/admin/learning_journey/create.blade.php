@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<style type="text/css">
    .no-border {
        border: none;
    }
</style>
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($glossary) ?trans('/admin/main.edit'): trans('admin/main.new') }} Learning Journey</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/learning_journey">Learning Journey</a>
            </div>
            <div class="breadcrumb-item">{{!empty($glossary) ?trans('/admin/main.edit'): trans('admin/main.new') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/learning_journey/{{ !empty($weeklyPlanner) ? $weeklyPlanner->id.'/store' : 'store' }}"
                              method="Post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>{{ trans('/admin/main.category') }}</label>
                                <select data-subject_id="{{ !empty($weeklyPlanner)? $weeklyPlanner->subject_id : 0}}"
                                        class="form-control category-id-field @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                    <option {{ !empty($trend) ?
                                    '' : 'selected' }} disabled>{{ trans('admin/main.choose_category') }}</option>

                                    @foreach($categories as $category)
                                    @if(!empty($category->subCategories) and count($category->subCategories))
                                    <optgroup label="{{  $category->title }}">
                                        @foreach($category->subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}" @if(!empty($weeklyPlanner) and
                                                $weeklyPlanner->
                                            key_stage == $subCategory->id) selected="selected" @endif>{{
                                            $subCategory->title }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @else
                                    <option value="{{ $category->id }}" class="font-weight-bold"
                                            @if(!empty($weeklyPlanner)
                                            and $weeklyPlanner->key_stage == $category->id) selected="selected"
                                        @endif>{{
                                        $category->title }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="category_subjects_list">

                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary add_learning_journey_set" type="button">Add Set</button>
                            </div>

                            <div class="learning_journey_sets">

                                @if( !empty( $weeklyPlanner->WeeklyPlannerItems ))
                                @foreach( $weeklyPlanner->WeeklyPlannerItems as $itemObj)
                                <div class="accordion-content-wrapper mt-15" id="chapterAccordion" role="tablist"
                                     aria-multiselectable="true">
                                    <ul class="draggable-content-lists  curriculum-set-ul">

                                        <li data-id="{{$itemObj->id}}" data-chapter-order=""
                                            class="accordion-row bg-white rounded-sm mt-20 py-15 py-lg-30 px-10 px-lg-20">
                                            <div class="d-flex align-items-center justify-content-between " role="tab"
                                                 id="chapter_{{$itemObj->id}}">
                                                <div class="d-flex align-items-center collapsed"
                                                     href="#collapseItems{{$itemObj->id}}"
                                                     aria-controls="collapseItems{{$itemObj->id}}"
                                                     data-parent="#chapterAccordion" role="button"
                                                     data-toggle="collapse" aria-expanded="false">
                                                                <span class="chapter-icon mr-10">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         width="24" height="24"
                                                                         viewBox="0 0 24 24"
                                                                         fill="none" stroke="currentColor"
                                                                         stroke-width="2"
                                                                         stroke-linecap="round"
                                                                         stroke-linejoin="round"
                                                                         class="feather feather-grid"><rect
                                                                                x="3"
                                                                                y="3"
                                                                                width="7"
                                                                                height="7"></rect><rect
                                                                                x="14" y="3" width="7"
                                                                                height="7"></rect><rect
                                                                                x="14"
                                                                                y="14"
                                                                                width="7"
                                                                                height="7"></rect><rect
                                                                                x="3" y="14" width="7"
                                                                                height="7"></rect></svg>
                                                                </span>
                                                    <div class="">
                                                                <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input
                                                                            name="learning_journey_title[{{$itemObj->id}}]"
                                                                            type="text" size="50"
                                                                            value="{{$itemObj->title}}"
                                                                            class="no-border"></span>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center">

                                                    <a href="javascript:;"
                                                       class="delete-parent-li btn btn-sm btn-transparent text-gray">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round"
                                                             class="feather feather-trash-2 mr-10 cursor-pointer">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </a>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-move move-icon mr-10 cursor-pointer text-gray ui-sortable-handle">
                                                        <polyline points="5 9 2 12 5 15"></polyline>
                                                        <polyline points="9 5 12 2 15 5"></polyline>
                                                        <polyline points="15 19 12 22 9 19"></polyline>
                                                        <polyline points="19 9 22 12 19 15"></polyline>
                                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                                        <line x1="12" y1="2" x2="12" y2="22"></line>
                                                    </svg>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-chevron-down collapse-chevron-icon feather-chevron-up text-gray collapsed"
                                                         href="#collapseItems{{$itemObj->id}}"
                                                         aria-controls="collapseItems{{$itemObj->id}}"
                                                         data-parent="#chapterAccordion" role="button"
                                                         data-toggle="collapse" aria-expanded="false">
                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div id="collapseItems{{$itemObj->id}}"
                                                 aria-labelledby="chapter_{{$itemObj->id}}"
                                                 class="curriculum-item-data collapse " role="tabpanel">
                                                <div class="panel-collapse text-gray">

                                                    <div class="accordion-content-wrapper mt-15"
                                                         id="chapterContentAccordion{{$itemObj->id}}"
                                                         role="tablist"
                                                         aria-multiselectable="true">
                                                        <ul class="curriculum-item-data-ul draggable-content-lists draggable-lists-chapter-{{$itemObj->id}} ui-sortable"
                                                            data-drag-class="draggable-lists-chapter-{{$itemObj->id}}"
                                                            data-order-table="webinar_chapter_items">

                                                            @php $total_weeks = 32; $week_count = 1; @endphp
                                                            <div class="form-group mt-15 ">
                                                                <label class="input-label d-block">Week</label>
                                                                <select name="learning_journey_chapter_topics[{{$itemObj->id}}][week_no]"
                                                                        id="week_no{{$itemObj->id}}"
                                                                        class="form-control"
                                                                        data-placeholder="Select Week">
                                                                    @while($week_count <= $total_weeks)
                                                                    @php $selected = ($week_count == $itemObj->week_no)?
                                                                    'selected' : ''; @endphp
                                                                    <option value="{{$week_count}}" {{$selected}}>
                                                                        {{$week_count}}
                                                                    </option>
                                                                    @php $week_count++; @endphp
                                                                    @endwhile
                                                                </select>
                                                            </div>

                                                            <div class="form-group mt-15 ">
                                                                <label class="input-label d-block">Topics</label>

                                                                <select name="learning_journey_chapter_topics[{{$itemObj->id}}][topics][]"
                                                                        id="topic_ids{{$itemObj->id}}"
                                                                        multiple="multiple"
                                                                        data-search-option="topic_ids"
                                                                        class="form-control search-topics-select2"
                                                                        data-placeholder="Search Topic">

                                                                    @if( !empty( $itemObj->WeeklyPlannerTopics
                                                                    ))
                                                                    @foreach( $itemObj->WeeklyPlannerTopics as
                                                                    $topicsObj)
                                                                    <option selected="selected"
                                                                            value="{{$topicsObj->topic_id}}">
                                                                        {{$topicsObj->WeeklyPlannerTopicData->sub_chapter_title}}
                                                                    </option>
                                                                    @endforeach
                                                                    @endif

                                                                </select>
                                                            </div>

                                                            <?php //echo $this->curriculum_item_layout($request, $data_id);
                                                            ?>


                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                @endforeach
                                @endif


                            </div>


                            <div class="text-right mt-4">
                                <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<script src="/assets/default/js/admin/filters.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {


        $('body').on('click', '.delete-parent-li', function (e) {

            $(this).closest('li').remove();
        });

        $('body').on('change', '.category-id-field', function (e) {
            var category_id = $(this).val();
            var subject_id = $(this).attr('data-subject_id');
            $.ajax({
                type: "GET",
                url: '/national-curriculum/subjects_by_category',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'category_id': category_id, 'subject_id': subject_id},
                success: function (response) {
                    $(".category_subjects_list").html(response);
                }
            });

        });
        $('body').on('click', '.add_learning_journey_set', function (e) {
            //$(".learning_journey_sets").html('');
            $.ajax({
                type: "GET",
                url: '/admin/learning_journey/learning_journey_set_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function (response) {
                    $(".learning_journey_sets").append(response);
                    $(".curriculum-set-ul").sortable();
                    $(".curriculum-item-data-ul").sortable();
                    $(".curriculum-chapter-data-ul").sortable();
                    $(".curriculum-topics-ul").sortable();
                    handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);
                }
            });
        });

        $('body').on('click', '.add-curriculum-item', function (e) {
            //$(".learning_journey_sets").html('');
            var thisObj = $(this);
            var data_id = $(this).attr('data-data_id');
			var subject_id = $('.choose-curriculum-subject').val();
            $.ajax({
                type: "GET",
                url: '/admin/learning_journey/learning_journey_topic_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'data_id': data_id, 'subject_id': subject_id},
                success: function (response) {
                    thisObj.closest('li').find('.curriculum-item-data').find('ul.curriculum-item-data-ul').append(response);

                }
            });
        });
		
		
		$('body').on('click', '.add-treasure-item', function (e) {
            //$(".learning_journey_sets").html('');
            var thisObj = $(this);
            var data_id = $(this).attr('data-data_id');
            $.ajax({
                type: "GET",
                url: '/admin/learning_journey/learning_journey_treasure_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'data_id': data_id},
                success: function (response) {
                    thisObj.closest('li').find('.curriculum-item-data').find('ul.curriculum-item-data-ul').append(response);
                }
            });
        });

        $('body').on('click', '.add-curriculum-chapter', function (e) {
            //$(".learning_journey_sets").html('');
            var thisObj = $(this);
            var data_id = $(this).attr('data-data_id');
            var item_id = $(this).attr('data-item_id');
            $.ajax({
                type: "GET",
                url: '/admin/national_curriculum/curriculum_item_chapter_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'data_id': data_id, 'item_id': item_id},
                success: function (response) {
                    thisObj.closest('li').find('ul.curriculum-chapter-data-ul').append(response);
                    $(".curriculum-chapter-data-ul").sortable();
                    $(".curriculum-topics-ul").sortable();
                    handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);
                }
            });
        });

        $(".learning_journey_sets").sortable();
        $(".curriculum-item-data-ul").sortable();
        $(".curriculum-chapter-data-ul").sortable();
        $(".curriculum-topics-ul").sortable();
        $(".category-id-field").change();
        handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);

    });

</script>

@endpush
