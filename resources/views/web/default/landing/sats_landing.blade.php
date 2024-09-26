@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .gallery-sub-header {
        min-height: 850px;
    }

    .lms-search-services {
        background-color: #f27530;
    }

    .lms-column-section {
        background-color: #7679ee;
    }

    .choose-sats-section {
        background-color: #3d358b;
    }
</style>
@endpush

@section('content')
<section class="content-section">
    <section class="position-relative job-singup-sub-header gallery-sub-header page-sub-header pb-80 pt-80 mb-0">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 col-md-12 col-lg-6">
                    <h1 class="font-72 font-weight-bold">Mastering <span class="text-scribble mr-10">SATs</span> with confidence.</h1>
                    <h2 class="mb-15 font-30">Maximize Your Performance: Boost your sats scores.
                    </h2>
                    <p class="font-19">
                        Don't leave your SAT performance to chance! Join us to unlock your full potential and excel on the SATs. Transform your test preparation with our expert guidance and resources—achieve the scores you’ve always dreamed of!

                    </p>
                    <ul class="mb-0 p-0">
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/mobile.svg" width="25" height="25" alt="#">Top Performance: Engaging Quizzes & Assessments
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/preparation.svg" width="25" height="25" alt="#">Comprehensive Exam Prep: Tools & Strategies

                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/graphic-design.svg" width="25" height="25" alt="#">Score Guarantee: Achieve Your Best
                        </li>
                        <li class="font-19">
                            <img src="../assets/default/svgs/book-opend.svg" width="25" height="25" alt="#">Proven Resources: 100% Success Results
                        </li>
                    </ul>
                    <a href="/pricing" class="py-15 px-30 text-dark-blue font-16 register-btn">Try Rurera for free</a>
                    <!-- <div class="d-flex align-items-center">
                        <a href="{{url('/')}}/register" class="btn-primary rounded-pill">KS1-year2 SATs</a>
                        <a href="{{url('/')}}/register" class="btn-primary rounded-pill ml-15">KS2-year6 SATs</a>
                    </div> -->
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
                        <h2 class="mt-0 mb-10 text-white font-40">Master the SATs with Rurera
                        </h2>
                        <p class="text-white font-19">
                            Work through a variety of SATs practice and SATs quizzes questions to improve your skills
                            and become familiar with the <br />
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
                <div class="col-12">
                    <div class="process-card-holder">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <div class="process-card mt-40 mb-30 text-center">
                                    <div class="process-step-number">
                                        <span>Step 1</span>
                                    </div>
                                    <div class="process-card-body">
                                        <div class="text-holder">
                                            <h3 class="post-title text-white">Learn &amp; Understand</h3>
                                            <p class="mt-15 text-white">
                                                Build a solid foundation with SATs quizzes, tests, and assessments, and get instant feedback.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <div class="process-card mt-40 mb-30 text-center">
                                    <div class="process-step-number">
                                        <span>Step 2</span>
                                    </div>
                                    <div class="process-card-body">
                                        <div class="text-holder">
                                            <h3 class="post-title text-white"> Practice Tests</h3>
                                            <p class="mt-15 text-white">
                                                Sharpen your skills with targeted practice tests to strengthen weak areas and boost your scores.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <div class="process-card mt-40 mb-30 text-center">
                                    <div class="process-step-number">
                                        <span>Step 3</span>
                                    </div>
                                    <div class="process-card-body">
                                        <div class="text-holder">
                                            <h3 class="post-title text-white">Track progress</h3>
                                            <p class="mt-15 text-white">
                                                Monitor your improvement and pinpoint areas for further development.
                                            </p>
                                        </div>
                                    </div>
                                </div>
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
                            Endless SATs Resources, Endless Practice Opportunities

                        </h2>
                        <p class="font-19 text-gray">
                            With consistent effort and top-tier SATs resources, boost your performance on exam day.

                        </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="element-title has-bg">
                        <h2 class="text-white m-0">Key Stage 1 & Key Stage 2</h2>
                    </div>
                </div>
                <div class="col-12">
                    <ul class="lms-key-stage-table bg-table mt-30">
                        <li class="lms-key-stage-head">
                            <div class="lms-key-stage keystage-title border-none"></div>
                            <div class="lms-key-stage">
                                <h3>English - Reading</h3>
                            </div>
                            <div class="lms-key-stage">
                                <h3>English - SPaG</h3>
                            </div>
                            <div class="lms-key-stage">
                                <h3>Math - Arithmetic</h3>
                            </div>
                            <div class="lms-key-stage">
                                <h3>Math - Reasoning</h3>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2022</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img">
                                        <img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img">
                                        <img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2019</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2018</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img">
                                        <img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2017</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="lms-key-stage-des">
                            <div class="lms-key-stage text-center"><strong>2016</strong></div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img3.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img1.webp" width="65" height="92" alt="#" />
                                    </div>
                                    <div class="lms-img"><img src="../assets/default/img/reading-img2.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div class="lms-key-stage">
                                <div class="lms-img-holder">
                                    <div class="lms-img"><img src="../assets/default/img/reading-img8.webp" width="65" height="92" alt="#" />
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-column-section lms-text-section exploring-curriculum mx-w-100 mt-80 mb-80 pt-70 pb-70 pr-30 pl-30">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="lms-text-holder d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <h4 class="mb-10 font-30 align-items-center d-inline-flex text-white">
                                <span class="icon-svg mr-15">
                                    <img src="../assets/default/svgs/bulb-white.svg" height="35" width="35" alt="#">
                                </span>
                                Kickstart your SATs Exam Prep Today.
                            </h4>
                            <p class="font-16 text-white"> Let us help you achieve the score you deserve and unlock <br>doors to your future academic success.</p>
                        </div>
                        <div class="lms-btn-group justify-content-center">
                            <a href="{{url('/')}}/register-as" class="lms-btn rounded-pill bg-white border-white">Try Rurera for free</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative mt-80">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="section-title text-center mb-50">
                    <h2 class="mt-0 mb-10 font-40"> Conquer the SATs with Confidence
                    </h2>
                    <p class="font-19 text-gray">
                        Rurera offer the capability to track their onscreen and practiced time activity well remaining
                        on system and <br />
                        can analyze the performance against each topic.
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="">
                    <div class="section-title section-inner-title">
                        <h2 class="font-40 text-dark">KS1 & KS2 SATs Practice</h2>
                        <p class="font-16 text-gray mt-10">

                            Rurera offers comprehensive KS1 and KS2 SATs practice, providing interactive exercises and personalized feedback tailored to each student's needs. This helps young learners build confidence and master essential skills for their assessments.

                        </p>
                    </div>
                    <!-- <div class="mt-35 d-flex align-items-center btn-holder">
                        <a href="{{url('/')}}/pricing" class="btn btn-primary">Start SATs Practice</a>
                        <a href="{{url('/')}}/pricing" class="btn btn-outline-primary ml-15">Learn More</a>
                    </div> -->
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative img-holder">
                    <img src="/store/1/default_images/home_sections_banners/learning-practice.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer" />
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle" />
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots" />
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative instructor-img-first">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative img-holder">
                    <img src="/store/1/default_images/home_sections_banners/quiz-sats.jpg" class="find-instructor-section-hero" width="400" height="460" alt="Track Student Progress" />
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle" />
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots" />
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="">
                    <div class="section-title section-inner-title">
                        <h2 class="font-40 text-dark">Ace SATs with Quizzes & Assessments!
                        </h2>
                        <p class="font-16 text-gray mt-10">
                            SATs quizzes and assessments cover key subjects like English, Maths, Science, and Computing. Enhance English reading skills and foster a love for books. Support Design and Technology learning. Ideal for effective SATs exam practice.

                        </p>
                    </div>
                    <!-- <div class="mt-35 d-flex align-items-center btn-holder">
                        <a href="{{url('/')}}/pricing" class="btn btn-primary">Take a SATs Quiz</a>
                        <a href="{{url('/')}}/pricing" class="btn btn-outline-primary ml-15">Moniter performance</a>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="">
                    <div class="section-title section-inner-title">
                        <h2 class="font-40 text-dark">Track Individual Progress with Ease</h2>
                        <p class="font-16 text-gray mt-10">
                        Rurera makes it simple to track individual progress by offering detailed insights into each student's performance. The platform provides comprehensive activity logs that highlight strengths and areas needing improvement.

                        </p>
                    </div>
                    <!-- <div class="mt-35 d-flex align-items-center btn-holder">
                        <a href="{{url('/')}}/pricing" class="btn btn-primary">Track performance</a>
                        <a href="{{url('/')}}/pricing" class="btn btn-outline-primary ml-15">Learn More</a>
                    </div> -->
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative img-holder">
                    <img src="/store/1/default_images/home_sections_banners/individual-performance.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer" />
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle" />
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots" />
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative instructor-img-first">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative img-holder">
                    <img src="/store/1/default_images/home_sections_banners/activity-tracking.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer" />
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle" />
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots" />
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div>
                    <div class="section-title section-inner-title">
                        <h2 class="font-40 text-dark"> Effortlessly Track Practice</h2>
                        <p class="font-16 text-gray mt-10">Easily monitor practice with detailed logs and performance insights, helping you keep track of progress and pinpoint areas needing improvement.</p>
                    </div>
                    <!-- <div class="mt-35 d-flex align-items-center btn-holder">
                        <a href="{{url('/')}}/pricing" class="btn btn-primary">Track performance</a>
                        <a href="{{url('/')}}/pricing" class="btn btn-outline-primary ml-15">Learn More</a>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="">
                    <div class="section-title section-inner-title">
                        <h2 class="font-40 text-dark">Enhance Learning with SATs Papers</h2>
                        <p class="font-16 text-gray mt-10">
                        Enhance learning by using SATs papers, which provide targeted practice and familiarize students with exam formats. These papers help reinforce key concepts, improve problem-solving skills, and build confidence by simulating real test conditions.


                        </p>
                    </div>
                    <!-- <div class="mt-35 d-flex align-items-center btn-holder">
                        <a href="{{url('/')}}/pricing" class="btn btn-primary">Take a Quiz</a>
                        <a href="{{url('/')}}/pricing" class="btn btn-outline-primary ml-15">Moniter performance</a>
                    </div> -->
                    <div class="flex-grow-1 ml-15"></div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative img-holder">
                    <img src="/store/1/default_images/home_sections_banners/lesson-topics.jpg" width="400" height="460" class="find-instructor-section-hero" alt="Have a Question? Ask it in forum and get answer" />
                    <img src="/assets/default/img/home/circle-4.png" width="170" height="170" class="find-instructor-section-circle" alt="circle" />
                    <img src="/assets/default/img/home/dot.png" width="70" height="110" class="find-instructor-section-dots" alt="dots" />
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center mt-90">
                    <a href="/pricing" class="btn-primary text-dark-blue font-16 register-btn py-15 px-30">Try Rurera for free</a>
                </div>
            </div>
        </div>
    </section>
    <section class="choose-sats choose-sats-section py-80 mt-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10 text-white font-40"> Ignite Your Path to Success with 100+ SATs practices</h2>
                        <p class="font-19 text-white">
                            With engaging learning experiences, proven SATs resources, and SATs practice, you'll be <br />well-prepared to achieve your best scores
                            on the SATs exam.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/exam-multiple-white.svg" width="50" height="50" alt="#" />
                                <h3 class="text-white">100+ SATs practices</h3>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/lessons-white.svg" width="50" height="50" alt="#" />
                                <span class="text-white">SATs Resources</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/impact-white.svg" width="50" height="50" alt="#" />
                                <span class="text-white">SATs Assesments</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/sav-time-white.svg" width="50" height="50" alt="#" />
                                <span class="text-white">SATs Quizzes</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/study-white.svg" width="50" height="50" alt="#" />
                                <span class="text-white">SATs Tests</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/flexibility-white.svg" width="50" height="50" alt="#" />
                                <span class="text-white">SATs papers</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/logic-white.svg" width="50" height="50" alt="#" />
                                <span class="text-white">SATs exam</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="sats-box border-white has-bg">
                                <img src="../assets/default/svgs/support-white.svg" width="50" height="50" alt="#" />
                                <span class="text-white">Friendly support</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-12 col-lg-6 col-md-6">
                    <div class="section-title">
                        <h2 class="font-36 text-white">
                            Ignite Your Path to Success with 100+ SATs practices
                        </h2>
                        <p class="font-19 mb-0 mt-10 text-white">
                            Work through a variety of SATs exam practice questions to improve your skills
                            and become familiar with the types of questions you'll encounter on
                            the SATs exam.
                        </p>
                    </div>
                </div> -->
            </div>
        </div>
    </section>



    <section class="pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mb-50 text-center">
                        <h2 class="mb-10 font-40">Personalized SATs Prep with Rurera</h2>
                        <p class="font-16 text-gray">Empower your child’s learning journey with tailored resources and assessments that meet their unique needs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20" class="mb-20">

                            <img src="../assets/default/img/ks1-year1-feature.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Key to Effective Learning</span>
                        </h3>
                        <p itemprop="description"> Build knowledge through SATs quizzes, SATs tests and SATs assessments with immediate feedback.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/entrance-exams.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">SATs 100s online Assessments</span>
                        </h3>
                        <p itemprop="description">Unlock 100+ Online SATs Quizzes and Assessments for High Achievers.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/analytics-feature.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Past SATs Papers</span>
                        </h3>
                        <p itemprop="description"> Access SATs papers and resources to boost learning and master key concepts for advanced problem-solving.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/quick-assesments.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Learn, Play & Win</span>
                        </h3>
                        <p itemprop="description">Enhance your skills, earn rewards, and win toys through continuous learning.

                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/insights-feature.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Student Engagement</span>
                        </h3>
                        <p itemprop="description"> Engage students with challenges, test practices, and rewards like toys and collectibles.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/sats-home-feature.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Activity Monitoring</span>
                        </h3>
                        <p itemprop="description"> Track SATs practice and analyze logs to identify strengths and improve.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/feature-automated-marking.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Parental Insights</span>
                        </h3>
                        <p itemprop="description"> Track progress and support your child's achievements with key learning insights.

                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/book-shelf-feature.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Interactive Learning</span>
                        </h3>
                        <p itemprop="description">
                            Explore online books, interactive multiplication, and activities that make learning fun and effective.


                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/timetables-feature.jpg" alt="feature image" height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Adaptive Assessments</span>
                        </h3>
                        <p itemprop="description">Get instant feedback and personalized learning paths with adaptive tests to ensure efficient progress.
                        </p>
                    </div>
                </div>



            </div>
        </div>
    </section>


    <section class="lms-column-section lms-accordion-section w-100 pb-60 pt-60" style="background-color: #f6f0ea; max-width: 100%;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title mb-35 text-center">
                        <h2 itemprop="section title" class="font-40">Why choose Rurera assessments ?</h2>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div itemprop="mainEntity" itemtype="https://schema.org/Question" class="accordion lms-accordion-modern" id="accordion-modern">
                        <div class="card active" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-1">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                    <span itemprop="size">#1</span>Adaptive Assessments Testing
                                </button>
                            </div>
                            <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        It helps schools to offer adaptive assessments that adjust the difficulty of questions as below, emerging, expected, exceeding and challenge which is based on a student's previous responses, history,
                                        reports and performance providing a more tailored learning experience.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/adpative-assessment.jpg" alt="company sats" title="company sats" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-2">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                    <span itemprop="size">#2</span>Quick Results via automated marking
                                </button>
                            </div>
                            <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Real-time marking data allows for quick identification of students who may require additional support or challenges. Students receive instant personalized feedback for every question and learning nugget.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-quiz.jpg" alt="company performance" title="company performance" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-3">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                    <span itemprop="size">#3</span>Diverse Question Formats
                                </button>
                            </div>
                            <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Online assessments can include a variety of question types, from multiple choice to audio types offering a more comprehensive evaluation of student knowledge.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/all-in-1-platform.jpg" alt="company rewards" title="company rewards" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-4">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                    <span itemprop="size">#4</span>Timely Reporting
                                </button>
                            </div>
                            <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">Online platforms often provide real-time reporting to both students and teachers, allowing for prompt interventions and support.</p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-sats.jpg" alt="company insights" title="company insights" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-5">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                    <span itemprop="size">#5</span>Breakthrough insights at every level
                                </button>
                            </div>
                            <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Students and their parents can access a dashboard that displays their live progress in various subjects. It allows them to identify their strengths and areas needing improvement. Parents can monitor
                                        completed work, track their child's progress, and view assigned tasks.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-insights.jpg" alt="company quiz" title="company quiz" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-6">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-6" aria-expanded="true" aria-controls="collapse-6">
                                    <span itemprop="size">#6</span>Students Engagement
                                </button>
                            </div>
                            <div id="collapse-6" class="collapse" aria-labelledby="heading-6" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Ignite student’s passion more to join your school. A fantastic learning experience is possible using interactive challenges, Online Test practices, Entrance Exams preparations and rewarding them with
                                        trending toys.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-performance.jpg" alt="company curriculum" width="100%" height="auto" title="company curriculum" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-6">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-7" aria-expanded="true" aria-controls="collapse-7">
                                    <span itemprop="size">#7</span>Reward points
                                </button>
                            </div>
                            <div id="collapse-7" class="collapse" aria-labelledby="heading-7" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Unlock Knowledge and Reward Yourself with Exciting Toys. It implies through continuous learning and improvement, students can increase their chances of winning playful toys. We believe in recognizing and
                                        appreciating your loyalty and engagement.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-rewards.jpg" alt="company curriculum" width="100%" height="auto" title="company curriculum" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center pt-50">
            <a href="/pricing" class="btn-primary font-16 text-dark-blue register-btn py-15 px-30">Try Rurera for free</a>
        </div>
    </section>
    @php $faq_items = isset( $faq_items )? $faq_items : array();@endphp
    <section class="py-100" style="background-color: #fff">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-30">
                        <h2 class="mt-0 mb-10 font-40">Frequently asked questions</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-md-12 mx-auto">
                    <div class="mt-0">
                        <div class="lms-faqs mx-w-100 mt-0" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div id="accordion">
                                @if( !empty( $faq_items ))

                                @foreach( $faq_items as $itemData)
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingonsix">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">{{isset( $itemData['title'])? $itemData['title'] : '' }}</button>
                                        </h3>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>{{isset( $itemData['description'])? $itemData['description'] : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @else
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingonsix">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">What are SATs in UK?</button>
                                        </h3>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>SATs (Standard Assessment Tests) are exams administered to primary school children in England to evaluate their academic progress and the quality of education at their schools. These tests are taken at the end of Key Stage 1 (Years 1–2) and Key Stage 2 (Years 3–6). <br>In Key Stage 2, SATs focus on English and mathematics, but do not include science. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingTwo">
                                        <h3 class="mb-0"><button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo"> When do students take their SATs?</button></h3>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                The Year 6 SATs in 2025 will take place between <strong>12th May-15th May:</strong>

                                            </p>
                                            <ul>
                                                <li> <strong>Monday:</strong> English paper 1 and English paper 2</li>
                                                <li><strong>Tuesday: </strong> English paper 3</li>
                                                <li><strong>Wednesday: </strong> Maths paper 1 and maths paper 2</li>
                                                <li> <strong>Thursday:</strong> Maths paper 3</li>
                                            </ul>





                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingseven">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven"> Which subjects are assessed during the SATs exams?</button>
                                        </h3>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                        <div class="card-body">
                                            <p> Year 6 SATs assess the topics taught on the Key Stage 2 national curriculum for English and maths.

                                            </p>
                                            <ul>
                                                <li><strong>English:</strong> Reading, spelling, vocabulary, grammar and punctuation</li>
                                                <li><strong>Maths:</strong> Number, data, geometry, algebra, measurement, ratio and proportion</li>
                                            </ul>
                                            <p>There are 6 papers in total – 3 for English (grammar and punctuation, spelling, and reading), and 3 for maths (2 reasoning papers and an arithmetic paper)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading8">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">Is it compulsory for students to take the SATs exams?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>SATs play a crucial role in providing teachers and parents with an understanding of children's strengths and areas that need improvement. The results help teachers identify which students may require additional support as they transition from primary to secondary school. <br> Additionally, the government uses these results to assess the quality of education in schools nationwide.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading9">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">What is the process for scoring SATs, and how are student results determined?
                                            </button>
                                        </h3>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>SATs are scored using scaled scores: A score of 100 represents the expected standard. Scores above 100 indicate higher performance, and below 100 indicate a need for improvement.</p>
                                            <p><strong>Total score:120</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading10">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">Does Rurera align with the national curriculum and standards?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Yes. Our content is created by teachers and grounded in the Key Stage 2 national curriculum in England. Rurera covers all the core topics in English, maths and science for Years 3–6 (ages 7–11).
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading11">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">How does Rurera boost and sustain my child's motivation?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                Along with exciting features like coins to collect and worlds to explore, our algorithm is busy working in the background. Rurera constantly adjusts the difficulty level to match your child's learning style and pace, ensuring they stay challenged without losing motivation. <br>There are plenty of interactive resources to help your child deepen their understanding of each topic, such as helpsheets.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading12">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">What support and resources does Rurera offer for my child's learning?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                No other platform combines adaptive learning, teacher-crafted content, and expert guidance all in one package! We're available to assist you by phone or email whenever you need support.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading13">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">Will my child need my help to use Rurera, or can they manage it independently?
                                            </button>
                                        </h3>
                                    </div>
                                    <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Not at all – we've crafted Rurera to be enjoyable and simple for your child to use independently. With helpsheets, they can build new knowledge and gain confidence in learning on their own.

                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="parent-account-section mt-0" style="background-color: #0065ff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-7 col-md-7">
                    <div class="section-title mb-50">
                        <h2 class="font-40 text-white">Parent account</h2>
                        <p class="font-16 font-weight-500 text-white">We make it easy to be involved in your child’s learning
                            Ability to assign activities</p>
                    </div>
                    <ul>
                        <li><span class="font-18">Real-Time diagnostics</span></li>
                        <li><span class="font-18">Track Child’s Learning</span></li>
                        <li><span class="font-18">Assign Goals for your Child</span></li>
                        <li><span class="font-18">Regular Notifications on Activities.</span></li>
                        <li><span class="font-18">learning controls</span></li>
                        <li><span class="font-18">Easy to Manage Sibling Accounts</span></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-5 col-md-5">
                    <div class="imb-box">
                        <img src="/assets/default/img/banner-home.webp" width="548" height="570" alt="banner-home image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
    $packages_only = isset( $packages )? $packages : array();
    $show_details = isset( $show_details )? $show_details : true;
    @endphp
    <section class="lms-setup-progress-section lms-membership-section mb-0 pt-70 pb-60" data-currency_sign="{{getCurrencySign()}}" style="background-color: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 text-center">
                    <div class="element-title text-center mb-40">
                        <h2 itemprop="title" class="font-40 text-dark-charcoal mb-0">Choose the right plan for you</h2>
                        <p class="font-16 pt-10">Save more with annual pricing</p>
                    </div>
                </div>
                <div class="col-12 col-lg-12 text-center">
                    <div class="plan-switch-holder">
                        <div class="plan-switch-option">
                            <span class="switch-label">Pay Monthly</span>
                            <div class="plan-switch">
                                <div class="custom-control custom-switch"><input type="checkbox" name="disabled" class="custom-control-input subscribed_for-field" value="12" id="iNotAvailable" /><label class="custom-control-label" for="iNotAvailable"></label></div>
                            </div>
                            <span class="switch-label">Pay Yearly</span>
                        </div>
                        <div class="save-plan"><span class="font-18 font-weight-500">Save 25%</span></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12 mx-auto">
                    <div class="row">

                        @include('web.default.pricing.packages_list',['subscribes' => array(), 'packages_only' => $packages_only, 'show_details' => false])

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade lms-choose-membership" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="modal-body">
                    <div class="tab-content subscription-content" id="nav-tabContent">
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
@endpush