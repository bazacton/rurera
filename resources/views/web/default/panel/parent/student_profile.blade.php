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
<div class="user-detail user-view-profile">
                <div class="detail-header-profile mb-25 pb-25">
                    <div class="info-media d-flex align-items-center flex-wrap">
                        <span class="media-box">
							<a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
								<img src="{{$user->getAvatar()}}" alt="">
							</a>
                        </span>
                        <h2 class="info-title font-weight-500">
                            {{$user->get_full_name()}}
                        </h2>
                    </div>
                </div>
                <div class="detail-body">
				
                    <div class="row mb-50">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="info-text">
								<h3 class="font-18 font-weight-500 mb-5">Account Overview</h3>
								<span class="font-14">Some basic information that we need to know about student.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-14 font-weight-500 mb-5 inner-heading">Account Overview</h2>
                            <div class="edit-info-list">
                                <ul class="profile-view-data">
									<li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                First Name
                                                <strong class="d-block font-weight-500">{{$user->get_first_name()}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									<li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Last name
                                                <strong class="d-block font-weight-500">{{$user->get_last_name()}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Display name
                                                <strong class="d-block font-weight-500">{{$user->display_name}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									 <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Preference
                                                <strong class="d-block font-weight-500">{{$user->user_preference}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
									 <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Year Group
                                                <strong class="d-block font-weight-500">{{isset($user->userYear->id )? $user->userYear->getTitleAttribute() : ''}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
								<div class="edit-profile edit-profile-block mt-10 rurera-hide">
								
								
								 <form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<div class="form-group">
												<span class="fomr-label">Student's first name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="First Name" name="first_name" value="{{$user->get_first_name()}}">
												</div>
											</div>
										</div>
										
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<div class="form-group">
												<span class="fomr-label">Student's last name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="Last name" name="last_name" value="{{$user->get_last_name()}}">
												</div>
											</div>
										</div>
										
										
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<div class="form-group">
												<span class="fomr-label">Display name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="Display name" name="display_name" value="{{($user->display_name != '')? $user->display_name : $user->get_first_name().' '.$user->get_last_name()}}">
												</div>
											</div>
										</div>
										
										
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<label>Preference</label>
											<div class="select-field">
												<select class="form-control rurera-req-field" name="user_preference">
													<option value="male" {{($user->user_preference == 'male' || $user->user_preference == '')? 'selected' : ''}}>Male</option>
													<option value="female" {{($user->user_preference == 'female')? 'selected' : ''}}>Female</option>
												</select>
											</div>
										</div>
										<div class="col-12 col-lg-12 col-md-12 form-group">
											<label>Year Group</label>
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
								<span class="font-14">List the schools with exam date you're applying for in order of preference.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-14 font-weight-500 mb-5 inner-heading">School Preference</h2>
                            <div class="edit-info-list">
                                <ul class="profile-view-data">
									<li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Test Prep School Choice
                                                <strong class="d-block font-weight-500">{{isset($user->userSchoolPreffernce1->title)? $user->userSchoolPreffernce1->title : '-'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                School Preference 1
                                                <strong class="d-block font-weight-500">{{isset($user->userSchoolPreffernce1->title)? $user->userSchoolPreffernce1->title : '-'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                School Preference 2
                                                <strong class="d-block font-weight-500">{{isset( $user->userSchoolPreffernce2->title )? $user->userSchoolPreffernce2->title : '-'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                School Preference 3
                                                <strong class="d-block font-weight-500">{{isset( $user->userSchoolPreffernce3->title )? $user->userSchoolPreffernce3->title : '-'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
								
								<div class="edit-profile edit-profile-block mt-10 rurera-hide">
								<form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6 col-lg-6 col-md-6 form-group">
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
										<div class="col-6 col-lg-6 col-md-6 form-group">
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
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<label>Preference 2</label>
											<div class="select-field">
												<select class="form-control preference_field rurera-req-field" name="school_preference_2">
													<option value="">Select Preference</option>
													@foreach( $schools as $schoolObj)
														<option value="{{$schoolObj->id}}" {{($schoolObj->id == $user->school_preference_2)? 'selected' : ''}}>{{$schoolObj->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6 form-group">
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
								<span class="font-14">Display settings control the layout and behavior of the student panel. You can toggle the visibility of different elements to customize what students can see.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-14 font-weight-500 mb-5 inner-heading">Display Settings</h2>
                            <div class="edit-info-list">
                                <ul class="profile-view-data">
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Hide Timestables
                                                <strong class="d-block font-weight-500">{{$user->hide_timestables == 1 ? 'Yes' : 'No'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Hide Spellings
                                                <strong class="d-block font-weight-500">{{$user->hide_spellings == 1 ? 'Yes' : 'No'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Hide Games
                                                <strong class="d-block font-weight-500">{{$user->hide_games == 1 ? 'Yes' : 'No'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Hide Books
                                                <strong class="d-block font-weight-500">{{$user->hide_books == 1 ? 'Yes' : 'No'}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
								<div class="edit-profile edit-profile-block mt-10 rurera-hide">
								<form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6 col-sm-12 col-md-6 col-lg-6">
										
										<div class="form-group custom-switches-stacked mb-15">
											<label class="custom-switch pl-0">
												<input type="checkbox" name="hide_timestables"
													   id="hide_timestables_field" value="1" class="custom-switch-input"  {{($user->hide_timestables == 1)? 'checked' : ''}}/>
												<span class="custom-switch-indicator"></span>
												<label class="custom-switch-description mb-0 cursor-pointer"
													   for="hide_timestables_field">Hide Timestables</label>
											</label>
										</div>
										</div>
										
										<div class="col-6 col-sm-12 col-md-6 col-lg-6">
											
											<div class="form-group custom-switches-stacked mb-15">
												<label class="custom-switch pl-0">
													<input type="checkbox" name="hide_spellings"
														   id="hide_spellings_field" value="1" class="custom-switch-input"  {{($user->hide_spellings == 1)? 'checked' : ''}}/>
													<span class="custom-switch-indicator"></span>
													<label class="custom-switch-description mb-0 cursor-pointer"
														   for="hide_spellings_field">Hide Spellings</label>
												</label>
											</div>
										</div>
										
										<div class="col-6 col-sm-12 col-md-6 col-lg-6">
											
											<div class="form-group custom-switches-stacked mb-15">
												<label class="custom-switch pl-0">
													<input type="checkbox" name="hide_games"
														   id="hide_games_field" value="1" class="custom-switch-input"  {{($user->hide_games == 1)? 'checked' : ''}}/>
													<span class="custom-switch-indicator"></span>
													<label class="custom-switch-description mb-0 cursor-pointer"
														   for="hide_games_field">Hide Games</label>
												</label>
											</div>
										</div>
										
										<div class="col-6 col-sm-12 col-md-6 col-lg-6">
											
											<div class="form-group custom-switches-stacked mb-15">
												<label class="custom-switch pl-0">
													<input type="checkbox" name="hide_books"
														   id="hide_books_field" value="1" class="custom-switch-input"  {{($user->hide_books == 1)? 'checked' : ''}}/>
													<span class="custom-switch-indicator"></span>
													<label class="custom-switch-description mb-0 cursor-pointer"
														   for="hide_books_field">Hide Books</label>
												</label>
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
                    <div class="row mb-0">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="info-text">
								<h3 class="font-18 font-weight-500 mb-5">Login Details</h3>
								<span class="font-14">login credential can be changed,Set a unique password to protect student account. Don't forget to change it from time to time.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<div class="edit-info-list">
								<h2 class="font-14 font-weight-500 mb-5 inner-heading">Login Details
									<a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between">
										<span class="edit-icon d-inline-flex align-items-center float-right pr-15">
											<img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
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
							<div class="edit-profile edit-profile-block mt-10 rurera-hide">
								 <form class="child-edit-form" method="post" action="javascript:;">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<label>Username</label>
											<div class="input-field">
												<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
												<input type="text" name="username" class="" placeholder="Username" value="{{$user->username}}">
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<label>Password</label>
											<div class="input-field">
												<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
												<input type="text" name="password" class="" placeholder="Password" value="">
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
								<span class="font-14">Some information we need to know about you, and to process legal matters.</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<h2 class="font-14 font-weight-500 mb-5 inner-heading">Subscription Details</h2>
                            <div class="edit-info-list">
								@if( !isset( $user->userSubscriptions->id))<a href="javascript:;" class="membership-btn font-14 float-right package-payment-btn subscription-modal" data-type="child_payment" data-id="{{$user->id}}">+ Subscription</a>@endif
								@if( isset( $user->userSubscriptions->id))
										<div class="subscribe-plan active current-plan position-relative d-flex flex-column rounded-lg p-20 mb-30 mt-10">
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
								</div>
								
								@if(isset( $user->userSubscriptions->subscribe ) && $user->userSubscriptions->is_cancelled == 0 )	
									<a href="javascript:;" class="package-payment-btn switch-user-btn cancel-subscription-modal btn w-100" data-type="child_payment" data-id="{{$user->id}}">
										Cancel Subscription
									</a>
								@else
									<div class="cancel-message">Subscription has been canceled. You will still be able to use the package till its expiry and wont be charged for the renwal.</div>
								@endif
						</div>
					</div>
								
								
								
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="info-text">
                        <h3 class="font-18 font-weight-500 mb-5">Main Card</h3>
                        <span class="font-14">This is your company main credit card. You can use it to pay for any type of expenses</span>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
					<h2 class="font-14 font-weight-500 mb-5 inner-heading">Main Card</h2>
                    <div class="edit-info-list">
                        <ul>
                            <li>
                                <div class="payment-card-holder mb-15">
                                    <div class="payment-card bg-white py-15 px-20 d-inline-block">
                                        <div class="card-top d-flex align-items-center flex-wrap justify-content-between mb-15">
                                            <span class="card-type-lebel d-inline-block pl-15">Mastercard</span>
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
                                                    <span class="user-name d-block font-15">Kendra Wilson</span>
                                                    <span class="card-number d-block font-14">&#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; 4728</span>
                                                    <div class="card-exp">
                                                        <span class="d-inline-block font-14">EXP</span>
                                                        <span class="d-inline-block font-14">&#x2022; &#x2022;/&#x2022; &#x2022;</span>
                                                        <span class="d-inline-block font-14">CVC</span>
                                                        <span class="d-inline-block font-14">&#x2022; &#x2022; &#x2022;</span>
                                                    </div>
                                                </div>
                                                <span class="card-info-icon">
                                                    <img src="/assets/default/svgs/card-info.svg" alt="" height="40" width="40">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="edtit-btn d-inline-flex align-items-center font-weight-500 font-15">Manage your cards <span class="font-16">&#8594;</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
					
					
					
                </div>
            </div>
			
			
			
			
			<div class="col-12 user-edit-profile rurera-hide">
            <div class="edit-profile mb-50">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="edit-profile-content-holder tab-content" id="myTabContent">
                            <div class="edit-profile-content" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                                <div class="edit-profile-top d-flex align-items-center flex-wrap justify-content-between mb-50">
                                    <div class="top-heading">
                                        <h5 class="font-14 font-weight-500">
                                            
                                        </h5>
                                    </div>
                                    <div class="edit-profile-controls">
										<a href="javascript:;" class="text-center cancel-edit-button">Cancel</a>
                                    </div>
                                </div>
                                <div class="edit-user-profile-body">
                                    <div class="edit-profile-image">
                                        <div class="edit-element-title mb-20">
                                            <h6 class="font-weight-500">
                                                Profile picture
                                                <span class="d-block pt-5 font-12">This is how others will recognize you</span>
                                            </h6>
                                        </div>
                                        <div class="profile-image text-center">
                                            <figure class="d-inline-flex position-relative">
                                                <img src="{{ (!empty($user)) ? $user->getAvatar(150) : '' }}" height="96" width="96" alt="">
                                                <a href="javascript:;" class="profile-image-btn cancel-btn d-inline-flex align-items-center justify-content-center font-14 bg-white"><img src="/assets/default/svgs/edit-2.svg" alt="" style="width:18px; height:18px"></a>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="mb-0 mt-20">
                                        <div class="row">
										
										
										<div class="col-12">
											<div class="edit-element-title mb-20">
												<h6 class="font-weight-500">
													Account overview
												</h6>
											</div>
										</div>
										
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<div class="form-group">
												<span class="fomr-label">Student's first name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="First Name" name="first_name" value="{{$user->get_first_name()}}">
												</div>
											</div>
										</div>
										
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<div class="form-group">
												<span class="fomr-label">Student's last name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="Last name" name="last_name" value="{{$user->get_last_name()}}">
												</div>
											</div>
										</div>
										
										
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<div class="form-group">
												<span class="fomr-label">Display name</span>
												<div class="input-field">
													<span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
													<input type="text" class="rurera-req-field" placeholder="Display name" name="display_name" value="{{($user->display_name != '')? $user->display_name : $user->get_first_name().' '.$user->get_last_name()}}">
												</div>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<label>Year Group</label>
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
								</div>
								
								<div class="mb-0 mt-20">
									<div class="row">
										<div class="col-12">
											<div class="edit-element-title mb-20">
												<h6 class="font-weight-500">
													School Preference
												</h6>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6 form-group">
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
										<div class="col-6 col-lg-6 col-md-6 form-group">
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
										<div class="col-6 col-lg-6 col-md-6 form-group">
											<label>Preference 2</label>
											<div class="select-field">
												<select class="form-control preference_field rurera-req-field" name="school_preference_2">
													<option value="">Select Preference</option>
													@foreach( $schools as $schoolObj)
														<option value="{{$schoolObj->id}}" {{($schoolObj->id == $user->school_preference_2)? 'selected' : ''}}>{{$schoolObj->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-6 col-lg-6 col-md-6 form-group">
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
										
										</div>
									</div>
									<div class="mb-0 mt-20">
										<div class="row">
										
										<div class="col-12">
											<div class="edit-element-title mb-20">
												<h6 class="font-weight-500">
													Display Settings
												</h6>
											</div>
										</div>
										
										
										<div class="col-6 col-sm-12 col-md-6 col-lg-6">
										
										<div class="form-group custom-switches-stacked mb-15">
											<label class="custom-switch pl-0">
												<input type="checkbox" name="hide_timestables"
													   id="hide_timestables_field" value="1" class="custom-switch-input"  {{($user->hide_timestables == 1)? 'checked' : ''}}/>
												<span class="custom-switch-indicator"></span>
												<label class="custom-switch-description mb-0 cursor-pointer"
													   for="hide_timestables_field">Hide Timestables</label>
											</label>
										</div>
									</div>
									
									<div class="col-6 col-sm-12 col-md-6 col-lg-6">
										
										<div class="form-group custom-switches-stacked mb-15">
											<label class="custom-switch pl-0">
												<input type="checkbox" name="hide_spellings"
													   id="hide_spellings_field" value="1" class="custom-switch-input"  {{($user->hide_spellings == 1)? 'checked' : ''}}/>
												<span class="custom-switch-indicator"></span>
												<label class="custom-switch-description mb-0 cursor-pointer"
													   for="hide_spellings_field">Hide Spellings</label>
											</label>
										</div>
									</div>
									
									<div class="col-6 col-sm-12 col-md-6 col-lg-6">
										
										<div class="form-group custom-switches-stacked mb-15">
											<label class="custom-switch pl-0">
												<input type="checkbox" name="hide_games"
													   id="hide_games_field" value="1" class="custom-switch-input"  {{($user->hide_games == 1)? 'checked' : ''}}/>
												<span class="custom-switch-indicator"></span>
												<label class="custom-switch-description mb-0 cursor-pointer"
													   for="hide_games_field">Hide Games</label>
											</label>
										</div>
									</div>
									
									<div class="col-6 col-sm-12 col-md-6 col-lg-6">
										
										<div class="form-group custom-switches-stacked mb-15">
											<label class="custom-switch pl-0">
												<input type="checkbox" name="hide_books"
													   id="hide_books_field" value="1" class="custom-switch-input"  {{($user->hide_books == 1)? 'checked' : ''}}/>
												<span class="custom-switch-indicator"></span>
												<label class="custom-switch-description mb-0 cursor-pointer"
													   for="hide_books_field">Hide Books</label>
											</label>
										</div>
									</div>
											
											
											<div class="col-12">
                                                <div class="edit-element-title mb-20">
                                                    <h6 class="font-weight-500">
                                                        Login Details
                                                        <span class="d-block pt-5 font-12">This can help you to set login details</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>Username</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="username" class="" placeholder="Username" value="{{$user->username}}">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>Password</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="password" class="" placeholder="Password" value="">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>Login Emojis</label>
												{!! $emoji_response !!}
												<a class="btn btn-primary d-block mt-15 regenerate-emoji" data-user_id="{{$user->id}}" href="javascript:;">Generate Emoji</a>
												
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>Login Pin</label>
												<div>{{$user->login_pin}}</div>
												<a class="btn btn-primary d-block mt-15 regenerate-pin" data-user_id="{{$user->id}}" href="javascript:;">Generate Pin</a>
                                            </div>
											
                                        </div>
                                    </div>
									
									<input type="hidden" name="user_id" value="{{$user->id}}">
									<div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group mt-20 mb-0">
                                            <div class="btn-field">
                                                <button type="submit" class="nav-link">Update student's profile</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="modal fade" id="profile-image-modal" tabindex="-1" role="dialog" aria-labelledby="profile-image-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                    <div id="svgAvatars"></div>
            </div>
        </div>
    </div>
</div>
			
			<script>
			/*$(document).on('click', '.edit-profile-btn', function (e) {
				$(".user-view-profile").addClass('rurera-hide');
				$(".user-edit-profile").removeClass('rurera-hide');
			});*/
			
			$(document).on('click', '.edit-profile-btn', function (e) {
				$(this).closest('.edit-info-list').find('.profile-view-data').addClass('rurera-hide');
				$(this).closest('.edit-info-list').find('.edit-profile-block').removeClass('rurera-hide');
			});

			$(document).on('click', '.cancel-edit-button', function (e) {
				$(this).closest('.edit-info-list').find('.profile-view-data').removeClass('rurera-hide');
				$(this).closest('.edit-info-list').find('.edit-profile-block').addClass('rurera-hide');
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
						}
					});
						
						//location.reload();
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
	</script>