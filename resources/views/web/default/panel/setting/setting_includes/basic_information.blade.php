<section>
    <h2 class="section-title after-line">{{ trans('financial.account') }}</h2>

    <div class="row mt-20">
        <div class="col-12 col-lg-12">
            <div id="svgAvatars"></div>
        </div>

        <div class="col-12 col-lg-4">

           <div class="form-group">
               <label class="input-label">{{ trans('auth.profile_image') }}</label>
               <img src="{{ (!empty($user)) ? $user->getAvatar(150) : '' }}" alt="" id="profileImagePreview" width="150" height="150" class="rounded-circle my-15 d-block ml-5">

               <button id="selectAvatarBtn" type="button" class="btn btn-sm btn-secondary select-image-cropit" data-ref-image="profileImagePreview" data-ref-input="profile_image">
                   <i data-feather="arrow-up" width="18" height="18" class="text-white mr-10"></i>
                   {{ trans('auth.select_image') }}
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

            <div class="form-group">
                <label class="input-label">Display Name</label>
                <input type="text" name="display_name" value="{{ (!empty($user) and empty($new_user)) ? $user->display_name : old('display_name') }}" class="form-control @error('display_name')  is-invalid @enderror" placeholder=""/>
                @error('display_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="input-label">Secret Word</label>
                <input type="password" name="secret_word" value="{{ old('secret_word') }}" class="form-control @error('secret_word')  is-invalid @enderror" placeholder=""/>
                @error('secret_word')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

        </div>
    </div>

</section>


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