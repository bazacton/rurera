@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/chartjs/chart.min.css"/>
<link rel="stylesheet" href="/assets/default/vendors/apexcharts/apexcharts.css"/>
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="">

    <div class="bg-white dashboard-banner-container position-relative px-15 px-ld-35 py-10 panel-shadow panel-border rounded-sm">
        <h2 class="font-30 text-primary line-height-1">
            <span class="d-block">{{ trans('panel.hi') }} {{ $authUser->get_full_name() }},</span>
            <span class="font-16 font-weight-bold">{{ trans('panel.have_event',['count' => !empty($unReadNotifications) ? count($unReadNotifications) : 0]) }}</span>
        </h2>

        <ul class="mt-15 unread-notification-lists">
            @if(!empty($unReadNotifications) and !$unReadNotifications->isEmpty())
            @foreach($unReadNotifications->take(5) as $unReadNotification)
            <li class="font-14 mt-1 text-gray">- {{ $unReadNotification->title }}</li>
            @endforeach

            @if(count($unReadNotifications) > 5)
            <li>&nbsp;&nbsp;...</li>
            @endif
            @endif
        </ul>

        <a href="/panel/notifications" class="mt-15 font-weight-500 text-dark-blue d-inline-block">{{
            trans('panel.view_all_events') }}</a>

        <div class="dashboard-banner">
            <img src="{{ getPageBackgroundSettings('dashboard') }}" alt="" class="img-cover">
        </div>
    </div>

    <!-- <section class="assignments-table count-number-wrapp mt-30">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
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
    </section>-->


</section>
<div class="dashboard-cards-holder">
    <div class="row mt-35">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dashboard-card panel-border rounded-sm bg-white mb-30 text-center">
                <span class="icon-box"><img src="/assets/default/svgs/plus.svg"></span>
                <h5 class="font-18 font-weight-bold mb-5"><a href="#">Start New Website</a></h5>
                <span class="d-block mb-10">Create an entirely new website</span>
                <a href="#" class="select-btn d-inline-block font-weight-500 rounded-sm mt-10">Select</a>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dashboard-card panel-border rounded-sm bg-white mb-30 text-center">
                <span class="icon-box"><img src="/assets/default/svgs/arrow-right.svg"></span>
                <h5 class="font-18 font-weight-bold mb-5"><a href="#">Migrate Website</a></h5>
                <span class="d-block mb-10">Move over an existing website</span>
                <a href="#" class="select-btn d-inline-block font-weight-500 rounded-sm mt-10">Select</a>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dashboard-card panel-border rounded-sm bg-white mb-30 text-center">
                <span class="icon-box"><img src="/assets/default/svgs/file-code.svg"></span>
                <h5 class="font-18 font-weight-bold mb-5"><a href="#">Start Site</a></h5>
                <span class="d-block mb-10">Let's build your website together</span>
                <a href="#" class="select-btn d-inline-block font-weight-500 rounded-sm mt-10">Select</a>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dashboard-card panel-border rounded-sm bg-white mb-30 text-center">
                <span class="icon-box"><img src="/assets/default/svgs/skip.svg"></span>
                <h5 class="font-18 font-weight-bold mb-5"><a href="#">Sip This</a></h5>
                <span class="d-block mb-10">I will take care of the setup myself</span>
                <a href="#" class="select-btn d-inline-block font-weight-500 rounded-sm mt-10">Select</a>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dashboard-card completed panel-border rounded-sm mb-30 text-center">
                <span class="icon-box"><img src="/assets/default/svgs/check-white.svg"></span>
                <h5 class="font-18 font-weight-bold mb-5"><a href="#">Completed</a></h5>
                <span class="d-block mb-10">Let's build your website together</span>
                <a href="#" class="select-btn d-inline-block font-weight-500 rounded-sm mt-10">Select</a>
            </div>
        </div>
    </div>
</div>
@if(!auth()->user()->isUser())
	<div class="section-title text-left mb-30">
		<h2 class="font-22">Set Work</h2>
	</div>
	@include('web.default.panel.set_work.set_work_listing',['assignments' => $assignments])
@endif
@if(auth()->user()->isUser())
	
