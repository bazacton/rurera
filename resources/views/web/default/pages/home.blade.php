@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .home-banner {background: url(../assets/default/img/home-banner.jpg) 0 0 /cover no-repeat; min-height: 650px;}
    .home-categories-section {background: url(assets/default/svgs/bank-note-white-thin.svg) #f27530;}
    .choose-sats-section {background-color: #7679ee; background-image: linear-gradient(transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px), linear-gradient(90deg, transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px); background-size: 100% 12px, 12px 100%;}
    .reward-program-section {background-color: #dbedff;}
    .lms-newsletter {background: url(../assets/default/svgs/diagonal-lines-white.svg) #f6b801;}
    .blue-filter {filter: brightness(0) saturate(100%) invert(20%) sepia(28%) saturate(3293%) hue-rotate(225deg) brightness(97%) contrast(96%);}
    .yellow-filter {filter: brightness(0) saturate(100%) invert(82%) sepia(51%) saturate(5470%) hue-rotate(9deg) brightness(108%) contrast(99%);}
    .orange-filter {filter: brightness(0) saturate(100%) invert(46%) sepia(70%) saturate(3496%) hue-rotate(359deg) brightness(96%) contrast(98%);}
    .blue-light-filter {filter: brightness(0) saturate(100%) invert(43%) sepia(68%) saturate(2203%) hue-rotate(219deg) brightness(104%) contrast(87%);}
</style>
@endpush

@section('content')
<section class="content-section">
    <section class="home-banner slider-hero-section position-relative pt-100 pb-100">
        <div class="container user-select-none">
            <div class="row slider-content align-items-center hero-section2 flex-column-reverse flex-md-row">
                <div class="col-12 col-md-12 col-lg-10 text-center mx-auto"> 
                    <h1 class="font-50 font-weight-bold text-dark-charcoal">Learn, Practice & Win with <br> <span class="text-scribble">Rurera</span></h1>
                    <p class="font-19 pt-15">Rurera is a game changer subscription based education learning platform. It provides 10000+ practices<br> for Key stage 1 courses, Key stage 2 courses, TimeTables, Books, SATs and 11 plus exams.</p>
                    <div class="choose-sats mt-90">
                        <div class="row">
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/dialogue.png">
                                    <span class="mb-10" style="color: #3d358b;">Practice papers</span>
                                    <p>Available for ks1, ks2, sats, 11 plus and much more.</p>
                                    <a href="https://rurera.chimpstudio.co.uk/register">Learn more</a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/cactus.png">
                                    <span class="mb-10" style="color: #f18700;">Interactive questions</span>
                                    <p>Over 5000+ questions are there to test and pass exam.</p>
                                    <a href="https://rurera.chimpstudio.co.uk/register">Learn more</a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/rocket-ship.png">
                                    <span class="mb-10" style="color: #7679ee;">Strong Foundation</span>
                                    <p>Fostering a strong impact in every aspect of your Child's life.</p>
                                    <a href="https://rurera.chimpstudio.co.uk/register">Learn more</a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
    <section class="py-40 home-categories-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mx-auto rurera-home-categories">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="d-flex align-items-center justify-content-sm-center"> 
                                    <span class="mr-15"> <img src="../assets/default/svgs/exam-full-white.svg" alt="globe svg" title="book svg" width="100%" height="auto" itemprop="image" loading="eager" style="width: 45px; height: 45px;"> 
                                    </span> 
                                    <span class="text-white font-24 font-weight-500 d-inline-flex flex-column line-height-1">5000+ <small class="pt-5 font-16">Quiz practices</small></span> 
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="d-flex align-items-center justify-content-sm-center"> 
                                    <span class="mr-15"> <img src="../assets/default/svgs/book-opend-white.svg" alt="globe svg" title="book svg" width="100%" height="auto" itemprop="image" loading="eager" style="width: 45px; height: 45px;"> </span> 
                                    <span class="text-white font-24 font-weight-500 d-inline-flex flex-column line-height-1">100+ <small class="pt-5 font-16">Books</small></span> 
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="d-flex align-items-center justify-content-sm-center"> 
                                    <span class="mr-15"> <img src="../assets/default/svgs/globe-sm.svg" alt="globe svg" title="globe svg" width="100%" height="auto" itemprop="image" loading="eager" style="width: 45px; height: 45px;"> </span> 
                                    <span class="text-white font-24 font-weight-500 d-inline-flex flex-column line-height-1">60+ <small class="pt-5 font-16">Cities</small></span> 
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="d-flex align-items-center justify-content-sm-center"> 
                                    <span class="mr-15"> <img src="../assets/default/svgs/study-full-white.svg" alt="book svg" title="book svg" width="100%" height="auto" itemprop="image" loading="eager" style="width: 45px; height: 45px;"> </span> 
                                    <span class="text-white font-24 font-weight-500 d-inline-flex flex-column line-height-1">5000+ <small class="pt-5 font-16">Questions</small></span> 
                                </div>
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
                        <h2 class="mb-10">Redefining Personalized learning</h2>
                        <p>Rurera provides powerful resources that align with student's specific interests and learning goals.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20" class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url">
                                <img src="../assets/default/img/ks1-year1-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url" class="text-dark-charcoal">KS1 (Year 1)</a>
                        </h3>
                        <p itemprop="description">Students can take quiz to test their knowledge of Geography, science, history, religious and art.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url">
                                <img src="../assets/default/img/ks1-year2-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url" class="text-dark-charcoal">KS1 (Year 2)</a>
                        </h3>
                        <p itemprop="description">Find out everything required to test science, history, religious education and art subjects.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url">
                                <img src="../assets/default/img/ks1-year3-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url" class="text-dark-charcoal">KS2 (Year 3)</a>
                        </h3>
                        <p itemprop="description">Explore our wide range of resources for Maths, english, science, history, religious and art.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url">
                                <img src="../assets/default/img/ks1-year4-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url" class="text-dark-charcoal">KS2 (Year 4)</a>
                        </h3>
                        <p itemprop="description">Get an awesome chance to test science, history, religious education and art subjects via quizzes.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url">
                                <img src="../assets/default/img/export-x5.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url" class="text-dark-charcoal">KS2 (Year 5)</a>
                        </h3>
                        <p itemprop="description">Explore our wide range of resources for Computing, maths, english, science, history, religious and art.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url">
                                <img src="../assets/default/img/ks1-year6-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/classes?sort=newest" itemprop="url" class="text-dark-charcoal">KS2 (Year 6)</a>
                        </h3>
                        <p itemprop="description">Find out wide range of resources for to Maths, science, history, religious education and art quizzes.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/sats/sats_landing" itemprop="url">
                                <img src="../assets/default/img/sats-home-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/sats/sats_landing" itemprop="url" class="text-dark-charcoal">SATs</a>
                        </h3>
                        <p itemprop="description">It provide opportunity to practice online as per past curriculum exams from past papers.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/11-plus" itemprop="url">
                                <img src="../assets/default/img/11-plus-home-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/11-plus" itemprop="url" class="text-dark-charcoal">11+ Exam</a>
                        </h3>
                        <p itemprop="description">Rurera provide opportunity to practice 11+ exams online as per defined criteria set.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/book-shelf" itemprop="url">
                                <img src="../assets/default/img/book-shelf-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/book-shelf" itemprop="url" class="text-dark-charcoal">Advanced ebook shelf</a>
                        </h3>
                        <p itemprop="description">It offers reading progress, like percentage of the book read or estimated time remaining.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/timestables/landing" itemprop="url">
                                <img src="../assets/default/img/timetables-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/timestables/landing" itemprop="url" class="text-dark-charcoal">Timestables Revision </a>
                        </h3>
                        <p itemprop="description">Offering interactive games specifically designed for learning times tables and division.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/national-curriculum" itemprop="url">
                                <img src="../assets/default/img/national-curriculum.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/national-curriculum" itemprop="url" class="text-dark-charcoal">National Curriculum</a>
                        </h3>
                        <p itemprop="description">It offer national curriculum and a wide range of resources, including books and assessments.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/leaderboard" itemprop="url">
                                <img src="../assets/default/img/leader-board-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/leaderboard" itemprop="url" class="text-dark-charcoal">Leaderboard</a>
                        </h3>
                        <p itemprop="description">Recognizing Outstanding Performance and Achievement where Success Takes Center Stage.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/register" itemprop="url">
                                <img src="../assets/default/img/performance-mintering-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/register" itemprop="url" class="text-dark-charcoal">Performance Monitoring</a>
                        </h3>
                        <p itemprop="description">It provides an easy overview of performance trends who may need additional support or recognition.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/rewards" itemprop="url">
                                <img src="../assets/default/img/rewards-features.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/rewards" itemprop="url" class="text-dark-charcoal">Rewards</a>
                        </h3>
                        <p itemprop="description">Start practicing quizes , SATs, 11+ and read books to earn coins and later redeem to toys.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="https://rurera.chimpstudio.co.uk/membership" itemprop="url">
                                <img src="../assets/default/img/membership-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-19 font-weight-500" itemprop="title">
                            <a target="_blank" href="https://rurera.chimpstudio.co.uk/membership" itemprop="url" class="text-dark-charcoal">Memberships</a>
                        </h3>
                        <p itemprop="description">It offers flexible and easy to use packages options for students, parents and teachers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="choose-sats choose-sats-section pt-80 pb-90 mt-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10 text-white">Discover how Rurera Support success</h2>
                        <p class="text-white">we've combined the best of education, real quiz practices into real results to cater and pass the exams.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 blue-filter" src="../assets/default/svgs/student-user.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-18">National Curriculum</h3>
                        <p class="pt-10">Explore wide range of learning resources available including for Years 1-6 and Functional Skills courses.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 yellow-filter" src="../assets/default/svgs/graphic-design.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-18">Quick assessments</h3>
                        <p class="pt-10">Real-time marking data helps identify students who need extra support or more challenges quickly.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 orange-filter" src="../assets/default/svgs/sav-time.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-18">Real time diagnostics</h3>
                        <p class="pt-10">It helps find students' learning gaps, strengths, and suggests the best study path for faster progress.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 blue-light-filter" src="../assets/default/svgs/support-white.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-18">Get Rewards</h3>
                        <p class="pt-10">Have fun learning with Reward Coins, earn rewards, and make lasting memories with favorite toys.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container reward-program-section position-relative mt-90">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="position-relative reward-program-section-hero-card"> 
                    <img src="/store/1/default_images/home_sections_banners/club_points_banner.png" class="reward-program-section-hero" alt="Win Club Points" height="390" width="570">
                    <div class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                        <div class="example-reward-card-medal"> 
                            <img src="/assets/default/img/rewards/medal.png" height="56" width="56" class="img-cover rounded-circle" alt="medal"> 
                        </div>
                        <div class="flex-grow-1 ml-15"> <span class="font-14 font-weight-bold text-secondary d-block">You earned 50 points!</span> <span class="text-gray font-12 font-weight-500">for completing the course...</span> </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mb-40 mt-lg-0 mb-lg-0">
                <div>
                    <h2 class="font-36 font-weight-bold text-dark">Win Coin Points</h2>
                    <p class="font-16 font-weight-normal text-gray mt-10">Start practicing and Reward Yourself with Exciting Toys. Through learning students can increase their chances of winning playful toys. Start using the system now and collect coins now!</p>
                    <div class="mt-35 d-flex align-items-center"> 
                        <a href="https://rurera.chimpstudio.co.uk/rewards" class="btn btn-primary">Rewards</a> 
                        <a href="https://rurera.chimpstudio.co.uk/products" class="btn btn-outline-primary ml-15">Rewards Store</a> 
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials-container pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-0">
                        <h2 class="mt-0 mb-10">Testimonials</h2>
                        <p>What our customers say about us</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="swiper-container testimonials-swiper px-10">
                        <div class="swiper-wrapper mb-50">
                            <div class="swiper-slide">
                                <div class="testimonials-card position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center mt-80">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="testimonials-user-avatar"> 
                                            <img src="/store/923/avatar/testimonial-grid1.png" alt="James Turner" class="img-cover rounded-circle" height="80" width="80"> 
                                        </div>
                                        <h3 class="font-16 font-weight-bold text-secondary mt-30">Natalie Turner</h3> <span class="d-block font-14 text-gray"></span>
                                    </div>
                                    <p class="mt-10 text-gray font-14">Rurera has been a lifesaver for me in high school. I used to get all F's, but now I have all B's and even a C. My grades have significantly improved, thanks to Rurera.</p>
                                    <div class="bottom-gradient"></div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-card position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center mt-80">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="testimonials-user-avatar"> 
                                            <img src="/store/923/avatar/617a4f9983fe5.png" alt="James Turner" class="img-cover rounded-circle" height="80" width="80"> 
                                        </div>
                                        <h3 class="font-16 font-weight-bold text-secondary mt-30">Liam Reed</h3> <span class="d-block font-14 text-gray"></span>
                                    </div>
                                    <p class="mt-10 text-gray font-14">Thanks to Rurera, my grades have gone up, and I enjoy practicing with the platform. I used to dislike learning, but now I have a thirst for knowledge and want to learn more.</p>
                                    <div class="bottom-gradient"></div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-card position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center mt-80">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="testimonials-user-avatar"> 
                                            <img src="/store/923/avatar/testimonial-grid3.png" alt="James Turner" class="img-cover rounded-circle" height="80" width="80"> 
                                        </div>
                                        <h3 class="font-16 font-weight-bold text-secondary mt-30">Michael Foster</h3> <span class="d-block font-14 text-gray"></span>
                                    </div>
                                    <p class="mt-10 text-gray font-14">It allows students to work on their own levels and at their own pace. I also love that I can see what they are doing when they are doing it, provide feedback or help in real time.</p>
                                    <div class="bottom-gradient"></div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @foreach($homeSections as $homeSection)
    @if($homeSection->name == \App\Models\HomeSection::$blog and !empty($blog) and !$blog->isEmpty())
           <section class="home-sections container">
               <div class="d-flex justify-content-between">
                   <div class="section-title">
                       <h2 class="mt-0 mb-10">{{ trans('home.blog') }}</h2>
                       <p class="section-hint">{{ trans('home.blog_hint') }}</p>
                   </div>
                   <a href="/blog" class="btn btn-border-white">{{ trans('home.all_blog') }}</a>
               </div>
               <div class="row mt-35">
                   @foreach($blog as $post)
                       <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
                           @include('web.default.blog.rurera-grid-list',['post' =>$post])
                       </div>
                   @endforeach

               </div>
           </section>
       @endif
    @endforeach
    <section class="lms-newsletter mt-90 py-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="newsletter-inner">
                        <div class="row">
                            <div class="col-12 col-lg-8 col-md-8">
                                <h2 itemprop="title" class="mb-10 text-white font-40">Kickstart your Exams Prep today!</h2>
                                <p itemprop="description" class="mb-0 text-white"> Let us help you achieve the score you deserve and unlock doors to your future academic success. </p>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4">
                                <div class="form-field position-relative text-right"> <button class="rounded-pill rounded bg-white"> <a href="https://rurera.chimpstudio.co.uk/sats" style="color:var(--gray-dark);">Signup</a> </button> </div>
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
<script src="/assets/default/vendors/parallax/parallax.min.js"></script>
@endpush
