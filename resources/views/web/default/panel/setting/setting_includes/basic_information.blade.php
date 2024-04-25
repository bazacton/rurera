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

    <div class="row mt-20">


        <div class="col-12">
            <div class="user-detail mb-50">
                <div class="detail-header mb-25 pb-25">
                    <div class="info-media d-flex align-items-center flex-wrap">
                        <span class="media-box">
                            <img src="/avatar/svgA04347573086307288.png" alt="">
                        </span>
                        <h2 class="info-title font-weight-500">
                            Kendra Wilsoz
                            <span class="d-block font-weight-normal font-14">kendraw@gmail.com</span>
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
                                                <strong class="d-block font-weight-500">Kendra Wilson</strong>
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
                                                Preferred name
                                                <strong class="d-block font-weight-500">Kendra Wilson</strong>
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
                                                Email address
                                                <strong class="d-block font-weight-500">kendraw@gmail.com</strong>
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
                                                Phone number
                                                <strong class="d-block font-weight-500">+1 (612) 429-3263</strong>
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
                                                <strong class="d-block font-weight-500">Female</strong>
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
                                                Family status
                                                <strong class="d-block font-weight-500">Married</strong>
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
                                <h3 class="font-18 font-weight-500 mb-5">Mailing address</h3>
                                <span class="font-14">We'll send physical cards as well as gifts and special offers to this address</span>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-15 font-weight-500 pb-15">Acme LLC</h4>
                                <ul>
                                    <li>
                                        <address class="mb-10">
                                            <span class="d-block info-list-label font-14 mb-5">28, Railroad Highway</span>
                                            <span class="d-block info-list-label font-14 mb-5">Parkston road, Block 2, Suite G23</span>
                                            <span class="d-block info-list-label font-14 mb-5">Los Angeles, CA 92841</span>
                                            <span class="d-block info-list-label font-14 mb-5">United States</span>
                                        </address>
                                        <a href="#" class="edtit-btn d-inline-flex align-items-center font-weight-500 font-15">Edit address <span class="font-16">&#8594;</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-50">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="info-text">
                                <h3 class="font-18 font-weight-500 mb-5">Legal address</h3>
                                <span class="font-14">This is the billing address for your cards and will appear on your documents</span>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="edit-info-list">
                                <h4 class="font-15 font-weight-500 pb-15">Acme LLC</h4>
                                <ul>
                                    <li>
                                        <address class="mb-10">
                                            <span class="d-block info-list-label font-14 mb-5">28, Railroad Highway</span>
                                            <span class="d-block info-list-label font-14 mb-5">Parkston road, Block 2, Suite G23</span>
                                            <span class="d-block info-list-label font-14 mb-5">Los Angeles, CA 92841</span>
                                            <span class="d-block info-list-label font-14 mb-5">United States</span>
                                        </address>
                                        <a href="#" class="edtit-btn d-inline-flex align-items-center font-weight-500 font-15">Edit address <span class="font-16">&#8594;</span></a>
                                    </li>
                                </ul>
                            </div>
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