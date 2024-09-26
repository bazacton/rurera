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
                    <h1 class="font-72 font-weight-bold">Inspiring <span class="text-scribble mr-10">Kids</span> to Love Words and Spelling!</h1>
                    <h2 class="mb-15 font-30">Discover a fun and simple way to Master English spelling!
                    </h2>
                    <p class="font-19">
                        We help kids build a strong foundation in spelling and vocabulary with engaging, interactive lessons based on British English. Our fun approach makes learning spelling and word usage enjoyable and effective.

                    </p>
                    <ul class="mb-0 p-0">
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/mobile.svg" width="25" height="25" alt="#">Curriculum Word Lists: According to Curriculum word sets.
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/preparation.svg" width="25" height="25" alt="#">Spelling Quizzes: Fun and interactive quizzes.

                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/graphic-design.svg" width="25" height="25" alt="#">Win Rewards: Earn rewards for milestones.
                        </li>
                        <li class="font-19">
                            <img src="../assets/default/svgs/book-opend.svg" width="25" height="25" alt="#">Progress Tracking: Easy monitoring.
                        </li>
                    </ul>
                    <a href="/pricing" class="try-rurera-btn justify-content-center bg-primary text-white register-btn">Try Rurera for free</a>
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
                        <h2 class="mt-0 mb-10 text-white font-40">Improve your Spelling and Vocabulary with Rurera
                        </h2>
                        <p class="text-white font-19">
                            See how Rurera helps you master spelling and vocabulary with easy-to-use tools and personalized support.
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
                                            <h3 class="post-title text-white">Custom Word Lists</h3>
                                            <p class="mt-15 text-white">
                                                Use personalized lists to focus on the words you need to learn.
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
                                            <h3 class="post-title text-white"> Fun Learning Quizzes</h3>
                                            <p class="mt-15 text-white">
                                                Enjoy interactive activities that make spelling and vocabulary practice exciting.
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
                                            <h3 class="post-title text-white">Easy Progress Tracking</h3>
                                            <p class="mt-15 text-white">
                                                See how you’re improving with simple reports and feedback.
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
    <section class="lms-column-section lms-text-section exploring-curriculum mx-w-100 mt-0 mb-80 pt-70 pb-70 pr-30 pl-30">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="lms-text-holder d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <h4 class="mb-10 font-30 align-items-center d-inline-flex text-white">
                                <span class="icon-svg mr-15">
                                    <img src="../assets/default/svgs/bulb-white.svg" height="35" width="35" alt="#">
                                </span>
                                Boost Your Spelling and Vocabulary Skills Today!
                            </h4>
                            <p class="font-16 text-white"> Unlock the power of words with our engaging resources. Build essential skills to excel and open doors to your future achievements.</p>
                        </div>
                        <div class="lms-btn-group justify-content-center">
                            <a href="{{url('/')}}/register-as" class="lms-btn rounded-pill text-white border-white">Try for free</a>
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
                    <h2 class="mt-0 mb-10 font-40"> Rurera’s Features for Mastering Vocabulary and Spelling!
                    </h2>
                    <p class="font-19 text-gray">
                        Find fun and impactful ways to enhance your vocabulary and spelling skills with Rurera’s top features!
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="">
                    <div class="section-title section-inner-title">
                        <h2 class="font-40 text-dark">Curriculum Based Word Lists</h2>
                        <p class="font-16 text-gray mt-10">
                            Explore Rurera’s Word Directory, a comprehensive collection of vocabulary designed to enhance spelling skills. With words organized from A-Z, suffix, prefix, learning becomes simple and effective.

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
                        <h2 class="font-40 text-dark">Play and Learn Quizzes
                        </h2>
                        <p class="font-16 text-gray mt-10">
                            With Rurera’s Play and Learn Quizzes, kids can enjoy fun, interactive challenges that help them strengthen vocabulary and spelling skills while having a great time learning.

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
                        <h2 class="font-40 text-dark">Audio Pronunciations</h2>
                        <p class="font-16 text-gray mt-10">
                            Improve pronunciation and listening skills with Rurera’s Audio Pronunciations. Hear words spoken clearly, and master phonemic awareness by learning the correct sounds, helping kids grasp the building blocks of language more effectively.

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
                        <h2 class="font-40 text-dark"> Spelling Bee Practices</h2>
                        <p class="font-16 text-gray mt-10">Get ready for spelling success with Rurera’s Spelling Bee practice. Test your skills with challenging words and timed quizzes to boost your spelling confidence and performance.</p>
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
                        <h2 class="font-40 text-dark">Progress Rewards</h2>
                        <p class="font-16 text-gray mt-10">
                            Celebrate your achievements with Rurera’s Progress Rewards. Earn rewards as you hit milestones and make improvements, keeping motivation high and recognizing your hard work along the way.

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
                    <a href="/pricing" class="try-rurera-btn justify-content-center bg-primary text-white register-btn">Try Rurera for free</a>
                </div>
            </div>
        </div>
    </section>

	{{do_shortcode('redefining_personalized_learning', array('heading' => "Achieve Success with Rurera’s Key Features.", 'description' => "Rurera provides powerful resources that align with student’s specific interests and learning goals.", 'items' => array(10,6,15,17,19)))}}
    

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
            <a href="/pricing" class="try-rurera-btn justify-content-center bg-primary text-white register-btn">Try Rurera for free</a>
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
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingonsix">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">What types of vocabulary resources does Rurera provide?</button>
                                        </h3>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Rurera offers a comprehensive curriculum based Word Directory, custom word lists, and sets to expand your child’s word knowledge. These resources are tailored to meet individual learning needs and interests.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingTwo">
                                        <h3 class="mb-0"><button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo"> What is the importance of vocabulary in language learning?</button></h3>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                Vocabulary is crucial for effective communication and understanding. A strong vocabulary enhances reading comprehension, writing ability, and overall language skills.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingseven">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven"> What are some common strategies for memorizing spelling words?</button>
                                        </h3>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                        <div class="card-body">
                                            <p> Strategies include breaking words into smaller parts, using mnemonic devices, practicing writing words repeatedly, and employing visual aids. Engaging in regular review and practice helps reinforce spelling.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading8">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">What are some effective methods for teaching vocabulary?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Effective methods include using flashcards, reading diverse texts, playing word games, and incorporating new words into daily conversations. Creating thematic word lists and practicing in context can also help build vocabulary.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading9">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">How do the Play and Learn Quizzes work?
                                            </button>
                                        </h3>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Our Play and Learn Quizzes turn vocabulary and spelling practice into engaging games. Kids complete interactive challenges that reinforce their learning in a fun and motivating way.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading10">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">How can Progress Rewards benefit my child?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Progress Rewards provide tangible recognition for your child’s achievements. Earning  rewards for milestones and improvements helps keep them motivated and engaged in their learning journey.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading11">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">Why should I choose Rurera for my child’s vocabulary and spelling practice?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                Rurera stands out with its engaging features, personalized learning tools, and a fun, interactive approach. We provide a comprehensive platform that makes vocabulary and spelling practice both effective and enjoyable for kids.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading12">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">How can I find new vocabulary words to learn on Rurera? </button>
                                        </h3>
                                    </div>
                                    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                Explore Rurera’s word lists, daily vocabulary features, and spelling bee vocabulary sets to discover new words to learn.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading13">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">How often should I practice spelling on Rurera to improve?
                                            </button>
                                        </h3>
                                    </div>
                                    <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>For the best results, practice regularly aim for a few times a week. Consistent practice helps reinforce your spelling skills and improve over time.

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