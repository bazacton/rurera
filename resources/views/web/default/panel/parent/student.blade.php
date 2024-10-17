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

<style>
.rurera-hide{display:none !important;}
    .profile-container {max-width: 1000px; margin: 0 auto; padding-top: 50px;}
    .student-profile-holder {width: 100%; display: inline-block; margin-right: -4px; padding: 0 8px 15px; box-sizing: border-box;}
    .profile-inner {border: 1px dashed #ddd; border-radius: 5px; padding: 20px;}
    .student-profile-holder h3 {font-size: 20px; color: #868686; text-transform: capitalize; margin: 0;}
    .student-info ul {margin: 0; padding: 0;}
    .student-info ul li {list-style: none; margin-bottom: 8px; display: flex; align-items: center; gap: 15px; color: #343434; font-weight: 600; font-size: 14px;}
    .student-info ul li:last-child {margin-bottom: 0;}
    .student-info ul li.user-name {color: #7750f9;}
    .student-info ul li.user-name span {color: #343434;}
    .student-info ul li > a {color: #343434; text-decoration: none;}
    .student-info ul li > span {min-width: 78px; max-width: 78px;}
    .emoji-icons {display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-start; }
    .emoji-icons .emoji-icon {border-radius: 100%; display: inline-block; object-fit: contain; height: 28px; width: 28px; }
    .emoji-icons .emoji-icon img {max-width: 100%; }
    .profile-header {display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; margin: 0 0 10px;}
    .student-qrCode {height: 35px;width: 35px;}
    .student-qrCode img {max-width: 100%;object-fit: contain;}
    @media print {
        .profile-container {
            padding-top: 0;
        }
        .profile-inner {
            padding: 15px;
        }
        .student-profile-holder h3 {
            font-size: 18px;
            color: #868686;
        }
        .emoji-icons .emoji-icon {
            height: 25px;
            width: 25px; 
        }
        .student-info ul li {
            margin-bottom: 6px;
            font-size: 14px;
        }
        .student-info ul li.user-name span {
            color: #343434;
        }
        @page {
            size: letter;
            margin: 50px 0 0;
        }
    }

    @media screen and (max-width: 767px) {
        .student-profile-holder {width: 100%; padding-bottom: 15px;}
    }
    .profile-container .row {
        page-break-before: always;
        margin: 0 0 50px;
    }
</style>
<script src="https://js.stripe.com/v3/"></script>
<link rel="stylesheet" href="/assets/admin/vendor/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
@php
$user_avatar_settings = $user->user_avatar_settings;
$user_avatar_settings = json_decode($user_avatar_settings);
$avatar_settings = isset( $user_avatar_settings->avatar_settings )? (array) $user_avatar_settings->avatar_settings : array();
$avatar_color_settings = isset( $user_avatar_settings->avatar_color_settings )? (array) $user_avatar_settings->avatar_color_settings : array();
$avatar_settings = json_encode($avatar_settings);
$avatar_color_settings = json_encode($avatar_color_settings);
$emoji_response = '';
$emojisArray = explode('icon', $user->login_emoji);
if( !empty( $emojisArray ) ){
	$emoji_response .= '<div class="emoji-icons">';
	foreach( $emojisArray as $emojiCode){
		if( $emojiCode != ''){
			$emoji_response .= '<a id="icon1" href="javascript:;" class="emoji-icon"><img src="/assets/default/svgs/emojis/icon'.$emojiCode.'.svg"></a>';
		}
	}
	$emoji_response .= '</div>';
}
$subscribe = isset( $user->userSubscriptions->subscribe)? $user->userSubscriptions->subscribe : (object) array();
@endphp

<div class="user-detail user-view-profile">
                <div class="detail-header-profile bg-white py-25 px-30 d-flex align-items-center flex-wrap justify-content-between mb-25 pb-25">
                    <div class="info-media d-flex align-items-center flex-wrap">
                        <span class="media-box">
							<a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between">
								<img src="{{$user->getAvatar()}}" alt="">
							</a>
                        </span>
                        <h2 class="info-title font-weight-500">
                            {{$user->get_full_name()}}
                        </h2>
                    </div>
                    <div class="profile-controls d-inline-flex align-items-center flex-wrap">
                        <a href="/{{panelRoute()}}/switch_user/{{$user->id}}" class="font-weight-500">
                            <span class="icon-box d-inline-block mr-5">
                                <img src="/assets/default/svgs/switch-user.svg" alt="">
                            </span>
                            Switch Profile
                        </a>
						<a href="javascript:;" class="package-payment-btn font-weight-500 unlink-modal" data-type="child_payment" data-id="{{$user->id}}">
                            <span class="icon-box d-inline-block mr-5">
                                <img src="/assets/default/svgs/unlink.svg" alt="">
                            </span>
                            Unlink
                        </a>
                        <a href="/{{panelRoute()}}/students/print-card/{{$user->id}}" target="_blank" class="font-weight-500">	
                            <span class="icon-box d-inline-block mr-5">
                                <img src="/assets/default/svgs/printer-activity.svg" alt="">
                            </span>
                            Print Login Card
                        </a>
                    </div>
                </div>
                <div class="detail-body p-25">
				
				
				
				
					@if( $childLinkedParents->count() > 1)
						<div class="row mb-50">
							<div class="col-lg-4 col-md-4 col-sm-12 col-12">
								<div class="info-text">
									<h3 class="font-18 font-weight-500 mb-5">Linked Accounts</h3>
									<span class="font-16">Some basic information that we need to know about student.</span>
								</div>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-12 col-12">
								<h2 class="font-16 font-weight-500 mb-5 inner-heading pb-15">Linked Accounts</h2>
								<div class="edit-info-list">
									<ul class="profile-view-data">
										@foreach( $childLinkedParents as $childLinkedParentObj)
											@php $parentObj = $childLinkedParentObj->studentParent; @endphp
											@if( auth()->user()->id != $parentObj->id)
											<li>
												<a href="javascript:;" data-parent_id="{{$parentObj->id}}" class="d-flex align-items-center unlink-parent-btn justify-content-between p-15">
													<span class="info-list-label font-16">
														{{$parentObj->role_name}}
														<strong class="d-block font-weight-500">{{$parentObj->get_full_name()}}</strong>
													</span>
													<span class="edit-icon d-inline-flex align-items-center">
														<!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
														<em class="font-weight-500">Delete</em>
													</span>
												</a>
											</li>
											@endif
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					@endif
						
					
				
				
				
				
				
				
				
				
                    <div class="row mb-50">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="info-text">
								<h3 class="font-18 font-weight-500 mb-5">Account Overview</h3>
								<span class="font-16">Some basic information that we need to know about student.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-16 font-weight-500 mb-5 inner-heading pb-15">Account Overview</h2>
                            <div class="edit-info-list">
                                <ul class="profile-view-data">
									<li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                First Name
                                                <strong class="d-block font-weight-500">{{$user->get_first_name()}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									<li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Last name
                                                <strong class="d-block font-weight-500">{{$user->get_last_name()}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Display name
                                                <strong class="d-block font-weight-500">{{$user->display_name}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									 <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Preference
                                                <strong class="d-block font-weight-500">{{$user->user_preference}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									 <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Year Group
                                                <strong class="d-block font-weight-500">{{isset($user->userYear->id )? $user->userYear->getTitleAttribute() : ''}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
								<div class="edit-profile edit-profile-block mt-20 rurera-hide bg-white p-25">
								
								
								 <form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6 col-lg-6 col-md-6">
											<div class="form-group">
												<span class="fomr-label mb-10 d-block">Student's first name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="First Name" name="first_name" value="{{$user->get_first_name()}}">
												</div>
											</div>
										</div>
										
										<div class="col-6 col-lg-6 col-md-6">
											<div class="form-group">
												<span class="fomr-label mb-10 d-block">Student's last name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="Last name" name="last_name" value="{{$user->get_last_name()}}">
												</div>
											</div>
										</div>
										
										
										<div class="col-6 col-lg-6 col-md-6">
											<div class="form-group">
												<span class="fomr-label mb-10 d-block">Display name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="Display name" name="display_name" value="{{($user->display_name != '')? $user->display_name : $user->get_first_name().' '.$user->get_last_name()}}">
												</div>
											</div>
										</div>
										
										
										<div class="col-6 col-lg-6 col-md-6">
                                            <span class="fomr-label mb-10 d-block">Preference</span>
											<!-- <div class="select-field">
												<select class="form-control rurera-req-field" name="user_preference">
													<option value="male" {{($user->user_preference == 'male' || $user->user_preference == '')? 'selected' : ''}}>Male</option>
													<option value="female" {{($user->user_preference == 'female')? 'selected' : ''}}>Female</option>
												</select>
											</div> -->
                                            <div class="select-option d-flex align-items-center flex-wrap">
                                                <div class="radio-field">
                                                    <input type="radio" name="gender" id="male">
                                                    <label for="male" class="d-inline-flex align-items-center flex-wrap mb-0 text-center">
                                                        <span class="thumb-box float-left mr-10">
                                                            <img src="/avatar/svgA16395287444009177.png" alt="" height="35" width="35">
                                                        </span>
                                                        Male
                                                    </label>
                                                </div>
                                                <div class="radio-field">
                                                    <input type="radio" name="gender" id="female">
                                                    <label for="female" class="d-inline-flex align-items-center flex-wrap mb-0 text-center">
                                                        <span class="thumb-box float-left mr-10">
                                                            <img src="/avatar/svgA16395287444009177.png" alt="" height="35" width="35">
                                                        </span>
                                                        Female
                                                    </label>
                                                </div>
                                            </div>
										</div>
										<div class="col-12 col-lg-12 col-md-12 form-group">
                                            <span class="fomr-label mb-10 d-block">Year Group</span>
											<div class="select-field">
												<select class="rurera-req-field" name="year_id">
												  <option {{ !empty($trend) ?
												  '' : 'selected' }} disabled>Choose Year Group</option>

												  @foreach($categories as $category)
												  @if(!empty($category->subCategories) and count($category->subCategories))
												  <optgroup label="{{  $category->title }}">
													  @foreach($category->subCategories as $subCategory)
													  <option value="{{ $subCategory->id }}" @if(!empty($user) and $user->year_id == $subCategory->id) selected="selected" @endif>{{
														  $subCategory->title }}
													  </option>
													  @endforeach
												  </optgroup>
												  @else
												  <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($user)
														  and $user->year_id == $subCategory->id) selected="selected" @endif>{{
													  $category->title }}
												  </option>
												  @endif
												  @endforeach
											  </select>
											</div>
										</div>
									</div>
									<div class="edit-profile-controls">
										<input type="hidden" name="user_id" value="{{$user->id}}">
										<a href="javascript:;" class="text-center cancel-edit-button">Reset</a>
										<a href="javascript:;" class="btn btn-primary text-center profile-save-btn">Save</a>
                                    </div>
									</form>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-50">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="info-text">
								<h3 class="font-18 font-weight-500 mb-5">School Preference</h3>
								<span class="font-16">List the schools with exam date you're applying for in order of preference.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-16 font-weight-500 mb-5 inner-heading pb-15">School Preference</h2>
                            <div class="edit-info-list">
                                <ul class="profile-view-data">
									<li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Test Prep School Choice
                                                <strong class="d-block font-weight-500">{{isset($user->userSchoolPreffernce1->title)? $user->userSchoolPreffernce1->title : '-'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                School Preference 1
                                                <strong class="d-block font-weight-500">{{isset($user->userSchoolPreffernce1->title)? $user->userSchoolPreffernce1->title : '-'}} {{($user->school_preference_1_date != '')? '( '.dateTimeFormat($user->school_preference_1_date, 'j M Y').' )' : ''}} </strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                School Preference 2
                                                <strong class="d-block font-weight-500">{{isset( $user->userSchoolPreffernce2->title )? $user->userSchoolPreffernce2->title : '-'}} {{($user->school_preference_2_date != '')? '( '.dateTimeFormat($user->school_preference_2_date, 'j M Y').' )' : ''}} </strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                School Preference 3
                                                <strong class="d-block font-weight-500">{{isset( $user->userSchoolPreffernce3->title )? $user->userSchoolPreffernce3->title : '-'}} {{($user->school_preference_3_date != '')? '( '.dateTimeFormat($user->school_preference_3_date, 'j M Y').' )' : ''}} </strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
								
								<div class="edit-profile edit-profile-block mt-20 rurera-hide bg-white p-25">
								<form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6 col-lg-6 col-md-6">
											<label>Test Prep School Choice</label>
											<div class="select-field">
												<select class="form-control rurera-req-field" name="test_prep_school">
													<option value="Not sure" selected>Not sure</option>
													<option value="Independent schools">Independent schools</option>
													<option value="Grammar schools">Grammar schools</option>
													<option value="Independent & grammar schools">Independent & grammar schools</option>
												</select>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6">
											<label>Preference 1</label>
											<div class="select-field">
												<select class="form-control preference_field rurera-req-field" name="school_preference_1">
													<option value="">Select Preference</option>
													@foreach( $schools as $schoolObj)
														<option value="{{$schoolObj->id}}" {{($schoolObj->id == $user->school_preference_1)? 'selected' : ''}}>{{$schoolObj->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6">
											<div class="form-group">
												<span class="fomr-label mb-10 d-block">Preference 1 Date</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="preference-date rureradatepicker" min="{{date('Y-m-d')}}" placeholder="Preference 1 Date" name="school_preference_1_date" value="{{($user->school_preference_1_date != '')? dateTimeFormatNumeric($user->school_preference_1_date, 'Y-m-d', 'numeric') : ''}}">
												</div>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6">
											<label>Preference 2</label>
											<div class="select-field">
												<select class="form-control preference_field" name="school_preference_2">
													<option value="">Select Preference</option>
													@foreach( $schools as $schoolObj)
														<option value="{{$schoolObj->id}}" {{($schoolObj->id == $user->school_preference_2)? 'selected' : ''}}>{{$schoolObj->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6">
											<div class="form-group">
												<span class="fomr-label mb-10 d-block">Preference 2 Date</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="preference-date rureradatepicker rurera-req-field" min="{{date('Y-m-d')}}" placeholder="Preference 2 Date" name="school_preference_2_date" value="{{($user->school_preference_2_date != '')? dateTimeFormatNumeric($user->school_preference_2_date, 'Y-m-d', 'numeric') : ''}}">
												</div>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6">
											<label>Preference 3</label>
											<div class="select-field">
												<select class="form-control preference_field rurera-req-field" name="school_preference_3">
													<option value="">Select Preference</option>
													@foreach( $schools as $schoolObj)
														<option value="{{$schoolObj->id}}" {{($schoolObj->id == $user->school_preference_3)? 'selected' : ''}}>{{$schoolObj->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6">
											<div class="form-group">
												<span class="fomr-label mb-10 d-block">Preference 3 Date</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="preference-date rureradatepicker rurera-req-field" min="{{date('Y-m-d')}}" placeholder="Preference 3 Date" name="school_preference_3_date" value="{{($user->school_preference_3_date != '')? dateTimeFormatNumeric($user->school_preference_3_date, 'Y-m-d', 'numeric') : ''}}">
												</div>
											</div>
										</div>
										
										</div>
										
									<div class="edit-profile-controls">
										<input type="hidden" name="user_id" value="{{$user->id}}">
										<a href="javascript:;" class="text-center cancel-edit-button">Reset</a>
										<a href="javascript:;" class="btn btn-primary text-center profile-save-btn">Save</a>
                                    </div>
									</form>
										</div>
								
								
                            </div>
                        </div>
                    </div>
                    <div class="row mb-50">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="info-text">
								<h3 class="font-18 font-weight-500 mb-5">Display Settings</h3>
								<span class="font-16">Display settings control the layout and behavior of the student panel. You can toggle the visibility of different elements to customize what students can see.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-16 font-weight-500 mb-5 inner-heading pb-15">Display Settings</h2>
                            <div class="edit-info-list">
                                <ul class="profile-view-data">
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Timestables
                                                <strong class="d-block font-weight-500">{{$user->show_timestables == 1 ? 'Show' : 'Hide'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Spellings
                                                <strong class="d-block font-weight-500">{{$user->show_spellings == 1 ? 'Show' : 'Hide'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Games
                                                <strong class="d-block font-weight-500">{{$user->show_games == 1 ? 'Show' : 'Hide'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Books
                                                <strong class="d-block font-weight-500">{{$user->show_books == 1 ? 'Show' : 'Hide'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Enterance Exams
                                                <strong class="d-block font-weight-500">{{$user->show_enterance_exams == 1 ? 'Show' : 'Hide'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                SATs
                                                <strong class="d-block font-weight-500">{{$user->show_sats == 1 ? 'Show' : 'Hide'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									@if( $courses_list->count() > 0)
											@php $hide_subjects = json_decode($user->hide_subjects);
											$hide_subjects = is_array( $hide_subjects )? $hide_subjects : array();
											@endphp
											@foreach( $courses_list as $courseObj)
												<li>
													<a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
														<span class="info-list-label font-16">
															{{$courseObj->getTitleAttribute()}}
															<strong class="d-block font-weight-500">{{!in_array($courseObj->id, $hide_subjects)? 'Show' : 'Hide'}}</strong>
														</span>
														<span class="edit-icon d-inline-flex align-items-center">
															<!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
															<em class="font-weight-500">Edit</em>
														</span>
													</a>
												</li>
											@endforeach
										@endif
                                </ul>
								<div class="edit-profile edit-profile-block mt-20 rurera-hide bg-white p-25">
								<form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<input type="hidden" name="type" value="display_settings">
									<div class="row">
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
										
										<div class="form-group custom-switches-stacked mb-15 ">
											<label class="custom-switch pl-0 custom-label">
												<input type="checkbox" name="show_timestables"
													   id="show_timestables_field" value="1" class="custom-switch-input"  {{($user->show_timestables == 1)? 'checked' : ''}}/>
												<span class="custom-switch-indicator">
														<em class="hide-text">Hide</em>
														<span class="switch-circle"></span>
														<em class="show-text">Show</em>
												</span>
												<label class="custom-switch-description mb-0 cursor-pointer"
													   for="show_timestables_field">Timestables</label>
											</label>
										</div>
										</div>
										
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
											
											<div class="form-group custom-switches-stacked mb-15">
											
												<label class="custom-switch pl-0 custom-label">
													<input type="checkbox" name="show_spellings"
														   id="show_spellings_field" value="1" class="custom-switch-input"  {{($user->show_spellings == 1)? 'checked' : ''}}/>
													<span class="custom-switch-indicator">
														<em class="hide-text">Hide</em>
														<span class="switch-circle"></span>
														<em class="show-text">Show</em>
													</span>
													<label class="custom-switch-description mb-7 cursor-pointer"
														   for="show_spellings_field">Spellings</label>
												</label>
											</div>
										</div>
										
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
										
											@php $disabled = (!$user->subscription('bookshelf'))? 'disabled' : ''; @endphp
											@php $is_disabled_style = (!$user->subscription('bookshelf'))? 'disabled-style' : ''; @endphp
											
											<div class="form-group custom-switches-stacked mb-15 {{$is_disabled_style}}">
												<label class="custom-switch pl-0 custom-label">
													<input type="checkbox" name="show_games"
														   id="show_games_field" value="1" class="custom-switch-input"  {{($user->show_games == 1)? 'checked' : ''}}/>
													<span class="custom-switch-indicator">
														<em class="hide-text">Hide</em>
														<span class="switch-circle"></span>
														<em class="show-text">Show</em>
													</span>
													<label class="custom-switch-description mb-0 cursor-pointer"
														   for="show_games_field">Games</label>
												</label>
											</div>
										</div>

										
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
										
											@php $disabled = (!$user->subscription('bookshelf'))? 'disabled' : ''; @endphp
											@php $is_disabled_style = (!$user->subscription('bookshelf'))? 'disabled-style' : ''; @endphp
											
											<div class="form-group custom-switches-stacked mb-15 {{$is_disabled_style}}">
												<label class="custom-switch pl-0 custom-label">
													<input type="checkbox" name="show_books"
														   id="show_books_field" value="1" class="custom-switch-input"  {{($user->show_books == 1)? 'checked' : ''}}/>
													<span class="custom-switch-indicator">
														<em class="hide-text">Hide</em>
														<span class="switch-circle"></span>
														<em class="show-text">Show</em>
													</span>
													<label class="custom-switch-description mb-0 cursor-pointer"
														   for="show_books_field">Books</label>
												</label>
											</div>
										</div>
										
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
										
											@php $is_disabled = (!$user->subscription('11plus'))? 'disabled' : ''; @endphp
											@php $is_disabled_style = (!$user->subscription('11plus'))? 'disabled-style' : ''; @endphp
											
											<div class="form-group custom-switches-stacked mb-15">
												<label class="custom-switch pl-0 custom-label  {{$is_disabled_style}}">
													<input type="checkbox" name="show_enterance_exams"
														   id="show_enterance_exams_field" value="1" class="custom-switch-input"  {{($user->show_enterance_exams == 1 && $is_disabled == '')? 'checked' : ''}} {{$is_disabled}}/>
													<span class="custom-switch-indicator">
														<em class="hide-text">Hide</em>
														<span class="switch-circle"></span>
														<em class="show-text">Show</em>
													</span>
													<label class="custom-switch-description mb-0 cursor-pointer"
														   for="show_enterance_exams_field">Enterance Exams</label>
												</label>
											</div>
										</div>
										
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
										
											@php $is_disabled = (!$user->subscription('sats'))? 'disabled' : ''; @endphp
											@php $is_disabled_style = (!$user->subscription('sats'))? 'disabled-style' : ''; @endphp
											
											<div class="form-group custom-switches-stacked mb-15">
												<label class="custom-switch pl-0 custom-label  {{$is_disabled_style}}">
													<input type="checkbox" name="show_sats"
														   id="show_sats_field" value="1" class="custom-switch-input"  {{($user->show_sats == 1 && $is_disabled == '')? 'checked' : ''}} {{$is_disabled}}/>
													<span class="custom-switch-indicator">
														<em class="hide-text">Hide</em>
														<span class="switch-circle"></span>
														<em class="show-text">Show</em>
													</span>
													<label class="custom-switch-description mb-0 cursor-pointer"
														   for="show_sats_field">SATs</label>
												</label>
											</div>
										</div>
										
										
										@if( $courses_list->count() > 0)
											@php $is_disabled = (!$user->subscription('courses'))? 'disabled' : ''; @endphp
											@php $is_disabled_style = (!$user->subscription('courses'))? 'disabled-style' : ''; @endphp
											@php $hide_subjects = json_decode($user->hide_subjects);
											$hide_subjects = is_array( $hide_subjects )? $hide_subjects : array();
											@endphp
											@foreach( $courses_list as $courseObj)
										
												<div class="col-12 col-sm-12 col-md-12 col-lg-12">
													
													<div class="form-group custom-switches-stacked mb-15">
														<label class="custom-switch pl-0 custom-label {{$is_disabled_style}}">
															<input type="checkbox" name="hide_subjects[]"
																   id="hide_{{$courseObj->id}}" value="{{$courseObj->id}}" class="custom-switch-input"  {{!in_array($courseObj->id, $hide_subjects)? 'checked' : ''}} {{$is_disabled}}/>
															<span class="custom-switch-indicator">
																<em class="hide-text">Hide</em>
																<span class="switch-circle"></span>
																<em class="show-text">Show</em>
															</span>
															<label class="custom-switch-description mb-7 cursor-pointer"
																   for="hide_{{$courseObj->id}}">{{$courseObj->getTitleAttribute()}}</label>
														</label>
													</div>
												</div>
											@endforeach
										@endif
										
										
										
										
											
											
										</div>
										
									<div class="edit-profile-controls">
										<input type="hidden" name="user_id" value="{{$user->id}}">
										<a href="javascript:;" class="text-center cancel-edit-button">Reset</a>
										<a href="javascript:;" class="btn btn-primary text-center profile-save-btn">Save</a>
                                    </div>
									</form>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="info-text">
								<h3 class="font-18 font-weight-500 mb-5">Login Details</h3>
								<span class="font-16">login credential can be changed,Set a unique password to protect student account. Don't forget to change it from time to time.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<div class="edit-info-list">
								<h2 class="font-16 font-weight-500 mb-25 inner-heading pb-15 d-flex align-items-center justify-content-between">Login Details
									<a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between">
										<span class="edit-icon d-inline-flex align-items-center float-right pr-15">
											<!-- <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18"> -->
											<em class="font-weight-500">Edit</em>
										</span>
									</a>
								</h2>
							
								<div class="student-profile-holder profile-view-data">
								<div class="profile-inner">
									<div class="profile-header">
										<h3>{{$user->get_full_name()}}</h3>
										<a href="#" class="student-qrCode"><img src="/store/1/default_images/qr-code.png" alt=""></a>
									</div>
									<div class="student-info">
										<ul>
											<li class="user-name">
												<span>Username:</span> {{$user->username}}
											</li>
											<li>
												<span>Login Pin:</span>
												{{$user->login_pin}}
											</li>
											<li>
												<span>Emoji:</span>
												<div class="emoji-icons"> {!! $emoji_response !!}</div>
											</li>
											<li>
												<span>Website:</span>
												<a href="https://rurera.com">https://rurera.com</a>
											</li>
										</ul>
									</div>
								</div>
								<a href="javascript:;" class="reset-btn regenerate-emoji" data-user_id="{{$user->id}}">
													<span class="icon-box"><img src="/assets/default/svgs/retry.svg" alt=""></span>
												    Reset Emoji
											    </a>
											<a href="javascript:;" class="reset-btn regenerate-pin" data-user_id="{{$user->id}}">
													<span class="icon-box"><img src="/assets/default/svgs/retry.svg" alt=""></span>
												    Reset Pin
											    </a>
											
							</div>
							<div class="edit-profile edit-profile-block mt-20 rurera-hide bg-white p-25">
								 <form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="username" class="" placeholder="Username" value="{{$user->username}}">
                                                </div>
                                            </div>
										</div>
										<div class="col-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="password" class="" placeholder="Password" value="">
                                                </div>
                                            </div>
										</div>
									</div>
									
									<div class="edit-profile-controls">
										<input type="hidden" name="user_id" value="{{$user->id}}">
										<a href="javascript:;" class="text-center cancel-edit-button">Reset</a>
										<a href="javascript:;" class="btn btn-primary text-center profile-save-btn">Save</a>
                                    </div>
									</form>
                        </div>
                        </div>
                    </div>
                    </div>
					
					
					
					
					
					<div class="row mb-50">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="info-text">
								<h3 class="font-18 font-weight-500 mb-5">Subscription Details</h3>
								<span class="font-16">Some information we need to know about you, and to process legal matters.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-16 font-weight-500 mb-25 inner-heading pb-15">Subscription Details</h2>
                            <div class="edit-info-list">
								@if( !isset( $user->userSubscriptions->id))<a href="javascript:;" class="membership-btn font-16 float-right package-payment-btn subscription-modal" data-type="child_payment" data-id="{{$user->id}}">+ Subscription</a>@endif
								@if( isset( $user->userSubscriptions->id))
										<div class="subscribe-plan active current-plan position-relative d-flex flex-column rounded-lg p-20 mb-10 mt-10">
											<div class="package-block">
												<span class="subscribe-icon"><img src="{{ $subscribe->icon }}" height="auto" width="auto" alt="Box image"/></span>
												<div class="subscribe-title">
													<h3 itemprop="title" class="font-24 font-weight-500">{{ $subscribe->title }}</h3>
												</div>
											</div>
											<div class="d-flex align-items-start text-dark-charcoal mb-20 subscribe-price">
												<span itemprop="price" class="font-36 line-height-1 packages-prices" data-package_price="{{$subscribe->price}}">{{ addCurrencyToPrice($subscribe->price) }}</span>
												<span class="yearly-price">{{ addCurrencyToPrice($subscribe->price) }} / {{(isset( $user->userSubscriptions->subscribe_for ) && $user->userSubscriptions->subscribe_for == 12)? 'Monthly' : 'Monthly'}}</span>
												<span class="yearly-price">Expiry: {{isset( $user->userSubscriptions->expiry_at )? dateTimeFormat($user->userSubscriptions->expiry_at, 'j M Y') : '-'}}</span>
														
											</div>
											<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12">
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12">
												<a href="javascript:;" class="package-update-btn btn w-100 subscription-modal" data-type="update_package" data-id="{{$user->id}}">Update Subscription
												</a>
											</div>
											</div>
										</div>
									@endif
									
									@if(isset( $user->userSubscriptions->subscribe ) && $user->userSubscriptions->is_cancelled == 0 )	
									<a href="javascript:;" class="reset-btn package-payment-btn cancel-subscription-modal" data-type="child_payment" data-id="{{$user->id}}">
										<span class="icon-box"><img src="/assets/default/svgs/retry.svg" alt=""></span>
												  &nbsp;&nbsp;Cancel Subscription
											&nbsp;&nbsp;&nbsp;&nbsp;
										</a>
									@else
										@if(isset( $user->userSubscriptions->id))
										<div class="cancel-message">Subscription has been canceled. You will still be able to use the package till its expiry and wont be charged for the renwal.</div>
										@endif
									@endif
									
									
								</div>
						</div>
					</div>
								
								
					
		    @if( isset( $user->card_last_four ) && $user->card_last_four != '')
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="info-text">
                        <h3 class="font-18 font-weight-500 mb-5">Main Card</h3>
                        <span class="font-16">This is your company main credit card. You can use it to pay for any type of expenses</span>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
					<h2 class="font-16 font-weight-500 mb-25 inner-heading pb-15">Main Card</h2>
                    <div class="edit-info-list">
                        <ul>
                            <li>
                                <div class="payment-card-holder mb-15">
                                    <div class="payment-card bg-white py-15 px-20 d-inline-block">
                                        <div class="card-top d-flex align-items-center flex-wrap justify-content-between mb-15">
                                            <span class="card-type-lebel d-inline-block pl-15">{{$user->card_brand}}</span>
                                            <div class="card-circle">
                                                <span class="circle-pink d-inline-block"></span>
                                                <span class="circle-yellow d-inline-block"></span>
                                            </div>
                                        </div>
                                        <div class="payment-card-body">
                                            <span class="card-type-icon d-block mb-15">
                                                <img src="/assets/default/svgs/card-chip.svg" alt="" height="32" width="44">
                                            </span>
                                            <div class="user-card-info d-flex align-items-center flex-wrap justify-content-between">
                                                <div class="card-info-text">
                                                    <span class="user-name d-block font-16">{{$user->get_full_name()}}</span>
                                                    <span class="card-number d-block font-16">&#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; {{$user->card_last_four}}</span>
                                                    <div class="card-exp">
                                                        <span class="d-inline-block font-16">EXP</span>
                                                        <span class="d-inline-block font-16">&#x2022; &#x2022;/&#x2022; &#x2022;</span>
                                                        <span class="d-inline-block font-16">CVC</span>
                                                        <span class="d-inline-block font-16">&#x2022; &#x2022; &#x2022;</span>
                                                    </div>
                                                </div>
                                                <span class="card-info-icon">
                                                    <img src="/assets/default/svgs/card-info.svg" alt="" height="40" width="40">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="edtit-btn d-inline-flex align-items-center font-weight-500 font-16">Manage your cards <span class="font-16">&#8594;</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
			@endif
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
                            <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                                <a href="javascript:;" class="nav-link btn-primary rounded-pill mb-10 unlink-btn" data-child_id="0">Proceed Unlink</a>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts_bottom')
<script src="/assets/admin/vendor/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
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
<script>
			/*$(document).on('click', '.edit-profile-btn', function (e) {
				$(".user-view-profile").addClass('rurera-hide');
				$(".user-edit-profile").removeClass('rurera-hide');
			});*/
			
			$(document).on('click', '.edit-profile-btn', function (e) {
				$('body').addClass('disabled-div');
				$('body').addClass('disabled-style2');
				$(this).closest('.edit-info-list').find('.profile-view-data').addClass('rurera-hide');
				$(this).closest('.edit-info-list').find('.edit-profile-block').removeClass('rurera-hide');
				
				$(this).closest('.edit-info-list').find('.edit-profile-block').addClass('no-disabled');
			});

			$(document).on('click', '.cancel-edit-button', function (e) {
				$('body').removeClass('disabled-div');
				$('body').removeClass('disabled-style2');
				$(this).closest('.edit-info-list').find('.profile-view-data').removeClass('rurera-hide');
				$(this).closest('.edit-info-list').find('.edit-profile-block').addClass('rurera-hide');
				$(this).closest('.edit-info-list').find('.edit-profile-block').removeClass('no-disabled');
			});
			
			var profileSubmission = null;
			
			$(document).on('click', '.profile-save-btn', function (e) {
				var user_id = '{{$user->id}}';
				var thisObj = $(this);
				var formData = new FormData($(this).closest('form')[0]);
				console.log('submission');
				returnType = rurera_validation_process($(this).closest('form'), 'under_field');
				if (returnType == false) {
					return false;
				}
				rurera_loader(thisObj, 'div');
				profileSubmission = $.ajax({
					type: "POST",
					url: '/subscribes/edit-child',
					data: formData,
					beforeSend: function () {
						if (profileSubmission != null) {
							profileSubmission.abort();
						}
					},
					processData: false,
					contentType: false,
					success: function (return_data) {
						$.ajax({
						type: "GET",
						url: '/panel/student-profile/'+user_id,
						data: {"user_id": user_id},
						success: function (return_data) {
							rurera_remove_loader(thisObj, 'div');
							jQuery.growl.notice({
								title: '',
								message: 'Updated Successfully',
							});
							$(".user-profile-block").html(return_data);
							rurera_remove_loader($('.user-profile-block'), 'div');
							location.reload();
						}
					});
						
						//location.reload();
					}
				});
				
			});
			
			
			
			$(document).on('click', '.unlink-parent-btn', function (e) {
				var parent_id = $(this).attr('data-parent_id');
				var user_id = '{{$user->id}}';
				var thisObj = $(this);
				rurera_loader(thisObj, 'div');
				$.ajax({
					type: "GET",
					url: '/panel/setting/unlink-child-parent',
					data: {"parent_id": parent_id, "user_id": user_id},
					dataType:'json',
					success: function (return_data) {
						rurera_remove_loader(thisObj, 'div');
						Swal.fire({
						  icon: return_data.status,
						  html: '<h3 class="font-20 text-center text-dark-blue py-25">'+return_data.msg+'</h3>',
						  showConfirmButton: false,
						  width: '25rem'
						});
						location.reload();
					}
						
				});
				
			});
			
			
			
			
			

			/*$(document).on('click', '.cancel-edit-button', function (e) {
				$(".user-view-profile").removeClass('rurera-hide');
				$(".user-edit-profile").addClass('rurera-hide');
			});*/
			
			var user_avatar_settings = '<?php echo $avatar_settings; ?>';
			var avatar_color_settings = '<?php echo $avatar_color_settings; ?>';

			user_avatar_settings = JSON.parse(user_avatar_settings);
			avatar_color_settings = JSON.parse(avatar_color_settings);
			
			var imageClicked = false;
			$(document).on('click', '.profile-image-btn', function (e) {
				$("#profile-image-modal").modal('show');
				if( imageClicked == false) {
					var start_id = '{{$user->user_preference}}';
					start_id = (start_id == 'female') ? 'girls' : 'boys';
					$("#svga-start-" + start_id).click();
					imageClicked = true;
				}
			});
			
			function refresh_preference_field() {
				$('.preference_field option').removeAttr('disabled');
				$('.preference_field').each(function () {
					var current_value = $(this).val();
					if( current_value != '') {
						$('.preference_field option[value="' + current_value + '"]').attr('disabled', 'disabled');
						$(this).find('option[value="' + current_value + '"]').removeAttr('disabled');
					}
				});
			}

			$(document).on('change', '.preference_field', function (e) {
				refresh_preference_field();
			});
			refresh_preference_field();
			resetRureraDatePickers();
			
			
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
