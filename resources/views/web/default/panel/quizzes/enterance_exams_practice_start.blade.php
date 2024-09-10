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
            @php $top_bar_class = ($quiz->quiz_type == 'vocabulary')? 'rurera-hide' : ''; @endphp

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
                                   <div class="quiz-pagination ">
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
                                <div class="quiz-timer">
                                    @php $remaining_time = ($practice_time*60)-$total_time_consumed; @endphp
                                    <span class="timer-number"><div class="quiz-timer-counter" data-time_counter="{{($practice_time*60)-$total_time_consumed}}" data-time_consumed="{{$total_time_consumed}}">{{getTimeWithText($remaining_time, true, true)}}</div></span>
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
                <div class="col-lg-9 col-md-12 col-sm-12 mt-50 mx-auto">
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
									<span class="value-lable" title="Target" style="left:{{$target_score}}%">{{$target_score}}%</span>
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
                        @php $first_question = rurera_decode($questions_layout[$first_question_id]);
                        echo $first_question;
                        @endphp

                        @endif
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
					<li>Total Questions: <strong class="total-questions">10</strong></li>
					<li><span class="icon-box"></span> Correct: <strong class="correct-questions">1</strong></li>
					<li>Incorrect: <strong class="incorrect-questions">2</strong></li>
					<li>Unanswered: <strong class="unanswered-questions">7</strong></li>
					<li>Time Remaining <strong class="time-remaining">10</strong></li>
				</ul>
				<div class="inactivity-controls">
					<a href="javascript:;" class="continue-btn" data-dismiss="modal" aria-label="Continue">Continue Test</a>
					<a href="javascript:;" class="review-btn" data-dismiss="modal" data-toggle="modal" data-target="#review_submit">Finish Test</a>
					<a href="/tests" class="exit-btn"> Need a break! </a>
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
			<li>Total Questions: <strong class="total-questions">10</strong></li>
			<li><span class="icon-box"></span> Correct: <strong class="correct-questions">1</strong></li>
			<li>Incorrect: <strong class="incorrect-questions">2</strong></li>
			<li>Unanswered: <strong class="unanswered-questions">7</strong></li>
			<li>Time Remaining <strong class="time-remaining">10</strong></li>
		</ul>
        <div class="inactivity-controls">
            <a href="javascript:;" class="continue-btn" data-dismiss="modal" aria-label="Continue">Continue Test</a>
            <a href="javascript:;" class="review-btn" data-dismiss="modal" data-toggle="modal" data-target="#review_submit">Finish Test</a>
			<a href="/tests" class="exit-btn"> Need a break! </a>
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
    var focusIntervalCount = 10;
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
						$(".question_inactivity_modal .modal-body .time-remaining").html(getTime(remaining_time));
						$(".question_inactivity_modal .modal-body .total-questions").html(total_questions);
						$(".question_inactivity_modal .modal-body .correct-questions").html(correct_questions);
						$(".question_inactivity_modal .modal-body .incorrect-questions").html(incorrect_questions);
						$(".question_inactivity_modal .modal-body .unanswered-questions").html(parseInt(total_questions) - parseInt(attempted_questions));
						
						
                        $(".question_inactivity_modal").modal('show');
                        focusIntervalCount = 10;
                        clearInterval(focusInterval);
                        focusInterval = null;
                    }
                }, 1000);

            }
        });


        window.addEventListener('focus', function () {
            focusIntervalCount = 10;
            clearInterval(focusInterval);
            focusInterval = null;
        });

        $(document).on('click', '.continue-btn', function (e) {
            TimerActive = true;
            focusIntervalCount = 10;
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
			$(".pause_quiz .modal-body .time-remaining").html(getTime(remaining_time));
			$(".pause_quiz .modal-body .total-questions").html(total_questions);
			$(".pause_quiz .modal-body .correct-questions").html(correct_questions);
			$(".pause_quiz .modal-body .incorrect-questions").html(incorrect_questions);
			$(".pause_quiz .modal-body .unanswered-questions").html(parseInt(total_questions) - parseInt(attempted_questions));
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
	
	function afterQuestionValidation(return_data, thisForm, question_id) {
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
