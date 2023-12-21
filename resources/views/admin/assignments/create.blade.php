@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<style>
    .year-group-select, .subject-group-select, .subchapter-group-select li {
        cursor: pointer;
    }


    .questions-list li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .questions-list li a.parent-li-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }

    .question-area {
        border-bottom: 2px solid #efefef;
        margin-bottom: 30px;
    }


    /**********************************************
    Questions Select, Questions Block style Start
    **********************************************/
    .questions-select-option ul {
        overflow: hidden;
    }

    .questions-select-option li {
        position: relative;
        flex: 1 1 0px;
    }

    .questions-select-option label {
        background-color: #e8e8e8;
        padding: 6px 20px;
        margin: 0;
        border-right: 1px solid rgba(0, 0, 0, 0.1);
        width: 100%;
        text-align: center;
        height: 100%;
        cursor: pointer;
        min-height: 55px;
    }

    .questions-select-option input,
    .questions-select-number input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .questions-select-option li:first-child label {
        border-radius: 5px 0 0 5px;
    }

    .questions-select-option li:last-child label {
        border-radius: 0 5px 5px 0;
    }

    .questions-select-option input:checked ~ label {
        background-color: var(--primary);
        color: #fff;
    }

    .questions-select-option label strong {
        font-weight: 500;
        font-size: 15px;
    }

    .questions-select-option label span {
        font-size: 14px;
    }

    .questions-select-number li {
        flex-basis: 33%;
        padding: 0 0 10px 10px;
    }

    .questions-select-number label {
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.1);
        width: 100%;
        text-align: center;
        margin: 0;
        border-radius: 5px;
        min-height: 70px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
    }

    .questions-select-number label.disabled {
        background-color: inherit;
    }

    .questions-select-number label.selectable {
        background-color: #fff;
    }

    .questions-select-number input:checked ~ label {
        background-color: var(--primary);
        color: #fff;
    }

    .questions-select-number ul {
        margin: 0 0 0 -10px;
        flex-wrap: wrap;
    }

    .questions-submit-btn {
        background-color: var(--primary);
        display: block;
        width: 92%;
        color: #fff;
        font-size: 24px;
        font-weight: 700;
        border-radius: 0;
        position: relative;
        z-index: 0;
        margin: 0 auto;
        height: 55px;
    }

    .questions-submit-btn:hover {
        color: #fff;
    }

    .questions-submit-btn:before,
    .questions-submit-btn:after {
        content: "";
        position: absolute;
        display: block;
        width: 100%;
        height: 105%;
        top: -1px;
        left: -1px;
        z-index: -1;
        pointer-events: none;
        background: var(--primary);
        transform-origin: top left;
        -ms-transform: skew(-30deg, 0deg);
        -webkit-transform: skew(-30deg, 0deg);
        transform: skew(-30deg, 0deg);
    }

    .questions-submit-btn:after {
        left: auto;
        right: -1px;
        transform-origin: top right;
        -ms-transform: skew(30deg, 0deg);
        -webkit-transform: skew(30deg, 0deg);
        transform: skew(30deg, 0deg);
    }
</style>
@endpush


