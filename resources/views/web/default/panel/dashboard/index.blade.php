@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/chartjs/chart.min.css"/>
    <link rel="stylesheet" href="/assets/default/vendors/apexcharts/apexcharts.css"/>
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
    <section class="">
        <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
            <h1 class="section-title">{{ trans('panel.dashboard') }}</h1>

            @if(!$authUser->isUser())
                <div class="d-flex align-items-center flex-row-reverse flex-md-row justify-content-start justify-content-md-center mt-20 mt-md-0">
                    <label class="mb-0 mr-10 cursor-pointer text-gray font-14 font-weight-500" for="iNotAvailable">{{ trans('panel.i_not_available') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="disabled" @if($authUser->offline) checked @endif class="custom-control-input" id="iNotAvailable">
                        <label class="custom-control-label" for="iNotAvailable"></label>
                    </div>
                </div>
            @endif
        </div>

        @if(!$authUser->financial_approval and !$authUser->isUser())
            <div class="p-15 mt-20 p-lg-20 not-verified-alert font-weight-500 text-dark-blue rounded-sm panel-shadow">
                {{ trans('panel.not_verified_alert') }}
                <a href="/panel/setting/step/7" class="text-decoration-underline">{{ trans('panel.this_link') }}</a>.
            </div>
        @endif

        <div class="bg-white dashboard-banner-container position-relative px-15 px-ld-35 py-10 panel-shadow rounded-sm">
            <h2 class="font-30 text-primary line-height-1">
                <span class="d-block">{{ trans('panel.hi') }} {{ $authUser->full_name }},</span>
                <span class="font-16 text-secondary font-weight-bold">{{ trans('panel.have_event',['count' => !empty($unReadNotifications) ? count($unReadNotifications) : 0]) }}</span>
            </h2>

            <ul class="mt-15 unread-notification-lists">
                @if(!empty($unReadNotifications) and !$unReadNotifications->isEmpty())
                    @foreach($unReadNotifications->take(5) as $unReadNotification)
                        <li class="font-14 mt-1 text-gray">- {{ $unReadNotification->title }}</li>
                    @endforeach

                    @if(count($unReadNotifications) > 5)
                        <li>&nbsp;&nbsp;...</li>
                    @endif
                @endif
            </ul>

            <a href="/panel/notifications" class="mt-15 font-weight-500 text-dark-blue d-inline-block">{{ trans('panel.view_all_events') }}</a>

            <div class="dashboard-banner">
                <img src="{{ getPageBackgroundSettings('dashboard') }}" alt="" class="img-cover">
            </div>
        </div>

        <section class="assignments-table count-number-wrapp mt-30">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <ul class="count-number-boxes row">
                            <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="count-number-icon">
                                    <i data-feather="edit-2" width="20" height="20" class="" style="color:#8cc811"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>answered</h5>
                                    <strong>1,355</strong>
                                    <h5>questions</h5>
                                </div>
                            </li>
                            <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="count-number-icon">
                                    <i data-feather="clock" width="20" height="20" class="" style="color:#00aeef"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>spent</h5>
                                    <strong>11 hr 32 min</strong>
                                    <h5>practising</h5>
                                </div>
                            </li>
                            <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="count-number-icon">
                                    <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>Made progress in</h5>
                                    <strong>73</strong>
                                    <h5>skills</h5>
                                </div>
                            </li>
                            <li class="count-number-card col-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="count-number-icon">
                                    <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>Made progress in</h5>
                                    <strong>73</strong>
                                    <h5>skills</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


    </section>

    <div class="dashboard">
        <div class="row">
            <div class="col-12 col-lg-9 mt-35">
                <div class="assignments-table">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="homeworks-tab" data-toggle="tab" href="#homeworks" role="tab" aria-controls="homeworks" aria-selected="true">Today Homeworks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="recent-tab" data-toggle="tab" href="#recent" role="tab" aria-controls="recent" aria-selected="false">Recent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="future-tab" data-toggle="tab" href="#future" role="tab" aria-controls="future" aria-selected="false">Future</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="homeworks" role="tabpanel" aria-labelledby="homeworks-tab">
                            <div class="assignments-list">
                                <ul>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="book">
                                            <label for="book">
                                                Book p. 77-85, read & complete tasks 1-6 on p. 85
                                                <span>Physics</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt=""></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt=""></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt=""></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="workbook">
                                            <label for="workbook">
                                                Workbook p. 17, tasks 1-6
                                                <span>Mathematics</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label in-process">In Process</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="paragraph">
                                            <label for="paragraph">
                                                Learn Paragraph p. 99, Exercise 1,2,3scoping & Estimations
                                                <span>Chemistry</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="essay">
                                            <label for="essay">
                                                Write Essay 1000 words "WW2 results"
                                                <span>History</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="poems">
                                            <label for="poems">
                                                Internal conflict in philip Larkin poems, read p 380-515
                                                <span>English Language</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                            <div class="assignments-list">
                                <ul>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="book2">
                                            <label for="book2">
                                                Book p. 77-85, read & complete tasks 1-6 on p. 85
                                                <span>Physics</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt=""></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt=""></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt=""></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="workbook2">
                                            <label for="workbook2">
                                                Workbook p. 17, tasks 1-6
                                                <span>Mathematics</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label in-process">In Process</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="paragraph2">
                                            <label for="paragraph2">
                                                Learn Paragraph p. 99, Exercise 1,2,3scoping & Estimations
                                                <span>Chemistty</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="essay2">
                                            <label for="essay2">
                                                Write Essay 1000 words "WW2 results"
                                                <span>History</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="poems2">
                                            <label for="poems2">
                                                Internal conflict in philip Larkin poems, read p 380-515
                                                <span>English Language</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="future" role="tabpanel" aria-labelledby="future-tab">
                            <div class="assignments-list">
                                <ul>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="book3">
                                            <label for="book3">
                                                Book p. 77-85, read & complete tasks 1-6 on p. 85
                                                <span>Physics</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt=""></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt=""></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt=""></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="workbook3">
                                            <label for="workbook3">
                                                Workbook p. 17, tasks 1-6
                                                <span>Mathematics</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label in-process">In Process</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="paragraph3">
                                            <label for="paragraph3">
                                                Learn Paragraph p. 99, Exercise 1,2,3scoping & Estimations
                                                <span>Chemistty</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="essay3">
                                            <label for="essay3">
                                                Write Essay 1000 words "WW2 results"
                                                <span>History</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="poems3">
                                            <label for="poems3">
                                                Internal conflict in philip Larkin poems, read p 380-515
                                                <span>English Language</span>
                                            </label>
                                        </div>
                                        <div class="assignment-controls">
                                            <span class="status-label success">Done</span>
                                            <div class="controls-holder">
                                                <a href="#"><img src="../assets/default/svgs/printer-2-svgrepo-com.svg" alt="printer"></a>
                                                <a href="#"><img src="../assets/default/svgs/mail-alt-1-svgrepo-com.svg" alt="mail"></a>
                                                <a href="#"><img src="../assets/default/svgs/link-svgrepo-com.svg" alt="link"></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-35">
                <div class="bg-white account-balance rounded-sm panel-shadow py-15 py-md-30 px-10 px-md-20">
                    <div class="text-center">
                        <img src="/assets/default/img/activity/36.svg" class="account-balance-icon" alt="">

                        <h3 class="font-16 font-weight-500 text-gray mt-25">Reward Points</h3>
                        <span class="mt-5 d-block font-30 text-secondary">{{$userObj->getRewardPoints()}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-12 col-lg-12 mt-35">
            <section class="product-tabs-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-tabs">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="latest-toy-tab" data-toggle="tab" href="#latest-toy" role="tab" aria-controls="latest-toy" aria-selected="true">Latest Toy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="favorite-toys-tab" data-toggle="tab" href="#favorite-toys" role="tab" aria-controls="favorite-toys" aria-selected="false">Favorite Toys</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="productTabContent">
                                    <div class="tab-pane fade active show" id="latest-toy" role="tabpanel" aria-labelledby="latest-toy-tab">
                                        <div class="swiper-container product-tabs-slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/VTech-Ride-Go-Recycling-Truck" class="image-box__a">


                                                                    <img src="/store/1/Shop/2-1.jpg" class="img-cover" alt="VTech Ride - Go Recycling Truck">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/VTech-Ride-Go-Recycling-Truck">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">VTech Ride - Go Recycling Truck</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 500 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/VTech-Ride-Go-Recycling-Truck">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Magformers-Amazing-Police-And-Rescue-26-Piece-Set-1" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/amazing-police-and-rescue.jpeg" class="img-cover" alt="Magformers Amazing Police And Rescue 26 Piece Set">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Magformers-Amazing-Police-And-Rescue-26-Piece-Set-1">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Magformers Amazing Police And Rescue 26 Piece Set</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 600 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Magformers-Amazing-Police-And-Rescue-26-Piece-Set-1">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Hape-Baby-Einstein-Magic-Touch-Wooden-Piano" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/magic-touch-wooden-piano-01.jpg" class="img-cover" alt="Hape Baby Einstein Magic Touch Wooden Piano">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Hape-Baby-Einstein-Magic-Touch-Wooden-Piano">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Hape Baby Einstein Magic Touch Wooden Piano</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 300 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Hape-Baby-Einstein-Magic-Touch-Wooden-Piano">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Little-Tikes-Tap-A-Tune-Drum" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/tikes-tap-a-tune-drum-01.jpg" class="img-cover" alt="Little Tikes Tap A Tune Drum">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Little-Tikes-Tap-A-Tune-Drum">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Little Tikes Tap A Tune Drum</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 600 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Little-Tikes-Tap-A-Tune-Drum">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/geosafari-junior-kidnoculars-01.jpeg" class="img-cover" alt="Learning Resources GeoSafari Junior Kidnoculars">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Learning Resources GeoSafari Junior Kidnoculars</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 500 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/geosafari-junior-kidnoculars-01.jpeg" class="img-cover" alt="Learning Resources GeoSafari Junior Kidnoculars">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Learning Resources GeoSafari Junior Kidnoculars</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 500 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Add Arrows -->
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-button-next"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="favorite-toys" role="tabpanel" aria-labelledby="favorite-toys-tab">
                                        <div class="swiper-container product-tabs-slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/VTech-Ride-Go-Recycling-Truck" class="image-box__a">


                                                                    <img src="/store/1/Shop/2-1.jpg" class="img-cover" alt="VTech Ride - Go Recycling Truck">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/VTech-Ride-Go-Recycling-Truck">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">VTech Ride - Go Recycling Truck</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 500 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/VTech-Ride-Go-Recycling-Truck">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Magformers-Amazing-Police-And-Rescue-26-Piece-Set-1" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/amazing-police-and-rescue.jpeg" class="img-cover" alt="Magformers Amazing Police And Rescue 26 Piece Set">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Magformers-Amazing-Police-And-Rescue-26-Piece-Set-1">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Magformers Amazing Police And Rescue 26 Piece Set</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 600 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Magformers-Amazing-Police-And-Rescue-26-Piece-Set-1">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Hape-Baby-Einstein-Magic-Touch-Wooden-Piano" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/magic-touch-wooden-piano-01.jpg" class="img-cover" alt="Hape Baby Einstein Magic Touch Wooden Piano">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Hape-Baby-Einstein-Magic-Touch-Wooden-Piano">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Hape Baby Einstein Magic Touch Wooden Piano</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 300 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Hape-Baby-Einstein-Magic-Touch-Wooden-Piano">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Little-Tikes-Tap-A-Tune-Drum" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/tikes-tap-a-tune-drum-01.jpg" class="img-cover" alt="Little Tikes Tap A Tune Drum">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Little-Tikes-Tap-A-Tune-Drum">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Little Tikes Tap A Tune Drum</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 600 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Little-Tikes-Tap-A-Tune-Drum">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/geosafari-junior-kidnoculars-01.jpeg" class="img-cover" alt="Learning Resources GeoSafari Junior Kidnoculars">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Learning Resources GeoSafari Junior Kidnoculars</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 500 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="product-card">
                                                        <figure>
                                                            <div class="image-box">
                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars" class="image-box__a">


                                                                    <img src="/store/1/Shop/products images/geosafari-junior-kidnoculars-01.jpeg" class="img-cover" alt="Learning Resources GeoSafari Junior Kidnoculars">
                                                                </a>
                                                            </div>

                                                            <figcaption class="product-card-body">

                                                                <a href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">
                                                                    <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">Learning Resources GeoSafari Junior Kidnoculars</h3>
                                                                </a>

                                                                <div class="product-price-box mt-25">
                                                                    <span class="real font-14"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> 500 Coins</span>
                                                                </div>
                                                            </figcaption>
                                                            <button type="button" class="cart-button"><a class="bt-button" href="https://rurera.chimpstudio.co.uk/products/Learning-Resources-GeoSafari-Junior-Kidnoculars">BUY</a></button>
                                                        </figure>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Add Arrows -->
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-button-next"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="verticle-tabs">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
                            </div>
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="chart-box"> 
                                                <div class="chart-title text-center">
                                                    <h2>Pie Chart</h2>
                                                </div>
                                                <div class="chart">
                                                    <canvas id="pieChart" height="150"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="chart-box">
                                                <div class="chart-title text-center">
                                                    <h2>Pageviews</h2>
                                                </div>
                                                <div class="chart">
                                                    <canvas id="chartBarHorizontal2" height="428"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    Profile
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    Messages
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    Settings
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>
</div>

        <!-- <div class="row">
            <div class="col-12 col-lg-3 mt-35">
                <a href="@if($authUser->isUser()) /panel/webinars/purchases @else /panel/meetings/requests @endif" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center">
                    <div class="stat-icon requests">
                        <img src="/assets/default/img/icons/request.svg" alt="">
                    </div>
                    <div class="d-flex flex-column ml-15">
                        <span class="font-30 text-secondary">{{ !empty($pendingAppointments) ? $pendingAppointments : (!empty($webinarsCount) ? $webinarsCount : 0) }}</span>
                        <span class="font-16 text-gray font-weight-500">{{ $authUser->isUser() ? trans('panel.purchased_courses') : trans('panel.pending_appointments') }}</span>
                    </div>
                </a>

                <a href="@if($authUser->isUser()) /panel/meetings/reservation @else /panel/financial/sales @endif" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center mt-15 mt-md-30">
                    <div class="stat-icon monthly-sales">
                        <img src="@if($authUser->isUser()) /assets/default/img/icons/meeting.svg @else /assets/default/img/icons/monay.svg @endif" alt="">
                    </div>
                    <div class="d-flex flex-column ml-15">
                        <span class="font-30 text-secondary">{{ !empty($monthlySalesCount) ? handlePrice($monthlySalesCount) : (!empty($reserveMeetingsCount) ? $reserveMeetingsCount : 0) }}</span>
                        <span class="font-16 text-gray font-weight-500">{{ $authUser->isUser() ? trans('panel.meetings') : trans('panel.monthly_sales') }}</span>
                    </div>
                </a>
            </div>

            <div class="col-12 col-lg-3 mt-35">
                <a href="/panel/support" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center">
                    <div class="stat-icon support-messages">
                        <img src="/assets/default/img/icons/support.svg" alt="">
                    </div>
                    <div class="d-flex flex-column ml-15">
                        <span class="font-30 text-secondary">{{ !empty($supportsCount) ? $supportsCount : 0 }}</span>
                        <span class="font-16 text-gray font-weight-500">{{ trans('panel.support_messages') }}</span>
                    </div>
                </a>

                <a href="@if($authUser->isUser()) /panel/webinars/my-comments @else /panel/webinars/comments @endif" class="dashboard-stats rounded-sm panel-shadow p-10 p-md-20 d-flex align-items-center mt-15 mt-md-30">
                    <div class="stat-icon comments">
                        <img src="/assets/default/img/icons/comment.svg" alt="">
                    </div>
                    <div class="d-flex flex-column ml-15">
                        <span class="font-30 text-secondary">{{ !empty($commentsCount) ? $commentsCount : 0 }}</span>
                        <span class="font-16 text-gray font-weight-500">{{ trans('panel.comments') }}</span>
                    </div>
                </a>
            </div>

            <div class="col-12 col-lg-3 mt-35">
                <div class="bg-white account-balance rounded-sm panel-shadow py-15 py-md-15 px-10 px-md-20">
                    <div data-percent="{{ !empty($nextBadge) ? $nextBadge['percent'] : 0 }}" data-label="{{ (!empty($nextBadge) and !empty($nextBadge['earned'])) ? $nextBadge['earned']->title : '' }}" id="nextBadgeChart" class="text-center">
                    </div>
                    <div class="mt-10 pt-10 border-top border-gray300 d-flex align-items-center justify-content-between">
                        <span class="font-16 font-weight-500 text-gray">{{ trans('panel.next_badge') }}:</span>
                        <span class="font-16 font-weight-bold text-secondary">{{ (!empty($nextBadge) and !empty($nextBadge['badge'])) ? $nextBadge['badge']->title : trans('public.not_defined') }}</span>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-12 col-lg-12 mt-35">
                <div class="bg-white noticeboard rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                    <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('panel.noticeboard') }}</h3>

                    @foreach($authUser->getUnreadNoticeboards() as $getUnreadNoticeboard)
                        <div class="noticeboard-item py-15">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="js-noticeboard-title font-weight-500 text-secondary">{!! truncate($getUnreadNoticeboard->title,150) !!}</h4>
                                    <div class="font-12 text-gray mt-5">
                                        <span class="mr-5">{{ trans('public.created_by') }} {{ $getUnreadNoticeboard->sender }}</span>
                                        |
                                        <span class="js-noticeboard-time ml-5">{{ dateTimeFormat($getUnreadNoticeboard->created_at,'j M Y | H:i') }}</span>
                                    </div>
                                </div>

                                <div>
                                    <button type="button" data-id="{{ $getUnreadNoticeboard->id }}" class="js-noticeboard-info btn btn-sm btn-border-white">{{ trans('panel.more_info') }}</button>
                                    <input type="hidden" class="js-noticeboard-message" value="{{ $getUnreadNoticeboard->message }}">
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <section style="padding: 0 0 60px;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9 col-md-8 mt-35">
                    <div class="bg-white monthly-sales-card rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="font-16 text-dark-blue font-weight-bold">{{ ($authUser->isUser()) ? trans('panel.learning_statistics') : trans('panel.monthly_sales') }}</h3>

                            <span class="font-16 font-weight-500 text-gray">{{ dateTimeFormat(time(),'M Y') }}</span>
                        </div>

                        <div class="monthly-sales-chart">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-4 mt-35">
                    <div class="assignments-table count-number-wrapp">
                        <ul class="count-number-boxes count-number-verticle row">
                            <li class="count-number-card col-12">
                                <div class="count-number-icon">
                                    <i data-feather="edit-2" width="20" height="20" class="" style="color:#8cc811"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>answered</h5>
                                    <strong>1,355</strong>
                                    <h5>questions</h5>
                                </div>
                            </li>
                            <li class="count-number-card col-12">
                                <div class="count-number-icon">
                                    <i data-feather="clock" width="20" height="20" class="" style="color:#00aeef"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>spent</h5>
                                    <strong>11 hr 32 min</strong>
                                    <h5>practising</h5>
                                </div>
                            </li>
                            <li class="count-number-card col-12">
                                <div class="count-number-icon">
                                    <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>Made progress in</h5>
                                    <strong>73</strong>
                                    <h5>skills</h5>
                                </div>
                            </li>
                            <li class="count-number-card col-12">
                                <div class="count-number-icon">
                                    <i data-feather="bar-chart" width="20" height="20" class="" style="color:#e67035"></i>
                                </div>
                                <div class="count-number-body">
                                    <h5>Made progress in</h5>
                                    <strong>73</strong>
                                    <h5>skills</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="d-none" id="iNotAvailableModal">
        <div class="offline-modal">
            <h3 class="section-title after-line">{{ trans('panel.offline_title') }}</h3>
            <p class="mt-20 font-16 text-gray">{{ trans('panel.offline_hint') }}</p>

            <div class="form-group mt-15">
                <label>{{ trans('panel.offline_message') }}</label>
                <textarea name="message" rows="4" class="form-control ">{{ $authUser->offline_message }}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="mt-30 d-flex align-items-center justify-content-end">
                <button type="button" class="js-save-offline-toggle btn btn-primary btn-sm">{{ trans('public.save') }}</button>
                <button type="button" class="btn btn-danger ml-10 close-swl btn-sm">{{ trans('public.close') }}</button>
            </div>
        </div>
    </div>

    <div class="d-none" id="noticeboardMessageModal">
        <div class="text-center">
            <h3 class="modal-title font-20 font-weight-500 text-dark-blue"></h3>
            <span class="modal-time d-block font-12 text-gray mt-25"></span>
            <p class="modal-message font-weight-500 text-gray mt-4"></p>
        </div>
    </div>

@endsection

@push('scripts_bottom')
        <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/default/vendors/chartjs/chart.min.js"></script>

    <script>
        var offlineSuccess = '{{ trans('panel.offline_success') }}';
        var $chartDataMonths = @json($monthlyChart['months']);
        var $chartData = @json($monthlyChart['data']);
    </script>

    <script src="/assets/default/js/panel/dashboard.min.js"></script>
        <script type="text/javascript">
            feather.replace();
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
