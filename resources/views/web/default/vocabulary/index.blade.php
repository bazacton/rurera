@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<link rel="stylesheet" href="/assets/default/css/assignments.css">
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<script src="/assets/default/vendors/charts/chart.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style>
    .hide {
        display: none !important;
    }
	.word-block.active {
		background: #edffea;
	}
	.word-block-inner {
		display: contents;
	}
	.word-block-inner-data {
		display: none;
		width:100%;
	}
	.spell-words-data {
		-webkit-user-select: none; /* Safari */
		-moz-user-select: none;    /* Firefox */
		-ms-user-select: none;     /* Internet Explorer/Edge */
		user-select: none;         /* Non-prefixed version, currently supported by Chrome, Opera, and Firefox */
	}
	
	.rurera-error {
		color: #ff0909;
	}
	
	.spell-words-data{
		position: static;
	}
	
	
.selectedArea{
  display:inline-block;
  margin:20px 0;
}

.dragArea{
  position:absolute;
  display:none;
  width:100px;
  height:100px;
  border:1px solid rgba(0,0,0,.15);
  background:rgba(0,0,0,.05);
  z-index:999999;
}

.dragArea.remove{  
  border:1px solid rgba(255,0,0,.15);
  background:rgba(255,0,0,.05);
}

.dragArea.add{  
  border:1px solid rgba(0,0,255,.15);
  background:rgba(0,0,255,.05);
}
.spell-words-data .word-block {
    position: relative;
}
.spell-words-data .word-block input[type="checkbox"] {
    width: 100%;
    height: 100%;
    left: 0;
}
</style>

@endpush

@section('content')

