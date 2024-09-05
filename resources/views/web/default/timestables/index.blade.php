@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style type="text/css">
    .timestables-mode-block{display:none;}
</style>
@endpush

@section('content')
<section class="content-section">
    <section class="page-section template-grid mx-w-100 p-0 news-section mb-30">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 mb-30">
                        <div class="timestables-modes row">
                            <div class="col-12 col-lg-12 col-md-12">
                                <div class="section-title mb-30">
                                <h2 itemprop="title" class="font-22 mb-0">Time Tables</h2>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 rurera-hide">
                            <ul class="tests-list type-list mb-30">
                                <li data-type="single-player" class="active"><img src="/assets/default/img/single.png" alt=""> Single Player</li>
                                <li data-type="multi-player"><img src="/assets/default/img/multi.png" alt=""> Multi Player</li>
                            </ul>
                        </div>


                        <div class="type-list-data single-player-data">
                            <div class="col-12 col-md-12 col-lg-12">
                                <a itemprop="url" href="/timestables-practice/freedom-mode">
                                    <div class="grid-card timestables-mode-data" data-mode_type="freedom_mode" itemtype="https://schema.org/NewsArticle">
                                        <div class="text-holder">
                                            <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                                Freedom mode
                                            </h3>
                                        </div>
                                        <div class="img-holder">
                                            <img src="/assets/default/svgs/eagle.svg" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" itemprop="image" loading="eager">
                                        </div>
                                        <p class="text-gray">Explore multiplication, division, or both at your own pace.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <a itemprop="url" href="/timestables-practice/powerup-mode">
                                    <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                        <div class="text-holder">
                                            <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                                Power-up Heatmap
                                            </h3>
                                        </div>
                                        <div class="img-holder">
                                            <img src="/assets/default/svgs/battery-level.svg" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" itemprop="image" loading="eager">
                                        </div>
                                        <p class="text-gray">Conquer questions to turn your heatmap green.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <a itemprop="url" href="/timestables-practice/trophy-mode">
                                    <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                        <div class="text-holder">
                                            <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                                Trophy Mode
                                            </h3>
                                        </div>
                                        <div class="img-holder">
                                            <img src="/assets/default/svgs/shuttlecock.svg" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" itemprop="image" loading="eager">
                                        </div>
                                        <p class="text-gray">Speed trophy badge by playing 10 games.</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-md-12 col-lg-12">
                                <a itemprop="url" href="/timestables-practice/treasure-mission">
                                    <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                        <div class="text-holder">
                                            <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                                Treasure Mission
                                            </h3>
                                            <div class="coin-counts">
                                            <strong>
                                                <img src="/assets/default/img/panel-sidebar/heart-red.png" alt="">
                                                {{$authUser->user_life_lines}}
                                            </strong>
                                            </div>
                                        </div>
                                        <div class="img-holder">
                                            <img src="/assets/default/img/treasure.png" class="img-cover" alt="How Online Courses Benefit KS1 and KS2 Students" title="How Online Courses Benefit KS1 and KS2 Students" itemprop="image" loading="eager">
                                        </div>
                                        <p class="text-gray">Journey through times tables practice and discover hidden treasures.</p>
                                        
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-md-12 col-lg-12">
                                <a itemprop="url" href="/timestables-practice/showdown-mode">
                                    <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                        <div class="text-holder">
                                            <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                                Showdown
                                            </h3>
                                        </div>
                                        <div class="img-holder">
                                            <img src="/assets/default/img/showdown.png" class="img-cover" alt="How Online Courses Benefit KS1 and KS2 Students" title="How Online Courses Benefit KS1 and KS2 Students" itemprop="image" loading="eager">
                                        </div>
                                        <p class="text-gray">Journey through times tables practice and discover hidden treasures.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <a itemprop="url" href="/timestables-practice/heat-map">
                                    <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                        <div class="text-holder">
                                            <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                                Heat Map
                                            </h3>
                                        </div>
                                        <div class="img-holder">
                                            <img src="/assets/default/svgs/fire.svg" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" itemprop="image" loading="eager">
                                        </div>
                                        <p class="text-gray">Colours visualization for user data in heatmap</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <a itemprop="url" href="/panel/analytics">
                                    <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                        <div class="text-holder">
                                            <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                                Analytics
                                            </h3>
                                        </div>
                                        <div class="img-holder">
                                            <img src="/assets/default/svgs/analytics.svg" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" itemprop="image" loading="eager">
                                        </div>
                                        <p class="text-gray">Connect with individuals worldwide in a Cloud.</p>

                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="type-list-data multi-player-data rurera-hide">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                    <div class="text-holder">
                                        <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                        <a class="grid-btn" itemprop="Button" href="javascript:;">Tournament</a>
                                            <span class="title-label">Coming Soon</span>
                                        </h3>
                                    </div>
                                    <div class="img-holder">
                                        <img src="/assets/default/svgs/worldCup-colord.svg" class="img-cover" alt="Preparing for Success: Online Courses for Year 5 Students" title="Preparing for Success: Online Courses for Year 5 Students" itemprop="image" loading="eager">
                                    </div>
                                    <p class="text-gray">Play and compete with classmates in exciting challenges.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="grid-card timestables-mode-data" itemtype="https://schema.org/NewsArticle">
                                    <div class="text-holder">
                                        <h3 class="blog-grid-title font-18 font-weight-bold" itemprop="title">
                                            <a class="grid-btn" itemprop="Button" href="javascript:;">Global Arena
                                                <span class="title-label">Coming Soon</span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="img-holder">
                                        <img src="/assets/default/svgs/global-arena.svg" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" itemprop="image" loading="eager">
                                    </div>
                                    <p class="text-gray">Connect with individuals worldwide in a Cloud.</p>

                                </div>
                            </div>
                        </div>

                        </div>
                        <div class="timestables-mode-block">
                            <a href="javascript:;" class="timestables-back-btn">Back</a>
                            <div class="timestables-mode-content">

                            </div>
                        </div>
                </div>
                </div>
            </div>
    </section>

    <div class="show-section-data">

    </div>



    <section class="page-section py-60 tournament-sec hide-sec" style="background-color:#333">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title mb-30">
                      <a href="#" itemprop="button" class="back-btn mb-30" style="margin-right: auto;">
                        <span>←</span>
                    </a>
                        <h1 itemprop="title" class="font-50 font-weight-bold mb-0 text-white">Tournament Tropics</h1>
                    </div>
                  </div>
                <div class="col-lg-12">
                    <div class="listings-card">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="deals-card bg-danger">
                                                <div class="card">
                                                    <div class="card-timer">
                                                        <p id="timer">60</p>
                                                    </div>
                                                    <a href="#">
                                                        <h5>Michigan Stadium</h5>
                                                        <p>$265,200 <span>4 Deals</span></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <div class="card-btn">
                                                        <a href="#"><i>&#x207A;</i> Join tournament</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Emma Thompson</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 98,321 <span>Whiz</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Liam Parker</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 75,092 <span>Enthusiast</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Olivia Turner</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 120,876 <span>Rockstar</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Lily Johnson</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 105,678 <span>Mastermind</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Grace Murphy</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 80,123 <span>Whiz</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Aiden Carter</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 45,678 <span>Rookie</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Chloe Adams</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 99,876 <span>Prodigy</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Lucas Martin</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 60,432 <span>Enthusiast</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Ella White</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 110,234 <span>Rockstar</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="deals-card bg-success">
                                                <div class="card">
                                                    <a href="#">
                                                        <h5>Beaver Stadium</h5>
                                                        <p>108,700<span>5 Deals</span></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <div class="card-btn">
                                                        <a href="#"><i>&#x207A;</i> Join tournament</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Mason Taylor</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 95,678 <span>Legend</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Amelia Davis</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 76,543 <span>Maestro</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Benjamin Reed</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 88,765 <span>Dynamo</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Oliver Wright</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 72,543 <span>Virtuoso</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="deals-card bg-warning">
                                                <div class="card">
                                                    <a href="#">
                                                        <h5>Noah Davis</h5>
                                                        <p>85,723 <span>Prodigy</span></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <div class="card-btn">
                                                        <a href="#"><i>&#x207A;</i> Join tournament</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Ava Smith</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 56,490 <span>Rookie</span>1</p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>James Lee</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 112,345 <span>Mastermind</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Mia Garcia</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 92,567 <span>Virtuoso</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="deals-card bg-info">
                                                <div class="card">
                                                    <a href="#">
                                                        <h5>Ethan Wilson</h5>
                                                        <p>103,456 <span>Dynamo</span></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <div class="card-btn">
                                                        <a href="#"><i>&#x207A;</i> Join tournament</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Sophia Brown</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 68,234 <span>Maestro</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                <div class="text">
                                                                    <h6>Jackson Hall</h6>
                                                                    <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 115,678 <span>Legend</span></p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $( window ).on( "load", function() {
                if(jQuery('.listings-card .swiper-container').length > 0){
                const swiper = new Swiper(".listings-card .swiper-container", {
                    slidesPerView: 4,
                    spaceBetween: 20,
                    observer: true,
                    observeParents: true,
                    loop: true,
                    autoplay: { delay: 5e3, disableOnInteraction: !1 },
                    breakpoints: {
                      991: {
                        slidesPerView: 4,
                        spaceBetween: 20
                      },
                      660: {
                        slidesPerView: 1,
                        spaceBetween: 0
                      },
                      480: {
                        slidesPerView: 1,
                        spaceBetween: 0
                      },
                      320: {
                        slidesPerView: 1,
                        spaceBetween: 0
                      }
                    },
                });
              }
            });
        </script>
    </section>
    <section class="page-section py-60 no-challeng-sec hide-sec" style="background-color:#333">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title mb-50">
                        <a href="#" itemprop="button" class="back-btn mb-30" style="margin-right: auto;">
                            <span>←</span>
                        </a>
                        <h1 class="font-50 font-weight-bold mb-0 text-white">Challenge Chamber</h1>
                    </div>
                    <div class="challenge-box-outer">
                        <div class="challenge-box">
                            <div class="challenge-controls nav" id="myTab2" role="tablist">
                                <ul class="nav" id="myTab" role="tablist">
                                    <li class="nav-item">
                                      <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true">New</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false">Sent</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Completed</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <p>No Challenge here..</p>
                                </div>
                                <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                                    <table class="simple-table text-left">
                                        <thead>
                                            <tr>
                                                <th>When</th>
                                                <th>To</th>
                                                <th>Your Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>439 days ago</td>
                                                <td>Mr Arnott</td>
                                                <td>70</td>
                                            </tr>
                                            <tr>
                                                <td>505 days ago</td>
                                                <td>Mr. G. O. A. T</td>
                                                <td>67</td>
                                            </tr>
                                            <tr>
                                                <td>528 days ago</td>
                                                <td>Emily Keeling</td>
                                                <td>36</td>
                                            </tr>
                                            <tr>
                                                <td>640 days ago</td>
                                                <td>POR vs FRA</td>
                                                <td>68</td>
                                            </tr>
                                            <tr>
                                                <td>677 days ago</td>
                                                <td>Miss Joshi</td>
                                                <td>22</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                                    <table class="simple-table">
                                        <thead>
                                            <tr>
                                                <th>Opponent</th>
                                                <th>Their score</th>
                                                <th>Your score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>OphXlia</td>
                                                <td>35</td>
                                                <td>33</td>
                                            </tr>
                                            <tr>
                                                <td>Sanrio Girl</td>
                                                <td>58</td>
                                                <td>73</td>
                                            </tr>
                                            <tr>
                                                <td>OphXlia</td>
                                                <td>33</td>
                                                <td>55</td>
                                            </tr>
                                            <tr>
                                                <td>OphXlia</td>
                                                <td>33</td>
                                                <td>40</td>
                                            </tr>
                                            <tr>
                                                <td>OphXlia</td>
                                                <td>23</td>
                                                <td>40</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