@if( $continueTests->count() > 0)

	<div class="quests-list quests-learning">
		<div class="section-title text-left mb-30">
			<h2 class="font-22">Continue Tests</h2>
		<section class="dashboard mb-60">
			<div class="db-form-tabs">
				<div class="db-members">
					<div class="row g-3 list-unstyled students-requests-list">
						@foreach( $continueTests as $resultObj)
							<div class="col-12 col-lg-12 students-requests-list-item">
								<div class="notification-card rounded-sm panel-shadow bg-white py-15 py-lg-20 px-15 px-lg-40 mt-20">
									<div class="row align-items-center">
										<div class="col-12 col-lg-3 mt-10 mt-lg-0 d-flex align-items-start">
											<span class="notification-badge badge badge-circle-danger mr-5 mt-5 d-flex align-items-center justify-content-center"></span>
											<div class="">
												<h3 class="notification-title font-16 font-weight-bold text-dark-blue">{{$resultObj->parentQuiz->getTitleAttribute()}}</h3>
												<span class="notification-time d-block font-12 text-gray mt-5">{{dateTimeFormat($resultObj->created_at, 'j M Y')}}</span>
											</div>
										</div>
										<div class="col-12 col-lg-5 mt-10 mt-lg-0">
											<span class="font-weight-500 text-gray font-14"></span>
										</div>
										<div class="col-12 col-lg-4 mt-10 mt-lg-0 text-right">
											<a href="/sats/{{$resultObj->parentQuiz->quiz_slug}}" data-request_type="approved" class="request-action-btn js-show-message btn btn-border-white">Resume Test</a>
										</div>
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



<div class="quests-list quests-learning">
	<div class="section-title text-left mb-30">
		<h2 class="font-22">Learning Journeys</h2>
	</div>
	<ul>
		<li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-20 bg-danger">
			<div class="quests-item">
				<div class="icon-box">
					<img src="/assets/default/img/types/timestables.svg" alt="">
				</div>
				<div class="item-text">
					<h5 class="font-18 font-weight-bold">English</h5>
					<div class="levels-progress horizontal">
						<span class="progress-box">
							<span class="progress-count" style="width: 0%;"></span>
						</span>
					</div>
					<span class="progress-icon font-16 font-weight-normal">
						<img src="/assets/default/img/quests-coin.png" alt="">
						+20
					</span>
					<span class="progress-info d-block pt-5">
						<strong>0/38</strong> correct questions this week
					</span>
				</div>
			</div>
		</li>
		<li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-20 bg-success">
			<div class="quests-item">
				<div class="icon-box">
					<img src="/assets/default/img/types/timestables.svg" alt="">
				</div>
				<div class="item-text">
					<h5 class="font-18 font-weight-bold">Verbal Reasoning</h5>
					<div class="levels-progress horizontal">
						<span class="progress-box">
							<span class="progress-count" style="width: 0%;"></span>
						</span>
					</div>
					<span class="progress-icon circle">
						<img src="/assets/default/svgs/check-border.svg" alt="" class="check-icon">
					</span>
					<span class="progress-info d-block pt-5">
						<strong>76/29</strong> correct questions this week
					</span>
				</div>
			</div>
		</li>
		<li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-20">
			<div class="quests-item">
				<div class="icon-box">
					<img src="/assets/default/img/types/timestables.svg" alt="">
				</div>
				<div class="item-text">
					<h5 class="font-18 font-weight-bold">Maths</h5>
					<div class="levels-progress horizontal">
						<span class="progress-box">
							<span class="progress-count" style="width: 0%;"></span>
						</span>
					</div>
					<span class="progress-icon font-16 font-weight-normal">
						<img src="/assets/default/img/quests-coin.png" alt="">
						+20
					</span>
					<span class="progress-info d-block pt-5">
						<strong>0/39</strong> correct questions this week
					</span>
				</div>
			</div>
		</li>
		<li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-0 bg-warning">
			<div class="quests-item">
				<div class="icon-box">
					<img src="/assets/default/img/types/timestables.svg" alt="">
				</div>
				<div class="item-text">
					<h5 class="font-18 font-weight-bold">Non-Verbal Reasoning</h5>
					<div class="levels-progress horizontal">
						<span class="progress-box">
							<span class="progress-count" style="width: 0%;"></span>
						</span>
					</div>
					<span class="progress-icon circle">
						<img src="/assets/default/svgs/check-border.svg" alt="" class="check-icon">
					</span>
					<span class="progress-info d-block pt-5">
						<strong>58/29</strong> correct questions this week
					</span>
				</div>
			</div>
		</li>
	</ul>
