@extends('web.default.panel.layouts.panel_layout')

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

    <section class="pt-10">
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
                    <div class="listing-search lms-jobs-form mb-20">
                        <form>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <div class="input-field">
                                            <input type="text" class="search-tests">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12 col-md-12">
                                    <ul class="tests-list">
                                        <li data-type="all" class="active">All Tests</li>
                                        <li data-type="sats"><img src="/assets/default/img/assignment-logo/sats.png" alt=""> SATs</li>
                                        <li data-type="11plus"><img src="/assets/default/img/assignment-logo/11plus.png" alt=""> 11Plus</li>
                                        <li data-type="iseb"><img src="/assets/default/img/assignment-logo/iseb.png" alt=""> ISEB</li>
                                        <li data-type="cat4"><img src="/assets/default/img/assignment-logo/cat4.png" alt=""> CAT 4</li>
                                        <li data-type="independent_exams"><img src="/assets/default/img/assignment-logo/independent_exams.png" alt=""> Independent Exams</li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-md-12">
                    <div class="sats-listing-card medium">
                        <table class="simple-table">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Title</th>
                                <th>Accuracy</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty( $sats))
                            @php $counter = 0; @endphp
                            @foreach( $sats as $rowObj)

                            @include('web.default.tests.single_item',['rowObj' => $rowObj])


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

        var searchRequest = null;
        $('body').on('keyup', '.search-tests', function (e) {
            rurera_loader($(".simple-table tbody"), 'div');
            var search_keyword = $(this).val();
            searchRequest = jQuery.ajax({
                type: "GET",
                url: '/tests/search_tests',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (searchRequest != null) {
                        searchRequest.abort();
                    }
                },
                data: {"search_keyword": search_keyword},
                success: function (return_data) {
                    rurera_remove_loader($(".simple-table tbody"), 'div');
                    if (return_data != '') {
                        $(".simple-table tbody").html(return_data);
                    }
                }
            });

        });

        $('body').on('click', '.tests-list li', function (e) {
            rurera_loader($(".simple-table tbody"), 'div');
            $(".tests-list li").removeAttr('class');
            $(this).addClass('active');
            var quiz_type = $(this).attr('data-type');
            searchRequest = jQuery.ajax({
                type: "GET",
                url: '/tests/search_tests',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (searchRequest != null) {
                        searchRequest.abort();
                    }
                },
                data: {"quiz_type": quiz_type},
                success: function (return_data) {
                    rurera_remove_loader($(".simple-table tbody"), 'div');
                    $(".simple-table tbody").html(return_data);
                }
            });

        });





    });

</script>
@endpush
