<div id="chapterModalHtml" class="d-none">
    <div class="custom-modal-body">
        <h2 class="section-title after-line">{{ trans('public.new_chapter') }}</h2>

        <div class="js-content-form chapter-form mt-20" data-action="{{ getAdminPanelUrl() }}/chapters/store">

            <input type="hidden" name="ajax[chapter][webinar_id]" class="js-chapter-webinar-id" value="">
            {{--<input type="hidden" name="ajax[chapter][type]" class="js-chapter-type" value="">--}}

            @if(!empty(getGeneralSettings('content_translate')))

                <div class="form-group">
                    <label class="input-label">{{ trans('auth.language') }}</label>
                    <select name="ajax[chapter][locale]"
                            class="form-control js-chapter-locale"
                            data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}"
                            data-id=""
                            data-relation="chapters"
                            data-fields="title"
                    >
                        @foreach($userLanguages as $lang => $language)
                            <option value="{{ $lang }}">{{ $language }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="ajax[chapter][locale]" value="{{ $defaultLocale }}">
            @endif


            <div class="form-group">
                <label class="input-label">{{ trans('public.chapter_title') }}</label>
                <input type="text" name="ajax[chapter][title]" class="form-control js-ajax-title" value=""/>
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
               <label class="input-label">Challenge Slug</label>
               <input type="text" name="ajax[chapter][chapter_slug]" class="form-control js-ajax-chapter_slug" value=""/>
               <span class="invalid-feedback"></span>
           </div>

            <div class="form-group">
               <label class="input-label">Challenge Title</label>
               <input type="text" name="ajax[chapter][challenge_title]" class="form-control js-ajax-challenge_title" value=""/>
               <span class="invalid-feedback"></span>
           </div>

            <div class="form-group">
               <label class="input-label">Challenge Quiz</label>

                <select name="ajax[chapter][challenge_quiz][]"
                        multiple="multiple"
                        data-search-option="name"
                        class="form-control search-quiz-field-select2 js-ajax-challenge_quiz"
                        data-placeholder="Search Quiz">
                </select>

               <span class="invalid-feedback"></span>
           </div>


            <div class="form-group">
                <label class="input-label">Challenge Image</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="input-group-text admin-file-manager" data-input="challenge_image_record"
                                data-preview="holder">
                            <i class="fa fa-upload"></i>
                        </button>
                    </div>
                    <input type="text" name="ajax[chapter][challenge_image]"
                           id="challenge_image_record"
                           class="form-control js-ajax-challenge_image"/>
                    <div class="input-group-append">
                        <button type="button" class="input-group-text admin-file-view" data-input="challenge_image_record">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Challenge Background Color</label>
                <div class="input-group colorpickerinput">
                    <input type="text" name="ajax[chapter][challenge_background_color]" class="form-control js-ajax-challenge_background_color">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-fill-drip"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Challenge border Color</label>
                <div class="input-group colorpickerinput">
                    <input type="text" name="ajax[chapter][challenge_border_color]" class="form-control js-ajax-challenge_border_color">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-fill-drip"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-2 d-flex align-items-center justify-content-between js-switch-parent">
                <label class="js-switch cursor-pointer" for="chapterStatus_record">{{ trans('public.active') }}</label>

                <div class="custom-control custom-switch">
                    <input id="chapterStatus_record" type="checkbox" checked name="ajax[chapter][status]" class="custom-control-input js-chapter-status-switch">
                    <label class="custom-control-label" for="chapterStatus_record"></label>
                </div>
            </div>

            @if(getFeaturesSettings('sequence_content_status'))
                <div class="form-group mt-2 d-flex align-items-center justify-content-between js-switch-parent">
                    <label class="js-switch cursor-pointer" for="checkAllContentsPassSwitch_record">{{ trans('update.check_all_contents_pass') }}</label>

                    <div class="custom-control custom-switch">
                        <input id="checkAllContentsPassSwitch_record" type="checkbox" name="ajax[chapter][check_all_contents_pass]" class="custom-control-input js-chapter-check-all-contents-pass">
                        <label class="custom-control-label" for="checkAllContentsPassSwitch_record"></label>
                    </div>
                </div>
            @endif

            <div class="d-flex align-items-center justify-content-end mt-3">
                <button type="button" class="save-chapter btn btn-sm btn-primary">{{ trans('public.save') }}</button>
                <button type="button" class="close-swl btn btn-sm btn-danger ml-2">{{ trans('public.close') }}</button>
            </div>

        </div>
    </div>
</div>
