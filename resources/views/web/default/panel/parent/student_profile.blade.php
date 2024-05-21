@php
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
@endphp
<div class="user-detail mb-50 user-view-profile">
                <div class="detail-header mb-25 pb-25">
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-14 font-weight-500 pb-15 px-15">Account Overview</h4>
                                <ul>
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
                                                Gender
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
                            </div>
                        </div>
                    </div>
                    <div class="row mb-50">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-14 font-weight-500 pb-15 px-15">School Preference</h4>
                                <ul>
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
                            </div>
                        </div>
                    </div>
                    <div class="row mb-50">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-14 font-weight-500 pb-15 px-15">Display Settings</h4>
                                <ul>
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
                            </div>
                        </div>
                    </div>
                    <div class="row mb-50">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-14 font-weight-500 pb-15 px-15">Login Details</h4>
                                <ul>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Username
                                                <strong class="d-block font-weight-500">{{isset($user->username)? $user->username : '-'}}</strong>
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
                                                Login Emojis
                                                <strong class="d-block font-weight-500">{!! $emoji_response !!}</strong>
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
                                                Login Pin
                                                <strong class="d-block font-weight-500">{{$user->login_pin}}</strong>
                                            </span>
                                            <span class="edit-icon d-inline-flex align-items-center">
                                                <img src="/assets/default/svgs/edit-2.svg" alt="" height="18" width="18">
                                                <em class="font-weight-500">Edit</em>
                                            </span>
                                        </a>
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
										<div class="col-12 form-group">
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
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="username" class="" placeholder="Username" value="{{$user->username}}">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="password" class="" placeholder="Password" value="">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												{!! $emoji_response !!}
												<a class="btn btn-primary d-block mt-15 regenerate-emoji" data-user_id="{{$user->id}}" href="javascript:;">Generate Emoji</a>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												{{$user->login_pin}}
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
			
			<script>
			$(document).on('click', '.edit-profile-btn', function (e) {
				$(".user-view-profile").addClass('rurera-hide');
				$(".user-edit-profile").removeClass('rurera-hide');
			});

			$(document).on('click', '.cancel-edit-button', function (e) {
				$(".user-view-profile").removeClass('rurera-hide');
				$(".user-edit-profile").addClass('rurera-hide');
			});
	</script>