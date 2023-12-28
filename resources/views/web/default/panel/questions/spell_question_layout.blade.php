@php $rand_id = rand(999,99999); @endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .rurera-hide{display:none;}
</style>


<div class="question-step quiz-complete" style="display:none">
    <div class="question-layout-block">
        <div class="left-content has-bg">
            <h2>&nbsp;</h2>
            <div id="leform-form-1"
                 class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable"
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


@endphp
<div class="question-area spell-question-area">
    <div class="correct-appriciate" style="display:none"></div>
    <div class="question-step question-step-{{ $question->id }}" data-elapsed="0"
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
                        <li class="total-points">
                            <span>{{isset( $total_points )? $total_points : 0}} </span> Points
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
                        <input type="text" maxlength="{{$no_of_words}}" class="editor-field" data-field_id="{{$field_id}}" data-id="{{$field_id}}" id="field-{{$field_id}}" style="width: {{$field_width}}ch;
                            background: repeating-linear-gradient(90deg, #747474 0, #747474 1ch, transparent 0, transparent 1.5ch) 0 100%/ {{$field_width}}ch 2px no-repeat;
                            font: 1.2rem 'Ubuntu Mono', monospace;
                            letter-spacing: 0.5ch;">
                    </div>



                    <div class="question-correct-answere rurera-hide">
                        {{$correct_answer}}
                    </div>
                    <div class="rurera-virtual-keyboard rurera-hide">
                        <div class="keyboard-delete">
                            <input type="button" value="delete" class="delete">
                        </div>
                        <div class="virtual-keyboard">
                          <div class="keyboard-controls">
                            <input type="button" class="control-nub" value="1">
                            <input type="button" class="control-nub" value="2">
                            <input type="button" class="control-nub" value="3">
                            <input type="button" class="control-nub" value="4">
                            <input type="button" class="control-nub" value="5">
                            <input type="button" class="control-nub" value="6">
                            <input type="button" class="control-nub" value="7">
                            <input type="button" class="control-nub" value="8">
                            <input type="button" class="control-nub" value="9">
                            <input type="button" class="control-nub" value="0">
                          </div>

                          <div class="keyboard-controls">
                            <div class="keyboard-cell">
                                <span><input type="button" value="q"></span>
                                <span><input type="button" value="w"></span>
                                <span><input type="button" value="e"></span>
                            </div>
                            <div class="keyboard-cell">
                              <span><input type="button" value="r"></span>
                              <span><input type="button" value="t"></span>
                              <span><input type="button" value="y"></span>
                            </div>
                            <div class="keyboard-cell">
                              <span><input type="button" value="u"></span>
                              <span><input type="button" value="i"></span>
                              <span><input type="button" value="o"></span>
                            </div>
                            <div class="keyboard-cell">
                                <span><input type="button" value="p"></span>
                                <span><input type="button" value="a"></span>
                                <span><input type="button" value="s"></span>
                            </div>
                            <div class="keyboard-cell">
                                <span><input type="button" value="d"></span>
                                <span><input type="button" value="f"></span>
                                <span><input type="button" value="g"></span>
                            </div>
                            <div class="keyboard-cell">
                                <span><input type="button" value="h"></span>
                                <span><input type="button" value="j"></span>
                                <span><input type="button" value="k"></span>
                            </div>
                            <div class="keyboard-cell">
                                <span><input type="button" value="l"></span>
                                <span><input type="button" value="z"></span>
                                <span><input type="button" value="x"></span>
                            </div>
                            <div class="keyboard-cell">
                                <span><input type="button" value="c"></span>
                                <span><input type="button" value="v"></span>
                                <span><input type="button" value="b"></span>
                            </div>
                            <div class="keyboard-cell">
                              <span><input type="button" value="n"></span>
                                <span><input type="button" value="m"></span>
                                <span><input type="button" value="shift" class="shift"></span>
                            </div>
                          </div>
                        </div>
                        <div class="keyboard-controls spacebar">
                          <input type="button" value="">
                        </div>
                      </div>


                    <div class="form-btn-field">
                        <button type="button" class="question-review-btn" data-id="{{ $question->id }}">Finish</button>
                        <button type="submit" class="question-submit-btn">Enter</button>
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
    var currentFunctionStart = null;
    var Questioninterval = null;

    var SpellQuestionintervalCountDownFunc = function() {
             currentFunctionStart = 'started';
            Questioninterval = setInterval(function () {
                var seconds_count_done = $(".question-step-{{ $question->id }}").attr('data-elapsed');
                seconds_count_done = parseInt(seconds_count_done) + parseInt(1);
                $(".question-step-{{ $question->id }}").attr('data-elapsed', seconds_count_done);
            }, 1000);

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
        $('#field-{{$field_id}}').focus();
        console.log(currentFunctionStart);
        if( currentFunctionStart == null) {
            SpellQuestionintervalCountDownFunc();
        }
        //SpellQuestionintervalFunc();
        var player_id = $(this).attr('data-id');
        

        $(this).toggleClass("pause");
        if ($(this).hasClass('pause')) {
            console.log('play');
            console.log(player_id);
            document.getElementById(player_id).play();
        } else {
            console.log('pause');
            console.log(player_id);
            document.getElementById(player_id).pause();
        }
    });
    var audio = document.getElementById("audio_file_{{ $question->id }}");

    audio.addEventListener('ended', function () {
        $('#sound-icon-{{ $question->id }}').toggleClass("pause");
    });

    $(document).on('click', '.start-spell-quiz', function (e) {
    //jQuery(document).ready(function() {


        $('#field-{{$field_id}}').focus();
        console.log('#sound-icon-{{ $question->id }}');
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
</script>

