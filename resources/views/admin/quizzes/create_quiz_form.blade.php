<style>
    .hide-class {
        display: none;
    }

    .questions-list ul li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .questions-list ul li a.parent-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }

    .questions-block ul li {
        background: #efefef;
        margin: 5px 5px;
    }

    .question-select {
        background: #617fe9;
        color: #fff;
    }
</style>

<div data-action="{{ getAdminPanelUrl() }}/quizzes/{{ !empty($quiz) ? $quiz->id .'/update' : 'store' }}"
     class="js-content-form quiz-form webinar-form">
    {{ csrf_field() }}
    <section>

        <div class="row">
            <div class="col-12 col-md-4">


                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <h2 class="section-title">{{ !empty($quiz) ? (trans('public.edit').' ('. $quiz->title .')') :
                            trans('quiz.new_quiz') }}</h2>

                        @if(!empty($creator))
                        <p>{{ trans('admin/main.instructor') }}: {{ $creator->full_name }}</p>
                        @endif
                    </div>
                </div>

                @if(!empty(getGeneralSettings('content_translate')))
                <div class="form-group">
                    <label class="input-label">{{ trans('auth.language') }}</label>
                    <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][locale]"
                            class="form-control {{ !empty($quiz) ? 'js-edit-content-locale' : '' }}">
                        @foreach($userLanguages as $lang => $language)
                        <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) ==
                            mb_strtolower($lang)) selected @endif>{{ $language }}
                        </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                @else
                <input type="hidden" name="[{{ !empty($quiz) ? $quiz->id : 'new' }}][locale]"
                       value="{{ getDefaultLocale() }}">
                @endif


                <div class="form-group mt-15 ">
                    <label class="input-label d-block">Quiz Type</label>
                    <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_type]"
                            class="form-control quiz-type" data-placeholder="Select Quiz Type">
                        <option value="practice" {{ (!empty($quiz) and $quiz->quiz_type == 'practice') ? 'selected' : ''
                            }}>Practice
                        </option>
                        <option value="assessment" {{ (!empty($quiz) and $quiz->quiz_type == 'assessment') ? 'selected'
                            : '' }}>Assessment
                        </option>
                        <option value="sats" {{ (!empty($quiz) and $quiz->quiz_type == 'sats') ? 'selected' : ''
                            }}>SATs
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="input-label">Quiz Title</label>
                    <input type="text" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][title]"
                           value="{{ !empty($quiz) ? $quiz->title : old('title') }}" class="js-ajax-title form-control "
                           placeholder=""/>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label class="input-label">Mastery Points</label>
                    <input type="number" value="{{ !empty($quiz) ? $quiz->mastery_points : old('mastery_points') }}"
                           name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][mastery_points]"
                           class="form-control @error('mastery_points')  is-invalid @enderror" placeholder=""/>
                </div>

                @php
                $assessment_hide_class = (!empty($quiz ) && $quiz->quiz_type != 'assessment')? 'hide-class' : '';
                $practice_hide_class = (empty($quiz ) || $quiz->quiz_type == 'practice')? '' : 'hide-class';
                @endphp


                <div class="conditional-fields sats-fields assessment-fields {{$assessment_hide_class}}">
                    <div class="form-group">
                        <label class="input-label">No of Attempts</label>
                        <input type="number" value="{{ !empty($quiz) ? $quiz->attempt : old('attempt') }}"
                               name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][attempt]"
                               class="form-control @error('attempt')  is-invalid @enderror" placeholder=""/>
                    </div>
                    <div class="form-group">
                        <label class="input-label">Total Time</label>
                        <input type="number" value="{{ !empty($quiz) ? $quiz->time : old('time') }}"
                               name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][time]"
                               class="form-control @error('time')  is-invalid @enderror" placeholder=""/>
                    </div>
                </div>
                <div class="conditional-fields assessment-fields {{$assessment_hide_class}}">
                    <div class="form-group">
                        <label class="input-label">Display no of Questions</label>
                        <input type="number"
                               value="{{ !empty($quiz) ? $quiz->display_number_of_questions : old('display_number_of_questions') }}"
                               name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][display_number_of_questions]"
                               class="form-control @error('display_number_of_questions')  is-invalid @enderror"
                               placeholder=""/>
                    </div>
                </div>

                <div class="conditional-fields practice-fields {{$practice_hide_class}}">
                    @php
                    $quiz_settings = array();
                    if( isset( $quiz->quiz_settings ) ){
                    $quiz_settings = $quiz->quiz_settings;
                    $quiz_settings = json_decode($quiz_settings);
                    $quiz_settings = (array)$quiz_settings;
                    }
                    @endphp

                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Below</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Below']->questions : '6' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Below]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Points %</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Below']->points_percentage : '25' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Below_points]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Emerging</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Emerging']->questions : '15' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Emerging]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Points %</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Emerging']->points_percentage : '20' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Emerging_points]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Expected</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Expected']->questions : '20' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Expected]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Points %</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Expected']->points_percentage : '30' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Expected_points]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Exceeding</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Exceeding']->questions : '15' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Exceeding]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Points %</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Exceeding']->points_percentage : '15' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Exceeding_points]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Challenge</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Challenge']->questions : '10' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Challenge]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label class="input-label">Points %</label>
                                <input type="number"
                                       value="{{ !empty($quiz_settings) ? $quiz_settings['Challenge']->points_percentage : '10' }}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Challenge_points]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-15 ">
                    <label class="input-label d-block">Questions</label>

                    <select id="questions_ids" multiple="multiple" data-search-option="questions_ids"
                            class="form-control search-questions-select2" data-placeholder="Search Question"></select>
                </div>

                <div class="questions-block">
                    <ul>
                    </ul>
                </div>


                <div class="questions-list">
                    <ul>

                        @if( !empty( $quiz->quizQuestionsList))
                        @foreach( $quiz->quizQuestionsList as $questionObj)
                        @if( !empty( $questionObj->QuestionData))
                        @foreach( $questionObj->QuestionData as $questionDataObj)
                        <li data-id="{{$questionDataObj->id}}">{{$questionDataObj->getTitleAttribute()}} <input
                                type="hidden" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new'
                                                           }}][question_list_ids][]"
                                value="{{$questionDataObj->id}}">
                            <a href="javascript:;" class="parent-remove"><span class="fas fa-trash"></span></a>
                        </li>
                        @endforeach
                        @endif
                        @endforeach
                        @endif

                    </ul>
                </div>


                <div class="form-group custom-switches-stacked">
                    <label class="custom-switch pl-0">
                        <input type="hidden" name="show_all_questions" value="disable">
                        <input type="checkbox" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][show_all_questions]" id="show_all_questions" value="1" {{
                               (!empty($quiz) and $quiz->show_all_questions == '1') ? 'checked="checked"' : ''
                        }} class="custom-switch-input"/>
                        <span class="custom-switch-indicator"></span>
                        <label class="custom-switch-description mb-0 cursor-pointer"
                               for="show_all_questions">Show All Questions</label>
                    </label>
                </div>


            </div>
        </div>
    </section>


    <input type="hidden" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][is_webinar_page]"
           value="@if(!empty($inWebinarPage) and $inWebinarPage) 1 @else 0 @endif">

    <div class="mt-20 mb-20">
        <button type="button" class="js-submit-quiz-form btn btn-sm btn-primary">{{ !empty($quiz) ?
            trans('public.save_change') : trans('public.create') }}
        </button>

        @if(empty($quiz) and !empty($inWebinarPage))
        <button type="button" class="btn btn-sm btn-danger ml-10 cancel-accordion">{{ trans('public.close') }}</button>
        @endif
    </div>
