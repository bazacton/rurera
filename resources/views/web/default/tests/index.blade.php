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

                    @if( !empty( $childs ) )
                        <div class="p-15 mt-20 p-lg-20 db-form-tabs panel-border font-weight-500 text-dark-blue rounded-sm panel-shadow mb-20 switch-user-block">

                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="javascript:;" class="avatar"><img src="{{$switchUserObj->getAvatar()}}" alt="{{isset( $switchUserObj->id )? $switchUserObj->get_full_name() : ''}}" class="avatar rounded-circle"></a>
                                    </div>

                                    <div class="col-5 ms-2">
                                        <h6 class="font-19 font-weight-bold"><a href="javascript:;">{{isset( $switchUserObj->id )? $switchUserObj->get_full_name() : ''}}</a></h6>
                                    </div>
                                    <div class="col-auto ms-auto mr-md-3 last-activity">
                                        <a href="javascript:;" class="switch-user-btn" data-toggle="modal" data-target="#switch_user_modal">
                                           <img src="/assets/default/img/default/user-switch.png">
                                       </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="section-title text-left mb-50">
                        <h2 class="mt-0 mb-10 font-22">Mock Tests</h2>
                        <p class="mb-15">Click on ‘Assign test’ next to your test papers. Here, you can choose the mock test(s) for which you would like to assign mock tests. Each learner has a limit mock tests per month, but guardians and teachers are allowed flexibility to decide which tests your learner should focus on. </p>
                        <p>Once you’ve assigned the mock tests, they will appear on the homepage of your learner’s account.</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="listing-search lms-jobs-form mb-20">
                        <form>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <div class="input-field">
                                            <input type="text" class="search-tests" placeholder="Test Keyword">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="tests-list-holder mb-25">
                                        <a href="#." class="filter-mobile-btn">Filters Dropdown</a>
                                        <ul class="tests-list mb-30">
                                            <li data-type="all" class="active">All Tests</li>
                                            <li data-type="sats"><img src="/assets/default/img/assignment-logo/sats.png" alt=""> SATs</li>
                                            <li data-type="11plus"><img src="/assets/default/img/assignment-logo/11plus.png" alt=""> 11Plus</li>
                                            <li data-type="iseb"><img src="/assets/default/img/assignment-logo/iseb.png" alt=""> ISEB</li>
                                            <li data-type="cat4"><img src="/assets/default/img/assignment-logo/cat4.png" alt=""> CAT 4</li>
                                            <li data-type="independent_exams"><img src="/assets/default/img/assignment-logo/independent_exams.png" alt=""> Independent Exams</li>
                                        </ul>
                                    </div>
                                    <h4 class="total-tests has-border font-22">Total Tests: {{$sats->count()}}</h4>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-md-12">
                    <div class="sats-listing-card medium">
                        <table class="simple-table">
                            <tbody>
							
							{!! $response_layout !!}

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
<div class="modal fade switch_user_modal" id="switch_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-box">
                    <div class="modal-title">
                        <h3>Switch User</h3>
                    </div>
                    <div class="p-15 db-form-tabs mt-20 p-lg-20 font-weight-500 text-dark-blue rounded-sm panel-shadow mb-20 switch-user-block">

                        @foreach( $childs as $childObj)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="javascript:;" class="avatar"><img src="{{$childObj->getAvatar()}}" alt="{{isset( $childObj->id )? $childObj->get_full_name() : ''}}" class="avatar rounded-circle"></a>
                                </div>

                                <div class="col-5 ms-2">
                                    <h6 class="font-19 font-weight-bold"><a href="javascript:;">{{isset( $childObj->id )? $childObj->get_full_name() : ''}}</a></h6>
                                </div>
                                <div class="col-auto ms-auto mr-md-3 last-activity">
                                    <a href="javascript:;" class="switch-user-btn switch-user-btn-event" data-user_id="{{$childObj->id}}">
                                       <img src="/assets/default/img/default/user-switch.png">
                                   </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

        var SwitchRequest = null;
        $('body').on('click', '.switch-user-btn-event', function (e) {
            rurera_loader($(".switch_user_modal .switch-user-block"), 'div');
            var switch_user = $(this).attr('data-user_id');
            SwitchRequest = jQuery.ajax({
                type: "GET",
                url: '/tests/switch_user',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    if (SwitchRequest != null) {
                        SwitchRequest.abort();
                    }
                },
                data: {"switch_user": switch_user},
                success: function (return_data) {
                    location.reload();
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
@if (!auth()->subscription('sats'))
    <script>
        if( $(".subscription-modal").length > 0){
            $(".subscription-modal").modal('show');
        }
    </script>
@endif
@endpush