<section class="content-section spells-page">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-left mb-30">
                        <h2 class="mt-0 mb-10 font-22">Spelling word lists</h2>
                        <p class="font-16"> Work through a variety of practice questions to improve your skills and become familiar with
                            the types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>


                <div class="col-12">
                    <div class="listing-search lms-jobs-form mb-20">
                        <a href="#." class="filter-mobile-btn">Filters Dropdown</a>
                        <ul class="inline-filters">
                            @php $active = ($quiz_category == '')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells">All Word Lists</a></li>
                            @php $active = ($quiz_category == 'Word Lists')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells/word-lists">Word Lists</a></li>
                            @php $active = ($quiz_category == 'Spelling Bee')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells/spelling-bee">Spelling Bee</a></li>
                        </ul>
                    </div>
                </div>

                @if( !empty( $data))

                <div class="col-12">
                    <section class="lms-data-table mt-0 mb-30 spells elevenplus-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">


                                    @php $total_questions_all = $total_attempts_all = $total_questions_attempt_all = $correct_questions_all =
                                    $incorrect_questions_all = $pending_questions_all = $not_used_words_all = 0;
                                    @endphp

                                    @foreach( $data as $dataObj)
                                    @php
									
									$total_questions = isset( $dataObj->quizQuestionsList )? count($dataObj->quizQuestionsList) : 0;
									$spell_test_count = $dataObj->parentResults->where('quiz_result_type', 'vocabulary')->where('attempt_mode', '')->where('status', 'waiting')->count();
									$spell_test_completed = $dataObj->parentResults->where('quiz_result_type', 'vocabulary')->where('attempt_mode', '')->where('status', '!=', 'waiting')->count();
									$word_search_count = $dataObj->parentResults->where('quiz_result_type', 'vocabulary')->where('attempt_mode', 'word-search')->where('status', 'waiting')->count();
									$word_cloud_count = $dataObj->parentResults->where('quiz_result_type', 'vocabulary')->where('attempt_mode', 'word-cloud')->where('status', 'waiting')->count();
									$word_missing_count = $dataObj->parentResults->where('quiz_result_type', 'vocabulary')->where('attempt_mode', 'word-missing')->where('status', 'waiting')->count();
									
									
									$quizResultObj = $dataObj->parentResults->where('user_id', $user->id)->where('quiz_result_type', 'vocabulary')->where('attempt_mode', '')->where('status', 'passed')->last();
									$percentage_class = '';
									if( isset( $quizResultObj->id)){
										$percentage_correct_answer = $QuestionsAttemptController->get_percetange_corrct_answer($quizResultObj);
										$percentage_class = 'danger';
										$percentage_class = ($percentage_correct_answer >= 70 )? 'improvement' : $percentage_class;
										$percentage_class = ($percentage_correct_answer > 90 )? 'success' : $percentage_class;
									}


                                    $overall_percentage = 0;
                                   
                                    $spell_quiz_completed = '';
                                    

                                    $treasure_box_closed = '<li class="treasure">
                                                        <a href="#">
                                                            <span class="thumb-box">
                                                                <img src="/assets/default/img/treasure2.png" alt="">
                                                            </span>
                                                        </a>
                                                    </li>';
                                    $treasure_box_opened = '<li class="treasure">
                                                                <a href="#">
                                                                    <span class="thumb-box">
                                                                        <img src="/assets/default/img/treasure.png" alt="">
                                                                    </span>
                                                                </a>
                                                            </li>';
                                    @endphp

                                    <div class="spell-levels {{$spell_quiz_completed}}">
                                        <div class="spell-levels-top">
                                            <div class="spell-top-left">
                                                <h3 class="font-18 font-weight-bold">{{$dataObj->getTitleAttribute()}} <span class="progress-star {{$percentage_class}}"><img src="/assets/default/img/tick-white.png"></span></h3>
												<div class="spell-links">
												<a href="javascript:;" class="spell-popup-btn" data-heading="{{$dataObj->getTitleAttribute()}}" data-play_link="/spelling/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/" data-spell_type="word-hunts" data-spell_id="{{$dataObj->id}}">
													Practice Words
												</a>
												
												
												<a href="javascript:;" class="spell-popup-btn1 rurera-tooltip dropup">
												
												<span class="dropdown-toggle h-100 w-100 d-flex align-items-center justify-content-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Take a test</span>
												
												<div class="lms-tooltip dropdown-menu">
													<div class="tooltip-box">	
														<button data-heading="Take a test" class="tooltip-btn practice font-16 d-block mb-15 text-center spell-test-btn"  data-play_link="/spelling/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/test" data-spell_type="test">Take Test</button>
														@if($spell_test_count > 0)
															<button class="tooltip-btn legendary d-block font-16 text-center" onclick='window.location.href = "/spelling/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/test"'>Continue</button>
														@endif
														@if($spell_test_completed > 0)
															<button class="tooltip-btn practice font-16 d-block mt-15 text-center" onclick='window.location.href = "/panel/analytics/vocabulary/{{$dataObj->id}}"'>Track</button>
														@endif
													</div>
												  </div>
												</a>
												
												</div>
                                                @if($overall_percentage > 0 && $overall_percentage != 100)
                                                <div class="levels-progress horizontal">
                                                    <span class="progress-box">
                                                        <span class="progress-count" style="width: {{$overall_percentage}}%;"></span>
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="spell-top-right">
                                                <a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/spelling-list" class="words-count"><img src="/assets/default/img/skills-icon.png" alt=""><span>{{$total_questions}}</span>word(s)</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach







                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                @endif

            </div>
        </div>
    </section>



    <a href="#" class="scroll-btn" style="display: block;">
        <div class="round">
            <div id="cta"><span class="arrow primera next"></span> <span class="arrow segunda next"></span></div>
        </div>
    </a>

</section>


