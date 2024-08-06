@extends(getTemplate() .'.panel.layouts.panel_layout_full')

@push('styles_top')
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343 !important;
    }
    .hide {
        display: none;
    }
	.emoji-icons {display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-start;min-height: auto;}
    .emoji-icons .emoji-icon {border-radius: 100%; display: inline-block; object-fit: contain; height: 28px;}
    .emoji-icons .emoji-icon img {max-width: 100%; }
</style>
<script src="https://js.stripe.com/v3/"></script>
<link rel="stylesheet" href="/assets/admin/vendor/daterangepicker/daterangepicker.min.css">
@endpush
@php $schools = array(); $user = auth()->user();@endphp

@section('content')
<section class="member-card-header pb-50">
    <div class="d-flex align-items-center justify-content-between flex-md-row">
        <h1 class="section-title font-22">Students</h1>
        <div class="dropdown">
        <button type="button" class="btn btn-sm btn-primary subscription-modal {{($childs->count() == 0)? 'add-child-btn' : ''}}" data-type="child_register" data-id="0">
            <img src="/assets/default/svgs/add-con.svg"> Add Student
        </button>
		<button type="button" class="btn btn-sm btn-primary link-student-modal" data-type="child_register" data-id="0">
            <img src="/assets/default/svgs/add-con.svg"> Link Student
        </button>

    </div>
    </div>
</section>

@if( $studentsRequests->count() > 0)
<section class="dashboard mb-60">

    <div class="db-form-tabs">
        <div class="db-members">
            <div class="row g-3 list-unstyled students-requests-list">
			
				@foreach( $studentsRequests as $studentsRequestObj)
						<div class="col-12 col-lg-12 students-requests-list-item">
							<div class="notification-card rounded-sm panel-shadow bg-white py-15 py-lg-20 px-15 px-lg-40 mt-20">
								<div class="row align-items-center">
									<div class="col-12 col-lg-3 mt-10 mt-lg-0 d-flex align-items-start">
										<span class="notification-badge badge badge-circle-danger mr-5 mt-5 d-flex align-items-center justify-content-center"></span>
										<div class="">
											<h3 class="notification-title font-16 font-weight-bold text-dark-blue">{{$studentsRequestObj->student->get_full_name()}}</h3>
											<span class="notification-time d-block font-12 text-gray mt-5">{{dateTimeFormat($studentsRequestObj->created_at, 'j M Y')}}</span>
										</div>
									</div>

									<div class="col-12 col-lg-5 mt-10 mt-lg-0">
										<span class="font-weight-500 text-gray font-16"><p>By granting them access, you are allowing the {{$studentsRequestObj->requestBy->get_full_name()}} to manage the {{$studentsRequestObj->student->get_full_name()}} account.</p></span>
									</div>

									<div class="col-12 col-lg-4 mt-10 mt-lg-0 text-right">
										<button type="button" data-id="{{$studentsRequestObj->id}}" id="showNotificationMessage2261" data-request_type="approved" class="request-action-btn js-show-message btn btn-border-white approve-btn">Approve</button>
										<button type="button" data-id="{{$studentsRequestObj->id}}" id="showNotificationMessage2261" data-request_type="rejected" class="request-action-btn js-show-message btn btn-border-white reject-btn">Reject</button>
									</div>
								</div>
							</div>
						</div>
				@endforeach
				
			</div>
		</div>
	</div>
