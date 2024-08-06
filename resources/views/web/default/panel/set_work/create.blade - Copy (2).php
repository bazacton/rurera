@extends(getTemplate() .'.panel.layouts.panel_layout_full')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/assignments.css">
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/admin/vendor/daterangepicker/daterangepicker.min.css">
<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<style>
    .wizard-steps{display:none;}
    .wizard-steps.active{display:block;}
    .show-after-ajax{display:none;}
</style>
@endpush

@section('content')

<div class="container set-work-container lms-choose-membership">
                    <div class="row">
                        <div class="col-12">
                            <form action="/panel/set-work/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}" method="Post" class="rurera-form-validation">
                                {{ csrf_field() }}

                                <ul class="set-work-tagss text-left 223 rurera-hide remove-pending">

                                </ul>

                                <div class="wizard-steps active" data-step_id="1">
                                    <div class="wizard-steps-heading mb-30 text-left 223">
                                        <h3 class="font-24 mb-5">Set Work</h3>
                                        <p class="text-muted font-16">The test changes as you go, getting tougher if you keep getting things right, and easier if you find it hard. Let's make a special practice plan just for your student, with questions that are just right for students level.</p>
                                    </div>
                                    <div class="years-group populated-data">
                                        <div class="form-section mb-20 text-left 223">
                                            <h2 class="section-title font-24">Select Student to Set Practice</h2>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">

                                                <div class="radio-buttons justify-content-center">

                                                    @if( !empty( $childs ) )
                                                    @php $child_count = 0; @endphp
                                                            @foreach($childs as $childLinkObj)
                                                            @php $childObj = $childLinkObj->user; @endphp
                                                            @php
                                                            $userSubscriptions = $childObj->userSubscriptions;
                                                            $is_user_subscribed = isset( $userSubscriptions->id )? true : false;
                                                            if($is_user_subscribed == true){
                                                                $child_count++;
                                                            }
                                                            $selected_child = ($child_count == 1)? 'checked' : '';
                                                            @endphp
                                                            <input type="hidden" class="user-permissions" data-type="sats" data-user_id="{{$childObj->id}}" value="{{$childObj->subscription('sats')}}">
                                                            <input type="hidden" class="user-permissions" data-type="11plus" data-user_id="{{$childObj->id}}" value="{{$childObj->subscription('11plus')}}">
                                                            <input type="hidden" class="user-permissions" data-type="iseb" data-user_id="{{$childObj->id}}" value="{{$childObj->subscription('11plus')}}">
                                                            <input type="hidden" class="user-permissions" data-type="cat4" data-user_id="{{$childObj->id}}" value="{{$childObj->subscription('11plus')}}">
                                                            <input type="hidden" class="user-permissions" data-type="independent_exams" data-user_id="{{$childObj->id}}" value="{{$childObj->subscription('11plus')}}">
                                                            <label class="card-radio">
                                                                @if( $is_user_subscribed == true)
                                                                    <input type="radio" data-year_id="{{$childObj->year_id}}" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_users][]"
                                                                            value="{{$childObj->id}}" class="assignment-user-class" data-tag_title="{{$childObj->get_full_name()}}" {{$selected_child}}>
                                                                    <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                        <img src="{{ $childObj->getAvatar() }}">
                                                                            <h3>{{$childObj->get_full_name()}}</h3>
                                                                        </div>
                                                                    </span>
                                                                @else
                                                                <a href="javascript:;" class="subscription-modal rurera-hide remove-pending" data-type="update_package_confirm" data-id="{{$childObj->id}}">
                                                                    <span class="radio-btn disabled-style"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                        <img src="{{ $childObj->getAvatar() }}">
                                                                            <h3>{{$childObj->get_full_name()}}</h3>
                                                                            <span>Buy Membership</span>
                                                                        </div>
                                                                    </span>
                                                                </a>
                                                                @endif
                                                            </label>
                                                            @endforeach
                                                    @endif
                                                    <label class="card-radio add-student-btn rurera-hide remove-pending">
                                                        <a href="javascript:;" class="subscription-modal add-student-modal" data-type="child_register" data-id="0" >
                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                            <div class="card-icon">
                                                                <img src="/assets/default/svgs/add-con.svg">
                                                                <h3>Student</h3>
                                                        </div>
                                                    </span>
                                                        </a>

                                                    </label>
                                                    <input type="hidden" class="year_id_field" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][year_id]" value="0">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="years-group populated-data rurera-hide remove-pending">
                                        <div class="form-group">
                                            <div class="form-section mb-20 text-left 223">
                                                <h2 class="section-title font-24">Select Type</h2>
                                            </div>


                                            <div class="radio-buttons justify-content-center mb-50">
                                                <label class="card-radio">
                                                    <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type_check]"
                                                        class="assignment_type_check" value="practice_test" data-tag_title="Set Practice" checked>
                                                    <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Set Practice</h3>
                                                            </div>

                                                        </span>
                                                </label>
                                                <label class="card-radio">
                                                    <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type_check]"
                                                        class="assignment_type_check" value="mock_test" data-tag_title="Set Mock Test">
                                                    <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Set Mock Test</h3>
                                                            </div>

                                                        </span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
									
									
									



                                    <div class="years-group populated-data">
                                        <div class="form-section mb-20 text-left 223">
                                            <h2 class="section-title font-24">Select Practice Type</h2>
                                        </div>
                                        <div class="form-group">


                                            <div class="input-group">

                                                <div class="radio-buttons justify-content-center">
                                                    <label class="card-radio practice-item-active" data-next_step="3">
                                                        <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                            class="assignment_topic_type_check " value="practice" data-tag_title="Courses">
                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                            <div class="card-icon">
                                                            <img src="/assets/default/img/assignment-logo/practice.png">
                                                                <h3>Courses</h3>
                                                        </div>
                                                    </span>
                                                    </label>
                                                   
                                                    <label class="card-radio  " data-next_step="3">
                                                        <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                            class="assignment_topic_type_check" value="vocabulary" data-tag_title="Vocabulary">
                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                            <div class="card-icon">
                                                                <img src="/assets/default/img/assignment-logo/vocabulary.png">
                                                                <h3>Vocabulary</h3>
                                                        </div>

                                                        </span>
                                                    </label>

                                                    <label class="card-radio " data-next_step="3">
                                                        <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                            class="assignment_topic_type_check" value="timestables" data-tag_title="Timestables">
                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                            <div class="card-icon">
                                                                <img src="/assets/default/img/assignment-logo/timestables.png">
                                                                <h3>Timestables</h3>
                                                        </div>

                                                        </span>
                                                    </label>
													
													<label class="card-radio " data-next_step="3">
													<input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
														class="assignment_topic_type_check" value="mock_test" data-tag_title="Mock Test">
													<span class="radio-btn"><i class="las la-check"></i>
														<div class="card-icon">
															<h3>Mock Test</h3>
													</div>

													</span>
												</label>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="years-group populated-data assignment_topic_type_fields mock_test_fields">

                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" class="search-tests" placeholder="Search Mock Test">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="tests-list-holder mb-25">
                                                <a href="#." class="filter-mobile-btn">Filters Dropdown</a>
                                                <ul class="tests-list mb-30">
                                                    <input type="radio" class="rurera-hide assignment_topic_type_check assignment_topic_type_mock" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]" value="">
                                                    <li data-type="all" data-test_type="all" class="active" data-tag_title="All Tests">All Tests</li>
                                                    <li data-type="sats" data-test_type="sats" data-tag_title="SATS"><img src="/assets/default/img/assignment-logo/sats.png" alt="">SATs</li>
                                                    <li data-type="11plus" data-test_type="11plus" data-tag_title="11Plus"><img src="/assets/default/img/assignment-logo/11plus.png" alt=""> 11Plus</li>
                                                    <li data-type="iseb" data-test_type="iseb" data-tag_title="ISEB"><img src="/assets/default/img/assignment-logo/iseb.png" alt=""> ISEB</li>
                                                    <li data-type="cat4" data-test_type="cat4" data-tag_title="CAT 4"><img src="/assets/default/img/assignment-logo/cat4.png" alt=""> CAT 4</li>
                                                    <li data-type="independent_exams" data-test_type="independent_exams" data-tag_title="Independent Exams"><img src="/assets/default/img/assignment-logo/independent_exams.png" alt=""> Independent Exams</li>
                                                </ul>
                                            </div>
                                            <div class="form-section mb-20 text-left 223">
                                                <h2 class="section-title font-24">Select a Topic</h2>
                                            </div>
                                            <h4 class="total-tests has-border font-22">Total Tests: {{$sats->count()}}</h4>
                                        </div>


                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="sats-listing-card medium mt-30">
                                                <table class="simple-table">
                                                    <tbody>
                                                    <input type="radio" data-total_questions="0"  name="ajax[new][topic_ids]" class="rurera-hide topic_selection topic_select_radio" value="0">
                                                    @if( !empty( $sats))
                                                    @php $counter = 0; @endphp
                                                        @foreach( $sats as $rowObj)
                                                            @include('web.default.tests.single_item_assignment',['rowObj' => $rowObj])
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                                <div class="sats-listing-empty rurera-hidden"><p>No Records Found</p></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="years-group populated-data assignment_type_check_fields practice_test_fields">


                                        <div class="form-section assignment_topic_type_fields practice_fields mb-20 text-left 223 ajax-title show-after-ajax">
                                            <h2 class="section-title font-24">Select a Subject</h2>
                                        </div>


                                        <div class="form-section assignment_topic_type_fields sats_fields mb-20 text-left 223">
                                            <h2 class="section-title font-24">Sats</h2>
                                        </div>


                                        <div class="form-section assignment_topic_type_fields 11plus_fields mb-20 text-left 223">
                                            <h2 class="section-title font-24">11 Plus</h2>
                                        </div>


                                        <div class="form-section assignment_topic_type_fields independent_exams_fields mb-20 text-left 223">
                                            <h2 class="section-title font-24">Independent Exams</h2>
                                        </div>


                                        <div class="form-section assignment_topic_type_fields iseb_fields mb-20 text-left 223">
                                            <h2 class="section-title font-24">ISEB</h2>
                                        </div>


                                        <div class="form-section assignment_topic_type_fields cat4_fields mb-20 text-left 223">
                                            <h2 class="section-title font-24">CAT 4</h2>
                                        </div>


                                        <div class="form-section assignment_topic_type_fields vocabulary_fields mb-20 text-left 223 ajax-title show-after-ajax">
                                            <h2 class="section-title font-24">Select List</h2>
                                        </div>

                                        <div class="form-section assignment_topic_type_fields timestables_fields mb-20 text-left 223 ajax-title show-after-ajax">
                                            <h2 class="section-title font-24">Times Tables</h2>
                                        </div>

                                        <div class="form-section assignment_topic_type_fields assignment_fields mb-20 text-left 223 ajax-title show-after-ajax">
                                            <h2 class="section-title font-24">Custom Assignment</h2>
                                        </div>

                                        <div class="practice-quiz-ajax-fields"></div>

                                        @php
                                        $tables_no = isset( $assignment->tables_no )? json_decode($assignment->tables_no) : array();
                                        @endphp


                                        <div class="form-group assignment_topic_type_fields timestables_fields ajax-title show-after-ajax">
                                            <div class="questions-select-number mx-auto">
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

                                        <div class="practice-quiz-topics-list assignment_topic_type_fields practice_fields"></div>


                                    </div>

                                </div>

                                <div class="wizard-steps" data-step_id="2">

                                    <div class="years-group populated-data">
                                        <div class="form-section mb-20 text-left 223">
                                            <h2 class="section-title font-30">General information</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label class="input-label">Practice Title</label>
                                                    <input type="text"
                                                        name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][title]"
                                                        value="{{ !empty($assignment) ? $assignment->title : old('title') }}"
                                                        class="js-ajax-title form-control rurera-req-field bg-white"
                                                        placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label class="input-label">Practice Start Date</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="off"
                                                            name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_start_date]"
                                                            value="{{ !empty($assignment) ? dateTimeFormat($assignment->assignment_start_date, 'Y-m-d', false) : old('assignment_start_date') }}"
                                                            class="form-control bg-white practice-start-date rureradatepicker rurera-req-field @error('assignment_start_date') is-invalid @enderror"
                                                            min="{{date('Y-m-d')}}"
                                                            placeholder=""/>
                                                        @error('assignment_start_date')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group conditional_fields Daily_field Weekly_field Monthly_field">
                                                    <label class="input-label">Practice Due Date</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="off"
                                                            name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_end_date]"
                                                            value="{{ !empty($assignment) ? dateTimeFormat($assignment->assignment_end_date, 'Y-m-d', false) : old('assignment_end_date') }}"
                                                            class="form-control bg-white practice-due-date rureradatepicker rurera-req-field" min="{{date('Y-m-d')}}"
                                                            placeholder=""/>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="row assignment_topic_type_fields practice_fields vocabulary_fields">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                                <div class="form-group">
                                                    <label class="input-label">Show No of Questions <span class="max_questions"></span></label>

                                                    <div class="range-slider">
                                                        <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                        <div class="range-slider_line">
                                                            <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                        </div>
                                                        <input type="range" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][no_of_questions]" value="0"
                                                            class="js-ajax-title form-control rurera-req-field no_of_questions range-slider-field" min="0" max="0" placeholder=""/>
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
                                                            placeholder="" min="1" max="10"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group assignment_topic_type_fields timestables_fields">
                                            <label class="input-label">Duration Type</label>

                                            <div class="years-group populated-data input-group">


                                                <div class="radio-buttons justify-content-center">
                                                    <label class="card-radio">
                                                        <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][duration_type]"
                                                            class="duration_conditional_check" value="total_practice" checked>
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

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                        <div class="form-group">
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

                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-6">
                                        <div class="form-group duration_type_fields per_question_fields assignment_topic_type_fields timestables_fields">
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
                                            </div>
                                        </div>


                                    <div class="form-group assignment_topic_type_fields practice_fields">
                                        <label class="input-label">Practice Method</label>
                                        <div class="plan-switch-option" style="justify-content: left;">
                                                <span class="switch-label font-18">Completion Target</span> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="plan-switch">
                                                    <div class="custom-control custom-switch"><input type="checkbox" name="auto_generate" class="assignment_method_check custom-control-input" id="method_check" value="target_improvements"><label class="custom-control-label" for="method_check"></label></div>
                                                </div>
                                        </div>
                                    </div>

                                        <div class="row assignment_topic_type_fields practice_fields">
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
                                                            value="0" data-label="%"
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



                                    </div>




                                </div>

                                <div class="wizard-pagination">
                                    <div class="previous-btn wizard-step disabled-btn" data-next_step="0">Previous</div>
                                    <div class="next-btn wizard-step" data-next_step="2">Continue</div>
                                </div>

                                <div class="rurera-hide wizard-step clear-all-btn" data-next_step="1">Clear all</div>




                            </form>
                        </div>
                    </div>
                </div>


