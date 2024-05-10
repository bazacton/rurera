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


        <div class="col-12">
            <div class="user-detail mb-50">
                <div class="detail-header mb-25 pb-25">
                    <div class="info-media d-flex align-items-center flex-wrap">
                        <span class="media-box">
                            <img src="{{$user->getAvatar()}}" alt="">
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
                                <h3 class="font-18 font-weight-500 mb-5">General info</h3>
                                <span class="font-14">Some information we need to know about you, and to process legal matters.</span>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-14 font-weight-500 pb-15 px-15">About you</h4>
                                <ul>
                                    <li>
                                        <a href="#" class="d-flex align-items-center justify-content-between p-15">
                                            <span class="info-list-label font-14">
                                                Legal name
                                                <strong class="d-block font-weight-500">{{$user->get_full_name()}}</strong>
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
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="info-text">
                                <h3 class="font-18 font-weight-500 mb-5">Personal info</h3>
                                <span class="font-14">Some information we need to know about you, and to process legal matters.</span>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-14 font-weight-500 pb-15 px-15">Additional info</h4>
                                <ul>
                                    <li>
                                        <a href="#" class="d-flex align-items-center justify-content-between p-15">
                                            <span class="info-list-label font-14">
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
                                        <a href="#" class="d-flex align-items-center justify-content-between p-15">
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="edit-profile mb-50">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="edit-profile-sidebar">
                            <div class="user-info d-flex align-items-center flex-wrap mb-30">
                                <img src="/avatar/svgA44708602509147854.png" alt="" height="48" width="48">
                                <span class="info-text d-inline-flex flex-column font-weight-500">
                                    Maya Rosselini
                                    <small>Product Manager</small>
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
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="edit-profile-content-holder tab-content" id="myTabContent">
                            <div class="edit-profile-content panel-border bg-white rounded-sm p-25 tab-pane fade show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                                <div class="edit-profile-top d-flex align-items-center flex-wrap justify-content-between mb-50">
                                    <div class="top-heading">
                                        <h5 class="font-14 font-weight-500">
                                            GENERAL INFO
                                            <span class="d-block pt-5 font-12">Edit your account's general information</span>
                                        </h5>
                                    </div>
                                    <div class="edit-profile-controls">
                                        <button class="text-center">Cancel</button>
                                        <button class="save-btn text-center">Save</button>
                                    </div>
                                </div>
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
                                                <img src="/avatar/svgA44708602509147854.png" height="96" width="96" alt="">
                                                <a href="#" class="cancel-btn d-inline-flex align-items-center justify-content-center font-14 bg-white">✖</a>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="edit-element-title mb-20">
                                                    <h6 class="font-weight-500">
                                                        Profile Info
                                                        <span class="d-block pt-5 font-12">Others diserve to know you more</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" placeholder="First name" value="Maya">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-menu-user.svg" alt=""></span>
                                                    <input type="text" placeholder="Job title" value="Rosselini">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/baig-form.svg" alt=""></span>
                                                    <input type="text" placeholder="Job title" value="Product Manager">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/location-form.svg" alt=""></span>
                                                    <input type="text" placeholder="Location">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-field">
                                                    <textarea placeholder="About you / Short bio..."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="edit-element-title mb-20">
                                                    <h6 class="font-weight-500">
                                                        Professional Info
                                                        <span class="d-block pt-5 font-12">This can help you to win some opportunities</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="select-field">
                                                    <select>
                                                        <option value="Experience">Experience</option>
                                                        <option value="0-2 years">0-2 years</option>
                                                        <option value="2-5 years">2-5 years</option>
                                                        <option value="5-10 years">5-10 years</option>
                                                        <option value="10+ years">10+ years</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="select-field">
                                                    <select>
                                                        <option value="Experience">Is this your first job?</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="select-field">
                                                    <select>
                                                        <option value="Experience">Are you flexible?</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="select-field">
                                                    <select>
                                                        <option value="Experience">Do you work remotely?</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="edit-element-title mb-20">
                                                    <h6 class="font-weight-500">
                                                        Social Profiles
                                                        <span class="d-block pt-5 font-12">This can help others finding you on social media</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-facebook.svg" alt=""></span>
                                                    <input type="text" placeholder="Facebook URL">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-twitter.svg" alt=""></span>
                                                    <input type="text" placeholder="Twitter URL">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-dribbel.svg" alt=""></span>
                                                    <input type="text" placeholder="Dribbel URL">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-instagram.svg" alt=""></span>
                                                    <input type="text" placeholder="Instagram URL">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-github.svg" alt=""></span>
                                                    <input type="text" placeholder="Github URL">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="input-field">
                                                    <span class="icon-box"><img src="/assets/default/svgs/edit-gitlab.svg" alt=""></span>
                                                    <input type="text" placeholder="Gitlab URL">
                                                </div>
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
        <div class="col-12 col-lg-12">
            <div class="profile-image-holder p-25 mb-10">
                <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <label class="input-label font-15">{{ trans('auth.profile_image') }}</label>
                            </div>
                            <div class="col-12 col-lg-8">
                                <img src="{{ (!empty($user)) ? $user->getAvatar(150) : '' }}" alt="" id="profileImagePreview" width="150" height="150" class="mb-15 d-block">
                                <button id="selectAvatarBtn" type="button" class="btn btn-sm btn-secondary profile-image-btn">
                                    <i data-feather="arrow-up" width="18" height="18" class="text-white mr-10"></i>
                                    Update Profile Picture
                                </button>

                                <div class="input-group">
                                    <input type="hidden" name="profile_image" id="profile_image" class="form-control @error('profile_image')  is-invalid @enderror"/>
                                    @error('profile_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <label class="input-label font-15">Display Name</label>
                            </div>
                            <div class="col-12 col-lg-8">
                                <input type="text" name="display_name" value="{{ (!empty($user) and empty($new_user)) ? $user->display_name : old('display_name') }}" class="form-control @error('display_name')  is-invalid @enderror" placeholder=""/>
                                @error('display_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <label class="input-label font-15">Your Preference</label>
                            </div>
                            <div class="col-12 col-lg-8">
                                <select class="form-control" name="user_preference">
                                    <option value="male" {{ (!empty($user) && $user->user_preference == 'male') ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ (!empty($user) && $user->user_preference == 'female') ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('display_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-30 mt-30">
                        <label class="input-label">Gold Member:</label>

                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="gold_member" value="1" {{ (!empty($user->gold_member) and $user->gold_member == 1) ? 'checked="checked"' : ''}} id="gold" class="custom-control-input">
                                <label class="custom-control-label font-14 cursor-pointer" for="gold">Yes</label>
                            </div>

                            <div class="custom-control custom-radio ml-15">
                                <input type="radio" name="gold_member" value="0" id="notgold" {{ (empty($user->gold_member) || $user->gold_member != 1) ? 'checked="checked"' : ''}} class="custom-control-input">
                                <label class="custom-control-label font-14 cursor-pointer" for="notgold">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group rurera-hide">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <label class="input-label font-15">Secret Word</label>
                            </div>
                            <div class="col-12 col-lg-8">
                                <input type="password" name="secret_word" value="{{ old('secret_word') }}" class="form-control @error('secret_word')  is-invalid @enderror" placeholder=""/>
                                @error('secret_word')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group rurera-hide">
                        <div class="row">
                            <div class="col-12 col-lg-4"></div>
                            <div class="col-12 col-lg-8">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <a class="btn btn-primary d-block mt-15 regenerate-emoji" href="javascript:;">Generate Emoji</a>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <a class="btn btn-primary d-block mt-15 regenerate-pin" href="javascript:;">Generate Pin</a>
                                    </div>
                                </div>
                            </div>
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