</section>
@endif
<section class="dashboard">

    <div class="db-form-tabs">
        <div class="db-members">
            <div class="row g-3 list-unstyled">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="list-group list-group-custom list-group-flush mb-0 totalChilds"
                                 data-childs="{{$childs->count()}}">

                                @if( !empty( $childs ) )
                                @foreach($childs as $childLinkObj)
                                @php $childObj = $childLinkObj->user; @endphp
                                @php $is_cancelled = (isset( $childObj->userSubscriptions->subscribe ) && $childObj->userSubscriptions->is_cancelled == 1 )? 'cancelled-membership' : ''; 
								$subscribe = isset( $childObj->userSubscriptions->subscribe)? $childObj->userSubscriptions->subscribe : (object) array();
								$emoji_response = '';
								$emojisArray = explode('icon', $childObj->login_emoji);
									if( !empty( $emojisArray ) ){
										$emoji_response .= '<div class="emoji-icons">';
										foreach( $emojisArray as $emojiCode){
											if( $emojiCode != ''){
												$emoji_response .= '<a id="icon1" href="javascript:;" class="emoji-icon"><img src="/assets/default/svgs/emojis/icon'.$emojiCode.'.svg"></a>';
											}
										}
										$emoji_response .= '</div>';
									}
								@endphp
								

                                <div class="list-group-item {{$is_cancelled}}">
								
								
									<div class="package-data rurera-hide">
									@if( isset( $subscribe->id))
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="subscribe-plan active current-plan position-relative d-flex flex-column rounded-lg pb-25 pt-60 px-20 mb-30">
											<span class="subscribe-icon mb-20"><img src="{{ $subscribe->icon }}" height="auto" width="auto" alt="Box image"/></span>
											<div class="subscribe-title">
												<h3 itemprop="title" class="font-24 font-weight-500">{{ $subscribe->title }}</h3>
											</div>
											<div class="d-flex align-items-start text-dark-charcoal mb-20 subscribe-price">
												<span itemprop="price" class="font-36 line-height-1 packages-prices" data-package_price="{{$subscribe->price}}">{{ addCurrencyToPrice($subscribe->price) }}</span><span
														class="yearly-price">{{ addCurrencyToPrice($subscribe->price) }} / month</span>
											</div>
											<button itemprop="button" type="submit" 
													class="package-selection btn w-100 disabled-style disabled-div">Subscribed
											</button>
											<span class="plan-label d-block font-weight-500 pt-20">
																				Suitable for:
																			</span>
											<ul class="mt-10 plan-feature">
												<li class="mt-10">Grammar school entrance</li>
												<li class="mt-10">Independent school entrance</li>
											</ul>
											<span class="plan-label d-block font-weight-500 pt-20">
																				Subjects:
																			</span>
											<ul class="mt-10 plan-feature">
												@php $is_available = ($subscribe->is_courses > 0)? '' : 'subscribe-no'; @endphp
												<li class="mt-10 {{$is_available}}">English, Maths, Science , Computer</li>
												<li class="mt-10 {{$is_available}}">Verbal reasoning, non-verbal reasoning</li>
												@php $is_available = ($subscribe->is_timestables > 0)? '' : 'subscribe-no'; @endphp
												<li class="mt-10 {{$is_available}}">Times Tables Practice</li>
												@php $is_available = ($subscribe->is_vocabulary > 0)? '' : 'subscribe-no'; @endphp
												<li class="mt-10 {{$is_available}}">Vocabulary</li>
												@php $is_available = ($subscribe->is_bookshelf > 0)? '' : 'subscribe-no'; @endphp
												<li class="mt-10 {{$is_available}}">Bookshelf</li>
											</ul>
											<span class="plan-label d-block font-weight-500 pt-20">
																				Mock Tests Prep:
																			</span>
											<ul class="mt-10 plan-feature">
												@php $is_available = ($subscribe->is_sats > 0)? '' : 'subscribe-no'; @endphp
												<li class="mt-10 {{$is_available}}">SATs</li>
												@php $is_available = ($subscribe->is_elevenplus > 0)? '' : 'subscribe-no'; @endphp
												<li class="mt-10 {{$is_available}}">ISEB Common Pre-Tests</li>
												<li class="mt-10 {{$is_available}}">GL 11+</li>
												<li class="mt-10 {{$is_available}}">CAT4</li>
											</ul>
										</div>
									</div>
									@endif
								</div>
								<span class="emojis-response rurera-hide">{!! $emoji_response !!}</span>
								<span class="pin-response rurera-hide">{{$childObj->login_pin}}</span>
								
                                    <div class="row align-items-center">
										<a href="/{{panelRoute()}}/students/{{$childObj->username}}" class="col-auto">
                                            <h6 class="listing-title font-16 font-weight-500">Student</h6>
                                            <img
                                                        src="{{$childObj->getAvatar()}}"
                                                        alt="{{$childObj->get_full_name()}}"
                                                        class="avatar rounded-circle">
										</a>

										<a href="/{{panelRoute()}}/students/{{$childObj->username}}" class="col-auto  ms-2">
												<h6 class="font-16 font-weight-normal">{{$childObj->get_full_name()}}</h6>
												
												<small class="text-muted">
													{{isset($childObj->userYear->id )? $childObj->userYear->getTitleAttribute() : ''}} {{isset($childObj->userClass->title)? $childObj->userClass->title : ''}} {{isset( $childObj->userSection->title )? $childObj->userSection->title : ''}}
												</small>
										</a>
                                        <div class="col-auto last-activity">
                                            <h6 class="listing-title font-16 font-weight-500">Membership</h6>
                                            <span class="font-16 d-block">
                                                @php $package_id = 0;

                                                @endphp
                                                @if(isset( $childObj->userSubscriptions->subscribe ) )
                                                @php $package_id = $childObj->userSubscriptions->subscribe->id;
                                                @endphp
                                                {{$childObj->userSubscriptions->subscribe->getTitleAttribute()}}
                                                @php
                                                $expiry_at = $childObj->userSubscriptions->expiry_at;
                                                @endphp
                                                @else
                                                    @if(!isset( $childObj->userSubscriptions->subscribe ) )
                                                        <a href="javascript:;" class="package-payment-btn subscription-modal" data-type="child_payment" data-id="{{$childObj->id}}">
                                                            + Add Membership
                                                        </a>
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
										<a href="/{{panelRoute()}}/students/{{$childObj->username}}" class="col-auto last-activity">
                                            <h6 class="listing-title font-16 font-weight-500">School</h6>
                                            <span class="font-16 d-block">
                                                {{isset($childObj->userSchool->title)? $childObj->userSchool->title : '-'}}
                                            </span>
                                        </a>

										<a href="/{{panelRoute()}}/students/{{$childObj->username}}" class="col-auto last-activity">
                                            <h6 class="listing-title font-16 font-weight-500">Last Activity</h6>
                                            <span class="font-16 d-block"><strong class="font-weight-normal d-block">{{ ($childObj->getLastActivity() != '')? dateTimeFormat($childObj->getLastActivity(), 'j M Y') : '' }}</strong>
                                                {{ ($childObj->getLastActivity() != '')? 'Last Activity' : '' }}
                                            </span>
                                        </a>
                                        <div class="col-auto ms-auto last-activity profile-dropdown">
                                            <h6 class="listing-title font-16 font-weight-500">Action</h6>
                                            <a href="javascript:;" class="font-16 font-weight-normal">
                                                <span class="icon-box">
                                                    <img src="/assets/default/svgs/dots-circle.svg" alt="">
                                                </span>
                                            </a>
                                            <ul>
                                                <li><a href="/panel/switch_user/{{$childObj->id}}" class="switch-user-btn"><span class="icon-box"><img src="/assets/default/svgs/switch-user.svg" alt=""></span> Switch User</a></li>
												<li><a href="javascript:;" data-toggle="modal" data-target="#class-connect-modal" class="connect-user-btn" data-user_id="{{$childObj->id}}"><span class="icon-box"><img src="/assets/default/svgs/link-file.svg" alt=""></span> Connect to Class</a></li>
                                                @if(!isset( $childObj->userSubscriptions->subscribe ) )
                                                <li>
                                                    <a href="javascript:;" class="package-payment-btn switch-user-btn subscription-modal" data-type="child_payment" data-id="{{$childObj->id}}">
                                                        <span class="icon-box"><img src="/assets/default/svgs/package.svg" alt=""></span> Add Package
                                                    </a>
                                                </li>
                                                @else
                                                <li>
                                                    <a href="javascript:;" class="package-update-btn switch-user-btn subscription-modal" data-type="update_package" data-id="{{$childObj->id}}">
                                                        <span class="icon-box"><img src="/assets/default/svgs/package.svg" alt=""></span> Update Package
                                                    </a>
                                                </li>
                                                @endif                                             
                                                <li><a href="/panel/students/print-card/{{$childObj->id}}" target="_blank"><span class="icon-box"><img src="/assets/default/svgs/printer-activity.svg" alt=""></span> Print Login Card <Profile></Profile></a></li>
                                            </ul>
                                        </div>
                                    </div> <!--[ row end ]-->
                                </div>

                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade choose-expiry-modal update-expiry-model" id="update-expiry-modal" tabindex="-1"
         aria-labelledby="update-expiry-modalLabel" aria-hidden="true">


        <form action="/panel/financial/update_subscribe_plan" method="post" class="w-100">
            {{ csrf_field() }}

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <strong>Choose a plan</strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="col-12">


                            <div class="lms-form-wrapper mb-15">

                                <div class="lms-choose-plan d-flex mb-30">
                                    <div class="lms-choose-field">
                                        <strong class="choose-title d-block mb-20 font-24">Choose a plan</strong>
                                        <div class="lms-radio-select">
                                            <ul class="lms-radio-btn-group d-inline-flex align-items-center">

                                                @php
                                                $payment_frequency = isset( $userObj->payment_frequency )?
                                                $userObj->payment_frequency : 1; @endphp
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 1)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_month" value="1" data-discount="0"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_month">
                                                        <span>01 month</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 3)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_three_months" value="3"
                                                           data-discount="5"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_three_months">
                                                        <span>03 month <span>(5%)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 6)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_six_months" value="6"
                                                           data-discount="10"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_six_months">
                                                        <span>06 month <span>(10%)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 12)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_year" value="12" data-discount="20"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_year">
                                                        <span>whole year <span>(20%)</span></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary btn-block mt-50">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>