<script src="/assets/default/vendors/chartjs/chart.min.js"></script>
<script>

    $(document).on('click', '.timestables-back-btn', function (e) {
        $(".timestables-mode-block").slideUp();
        $(".timestables-modes").slideDown();
    });
$(document).on('click', '.ajax-callback', function (e) {
    var thisObj = $(this);
    var thisContent_div = $(".timestables-mode-content");
    var ajax_type = $(this).attr('data-type');
    rurera_loader(thisObj.closest('.timestables-mode-data'), 'div');
    jQuery.ajax({
       type: "GET",
       url: '/timestables/'+ajax_type,
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {'ajax_type':ajax_type},
       success: function (return_data) {
           thisContent_div.html(return_data);
           //jQuery(".show-section-data").html(return_data);
           $(".timestables-modes").slideUp();
           $(".timestables-mode-block").slideDown();
           rurera_remove_loader(thisObj.closest('.timestables-mode-data'), 'div');
       }
   });
});

$(document).on('click', '.week-selection-btn', function (e) {
    var thisObj = $(this);
    var week_no = $(this).attr('data-week_no');
    var thisContent_div = $(".timestables-mode-content");
    var ajax_type = 'showdown_mode';
    rurera_loader(thisContent_div, 'div');
    jQuery.ajax({
       type: "GET",
       url: '/timestables/'+ajax_type,
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {'ajax_type':ajax_type, 'weekNumber':week_no},
       success: function (return_data) {
           thisContent_div.html(return_data);
           //jQuery(".show-section-data").html(return_data);
           $(".timestables-modes").slideUp();
           $(".timestables-mode-block").slideDown();
           rurera_remove_loader(thisContent_div, 'div');
       }
   });
});