<div class="modal fade spell_words_popup lms-choose-membership" id="spell_words_popup" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="modal-body spell_words_popup_body">
      <div class="container container-nosidebar">
		<div class="row">
			<div class="col-10 col-lg-10 col-md-12">
				<h2 class="page-title">Filter Words</h2>
				<p>From sources across the web</p>
			</div>
			<div class="col-2 col-lg-2 col-md-12 spell-words-filters pt-5">
			<a href="javascript:;" data-href="javascript:;" class="play-again">Play (<span class="selected_questions">All</span>)</a>
			</div>
		</div>
		<h3 class="mt-30">Choose Practice Type</h3>
		<div class="tests-list-holder spell-type-check mb-25 mt-20">
			<a href="#." class="filter-mobile-btn">Filters Dropdown</a>
			<ul class="tests-list mb-30">
				<li data-type="word-hunts" class="active">Word Hunts</li>
				<li data-type="word-search">Word Search</li>
				<li data-type="word-cloud">Word Cloud</li>
				<li data-type="word-missing">Practice Test</li>
			</ul>
			<input type="text" name="spell_type" class="spell_type_check rurera-hide" value="word-hunts">
		</div>
		
		<div class="spell-words-filters" data-spell_id="0" data-spell_type="">
		<div class="rurera-error mb-30 rurera-hide">Select atleast 15 words to continue!</div>
		<div class="row">
		
		
		<div class="col-9 col-lg-9 col-md-12">
			<h3>Choosen Words (<span class="choosen-words">Default All Selected</span>)</h3>
		</div>
		<div class="col-3 col-lg-3 col-md-12">
			Sort By
			<div class="form-group">
				<select name="sort_by" class="sort_by_filter">
					<option value="alphabetically">Alphabetically</option>
					<option value="attempts">No of Attempts</option>
				</select>
			</div>
		</div>
		
		
		</div>
		<form class="spell-quiz-form" action="#" method="POST">
		<input type="hidden" name="is_new" value="yes">
		{{ csrf_field() }}
		
		<div class="spell-words-data" id="accordion">
		</div>
		
		</form>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<form class="spell-test-quiz-form" action="#" method="POST">
<input type="hidden" name="is_new" value="yes">
{{ csrf_field() }}
</form>
@endsection

