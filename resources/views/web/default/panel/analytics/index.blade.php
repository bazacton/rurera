@extends('web.default.panel.layouts.panel_layout')
@push('styles_top')
<script src="/assets/default/vendors/charts/chart.js"></script>
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style>
    .hide {
        display: none !important;
    }
</style>
@endpush

@section('content')
<section class="page-section analytics-graph-data hide">
    @include('web.default.panel.analytics.graph_data',['show_types'=> true, 'graphs_array' => $graphs_array,
    'summary_type' => $summary_type,
    'QuestionsAttemptController'=> $QuestionsAttemptController])
</section>
<section>


    <div class="activities-container mt-10 p-20 p-lg-35 ">
        <div class="chart-filters p-0">
            <ul class="analytics-type">
                <li><a href="javascript:;" data-graph_type="learn"><img src="/assets/default/img/sidebar/learn.png"> LEARN</a></li>
                <li><a href="javascript:;" data-graph_type="timestables"><img src="/assets/default/img/sidebar/timestable.png"> TIMESTABLE</a></li>
                <li><a href="javascript:;" data-graph_type="word_lists"><img src="/assets/default/img/sidebar/spell.png"> WORD LISTS</a></li>
                <li><a href="javascript:;" data-graph_type="books"><img src="/assets/default/img/sidebar/books.png"> BOOKS</a></li>
                <li><a href="javascript:;" data-graph_type="tests"><img src="/assets/default/img/sidebar/test.png"> TEST</a></li>
            </ul>
            <h3 class="font-22">Analytics</h3>
            <ul class="analytics-data-ul">
                <li><a href="javascript:;" class=" graph_Custom" data-graph_id="graph_id_Custom">September 20, 2023 -
                        September 26, 2023</a>
                </li>

            </ul>



        </div>

        <div class="time-card panel-border panel-shadow mb-30">
            <div class="card-header">
                <h3 class="font-19 font-weight-bold">
                    What’s up Today
                    <span>Total 424,567 deliveries</span>
                </h3>
                <div class="card-toolbar">
                    <a href="#">Report Cecnter</a>
                </div>
            </div>
            <div class="card-body">
                <div class="time-nav">
                    <ul>
                        <li>
                            <a href="#">
                                <span>Jan</span>
                                <em>12</em>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Feb</span>
                                <em>22</em>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>March</span>
                                <em>20</em>
                            </a>
                        </li>
                        <li>
                            <a class="active" href="#">
                                <span>April</span>
                                <em>27</em>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>May</span>
                                <em>9</em>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>June</span>
                                <em>17</em>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>July</span>
                                <em>11</em>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Aug</span>
                                <em>6</em>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Sep</span>
                                <em>10</em>
                            </a>                    
                        </li>
                    </ul>
                </div>
                <div class="time-info-list">
                    <ul>
                        <li>
                            <div class="infobox">
                                <strong>
                                    <span>10:20</span> - <span>11:00</span> <em>Am</em>
                                </strong>
                                <p>9 Degree Project Estimation Meeting</p>
                                <a href="#"><span>Lead by</span> Peter Marcus</a>
                            </div>
                            <a href="#" class="view-btn">View</a>
                        </li>
                        <li class="warning-info">
                            <div class="infobox">
                                <strong>
                                    <span>16:30</span> - <span>17:00</span> <em>Pm</em>
                                </strong>
                                <p>Dashboard UI/UX Design Review</p>
                                <a href="#"><span>Lead by</span> Lead by Bob</a>
                            </div>
                            <a href="#" class="view-btn">View</a>
                        </li>
                        <li class="success-info">
                            <div class="infobox">
                                <strong>
                                    <span>12:00</span> - <span>13:40</span> <em>Am</em>
                                </strong>
                                <p>Marketing Campaign Discussion</p>
                                <a href="#"><span>Lead by</span> Lead by Mark Morris</a>
                            </div>
                            <a href="#" class="view-btn">View</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="accordion" id="analyticsAccordion">

            @if( !empty( $analytics_data) )
            @foreach( $analytics_data as $date_str => $analyticDataArray)
            @php $report_date = strtotime(str_replace('_', '-', $date_str)); @endphp
            <div class="card">
                <div class="card-header collapsed mb-0" id="headingOne" type="button" data-toggle="collapse"
                     data-target="#report_{{$date_str}}" aria-expanded="true" aria-controls="report_{{$date_str}}">
                    <span>{{ dateTimeFormat($report_date,'d F Y') }}</span>

                </div>

                <div id="report_{{$date_str}}" class="collapse" aria-labelledby="headingOne"
                     data-parent="#analyticsAccordion">
                    <div class="card-body">
                        <ul class="timeline-list">

                        @if( !empty( $analyticDataArray['data'] ) )
                        @foreach( $analyticDataArray['data'] as $attempt_id => $analyticData)
                        @php $parent_type_id = isset( $analyticData['parent_type_id'] )? $analyticData['parent_type_id']
                        : '';
                        $parent_type = isset( $analyticData['parent_type'] )? $analyticData['parent_type'] : '';
                        $result_id = isset( $analyticData['result_id'] )? $analyticData['result_id'] : 0;
                        $start_time = isset( $analyticData['start_time'] )? $analyticData['start_time'] : 0;
                        $more_than_minute = isset( $analyticData['more_than_minute'] )? $analyticData['more_than_minute'] : 'yes';
                        $end_time = isset( $analyticData['end_time'] )? $analyticData['end_time'] : 0;
                        $type = isset( $analyticData['type'] )? $analyticData['type'] : '';


                        $detail_link = '';
                        if( $parent_type == 'practice' || $parent_type == 'sats' || $parent_type == '11plus' || $parent_type == 'assessment' || $parent_type == 'book_page' || $parent_type == 'vocabulary' || $parent_type == 'assignment'){
                            $detail_link = '/panel/quizzes/'.$result_id.'/check_answers';
                        }
                        if( $parent_type == 'timestables' || $parent_type == 'timestables_assignment'){
                            $detail_link = '/panel/results/'.$result_id.'/timetables';
                        }

                        if( $parent_type == 'book_read'){
                           $book_slug = isset( $analyticData['book_slug'] )? $analyticData['book_slug'] : '';
                            $detail_link = 'books/'.$book_slug.'/activity';
                        }

                        @endphp


                                <li>
                                    <div class="timeline-icon"><img src="/assets/default/img/types/{{$parent_type}}.png" width="26" height="26" alt=""></div>
                                    <div class="timeline-text"><p><strong><a href="{{$detail_link}}">{{isset( $analyticData['topic_title'] )? $analyticData['topic_title'] : ''}}</a></strong><span class="info-time">{{ dateTimeFormat($start_time,'H:i') }}</span></p>
                                    @if( $type != 'book_read')
                                        <span class="analytic-item">Active practice: {{isset( $analyticData['practice_time'] )? $analyticData['practice_time'] : 0}} min</span>
                                        <span class="analytic-item">Questions answered: {{isset( $analyticData['question_answered'] )? $analyticData['question_answered'] : 0}}</span>
                                        <span class="analytic-item">Coins earned: {{isset( $analyticData['coins_earned'] )? $analyticData['coins_earned'] : 0}}</span>

                                        @else
                                        <span class="analytic-item">Reading Time: {{isset( $analyticData['read_time'] )? $analyticData['read_time'] : 0}} min</span>
                                        <span class="analytic-item">Pages Read: {{isset( $analyticData['pages_read'] )? $analyticData['pages_read'] : ''}}</span>
                                        <span class="analytic-item">&nbsp;</span>
                                        <span class="analytic-item">&nbsp;</span>
                                    @endif
                                    <span class="analytics-more_details"><a href="{{$detail_link}}">More Details</a></span>
                                    </div>
                                </li>


                        @endforeach
                        @endif

                        </ul>

                    </div>
                </div>
            </div>
            @endforeach

            @endif

        </div>


    </div>
</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.graph-data-ul li a', function (e) {
            var thisObj = $('.chart-summary-fields');
            var graph_type = $(this).attr('data-graph_type');
            if (!FieldIsEmpty(graph_type)) {
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/panel/analytics/graph_data',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"graph_type": graph_type, "show_types": true},
                    success: function (return_data) {
                        rurera_remove_loader(thisObj, 'div');
                        if (return_data != '') {
                            $(".analytics-graph-data").html(return_data);
                        }
                    }
                });
            } else {
                $('.graph-data-ul li a').removeClass('active');
                $(this).addClass('active');
                var graph_id = $(this).attr('data-graph_id');
                $('.graph_div').addClass('hide');
                $('.' + graph_id).removeClass('hide');
            }
        });

    });

</script>

@endpush
