@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343;
    }

    .hide {
        display: none;
    }
</style>
@endpush

@section('content')
<section class="">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
        <h1 class="section-title">{{ trans('panel.dashboard') }}</h1>
    </div>
</section>

<section class="dashboard">

    <div class="row">
        <div class="col-12 col-lg-12 mt-35">
            <button type="button" class="hide add-child btn btn-sm btn-border-white" data-toggle="modal"
                    data-target="#addChildModal">Add Child
            </button>
            <div class="bg-white noticeboard rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                <h3 class="font-16 text-dark-blue font-weight-bold">Childs</h3>


                @if( !empty( $childs ) )
                @foreach($childs as $childObj)
                <div class="noticeboard-item py-15">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="js-noticeboard-title font-weight-500 text-secondary">
                                {{$childObj->full_name}}</h4>
                            <div class="font-12 text-gray mt-5">
                                <span class="mr-5">{{$childObj->email}}</span>
                                |
                                <span class="js-noticeboard-time ml-5">{{ dateTimeFormat($childObj->created_at,'j M Y | H:i') }}</span>
                            </div>
                        </div>

                        <div>
                            @php $package_id = 0; @endphp
                            @if(isset( $childObj->userSubscriptions->subscribe ) )
                            @php $package_id = $childObj->userSubscriptions->subscribe->id; @endphp
                            {{$childObj->userSubscriptions->subscribe->getTitleAttribute()}}
                            @endif
                            <button type="button" data-child="{{$childObj->id}}"
                                    class="js-switch-user btn btn-sm btn-border-white">Switch
                            </button>
                            <a href="/panel/parent/user/{{$childObj->id}}" data-child="{{$childObj->id}}"
                               class="btn btn-sm btn-border-white">Modify
                            </a>
                            <button type="button" data-child="{{$childObj->id}}" class="btn btn-sm btn-border-white">Cancel</button>
                            <button data-package_id="{{$package_id}}" type="button" data-toggle="modal" data-target="#update-plan-modal" data-child="{{$childObj->id}}" class="update-package btn btn-sm btn-border-white">Update Package</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>

        </div>

    </div>
</section>


