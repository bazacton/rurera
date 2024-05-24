@extends('admin.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css">
<style>
    .main-content{
        padding-top: 0px;
    }
    .navbar-bg {
        display: none;
    }
    nav.navbar.navbar-expand-lg.main-navbar {
        display: none;
    }
    .year-group-select, .subject-group-select, .subchapter-group-select li {
        cursor: pointer;
    }

    .questions-list li{
        cursor:move;
    }

    .question-area {
        border-bottom: 2px solid #efefef;
        margin-bottom: 30px;
    }

    .admin-rurera-tabs li.nav-item.disabled {
        pointer-events: none;
        opacity: 0.4;
    }
    .disable-click{
        pointer-events: none;
    }
</style>
@endpush


@section('content')
<form action="/admin/assignments/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}"
      method="Post">
    {{ csrf_field() }}
    <section class="section">
        <div class="section-body" style="margin-top: 50px;">
            <div class="row col-12 col-md-12 col-lg-12">

                <ul class="col-10 col-md-10 col-lg-10 admin-rurera-tabs nav nav-pills" id="assignment_tabs" role="tablist">
                    @php $tab_active_class = ($assignment->subtopic_id > 0)? '' : 'active'; @endphp
                    <li class="nav-item">
                        <a class="nav-link {{$tab_active_class}}" id="topics-tab" data-toggle="tab" href="#topics" role="tab"
                           aria-controls="basic" aria-selected="true">
                            <span class="tab-title">Topic</span>
                            <span class="tab-detail">Choose Subject Topic</span>
                        </a>
                    </li>

                    @php $tab_active_class = ($assignment->subtopic_id > 0)? 'active' : ''; @endphp
                    <li class="nav-item {{($tab_active_class == 'active')? '' : 'disabled'}}">
                        <a class="nav-link {{$tab_active_class}}" id="questions-tab" data-toggle="tab" href="#questions" role="tab"
                           aria-controls="socials" aria-selected="false"><span
                                    class="tab-title">Choose Questions</span>
                            <span class="tab-detail">Choose Questions from topics</span></a>
                    </li>

                    @php  $is_disable_preview = (!empty($assignment->quizQuestionsList) && count($assignment->quizQuestionsList) > 0)? '' : 'disabled'; @endphp

                    <li class="nav-item {{$is_disable_preview}}">
                        <a class="nav-link" id="preview-tab" data-toggle="tab" href="#preview"
                           role="tab"
                           aria-controls="features" aria-selected="false"><span
                                    class="tab-title">Test preview</span>
                            <span class="tab-detail">Preview assignment</span></a>
                    </li>
                </ul>
                <a href="javascript:;" class="col-2 col-md-2 col-lg-2 rurera-btn-grn rurera-confirm-dialog" data-title="Are you sure?" data-subtitle="You will not be able to edit the assignment after publishing." data-on_confirm="publish_assignment();">Publish</a>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">


                            <div class="tab-content" id="myTabContent2">
                                @php $show_class = ($assignment->subtopic_id > 0)? '' : 'active show'; @endphp
                                <div class="tab-pane mt-3 fade {{$show_class}}" id="topics" role="tabpanel"
                                     aria-labelledby="topics-tab">
                                    <div class="row col-lg-12 col-md-12 col-sm-4 col-12">
                                        <div class="populated-content-area col-lg-12 col-md-12 col-sm-12 col-12">

                                            <div class="topics-subtopics-content-area">

                                                {!! $topics_subtopics_layout !!}

                                            </div>
                                        </div>

                                    </div>
                                    <input class="topic_id_value" type="hidden" name="ajax[{{$assignment->id}}][topic_id]" value="{{$assignment->topic_id}}">
                                    <input class="subtopic_id_value" type="hidden" name="ajax[{{$assignment->id}}][subtopic_id]" value="{{$assignment->subtopic_id}}">
                                </div>


                                @php $show_class = ($assignment->subtopic_id > 0)? 'active show' : ''; @endphp
                                <div class="tab-pane mt-3 fade {{$show_class}}" id="questions" role="tabpanel"
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
                                                @php $review_required_title = ($questionDataObj->review_required > 0)? '<span class="topic-title review-required">Review Required</span>' : ''; @endphp

                                                <li data-question_id="{{$questionDataObj->id}}">
                                                    <input type="hidden" name="ajax[{{$assignment->id}}][question_list_ids][]" value="{{$questionDataObj->id}}">
                                                    <div class="question-list-item" id="question-list-item">
                                                    <span class="question-title">{{$questionDataObj->question_title}}</span>
                                                    <span class="topic-title">{{$assignment->topic->getTitleAttribute()}}</span>
                                                        {!! $review_required_title !!}
                                                    <span class="difficulty-level">{{$questionDataObj->question_difficulty_level}}</span>
                                                    <span class="question-id">ID:# {{$questionDataObj->id}}</span>
                                                    <span class="question-marks">Marks: {{$questionDataObj->question_score}}</span>
                                                    <span class="list-buttons">
                                                        <a href="javascript:;" class="questions-parent-li-remove">Remove</a>
                                                    </span>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @endif
                                                @endforeach
                                                @endif
                                            </ul>

                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-8">
                                            <div class="assignment-questions-preview">
                                            </div>
                                        </div>
                                    </div>


                                </div>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
    </section>
</form>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
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
                var chapter_id = $(this).attr('data-chapter_id');
                $(".topic_id_value").val(chapter_id);
                $(".subtopic_id_value").val(subchapter_id);
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/assignments/questions_by_subchapter',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subchapter_id": subchapter_id, "chapter_id": chapter_id, "assignment_id": '{{$assignment->id}}'},
                    success: function (return_data) {
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        rurera_remove_loader($(".selected-questions-group"), 'button');
                        //$(".questions-populate-area").html(return_data);
                        $(".selected-questions-group").html(return_data);
                        $("#questions-tab").closest('li').removeClass('disabled');
                        $("#questions-tab").click();
                        questions_select_callback();

                    }
                });
            });
        }
        


        questions_callback();

        var currentRequest5 = null;
        var update_questions_list = function () {
            var questions_ids = [];
           $("ul.questions-list li").each(function () {
               var question_id = $(this).attr('data-question_id');
               questions_ids.push(question_id);
           });
            currentRequest5 = jQuery.ajax({
                type: "POST",
                url: '/admin/assignments/update_question',
                beforeSend: function () {
                    if (currentRequest5 != null) {
                        currentRequest5.abort();
                    }
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"action": 'add',"questions_ids": questions_ids, "assignment_id": '{{$assignment->id}}'},
                success: function (return_data) {
                    console.log(return_data);
                }
           });
        }

        var questions_select_callback = function () {

            $('body').on('click', '.questions-group-select li .add-to-list-btn', function (e) {

                var thisObj = $('.assignment-preview');
                var question_id = $(this).closest('li').attr('data-question_id');
                var cloned_li = $(this).closest('li').clone();

                $(this).closest('li').find('.list-buttons').html('<a href="javascript:;" class="questions-rm-list">Remove</a>');

                cloned_li.find('.list-buttons').html('<a href="javascript:;" class="questions-parent-li-remove">Remove</a>');
                cloned_li = cloned_li.html();
                var li_value = '<li data-question_id="' + question_id + '"><input type="hidden" name="ajax[{{$assignment->id}}][question_list_ids][]" value="' + question_id + '">';
                li_value += cloned_li;
                li_value += '</li>';
                $('.questions-list li[data-question_id="' + question_id + '"]').remove();
                $(".questions-list").append(li_value);
                $("#preview-tab").closest('li').removeClass('disabled');
                update_questions_list();
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


        $(".questions-list").sortable({
            update: function( event, ui ) {update_questions_list(); $("#preview-tab").click();}
        });


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
            var question_id = $(this).closest('li').attr('data-question_id');
            if ($(".assignment-preview .questions-list li").length == 0) {
                $("#questions-tab").click();
                $("#preview-tab").closest('li').addClass('disabled');
            }
            $('.questions-group-select li[data-question_id="'+question_id+'"]').find('.list-buttons').html('<a href="javascript:;" class="add-to-list-btn">Add</a>');
            update_questions_list();
            $("#preview-tab").click();
        });
        $(document).on('click', '.questions-rm-list', function (e) {
            var question_id = $(this).closest('li').attr('data-question_id');
            $(this).closest('li').find('.list-buttons').html('<a href="javascript:;" class="add-to-list-btn">Add</a>');
            $('.questions-list li[data-question_id="'+question_id+'"]').find('.questions-parent-li-remove').click();
            //update_questions_list();
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

        if( $(".subchapter-group-select li.default-active").length > 0){
            rurera_loader($(".selected-questions-group"), 'div');
            $(".subchapter-group-select li.default-active").click();
        }

    });

    function publish_assignment(thisObj){
        rurera_loader($(".main-content"), 'div');
        jQuery.ajax({
            type: "POST",
            url: '/admin/assignments/publish_assignment',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"assignment_id": '{{$assignment->id}}'},
            success: function (return_data) {
                window.location.href = '/admin/assignments';
            }
        });
    }

</script>
@endpush
