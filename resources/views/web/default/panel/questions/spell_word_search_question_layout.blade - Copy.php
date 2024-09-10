@php $rand_id = rand(999,99999); @endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .rurera-hide{display:none;}
	 /* Style for grid cells */
            .rf-tgrid {
                
                font-family: Arial;
                font-weight: normal;
                font-size: 14px;
                margin: 1px;
                padding: 8px;
            /*    border: 1px solid bisque;*/
                vertical-align: middle;
                text-align: center;

            }

            /* Style for the grid */
            .rf-tablestyle {
                border: 2px solid;
                border-color: black;
                background-color: #eee;
                cursor: pointer;

            }

            /* Style for the div containing the grid */
            #rf-searchgamecontainer {
                float: left;
                padding-right: 50px; 
            }

            /* Style for the div containing the word list */
            #rf-wordcontainer {
                font-family: Arial,sans-serif;
                font-weight: normal;
                font-size: 14px;
                float :left;
                padding-right: 10px; 
                cursor: default;
                margin : 1em 1em 1em 0;
                width : 200px;  
                border: 2px solid;
                border-color: black;
                background-color: #eee;
                cursor: pointer;    
            }

            /* Style for the words that have been found */
            .rf-foundword {
                font-family: Arial,sans-serif;
                text-decoration : line-through;
                color : darkslategray;                
            }

            #rf-tablegrid .rf-armed {
            /*  background: lightcyan;*/
            }

            #rf-tablegrid .rf-highlight {
                background: red;
            }


            #rf-tablegrid .rf-glowing {
                background: gold;
                    
            }

            #rf-tablegrid .rf-selected {
                background: #00ffff;
            }

            /* style for words that didn't make it on the grid */
            .rf-pfalse {
                color: #111;
                visibility: hidden; 
            }

</style>


<div class="question-step quiz-complete" style="display:none">
    <div class="question-layout-block">
        <div class="left-content has-bg">
            <h2>&nbsp;</h2>
            <div id="rureraform-form-1"
                 class="rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable"
                 _data-parent="1"
                 _data-parent-col="0" style="display: block;"></div>
        </div>

    </div>
</div>

@php
$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question->question_layout)))));
$search_tags = ($question->search_tags != '')? explode(' | ', $question->search_tags) : array();
$is_development = (!empty( $search_tags ) && in_array('development', $search_tags))? true : false;

$no_of_words = strlen($correct_answer);
$field_width = ($no_of_words * 1.5);
$question->question_average_time = 0.70;
if( isset( $time_limit )){
 $total_time = gmdate("i:s", $time_limit);
 $question->question_average_time = ($time_limit/60);
}
else{
    $total_time = gmdate("i:s", $question->question_average_time*60);
}
$duration_type = isset( $duration_type )? $duration_type : 'no_time_limit';

$timer_counter = 0;
if( isset( $duration_type ) ){
    if( $duration_type == 'per_question'){
    $timer_counter = $time_interval;
    }
    if( $duration_type == 'total_practice'){
    $timer_counter = $practice_time;
    }
}

$quiz_level = isset( $quiz_level )? $quiz_level : 'easy';
$hidden_indexes = getRandomIndexes($correct_answer);
$characters_list = [];
foreach( $hidden_indexes as $index_no){
	$characters_list[] = substr($correct_answer, $index_no,1);
}
$random_characters = getRandomCharacters($characters_list);
$characters_list = array_merge($characters_list, $random_characters);
shuffle($characters_list);
@endphp
<div class="question-area spell-question-area">
    <div class="correct-appriciate" style="display:none"></div>
    <div class="question-step question-step-{{ $question->id }}" data-time_counter="{{$timer_counter}}" data-elapsed="0"
         data-qattempt="{{isset( $quizAttempt->id )? $quizAttempt->id : 0}}"
         data-start_time="0" data-qresult="{{isset( $newQuestionResult->id )? $newQuestionResult->id : 0}}"
         data-quiz_result_id="{{isset( $quizAttempt->quiz_result_id )? $quizAttempt->quiz_result_id : 0}}">
        <div class="question-layout-block">

            <form class="question-fields" action="javascript:;" data-defination="{{isset($word_data['audio_defination'])? $word_data['audio_defination'] : ''}}" data-question_id="{{ $question->id }}">
                <div class="spells-quiz-info">
                    <ul>
                        <li class="show-correct-answer">
                            <span>{{$question_no}}</span> Of {{$total_questions_count}}
                        </li>
                        <li>
                            <span class="nub-of-sec question-time-remaining-{{ $question->id }}" data-remaining="{{($question->question_average_time*60)}}">{{$total_time}}</span>
                        </li>
                        <li class="total-points" data-total_points="{{isset( $total_points )? $total_points : 0}}">
                            <span>{{isset( $total_points )? $total_points : 0}}</span> Coins
                        </li>
                    </ul>
                </div>
                <div class="left-content has-bg">
                <div class="spells-quiz-sound">
                    <strong>Hear It: <a href="javascript:;"  id="sound-icon-{{ $question->id }}" data-id="audio_file_{{ $question->id }}" class="play-btn sound-icon pause">
                      <img class="play-icon" src="/assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
                      <img class="pause-icon" src="/assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
                    </a></strong>
                </div>
                <div class="player-box">
                   <audio  class="player-box-audio" id="audio_file_{{ $question->id }}" src="{{isset($word_data['audio_file'])? $word_data['audio_file'] : ''}}"> </audio>
                </div>
                <div class="spells-quiz-from question-layout">
                    <div class="form-field">
					
						{{$correct_answer}}
                        <input type="text" class="editor-field hide" data-field_id="{{$field_id}}" data-id="{{$field_id}}" id="field-{{$field_id}}">
						<div id="rurera-words-search" class="rurera-words-search-{{ $question->id }}" width="100%"></div>
                    </div>



                    <div class="question-correct-answere rurera-hide">
                        {{$correct_answer}} - {{$question->id}}
                    </div>


                    <div class="form-btn-field">
                        <button type="button" class="question-review-btn" data-id="{{ $question->id }}">Finish</button>
                        <button type="submit" class="question-submit-btn">Enter</button>
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

                    <div class="prev-next-controls text-center mb-50 questions-nav-controls  rurera-hide">
                        @if( !isset( $disable_finish ) || $disable_finish == 'false')
                        <a href="javascript:;" id="review-btn_{{ $question->id }}" data-toggle="modal" class="review-btn" data-target="#review_submit">
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
                        @endif
                        @php $prev_class = (isset( $prev_question ) && $prev_question > 0)? '' : 'disable-btn'; @endphp
                        @if( !isset( $disable_prev ) || $disable_prev == 'false')
                        <a href="javascript:;" id="prev-btn" class="{{$prev_class}} prev-btn" data-question_id="{{$prev_question}}">
                            <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                 width="512.000000pt" height="512.000000pt"
                                 viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                            d="M3620 5103 c-39 -13 -198 -168 -1238 -1207 -1095 -1093 -1194 -1195 -1212 -1244 -25 -67 -25 -117 0 -184 18 -49 117 -151 1212 -1244 1141 -1140 1195 -1193 1247 -1209 214 -69 408 147 315 352 -11 25 -377 398 -1093 1115 l-1076 1078 1076 1077 c701 703 1082 1091 1093 1115 61 135 -4 297 -140 348 -64 23 -121 24 -184 3z"></path>
                                </g>
                            </svg>
                        </a>
                        @endif
                        @php $next_class = (isset( $next_question ) && $next_question > 0)? '' : 'disable-btn'; @endphp
                        @if( !isset( $disable_next ) || $disable_next == 'false')
                        <a href="javascript:;" id="next-btn" class="{{$next_class}} next-btn" data-question_id="{{$next_question}}">
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
                        @else
                        <a href="javascript:;" id="next-btn" class="{{$next_class}} next-btn rurera-hide" data-question_id="{{$next_question}}" data-actual_question_id="{{$next_question}}">&nbsp;</a>
                        @endif
                        @if( !isset( $disable_submit ) || $disable_submit == 'false')
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



                        @endif
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>


