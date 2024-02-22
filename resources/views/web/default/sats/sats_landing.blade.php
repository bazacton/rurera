@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .gallery-sub-header {
        min-height: 480px;
    }
    .lms-search-services {
        background-color: #f27530;
    }
    .lms-column-section {
        background-color: #7679ee;
    }
    .choose-sats-section {
        background-color:#3d358b;
    }
</style>
@endpush

@section('content')
<section class="content-section">
    <section class="position-relative job-singup-sub-header gallery-sub-header pb-80 pt-80 mb-0">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 col-md-6 col-lg-6">
                    <h1 class="font-50 font-weight-bold">Online <span class="text-scribble mr-10">SATs</span>Exam Practice</h1>
                    <h2 class="mb-15 font-30">Maximize Your Performance: Excel on SATs Test Day</h2>
                    <p class="font-19">
                        Don't leave your SATs Exam performance to chance. Join us and unlock your full potential for success
                        on the SATs tests!
                    </p>
                    <ul class="mb-30 p-0">
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/mobile.svg" width="25" height="25" alt="#">SATs Quizzes & Assessments
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/preparation.svg" width="25" height="25" alt="#">SATs Tests
                            preparation
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/graphic-design.svg" width="25" height="25" alt="#">SATs Exam Score
                            guarantee
                        </li>
                        <li class="font-19">
                            <img src="../assets/default/svgs/book-opend.svg" width="25" height="25" alt="#">SATs Resources - 100% results
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="{{url('/')}}/register" class="btn-primary rounded-pill">KS1-year2 SATs</a>
                        <a href="{{url('/')}}/register" class="btn-primary rounded-pill ml-15">KS2-year6 SATs</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="masonry-grid-gallery has-bg simple">
            <div class="masonry-grid">
                <div class="row">
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-16.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-16.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-17.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-17.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-18.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-19.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-18.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-19.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-22.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-22.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-22.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-16.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-18.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-18.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-22.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-19.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-17.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/key-19.png" width="140" height="59" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-18.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure>
                                <a href="{{url('/')}}/register">
                                    <img src="/store/1/default_images/sats-header/ks1-22.png" width="140" height="45" alt="#" class="rounded">
                                </a>
                            </figure>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="lms-search-services mb-0 mt-0 pt-80 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10 text-white font-40">SATs Exam Practice steps to Success with Rurera</h2>
                        <p class="text-white font-19">
                            Work through a variety of SATs practice and SATs quizzes questions to improve your skills
                            and become familiar with the <br/>
                            types of questions you'll encounter on the SATs exam.
                        </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="process-holder">
                        <ul class="process-list d-flex justify-content-center steps-3 has-bg">
                            <li class="process-item"><a href="#" class="text-white">step 1</a></li>
                            <li class="process-item"><a href="#" class="text-white">step 2</a></li>
                            <li class="process-item"><a href="#" class="text-white">step 3</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="process-card mt-40 mb-30 text-center">
                        <div class="process-card-body">
                            <div class="text-holder">
                                <h3 class="post-title text-white">Learn &amp; Understand</h3>
                                <p class="mt-15 text-white">
                                    Build knowledge through SATs quizzes, SATs tests and SATs assessments with
                                    immediate feedback.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="process-card mt-40 mb-30 text-center">
                        <div class="process-card-body">
                            <div class="text-holder">
                                <h3 class="post-title text-white">Take SATs Practice Tests</h3>
                                <p class="mt-15 text-white">
                                    Improve SATs exam skills and target weak areas for success and
                                    improve your SATs tests.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="process-card mt-40 mb-30 text-center">
                        <div class="process-card-body">
                            <div class="text-holder">
                                <h3 class="post-title text-white">Track progress</h3>
                                <p class="mt-15 text-white">
                                    Monitor SATs practice and SATs assessments progress and identify areas of improvement.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="key-stage-section mt-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-left mb-40">
                        <h2 class="mb-15 font-40">
                            So Many SATs Resources, <br/>
                            So Many Ways for SATs Exam Practices..
                        </h2>
                        <p class="font-19 text-gray">
                            With consistent effort and effective SATs resources and SATs papers, you can improve <br/> your performance on the SATs exam day.
                        </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="element-title has-bg"><h2 class="text-white m-0">key Stage 1</h2></div>
                </div>
                <div class="col-12">
                    <ul class="lms-key-stage-table bg-table mt-30">
                        <li class="lms-key-stage-head">
                            <div class="lms-key-stage keystage-title border-none"></div>
                            <div class="lms-key-stage"><h3>English - Reading</h3></div>
                            <div class="lms-key-stage"><h3>English - SPaG</h3></div>
                            <div class="lms-key-stage"><h3>Math - Arithmetic</h3></div>
                            <div class="lms-key-stage"><h3>Math - Reasoning</h3></div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2022</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img">
                                        <img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img">
                                        <img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2019</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2018</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img">
                                        <img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2017</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2016</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#"/>
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#"/>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-column-section lms-text-section mx-w-100 mt-80 mb-80 pt-70 pb-70 pr-30 pl-30">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="lms-text-holder d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <h4 class="mb-10 font-30 align-items-center d-flex text-white">
                                <span class="icon-svg mr-15">
                                    <img src="../assets/default/svgs/bulb-white.svg" height="35" width="35" alt="#">
                                </span>
                                Exploring the National Curriculum in the UK?
                            </h4>
                            <p class="font-16 text-white"> Our resources will help you navigate and provide a
                                comprehensive<br> learning experience for your students.</p>
                        </div>
                        <div class="lms-btn-group justify-content-center">
                            <a href="{{url('/')}}/national-curriculum" class="lms-btn rounded-pill text-white border-white">Find more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative mt-80">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="section-title text-left mb-50">
                    <h2 class="mt-0 mb-10 font-40">Challenging the SATs with Confidence</h2>
                    <p class="font-19 text-gray">
                        Rurera offer the capability to track their onscreen and practiced time activity well remaining
                        on system and <br/>
                        can analyze the performance against each topic.
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="">
                    <h2 class="font-40 text-dark">KS1 SATs, KS2 SATs practice</h2>
                    <p class="font-16 text-gray mt-10">
                        Rurera provide opportunity to practice KS1, KS2 SATs online as per past curriculum exams and avoid wasting
                        time creating your own SATs tests, choose from one of the given SATs assignment from past SATs papers.
                    </p>
                    <div class="mt-35 d-flex align-items-center">
                        <a href="{{url('/')}}/membership" class="btn btn-primary">Start SATs Practice</a>
                        <a href="{{url('/')}}/membership" class="btn btn-outline-primary ml-15">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative">
                    <img src="/store/1/default_images/home_sections_banners/learning-practice.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer"/>
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle"/> 
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots"/>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative">
                    <img src="/store/1/default_images/home_sections_banners/quiz-sats.jpg" class="find-instructor-section-hero" width="400" height="460" alt="Track Student Progress"/>
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle"/> 
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots"/>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="">
                    <h2 class="font-40 text-dark">SATs Quizzes & SATs Assessments</h2>
                    <p class="font-16 text-gray mt-10">
                        Students can take SATs quizzes and SATs assessments to test their knowledge. The SATs tests evaluate your child’s
                        knowledge in: English, Maths, Science, Computing, English Reading for pleasure, Design and
                        technology as a result of SATs exam practice.
                    </p>
                    <div class="mt-35 d-flex align-items-center">
                        <a href="{{url('/')}}/membership" class="btn btn-primary">Take a SATs Quiz</a>
                        <a href="{{url('/')}}/membership" class="btn btn-outline-primary ml-15">Moniter performance</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="">
                    <h2 class="font-40 text-dark">Individual Performance Analysis</h2>
                    <p class="font-16 text-gray mt-10">
                        Performance Analysis is essential for SATs exam practice. Rurera offers
                        a user-friendly platform where teachers can analyze individual and group performance trends.
                    </p>
                    <div class="mt-35 d-flex align-items-center">
                        <a href="{{url('/')}}/membership" class="btn btn-primary">Track performance</a>
                        <a href="{{url('/')}}/membership" class="btn btn-outline-primary ml-15">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative">
                    <img src="/store/1/default_images/home_sections_banners/individual-performance.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer"/>
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle"/> 
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots"/>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative">
                    <img src="/store/1/default_images/home_sections_banners/activity-tracking.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer"/>
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle"/> 
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots"/>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div>
                    <h2 class="font-40 text-dark">Activity Tracking</h2>
                    <p class="font-16 text-gray mt-10">Rurera offer the capability to track their
                        SATs exam practice time activity log while  remaining on system and can analyze the performance
                        against each SATs tests.</p>
                    <div class="mt-35 d-flex align-items-center">
                        <a href="{{url('/')}}/membership" class="btn btn-primary">Track performance</a>
                        <a href="{{url('/')}}/membership" class="btn btn-outline-primary ml-15">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="">
                    <h2 class="font-40 text-dark">SATs Papers</h2>
                    <p class="font-16 text-gray mt-10">
                        Discover wide range of SATs Papers and SATs resources to improve your learning process and explore the fundamental concepts of
                        SATs exam practice for advanced problem-solving.
                    </p>
                    <div class="mt-35 d-flex align-items-center">
                        <a href="{{url('/')}}/membership" class="btn btn-primary">Take a Quiz</a>
                        <a href="{{url('/')}}/membership" class="btn btn-outline-primary ml-15">Moniter performance</a>
                    </div>
                    <div class="flex-grow-1 ml-15"></div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative">
                    <img src="/store/1/default_images/home_sections_banners/lesson-topics.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer"/>
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle"/> 
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots"/>
                </div>
            </div>
        </div>
    </section>
    <section class="choose-sats choose-sats-section py-80 mt-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10 text-white font-40">About SATs Exam</h2>
                        <p class="font-19 text-white">
                            With engaging learning experiences, proven SATs resources, and SATs practice, you'll be <br/>well-prepared to achieve your best scores
                            on the SATs exam.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-md-6">
                    <div class="row">
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/exam-multiple-white.svg" width="50" height="50" alt="#"/>
                                <h3 class="text-white">100+ SATs practices</h3>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/lessons-white.svg" width="50" height="50" alt="#"/>
                                <span class="text-white">SATs Resources</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/impact-white.svg" width="50" height="50" alt="#"/>
                                <span class="text-white">SATs Assesments</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/sav-time-white.svg" width="50" height="50" alt="#"/>
                                <span class="text-white">SATs Quizzes</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/study-white.svg" width="50" height="50" alt="#"/>
                                <span class="text-white">SATs Tests</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/flexibility-white.svg" width="50" height="50" alt="#"/>
                                <span class="text-white">SATs papers</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/logic-white.svg" width="50" height="50" alt="#"/>
                                <span class="text-white">SATs exam</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/support-white.svg" width="50" height="50" alt="#"/>
                                <span class="text-white">Friendly support</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-md-6">
                    <div>
                        <h2 class="font-36 text-white">
                            Ignite Your Path to Success with 100+ SATs practices
                        </h2>
                        <p class="font-19 mb-0 mt-10 text-white">
                            Work through a variety of SATs exam practice questions to improve your skills
                            and become familiar with the types of questions you'll encounter on
                            the SATs exam.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container mt-50 pt-30">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-50">
                    <h2 class="mt-0 mb-10 font-40">Frequently asked questions</h2>
                    <p class="font-19 text-gray">Asking the right questions is indeed a skill that requires careful
                        consideration.</p>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-md-12 mx-auto">
                <div class="mt-0">
                    <div class="lms-faqs mx-w-100 mt-0">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingonsix">
                                    <button class="btn btn-link font-22 font-weight-normal" data-toggle="collapse" data-target="#collapsesix"
                                            aria-expanded="true" aria-controls="collapsesix"><h3>What are SATs exam in the UK?</h3>
                                    </button>
                                </div>
                                <div id="collapsesix" class="collapse show" aria-labelledby="headingsix"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        SATs exam (Standard Assessment Tests) refer to a set of national SATs exam practices and SATs assessments
                                        conducted in primary schools. These SATs tests are typically administered to students
                                        at the end of Key Stage 1 (KS1) and Key Stage 2 (KS2) of their education, which
                                        correspond roughly to ages 7-11.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h3>What are SATs exam for?</h3>
                                    </button>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        SATs exam provide a standardized measure of students' academic abilities and track
                                        their progress over time. They help assess how well students are meeting the
                                        expected learning outcomes for their age group.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingseven">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven"><h3>What subjects are assessed in SATs exam?</h3></button>
                                </div>
                                <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                    <div class="card-body">
                                        The core subjects assessed in SATs exam are English (including reading, writing,
                                        spelling, and grammar), mathematics, and, in some cases, science for Key Stage
                                        2.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading8">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8"><h3>What are SATs resources and how they help for KS1 , KS2 SATs?</h3></button>
                                </div>
                                <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                    <div class="card-body">
                                        SATs resources refer to the SATs exam practices, SATs quizzes designed to help students prepare for their KS1 SATs and KS2 SATs
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading9">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9"><h3>Do SATs exam have pass or fail grades?</h3></button>
                                </div>
                                <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                    <div class="card-body">
                                        SATs are not graded on a pass or fail basis. Instead, they provide information
                                        about a student's performance and attainment levels. Results are often reported
                                        as scaled scores or levels of achievement.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading10">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10"><h3>Are SATs compulsory?</h3></button>
                                </div>
                                <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                    <div class="card-body">
                                        SATs are compulsory in terms of administration, meaning schools are required to
                                        administer the tests. However, students themselves are not obligated to take the
                                        tests, but it is highly encouraged.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading11">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11"><h3>Are SATs quizzes helpful for preparing for the exams?</h3></button>
                                </div>
                                <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                    <div class="card-body">
                                        Yes, SATs quizzes can be helpful for preparing for KS1 and KS2 SATs. They offer interactive SATs practice quizzes and help students become familiar with the format of the SATs exams. 
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading12">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12"><h3>Can parents help their children prepare for KS1 and KS2 SATs?</h3></button>
                                </div>
                                <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                    <div class="card-body">
                                        Yes, parents can support their children in preparing for SATs by using SATs resources, helping with homework, and providing a supportive study environment.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="lms-newsletter mt-60 py-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="newsletter-inner">
                        <div class="row">
                            <div class="col-12 col-lg-8 col-md-8">
                                <h2 itemprop="title" class="mb-10 text-white font-40">Kickstart your SATs Exam Prep today</h2>
                                <p itemprop="description" class="mb-0 text-white font-16">
                                    Let us help you achieve the score you deserve and unlock <br/>
                                    doors to your future academic success.
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4">
                                <div class="form-field position-relative text-right">
                                    <button class="rounded rounded-pill bg-white">
                                        <a href="{{url('/')}}/membership" style="color:var(--gray-dark);">View our plans</a>
                                    </button>
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
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
@endpush
