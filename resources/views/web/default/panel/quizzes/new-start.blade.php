@php namespace App\Http\Controllers\Web; @endphp
@extends(getTemplate().'.layouts.appstart')
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">

@section('content')

<div class="lms-content-holder">
    <div class="lms-content-header">
        <div class="header-left">
            <p>
                <strong>{{$quiz->title}}</strong>
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
        <div class="header-right">
            <a href="#" class="tab-toggle-btn">
                <span class="sort-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
        </div>
    </div>
    <div class="user-question-panel hide">
        <ul class="question-list">
            @while($i++ < $quizQuestions->count())
				
            <li>{{$i}}</li>
            @endwhile
        </ul>
    </div>
    <div class="questions-data-block" data-total_questions="{{$quizQuestions->count()}}">
	
	<div class="question-step quiz-complete" style="display:none">
        <div class="question-layout-block">
                <div class="left-content has-bg">
                    <h2>&nbsp;</h2>
                    <div id="rureraform-form-1" class="rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable" _data-parent="1" _data-parent-col="0" style="display: block;">
                        <div class="question-layout">
                            
                        </div>
                    </div>
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
        <div class="question-step question-step-{{ $question->id }}" data-qattempt="{{$quizAttempt->id}}" data-start_time="0" data-qresult="{{$newQuestionResultData->id}}" {{$hide_style}}>
            <div class="question-layout-block">
                            <div class="correct-appriciate" style="display:none"></div>
                <form class="question-fields" action="javascript:;" data-question_id="{{ $question->id }}">
                    <div class="left-content has-bg">
                        <h2><span>Q {{$j}}</span> - {{ $question->question_title }} <span class="icon-img"><img src="../../assets/default/img/quiz/sound-img.png" alt=""></span> </h2>
                        <div id="rureraform-form-1" class="rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable" _data-parent="1" _data-parent-col="0" style="display: block;">
                            <div class="question-layout">
                                <span class="marks" data-marks="{{$question->question_score}}">[{{$question->question_score}}]</span>
                                {!! $question_layout !!}

                            </div>
                            <div class="form-btn">
                                <input class="submit-btn" type="button" data-question_no="{{$j}}" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="right-content">
        <div class="range-value-count">
            <span>1100</span>
        </div>
        <!-- vertical range-slider -->
        <div class="range-container vertical">
            <div class="range-box">
                <span class="range-bar-holder">
                    <span class="track-bar" style="background-color: #4bc1ef;"></span>
                    <span class="track-bar" style="background-color: #a4b96a;"></span>
                    <span class="track-bar" style="background-color: #fecc49;"></span>
                    <span class="track-bar" style="background-color: #f59618;"></span>
                    <span class="track-bar" style="background-color: #c12f16;"></span>
                </span>
                <input orient="vertical" type="range" id="range" min="0" max="100">
                <label for="range" class="coin-marks-label">
                    50
                </label>
            </div>
        </div>
		
        <div class="range-price" data-time_elapsed="0">
            <strong class="t-minute">4<em>m</em></strong>
            <strong class="t-seconds">50<em>s</em></strong>
        </div>
        <p class="mastery-text" style="color: #50517d;">1400 Mastery Coins</p>
    </div>
    </div>



</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/js/sortable.js"></script>
<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js?var={{$rand_id}}"></script>
<script>

const range = document.getElementById('range')
        range.addEventListener('input', (e) = > {
        const value = + e.target.value
                const label = e.target.nextElementSibling

                const range_width = getComputedStyle(e.target).getPropertyValue('width')
                const label_width = getComputedStyle(label).getPropertyValue('width')

                const num_width = + range_width.substring(0, range_width.length - 2)
                const num_label_width = + label_width.substring(0, label_width.length - 2)

                const max = + e.target.max
                const min = + e.target.min

                const left = value * (num_width / max) - num_label_width / 2 + scale(value, min, max, 10, - 10)
                label.style.left = `${left}px`

                label.innerHTML = value
        })
        const scale = (num, in_min, in_max, out_min, out_max) = > {
return (num - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}
</script>
@endpush
