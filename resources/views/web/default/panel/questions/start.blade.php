@php namespace App\Http\Controllers\Web; @endphp
@extends(getTemplate().'.layouts.appstart')
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
@endpush

<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    .image-field img{
        width:50px;
        height:50px
    }
    .image-field-box{
        position:absolute !important;
    }
    .draggable-items{
        display:table-row;
        clear:both;

    }
    .draggable-items li{
        display:block;
        float: left;
    }
    .rurera-droppable{
            width:100; border:1px solid #efefef; height:50px; display:inline-block;
        }
</style>
@section('content')

<div class="lms-content-holder">
    <div class="lms-content-header">
        <div class="header-left">
            <p>
                <strong>Test View</strong>
                <span>Maths</span>
                <span>1400 Mastery Coins</span>
            </p>
            <div class="ribbon-images">
                <img src="../../assets/default/img/quiz/ribbon-img1.png" alt="">
                <img src="../../assets/default/img/quiz/ribbon-img2.png" alt="">
                <img src="../../assets/default/img/quiz/ribbon-img3.png" alt="">
                <img src="../../assets/default/img/quiz/ribbon-img4.png" alt="">
            </div>
        </div>
    </div>



    @php
    $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question->question_layout)))));
    $hide_style = '';
    if( $j != 1){
		$hide_style = 'style=display:none;';
    }
    @endphp

    <div class="question-area">
        <div class="question-step question-step-1" data-qattempt="1" data-start_time="0" data-qresult="1" data-quiz_result_id="1" {{$hide_style}}>
            <div class="question-layout-block">
                            <div class="correct-appriciate" style="display:none"></div>
                <form class="question-fields" action="javascript:;" data-question_id="{{ $question->id }}">
                    <div class="left-content has-bg">
                        <span class="question-number-holder"> <span class="question-number">{{$j}}</span> <span class="question-icon"> <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1620 4674 c-46 -20 -77 -50 -103 -99 l-22 -40 -3 -1842 -2 -1843 -134 0 c-120 0 -137 -2 -177 -23 -24 -13 -57 -43 -74 -66 -27 -39 -30 -50 -30 -120 0 -66 4 -83 25 -114 14 -21 43 -50 64 -65 l39 -27 503 0 502 0 44 30 c138 97 118 306 -34 370 -27 11 -73 15 -168 15 l-130 0 0 750 0 750 1318 2 1319 3 40 28 c83 57 118 184 75 267 -10 19 -140 198 -290 398 -170 225 -270 367 -265 375 4 7 128 174 276 372 149 197 276 374 283 392 19 45 17 120 -5 168 -23 51 -79 101 -128 114 -26 7 -459 11 -1330 11 l-1293 0 0 20 c0 58 -56 137 -122 171 -45 23 -128 25 -178 3z"></path> </g> </svg> </span> </span>
                        <div id="leform-form-1" class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable" _data-parent="1" _data-parent-col="0" style="display: block;">
                            <div class="question-layout">
                                <span class="marks" data-marks="0">[{{$question->question_score}}]</span>


                                <ul class="draggable-items">
                                    <li><span class="draggable-option">Option 1</span></li>
                                    <li><span class="draggable-option">Option 2</span></li>
                                    <li><span class="draggable-option">Option 3</span></li>
                                    <li><span class="draggable-option">Option 4</span></li>
                                </ul>


                                Test <span class="rurera-droppable"></span>   test 2 <span class="rurera-droppable"></span>



                                {!! $question_layout !!}

                            </div>

                            @include('web.default.panel.questions.fail_view')
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="question-area-temp hide"></div>


    </div>



</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/js/sortable.js"></script>
<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js?var={{$rand_id}}"></script>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>



$(document).ready(function () {
    $(".droppable_area").droppable({
        drop: function(event, ui) {
            // Clone the dropped element
            var clone = ui.helper.clone();
            if( $(this).html() == '') {
                $(this).append($(clone).html());
                $(".droppable_area .draggable-option").on("dblclick", function () {
                    $(this).remove();
                });
            }
        }
    });
    $(".draggable-items li").draggable({revert: "invalid", helper: "clone"});



});
</script>
@endpush
