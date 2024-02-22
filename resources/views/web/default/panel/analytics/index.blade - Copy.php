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


    <div class="activities-container mt-25 p-20 p-lg-35 ">
        <div class="chart-filters">
            <h3>Analytics</h3>
            <ul class="analytics-data-ul">
                <li><a href="javascript:;" class=" graph_Custom" data-graph_id="graph_id_Custom">September 20, 2023 -
                        September 26, 2023</a>
                </li>
                <li class="has-child">
                    <a href="javascript:;" class="graph_Hour" data-graph_id="graph_id_Hour">Type</a>
                    <ul class="sub-dropdown">
                        <li><a href="javascript:;" data-graph_type="11plus">11+</a></li>
                        <li><a href="javascript:;" data-graph_type="sats">Sats</a></li>
                        <li><a href="javascript:;" data-graph_type="iseb">ISEB</a></li>
                        <li><a href="javascript:;" data-graph_type="independent_exams">Independent Exams</a></li>
                        <li><a href="javascript:;" data-graph_type="timetables">Timestables</a></li>
                        <li><a href="javascript:;" data-graph_type="books">Books</a></li>

                    </ul>
                </li>
            </ul>
        </div>

        <div class="accordion" id="analyticsAccordion">

            @if( !empty( $analytics_data) )
            @foreach( $analytics_data as $date_str => $analyticDataArray)
            @php $report_date = strtotime(str_replace('_', '-', $date_str)); @endphp
            <div class="card">
                <div class="card-header collapsed mb-0" id="headingOne" type="button" data-toggle="collapse"
                     data-target="#report_{{$date_str}}" aria-expanded="true" aria-controls="report_{{$date_str}}">
                    <span>{{ dateTimeFormat($report_date,'d F Y') }}</span>
                    <span style="float:right">
                        {{isset( $analyticDataArray['data'] )? count($analyticDataArray['data']) : 0}} Skills practiced: {{isset( $analyticDataArray['question_answered'] )? $analyticDataArray['question_answered'] : 0}} questions
                    </span>
                </div>

                <div id="report_{{$date_str}}" class="collapse" aria-labelledby="headingOne"
                     data-parent="#analyticsAccordion">
                    <div class="card-body">

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

                        @endphp
                        <div class="card-header" id="headingOnes">
                            <h2 class="mb-0">
                                <a href="javascript:;" class="text-left">
                                    {{isset( $analyticData['topic_title'] )? $analyticData['topic_title'] : ''}}
                                    @if( $type != 'book_read')
                                    @if( $more_than_minute == 'yes')
                                    | <span class="start_end_time" style="font-size: 16px;">{{ dateTimeFormat($start_time,'H:i') }} - {{ dateTimeFormat($end_time,'H:i') }}</span>
                                    @else
                                    | <span class="start_end_time" style="font-size: 16px;">{{ dateTimeFormat($start_time,'H:i:s') }} - {{ dateTimeFormat($end_time,'H:i:s') }}</span>
                                    @endif
                                    @endif
                                </a>
                                @if( $parent_type == 'practice' || $parent_type == 'sats' || $parent_type == '11plus' || $parent_type == 'assessment'
                                || $parent_type == 'book_page' || $parent_type == 'vocabulary' || $parent_type == 'assignment')
                                <span style="float:right;font-size: 15px;"><a
                                            href="/panel/quizzes/{{$result_id}}/check_answers">More Details</a></span>
                                @endif
                                @if( $parent_type == 'timestables' || $parent_type == '<timest></timest>ables_assignment')
                                <span style="float:right;font-size: 15px;"><a
                                            href="/panel/results/{{$result_id}}/timetables">More Details</a></span>
                                @endif

                                @if( $parent_type == 'book_read')
                                @php $book_slug = isset( $analyticData['book_slug'] )? $analyticData['book_slug'] : '';
                                @endphp
                                <span style="float:right;font-size: 15px;"><a href="/books/{{$book_slug}}/activity">More Details</a></span>
                                @endif

                            </h2>
                        </div>
                        <div class="col-12 card-footer" id="headingOnes" style="margin-bottom:10px;">
                            <div class="row">
                                @if( $type != 'book_read')
                                <span class="col-3">Active practice: {{isset( $analyticData['practice_time'] )? $analyticData['practice_time'] : 0}} min</span>
                                <span class="col-3">Questions answered: {{isset( $analyticData['question_answered'] )? $analyticData['question_answered'] : 0}}</span>
                                <span class="col-3">Coins earned: {{isset( $analyticData['coins_earned'] )? $analyticData['coins_earned'] : 0}}</span>

                                @else
                                <span class="col-3">Reading Time: {{isset( $analyticData['read_time'] )? $analyticData['read_time'] : 0}} min</span>
                                <span class="col-3">Pages Read: {{isset( $analyticData['pages_read'] )? $analyticData['pages_read'] : ''}}</span>
                                <span class="col-3">&nbsp;</span>
                                <span class="col-3">&nbsp;</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @endif


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