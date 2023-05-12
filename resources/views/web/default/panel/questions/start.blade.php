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
                <span>{{$quiz->mastery_points}} Mastery Coins</span>
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
                        <h2><span>Q {{$j}}</span> - {{ $question->question_title }} <span class="icon-img"><img src="../../assets/default/img/quiz/sound-img.png" alt=""></span> </h2>
                        <div id="leform-form-1" class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable" _data-parent="1" _data-parent-col="0" style="display: block;">
                            <div class="question-layout">
                                <span class="marks" data-marks="0">[{{$question->question_score}}]</span>
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
