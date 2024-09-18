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
@endphp
<style type="text/css">
	.emoji-icons {display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-start;min-height: auto;}
    .emoji-icons .emoji-icon {border-radius: 100%; display: inline-block; object-fit: contain; height: 28px; width: 28px; }
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
<section>
    <h2 class="section-title">{{ trans('financial.account') }}</h2>

    <div class="row mt-30">


        <div class="col-12 user-profile-block rurera-hide">
            <div class="user-detail mb-50">
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
                        <div class="rurera-hide col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="info-text">
                                <h3 class="font-18 font-weight-500 mb-5">General info</h3>
                                <span class="font-16">Some information we need to know about you, and to process legal matters.</span>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-16 font-weight-500 pb-15 px-15">About you</h4>
                                <ul>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
                                                Display name
                                                <strong class="d-block font-weight-500">{{$user->display_name}}</strong>
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
                        <div class="rurera-hide col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="info-text">
                                <h3 class="font-18 font-weight-500 mb-5">Personal info</h3>
                                <span class="font-16">Some information we need to know about you, and to process legal matters.</span>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-16 font-weight-500 pb-15 px-15">Additional info</h4>
                                <ul>
                                    <li>
                                        <a href="javascript:;" class="d-flex align-items-center edit-profile-btn justify-content-between p-15">
                                            <span class="info-list-label font-16">
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
                                            <span class="info-list-label font-16">
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
                                            <span class="info-list-label font-16">
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
                                            <span class="info-list-label font-16">
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
                </div>
            </div>
        </div>
        <div class="col-12 user-edit-profile">
            <div class="edit-profile mb-50">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12 rurera-hide">
                        <div class="edit-profile-sidebar">
                            <div class="user-info d-flex align-items-center flex-wrap mb-30">
                                <img src="{{ (!empty($user)) ? $user->getAvatar(150) : '' }}" alt="" height="48" width="48">
                                <span class="info-text d-inline-flex flex-column font-weight-500">
                                    {{$user->display_name}}
                                </span>
                            </div>
                            <div class="edit-profile-menu">
                                <ul class="nav flex-column" id="myTab" role="tablist">
                                    <li>
                                        <a class="nav-link active d-flex align-items-center" id="edit-profile-tab" data-toggle="tab" href="#edit-profile" role="tab" aria-controls="edit-profile" aria-selected="true">
                                            <span class="icon-box d-inline-block"><img src="/assets/default/svgs/edit-menu-user.svg" height="15" width="15" alt=""></span> General
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link d-flex align-items-center" id="edit-experience-tab" data-toggle="tab" href="#edit-experience" role="tab" aria-controls="edit-experience" aria-selected="false">
                                            <span class="icon-box d-inline-block"><img src="/assets/default/svgs/edit-menu-home.svg" height="15" width="15" alt=""></span>Experience
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link d-flex align-items-center" id="edit-skills-tab" data-toggle="tab" href="#edit-skills" role="tab" aria-controls="edit-skills" aria-selected="false">
                                            <span class="icon-box d-inline-block"><img src="/assets/default/svgs/edit-menu-diamond.svg" height="15" width="15" alt=""></span>Skills &amp; Tools
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link d-flex align-items-center" id="edit-settings-tab" data-toggle="tab" href="#edit-settings" role="tab" aria-controls="edit-settings" aria-selected="false">
                                            <span class="icon-box d-inline-block"><img src="/assets/default/svgs/edit-menu-setting.svg" height="15" width="15" alt=""></span>Settings
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="edit-profile-content-holder tab-content" id="myTabContent">
                            <div class="edit-profile-content panel-border bg-white rounded-sm p-25 tab-pane fade show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                                <!-- <div class="edit-profile-top d-flex align-items-center flex-wrap justify-content-between mb-50">
                                    <div class="top-heading">
                                        <h5 class="font-16 font-weight-500">
                                            GENERAL INFO
                                            <span class="d-block pt-5 font-12">Edit your account's general information</span>
                                        </h5>
                                    </div>
                                </div> -->
                                <div class="edit-element-title mb-15">
                                    <h6 class="font-weight-500">
                                        Profile picture
                                        <!-- <span class="d-block pt-5 font-12">This is how others will recognize you</span> -->
                                    </h6>
                                </div>
                                <div class="edit-profile-body">
                                    <div class="edit-profile-image mb-30">
                                        <div class="profile-image">
                                            <figure class="d-inline-flex position-relative">
                                                <img src="{{ (!empty($user)) ? $user->getAvatar(150) : '' }}" height="96" width="96" alt="">
                                                <a href="javascript:;" class="profile-image-btn cancel-btn d-inline-flex justify-content-center font-14 flex-column">
                                                    <small class="img-type font-14 font-weight-500">JPG, GIF or PNG. Maximum file size 1 MB.</small>    
                                                    <span class="font-weight-bold">Change photo</span>
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="edit-element-title mb-10">
                                                    <h6 class="font-weight-500">
                                                        Profile Info
                                                        <!-- <span class="d-block pt-5 font-12">Others diserve to know you more</span> -->
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-12 col-md-12 form-group">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="display_name" class="rurera-req-field" placeholder="Display Name" value="{{( $user->display_name != '')? $user->display_name : $user->first_name.' '.$user->last_name}}">
                                                </div>
                                            </div>	
											
											
											<div class="col-12">
                                                <div class="edit-element-title mb-10">
                                                    <h6 class="font-weight-500">
                                                        Login Details
                                                        <!-- <span class="d-block pt-5 font-12">This can help you to set login details</span> -->
                                                    </h6>
                                                </div>
                                            </div>
											<div class="col-12 detail-body">
												<div class="student-profile-holder profile-view-data">
													<div class="profile-inner">
														<div class="profile-header">
															<h3>{{$user->display_name}}</h3>
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
																
												</div>
											</div>
											
											
                                        </div>
                                    </div>
                                </div>
                                <div class="edit-profile-controls d-flex justify-content-end align-items-center">
                                    <button type="button" id="saveData" class="save-btn text-center ">Save</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="edit-experience" role="tabpanel" aria-labelledby="edit-experience-tab">Experience</div>
                            <div class="tab-pane fade" id="edit-skills" role="tabpanel" aria-labelledby="edit-skills-tab">Skills</div>
                            <div class="tab-pane fade" id="edit-settings" role="tabpanel" aria-labelledby="edit-settings-tab">Settings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>


