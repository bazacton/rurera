@php namespace App\Http\Controllers\Web; @endphp
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);


@endphp


<style>
    .ui-state-highlight {
        margin: 0px 10px;
    }

    .field-holder.wrong, .form-field.wrong, .form-field.wrong label {
        background: #ff4a4a;
        color: #fff;
    }
    .rurera-hide{
        display:none;
    }
	
	.rurera-question-block{display:none;}
	.rurera-question-block.active{display:block;}

</style>
@php $quiz_type = isset( $quiz->quiz_type )? $quiz->quiz_type : '';
$duration_type = isset( $duration_type )? $duration_type : 'no_time_limit';

$timer_counter = 0;
if( $duration_type == 'per_question'){
$timer_counter = $time_interval;
}
if( $duration_type == 'total_practice'){
$timer_counter = $practice_time;
}
$target_score = isset( $quiz->target_score)? $quiz->target_score : 0;
$target_score = ($target_score > 0)? $target_score : 100;
$practice_time = 0;
@endphp
<div class="content-section quiz-settings dis-arrows">

    <section class="lms-quiz-section">

        @if( $quiz->quiz_pdf != '')
        <script type="text/javascript">
            $(document).ready(function () {
                $(".read-quiz-info").flipBook({
                    pdfUrl: '{{$quiz->quiz_pdf}}',
                    btnZoomIn: {enabled: true},
                    btnZoomOut: {enabled: true},
                    btnToc: {enabled: false},
                    btnShare: {enabled: false},
                    btnDownloadPages: {enabled: false},
                    btnDownloadPdf: {enabled: false},
                    btnSound: {enabled: false},
                    btnAutoplay: {enabled: false},
                    btnSelect: {enabled: false},
                    btnBookmark: {enabled: false},
                    btnThumbs: {enabled: false},
                    btnPrint: {enabled: false},
                    currentPage: {enabled: false},
                    viewMode: "swipe",
                    singlePageMode: true,
                    skin: 'dark',
                    menuMargin: 10,
                    menuBackground: 'none',
                    menuShadow: 'none',
                    menuAlignHorizontal: 'right',
                    menuOverBook: true,
                    btnRadius: 40,
                    btnMargin: 4,
                    btnSize: 14,
                    btnPaddingV: 16,
                    btnPaddingH: 16,
                    btnBorder: '2px solid rgba(255,255,255,.7)',
                    btnBackground: "rgba(0,0,0,.3)",
                    btnColor: 'rgb(255,120,60)',
                    sideBtnRadius: 60,
                    sideBtnSize: 60,
                    sideBtnBackground: "rgba(0,0,0,.7)",
                    sideBtnColor: 'rgb(255,120,60)',
                });
            });

        </script>
        <div class="read-quiz-info quiz-show"></div>
        <script>


        </script>
        @endif

        <div class="container questions-data-block read-quiz-content"
             data-total_questions="{{$quizQuestions->count()}}">
            @php $top_bar_class = ''; @endphp

            <section class="quiz-topbar {{$top_bar_class}}">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            @if( isset( $quiz->quiz_type ))
                               <img class="quiz-type-icon" src="/assets/default/img/assignment-logo/{{$quiz->quiz_type}}.png">
                           @endif
                            <div class="quiz-top-info"><p>{{$quiz->getTitleAttribute()}}</p>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                            <div class="topbar-right">
                                   <div class="quiz-pagination rurera-hide">
                                       <div class="swiper-container">
                                       <ul class="swiper-wrapper disabled-div">
                                           @if( !empty( $questions_list ) )
                                           @php $question_count = 1; @endphp
                                           @foreach( $questions_list as $question_id)
                                           @php $is_flagged = false;
                                           $flagged_questions = ($newQuizStart->flagged_questions != '')? json_decode
                                           ($newQuizStart->flagged_questions) : array();
                                           $actual_question_id = isset( $actual_question_ids[$question_id] )? $actual_question_ids[$question_id] : 0;
                                           @endphp
                                           @if( is_array( $flagged_questions ) && in_array( $actual_question_id,
                                           $flagged_questions))
                                           @php $is_flagged = true;
                                           @endphp
                                           @endif
                                           @php $question_status_class = isset( $questions_status_array[$question_id] )? $questions_status_array[$question_id] : 'waiting'; @endphp
                                           <li data-question_id="{{$question_id}}" data-actual_question_id="{{$actual_question_id}}" class="swiper-slide {{ ( $is_flagged == true)?
                                                   'has-flag' : ''}} {{$question_status_class}}"><a
                                                   href="javascript:;">
                                                   {{$question_count}}</a></li>
                                           @php $question_count++; @endphp
                                           @endforeach
                                           @endif
                                       </ul>
                                       </div>
                                       <div class="swiper-button-prev"></div>
                                       <div class="swiper-button-next"></div>
                                   </div>
								<div class="close-btn-holder">
                                    <button class="close-btn review-btn pause-quiz" data-toggle="modal" data-target="#pause_quiz">&#x2715;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="justify-content-center">
                <div class="col-lg-9 col-md-12 col-sm-12 mt-100 mx-auto">
                    <div class="question-step quiz-complete" style="display:none">
                        <div class="question-layout-block">
                            <div class="left-content has-bg">
                                <h2>&nbsp;</h2>
                                <div id="rureraform-form-1"
                                     class="rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable"
                                     _data-parent="1"
                                     _data-parent-col="0" style="display: block;">
                                    <div class="question-layout">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
					
					<div class="quiz-status-bar">
                        <div class="quiz-questions-bar-holder">
                            
                            <div class="quiz-questions-bar">
								@if( $target_score > 0)
									<span class="value-lable" data-title="Target" style="left:{{$target_score}}%"><span>{{$target_score}}%</span></span>
								@endif
                                <span class="bar-fill" title="" style="width: 0%;"></span>
                            </div>
                            <span class="coin-numbers">
                                <img src="/assets/default/img/quests-coin.png" alt="">
                                <span class="total-earned-coins">0</span>
                            </span>
                        </div>
                        <div class="quiz-corrects-incorrects">
                            <span class="quiz-corrects">0</span>
                            <span class="quiz-incorrects">0</span>
                        </div>
                    </div>

                    <div class="question-area-block" data-active_question_id="{{$active_question_id}}" data-questions_layout="{{json_encode($questions_layout)}}">
					@php $total_questions = 10; @endphp
					<div class="question-area dis-arrows1" data-total_questions="{{$total_questions}}">
						<div class="correct-appriciate" style="display:none"></div>
						<div class="question-inner-step-area">
							<div class="question-layout-block">

									<div class="left-content has-bg">


                        @if( is_array( $question ))
                        @php $question_no = 1; @endphp

                        @foreach( $question as $questionObj)
                        @include('web.default.panel.questions.question_layout',[
                        'question'=> $questionObj,
                        'prev_question' => 0,
                        'next_question' => 0,
                        'question_no' => $question_no,
                        'quizAttempt' => $quizAttempt,
                        'newQuestionResult' => $newQuestionResult,
                        'quizResultObj' => $newQuizStart
                        ])
                        @php $question_no++; @endphp
                        @endforeach
                        @else
							
						
						
						@if( !empty( $questions_layout  ) )
							@php $question_counter  = 1; @endphp
							@foreach( $questions_layout as $result_question_id => $questionLayout)
								@php $active_actual_question_id = isset( $actual_question_ids[$result_question_id] )? $actual_question_ids[$result_question_id] : 0; 
								$active_class = ($active_question_id == $active_actual_question_id)? 'active' : '';
								$active_class = ($active_class == '' && $question_counter == 1)? 'active' : '';
								@endphp
								<div class="rurera-question-block question-step question-step-{{ $active_actual_question_id }} {{$active_class}}" data-elapsed="0"
								data-qattempt="{{isset( $quizAttempt->id )? $quizAttempt->id : 0}}"
								data-start_time="0" data-qresult="{{isset( $result_question_id )? $result_question_id : 0}}"
								data-quiz_result_id="{{isset( $quizAttempt->quiz_result_id )? $quizAttempt->quiz_result_id : 0}}">
								{!! $questionLayout !!}
								</div>
								
								@php $question_counter++; @endphp
							@endforeach
						@endif	

                        @endif
						<div class="show-notifications" data-show_message="yes"></div>
						
						
						
					<div class="prev-next-controls text-center mb-50 questions-nav-controls">
                        <a href="javascript:;" data-toggle="modal" class="review-btn rurera-hide1" data-target="#review_submit">
                            Finish
                            <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                 width="512.000000pt" height="512.000000pt"
                                 viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                            d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                </g>
                            </svg>
                        </a>
                        <a href="javascript:;" id="next-btn" class="rurera-hide next-btn">
                            Next
                            <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                 width="512.000000pt" height="512.000000pt"
                                 viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                            d="M1340 5111 c-118 -36 -200 -156 -187 -272 3 -27 14 -66 23 -86 11 -25 377 -398 1093 -1116 l1076 -1077 -1076 -1078 c-716 -717 -1082 -1090 -1093 -1115 -61 -135 4 -296 140 -347 66 -24 114 -25 180 -4 45 15 146 113 1242 1208 1095 1093 1194 1195 1212 1244 11 29 20 70 20 92 0 22 -9 63 -20 92 -18 49 -117 151 -1212 1244 -1096 1095 -1197 1193 -1242 1208 -52 17 -114 20 -156 7z"></path>
                                </g>
                            </svg>
                        </a>

                        <a href="javascript:;" id="question-submit-btn" class="question-submit-btn">
                            mark answer
                            <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                 width="512.000000pt" height="512.000000pt"
                                 viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                            d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                </g>
                            </svg>
                        </a>

                        <a href="javascript:;" id="question-next-btn" class="question-next-btn rurera-hide">
                            Next
                            <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                 width="512.000000pt" height="512.000000pt"
                                 viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                            d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
						
						
						
						</div>

        </div>
    </div>

