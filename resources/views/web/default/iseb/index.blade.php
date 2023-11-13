@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<script src="/assets/default/vendors/charts/chart.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style>
    .hide {
        display: none !important;
    }
</style>
@endpush

@section('content')

<section class="content-section">
    <section class="pt-80" style="background-color: var(--panel-bg);">
        <div class="container">
            <div class="row pt-80">

                <div class="col-12">
                    <div class="section-title text-left mb-50">
                        <h2 class="mt-0 mb-10 testing222">ISEB Online 10-Minutes test practices</h2>
                        <p> Work through a variety of practice questions to improve your skills and become familiar with
                            the <br> types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="listing-search lms-jobs-form mb-20">
                        <form>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Year Group</label>
                                        <div class="input-field select-arrow">
                                            <select name="year_group" class="lms-jobs-select">
                                                <
                                                <option value="All">All</option>
                                                <option value="Year 3" @if(request()->get('year_group') == 'Year 3')
                                                    selected @endif>Year 3
                                                </option>
                                                <option value="Year 4" @if(request()->get('year_group') == 'Year 4')
                                                    selected @endif>Year 4
                                                </option>
                                                <option value="Year 5" @if(request()->get('year_group') == 'Year 5')
                                                    selected @endif>Year 5
                                                </option>
                                                <option value="Year 6" @if(request()->get('year_group') == 'Year 6')
                                                    selected @endif>Year 6
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Subject</label>
                                        <div class="input-field select-arrow">
                                            <select name="subject" class="lms-jobs-select">
                                                <option value="All">All</option>
                                                <option value="Math" @if(request()->get('subject') == 'Math') selected
                                                    @endif>Math
                                                </option>
                                                <option value="Non-Verbal Reasoning" @if(request()->get('subject') ==
                                                    'Non-Verbal Reasoning') selected @endif>Non-Verbal Reasoning
                                                </option>
                                                <option value="Verbal Reasoning" @if(request()->get('subject') ==
                                                    'Verbal Reasoning') selected @endif>Verbal Reasoning
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Exam Board</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select" name="examp_board">
                                                <option value="All">All</option>
                                                <option value="GL" @if(request()->get('examp_board') == 'GL') selected
                                                    @endif>GL
                                                </option>
                                                <option value="CEM" @if(request()->get('examp_board') == 'CEM') selected
                                                    @endif>CEM
                                                </option>
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
                    <section class="lms-data-table my-30 elevenplus-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped simple-table table-bordered dataTable" style="width: 100%;"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr>

                                            <th>&nbsp;</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">Title
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">&nbsp;
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">Attempts
                                            </th>

                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1"
                                                aria-label="Percent: activate to sort column ascending">Average Score %
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @php $counter = 0; @endphp
                                        @foreach( $data as $dataObj)
                                        @php $resultData = $QuestionsAttemptController->get_result_data($dataObj->id);
                                        $counter++;
                                        $lock_image = ($counter > 2)? 'lock.svg' : 'unlock.svg';
                                        $lock_unlock_class = ($counter > 2)? 'rurera-lock-item' : 'rurera-unlock-item';
                                        $total_attempts = $total_questions_attempt = $correct_questions =
                                        $incorrect_questions = 0;
                                        $total_questions = isset( $dataObj->quizQuestionsList )? count(
                                        $dataObj->quizQuestionsList) : 0;

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
                                            <td class="{{$lock_unlock_class}}">
                                                <img src="/assets/default/img/{{$lock_image}}">
                                            </td>
                                            <td>

                                                <a href="/iseb/{{$dataObj->quiz_slug}}">{{$dataObj->getTitleAttribute()}}</a>
                                                <br> <span class="sub_label">{{$total_questions}} Question(s)</span>
                                                {{ user_assign_topic_template($dataObj->id, 'iseb', $childs, $parent_assigned_list)}}
                                            </td>
                                            <td>
                                                @if( $dataObj->examp_board != '' && $dataObj->examp_board != 'All')
                                                <img src="/assets/default/img/{{$dataObj->examp_board}}.jpeg">
                                                @endif
                                            </td>
                                            <td>{{$total_attempts}}</td>
                                            <td>
                                                <div class="attempt-progress">
                                                    <span class="progress-number">{{round($total_percentage, 2)}}%</span>
                                                    <span class="progress-holder">
                                                  <span class="progressbar"
                                                        style="width: {{$total_percentage}}%;"></span>
                                              </span>
                                                </div>
                                                {{ user_assign_topic_template($dataObj->id, 'iseb', $childs, $parent_assigned_list) }}
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
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.graph-data-ul li a', function (e) {
            $('.graph-data-ul li a').removeClass('active');
            $(this).addClass('active');
            var graph_id = $(this).attr('data-graph_id');
            $('.graph_div').addClass('hide');
            $('.' + graph_id).removeClass('hide');
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.graph-data-ul li a', function (e) {
            $('.graph-data-ul li a').removeClass('active');
            $(this).addClass('active');
            var graph_id = $(this).attr('data-graph_id');
            $('.graph_div').addClass('hide');
            $('.' + graph_id).removeClass('hide');
        });

        $('body').on('change', '.analytics_graph_type', function (e) {
            var thisObj = $('.chart-summary-fields');
            rurera_loader(thisObj, 'div');
            var graph_type = $(this).val();
            jQuery.ajax({
                type: "GET",
                url: '/panel/analytics/graph_data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"graph_type": graph_type},
                success: function (return_data) {
                    rurera_remove_loader(thisObj, 'div');
                    if (return_data != '') {
                        $(".analytics-graph-data").html(return_data);
                    }
                }
            });

        });




    });

</script>
@endpush
