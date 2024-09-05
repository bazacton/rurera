@extends('web.default.panel.layouts.panel_layout_full')
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
<section class="member-card-header pb-20">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-md-row">
        <h1 class="section-title font-22">Analytics</h1>
        <div class="dropdown db-members">
            @if(auth()->check() && (auth()->user()->isParent()))
            <div class="ms-auto last-activity profile-dropdown">
                <a href="#" class="font-16 font-weight-normal">{{$selected_child}}</a>
                <ul>
                    <li><a href="/{{panelRoute()}}/analytics/?child=all" class="switch-user-btn"><span class="icon-box"><img src="/assets/default/svgs/switch-user.svg" alt=""></span> All Students</a></li>
                    @if( !empty( $childs ) )
                    @foreach($childs as $childLinkObj)
                    @php $childObj = $childLinkObj->user; @endphp
                        <li><a href="/{{panelRoute()}}/analytics/?child={{ $childObj->id }}" class="switch-user-btn"><span class="icon-box"><img src="{{$childObj->getAvatar()}}" alt=""></span> {{ $childObj->get_full_name() }}</a></li>
                    @endforeach
                    @endif
                </ul>
            </div>
            @endif
    </div>
    </div>
</section>


<section>


    <div class="activities-container mt-10 p-20 p-lg-35 ">
        <div class="chart-filters p-0">
            <div class="filters-list">
                <a href="#" class="filter-mobile-btn">Filters Dropdown</a>
                <ul class="analytics-type">
                    @php $link_append = (isset($_GET['child'])) ? '?child='.$_GET['child'] : ''; @endphp
                    <li {{($type_selected == 'all')? 'class=active' : ''}}><a href="/{{panelRoute()}}/analytics{{$link_append}}" data-graph_type="all"><img src="/assets/default/img/sidebar/all.svg"> ALL</a></li>
                    <li {{($type_selected == 'learn')? 'class=active' : ''}}><a href="/{{panelRoute()}}/analytics/learn{{$link_append}}" data-graph_type="learn"><img src="/assets/default/img/sidebar/learn.svg"> LEARN</a></li>
                    <li {{($type_selected == 'timestables')? 'class=active' : ''}}><a href="/{{panelRoute()}}/analytics/timestables{{$link_append}}" data-graph_type="timestables"><img src="/assets/default/img/sidebar/timestable.svg"> TIMESTABLE</a></li>
                    <li {{($type_selected == 'vocabulary')? 'class=active' : ''}}><a href="/{{panelRoute()}}/analytics/vocabulary{{$link_append}}" data-graph_type="word_lists"><img src="/assets/default/img/sidebar/spell.svg"> WORD LISTS</a></li>
                    <li {{($type_selected == 'books')? 'class=active' : ''}}><a href="/{{panelRoute()}}/analytics/books{{$link_append}}" data-graph_type="books"><img src="/assets/default/img/sidebar/books.svg"> BOOKS</a></li>
                    <li {{($type_selected == 'tests')? 'class=active' : ''}}><a href="/{{panelRoute()}}/analytics/tests{{$link_append}}" data-graph_type="tests"><img src="/assets/default/img/sidebar/test.svg"> TEST</a></li>
                </ul>
            </div>



            <ul class="analytics-data-ul">
                <li><a href="javascript:;" class=" hide graph_Custom" data-graph_id="graph_id_Custom">September 20, 2023 -
                        September 26, 2023</a>
                </li>

            </ul>



        </div>

        <div class="time-card panel-border panel-shadow mb-30 rurera-hide">
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
        <div class="analytics-header">
            <div class="header-text">
                <span class="font-18 font-weight-bold">Date</span>
                <span class="font-18 font-weight-bold">Avg Daily Mins</span>
                <span class="font-18 font-weight-bold">Coins Earned</span>
            </div>
        </div>
        <div class="accordion" id="analyticsAccordion">

            @if( !empty( $analytics_data) )
            @foreach( $analytics_data as $date_str => $analyticDataArray)
            @php if(!isset( $analyticDataArray['practice_time'] ) || $analyticDataArray['practice_time'] == 0){ continue; } @endphp
            @php $report_date = strtotime(str_replace('_', '-', $date_str)); @endphp
            <div class="card">
                <div class="card-header collapsed mb-0" id="headingOne" type="button" data-toggle="collapse"
                     data-target="#report_{{$date_str}}" aria-expanded="true" aria-controls="report_{{$date_str}}">
                    <span>{{ dateTimeFormat($report_date,'d F Y') }}</span>
                    <span class="analytics-timespend float-right">
                        <img src="/assets/default/img/panel-sidebar/clock.svg" alt="">
                        <span>{{ isset( $analyticDataArray['practice_time'] )? getTimeWithText($analyticDataArray['practice_time']) : 0 }}</span>
                    </span>
                    <span class="analytics-cions-earned float-right mr-10">
                        <img src="/assets/default/img/panel-sidebar/coins.svg" alt="">
                        <span>
                            {{ isset( $analyticDataArray['coins_earned'] )? $analyticDataArray['coins_earned'] : 0 }}
                        </span>
                    </span>

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
                            $detail_link = '/panel/analytics/timestables/result/'.$result_id;
                        }

                        if( $parent_type == 'book_read'){
                           $book_slug = isset( $analyticData['book_slug'] )? $analyticData['book_slug'] : '';
                            $detail_link = '/books/'.$book_slug.'/activity';
                        }
                        $analytic_icon = '/assets/default/img/types/'.$parent_type.'.svg';
                        $analytic_icon =   isset( $analyticData['list_icon'] )? $analyticData['list_icon'] : $analytic_icon;

                        $by_user_label = '';
                        if(auth()->check() && (auth()->user()->isParent() || auth()->user()->isTutor())){
                            $userObj = isset( $analyticData['user'] )? $analyticData['user'] : array();
                            if( isset( $userObj->id)){
                                $by_user_label .= 'By <img src="'.$userObj->getAvatar().'" width="26" height="26"> ' . $userObj->get_full_name();
                            }
                        }


                        @endphp


                                <li>
                                    <div class="timeline-icon"><img src="{{$analytic_icon}}" width="26" height="26" alt=""></div>
                                    <div class="timeline-text"><p><strong><a href="{{$detail_link}}">{{isset( $analyticData['topic_title'] )? $analyticData['topic_title'] : ''}}</a></strong> {!! $by_user_label !!} <span class="info-time">{{ dateTimeFormat($start_time,'H:i') }}</span></p>
                                    @if( $type == 'book_read')
                                            <span class="analytic-item">Reading Time: {{isset( $analyticData['read_time'] )? $analyticData['read_time'] : 0}} min</span>
                                            <span class="analytic-item">Pages Read: {{isset( $analyticData['pages_read'] )? $analyticData['pages_read'] : ''}}</span>
                                            <span class="analytic-item">&nbsp;</span>
                                            <span class="analytic-item">&nbsp;</span>
                                        @elseif( $type == 'quest')
                                            <span class="analytic-item">Coins earned: {{isset( $analyticData['coins_earned'] )? $analyticData['coins_earned'] : 0}}</span>
                                        @else
                                            <span class="analytic-item">Active practice: {{isset( $analyticData['practice_time'] )? getTimeWithText($analyticData['practice_time']) : 0}}</span>
                                            <span class="analytic-item">Questions answered: {{isset( $analyticData['question_answered'] )? $analyticData['question_answered'] : 0}}</span>
                                            <span class="analytic-item">Coins earned: {{isset( $analyticData['coins_earned'] )? $analyticData['coins_earned'] : 0}}</span>
                                    @endif
                                    @if( $type != 'quest')
                                        <span class="analytics-more_details"><a href="{{$detail_link}}">More Details</a></span>
                                    @endif
                                    </div>
                                </li>


                        @endforeach
                        @endif

                        </ul>

                    </div>
                </div>
            </div>
            @endforeach

            @else
                <div class="card">
                    <div class="card-header collapsed mb-0" id="headingOne" type="button" data-toggle="collapse" data-target="#report_07_03_2024" aria-expanded="true" aria-controls="report_07_03_2024">
                        <span>&nbsp;</span>
                        <span class="analytics-timespend float-right">
                            <span>No Records Found</span>
                        </span>
                        <span class="analytics-cions-earned float-right mr-10">
                            &nbsp;
                        </span>
                    </div>
                </div>
            @endif

        </div>


    </div>
</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('body').on('change', '.child-analytics', function (e) {
            console.log('test');
            $(".child-analytics-form").submit();
        });

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
