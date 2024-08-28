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
		
		
		
		
<section class="pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mb-50 text-center">
                        <h2 class="mb-10 font-40">Redefining Personalized learning</h2>
                        <p class="font-16 text-gray">Rurera provides powerful resources that align with student's specific interests and learning goals.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20" class="mb-20">
                            <a href="{{url('/')}}/classes" itemprop="url">
                                <img src="../assets/default/img/ks1-year1-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/classes" itemprop="url" class="text-dark-charcoal">KS1, KS2 Courses</a>
                        </h3>
                        <p itemprop="description">Explore wide range of kS1, KS2 courses, Tests, practices, assessments, resources and much more.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/11-plus" itemprop="url">
                                <img src="../assets/default/img/entrance-exams.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/11-plus" itemprop="url" class="text-dark-charcoal">Entrance Examination Preps</a>
                        </h3>
                        <p itemprop="description">Rurera offers a chance to prepare for 11+ Exam, Independent Exams, ISEB and CAT4.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/sats-preparation" itemprop="url">
                                <img src="../assets/default/img/sats-home-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/sats-preparation" itemprop="url" class="text-dark-charcoal">SATs Exam Preps</a>
                        </h3>
                        <p itemprop="description">We are providing opportunity to practice SATs exam, SATs papers, SATs assessments SATs tests online.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/analytics" itemprop="url">
                                <img src="../assets/default/img/analytics-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/panel/analytics" itemprop="url" class="text-dark-charcoal">Analytics</a>
                        </h3>
                        <p itemprop="description">It provides complete insights and data analysis of Total scores, Total attempts, Earned Scores and Earned Coins.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/quick-assesments.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Quick Assessments</a>
                        </h3>
                        <p itemprop="description">It offers quick assessments and answers to questions are automatically assessed for personalized feedback.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/feature-automated-marking.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Automated Marking</a>
                        </h3>
                        <p itemprop="description">Automated marking data allows for quick identification of students who may require additional support or challenges.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/insights-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Breakthrough insights</a>
                        </h3>
                        <p itemprop="description">It significantly allows to identify student’s learning strengths and areas needing improvement.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/book-shelf" itemprop="url">
                                <img src="../assets/default/img/book-shelf-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/book-shelf" itemprop="url" class="text-dark-charcoal">Children Books Online</a>
                        </h3>
                        <p itemprop="description">Discover vast collection of children books and track reading progress and activity, like percentage and time.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/timestables-practice" itemprop="url">
                                <img src="../assets/default/img/timetables-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/timestables-practice" itemprop="url" class="text-dark-charcoal">TimeTables Revision</a>
                        </h3>
                        <p itemprop="description">Offering interactive Multiplication and division Practices and challenges to Master TimesTables online.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/national-curriculum" itemprop="url">
                                <img src="../assets/default/img/national-curriculum.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/national-curriculum" itemprop="url" class="text-dark-charcoal">National Curriculum</a>
                        </h3>
                        <p itemprop="description">If offer Skill plans, Courses Topics and Test preparations as per defined curricula.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/performance-monitering.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Performance Monitoring</a>
                        </h3>
                        <p itemprop="description">It provides an easy overview of performance trends who may need additional support or recognition.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/progress-tracking.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Progress Tracking</a>
                        </h3>
                        <p itemprop="description">Rurera offers a user-friendly platform where teachers can analyze individual and group performance trends.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/weekly-planner" itemprop="url">
                                <img src="../assets/default/img/skill-plans-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/weekly-planner" itemprop="url" class="text-dark-charcoal">Skills Plan</a>
                        </h3>
                        <p itemprop="description">This involves setting goals, identifying the skills you want to acquire or improve, and planning to achieve those goals weekly or monthly.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/classes?sort=newest" itemprop="url">
                                <img src="../assets/default/img/advance-learning-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/classes?sort=newest" itemprop="url" class="text-dark-charcoal">Advance Learning</a>
                        </h3>
                        <p itemprop="description">Rurera empowers students through courses, interactive books, exams practices and rewarding experiences.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/features" itemprop="url">
                                <img src="../assets/default/img/teacher-empowerment-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/features" itemprop="url" class="text-dark-charcoal">Teacher Empowerment Tools</a>
                        </h3>
                        <p itemprop="description">Immediate feedback and assessment tools allow teachers to monitor student progress and identify areas that require improvement.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/contact-us" itemprop="url">
                                <img src="../assets/default/img/protection-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/contact-us" itemprop="url" class="text-dark-charcoal">Security and Privacy</a>
                        </h3>
                        <p itemprop="description">Rurera protect student data, maintain trust and comply with data protection and privacy regulations.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/rewards-features.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Win Rewards</a>
                        </h3>
                        <p itemprop="description">Avail an awesome opportunity to Earn Rewards, Coin points, Win and later redeem to toys.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/products" itemprop="url">
                                <img src="../assets/default/img/rewards-store-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/products" itemprop="url" class="text-dark-charcoal">Rewards Store</a>
                        </h3>
                        <p itemprop="description">Students can redeem coin points and exchange trending toys with every practice via Rurera toy store.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	
	<section class="lms-column-section lms-accordion-section w-100 pb-60 pt-60" style="background-color: #f6f0ea; max-width: 100%;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-title mb-35 text-center"><h2 itemprop="section title" class="font-40">Why choose Rurera assessments ?</h2></div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div itemscope="" itemtype="https://schema.org/accordion" class="accordion lms-accordion-modern" id="accordion-modern">
                    <div class="card active">
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
                    <div class="card">
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
                    <div class="card">
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
                    <div class="card">
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
                    <div class="card">
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
                    <div class="card">
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
                    <div class="card">
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
</section>

	@php $faq_items =  isset( $faq_items )? $faq_items : array();@endphp