</div>

@if(!empty($quiz))
@include('admin.quizzes.modals.multiple_question')
@include('admin.quizzes.modals.descriptive_question')
@endif
@push('scripts_bottom')
@php
$quiz_add_edit = !empty($quiz) ? $quiz->id : 'new';
@endphp
<script type="text/javascript">
    $(document).ready(function () {
        handleQuestionsMultiSelect2('search-questions-select2', '/admin/questions_bank/search', ['class', 'course', 'subject', 'title']);

        $(document).on('change', '.quiz-type', function (e) {
            var quiz_type = $(this).val();
            $(".conditional-fields").addClass('hide-class');
            $('.' + quiz_type + "-fields").removeClass('hide-class');
        });

        $(document).on('change', '.search-questions-select2', function (e) {
            var field_value = $(this).val();
            var field_label = $(this).text();
            $(".questions-list ul").append('<li data-id="' + field_value + '">' + field_label + '  <input type="hidden" name="ajax[{{ $quiz_add_edit }}][question_list_ids][]" ' +
                'value="' + field_value + '"><a href="javascript:;"' +
                ' ' +
                'class="parent-remove"><span class="fas ' +
                'fa-trash"></span></a></li>');
            $(".questions-list ul").sortable();
            $(this).html('');
        });


        $(document).on('click', '.questions-block ul li .question-select', function (e) {
            var field_value = $(this).closest('li').attr('data-id');
            var field_label = $(this).closest('li').find('.question-title').html();
            $(".questions-list ul").append('<li data-id="' + field_value + '">' + field_label + '  <input type="hidden" name="ajax[{{ $quiz_add_edit }}][question_list_ids][]" ' +
                'value="' + field_value + '"><a href="javascript:;"' +
                ' ' +
                'class="parent-remove"><span class="fas ' +
                'fa-trash"></span></a></li>');
            $(this).closest('li').remove();
            $(".questions-list ul").sortable();
        });

        $(".questions-list ul").sortable();
    });
</script>
@endpush
