@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .home-banner {background: url(../assets/default/img/home-banner.jpg) 0 0 /cover no-repeat; min-height: 650px;}
    .home-categories-section {background-color: #f27530;}
    .choose-sats-section {background-color: #7679ee;}
    .reward-program-section {background-color: #fffcee;}
    .lms-newsletter {background-color: #f6b801;}
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
                    <h1 class="font-72 font-weight-bold text-dark-charcoal">Learn, Practice & Win with <br> <span class="text-scribble">Rurera</span></h1>
                    <p class="font-19 pt-15 text-gray">Rurera is a game changer subscription based education learning platform. It provides 10000+ practices<br> for Key stage 1 courses, Key stage 2 courses, TimeTables, Books, SATs and 11 plus exams.</p>
                    <div class="choose-sats mt-90">
                        <div class="row">
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/dialogue.png" alt="practice papers">
                                    <span class="mb-10" style="color: #3d358b;">Practice papers</span>
                                    <p>Available for ks1, ks2, sats, 11 plus and much more.</p>
                                    <a href="{{url('/')}}/register">Learn more</a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/cactus.png" alt="questions">
                                    <span class="mb-10" style="color: #f18700;">Interactive questions</span>
                                    <p>Over 5000+ questions are there to test and pass exam.</p>
                                    <a href="{{url('/')}}/register">Learn more</a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/rocket-ship.png" alt="help">
                                    <span class="mb-10" style="color: #7679ee;">Strong Foundation</span>
                                    <p>Fostering a strong impact in every aspect of your Child's life.</p>
                                    <a href="{{url('/')}}/register">Learn more</a>
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
    {{do_shortcode('redefining_personalized_learning', array('items' => array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18)))}}
    <section class="choose-sats choose-sats-section pt-80 pb-90 mt-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-10 text-white font-40">Discover how Rurera Support success</h2>
                        <p class="text-white font-16">we've combined the best of education, real quiz practices into real results to cater and pass the exams.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 blue-filter" src="../assets/default/svgs/student-user.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-20">National Curriculum</h3>
                        <p class="pt-10">Explore wide range of learning resources available including for Years 1-6 and Functional Skills courses.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 yellow-filter" src="../assets/default/svgs/graphic-design.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-20">Quick assessments</h3>
                        <p class="pt-10">Real-time marking data helps identify students who need extra support or more challenges quickly.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 orange-filter" src="../assets/default/svgs/sav-time.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-20">Real time diagnostics</h3>
                        <p class="pt-10">It helps find students' learning gaps, strengths, and suggests the best study path for faster progress.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="sats-box d-inline-flex border-solid border-transparent bg-white">
                        <img class="mb-15 blue-light-filter" src="../assets/default/svgs/support-white.svg" alt="Rurera Support image" height="50" width="50"> 
                        <h3 class="font-20">Get Rewards</h3>
                        <p class="pt-10">Have fun learning with Reward Coins, earn rewards, and make lasting memories with favorite toys.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-sections home-sections-swiper container position-relative mt-90">
        <div class="row">
            <div class="col-12">
                <div class="reward-program-section">
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
                            <div class="column-text">
                                <h2 class="font-40 text-dark">Win Coin Points</h2>
                                <p class="font-16 text-gray mt-10">Start practicing and Reward Yourself with Exciting Toys. Through learning students can increase their chances of winning playful toys. Start using the system now and collect coins now!</p>
                                <div class="mt-35 d-flex align-items-center"> 
                                    <a href="{{url('/')}}/rewards" class="btn btn-primary">Rewards</a> 
                                    <a href="{{url('/')}}/products" class="btn btn-outline-primary ml-15">Rewards Store</a> 
                                </div>
                            </div>
                        </div>
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
                        <h2 class="mt-0 mb-10 font-40">Testimonials</h2>
                        <p class="font-16 text-gray">What our customers say about us</p>
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
                                        <span class="font-20 font-weight-bold text-secondary mt-30 d-block">Natalie Turner</span> <span class="d-block font-14 text-gray"></span>
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
                                        <span class="font-20 font-weight-bold text-secondary mt-30 d-block">Liam Reed</span> <span class="d-block font-14 text-gray"></span>
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
                                        <span class="font-20 font-weight-bold text-secondary mt-30 d-block">Michael Foster</span> <span class="d-block font-14 text-gray"></span>
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
                       <h2 class="mt-0 mb-10 font-40">{{ trans('home.blog') }}</h2>
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
                                <p itemprop="description" class="mb-0 text-white font-16"> Let us help you achieve the score you deserve and unlock doors to your future academic success. </p>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4">
                                <div class="form-field position-relative text-right"> <button class="rounded-pill rounded bg-white"> <a href="{{url('/')}}/register" style="color:var(--gray-dark);">Signup</a> </button> </div>
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
