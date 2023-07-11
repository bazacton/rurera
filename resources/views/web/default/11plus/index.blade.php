@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="content-section">
    <section class="my-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-left mb-50">
                        <h2 class="mt-0 mb-10">11Plus Online 10-Minutes test practices</h2>
                        <p> Work through a variety of practice questions to improve your skills and become familiar with
                            the <br> types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="listing-search lms-jobs-form mb-50">
                        <form>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Product</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option selected="selected">One option selected</option>
                                                <option>Subject Matter Expert (SME)</option>
                                                <option>Online Instructor/Educator</option>
                                                <option>Curriculum Developer</option>
                                                <option>Learning Experience Designer</option>
                                                <option>Administrator</option>
                                                <option>Quality Assurance Specialist</option>
                                                <option>Marketing and Enrollment Manager</option>
                                                <option>Technical Support Specialist</option>
                                                <option>Data Analyst</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Year</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option selected="selected">All</option>
                                                <option>Subject Matter Expert (SME)</option>
                                                <option>Online Instructor/Educator</option>
                                                <option>Curriculum Developer</option>
                                                <option>Learning Experience Designer</option>
                                                <option>Administrator</option>
                                                <option>Quality Assurance Specialist</option>
                                                <option>Marketing and Enrollment Manager</option>
                                                <option>Technical Support Specialist</option>
                                                <option>Data Analyst</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Pack type</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option selected="selected">All</option>
                                                <option>Subject Matter Expert (SME)</option>
                                                <option>Online Instructor/Educator</option>
                                                <option>Curriculum Developer</option>
                                                <option>Learning Experience Designer</option>
                                                <option>Administrator</option>
                                                <option>Quality Assurance Specialist</option>
                                                <option>Marketing and Enrollment Manager</option>
                                                <option>Technical Support Specialist</option>
                                                <option>Data Analyst</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group mb-0">
                                        <button type="submit"
                                                class="btn-primary px-20 border-0 rounded-pill text-white text-uppercase">
                                            Filter
                                        </button>
                                        <a href="#" class="clear-btn ml-10 text-uppercase text-primary">Clear
                                            Filters</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                @if( !empty( $data))
                <div class="col-12">
                    <section class="lms-data-table my-80 elevenplus-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped table-bordered dataTable" style="width: 100%;"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">Title
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Percent: activate to sort column ascending">
                                                Total Questions
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">Attempts
                                            </th>

                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Percent: activate to sort column ascending">
                                                Questions Attempted
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1"
                                                aria-label="Percent: activate to sort column ascending">Average Score %
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach( $data as $dataObj)
                                        @php $resultData = $QuestionsAttemptController->get_result_data($dataObj->id);
                                        $total_attempts = $total_questions_attempt = $correct_questions =
                                        $incorrect_questions = 0;
                                        $total_questions = isset( $dataObj->quizQuestionsList )? count( $dataObj->quizQuestionsList) : 0;

                                        $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
                                        $is_passed = isset( $resultData->is_passed )? $resultData->is_passed : false;
                                        $in_progress = isset( $resultData->in_progress )? $resultData->in_progress :
                                        false;
                                        $current_status = isset( $resultData->current_status )?
                                        $resultData->current_status
                                        : '';
                                        $button_label = ($in_progress == true)? 'Resume' :'Practice Now';
                                        $button_label = ($is_passed == true) ? 'Practice Again' : $button_label;

                                        @endphp


                                        @if( !empty( $resultData ) )

                                        @php $attempt_count = 1; @endphp
                                        @foreach( $resultData as $resultObj)


                                        @php
                                        $total_questions_attempt += $resultObj->attempted;
                                        $correct_questions += $resultObj->correct;
                                        $incorrect_questions += $resultObj->incorrect;
                                        $total_attempts++;


                                        @endphp


                                        @php $attempt_count++; @endphp
                                        @endforeach

                                        @endif

                                        @php
                                        $total_percentage = 0;
                                        if( $total_questions_attempt > 0 && $correct_questions > 0){
                                        $total_percentage = ($correct_questions * 100) / $total_questions_attempt;
                                        }
                                        @endphp

                                        <tr class="odd">
                                            <td><a href="/11plus/{{$dataObj->id}}/start">{{$dataObj->getTitleAttribute()}}</a>
                                            </td>
                                            <td>{{$total_questions}}</td>
                                            <td>{{$total_attempts}}</td>
                                            <td>{{$total_questions_attempt}}</td>
                                            <td>
                                                <div class="attempt-progress">
                                                    <span class="progress-number">{{round($total_percentage, 2)}}%</span>
                                                    <span class="progress-holder">
                                                  <span class="progressbar"
                                                        style="width: {{$total_percentage}}%;"></span>
                                              </span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                @endif

            </div>
        </div>
    </section>

    <a href="#" class="scroll-btn" style="display: block;">
        <div class="round">
            <div id="cta"><span class="arrow primera next"></span> <span class="arrow segunda next"></span></div>
        </div>
    </a>

</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
@endpush
