@extends('web.default.panel.layouts.panel_layout')
@push('styles_top')
<script src="/assets/default/vendors/charts/chart.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style>
    .hide {
        display: none !important;
    }
</style>
@endpush

@section('content')
<section class="page-section analytics-graph-data">
@include('web.default.panel.analytics.graph_data',['graphs_array' => $graphs_array, 'summary_type' => $summary_type, 'QuestionsAttemptController'=> $QuestionsAttemptController])
</section>
<section>


    <div class="activities-container mt-25 p-20 p-lg-35">

        <h2 class="section-title">Analytics</h2><br>
        <div class="accordion" id="analyticsAccordion">

            @if( !empty( $analytics_data) )
            @foreach( $analytics_data as $date_str => $analyticDataArray)
            @php $report_date = strtotime(str_replace('_', '-', $date_str)); @endphp
            <div class="card">
                <div class="card-header collapsed mb-0" id="headingOne" type="button" data-toggle="collapse"
                     data-target="#report_{{$date_str}}" aria-expanded="true" aria-controls="report_{{$date_str}}">
                    <span>{{ dateTimeFormat($report_date,'d F Y') }}</span> |
                    <span>{{isset( $analyticDataArray['practice_time'] )? $analyticDataArray['practice_time'] : 0}} min</span>
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
                        $end_time = isset( $analyticData['end_time'] )? $analyticData['end_time'] : 0;
                        $type = isset( $analyticData['type'] )? $analyticData['type'] : '';

                        @endphp
                        <div class="card-header" id="headingOnes">
                            <h2 class="mb-0">
                                <a href="javascript:;" class="text-left">
                                    {{isset( $analyticData['topic_title'] )? $analyticData['topic_title'] : ''}}
                                    @if( $type != 'book_read')
                                    | <span class="start_end_time" style="font-size: 16px;">{{ dateTimeFormat($start_time,'H:i') }} - {{ dateTimeFormat($end_time,'H:i') }}</span>
                                    @endif
                                </a>
                                @if( $parent_type == 'sats' || $parent_type == '11plus' || $parent_type == 'assessment'
                                || $parent_type == 'book_page')
                                <span style="float:right;font-size: 15px;"><a
                                            href="/panel/quizzes/{{$result_id}}/check_answers">More Details</a></span>
                                @endif
                                @if( $parent_type == 'timestables')
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
                                <span class="col-3">Level: {{isset( $analyticData['score_level'] )? $analyticData['score_level'] : ''}}</span>
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