<div class="modal fade lms-choose-membership" id="assignmentCreateModal" tabindex="-1" aria-labelledby="assignmentCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel-header">
                <div class="modal-logo"><img src="/assets/default/img/sidebar/logo.svg"></div>
                <span class="steps-counter">Step 1</span>
                <button type="button" class="close" ><a href="/{{panelRoute()}}/set-work">Close <span aria-hidden="true">×</span></a></button>
                <div class="progress-line">
                    <span class="progress-count" style="width: 30%;"></span>
                </div>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade lms-choose-membership" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel-header">
                <div class="modal-logo"><img src="/assets/default/img/sidebar/logo.svg"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">Back to Dashboard <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container container-nosidebar">
                <div class="tab-content subscription-content" id="nav-tabContent">

                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="section">
    <div class="section-body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">

                    <div class="card">
                        <div class="card-body">
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
<script src="/assets/admin/vendor/daterangepicker/daterangepicker.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script type="text/javascript">

    //$("#assignmentCreateModal").modal('show');
    $(document).ready(function () {

        if ($('.summernote-editor-mintool').length) {

            $('.summernote-editor-mintool').summernote({
                toolbar: [
                    ['font', ['bold', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
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
            //$(".year_id_field").val(year_id);
            $(".ajax-title").addClass('show-after-ajax');
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
                        $(".show-after-ajax").not('.rurera-hide').removeClass('show-after-ajax');
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


        $('body').on('click', '.mock-test-assign-btn', function (e) {
            $(".mock-test-assign-btn").removeClass('active');
            $(this).addClass('active');
        	var topic_id = $(this).attr('data-id');
            var topic_type = $(this).attr('data-topic_type');
            $(".assignment_topic_type_mock").val(topic_type);
            $(".assignment_topic_type_mock").prop('checked', true);
        	var total_questions = $(this).attr('data-total_questions');
        	$(".topic_select_radio").val(topic_id);

        	$(".topic_select_radio").attr('data-total_questions', total_questions);
        	$(".topic_select_radio").click();

            refresh_tags();
        });

        $('body').on('click', '.vocabulary-assign-btn', function (e) {
            $(this).toggleClass('active');
            var topic_id = $(this).attr('data-id');
            console.log('topic_id: '+topic_id);
            var topic_type = $(this).attr('data-topic_type');
            $(".assignment_topic_type_mock").val(topic_type);
            /*$('.vocabulary-topic-selection[name="ajax[new][topic_ids][]"][value="'+topic_id+'"]').prop('checked', function(i, oldVal) {
                return !oldVal;
            });*/
            $('.vocabulary-topic-selection[name="ajax[new][topic_ids][]"][value="'+topic_id+'"]').prop('checked', true).change();
            var total_questions = $(this).attr('data-total_questions');
            $(".no_of_questions").attr('max', total_questions);
            $(".no_of_questions").val(total_questions);
        });



        $('body').on('click', '.wizard-pagination1 .previous-btn', function (e) {
        	var next_step = $(this).attr('data-next_step');
        	prev_step = parseInt(next_step) - 1;
        	$(".wizard-pagination .previous-btn").attr('data-next_step', prev_step);
        	$(".wizard-pagination .next-btn").attr('data-next_step', next_step);
        });

        $('body').on('click', '.wizard-pagination1 .next-btn', function (e) {
        	var next_step = $(this).attr('data-next_step');
        	next_step_count = parseInt(next_step) + 1;
        	$(".wizard-pagination .previous-btn").attr('data-next_step', next_step);
        	$(".wizard-pagination .next-btn").attr('data-next_step', next_step_count);
        });

        typeCheckRequest = null;
        $('body').on('change', '.assignment_topic_type_check', function (e) {
            var current_value = $(this).val();
            $(".ajax-title").addClass('show-after-ajax');
            $(".practice-quiz-ajax-fields").html('');
            $(".practice-quiz-topics-list").html('');
            $(".assignment_topic_type_fields").addClass('rurera-hide');
            $('.' + current_value + '_fields').removeClass('rurera-hide');
            var total_questions = 0;
            var current_questions = 0;
            if (current_value == 'timestables') {
                total_questions = 200;
            }
            if( current_value == '11plus' || current_value == 'independent_exams' || current_value == 'iseb' || current_value == 'cat4'){
                total_questions = 50;
                current_questions = 50;
            }

            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            $(".no_of_questions").val(current_questions);
            console.log('assignment_topic_type_check');
            slider_fields_refresh();
            refresh_tags();
            var year_id = $(".year_id_field").val();

            if( year_id > 0) {
                var quiz_type = $(".assignment_topic_type_check:checked").val();
                var thisObj = $(this);//$(".quiz-ajax-fields");
                $(".yeargroup-ajax-fields").html('');
                rurera_loader(thisObj.closest('label'), 'div');
                typeCheckRequest = jQuery.ajax({
                    type: "GET",
                    url: '/common/types_quiz_by_year',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        if (typeCheckRequest != null) {
                            //rurera_remove_loader(thisObj.closest('label'), 'div');
                            //typeCheckRequest.abort();
                        }
                    },
                    data: {"quiz_type": quiz_type, "year_id": year_id, "is_frontend": 'yes'},
                    success: function (return_data) {
                        if (quiz_type == 'practice') {
                            $(".practice-quiz-ajax-fields").html(return_data);
                            $(".active-subject").find('input').prop('checked', true).change();
                        } else {
                            //$(".quiz-ajax-fields").html(return_data);
                            $(".practice-quiz-ajax-fields").html(return_data);
                        }
                        $(".show-after-ajax").not('.rurera-hide').removeClass('show-after-ajax');
                        rurera_remove_loader(thisObj.closest('label'), 'div');
                    }
                });
            }else{
                $(".assignment-user-class:checked").change();
            }

        });

        $('body').on('change', '.assignment_method_check', function (e) {
            var current_value = $('.assignment_method_check:checked').val();
            $(".practice-quiz-ajax-fields").html('');

            $(".assignment_method_check_fields").addClass('rurera-hide');
            $('.assignment_method_check_fields.' + current_value + '_fields').removeClass('rurera-hide');
        });
        $('body').on('change', '.assignment_type_check', function (e) {
            $(".practice-quiz-ajax-fields").html('');
            var current_value = $(this).val();
            $(".assignment_type_check_fields").addClass('rurera-hide');
            $('.assignment_type_check_fields.' + current_value + '_fields').removeClass('rurera-hide');
            if( current_value == 'practice_test'){
                $(".practice-item-active").click();
            }
            refresh_tags();
        });



        $('body').on('change', '.year_quiz_ajax_select12', function (e) {
            var year_id = $(this).val();
            $(".ajax-title").addClass('show-after-ajax');
            var quiz_type = $(".assignment_topic_type_check:checked").val();
            var thisObj = $(this);//$(".quiz-ajax-fields");
            $(".yeargroup-ajax-fields").html('');
            rurera_loader(thisObj, 'button');
            jQuery.ajax({
                type: "GET",
                url: '/common/types_quiz_by_year',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"quiz_type": quiz_type, "year_id": year_id},
                success: function (return_data) {
                    if (quiz_type == 'practice') {
                        $(".practice-quiz-ajax-fields").html(return_data);
                    } else {
                        $(".quiz-ajax-fields").html(return_data);
                    }
                    $(".show-after-ajax").not('.rurera-hide').removeClass('show-after-ajax');
                    rurera_remove_loader(thisObj, 'button');
                    //$(".topic-item-active").click();
                }
            });
        });

        $('body').on('change', '.year_group_quiz_ajax_select', function (e) {
            var year_group = $(this).val();
            $(".ajax-title").addClass('show-after-ajax');
            var quiz_type = $(".assignment_topic_type_check:checked").val();
            var thisObj = $(this);//$(".yeargroup-ajax-fields");
            $(".practice-quiz-ajax-fields").html('');
            $(".quiz-ajax-fields").html('');
            rurera_loader(thisObj, 'button');
            jQuery.ajax({
                type: "GET",
                url: '/common/types_quiz_by_year_group',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"quiz_type": quiz_type, "year_group": year_group},
                success: function (return_data) {
                    $(".yeargroup-ajax-fields").html(return_data);
                    $(".show-after-ajax").not('.rurera-hide').removeClass('show-after-ajax');
                    rurera_remove_loader(thisObj, 'button');
                }
            });
        });

        $('body').on('change', '.assignment_subject_check', function (e) {
            //console.log($(".assignment_type_check:checked").val());
            if( $(".assignment_type_check:checked").val() != 'practice_test' ){
                $(".practice-quiz-topics-list").html('');
                return false;
            }
            //$(this).prop('checked', true);
            var subject_id = $(this).val();
            var thisObj = $(this);
            rurera_loader($(".practice-quiz-topics-list"), 'div');
            refresh_tags();
            jQuery.ajax({
                type: "GET",
                url: '/common/topics_subtopics_by_subject',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"subject_id": subject_id},
                success: function (return_data) {
                    rurera_remove_loader($(".practice-quiz-topics-list"), 'div');
                    $(".practice-quiz-topics-list").html(return_data);
                }
            });
        });

        var slider_fields_refresh = function () {
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
        }
        slider_fields_refresh();


        function showSliderValue(sliderInput, sliderThumb, sliderLine) {
            var label_value = sliderInput.attr('data-label');
            label_value = (label_value != undefined && label_value != 'undefined') ? label_value : '';
            sliderThumb.html(sliderInput.val() + label_value);
            var max_value = sliderInput.attr('max');
            var current_percentage = (sliderInput.val() * 100 / max_value);
            var bulletPosition = sliderInput.val() / sliderInput.attr('max');
            var space = sliderInput.width() - sliderThumb.width();
            space = parseInt(space) + parseInt(20);
            var text_to_display = sliderInput.val();
            if (sliderInput.hasClass('time_interval')) {
                var time_label = 'No Time Limit';
                if( sliderInput.val() > 0){
                    var time_label = sliderInput.val() + ' Seconds, ' + formatTime(sliderInput.val(), 'm', 's');
                }
                $(".time_interval_data").html(time_label);
            }
            if (sliderInput.hasClass('practice_interval')) {
                var time_label = 'No Time Limit';
                if( sliderInput.val() > 0){
                    var time_label = sliderInput.val() + ' Minutes, ' + formatTime(sliderInput.val(), 'h', 'm');
                }
                $(".practice_interval_data").html(time_label);
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
            //var total_questions = $(this).find('input[name="ajax[new][topic_id]"][value="' + current_value + '"]').attr('data-total_questions');
            var total_questions = $(this).attr('data-total_questions');
            var assignment_topic_type_check = $(".assignment_topic_type_check:checked").val();
            console.log(assignment_topic_type_check);
            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            $(".no_of_questions").val(0);
            if(assignment_topic_type_check == 'vocabulary' || assignment_topic_type_check == 'sats' || assignment_topic_type_check == '11plus' || assignment_topic_type_check == 'independent_exams' || assignment_topic_type_check == 'iseb' || assignment_topic_type_check == 'cat4') {
                var practice_time = $(".mock-test-assign-btn.active").attr('data-total_time');
                $(".practice_interval").attr('min', practice_time);
                $(".practice_interval").val(practice_time);
                $(".no_of_questions").attr('min', total_questions);
                $(".no_of_questions").val(total_questions);
                slider_fields_refresh();
            }
        });

        $('body').on('click', '.wizard-step', function (e) {
            $(".previous-btn").removeClass('disabled-btn');
            $(".next-btn").removeClass('disabled-btn');
            var next_step = $(this).attr('data-next_step');

            if( next_step == 2){

                //if ($('.assignment-user-class:checked').length > 0 && $('.assignment_type_check:checked').length > 0) {
                if ($('.assignment-user-class:checked').length < 1 || $('.assignment_type_check:checked').length < 1) {
                    jQuery.growl.error({
                        message: 'Please select all fields',
                        duration: 10000,
                    });
                    return false;
                }
            }

            if( next_step == 3){
                var quiz_type = $(".assignment_topic_type_check:checked").val();
                if(quiz_type != 'timestables'){
				if ($(".topic_selection").not('.rurera-hide').length > 0) {
                    //if ($('.assignment-user-class:checked').length > 0 && $('.assignment_type_check:checked').length > 0) {
                    if ($('.topic_selection:checked').length < 1 || $('.topic_selection:checked').length < 1) {
                        jQuery.growl.error({
                            message: 'Please select atleast one topic',
                            duration: 10000,
                        });
                        return false;
                    }
                }else{
				if ($(".topics_multi_selection").not('.rurera-hide').length > 0) {
                    //if ($('.assignment-user-class:checked').length > 0 && $('.assignment_type_check:checked').length > 0) {
                    if ($('.topics_multi_selection:checked').length < 1 || $('.topics_multi_selection:checked').length < 1) {
                        jQuery.growl.error({
                            message: 'Please select atleast one topic',
                            duration: 10000,
                        });
                        return false;
                    }
                }
                }
                }


            }



            var prev_step = parseInt(next_step) - 1;
            var next_step_counter = parseInt(next_step) + 1;
            var prev_step_counter = prev_step;
            $(".previous-btn").attr('data-next_step', prev_step);
            if( prev_step < 1){
                $(".previous-btn").addClass('disabled-btn');
            }
            if( next_step_counter > 3){
                $(".next-btn").addClass('disabled-btn');
            }
            $(".wizard-steps").removeClass('active');
            $('.wizard-steps[data-step_id="'+next_step+'"]').addClass('active');
            $(".wizard-pagination .previous-btn").attr('data-next_step', prev_step_counter);
            $(".wizard-pagination .next-btn").attr('data-next_step', next_step_counter);
            if( next_step == 2){
                $(".practice-item-active").find('input').prop('checked', true).change();

            }
            refresh_tags();
        });


        $('body').on('change', '.topics_multi_selection', function (e) {

            var total_questions = 0;
            $('.topics_multi_selection:checked').each(function () {
                total_questions = parseInt(total_questions) + parseInt($(this).attr('data-total_questions'));
            });

            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            //$( ".no_of_questions" ).val( $( "#slider-range-max" ).slider( "value" ) );
            $(".no_of_questions").val(0);
        });


        $(".conditional_check").change();
        $(".assignment-user-class:checked").change();
        $(".duration_conditional_check:checked").change();
        $(".assignment_topic_type_fields").addClass('rurera-hide');
        $(".assignment_method_check_fields").addClass('rurera-hide');

        $(".assignment_topic_type_check:checked").change();
        $(".assignment_method_check:checked").change();
        $(".year_quiz_ajax_select").change();
        $(".year_group_quiz_ajax_select").change();
        $(".assignment_type_check:checked").change();




        $('body').on('click', '.add-student-modal-bkk', function (e) {
            var action_type = 'child_register';
            var action_id = 0;
            selectedPackage = action_id;
            $(".set-work-container").addClass('subscription-content');
            //$(".subscription-content").html('');
            //$("#subscriptionModal").modal('show');
            rurera_loader($('.subscription-content'), 'div');
            subscriptionRequest = jQuery.ajax({
                type: "GET",
                url: '/subscribes/apply-subscription',
                async: true,
                beforeSend: function () {
                    if (subscriptionRequest != null) {
                        subscriptionRequest.abort();
                    }
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"action_type": action_type, "action_id": action_id},
                success: function (return_data) {
                    rurera_remove_loader($('.subscription-content'), 'div');
                    $(".subscription-content").html(return_data);
                }
            });
        });

        $('body').on('click', '.update-student-modal', function (e) {
            var action_type = 'child_payment';
            var action_id = $(this).attr('data-action_id');
            selectedPackage = action_id;
            $(".set-work-container").addClass('subscription-content');
            //$(".subscription-content").html('');
            //$("#subscriptionModal").modal('show');
            rurera_loader($('.subscription-content'), 'div');
            subscriptionRequest = jQuery.ajax({
                type: "GET",
                url: '/subscribes/apply-subscription',
                async: true,
                beforeSend: function () {
                    if (subscriptionRequest != null) {
                        subscriptionRequest.abort();
                    }
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"action_type": action_type, "action_id": action_id},
                success: function (return_data) {
                    rurera_remove_loader($('.subscription-content'), 'div');
                    $(".subscription-content").html(return_data);
                }
            });
        });


        var userRequest = null;
        $('body').on('change', '.assignment-user-class', function (e) {
            var year_id = $(this).attr('data-year_id');
			year_id = (year_id > 0)? year_id : 0;
            $(".year_id_field").val(year_id);
            $(".assignment_topic_type_check:checked").change();
            var user_id = $(this).val();


            $(".sats-listing-empty").addClass('rurera-hide');
            $('.sats-listing-card tr').removeClass('rurera-hide');
            $('.user-permissions[data-user_id="'+user_id+'"]').each(function(){
                var data_type = $(this).attr('data-type');
                var is_permission = $(this).val();
				
				$('.tests-list li[data-test_type="' + data_type + '"]').removeClass('disabled-style');
				$('.tests-list li[data-test_type="' + data_type + '"]').removeClass('subscription-modal');
				$('.tests-list li[data-test_type="' + data_type + '"]').attr('data-type', data_type);
				
                if( is_permission != true) {
                    $('.tests-list li[data-test_type="' + data_type + '"]').addClass('disabled-style');
                    $('.tests-list li[data-test_type="' + data_type + '"]').addClass('subscription-modal');
                    $('.tests-list li[data-test_type="' + data_type + '"]').attr('data-reason', 'module_access');
                    $('.tests-list li[data-test_type="' + data_type + '"]').attr('data-type', 'update_package_confirm');
                    $('.tests-list li[data-test_type="' + data_type + '"]').attr('data-id', user_id);
                    $('.sats-listing-card tr[data-assignment_type="'+data_type+'"]').addClass('rurera-hide');
                }

            });

            $(".total-tests").html('Total Tests: '+$('.sats-listing-card tr').not('.rurera-hide').length);
            if($('.sats-listing-card tr').not('.rurera-hide').length == 0){
                $(".sats-listing-empty").removeClass('rurera-hide');
            }


            /*
            userRequest = jQuery.ajax({
                type: "GET",
                url: '/tests/search_tests',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (userRequest != null) {
                        userRequest.abort();
                    }
                },
                data: {"quiz_type": 'all', "is_assignment": 'yes',  "year_id": year_id},
                success: function (return_data) {
                    rurera_remove_loader($(".simple-table tbody"), 'div');
                    $(".simple-table tbody").html(return_data);
                }
            });
            */


        });

        var searchRequest = null;
        $('body').on('click', '.mock_test_fields-bkkkk', function (e) {
            var quiz_type = $(this).attr('data-type');

            searchRequest = jQuery.ajax({
                type: "GET",
                url: '/tests/search_tests',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (searchRequest != null) {
                        searchRequest.abort();
                    }
                },
                data: {"quiz_type": quiz_type},
                success: function (return_data) {
                    console.log(return_data);
                }
            });

        });
        $('body').on('change', '.topic-section-parent', function (e) {
            let $this = $(this);
            let parent = $this.parent().closest('.section-box');
            let isChecked = e.target.checked;

            if (isChecked) {
                parent.find('input[type="checkbox"].section-child').prop('checked', true);
            } else {
                parent.find('input[type="checkbox"].section-child').prop('checked', false);
            }

            $(".topics_multi_selection").change();
        });

        $('body').on('apply.daterangepicker', '.practice-start-date', function (ev, picker) {
            $(".practice-due-date").attr('min', picker.startDate.format('YYYY-MM-DD'));
            $(".reviewer-date").attr('min', picker.startDate.format('YYYY-MM-DD'));
            resetRureraDatePickers();
        });

        $('body').on('apply.daterangepicker', '.practice-due-date', function (ev, picker) {
            $(".reviewer-date").attr('min', picker.startDate.format('YYYY-MM-DD'));
            resetRureraDatePickers();
        });


        function refresh_tags() {
            $(".set-work-tags").html('');
            if ($(".assignment-user-class:checked").length > 0) {
                var current_step = $(".wizard-steps.active").attr('data-step_id');
                var tag_title = $(".assignment-user-class:checked").attr('data-tag_title');
                $(".set-work-tags").append('<li>' + tag_title + '</li>');
                var tag_title = $(".assignment_type_check:checked").attr('data-tag_title');
                var practice_type = $(".assignment_type_check:checked").val();
                $(".set-work-tags").append('<li>' + tag_title + '</li>');

                if( current_step > 1) {
                    if (practice_type == 'mock_test') {
                        tag_title = $(".tests-list li.active").attr('data-tag_title');
                        $(".set-work-tags").append('<li>' + tag_title + '</li>');
                    } else {
                        var tag_title = $(".assignment_topic_type_check:checked").attr('data-tag_title');
                        $(".set-work-tags").append('<li>' + tag_title + '</li>');
                    }
                    var tag_title = $(".mock-test-assign-btn.active").attr('data-tag_title');
                    if( tag_title != '' && tag_title != 'undefined' && tag_title != undefined) {
                        $(".set-work-tags").append('<li>' + tag_title + '</li>');
                    }

                    var tag_title = $(".assignment_subject_check:checked").attr('data-tag_title');
                    if( tag_title != '' && tag_title != 'undefined' && tag_title != undefined) {
                        $(".set-work-tags").append('<li>' + tag_title + '</li>');
                    }


                }
                $(".set-work-tags").append('<li class="clear-tags">Clear All</li>');
            }
        }
        refresh_tags();

        $('body').on('click', '.clear-tags', function (e) {

            $(".clear-all-btn").click();
        });


        $('body').on('click', '.vocabulary-ul li a', function (e) {
            rurera_loader($(".simple-table tbody"), 'div');
            $(".vocabulary-ul li").removeAttr('class');
            $(this).closest('li').addClass('active');
            var year_id = $(".year_id_field").val();
            var quiz_category = $(this).attr('data-category');
            searchRequest = jQuery.ajax({
                type: "GET",
                url: '/spells/search',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (searchRequest != null) {
                        searchRequest.abort();
                    }
                },
                data: {"quiz_category": quiz_category, "is_assignment": 'yes',  "year_id": year_id},
                success: function (return_data) {
                    $(".total-tests").remove();
                    rurera_remove_loader($(".simple-table tbody"), 'div');
                    $(".simple-table tbody").html(return_data);
                }
            });

        });

        $('body').on('click', '.tests-list li', function (e) {
            if( $(this).hasClass('subscription-modal')){
                return;
            }
            rurera_loader($(".simple-table tbody"), 'div');
            $(".tests-list li").removeClass('active');
            $(this).addClass('active');
            var year_id = $(".year_id_field").val();
            var quiz_type = $(this).attr('data-type');
            $(".assignment_topic_type_mock").val(quiz_type);
            $(".assignment_topic_type_mock").prop('checked', true);
            refresh_tags();
            searchRequest = jQuery.ajax({
                type: "GET",
                url: '/tests/search_tests',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (searchRequest != null) {
                        searchRequest.abort();
                    }
                },
                data: {"quiz_type": quiz_type, "is_assignment": 'yes',  "year_id": year_id},
                success: function (return_data) {
                    rurera_remove_loader($(".simple-table tbody"), 'div');
                    $(".simple-table tbody").html(return_data);
                }
            });

        });

        var searchRequest = null;
        $('body').on('keyup', '.search-tests', function (e) {
            rurera_loader($(".simple-table tbody"), 'div');
            var year_id = $(".year_id_field").val();
            var search_keyword = $(this).val();
            searchRequest = jQuery.ajax({
                type: "GET",
                url: '/tests/search_tests',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (searchRequest != null) {
                        searchRequest.abort();
                    }
                },
                data: {"search_keyword": search_keyword, "is_assignment": 'yes',  "year_id": year_id},
                success: function (return_data) {
                    rurera_remove_loader($(".simple-table tbody"), 'div');
                    if (return_data != '') {
                        $(".simple-table tbody").html(return_data);
                    }
                }
            });

        });

    });