</div>
						
						
						
						
                    </div>

                    <div class="question-area-temp hide"></div>

                </div>

            </div>
        </div>
    </section>


</div>

@if($quiz->quiz_type == 'vocabulary')
<div class="question-status-modal">
  <div class="modal fade question_status_modal" id="question_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-box">
            <div class="modal-title">
              <h3>Incorrect!</h3>
              <span class="inc" style="text-decoration: line-through;">are</span>
              <span class="cor">are</span>
            </div>
            <p>
              <span>verb</span> when more than one person is being something
            </p>
            <a href="javascript:;" class="confirm-btn" data-dismiss="modal" aria-label="Close">Okay</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<div class="modal fade review_submit1" id="review_submit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <button type="button" class="close unpause-quiz" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
           <div class="modal-body">
			  <div class="modal-box">
				<span class="icon-box d-block mb-15">
					<img src="../assets/default/img/clock-modal-img.png" alt="">
				</span>
				<h3 class="font-24 font-weight-normal mb-10">Are you sure?</h3>
				<p class="mb-15 font-16">
					You've  been gone a while, we have paused you, you still can continue learning by using following&nbsp;links.
				</p>
				<div class="inactivity-controls flex-column d-flex">
					<a href="javascript:;" class="review-btn submit_quiz_final">Finish Test</a>
				</div>
			  </div>
			</div>
       </div>
   </div>
