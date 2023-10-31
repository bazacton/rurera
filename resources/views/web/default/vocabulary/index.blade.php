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
            <section class="page-section analytics-graph-data">
                @include('web.default.panel.analytics.graph_data',['custom_dates' => $custom_dates, 'graphs_array' => $graphs_array, 'summary_type' => $summary_type, 'QuestionsAttemptController'=>
                $QuestionsAttemptController])
            </section>
            <div class="row pt-80">

                <div class="col-12">
                    <div class="section-title text-left mb-50">
                        <h2 class="mt-0 mb-10 testing222">11Plus Online 10-Minutes test practices</h2>
                        <p> Work through a variety of practice questions to improve your skills and become familiar with
                            the <br> types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>



                @if( !empty( $data))

                <div class="col-12">
                    <section class="lms-data-table my-30 spells elevenplus-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped table-bordered dataTable" style="width: 100%;"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">List
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">&nbsp;
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Percent: activate to sort column ascending">
                                                Words
                                            </th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Date: activate to sort column descending">Attempts
                                            </th>

                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Percent: activate to sort column ascending">Average Score %
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach( $data as $dataObj)
                                        @php $resultData = $QuestionsAttemptController->get_result_data($dataObj->id);
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
                                            <td>

                                                <a href="#" class="vocabulary-words-list" data-slug="{{$dataObj->quiz_slug}}" data-id="{{$dataObj->id}}" data-toggle="modal" data-target=".bd-example-modal-lg">{{$dataObj->getTitleAttribute()}}</a>
                                            </td>
                                            <td>
                                                @if( $dataObj->examp_board != '' && $dataObj->examp_board != 'All')
                                                <img src="/assets/default/img/{{$dataObj->examp_board}}.jpeg">
                                                @endif
                                            </td>
                                            <td>{{$total_questions}}</td>
                                            <td>{{$total_attempts}}</td>
                                            <td>
                                                <div class="attempt-progress">
                                                    <span class="progress-number">{{round($total_percentage, 2)}}%</span>
                                                    <span class="progress-holder">
                                                  <span class="progressbar"
                                                        style="width: {{$total_percentage}}%;"></span>
                                              </span>
                                                </div>
                                                {{ user_assign_topic_template($dataObj->id, '11plus', $childs, $parent_assigned_list) }}
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

<div class="spells-modal">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <section class="lms-data-table spells p-50 elevenplus-block">
            <div class="spells-topbar">
                <p>This is a preview. View this spelling list in EdShed, with full data available to subscribers.</p>
                <a href="#" class="view-btn">Start Test</a>
            </div>
            <table class="table table-striped table-bordered dataTable">
                <thead>
                <tr>
                    <th class="sorting sorting_asc"></th>
                    <th class="sorting">Word</th>
                    <th class="sorting">Sentences</th>
                </tr>
                </thead>
                <tbody class="vocabulary-block">
                <tr>
                    <td id="accordion2">
                    <a href="#" class="play-btn collapsed" data-toggle="collapse" data-target="#player" aria-expanded="true" aria-controls="player">
                        <img src="../assets/default/svgs/play-circle.svg" alt="">
                    </a>
                    <div id="player" class="player-box collapse" aria-labelledby="player" data-parent="#accordion2">
                        <audio preload="metadata" id="play" controls>
                        <source src="http://stash.rachelnabors.com/music/byakkoya_single.mp3" type="audio/ogg">
                        Your browser does not support the audio element.
                        </audio>
                    </div>
                    </td>
                    <td>54 <span>Word(s)</span> </td>
                    <td>
                    <p>His <strong>treachery</strong> in cheating his own sister saddened their family</p>
                    </td>
                </tr>
                <tr>
                    <td>
                    <a href="#" class="play-btn"><img src="../assets/default/svgs/play-circle.svg" alt=""></a>
                    </td>
                    <td>54 <span>Word(s)</span> </td>
                    <td>
                    <p>His <strong>treachery</strong> in cheating his own sister saddened their family</p>
                    </td>
                </tr>
                <tr>
                    <td>
                    <a href="#" class="play-btn"><img src="../assets/default/svgs/play-circle.svg" alt=""></a>
                    </td>
                    <td>54 <span>Word(s)</span> </td>
                    <td>
                    <p>His <strong>treachery</strong> in cheating his own sister saddened their family</p>
                    </td>
                </tr>
                <tr>
                    <td>
                    <a href="#" class="play-btn"><img src="../assets/default/svgs/play-circle.svg" alt=""></a>
                    </td>
                    <td>54 <span>Word(s)</span> </td>
                    <td>
                    <p>His <strong>treachery</strong> in cheating his own sister saddened their family</p>
                    </td>
                </tr>
                </tbody>
            </table>
            </section>
        </div>
        </div>
    </div>
</div>

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


        $('body').on('click', '.vocabulary-words-list', function (e) {
            var thisObj = $('.vocabulary-block');
            rurera_remove_loader(thisObj, 'div');
            rurera_loader(thisObj, 'div');
            var quiz_id = $(this).attr('data-id');
            var quiz_slug = $(this).attr('data-slug');

            $(".view-btn").attr('href', '/spells/'+quiz_slug);
            jQuery.ajax({
                type: "GET",
                url: '/spells/words_list',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"quiz_id": quiz_id},
                success: function (return_data) {
                    rurera_remove_loader(thisObj, 'button');
                    if (return_data != '') {
                        $('.vocabulary-block').html(return_data);
                        var audioElements = $(".player-box-audio");
                            audioElements.each(function() {
                            var audio = this;
                            audio.addEventListener('ended', function() {
                                $(this).closest('.play-btn').toggleClass("pause");
                            });
                          });
                    }
                }
            });

        });

    });
    $(document).on('click', '.play-btn', function (e) {
        var player_id = $(this).attr('data-id');

        $(this).toggleClass("pause");
        if($(this).hasClass('pause')) {
            document.getElementById(player_id).play();
        }else{
            document.getElementById(player_id).pause();
        }
    });



</script>
@endpush