<section class="mb-0 pt-70 pb-60">
    <div class="container">
        <div class="row">
            <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                {{ csrf_field() }}
                <div class="col-12">

                    <div class="lms-form-wrapper mb-50">
                        <div class="lms-choose-plan d-flex mb-30">
                            <div class="lms-choose-field">
                                <strong class="choose-title d-block mb-20 font-24">Choose a plan</strong>
                                <div class="lms-radio-select">
                                    <ul class="lms-radio-btn-group d-inline-flex align-items-center">
                                        <li>
                                            <input type="radio" id="month" value="1" data-discount="0"
                                                   name="subscribe_for" checked="checked"/>
                                            <label class="lms-label" for="month">
                                                <span>01 month</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="three_months" value="3" data-discount="5"
                                                   name="subscribe_for"/>
                                            <label class="lms-label" for="three_months">
                                                <span>03 month <span>(5%)</span> </span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="six_months" value="6" data-discount="10"
                                                   name="subscribe_for"/>
                                            <label class="lms-label" for="six_months">
                                                <span>06 month <span>(10%)</span> </span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="year" value="12" data-discount="20"
                                                   name="subscribe_for"/>
                                            <label class="lms-label" for="year">
                                                <span>whole year <span>(20%)</span></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lms-count-field">
                                <strong class="choose-title d-block mb-20 font-24">Choose number</strong>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-left-minus btn btn-number"
                                                data-type="minus" data-field="">
                                            <span class="icon-minus">−</span>
                                        </button>
                                    </span>
                                    <input type="text" id="quantity" name="quantity"
                                           class="form-control input-number" value="1" min="1"
                                           max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-right-plus btn btn-number"
                                                data-type="plus" data-field="">
                                            <span class="icon-plus">+</span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="childs-block">
                            <div class="child-item lms-choose-plan-selected mt-10">
                                <div class="lms-jobs-form">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-8">
                                            <div class="input-field">
                                                <input type="text" name="student_name[]"
                                                       placeholder="Enter your name..">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-2 col-md-4">
                                            <div class="field-btn select-arrow">
                                                <button type="button" data-toggle="modal" class="package_label"
                                                        data-target="#choose-plan-modal">Monthly
                                                </button>
                                                <input type="hidden" name="package_id[]" class="package_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br><br><br><br>
                        <div class="total-amount"></div>

                        <button type="submit" class="btn btn-primary btn-block mt-50">{{
                            trans('financial.purchase') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="child-hidden-block hide">
    <div class="child-item lms-choose-plan-selected mt-10">
        <div class="lms-jobs-form">
            <div class="row">
                <div class="col-12 col-lg-4 col-md-8">
                    <div class="input-field">
                        <input type="text" name="student_name[]" placeholder="Enter your name..">
                    </div>
                </div>
                <div class="col-12 col-lg-2 col-md-4">
                    <div class="field-btn select-arrow">
                        <button type="button" data-toggle="modal" class="package_label"
                                data-target="#choose-plan-modal">Monthly
                        </button>
                        <input type="hidden" name="package_id[]" class="package_id">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade choose-plan-modal update-plan-model" id="update-plan-modal" tabindex="-1"
     aria-labelledby="update-plan-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update plan</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="subscribe-plan-holder">
                    <div class="container">
                        <div class="row">

                            @if(!empty($subscribes) and !$subscribes->isEmpty())
                            @foreach($subscribes as $subscribe)

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="select-plan">
                                    <input type="radio" class="choose-package update-package-{{$subscribe->id}}" data-label="{{ $subscribe->title }}"
                                           id="up-{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                           value="{{ $subscribe->id }}" name="package">
                                    <label for="up-{{$subscribe->id}}" data-label="{{ $subscribe->title }}">
                                        <div class="subscribe-plan position-relative d-flex flex-column rounded-lg py-25 px-20">
                                                        <span class="subscribe-icon mb-35">
                                                            <img src="../assets/default/svgs/box-color2.svg" alt="#">
                                                            <img src="../assets/default/svgs/box-white.svg"
                                                                 class="box-white-svg" alt="#">
                                                        </span>
                                            <h3 itemprop="title"
                                                class="font-24 font-weight-500 text-dark-charcoal pt-20">{{
                                                $subscribe->title }}</h3>
                                            <div class="d-flex align-items-start text-dark-charcoal mt-10">
                                                <span itemprop="price" class="font-36 line-height-1">{{ addCurrencyToPrice($subscribe->price) }}</span>
                                            </div>
                                            <span class="plan-label d-block font-weight-500 pt-20">For Teachers</span>
                                            <ul class="plan-feature">
                                                @php
                                                $is_course_class = ($subscribe->is_courses == 0)? 'subscribe-no' :
                                                '';
                                                $is_timestables_class = ($subscribe->is_timestables == 0)?
                                                'subscribe-no' : '';
                                                $is_bookshelf_class = ($subscribe->is_bookshelf == 0)?
                                                'subscribe-no' : '';
                                                $is_sats_class = ($subscribe->is_sats == 0)? 'subscribe-no' : '';
                                                $is_elevenplus_class = ($subscribe->is_elevenplus == 0)?
                                                'subscribe-no' : '';
                                                @endphp

                                                <li itemprop="list" class="mt-15 {{$is_course_class}}"><span>All Courses Access</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_timestables_class}}"><span>Timestables</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_bookshelf_class}}"><span>Bookshelf</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_sats_class}}">
                                                    <span>SATs</span></li>
                                                <li itemprop="list" class="mt-15 {{$is_elevenplus_class}}">
                                                    <span>11Plus</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="col-12 mt-20">
                                <button type="button" class="select-plan-btn">Select Plan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade choose-plan-modal" id="choose-plan-modal" tabindex="-1"
     aria-labelledby="choose-plan-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Choose a plan</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="subscribe-plan-holder">
                    <div class="container">
                        <div class="row">

                            @if(!empty($subscribes) and !$subscribes->isEmpty())
                            @foreach($subscribes as $subscribe)

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="select-plan">
                                    <input type="radio" class="choose-package" data-label="{{ $subscribe->title }}"
                                           id="{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                           value="{{ $subscribe->id }}" name="package">
                                    <label for="{{$subscribe->id}}" data-label="{{ $subscribe->title }}">
                                        <div class="subscribe-plan position-relative d-flex flex-column rounded-lg py-25 px-20">
                                                        <span class="subscribe-icon mb-35">
                                                            <img src="../assets/default/svgs/box-color2.svg" alt="#">
                                                            <img src="../assets/default/svgs/box-white.svg"
                                                                 class="box-white-svg" alt="#">
                                                        </span>
                                            <h3 itemprop="title"
                                                class="font-24 font-weight-500 text-dark-charcoal pt-20">{{
                                                $subscribe->title }}</h3>
                                            <div class="d-flex align-items-start text-dark-charcoal mt-10">
                                                <span itemprop="price" class="font-36 line-height-1">{{ addCurrencyToPrice($subscribe->price) }}</span>
                                            </div>
                                            <span class="plan-label d-block font-weight-500 pt-20">For Teachers</span>
                                            <ul class="plan-feature">
                                                @php
                                                $is_course_class = ($subscribe->is_courses == 0)? 'subscribe-no' :
                                                '';
                                                $is_timestables_class = ($subscribe->is_timestables == 0)?
                                                'subscribe-no' : '';
                                                $is_bookshelf_class = ($subscribe->is_bookshelf == 0)?
                                                'subscribe-no' : '';
                                                $is_sats_class = ($subscribe->is_sats == 0)? 'subscribe-no' : '';
                                                $is_elevenplus_class = ($subscribe->is_elevenplus == 0)?
                                                'subscribe-no' : '';
                                                @endphp

                                                <li itemprop="list" class="mt-15 {{$is_course_class}}"><span>All Courses Access</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_timestables_class}}"><span>Timestables</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_bookshelf_class}}"><span>Bookshelf</span>
                                                </li>
                                                <li itemprop="list" class="mt-15 {{$is_sats_class}}">
                                                    <span>SATs</span></li>
                                                <li itemprop="list" class="mt-15 {{$is_elevenplus_class}}">
                                                    <span>11Plus</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="col-12 mt-20">
                                <button type="button" class="select-plan-btn">Select Plan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addChildModal" tabindex="-1" aria-labelledby="addChildModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            <div class="modal-body">

                <form method="Post" action="panel/parent/create_student" class="create_student_form mt-35">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="input-label" for="full_name">Full Name:</label>
                        <input name="full_name" type="text" class="form-control rurera-req-field" id="full_name">
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="email">Email :</label>
                        <input name="email" type="text" class="form-control rurera-req-field rurera-email-field"
                               id="email">
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="password">Password :</label>
                        <input name="password" type="password" class="form-control rurera-req-field" id="password">
                    </div>


                    <button type="submit" class="btn btn-primary btn-block mt-20 submit-button">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts_bottom')