<script>

	/*$(document).ready(function() {
		const draggableItems = document.querySelectorAll('.draggable');
		const dropTargets = document.getElementsByClassName('drop-target{{ $question->id }}');
		

		draggableItems.forEach(item => {
			item.addEventListener('dragstart', (event) => {
				event.dataTransfer.setData('text/plain', event.target.id);
			});
		});

		Array.from(dropTargets).forEach(dropTarget => {
			dropTarget.addEventListener('dragover', (event) => {
				event.preventDefault(); // Necessary to allow drop
			});
		});
		
		Array.from(dropTargets).forEach(dropTarget => {
			dropTarget.addEventListener('drop', (event) => {
				const id = event.dataTransfer.getData('text/plain');
				console.log('sdfsdfsdfsdf');
				const draggedElement = document.getElementById(id);
				console.log(draggedElement.innerHTML);
				if (draggedElement) {
					dropTarget.value  = draggedElement.innerHTML;
				}
			});
		});
	});*/
	
    var currentFunctionStart = null;
    var Questioninterval = null;

    var hint_counter = 0;
    var charPosition = 0;
    var userInput = false;
    var excludeArray = [];
    var ansCorr = '{{$correct_answer}}';
    var ansCharactersCount = ansCorr.length;
    var SpellQuestionintervalCountDownFunc = function() {
             currentFunctionStart = 'started';
            Questioninterval = setInterval(function () {
                var seconds_count_done = $(".question-step-{{ $question->id }}").attr('data-elapsed');
                hint_counter = parseInt(hint_counter) + parseInt(1);
                var quiz_level = '{{$quiz_level}}';
                seconds_count_done = parseInt(seconds_count_done) + parseInt(1);
                $(".question-step-{{ $question->id }}").attr('data-elapsed', seconds_count_done);
            }, 1000);

        }

    $(document).on('keyup', ".question-step-{{ $question->id }} .editor-field", function (e) {
        userInput = false;
        hint_counter = 0;
    });

    $(document).on('input keydown paste', ".editor-field-inputs", function (event) {
        var $this = $(this);
        var value = $this.val();

        if (event.type === 'paste') {
            event.preventDefault(); // Prevent default paste behavior

            // Get the pasted text
            var pastedText = (event.originalEvent || event).clipboardData.getData('text');

            // Split the pasted text into individual characters
            var characters = pastedText.split('');

            // Distribute each character into successive input fields
            characters.forEach(function(char) {
                $this.val(char);
                $this = $this.next('.editor-field-inputs');
            });

            // Ensure focus is on the last input field
            $this.focus();
        } else if ((event.type === 'input' || event.type === 'keydown') && value.length === 1) {
            $this.next('.editor-field-inputs').focus();
        } else if (event.type === 'keydown' && event.which === 8 && value === "") {
            $this.prev('.editor-field-inputs').focus();
        }
    });
	
	
	
	
	






    function getRandomNumberNotInArray(maxNumber, excludeArray) {
      var randomNumber;
      do {
        randomNumber = Math.floor(Math.random() * parseInt(maxNumber)); // Generate random number from 0 to 8
      } while (excludeArray.includes(randomNumber)); // Repeat if the number is in the array

      return randomNumber;
    }


