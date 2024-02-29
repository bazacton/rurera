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
    var start_id = '{{$user->user_preference}}';
    start_id = (start_id == 'female')? 'girls' : 'boys';
    $("#svga-start-"+start_id).click();


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

    $(document).on('click', '.profile-image-btn', function (e) {
        $("#profile-image-modal").modal('show');
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