<section class="py-70" style="background-color: #fff">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title text-center mb-30">
					<h2 class="mt-0 mb-10 font-40">Frequently asked questions</h2>
				</div>
			</div>
			<div class="col-12 col-lg-12 col-md-12 mx-auto">
				<div class="mt-0">
					<div class="lms-faqs mx-w-100 mt-0">
						<div id="accordion">
							@if( !empty( $faq_items ))
								
								@foreach( $faq_items as $itemData)
									<div class="card">
										<div class="card-header" id="headingonsix">
											<h3 class="mb-0">
												<button class="btn btn-link font-18 font-weight-bold" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">{{isset( $itemData['title'])? $itemData['title'] : '' }}</button>
											</h3>
										</div>
										<div id="collapsesix" class="collapse" aria-labelledby="headingsix"
											data-parent="#accordion">
											<div class="card-body"><p>{{isset( $itemData['description'])? $itemData['description'] : '' }}</p></div>
										</div>
									</div>
								@endforeach
							
								@else 
								<div class="card">
									<div class="card-header" id="headingonsix">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">What is the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapsesix" class="collapse" aria-labelledby="headingsix"
										data-parent="#accordion">
										<div class="card-body"><p>The 11 Plus exam is a selective entrance examination taken by students around the age of 10 or 11 in uk.
										It assesses students' aptitude in key subjects to determine their suitability for admission to selective
										secondary schools or grammar schools</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingTwo">
										<h3 class="mb-0"><button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse"
												data-target="#collapseTwo" aria-expanded="false"
												aria-controls="collapseTwo">What subjects are covered in the 11 Plus exam?</button></h3>
									</div>
									<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
										data-parent="#accordion">
										<div class="card-body"><p>The 11 Plus exam typically includes English comprehension, grammar, vocabulary, creative writing,
										mathematics, and reasoning skills.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingseven">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">How do I prepare my child for the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
										<div class="card-body"><p>Preparation for the 11 Plus exam usually involves a combination of practice materials, and
										familiarization with the exam format. Solving past papers, improving time management skills, and
										receiving targeted coaching are common preparation methods</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading8">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">When should my child start preparing for the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
										<div class="card-body"><p>The ideal preparation time for the 11 Plus exam varies depending on the child and their academic
										progress.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading9">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">Are there different types of 11 Plus exams?</button>
										</h3>
									</div>
									<div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
										<div class="card-body"><p>Yes, there are different types of 11 Plus exams conducted by various exam boards or organizations. The
										content, format, and style of questions may vary between regions and schools. It's important to
										research and understand the specific requirements of the schools your child is interested in.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading10">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">Can my child retake the 11 Plus exam if they don't pass?</button>
										</h3>
									</div>
									<div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
										<div class="card-body"><p>The policies regarding retaking the 11 Plus exam vary depending on the region and school. Some schools
										allow students to retake the exam, while others do not. It is advisable to check with the individual
										schools or local education authorities for their specific retake policies.</p></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="heading11">
										<h3 class="mb-0">
											<button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">What happens if my child passes the 11 Plus exam?</button>
										</h3>
									</div>
									<div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
										<div class="card-body"><p>If your child passes the 11 Plus exam, they may be eligible for admission to selective secondary schools
										or grammar schools. However, admission is not solely based on exam results and may also consider
										other factors such as school capacity and distance from your home</p></div>
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
	<section class="marquee-sec py-70" style="background-color: #fbfbfb;">
    <div class="section-title text-center mb-50">
        <h2 class="mb-10 font-40">They<span class="text-primary">love</span>Able Pro, Now your turn ðŸ˜</h2>
        <div class="reviews-holder mt-15">
            <span class="reviews-lable">
                <span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span>Trustpilot
            </span>
            <span class="reviews-star d-block">
                <span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span><span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span>
                <span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span><span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span>
                <span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span>
            </span>
            <div class="reviews-info">
                <span class="reviews-score">Trustscore<em>4.8</em></span><a href="#" class="reviews-number"><em>322</em>Trustscore</a>
            </div>
        </div>
    </div>
    <div class="marquee-list marquee-inner-wrapper">
        <div class="marquee-list-holder marquee__inner_animation marquee-right-to-left mb-20">
            <ul>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œAmazing template for fast develop.ðŸ’Žâ€œ</span><span class="author-name">devbar -<span>Customizability</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œCode quality is amazing. Design is astonishing. very easy to customize..ðŸ˜â€œ</span><span class="author-name">shahabblouch -<span>Code Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œThis has been one of my favorite admin dashboards to use. ðŸ˜â€œ</span><span class="author-name">htmhell -<span>Design Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œExcellent support, if we need any modification, they are doing immediatelyâ€œ</span><span class="author-name">hemchandkodali -<span>Customer Support</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œFor developers like me, this is the total package! ðŸ˜ â€œ</span><span class="author-name">sumaranjum -<span>Feature Availability</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œI love the looks of Able Pro 7.0. I really like the colors you guys have chosen for this theme. It looks really nice.. ðŸ’Žâ€œ</span>
                                        <span class="author-name">ritelogic -<span>Other</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œThe author is very nice and solved my problem inmediately ðŸ˜ â€œ</span><span class="author-name">richitela -<span>Customer Support</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œVery universal admin templateâ€œ</span><span class="author-name">Genstiade -<span>Feature Availability</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œI have it running on a medium size site that is geared towards. My customers love the design and speed in which pages load.â€œ</span>
                                        <span class="author-name">RizzoFrank -<span>Design Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œAn amazing template. Very good design, good quality code and also very good customer support. ðŸ’Žâ€œ</span>
                                        <span class="author-name">hemchandkodali -<span>Customer Support</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="marquee-list marquee-inner-wrapper-v2">
        <div class="marquee-list-holder marquee__inner_animation marquee-left-to-right">
            <ul>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œPerfect for my need. Elegant look n feel with blazing fast code. ðŸ’Žâ€œ</span><span class="author-name">ThemeShakers -<span>Feature Availability</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œExcellent template! It's also very well organized and easy to find our way..â€œ</span><span class="author-name">Danlec -<span>Code Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œTheir Team is great and working great always. when you need help...â€œ</span><span class="author-name">manojkumarhr -<span>Customer Support</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œWonderful theme, full of features, with ton of addons.â€œ</span><span class="author-name">momennoor -<span>Design Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œAn excellent theme. It contains everything you need to open complex projects. ðŸ˜ â€œ</span><span class="author-name">Vihtora -<span>Other</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œExcellent template. Very complete. ðŸ’Žâ€œ</span><span class="author-name">mundodascasas -<span>Code Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œIt serves my all purposes well and one thing it was great because i didn't require designer at all.â€œ</span>
                                        <span class="author-name">amit1134 -<span>Code Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œI highly recommend Able pro admin template and team phoenixcoded item. It was best purchase on themeforest for me.â€œ</span>
                                        <span class="author-name">vishalmg -<span>Flexibility</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œ5 stars are for the excellent support, that is brilliant! The design is very cool and...!â€œ</span><span class="author-name">ab69aho -<span>Code Quality</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="marquee-card">
                        <div class="card-body">
                            <div class="card-content">
                                <a href="#">
                                    <span class="card-media"><img src="/avatar/svgA16395287444009177.png" alt="" /></span>
                                    <span class="card-text">
                                        <span class="car-discription">â€œAn amazing template. Very good design, good quality code and also very good customer support. ðŸ’Žâ€œ</span>
                                        <span class="author-name">hemchandkodali -<span>Customer Support</span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

	@php
$packages_only = isset( $packages )? $packages : array();
$show_details = isset( $show_details )? $show_details : true;
@endphp
<section class="lms-setup-progress-section lms-membership-section mb-0 pt-70 pb-60"  data-currency_sign="{{getCurrencySign()}}" style="background-color: #fff;">
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

					@include('web.default.pricing.packages_list',['subscribes' => array(), 'packages_only' => $packages_only, 'show_details' => $show_details])

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
