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
    .card-header.inner-header{
        padding-left:45px;
    }
    .test_type_conditional_fields .card-body {
        padding-left: 60px;
    }
</style>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@php $subject_id = isset( $quiz->subject_id )? $quiz->subject_id : 0;
$quiz_id = isset( $quiz->id )? $quiz->id : 0;
 @endphp
<div data-action="{{ getAdminPanelUrl() }}/quizzes/{{ !empty($quiz) ? $quiz->id .'/update' : 'store' }}"
     class="js-content-form quiz-form webinar-form">
    {{ csrf_field() }}
    <section>

        <div class="row">
            <div class="col-12 col-md-12">


                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <h2 class="section-title">{{ !empty($quiz) ? (trans('public.edit').' ('. $quiz->title .')') :
                            trans('quiz.new_quiz') }}</h2>

                        @if(!empty($creator))
                        <p>{{ trans('admin/main.instructor') }}: {{ $creator->get_full_name() }}</p>
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
                        <option value="11plus" {{ (!empty($quiz) and $quiz->quiz_type == '11plus') ? 'selected' : ''
                            }}>11 Plus
                        </option>
                        <option value="independent_exams" {{ (!empty($quiz) and $quiz->quiz_type == 'independent_exams') ? 'selected' : ''}}>Independent Exams</option>
                        <option value="iseb" {{ (!empty($quiz) and $quiz->quiz_type == 'iseb') ? 'selected' : ''}}>ISEB</option>
                        <option value="cat4" {{ (!empty($quiz) and $quiz->quiz_type == 'cat4') ? 'selected' : ''}}>CAT 4</option>
                        <option value="challenge" {{ (!empty($quiz) and $quiz->quiz_type == 'challenge') ? 'selected' : ''
                            }}>Challenge
                        </option>
                        <option value="vocabulary" {{ (!empty($quiz) and $quiz->quiz_type == 'vocabulary') ? 'selected' : ''
                            }}>Vocabulary
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
                    <label class="input-label">Quiz Slug</label>
                    <input type="text" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_slug]"
                           value="{{ !empty($quiz) ? $quiz->quiz_slug : old('quiz_slug') }}" class="form-control "
                           placeholder=""/>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="conditional-fields sats-fields 11plus-fields independent_exams-fields iseb-fields cat4-fields">
                    <div class="form-group mt-15 ">
                        <label class="input-label d-block">Type</label>
                        <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][mock_type]"
                                class="form-control mock_type" data-placeholder="Select Type">
                            <option value="mock_practice" {{ (!empty($quiz) and ($quiz->mock_type == 'mock_practice' || $quiz->mock_practice == ''))
                                ? 'selected'
                                : ''
                                }}>Practice
                            </option>
                            <option value="mock_exam" {{ (!empty($quiz) and $quiz->mock_type == 'mock_exam') ?
                                'selected'
                                : '' }}>Mock Exam
                            </option>


                        </select>
                    </div>
                </div>

                <div class="conditional-fields vocabulary-fields">
                    <div class="form-group mt-15 ">
                        <label class="input-label d-block">Treasure</label>
                        <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][treasure_after]"
                                class="form-control" data-placeholder="Select Topic Size">
                            <option value="no_treasure" {{ (!empty($quiz) and $quiz->treasure_after == 'no_treasure') ? 'selected' : ''
                                }}>No Treasure
                            </option>
                            <option value="after_easy" {{ (!empty($quiz) and $quiz->treasure_after == 'after_easy') ? 'selected'
                                : '' }}>After Easy
                            </option>
                            <option value="after_medium" {{ (!empty($quiz) and $quiz->treasure_after == 'after_medium') ? 'selected' : ''
                                }}>After Medium
                            </option>
                            <option value="after_hard" {{ (!empty($quiz) and $quiz->treasure_after == 'after_hard') ? 'selected' : ''
                                }}>After Hard
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="input-label">Treasure Coins</label>
                        <input type="number"
                               value="{{ !empty($quiz) ? $quiz->treasure_coins : old('treasure_coins') }}"
                               name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][treasure_coins]"
                               class="form-control @error('treasure_coins')  is-invalid @enderror"
                               placeholder=""/>
                    </div>
                </div>

                <div class="conditional-fields vocabulary-fields practice-fields sats-fields 11plus-fields independent_exams-fields iseb-fields cat4-fields">

                    <div class="form-group">
                        <label>Year</label>
                        <select data-default_id="{{isset( $quiz->id)? $quiz->year_id : 0}}"
                                class="form-control year_mock_exams_subject_ajax_select year-group-select select2 @error('year_id') is-invalid @enderror"
                                name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][year_id]">
                            <option {{ !empty($trend) ?
                            '' : 'selected' }} disabled>Select Year</option>

                            @foreach($categories as $category)
                            @if(!empty($category->subCategories) and
                            count($category->subCategories))
                            <optgroup label="{{  $category->title }}">
                                @foreach($category->subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @if(!empty($quiz) and $quiz->year_id == $subCategory->id) selected="selected" @endif>
                                    {{$subCategory->title}}
                                </option>
                                @endforeach
                            </optgroup>
                            @else
                            <option value="{{ $category->id }}"
                                    class="font-weight-bold">{{
                                $category->title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('year_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="practice-quiz-ajax-fields populated-data conditional-fields vocabulary-fields practice-fields sats-fields 11plus-fields independent_exams-fields iseb-fields cat4-fields"></div>


                <div class="practice-quiz-topics-list populated-data conditional-fields vocabulary-fields practice-fields sats-fields 11plus-fields independent_exams-fields iseb-fields cat4-fields"></div>

                <div class="mock-exams-quiz-settings populated-data conditional-fields vocabulary-fields practice-fields sats-fields 11plus-fields independent_exams-fields1 iseb-fields cat4-fields"></div>
				
				
				
				<div class="no-of-questions-field rurera-hide">
                    <div class="form-group">
                        <label class="input-label">No of Questions</label>
                        <input type="number" value="{{ !empty($quiz) ? $quiz->no_of_questions : old('no_of_questions') }}"
                               name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][no_of_questions]"
                               class="form-control @error('no_of_questions')  is-invalid @enderror" placeholder=""/>
                    </div>
                </div>


                <div class="conditional-fields vocabulary-fields ">
                    <div class="form-group mt-15 ">
                        <label class="input-label d-block">Vocabulary Category</label>
                        <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_category]"
                                class="form-control" data-placeholder="Select Year Group">
                            <option value="Word Lists" {{ (!empty($quiz) and ($quiz->quiz_category == 'Word Lists' || $quiz->quiz_category == ''))
                                ? 'selected'
                                : ''
                                }}>Word Lists
                            </option>
                            <option value="Spelling Bee" {{ (!empty($quiz) and $quiz->quiz_category == 'Spelling Bee') ?
                                'selected'
                                : '' }}>Spelling Bee
                            </option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="input-label">Quiz Instructions</label>
                    <textarea rows="7" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_instructions]"
                              class="summernote form-control ">{{ !empty($quiz) ? $quiz->quiz_instructions : old('quiz_instructions') }}</textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label class="input-label">Quiz Image</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="input-group-text admin-file-manager" data-input="quiz_image"
                                    data-preview="holder">
                                <i class="fa fa-upload"></i>
                            </button>
                        </div>
                        <input type="text" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_image]"
                               id="quiz_image"
                               value="{{ !empty($quiz) ? $quiz->quiz_image : old('quiz_image') }}"
                               class="form-control @error('quiz_image')  is-invalid @enderror"/>
                        <div class="input-group-append">
                            <button type="button" class="input-group-text admin-file-view" data-input="quiz_image">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        @error('quiz_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="input-label">Quiz PDF</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="input-group-text admin-file-manager"
                                    data-input="quiz_pdf"
                                    data-preview="holder">
                                <i class="fa fa-upload"></i>
                            </button>
                        </div>
                        <input type="text" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_pdf]" id="quiz_pdf"
                               value="{{ !empty($quiz) ? $quiz->quiz_pdf : old('quiz_pdf') }}"
                               class="form-control @error('quiz_pdf')  is-invalid @enderror"/>
                        @error('quiz_pdf')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
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
                $sats_hide_class = (empty($quiz ) || $quiz->quiz_type == 'sats')? '' : 'hide-class';
                $eleven_plus_hide_class = (empty($quiz ) || $quiz->quiz_type == '11plus')? 'hide-class' : '';
                @endphp

                <div class="conditional-fields sats-fields 11plus-fields {{$sats_hide_class}}">
                    <div class="form-group">
                        <label class="input-label">Quiz Sub Title</label>
                        <input type="text" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][sub_title]"
                               value="{{ !empty($quiz) ? $quiz->sub_title : old('sub_title') }}" class="form-control "
                               placeholder=""/>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="conditional-fields 11plus-fields independent_exams-fields iseb-fields cat4-fields {{$eleven_plus_hide_class}}">


                    <div class="form-group mt-15 ">
                        <label class="input-label d-block">Year Group</label>
                        <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][year_group]"
                                class="form-control" data-placeholder="Select Year Group">
                            <option value="All" {{ (!empty($quiz) and ($quiz->year_group == 'All' || $quiz->year_group
                                == '')) ? 'selected'
                                : ''
                                }}>All
                            </option>
                            <option value="Year 3" {{ (!empty($quiz) and $quiz->year_group == 'Year 3') ?
                                'selected'
                                : '' }}>Year 3
                            </option>

                            <option value="Year 4" {{ (!empty($quiz) and $quiz->year_group == 'Year 4') ?
                                'selected'
                                : '' }}>Year 4
                            </option>

                            <option value="Year 5" {{ (!empty($quiz) and $quiz->year_group == 'Year 5') ?
                                'selected'
                                : '' }}>Year 5
                            </option>

                            <option value="Year 6" {{ (!empty($quiz) and $quiz->year_group == 'Year 6') ?
                                'selected'
                                : '' }}>Year 6
                            </option>
                        </select>
                    </div>

                    <div class="form-group mt-15 ">
                        <label class="input-label d-block">Subject</label>
                        <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][subject]"
                                class="form-control" data-placeholder="Select Year Group">
                            <option value="All" {{ (!empty($quiz) and ($quiz->subject == 'All' || $quiz->subject == ''))
                                ? 'selected'
                                : ''
                                }}>All
                            </option>
                            <option value="English" {{ (!empty($quiz) and $quiz->subject == 'English') ?
                                'selected'
                                : '' }}>English
                            </option>
                            <option value="Math" {{ (!empty($quiz) and $quiz->subject == 'Math') ?
                                'selected'
                                : '' }}>Math
                            </option>

                            <option value="Non-Verbal Reasoning" {{ (!empty($quiz) and $quiz->subject == 'Non-Verbal
                                Reasoning') ?
                                'selected'
                                : '' }}>Non-Verbal Reasoning
                            </option>

                            <option value="Verbal Reasoning" {{ (!empty($quiz) and $quiz->subject == 'Verbal Reasoning')
                                ?
                                'selected'
                                : '' }}>Verbal Reasoning
                            </option>

                        </select>
                    </div>

                    <div class="form-group mt-15 ">
                        <label class="input-label d-block">Exam Board</label>
                        <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][examp_board]"
                                class="form-control" data-placeholder="Select Year Group">
                            <option value="All" {{ (!empty($quiz) and ($quiz->examp_board == 'All' || $quiz->examp_board == ''))
                                ? 'selected'
                                : ''
                                }}>All
                            </option>
                            <option value="GL" {{ (!empty($quiz) and $quiz->examp_board == 'GL') ?
                                'selected'
                                : '' }}>GL
                            </option>

                            <option value="CEM" {{ (!empty($quiz) and $quiz->examp_board == 'CEM') ?
                                'selected'
                                : '' }}>CEM
                            </option>

                        </select>
                    </div>

                </div>
				<div class="form-group">
					<label class="input-label">Target Score</label>
					<input type="number" value="{{ !empty($quiz) ? $quiz->target_score : old('target_score') }}"
						   name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][target_score]"
						   class="form-control @error('target_score')  is-invalid @enderror" max="100" placeholder=""/>
				</div>
                <div class="conditional-fields sats-fields 11plus-fields assessment-fields {{$assessment_hide_class}}">
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

                    <div class="form-group mt-15 ">
                            <label class="input-label d-block">Topic Size</label>
                            <select name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][quiz_size]"
                                    class="form-control" data-placeholder="Select Topic Size">
                                <option value="Large" {{ (!empty($quiz) and $quiz->quiz_size == 'Large') ? 'selected' : ''
                                    }}>Large
                                </option>
                                <option value="Medium" {{ (!empty($quiz) and $quiz->quiz_size == 'Medium') ? 'selected'
                                    : '' }}>Medium
                                </option>
                                <option value="Small" {{ (!empty($quiz) and $quiz->quiz_size == 'Small') ? 'selected' : ''
                                    }}>Small
                                </option>
                                <option value="X-Small" {{ (!empty($quiz) and $quiz->quiz_size == 'X-Small') ? 'selected' : ''
                                    }}>X-Small
                                </option>
                            </select>
                        </div>

                    @php
                    $quiz_settings = array();
                    if( isset( $quiz->quiz_settings ) ){
                    $quiz_settings = $quiz->quiz_settings;
                    $quiz_settings = json_decode($quiz_settings);
                    $quiz_settings = (array)$quiz_settings;
                    }
                    @endphp

                    <div class="row">
                        <div class="col-12 col-md-12">
                            <h4>Emerging</h4>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Question Type</label><br>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Total Questions</label><br>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Exam Questions</label>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">Dropdown</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="dropdown">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Emerging']->breakdown->dropdown)? $quiz_settings['Emerging']->breakdown->dropdown : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Emerging][dropdown]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">True / False</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="true_false">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Emerging']->breakdown->true_false)? $quiz_settings['Emerging']->breakdown->true_false : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Emerging][true_false]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">Matching</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="matching">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Emerging']->breakdown->matching)? $quiz_settings['Emerging']->breakdown->matching : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Emerging][matching]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-md-12">
                            <h4>Expected</h4>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Question Type</label><br>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Total Questions</label><br>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Exam Questions</label>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">Sorting</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="sorting">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Expected']->breakdown->sorting)? $quiz_settings['Expected']->breakdown->sorting : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Expected][sorting]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">Single Select</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="single_select">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Expected']->breakdown->single_select)? $quiz_settings['Expected']->breakdown->single_select : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Expected][single_select]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-md-12">
                            <h4>Exceeding</h4>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Question Type</label><br>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Total Questions</label><br>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label class="input-label">Exam Questions</label>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">Text Field</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="text_field">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Exceeding']->breakdown->text_field)? $quiz_settings['Exceeding']->breakdown->text_field : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Exceeding][text_field]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">Multi Select</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="multi_select">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Exceeding']->breakdown->multi_select)? $quiz_settings['Exceeding']->breakdown->multi_select : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Exceeding][multi_select]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>

                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label">Short Answer</h6>

                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <h6 class="input-label total-questions-block" data-question_type="short_answer">20</h6>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <input type="number"
                                       value="{{isset( $quiz_settings['Exceeding']->breakdown->short_answer)? $quiz_settings['Exceeding']->breakdown->short_answer : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][Exceeding][short_answer]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label class="input-label">Incorrect Attempts</label>
                                <input type="number"
                                       value="{{isset( $quiz_settings['Exceeding']->incorrect_attempts)? $quiz_settings['Exceeding']->incorrect_attempts : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][incorrect_attempts]"
                                       class="form-control" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label class="input-label">Excess Time Taken</label>
                                <input type="number"
                                       value="{{isset( $quiz_settings['Exceeding']->excess_time_taken)? $quiz_settings['Exceeding']->excess_time_taken : 0}}"
                                       name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][excess_time_taken]"
                                       class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            </div>
                        </div>
                    </div>
                </div>

                    

                <div class="form-group mt-15 search-questions-block conditional-fields sats-fields 11plus-fields independent_exams-fields iseb-fields cat4-fields">
                    <label class="input-label d-block">Questions</label>

                    <select id="questions_ids" multiple="multiple" data-search-option="questions_ids"
                            class="form-control search-questions-select2" data-placeholder="Search Question"></select>
                </div>

                <div class="questions-block">
                    <ul>
                    </ul>
                </div>


                <div class="questions-list conditional-fields sats-fields 11plus-fields independent_exams-fields iseb-fields cat4-fields">
                    <ul>
                        @if( !empty( $quiz->quizQuestionsList))
                        @foreach( $quiz->quizQuestionsList as $questionObj)
                        @if( !empty( $questionObj->QuestionData))
                        @foreach( $questionObj->QuestionData as $questionDataObj)
                        <li data-id="{{$questionDataObj->id}}" data-question_type="{{$questionDataObj->question_type}}">{{$questionDataObj->getTitleAttribute()}} <input
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
                        <input type="checkbox" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][show_all_questions]"
                               id="show_all_questions" value="1" {{
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
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script src="/assets/vendors/summernote/summernote-table-headers.js"></script>
<script type="text/javascript">
    $(document).ready(function () {


        handleQuestionsMultiSelect2('search-questions-select2', '/admin/questions_bank/search', ['class', 'course', 'subject', 'title']);

		
		$('body').on('change', '.mock_type', function (e) {
			var mock_type = $(this).val();
			$(".search-questions-block").removeClass('rurera-hide');
			if( mock_type == 'mock_practice') {
				$(".search-questions-block").addClass('rurera-hide');
			}
		});
		$(".mock_type:checked").change();
		

        $('body').on('change', '.year_mock_exams_subject_ajax_select', function (e) {
            var year_id = $(this).val();
            var thisObj = $(this);//$(".quiz-ajax-fields");
            var quiz_type = $('.quiz-type').val();
            var mock_type = $('.mock_type').val();
			var subject_id = '{{$subject_id}}';

            $(".practice-quiz-topics-list").html('');
            if( quiz_type == 'sats' || quiz_type == '11plus' || quiz_type == 'independent_exams' || quiz_type == 'iseb' || quiz_type == 'cat4' ) {
                if( mock_type == 'mock_practice') {
                    $(".practice-quiz-ajax-fields").html('');
                    rurera_loader(thisObj, 'button');
                    jQuery.ajax({
                        type: "GET",
                        url: '/admin/common/get_mock_subjects_by_year',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"year_id": year_id},
                        success: function (return_data) {
                            $(".practice-quiz-ajax-fields").html(return_data);
							$('.mock_exams_subject_check[value="'+subject_id+'"]').prop('checked', true).change();
							
                            rurera_remove_loader(thisObj, 'button');
                        }
                    });
                }
            }
        });

        $('body').on('change', '.mock_exams_subject_check', function (e) {
            var subject_id = $(this).val();
            var thisObj = $(this);
			var quiz_id = '{{$quiz_id}}';
            rurera_loader($(".practice-quiz-topics-list"), 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/mock_topics_subtopics_by_subject',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"subject_id": subject_id, "chapter_type": 'Mock Exams', "quiz_id": quiz_id},
                success: function (return_data) {
                    rurera_remove_loader($(".practice-quiz-topics-list"), 'button');
                    $(".practice-quiz-topics-list").html(return_data);
                }
            });
        });

        $('body').on('click', '.year_mock_exams_subject_ajax_select', function (e) {
            var thisObj = $('.populated-content-area');
            var year_id = $(this).attr('data-year_id');
            $(".year_id_field").val(year_id);
            rurera_loader(thisObj, 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/subjects_by_year',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"year_id": year_id},
                success: function (return_data) {
                    $(".populated-data").addClass('rurera-hide');
                    rurera_remove_loader(thisObj, 'button');
                    if (return_data != '') {
                        $(".populated-content-area").append(return_data);
                        subjects_callback();
                    }
                }
            });
        });

        var subjects_callback = function () {
            $('body').on('change', '.subject_ajax_select', function (e) {
                var thisObj = $('.populated-content-area');
                var subject_id = $(this).val();
                $(".subject_id_field").val(subject_id);
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/topics_subtopics_by_subject',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subject_id": subject_id},
                    success: function (return_data) {
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        if (return_data != '') {
                            //$(".populated-content-area").append(return_data);
                            $(".topics-subtopics-content-area").append(return_data);
                            $("#questions-tab").click();
                            //questions_callback();
                        }
                    }
                });
            });
        }
        subjects_callback();
		
		$(".year_mock_exams_subject_ajax_select").change();



        $('body').on('change', '.topic-section-parent', function (e) {
            let $this = $(this);
            let parent = $this.parent().closest('.section-box');
            let isChecked = e.target.checked;

            if (isChecked) {
                parent.find('input[type="checkbox"].topic-section-parent-child').prop('checked', true);
                parent.find('input[type="checkbox"].section-child').prop('checked', true);
                parent.find('.inner-header').addClass('rurera-hide');
            } else {
                parent.find('input[type="checkbox"].topic-section-parent-child').prop('checked', false);
                parent.find('input[type="checkbox"].section-child').prop('checked', false);
                parent.find('.inner-header').removeClass('rurera-hide');
            }

            $(".topics_multi_selection").change();
            $(".topic-section-parent-child").change();
        });
        $('body').on('change', '.topic-section-parent-child', function (e) {
            let $this = $(this);
            let parent = $this.parent().closest('.section-box');
            let isChecked = e.target.checked;

            if (isChecked) {
                parent.find('input[type="checkbox"].section-child').prop('checked', true);
                parent.find('.card-body').addClass('rurera-hide');

            } else {
                parent.find('input[type="checkbox"].section-child').prop('checked', false);
                parent.find('.card-body').removeClass('rurera-hide');
            }

            $(".topics_multi_selection").change();
        });


        $(document).on('change', '.topics_multi_selection', function (e) {

            var return_response = '<div class="row">\n\
                                    <div class="col-4 col-md-4">\n\
                                        <div class="form-group">\n\
                                            <label class="input-label">Chapter</label><br>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-4 col-md-4">\n\
                                        <div class="form-group">\n\
                                            <label class="input-label">Total Questions</label><br>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-4 col-md-4">\n\
                                        <div class="form-group">\n\
                                            <label class="input-label">Exam Questions</label>\n\
                                        </div>\n\
                                    </div>';
            $(".topics_multi_selection:checked").each(function( e ) {
                var sub_chapter_id = $(this).val();
                var sub_chapter_title = $(this).attr('data-title');
                var total_questions = $(this).attr('data-total_questions');

                return_response += '<div class="col-4 col-md-4">\n\
                                            <div class="form-group">\n\
                                                <h6 class="input-label">'+sub_chapter_title+'</h6>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-4 col-md-4">\n\
                                            <div class="form-group">\n\
                                                <h6 class="input-label total-questions-block" data-question_type="dropdown">'+total_questions+'</h6>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-4 col-md-4">\n\
                                            <div class="form-group">\n\
                                                <input type="number" value="0" max="'+total_questions+'" name="ajax[{{ $quiz_add_edit }}][mock_exam_settings]['+sub_chapter_id+']" class="form-control" placeholder="">\n\
                                            </div>\n\
                                        </div>';

            });
            return_response += '</div>';
            $(".mock-exams-quiz-settings").html(return_response);
        });
		
		
		
		$(document).on('change', '.pick_auto_switch', function (e) {
			let isChecked = e.target.checked;
			if(isChecked){
				$(".mock-exams-quiz-settings").addClass('rurera-hide');
				$(".no-of-questions-field").removeClass('rurera-hide');
			}else{
				$(".mock-exams-quiz-settings").removeClass('rurera-hide');
				$(".no-of-questions-field").addClass('rurera-hide');
			}
        });


        $(document).on('change', '.quiz-type', function (e) {
            var quiz_type = $(this).val();
            $(".conditional-fields").addClass('hide-class');
            $('.' + quiz_type + "-fields").removeClass('hide-class');
        });
        $(document).on('change', '.test_type_field', function (e) {
           var test_type = $(this).val();
           $(".test_type_conditional_fields").addClass('hide-class');
           $('.test_type_conditional_fields.' + test_type + "-fields").removeClass('hide-class');
       });


        $(".quiz-type").change();
        $(".test_type_field").change();

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
            var question_type = $(this).closest('li').attr('data-question_type');
            var field_label = $(this).closest('li').find('.question-title').html();
            $(".questions-list ul").append('<li data-id="' + field_value + '" data-question_type="' + question_type + '">' + field_label + '  <input type="hidden" name="ajax[{{ $quiz_add_edit }}][question_list_ids][]" ' +
                'value="' + field_value + '"><a href="javascript:;"' +
                ' ' +
                'class="parent-remove"><span class="fas ' +
                'fa-trash"></span></a></li>');
            $(this).closest('li').remove();
            $(".questions-list ul").sortable();
            update_total_questions();
        });

        $(".questions-list ul").sortable();
        update_total_questions();

        function update_total_questions() {
            var dropdown_count = $('.questions-list ul li[data-question_type="dropdown"]').length
            var true_false_count = $('.questions-list ul li[data-question_type="true_false"]').length
            var matching_count = $('.questions-list ul li[data-question_type="matching"]').length

            var sorting_count = $('.questions-list ul li[data-question_type="sorting"]').length
            var single_select_count = $('.questions-list ul li[data-question_type="single_select"]').length

            var text_field_count = $('.questions-list ul li[data-question_type="text_field"]').length
            var multi_select_count = $('.questions-list ul li[data-question_type="multi_select"]').length
            var short_answer_count = $('.questions-list ul li[data-question_type="short_answer"]').length

            $('.total-questions-block[data-question_type="dropdown"]').html(dropdown_count);
            $('.total-questions-block[data-question_type="true_false"]').html(true_false_count);
            $('.total-questions-block[data-question_type="matching"]').html(matching_count);

            $('.total-questions-block[data-question_type="sorting"]').html(sorting_count);
            $('.total-questions-block[data-question_type="single_select"]').html(single_select_count);

            $('.total-questions-block[data-question_type="text_field"]').html(text_field_count);
            $('.total-questions-block[data-question_type="multi_select"]').html(multi_select_count);
            $('.total-questions-block[data-question_type="short_answer"]').html(short_answer_count);

        }
    });
</script>
@endpush
