@extends(getTemplate() .'.panel.layouts.panel_layout_full')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/assignments.css">
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/admin/vendor/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
<section class="section">
    <div class="section-body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <h1>SET WORK</h1>
                <p>The test changes as you go, getting tougher if you keep getting things right, and easier if you find it hard. Let's make a special practice plan just for your student, with questions that are just right for students level.</p>

                    <div class="card">
                        <div class="card-body">

                            <form action="/panel/set-work/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}"
                                  method="Post" class="rurera-form-validation">
                                {{ csrf_field() }}

                                <div class="row col-lg-12 col-md-12 col-sm-4 col-12">
                                    <div class="populated-content-area col-lg-12 col-md-12 col-sm-12 col-12">
                                        
                                        <div class="years-group populated-data">
                                            <div class="form-section">
                                                <h2 class="section-title">Select Students to Set Practice</h2>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
        
                                                    <div class="radio-buttons">
                                                        
                                                        @if( !empty( $childs ) )
                                                        @php $child_count = 0; @endphp
                                                                @foreach($childs as $childLinkObj)
                                                                @php $childObj = $childLinkObj->user; $child_count++; @endphp
                                                                @php $selected_child = ($child_count == 1)? 'checked' : ''; @endphp
                                                                <label class="card-radio">
                                                                    <input type="radio" data-year_id="{{$childObj->year_id}}" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_users][]"
                                                                            value="{{$childObj->id}}" class="assignment-user-class" {{$selected_child}}>
                                                                    <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                         <img src="{{ $childObj->getAvatar() }}">
                                                                            <h3>{{$childObj->get_full_name()}}</h3>
                                                                       </div>
                                                                  </span>
                                                                </label>
                                                                @endforeach
                                                        @endif
                                                        <input type="hidden" class="year_id_field" name="ajax[{{ !empty($quiz) ? $quiz->id : 'new' }}][year_id]" value="0">
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        

                                        <div class="years-group populated-data">
                                        <div class="form-group">
                                            <div class="form-section">
                                                <h2 class="section-title">Select Type</h2>
                                            </div>

                                            
                                            <div class="radio-buttons">
                                                <label class="card-radio">
                                                    <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type_check]"
                                                           class="assignment_type_check" value="practice_test" checked>
                                                    <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Set Practice</h3>
                                                               </div>

                                                          </span>
                                                </label>
                                                <label class="card-radio">
                                                    <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type_check]"
                                                           class="assignment_type_check" value="mock_test">
                                                    <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Set Mock Test</h3>
                                                               </div>

                                                          </span>
                                                </label>
                                            </div>

                                        </div>
                                        </div>


                                        @if( !empty($categories ))

                                        <div class="years-group populated-data">
                                            <div class="form-section">
                                                <h2 class="section-title">Select Practice Type</h2>
                                            </div>
                                            <div class="form-group">


                                                <div class="input-group">

                                                    <div class="radio-buttons">
                                                        <label class="card-radio assignment_type_check_fields practice_test_fields">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="practice">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                 <img src="/assets/default/img/assignment-logo/practice.png">
                                                                    <h3>Courses</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                        <label class="card-radio assignment_type_check_fields mock_test_fields">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="sats">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/sats.png">
                                                                    <h3>SATs</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                        <label class="card-radio assignment_type_check_fields mock_test_fields">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="11plus">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/11plus.png">
                                                                    <h3>11 Plus</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                        <label class="card-radio assignment_type_check_fields mock_test_fields">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="independent_exams">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/independent-exams.png">
                                                                    <h3>Independent Exams</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio assignment_type_check_fields mock_test_fields">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="iseb">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/iseb.png">
                                                                    <h3>ISEB</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio assignment_type_check_fields mock_test_fields">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="cat4">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/cat4.png">
                                                                    <h3>CAT 4</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio assignment_type_check_fields practice_test_fields">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_topic_type]"
                                                                   class="assignment_topic_type_check" value="vocabulary">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/vocabulary.png">
                                                                    <h3>Vocabulary</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio assignment_type_check_fields practice_test_fields">
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
                                                <h2 class="section-title">Select a Subject</h2>
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

                                            <div class="form-section assignment_topic_type_fields assignment_fields">
                                                <h2 class="section-title">Custom Assignment</h2>
                                            </div>



                                            <div class="practice-quiz-ajax-fields "></div>


                                            <div class="assignment_topic_type_fields 11plus_fields independent_exams_fields iseb_fields cat4_fields">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="input-label d-block">Year Group</label>
                                                            <select name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][year_group]"
                                                                    class="form-control select2 bg-white" data-placeholder="Select Year Group">
                                                                <option value="">Select Year Group</option>
                                                                <option value="All">All</option>
                                                                <option value="Year 3" selected>Year 3</option>
                                                                <option value="Year 4">Year 4</option>
                                                                <option value="Year 5">Year 5</option>
                                                                <option value="Year 6">Year 6</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="input-label">Test Type</label>
                                                            <div class="input-group">
                                                                <div class="radio-buttons">

                                                                    <label class="card-radio">
                                                                        <input type="radio" name="ajax[new][subject]" value="English">
                                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                                            <div class="card-icon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="96.000000pt" height="152.000000pt" viewBox="0 0 96.000000 152.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,152.000000) scale(0.100000,-0.100000)" fill="#fff" stroke="none"><path d="M64 1491 c-17 -11 -36 -34 -43 -52 -8 -22 -11 -190 -11 -546 0 -581 -1 -571 72 -602 l37 -16 3 -133 3 -134 66 61 67 61 63 -57 64 -57 5 130 5 129 278 3 277 2 0 510 0 510 -420 0 -420 0 -32 29 c-43 38 -45 92 -4 127 l27 24 365 0 c317 0 364 2 364 15 0 13 -47 15 -367 15 -344 0 -370 -1 -399 -19z m326 -416 l0 -195 -170 0 -170 0 0 25 c0 14 5 25 12 25 9 0 9 3 0 12 -7 7 -12 18 -12 26 0 11 8 9 36 -7 26 -15 52 -21 97 -21 l62 0 -85 50 c-47 27 -91 52 -98 57 -8 5 -12 21 -10 39 l3 32 130 -74 c72 -40 133 -73 138 -74 4 0 7 68 7 150 l0 150 30 0 30 0 0 -195z m220 45 c0 -82 3 -150 8 -150 4 0 70 36 147 80 107 61 141 76 143 64 5 -19 20 -9 -138 -98 l-135 -76 60 0 c53 0 69 6 138 44 l77 45 0 -40 c0 -24 -5 -39 -12 -40 -10 0 -10 -2 0 -6 6 -2 12 -18 12 -34 l0 -29 -180 0 -180 0 0 188 c0 104 3 192 7 195 3 4 17 7 30 7 l23 0 0 -150z m-222 -607 l2 -203 -30 0 -30 0 -2 159 -3 159 -125 -70 c-149 -84 -150 -84 -150 -66 0 8 58 48 129 89 l130 74 -55 3 c-48 3 -63 -2 -129 -38 l-75 -41 0 35 c0 22 5 36 13 37 9 0 9 2 0 6 -7 2 -13 15 -13 28 0 29 23 32 210 31 l125 -1 3 -202z m522 176 c0 -21 -5 -29 -17 -29 -17 -1 -17 -1 0 -14 9 -7 17 -21 17 -30 0 -13 -10 -11 -54 14 -45 26 -64 31 -108 28 l-53 -3 107 -60 c106 -59 107 -61 108 -97 l0 -36 -147 83 -148 84 -3 -160 -3 -160 -27 3 -27 3 -3 190 c-1 104 0 195 3 203 4 10 43 12 180 12 l175 -2 0 -29z m-557 -491 c-3 -46 -7 -85 -9 -87 -2 -2 -22 13 -44 33 l-41 37 -40 -35 c-21 -20 -44 -36 -49 -36 -6 0 -10 35 -10 85 l0 85 100 0 99 0 -6 -82z"></path><path d="M120 1425 c0 -13 44 -15 335 -15 291 0 335 2 335 15 0 13 -44 15 -335 15 -291 0 -335 -2 -335 -15z"></path><path d="M140 1355 c0 -13 45 -15 345 -15 300 0 345 2 345 15 0 13 -45 15 -345 15 -300 0 -345 -2 -345 -15z"></path></g></svg>
                                                                                <h3>English</h3>
                                                                            </div>

                                                                        </span>
                                                                    </label>
                                                                    <label class="card-radio">
                                                                        <input type="radio" name="ajax[new][subject]" value="Math">
                                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                                            <div class="card-icon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 191.836 191.836" xml:space="preserve" style=""><path d="M70.806,0.975H17.313C7.767,0.975,0,8.741,0,18.288V71.78c0,9.547,7.767,17.314,17.313,17.314h53.492  c9.547,0,17.313-7.767,17.313-17.314V18.288C88.119,8.741,80.353,0.975,70.806,0.975z M61.365,50.034H49.06v12.305  c0,2.761-2.239,5-5,5s-5-2.239-5-5V50.034H26.754c-2.761,0-5-2.239-5-5s2.239-5,5-5H39.06V27.729c0-2.761,2.239-5,5-5s5,2.239,5,5  v12.305h12.305c2.761,0,5,2.239,5,5S64.126,50.034,61.365,50.034z M70.806,102.742H17.313C7.767,102.742,0,110.509,0,120.056v53.492  c0,9.547,7.767,17.314,17.313,17.314h53.492c9.547,0,17.313-7.767,17.313-17.314v-53.492  C88.119,110.509,80.353,102.742,70.806,102.742z M61.365,151.802h-34.61c-2.761,0-5-2.239-5-5s2.239-5,5-5h34.61  c2.761,0,5,2.239,5,5S64.126,151.802,61.365,151.802z M174.523,0.975H121.03c-9.547,0-17.313,7.767-17.313,17.313V71.78  c0,9.547,7.767,17.314,17.313,17.314h53.492c9.547,0,17.313-7.767,17.313-17.314V18.288C191.836,8.741,184.069,0.975,174.523,0.975z   M163.548,53.735c1.953,1.953,1.953,5.119,0,7.071c-0.977,0.976-2.256,1.464-3.536,1.464s-2.559-0.488-3.536-1.464l-8.701-8.701  l-8.701,8.701c-0.977,0.976-2.256,1.464-3.536,1.464s-2.559-0.488-3.536-1.464c-1.953-1.953-1.953-5.119,0-7.071l8.701-8.701  l-8.701-8.701c-1.953-1.953-1.953-5.119,0-7.071c1.953-1.952,5.118-1.952,7.071,0l8.701,8.701l8.701-8.701  c1.953-1.952,5.118-1.952,7.071,0c1.953,1.953,1.953,5.119,0,7.071l-8.701,8.701L163.548,53.735z M174.523,102.742H121.03  c-9.547,0-17.313,7.767-17.313,17.314v53.492c0,9.547,7.767,17.314,17.313,17.314h53.492c9.547,0,17.313-7.767,17.313-17.314  v-53.492C191.836,110.509,184.069,102.742,174.523,102.742z M147.776,123.906c2.807,0,5.083,2.276,5.083,5.083  c0,2.808-2.276,5.083-5.083,5.083c-2.807,0-5.083-2.276-5.083-5.083C142.693,126.182,144.969,123.906,147.776,123.906z   M147.776,169.697c-2.807,0-5.083-2.276-5.083-5.083c0-2.807,2.276-5.083,5.083-5.083c2.807,0,5.083,2.276,5.083,5.083  C152.86,167.422,150.584,169.697,147.776,169.697z M165.082,151.802h-34.61c-2.761,0-5-2.239-5-5s2.239-5,5-5h34.61  c2.761,0,5,2.239,5,5S167.843,151.802,165.082,151.802z"></path></svg>
                                                                                <h3>Math</h3>
                                                                            </div>

                                                                        </span>
                                                                    </label>
                                                                    <label class="card-radio">
                                                                        <input type="radio" name="ajax[new][subject]" value="Non-Verbal Reasoning">
                                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                                            <div class="card-icon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="96.000000pt" height="152.000000pt" viewBox="0 0 96.000000 152.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,152.000000) scale(0.100000,-0.100000)" fill="#fff" stroke="none"><path d="M64 1491 c-17 -11 -36 -34 -43 -52 -8 -22 -11 -190 -11 -546 0 -581 -1 -571 72 -602 l37 -16 3 -133 3 -134 66 61 67 61 63 -57 64 -57 5 130 5 129 278 3 277 2 0 510 0 510 -420 0 -420 0 -32 29 c-43 38 -45 92 -4 127 l27 24 365 0 c317 0 364 2 364 15 0 13 -47 15 -367 15 -344 0 -370 -1 -399 -19z m326 -416 l0 -195 -170 0 -170 0 0 25 c0 14 5 25 12 25 9 0 9 3 0 12 -7 7 -12 18 -12 26 0 11 8 9 36 -7 26 -15 52 -21 97 -21 l62 0 -85 50 c-47 27 -91 52 -98 57 -8 5 -12 21 -10 39 l3 32 130 -74 c72 -40 133 -73 138 -74 4 0 7 68 7 150 l0 150 30 0 30 0 0 -195z m220 45 c0 -82 3 -150 8 -150 4 0 70 36 147 80 107 61 141 76 143 64 5 -19 20 -9 -138 -98 l-135 -76 60 0 c53 0 69 6 138 44 l77 45 0 -40 c0 -24 -5 -39 -12 -40 -10 0 -10 -2 0 -6 6 -2 12 -18 12 -34 l0 -29 -180 0 -180 0 0 188 c0 104 3 192 7 195 3 4 17 7 30 7 l23 0 0 -150z m-222 -607 l2 -203 -30 0 -30 0 -2 159 -3 159 -125 -70 c-149 -84 -150 -84 -150 -66 0 8 58 48 129 89 l130 74 -55 3 c-48 3 -63 -2 -129 -38 l-75 -41 0 35 c0 22 5 36 13 37 9 0 9 2 0 6 -7 2 -13 15 -13 28 0 29 23 32 210 31 l125 -1 3 -202z m522 176 c0 -21 -5 -29 -17 -29 -17 -1 -17 -1 0 -14 9 -7 17 -21 17 -30 0 -13 -10 -11 -54 14 -45 26 -64 31 -108 28 l-53 -3 107 -60 c106 -59 107 -61 108 -97 l0 -36 -147 83 -148 84 -3 -160 -3 -160 -27 3 -27 3 -3 190 c-1 104 0 195 3 203 4 10 43 12 180 12 l175 -2 0 -29z m-557 -491 c-3 -46 -7 -85 -9 -87 -2 -2 -22 13 -44 33 l-41 37 -40 -35 c-21 -20 -44 -36 -49 -36 -6 0 -10 35 -10 85 l0 85 100 0 99 0 -6 -82z"></path><path d="M120 1425 c0 -13 44 -15 335 -15 291 0 335 2 335 15 0 13 -44 15 -335 15 -291 0 -335 -2 -335 -15z"></path><path d="M140 1355 c0 -13 45 -15 345 -15 300 0 345 2 345 15 0 13 -45 15 -345 15 -300 0 -345 -2 -345 -15z"></path></g></svg>
                                                                                <h3>Non-Verbal Reasoning</h3>
                                                                            </div>

                                                                        </span>
                                                                    </label>
                                                                    <label class="card-radio">
                                                                        <input type="radio" name="ajax[new][subject]" value="Verbal Reasoning">
                                                                        <span class="radio-btn"><i class="las la-check"></i>
                                                                            <div class="card-icon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="96.000000pt" height="152.000000pt" viewBox="0 0 96.000000 152.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,152.000000) scale(0.100000,-0.100000)" fill="#fff" stroke="none"><path d="M64 1491 c-17 -11 -36 -34 -43 -52 -8 -22 -11 -190 -11 -546 0 -581 -1 -571 72 -602 l37 -16 3 -133 3 -134 66 61 67 61 63 -57 64 -57 5 130 5 129 278 3 277 2 0 510 0 510 -420 0 -420 0 -32 29 c-43 38 -45 92 -4 127 l27 24 365 0 c317 0 364 2 364 15 0 13 -47 15 -367 15 -344 0 -370 -1 -399 -19z m326 -416 l0 -195 -170 0 -170 0 0 25 c0 14 5 25 12 25 9 0 9 3 0 12 -7 7 -12 18 -12 26 0 11 8 9 36 -7 26 -15 52 -21 97 -21 l62 0 -85 50 c-47 27 -91 52 -98 57 -8 5 -12 21 -10 39 l3 32 130 -74 c72 -40 133 -73 138 -74 4 0 7 68 7 150 l0 150 30 0 30 0 0 -195z m220 45 c0 -82 3 -150 8 -150 4 0 70 36 147 80 107 61 141 76 143 64 5 -19 20 -9 -138 -98 l-135 -76 60 0 c53 0 69 6 138 44 l77 45 0 -40 c0 -24 -5 -39 -12 -40 -10 0 -10 -2 0 -6 6 -2 12 -18 12 -34 l0 -29 -180 0 -180 0 0 188 c0 104 3 192 7 195 3 4 17 7 30 7 l23 0 0 -150z m-222 -607 l2 -203 -30 0 -30 0 -2 159 -3 159 -125 -70 c-149 -84 -150 -84 -150 -66 0 8 58 48 129 89 l130 74 -55 3 c-48 3 -63 -2 -129 -38 l-75 -41 0 35 c0 22 5 36 13 37 9 0 9 2 0 6 -7 2 -13 15 -13 28 0 29 23 32 210 31 l125 -1 3 -202z m522 176 c0 -21 -5 -29 -17 -29 -17 -1 -17 -1 0 -14 9 -7 17 -21 17 -30 0 -13 -10 -11 -54 14 -45 26 -64 31 -108 28 l-53 -3 107 -60 c106 -59 107 -61 108 -97 l0 -36 -147 83 -148 84 -3 -160 -3 -160 -27 3 -27 3 -3 190 c-1 104 0 195 3 203 4 10 43 12 180 12 l175 -2 0 -29z m-557 -491 c-3 -46 -7 -85 -9 -87 -2 -2 -22 13 -44 33 l-41 37 -40 -35 c-21 -20 -44 -36 -49 -36 -6 0 -10 35 -10 85 l0 85 100 0 99 0 -6 -82z"></path><path d="M120 1425 c0 -13 44 -15 335 -15 291 0 335 2 335 15 0 13 -44 15 -335 15 -291 0 -335 -2 -335 -15z"></path><path d="M140 1355 c0 -13 45 -15 345 -15 300 0 345 2 345 15 0 13 -45 15 -345 15 -300 0 -345 -2 -345 -15z"></path></g></svg>
                                                                                <h3>Verbal Reasoning</h3>
                                                                            </div>

                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-4">
                                                    <div class="form-group">
                                                        <label class="input-label">Practice Title</label>
                                                        <input type="text"
                                                               name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][title]"
                                                               value="{{ !empty($assignment) ? $assignment->title : old('title') }}"
                                                               class="js-ajax-title form-control rurera-req-field bg-white"
                                                               placeholder=""/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-4">
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
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-4">
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

                                            </div>



                                            <div class="form-group assignment_topic_type_fields timestables_fields">
                                                <label class="input-label">Duration Type</label>

                                                <div class="years-group populated-data input-group">


                                                    <div class="radio-buttons">
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


                                        <div class="form-group">
                                            <label class="input-label">Practice Method</label>
                                            <div class="plan-switch-option" style="justify-content: left;">
                                                    <span class="switch-label font-18">Completion Target</span> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <div class="plan-switch">
                                                        <div class="custom-control custom-switch"><input type="checkbox" name="auto_generate" class="assignment_method_check custom-control-input" id="method_check" value="target_improvements"><label class="custom-control-label" for="method_check"></label></div>
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
<script src="/assets/admin/vendor/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">

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
            slider_fields_refresh();
            var year_id = $(".year_id_field").val();
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
                data: {"quiz_type": quiz_type, "year_id": year_id, "is_frontend": 'yes'},
                success: function (return_data) {
                    if (quiz_type == 'practice') {
                        $(".practice-quiz-ajax-fields").html(return_data);
                    } else {
                        //$(".quiz-ajax-fields").html(return_data);
                        $(".practice-quiz-ajax-fields").html(return_data);
                    }
                    rurera_remove_loader(thisObj, 'button');
                }
            });


        });

        $('body').on('change', '.assignment_method_check', function (e) {
            var current_value = $('.assignment_method_check:checked').val();
            console.log(current_value);
            $(".assignment_method_check_fields").addClass('rurera-hide');
            $('.assignment_method_check_fields.' + current_value + '_fields').removeClass('rurera-hide');
        });
        $('body').on('change', '.assignment_type_check', function (e) {
            var current_value = $(this).val();
            $(".assignment_type_check_fields").addClass('rurera-hide');
            $('.assignment_type_check_fields.' + current_value + '_fields').removeClass('rurera-hide');
        });



        $('body').on('change', '.year_quiz_ajax_select12', function (e) {
            var year_id = $(this).val();
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
                    rurera_remove_loader(thisObj, 'button');
                }
            });
        });

        $('body').on('change', '.year_group_quiz_ajax_select', function (e) {
            var year_group = $(this).val();
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
            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            //$( ".no_of_questions" ).val( $( "#slider-range-max" ).slider( "value" ) );
            $(".no_of_questions").val(0);
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
        $(".duration_conditional_check:checked").change();
        $(".assignment_topic_type_fields").addClass('rurera-hide');
        $(".assignment_method_check_fields").addClass('rurera-hide');

        $(".assignment_topic_type_check:checked").change();
        $(".assignment_method_check:checked").change();
        $(".assignment_type_check:checked").change();
        $(".year_quiz_ajax_select").change();
        $(".year_group_quiz_ajax_select").change();



        $('body').on('change', '.assignment-user-class', function (e) {
            var year_id = $(this).attr('data-year_id');
            $(".year_id_field").val(year_id);

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

    });

</script>
@endpush