</script>
<script type="text/javascript">
    window.onload = function() {
      var context = new AudioContext();
    }

    $(document).on('click', '.show-correct-answer', function (e) {
        $(this).closest('.spell-question-area').find('.question-correct-answere').removeClass('rurera-hide');

    });

    $(document).on('click', '#sound-icon-{{ $question->id }}', function (e) {
        var context = new AudioContext();
        $('.editor-field-inputs:eq(0)').focus();
        //$('#field-{{$field_id}}').focus();
        if( currentFunctionStart == null) {
            SpellQuestionintervalCountDownFunc();
        }
        //SpellQuestionintervalFunc();
        var player_id = $(this).attr('data-id');
        

        $(this).toggleClass("pause");
        if ($(this).hasClass('pause')) {
            document.getElementById(player_id).play();
        } else {
            document.getElementById(player_id).pause();
        }
    });
    var audio = document.getElementById("audio_file_{{ $question->id }}");

    audio.addEventListener('ended', function () {
        $('#sound-icon-{{ $question->id }}').toggleClass("pause");
    });

    $(document).on('click', '.start-spell-quiz', function (e) {
    //jQuery(document).ready(function() {

        console.log('focus-field');

        $('.editor-field-inputs:eq(0)').focus();
        //$('#field-{{$field_id}}').focus();
        $('#sound-icon-{{ $question->id }}').click();
          var $keyboardWrapper = $('.virtual-keyboard'),
          $key = $keyboardWrapper.find("input"),
          $key_delete = $('.delete'),
          $key_shift = $('.shift'),
          $outputField = $('#field-{{$field_id}}'),
          $currentValue = $outputField.val(),
          actionKeys = $(".delete,.shift")
          activeShiftClass = "shift-activated";

          function _keystroke(keyCase){
            $key.not(actionKeys).on('click',function(e){
              e.preventDefault();

              if($key_shift.hasClass(activeShiftClass)){
                keyCase = 'upper';
                $key_shift.removeClass(activeShiftClass);
              }else{
                keyCase = 'lower';
              }

              if(keyCase == 'upper'){
                var keyValue = $(this).val().toUpperCase();
              }else{
                var keyValue = $(this).val().toLowerCase();
              }

              var output = $('#field-{{$field_id}}').val();
                  $outputField.val(output + keyValue);
                  getCurrentVal();
                  focusOutputField();
            });

            }
            $key_delete.on('click',function(e){
            e.preventDefault();
            $outputField.val($currentValue.substr(0,$currentValue.length - 1));
            getCurrentVal();
            focusOutputField();
            });

            $key_shift.on('click',function(e){
            e.preventDefault();
            $(this).toggleClass(activeShiftClass);
            });

            function getCurrentVal(){
            $currentValue = $outputField.val();
            }

            function focusOutputField(){
            $outputField.focus();
            }

            _keystroke("lower");
        });
		
		

