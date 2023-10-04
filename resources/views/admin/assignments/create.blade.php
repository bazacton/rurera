@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<style>
    .year-group-select, .subject-group-select, .subchapter-group-select li {
        cursor: pointer;
    }


    .questions-list li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .questions-list li a.parent-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }
</style>
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new') }} Assignment</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/assignments">Assignment</a>
            </div>
            <div class="breadcrumb-item">{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/assignments/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}"
                             method="Post">
                            {{ csrf_field() }}


                            <div class="row col-lg-12 col-md-12 col-sm-4 col-12">
                                <div class="populated-content-area col-lg-8 col-md-8 col-sm-4 col-12">


                                    @if( !empty($categories ))

                                    <div class="years-group populated-data">

                                        <div class="form-group">
                                            <label class="input-label">Assignment Title</label>
                                            <input type="text"
                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][title]"
                                                   value="{{ !empty($assignment) ? $assignment->title : old('title') }}"
                                                   class="js-ajax-title form-control "
                                                   placeholder=""/>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <input type="hidden" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][year_id]" class="year_id_field" value="{{ !empty($assignment) ? $assignment->year_id : old('year_id') }}">
                                        <input type="hidden" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][subject_id]" class="subject_id_field" value="{{ !empty($assignment) ? $assignment->subject_id : old('subject_id') }}">

                                        <div class="row">
                                            @foreach( $categories as $categoryObj)

                                            @if(!empty($categoryObj->subCategories))
                                            @foreach( $categoryObj->subCategories as $subCategoryObj)
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 year-group-select"
                                                 data-year_id="{{$subCategoryObj->id}}">
                                                <div class="card card-medium-icons">
                                                    <div class="card-icon bg-primary text-white p-30 text-center">
                                                        {{$subCategoryObj->getTitleAttribute()}}
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif

                                            @endforeach

                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12 card selected-questions-group">
                                    <ul class="questions-list">

                                        @if( !empty( $assignment->quizQuestionsList))
                                            @foreach( $assignment->quizQuestionsList as $questionObj)
                                                @if( !empty( $questionObj->QuestionData))
                                                    @foreach( $questionObj->QuestionData as $questionDataObj)
                                                    <li data-id="{{$questionDataObj->id}}">{{$questionDataObj->getTitleAttribute()}} <input
                                                                type="hidden" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new'
                                                                                       }}][question_list_ids][]"
                                                                value="{{$questionDataObj->id}}">
                                                        <a href="javascript:;" class="parent-remove"><span class="fas fa-trash"></span></a>
                                                    </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="mt-20 mb-20">
                                        <button type="submit" class="js-submit-quiz-form btn btn-sm btn-primary">{{ !empty($assignment) ?
                                            trans('public.save_change') : trans('public.create') }}
                                        </button>

                                        @if(empty($assignment) and !empty($inWebinarPage))
                                        <button type="button" class="btn btn-sm btn-danger ml-10 cancel-accordion">{{ trans('public.close') }}</button>
                                        @endif
                                    </div>
                            </div>
                        </form>
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
                url: '/admin/assignments/subjects_by_year',
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

        var subjects_callback = function () {
            $('body').on('click', '.subject-group-select', function (e) {
                var thisObj = $('.populated-content-area');
                var subject_id = $(this).attr('data-subject_id');
                $(".subject_id_field").val(subject_id);
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/assignments/topics_subtopics_by_subject',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subject_id": subject_id},
                    success: function (return_data) {
                        $(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        if (return_data != '') {
                            $(".populated-content-area").append(return_data);
                            questions_callback();
                        }
                    }
                });
            });
        }

        var questions_callback = function () {
            $('body').on('click', '.subchapter-group-select li', function (e) {
                var thisObj = $('.populated-content-area');
                var subchapter_id = $(this).attr('data-subchapter_id');
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/assignments/questions_by_subchapter',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subchapter_id": subchapter_id},
                    success: function (return_data) {
                        $(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        //$(".questions-populate-area").html(return_data);
                        $(".populated-content-area").append(return_data);
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
                $(".questions-list").append('<li data-question_id="' + question_id + '"><input type="hidden" name="ajax[new][question_list_ids][]" value="' + question_id + '">' + question_title + '<a href="javascript:;" class="parent-remove"><span class="fas fa-trash"></span></a></li>');
            });


        }

        var currentRequest = null;
        var question_search = function () {
            $('body').on('keyup', '.search-questions', function (e) {
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
                    rurera_loader(thisObj, 'div');

                    currentRequest = jQuery.ajax({
                        type: "GET",
                        url: '/admin/assignments/questions_by_keyword',
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
            if($(this).hasClass('questions-list-btn')){
                console.log('questions-btn');
            }
        });
    });

</script>
@endpush
