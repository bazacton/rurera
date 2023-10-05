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

    .questions-list li a.questions-parent-li-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }

    .question-area {
        border-bottom: 2px solid #efefef;
        margin-bottom: 30px;
    }

    .admin-rurera-tabs li.nav-item.disabled {
        pointer-events: none;
        opacity: 0.4;
    }
</style>
@endpush


@section('content')
<form action="/admin/assignments/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}"
      method="Post">
    {{ csrf_field() }}
    <section class="section">
        <div class="section-header">
            <h1>{{$assignment->title}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active"><a href="/admin/assignments">Assignment</a>
                </div>
                <div class="breadcrumb-item">{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new')
                    }}
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">

                    <ul class="admin-rurera-tabs nav nav-pills" id="assignment_tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="topics-tab" data-toggle="tab" href="#topics" role="tab"
                               aria-controls="basic" aria-selected="true">
                                <span class="tab-title">Topic</span>
                                <span class="tab-detail">Choose Year / Subject Topic</span>
                            </a>
                        </li>

                        <li class="nav-item disabled">
                            <a class="nav-link" id="questions-tab" data-toggle="tab" href="#questions" role="tab"
                               aria-controls="socials" aria-selected="false"><span
                                        class="tab-title">Choose Questions</span>
                                <span class="tab-detail">Choose Questions from topics</span></a>
                        </li>

                        <li class="nav-item disabled">
                            <a class="nav-link" id="preview-tab" data-toggle="tab" href="#preview"
                               role="tab"
                               aria-controls="features" aria-selected="false"><span
                                        class="tab-title">Test preview</span>
                                <span class="tab-detail">Previw assignment</span></a>
                        </li>


                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">


                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane mt-3 fade active show" id="topics" role="tabpanel"
                                     aria-labelledby="topics-tab">
                                    <div class="row col-lg-12 col-md-12 col-sm-4 col-12">
                                        <div class="populated-content-area col-lg-12 col-md-12 col-sm-12 col-12">

                                            <div class="topics-subtopics-content-area">

                                                {!! $topics_subtopics_layout !!}

                                            </div>


                                        </div>


                                    </div>
                                </div>

                                <div class="tab-pane mt-3 fade" id="questions" role="tabpanel"
                                     aria-labelledby="questions-tab">
                                    <div class="row col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-4 selected-questions-group">

                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-8 single-question-preview">
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane mt-3 fade assignment-preview" id="preview" role="tabpanel"
                                     aria-labelledby="preview-tab">


                                    <div class="row col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                                            <ul class="questions-list">

                                                @if( !empty( $assignment->quizQuestionsList))
                                                @foreach( $assignment->quizQuestionsList as $questionObj)
                                                @if( !empty( $questionObj->QuestionData))
                                                @foreach( $questionObj->QuestionData as $questionDataObj)
                                                <li data-id="{{$questionDataObj->id}}">
                                                    {{$questionDataObj->getTitleAttribute()}} <input
                                                            type="hidden" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new'
                                                                                                                                                                                                                                                                                                                  }}][question_list_ids][]"
                                                            value="{{$questionDataObj->id}}">
                                                    <a href="javascript:;" class="parent-li-remove"><span
                                                                class="fas fa-trash"></span></a>
                                                </li>
                                                @endforeach
                                                @endif
                                                @endforeach
                                                @endif
                                            </ul>

                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-8">
                                            <button type="button"
                                                    class="btn btn-sm btn-primary update-assignment-preview">Update
                                                Preview
                                            </button>
                                            <div class="assignment-questions-preview">
                                            </div>
                                        </div>
                                    </div>


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


                        </div>
                    </div>
                </div>
            </div>
    </section>