$(document).on('click', '.type-list li', function (e) {
    $(".type-list li").removeClass('active');
    $(this).addClass('active');
    var data_type = $(this).attr('data-type');
    $(".type-list-data").addClass('rurera-hide');
    $("."+data_type+"-data").removeClass('rurera-hide');

});
$(document).on('click', '.back-btn', function (e) {
    $('.deals-section').addClass("hide-sec");
    $('.challenge-sec').addClass("hide-sec");
    $('.no-challeng-sec').addClass("hide-sec");
    $('.tournament-sec').addClass("hide-sec");
    $('.news-section').removeClass("hide-sec");
    e.preventDefault();
});
</script>

<script>
    $(document).ready(function () {
        if(jQuery('.back-btn').length > 0){
        $('.back-btn').on('click', function(e) {
            $('.deals-section').addClass("hide-sec");
            $('.challenge-sec').addClass("hide-sec");
            $('.no-challeng-sec').addClass("hide-sec");
            $('.tournament-sec').addClass("hide-sec");
            $('.news-section').removeClass("hide-sec");
            e.preventDefault();
        });
        }

        if(jQuery('.template-grid .grid-btn1').length > 0){
        $('.template-grid .grid-btn1').on('click', function(e) {
            $('.news-section').addClass("hide-sec");
            $('.deals-section').removeClass("hide-sec");
            e.preventDefault();
        });

        }
        if(jQuery('.template-grid .challenge-btn').length > 0){
            $('.template-grid .challenge-btn').on('click', function(e) {
                //$('.news-section').addClass("hide-sec");
                $('.deals-section').addClass("hide-sec");
                $('.challenge-sec').addClass("hide-sec");
                $('.no-challeng-sec').removeClass("hide-sec");
                e.preventDefault();
            });
        }
        if(jQuery('.template-grid .assignment-btn').length > 0){
            $('.template-grid .assignment-btn').on('click', function(e) {
                //$('.news-section').addClass("hide-sec");
                $('.deals-section').addClass("hide-sec");
                $('.no-challeng-sec').addClass("hide-sec");
                $('.challenge-sec').removeClass("hide-sec");
                e.preventDefault();
            });
        }
        if(jQuery('.template-grid .tournament-btn').length > 0){
            $('.template-grid .tournament-btn').on('click', function(e) {
                //$('.news-section').addClass("hide-sec");
                $('.deals-section').addClass("hide-sec");
                $('.no-challeng-sec').addClass("hide-sec");
                $('.challenge-sec').addClass("hide-sec");
                $('.tournament-sec').removeClass("hide-sec");
                e.preventDefault();
            });
        }
    });
</script>

<script>
    $( window ).on( "load", function() {
        if(jQuery('.listings-card .swiper-container').length > 0){
        const swiper = new Swiper(".listings-card .swiper-container", {
            slidesPerView: 4,
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            loop: true,
            autoplay: { delay: 5e3, disableOnInteraction: !1 },
            breakpoints: {
              991: {
                slidesPerView: 4,
                spaceBetween: 20
              },
              660: {
                slidesPerView: 1,
                spaceBetween: 0
              },
              480: {
                slidesPerView: 1,
                spaceBetween: 0
              },
              320: {
                slidesPerView: 1,
                spaceBetween: 0
              }
            },
        });
      }
    });
</script>

@endpush

