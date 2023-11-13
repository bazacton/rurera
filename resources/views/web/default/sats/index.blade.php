@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<script src="/assets/default/vendors/charts/chart.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<style>
    .hide {
        display: none !important;
    }
</style>
@endpush

@section('content')
<section class="content-section">

    <section class="pt-80">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="section-title text-left mb-50">
                        <h2 class="mt-0 mb-10">KS2 SATs Online 10-Minutes test practices</h2>
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
                <div class="col-12 col-md-12">
                    <div class="sats-listing-card medium">
                        <table class="simple-table">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Title</th>
                                <th>Attempts</th>
                                <th>Last attempt</th>
                                <th>Accuracy</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty( $sats))
                            @php $counter = 0; @endphp
                            @foreach( $sats as $satObj)
                            @php $resultData = $QuestionsAttemptController->get_result_data($satObj->id);
                            $counter++;
                            $lock_image = ($counter > 2)? 'lock.svg' : 'unlock.svg';
                            $lock_unlock_class = ($counter > 2)? 'rurera-lock-item' : 'rurera-unlock-item';

                            $is_passed = isset( $resultData->is_passed )? $resultData->is_passed : false;
                            $in_progress = isset( $resultData->in_progress )? $resultData->in_progress : false;
                            $current_status = isset( $resultData->current_status )? $resultData->current_status : '';
                            $button_label = ($in_progress == true)? 'Resume' :'Practice Now';
                            $button_label = ($is_passed == true) ? 'Practice Again' : $button_label;

                            @endphp
                            <tr>
                                <td class="{{$lock_unlock_class}}">
                                    <img src="/assets/default/img/{{$lock_image}}">
                                </td>
                                <td>
                                    <img src="../assets/default/img/sats-list-img1.png" alt="">
                                    <h4><a href="/sats/{{$satObj->quiz_slug}}">{{$satObj->getTitleAttribute()}}</a>
                                        <br> <span class="sub_label">54 Question(s)</span>
                                        {{ user_assign_topic_template($satObj->id, 'sats', $childs, $parent_assigned_list)}}
                                    </h4>
                                </td>
                                <td>0</td>
                                <td>12</td>
                                <td>
                                    <div class="attempt-progress">
                                        <span class="progress-number">0%</span>
                                        <span class="progress-holder">
                                            <span class="progressbar"
                                                  style="width: 0%;"></span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-12">
                    <div class="mt-60">
                        {{ $sats->appends(request()->input())->links('vendor.pagination.panel') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
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