</div>
@endif
<div class="dashboard">
    @if(auth()->check() && (auth()->user()->isUser()))
	<div class="section-title text-left mt-30">
		<h2 class="font-22">Tasks List</h2>
	</div>
    <div class="row">
        <div class="col-12 col-lg-12 mt-35">
            <div class="assignments-table panel-border">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active user-assignments-tab" data-type="current" data-content_id="homeworks" id="homeworks-tab" data-toggle="tab" href="#homeworks" role="tab"
                           aria-controls="homeworks" aria-selected="true">To Do List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link user-assignments-tab" data-type="previous" data-content_id="recent" id="recent-tab" data-toggle="tab" href="#recent" role="tab"
                           aria-controls="recent" aria-selected="false">Recently Completed</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="homeworks" role="tabpanel"
                         aria-labelledby="homeworks-tab">
                        <div class="assignments-list">
                            <ul>
                                @if( $assignmentsArray->count() > 0 )
                                @foreach( $assignmentsArray as $assignmentObj)
                                @php
                                $assignmentTitle = $assignmentObj->StudentAssignmentData->title;
                                $assignmentLink = '/assignment/'.$assignmentObj->id;
                                $assignmentTitle .= '<span>'.dateTimeFormat($assignmentObj->deadline_date, 'd F Y').'</span>';
                                @endphp
                                <li>
                                    <div class="checkbox-field">
                                        <input type="checkbox" id="book">
                                        <label for="book">
                                            <a href="{{$assignmentLink}}">{!! $assignmentTitle !!}</a>
                                            <span>{{$assignmentObj->topic_type}}</span>
                                        </label>
                                    </div>
                                    <div class="assignment-controls">
                                        <span class="status-label success">{{$assignmentObj->status}}</span>
                                        <div class="controls-holder">

                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @else
                                <li>
                                    No assigned assignments at the moment
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                        <div class="assignments-list">
                            <ul>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(auth()->check() && (auth()->user()->isUser()))
    <div class="row rurera-hide">
        <div class="col-12 col-lg-12 mt-35">
            <section class="product-tabs-section panel-border">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-tabs">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="trending-toys-tab" data-toggle="tab"
                                           href="#trending-toys" role="tab" aria-controls="trending-toys"
                                           aria-selected="true">Trending Toys</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="shortlisted-toys-tab" data-toggle="tab"
                                           href="#shortlisted-toys" role="tab" aria-controls="shortlisted-toys"
                                           aria-selected="false">Favorite Toys</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="entitled-toys-tab" data-toggle="tab"
                                           href="#entitled-toys" role="tab" aria-controls="entitled-toys"
                                           aria-selected="false">Entitled Toys</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="productTabContent">
                                    <div class="tab-pane fade active show" id="trending-toys" role="tabpanel"
                                         aria-labelledby="trending-toys-tab">
                                        <div class="swiper-container product-tabs-slider">
                                            <div class="swiper-wrapper">
                                                @if( isset( $trending_toys ) && $trending_toys->count() > 0)
                                                    @foreach( $trending_toys as $product)
                                                        @php
                                                            $hasDiscount = $product->getActiveDiscount();
                                                        @endphp
                                                        <div class="swiper-slide">
                                                            <div class="product-card">
                                                                <figure>
                                                                    @include('web.default.products.includes.card')
                                                                </figure>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <!-- Add Arrows -->
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-button-next"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="shortlisted-toys" role="tabpanel"
                                         aria-labelledby="shortlisted-toys-tab">
                                        <div class="swiper-container product-tabs-slider">
                                            <div class="swiper-wrapper">
                                                @if( isset( $shortlisted_toys ) && $shortlisted_toys->count() > 0)
                                                    @foreach( $shortlisted_toys as $product)
                                                        @php
                                                            $hasDiscount = $product->getActiveDiscount();
                                                        @endphp
                                                        <div class="swiper-slide">
                                                            <div class="product-card">
                                                                <figure>
                                                                    @include('web.default.products.includes.card')
                                                                </figure>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <!-- Add Arrows -->
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-button-next"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="entitled-toys" role="tabpanel"
                                         aria-labelledby="entitled-toys-tab">
                                        <div class="swiper-container product-tabs-slider">
                                            <div class="swiper-wrapper">
                                                @if( isset( $entitled_toys ) && $entitled_toys->count() > 0)
                                                    @foreach( $entitled_toys as $product)
                                                        @php
                                                            $hasDiscount = $product->getActiveDiscount();
                                                        @endphp
                                                        <div class="swiper-slide">
                                                            <div class="product-card">
                                                                <figure>
                                                                    @include('web.default.products.includes.card')
                                                                </figure>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <!-- Add Arrows -->
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-button-next"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--<section>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="verticle-tabs">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                                       href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                        <div class="count-number-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-edit-2" style="color:#8cc811">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                            </svg>
                                        </div>
                                        <div class="count-number-body">
                                            <span>Assessments</span>
                                            <strong>48</strong>
                                            <h5>Courses</h5>
                                        </div>
                                    </a>
                                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                       href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                        <div class="count-number-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-clock" style="color:#00aeef">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                        </div>
                                        <div class="count-number-body">
                                            <span>Q. Attempt</span>
                                            <strong>300</strong>
                                            <h5>SATS</h5>
                                        </div>
                                    </a>
                                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill"
                                       href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                        <div class="count-number-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-bar-chart" style="color:#e67035">
                                                <line x1="12" y1="20" x2="12" y2="10"></line>
                                                <line x1="18" y1="20" x2="18" y2="4"></line>
                                                <line x1="6" y1="20" x2="6" y2="16"></line>
                                            </svg>
                                        </div>
                                        <div class="count-number-body">
                                            <span>Coins</span>
                                            <strong>5000</strong>
                                            <h5>11+</h5>
                                        </div>
                                    </a>
                                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill"
                                       href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                        <div class="count-number-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-bar-chart" style="color:#e67035">
                                                <line x1="12" y1="20" x2="12" y2="10"></line>
                                                <line x1="18" y1="20" x2="18" y2="4"></line>
                                                <line x1="6" y1="20" x2="6" y2="16"></line>
                                            </svg>
                                        </div>
                                        <div class="count-number-body">
                                            <span>Assessments</span>
                                            <strong>73</strong>
                                            <h5>Books</h5>
                                        </div>
                                    </a>
                                </div>
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                         aria-labelledby="v-pills-home-tab">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="chart-box">
                                                    <div class="chart-title text-center">
                                                        <h2>Pageviews</h2>
                                                    </div>
                                                    <div class="chart">
                                                        <canvas id="chartBarHorizontal2" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                         aria-labelledby="v-pills-profile-tab">
                                        Profile
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                         aria-labelledby="v-pills-messages-tab">
                                        Messages
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                         aria-labelledby="v-pills-settings-tab">
                                        Settings
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>-->
        </div>
    </div>
    @endif

    <!-- <div class="row">
        <div class="col-12 col-lg-3 mt-35">
            <a href="@if($authUser->isUser()) /panel/webinars/purchases @else /panel/meetings/requests @endif" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center">
                <div class="stat-icon requests">
                    <img src="/assets/default/img/icons/request.svg" alt="">
                </div>
                <div class="d-flex flex-column ml-15">
                    <span class="font-30 text-secondary">{{ !empty($pendingAppointments) ? $pendingAppointments : (!empty($webinarsCount) ? $webinarsCount : 0) }}</span>
                    <span class="font-16 text-gray font-weight-500">{{ $authUser->isUser() ? trans('panel.purchased_courses') : trans('panel.pending_appointments') }}</span>
                </div>
            </a>

            <a href="@if($authUser->isUser()) /panel/meetings/reservation @else /panel/financial/sales @endif" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center mt-15 mt-md-30">
                <div class="stat-icon monthly-sales">
                    <img src="@if($authUser->isUser()) /assets/default/img/icons/meeting.svg @else /assets/default/img/icons/monay.svg @endif" alt="">
                </div>
                <div class="d-flex flex-column ml-15">
                    <span class="font-30 text-secondary">{{ !empty($monthlySalesCount) ? handlePrice($monthlySalesCount) : (!empty($reserveMeetingsCount) ? $reserveMeetingsCount : 0) }}</span>
                    <span class="font-16 text-gray font-weight-500">{{ $authUser->isUser() ? trans('panel.meetings') : trans('panel.monthly_sales') }}</span>
                </div>
            </a>
        </div>

        <div class="col-12 col-lg-3 mt-35">
            <a href="/panel/support" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center">
                <div class="stat-icon support-messages">
                    <img src="/assets/default/img/icons/support.svg" alt="">
                </div>
                <div class="d-flex flex-column ml-15">
                    <span class="font-30 text-secondary">{{ !empty($supportsCount) ? $supportsCount : 0 }}</span>
                    <span class="font-16 text-gray font-weight-500">{{ trans('panel.support_messages') }}</span>
                </div>
            </a>

            <a href="@if($authUser->isUser()) /panel/webinars/my-comments @else /panel/webinars/comments @endif" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center mt-15 mt-md-30">
                <div class="stat-icon comments">
                    <img src="/assets/default/img/icons/comment.svg" alt="">
                </div>
                <div class="d-flex flex-column ml-15">
                    <span class="font-30 text-secondary">{{ !empty($commentsCount) ? $commentsCount : 0 }}</span>
                    <span class="font-16 text-gray font-weight-500">{{ trans('panel.comments') }}</span>
                </div>
            </a>
        </div>

        <div class="col-12 col-lg-3 mt-35">
            <div class="bg-white account-balance rounded-sm panel-shadow py-15 py-md-15 px-10 px-md-20">
                <div data-percent="{{ !empty($nextBadge) ? $nextBadge['percent'] : 0 }}" data-label="{{ (!empty($nextBadge) and !empty($nextBadge['earned'])) ? $nextBadge['earned']->title : '' }}" id="nextBadgeChart" class="text-center">
                </div>
                <div class="mt-10 pt-10 border-top border-gray300 d-flex align-items-center justify-content-between">
                    <span class="font-16 font-weight-500 text-gray">{{ trans('panel.next_badge') }}:</span>
                    <span class="font-16 font-weight-bold text-secondary">{{ (!empty($nextBadge) and !empty($nextBadge['badge'])) ? $nextBadge['badge']->title : trans('public.not_defined') }}</span>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="row">
        <div class="col-12 col-lg-12 mt-35">
            <div class="bg-white noticeboard rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('panel.noticeboard') }}</h3>

                @foreach($authUser->getUnreadNoticeboards() as $getUnreadNoticeboard)
                <div class="noticeboard-item py-15">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="js-noticeboard-title font-weight-500 text-secondary">{!!
                                truncate($getUnreadNoticeboard->title,150) !!}</h4>
                            <div class="font-12 text-gray mt-5">
                                <span class="mr-5">{{ trans('public.created_by') }} {{ $getUnreadNoticeboard->sender }}</span>
                                |
                                <span class="js-noticeboard-time ml-5">{{ dateTimeFormat($getUnreadNoticeboard->created_at,'j M Y | H:i') }}</span>
                            </div>
                        </div>

                        <div>
                            <button type="button" data-id="{{ $getUnreadNoticeboard->id }}"
                                    class="js-noticeboard-info btn btn-sm btn-border-white">{{ trans('panel.more_info')
                                }}
                            </button>
                            <input type="hidden" class="js-noticeboard-message"
                                   value="{{ $getUnreadNoticeboard->message }}">
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div> -->
    </div>
    </section>
    <!--<section style="padding: 0 0 60px;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9 col-md-8 mt-35">
                    <div class="bg-white monthly-sales-card rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="font-16 text-dark-blue font-weight-bold">{{ ($authUser->isUser()) ?
                                trans('panel.learning_statistics') : trans('panel.monthly_sales') }}</h3>

                            <span class="font-16 font-weight-500 text-gray">{{ dateTimeFormat(time(),'M Y') }}</span>
                        </div>

                        <div class="monthly-sales-chart">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-4 mt-35">
                    <div class="assignments-table count-number-wrapp">
                        <ul class="count-number-boxes count-number-verticle row">
                            <li class="count-number-card col-12">
                                <a href="#" class="count-number-btn">
                                    <div class="count-number-icon">
                                        <i data-feather="edit-2" width="20" height="20" class=""
                                           style="color:#8cc811"></i>
                                    </div>
                                    <div class="count-number-body">
                                        <h5>Assessments</h5>
                                        <strong>48</strong>
                                        <h5>Courses</h5>
                                    </div>
                                </a>
                            </li>
                            <li class="count-number-card col-12">
                                <a href="#" class="count-number-btn">
                                    <div class="count-number-icon">
                                        <i data-feather="clock" width="20" height="20" class=""
                                           style="color:#00aeef"></i>
                                    </div>
                                    <div class="count-number-body">
                                        <h5>Q. Attempt</h5>
                                        <strong>300</strong>
                                        <h5>SATS</h5>
                                    </div>
                                </a>
                            </li>
                            <li class="count-number-card col-12">
                                <a href="#" class="count-number-btn">
                                    <div class="count-number-icon">
                                        <i data-feather="bar-chart" width="20" height="20" class=""
                                           style="color:#e67035"></i>
                                    </div>
                                    <div class="count-number-body">
                                        <h5>Coins</h5>
                                        <strong>5000</strong>
                                        <h5>11+</h5>
                                    </div>
                                </a>
                            </li>
                            <li class="count-number-card col-12">
                                <a href="#" class="count-number-btn">
                                    <div class="count-number-icon">
                                        <i data-feather="bar-chart" width="20" height="20" class=""
                                           style="color:#e67035"></i>
                                    </div>
                                    <div class="count-number-body">
                                        <h5>Assessments</h5>
                                        <strong>73</strong>
                                        <h5>Books</h5>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>-->


    <div class="d-none" id="iNotAvailableModal">
        <div class="offline-modal">
            <h3 class="section-title after-line">{{ trans('panel.offline_title') }}</h3>
            <p class="mt-20 font-16 text-gray">{{ trans('panel.offline_hint') }}</p>

            <div class="form-group mt-15">
                <label>{{ trans('panel.offline_message') }}</label>
                <textarea name="message" rows="4" class="form-control ">{{ $authUser->offline_message }}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="mt-30 d-flex align-items-center justify-content-end">
                <button type="button" class="js-save-offline-toggle btn btn-primary btn-sm">{{ trans('public.save') }}
                </button>
                <button type="button" class="btn btn-danger ml-10 close-swl btn-sm">{{ trans('public.close') }}</button>
            </div>
        </div>
    </div>

    <div class="d-none" id="noticeboardMessageModal">
        <div class="text-center">
            <h3 class="modal-title font-20 font-weight-500 text-dark-blue"></h3>
            <span class="modal-time d-block font-12 text-gray mt-25"></span>
            <p class="modal-message font-weight-500 text-gray mt-4"></p>
        </div>
    </div>

    @endsection

    @push('scripts_bottom')

    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/default/vendors/chartjs/chart.min.js"></script>

    <script>
        var offlineSuccess = '';
        var $chartDataMonths = @json($monthlyChart['months']);
        var $chartData = @json($monthlyChart['data']);
    </script>

    <script src="/assets/default/js/panel/dashboard.min.js"></script>
    <script type="text/javascript">
        feather.replace();
    </script>
		<script type="text/javascript">
var searchRequest = null;
$('body').on('click', '.set-work-ajax li', function (e) {
    rurera_loader($(".set-work-content"), 'div');
    $(".set-work-ajax li").removeAttr('class');
    $(this).addClass('active');
    var assignment_status = $(this).attr('data-type');
    searchRequest = jQuery.ajax({
        type: "GET",
        url: '/panel/set-work/search',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            if (searchRequest != null) {
                searchRequest.abort();
            }
        },
        data: {"assignment_status": assignment_status},
        success: function (return_data) {
            rurera_remove_loader($(".set-work-content"), 'div');
            $(".set-work-content").html(return_data);
        }
    });

});
</script>
    @endpush

    @if(!empty($giftModal))
    @push('scripts_bottom2')
    <script>
        (function () {
            "use strict";

            handleLimitedAccountModal('{!! $giftModal !!}', 40)
        })(jQuery)
    </script>

    @endpush
    @endif

