@php namespace App\Http\Controllers\Web; @endphp
@extends(getTemplate().'.layouts.appstart')
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">


<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
<script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .ui-state-highlight {
        margin: 0px 10px;
    }

    .field-holder.wrong, .form-field.wrong, .form-field.wrong label {
        background: #ff4a4a;
        color: #fff;
    }

</style>
@endpush
@section('content')
<div class="content-section">

    <section class="lms-quiz-section">


        <div class="container-fluid questions-data-block read-quiz-content"
             data-total_questions="30">

            <section class="quiz-topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="quiz-top-info"><p>Test</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 col-sm-12 mt-50">
                    <div class="question-step quiz-complete" style="display:none">
                        <div class="question-layout-block">
                            <div class="left-content has-bg">
                                <h2>&nbsp;</h2>
                                <div id="leform-form-1"
                                     class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable"
                                     _data-parent="1"
                                     _data-parent-col="0" style="display: block;">
                                    <div class="question-layout">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="question-area-block" data-total_questions="{{count($questions_list)}}">
                        <div class="col-12 col-lg-8 mx-auto">

                            @if( is_array( $questions_list ))
                            @php $question_no = 1; @endphp

                            @foreach( $questions_list as $questionIndex => $questionObj)

                            @php $class = ($questionIndex == 0)? 'active' : 'hide'; @endphp


                            <div class="questions-block {{$class}}" data-id="{{$questionIndex}}" data-tconsumed="0">
                            <form action="javascript:;" class="question-form" method="post"
                                                                  data-id="{{$questionIndex}}">
                                <div class="questions-status d-flex mb-15">
                                </div>
                                <div class="questions-arithmetic-box d-flex align-items-center justify-content-center">
                            		<span>{{$questionObj->from}} <span>{{$questionObj->type}}</span> {{$questionObj->to}} <span>&equals;</span></span>
                                   <input type="text" data-from="{{$questionObj->from}}"
                                                                           data-type="{{$questionObj->type}}"data-table_no="{{$questionObj->table_no}}" data-to="{{$questionObj->to}}"
                                                                           class="editor-fields" id="editor-fields-{{$questionIndex}}">
                                   <div class="questions-controls">
                                       <a href="#" class="setting-btn mr-5">
                                        <img src="../assets/default/svgs/setting.svg" alt="mute svg">
                                       </a>
                                       <a href="#">
                                        <img src="../assets/default/svgs/vol-mute.svg" alt="mute svg">
                                       </a>
                                       <a href="#">
                                           <img src="../assets/default/svgs/spr-mute.svg" alt="mute svg">
                                       </a>
                                   </div>
                                </div>
                                <div class="questions-block-numbers">
                                   <ul class="d-flex justify-content-center flex-wrap">
                                      <li id="key-7" data-value="8"><a href="javascript:;">7</a></li>
                            			<li id="key-8" data-value="8"><a href="javascript:;">8</a></li>
                            			<li id="key-9" data-value="9"><a href="javascript:;">9</a></li>
                            			<li id="key-4" data-value="4"><a href="javascript:;">4</a></li>
                            			<li id="key-5" data-value="5"><a href="javascript:;">5</a></li>
                            			<li id="key-6" data-value="6"><a href="javascript:;">6</a></li>
                            			<li id="key-1" data-value="1"><a href="javascript:;">1</a></li>
                            			<li id="key-2" data-value="2"><a href="javascript:;">2</a></li>
                            			<li id="key-3" data-value="3"><a href="javascript:;">3</a></li>
                            			<li class="delete" data-value="delete"><a href="javascript:;">Delete</a></li>
                            			<li id="key-0" data-value="0"><a href="javascript:;">0</a></li>
                            			<li class="enter" data-value="enter"><a href="javascript:;">Enter</a></li>
                                   </ul>
                                </div>
                            	</form>
                             </div>


                            @php $question_no++; @endphp
                            @endforeach

                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


</div>

@endsection

@push('scripts_bottom')