</div>
<div class="modal fade pause_quiz quiz-activity-pause" id="pause_quiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog">
       <div class="modal-content">
		   <div class="modal-body">
			  <div class="modal-box">
				<span class="icon-box d-block mb-15">
					<img src="../assets/default/img/clock-modal-img.png" alt="">
				</span>
				<h3 class="font-24 font-weight-normal mb-10 pause-title">Need a Break?</h3>
				<p class="mb-15 font-16 pause-description">
					Practice tests do not let you go over time, though you can pause them and come back to them later.
				</p>
				<ul class="activity-info">
					<li>Total Answered: <strong class="total-questions">10</strong></li>
					<li><span class="icon-box"></span> Correct: <strong class="correct-questions">1</strong></li>
					<li>Incorrect: <strong class="incorrect-questions">2</strong></li>
				</ul>
				<div class="inactivity-controls">
					<a href="javascript:;" class="continue-btn" data-dismiss="modal" aria-label="Continue">Continue Test</a>
					<a href="javascript:;" class="review-btn" data-dismiss="modal" data-toggle="modal" data-target="#review_submit">Finish Test</a>
					<a href="/panel" class="exit-btn"> Need a break! </a>
				</div>
			  </div>
			</div>
       </div>
   </div>
</div>
<div class="modal fade validation_error" id="validation_error" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
           <div class="modal-body">
               <p>Please fill all the required fields before submitting.</p>
           </div>
       </div>
   </div>
</div>