<div class="modal fade" id="addChildModal" tabindex="-1" aria-labelledby="addChildModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">


                    <div class="col-12">
                        @php $discount = isset( $ParentsOrders->payment_frequency )?
                        $frequency_discounts[$ParentsOrders->payment_frequency] : 0; @endphp


                        <div class="lms-form-wrapper mb-15">




                            <div class="childs-block">
                                <div class="child-item lms-choose-plan-selected">
                                    <div class="lms-jobs-form">
                                        <form action="/panel/financial/pay-subscribes" method="post" class="w-100 childs-form">
                                        {{ csrf_field() }}
                                        <div class="row user-details-block">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student's first name</span>
                                                <div class="input-field">
                                                    <input type="text" name="student_name"
                                                           placeholder="Student First Name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student's last name</span>
                                                <div class="input-field">
                                                    <input type="text" name="student_last_name"
                                                           placeholder="Student Last Name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student Username</span>
                                                <div class="input-field">
                                                    <input type="text" name="username"
                                                           placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student Password</span>
                                                <div class="input-field">
                                                    <input type="password" name="student_password"
                                                           placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student Preference</span>
                                                <div class="input-field">
                                                    <select class="form-control" name="user_preference">
                                                        <option value="">Preference</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student Year</span>
                                                <div class="input-field">
                                                    <select class="form-control"
                                                            name="year_id">
                                                        <option disabled>Choose Year</option>
                                                        @foreach($categories as $category)
                                                        @if(!empty($category->subCategories) and count($category->subCategories))
                                                        <optgroup label="{{  $category->title }}">
                                                            @foreach($category->subCategories as $subCategory)
                                                            <option value="{{ $subCategory->id }}">{{ $subCategory->title }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-block mt-50 childs-next-btn" style="background:#0272b6; color:#fff">Next
                                            </button>
                                        </div>
                                        </form>
                                        <div class="row choose-package-block rurera-hide">
                                            <form action="/panel/financial/pay-subscribes" method="post" class="w-100 package-form">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="user_id" class="package_user_id">
                                                @if( isset( $ParentsOrders->id ) )
                                            <input type="radio" class="hide subscribe_for" name="subscribe_for"
                                                   value="{{isset($ParentsOrders->payment_frequency)? $ParentsOrders->payment_frequency : 1}}"
                                                   data-discount="{{$discount}}" checked>
                                            @else
                                            <div class="lms-choose-plan d-flex mb-30">
                                                <div class="lms-choose-field">
                                                    <strong class="choose-title d-block mb-20 font-24">Choose a plan</strong>
                                                    <div class="lms-radio-select">
                                                        <ul class="lms-radio-btn-group d-inline-flex align-items-center">

                                                            @php
                                                            $payment_frequency = isset( $ParentsOrders->payment_frequency )?
                                                            $ParentsOrders->payment_frequency : 1; @endphp
                                                            <li>
                                                                @php $checked = (isset( $payment_frequency) &&
                                                                $payment_frequency == 1)? 'checked' : ''; @endphp
                                                                <input type="radio" id="month" value="1" data-discount="0"
                                                                       name="subscribe_for" {{$checked}}/>
                                                                <label class="lms-label" for="month">
                                                                    <span>01 month</span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                @php $checked = (isset( $payment_frequency) &&
                                                                $payment_frequency == 3)? 'checked' : ''; @endphp
                                                                <input type="radio" id="three_months" value="3" data-discount="5"
                                                                       name="subscribe_for" {{$checked}}/>
                                                                <label class="lms-label" for="three_months">
                                                                    <span>03 month <span>(5%)</span> </span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                @php $checked = (isset( $payment_frequency) &&
                                                                $payment_frequency == 6)? 'checked' : ''; @endphp
                                                                <input type="radio" id="six_months" value="6" data-discount="10"
                                                                       name="subscribe_for" {{$checked}}/>
                                                                <label class="lms-label" for="six_months">
                                                                    <span>06 month <span>(10%)</span> </span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                @php $checked = (isset( $payment_frequency) &&
                                                                $payment_frequency == 12)? 'checked' : ''; @endphp
                                                                <input type="radio" id="year" value="12" data-discount="20"
                                                                       name="subscribe_for" {{$checked}}/>
                                                                <label class="lms-label" for="year">
                                                                    <span>whole year <span>(20%)</span></span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <input type="hidden" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="1">

                                            <div class="col-12 col-lg-12 col-md-124">
                                                <strong class="choose-title d-block mb-10 font-24">Choose Package</strong>
                                                <div class="subscribe-plan-holder">
                                                    <div class="container">
                                                        <div class="row">
                                                            <input type="hidden" name="child_id" class="update_plan_child">
                                                            @if(!empty($subscribes) and !$subscribes->isEmpty())
                                                            @foreach($subscribes as $subscribe)

                                                            <div class="col-lg-6 col-md-6 col-sm-12">

                                                                <div class="select-plan">
                                                                    <input type="radio" class="package_id choose-package update-package-{{$subscribe->id}}"
                                                                           data-label="{{ $subscribe->title }}"
                                                                           id="up-{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                                                           value="{{ $subscribe->id }}" name="package_id">
                                                                    <label for="up-{{$subscribe->id}}" data-label="{{ $subscribe->title }}">
                                                                        <div class="subscribe-plan position-relative d-flex flex-column rounded-lg py-25 px-20">
                                                                            <span class="subscribe-icon mb-20">
                                                                                <img src="../assets/default/img/pig.png" height="auto" width="auto" alt="Box image">
                                                                            </span>
                                                                            <div class="subscribe-title">
                                                                                <h3 itemprop="title" class="font-24 font-weight-500">{{$subscribe->title }}</h3>
                                                                                <span>A simple start for everyone</span>
                                                                            </div>
                                                                            <div class="d-flex align-items-start mt-10 subscribe-price">
                                                                                <span itemprop="price" class="font-36 line-height-1">
                                                                                    {!! addCurrencyToPrice($subscribe->price, null, 'currency_small') !!}
                                                                                </span>
                                                                                <span class="yearly-price">$ 90 / year</span>
                                                                            </div>
                                                                            <span class="plan-label d-block font-weight-500 pt-20">For Teachers</span>
                                                                            <ul class="plan-feature">
                                                                                @php
                                                                                $is_course_class = ($subscribe->is_courses == 0)? 'subscribe-no' :
                                                                                '';
                                                                                $is_timestables_class = ($subscribe->is_timestables == 0)?
                                                                                'subscribe-no' : '';
                                                                                $is_bookshelf_class = ($subscribe->is_bookshelf == 0)?
                                                                                'subscribe-no' : '';
                                                                                $is_sats_class = ($subscribe->is_sats == 0)? 'subscribe-no' : '';
                                                                                $is_elevenplus_class = ($subscribe->is_elevenplus == 0)?
                                                                                'subscribe-no' : '';
                                                                                $is_vocabulary_class = ($subscribe->is_vocabulary == 0)?
                                                                                'subscribe-no' : '';
                                                                                @endphp

                                                                                <li itemprop="list" class="mt-15 {{$is_course_class}}"><span>All Courses Access</span>
                                                                                </li>
                                                                                <li itemprop="list" class="mt-15 {{$is_timestables_class}}"><span>Timestables</span>
                                                                                </li>
                                                                                <li itemprop="list" class="mt-15 {{$is_vocabulary_class}}"><span>Vocabulary</span>
                                                                                </li>
                                                                                <li itemprop="list" class="mt-15 {{$is_bookshelf_class}}"><span>Bookshelf</span>
                                                                                </li>
                                                                                <li itemprop="list" class="mt-15 {{$is_sats_class}}">
                                                                                    <span>SATs</span></li>
                                                                                <li itemprop="list" class="mt-15 {{$is_elevenplus_class}}">
                                                                                    <span>11Plus</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="total-amount"></div>
                                            <button type="submit" class="btn btn-primary btn-block mt-30" style="background:#0272b6; color:#fff">{{
                                                trans('financial.purchase') }}
                                            </button>
                                        </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>


<div class="child-hidden-block hide">
    <div class="child-item lms-choose-plan-selected">
        <div class="lms-jobs-form">
            <div class="row">
                <div class="col-12 col-lg-4 col-md-8">
                    <div class="input-field">
                        <input type="text" name="student_name[]" placeholder="Enter your name..">
                    </div>
                </div>
                <div class="col-12 col-lg-2 col-md-4">
                    <div class="field-btn select-arrow">
                        <button type="button" data-toggle="modal" class="package_label"
                                data-target="#choose-plan-modal">Monthly
                        </button>
                        <input type="hidden" name="package_id[]" class="package_id">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade choose-plan-modal update-plan-model" id="update-plan-modal" tabindex="-1"
     aria-labelledby="update-plan-modalLabel" aria-hidden="true">
    <form action="/panel/financial/add-childs" method="post" class="w-100 ">
        {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Update plan</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="subscribe-plan-holder">
                        <div class="container">
                            <div class="row">
                                <input type="hidden" name="child_id" class="update_plan_child">
                                @if(!empty($subscribes) and !$subscribes->isEmpty())
                                @foreach($subscribes as $subscribe)

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <div class="select-plan">
                                        <input type="radio" class="choose-package update-package-{{$subscribe->id}}"
                                               data-label="{{ $subscribe->title }}"
                                               id="up-{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                               value="{{ $subscribe->id }}" name="package">
                                        <label for="up-{{$subscribe->id}}" data-label="{{ $subscribe->title }}">
                                            <div class="subscribe-plan position-relative d-flex flex-column rounded-lg py-25 px-20">
                                                <span class="subscribe-icon mb-20">
                                                    <img src="../assets/default/img/plan-rocket.png" height="auto" width="auto" alt="Box image">
                                                </span>
                                                <div class="subscribe-title">
                                                    <h3 itemprop="title" class="font-24 font-weight-500 pt-20">
                                                        {{$subscribe->title }}
                                                    </h3>
                                                    <span>A simple start for everyone</span>
                                                </div>
                                                <div class="d-flex align-items-start mt-10 subscribe-price">
                                                    <span itemprop="price" class="font-36 line-height-1">
                                                        {!! addCurrencyToPrice($subscribe->price, null, 'currency_small') !!}
                                                        <em>/month</em>
                                                    </span>
                                                    <span class="yearly-price">$ 90 / year</span>
                                                </div>
                                                <span class="plan-label d-block font-weight-500 pt-20">For Teachers</span>
                                                <ul class="plan-feature">
                                                    @php
                                                    $is_course_class = ($subscribe->is_courses == 0)? 'subscribe-no' :
                                                    '';
                                                    $is_timestables_class = ($subscribe->is_timestables == 0)?
                                                    'subscribe-no' : '';
                                                    $is_bookshelf_class = ($subscribe->is_bookshelf == 0)?
                                                    'subscribe-no' : '';
                                                    $is_sats_class = ($subscribe->is_sats == 0)? 'subscribe-no' : '';
                                                    $is_elevenplus_class = ($subscribe->is_elevenplus == 0)?
                                                    'subscribe-no' : '';
                                                    @endphp

                                                    <li itemprop="list" class="mt-15 {{$is_course_class}}"><span>All Courses Access</span>
                                                    </li>
                                                    <li itemprop="list" class="mt-15 {{$is_timestables_class}}"><span>Timestables</span>
                                                    </li>
                                                    <li itemprop="list" class="mt-15 {{$is_bookshelf_class}}"><span>Bookshelf</span>
                                                    </li>
                                                    <li itemprop="list" class="mt-15 {{$is_sats_class}}">
                                                        <span>SATs</span></li>
                                                    <li itemprop="list" class="mt-15 {{$is_elevenplus_class}}">
                                                        <span>11Plus</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <div class="col-12 mt-20">
                                    <button type="submit" class="select-plan-btn">Update Plan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade choose-plan-modal" id="choose-plan-modal" tabindex="-1"
     aria-labelledby="choose-plan-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Choose a plan</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="subscribe-plan-holder">
                    <div class="container">
                        <div class="row">

                            @if(!empty($subscribes) and !$subscribes->isEmpty())
                            @foreach($subscribes as $subscribe)

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="select-plan">
                                    <input type="radio" class="choose-package" data-label="{{ $subscribe->title }}"
                                           id="{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                           value="{{ $subscribe->id }}" name="package">
                                    <label for="{{$subscribe->id}}" data-label="{{ $subscribe->title }}">
                                        <div class="subscribe-plan position-relative d-flex flex-column rounded-lg py-25 px-20">
                                            <span class="subscribe-icon mb-20">
                                                <img src="../assets/default/img/plan-rocket.png" height="auto" width="auto" alt="Box image">
                                            </span>
                                            <div class="subscribe-title">
                                                <h3 itemprop="title" class="font-24 font-weight-500">{{$subscribe->title }}</h3>
                                                <span>A simple start for everyone</span>
                                            </div>
                                            <div class="d-flex align-items-start mt-10 subscribe-price">
                                                <span itemprop="price" class="font-36 line-height-1">
                                                    {!! addCurrencyToPrice($subscribe->price, null, 'currency_small') !!}
                                                </span>
                                                <span class="yearly-price">$ 20 / year</span>
                                            </div>
                                            <span class="plan-label d-block font-weight-500 pt-20">For Teachers</span>
                                            <ul class="plan-feature">
                                                @php
                                                $is_course_class = ($subscribe->is_courses == 0)? 'subscribe-no' :
                                                '';
                                                $is_timestables_class = ($subscribe->is_timestables == 0)?
                                                'subscribe-no' : '';
                                                $is_bookshelf_class = ($subscribe->is_bookshelf == 0)?
                                                'subscribe-no' : '';
                                                $is_sats_class = ($subscribe->is_sats == 0)? 'subscribe-no' : '';
                                                $is_elevenplus_class = ($subscribe->is_elevenplus == 0)?
                                                'subscribe-no' : '';
                                                @endphp

                                                <li itemprop="list" class="mt-15 {{$is_course_class}}"><span>All Courses Access</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_timestables_class}}"><span>Timestables</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_bookshelf_class}}"><span>Bookshelf</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_sats_class}}">
                                                    <span>SATs</span></li>
                                                <li itemprop="list" class="mt-15 {{$is_elevenplus_class}}">
                                                    <span>11Plus</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="col-12 mt-20">
                                <button type="button" class="select-plan-btn">Select Plan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade class-connect-modal" id="class-connect-modal" tabindex="-1" aria-labelledby="class-connect-modallabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Connect To Class</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="class-thumb-list connect-class-steps" data-id="1">
                    <ul>
                        <li>
                            <div class="class-thumb">
                                <a href="#">
                                    <figure class="media-box"></figure>
                                    <span class="thumb-lable">Billy</span>
                                </a>
                            </div>
                        </li>
                        <li class="school-box">
                            <div class="class-thumb">
                                <figure class="media-icon"><img src="/assets/default/svgs/school-with-flag.svg" alt=""></figure>
                            </div>
                        </li>
                        <li>
                            <div class="class-thumb">
                                <a href="#">
                                    <figure class="media-box"></figure>
                                    <span class="thumb-lable">your School</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <p>Connect to your child's class to receive Lesson recommendations and to see what your child is learning in school.</p>
                    <div class="connect-controls">
                        <a href="javascript:;" data-dismiss="modal" aria-label="Close">Never Mind</a>
                        <a href="javascript:;" class="connect-next-step">Find Your School</a>
                    </div>
                </div>

                <form action="#" method="post" class="w-100 connect-to-class-form connect-class-steps rurera-hide" data-id="2">

                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" class="connect_user_id">
                    <div class="row user-details-block">
                        <div class="col-12 col-lg-6 col-md-6">
                            <span class="form-label">Class Code</span>
                            <div class="input-field">
                                <input type="text" name="class_code" class="rurera-req-field" placeholder="Class Code">
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12">
                            <button type="button" class="btn btn-primary btn-block mt-50 class-code-submit" style="background:#0272b6; color:#fff">Submit
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade edit-user-modal lms-choose-membership" id="edit-user-modal" tabindex="-1"
     aria-labelledby="edit-user-modallabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel-header">
                <div class="modal-logo"><img src="/assets/default/img/sidebar/logo.svg"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">Back to Dashboard <span aria-hidden="true">×</span></button>
            </div>
            <div class="container">
                <div class="modal-body pt-50">
				
				

                   
						
				<div class="bg-white panel-border p-25 rounded-sm my-30 mx-auto w-80 user-profile-block">
				
				</div>

                    </div>
                </div>
            </div>
    </div>