<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_id}}"></script>
<script>
    //init_question_functions();

    var user_data = [];

    var Questionintervals = setInterval(function () {
        if ($('.questions-block[data-id="0"]').hasClass('active')) {
            var seconds_count = $('.questions-block[data-id="0"]').attr('data-tconsumed');
            seconds_count = parseInt(seconds_count) + parseInt(1);
            $('.questions-block[data-id="0"]').attr('data-tconsumed', seconds_count);
            //$('.questions-block[data-id="0"]').find(".time-count-seconds").html(parseInt(seconds_count) / 10);
        } else {
            clearInterval(Questionintervals);
        }
    }, 100);

    $(document).on('click', '.questions-block-numbers ul li', function (e) {
        var current_value = $(this).attr('data-value');
        var current_field_value = $(this).closest('form').find('.editor-fields').val();
        if( current_value == 'delete'){
            current_field_value = current_field_value.substring(0,current_field_value.length - 1);
            $(this).closest('form').find('.editor-fields').val(current_field_value);
        }else if( current_value == 'enter'){
            $(this).closest('form').submit();
        }else {
            $(this).closest('form').find('.editor-fields').val(current_field_value + current_value);
        }
    });




    $(document).on('submit', '.question-form', function (e) {

        var total_questions = $(".question-area-block").attr('data-total_questions');

        clearInterval(Questionintervals);
        var data_id = $(this).attr('data-id');
        var time_consumed = $(this).closest('.questions-block').attr('data-tconsumed');
        var next_question = parseInt(data_id) + 1;
        user_data[data_id] = [];

        var from = $("#editor-fields-" + data_id).attr('data-from');
        var to = $("#editor-fields-" + data_id).attr('data-to');
        var type = $("#editor-fields-" + data_id).attr('data-type');
        var table_no = $("#editor-fields-" + data_id).attr('data-table_no');
        var answer = $("#editor-fields-" + data_id).val();



        var correct_answer = rurera_correct_value(from, to, type);
        var is_correct = (answer == correct_answer)? true : false;
        user_data[data_id] = {'from': from, 'to': to, 'type': type, 'answer': answer, 'time_consumed': time_consumed, 'table_no':table_no, 'is_correct':is_correct, 'correct_answer':correct_answer};

        var status_class = (answer == correct_answer)? 'successful' : 'wrong';

        $('.questions-status').append('<span class="'+status_class+'"></span>');


        $('.questions-block').addClass('hide');
        $('.questions-block').removeClass('active');

        if (parseInt(next_question) < parseInt(total_questions)) {

            $('.questions-block[data-id="' + next_question + '"]').removeClass('hide');
            $('.questions-block[data-id="' + next_question + '"]').addClass('active');
            $("#editor-fields-" + next_question).focus();

            var Questionintervals = setInterval(function () {
                var seconds_count = $('.questions-block[data-id="' + next_question + '"].active').attr('data-tconsumed');
                seconds_count = parseInt(seconds_count) + parseInt(1);
                $('.questions-block[data-id="' + next_question + '"].active').attr('data-tconsumed', seconds_count);
                //$('.questions-block[data-id="' + next_question + '"].active').find(".time-count-seconds").html(parseInt(seconds_count) / 10);
            }, 100);
        } else {
            var response_layout = '';


            jQuery.ajax({
                type: "POST",
                url: '/question_attempt/timestables_submit',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'timestables_data':user_data},
                success: function (return_data) {
                    console.log(return_data);
                }
            });

            window.location.href = '/timestables/summary';




            $.each(user_data, function (field_id, user_data_obj) {
                var from = user_data_obj.from;
                var to = user_data_obj.to;
                var action_type = user_data_obj.type;
                var user_answer = user_data_obj.answer;
                var time_consumed = user_data_obj.time_consumed;
                var time_consumed_seconds = parseInt(time_consumed) / 10;

                var correct_answer = rurera_correct_value(from, to, action_type);

                var is_correct_label = (user_answer == correct_answer)? 'Correct' : 'Incorrect';

                response_layout += '<div class="question-answer-block">\n\
                    '+from+' '+action_type+' '+to+' = '+user_answer+'   '+is_correct_label+' ('+time_consumed_seconds+' seconds)\n\
                    </div>';

                console.log(user_answer+'===='+correct_answer+'====='+time_consumed+'======='+time_consumed_seconds);

            });
            response_layout = '';

            $(".question-area-block").html(response_layout);
        }

    });

    function rurera_correct_value(from, to, operator) {
        var correct_value = '';
        switch (operator) {

            case "÷":
                var correct_value = parseInt(from) / parseInt(to);
                break;

            case "x":
                var correct_value = parseInt(from) * parseInt(to);
                break;
        }
        return correct_value;
    }

    $(document).on('click', '.next', function (e) {
        $(".prevm").removeClass('active');
        $(".nextm").addClass('active');
    });
    $(".editor-fields").focus();


    $('body').addClass('quiz-show');
    var header = document.getElementById("navbar");
    var headerOffset = (header != null) ? header.offsetHeight : 100;
    var header_height = parseInt(headerOffset) + parseInt(85) + "px";


    if (jQuery('.quiz-pagination .swiper-container').length > 0) {
        console.log('slides-count');
        console.log($(".quiz-pagination ul li").length);
        const swiper = new Swiper('.quiz-pagination .swiper-container', {
            slidesPerView: ($(".quiz-pagination ul li").length > 20) ? 20 : $(".quiz-pagination ul li").length,
            spaceBetween: 0,
            slidesPerGroup: 5,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 3,
                    spaceBetween: 5
                },

                480: {
                    slidesPerView: ($(".quiz-pagination ul li").length > 20) ? 20 : $(".quiz-pagination ul li").length,
                    spaceBetween: 5
                },

                640: {
                    slidesPerView: ($(".quiz-pagination ul li").length > 20) ? 20 : $(".quiz-pagination ul li").length,
                    spaceBetween: 5
                }
            }
        })
    }
</script>
@endpush