@push('scripts_bottom')
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.graph-data-ul li a', function (e) {
            $('.graph-data-ul li a').removeClass('active');
            $(this).addClass('active');
            var graph_id = $(this).attr('data-graph_id');
            $('.graph_div').addClass('hide');
            $('.' + graph_id).removeClass('hide');
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.spell-levels ul').slideUp();
        $('body').on('click', '.graph-data-ul li a', function (e) {
            $('.graph-data-ul li a').removeClass('active');
            $(this).addClass('active');
            var graph_id = $(this).attr('data-graph_id');
            $('.graph_div').addClass('hide');
            $('.' + graph_id).removeClass('hide');
        });

        $('body').on('change', '.analytics_graph_type', function (e) {
            var thisObj = $('.chart-summary-fields');
            rurera_loader(thisObj, 'div');
            var graph_type = $(this).val();
            jQuery.ajax({
                type: "GET",
                url: '/panel/analytics/graph_data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"graph_type": graph_type},
                success: function (return_data) {
                    rurera_remove_loader(thisObj, 'div');
                    if (return_data != '') {
                        $(".analytics-graph-data").html(return_data);
                    }
                }
            });

        });


        //$(".master-card.master span").html('{{$correct_questions_all}}');
        //$(".master-card.non-master span").html('{{$incorrect_questions_all}}');
        $(".master-card.non-use span").html('{{$not_used_words_all}}');

    });
    $(document).on('click', '.play-btn', function (e) {
        var player_id = $(this).attr('data-id');

        $(this).toggleClass("pause");
        if($(this).hasClass('pause')) {
            document.getElementById(player_id).play();
        }else{
            document.getElementById(player_id).pause();
        }
    });

    $(document).on('click', '.spell-levels ul li a', function (e) {

        var quiz_id = $(this).closest('li').attr('data-id');
        var quiz_level = $(this).closest('li').attr('data-quiz_level');
        localStorage.setItem('quiz_level_'+quiz_id, quiz_level);
    });


    $(document).on('click', '.spell-levels-top', function (e) {
        if (!$(e.target).closest('.spell-top-right').length) {
            $(this).closest('.spell-levels').find('ul').slideToggle();
        }

    });
	
	var spellPopupRequest = null;
	
	$(document).on('click', '.spell-test-btn', function (e) {
		var play_link = $(this).attr('data-play_link');
		$(".spell-test-quiz-form").attr('action',play_link);
		$(".spell-test-quiz-form").submit();
	});
	
	
	$(document).on('click', '.spell-popup-btn', function (e) {
		var thisObj = $(this);
		var spell_id = $(this).attr('data-spell_id');
		var spell_heading = $(this).attr('data-heading');
		$(".spell_words_popup_body .container-nosidebar .page-title").html(spell_heading);
		var spell_type = $(this).attr('data-spell_type');
		var play_link = $(this).attr('data-play_link');
		$(".play-again").attr('data-href', play_link);
			
		rurera_loader(thisObj.closest(".spell-levels "), 'div');
		//rurera_loader(thisObj, 'div');
		$(".spell-words-filters").attr('data-spell_id', spell_id);
		$(".spell-words-filters").attr('data-spell_type', spell_type);
		$(".spell-words-filters").attr('data-play_link', play_link);
		spellPopupRequest = jQuery.ajax({
			type: "GET",
			beforeSend: function () {
				if (spellPopupRequest != null) {
					rurera_remove_loader($(".spell-levels "), 'div');
					spellPopupRequest.abort();
					//rurera_loader(thisObj, 'div');
					rurera_loader(thisObj.closest(".spell-levels "), 'div');
				}
			},
			url: '/spells/words-data',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {"spell_id": spell_id, "spell_type": spell_type},
			success: function (return_data) {
				spellPopupRequest = null;
				rurera_remove_loader(thisObj.closest(".spell-levels "), 'div');
				$(".spell-words-data").html(return_data);
				$(".spell_words_popup").modal('show');
			}
		});

    });
	
	$(document).on('click', '.play-again', function (e) {
		var selected_words = $('.word-block.active').length;
		selected_words = (selected_words > 0)? selected_words : 'All';
		$(".rurera-error").addClass('rurera-hide');
		if( selected_words != 'All' && selected_words < 3){
			$(".rurera-error").removeClass('rurera-hide');
			/*var error_message = jQuery.growl.error({
                message: 'Select atleast 15 words to continue!',
                duration: 10000,
            });*/
		}else{
			var play_link = $(".spell-words-filters").attr('data-play_link');
			var spell_type = $(".spell_type_check").val();
			play_link += spell_type;
			$(".spell-quiz-form").attr('action',play_link);
			$(".spell-quiz-form").submit();
		}
    });
	
	
	
	var spellFilterRequest = null;
	$(document).on('change', '.sort_by_filter', function (e) {
		filter_words();
    });
	
	function filter_words(){
		var sort_by = $('.sort_by_filter').val();
		var spell_id = $(".spell-words-filters").attr('data-spell_id');
		var spell_type = $(".spell-words-filters").attr('data-spell_type');
		
		var search_word = '';
		

		var thisObj = $('.spell-words-data');
		rurera_loader(thisObj, 'div');
		$(".spell-words-filters").attr('data-spell_id', spell_id);
		$(".spell-words-filters").attr('data-spell_type', spell_type);
		spellFilterRequest = jQuery.ajax({
			type: "GET",
			beforeSend: function () {
				if (spellFilterRequest != null) {
					rurera_remove_loader($(".spell-levels "), 'div');
					spellFilterRequest.abort();
					rurera_loader(thisObj, 'div');
				}
			},
			url: '/spells/words-data',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {"spell_id": spell_id, "spell_type": spell_type, 'sort_by' : sort_by, 'search_word' : search_word},
			success: function (return_data) {
				rurera_remove_loader(thisObj, 'div');
				$(".spell-words-data").html(return_data);
				document.oncontextmenu = function() {
				  return false;
				}
			}
		});
	}
	
	
	