</form>
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
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        //$(".questions-populate-area").html(return_data);
                        $(".selected-questions-group").append(return_data);
                        $("#questions-tab").closest('li').removeClass('disabled');
                        $("#questions-tab").click();
                        questions_select_callback();

                    }
                });
            });
        }


        questions_callback();

        var questions_select_callback = function () {

            $('body').on('click', '.questions-group-select li .add-to-list-btn', function (e) {
                var thisObj = $('.assignment-preview');
                var question_id = $(this).closest('li').attr('data-question_id');
                var question_title = $(this).closest('li').find('.question-title').html();
                $('.questions-list li[data-question_id="' + question_id + '"]').remove();
                $(".questions-list").append('<li data-question_id="' + question_id + '"><input type="hidden" name="ajax[new][question_list_ids][]" value="' + question_id + '">' + question_title + '<a href="javascript:;" class="questions-parent-li-remove"><span class="fas fa-trash"></span></a></li>');
                $("#preview-tab").closest('li').removeClass('disabled');
            });

            var currentRequest3 = null;
            $('body').on('click', '.questions-group-select li', function (e) {
                var thisObj = $('.single-question-preview');
                //var question_id = $(this).closest('li').attr('data-question_id');
                var question_id = $(this).attr('data-question_id');
                if (question_id > 0) {
                    rurera_loader(thisObj, 'div');
                    currentRequest3 = jQuery.ajax({
                        type: "GET",
                        url: '/admin/assignments/single_question_preview',
                        beforeSend: function () {
                            if (currentRequest3 != null) {
                                currentRequest3.abort();
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"question_id": question_id, "assignment_title": '{{$assignment->title}}'},
                        success: function (return_data) {
                            rurera_remove_loader(thisObj, 'button');
                            $(".single-question-preview").html(return_data);
                        }
                    });
                }

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
                        a = li[i].getElementsByTagName("div")[0];
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
            if ($(this).hasClass('questions-list-btn')) {
                console.log('questions-btn');
            }
        });


        var currentRequest2 = null;
        $('body').on('click', '#preview-tab, .update-assignment-preview', function (e) {
            var thisObj = $(".assignment-questions-preview");

            var questions_ids = [];
            $("ul.questions-list li").each(function () {
                var question_id = $(this).attr('data-question_id');
                questions_ids.push(question_id);
            });
            if (questions_ids.length > 0) {
                rurera_loader(thisObj, 'div');
                currentRequest2 = jQuery.ajax({
                    type: "GET",
                    url: '/admin/assignments/assignment_preview',
                    beforeSend: function () {
                        if (currentRequest2 != null) {
                            currentRequest2.abort();
                        }
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"questions_ids": questions_ids, "assignment_title": '{{$assignment->title}}'},
                    success: function (return_data) {
                        rurera_remove_loader(thisObj, 'button');
                        $(".assignment-questions-preview").html(return_data);
                    }
                });
            }

        });

        $(document).on('click', '.questions-parent-li-remove', function (e) {
            $(this).closest('li').remove();
            if ($(".assignment-preview .questions-list li").length == 0) {
                $("#questions-tab").click();
                $("#preview-tab").closest('li').addClass('disabled');
            }
        });

        $(document).on('click', '.question-block .next-btn', function (e) {
            var question_id = $(this).closest('.question-block').next('.question-block').attr('data-question_id');
            if( question_id > 0) {
                $(".quiz-pagination ul li").removeClass('active');
                $('.quiz-pagination ul li[data-question_id="' + question_id + '"]').addClass('active');

                $(this).closest('.question-block').addClass('rurera-hide');
                $(this).closest('.question-block').next('.question-block').removeClass('rurera-hide');
            }
        });
        $(document).on('click', '.question-block .prev-btn', function (e) {
            var question_id = $(this).closest('.question-block').prev('.question-block').attr('data-question_id');
            if( question_id > 0) {
                $(".quiz-pagination ul li").removeClass('active');
                $('.quiz-pagination ul li[data-question_id="' + question_id + '"]').addClass('active');
                $(this).closest('.question-block').addClass('rurera-hide');
                $(this).closest('.question-block').prev('.question-block').removeClass('rurera-hide');
            }
        });
        $(document).on('click', '.quiz-pagination ul li', function (e) {
            $(".quiz-pagination ul li").removeClass('active');
            $(this).addClass('active');
            var question_id = $(this).attr('data-question_id');
            $('.question-block').addClass('rurera-hide');
            $('.question-block[data-question_id="'+question_id+'"]').removeClass('rurera-hide');

        });


    });

</script>
@endpush
