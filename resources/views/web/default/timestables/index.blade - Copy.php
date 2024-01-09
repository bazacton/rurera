@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="content-section">
    <section class="page-section template-grid mx-w-100 py-60 news-section" style="background-color:#333">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 mb-10">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="section-title mb-50">
                                <h1 itemprop="title" class="font-50 font-weight-bold mb-0 text-white">Time Tables</h1>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                              <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-3.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                              </div>
                              <div class="text-holder">
                                <h3 class="blog-grid-title" itemprop="title">
                                  <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Freedom mode</a>
                                </h3>
                              </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                                <div class="img-holder">
                                    <img src="/store/1/default_images/blogs/blog-19.png" class="img-cover" alt="Preparing for Success: Online Courses for Year 5 Students" title="Preparing for Success: Online Courses for Year 5 Students" width="100%" height="160" itemprop="image" loading="eager">
                                </div>
                                <div class="text-holder">
                                    <h3 class="blog-grid-title" itemprop="title">
                                        <a class="assignment-btn ajax-callback" data-type="assignment_chase" itemprop="url" href="javascript:;">Assignment Chase</a>
                                    </h3>
                                    <span class="assignment-count">5</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                                <div class="img-holder">
                                    <img src="/store/1/default_images/blogs/blog-38.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                                </div>
                                <div class="text-holder">
                                    <h3 class="blog-grid-title" itemprop="title">
                                        <a class="challenge-btn" itemprop="Button" href="#">Challenge Chamber</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                              <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-18.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                              </div>
                              <div class="text-holder">
                                <h3 class="blog-grid-title" itemprop="title">
                                  <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Power-Up Junction</a>
                                </h3>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12">
                    <div class="row">
                      <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                          <div class="img-holder">
                            <img src="/store/1/default_images/blogs/blog-3.png" class="img-cover" alt="How Online Courses Benefit KS1 and KS2 Students" title="How Online Courses Benefit KS1 and KS2 Students" width="100%" height="160" itemprop="image" loading="eager">
                          </div>
                          <div class="text-holder">
                            <h3 class="blog-grid-title" itemprop="title">
                              <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Treasure Mission</a>
                            </h3>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                          <div class="img-holder">
                            <img src="/store/1/default_images/blogs/blog-19.png" class="img-cover" alt="Preparing for Success: Online Courses for Year 5 Students" title="Preparing for Success: Online Courses for Year 5 Students" width="100%" height="160" itemprop="image" loading="eager">
                          </div>
                          <div class="text-holder">
                            <h3 class="blog-grid-title" itemprop="title">
                              <a class="tournament-btn" itemprop="Button" href="#">Tournament Tropics</a>
                            </h3>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-38.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <h3 class="blog-grid-title" itemprop="title">
                                    <a class="grid-btn ajax-callback" data-type="global_arena"  itemprop="Button" href="javascript:;">Global Arena</a>
                                </h3>
                            </div>
                        </div>
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
                    <div class="section-title mb-50">
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
<section class="pt-80 pb-30" style="background-color: #f8f8f8;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-50 text-center"><h2>Select Arithmetic Operations </h2></div>
            </div>
            <div class="col-12 col-lg-8 mx-auto mb-50">
                <form action="/timestables/generate" method="post">
                    {{ csrf_field() }}
                    <div class="questions-select-option">
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input  type="radio" value="multiplication_division" id="multi-divi" name="question_type" />
                                <label for="multi-divi" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">
                                    8 per correct answer
                                </span>
                                <strong>Multiplication and Division</strong>
                                </label>
                            </li>
                            <li>
                                <input checked type="radio" value="multiplication" id="multi-only" name="question_type" />
                                <label for="multi-only" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">4 per correct answer</span>
                                <strong>Multiplication only</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" value="division" id="divi-only" name="question_type" />
                                <label for="divi-only" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">4 per correct answer</span>
                                <strong>Division only</strong>
                                </label>
                            </li>
                        </ul>
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input checked type="radio" id="ten-questions" value="10" name="no_of_questions" />
                                <label for="ten-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>10 questions</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="twenty-questions" value="20" name="no_of_questions" />
                                <label for="twenty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>20 questions</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="thirty-questions" value="30" name="no_of_questions" />
                                <label for="thirty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>30 questions</strong>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="questions-select-number">
                        <ul class="d-flex justify-content-center flex-wrap mb-30">
                        <li><input type="checkbox" value="10" name="question_values[]" id="ten" /> <label for="ten" >10</label></li>
                        <li><input type="checkbox" value="2" name="question_values[]" id="two" /> <label for="two">2</label></li>
                        <li><input type="checkbox" value="5" name="question_values[]" id="five" /> <label for="five" >5</label></li>
                        <li><input type="checkbox" value="3" name="question_values[]" checked id="three" /> <label for="three">3</label></li>
                        <li><input type="checkbox" value="4" name="question_values[]" checked id="four" /> <label for="four">4</label></li>
                        <li><input type="checkbox" value="8" name="question_values[]" id="eight" /> <label for="eight">8</label></li>
                        <li><input type="checkbox" value="6" name="question_values[]" id="six" /> <label for="six">6</label></li>
                        <li><input type="checkbox" value="7" name="question_values[]" id="seven" /> <label for="seven">7</label></li>
                        <li><input type="checkbox" value="9" name="question_values[]" id="nine" /> <label for="nine">9</label></li>
                        <li><input type="checkbox" value="11" name="question_values[]" id="eleven" /> <label for="eleven">11</label></li>
                        <li><input type="checkbox" value="12" name="question_values[]" id="twelve" /> <label for="twelve" >12</label></li>
                        <li><input type="checkbox" value="13" name="question_values[]" id="thirteen" /> <label for="thirteen" >13</label></li>
                        <li><input type="checkbox" value="14" name="question_values[]" id="fourteen" /> <label for="fourteen" >14</label></li>
                        <li><input type="checkbox" value="15" name="question_values[]" id="fifteen" /> <label for="fifteen" >15</label></li>
                        <li><input type="checkbox" value="16" name="question_values[]" id="sixteen" /> <label for="sixteen" >16</label></li>
                        </ul>
                    </div>
                    <div class="form-btn">
                        <button type="submit" class="questions-submit-btn btn"><span>Play</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="mb-50 mt-20 template-grid mx-w-100 mb-60 pt-50">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-title mb-30 d-flex justify-content-between align-items-center">
                    <h2 itemprop="title" class="font-30 mb-0 text-dark-charcoal">Templates</h2>
                    <a href="#" itemprop="button" class="seemore-btn">See More <span>›</span> </a>
                </div>
            </div>
            <div class="col-12 col-lg-12 mb-30">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-3.png" class="img-cover" alt="How Online Courses Benefit KS1 and KS2 Students" title="How Online Courses Benefit KS1 and KS2 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Daily Check-in</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">4 Questions</li>
                                    <li itemprop="name">11.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-19.png" class="img-cover" alt="Preparing for Success: Online Courses for Year 5 Students" title="Preparing for Success: Online Courses for Year 5 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Lesson</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Gratitude Lesson - SEL (Inspired by..) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">2 Questions</li>
                                    <li itemprop="name">15.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-38.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 6th Grade (with new question) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">5 Questions</li>
                                    <li itemprop="name">8.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-18.png" class="img-cover" alt="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" title="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 3rd Grade (with new question)</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">3 Questions</li>
                                    <li itemprop="name">12.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-title mb-30 d-flex justify-content-between align-items-center">
                    <h2 itemprop="title" class="font-30 mb-0 text-dark-charcoal">Mathematics</h2>
                    <a href="#" itemprop="button" class="seemore-btn">See More <span>›</span> </a>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-3.png" class="img-cover" alt="How Online Courses Benefit KS1 and KS2 Students" title="How Online Courses Benefit KS1 and KS2 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Daily Check-in</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">4 Questions</li>
                                    <li itemprop="name">11.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-19.png" class="img-cover" alt="Preparing for Success: Online Courses for Year 5 Students" title="Preparing for Success: Online Courses for Year 5 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Lesson</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Gratitude Lesson - SEL (Inspired by..) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">2 Questions</li>
                                    <li itemprop="name">15.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-38.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 6th Grade (with new question) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">5 Questions</li>
                                    <li itemprop="name">8.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-18.png" class="img-cover" alt="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" title="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Lesson</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 3rd Grade (with new question)</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">3 Questions</li>
                                    <li itemprop="name">12.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="lms-column-section lms-text-section w-100 pt-50 pb-50" style="background: url(assets/default/svgs/bank-note.svg) #f27530;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="lms-text-holder d-flex flex-column justify-content-center text-center">
                    <h2 itemprop="title" class="mb-20 text-white">Get Started</h2> <strong itemprop="description" class="text-white">Want to find out more or arrange a free trial ?</strong>
                    <div class="lms-btn-group mt-30 justify-content-center"><a itemprop="url" href="{{url('/')}}/register" class="lms-btn rounded-pill text-white border-white">Join Rurera today</a></div>
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
<script>
$(document).on('click', '.ajax-callback', function (e) {
    var thisObj = $(this);
    var ajax_type = $(this).attr('data-type');
    rurera_loader($(".news-section"), 'div');
    jQuery.ajax({
       type: "GET",
       url: '/timestables/'+ajax_type,
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {'ajax_type':ajax_type},
       success: function (return_data) {
           $('.news-section').addClass("hide-sec");
           jQuery(".show-section-data").html(return_data);
           rurera_remove_loader($(".news-section"), 'button');
       }
   });
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
