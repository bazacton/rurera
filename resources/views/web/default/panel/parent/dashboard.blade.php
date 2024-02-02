@extends(getTemplate() .'.panel.layouts.panel_layout_full')

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
<section class="member-card-header">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
        <h1 class="section-title">Members</h1>
        <div class="dropdown">

        <button type="button" class="btn btn-sm btn-primary add-child-btn" data-toggle="modal"
                data-target="#addChildModal"><img src="/assets/default/svgs/settings.svg"> Add Child
        </button>

    </div>
        <br><br><br>
    </div>
</section>

<section class="dashboard">

    <div class="db-form-tabs">
        <div class="db-members">
            <div class="row g-3 list-unstyled">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="list-group list-group-custom list-group-flush mb-0 totalChilds"
                                 data-childs="{{$childs->count()}}">

                                @if( !empty( $childs ) )
                                @foreach($childs as $childObj)

                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="javascript:;" class="avatar"><img
                                                        src="{{$childObj->getAvatar()}}"
                                                        alt="{{$childObj->full_name}}"
                                                        class="avatar rounded-circle"></a>
                                        </div>

                                        <div class="col-5 ms-2">
                                            <h6 class="font-19 font-weight-bold"><a href="#">{{$childObj->full_name}}</a></h6>
                                            <small class="text-muted">
                                                @if(isset( $childObj->userSubscriptions->subscribe ) )
                                                @php $package_id = $childObj->userSubscriptions->subscribe->id;
                                                @endphp
                                                Membership: {{$childObj->userSubscriptions->subscribe->getTitleAttribute()}}
                                                @php
                                                $expiry_at = $childObj->userSubscriptions->expiry_at;
                                                @endphp
                                                - Expiry: {{ dateTimeFormat($expiry_at, 'j M Y') }}
                                                @endif
                                            </small>
                                        </div>

                                        <a href="/panel/switch_user/{{$childObj->id}}" class="switch-user-btn">
                                            <img src="/assets/default/img/default/user-switch.png">
                                        </a>
                                        <a href="javascript:;" class="connet-user-btn">
                                            <img src="/assets/default/img/default/plus-icon.png"> Connect to Class
                                        </a>
                                        <div class="col-auto ms-auto mr-md-3 last-activity">
                                            <span><strong>{{ ($childObj->getLastActivity() != '')? dateTimeFormat($childObj->getLastActivity(), 'j M Y') : 'No Activity' }}</strong>
                                            <br>Last Activity
                                            </span>
                                        </div>
                                    </div> <!--[ row end ]-->
                                </div>

                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade choose-expiry-modal update-expiry-model" id="update-expiry-modal" tabindex="-1"
         aria-labelledby="update-expiry-modalLabel" aria-hidden="true">


        <form action="/panel/financial/update_subscribe_plan" method="post" class="w-100">
            {{ csrf_field() }}

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <strong>Choose a plan</strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="col-12">


                            <div class="lms-form-wrapper mb-50">

                                <div class="lms-choose-plan d-flex mb-30">
                                    <div class="lms-choose-field">
                                        <strong class="choose-title d-block mb-20 font-24">Choose a plan</strong>
                                        <div class="lms-radio-select">
                                            <ul class="lms-radio-btn-group d-inline-flex align-items-center">

                                                @php
                                                $payment_frequency = isset( $userObj->payment_frequency )?
                                                $userObj->payment_frequency : 1; @endphp
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 1)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_month" value="1" data-discount="0"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_month">
                                                        <span>01 month</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 3)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_three_months" value="3"
                                                           data-discount="5"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_three_months">
                                                        <span>03 month <span>(5%)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 6)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_six_months" value="6"
                                                           data-discount="10"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_six_months">
                                                        <span>06 month <span>(10%)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    @php $checked = (isset( $payment_frequency) &&
                                                    $payment_frequency == 12)? 'checked' : ''; @endphp
                                                    <input type="radio" id="package_year" value="12" data-discount="20"
                                                           name="subscribe_for_package" {{$checked}}/>
                                                    <label class="lms-label" for="package_year">
                                                        <span>whole year <span>(20%)</span></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary btn-block mt-50">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>