(function( $, undefined ) {
    
    $.widget("ryanf.wordsearchwidget", $.ui.mouse, {

            options : {
                wordlist : null,
                gridsize : 10
            },
            _mapEventToCell: function(event) {
                var currentColumn = Math.ceil((event.pageX - this._cellX) / this._cellWidth);
                var currentRow = Math.ceil((event.pageY - this._cellY) / this._cellHeight);
                var el = $('#rf-tablegrid tr:nth-child('+currentRow+') td:nth-child('+currentColumn+')');
                return el;
            },
            
            _create : function () {
                //member variables
                this.model      = GameWidgetHelper.prepGrid(this.options.gridsize, this.options.wordlist)
                this.startedAt  = new Root();
                this.hotzone    = new Hotzone();
                this.arms       = new Arms();
                
                
                GameWidgetHelper.renderGame(this.element[0],this.model);
                
                this.options.distance=0; // set mouse option property
                this._mouseInit();
                
                var cell = $('#rf-tablegrid tr:first td:first');
        this._cellWidth = cell.outerWidth();
        this._cellHeight = cell.outerHeight();
        this._cellX = cell.offset().left;
        this._cellY = cell.offset().top;
            },//_create
            
            destroy : function () {
                
                this.hotzone.clean();
                this.arms.clean();
                this.startedAt.clean();
                
                this._mouseDestroy();
                return this;
                
            },
            
            //mouse callbacks
            _mouseStart: function(event) {
                
                var panel = $(event.target).parents("div").attr("id");
                if ( panel == 'rf-searchgamecontainer') {
                    this.startedAt.setRoot( event.target );
                    this.hotzone.createZone( event.target )
                }
                else if ( panel == 'rf-wordcontainer') {
                    //User has requested help. Identify the word on the grid
                    //We have a reference to the td in the cells that make up this word
                    var idx = $(event.target).parent().children().index(event.target);

                    var selectedWord = this.model.wordList.get(idx);
                    $(selectedWord.cellsUsed).each ( function () {
                        Visualizer.highlight($(this.td));
                    });
                    
                }

            },
            
            _mouseDrag : function(event) {
                event.target = this._mapEventToCell(event); 
                //if this.root - clear out everything and return to orignal clicked state
                if (this.startedAt.isSameCell(event.target)) {
                    this.arms.returnToNormal();
                    this.hotzone.setChosen(-1);
                    return;
                }
                
                //if event is on an armed cell
                if ($(event.target).hasClass("rf-armed") || $(event.target).hasClass("rf-glowing") ) { //CHANGE! 
                    
                    //if in hotzone
                    var chosenOne = this.hotzone.index(event.target);
                    if (chosenOne!= -1) {
                        //set target to glowing; set rest of hotzone to armed
                        this.hotzone.setChosen(chosenOne);
                        
                        //calculate arms and set to armed
                        this.arms.deduceArm(this.startedAt.root, chosenOne);
                        
                        
                    }else { //in arms
                        //set glowing from target to root
                        this.arms.glowTo(event.target)
                    }
                }
                
            },
            
            _mouseStop : function (event) {

                //get word
                var selectedword = '';
                $('.rf-glowing, .rf-highlight', this.element[0]).each(function() {
                        var u = $.data(this,"cell");
                        selectedword += u.value;
                });

                var wordIndex = this.model.wordList.isWordPresent(selectedword)
                if (wordIndex!=-1) {
                    $('.rf-glowing, .rf-highlight', this.element[0]).each(function() {
                            Visualizer.select(this);
                            $.data(this,"selected", "true");

                    });
                    GameWidgetHelper.signalWordFound(wordIndex);
                }

                this.hotzone.returnToNormal();
                this.startedAt.returnToNormal();
                this.arms.returnToNormal();
            }
            
        }
    ); //widget


$.extend($.ryanf.wordsearchwidget, {
    version: "0.0.1"
});

//------------------------------------------------------------------------------
// VIEW OBJECTS 
//------------------------------------------------------------------------------
/*
 * The Arms represent the cells that are selectable once the hotzone has been 
 * exited/passed
 */
function Arms() {
    this.arms = null;

    //deduces the arm based on the cell from which it exited the hotzone.
    this.deduceArm = function (root, idx) {

        this.returnToNormal(); //clear old arm
        var ix = $(root).parent().children().index(root);

        //create the new nominees
        this.arms = new Array();

        //create surrounding nominees
        switch (idx) {
            case 0: //horizontal left
                this.arms = $(root).prevAll();
                break;

            case 1: //horizontal right
                this.arms = $(root).nextAll();
                break;

            case 2: //vertical top
                var $n = this.arms;
                $(root).parent().prevAll().each( function() {
                    $n.push($(this).children().get(ix));
                });
                
                break;

            case 3: //vertical bottom
                var $o = this.arms;
                $(root).parent().nextAll().each( function() {
                    $o.push($(this).children().get(ix));
                });
                break;

            case 4: //right diagonal up
                
                var $p = this.arms;

                //for all prevAll rows
                var currix = ix;
                $(root).parent().prevAll().each( function () {
                    $p.push($(this).children().get(++currix));
                });
                break;

            case 5: //left diagonal up
                var $q = this.arms;

                //for all prevAll rows
                var currixq = ix;
                $(root).parent().prevAll().each( function () {
                    $q.push($(this).children().get(--currixq));
                });
                break;

            case 6 : //left diagonal down
                var $r = this.arms;
                //for all nextAll rows
                var currixr = ix;
                $(root).parent().nextAll().each( function () {
                    $r.push($(this).children().get(++currixr));
                });
                break;

            case 7: //right diagonal down
                var $s = this.arms;
                //for all nextAll rows
                var currixs = ix;
                $(root).parent().nextAll().each( function () {
                    $s.push($(this).children().get(--currixs));
                });
                break;


        }
        for (var x=1;x<this.arms.length;x++) {
            Visualizer.arm(this.arms[x]);
        }
    }

    //lights up the cells that from the root cell tothe current one
    this.glowTo = function (upto) {
        var to = $(this.arms).index(upto);
        
        for (var x=1;x<this.arms.length;x++) {
            
            if (x<=to) {
                Visualizer.glow(this.arms[x]);
            }
            else {
                Visualizer.arm(this.arms[x]);

            }
        }
    }
    
    //clear out the arms 
    this.returnToNormal = function () {
        if (!this.arms) return;
        
        for (var t=1;t<this.arms.length;t++) { //don't clear the hotzone
            Visualizer.restore(this.arms[t]);
        }
    }
    
    
    this.clean = function() {
        $(this.arms).each(function () {
           Visualizer.clean(this); 
        });
    }
 
}

/*
 * Object that represents the cells that are selectable around the root cell
 */
function Hotzone() {
    
    this.elems = null;
    
    //define the hotzone
    //select all neighboring cells as nominees
    this.createZone = function (root) {
        this.elems = new Array(); 
        
        var $tgt = $(root);
        var ix = $tgt.parent().children().index($tgt);

        var above = $tgt.parent().prev().children().get(ix); // above
        var below = $tgt.parent().next().children().get(ix); // below

        //nominatedCells.push(event.target); // self
        this.elems.push($tgt.prev()[0],$tgt.next()[0]); //horizontal
        this.elems.push( above, below, 
                            $(above).next()[0],$(above).prev()[0], //diagonal
                            $(below).next()[0],$(below).prev()[0] //diagonal
                          );


        $(this.elems).each( function () {
            if ($(this)!=null) {
                Visualizer.arm(this);
            }
        });
        
    }
    //give the hotzone some intelligence
    this.index = function (elm) {
        return $(this.elems).index(elm);
    }

    this.setChosen = function (chosenOne) {
        for (var x=0;x<this.elems.length;x++) {
            Visualizer.arm(this.elems[x]);
        }
        if (chosenOne != -1) {
            Visualizer.glow(this.elems[chosenOne]);
        }

    }

    this.returnToNormal = function () {

        for (var t=0;t<this.elems.length;t++) {
            Visualizer.restore(this.elems[t]);
        }
    }
    
    this.clean = function() {
        $(this.elems).each(function () {
           Visualizer.clean(this); 
        });
    }
    
}

/*
 * Object that represents the first cell clicked
 */
function Root() {
    this.root = null;
    
    this.setRoot = function (root) {
        this.root = root;
        Visualizer.glow(this.root);
    }
    
    this.returnToNormal = function () {
        Visualizer.restore(this.root);
    }
    
    this.isSameCell = function (t) {
        return $(this.root).is($(t));
    }
    
    this.clean = function () {
        Visualizer.clean(this.root);
    }
    
}

/*
 * A utility object that manipulates the cell display based on the methods called.
 */
var Visualizer = {
    
    glow : function (c) {
        $(c).removeClass("rf-armed")
            .removeClass("rf-selected")
            .addClass("rf-glowing");
    },
    
    arm : function (c) {
        $(c)//.removeClass("rf-selected")
            .removeClass("rf-glowing")
            .addClass("rf-armed");
        
    },
    
    restore : function (c) {
        $(c).removeClass("rf-armed")
            .removeClass("rf-glowing");
            
        if ( c!=null && $.data(c,"selected") == "true" ) {
            $(c).addClass("rf-selected");
        }
    },
    
    select : function (c) {
        $(c).removeClass("rf-armed")
            .removeClass("rf-glowing")
            .animate({'opacity' : '20'}, 500, "linear", function () {
                $(c).removeClass("rf-highlight").addClass("rf-selected")
                .animate({'opacity' : 'show'}, 500, "linear")
            })
            
        
    },
    
    highlight : function (c) {
        $(c).removeClass("rf-armed")
            .removeClass("rf-selected")
            .addClass("rf-highlight");
    },
    
    signalWordFound : function (w) {

        $(w).css("background",'yellow').animate({"opacity": 'hide'},1000,"linear",
                     function () {
                         $(w).css("background",'white')
                         $(w).addClass('rf-foundword').animate({"opacity": 'show'},1000,"linear")
                     });
    },

    


    clean : function (c) {
        $(c).removeClass("rf-armed")
            .removeClass("rf-glowing")
            .removeClass("rf-selected");
            
        $.removeData($(c),"selected");    
        
    }
}

//--------------------------------------------------------
// OBJECTS RELATED TO THE MODEL
//------------------------------------------------------------------------------

/*
 * Represents the individual cell on the grid
 */
function Cell() {
    this.DEFAULT = "-";
    this.isHighlighted = false;
    this.value = this.DEFAULT;
    this.parentGrid = null;
    this.isUnwritten = function () {
        return (this.value == this.DEFAULT);
    };
    this.isSelected = false;
    this.isSelecting = true;
    this.td = null; // reference to UI component

    
}//Cell

/*
 * Represents the Grid
 */
function Grid() {
    this.cells = null;
    
    this.directions = [
                "LeftDiagonal",
                "Horizontal",
                "RightDiagonal",
                "Vertical"
                      ];
    
    this.initializeGrid= function(size) {
        this.cells = new Array(size);
        for (var i=0;i<size;i++) {
            this.cells[i] = new Array(size);
            for (var j=0;j<size;j++) {
                var c = new Cell();
                c.parentgrid = this;
                this.cells[i][j] = c;
            }
        }
    }
    
    
    this.getCell = function(row,col) {
        return this.cells[row][col];
    }
    
    this.createHotZone = function(uic) {
        var $tgt = uic;

        var hzCells = new Array(); 
        var ix = $tgt.parent().children().index($tgt);

    }
    
    this.size = function() {
        return this.cells.length;
    }
    
    //place word on grid at suggested location
    this.put = function(row, col, word) {
        //Pick the right Strategy to place the word on the grid
        var populator = eval("new "+ eval("this.directions["+Math.floor(Math.random()*4)+"]") +"Populator(row,col,word, this)");
        var isPlaced= populator.populate();
        
        //Didn't get placed.. brute force-fit (if possible)
        if (!isPlaced) {
            for (var x=0;x<this.directions.length;x++) {
                var populator2 = eval("new "+ eval("this.directions["+x+"]") +"Populator(row,col,word, this)");
                var isPlaced2= populator2.populate();
                if (isPlaced2) break;
                
            }
            
        }
    }
    
    this.fillGrid = function() {
   
    for (var i=0;i<this.size();i++) {
        for (var j=0;j<this.size();j++) {
            if (this.cells[i][j].isUnwritten()) {
                this.cells[i][j].value = String.fromCharCode(Math.floor(65+Math.random()*26));
            }
        }
    }
        
    }

}//Grid

/*
 * Set of strategies to populate the grid.
 */
//Create a Horizontal Populator Strategy 
function HorizontalPopulator(row, col, word, grid) {
    
    this.grid = grid;
    this.row =  row;
    this.col = col;
    this.word = word;
    this.size = this.grid.size();
    this.cells = this.grid.cells;
    
    //populate the word
    this.populate = function() {
        

        // try and place word in this row

        // check if this row has a contigous block free
        // 1. starting at col (honour the input)
        if (this.willWordFit()) {
            this.writeWord();
        }
        else {

            // for every row - try to fit this
            for (var i=0;i<this.size;i++) {

                var xRow = (this.row+i)%this.size; // loop through all rows starting at current;

                // 2. try starting anywhere on line
                var startingPoint = this.findContigousSpace(xRow, word);

                if (startingPoint == -1) {
                    // if not, then try to see if we can overlap this word only any existing alphabets
                    var overlapPoint = this.isWordOverlapPossible(xRow, word);
                    if (overlapPoint == -1) {
                        // if not, then try another row and repeat process,
                        continue;
                    }
                    else {
                        this.row = xRow;
                        this.col = overlapPoint;
                        this.writeWord();
                        break;
                    }
                }
                else {
                    this.row = xRow;
                    this.col = startingPoint;
                    this.writeWord();
                    break;
                }
            }//for each row
        }
        // if still not, then return false (i.e. not placed. we need to try another direction
        return (word.isPlaced);
            
        
    }//populate

    
    //write word on grid at given location
    //also remember which cells were used for displaying the word
    this.writeWord = function () {

        var chars = word.chars;
        for (var i=0;i<word.size;i++) {
            var c = new Cell();
            c.value = chars[i];
            this.cells[this.row][this.col+i] = c;
            word.containedIn(c);
            word.isPlaced = true;
        }

    }

    //try even harder, check if this word can be placed by overlapping cells with same content
    this.isWordOverlapPossible = function (row, word) {
        return -1; //TODO: implement
    }

    //check if word will fit at the chosen location
    this.willWordFit = function() {
        var isFree = false;
        var freeCounter=0;
        var chars = this.word.chars;
        for (var i=col;i<this.size;i++) {
            if (this.cells[row][i].isUnwritten() || this.cells[row][i] == chars[i] ) {
                freeCounter++;
                if (freeCounter == word.size) {
                    isFree = true;
                    break;
                }
            }
            else {
                break;
            }
        }
        return isFree;
    }
    
    //try harder, check if there is contigous space anywhere on this line.
    this.findContigousSpace = function (row, word) {
        var freeLocation = -1;
        var freeCounter=0;
        var chars = word.chars;
        for (var i=0;i<this.size;i++) {
            if (this.cells[row][i].isUnwritten() || this.cells[row][i] == chars[i]) {
                freeCounter++;
                if (freeCounter == word.size) {
                    freeLocation = (i - (word.size-1));
                    break;
                }
            }
            else {
                freeCounter=0;
            }
        }
        return freeLocation;
        
    }
}//HorizontalPopulator


//Create a Vertical Populator Strategy 
function VerticalPopulator(row, col, word, grid) {
    
    this.grid = grid;
    this.row =  row;
    this.col = col;
    this.word = word;
    this.size = this.grid.size();
    this.cells = this.grid.cells;
    
    //populate the word
    this.populate = function() {
        

        // try and place word in this row

        // check if this row has a contigous block free
        // 1. starting at col (honour the input)
        if (this.willWordFit()) {
            this.writeWord();
        }
        else {

            // for every row - try to fit this
            for (var i=0;i<this.size;i++) {

                var xCol = (this.col+i)%this.size; // loop through all rows starting at current;

                // 2. try starting anywhere on line
                var startingPoint = this.findContigousSpace(xCol, word);

                if (startingPoint == -1) {
                    // if not, then try to see if we can overlap this word only any existing alphabets
                    var overlapPoint = this.isWordOverlapPossible(xCol, word);
                    if (overlapPoint == -1) {
                        // if not, then try another row and repeat process,
                        continue;
                    }
                    else {
                        this.row = overlapPoint;
                        this.col = xCol;
                        this.writeWord();
                        break;
                    }
                }
                else {
                    this.row = startingPoint;
                    this.col = xCol;
                    this.writeWord();
                    break;
                }
            }//for each row
        }
        // if still not, then return false (i.e. not placed. we need to try another direction
        return (word.isPlaced);
            
        
    }//populate

    
    //write word on grid at given location
    this.writeWord = function () {

        var chars = word.chars;
        for (var i=0;i<word.size;i++) {
            var c = new Cell();
            c.value = chars[i];
            this.cells[this.row+i][this.col] = c; //CHANGED
            word.containedIn(c);
            word.isPlaced = true;
        }
        
    }

    //try even harder, check if this word can be placed by overlapping cells with same content
    this.isWordOverlapPossible = function (col, word) {
        return -1; //TODO: implement
    }

    //check if word will fit at the chosen location
    this.willWordFit = function() {
        var isFree = false;
        var freeCounter=0;
        var chars = this.word.chars;
        for (var i=row;i<this.size;i++) { // CHANGED
            if (this.cells[i][col].isUnwritten() || chars[i] == this.cells[i][col].value) { //CHANGED
                freeCounter++;
                if (freeCounter == word.size) {
                    isFree = true;
                    break;
                }
            }
            else {
                break;
            }
        }
        return isFree;
    }
    
    //try harder, check if there is contigous space anywhere on this line.
    this.findContigousSpace = function (col, word) {
        var freeLocation = -1;
        var freeCounter=0;
        var chars = word.chars;
        for (var i=0;i<this.size;i++) {
            if (this.cells[i][col].isUnwritten() || chars[i] == this.cells[i][col].value) { //CHANGED
                freeCounter++;
                if (freeCounter == word.size) {
                    freeLocation = (i - (word.size-1));
                    break;
                }
            }
            else {
                freeCounter=0;
            }
        }
        return freeLocation;
        
    }
}//VerticalPopulator


//Create a LeftDiagonal Populator Strategy 
function LeftDiagonalPopulator(row, col, word, grid) {
    
    this.grid = grid;
    this.row =  row;
    this.col = col;
    this.word = word;
    this.size = this.grid.size();
    this.cells = this.grid.cells;
    
    //populate the word
    this.populate = function() {
        

        // try and place word in this row

        // check if this row has a contigous block free
        // 1. starting at col (honour the input)
        if (this.willWordFit()) {
            this.writeWord();
        }
        else {

            var output = this.findContigousSpace(this.row,this.col, word);

            if (output[0] != true) {
                
                // for every row - try to fit this
                OUTER:for (var col=0, row=(this.size-word.size); row>=0; row--) {
                    for (var j=0;j<2;j++) {

                        var op = this.findContigousSpace( (j==0)?row:col, (j==0)?col:row, word);

                        if (op[0] == true) {
                            this.row = op[1];
                            this.col = op[2];
                            this.writeWord();
                            break OUTER;
                        }
                    }
                    
                }
           }
            else {
                this.row = output[1];
                this.col = output[2];
                this.writeWord();
            }


        }
        // if still not, then return false (i.e. not placed. we need to try another direction
        return (word.isPlaced);
            
        
    }//populate

    
    //write word on grid at given location
    //also remember which cells were used for displaying the word
    this.writeWord = function () {

        var chars = word.chars;
        var lrow = this.row;
        var lcol = this.col;
        for (var i=0;i<word.size;i++) {
            var c = new Cell();
            c.value = chars[i];
            this.cells[lrow++][lcol++] = c;
            word.containedIn(c);
            word.isPlaced=true;
        }

    }

    //try even harder, check if this word can be placed by overlapping cells with same content
    this.isWordOverlapPossible = function (row, word) {
        return -1; //TODO: implement
    }

    //check if word will fit at the chosen location
    this.willWordFit = function() {
        var isFree = false;
        var freeCounter=0;
        var chars = this.word.chars;
        var lrow = this.row;
        var lcol = this.col;
        var i=0;
        while (lcol < this.grid.size() && lrow < this.grid.size()) {
            if (this.cells[lrow][lcol].isUnwritten() || this.cells[lrow][lcol] == chars[i++] ) {
                freeCounter++;
                if (freeCounter == word.size) {
                    isFree = true;
                    break;
                }
            }
            else {
                break;
            }
            lrow++;
            lcol++;
            
        }
        return isFree;
    }
    
    //try harder, check if there is contigous space anywhere on this line.
    this.findContigousSpace = function (xrow, xcol,word) {
        var freeLocation = false;
        var freeCounter=0;
        var chars = word.chars;
        var lrow = xrow;
        var lcol = xcol;
        
        while (lrow > 0 && lcol > 0) {
            lrow--;
            lcol--;
        }
        var i=0;
        while (true) {
            if (this.cells[lrow][lcol].isUnwritten() || this.cells[lrow][lcol] == chars[i++]) {
                freeCounter++;
                if (freeCounter == word.size) {
                    freeLocation = true;
                    break;
                }
            }
            else {
                freeCounter=0;
            }
            lcol++;
            lrow++;
            
            if (lcol >= this.size || lrow >= this.size) {
                break;
            }
        }
        if (freeLocation) {
            lrow = lrow - word.size+1;
            lcol = lcol - word.size+1;
        }
        return [freeLocation,lrow,lcol];
        
    }
}//LeftDiagonalPopulator


//Create a RightDiagonal Populator Strategy 
function RightDiagonalPopulator(row, col, word, grid) {
    
    this.grid = grid;
    this.row =  row;
    this.col = col;
    this.word = word;
    this.size = this.grid.size();
    this.cells = this.grid.cells;
    
    //populate the word
    this.populate = function() {
        

        // try and place word in this row

        // check if this row has a contigous block free
        // 1. starting at col (honour the input)
        var rr=0;
        if (this.willWordFit()) {
            this.writeWord();
        }
        else {

            var output = this.findContigousSpace(this.row,this.col, word);

            if (output[0] != true) {
                
                // for every row - try to fit this
                OUTER:for (var col=this.size-1, row=(this.size-word.size); row>=0; row--) {
                    for (var j=0;j<2;j++) {

                        var op = this.findContigousSpace( (j==0)?row:(this.size-1-col), (j==0)?col:(this.size-1-row), word);

                        if (op[0] == true) {
                            this.row = op[1];
                            this.col = op[2];
                            this.writeWord();
                            break OUTER;
                        }
                    }
                    
                }
           }
            else {
                this.row = output[1];
                this.col = output[2];
                this.writeWord();
            }


        }
        // if still not, then return false (i.e. not placed. we need to try another direction
        return (word.isPlaced);
            
        
    }//populate

    
    //write word on grid at given location
    //also remember which cells were used for displaying the word
    this.writeWord = function () {

        var chars = word.chars;
        var lrow = this.row;
        var lcol = this.col;
        for (var i=0;i<word.size;i++) {
            var c = new Cell();
            c.value = chars[i];
            this.cells[lrow++][lcol--] = c;
            word.containedIn(c);
            word.isPlaced = true;
        }

    }

    //try even harder, check if this word can be placed by overlapping cells with same content
    this.isWordOverlapPossible = function (row, word) {
        return -1; //TODO: implement
    }

    //check if word will fit at the chosen location
    this.willWordFit = function() {
        var isFree = false;
        var freeCounter=0;
        var chars = this.word.chars;
        var lrow = this.row;
        var lcol = this.col;
        var i=0;
        while (lcol >= 0 && lrow < this.grid.size()) {
            if (this.cells[lrow][lcol].isUnwritten() || this.cells[lrow][lcol] == chars[i++] ) {
                freeCounter++;
                if (freeCounter == word.size) {
                    isFree = true;
                    break;
                }
            }
            else {
                break;
            }
            lrow++;
            lcol--;
            
        }
        return isFree;
    }
    
    //try harder, check if there is contigous space anywhere on this line.
    this.findContigousSpace = function (xrow, xcol,word) {
        var freeLocation = false;
        var freeCounter=0;
        var chars = word.chars;
        var lrow = xrow;
        var lcol = xcol;
        
        while (lrow > 0 && lcol < this.size-1) {
            lrow--;
            lcol++;
        }
        var i=0;
        while (lcol >= 0 && lrow < this.grid.size()) {
            if (this.cells[lrow][lcol].isUnwritten() || this.cells[lrow][lcol] == chars[i++]) {
                freeCounter++;
                if (freeCounter == word.size) {
                    freeLocation = true;
                    break;
                }
            }
            else {
                freeCounter=0;
            }
            lrow++;
            lcol--;
//            if (lcol <= 0 || lrow > this.size-1) {
//                break;
//            }
        }
        if (freeLocation) {
            lrow = lrow - word.size+1;
            lcol = lcol + word.size-1;
        }
        return [freeLocation,lrow,lcol];
        
    }
}//RightDiagonalPopulator

/*
 * Container for the Entire Model
 */
function Model() {
    this.grid= null;
    this.wordList= null;
    
    this.init = function(grid,list) {
        this.grid = grid;
        this.wordList = list;
    
        for (var i=0;i<this.wordList.size();i++) {
            grid.put( Util.random(this.grid.size()), Util.random(this.grid.size()), this.wordList.get(i) );
        }

    }
    
}//Model

/*
 * Represents a word on the grid
 */
function Word(val) {
    this.value = val.toUpperCase();
    this.originalValue = this.value;
    this.isFound= false;
    this.cellsUsed = new Array();

    this.isPlaced = false;
    this.row = -1;
    this.col = -1;
    this.size = -1;
    this.chars = null;

    this.init = function () {
        this.chars = this.value.split("");
        this.size = this.chars.length;
    }
    this.init();
    
    this.containedIn = function (cell) {
        this.cellsUsed.push(cell);
    }
    
    
    
    this.checkIfSimilar = function (w) {
        if (this.originalValue == w || this.value == w) {
            this.isFound = true;
			$(".editor-field").val(w);
			$('#question-submit-btn')[0].click();
            return true;
        }else{
			this.isFound = true;
			$(".editor-field").val(w);
			$('#question-submit-btn')[0].click();
            return true;
		}
        //return false;
    }
    

}

/*
 * Represents the list of words to display
 */
function WordList() {
    this.words = new Array();
    
    this.loadWords = function (csvwords) {
        var $n = this.words;
        $(csvwords.split(",")).each(function () {
            $n.push(new Word(this));
        });
        
    }
    
    this.add = function(word) {
        //here's where we reverse the letters randomly
        if (Math.random()*10 >5) {
            var s="";
            for (var i=word.size-1;i>=0;i--) {
                s = s+ word.value.charAt(i);
            }
            word.value = s;
            word.init();
        }
        this.words[this.words.length] = word;
    }
    
    this.size = function() {
        return this.words.length;
    }
    
    this.get = function(index) {
        return this.words[index];
    }
    
    this.isWordPresent = function(word2check) {
        for (var x=0;x<this.words.length;x++) {
            if (this.words[x].checkIfSimilar(word2check)) return x;
        }
        return -1;
    }
}

/*
 * Utility class
 */
var Util = {
    random : function(max) {
        return Math.floor(Math.random()*max);
    },
    
    log : function (msg) {
        $("#logger").append(msg);
    }
} 


//------------------------------------------------------------------------------
// OBJECTS RELATED TO THE CONTROLLER
//------------------------------------------------------------------------------
/*
 * Main controller that interacts with the Models and View Helpers to render and
 * control the game
 */
var GameWidgetHelper = {
    prepGrid : function (size, words) {
        var grid = new Grid();
        grid.initializeGrid(size);

        var wordList = new WordList();
        wordList.loadWords(words);

        var model = new Model();
        model.init(grid, wordList);
        grid.fillGrid();
        return model;

    },
    
    renderGame : function(container, model) {
        var grid = model.grid;
        var cells = grid.cells;
        
        
        var puzzleGrid = "<div id='rf-searchgamecontainer'><table id='rf-tablegrid' cellspacing=0 cellpadding=0 class='rf-tablestyle'>";
        for (var i=0;i<grid.size();i++) {
            puzzleGrid += "<tr>";
            for (var j=0;j<grid.size();j++) {
                puzzleGrid += "<td  class='rf-tgrid'>"+cells[i][j].value+"</td>";
            }
            puzzleGrid += "</tr>";
        }
        puzzleGrid += "</table></div>";
        $(container).append(puzzleGrid);

        var x=0;
        var y=0;
        $("tr","#rf-tablegrid").each(function () {
            $("td", this).each(function (col){
                var c = cells[x][y++];
                $.data(this,"cell",c);
                c.td = this;
            }) 
            y=0;
            x++;
        });
       


    },
    
    signalWordFound : function(idx) {
        var w = $("li").get(idx);
        Visualizer.signalWordFound(w);
    }
    
}


})(jQuery);


