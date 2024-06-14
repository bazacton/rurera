@extends('web.default.panel.layouts.panel_layout')
@php use App\Models\Quiz; @endphp


@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush


@section('content')



<section class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="post-show" style="overflow:hidden;">

<section class="count-number-wrapp" style="display:none">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="section-title">
                    <h2>{{ $course->title }}</h2>
                </div>
                <ul class="count-number-boxes row">
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="edit-2" width="20" height="20" class="" style="color:#8cc811"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>answered</h5>
                            <strong>1,355</strong>
                            <h5>questions</h5>
                        </div>
                    </li>
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="clock" width="20" height="20" class="" style="color:#00aeef"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>spent</h5>
                            <strong>11 hr 32 min</strong>
                            <h5>practising</h5>
                        </div>
                    </li>
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>Made progress in</h5>
                            <strong>73</strong>
                            <h5>skills</h5>
                        </div>
                    </li>
                    <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="count-number-icon">
                            <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                        </div>
                        <div class="count-number-body">
                            <h5>Made progress in</h5>
                            <strong>73</strong>
                            <h5>skills</h5>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="lms-chapter-section">
    <div class="container">
        <div class="row">
            <div class="col-12 lms-chapter-area">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="sidebar-nav mb-30 mt-15">

                            <div class="panel-stats" style="background:{{(isset( $course->learn_background_color ) && $course->learn_background_color != '')? $course->learn_background_color : '#ffff'}}">
                                    <div class="stats-user">
                                        <h1>{{ $course->title }}</h1>
                                    </div>
                                    @if(isset( $course->learn_icon ) && $course->learn_icon != '')
                                        <div class="course-icon"><img src="{{$course->learn_icon}}"></div>
                                    @endif
                                    <div class="stats-list">
                                        <ul>
                                            <li>
                                                <div class="list-box">
                                                    <strong>{{$course->chapters->count()}}</strong>
                                                    <span>Units</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="list-box">
                                                    <strong>{{$course->webinar_sub_chapters->count()}}</strong>
                                                    <span>Lessons</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <ul>
                                @foreach($course->chapters as $chapter)
                                    @if((!empty($chapter->chapterItems) and count($chapter->chapterItems)) or (!empty($chapter->quizzes) and count($chapter->quizzes)))
                                        <li><a href="#subject_{{$chapter->id}}">{{ $chapter->title}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                     <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-10">
                         <div class="sorting-filter">
                            <a href="javascript:;" class="grid-btn active view-change-btn" data-type="chapters-short-view">
                                <span><img src="/assets/default/svgs/grid-view.svg" alt=""></span>
                            </a>
                            <a href="javascript:;" class="list-btn view-change-btn" data-type="chapters-detail-view">
                                <span><img src="/assets/default/svgs/list-view.svg" alt=""></span>
                        </a>
                        </div>
                     </div>
                    
					
					
					
					
					
					
					
					
                    
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 chapter-views chapters-short-view">
                        <div class="accordion-content-wrapper" id="chaptersAccordion" role="tablist"
                            aria-multiselectable="true">


                            <ul class="lms-chapter-ul">
                                @foreach($course->chapters as $chapter)

                                @if((!empty($chapter->chapterItems) and count($chapter->chapterItems)) or (!empty($chapter->quizzes) and count($chapter->quizzes)))
                                <li id="subject_{{$chapter->id}}"><div class="element-title mb-20"><h2 class="mb-0 font-22 text-dark-charcoal">{{ $chapter->title }}</h2></div>

                                    @if(!empty($sub_chapters[$chapter->id]) and count($sub_chapters[$chapter->id]))
                                    <div class="lms-chapter-ul-outer"><ul>
                                        @foreach($sub_chapters[$chapter->id] as $sub_chapter)
                                        @if(!empty($sub_chapter))
                                            @php $quizUserData = Quiz::getQuizPercentage($sub_chapter['id'], true);
                                            $completion_count = isset( $quizUserData['completion_count'] )? $quizUserData['completion_count'] : 0;
                                            $topic_percentage = isset( $quizUserData['topic_percentage'] )? $quizUserData['topic_percentage'] : 0;

                                            $topic_percentage_flag = ( $topic_percentage >= 95 && $topic_percentage < 100)? '<img src="/assets/default/svgs/completion-flag.svg">' : '';
                                            $topic_percentage_text = ($topic_percentage > 0 && $topic_percentage < 100)? '('.$topic_percentage.')' : '';

                                            $completion_counter = 1;
                                            while($completion_counter <= $completion_count){
                                                $topic_percentage_text .= '<img src="/assets/default/svgs/completion-star.svg">';
                                                $completion_counter++;
                                            }

                                            $topic_percentage_text .= $topic_percentage_flag;
                                            @endphp
                                            <li>
                                                <a href="/{{$category_slug}}/{{$course->slug}}/{{$sub_chapter['sub_chapter_slug']}}" class="{{ subscriptionCheckLink('courses') }}">{{ $sub_chapter['title'] }} {!! $topic_percentage_text !!}</a>
                                                {{ user_assign_topic_template($sub_chapter['id'], 'practice', $childs, $parent_assigned_list) }}
                                            </li>
                                        @endif
                                        @endforeach
                                        </ul>
                                        @if( $chapter->challenge_title != '')
                                        @php $challenge_image = isset( $chapter->challenge_image )? $chapter->challenge_image : '';
                                        $challenge_border_color = isset( $chapter->challenge_border_color )? $chapter->challenge_border_color : '#146ebe';
                                        $challenge_background_color = isset( $chapter->challenge_background_color )? $chapter->challenge_background_color : '#74c0fc';
                                        @endphp
                                        <style>
                                            .lms-chapter-footer.lms-chapter-bg-blue:before {
                                                background: {{$challenge_background_color}};
                                            }
                                        </style>
                                        <div class="lms-chapter-footer lms-chapter-bg-blue" style="background:{{$challenge_border_color}}">
                                            @if($challenge_image != '')
                                            <span class="lms-chapter-icon">
                                                <figure>
                                                    <img src="{{$challenge_image}}" alt="#" />
                                                </figure>
                                            </span>
                                            @endif
                                            <div class="lms-chapter-widget">
                                                <h5 class="lms-widget-title">
                                                    {{$chapter->challenge_title}}
                                                </h5>
                                                @php $challenge_quiz = isset( $chapter->challenge_quiz )? json_decode($chapter->challenge_quiz) : array(); $counter = 1;  @endphp

                                                @if( !empty( $challenge_quiz ))
                                                    <ul class="row">
                                                    @foreach( $challenge_quiz as $quiz_id)
                                                        @php $quizObj = App\Models\Quiz::find($quiz_id); @endphp
                                                        <li class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                            {{$quizObj->getTitleAttribute()}} # {{$counter}} ({{$quizObj->mastery_points}} Coins)
                                                        </li>
                                                        @php $counter++; @endphp
                                                    @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif

                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
                    
                     <div class="col-12 col-sm-12 col-md-12 col-lg-12 chapter-views chapters-detail-view rurera-hide">
                         
			<div class="current-topics-detail bg-white mb-30 mt-15">
			<div class="topics-table-group">
		
			@foreach($course->chapters as $chapter)
				@if((!empty($chapter->chapterItems) and count($chapter->chapterItems)) or (!empty($chapter->quizzes) and count($chapter->quizzes)))
				
					<div class="topics-table">
						<table class="w-100">
							<thead>
								<tr>
									<th class="text-white text-left p-15">{{ $chapter->title }}</th>
									<th class="text-white text-left p-15">Mastery Level</th>
									<th class="text-white text-left p-15">Questions Count</th>
									<th class="text-white text-left p-15">Rersources</th>
								</tr>
							</thead>
							
							<tbody>
								@if(!empty($sub_chapters[$chapter->id]) and count($sub_chapters[$chapter->id]))
									@foreach($sub_chapters[$chapter->id] as $sub_chapter)
                                        @if(!empty($sub_chapter))
                                            @php $quizUserData = Quiz::getQuizPercentage($sub_chapter['id'], true);
                                            $completion_count = isset( $quizUserData['completion_count'] )? $quizUserData['completion_count'] : 0;
                                            $topic_percentage = isset( $quizUserData['topic_percentage'] )? $quizUserData['topic_percentage'] : 0;

                                            $topic_percentage_flag = ( $topic_percentage >= 95 && $topic_percentage < 100)? '<img src="/assets/default/svgs/completion-flag.svg">' : '';
                                            $topic_percentage_text = ($topic_percentage > 0 && $topic_percentage < 100)? '('.$topic_percentage.')' : '';

                                            $completion_counter = 1;
                                            while($completion_counter <= $completion_count){
                                                $topic_percentage_text .= '<img src="/assets/default/svgs/completion-star.svg">';
                                                $completion_counter++;
                                            }

                                            $topic_percentage_text .= $topic_percentage_flag;
                                            @endphp
											
											<tr>
												<td data-label="{{ $chapter->title }}" class="px-15 py-20">
													<div class="checkbox-field mb-0">
														<label for="{{$sub_chapter['sub_chapter_slug']}}" class="m-0 font-weight-bold">{{ $sub_chapter['title'] }} {!! $topic_percentage_text !!}</label>
													</div>
												</td>
												<td data-label="Mastery Level" class="px-15 py-20">
													<span>
													@if( $topic_percentage > 0)
														<div class="rurera-progress-bar">
															<span class="progress-inner" style="width: {{$topic_percentage}}%;"></span>
														</div>
													@else
														-
													@endif
													</span>
												</td>
												<td data-label="Last Seen" class="px-15 py-20">
													<span>{{$sub_chapter['total_questions']}}</span>
												</td>
												<td data-label="Rersources" class="px-15 py-20">
													<a href="#" class="video-btn mr-10">
														<span class="icon-box">
															<img src="/assets/default/svgs/play-video.svg" alt="" title="Video">
														</span>
													</a>
													<a href="#" class="file-btn">
														<span class="icon-box">
															<img src="/assets/default/svgs/filesheet.svg" alt="" title="Helpsheet">
														</span>
													</a>
												</td>
											</tr>
											
										@endif
									@endforeach
									
									
									
								@endif
								
							</tbody>
						</table>
					</div>
				@endif
			@endforeach
        </div>
    </div>
</div>

                    
                    
                    
                    
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
</div>
</section>





























    <div id="webinarReportModal" class="d-none">
        <h3 class="section-title after-line font-20 text-dark-blue">{{ trans('product.report_the_course') }}</h3>

        <form action="/course/{{ $course->id }}/report" method="post" class="mt-25">

            <div class="form-group">
                <label class="text-dark-blue font-14">{{ trans('product.reason') }}</label>
                <select id="reason" name="reason" class="form-control">
                    <option value="" selected disabled>{{ trans('product.select_reason') }}</option>

                    @foreach(getReportReasons() as $reason)
                        <option value="{{ $reason }}">{{ $reason }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label class="text-dark-blue font-14" for="message_to_reviewer">{{ trans('public.message_to_reviewer') }}</label>
                <textarea name="message" id="message_to_reviewer" class="form-control" rows="10"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <p class="text-gray font-16">{{ trans('product.report_modal_hint') }}</p>

            <div class="mt-30 d-flex align-items-center justify-content-end">
                <button type="button" class="js-course-report-submit btn btn-sm btn-primary">{{ trans('panel.report') }}</button>
                <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div>

    @include('web.default.course.share_modal')
    @include('web.default.course.buy_with_point_modal')
@endsection

@push('scripts_bottom')
<script src="/assets/default/js/helpers.js"></script>
    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>

    <script>
        var webinarDemoLang = '{{ trans('webinars.webinar_demo') }}';
        var replyLang = '{{ trans('panel.reply') }}';
        var closeLang = '{{ trans('public.close') }}';
        var saveLang = '{{ trans('public.save') }}';
        var reportLang = '{{ trans('panel.report') }}';
        var reportSuccessLang = '{{ trans('panel.report_success') }}';
        var reportFailLang = '{{ trans('panel.report_fail') }}';
        var messageToReviewerLang = '{{ trans('public.message_to_reviewer') }}';
        var copyLang = '{{ trans('public.copy') }}';
        var copiedLang = '{{ trans('public.copied') }}';
        var learningToggleLangSuccess = '{{ trans('public.course_learning_change_status_success') }}';
        var learningToggleLangError = '{{ trans('public.course_learning_change_status_error') }}';
        var notLoginToastTitleLang = '{{ trans('public.not_login_toast_lang') }}';
        var notLoginToastMsgLang = '{{ trans('public.not_login_toast_msg_lang') }}';
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
        var canNotTryAgainQuizToastTitleLang = '{{ trans('public.can_not_try_again_quiz_toast_lang') }}';
        var canNotTryAgainQuizToastMsgLang = '{{ trans('public.can_not_try_again_quiz_toast_msg_lang') }}';
        var canNotDownloadCertificateToastTitleLang = '{{ trans('public.can_not_download_certificate_toast_lang') }}';
        var canNotDownloadCertificateToastMsgLang = '{{ trans('public.can_not_download_certificate_toast_msg_lang') }}';
        var sessionFinishedToastTitleLang = '{{ trans('public.session_finished_toast_title_lang') }}';
        var sessionFinishedToastMsgLang = '{{ trans('public.session_finished_toast_msg_lang') }}';
        var sequenceContentErrorModalTitle = '{{ trans('update.sequence_content_error_modal_title') }}';
        var courseHasBoughtStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasBoughtStatusToastMsgLang = '{{ trans('site.you_bought_webinar') }}';
        var courseNotCapacityStatusToastTitleLang = '{{ trans('public.request_failed') }}';
        var courseNotCapacityStatusToastMsgLang = '{{ trans('cart.course_not_capacity') }}';
        var courseHasStartedStatusToastTitleLang = '{{ trans('cart.fail_purchase') }}';
        var courseHasStartedStatusToastMsgLang = '{{ trans('update.class_has_started') }}';

    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/webinar_show.min.js"></script>
    <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script>
      feather.replace()
    </script>
@if (!auth()->subscription('courses'))
    <script>
        if( $(".subscription-modal").length > 0){
            $(".subscription-modal").modal('show');
        }
    </script>
@endif

<script>
$(document).on('click', '.view-change-btn', function (e) {
	
	$(".view-change-btn").removeClass('active');
	$(this).addClass('active');
	var view_chapter = $(this).attr('data-type');
	$(".chapter-views").addClass('rurera-hide');
	$(".chapter-views."+view_chapter).removeClass('rurera-hide');
});
</script>

@endpush