<script type="text/javascript">

    $(document).on('change', 'input[name="subscribe_for"]', function (e) {
        calculate_total_amount();
    });


    $(document).on('click', '.update-package', function (e) {
        var package_id = $(this).attr('data-package_id');
        console.log(package_id);
        $(".update-package-"+package_id).attr('checked', true);
    });


    $(document).on('click', '.package_label', function (e) {
        var current_index = $(".package_label").index($(this));
        $(this).closest('.field-btn').find('.package_id').attr('data-current_index', current_index);
        $(this).attr('data-index_no', current_index);
        $(".choose-plan-modal").attr('data-current_index', current_index);
    });
    $(document).on('click', '.quantity-right-plus', function (e) {
        var child_item_html = $(".child-hidden-block").html();
        $(".childs-block").append(child_item_html);
    });

    $(document).on('click', '.quantity-left-minus', function (e) {
        $('.childs-block .child-item:last-child').remove();
    });


    $(document).on('click', '.select-plan-btn', function (e) {
        var current_index = $(".choose-plan-modal").attr('data-current_index');
        var package_label = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-label');
        var package_price = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-price');
        $('.package_id[data-current_index="' + current_index + '"]').val($(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).val());
        $('.package_id[data-current_index="' + current_index + '"]').attr('data-price', package_price);
        $('.package_label[data-index_no="' + current_index + '"]').html(package_label);
        $("#choose-plan-modal").modal('hide');
        calculate_total_amount();
    });

    function calculate_total_amount() {

        var total_amount = 0;
        var child_count = 0;
        $('.childs-block').find('.package_id').each(function (index_no) {
            if ($(this).attr('data-price') != 'undefined') {
                child_count++;
                var discount_percentage = 0;
                if( child_count > 1){
                    discount_percentage = 5;
                }
                var current_price = parseInt($(this).attr('data-price'));
                var discount_amount = (parseFloat(current_price) * parseInt(discount_percentage)) / 100;
                current_price = (parseFloat(current_price) - parseFloat(discount_amount));
                total_amount = parseInt(total_amount) + parseInt(current_price);
            }
        });

        var discount_percentage = $('input[name="subscribe_for"]:checked').attr('data-discount');

        var discount_amount = (parseFloat(total_amount) * parseInt(discount_percentage)) / 100;
        total_amount = (parseFloat(total_amount) - parseFloat(discount_amount));

        $(".total-amount").html(total_amount);
        console.log(total_amount);
    }


</script>
@endpush

@if(!empty($giftModal))
@push('scripts_bottom2')
<script>
    (function () {
        "use strict";

        handleLimitedAccountModal('{!! $giftModal !!}', 40)
    })(jQuery)
</script>

@endpush
@endif