@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new') }} Timestables Assignment</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/assignments">Assignment</a>
            </div>
            <div class="breadcrumb-item">{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new')
                }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="/admin/assignments/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}"
                                  method="Post">
                                {{ csrf_field() }}

                                <div class="row col-lg-12 col-md-12 col-sm-4 col-12">
                                    <div class="populated-content-area col-lg-12 col-md-12 col-sm-12 col-12">


                                        @if( !empty($categories ))

                                        <div class="years-group populated-data">
                                            <div class="form-group">
                                                <label class="input-label">Assignment Type</label>
                                                <div class="input-group">

                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="practice" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                 <img src="/assets/default/img/assignment-logo/practice.png">
                                                                    <h3>Practice</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="sats">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/sats.png">
                                                                    <h3>SATs</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="11plus">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/11plus.png">
                                                                    <h3>11 Plus</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="independent_exams">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/independent-exams.png">
                                                                    <h3>Independent Exams</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="iseb">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/iseb.png">
                                                                    <h3>ISEB</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="cat4">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/cat4.png">
                                                                    <h3>CAT 4</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="vocabulary">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/vocabulary.png">
                                                                    <h3>Vocabulary</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="timestables">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/timestables.png">
                                                                    <h3>Timestables</h3>
                                                               </div>

                                                              </span>
                                                        </label>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="form-section assignment_topic_type_fields practice_fields">
                                                <h2 class="section-title">Practice</h2>
                                            </div>


                                            <div class="form-section assignment_topic_type_fields sats_fields">
                                                <h2 class="section-title">Sats</h2>
                                            </div>


                                            <div class="form-section assignment_topic_type_fields 11plus_fields">
                                                <h2 class="section-title">11 Plus</h2>
                                            </div>


                                            <div class="form-section assignment_topic_type_fields independent_exams_fields">
                                                <h2 class="section-title">Independent Exams</h2>
                                            </div>


                                            <div class="form-section assignment_topic_type_fields iseb_fields">
                                                <h2 class="section-title">ISEB</h2>
                                            </div>


                                            <div class="form-section assignment_topic_type_fields cat4_fields">
                                                <h2 class="section-title">CAT 4</h2>
                                            </div>


                                            <div class="form-section assignment_topic_type_fields vocabulary_fields">
                                                <h2 class="section-title">Vocabulary</h2>
                                            </div>

                                            <div class="form-section assignment_topic_type_fields timestables_fields">
                                                <h2 class="section-title">Times Tables</h2>
                                            </div>


                                            <div class="assignment_topic_type_fields vocabulary_fields sats_fields practice_fields">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                        <div class="form-group">
                                                            <label class="input-label">Year Group</label>
                                                            <select data-default_id="{{isset( $quiz->id)? $quiz->year_id : 0}}"
                                                                    class="form-control year_quiz_ajax_select @error('year_id') is-invalid @enderror"
                                                                    name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][year_id]">
                                                                <option value="0">Select Year Group</option>

                                                                @foreach($categories as $category)
                                                                @if(!empty($category->subCategories) and
                                                                count($category->subCategories))
                                                                @foreach($category->subCategories as $subCategory)
                                                                <option value="{{ $subCategory->id }}" @if(!empty($quiz) and $quiz->year_id == $subCategory->id) selected="selected" @endif>
                                                                    {{$subCategory->title}}
                                                                </option>
                                                                @endforeach
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
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                        <div class="quiz-ajax-fields"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="practice-quiz-ajax-fields assignment_topic_type_fields practice_fields"></div>


                                            <div class="assignment_topic_type_fields 11plus_fields independent_exams_fields iseb_fields cat4_fields">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                        <div class="form-group">
                                                            <label class="input-label d-block">Year Group</label>
                                                            <select name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][year_group]"
                                                                    class="form-control year_group_quiz_ajax_select" data-placeholder="Select Year Group">
                                                                <option value="">Select Year Group</option>
                                                                <option value="All">All</option>
                                                                <option value="Year 3" selected>Year 3</option>
                                                                <option value="Year 4">Year 4</option>
                                                                <option value="Year 5">Year 5</option>
                                                                <option value="Year 6">Year 6</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                        <div class="yeargroup-ajax-fields"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="practice-quiz-topics-list assignment_topic_type_fields practice_fields"></div>

                                            @php
                                            $tables_no = isset( $assignment->tables_no )? json_decode($assignment->tables_no) : array();
                                            @endphp


                                            <div class="form-group assignment_topic_type_fields timestables_fields">
                                                <div class="questions-select-number">
                                                    <ul class="d-flex justify-content-center flex-wrap mb-30">
                                                        <li><input type="checkbox" value="10" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(10,$tables_no)?
                                                            'checked' : ''}} id="tables_ten" /> <label for="tables_ten">10</label></li>
                                                        <li><input type="checkbox" value="2" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(2,$tables_no)?
                                                            'checked' : 'checked'}} id="tables_two" /> <label for="tables_two">2</label></li>
                                                        <li><input type="checkbox" value="5" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(5,$tables_no)?
                                                            'checked' : ''}} id="tables_five" /> <label for="tables_five">5</label></li>
                                                        <li><input type="checkbox" value="3" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(3,$tables_no)?
                                                            'checked' : 'checked'}} id="tables_three" /> <label for="tables_three">3</label></li>
                                                        <li><input type="checkbox" value="4" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(4,$tables_no)?
                                                            'checked' : ''}} id="tables_four" /> <label for="tables_four">4</label></li>
                                                        <li><input type="checkbox" value="8" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(8,$tables_no)?
                                                            'checked' : ''}} id="tables_eight" /> <label for="tables_eight">8</label></li>
                                                        <li><input type="checkbox" value="6" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(6,$tables_no)?
                                                            'checked' : ''}} id="tables_six" /> <label for="tables_six">6</label></li>
                                                        <li><input type="checkbox" value="7" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(7,$tables_no)?
                                                            'checked' : ''}} id="tables_seven" /> <label for="tables_seven">7</label></li>
                                                        <li><input type="checkbox" value="9" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(9,$tables_no)?
                                                            'checked' : ''}} id="tables_nine" /> <label for="tables_nine">9</label></li>
                                                        <li><input type="checkbox" value="11" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(11,$tables_no)?
                                                            'checked' : ''}} id="tables_eleven" /> <label for="tables_eleven">11</label></li>
                                                        <li><input type="checkbox" value="12" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(12,$tables_no)?
                                                            'checked' : ''}} id="tables_twelve" /> <label for="tables_twelve">12</label></li>
                                                        <li><input type="checkbox" value="13" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(13,$tables_no)?
                                                            'checked' : ''}} id="tables_thirteen" /> <label for="tables_thirteen">13</label></li>
                                                        <li><input type="checkbox" value="14" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(14,$tables_no)?
                                                            'checked' : ''}} id="tables_fourteen" /> <label for="tables_fourteen">14</label></li>
                                                        <li><input type="checkbox" value="15" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(15,$tables_no)?
                                                            'checked' : ''}} id="tables_fifteen" /> <label for="tables_fifteen">15</label></li>
                                                        <li><input type="checkbox" value="16" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][tables_no][]" {{in_array(16,$tables_no)?
                                                            'checked' : ''}} id="tables_sixteen" /> <label for="tables_sixteen">16</label></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="form-section">
                                                <h2 class="section-title">General information</h2>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Assignment Title</label>
                                                <input type="text"
                                                       name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][title]"
                                                       value="{{ !empty($assignment) ? $assignment->title : old('title') }}"
                                                       class="js-ajax-title form-control "
                                                       placeholder=""/>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Assignment Description</label>
                                                <textarea
                                                        name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][description]"
                                                        class="form-control summernote-editor-mintool"
                                                        placeholder="" rows="20"></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="form-section">
                                                <h2 class="section-title">Schedule</h2>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                                                    <div class="form-group">
                                                        <label class="input-label">Training Start Date</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="input-group-text admin-file-manager" data-input="logo" data-preview="holder">
                                                                    <i class="fa fa-calendar-week"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" autocomplete="off"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_start_date]"
                                                                   value="{{ !empty($assignment) ? dateTimeFormat($assignment->assignment_start_date, 'Y-m-d', false) : old('assignment_start_date') }}"
                                                                   class="form-control datepicker" min="2023-12-20" max="2023-12-31"
                                                                   placeholder=""/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                                                    <div class="form-group conditional_fields Daily_field Weekly_field Monthly_field">
                                                        <label class="input-label">Training Due Date</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="input-group-text admin-file-manager" data-input="logo" data-preview="holder">
                                                                    <i class="fa fa-calendar-week"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" autocomplete="off"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_end_date]"
                                                                   value="{{ !empty($assignment) ? dateTimeFormat($assignment->assignment_end_date, 'Y-m-d', false) : old('assignment_end_date') }}"
                                                                   class="form-control datepicker"
                                                                   placeholder=""/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                                                    <div class="form-group">
                                                        <label class="input-label">Review Due Date</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="input-group-text admin-file-manager" data-input="logo" data-preview="holder">
                                                                    <i class="fa fa-calendar-week"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" autocomplete="off"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_review_due_date]"
                                                                   value="{{ !empty($assignment) ? dateTimeFormat($assignment->assignment_review_due_date, 'Y-m-d', false) : old('assignment_review_due_date') }}"
                                                                   class="form-control datepicker"
                                                                   placeholder=""/>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                    <div class="form-group">
                                                        <label class="input-label">Show No of Questions <span class="max_questions"></span></label>

                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][no_of_questions]" value="0"
                                                                   class="js-ajax-title form-control no_of_questions range-slider-field" min="0" max="0" placeholder=""/>
                                                        </div>


                                                        <div class="invalid-feedback"></div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                    <div class="form-group">
                                                        <label class="input-label">No of Attempts</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][no_of_attempts]"
                                                                   value="0"
                                                                   class="js-ajax-title form-control no_of_attempts range-slider-field"
                                                                   placeholder="" min="0" max="10"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Assignment Method</label>
                                                <div class="input-group">

                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_method]"
                                                                   class="assignment_method_check" value="practice" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                            <h3>Practice</h3>
                                                                       </div>

                                                                  </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_method]"
                                                                   class="assignment_method_check" value="target_improvements">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                            <h3>Target / Improvements</h3>
                                                                       </div>

                                                                  </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                    <div class="form-group assignment_method_check_fields target_improvements_fields">
                                                        <label class="input-label">Percentage of Correct Answers</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][target_percentage]"
                                                                   value="0"
                                                                   class="js-ajax-title form-control correct_answers_percentage range-slider-field" min="0" max="100"
                                                                   placeholder=""/>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                    <div class="form-group assignment_method_check_fields target_improvements_fields">
                                                        <label class="input-label">Average Time of Correct Answers (Seconds)</label>

                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][target_average_time]"
                                                                   value="0"
                                                                   class="js-ajax-title form-control average_time range-slider-field" min="0" max="60"
                                                                   placeholder=""/>
                                                        </div>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Duration Type</label>
                                                <div class="input-group">


                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][duration_type]"
                                                                   class="duration_conditional_check" value="no_time_limit" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>No Time Limit</h3>
                                                               </div>

                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][duration_type]"
                                                                   class="duration_conditional_check" value="total_practice">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Total Practice</h3>
                                                               </div>

                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][duration_type]"
                                                                   class="duration_conditional_check" value="per_question">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Per Question</h3>
                                                               </div>

                                                         </span>
                                                        </label>
                                                    </div>

                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="form-group duration_type_fields total_practice_fields">
                                                <label class="input-label">Practice Time (<span class="practice_interval_data">Minutes</span>)</label>
                                                <div class="range-slider">
                                                    <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                    <div class="range-slider_line">
                                                        <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                    </div>
                                                    <input type="range"
                                                           name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][practice_time]"
                                                           value="0"
                                                           class="js-ajax-title form-control practice_interval range-slider-field" step="20" min="0" max="240"
                                                           placeholder=""/>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="form-group duration_type_fields per_question_fields">
                                                <label class="input-label">Questions Time Interval (<span class="time_interval_data">Seconds</span>)</label>

                                                <div class="range-slider">
                                                    <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                    <div class="range-slider_line">
                                                        <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                    </div>
                                                    <input type="range"
                                                           name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][time_interval]"
                                                           value="0"
                                                           class="js-ajax-title form-control time_interval range-slider-field" step="10" min="0" max="1200"
                                                           placeholder=""/>
                                                </div>

                                                <div class="invalid-feedback"></div>
                                            </div>


                                            <div class="form-group">
                                                <label class="input-label">Assignment Reviewer</label>
                                                <div class="input-group">
                                                    <select name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_reviewer][]"
                                                            class="form-control select2" multiple="multiple">
                                                        @if( !empty( $teachers ) )
                                                        @foreach( $teachers as $teacherObj)
                                                        <option value="{{$teacherObj->id}}">{{$teacherObj->full_name}}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="form-section">
                                                <h2 class="section-title">User Criteria</h2>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Assignment Assign Type</label>
                                                <div class="input-group">


                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type]"
                                                                   class="duration_conditional_check" value="Individual">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Individual</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type]"
                                                                   class="duration_conditional_check" value="Class" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Class</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Class</label>
                                                <div class="input-group">
                                                    <select name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type]" class="form-control select2 class_condition">
                                                        <option value="">Select</option>
                                                        @if( !empty( $classes) )
                                                        @foreach( $classes as $classObj)
                                                        <option value="{{$classObj->id}}" @if(!empty($assignment) && $assignment->assignment_type == 'Individual') selected @endif>
                                                            {{$classObj->title}}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>


                                            <ul class="col-10 col-md-10 col-lg-10 admin-rurera-tabs nav nav-pills" id="assignment_tabs" role="tablist">
                                                @if( !empty( $sections) )
                                                @foreach( $sections as $sectionObj)
                                                <li class="nav-item conditional_sections rurera-hide class_sections_{{$sectionObj->parent_id}}">
                                                    <a class="nav-link" id="section-tabid-{{$sectionObj->id}}" data-toggle="tab" href="#section-tab-{{$sectionObj->id}}" role="tab"
                                                       aria-controls="section-tab-{{$sectionObj->id}}" aria-selected="true"><span class="tab-title">{{$sectionObj->title}}</span></a>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>

                                            <div class="tab-content" id="myTabContent2">
                                                @if( !empty( $sections) )
                                                @foreach( $sections as $sectionObj)
                                                <div class="tab-pane mt-3 fade" id="section-tab-{{$sectionObj->id}}" role="tabpanel" aria-labelledby="section-tab-{{$sectionObj->id}}-tab">
                                                    @if( !empty( $sectionObj->users) )
                                                    <div class="users_list_block">
                                                        <span><input type="checkbox" class="select_all" id="select_all_{{$sectionObj->id}}" value="{{$sectionObj->id}}"
                                                                     name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][class_ids][]"><label for="select_all_{{$sectionObj->id}}">Select All</label></span>
                                                        <ul class="users-list">
                                                            @foreach( $sectionObj->users as $userObj)
                                                            <li data-user_id="{{$userObj->id}}">
                                                                <span><input type="checkbox" id="select_user{{$userObj->id}}" value="{{$userObj->id}}"
                                                                             name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_users][]"><label
                                                                            for="select_user{{$userObj->id}}">{{$userObj->full_name}}</label></span>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                                @endif

                                            </div>

                                        </div>
                                        @endif

                                    </div>


                                </div>

                                <div class="mt-20 mb-20">
                                    <button type="submit"
                                            class="js-submit-quiz-form btn btn-sm btn-primary">{{
                                        !empty($assignment) ?
                                        trans('public.save_change') : trans('public.create') }}
                                    </button>

                                    @if(empty($assignment) and !empty($inWebinarPage))
                                    <button type="button"
                                            class="btn btn-sm btn-danger ml-10 cancel-accordion">{{
                                        trans('public.close') }}
                                    </button>
                                    @endif
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<script src="/assets/default/js/admin/filters.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

        if ($('.summernote-editor-mintool').length) {

            $('.summernote-editor-mintool').summernote({
                toolbar: [
                    ['font', ['bold', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                callbacks: {
                    onChange: function (contents, $editable) {
                        $('.summernote-editor_' + parent_field_id).val(EditorValueEnocde(contents));
                        trigger_field_change($('.summernote-editor_' + parent_field_id));
                    }
                }
            });
        }


        $('body').on('change', '.select_all', function (e) {
            if ($(this).is(':checked')) {
                $(this).closest('.users_list_block').find('.users-list').find('input').prop('checked', true);
                console.log('checked');
            } else {
                $(this).closest('.users_list_block').find('.users-list').find('input').prop('checked', false);
                console.log('unchecked');
            }
            ;
        });

        $('body').on('click', '.year-group-select', function (e) {
            var thisObj = $('.populated-content-area');
            var year_id = $(this).attr('data-year_id');
            $(".year_id_field").val(year_id);
            rurera_loader(thisObj, 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/custom_quiz/subjects_by_year',
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

        var subjects_callback_bk = function () {
            $('body').on('click', '.subject-group-selects', function (e) {
                var thisObj = $('.populated-content-area');
                var subject_id = $(this).attr('data-subject_id');
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
                        $(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        if (return_data != '') {
                            //$(".populated-content-area").append(return_data);
                            $(".topics-subtopics-content-area").append(return_data);
                            questions_callback();
                        }
                    }
                });
            });
        }

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
                            questions_callback();
                        }
                    }
                });
            });
        }
        subjects_callback();


        var questions_callback = function () {
            $('body').on('click', '.subchapter-group-select li', function (e) {
                var thisObj = $('.populated-content-area');
                var subchapter_id = $(this).attr('data-subchapter_id');
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/questions_by_subchapter',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subchapter_id": subchapter_id},
                    success: function (return_data) {
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        //$(".questions-populate-area").html(return_data);
                        $(".selected-questions-group").append(return_data);
                        questions_select_callback();

                    }
                });
            });
        }

        var questions_select_callback = function () {
            $('body').on('click', '.questions-group-select li', function (e) {
                var thisObj = $('.populated-content-area');
                var question_id = $(this).attr('data-question_id');
                var question_title = $(this).find('a').html();
                $('.questions-list li[data-question_id="' + question_id + '"]').remove();
                $(".questions-list").append('<li data-question_id="' + question_id + '"><input type="hidden" name="ajax[new][question_list_ids][]" value="' + question_id + '">' + question_title + '<a href="javascript:;" class="parent-li-remove"><span class="fas fa-trash"></span></a></li>');
            });


        }

        var currentRequest = null;
        var question_search = function () {
            $('body').on('keyup', '.search-questions', function (e) {
                var input, filter, ul, li, a, i, txtValue;
                var search_question_bank = $('.search_question_bank').is(":checked");
                if (search_question_bank == false) {
                    input = document.getElementById("search-questions");
                    filter = input.value.toUpperCase();
                    ul = document.getElementById("questions-group-select");
                    li = ul.getElementsByTagName("li");
                    for (i = 0; i < li.length; i++) {
                        a = li[i].getElementsByTagName("a")[0];
                        txtValue = a.textContent || a.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1 || li[i].className.indexOf("alwaysshow") > -1) {
                            li[i].style.display = "";
                        } else {
                            li[i].style.display = "none";
                        }
                    }
                } else {
                    var input = $(this).val();
                    var thisObj = $('.questions-populate-area');
                    var year_id = $(".year_id_field").val();
                    var subject_id = $(".subject_id_field").val();
                    rurera_loader(thisObj, 'div');

                    currentRequest = jQuery.ajax({
                        type: "GET",
                        url: '/admin/custom_quiz/questions_by_keyword',
                        beforeSend: function () {
                            if (currentRequest != null) {
                                currentRequest.abort();
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"keyword": input, "year_id": year_id, "subject_id": subject_id},
                        success: function (return_data) {
                            rurera_remove_loader(thisObj, 'button');
                            $(".questions-group-select").html(return_data);
                        }
                    });
                }
            });
        }

        question_search();


        $(".questions-list").sortable();


        $('body').on('click', '.rurera-back-btn', function (e) {
            $(this).closest('.populated-data').prev('.populated-data').removeClass('rurera-hide');
            $(this).closest('.populated-data').addClass('rurera-hide');
            $(this).closest('.populated-data').remove();
            if ($(this).hasClass('questions-list-btn')) {
                console.log('questions-btn');
            }
        });

        $('body').on('change', '.conditional_check', function (e) {
            var current_value = $(this).val();
            $(".conditional_fields").addClass('rurera-hide');
            $('.' + current_value + '_field').removeClass('rurera-hide');
        });

        $('body').on('change', '.class_condition', function (e) {
            var current_value = $(this).val();
            $(".conditional_sections").addClass('rurera-hide');
            $('.class_sections_' + current_value).removeClass('rurera-hide');
        });

        $('body').on('change', '.duration_conditional_check', function (e) {
            var current_value = $(this).val();
            $(".duration_type_fields").addClass('rurera-hide');
            $('.' + current_value + '_fields').removeClass('rurera-hide');
        });

        $('body').on('change', '.assignment_topic_type_check', function (e) {
            var current_value = $(this).val();
            $(".assignment_topic_type_fields").addClass('rurera-hide');
            $('.' + current_value + '_fields').removeClass('rurera-hide');
        });

        $('body').on('change', '.assignment_method_check', function (e) {
            var current_value = $(this).val();
            $(".assignment_method_check_fields").addClass('rurera-hide');
            $('.' + current_value + '_fields').removeClass('rurera-hide');
        });


        $('body').on('change', '.year_quiz_ajax_select', function (e) {
            var year_id = $(this).val();
            var quiz_type = $(".assignment_topic_type_check:checked").val();
            var thisObj = $(this);//$(".quiz-ajax-fields");
            rurera_loader(thisObj, 'button');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/types_quiz_by_year',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"quiz_type": quiz_type, "year_id": year_id},
                success: function (return_data) {
                    if(quiz_type == 'practice'){
                        $(".practice-quiz-ajax-fields").html(return_data);
                    }else {
                        $(".quiz-ajax-fields").html(return_data);
                    }
                    rurera_remove_loader(thisObj, 'button');
                }
            });
        });

        $('body').on('change', '.year_group_quiz_ajax_select', function (e) {
            var year_group = $(this).val();
            var quiz_type = $(".assignment_topic_type_check:checked").val();
            var thisObj = $(this);//$(".yeargroup-ajax-fields");
            rurera_loader(thisObj, 'button');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/types_quiz_by_year_group',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"quiz_type": quiz_type, "year_group": year_group},
                success: function (return_data) {
                    $(".yeargroup-ajax-fields").html(return_data);
                    rurera_remove_loader(thisObj, 'button');
                }
            });
        });

        $('body').on('change', '.assignment_subject_check', function (e) {
            var subject_id = $(this).val();
            var thisObj = $(this);
            rurera_loader($(".practice-quiz-topics-list"), 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/topics_subtopics_by_subject',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"subject_id": subject_id},
                success: function (return_data) {
                    rurera_remove_loader($(".practice-quiz-topics-list"), 'button');
                    $(".practice-quiz-topics-list").html(return_data);
                }
            });
        });




        $('.range-slider-field').each(function () {
            var thisObj = $(this);
            //var sliderStructure = $('<div class="range-slider"><div id="slider_thumb" class="range-slider_thumb" style="left: 425.5px;">0</div><div class="range-slider_line"><div id="slider_line" class="range-slider_line-fill" style="width: 46%;"></div></div>'+thisObj.clone().wrap('<div>').parent().html() +'</div>');
            //thisObj.replaceWith(sliderStructure);
            var sliderInput = thisObj;
            var sliderThumb = thisObj.closest('.range-slider').find('.range-slider_thumb');
            var sliderLine = thisObj.closest('.range-slider').find('.range-slider_line-fill');
            showSliderValue(sliderInput, sliderThumb, sliderLine);
            $(window).on("resize", function () {
                showSliderValue(sliderInput, sliderThumb, sliderLine);
            });

            sliderInput.on('input', function () {
                showSliderValue(sliderInput, sliderThumb, sliderLine);
            });
        });

        function showSliderValue(sliderInput, sliderThumb, sliderLine) {
            sliderThumb.html(sliderInput.val());
            var max_value = sliderInput.attr('max');
            var current_percentage = (sliderInput.val() * 100 / max_value);
            var bulletPosition = sliderInput.val() / sliderInput.attr('max');
            var space = sliderInput.width() - sliderThumb.width();
            space = parseInt(space) + parseInt(20);
            console.log(space);
            var text_to_display = sliderInput.val();
            if (sliderInput.hasClass('time_interval')) {
                $(".time_interval_data").html(sliderInput.val() + ' Seconds, ' + formatTime(sliderInput.val(), 'm', 's'));
            }
            if (sliderInput.hasClass('practice_interval')) {
                $(".practice_interval_data").html(sliderInput.val() + ' Minutes, ' + formatTime(sliderInput.val(), 'h', 'm'));
            }

            sliderThumb.css('left', (bulletPosition * space) + 'px');
            sliderLine.css('width', current_percentage + '%');
        }

        function formatTime(seconds, label_1, label_2) {
            var minutes = Math.floor(seconds / 60);
            var remainingSeconds = seconds % 60;

            var formattedTime = "";

            if (minutes > 0) {
                formattedTime += minutes + label_1 + " ";
            }

            formattedTime += remainingSeconds + label_2;

            return formattedTime;
        }

        $('body').on('change', '.topic_selection', function (e) {
            var current_value = $(this).val();
            var total_questions = $(this).find('option[value="' + current_value + '"]').attr('data-total_questions');
            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            //$( ".no_of_questions" ).val( $( "#slider-range-max" ).slider( "value" ) );
            $(".no_of_questions").val(0);
        });


        $(".conditional_check").change();
        $(".duration_conditional_check:checked").change();
        $(".assignment_topic_type_check:checked").change();
        $(".assignment_method_check:checked").change();
        $(".year_quiz_ajax_select").change();
        $(".year_group_quiz_ajax_select").change();


        $('body').on('change', '.section-parent', function (e) {
            let $this = $(this);
            let parent = $this.parent().closest('.section-box');
            let isChecked = e.target.checked;

            if (isChecked) {
                parent.find('input[type="checkbox"].section-child').prop('checked', true);
            } else {
                parent.find('input[type="checkbox"].section-child').prop('checked', false);
            }
        });

    });

</script>
@endpush
