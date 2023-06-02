<div data-action="{{ getAdminPanelUrl() }}/quizzes/{{ !empty($quiz) ? $quiz->id .'/update' : 'store' }}" class="js-content-form quiz-form webinar-form">
    {{ csrf_field() }}
    <section>

        <div class="row">
            <div class="col-12 col-md-4">


                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <h2 class="section-title">{{ !empty($quiz) ? (trans('public.edit').' ('. $quiz->title .')') : trans('quiz.new_quiz') }}</h2>

                        @if(!empty($creator))
                            <p>{{ trans('admin/main.instructor') }}: {{ $creator->full_name }}</p>
                        @endif
                    </div>
                </div>

                @if(!empty(getGeneralSettings('content_translate')))
                    <div class="form-group">
                        <label class="input-label">{{ trans('auth.language') }}</label>
                        <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][locale]" class="form-control {{ !empty($quiz) ? 'js-edit-content-locale' : '' }}">
                            @foreach($userLanguages as $lang => $language)
                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                @else
                    <input type="hidden" name="[{{ !empty($quiz) ? $quiz->id : 'new' }}][locale]" value="{{ getDefaultLocale() }}">
                @endif

                @if(empty($selectedWebinar))
                    @if(!empty($webinars) and count($webinars))
                        <div class="form-group mt-3">
                            <label class="input-label">{{ trans('panel.webinar') }}</label>
                            <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][webinar_id]" class="js-ajax-webinar_id custom-select">
                                <option {{ !empty($quiz) ? 'disabled' : 'selected disabled' }} value="">{{ trans('panel.choose_webinar') }}</option>
                                @foreach($webinars as $webinar)
                                    <option value="{{ $webinar->id }}" {{  (!empty($quiz) and $quiz->webinar_id == $webinar->id) ? 'selected' : '' }}>{{ $webinar->title }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    @else
                        <div class="form-group">
                            <label class="input-label d-block">{{ trans('admin/main.webinar') }}</label>
                            <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][webinar_id]" class="js-ajax-webinar_id form-control search-webinar-select2" data-placeholder="{{ trans('admin/main.search_webinar') }}">

                            </select>

                            <div class="invalid-feedback"></div>
                        </div>
                    @endif
                @else
                    <input type="hidden" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][webinar_id]" value="{{ $selectedWebinar->id }}">
                @endif


                <input type="hidden" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][chapter_id]" value="{{ !empty($quiz) ? $quiz->chapter_id : '' }}" class="chapter-input">



                <div class="form-group mt-15 ">
                    <label class="input-label d-block">Sub Chapter</label>
                    <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][sub_chapter_id]" class="form-control search-sub_chapter-select2" data-placeholder="Select Sub Chapter">
                        @if(!empty($quiz) && $quiz->sub_chapter_id > 0)
                        <option value="{{ $quiz->sub_chapter_id }}" selected>{{ getSubChapterTitle($quiz->sub_chapter_id) }}</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label class="input-label">{{ trans('quiz.quiz_title') }}</label>
                    <input type="text" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][title]" value="{{ !empty($quiz) ? $quiz->title : old('title') }}"  class="js-ajax-title form-control " placeholder=""/>
                    <div class="invalid-feedback"></div>
                </div>


                <div class="form-group mt-15 ">
                    <label class="input-label d-block">Quiz Type</label>
                    <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_type]" class="form-control search-quiz-select2" data-placeholder="Select Quiz Type">
                        <option value="practice" {{  (!empty($quiz) and $quiz->quiz_type == 'practice') ? 'selected' : '' }}>Practice</option>
                        <option value="assessment" {{  (!empty($quiz) and $quiz->quiz_type == 'assessment') ? 'selected' : '' }}>Assessment</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label class="input-label">Mastery Points</label>
                            <input type="number" value="{{ !empty($quiz) ? $quiz->mastery_points : old('mastery_points') }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][mastery_points]" class="form-control @error('mastery_points')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                </div>

                @php
                $quiz_settings = array();
                if( isset( $quiz->quiz_settings ) ){
                $quiz_settings  = $quiz->quiz_settings;
                $quiz_settings    = json_decode($quiz_settings);
                $quiz_settings	= (array)$quiz_settings;
                }
                @endphp

                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Below</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Below']->questions : '6' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Below]" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Points %</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Below']->points_percentage : '25' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Below_points]" class="form-control" placeholder=""/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Emerging</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Emerging']->questions : '15' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Emerging]" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Points %</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Emerging']->points_percentage : '20' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Emerging_points]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Expected</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Expected']->questions : '20' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Expected]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Points %</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Expected']->points_percentage : '30' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Expected_points]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Exceeding</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Exceeding']->questions : '15' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Exceeding]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Points %</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Exceeding']->points_percentage : '15' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Exceeding_points]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Challenge</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Challenge']->questions : '10' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Challenge]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Points %</label>
                            <input type="number" value="{{ !empty($quiz_settings) ? $quiz_settings['Challenge']->points_percentage : '10' }}" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Challenge_points]" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                        </div>
                    </div>
                </div>





            </div>
        </div>
    </section>

    @if(!empty($quiz))
        <section class="mt-5">
            <div class="d-flex justify-content-between align-items-center pb-20">
                <h2 class="section-title after-line">{{ trans('public.questions') }}</h2>
                <button id="add_multiple_question" data-quiz-id="{{ $quiz->id }}" type="button" class="btn btn-primary btn-sm ml-2 mt-3">{{ trans('quiz.add_multiple_choice') }}</button>
                <button id="add_descriptive_question" data-quiz-id="{{ $quiz->id }}" type="button" class="btn btn-primary btn-sm ml-2 mt-3">{{ trans('quiz.add_descriptive') }}</button>
            </div>
            @if($quizQuestions)
                <ul class="draggable-questions-lists draggable-questions-lists-{{ $quiz->id }}" data-drag-class="draggable-questions-lists-{{ $quiz->id }}" data-order-table="quizzes_questions" data-quiz="{{ $quiz->id }}">
                    @foreach($quizQuestions as $question)
                        <li data-id="{{ $question->id }}" class="quiz-question-card d-flex align-items-center mt-4">
                            <div class="flex-grow-1">
                                <h4 class="question-title">{{ $question->title }}</h4>
                                <div class="font-12 mt-3 question-infos">
                                    <span>{{ $question->type === App\Models\QuizzesQuestion::$multiple ? trans('quiz.multiple_choice') : trans('quiz.descriptive') }} | {{ trans('quiz.grade') }}: {{ $question->grade }}</span>
                                </div>
                            </div>

                            <i data-feather="move" class="move-icon mr-10 cursor-pointer" height="20"></i>

                            <div class="btn-group dropdown table-actions">
                                <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu text-left">
                                    <button type="button" data-question-id="{{ $question->id }}" class="edit_question btn btn-sm btn-transparent">{{ trans('public.edit') }}</button>
                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/quizzes-questions/'. $question->id .'/delete'), 'btnClass' => 'btn-sm btn-transparent' , 'btnText' => trans('public.delete')])
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    @endif

    <input type="hidden" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][is_webinar_page]" value="@if(!empty($inWebinarPage) and $inWebinarPage) 1 @else 0 @endif">

    <div class="mt-20 mb-20">
        <button type="button" class="js-submit-quiz-form btn btn-sm btn-primary">{{ !empty($quiz) ? trans('public.save_change') : trans('public.create') }}</button>

        @if(empty($quiz) and !empty($inWebinarPage))
            <button type="button" class="btn btn-sm btn-danger ml-10 cancel-accordion">{{ trans('public.close') }}</button>
        @endif
    </div>
</div>

@if(!empty($quiz))
    @include('admin.quizzes.modals.multiple_question')
    @include('admin.quizzes.modals.descriptive_question')
@endif