$(document).on('change', '.spell_checkbox', function (e) {
    if ($(this).is(':checked')) {
        $(this).closest('.word-block').addClass('active');
    } else {
        $(this).closest('.word-block').removeClass('active');
    }
	var selected_words = $('.word-block.active').length;
	var choosen_words = (selected_words > 0)? selected_words+' Choosen' : 'Default All Selected';
	selected_words = (selected_words > 0)? selected_words : 'All';
	$(".play-again .selected_questions").html(selected_words);
	$(".choosen-words").html(choosen_words);
});


$(document).on('click', '.phonics-btn', function (e) {
        var player_id = $(this).attr('data-id');
        var audio_elements = $(this).find('.player-box-audio');
        var current_index = 0;

        // Function to play next audio with delay
        function playNextWithDelay() {
            if (current_index < audio_elements.length) {
                // Play the current audio
                console.log(audio_elements);
                audio_elements[current_index].play();

                // Increment index for the next audio
                current_index++;

                // Call recursively with a delay of 1 second
                setTimeout(playNextWithDelay, 1000);
            }
        }

        // Toggle pause class
        $(this).toggleClass("pause");

        // Check if paused or not
        if ($(this).hasClass('pause')) {
            // Start playing the sequence
            playNextWithDelay();
        } else {
            // Pause the current audio
            audio_elements[current_index - 1].pause();
        }
    });

$(document).on('click', '.word-block label .down-arrow', function (e) {
	var thisObj = $(this).closest('label');
	$('.word-block-inner-data').slideUp();
	var target_id = thisObj.attr('data-target');
	var target_data = $(target_id).html();
	$(this).closest('.word-block-inner').find('.word-block-inner-data').html('<div class="word-details">'+target_data+'</div>');
	$(this).closest('.word-block-inner').find('.word-block-inner-data').slideDown();
});

$(document).on('click', '.word-details .close-btn', function (e) {
	$('.word-block-inner-data').slideUp();
});

$(document).on('click', '.spell-type-check ul li', function (e) {
	var spell_type = $(this).attr('data-type');
	$(".spell-type-check ul li").removeClass('active');
	$(".spell_type_check").val(spell_type);
	$(this).addClass('active');
	
});

/*$(document).on('click', '.lms-tooltip', function (e) {
	e.stopPropagation();
});*/


</script>



<script>
        var sx;
var sy;
var ex;
var ey;
var ta;
var drag = false;

$(document).ready(function(){
  var dragArea = document.createElement("div");
  //dragArea.addClass("dragArea");
  dragArea.setAttribute('class', 'dragArea');
  document.body.appendChild(dragArea);
  
});



$(document).on("mousemove", function(event){
	if ($(event.target).closest('.spell_words_popup').length < 1) {
		return ;
	}
  if(drag){  
    var flipX = "";
    var flipY = "";   
    var top = sy;
    var left = sx;
    var height = event.pageY - sy;
    var width = event.pageX - sx;
    
    if((event.pageX - sx) < 0){
      flipX = "scaleX(-1)";
      width = sx - event.pageX;
      left = event.pageX;
    }
    
    if((event.pageY - sy) < 0){
      flipY = "scaleY(-1)";
      height = sy - event.pageY;
      top = event.pageY;
    }
    
    $(".dragArea").attr("style", "display:block; top:"+ top + "px;  left:" + left + "px; width:"+ width + "px; height: " + height + "px; transform:" + flipX + " " + flipY + ";");
	console.log('moving');
	console.log(event.which);
	
	ex = event.pageX;
	ey = event.pageY;
	  
	if(ex < sx){
		ta = ex;
		ex = sx;
		sx = ta;
	  }
		
	  if(ey < sy){
		ta = ey;
		ey = sy;
		sy = ta;
	  }
	  switch (event.which) {
        case 1:
            //Left Mouse button pressed. Check                   
            selectItems(true);
            break;
        case 3:
            //Right Mouse button pressed. Uncheck       
            selectItems(false);
            break;
        default:
            //do nothing 
    }
	
	/*if ($(event.target).closest('.spell_words_popup').length < 1) {
		return ;
	}
	
	  drag = true;
	  sx = event.pageX;
	  sy = event.pageY;
	  switch (event.which) {
			case 1:
				//Left Mouse button pressed.           
				$(".dragArea").addClass("add");
				$(".dragArea").removeClass("remove");
				break;
			case 3:
				//Right Mouse button pressed.
				$(".dragArea").addClass("remove");
				$(".dragArea").removeClass("add");
				break;
			default:
				//do nothing
		}*/
	
  }
  });

