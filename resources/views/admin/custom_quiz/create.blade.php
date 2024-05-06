@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css">
<style>
    .year-group-select, .subject-group-select, .subchapter-group-select li {
        cursor: pointer;
    }


    .questions-list li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .questions-list li a.parent-li-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }

    .question-area {
        border-bottom: 2px solid #efefef;
        margin-bottom: 30px;
    }
</style>
@endpush


@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new') }} Quiz</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active"><a href="/admin/assignments">Quiz</a>
                </div>
                <div class="breadcrumb-item">{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new')
                    }}
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <form action="/admin/custom_quiz/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}"
                                      method="Post">
                                    {{ csrf_field() }}

                                <div class="row col-lg-12 col-md-12 col-sm-4 col-12">
                                    <div class="populated-content-area col-lg-12 col-md-12 col-sm-12 col-12">


                                        @if( !empty($categories ))

                                        <div class="years-group populated-data">

                                            <div class="form-group">
                                                <label class="input-label">Quiz Title</label>
                                                <input type="text"
                                                       name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][title]"
                                                       value="{{ !empty($assignment) ? $assignment->title : old('title') }}"
                                                       class="js-ajax-title form-control "
                                                       placeholder=""/>
                                                <div class="invalid-feedback"></div>
                                            </div>


                                            <div class="form-group">
                                                <label>Year</label>
                                                <select data-default_id="{{isset( $user->id)? $user->year_id : 0}}"
                                                        class="form-control year_subject_ajax_select select2 @error('year_id') is-invalid @enderror"
                                                        name="year_id">
                                                    <option {{ !empty($trend) ?
                                                    '' : 'selected' }} disabled>Select Year</option>

                                                    @foreach($categories as $category)
                                                    @if(!empty($category->subCategories) and
                                                    count($category->subCategories))
                                                    <optgroup label="{{  $category->title }}">
                                                        @foreach($category->subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @if(!empty($user)
                                                                and
                                                                $user->
                                                            year_id
                                                            ==
                                                            $subCategory->id) selected="selected" @endif>{{
                                                            $subCategory->title
                                                            }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    @else
                                                    <option value="{{ $category->id }}"
                                                            class="font-weight-bold">{{
                                                        $category->title }}
                                                    </option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('year_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Subjects</label>
                                                <select data-return_type="option"
                                                        data-default_id="{{isset( $user->id)? $user->class_id : 0}}"
                                                        class="subject_ajax_select year_subjects form-control select2 @error('class_id') is-invalid @enderror"
                                                        id="class_id" name="class_id">
                                                    <option disabled selected>Subject</option>
                                                </select>
                                                @error('class_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>


                                            <input type="hidden"
                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][year_id]"
                                                   class="year_id_field"
                                                   value="{{ !empty($assignment) ? $assignment->year_id : old('year_id') }}">
                                            <input type="hidden"
                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][subject_id]"
                                                   class="subject_id_field"
                                                   value="{{ !empty($assignment) ? $assignment->subject_id : old('subject_id') }}">

                                        </div>
                                        @endif

                                    </div>


                                </div>

                                <div class="mt-20 mb-20">
                                    <button type="submit"
                                            class="js-submit-quiz-form btn btn-sm btn-primary">{{
                                        !empty($assignment) ?
                                        trans('public.save_change') : trans('public.create') }}
                                    </button>

                                    @if(empty($assignment) and !empty($inWebinarPage))
                                    <button type="button"
                                            class="btn btn-sm btn-danger ml-10 cancel-accordion">{{
                                        trans('public.close') }}
                                    </button>
                                    @endif
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
        $('body').on('click', '.year-group-select', function (e) {
            var thisObj = $('.populated-content-area');
            var year_id = $(this).attr('data-year_id');
            $(".year_id_field").val(year_id);
            rurera_loader(thisObj, 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/custom_quiz/subjects_by_year',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"year_id": year_id},
                success: function (return_data) {
                    $(".populated-data").addClass('rurera-hide');
                    rurera_remove_loader(thisObj, 'button');
                    if (return_data != '') {
                        $(".populated-content-area").append(return_data);
                        subjects_callback();
                    }
                }
            });
        });

        var subjects_callback_bk = function () {
            $('body').on('click', '.subject-group-selects', function (e) {
                var thisObj = $('.populated-content-area');
                var subject_id = $(this).attr('data-subject_id');
                $(".subject_id_field").val(subject_id);
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/topics_subtopics_by_subject',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subject_id": subject_id},
                    success: function (return_data) {
                        $(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        if (return_data != '') {
                            //$(".populated-content-area").append(return_data);
                            $(".topics-subtopics-content-area").append(return_data);
                            questions_callback();
                        }
                    }
                });
            });
        }

        var subjects_callback = function () {
            $('body').on('change', '.subject_ajax_select', function (e) {
                var thisObj = $('.populated-content-area');
                var subject_id = $(this).val();
                $(".subject_id_field").val(subject_id);
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/topics_subtopics_by_subject',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subject_id": subject_id},
                    success: function (return_data) {
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        if (return_data != '') {
                            //$(".populated-content-area").append(return_data);
                            $(".topics-subtopics-content-area").append(return_data);
                            $("#questions-tab").click();
                            questions_callback();
                        }
                    }
                });
            });
        }
        subjects_callback();


        var questions_callback = function () {
            $('body').on('click', '.subchapter-group-select li', function (e) {
                var thisObj = $('.populated-content-area');
                var subchapter_id = $(this).attr('data-subchapter_id');
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/questions_by_subchapter',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subchapter_id": subchapter_id},
                    success: function (return_data) {
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        //$(".questions-populate-area").html(return_data);
                        $(".selected-questions-group").append(return_data);
                        questions_select_callback();

                    }
                });
            });
        }

        var questions_select_callback = function () {
            $('body').on('click', '.questions-group-select li', function (e) {
                var thisObj = $('.populated-content-area');
                var question_id = $(this).attr('data-question_id');
                var question_title = $(this).find('a').html();
                $('.questions-list li[data-question_id="' + question_id + '"]').remove();
                $(".questions-list").append('<li data-question_id="' + question_id + '"><input type="hidden" name="ajax[new][question_list_ids][]" value="' + question_id + '">' + question_title + '<a href="javascript:;" class="parent-li-remove"><span class="fas fa-trash"></span></a></li>');
            });


        }

        var currentRequest = null;
        var question_search = function () {
            $('body').on('keyup', '.search-questions', function (e) {
                console.log('search-questions');
                var input, filter, ul, li, a, i, txtValue;
                var search_question_bank = $('.search_question_bank').is(":checked");
                if (search_question_bank == false) {
                    input = document.getElementById("search-questions");
                    filter = input.value.toUpperCase();
                    ul = document.getElementById("questions-group-select");
                    li = ul.getElementsByTagName("li");
                    for (i = 0; i < li.length; i++) {
                        a = li[i].getElementsByTagName("a")[0];
                        txtValue = a.textContent || a.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1 || li[i].className.indexOf("alwaysshow") > -1) {
                            li[i].style.display = "";
                        } else {
                            li[i].style.display = "none";
                        }
                    }
                } else {
                    var input = $(this).val();
                    var thisObj = $('.questions-populate-area');
                    var year_id = $(".year_id_field").val();
                    var subject_id = $(".subject_id_field").val();
                    console.log(year_id);
                    console.log(subject_id);
                    rurera_loader(thisObj, 'div');

                    currentRequest = jQuery.ajax({
                        type: "GET",
                        url: '/admin/custom_quiz/questions_by_keyword',
                        beforeSend: function () {
                            if (currentRequest != null) {
                                currentRequest.abort();
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"keyword": input, "year_id": year_id, "subject_id": subject_id},
                        success: function (return_data) {
                            rurera_remove_loader(thisObj, 'button');
                            $(".questions-group-select").html(return_data);
                        }
                    });
                }
            });
        }

        question_search();


        $(".questions-list").sortable();


        $('body').on('click', '.rurera-back-btn', function (e) {
            $(this).closest('.populated-data').prev('.populated-data').removeClass('rurera-hide');
            $(this).closest('.populated-data').addClass('rurera-hide');
            $(this).closest('.populated-data').remove();
            if ($(this).hasClass('questions-list-btn')) {
                console.log('questions-btn');
            }
        });


        var currentRequest2 = null;
        $('body').on('click', '#preview-tab', function (e) {
            var thisObj = $(".assignment-preview");

            var questions_ids = [];
            $("ul.questions-list li").each(function () {
                var question_id = $(this).attr('data-question_id');
                questions_ids.push(question_id);
            });
            if (questions_ids.length > 0) {
                rurera_loader(thisObj, 'div');
                currentRequest2 = jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/assignment_preview',
                    beforeSend: function () {
                        if (currentRequest2 != null) {
                            currentRequest2.abort();
                        }
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"questions_ids": questions_ids},
                    success: function (return_data) {
                        rurera_remove_loader(thisObj, 'button');
                        $(".assignment-preview").html(return_data);
                    }
                });
            }

        });

    });

</script>
@endpush
