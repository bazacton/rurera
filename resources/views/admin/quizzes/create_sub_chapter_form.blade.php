<div data-action="{{ !empty($subChapter) ? '/admin/webinars/'. $subChapter->id .'/update_sub_chapter' : '/admin/webinars/store_sub_chapter' }}" class="js-content-form quiz-form webinar-form">
    {{ csrf_field() }}
    <section>

        <div class="row">
            <div class="col-12 col-md-12">


                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <h2 class="section-title">{{ !empty($subChapter) ? (trans('public.edit').' ('. $subChapter->sub_chapter_title .')') : trans('quiz.sub_section') }}</h2>
                        <p>{{ trans('admin/main.instructor') }}: {{ $creator->full_name }}</p>
                    </div>
                </div>

                @if(!empty(getGeneralSettings('content_translate')))
                    <div class="form-group">
                        <label class="input-label">{{ trans('auth.language') }}</label>
                        <select name="ajax[locale]" class="form-control {{ !empty($subChapter) ? 'js-edit-content-locale' : '' }}">
                            @foreach($userLanguages as $lang => $language)
                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                            @endforeach
                        </select>
                        @error('locale')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @else
                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                @endif

                @if(empty($selectedWebinar))
                    <div class="form-group mt-3">
                        <label class="input-label">{{ trans('panel.webinar') }}</label>
                        <select name="ajax[webinar_id]" class="custom-select">
                            <option {{ !empty($subChapter) ? 'disabled' : 'selected disabled' }} value="">{{ trans('panel.choose_webinar') }}</option>
                            @foreach($webinars as $webinar)
                                <option value="{{ $webinar->id }}" {{  (!empty($subChapter) and $subChapter->webinar_id == $webinar->id) ? 'selected' : '' }}>{{ $webinar->title }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="ajax[webinar_id]" value="{{ $selectedWebinar->id }}">
                @endif

                <input type="hidden" name="ajax[chapter_id]" value="{{ !empty($chapter) ? $chapter->id :'' }}" class="chapter-input">
                <input type="hidden" name="ajax[quiz_type]" value="auto_builder">

                <div class="form-group">
                    <label class="input-label">Sub Chapter Title</label>
                    <input type="text" value="{{ !empty($subChapter) ? $subChapter->sub_chapter_title : old('title') }}" name="ajax[title]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
				@php
				$chapter_settings = array();
				if( isset( $subChapter->chapter_settings ) ){
					$chapter_settings  = $subChapter->chapter_settings;
					$chapter_settings    = json_decode($chapter_settings);
					$chapter_settings	= (array)$chapter_settings;
				}
				@endphp

            </div>
        </div>
    </section>
   

    <input type="hidden" name="ajax[is_webinar_page]" value="@if(!empty($inWebinarPage) and $inWebinarPage) 1 @else 0 @endif">

    <div class="mt-20 mb-20">
        <button type="button" class="js-submit-quiz-form btn btn-sm btn-primary">{{ !empty($subChapter) ? trans('public.save_change') : trans('public.create') }}</button>

        @if(empty($subChapter) and !empty($inWebinarPage))
            <button type="button" class="btn btn-sm btn-danger ml-10 cancel-accordion">{{ trans('public.close') }}</button>
        @endif
    </div>
</div>

@if(!empty($subChapter))
    @include('admin.quizzes.modals.multiple_question')
    @include('admin.quizzes.modals.descriptive_question')
@endif