<div class="modal fade" id="profile-image-modal" tabindex="-1" role="dialog" aria-labelledby="profile-image-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                    <div id="svgAvatars"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="avatarCropModalContainer" tabindex="-1" role="dialog" aria-labelledby="avatarCrop">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ trans('public.edit_selected_image') }}</h4>
            </div>
            <div class="modal-body">
                <div id="imageCropperContainer">
                    <div class="cropit-preview"></div>
                    <div class="cropit-tools">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="mr-20">
                                <button type="button" class="btn btn-transparent rotate-cw mr-10">
                                    <i data-feather="rotate-cw" width="18" height="18"></i>
                                </button>
                                <button type="button" class="btn btn-transparent rotate-ccw">
                                    <i data-feather="rotate-ccw" width="18" height="18"></i>
                                </button>
                            </div>

                            <div class="d-flex align-items-center justify-content-center">
                                <span>-</span>
                                <input type="range" class="cropit-image-zoom-input mx-10">
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-transparent" id="cancelAvatarCrop">{{ trans('public.cancel') }}</button>
                        <button class="btn btn-green" id="storeAvatar">{{ trans('public.select') }}</button>
                    </div>
                    <input type="file" class="cropit-image-input">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var user_avatar_settings = '<?php echo $avatar_settings; ?>';
    var avatar_color_settings = '<?php echo $avatar_color_settings; ?>';

    user_avatar_settings = JSON.parse(user_avatar_settings);
    avatar_color_settings = JSON.parse(avatar_color_settings);

$(document).ready(function () {





    $(document).on('click', '.regenerate-emoji', function (e) {
        rurera_loader($("#userSettingForm"), 'div');
        var login_emoji = $(".emoji-password-field").val();

        jQuery.ajax({
           type: "POST",
           url: '/panel/users/generate-emoji',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {'login_emoji':login_emoji},
           success: function (return_data) {
               rurera_remove_loader($("#userSettingForm"), 'div');
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


    $(document).on('click', '.edit-profile-btn', function (e) {
        $(".user-profile-block").addClass('rurera-hide');
        $(".user-edit-profile").removeClass('rurera-hide');
    });

    $(document).on('click', '.cancel-edit-button', function (e) {
        $(".user-profile-block").removeClass('rurera-hide');
        $(".user-edit-profile").addClass('rurera-hide');
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





    $(document).on('click', '.regenerate-pin', function (e) {
        rurera_loader($("#userSettingForm"), 'div');
        jQuery.ajax({
           type: "POST",
           url: '/panel/users/generate-pin',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {},
           success: function (return_data) {
               rurera_remove_loader($("#userSettingForm"), 'div');
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
});


</script>