@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="content-section">
    <section class="time-tables-sub-header pt-70 pb-80 text-center" style="background-color: #333399; background-image: linear-gradient(transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px), linear-gradient(90deg, transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px); background-size: 100% 12px, 12px 100%;">
        <div class="container">
            <div class="row">
                <div class="col-10 mx-auto">
                    <h1 class="font-50 font-weight-bold text-white mb-15">Fun techniques to master <span class="text-scribble">Timestables</span></h1>
                    <p class="text-white mb-20">
                        A brilliant way to learn times tables and division. With these strategies, learning time’s tables and <br />
                        division will be an enjoyable journey filled with excitement and success.
                    </p>
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="icon-box">
                                <span class="icon-holder" style="background-color: #f6b801;"> <img src="../assets/default/svgs/student-user-white.svg" alt="" /> </span>
                                <div class="text-holder">
                                    <strong class="text-white font-18 font-weight-bold mb-10 d-block">Times Tables Treasure Hunt</strong>
                                    <p class="text-white">Transform the process of memorizing times tables into an adventurous treasure hunt.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="icon-box">
                                <span class="icon-holder" style="background-color: #7679ee;"> <img src="../assets/default/svgs/student-user-white.svg" alt="" /> </span>
                                <div class="text-holder">
                                    <strong class="text-white font-18 font-weight-bold mb-10 d-block">Division Story Problems</strong>
                                    <p class="text-white">Bring division and multiplication magic to life by turning it into a storytelling experience.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="icon-box">
                                <span class="icon-holder" style="background-color: #f35b05;"> <img src="../assets/default/svgs/student-user-white.svg" alt="" /> </span>
                                <div class="text-holder">
                                    <strong class="text-white font-18 font-weight-bold mb-10 d-block">Interactive Challenges</strong>
                                    <p class="text-white">Offering interactive challenges specifically designed for earning bonus points.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-search-services find-instructor-section mt-60 pt-80 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 col-md-6">
                    <div class="position-relative">
                        <img src="../assets/default/img/time-tables/times-tables.png" alt="#" />
                        <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle" width="100%" height="auto" style="top: -50px; right: 25%;" />
                        <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots" width="100%" height="auto" style="left: 0; bottom: 0;" />
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-md-6 text-center">
                    <h2 class="font-weight-bold d-block font-36 mb-10">More practice, Better Outcomes</h2>
                    <p class="font-16 font-weight-normal text-gray mb-30">
                        Rurera provide awesome and interactive ways for students to learn and memorize timetables while having fun. Immediate feedback helps students identify and correct any mistakes they make while practicing their times
                        tables.
                    </p>
                    <strong class="font-16 font-weight-normal text-gray mb-20 d-block">Memorize Times Tables, Multiply with Ease!</strong>
                    <p class="font-16 font-weight-normal text-gray">
                        Personalized approach allows students to focus on specific times tables they find challenging and spend more time practicing those particular facts until they are confidently memorized.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-column-section lms-text-section mx-w-100 py-50 pr-30 pl-30" style="background: radial-gradient(rgba(0, 0, 0, 0.1) 2px, transparent 3px), radial-gradient(rgba(0, 0, 0, 0.1) 2px, transparent 3px), #7679ee; background-position: 0 0, 20px 20px; background-size: 40px 40px;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="lms-text-holder d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <h4 class="mb-10 font-30 d-flex text-white">
                                <span class="icon-svg mr-15 mt-5"> <img src="../assets/default/svgs/bulb-white.svg" alt="#" /> </span> Boost Your Child's Multiplication and Division Skills with a Splash of Fun!
                            </h4>
                        </div>
                        <div class="lms-btn-group justify-content-center">
                            <a href="https://rurera.chimpstudio.co.uk/register" class="lms-btn rounded-pill text-white border-white">Find more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="choose-sats pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50"><h2 class="mt-0 mb-10">How it works</h2></div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/exam-multiple.svg" alt="#" /> <span class="font-18">Register / login</span>
                        <p class="pt-10">Register today via the website and access to learn timestables.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/lessons.svg" alt="#" /> <span class="font-18">Create Accounts</span>
                        <p class="pt-10">Easily setup accounts for parents, students and teachers to get benefit from.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/impact.svg" alt="#" /> <span class="font-18">Learn &amp; Play</span>
                        <p class="pt-10">Student will have access to both single and multi player games interfaces.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/sav-time.svg" alt="#" /> <span class="font-18">Progress Tracking</span>
                        <p class="pt-10">Use the stats to keep track of your child's progress and celebrate their success.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-60 pt-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-md-8">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10">Frequently asked questions</h2>
                        <p class="font-19">Asking the right questions is indeed a skill that requires careful consideration.</p>
                    </div>
                    <div class="mt-0">
                        <div class="lms-faqs mx-w-100 mt-0">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" id="headingonsix">
                                        <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">Is there a free version of Rurera?</button></h5>
                                    </div>
                                    <div id="collapsesix" class="collapse show" aria-labelledby="headingsix" data-parent="#accordion"><div class="card-body">Yes, Free and paid both versions are available.</div></div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">How much does membership for student cost ?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion"><div class="card-body">It starts from 100$ per month and extended as per choice.</div></div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingseven">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">Which pricing plan is right for me?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                        <div class="card-body">You can discuss with support and can have learning suggestions based on your skill set.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading8">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">Can i change my membership plan ?</button></h5>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion"><div class="card-body">You can make changes to your plan at any time by changing your plan type.</div></div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading9">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">What payment methods do you accept?</button></h5>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion"><div class="card-body">You can use paypal, skrill and bank transfer method.</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-column-section lms-text-section py-70 mx-w-100" style="background: url(../assets/default/svgs/bank-note-white-thin.svg) #7679ee;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="lms-text-holder d-flex flex-column justify-content-center text-center">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-12 col-md-12">
                                <h2 itemprop="title" class="mb-20 text-white font-40">Get Started</h2>
                                <p itemprop="description" class="mb-0 text-white" style="font-size: 26px;">Want to practice your TimesTables now ?</p>
                                <div class="lms-btn-group mt-30 justify-content-center">
                                    <a itemprop="url" href="https://rurera.chimpstudio.co.uk/register" class="lms-btn rounded-pill text-white border-white">Join Rurera today</a>
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
@endpush