/*
 * jQuery UI Touch Punch 0.2.2
 *
 * Copyright 2011, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Depends:
 *  jquery.ui.widget.js
 *  jquery.ui.mouse.js
 */
(function(b){b.support.touch="ontouchend" in document;if(!b.support.touch){return;}var c=b.ui.mouse.prototype,e=c._mouseInit,a;function d(g,h){if(g.originalEvent.touches.length>1){return;}g.preventDefault();var i=g.originalEvent.changedTouches[0],f=document.createEvent("MouseEvents");f.initMouseEvent(h,true,true,window,1,i.screenX,i.screenY,i.clientX,i.clientY,false,false,false,false,0,null);g.target.dispatchEvent(f);}c._touchStart=function(g){var f=this;if(a||!f._mouseCapture(g.originalEvent.changedTouches[0])){return;}a=true;f._touchMoved=false;d(g,"mouseover");d(g,"mousemove");d(g,"mousedown");};c._touchMove=function(f){if(!a){return;}this._touchMoved=true;d(f,"mousemove");};c._touchEnd=function(f){if(!a){return;}d(f,"mouseup");d(f,"mouseout");if(!this._touchMoved){d(f,"click");}a=false;};c._mouseInit=function(){var f=this;f.element.bind("touchstart",b.proxy(f,"_touchStart")).bind("touchmove",b.proxy(f,"_touchMove")).bind("touchend",b.proxy(f,"_touchEnd"));e.call(f);};})(jQuery);




$(document).ready( function () {
    var words = "{{$correct_answer}}";
        //attach the game to a div
        $(".rurera-words-search-{{$question->id}}").wordsearchwidget({
            "wordlist" : words,
            "gridsize" : 15,
            "width" : 300});

});   

</script>

