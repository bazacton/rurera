@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<style type="text/css">
    .no-border{
        border:none;
    }
</style>
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($glossary) ?trans('/admin/main.edit'): trans('admin/main.new') }} Curriculum</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/glossary">Curriculum</a>
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
                        <form action="/admin/national_curriculum/{{ !empty($nationalCurriculum) ? $nationalCurriculum->id.'/store' : 'store' }}"
                              method="Post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>{{ trans('/admin/main.category') }}</label>
                                <select data-subject_id="{{ !empty($nationalCurriculum)? $nationalCurriculum->subject_id : 0}}" class="form-control category-id-field @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                    <option {{ !empty($trend) ?
                                    '' : 'selected' }} disabled>{{ trans('admin/main.choose_category') }}</option>

                                    @foreach($categories as $category)
                                    @if(!empty($category->subCategories) and count($category->subCategories))
                                    <optgroup label="{{  $category->title }}">
                                        @foreach($category->subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}" @if(!empty($nationalCurriculum) and $nationalCurriculum->
                                            key_stage == $subCategory->id) selected="selected" @endif>{{
                                            $subCategory->title }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @else
                                    <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($glossary)
                                            and $glossary->category_id == $category->id) selected="selected" @endif>{{
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
                                <button class="btn btn-primary add_curriculum_set" type="button">Add Set</button>
                            </div>

                            <div class="curriculum_sets">

                                @if( !empty( $nationalCurriculum->NationalCurriculumItems ))
                                        @foreach( $nationalCurriculum->NationalCurriculumItems as $itemObj)
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
                                                                <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input name="national_curriculum_title[{{$itemObj->id}}]" type="text"
                                                                                                                                            value="{{$itemObj->title}}"
                                                                                                                                            class="no-border"></span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-center">

                                                            <button type="button" data-data_id="{{$itemObj->id}}"
                                                                    class="add-course-content-btn  add-curriculum-item mr-10"
                                                                    aria-expanded="false">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                     stroke-linejoin="round" class="feather feather-plus">
                                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                                </svg>
                                                            </button>

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

                                                    <div id="collapseItems{{$itemObj->id}}" aria-labelledby="chapter_{{$itemObj->id}}"
                                                         class="curriculum-item-data collapse " role="tabpanel">
                                                        <div class="panel-collapse text-gray">



                                                            <div class="accordion-content-wrapper mt-15"
                                                                 id="chapterContentAccordion{{$itemObj->id}}" role="tablist"
                                                                 aria-multiselectable="true">
                                                                <ul class="curriculum-item-data-ul draggable-content-lists draggable-lists-chapter-{{$itemObj->id}} ui-sortable"
                                                                    data-drag-class="draggable-lists-chapter-{{$itemObj->id}}"
                                                                    data-order-table="webinar_chapter_items">



                                                                    <li data-id="{{$itemObj->id}}"
                                                                                class="accordion-row bg-white rounded-sm border border-gray300 mt-20 py-15 py-lg-30 px-10 px-lg-20">
                                                                                <div class="d-flex align-items-center justify-content-between "
                                                                                     role="tab" id="quiz_{{$itemObj->id}}">
                                                                                    <div class="d-flex align-items-center"
                                                                                         href="#collapseItem{{$itemObj->id}}"
                                                                                         aria-controls="collapseItem{{$itemObj->id}}"
                                                                                         data-parent="#chapterContentAccordion{{$itemObj->id}}"
                                                                                         role="button" data-toggle="collapse"
                                                                                         aria-expanded="true">

                                                                                        <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input name="national_curriculum_item_title[{{$itemObj->id}}][items][{{$itemObj->id}}]" type="text" size="100"
                                                                                                                                                                    value="{{$itemObj->sub_title}}"
                                                                                                                                                                    class="no-border"></span>
                                                                                    </div>

                                                                                    <div class="d-flex align-items-center">

                                                                                        <button type="button" data-data_id="{{$itemObj->id}}" data-item_id="{{$itemObj->id}}"
                                                                                                class="add-course-content-btn  add-curriculum-chapter mr-10"
                                                                                                aria-expanded="false">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                                                 stroke-linejoin="round" class="feather feather-plus">
                                                                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                                                            </svg>
                                                                                        </button>

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

                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                             width="24" height="20" viewBox="0 0 24 24"
                                                                                             fill="none" stroke="currentColor"
                                                                                             stroke-width="2" stroke-linecap="round"
                                                                                             stroke-linejoin="round"
                                                                                             class="feather feather-move move-icon mr-10 cursor-pointer ui-sortable-handle">
                                                                                            <polyline points="5 9 2 12 5 15"></polyline>
                                                                                            <polyline points="9 5 12 2 15 5"></polyline>
                                                                                            <polyline
                                                                                                    points="15 19 12 22 9 19"></polyline>
                                                                                            <polyline
                                                                                                    points="19 9 22 12 19 15"></polyline>
                                                                                            <line x1="2" y1="12" x2="22" y2="12"></line>
                                                                                            <line x1="12" y1="2" x2="12" y2="22"></line>
                                                                                        </svg>


                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                             width="24" height="20" viewBox="0 0 24 24"
                                                                                             fill="none" stroke="currentColor"
                                                                                             stroke-width="2" stroke-linecap="round"
                                                                                             stroke-linejoin="round"
                                                                                             class="feather feather-chevron-down collapse-chevron-icon"
                                                                                             href="#collapseItem{{$itemObj->id}}"
                                                                                             aria-controls="collapseItem{{$itemObj->id}}"
                                                                                             data-parent="#chapterContentAccordion{{$itemObj->id}}"
                                                                                             role="button" data-toggle="collapse"
                                                                                             aria-expanded="true">
                                                                                            <polyline
                                                                                                    points="6 9 12 15 18 9"></polyline>
                                                                                        </svg>
                                                                                    </div>
                                                                                </div>

                                                                                <div id="collapseItem{{$itemObj->id}}"
                                                                                     aria-labelledby="quiz_{{$itemObj->id}}"
                                                                                     class=" collapse curriculum-chapter-data" role="tabpanel">
                                                                                    <div class="panel-collapse text-gray">

                                                                                        <div class=" accordion-content-wrapper mt-15"
                                                                                             id="chapterContentAccordion{{$itemObj->id}}"
                                                                                             role="tablist"
                                                                                             aria-multiselectable="true">
                                                                                            <ul class="draggable-content-lists curriculum-chapter-data-ul draggable-lists-chapter-{{$itemObj->id}} ui-sortable"
                                                                                                data-drag-class="draggable-lists-chapter-{{$itemObj->id}}"
                                                                                                data-order-table="webinar_chapter_items">



                                                                                                @if( !empty( $itemObj->NationalCurriculumChapters ))
                                                                                                    @foreach( $itemObj->NationalCurriculumChapters as $chapterObj)
                                                                                                <li data-id="{{$chapterObj->id}}"
                                                                                                class="accordion-row bg-white rounded-sm border border-gray300 mt-20 py-15 py-lg-30 px-10 px-lg-20">
                                                                                                <div class="d-flex align-items-center justify-content-between "
                                                                                                role="tab" id="quiz_{{$chapterObj->id}}">
                                                                                                <div class="d-flex align-items-center"
                                                                                                    href="#collapseChapter{{$chapterObj->id}}"
                                                                                                    aria-controls="collapseChapter{{$chapterObj->id}}"
                                                                                                    data-parent="#chapterContentAccordion{{$itemObj->id}}"
                                                                                                    role="button" data-toggle="collapse"
                                                                                                    aria-expanded="true">

                                                                                                   <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input name="national_curriculum_chapter_title[{{$itemObj->id}}][{{$itemObj->id}}][chapters][{{$chapterObj->id}}]" type="text" size="150" value="{{$chapterObj->title}}" class="no-border"></span>
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
                                                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                        width="24" height="20" viewBox="0 0 24 24"
                                                                                                        fill="none" stroke="currentColor"
                                                                                                        stroke-width="2" stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        class="feather feather-move move-icon mr-10 cursor-pointer ui-sortable-handle">
                                                                                                       <polyline points="5 9 2 12 5 15"></polyline>
                                                                                                       <polyline points="9 5 12 2 15 5"></polyline>
                                                                                                       <polyline
                                                                                                               points="15 19 12 22 9 19"></polyline>
                                                                                                       <polyline
                                                                                                               points="19 9 22 12 19 15"></polyline>
                                                                                                       <line x1="2" y1="12" x2="22" y2="12"></line>
                                                                                                       <line x1="12" y1="2" x2="12" y2="22"></line>
                                                                                                   </svg>


                                                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                        width="24" height="20" viewBox="0 0 24 24"
                                                                                                        fill="none" stroke="currentColor"
                                                                                                        stroke-width="2" stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        class="feather feather-chevron-down collapse-chevron-icon"
                                                                                                        href="#collapseChapter{{$chapterObj->id}}"
                                                                                                        aria-controls="collapseChapter{{$chapterObj->id}}"
                                                                                                        data-parent="#chapterContentAccordion{{$itemObj->id}}"
                                                                                                        role="button" data-toggle="collapse"
                                                                                                        aria-expanded="true">
                                                                                                       <polyline
                                                                                                               points="6 9 12 15 18 9"></polyline>
                                                                                                   </svg>
                                                                                                </div>
                                                                                                </div>

                                                                                                <div id="collapseChapter{{$chapterObj->id}}"
                                                                                                aria-labelledby="quiz_{{$chapterObj->id}}"
                                                                                                class="collapse show" role="tabpanel" style="">
                                                                                                <div class="panel-collapse text-gray">

                                                                                                   <div data-action="/admin/webinars/1174/store_quiz_selection"
                                                                                                        class="js-content-form quiz-form webinar-form">
                                                                                                       <section>

                                                                                                           <div class="row">
                                                                                                               <div class="col-12 col-md-12">

                                                                                                                   <div class="form-group mt-15 ">
                                                                                                                       <label class="input-label d-block">Topics</label>

                                                                                                                       <select name="national_curriculum_chapter_topics[{{$itemObj->id}}][{{$itemObj->id}}][{{$chapterObj->id}}][topics][]" id="topic_ids{{$chapterObj->id}}" multiple="multiple" data-search-option="topic_ids"
                                                                                                                               class="form-control search-topics-select2" data-placeholder="Search Topic">
                                                                                                                           @if( !empty( $chapterObj->NationalCurriculumTopics ))
                                                                                                                                @foreach( $chapterObj->NationalCurriculumTopics as $topicsObj)
                                                                                                                                        <option selected="selected" value="{{$topicsObj->topic_id}}">{{$topicsObj->NationalCurriculumTopicData->sub_chapter_title}}</option>
                                                                                                                                @endforeach
                                                                                                                           @endif

                                                                                                                       </select>
                                                                                                                   </div>




                                                                                                               </div>
                                                                                                           </div>
                                                                                                       </section>

                                                                                                   </div>

                                                                                                </div>
                                                                                                </div>
                                                                                                </li>
                                                                                                    @endforeach
                                                                                                @endif

                                                                                            </ul>
                                                                                        </div>


                                                                                    </div>
                                                                                </div>
                                                                            </li>






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
    $(document).ready(function(){


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
                data: {'category_id': category_id, 'subject_id':subject_id},
                success: function (response) {
                    $(".category_subjects_list").html(response);
                }
            });

        });
        $('body').on('click', '.add_curriculum_set', function (e) {
            //$(".curriculum_sets").html('');
            $.ajax({
                type: "GET",
                url: '/admin/national_curriculum/curriculum_set_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function (response) {
                    $(".curriculum_sets").append(response);
                    $(".curriculum-set-ul").sortable();
                    $(".curriculum-item-data-ul").sortable();
                    $(".curriculum-chapter-data-ul").sortable();
                    $(".curriculum-topics-ul").sortable();
                    handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);
                }
            });
        });

        $('body').on('click', '.add-curriculum-item', function (e) {
            //$(".curriculum_sets").html('');
            var thisObj = $(this);
            var data_id = $(this).attr('data-data_id');
            console.log(data_id);
            $.ajax({
                type: "GET",
                url: '/admin/national_curriculum/curriculum_item_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'data_id': data_id},
                success: function (response) {
                    thisObj.closest('li').find('.curriculum-item-data').find('ul.curriculum-item-data-ul').append(response);
                    $(".curriculum-item-data-ul").sortable();
                    $(".curriculum-chapter-data-ul").sortable();
                    $(".curriculum-topics-ul").sortable();
                    handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);

                }
            });
        });

        $('body').on('click', '.add-curriculum-chapter', function (e) {
            //$(".curriculum_sets").html('');
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

        $(".curriculum_sets").sortable();
        $(".curriculum-item-data-ul").sortable();
        $(".curriculum-chapter-data-ul").sortable();
        $(".curriculum-topics-ul").sortable();
        $(".category-id-field").change();
        handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);

    });

</script>

@endpush