</div>


<div class="modal fade lms-choose-membership" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel-header">
                <div class="modal-logo"><img src="/assets/default/img/sidebar/logo.svg"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">Back to Dashboard <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container container-nosidebar">
                <div class="tab-content subscription-content" id="nav-tabContent">

                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade class-connect-modal" id="cancelsubscriptionModal" tabindex="-1" aria-labelledby="cancelsubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
			<div class="modal-header">
                <strong>Cancel Subscription</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
			
            <div class="modal-body">
                <div class="container container-nosidebar">
                <div class="tab-content cancel-membership-block" id="nav-tabContent">
						<div class="cancel-package-data"></div>
                        <h3>You will still be able to use the package till its expiry and wont be charged for the renwal.</h3>
                        <div class="row justify-content-center payment-content">
                            <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center"><a href="javascript:;" class="nav-link btn-primary rounded-pill mb-25 cancel-subscription-btn modal-btn" data-child_id="0">Cancel Membership</a></div>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade class-connect-modal" id="unlinkModal" tabindex="-1" aria-labelledby="unlinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Unlink Student</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container container-nosidebar">
                <div class="tab-content unlink-block" id="nav-tabContent">
                        <h3>Data will be removed and may not be retrievable.</h3>
                        <div class="row justify-content-center payment-content">
                            <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center"><a href="javascript:;" class="nav-link btn-primary rounded-pill mb-25 unlink-btn" data-child_id="0">Proceed Unlink</a></div>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade student-link-modal" id="student-link-modal" tabindex="-1" aria-labelledby="studentLinkModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Connect Student</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="class-thumb-list connect-class-steps" data-id="1">
                    <p>Connect to your student's account to view their progress and set lesson plans.</p>
                    <div class="connect-controls">
                        <a href="javascript:;" data-dismiss="modal" aria-label="Close">Never Mind</a>
                        <a href="javascript:;" class="connect-next-step">Find Student</a>
                    </div>
                </div>

                <form action="#" method="post" class="w-100 connect-student-form connect-class-steps rurera-hide" data-id="2">

                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" class="connect_user_id">
                    <div class="row user-details-block">
                        <div class="col-12 col-lg-12 col-md-12">
                            <span class="form-label d-block mb-10">Student Username</span>
                            <div class="input-field d-inline-flex align-items-center">
                                <input type="text" name="username" class="rurera-req-field" placeholder="Username">
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12">
                            <button type="button" class="btn btn-primary btn-block mt-15 class-student-submit" style="background:#0272b6; color:#fff">Submit
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/admin/vendor/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">




	$(document).on('click', '.link-student-modal', function (e) {
        $(".student-link-modal").modal('show');
    });
    $(document).on('change', 'input[name="subscribe_for"]', function (e) {
        calculate_total_amount();
    });


    $(document).on('click', '.regenerate-emoji', function (e) {
        rurera_loader($(".child-edit-form"), 'div');
        var login_emoji = $(".emoji-password-field").val();
        var user_id = $(this).attr('data-user_id');

        jQuery.ajax({
           type: "POST",
           url: '/panel/users/generate-emoji',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {'login_emoji':login_emoji, 'user_id':user_id},
           success: function (return_data) {
               rurera_remove_loader($(".child-edit-form"), 'div');
               Swal.fire({
                  icon: 'success',
                  html: return_data,
                  showCloseButton: true,
                   allowOutsideClick: false,
                   allowEscapeKey: false,
                  showConfirmButton: !1
              });
           }
       });

    });


    $(document).on('click', '.regenerate-pin', function (e) {
        rurera_loader($(".child-edit-form"), 'div');
        var user_id = $(this).attr('data-user_id');
        jQuery.ajax({
           type: "POST",
           url: '/panel/users/generate-pin',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {'user_id':user_id},
           success: function (return_data) {
               rurera_remove_loader($(".child-edit-form"), 'div');
               Swal.fire({
                  icon: 'success',
                  html: return_data,
                  showCloseButton: true,
                   allowOutsideClick: false,
                   allowEscapeKey: false,
                  showConfirmButton: !1
              });
           }
       });

    });
    $(document).on('click', '.update-package', function (e) {
        var package_id = $(this).attr('data-package_id');
        var child_id = $(this).attr('data-child');
        $(".update_plan_child").val(child_id);
        $(".choose-package").attr('checked', false);
        $('label[for="up-' + package_id + '"]').click();
        $(".update-package-" + package_id).attr('checked', true);
    });


    $(document).on('click', '.connect-next-step', function (e) {
        var step_id = $(this).closest(".connect-class-steps").attr('data-id');
        $(".connect-class-steps").addClass('rurera-hide');
        if( step_id == 1){
            $('.connect-class-steps[data-id="2"]').removeClass('rurera-hide');
        }
    });




    $(document).on('click', '.package_label', function (e) {
        var current_index = $(".package_label").index($(this));
        $(this).closest('.field-btn').find('.package_id').attr('data-current_index', current_index);
        $(this).attr('data-index_no', current_index);
        $(".choose-plan-modal").attr('data-current_index', current_index);
    });
    $(document).on('click', '.quantity-right-plus', function (e) {
        var child_item_html = $(".child-hidden-block").html();
        $(".childs-block").append(child_item_html);
    });

    $(document).on('click', '.quantity-left-minus', function (e) {
        $('.childs-block .child-item:last-child').remove();
    });

    $(document).on('click', '.childs-next-btn', function (e) {

        var formData = new FormData($(".childs-form")[0]);

        jQuery.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            data:formData,
            dataType:'json',
            url: '/panel/financial/add-childs',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (return_data) {
                $(".package_user_id").val(return_data.user_id)
                $('.user-details-block').addClass('rurera-hide');
                $('.choose-package-block').removeClass('rurera-hide');
            },
            error: function error(err) {
                var errors = err.responseJSON.errors;
                var error_mesages = '';
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        var errorMessages = errors[key];
                        errorMessages.forEach(function(errorMessage) {
                            error_mesages += errorMessage+'<br>';
                            console.log("Field: " + key + ", Error: " + errorMessage);
                            // Perform any other action you need with the error message
                        });
                    }
                }
                Swal.fire({
                  icon: 'error',
                  html: '<h3 class="font-20 text-center text-dark-blue py-25">'+error_mesages+'</h3>',
                  showConfirmButton: false,
                  width: '25rem'
                });
            }
        });

        //$('.user-details-block').addClass('rurera-hide');
        //$('.choose-package-block').removeClass('rurera-hide');
    });

    $(document).on('click', '.add-child-btn', function (e) {
        $('.user-details-block').removeClass('rurera-hide');
        $('.choose-package-block').addClass('rurera-hide');
    });

    $(document).on('click', '.class-code-submit', function (e) {
        var thisObj = $(this);
        var formData = new FormData($(".connect-to-class-form")[0]);
        returnType = rurera_validation_process($(".connect-to-class-form"), 'growl');
        if (returnType == false) {
            return false;
        }
        rurera_loader(thisObj, 'div');
        jQuery.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            data:formData,
            dataType:'json',
            url: '/panel/setting/connect-user-class',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (return_data) {
                rurera_remove_loader(thisObj, 'div');
                $("#class-connect-modal").modal('hide');
                Swal.fire({
                  icon: return_data.status,
                  html: '<h3 class="font-20 text-center text-dark-blue py-25">'+return_data.msg+'</h3>',
                  showConfirmButton: false,
                  width: '25rem'
                });
            },
        });
    });
	
	
	$(document).on('click', '.class-student-submit', function (e) {
        var thisObj = $(this);
        var formData = new FormData($(".connect-student-form")[0]);
        returnType = rurera_validation_process($(".connect-student-form"), 'growl');
        if (returnType == false) {
            return false;
        }
        rurera_loader(thisObj, 'div');
        jQuery.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            data:formData,
            dataType:'json',
            url: '/panel/setting/connect-student',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (return_data) {
                rurera_remove_loader(thisObj, 'div');
                $("#class-connect-modal").modal('hide');
                Swal.fire({
                  icon: return_data.status,
                  html: '<h3 class="font-20 text-center text-dark-blue py-25">'+return_data.msg+'</h3>',
                  showConfirmButton: false,
                  width: '25rem'
                });
            },
        });
    });
	
	




    $(document).on('click', '.connect-user-btn', function (e) {
        $('.connect-class-steps').addClass('rurera-hide');
        $('.connect-class-steps[data-id="1"]').removeClass('rurera-hide');
        var user_id = $(this).attr('data-user_id');
        $(".connect_user_id").val(user_id);

    });

    $(document).on('click', '.edit-user-btn', function (e) {
        var first_name = $(this).attr('data-first_name');
        var last_name = $(this).attr('data-last_name');
        var user_id = $(this).attr('data-user_id');
		$(".user-profile-block").html('');
		
		rurera_loader($('.user-profile-block'), 'div');
		$.ajax({
			type: "GET",
			url: '/panel/student-profile/'+user_id,
			data: {"user_id": user_id},
			success: function (return_data) {
				$(".user-profile-block").html(return_data);
				rurera_remove_loader($('.user-profile-block'), 'div');
			}
		});
    });
	
	$(document).on('click', '.request-action-btn', function (e) {
        var thisObj = $(this);
		var request_type = thisObj.attr('data-request_type');
		var request_id = thisObj.attr('data-id');
        rurera_loader(thisObj, 'div');
        jQuery.ajax({
            type: "POST",
            data: {"request_id": request_id, "request_type": request_type},
            dataType:'json',
            url: '/panel/setting/request-action',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (return_data) {
                rurera_remove_loader(thisObj, 'div');
                $("#class-connect-modal").modal('hide');
                Swal.fire({
                  icon: return_data.status,
                  html: '<h3 class="font-20 text-center text-dark-blue py-25">'+return_data.msg+'</h3>',
                  showConfirmButton: false,
                  width: '25rem'
                });
				thisObj.closest('.students-requests-list-item').slideUp();
				
            },
        });
    });
	
	

	

	$(document).on('click', '.close-modal', function (e) {
		$("#subscriptionModal").modal('hide');
	});

    $(document).on('click', '.subscribe-plans', function (e) {
        var current_index = $(".choose-plan-modal").attr('data-current_index');
        console.log(current_index);
        var package_label = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-label');
        var package_price = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-price');
        //$('.package_id[data-current_index="' + current_index + '"]').val($(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).val());
        $('.package_id[data-current_index="' + current_index + '"]').attr('data-price', package_price);
        $('.package_label[data-index_no="' + current_index + '"]').html(package_label);
        //$("#choose-plan-modal").modal('hide');
        calculate_total_amount();
    });

    function calculate_total_amount() {

        var total_amount = 0;
        var child_count = $(".totalChilds").attr('data-childs');
        console.log(child_count);
        $('.childs-block').find('.package_id:checked').each(function (index_no) {
            console.log($(this).attr('data-price'));
            if ($(this).attr('data-price') != 'undefined') {
                child_count++;
                var discount_percentage = 0;
                if (child_count > 1) {
                    discount_percentage = 5;
                }
                var current_price = parseInt($(this).attr('data-price'));
                var discount_amount = (parseFloat(current_price) * parseInt(discount_percentage)) / 100;
                current_price = (parseFloat(current_price) - parseFloat(discount_amount));
                total_amount = parseFloat(total_amount) + parseFloat(current_price);
            }
        });

        var discount_percentage = $('input[name="subscribe_for"]:checked').attr('data-discount');
        total_amount = (total_amount * $('input[name="subscribe_for"]:checked').val());

        var discount_amount = (parseFloat(total_amount) * parseInt(discount_percentage)) / 100;
        total_amount = (parseFloat(total_amount) - parseFloat(discount_amount));
        total_amount = parseFloat(total_amount).toFixed(2);

        if (total_amount != 'NaN') {
            $(".total-amount").html(total_amount);
        }
    }
	
	function closeModal(modalId) {
	  $(modalId).modal('hide');
	}


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
