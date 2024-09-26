@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
.gallery-sub-header {
    min-height: 780px;
}

.lms-newsletter {
    background-color: #f18700;
}

.bg-deepskyblue {
    background-color: #46b7e9;
}

.bg-blue {
    background-color: #3d358b;
}

.bg-yellow {
    background-color: #f6b801;
}

.bg-deepyellow {
    background-color: #f18700;
}

.bg-lightblue {
    background-color: #7679ee;
}

.bg-orange {
    background-color: #f35b05;
}
</style>
@endpush

@section('content')
<section class="content-section">
    <section class="position-relative job-singup-sub-header gallery-sub-header page-sub-header pb-90 pt-80 mb-70">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 col-md-6 col-lg-6">
                    <h1 class="font-72 font-weight-bold"><span class="text-scribble mr-10">11 Plus</span> and Entrance
                        Exams</h1>
                    <h2 class="mb-15 font-30">Unlock Opportunities: Ace the 11 Plus Exam!
                    </h2>
                    <p class="font-19">Prepare for selective school admissions with comprehensive learning and practice
                        tools.</p>
                    <ul class="mb-30 p-0">
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/mobile.svg" alt="mobile" title="mobile" width="25"
                                height="25" itemprop="image" loading="eager">11+ Learning practice
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/preparation.svg" alt="preparation" title="preparation"
                                width="25" height="25" itemprop="image" loading="eager">11+ Assessment & 11+ Tests
                        </li>
                        <li class="mb-10 font-19">
                            <img src="../assets/default/svgs/graphic-design.svg" alt="graphic-design"
                                title="graphic-design" width="25" height="25" itemprop="image" loading="eager">11+
                            Quizzes & Exam Prep
                        </li>
                        <li class="font-19">
                            <img src="../assets/default/svgs/book-opend.svg" alt="book-opend" title="book-opend"
                                width="25" height="25" itemprop="image" loading="eager">Guaranteed Results
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="{{url('/')}}/pricing" class="py-15 px-30 text-dark-blue font-16 register-btn try-rurera-btn  mt-0">Try Rurera for free</a>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="masonry-grid-gallery has-fix-height">
            <div class="masonry-grid">
                <div class="row">
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing">
                                    <img src="../assets/default/img/11-plus/paper1.png" alt="sats-header"
                                        title="sats-header" width="100%" height="auto" itemprop="image" loading="eager"
                                        class="rounded has-shadow-x"></a>
                            </figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing">
                                    <img src="../assets/default/img/11-plus/paper2.png" alt="sats-header"
                                        title="sats-header" width="100%" height="auto" itemprop="image" loading="eager"
                                        class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper3.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper4.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper5.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper6.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper1.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper2.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper3.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper4.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper5.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper6.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper1.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper2.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper3.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper4.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper5.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper6.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper3.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                    <div class="grid-item col-lg-3 col-md-4 col-sm-4">
                        <div class="img-holder">
                            <figure><a href="{{url('/')}}/pricing"><img src="../assets/default/img/11-plus/paper1.png"
                                        alt="sats-header" title="sats-header" width="100%" height="auto"
                                        itemprop="image" loading="eager" class="rounded has-shadow-x"></a></figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-features-section mx-w-100 mt-20">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title">
                        <h2 itemprop="title" class="mb-5 font-40">Comprehensive 11+ Exam Prep with Rurera</h2>
                        <p itemprop="description" class="font-19 text-gray">Boost Your Success: Tailored 11+ Practice &
                            Resources
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="lms-feature-card mt-50">
                        <figure>
                            <i class="svg-icon bg-blue">
                               <img src="/assets/default/svgs/feature-mock.svg" height="24" width="24" alt="Mock Exams"> 
                            </i>
                        </figure>
                        <div class="lms-text-holder">
                            <h3 itemprop="title" class="post-title font-30 mb-15">Mock Exams</h3>
                            <p itemprop="description" class="font-18 text-dark">Experience realistic 11+ mock exams
                                designed to simulate actual test conditions. These practice exams help build your
                                child's confidence and improve their exam readiness by familiarising them with the
                                format, timing, and pressure of the real test.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="lms-feature-card mt-50">
                        <figure>
                            <i class="svg-icon bg-yellow">
                                <img src="/assets/default/svgs/feature-time.svg" height="24" width="24" alt="Timed Practices"> 
                            </i>
                        </figure>
                        <div class="lms-text-holder">
                            <h3 itemprop="title" class="post-title font-30 mb-15">Timed Practices</h3>
                            <p itemprop="description" class="font-18 text-dark">Our timed practice exercises are
                                specifically designed to develop your child’s time management skills. By working within
                                set time limits, your child learns to pace themselves effectively, ensuring they can
                                complete all sections of the exam within the allotted time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="lms-feature-card mt-50">
                        <figure>
                            <i class="svg-icon bg-deepyellow">
                                <img src="/assets/default/svgs/feature-target.svg" height="24" width="24" alt="Target Identification">
                            </i>
                        </figure>
                        <div class="lms-text-holder">
                            <h3 itemprop="title" class="post-title font-30 mb-15">Target Identification</h3>
                            <p itemprop="description" class="font-18 text-dark">We provide personalised strategies to
                                identify and address your child’s specific weaknesses. By focusing on areas that need
                                improvement, we help your child overcome challenges and excel in their 11+ exam
                                preparation.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="lms-feature-card mt-50">
                        <figure>
                            <i class="svg-icon bg-lightblue">
                                <img src="/assets/default/svgs/feature-exam.svg" height="24" width="24" alt="Exam Practice Resources">
                            </i>
                        </figure>
                        <div class="lms-text-holder">
                            <h3 itemprop="title" class="post-title font-30 mb-15">Exam Practice Resources</h3>
                            <p itemprop="description" class="font-18 text-dark">Our comprehensive self-assessment tools
                                offer continuous opportunities for growth and improvement. These resources enable your
                                child to regularly evaluate their progress and fine-tune their skills, ensuring they
                                stay on track</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="lms-feature-card mt-50">
                        <figure>
                            <i class="svg-icon bg-orange">
                                <img src="/assets/default/svgs/feature-progress.svg" height="24" width="24" alt="Progress Reports">
                            </i>
                        </figure>
                        <div class="lms-text-holder">
                            <h3 itemprop="title" class="post-title font-30 mb-15">Progress Reports</h3>
                            <p itemprop="description" class="font-18 text-dark">Receive detailed progress reports that
                                track your child’s development over time. These insights, paired with expert guidance,
                                help you understand their strengths and areas for improvement, ensuring a targeted and
                                effective preparation plan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="lms-feature-card mt-50">
                        <figure>
                            <i class="svg-icon bg-deepskyblue">
                                <img src="/assets/default/svgs/feature-Professional.svg" height="24" width="24" alt="Professional Support">
                            </i>
                        </figure>
                        <div class="lms-text-holder">
                            <h3 itemprop="title" class="post-title font-30 mb-15">Professional Support</h3>
                            <p itemprop="description" class="font-18 text-dark">Benefit from expert feedback tailored to
                                refine your child’s skills and guide them toward achieving excellence. Our professional
                                support ensures that your child is fully prepared to tackle the 11+ exam with
                                confidence.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="exames-section mt-50 mb-80 pt-70 pb-90 bg-exames">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title mb-50 text-center">
                        <h2 itemprop="title" class="text-white font-40">Discover Top Resources for 11 Plus & Entrance
                            Exams!</h2>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="exame-listing">
                        <ul class="exame-holder">
                            <li class="exame-list border-right">
                                <a href="{{url('/')}}/pricing" class="d-flex align-items-center">
                                    <div class="img-holder">
                                        <figure>
                                            <span class="icon-savg">
                                                <svg width="64px" height="64px" viewBox="0 0 960 960" version="1.1"
                                                    xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#3d358b">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <style type="text/css">
                                                        .st0 {
                                                            display: none;
                                                        }

                                                        .st1 {
                                                            display: inline;
                                                            opacity: 0.93;
                                                        }

                                                        .st2 {
                                                            display: inline;
                                                            fill: none;
                                                            stroke: #3d358b;
                                                            stroke-width: 15;
                                                            stroke-linecap: round;
                                                            stroke-linejoin: round;
                                                            stroke-miterlimit: 10;
                                                        }

                                                        .st3 {
                                                            display: inline;
                                                        }

                                                        .st4 {
                                                            fill: none;
                                                            stroke: #3d358b;
                                                            stroke-width: 15;
                                                            stroke-linecap: round;
                                                            stroke-linejoin: round;
                                                            stroke-miterlimit: 10;
                                                        }

                                                        .st5 {
                                                            display: inline;
                                                            fill: none;
                                                            stroke: #1A1D3F;
                                                            stroke-width: 15;
                                                            stroke-linecap: round;
                                                            stroke-linejoin: round;
                                                            stroke-miterlimit: 10;
                                                        }

                                                        .st6 {
                                                            fill: #3d358b;
                                                        }

                                                        .st7 {
                                                            fill: #3d358b;
                                                        }

                                                        .st8 {
                                                            fill: #3d358b;
                                                        }

                                                        .st9 {
                                                            fill: #3d358b;
                                                        }

                                                        .st10 {
                                                            fill: #3d358b;
                                                        }

                                                        .st11 {
                                                            fill: #3d358b;
                                                        }

                                                        .st12 {
                                                            fill: #3d358b;
                                                        }

                                                        .st13 {
                                                            fill: none;
                                                        }

                                                        .st14 {
                                                            fill: none;
                                                            stroke: #3d358b;
                                                            stroke-width: 15;
                                                            stroke-linecap: round;
                                                            stroke-linejoin: round;
                                                            stroke-miterlimit: 10;
                                                        }

                                                        .st15 {
                                                            display: inline;
                                                            fill: #3d358b;
                                                        }

                                                        .st16 {
                                                            fill: #3d358b;
                                                        }

                                                        .st17 {
                                                            display: inline;
                                                            fill: #3d358b;
                                                        }
                                                        </style>
                                                        <g class="st0" id="guide"></g>
                                                        <g class="st0" id="sketch"></g>
                                                        <g class="st0" id="stroke">
                                                            <path class="st2"
                                                                d="M671.8,450.7c-0.3-114.8-6-232.7-6.4-347.6c-125.5,0.9-252.9,1.6-378.4,2.5c1.3,108.9,2.6,241.4,3.9,350.2 C417.6,454.2,545.1,452.4,671.8,450.7z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M472.1,853.7c1-115.6-3-253.2-2.1-368.8c-123-1.7-253.4-1.7-376.4-3.4c-2.2,124.8-4.4,249.5-6.6,374.3 C227.1,855.8,342.9,859.3,472.1,853.7z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M867.6,851.4c2.3-113.7,3.1-247.8,5.4-361.5c-92.9-3.4-218.9-6.2-346-4.4c-1.1,120.4-2.2,240.9-3.3,361.3 C627.6,846.1,763.5,852.1,867.6,851.4z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M634.9,414.7c-0.9-98.7-2.1-178.6-3-277.3c-104.3,2.7-207.3,3.8-311.6,6.5c2.1,94.2,4.1,183.3,6.2,277.5 C442.3,421.4,523.6,419.7,634.9,414.7z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M433.1,823c-2.4-106.2,2.4-196.4,0-302.5c-96-7.1-209.9-7-306.1-2.8c0.5,99.6,0.9,205.4,1.4,304.9 C247.5,824,331,824.9,433.1,823z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M829.8,812.3c-2.2-97.2,2-190.1-0.1-287.4c-85.8-1.4-178.1-2.7-263.8-4c-2.7,94.2-1.4,192.5-4.1,286.7 C671.8,812.3,730,809,829.8,812.3z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M434.4,227.3c6.1-10.6,13-20.9,22.4-28.7c9.4-7.7,21.8-12.6,33.9-10.8c21.8,3.2,34.8,25.6,43.6,45.9 c13.7,31.4,25.3,63.8,34.6,96.8c2.6,9.1,5,18.8,2.5,27.9c-2.5,9.1-11.6,17.2-20.8,15c-7.4-1.7-12.1-9.1-14.6-16.3 c-2.5-7.2-3.8-15-8.1-21.3c-9.3-13.6-28.6-14.8-45.1-14.7c-10.3,0.1-21.4,0.4-29.8,6.4c-8.9,6.4-12.6,17.6-15.9,28 c-3.8,12-14.8,37.9-32.5,29.8c-11.8-5.4-8.9-24.7-8.1-35C400.2,307.3,412.8,265,434.4,227.3z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M462.1,272.5c-0.5,3.7-0.6,8,2,10.7c2.4,2.5,6.2,2.8,9.6,2.9c5.4,0.1,10.9,0,16.3-0.3c3-0.2,6.2-0.5,8.5-2.4 c4.2-3.4,3.5-9.9,2.1-15.2c-1.6-6.4-3.7-12.9-7.8-18.1c-4.5-5.6-14.4-11.4-20.5-5.6C466,250.6,463.2,264.4,462.1,272.5z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M244.8,560.7c-9.7-0.2-24,0.9-32.2,9.7c-5.9,6.3-7.2,15.4-8,24c-4.2,50-8.3,100-12.5,149.9 c-0.8,9.3-1.3,19.6,4.4,27c6,7.9,17,9.8,26.8,10.7c22.4,2.1,45.1,4.1,67.5,2c23.8-2.2,44.2-7,57.4-26.9 c10.8-16.3,15.4-39.5,4.9-55.9c-10.5-16.5-19.5-22.8-33.2-29.1c19.8-7.1,30.1-12.2,38.7-32.9c8.6-20.6,1.5-47.7-16.4-61.1 C313.5,556.7,282.8,561.3,244.8,560.7z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M245.6,635.9c-0.2,2.3-0.3,4.7,0.5,6.8c1.5,3.6,5.3,4.6,8.5,5.1c8.1,1.1,16.3,1.3,24.4,0.7 c6-0.4,12.2-1.4,17.4-5c5.2-3.6,9.3-10.5,9-18c-0.3-5.8-3.2-11.1-6.9-14.7c-3.7-3.6-8.2-5.6-12.8-7.2c-9.7-3.4-24.4-7.3-34.2-3.6 c-4.8,1.8-3.9,7.1-4.3,12.7C246.7,620.5,246.1,628.2,245.6,635.9z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M239.6,739.4c2.5,5.3,9.4,6.4,15.3,6.9c10.1,0.8,20.7,1.5,30.1-2.3c9.4-3.8,17.3-13.5,15.5-23.5 c-1.2-6.6-6.3-11.8-11.8-15.6c-10.3-6.9-24.8-10.8-37.1-8.1c-9.7,2.2-10.9,10.4-11.7,19C239.4,722.6,236.6,733.1,239.6,739.4z">
                                                            </path>
                                                            <path class="st2"
                                                                d="M678.2,622.7c18.9-11.2,44.8-9,61.5,5.3c9.4,8,18.4,20.3,30.6,18.2c8.1-1.4,13.8-9.5,14.5-17.6 c0.7-8.2-2.7-16.2-7.3-23c-18.4-27.4-55.8-37.8-88-30.7c-37.8,8.4-70.1,39.6-78,77.5c-7.8,37.9,10.3,80.3,44.1,99.3 c33.8,18.9,80.7,11.6,105.7-18c7-8.3,12.5-18.6,12-29.4s-8.7-21.7-19.5-22.4c-8.2-0.5-15.8,4.5-21.5,10.4 c-5.8,5.9-10.5,12.8-17.1,17.8c-11,8.2-26.6,9.7-38.9,3.7C641.3,696.5,648,640.7,678.2,622.7z">
                                                            </path>
                                                        </g>
                                                        <g id="outline">
                                                            <path
                                                                d="M679.3,450.6c-0.2-57.5-1.7-116.7-3.2-174c-1.5-57.2-3-116.3-3.2-173.6c0-2-0.8-3.9-2.2-5.3s-3.3-2.1-5.3-2.2 c-62.6,0.5-126.7,0.9-188.8,1.3c-62.3,0.4-126.8,0.8-189.7,1.3c-2,0-3.9,0.8-5.3,2.2c-1.4,1.4-2.2,3.3-2.1,5.3 c0.7,54.4,1.3,115.8,2,175.1c0.6,59.3,1.3,120.7,2,175.1c0,2,0.8,3.9,2.3,5.3c1.4,1.4,3.3,2.1,5.2,2.1c0,0,0.1,0,0.1,0 c63.4-0.8,126.9-1.7,190.5-2.6c63.5-0.9,127.1-1.8,190.4-2.6C676,458.1,679.3,454.8,679.3,450.6z M481.2,445.8 c-61,0.8-122.1,1.7-182.9,2.5c-0.6-52.5-1.3-111-1.9-167.6c-0.6-56.6-1.2-115.1-1.9-167.6c60.5-0.4,122.3-0.8,182.1-1.2 c59.5-0.4,121-0.8,181.2-1.2c0.3,55.1,1.7,111.7,3.2,166.4c1.4,54.7,2.9,111.2,3.2,166.2C603.4,444.1,542.3,444.9,481.2,445.8z M477.6,485c0-4.1-3.3-7.5-7.4-7.6c-61.5-0.8-126-1.3-188.3-1.7c-62.3-0.4-126.7-0.9-188.2-1.7c0,0-0.1,0-0.1,0 c-4.1,0-7.4,3.3-7.5,7.4l-6.6,374.3c0,2,0.7,4,2.1,5.4c1.4,1.4,3.3,2.2,5.3,2.2c40.1,0,78.3,0.3,115.2,0.6 c34.6,0.3,68.5,0.5,102.3,0.5c55.4,0,110.4-0.7,167.8-3.2c4-0.2,7.1-3.4,7.2-7.4c0.5-57.9-0.3-122.3-1-184.6 C477.9,607,477.1,542.7,477.6,485z M464.7,846.5c-89.4,3.7-173.4,3-262.3,2.4c-34.6-0.3-70.3-0.5-107.7-0.6l6.3-359.2 c59.3,0.8,121,1.2,180.8,1.6c59.8,0.4,121.5,0.8,180.7,1.6c-0.4,55.9,0.4,117.5,1.1,177.1C464.3,729,465.1,790.6,464.7,846.5z M873.2,482.4c-67.9-2.5-203.1-6.4-346.4-4.4c-4.1,0.1-7.4,3.4-7.4,7.4l-3.3,361.3c0,2,0.8,3.9,2.2,5.4c1.4,1.4,3.4,2.2,5.4,2.2 c51.9-0.3,112.8,1,171.7,2.3C747.9,857.8,802,859,850,859c6,0,11.9,0,17.6-0.1c4.1,0,7.4-3.3,7.4-7.3c1.2-56.9,1.9-119.9,2.7-180.9 c0.8-60.9,1.5-123.8,2.7-180.7C880.5,485.9,877.3,482.5,873.2,482.4z M862.7,670.5c-0.7,58.3-1.5,118.5-2.5,173.4 c-50.3,0.2-108.3-1.1-164.4-2.3c-52.5-1.2-106.6-2.4-154.5-2.4c-3.4,0-6.7,0-10,0l3.2-346.4c135.2-1.7,262.3,1.8,330.9,4.2 C864.2,552,863.5,612.2,862.7,670.5z M639.4,137.2c0-2-0.8-3.9-2.3-5.3c-1.4-1.4-3.4-2.1-5.4-2.1c-52.1,1.4-104.8,2.3-155.8,3.3 c-51,0.9-103.7,1.9-155.9,3.3c-4.1,0.1-7.4,3.5-7.3,7.7c1,47.1,2.1,92.9,3.1,138.7c1,45.8,2.1,91.6,3.1,138.7 c0.1,4.1,3.4,7.3,7.5,7.3c1.5,0,3,0,4.6,0c115.4,0,195.5-1.8,304.2-6.7c4-0.2,7.2-3.5,7.2-7.6c-0.4-49.4-1-94.8-1.5-138.7 C640.4,232,639.8,186.6,639.4,137.2z M333.8,413.8c-1-44.5-1.9-88-2.9-131.4c-1-43.4-1.9-86.8-2.9-131.3 c49.7-1.3,99.8-2.2,148.3-3.1c48.5-0.9,98.6-1.8,148.2-3.1c0.4,46.4,0.9,89.4,1.4,131.1c0.5,41.8,1,84.9,1.4,131.4 C523.3,412.1,444.8,413.8,333.8,413.8z M433.6,513c-87.7-6.5-199.6-7.5-307-2.8c-4,0.2-7.2,3.5-7.2,7.5c0.2,50.2,0.5,102,0.7,153.8 c0.2,50.9,0.5,101.8,0.7,151.1c0,4.1,3.3,7.4,7.4,7.5c72.6,0.8,130.4,1.5,186.1,1.5c39.3,0,77.4-0.3,118.9-1.1c2,0,3.9-0.9,5.3-2.3 c1.4-1.4,2.1-3.4,2.1-5.4c-1.2-53-0.6-102.8,0-151c0.6-48.3,1.2-98.3,0-151.5C440.5,516.5,437.5,513.3,433.6,513z M425.6,671.7 c-0.6,46-1.1,93.6-0.2,144c-94.7,1.6-173.2,0.9-289.6-0.5c-0.2-47-0.4-95.4-0.6-143.7c-0.2-49.3-0.4-98.6-0.7-146.6 c101.9-4.2,207.1-3.3,291.2,2.6C426.7,577.9,426.1,625.6,425.6,671.7z M558.4,520.7c-1.4,47.2-1.7,96.2-2.1,143.5 c-0.4,47.3-0.7,96.2-2.1,143.2c-0.1,4.1,3.1,7.5,7.2,7.7c60.6,2.6,106.1,2.8,150.1,2.9c36,0.1,73.1,0.3,118,1.7c0.1,0,0.2,0,0.2,0 c2,0,3.9-0.8,5.3-2.2c1.5-1.4,2.3-3.4,2.2-5.5c-1.1-48.5-0.6-96.8-0.1-143.4c0.5-46.8,1-95.2-0.1-143.9c-0.1-4-3.3-7.3-7.4-7.3 c-42.9-0.7-88.1-1.4-131.9-2c-43.8-0.7-89-1.3-131.9-2C561.9,513.3,558.5,516.6,558.4,520.7z M571.3,664.3 c0.3-44.8,0.7-91.1,1.9-135.8c40.7,0.6,83.2,1.3,124.5,1.9c41.3,0.6,84,1.3,124.7,1.9c0.9,46.1,0.4,91.9-0.1,136.2 c-0.5,44.3-1,90-0.1,136c-41.6-1.2-76.6-1.4-110.6-1.5c-42.1-0.2-85.5-0.3-142.2-2.6C570.6,755.5,570.9,709.2,571.3,664.3z M541.2,230.7c-8.6-19.7-23.1-46.4-49.4-50.3c-13.2-2-27.7,2.6-39.7,12.5c-10.8,8.9-18.3,20.5-24.1,30.8 c-21.7,37.8-35.1,81.4-38.8,126.3c-0.1,0.8-0.2,1.7-0.2,2.7c-1.1,11.4-3,32.6,12.7,39.7c3.2,1.5,6.5,2.2,9.7,2.2c3,0,6-0.6,8.8-1.9 c13.3-5.9,20.9-24.3,24.2-34.7c2.9-9,6.1-19.1,13.2-24.2c6.3-4.5,15.3-4.9,25.5-5c16-0.1,31.8,1.2,38.8,11.4 c2.4,3.5,3.7,8,5.1,12.8c0.6,2.2,1.3,4.5,2.1,6.7c4,11.6,11.1,19.1,20,21.1c13.7,3.2,26.4-8,29.7-20.4c2.9-10.8,0.3-21.7-2.6-31.9 C566.7,295.2,555,262.3,541.2,230.7z M564.2,356.5c-1.5,5.4-6.9,10.8-11.8,9.7c-5.1-1.2-8.2-8.4-9.2-11.5c-0.7-1.9-1.2-3.9-1.9-6 c-1.7-5.7-3.4-11.6-7.1-17.1c-12.5-18.2-38.7-18-51.3-17.9c-9.9,0.1-23.5,0.2-34.1,7.9c-11.1,8-15.3,21.2-18.7,31.8 c-4.2,13-10.5,23.1-16,25.5c-2,0.9-3.9,0.8-6.2-0.3c-6-2.7-4.7-17-4-24.7c0.1-1,0.2-1.9,0.3-2.8c3.5-42.7,16.3-84.2,36.9-120h0 c5.2-9,11.7-19.3,20.7-26.6c7.5-6.2,16.1-9.5,24-9.5c1.3,0,2.7,0.1,4,0.3c9.1,1.3,22.9,7.1,37.8,41.4c13.5,31,25.1,63.3,34.3,95.9 C564.1,341.1,566.1,349.3,564.2,356.5z M498.7,245.6c-3.7-4.6-10.9-10.2-19-10.8c-4.8-0.3-9.1,1.2-12.5,4.4 c-6,5.7-10.2,16.6-12.6,32.3c-0.4,2.8-1.6,11.1,4,17c4.8,5,11.6,5.1,14.9,5.2c1.6,0,3.2,0.1,4.8,0.1c4,0,8.1-0.1,12.1-0.3 c3-0.2,8.5-0.5,12.9-4.1c5.7-4.7,7.3-12.4,4.6-22.8C506.1,259.3,503.7,251.8,498.7,245.6z M493.7,277.7c-0.4,0.3-1.8,0.6-4.2,0.7 c-5.2,0.3-10.5,0.4-15.7,0.3c-3-0.1-4-0.4-4.4-0.6c-0.1-0.2-0.4-1.3,0-4.5c1.7-11.6,4.7-20.4,8-23.6c0.2-0.2,0.4-0.4,1.2-0.3 c2.4,0.2,6.1,2.5,8.3,5.2c3.3,4.1,5,9.7,6.4,15.2C494.9,276.3,493.8,277.7,493.7,277.7z M365.6,642.2c9.9-23.9,1.6-54.6-18.9-70 c-25.8-19.4-52.4-19.2-83.2-19c-6,0-12.2,0.1-18.5,0c-17.3-0.3-30,3.8-37.8,12.1c-7.3,7.8-9.1,18.3-10,28.5l-12.5,149.9 c-0.7,8.8-1.8,22.1,5.9,32.2c7.7,10.1,20.6,12.5,32.1,13.6c14.9,1.4,31.1,2.9,47.7,2.9c7,0,14.1-0.3,21.2-0.9 c22.1-2.1,47.1-6.3,62.9-30.2c11.7-17.6,17.7-44.2,5-64.1c-7.4-11.6-14.3-18.7-22.1-24C349.5,667.3,358.4,659.4,365.6,642.2z M317.4,665.1c-2.9,1-4.8,3.7-5,6.7c-0.1,3,1.6,5.9,4.4,7.1c12.6,5.8,20.4,11.2,30,26.3c9.1,14.2,3.8,34.7-4.8,47.7 c-11,16.6-28,21.3-51.8,23.6c-22.4,2.1-45.6-0.1-66.1-2c-8.3-0.8-17.4-2.3-21.6-7.8c-3.9-5.1-3.6-13.3-2.9-21.9L212.1,595 c0.7-8.6,2-15.2,6-19.4c4.6-4.9,13-7.3,25.1-7.3c0.5,0,1,0,1.5,0c6.5,0.1,12.8,0.1,18.9,0c29.2-0.2,52.3-0.4,74.1,16 c15,11.3,21.3,34.7,14,52.2C344.4,654,336.5,658.2,317.4,665.1z M303.7,605.5c-5.1-4.9-10.9-7.3-15.5-8.9 c-17.1-5.9-30-7.1-39.4-3.5c-8.6,3.3-8.8,11.6-9,16.5c0,0.9-0.1,1.7-0.1,2.6l-1.6,23.1c0,0,0,0,0,0c-0.2,2.5-0.4,6.4,1.1,10.1 c2.2,5.5,7.1,8.7,14.5,9.7c5.6,0.7,11.2,1.1,16.9,1.1c3,0,6-0.1,9-0.3c6.6-0.5,14.4-1.6,21.2-6.3c7.9-5.5,12.6-15.1,12.2-24.5 C312.6,617.9,309.2,610.7,303.7,605.5z M292.2,637.4c-3.8,2.7-8.8,3.3-13.7,3.7c-7.6,0.5-15.3,0.3-22.9-0.7 c-1.6-0.2-2.3-0.5-2.6-0.6c-0.1-0.7,0-2.4,0-3.3l1.6-23.1c0.1-1.1,0.1-2.2,0.1-3.2c0-1,0.1-2.4,0.2-3.3c3.7-1.1,12-1.8,28.3,3.9 c4.7,1.6,7.7,3.3,10,5.5c2.7,2.6,4.4,6.2,4.6,9.6C298.2,630.9,295.2,635.2,292.2,637.4z M292.9,698.6c-12.9-8.7-29.3-12.2-42.9-9.2 c-15.6,3.5-16.8,17.9-17.5,25.7c-0.1,1.4-0.4,3.1-0.6,5c-1,7-2.3,15.6,1,22.5h0c4.7,9.9,16.9,10.8,21.5,11.2 c4,0.3,8.3,0.6,12.8,0.6c6.8,0,13.9-0.7,20.7-3.5c11.7-4.7,22.7-17.4,20.1-31.8C306.5,711.4,301.3,704.3,292.9,698.6z M282.3,737 c-8,3.2-18,2.5-26.8,1.8c-7.3-0.6-8.8-2-9.1-2.6c-1.3-2.8-0.3-9.4,0.3-13.9c0.3-2,0.6-4,0.7-5.8c0.8-9.7,2.2-11.6,5.8-12.4 c9.6-2.1,21.8,0.6,31.3,7c2.8,1.9,7.7,5.8,8.6,10.7C294.3,728,288.4,734.5,282.3,737z M767.2,738.6c9.6-11.3,14.3-23.2,13.7-34.7 c-0.8-15.4-12.7-28.6-26.5-29.5c-9.2-0.6-18.7,3.8-27.4,12.7c-2.2,2.2-4.2,4.5-6.1,6.8c-3.3,3.9-6.5,7.5-10.1,10.2 c-8.8,6.6-21.2,7.7-31.1,2.9c-16.1-7.9-19.1-23.9-19.4-32.8c-0.8-18.4,8.2-37,21.8-45c16.2-9.7,38.4-7.8,52.7,4.5 c1.8,1.5,3.6,3.2,5.5,5.1c8,7.6,17.9,17.1,31.3,14.8c11-1.9,19.7-12.1,20.7-24.4c0.8-8.9-2.1-18.3-8.5-27.8 c-19-28.2-58.4-42.1-95.9-33.8c-20.1,4.4-38.7,14.7-53.9,29.6c-15.4,15.2-25.7,33.7-29.8,53.7c-8.6,41.8,11.5,87,47.8,107.3 c13.8,7.7,29.4,11.4,44.9,11.4C723.5,769.7,750,758.8,767.2,738.6z M710.6,753.5c-18.1,3-36.3,0-51.2-8.3 c-14.8-8.3-27.1-22.2-34.5-39c-7.4-16.7-9.5-35.3-6-52.2c7.1-34.4,36.8-63.9,72.2-71.7c6.2-1.4,12.5-2,18.7-2 c25.2,0,48.9,11,61.4,29.6c3.1,4.6,6.6,11.4,6,18.1c-0.5,5.3-4.2,10.2-8.3,10.9c-5.5,0.9-10.9-3.7-18.4-10.9c-2-1.9-4-3.8-6.1-5.6 c-19.1-16.4-48.6-18.9-70.2-6c-18.4,11-30.1,34.5-29.1,58.5c0.9,20.7,11,37.4,27.8,45.6c14.8,7.2,33.5,5.5,46.7-4.4 c4.9-3.7,8.8-8.1,12.5-12.4c1.9-2.2,3.6-4.2,5.5-6.1c3.9-3.9,9.7-8.6,15.7-8.2c7,0.5,12.2,8.4,12.5,15.3 c0.5,9.5-5.3,18.4-10.2,24.2C744.8,741.7,728.8,750.5,710.6,753.5z">
                                                            </path>
                                                        </g>
                                                        <g class="st0" id="flat">
                                                            <g class="st3">
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st9"
                                                                                                d="M671.8,450.7c-0.3-114.8-6-232.7-6.4-347.6c-125.5,0.9-252.9,1.6-378.4,2.5 c1.3,108.9,2.6,241.4,3.9,350.2C417.6,454.2,545.1,452.4,671.8,450.7z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st8"
                                                                                                d="M472.1,853.7c1-115.6-3-253.2-2.1-368.8c-123-1.7-253.4-1.7-376.4-3.4c-2.2,124.8-4.4,249.5-6.6,374.3 C227.1,855.8,342.9,859.3,472.1,853.7z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st11"
                                                                                                d="M867.6,851.4c2.3-113.7,3.1-247.8,5.4-361.5c-92.9-3.4-218.9-6.2-346-4.4 c-1.1,120.4-2.2,240.9-3.3,361.3C627.6,846.1,763.5,852.1,867.6,851.4z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st11"
                                                                                                d="M634.9,414.7c-0.9-98.7-2.1-178.6-3-277.3c-104.3,2.7-207.3,3.8-311.6,6.5 c2.1,94.2,4.1,183.3,6.2,277.5C442.3,421.4,523.6,419.7,634.9,414.7z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st9"
                                                                                                d="M433.1,823c-2.4-106.2,2.4-196.4,0-302.5c-96-7.1-209.9-7-306.1-2.8c0.5,99.6,0.9,205.4,1.4,304.9 C177.8,823.2,331,824.9,433.1,823z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st8"
                                                                                                d="M829.8,812.3c-2.2-97.2,2-190.1-0.1-287.4c-85.8-1.4-178.1-2.7-263.8-4c-2.7,94.2-1.4,192.5-4.1,286.7 C671.8,812.3,730,809,829.8,812.3z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st10"
                                                                                                d="M568.9,330.5c-9.3-33-20.9-65.4-34.6-96.8c-8.8-20.2-21.8-42.6-43.6-45.9 c-12.1-1.8-24.4,3.1-33.9,10.8s-16.3,18.1-22.4,28.7c-21.6,37.6-34.3,79.9-37.8,123.2c-0.9,10.3-3.8,29.6,8.1,35 c17.7,8.1,28.7-17.8,32.5-29.8c3.3-10.4,7-21.6,15.9-28c8.4-6,19.5-6.4,29.8-6.4c16.5-0.1,35.7,1.1,45.1,14.7 c4.3,6.3,5.6,14.1,8.1,21.3c2.5,7.2,7.2,14.6,14.6,16.3c9.2,2.2,18.3-5.9,20.8-15C573.9,349.3,571.5,339.6,568.9,330.5z M498.5,283.5c-2.3,1.9-5.5,2.2-8.5,2.4c-5.4,0.3-10.9,0.4-16.3,0.3c-3.4-0.1-7.2-0.4-9.6-2.9c-2.6-2.7-2.5-7-2-10.7 c1.2-8.2,4-22,10.3-27.9c6.1-5.8,16,0,20.5,5.6c4.1,5.2,6.2,11.7,7.8,18.1C502,273.6,502.7,280.1,498.5,283.5z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st11"
                                                                                                d="M411.3,387.5c-2.2,0-4.5-0.5-6.8-1.6c-11.2-5.1-9.6-21.7-8.6-32.7c0.1-1,0.2-1.9,0.2-2.7 c3.6-43.8,16.7-86.5,37.9-123.4c5.6-9.7,12.6-20.7,22.5-28.8c10.5-8.6,23-12.6,34.2-10.9c22.9,3.4,36.1,28,44,46.2 c13.7,31.4,25.3,64,34.6,96.9l0,0c2.7,9.7,5,19.1,2.5,28.2c-2.5,9.3-11.7,17.7-21.4,15.4c-8.7-2-13.1-11.3-15-16.6 c-0.7-2.1-1.4-4.3-2-6.4c-1.5-5.1-3-10.4-6-14.8c-8.9-13-26.7-14.6-44.6-14.4c-11.5,0.1-21.6,0.6-29.5,6.3 c-8.9,6.4-12.5,17.7-15.7,27.7c-2.4,7.5-9.2,25.4-20.4,30.4C415.3,387,413.3,387.5,411.3,387.5z M485.6,187.9 c-9.6,0-19.7,3.9-28.5,11.1c-9.8,8.1-16.8,19-22.3,28.6c-21.1,36.7-34.1,79.3-37.8,123c-0.1,0.9-0.2,1.8-0.2,2.7 c-1,10.7-2.5,26.9,8,31.7c4.1,1.9,8.2,2,12,0.3c10.9-4.8,17.5-22.4,19.8-29.8c3.1-9.6,6.9-21.6,16.1-28.2 c8.2-5.9,18.5-6.4,30.1-6.5c18.2-0.2,36.3,1.5,45.5,14.9c3.1,4.5,4.7,9.9,6.2,15.1c0.6,2.1,1.2,4.3,2,6.3 c1.8,5.1,6,14.1,14.2,16c9,2.1,17.9-6,20.2-14.7c2.4-8.9,0.2-18.1-2.5-27.6l0,0c-9.3-32.9-20.9-65.4-34.6-96.8 c-16.4-37.5-32.5-44-43.2-45.6C489,188.1,487.3,187.9,485.6,187.9z M478.3,286.7c-1.6,0-3.1,0-4.6-0.1 c-3.5-0.1-7.4-0.4-10-3c-2.9-3-2.6-7.8-2.1-11.2c1.4-9.7,4.4-22.5,10.4-28.2c2-1.8,4.4-2.7,7.2-2.5 c5.4,0.4,11.1,4.5,14,8.2c4.2,5.2,6.3,11.9,7.9,18.3c1.9,7.7,1.2,12.8-2.3,15.7h0c-2.4,2-5.7,2.3-8.8,2.5 C486.1,286.6,482.2,286.7,478.3,286.7z M478.4,242.7c-2.2,0-4.2,0.8-5.7,2.2c-5.8,5.5-8.7,18.1-10.1,27.6 c-0.5,3.1-0.8,7.6,1.8,10.3c2.3,2.4,6,2.7,9.3,2.7c5.4,0.1,10.9,0,16.3-0.3c3-0.2,6.1-0.5,8.3-2.3l0,0 c3.2-2.6,3.8-7.4,2-14.7c-1.6-6.3-3.6-12.8-7.7-17.9c-2.8-3.5-8.2-7.4-13.3-7.8C478.9,242.7,478.7,242.7,478.4,242.7z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st11"
                                                                                                d="M320,672.2c19.8-7.1,30.1-12.2,38.7-32.9c8.6-20.6,1.5-47.7-16.4-61.1 c-28.7-21.5-59.4-16.9-97.4-17.5c-9.7-0.2-24,0.9-32.2,9.7c-5.9,6.3-7.2,15.4-8,24c-4.2,50-8.3,100-12.5,149.9 c-0.8,9.3-1.3,19.6,4.4,27c6,7.9,17,9.8,26.8,10.7c22.4,2.1,45.1,4.1,67.5,2c23.8-2.2,44.2-7,57.4-26.9 c10.8-16.3,15.4-39.5,4.9-55.9C342.6,684.8,333.6,678.4,320,672.2z M285.1,743.9c-9.4,3.8-20,3.1-30.1,2.3 c-5.9-0.4-12.8-1.6-15.3-6.9c-3-6.3-0.2-16.8,0.3-23.5c0.8-8.6,2-16.9,11.7-19c12.3-2.7,26.8,1.1,37.1,8.1 c5.6,3.7,10.6,9,11.8,15.6C302.4,730.4,294.5,740.2,285.1,743.9z M296.5,643.5c-5.2,3.6-11.4,4.6-17.4,5 c-8.1,0.6-16.3,0.3-24.4-0.7c-3.3-0.4-7-1.4-8.5-5.1c-0.8-2.1-0.7-4.5-0.5-6.8c0.5-7.7,1.1-15.4,1.6-23.1 c0.4-5.6-0.5-10.8,4.3-12.7c9.8-3.8,24.5,0.2,34.2,3.6c4.5,1.6,9,3.6,12.8,7.2c3.7,3.6,6.6,8.9,6.9,14.7 C305.8,633,301.7,639.9,296.5,643.5z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st9"
                                                                                                d="M678.2,622.7c18.9-11.2,44.8-9,61.5,5.3c9.4,8,18.4,20.3,30.6,18.2c8.1-1.4,13.8-9.5,14.5-17.6 c0.7-8.2-2.7-16.2-7.3-23c-18.4-27.4-55.8-37.8-88-30.7c-37.8,8.4-70.1,39.6-78,77.5c-7.8,37.9,10.3,80.3,44.1,99.3 c33.8,18.9,87.7,11.6,112.7-18c7-8.3,12.5-18.6,12-29.4s-8.7-21.7-19.5-22.4c-8.2-0.5-15.8,4.5-21.5,10.4 c-5.8,5.9-10.5,12.8-17.1,17.8c-11,8.2-33.6,9.7-45.9,3.7C641.3,696.5,648,640.7,678.2,622.7z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st7"
                                                                                                d="M636.5,424.3c-4.1,0-7.4-3.2-7.5-7.3c-1.2-49.4-2.1-94.8-3-138.7c-0.9-41.7-1.8-84.8-2.9-131.3 c-32.2-0.4-61.5-0.5-89.3-0.5c0,0,0,0,0,0c-4.1,0-7.5-3.4-7.5-7.5c0-4.1,3.3-7.5,7.5-7.5c30,0,61.7,0.2,96.8,0.6 c4,0,7.3,3.3,7.4,7.3c1.2,49.3,2.1,94.7,3,138.6c0.9,43.9,1.9,89.3,3,138.7c0.1,4.1-3.2,7.6-7.3,7.7 C636.6,424.3,636.5,424.3,636.5,424.3z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st7"
                                                                                                d="M389.1,429.1c-7.7,0-14.8-0.1-23-0.1c-10.5-0.1-22.4-0.2-39.7-0.2c-4.1,0-7.4-3.3-7.5-7.3 c-1-47.1-1.3-59-1.6-70.9c-0.3-11.9-0.5-23.8-1.6-70.9c-0.1-4.1,3.2-7.6,7.3-7.7c4.2-0.1,7.6,3.2,7.7,7.3 c1,47.1,1.3,59,1.6,70.9c0.3,11.3,0.5,22.5,1.4,63.6c13.4,0,23.5,0.1,32.4,0.2c17.5,0.1,30.2,0.2,54.9-0.2c0,0,0.1,0,0.1,0 c4.1,0,7.4,3.3,7.5,7.4c0.1,4.1-3.2,7.6-7.4,7.6C408,429,398.1,429.1,389.1,429.1z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st7"
                                                                                                d="M269.5,831.6C269.5,831.6,269.5,831.6,269.5,831.6c-16.8-0.1-30.9-0.2-43.4-0.2 c-37.9-0.2-60.8-0.3-98-1.2c-4.1-0.1-7.3-3.4-7.3-7.5c-0.2-49.3-0.5-100.2-0.7-151.1c-0.2-51.8-0.5-103.6-0.7-153.8 c0-4,3.1-7.4,7.2-7.5c96.7-4.2,143-4.5,235.9-1.1c4.1,0.2,7.4,3.6,7.2,7.8c-0.2,4.1-3.6,7.3-7.8,7.2 c-90.1-3.3-136.1-3.2-227.5,0.8c0.2,48,0.4,97.3,0.7,146.6c0.2,48.4,0.4,96.8,0.6,143.8c32.9,0.8,55.1,0.9,90.4,1.1 c12.5,0.1,26.6,0.1,43.4,0.2c4.1,0,7.5,3.4,7.5,7.5C277,828.3,273.7,831.6,269.5,831.6z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st7"
                                                                                                d="M829.8,819.8c-0.1,0-0.2,0-0.2,0c-32.4-1.1-78.8-1.4-110.8-1.6c-4.1,0-7.5-3.4-7.5-7.5 c0-4.1,3.4-7.4,7.5-7.5c29.6,0.2,71.4,0.5,103.3,1.4c-0.9-46.1-0.4-91.8,0.1-136c0.5-44.4,1-90.2,0.1-136.2 c-37.9-0.6-55.1-1.3-71.9-1.9c-17.7-0.7-36-1.3-78.8-2c-4.1-0.1-7.4-3.5-7.4-7.6c0.1-4.1,3.5-7.5,7.6-7.4 c43,0.7,61.3,1.4,79.1,2c17.7,0.7,36,1.3,78.8,2c4,0.1,7.3,3.3,7.4,7.3c1.1,48.7,0.6,97.1,0.1,143.9 c-0.5,46.7-1,94.9,0.1,143.4c0,2.1-0.8,4-2.2,5.5C833.7,819,831.8,819.8,829.8,819.8z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path class="st7"
                                                                                                d="M641.4,817.7C641.4,817.7,641.3,817.7,641.4,817.7c-25.9-0.3-38.4-0.8-66-2l-14-0.6 c-4.1-0.2-7.3-3.7-7.2-7.8c0.2-4.1,3.7-7.4,7.8-7.2l14,0.6c27.4,1.2,39.9,1.7,65.5,2c4.1,0,7.5,3.4,7.4,7.6 C648.9,814.4,645.5,817.7,641.4,817.7z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g class="st0" id="colored_x5F_line">
                                                            <g class="st3">
                                                                <path class="st8"
                                                                    d="M527,485.5c-1.1,120.4-2.2,240.9-3.3,361.3c104-0.7,239.9,5.3,343.9,4.6c2.3-113.7,3.1-247.8,5.4-361.5 C780.1,486.4,654,483.7,527,485.5z M829.8,812.3c-99.8-3.3-158,0.1-268.1-4.7c2.7-94.2,1.4-192.5,4.1-286.7 c85.8,1.4,178.1,2.7,263.8,4C831.8,622.1,827.6,715,829.8,812.3z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st8"
                                                                    d="M665.4,103.1c-125.5,0.9-252.9,1.6-378.4,2.5c1.3,108.9,2.6,241.4,3.9,350.2c126.7-1.7,254.2-3.5,380.9-5.2 C671.4,335.9,665.7,217.9,665.4,103.1z M326.4,421.3c-2.1-94.2-4.1-183.3-6.2-277.5c104.3-2.7,207.3-3.8,311.6-6.5 c0.9,98.7,2.1,178.6,3,277.3C523.6,419.7,442.3,421.4,326.4,421.3z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st8"
                                                                    d="M470.1,484.9c-123-1.7-253.4-1.7-376.4-3.4c-2.2,124.8-4.4,249.5-6.6,374.3c140.1,0,255.8,3.5,385.1-2.1 C473.1,738.1,469.1,600.6,470.1,484.9z M433.1,823c-102,1.9-185.5,1-304.7-0.4c-0.5-99.6-0.9-205.4-1.4-304.9 c96.2-4.2,210.1-4.3,306.1,2.8C435.4,626.7,430.7,716.9,433.1,823z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st16"
                                                                    d="M331,428.8c-1.5,0-3,0-4.6,0c-4.1,0-7.4-3.3-7.5-7.3c-1-47.1-2.1-92.9-3.1-138.7c-1-45.8-2.1-91.7-3.1-138.7 c-0.1-4.1,3.2-7.6,7.3-7.7C372.3,135,425,134,476,133.1c50.9-0.9,103.6-1.9,155.8-3.3c2,0,4,0.7,5.4,2.1c1.4,1.4,2.3,3.3,2.3,5.3 c0.4,49.3,1,94.7,1.5,138.6c0.5,43.9,1.1,89.3,1.5,138.7c0,4-3.1,7.4-7.2,7.6C526.5,427.1,446.3,428.8,331,428.8z M327.9,151.2 c1,44.5,1.9,87.9,2.9,131.3c1,43.4,1.9,86.9,2.9,131.4c111.1,0,189.6-1.7,293.6-6.3c-0.4-46.6-0.9-89.7-1.4-131.4 c-0.5-41.6-1-84.6-1.4-131.1c-49.7,1.3-99.8,2.2-148.2,3.1C427.7,149,377.6,149.9,327.9,151.2z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st16"
                                                                    d="M314.3,831.6c-55.7,0-113.5-0.6-186.1-1.5c-4.1,0-7.4-3.4-7.4-7.5c-0.2-49.3-0.5-100.2-0.7-151.1 c-0.2-51.8-0.5-103.6-0.7-153.8c0-4,3.1-7.4,7.2-7.5c107.4-4.7,219.3-3.7,307,2.8c3.9,0.3,6.9,3.5,6.9,7.3 c1.2,53.2,0.6,103.2,0,151.5c-0.6,48.2-1.2,98,0,151c0,2-0.7,3.9-2.1,5.4c-1.4,1.4-3.3,2.3-5.3,2.3 C391.7,831.3,353.5,831.6,314.3,831.6z M135.8,815.2c116.4,1.4,195,2.1,289.6,0.5c-1-50.4-0.4-97.9,0.2-144 c0.6-46.1,1.1-93.8,0.1-144.2c-84.1-5.9-189.4-6.8-291.2-2.6c0.2,48,0.4,97.3,0.7,146.6C135.3,719.8,135.6,768.2,135.8,815.2z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st16"
                                                                    d="M829.8,819.8c-0.1,0-0.2,0-0.2,0c-44.9-1.5-82.1-1.6-118-1.7c-44-0.2-89.6-0.3-150.1-2.9 c-4.1-0.2-7.3-3.6-7.2-7.7c1.4-47,1.7-95.9,2.1-143.2c0.4-47.4,0.7-96.3,2.1-143.5c0.1-4.1,3.5-7.3,7.6-7.3 c42.9,0.7,88.1,1.4,131.9,2c43.8,0.7,89,1.3,131.9,2c4,0.1,7.3,3.3,7.4,7.3c1.1,48.7,0.6,97.1,0.1,143.9 c-0.5,46.7-1,94.9,0.1,143.4c0,2.1-0.8,4-2.2,5.5C833.7,819,831.8,819.8,829.8,819.8z M569.4,800.4c56.6,2.3,100.1,2.4,142.2,2.6 c33.9,0.1,69,0.3,110.6,1.5c-0.9-46.1-0.4-91.8,0.1-136c0.5-44.4,1-90.2,0.1-136.2c-40.7-0.6-83.4-1.3-124.7-1.9 c-41.3-0.6-83.8-1.2-124.5-1.9c-1.2,44.8-1.5,91-1.9,135.8C570.9,709.2,570.6,755.5,569.4,800.4z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st8"
                                                                    d="M568.9,330.5c-9.3-33-20.9-65.4-34.6-96.8c-8.8-20.2-21.8-42.6-43.6-45.9c-12.1-1.8-24.4,3.1-33.9,10.8 s-16.3,18.1-22.4,28.7c-21.6,37.6-34.3,79.9-37.8,123.2c-0.9,10.3-3.8,29.6,8.1,35c17.7,8.1,28.7-17.8,32.5-29.8 c3.3-10.4,7-21.6,15.9-28c8.4-6,19.5-6.4,29.8-6.4c16.5-0.1,35.7,1.1,45.1,14.7c4.3,6.3,5.6,14.1,8.1,21.3 c2.5,7.2,7.2,14.6,14.6,16.3c9.2,2.2,18.3-5.9,20.8-15C573.9,349.3,571.5,339.6,568.9,330.5z M498.5,283.5 c-2.3,1.9-5.5,2.2-8.5,2.4c-5.4,0.3-10.9,0.4-16.3,0.3c-3.4-0.1-7.2-0.4-9.6-2.9c-2.6-2.7-2.5-7-2-10.7c1.2-8.2,4-22,10.3-27.9 c6.1-5.8,16,0,20.5,5.6c4.1,5.2,6.2,11.7,7.8,18.1C502,273.6,502.7,280.1,498.5,283.5z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st8"
                                                                    d="M320,672.2c19.8-7.1,30.1-12.2,38.7-32.9c8.6-20.6,1.5-47.7-16.4-61.1c-28.7-21.5-59.4-16.9-97.4-17.5 c-9.7-0.2-24,0.9-32.2,9.7c-5.9,6.3-7.2,15.4-8,24c-4.2,50-8.3,100-12.5,149.9c-0.8,9.3-1.3,19.6,4.4,27c6,7.9,17,9.8,26.8,10.7 c22.4,2.1,45.1,4.1,67.5,2c23.8-2.2,44.2-7,57.4-26.9c10.8-16.3,15.4-39.5,4.9-55.9C342.6,684.8,333.6,678.4,320,672.2z M285.1,743.9c-9.4,3.8-20,3.1-30.1,2.3c-5.9-0.4-12.8-1.6-15.3-6.9c-3-6.3-0.2-16.8,0.3-23.5c0.8-8.6,2-16.9,11.7-19 c12.3-2.7,26.8,1.1,37.1,8.1c5.6,3.7,10.6,9,11.8,15.6C302.4,730.4,294.5,740.2,285.1,743.9z M296.5,643.5 c-5.2,3.6-11.4,4.6-17.4,5c-8.1,0.6-16.3,0.3-24.4-0.7c-3.3-0.4-7-1.4-8.5-5.1c-0.8-2.1-0.7-4.5-0.5-6.8 c0.5-7.7,1.1-15.4,1.6-23.1c0.4-5.6-0.5-10.8,4.3-12.7c9.8-3.8,24.5,0.2,34.2,3.6c4.5,1.6,9,3.6,12.8,7.2 c3.7,3.6,6.6,8.9,6.9,14.7C305.8,633,301.7,639.9,296.5,643.5z">
                                                                </path>
                                                            </g>
                                                            <g class="st3">
                                                                <path class="st8"
                                                                    d="M678.2,622.7c18.9-11.2,37.8-9,54.5,5.3c9.4,8,18.4,20.3,30.6,18.2c8.1-1.4,13.8-9.5,14.5-17.6 c0.7-8.2-2.7-16.2-7.3-23c-18.4-27.4-48.8-37.8-81-30.7c-37.8,8.4-70.1,39.6-78,77.5c-7.8,37.9,10.3,80.3,44.1,99.3 c33.8,18.9,80.7,11.6,105.7-18c7-8.3,12.5-18.6,12-29.4s-8.7-21.7-19.5-22.4c-8.2-0.5-15.8,4.5-21.5,10.4 c-5.8,5.9-10.5,12.8-17.1,17.8c-11,8.2-26.6,9.7-38.9,3.7C641.3,696.5,648,640.7,678.2,622.7z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h3 itemprop="title" class="post-title font-19 font-weight-bold">
                                            English
                                        </h3>
                                        <p itemprop="description" class="font-16 text-gray">Patterns, sequencing and
                                            geometry</p>
                                    </div>
                                </a>
                            </li>
                            <li class="exame-list">
                                <a href="{{url('/')}}/pricing" class="d-flex align-items-center">
                                    <div class="img-holder">
                                        <figure>
                                            <span class="icon-savg">
                                                <svg fill="#f18700" height="64px" width="64px" version="1.1" id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 486.1 486.1"
                                                    xml:space="preserve">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="M445.5,0H40.7C18.3,0,0,18.3,0,40.7v404.7c0,22.4,18.3,40.7,40.7,40.7h404.7c22.4,0,40.7-18.3,40.7-40.7V40.7 C486.2,18.3,467.9,0,445.5,0z M462.2,445.5c0,9.2-7.5,16.7-16.7,16.7H40.7c-9.2,0-16.7-7.5-16.7-16.7V40.7 C24,31.5,31.5,24,40.7,24h404.7c9.2,0,16.7,7.5,16.7,16.7v404.8H462.2z">
                                                                </path>
                                                                <path
                                                                    d="M193,300.6c-4.7-4.7-12.3-4.7-17,0l-36.1,36.1l-36.1-36.1c-4.7-4.7-12.3-4.7-17,0s-4.7,12.3,0,17l36.1,36.1l-36.1,36.1 c-4.7,4.7-4.7,12.3,0,17c2.3,2.3,5.4,3.5,8.5,3.5c3.1,0,6.1-1.2,8.5-3.5l36.1-36.1l36.1,36.1c2.3,2.3,5.4,3.5,8.5,3.5 s6.1-1.2,8.5-3.5c4.7-4.7,4.7-12.3,0-17l-36.1-36.1l36.1-36.1C197.7,312.9,197.7,305.3,193,300.6z">
                                                                </path>
                                                                <path
                                                                    d="M203,131.7h-51v-51c0-6.6-5.4-12-12-12s-12,5.4-12,12v51H77c-6.6,0-12,5.4-12,12s5.4,12,12,12h51v51c0,6.6,5.4,12,12,12 s12-5.4,12-12v-51h51c6.6,0,12-5.4,12-12S209.6,131.7,203,131.7z">
                                                                </path>
                                                                <path
                                                                    d="M403.9,371.1H296.4c-6.6,0-12,5.4-12,12s5.4,12,12,12h107.4c6.6,0,12-5.4,12-12S410.5,371.1,403.9,371.1z">
                                                                </path>
                                                                <path
                                                                    d="M403.9,312.2H296.4c-6.6,0-12,5.4-12,12s5.4,12,12,12h107.4c6.6,0,12-5.4,12-12S410.5,312.2,403.9,312.2z">
                                                                </path>
                                                                <path
                                                                    d="M394.6,155.7c6.6,0,12-5.4,12-12s-5.4-12-12-12H287.1c-6.6,0-12,5.4-12,12s5.4,12,12,12H394.6z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h3 itemprop="title" class="post-title font-19 font-weight-bold">
                                            Maths
                                        </h3>
                                        <p itemprop="description" class="font-16 text-gray">Patterns, sequencing and
                                            geometry</p>
                                    </div>
                                </a>
                            </li>
                            <li class="exame-list border-right">
                                <a href="{{url('/')}}/pricing" class="d-flex align-items-center">
                                    <div class="img-holder">
                                        <figure>
                                            <span class="icon-savg">
                                                <svg width="64px" height="64px" viewBox="0 0 512 512"
                                                    xmlns="http://www.w3.org/2000/svg" fill="#f35b05">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill="#f35b05"
                                                            d="M83.014 30.53c-14.8 0-26.118 5.868-33.96 17.6-7.782 11.675-11.673 28.656-11.673 50.942 0 22.228 3.892 39.207 11.675 50.94 7.84 11.674 19.16 17.51 33.96 17.51 14.797 0 26.09-5.836 33.872-17.51 7.84-11.733 11.76-28.712 11.76-50.94 0-22.286-3.92-39.267-11.76-50.94-7.783-11.734-19.075-17.6-33.873-17.6zm230.648 0c-14.8 0-26.12 5.868-33.96 17.6-7.783 11.675-11.675 28.656-11.675 50.942 0 22.228 3.892 39.207 11.674 50.94 7.843 11.674 19.163 17.51 33.962 17.51 14.8 0 26.09-5.836 33.87-17.51 7.843-11.733 11.765-28.712 11.765-50.94 0-22.286-3.922-39.267-11.764-50.94-7.782-11.734-19.072-17.6-33.87-17.6zm115.324 0c-14.798 0-26.12 5.868-33.96 17.6-7.783 11.675-11.674 28.656-11.674 50.942 0 22.228 3.89 39.207 11.673 50.94 7.842 11.674 19.163 17.51 33.96 17.51 14.8 0 26.09-5.836 33.872-17.51 7.842-11.733 11.762-28.712 11.762-50.94 0-22.286-3.92-39.267-11.763-50.94-7.782-11.734-19.072-17.6-33.87-17.6zm-236.75 2.39l-31.572 6.367V55.56l31.748-6.367v100.73H163.23v15.036h76.055v-15.036H210.1V32.92h-17.864zM83.014 44.682c9.256 0 16.184 4.54 20.783 13.62 4.658 9.02 6.986 22.61 6.986 40.77 0 18.1-2.328 31.69-6.986 40.77-4.6 9.02-11.527 13.53-20.783 13.53-9.198 0-16.124-4.51-20.782-13.53-4.598-9.08-6.898-22.67-6.898-40.77 0-18.16 2.3-31.75 6.898-40.77 4.658-9.08 11.584-13.62 20.782-13.62zm230.648 0c9.257 0 16.185 4.54 20.783 13.62 4.658 9.02 6.987 22.61 6.987 40.77 0 18.1-2.33 31.69-6.987 40.77-4.598 9.02-11.526 13.53-20.783 13.53-9.197 0-16.125-4.51-20.783-13.53-4.6-9.08-6.9-22.67-6.9-40.77 0-18.16 2.3-31.75 6.9-40.77 4.657-9.08 11.585-13.62 20.782-13.62zm115.324 0c9.257 0 16.185 4.54 20.784 13.62 4.657 9.02 6.986 22.61 6.986 40.77 0 18.1-2.33 31.69-6.986 40.77-4.6 9.02-11.527 13.53-20.784 13.53-9.197 0-16.125-4.51-20.783-13.53-4.6-9.08-6.898-22.67-6.898-40.77 0-18.16 2.3-31.75 6.898-40.77 4.658-9.08 11.586-13.62 20.783-13.62zM83.014 187.504c-14.8 0-26.118 5.867-33.96 17.6-7.782 11.673-11.673 28.654-11.673 50.94 0 22.228 3.892 39.208 11.675 50.94 7.84 11.674 19.16 17.512 33.96 17.512 14.797 0 26.09-5.838 33.872-17.512 7.84-11.732 11.76-28.712 11.76-50.94 0-22.286-3.92-39.267-11.76-50.94-7.783-11.733-19.075-17.6-33.873-17.6zm115.324 0c-14.8 0-26.12 5.867-33.96 17.6-7.784 11.673-11.675 28.654-11.675 50.94 0 22.228 3.89 39.208 11.674 50.94 7.84 11.674 19.162 17.512 33.96 17.512 14.8 0 26.09-5.838 33.874-17.512 7.842-11.732 11.763-28.712 11.763-50.94 0-22.286-3.92-39.267-11.762-50.94-7.782-11.733-19.073-17.6-33.872-17.6zm109.223 2.39l-31.574 6.366v16.273l31.75-6.37v100.733h-29.183v15.036h76.056v-15.036h-29.186V189.893H307.56zm115.323 0l-31.572 6.366v16.273l31.75-6.37v100.733h-29.185v15.036h76.057v-15.036h-29.184V189.893h-17.865zm-339.87 11.76c9.257 0 16.185 4.54 20.784 13.62 4.658 9.02 6.986 22.612 6.986 40.77 0 18.1-2.328 31.69-6.986 40.77-4.6 9.02-11.527 13.532-20.783 13.532-9.198 0-16.124-4.51-20.782-13.532-4.598-9.08-6.898-22.67-6.898-40.77 0-18.158 2.3-31.75 6.898-40.77 4.658-9.08 11.584-13.62 20.782-13.62zm115.325 0c9.256 0 16.184 4.54 20.783 13.62 4.66 9.02 6.987 22.612 6.987 40.77 0 18.1-2.328 31.69-6.986 40.77-4.598 9.02-11.526 13.532-20.782 13.532-9.198 0-16.126-4.51-20.783-13.532-4.6-9.08-6.9-22.67-6.9-40.77 0-18.158 2.3-31.75 6.9-40.77 4.657-9.08 11.585-13.62 20.783-13.62zm0 142.823c-14.8 0-26.12 5.866-33.96 17.6-7.784 11.673-11.675 28.652-11.675 50.94 0 22.226 3.89 39.207 11.674 50.94 7.84 11.674 19.162 17.512 33.96 17.512 14.8 0 26.09-5.84 33.874-17.513 7.842-11.733 11.763-28.714 11.763-50.94 0-22.288-3.92-39.267-11.762-50.94-7.782-11.734-19.073-17.6-33.872-17.6zm115.324 0c-14.8 0-26.12 5.866-33.96 17.6-7.783 11.673-11.675 28.652-11.675 50.94 0 22.226 3.892 39.207 11.674 50.94 7.843 11.674 19.163 17.512 33.962 17.512 14.8 0 26.09-5.84 33.87-17.513 7.843-11.733 11.765-28.714 11.765-50.94 0-22.288-3.922-39.267-11.764-50.94-7.782-11.734-19.072-17.6-33.87-17.6zm-236.75 2.388l-31.572 6.367v16.272l31.75-6.367V463.87H47.904V478.9h76.057V463.87H94.778V346.864H76.912zm345.97 0l-31.57 6.367v16.272l31.75-6.367V463.87h-29.187V478.9h76.057V463.87h-29.184V346.864h-17.865zM198.34 358.627c9.256 0 16.184 4.54 20.783 13.62 4.66 9.02 6.987 22.61 6.987 40.77 0 18.1-2.328 31.69-6.986 40.77-4.598 9.02-11.526 13.53-20.782 13.53-9.198 0-16.126-4.51-20.783-13.53-4.6-9.08-6.9-22.67-6.9-40.77 0-18.16 2.3-31.75 6.9-40.77 4.657-9.08 11.585-13.62 20.783-13.62zm115.324 0c9.257 0 16.185 4.54 20.783 13.62 4.658 9.02 6.987 22.61 6.987 40.77 0 18.1-2.33 31.69-6.987 40.77-4.598 9.02-11.526 13.53-20.783 13.53-9.197 0-16.125-4.51-20.783-13.53-4.6-9.08-6.9-22.67-6.9-40.77 0-18.16 2.3-31.75 6.9-40.77 4.657-9.08 11.585-13.62 20.782-13.62z">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h3 itemprop="title" class="post-title font-19 font-weight-bold">
                                            Computing
                                        </h3>
                                        <p itemprop="description" class="font-16 text-gray">Patterns, sequencing and
                                            geometry</p>
                                    </div>
                                </a>
                            </li>
                            <li class="exame-list">
                                <a href="{{url('/')}}/pricing" class="d-flex align-items-center">
                                    <div class="img-holder">
                                        <figure>
                                            <span class="icon-savg">
                                                <svg width="64px" height="64px" viewBox="0 0 32 32" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#7679ee">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g id="icomoon-ignore"> </g>
                                                        <path
                                                            d="M24.589 16c2.617-2.69 3.788-5.307 2.806-6.922-0.391-0.644-1.292-1.411-3.363-1.411-1.136 0-2.463 0.23-3.895 0.654-0.951-3.437-2.536-5.649-4.366-5.649-1.807 0-3.376 2.159-4.331 5.525-1.266-0.345-2.441-0.53-3.461-0.53-2.071 0-2.972 0.767-3.364 1.411-0.787 1.294-0.259 3.226 1.485 5.44 0.389 0.494 0.833 0.99 1.317 1.486-2.615 2.688-3.783 5.304-2.802 6.919 0.391 0.643 1.293 1.411 3.363 1.411 1.020 0 2.196-0.186 3.462-0.53 0.954 3.366 2.523 5.524 4.33 5.524 1.829 0 3.414-2.212 4.366-5.648 1.432 0.424 2.76 0.654 3.896 0.654 2.071 0 2.972-0.767 3.363-1.411 0.981-1.615-0.19-4.234-2.806-6.923zM24.032 8.733c0.869 0 2.001 0.156 2.452 0.899 0.65 1.070-0.329 3.235-2.655 5.622-0.849-0.794-1.816-1.587-2.887-2.354-0.116-1.263-0.3-2.451-0.545-3.539 1.353-0.405 2.598-0.628 3.636-0.628zM18.21 19.627c-0.73 0.444-1.468 0.852-2.204 1.225-0.735-0.373-1.473-0.781-2.203-1.225-0.768-0.467-1.503-0.957-2.201-1.46-0.045-0.699-0.075-1.418-0.075-2.167 0-0.75 0.029-1.47 0.075-2.169 0.683-0.494 1.416-0.982 2.199-1.458 0.73-0.444 1.469-0.852 2.205-1.226 0.736 0.373 1.474 0.782 2.205 1.226 0.602 0.366 1.167 0.741 1.71 1.118 0.061 0.802 0.095 1.638 0.095 2.509s-0.034 1.707-0.095 2.508c-0.543 0.378-1.108 0.753-1.711 1.119zM19.785 19.892c-0.105 0.861-0.245 1.665-0.41 2.416-0.706-0.249-1.432-0.543-2.169-0.877 0.519-0.28 1.039-0.577 1.557-0.892 0.349-0.212 0.689-0.428 1.021-0.647zM14.805 21.43c-0.889 0.404-1.764 0.747-2.604 1.025-0.202-0.889-0.366-1.86-0.482-2.907 0.496 0.338 1.003 0.671 1.529 0.991 0.518 0.315 1.038 0.612 1.557 0.891zM10.486 17.319c-0.546-0.433-1.064-0.874-1.542-1.318 0.47-0.438 0.988-0.88 1.542-1.321-0.016 0.434-0.025 0.874-0.025 1.32s0.009 0.886 0.025 1.319zM11.721 12.446c0.115-1.044 0.279-2.013 0.48-2.9 0.84 0.278 1.714 0.621 2.603 1.025-0.519 0.28-1.040 0.577-1.558 0.892-0.527 0.321-1.036 0.65-1.526 0.984zM17.207 10.57c0.737-0.334 1.463-0.628 2.168-0.877 0.165 0.75 0.305 1.554 0.41 2.415-0.333-0.219-0.672-0.434-1.020-0.646-0.518-0.315-1.039-0.612-1.558-0.892zM21.039 14.304c0.741 0.565 1.423 1.134 2.026 1.696-0.603 0.562-1.285 1.13-2.026 1.696 0.027-0.554 0.043-1.12 0.043-1.696s-0.016-1.141-0.043-1.696zM15.771 3.738c1.215 0 2.51 1.852 3.347 4.91-1.006 0.35-2.052 0.789-3.112 1.306-1.212-0.591-2.404-1.079-3.54-1.45 0.837-2.971 2.11-4.766 3.306-4.766zM5.527 9.632c0.451-0.743 1.583-0.899 2.453-0.899 0.924 0 2.013 0.177 3.195 0.501-0.283 1.228-0.491 2.583-0.607 4.033-0.874 0.653-1.674 1.32-2.389 1.99-0.457-0.468-0.875-0.935-1.241-1.399-1.428-1.812-1.942-3.352-1.411-4.226zM7.979 23.267c-0.87 0-2.001-0.156-2.452-0.899-0.65-1.070 0.328-3.235 2.654-5.622 0.723 0.673 1.525 1.336 2.387 1.979 0.116 1.453 0.324 2.81 0.607 4.040-1.182 0.324-2.271 0.501-3.195 0.501zM15.771 28.262c-1.195 0-2.468-1.795-3.306-4.765 1.136-0.371 2.329-0.859 3.54-1.451 1.060 0.517 2.106 0.956 3.112 1.307-0.836 3.057-2.132 4.909-3.347 4.909zM26.484 22.369c-0.451 0.742-1.582 0.899-2.452 0.899-1.038 0-2.283-0.223-3.636-0.628 0.245-1.089 0.43-2.277 0.546-3.54 1.070-0.768 2.038-1.56 2.887-2.354 2.327 2.388 3.305 4.553 2.655 5.624z"
                                                            fill="#7679ee"> </path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h3 itemprop="title" class="post-title font-19 font-weight-bold">
                                            Science
                                        </h3>
                                        <p itemprop="description" class="font-16 text-gray">Patterns, sequencing and
                                            geometry</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-counter-section pb-10 bg-counter">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title mb-50 text-center">
                        <h2 itemprop="section title" class="mb-10 font-40">Real practice, Proven Results</h2>
                        <p itemprop="description" class="font-19 text-gray">It’s hugely trusted by parents, recommended
                            by teachers and loved by students</p>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="counter-holder row mt-100">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-30 position-relative">
                            <div class="lms-counter-card counter-purple-bg text-white">
                                <strong itemprop="size" class="custom-counter" data-count="100"></strong><span itemprop="plus"
                                    class="plus-icons">+</span>
                                <p itemprop="description" class="font-16 text-white">
                                    11+ practices
                                </p>
                            </div>
                            <div class="svg-shapes-top">
                                <span class="icon-svg">
                                    <img src="/assets/default/svgs/svg-shapes-top.svg" width="64" height="64" alt="shapes-top svg">
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-30">
                            <div class="lms-counter-card counter-yellow-bg text-white">
                                <strong itemprop="size" class="custom-counter" data-count="5000"></strong><span itemprop="plus"
                                    class="plus-icons">+</span>
                                <p itemprop="description" class="font-16 text-white">Questions</p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-30 position-relative">
                            <div class="svg-shapes-bottom">
                                <span class="icon-svg">
                                    <img src="/assets/default/svgs/shapes-bottom.svg" width="64" height="64" alt="shapes-bottom svg">
                                </span>
                            </div>
                            <div class="lms-counter-card counter-orange-bg text-white">
                                <strong itemprop="size" class="custom-counter" data-count="60"></strong><span itemprop="plus"
                                    class="plus-icons">+</span>
                                <p itemprop="description" class="font-16 text-white">
                                    Cities
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>








    <section class="pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mb-50 text-center">
                        <h2 class="mb-10 font-40">Personalized 11 Plus Prep with Rurera</h2>
                        <p class="font-16 text-gray">Empower your child’s learning journey with tailored resources and
                            assessments that meet their unique needs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20" class="mb-20">

                            <img src="../assets/default/img/ks1-year1-feature.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Game-Based Learning</span>
                        </h3>
                        <p itemprop="description">Make study sessions fun with engaging, reward-based activities and
                            instant feedback.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/entrance-exams.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Essential Mock Exams</span>
                        </h3>
                        <p itemprop="description">Boost confidence with realistic 11+ mock exams that simulate actual
                            test conditions.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/sats-home-feature.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Parental Insights</span>
                        </h3>
                        <p itemprop="description">Monitor progress with detailed insights to support your child’s
                            academic success.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/analytics-feature.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Ultimate 11 Plus Practice Toolkit</span>
                        </h3>
                        <p itemprop="description">Encourage continuous improvement with self-assessment tools and
                            progress tracking.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/quick-assesments.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Top-Tier Study Materials</span>
                        </h3>
                        <p itemprop="description">Access all-encompassing resources to thoroughly prepare for every
                            aspect of the 11+ exam.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/feature-automated-marking.jpg" alt="feature image"
                                height="143" width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Smart Exam Tactics</span>
                        </h3>
                        <p itemprop="description">Learn effective tips for time management, stress reduction, and
                            question strategies.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/insights-feature.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Adaptive Curriculum</span>
                        </h3>
                        <p itemprop="description">Use a curriculum that adjusts to each student’s needs for personalised
                            learning.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/book-shelf-feature.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Personalised Practice</span>
                        </h3>
                        <p itemprop="description">Provide practice options that reinforce key concepts and reduce
                            learning anxiety.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">

                            <img src="../assets/default/img/timetables-feature.jpg" alt="feature image" height="143"
                                width="276">

                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <span class="text-dark-charcoal">Elevate 11 Plus Preparation</span>
                        </h3>
                        <p itemprop="description">Achieve exam success with tailored practice and confidence-building
                            resources.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="lms-column-section lms-accordion-section w-100 pb-60 pt-60"
        style="background-color: #f6f0ea; max-width: 100%;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title mb-35 text-center">
                        <h2 itemprop="section title" class="font-40">Why choose Rurera assessments ?</h2>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div itemprop="mainEntity" itemtype="https://schema.org/Question" class="accordion lms-accordion-modern"
                        id="accordion-modern">
                        <div class="card active" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-1">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false"
                                    aria-controls="collapse-1">
                                    <span itemprop="size">#1</span>Adaptive Assessments Testing
                                </button>
                            </div>
                            <div id="collapse-1" class="collapse show" aria-labelledby="heading-1"
                                data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        It helps schools to offer adaptive assessments that adjust the difficulty of
                                        questions as below, emerging, expected, exceeding and challenge which is based
                                        on a student's previous responses, history,
                                        reports and performance providing a more tailored learning experience.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/adpative-assessment.jpg"
                                        alt="company sats" title="company sats" width="100%" height="auto"
                                        itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-2">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false"
                                    aria-controls="collapse-2">
                                    <span itemprop="size">#2</span>Quick Results via automated marking
                                </button>
                            </div>
                            <div id="collapse-2" class="collapse" aria-labelledby="heading-2"
                                data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Real-time marking data allows for quick identification of students who may
                                        require additional support or challenges. Students receive instant personalized
                                        feedback for every question and learning nugget.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-quiz.jpg"
                                        alt="company performance" title="company performance" width="100%" height="auto"
                                        itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-3">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false"
                                    aria-controls="collapse-3">
                                    <span itemprop="size">#3</span>Diverse Question Formats
                                </button>
                            </div>
                            <div id="collapse-3" class="collapse" aria-labelledby="heading-3"
                                data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Online assessments can include a variety of question types, from multiple choice
                                        to audio types offering a more comprehensive evaluation of student knowledge.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/all-in-1-platform.jpg"
                                        alt="company rewards" title="company rewards" width="100%" height="auto"
                                        itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-4">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false"
                                    aria-controls="collapse-4">
                                    <span itemprop="size">#4</span>Timely Reporting
                                </button>
                            </div>
                            <div id="collapse-4" class="collapse" aria-labelledby="heading-4"
                                data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">Online platforms often
                                        provide real-time reporting to both students and teachers, allowing for prompt
                                        interventions and support.</p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-sats.jpg"
                                        alt="company insights" title="company insights" width="100%" height="auto"
                                        itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-5">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-5" aria-expanded="false"
                                    aria-controls="collapse-5">
                                    <span itemprop="size">#5</span>Breakthrough insights at every level
                                </button>
                            </div>
                            <div id="collapse-5" class="collapse" aria-labelledby="heading-5"
                                data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Students and their parents can access a dashboard that displays their live
                                        progress in various subjects. It allows them to identify their strengths and
                                        areas needing improvement. Parents can monitor
                                        completed work, track their child's progress, and view assigned tasks.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-insights.jpg"
                                        alt="company quiz" title="company quiz" width="100%" height="auto"
                                        itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-6">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-6" aria-expanded="true"
                                    aria-controls="collapse-6">
                                    <span itemprop="size">#6</span>Students Engagement
                                </button>
                            </div>
                            <div id="collapse-6" class="collapse" aria-labelledby="heading-6"
                                data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Ignite student’s passion more to join your school. A fantastic learning
                                        experience is possible using interactive challenges, Online Test practices,
                                        Entrance Exams preparations and rewarding them with
                                        trending toys.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-performance.jpg"
                                        alt="company curriculum" width="100%" height="auto" title="company curriculum"
                                        itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                        <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <div class="card-header" id="heading-6">
                                <button itemprop="button" class="btn btn-link btn-block text-left collapsed"
                                    type="button" data-toggle="collapse" data-target="#collapse-7" aria-expanded="true"
                                    aria-controls="collapse-7">
                                    <span itemprop="size">#7</span>Reward points
                                </button>
                            </div>
                            <div id="collapse-7" class="collapse" aria-labelledby="heading-7"
                                data-parent="#accordion-modern">
                                <div class="card-body">
                                    <p itemprop="description" class="font-16 font-weight-normal">
                                        Unlock Knowledge and Reward Yourself with Exciting Toys. It implies through
                                        continuous learning and improvement, students can increase their chances of
                                        winning playful toys. We believe in recognizing and
                                        appreciating your loyalty and engagement.
                                    </p>
                                </div>
                            </div>
                            <div class="lms-img-holder">
                                <figure><img class="w-100" src="../assets/default/img/company-rewards.jpg"
                                        alt="company curriculum" width="100%" height="auto" title="company curriculum"
                                        itemprop="image" loading="eager" /></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center pt-50">
            <a href="{{url('/')}}/pricing" class="btn-primary font-16 text-dark-blue register-btn try-rurera-btn py-15 px-30">Try Rurera for free</a>
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
                                            <button class="btn btn-link font-18 font-weight-bold" data-toggle="collapse"
                                                data-target="#collapsesix" aria-expanded="true"
                                                aria-controls="collapsesix">{{isset( $itemData['title'])? $itemData['title'] : '' }}</button>
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
                                            <button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapsesix" aria-expanded="true"
                                                aria-controls="collapsesix">What is the 11 Plus exam?</button>
                                        </h3>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>The 11+ exam is a selective entrance test used by grammar schools and
                                                some independent schools in the UK to determine which students are
                                                eligible for admission. Taken by students in their final year of primary
                                                school (typically around age 10 or 11), the exam assesses a range of
                                                skills, including English, mathematics, verbal reasoning, and non-verbal
                                                reasoning.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingTwo">
                                        <h3 class="mb-0"><button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">How Will Rurera Help in Preparing for the 11
                                                Plus Exam?</button></h3>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Rurera helps students prepare for the 11+ exam by offering tailored
                                                practice tests, expert-led tutorials, and detailed feedback that covers
                                                all key subjects—English, mathematics, verbal reasoning, and non-verbal
                                                reasoning. The platform provides customizable study plans, tracks
                                                progress, and offers exam strategies to build confidence and reduce
                                                stress.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingseven">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapseseven"
                                                aria-expanded="false" aria-controls="collapseseven"> How do I register
                                                my child for the 11 Plus exam?</button>
                                        </h3>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>To register your child for the 11+ exam, you typically need to apply
                                                directly to the schools you are interested in or through your local
                                                education authority. The registration process usually involves filling
                                                out an application form and, in some cases, paying a registration fee.
                                                Deadlines for registration vary by region and school, so it's important
                                                to begin the process early to ensure your child is registered before the
                                                cutoff date. Some schools may also have online registration systems,
                                                while others may require paper forms to be submitted.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading8">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapse8" aria-expanded="false"
                                                aria-controls="collapse8">What subjects are covered in 11 Plus exam
                                                preparation?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>11+ exam preparation includes English, Maths, and Reasoning (if
                                                applicable), the core subjects assessed in the exams. Our expert tutors
                                                offer thorough guidance and practice to ensure your child is
                                                well-prepared in all three areas.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading9">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapse9" aria-expanded="false"
                                                aria-controls="collapse9"> Do I need to help my child use
                                                Rurera?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p> No, Rurera is designed to be intuitive and easy for children to use on
                                                their own. The platform encourages independent learning, helping your
                                                child build confidence as they navigate and complete their studies
                                                without needing constant assistance.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading10">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapse10" aria-expanded="false"
                                                aria-controls="collapse10"> When are the results of the 11 Plus exam
                                                released?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>The results of the 11+ exam are typically released in late October or
                                                early November, depending on the exam board or school administering the
                                                test. The timing of the results allows parents and students to know
                                                whether they have been offered a place at their chosen school in time to
                                                plan for the next academic year. Each school or local authority will
                                                provide specific details on when and how results will be communicated,
                                                so it’s important to stay informed and check for any updates.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading11">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapse11" aria-expanded="false"
                                                aria-controls="collapse11">When is the 11 Plus exam taken?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse11" class="collapse" aria-labelledby="heading11"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p>The 11+ exam is typically taken in September or October of a student's
                                                final year of primary school, when they are around 10 or 11 years old.
                                                This timing allows schools to use the results to offer places for the
                                                next academic year, beginning the following September. Some areas may
                                                have slightly different testing dates, so it's essential for parents to
                                                confirm the specific dates with their local education authority or the
                                                schools they are applying to.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="heading12">
                                        <h3 class="mb-0">
                                            <button class="btn btn-link font-18 font-weight-bold collapsed"
                                                data-toggle="collapse" data-target="#collapse12" aria-expanded="false"
                                                aria-controls="collapse12">How is the 11 Plus Exam scored?</button>
                                        </h3>
                                    </div>
                                    <div id="collapse12" class="collapse" aria-labelledby="heading12"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <p> Students who sit an Eleven Plus Exam will receive a standardised score
                                                for each paper they sit. Standardised scores are usually between 70 and
                                                140, but again, these can vary across different areas and schools.</p>
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
    <section class="lms-setup-progress-section lms-membership-section mb-0 pt-70 pb-60"
        data-currency_sign="{{getCurrencySign()}}" style="background-color: #fff;">
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
                                <div class="custom-control custom-switch"><input type="checkbox" name="disabled"
                                        class="custom-control-input subscribed_for-field" value="12"
                                        id="iNotAvailable" /><label class="custom-control-label"
                                        for="iNotAvailable"></label></div>
                            </div>
                            <span class="switch-label">Pay Yearly</span>
                        </div>
                        <div class="save-plan"><span class="font-18 font-weight-500">Save 25%</span></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12 mx-auto">
                    <div class="row">

                        @include('web.default.pricing.packages_list',['subscribes' => array(), 'packages_only' =>
                        $packages_only, 'show_details' => false])

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade lms-choose-membership" id="subscriptionModal" tabindex="-1"
        aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
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
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<!-- <script src="/assets/default/js/parts/counter.js"></script> -->

<script>
    var counted = 0;
    $(window).scroll(function() {

    var oTop = $('.counter-holder').offset().top - window.innerHeight;
    if (counted == 0 && $(window).scrollTop() > oTop) {
        $('.custom-counter').each(function() {
        var $this = $(this),
            countTo = $this.attr('data-count');
        $({
            countNum: $this.text()
        }).animate({
            countNum: countTo
            },

            {

            duration: 2000,
            easing: 'swing',
            step: function() {
                $this.text(Math.floor(this.countNum));
            },
            complete: function() {
                $this.text(this.countNum);
                //alert('finished');
            }

            });
        });
        counted = 1;
    }

    });
</script>
@endpush