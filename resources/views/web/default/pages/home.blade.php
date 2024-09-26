@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .home-banner {background-color: #596bfd; min-height: 650px;}
    .home-categories-section {background-color: #f27530;}
    .choose-sats-section {background-color: #7679ee;}
    .reward-program-section {background-color: #fffcee;}
    .lms-newsletter {background-color: #f6b801;}
    .blue-filter {filter: brightness(0) saturate(100%) invert(20%) sepia(28%) saturate(3293%) hue-rotate(225deg) brightness(97%) contrast(96%);}
    .yellow-filter {filter: brightness(0) saturate(100%) invert(82%) sepia(51%) saturate(5470%) hue-rotate(9deg) brightness(108%) contrast(99%);}
    .orange-filter {filter: brightness(0) saturate(100%) invert(46%) sepia(70%) saturate(3496%) hue-rotate(359deg) brightness(96%) contrast(98%);}
    .blue-light-filter {filter: brightness(0) saturate(100%) invert(43%) sepia(68%) saturate(2203%) hue-rotate(219deg) brightness(104%) contrast(87%);}
    #change {
        position: relative;
        white-space: nowrap;
        }
    #change .new {
        position: absolute;
        user-select: none;
        left: 0px;
        bottom: 0.9em;
        opacity: 0;
        }

        #change .old {
        display: inline-block;
        position: relative;
        top: 0px;
        }
</style>
@endpush

@section('content')
<section class="content-section">
    <section class="home-banner slider-hero-section position-relative pt-100 pb-100">
        <div class="container user-select-none">
            <div class="row slider-content align-items-center hero-section2 flex-column-reverse flex-md-row">
                <div class="col-12 col-md-12 col-lg-12 text-center mx-auto">
                    <h1 class="top-text font-72 font-weight-bold text-white">One Stop for Fun Learning</h1>
                    <h1 class="font-50 font-weight-bold text-white"><span id="change"><span class="old">Exam Prep 11 Plus , CAT-4 . ISEB</span></span> </h1>
                    <p class="font-19 pt-15 text-white pb-30">Rurera is a transformative learning platform featuring a subscription model that delivers over 10,000 practice exercises for Key Stage 1 and Key Stage 2, along with resources for Times Tables, Books, SATs, and 11+ exams, empowering success.</p>
                    <div class="choose-sats mt-90">
                        <div class="row">
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/dialogue.webp" height="300" width="300" alt="practice papers">
                                    <span class="mb-10" style="color: #3d358b;">Practice papers</span>
                                    <p>Ace every exam with tailored practice papers for KS1, KS2, SATs, 11 Plus, and more.</p>
                                    <!-- <a href="{{url('/')}}/register">Learn more</a> -->
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/cactus.webp" width="300" height="300" alt="cactus image">
                                    <span class="mb-10" style="color: #f18700;">Interactive questions</span>
                                    <p>Conquer exams with 5,000+ interactive questions designed for success.</p>
                                    <!-- <a href="{{url('/')}}/register">Learn more</a> -->
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-6">
                                <div class="sats-box justify-content: center">
                                    <img src="/store/1/default_images/home_sections_banners/rocket-ship.webp" width="280" height="280" alt="rocket-ship image">
                                    <span class="mb-10" style="color: #7679ee;">Strong Foundation</span>
                                    <p>Build a powerful foundation that shapes every aspect of future success.</p>
                                    <!-- <a href="{{url('/')}}/register">Learn more</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center mt-80">
                        <a href="/pricing" class="try-rurera-btn btn-primary text-dark-blue font-16 register-btn py-15 px-30">Try Rurera for free</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{do_shortcode('redefining_personalized_learning', array('items' => array(2,3,5,6,7,8,9,10,11,15,16,17)))}}
    <section class="choose-sats choose-sats-section pt-80 pb-90 mt-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 class="mt-0 mb-0 text-white font-40">How Rurera Support Enhances Success</h2>
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
    <section class="parent-account-section" style="background-color: #0065ff;">
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
    <section class="home-sections home-sections-swiper container position-relative mt-90">
        <div class="row">
            <div class="col-12">
                <div class="reward-program-section">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6">
                            <div class="position-relative reward-program-section-hero-card"> 
                                <img src="/store/1/default_images/home_sections_banners/club_points_banner.webp" class="reward-program-section-hero" alt="You earned 50 points!" height="390" width="570">
                                <div class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                                    <div class="example-reward-card-medal"> 
                                        <img src="/assets/default/img/rewards/medal.webp" height="100" width="100" class="img-cover rounded-circle" alt="medal"> 
                                    </div>
                                    <div class="flex-grow-1 ml-15"> 
                                        <span class="font-16 font-weight-bold text-secondary d-block">You earned 50 points!</span> 
                                        <span class="font-12 font-weight-500" style="color: #000;">for completing the course...</span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mt-20 mb-40 mt-lg-0 mb-lg-0">
                            <div class="column-text">
                                <h2 class="font-40 text-dark">Unlock Coin Bonuses!</h2>
                                <p class="font-16 mt-10" style="color: #000;">Start practicing now and unlock a world of exciting toys! As you learn and progress, earn coin points that boost your chances of winning amazing rewards. Dive into the fun and collect your coins today!</p>
                                <div class="mt-35 d-flex align-items-center"> 
                                    <a href="{{url('/')}}/rewards" class="btn btn-outline-primary font-16 font-weight-500">Rewards</a> 
                                    <a href="{{url('/')}}/pricing" class="btn btn-outline-primary font-16 font-weight-500 ml-25">Rewards Store</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials-container pt-80 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-0">
                        <h2 class="mt-0 mb-10 font-40">Hear from Those Who Believe in Us!</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="swiper-container testimonials-swiper px-10">
                        <div class="swiper-wrapper mb-50">
                            <div class="swiper-slide">
                                <div class="testimonials-card position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center mt-80">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="testimonials-user-avatar"> 
                                            <img src="/store/923/avatar/testimonial-grid1.webp" alt="James Turner" class="img-cover rounded-circle" height="350" width="350"> 
                                        </div>
                                        <span class="font-20 font-weight-bold text-secondary mt-30 d-block">Natalie Turner</span> <span class="d-block font-16 text-gray"></span>
                                    </div>
                                    <p class="mt-10 font-16">Rurera has been a lifesaver for me in high school. I used to get all F's, but now I have all B's and even a C. My grades have significantly improved, thanks to Rurera.</p>
                                    <div class="bottom-gradient"></div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-card position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center mt-80">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="testimonials-user-avatar"> 
                                            <img src="/store/923/avatar/617a4f9983fe5.webp" alt="James Turner" class="img-cover rounded-circle" height="350" width="350"> 
                                        </div>
                                        <span class="font-20 font-weight-bold text-secondary mt-30 d-block">Liam Reed</span> <span class="d-block font-16 text-gray"></span>
                                    </div>
                                    <p class="mt-10 font-16">Thanks to Rurera, my grades have gone up, and I enjoy practicing with the platform. I used to dislike learning, but now I have a thirst for knowledge and want to learn more.</p>
                                    <div class="bottom-gradient"></div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonials-card position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center mt-80">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="testimonials-user-avatar"> 
                                            <img src="/store/923/avatar/testimonial-grid3.webp" alt="James Turner" class="img-cover rounded-circle" height="350" width="350"> 
                                        </div>
                                        <span class="font-20 font-weight-bold text-secondary mt-30 d-block">Michael Foster</span> <span class="d-block font-16 text-gray"></span>
                                    </div>
                                    <p class="mt-10 font-16">It allows students to work on their own levels and at their own pace. I also love that I can see what they are doing when they are doing it, provide feedback or help in real time.</p>
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
</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script>
    function setupWordChange(timeout, animationTimeout = 300) {
    const container = document.getElementById("change");
    const oldText = container.querySelector(".old");

    const headlines = [
        oldText.innerText,
        "Times table Practice Games",
        "SATs Revision Practice papers",
    ];

    const newText = document.createElement("span");
    newText.setAttribute("aria-hidden", "true");
    newText.className = "new";
    newText.innerText = headlines[1];
    container.insertBefore(newText, container.firstChild);

    const maxMargin = 0.9;

    // The last time the animation was started
    let lastChange = Date.now();
    // The index of the current headline
    let currentHeadline = 0;
    // Whether the DOM needs to be updated after the animation
    let needsUpdate = true;

    const changeFrame = () =>
        window.requestAnimationFrame(() => {
        const delta = Date.now() - lastChange;

        // Less time than the animation duration has passed
        if (delta < animationTimeout) {
            needsUpdate = true;

            // Ratio for where in the animation we are
            const ratio = Math.min(delta / animationTimeout, 1);
            
            // Measure both text boxes
            const targetWidth = newText.scrollWidth;
            const oldWidth = oldText.scrollWidth;
            const difference = targetWidth - oldWidth;

            // Make room for the new text
            const halfWidth = `${(difference * ratio) / 2}px`;
            oldText.style.marginLeft = halfWidth;
            oldText.style.marginRight = halfWidth;

            // Fade the new text in
            oldText.style.opacity = 1 - ratio;
            newText.style.opacity = ratio;

            // Center the new text over the old one
            newText.style.left = `${(difference * (ratio - 1)) / 2}px`;

            // Move the new text in
            newText.style.bottom = `${maxMargin * (1 - ratio)}em`;
            oldText.style.top = `${maxMargin * ratio}em`;

            changeFrame();
            return;
        } else if (needsUpdate) {
            // Update the text
            oldText.innerHTML = headlines[(currentHeadline + 1) % headlines.length];
            newText.innerHTML =
            headlines[(currentHeadline + 2) % headlines.length];
            needsUpdate = false;
        }

        // Reset spacing around word on the line
        oldText.style.marginLeft = "0px";
        oldText.style.marginRight = "0px";

        // Reset opacities
        oldText.style.opacity = 1;
        newText.style.opacity = 0;

        // Update container positions
        oldText.style.top = "0px";
        newText.style.bottom = `${maxMargin}em`;
        newText.style.left = "0px";

        if (delta > timeout) {
            lastChange = Date.now();
            currentHeadline = (currentHeadline + 1) % headlines.length;
        }

        changeFrame();
        });

    setTimeout(() => {
        lastChange = Date.now();
        changeFrame();
    }, timeout);
    }

    // Play the animation
    document.addEventListener("DOMContentLoaded", () => {
    setupWordChange(2000);
    });
</script>
@endpush
