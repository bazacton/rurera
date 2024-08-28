@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .time-tables-sub-header {
        background-color: #333399; 
        /* background-image: linear-gradient(transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px), linear-gradient(90deg, transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px); 
        background-size: 100% 12px, 12px 100%; */
    }
    .lms-column-section {
        /* background: radial-gradient(rgba(0, 0, 0, 0.1) 2px, transparent 3px), radial-gradient(rgba(0, 0, 0, 0.1) 2px, transparent 3px), #7679ee; 
        background-position: 0 0, 20px 20px; 
        background-size: 40px 40px; */
        background-color: #7679ee;
    }
</style>
@endpush

@section('content')
<section class="content-section">
    <section class="time-tables-sub-header pt-70 pb-80 text-center">
        <div class="container">
            <div class="row">
                <div class="col-11 mx-auto">
                    <h1 class="font-72 font-weight-bold text-white mb-30">Fun Multiplication and Division techniques to <br /> master <span class="text-scribble">times tables</span></h1>
                    <p class="text-white font-19 mb-20">
                        A brilliant way to learn times tables multiplication and division. With these smart practices, recalling times tables <br />
                        will be an enjoyable journey filled with excitement and rewards.
                    </p>
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="icon-box">
                                <span class="icon-holder" style="background-color: #f6b801;">
                                    <img src="../assets/default/svgs/student-user-white.svg" alt="#" height="30" width="30" />
                                </span>
                                <div class="text-holder">
                                    <h2 class="text-white font-18 font-weight-bold mb-10 d-block">Times tables Treasure Hunt</h2>
                                    <p class="text-white font-16">Transform the process of memorizing times tables into an adventurous treasure hunt.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="icon-box">
                                <span class="icon-holder" style="background-color: #7679ee;">
                                    <img src="../assets/default/svgs/student-user-white.svg" alt="#" height="30" width="30" />
                                </span>
                                <div class="text-holder">
                                    <h2 class="text-white font-18 font-weight-bold mb-10 d-block">Division Tables Problems</h2>
                                    <p class="text-white font-16">Bring division and multiplication magic to life by turning it into a storytelling experience.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="icon-box">
                                <span class="icon-holder" style="background-color: #f35b05;">
                                    <img src="../assets/default/svgs/student-user-white.svg" alt="#" height="30" width="30" />
                                </span>
                                <div class="text-holder">
                                    <h2 class="text-white font-18 font-weight-bold mb-10 d-block">Multiplication tables challenges</h2>
                                    <p class="text-white font-16">Offering interactive challenges specifically designed for earning bonus points.</p>
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
                        <img src="../assets/default/img/time-tables/times-tables.png" height="350" width="390" alt="#" />
                        <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle" width="170" height="170" style="top: -50px; right: 25%;" />
                        <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots" width="70" height="110" style="left: 0; bottom: 0;" />
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-md-6 text-center">
                    <h2 class="d-block font-40 mb-10">Outstanding Maths learning platform</h2>
                    <p class="font-16 text-gray mb-30">
                        Rurera provide awesome and interactive ways for students to learn and memorize times tables while having fun. Immediate feedback helps students identify and correct any mistakes they make while practicing their times
                        tables.
                    </p>
                    <strong class="font-16 text-gray mb-20 d-block">Memorize times tables, Multiply with Ease!</strong>
                    <p class="font-16 text-gray">
                        Personalized approach allows students to focus on specific times tables they find challenging and spend more time practicing those particular facts until they are confidently memorized.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-column-section lms-text-section mx-w-100 py-50 pr-30 pl-30">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="lms-text-holder d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <h3 class="mb-10 font-30 d-flex text-white">
                                <span class="icon-svg mr-15 mt-5">
                                    <img src="../assets/default/svgs/bulb-white.svg" alt="#" height="35" width="35" />
                                </span> Boost Your Child's Multiplication and Division Skills with a Splash of Fun!
                            </h3>
                        </div>
                        <div class="lms-btn-group justify-content-center">
                            <a href="{{url('/')}}/register" class="lms-btn rounded-pill text-white border-white">Find more</a>
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
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10 font-40">How times tables work</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/exam-multiple.svg" alt="#" height="50" width="50" /> <span class="font-18">Register / login</span>
                        <p class="pt-10 font-16 text-dark">Register today via the website and access to learn times tables.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/lessons.svg" alt="#" height="50" width="50" /> <span class="font-18">Create Accounts</span>
                        <p class="pt-10 font-16 text-dark">Easily setup accounts for parents, students and teachers to get benefit from.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/impact.svg" alt="#" height="50" width="50" /> <span class="font-18">Learn &amp; Play</span>
                        <p class="pt-10 font-16 text-dark">Student will have access to both single and multi player games interfaces.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent">
                        <img class="mb-15" src="../assets/default/svgs/sav-time.svg" alt="#" height="50" width="50" /> <span class="font-18">Progress Tracking</span>
                        <p class="pt-10 font-16 text-dark">Use the stats to keep track of your child's progress and celebrate their success.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="choose-sats pt-80">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-6">
                        <div class="sats-box d-inline-flex border-solid border-transparent " style="background: #f6b801;color: #fff;">
                            <h2 class="mt-0 mb-10 font-24">Essential tool for Maths teachers</h2>
                            <p class="pt-0 font-16" style="text-align: left;">Multiplication practices and challenges mean students will be excited to re-call their times tables helping teachers in a various ways :</p><br>

                            <ul style="text-align: left;">
                                <li>- Progress can be monitored on heatmap while student is practicing their times tables.</li>
                                <li>- Track statistics to identify gaps in their knowledge.</li>
                                <li>- It helps to provide targeted support and resources.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6">
                        <div class="sats-box d-inline-flex border-solid border-transparent" style="background: #f35b05;color: #fff;">
                            <h2 class="mt-0 mb-10 font-24">Engaging, trusted and easy to use</h2>
                            <p class="pt-0 font-16" style="text-align: left;">It's a good idea to ensure if multiplication and division practices align with your learning goals and values.</p><br>
                                <ul style="text-align: left;">
                                <li>- Questions and quizzes are easily adapted to each child’s unique learning needs.</li>
                                <li>- Give your child daily practice and get the results.</li>
                                <li>- More practicing give more chances to win rewards and toys.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		{{do_shortcode('redefining_personalized_learning', array('items' => array(1,2,3,4,5,6,7,8,9)))}}
	{{do_shortcode('rurera_assessments')}}
	{{do_shortcode('faqs')}}
	{{do_shortcode('reviews')}}
	{{do_shortcode('packages', array('packages' => array(6,7,9), 'show_details' => false))}}
    <section class="lms-column-section lms-text-section py-70 mx-w-100" style="background-color: #f27530;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="lms-text-holder d-flex flex-column justify-content-center text-center">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-12 col-md-12">
                                <h2 itemprop="title" class="mb-20 text-white font-40">Looking to discover Magic of Multiplication tables?</h2>
                                <p itemprop="description" class="mb-0 text-white font-weight-normal font-24">Practice your times tables now.</p>
                                <div class="lms-btn-group mt-30 justify-content-center">
                                    <a itemprop="url" href="{{url('/')}}/register" class="lms-btn rounded-pill text-white border-white">Join Rurera today</a>
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