</script>
@endpush


<script type="text/javascript">

    $(document).on('change', '.subscribed_for-field', function (e) {
        var package_month = 1;
        var package_discount = 0;
        if($(this).is(':checked')) {
            package_month = 12;
            package_discount = 25;
        }
        var currency_sign = $(".lms-membership-section").attr('data-currency_sign');
        console.log(package_month);
        $(".packages-prices").each(function(){
           var package_price = $(this).attr('data-package_price');
            var package_price_org = package_price;
           var discount_price = parseFloat(parseFloat(package_price))*package_discount / 100;
           var package_price = parseFloat(parseFloat(package_price))-discount_price;
           //var package_price = parseInt(package_price)*package_month;
           package_price_label = currency_sign+parseFloat(parseFloat(package_price).toFixed(2));
           if( package_month == 12) {
               var yearly_price = package_price * 12;
               yearly_price = parseFloat(parseFloat(yearly_price).toFixed(2));
               $(this).closest('.subscribe-price').find('.yearly-price').html(currency_sign + yearly_price + ' billed yearly');
           }else{
               var without_discount = package_price_org*12;
               var discount_price = parseFloat(parseFloat(package_price))*25 / 100;
               var yearly_price = parseFloat(parseFloat(package_price_org))-discount_price;
               yearly_price = without_discount-(yearly_price*12);
               yearly_price = parseFloat(parseFloat(yearly_price).toFixed(2));
               $(this).closest('.subscribe-price').find('.yearly-price').html('Save '+currency_sign+yearly_price+' with a yearly plan');
           }


           $(this).html(package_price_label+'/mo');
        });
    });
</script>