$( document ).on( "mousedown", function( event ) {
	if ($(event.target).closest('.tests-list').length > 0) {
		return ;
	}
	if ($(event.target).closest('.spell-words-filters').length > 0) {
		return ;
	}
	if ($(event.target).closest('.close').length > 0) {
		return ;
	}
	
	
	if ($(event.target).closest('.spell_words_popup').length < 1) {
		return ;
	}
	  drag = true;
	  sx = event.pageX;
	  sy = event.pageY;
	  switch (event.which) {
			case 1:
				//Left Mouse button pressed.           
				$(".dragArea").addClass("add");
				$(".dragArea").removeClass("remove");
				break;
			case 3:
				//Right Mouse button pressed.
				$(".dragArea").addClass("remove");
				$(".dragArea").removeClass("add");
				break;
			default:
				//do nothing
		}
	  $(".dragArea").attr("style", "display:block; top:"+ event.pageY + "px; left:" + event.pageX + "px; width:0; height:0;");
  
  
});

$( document ).on( "mouseup", function( event ) {  
if ($(event.target).closest('.spell_words_popup').length < 1) {
	return ;
}
  drag = false;
  $(".dragArea").attr("style", "display:none;");
  
  ex = event.pageX;
  ey = event.pageY;
  
  if(ex < sx){
    ta = ex;
    ex = sx;
    sx = ta;
  }
    
  if(ey < sy){
    ta = ey;
    ey = sy;
    sy = ta;
  }
  switch (event.which) {
        case 1:
            //Left Mouse button pressed. Check                   
            selectItems(true);
            break;
        case 3:
            //Right Mouse button pressed. Uncheck       
            selectItems(false);
            break;
        default:
            //do nothing 
    }
  $( ".selectedArea" ).text("X-Range: " + sx + ":" + ex + " | Y-Range: " + sy + ":" + ey);
});

function selectItems(checked){
  $(".spell_checkbox").each(function(){
    var pos = $(this).offset();
    var cxLow = pos.left;
    var cxHi = pos.left + $(this).width();
    var cyLow = pos.top;
    var cyHi = pos.top + $(this).height();
    if(cxLow <= sx && sx <= cxHi && cxLow <= ex && ex <= cxHi ){
      if(cyLow <= sy && sy <= cyHi && cyLow <= ey && ey <= cyHi){
		  $(this).closest('.word-block').removeClass('active');
        $(this).prop("checked", !$(this).prop("checked"));
        
      }
    }  
	else if(sx <= cxHi && ex >= cxLow ){
      if(sy <= cyHi && ey >= cyLow){
        console.log(checked);
			$(this).prop("checked", checked);
			if( checked == true){
				$(this).closest('.word-block').addClass('active');
			}else{
				$(this).closest('.word-block').removeClass('active');
			}
		//$(".spell_checkbox").change();
      }
    }	
    
    //alert("X: " + position.left + " | " + "Y: " + position.top)
  });
  var selected_words = $('.word-block.active').length;
  selected_words = (selected_words > 0)? selected_words : 'All';
  var choosen_words = (selected_words > 0)? selected_words+' Choosen' : 'Default All Selected';
  $(".play-again .selected_questions").html(selected_words);
  $(".choosen-words").html(choosen_words);
  
  //$(".spell_checkbox").change();
}
    </script>

@endpush
