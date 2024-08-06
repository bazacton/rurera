@php
$user_avatar_settings = $user->user_avatar_settings;
$user_avatar_settings = json_decode($user_avatar_settings);
$avatar_settings = isset( $user_avatar_settings->avatar_settings )? (array) $user_avatar_settings->avatar_settings : array();
$avatar_color_settings = isset( $user_avatar_settings->avatar_color_settings )? (array) $user_avatar_settings->avatar_color_settings : array();
$avatar_settings = json_encode($avatar_settings);
$avatar_color_settings = json_encode($avatar_color_settings);
@endphp

<section>
    <h2 class="section-title">{{ trans('financial.account') }}</h2>

    <div class="row mt-30">


        <div class="col-12 user-profile-block">
            <div class="user-detail mb-50">
                <div class="detail-header mb-25 pb-25">
                    <div class="info-media d-flex align-items-center flex-wrap">
                        <span class="media-box">
                            <img src="{{$user->getAvatar()}}" alt="">
                        </span>
                        <h2 class="info-title font-weight-500">
                            {{$user->display_name}}
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
                                                Date of birth
                                                <strong class="d-block font-weight-500">12/10/1988</strong>
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
                                            <span class="info-list-label font-16">
                                                Email Addres
                                                <strong class="d-block font-weight-500">{{$user->email}}</strong>
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
                                                Contact no
                                                <strong class="d-block font-weight-500">{{$user->mobile}}</strong>
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
        <div class="col-12 user-edit-profile rurera-hide">
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
                                <div class="edit-profile-body">
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
                                                <a href="javascript:;" class="profile-image-btn cancel-btn d-inline-flex align-items-center justify-content-center font-16 bg-white"><img src="/assets/default/svgs/edit-2.svg" alt="" style="width:18px; height:18px"></a>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="edit-element-title mb-20">
                                                    <h6 class="font-weight-500">
                                                        Profile Info
                                                        <span class="d-block pt-5 font-12">Others diserve to know you more</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>First Name</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="first_name" class="rurera-req-field" placeholder="First Name" value="{{( $user->first_name != '')? $user->first_name : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>Last Name</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="last_name" class="rurera-req-field" placeholder="Last Name" value="{{( $user->last_name != '')? $user->last_name : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>Display Name</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="display_name" class="rurera-req-field" placeholder="Display Name" value="{{( $user->display_name != '')? $user->display_name : $user->first_name.' '.$user->last_name}}">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6 form-group">
												<label>Email Address</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" name="email" class="rurera-req-field" placeholder="Email Address" value="{{( $user->email != '')? $user->email : ''}}">
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
												<label>Contact no</label>
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/mobile.svg" alt=""></span>
                                                    <input type="text" name="mobile" class="rurera-req-field" placeholder="Contact no" value="{{( $user->mobile != '')? $user->mobile : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Your Preference</label>
                                                <div class="select-field">
                                                    <select name="user_preference" class="rurera-req-field">
                                                        <option value="male" {{ (!empty($user) && $user->user_preference == 'male') ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ (!empty($user) && $user->user_preference == 'female') ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                            </div>
											<div class="col-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group custom-switches-stacked">
													<label class="custom-switch pl-0">
														<input type="hidden" name="weekly_summary_emails_label" value="0">
														<input type="checkbox" name="weekly_summary_emails"
															   id="weekly_summary_emails_label" value="1" class="custom-switch-input" {{ (!empty($user) && $user->weekly_summary_emails == '1') ? 'checked' : '' }}/>
														<span class="custom-switch-indicator"></span>
														<label class="custom-switch-description mb-0 cursor-pointer"
															   for="weekly_summary_emails_label">Receive weekly summary emails</label>
													</label>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="edit-profile-footer">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="edit-profile-controls text-right">
                                                <a href="javascript:;" class="text-center cancel-edit-button">Cancel</a>
                                                <button type="button" id="saveData" class="save-btn text-center ">Save</button>
                                            </div>
                                        </div>
                                    </div>
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