<div class="modal fade question_inactivity_modal" id="question_inactivity_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-body">
      <div class="modal-box">
        <span class="icon-box d-block mb-15">
            <img src="../assets/default/img/clock-modal-img.png" alt="">
        </span>
        <h3 class="font-24 font-weight-normal mb-10">Are you still there?</h3>
        <p class="mb-15 font-16">
            You've been inactive for a while, and your session was paused. You can continue learning by using the following links
        </p>
		<ul class="activity-info">
			<li>Total Answered: <strong class="total-questions">10</strong></li>
			<li><span class="icon-box"></span> Correct: <strong class="correct-questions">1</strong></li>
			<li>Incorrect: <strong class="incorrect-questions">2</strong></li>
		</ul>
        <div class="inactivity-controls">
            <a href="javascript:;" class="continue-btn" data-dismiss="modal" aria-label="Continue">Continue Test</a>
            <a href="javascript:;" class="review-btn" data-dismiss="modal" data-toggle="modal" data-target="#review_submit">Finish Test</a>
			<a href="/panel" class="exit-btn"> Need a break! </a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<a href="#" data-toggle="modal" class="hide review_submit_btn" data-target="#review_submit">modal button</a>



<script>
    //init_question_functions();
    $('body').addClass('quiz-show');
    var header = document.getElementById("navbar");
    var headerOffset = (header != null) ? header.offsetHeight : 100;
    var header_height = parseInt(headerOffset) + parseInt(85) + "px";


    var Quizintervals = null;
	var InactivityInterval = null;
    var focusInterval = null;
    var focusIntervalCount = 180;
	var TimerActive = true;
    var duration_type = '{{$duration_type}}';
	
	
	
	
	
	

    function quiz_default_functions() {
		
		
		var total_questions = $('.quiz-pagination li').length;
		var attempted_questions = $('.quiz-pagination li.correct, .quiz-pagination li.incorrect').length;
		var correct_questions = $('.quiz-pagination li.correct').length;
		var incorrect_questions = $('.quiz-pagination li.incorrect').length;
		var total_percentage_questions = parseInt(total_questions) * 100 / '{{$target_score}}';
		console.log('total_percentage_questions=='+total_percentage_questions);
		var correct_percentage = parseInt(correct_questions) * 100 / parseInt(total_percentage_questions);
		var correct_percentage = ( correct_percentage > 0)? correct_percentage : 0;
		$(".quiz-corrects").html(attempted_questions);
		$(".quiz-incorrects").html(incorrect_questions);
		$(".quiz-questions-bar .bar-fill").css('width', Math.round(correct_percentage)+'%');
		$(".quiz-questions-bar .bar-fill").attr('title',Math.round(correct_percentage)+'%');
		
		$(".total-earned-coins").html(correct_questions);
		
		window.addEventListener('blur', function () {
            //var attempt_id = $(".question-area .question-step").attr('data-qattempt');
            //inactivity-timer
            if( focusInterval == null) {

                focusInterval = setInterval(function () {
                    var focus_count = focusIntervalCount-1;
                    console.log('focusout--'+focus_count);
                    focusIntervalCount = focus_count;
                    if (focus_count <= 0 && TimerActive == true) {
                        TimerActive = false;
						var total_questions = $('.quiz-pagination li').length;
						var attempted_questions = $('.quiz-pagination li.correct, .quiz-pagination li.incorrect').length;
						var correct_questions = $('.quiz-pagination li.correct').length;
						var incorrect_questions = $('.quiz-pagination li.incorrect').length;
						var total_percentage_questions = parseInt(total_questions) * 100 / '{{$target_score}}';
						var correct_percentage = parseInt(correct_questions) * 100 / parseInt(total_percentage_questions);
						var correct_percentage = ( correct_percentage > 0)? correct_percentage : 0;
						var remaining_time = $('.quiz-timer-counter').attr('data-time_counter');
						$(".question_inactivity_modal .modal-body .total-questions").html(attempted_questions);
						$(".question_inactivity_modal .modal-body .correct-questions").html(correct_questions);
						$(".question_inactivity_modal .modal-body .incorrect-questions").html(incorrect_questions);
						
						
                        $(".question_inactivity_modal").modal('show');
                        focusIntervalCount = 180;
                        clearInterval(focusInterval);
                        focusInterval = null;
                    }
                }, 1000);

            }
        });


        window.addEventListener('focus', function () {
            focusIntervalCount = 180;
            clearInterval(focusInterval);
            focusInterval = null;
        });

        $(document).on('click', '.continue-btn', function (e) {
            TimerActive = true;
            focusIntervalCount = 180;
            focusInterval = null;
        });
		
		$(document).on('click', '.finish-btn', function (e) {
            $(".pause_quiz").modal('hide');
        });
		

		
		if (jQuery('.quiz-pagination .swiper-container').length > 0) {
        const swiper = new Swiper('.quiz-pagination .swiper-container', {
            slidesPerView: ($(".quiz-pagination ul li").length > 15) ? 15 : $(".quiz-pagination ul li").length,
            spaceBetween: 0,
            slidesPerGroup: 10,
            // observer: true,
            // observeParents: true,
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
                    slidesPerView: ($(".quiz-pagination ul li").length > 15) ? 15 : $(".quiz-pagination ul li").length,
                    spaceBetween: 5
                },

                640: {
                    slidesPerView: ($(".quiz-pagination ul li").length > 15) ? 15 : $(".quiz-pagination ul li").length,
                    spaceBetween: 5
                }
            }
        })
    }
		
		
		
		
		
		
		
		
		
		var quiz_result_id = $(".question-area .question-step").attr('data-quiz_result_id');
		var timeUpdateRequest = null;
		timeUpdateRequestInterval = setInterval(function () {
			var time_consumed = $('.quiz-timer-counter').attr('data-time_consumed');
			
			timeUpdateRequest = jQuery.ajax({
				type: "POST",
				dataType: 'json',
				url: '/question_attempt/update_time',
				async: true,
				beforeSend: function () {
					if (timeUpdateRequest != null) {
						timeUpdateRequest.abort();
					}
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {"time_consumed": time_consumed, "quiz_result_id":quiz_result_id},
				success: function (return_data) {
					console.log(return_data);
				}
			});
		}, 5000);
		
		

        var active_question_id = $(".question-area-block").attr('data-active_question_id');
       $('.quiz-pagination ul li[data-actual_question_id="'+active_question_id+'"]').click();
	   
	   
	   
	   $("body").on("click", ".pause-quiz", function (e) {
			$(".pause_quiz .continue-btn").removeClass('rurera-hide');
			$(".pause_quiz .exit-btn").removeClass('rurera-hide');
			var total_questions = $('.quiz-pagination li').length;
			var attempted_questions = $('.quiz-pagination li.correct, .quiz-pagination li.incorrect').length;
			var correct_questions = $('.quiz-pagination li.correct').length;
			var incorrect_questions = $('.quiz-pagination li.incorrect').length;
			var total_percentage_questions = parseInt(total_questions) * 100 / '{{$target_score}}';
			var correct_percentage = parseInt(correct_questions) * 100 / parseInt(total_percentage_questions);
			var correct_percentage = ( correct_percentage > 0)? correct_percentage : 0;
			var remaining_time = $('.quiz-timer-counter').attr('data-time_counter');
			$(".pause-title").html('Need a Break?');
			$(".pause-description").html('Practice tests do not let you go over time, though you can pause them and come back to them later.');
			$(".pause_quiz .modal-body .total-questions").html(attempted_questions);
			$(".pause_quiz .modal-body .correct-questions").html(correct_questions);
			$(".pause_quiz .modal-body .incorrect-questions").html(incorrect_questions);
            TimerActive = false;
        });
		$("body").on("click", ".unpause-quiz", function (e) {
            TimerActive = true;
        });
		
		$("body").on("click", ".review-btn", function (e) {
			var attempted_questions = $('.quiz-pagination li.correct, .quiz-pagination li.incorrect').length;
			$(".review_submit1 .modal-body p").html('You have attempted ' + attempted_questions + ' questions. are you sure you want to submit your test? you will not able to access this test again.');
            $(".pause_quiz").modal('hide');
        });
		
		
		

        Quizintervals = setInterval(function () {
			if( TimerActive == true){
				var quiz_timer_counter = $('.quiz-timer-counter').attr('data-time_counter');
				var time_consumed = $('.quiz-timer-counter').attr('data-time_consumed');
				time_consumed = parseInt(time_consumed) + parseInt(1);
				$('.quiz-timer-counter').attr('data-time_consumed', time_consumed);
				
				if (duration_type == 'no_time_limit') {
					quiz_timer_counter = parseInt(quiz_timer_counter) + parseInt(1);
				} else {
					quiz_timer_counter = parseInt(quiz_timer_counter) - parseInt(1);
				}
				$('.quiz-timer-counter').html(getTime(quiz_timer_counter));
				if ($('.nub-of-sec').length > 0) {
					$('.nub-of-sec').html(getTime(quiz_timer_counter));
				}
				$('.quiz-timer-counter').attr('data-time_counter', quiz_timer_counter);
				if( quiz_timer_counter == 0){
					clearInterval(Quizintervals);
					rurera_loader($(".lms-quiz-section"), 'div');
					clearInterval(Quizintervals);
					$(".pause-quiz").click();
					$(".pause_quiz .continue-btn").addClass('rurera-hide');
					$(".pause_quiz .exit-btn").addClass('rurera-hide');
					$(".pause-title").html('');
					$(".pause-description").html('');
					//$(".submit_quiz_final").click();
				}
			}

        }, 1000);

        $("body").on("click", ".increasetext", function (e) {
            curSize = parseInt($('.learning-page').css('font-size')) + 2;
            if (curSize <= 32)
                $('.learning-page').css('font-size', curSize);
        });

        $("body").on("click", ".resettext", function (e) {
            if (curSize != 16)
            $('.learning-page').css('font-size', 18);
        });

        $("body").on("click", ".decreasetext", function (e) {
            curSize = parseInt($('.learning-page').css('font-size')) - 2;
            if (curSize >= 16)
            $('.learning-page').css('font-size', curSize);
        });
		


    }

    function getTime(secondsString) {
        var h = Math.floor(secondsString / 3600); //Get whole hours
        secondsString -= h * 3600;
        var m = Math.floor(secondsString / 60); //Get remaining minutes
        secondsString -= m * 60;
        var return_string = '';
        if( h > 0) {
            var return_string = return_string + h + "h ";
        }
        var quiz_type = '{{$quiz_type}}';
        if( (m > 0 || h > 0) || quiz_type != 'vocabulary') {
            var return_string = return_string + (m < 10 ? '0' + m : m) + "m ";
        }
        var return_string = return_string + (secondsString < 10 ? '0' + secondsString : secondsString);	
        return_string = return_string + 's';

        return return_string;
    }
	
	function afterQuestionValidation(return_data, thisForm, question_id, thisBlock) {
		var question_status_class = (return_data.incorrect_flag == true) ? 'incorrect' : 'correct';
		$(".quiz-pagination ul li[data-actual_question_id='" + question_id + "']").addClass(question_status_class);
        var notifications_settings_show_message = $(".show-notifications").attr('data-show_message');
		if( notifications_settings_show_message == 'yes'){
			var notification_class = (return_data.incorrect_flag == true) ? 'wrong' : 'correct';
			var notification_label = (return_data.incorrect_flag == true) ? 'Thats incorrect, but well done for trying' : 'Well done! Thats exactly right.';
			var notification_sound = (return_data.incorrect_flag == true) ? 'wrong-answer.mp3' : 'correct-answer.mp3';
			thisForm.find('.show-notifications').html('<span class="question-status-'+notification_class+'">'+notification_label+'</span>');
			thisForm.find('.show-notifications').append('<audio autoPlay="" className="player-box-audio" id="audio_file_4492" src="/speech-audio/'+notification_sound+'"></audio>');
		}
		var total_questions = $('.quiz-pagination li').length;
		var attempted_questions = $('.quiz-pagination li.correct, .quiz-pagination li.incorrect').length;
		var correct_questions = $('.quiz-pagination li.correct').length;
		var incorrect_questions = $('.quiz-pagination li.incorrect').length;
		var total_percentage_questions = parseInt(total_questions) * 100 / '{{$target_score}}';
		var correct_percentage = parseInt(correct_questions) * 100 / parseInt(total_percentage_questions);
		var correct_percentage = ( correct_percentage > 0)? correct_percentage : 0;
		$(".quiz-corrects").html(attempted_questions);
		$(".quiz-incorrects").html(incorrect_questions);
		$(".quiz-questions-bar .bar-fill").css('width', Math.round(correct_percentage)+'%');
		$(".quiz-questions-bar .bar-fill").attr('title',Math.round(correct_percentage)+'%');
		$(".total-earned-coins").html(correct_questions);
    }

</script>
