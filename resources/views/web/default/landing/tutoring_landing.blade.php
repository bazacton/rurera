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
                    <h1 class="font-72 font-weight-bold">Find Confidence with <span class="text-scribble mr-10">Rurera's</span> Tutors</h1>
                    <h2 class="mb-15 font-30">Supporting Your Learning with Expert Tutors and Personal Help.</h2>
                    <p class="font-19">
                        Don't leave your SAT performance to chance! Join us to unlock your full potential and excel on the SATs. Transform your test preparation with our expert guidance and resources—achieve the scores you’ve always dreamed of!

                    </p>
                    <ul class="mb-30 p-0">
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/mobile.svg" width="25" height="25" alt="#">Covers the National Curriculum ( Math, English, Science)
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/preparation.svg" width="25" height="25" alt="#">11 Plus Entrance Exams Preparation

                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/graphic-design.svg" width="25" height="25" alt="#">SATs (KS1, KS2) Preparation
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/book-opend.svg" width="25" height="25" alt="#">ISEB Exams Preparation
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/book-opend.svg" width="25" height="25" alt="#">Independent Schools Entrance Preparation
                        </li>
                        <li class="font-19">
                            <img src="../assets/default/svgs/book-opend.svg" width="25" height="25" alt="#">CAT-4
                        </li>
                    </ul>
                    <a href="/pricing" class="mt-0 bg-primary justify-content-center register-btn text-white try-rurera-btn">Try Rurera for free</a>
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
    <section class="tutoring-features-section pb-40 pt-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10 font-40">Our Tutoring Features</h2>
                        <p class="font-19 text-gray">
                            Discover the benefits that make our online tutoring the <br> perfect choice for your learning journey.
                        </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="tutoring-features-holder">
                        <div class="row">
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="feature-card">
                                    <div class="img-holder">
                                        <span class="icon-box">
                                            <img src="/assets/default/svgs/student-user.svg" alt="Flexible Scheduling" height="50" width="50">
                                        </span>
                                    </div>
                                    <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                                        <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Flexible Scheduling</a>
                                    </h3>
                                    <p itemprop="description">Choose tutoring sessions that fit your schedule, including evenings and weekends</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="feature-card">
                                    <div class="img-holder">
                                        <span class="icon-box">
                                            <img src="/assets/default/svgs/student-user.svg" alt="Personalized Learning Plans" height="50" width="50">
                                        </span>
                                    </div>
                                    <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                                        <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Personalized Learning Plans</a>
                                    </h3>
                                    <p itemprop="description">Tailored lessons based on individual student needs and goals.</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="feature-card">
                                    <div class="img-holder">
                                        <span class="icon-box">
                                            <img src="/assets/default/svgs/student-user.svg" alt="Progress Tracking" height="50" width="50">
                                        </span>
                                    </div>
                                    <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                                        <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Progress Tracking</a>
                                    </h3>
                                    <p itemprop="description">Regular updates on student performance and progress toward goals.</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="feature-card">
                                    <div class="img-holder">
                                        <span class="icon-box">
                                            <img src="/assets/default/svgs/student-user.svg" alt="One-on-One Sessions" height="50" width="50">
                                        </span>
                                    </div>
                                    <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                                        <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">One-on-One Sessions</a>
                                    </h3>
                                    <p itemprop="description">Individual sessions to enhance each child's specific growth and learning.</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="feature-card">
                                    <div class="img-holder">
                                        <span class="icon-box">
                                            <img src="/assets/default/svgs/student-user.svg" alt="Parent Involvement" height="50" width="50">
                                        </span>
                                    </div>
                                    <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                                        <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Parent Involvement</a>
                                    </h3>
                                    <p itemprop="description">Regular reports and feedback for parents to stay informed about their child’s progress.</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="feature-card">
                                    <div class="img-holder">
                                        <span class="icon-box">
                                            <img src="/assets/default/svgs/student-user.svg" alt="Learning Resources" height="50" width="50">
                                        </span>
                                    </div>
                                    <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                                        <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Learning Resources</a>
                                    </h3>
                                    <p itemprop="description">Access to additional notes, practice materials and exercises to reinforce learning.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-column-section lms-accordion-section tutoring-works w-100 pb-60 pt-60" style="background-color: #f5f9ff; max-width: 100%;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title mb-35 text-center">
                        <h2 itemprop="section title" class="font-40">How Rurera Tutoring Works</h2>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div itemprop="mainEntity" itemtype="https://schema.org/Question" class="accordion lms-accordion-modern" id="accordion-modern">
                        <div class="card active" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-1">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                    <span itemprop="size">1</span>Consult with Our Experts
                                </button>
                            </div>
                            <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Discuss your child’s goals, target schools, learning preferences, and the type of tutor that will best support them.
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
                                    <span itemprop="size">2</span>Find Your Ideal Tutor
                                </button>
                            </div>
                            <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Based on your child’s academic needs, your tuition advisor will pair you with the perfect tutor.
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
                                    <span itemprop="size">3</span>Book a Free Trial
                                </button>
                            </div>
                            <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Schedule a trial lesson with the tutor to see their teaching style in action and ensure they connect well with your child. We guarantee your satisfaction.
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
                                    <span itemprop="size">4</span>Begin Your Learning Journey
                                </button>
                            </div>
                            <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">If you’re satisfied with the free trial, your tutor will schedule sessions for your child. You’ll receive regular updates on their progress.</p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-sats.jpg" alt="company insights" title="company insights" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-5">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                    <span itemprop="size">5</span>Continuous Support and Guidance
                                </button>
                            </div>
                            <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        The Rurera team is here to support you throughout your child’s learning journey. Whether you need advice on exams or school admissions, we’re always ready to assist.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-insights.jpg" alt="company quiz" title="company quiz" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
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
    <section class="why-choose-section pt-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 col-md-6">
                    <div class="position-relative">
                        <img alt="#" height="350" src="../assets/default/img/assessments-educators.png" width="390">
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-md-6">
                    <h2 itemprop="title" class="font-36 text-secondary mb-15">Why choose us?</h2>
                    <p class="mb-15">We make your child's educational journey easier by handling the hard work of finding the right tutor.</p>
                    <p class="mb-30">Whether your child needs extra support in math and English, help with exam prep, or is ready for new challenges, you can rely on us to meet their unique learning needs.</p>
                    <h2 itemprop="title" class="font-36 text-secondary mb-15">Expert Guidance</h2>
                    <p>Our tutors are backed by a team of experts who provide ongoing training and development, ensuring they stay up-to-date with the latest teaching methods and curriculum changes.</p>
                </div>
            </div>
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
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">What subjects do you offer in Rurera tutoring?</button>
                                        </h3>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Rurera offers tutoring in a variety of subjects, including Math, English, Science, and Humanities, tailored to suit different age groups and academic levels.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingTwo">
                                        <h3 class="mb-0"><button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">How do I choose the right tutor for my child?</button></h3>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                Our team collaborates with you to understand your child’s learning needs and preferences, matching them with a tutor who best fits the child’s needs.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingseven">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">Can I book a trial session before committing?</button>
                                        </h3>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Yes, we offer a free trial session so you can evaluate the tutor’s compatibility with your child and their teaching style before making a commitment.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading8">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">How do online tutoring sessions work?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Our online sessions utilize a secure platform with interactive tools, allowing tutors to provide real-time feedback and support to engage your child effectively.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading9">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">What qualifications do your tutors have?
                                            </button>
                                        </h3>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>All Rurera tutors are highly qualified, with extensive teaching experience and a strong understanding of the UK curriculum.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading10">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">How is my child’s progress tracked by Rurera?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>You will receive regular progress reports that highlight your child’s achievements, areas for improvement, and suggested next steps in their learning journey.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading11">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">Can tutoring help my child prepare for exams?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                Absolutely! Our tutors are experienced in preparing students for various exams, including SATs, 11 plus, and entrance exams for independent schools.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading12">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">What support is available beyond tutoring sessions?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                The Rurera team is always available to provide additional support, whether it’s answering questions, offering school admissions advice, or helping with exam preparation.
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
                        <h2 class="font-40 text-white">Parental Control</h2>
                        <p class="font-16 font-weight-500 text-white">We make it easy to be involved in your child’s learning.s</p>
                    </div>
                    <ul>
                        <li><span class="font-18">Real-Time diagnostics</span></li>
                        <li><span class="font-18">Track Child’s learning</span></li>
                        <li><span class="font-18">Regular Reports on Activities</span></li>
                        <li><span class="font-18">Feedback for Tutors </span></li>
                        <li><span class="font-18">Customizable Learning Goals</span></li>
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
    <section class="lms-setup-progress-section tutoring-plans lms-membership-section mb-0 pt-70 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="element-title text-center mb-40">
                        <h2 itemprop="title" class="font-40 text-dark-charcoal mb-0">Ideal Tuition for Your Child</h2>
                        <p class="font-16 pt-10" itemprop="description">For Exceptional Value: Choose Our Pre-Selected Package for Maximum Savings! </p>
                    </div>
                </div>
                <div class="col-12 col-lg-12 text-center">
                    <div class="plan-switch-holder">
                        <div class="plan-switch-option">
                            <span class="switch-label">Monthly</span>
                            <div class="plan-switch">
                                <div class="custom-control custom-switch"><input type="checkbox" name="disabled" class="custom-control-input subscribed_for-field" value="12" id="iNotAvailable"><label class="custom-control-label" for="iNotAvailable"></label></div>
                            </div>
                            <span class="switch-label">Session</span>
                        </div>
                        <div class="save-plan"><span class="font-18 font-weight-500">Save 25%</span></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12 mx-auto">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="subscribe-plan current-plan position-relative d-flex flex-column mb-30">
                                <span class="plan-top-title">1:1 Session</span>
                                <div class="subscribe-title text-left">
                                    <h3 itemprop="title" class="font-weight-500 text-left">School Entrance Exams</h3>
                                    <ul class="plan-feature">
                                        <li class="mt-10">Grammar Schools</li>
                                        <li class="mt-10">Independent Schools</li>
                                        <li class="mt-10">ISEB</li>
                                        <li class="mt-10">CAT-4</li>
                                    </ul>
                                </div>
                                <div class="d-flex align-items-start mb-15 subscribe-price">
                                    <input type="radio" id="one">
                                    <label for="one">
                                        <span class="plan-price">1 session per week</span>
                                        <span itemprop="price" class="font-30 line-height-1 plan-prices yearly-price">£29.99<small>/month</small></span>
                                    </label>
                                </div>
                                <div class="d-flex align-items-start mb-50 subscribe-price best-price">
                                    <input type="checkbox" id="two" checked="">
                                    <label for="two">
                                        <span class="best-option">Best Value</span>
                                        <span class="plan-price">1 session per week</span>
                                        <span itemprop="price" class="font-30 line-height-1 plan-prices yearly-price">£29.99<small>/month</small></span>
                                    </label>
                                </div>
                                <div class="plan-btn-holder">
                                    <button itemprop="button" type="submit" class="subscription-modal btn w-100">Get Started</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="subscribe-plan position-relative d-flex flex-column mb-30">
                                <span class="plan-top-title">1:1 Session</span>
                                <div class="subscribe-title text-left">
                                    <h3 itemprop="title" class="font-weight-500 text-left">SATs Exam Preparation</h3>
                                    <ul class="plan-feature">
                                        <li class="mt-10">Key Stage 1(year-2)</li>
                                        <li class="mt-10">Key Stage 2(year-6)</li>
                                    </ul>
                                </div>
                                <div class="d-flex align-items-start mb-15 subscribe-price">
                                    <input type="radio" id="three">
                                    <label for="three">
                                        <span class="plan-price">1 session per week</span>
                                        <span itemprop="price" class="font-30 line-height-1 plan-prices yearly-price">£29.99<small>/month</small></span>
                                    </label>
                                </div>
                                <div class="d-flex align-items-start mb-50 subscribe-price best-price">
                                    <input type="checkbox" id="four" checked="">
                                    <label for="four">
                                        <span class="best-option">Best Value</span>
                                        <span class="plan-price">2 sessions per week</span>
                                        <span itemprop="price" class="font-30 line-height-1 plan-prices yearly-price">£29.99<small>/month</small></span>
                                    </label>
                                </div>
                                <div class="plan-btn-holder">
                                    <button itemprop="button" type="submit" class="subscription-modal btn w-100">Get Started</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="subscribe-plan position-relative d-flex flex-column mb-30">
                                <span class="plan-top-title">1:1 Session</span>
                                <div class="subscribe-title text-left">
                                    <h3 itemprop="title" class="font-weight-500 text-left">Maths and English Tuition</h3>
                                    <ul class="plan-feature">
                                        <li class="mt-10">Math Arithmetic</li>
                                        <li class="mt-10">Math Reasoning</li>
                                        <li class="mt-10">English Reading</li>
                                        <li class="mt-10">English SPaG</li>
                                    </ul>
                                </div>
                                <div class="d-flex align-items-start mb-15 subscribe-price">
                                    <input type="radio" id="five">
                                    <label for="five">
                                        <span class="plan-price">1 session per week</span>
                                        <span itemprop="price" class="font-30 line-height-1 plan-prices yearly-price">£29.99<small>/month</small></span>
                                    </label>
                                </div>
                                <div class="d-flex align-items-start mb-50 subscribe-price best-price">
                                    <input type="checkbox" id="six" checked="">
                                    <label for="six">
                                        <span class="best-option">Best Value</span>
                                        <span class="plan-price">2 sessions per week</span>
                                        <span itemprop="price" class="font-30 line-height-1 plan-prices yearly-price">£29.99<small>/month</small></span>
                                    </label>
                                </div>
                                <div class="plan-btn-holder">
                                    <button itemprop="button" type="submit" class="subscription-modal btn w-100">Get Started</button>
                                </div>
                            </div>
                        </div>
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