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
                        <h2 class="mt-0 mb-10 testing222">11Plus Online 10-Minutes test practices</h2>
                        <p> Work through a variety of practice questions to improve your skills and become familiar with
                            the <br> types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>



                @if( !empty( $data))

                <div class="col-12">
                    <section class="pb-70">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="master-list">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="master-card master">
                                                    <strong>Mastered Words</strong> <span>{{count($user_mastered_words)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="master-card non-master">
                                                    <strong>Troubled Words</strong> <span>{{count($user_non_mastered_words)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="master-card master">
                                                    <strong>In-progress Words</strong> <span>{{count($user_in_progress_words)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="master-card non-use">
                                                    <strong>Not Used Words</strong> <span class="rurera-processing"><div class="rurera-button-loader" style="display: block;"><div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div></div></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="lms-data-table my-30 spells elevenplus-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                        <div class="listing-search lms-jobs-form mb-20">
                                            <form>
                                                <div class="row align-items-center">
                                                    <div class="col-12 col-lg-9 col-md-6">
                                                        <div class="form-group">
                                                            <label class="input-label">Year Group</label>
                                                            <div class="input-field select-arrow">
                                                                <select
                                                                        class="lms-jobs-select"
                                                                        name="year">
                                                                    <option {{ !empty($trend) ?
                                                                    '' : 'selected' }} disabled>Select Year</option>

                                                                    @foreach($categories as $category)
                                                                    @if(!empty($category->subCategories) and
                                                                    count($category->subCategories))
                                                                    <optgroup label="{{  $category->title }}">
                                                                        @foreach($category->subCategories as $subCategory)
                                                                        <option value="{{ $subCategory->id }}" @if(request()->get('year') == $subCategory->id) selected="selected" @endif>
                                                                            {{$subCategory->title}}
                                                                        </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                    @else
                                                                    <option value="{{ $category->id }}"
                                                                            class="font-weight-bold">{{
                                                                        $category->title }}
                                                                    </option>
                                                                    @endif
                                                                    @endforeach
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
                                                            <a href="/spells" class="clear-btn ml-10 text-uppercase text-primary">Clear
                                                                Filters</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <div class="col-12">
                                    <div class="spells-table-inner">
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
                                                    aria-label="Date: activate to sort column descending">Mastered Words
                                                </th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Date: activate to sort column descending">Troubled Words
                                                </th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Date: activate to sort column descending">In-progress Words
                                                </th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Date: activate to sort column descending">Not Used Words
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @php $total_questions_all = $total_attempts_all = $total_questions_attempt_all = $correct_questions_all =
                                            $incorrect_questions_all = $pending_questions_all = $not_used_words_all = 0;
                                            @endphp

                                            @foreach( $data as $dataObj)
                                            @php $resultData = $QuestionsAttemptController->get_result_data($dataObj->id);
                                            $total_attempts = $total_questions_attempt = $correct_questions =
                                            $incorrect_questions = 0;
                                            $mastered_words = $non_mastered_words = $in_progress_words = 0;
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

                                                $mastered_words += $resultObj->mastered_words;
                                                $non_mastered_words += $resultObj->non_mastered_words;
                                                $in_progress_words += $resultObj->in_progress_words;
                                                $total_questions_attempt += $resultObj->attempted;
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

                                            @php $total_questions_all += $total_questions;
                                            $total_questions_attempt_all += $total_questions_attempt;
                                            $correct_questions_all += $correct_questions;
                                            $incorrect_questions_all += $incorrect_questions;
                                            $pending_questions_all += ($total_questions - $total_questions_attempt);
                                            $not_used_words_all += ($total_questions - $mastered_words - $non_mastered_words - $in_progress_words);


                                            @endphp

                                            <tr class="odd">
                                                <td>

                                                    <a href="/spells/{{$dataObj->quiz_slug}}/words-list" data-slug="{{$dataObj->quiz_slug}}" data-id="{{$dataObj->id}}" >{{$dataObj->getTitleAttribute()}}</a>
                                                </td>
                                                <td>
                                                    @if( $dataObj->examp_board != '' && $dataObj->examp_board != 'All')
                                                    <img src="/assets/default/img/{{$dataObj->examp_board}}.jpeg">
                                                    @endif
                                                </td>
                                                <td>{{$total_questions}}</td>
                                                <td>{{$mastered_words}}</td>
                                                <td>{{$non_mastered_words}}</td>
                                                <td>{{$in_progress_words}}</td>
                                                <td>{{($total_questions - $mastered_words - $non_mastered_words - $in_progress_words)}}</td>

                                            </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
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


        //$(".master-card.master span").html('{{$correct_questions_all}}');
        //$(".master-card.non-master span").html('{{$incorrect_questions_all}}');
        $(".master-card.non-use span").html('{{$not_used_words_all}}');

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
