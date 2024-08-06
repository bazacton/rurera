@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<script src="/assets/default/vendors/charts/chart.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style>
    .hide {
        display: none !important;
    }

</style>
@endpush

@section('content')

<section class="content-section">
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
                            <li class="{{$active}}"><a href="/spells"><span class="icon-box">
                                                                    <img src="/assets/default/svgs/filter-all.svg">
                                                                </span>All Word Lists</a></li>
                            @php $active = ($quiz_category == 'Word Lists')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells?quiz_category=Word+Lists"><span class="icon-box">
                                                                                                <img src="/assets/default/svgs/filter-letters.svg">
                                                                                            </span>Word Lists
                                </a></li>
                            @php $active = ($quiz_category == 'Spelling Bee')? 'active' :'' @endphp
                            <li class="{{$active}}"><a href="/spells?quiz_category=Spelling+Bee"><span class="icon-box">
                                                                    <img src="/assets/default/svgs/filter-words.svg">
                                                                </span>Spelling Bee
                                </a></li>
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
                                                <h3 class="font-18 font-weight-bold">{{$dataObj->getTitleAttribute()}}</h3>
												<div class="spell-links">
												<a href="javascript:;" class="spell-popup-btn" data-play_link="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-search/exercise" data-spell_type="word-hunts" data-spell_id="{{$dataObj->id}}">Word Hunts</a>
												<a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-search/exercise">Word Search</a>
												<a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-cloud/exercise">Word Cloud</a>
												<a href="/{{isset( $dataObj->quizYear->slug )? $dataObj->quizYear->slug : ''}}/{{$dataObj->quiz_slug}}/word-missing/exercise">Complete the Sentence</a>
												<a href="javascript:;">Flashcards</a>
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
	  
		<h2>Filter Words</h2>
		<p>From sources across the web</p>
		<div class="spell-words-filters" data-spell_id="0" data-spell_type="">
		<div class="row">
		<div class="col-3 col-lg-3 col-md-12">
			Sort By
			<div class="form-group">
				<select name="sort_by" class="sort_by_filter">
					<option value="alphabetically">Alphabetically</option>
					<option value="attempts">No of Attempts</option>
				</select>
			</div>
		</div>
		<div class="col-3 col-lg-3 col-md-12">
			Difficulty Level
			<div class="form-group">
				<select>
					<option>All</option>
				</select>
			</div>
		</div>
		<div class="col-4 col-lg-4 col-md-12">
			Word
			<div class="form-group">
				<div class="input-field">
					<input type="text" class="search-word" placeholder="Search....">
				</div>
			</div>
		</div>
		<div class="col-2 col-lg-2 col-md-12">
			<a href="javascript:;" data-href="javascript:;" class="play-again" data-dismiss="modal" aria-label="Continue">Play Again</a>
		</div>
		</div>
		<form class="spell-quiz-form" action="#" method="POST">
		
		<div class="spell-words-data">
		</div>
		
		</form>
      </div>
    </div>
  </div>
</div>
</div>
</div>

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
	
	$(document).on('click', '.spell-popup-btn', function (e) {
		var thisObj = $(this);
		var spell_id = $(this).attr('data-spell_id');
		var spell_type = $(this).attr('data-spell_type');
		var play_link = $(this).attr('data-play_link');
		$(".play-again").attr('data-href', play_link);
		
		rurera_loader(thisObj.closest(".spell-levels "), 'div');
		$(".spell-words-filters").attr('data-spell_id', spell_id);
		$(".spell-words-filters").attr('data-spell_type', spell_type);
		$(".spell-words-filters").attr('data-play_link', play_link);
		spellPopupRequest = jQuery.ajax({
			type: "GET",
			beforeSend: function () {
				if (spellPopupRequest != null) {
					rurera_remove_loader($(".spell-levels "), 'div');
					spellPopupRequest.abort();
					rurera_loader(thisObj.closest(".spell-levels "), 'div');
				}
			},
			url: '/spells/words-data',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {"spell_id": spell_id, "spell_type": spell_type},
			success: function (return_data) {
				rurera_remove_loader(thisObj.closest(".spell-levels "), 'div');
				$(".spell-words-data").html(return_data);
				$(".spell_words_popup").modal('show');
			}
		});

    });
	
	$(document).on('click', '.play-again', function (e) {
		var play_link = $(".spell-words-filters").attr('data-play_link');
		$(".spell-quiz-form").attr('action',play_link);
		$(".spell-quiz-form").submit();
    });
	
	
	
	var spellFilterRequest = null;
	$(document).on('change', '.sort_by_filter', function (e) {
		filter_words();
    });
	
	$(document).on('keyup change', '.search-word', function (e) {
		filter_words();
    });
	
	function filter_words(){
		var sort_by = $('.sort_by_filter').val();
		var spell_id = $(".spell-words-filters").attr('data-spell_id');
		var spell_type = $(".spell-words-filters").attr('data-spell_type');
		
		var search_word = $('.search-word').val();
		

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
			}
		});
	}
	
	
	







</script>
@endpush