<div class="modal fade" id="addChildModal" tabindex="-1" aria-labelledby="addChildModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                    {{ csrf_field() }}
                    <div class="col-12">
                        @php $discount = isset( $ParentsOrders->payment_frequency )?
                        $frequency_discounts[$ParentsOrders->payment_frequency] : 0; @endphp


                        <div class="lms-form-wrapper mb-50">

                            @if( isset( $ParentsOrders->id ) )
                            <input type="radio" class="hide subscribe_for" name="subscribe_for"
                                   value="{{isset($ParentsOrders->payment_frequency)? $ParentsOrders->payment_frequency : 1}}"
                                   data-discount="{{$discount}}" checked>
                            @else
                            <div class="lms-choose-plan d-flex mb-30">
                                <div class="lms-choose-field">
                                    <strong class="choose-title d-block mb-20 font-24">Choose a plan</strong>
                                    <div class="lms-radio-select">
                                        <ul class="lms-radio-btn-group d-inline-flex align-items-center">

                                            @php
                                            $payment_frequency = isset( $ParentsOrders->payment_frequency )?
                                            $ParentsOrders->payment_frequency : 1; @endphp
                                            <li>
                                                @php $checked = (isset( $payment_frequency) &&
                                                $payment_frequency == 1)? 'checked' : ''; @endphp
                                                <input type="radio" id="month" value="1" data-discount="0"
                                                       name="subscribe_for" {{$checked}}/>
                                                <label class="lms-label" for="month">
                                                    <span>01 month</span>
                                                </label>
                                            </li>
                                            <li>
                                                @php $checked = (isset( $payment_frequency) &&
                                                $payment_frequency == 3)? 'checked' : ''; @endphp
                                                <input type="radio" id="three_months" value="3" data-discount="5"
                                                       name="subscribe_for" {{$checked}}/>
                                                <label class="lms-label" for="three_months">
                                                    <span>03 month <span>(5%)</span> </span>
                                                </label>
                                            </li>
                                            <li>
                                                @php $checked = (isset( $payment_frequency) &&
                                                $payment_frequency == 6)? 'checked' : ''; @endphp
                                                <input type="radio" id="six_months" value="6" data-discount="10"
                                                       name="subscribe_for" {{$checked}}/>
                                                <label class="lms-label" for="six_months">
                                                    <span>06 month <span>(10%)</span> </span>
                                                </label>
                                            </li>
                                            <li>
                                                @php $checked = (isset( $payment_frequency) &&
                                                $payment_frequency == 12)? 'checked' : ''; @endphp
                                                <input type="radio" id="year" value="12" data-discount="20"
                                                       name="subscribe_for" {{$checked}}/>
                                                <label class="lms-label" for="year">
                                                    <span>whole year <span>(20%)</span></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <input type="hidden" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="1">


                            <div class="childs-block">
                                <div class="child-item lms-choose-plan-selected mt-10 mb-20">
                                    <div class="lms-jobs-form">
                                        <div class="row user-details-block">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student's first name</span>
                                                <div class="input-field">
                                                    <input type="text" name="student_name[]"
                                                           placeholder="Student First Name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student's last name</span>
                                                <div class="input-field">
                                                    <input type="text" name="student_last_name[]"
                                                           placeholder="Student Last Name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student Username</span>
                                                <div class="input-field">
                                                    <input type="text" name="student_username[]"
                                                           placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student Password</span>
                                                <div class="input-field">
                                                    <input type="password" name="student_password[]"
                                                           placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <span class="form-label">Student Preference</span>
                                                <div class="input-field">
                                                    <select class="form-control">
                                                        <option value="">Preference</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-block mt-50 childs-next-btn" style="background:#0272b6; color:#fff">Next
                                            </button>
                                        </div>
                                        <div class="row choose-package-block rurera-hide">
                                            <div class="col-12 col-lg-12 col-md-124">
                                                <strong class="choose-title d-block mb-20 mt-20 font-24">Choose Package</strong>
                                                <div class="subscribe-plan-holder">
                                                    <div class="container">
                                                        <div class="row">
                                                            <input type="hidden" name="child_id" class="update_plan_child">
                                                            @if(!empty($subscribes) and !$subscribes->isEmpty())
                                                            @foreach($subscribes as $subscribe)

                                                            <div class="col-lg-6 col-md-6 col-sm-12">

                                                                <div class="select-plan">
                                                                    <input type="radio" class="package_id choose-package update-package-{{$subscribe->id}}"
                                                                           data-label="{{ $subscribe->title }}"
                                                                           id="up-{{$subscribe->id}}" data-price="{{$subscribe->price}}"
                                                                           value="{{ $subscribe->id }}" name="package_id[]">
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="total-amount"></div>
                                            <button type="submit" class="btn btn-primary btn-block mt-50" style="background:#0272b6; color:#fff">{{
                                                trans('financial.purchase') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


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
    <form action="/panel/financial/update-plan" method="post" class="w-100">
        {{ csrf_field() }}
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
                                <input type="hidden" name="child_id" class="update_plan_child">
                                @if(!empty($subscribes) and !$subscribes->isEmpty())
                                @foreach($subscribes as $subscribe)

                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <div class="select-plan">
                                        <input type="radio" class="choose-package update-package-{{$subscribe->id}}"
                                               data-label="{{ $subscribe->title }}"
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
                                    <button type="submit" class="select-plan-btn">Update Plan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

@endsection

@push('scripts_bottom')
<script type="text/javascript">

    $(document).on('change', 'input[name="subscribe_for"]', function (e) {
        calculate_total_amount();
    });


    $(document).on('click', '.update-package', function (e) {
        var package_id = $(this).attr('data-package_id');
        var child_id = $(this).attr('data-child');
        $(".update_plan_child").val(child_id);
        $(".choose-package").attr('checked', false);
        $('label[for="up-' + package_id + '"]').click();
        $(".update-package-" + package_id).attr('checked', true);
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

    $(document).on('click', '.childs-next-btn', function (e) {
        $('.user-details-block').addClass('rurera-hide');
        $('.choose-package-block').removeClass('rurera-hide');
    });

    $(document).on('click', '.add-child-btn', function (e) {
        $('.user-details-block').removeClass('rurera-hide');
        $('.choose-package-block').addClass('rurera-hide');
    });





    $(document).on('click', '.subscribe-plans', function (e) {
        var current_index = $(".choose-plan-modal").attr('data-current_index');
        console.log(current_index);
        var package_label = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-label');
        var package_price = $(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).attr('data-price');
        //$('.package_id[data-current_index="' + current_index + '"]').val($(this).closest('.subscribe-plan-holder').find($('input[class="choose-package"]:checked')).val());
        $('.package_id[data-current_index="' + current_index + '"]').attr('data-price', package_price);
        $('.package_label[data-index_no="' + current_index + '"]').html(package_label);
        //$("#choose-plan-modal").modal('hide');
        calculate_total_amount();
    });

    function calculate_total_amount() {

        var total_amount = 0;
        var child_count = $(".totalChilds").attr('data-childs');
        console.log(child_count);
        $('.childs-block').find('.package_id:checked').each(function (index_no) {
            console.log($(this).attr('data-price'));
            if ($(this).attr('data-price') != 'undefined') {
                child_count++;
                var discount_percentage = 0;
                if (child_count > 1) {
                    discount_percentage = 5;
                }
                var current_price = parseInt($(this).attr('data-price'));
                var discount_amount = (parseFloat(current_price) * parseInt(discount_percentage)) / 100;
                current_price = (parseFloat(current_price) - parseFloat(discount_amount));
                total_amount = parseFloat(total_amount) + parseFloat(current_price);
            }
        });

        var discount_percentage = $('input[name="subscribe_for"]:checked').attr('data-discount');
        total_amount = (total_amount * $('input[name="subscribe_for"]:checked').val());

        var discount_amount = (parseFloat(total_amount) * parseInt(discount_percentage)) / 100;
        total_amount = (parseFloat(total_amount) - parseFloat(discount_amount));
        total_amount = parseFloat(total_amount).toFixed(2);

        if (total_amount != 'NaN') {
            $(".total-amount").html(total_amount);
        }
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
