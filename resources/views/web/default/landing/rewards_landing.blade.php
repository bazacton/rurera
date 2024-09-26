@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section
    class="products-sub-header page-sub-header position-relative pb-25 pt-80 d-flex align-items-center"
    style="
        background-image: linear-gradient(transparent 11px, rgba(220, 220, 200, 0.1) 12px, transparent 12px), linear-gradient(90deg, transparent 11px, rgba(220, 220, 200, 0.1) 12px, transparent 12px);
        background-size: 100% 12px, 12px 100%;
    "
>
    <div class="container">
        <div class="row align-items-center job-singup-sub-header">
            <div class="col-12 col-md-12 col-lg-6">
                <h1 itemprop="title" class="font-72 font-weight-bold">
                    Learn, Play, and Win <span class="text-scribble">Rewards!</span>
                </h1>
				
                <p class="mt-30">Join our fun learning adventure to master lessons and earn amazing toys and Amazon gift cards!</p>
                <ul class="mb-30 p-0 mt-30">
                        <li class="mb-10 font-19">
                            Master your Lessons
                        </li>
                        <li class="mb-10 font-19">
                            Earn Great Rewards
                        </li>
                        <li class="mb-10 font-19">
                            Celebrate your Success
                        </li>
                        <li class="font-19">
                            Have Fun Learning 
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="https://rurera.com/pricing" class="mt-0 bg-primary justify-content-center register-btn text-white try-rurera-btn">Try Rurera for free</a>
                    </div>
            </div>
            <div class="col-12 col-lg-6 text-right">
                <div class="home-sections home-sections-swiper container reward-program-section position-relative" style="background: 0 0; margin-top: 0;">
                    <div class="position-relative reward-program-section-hero-card">
                        <img
                            src="/store/1/default_images/home_sections_banners/club_points_banner.png"
                            class="reward-program-section-hero"
                            alt="Win Club Points"
                            title="Win Club Points"
                            width="410"
                            height="auto"
                            itemprop="image"
                            loading="eager"
                        />
                        <div class="example-reward-card rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center" style="background-color: #f60;">
                            <div class="example-reward-card-medal">
                                <img src="/assets/default/img/rewards/medal.png" class="img-cover rounded-circle" alt="medal" title="medal" width="100%" height="auto" itemprop="image" loading="eager" />
                            </div>
                            <div class="flex-grow-1 ml-15"><span class="font-14 font-weight-bold text-white d-block">You earned 50 coin points!</span><span class="text-white font-12 font-weight-500">Buy your favoruite toy now!</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="reward-section mt-0 pt-80 pb-70" style="background-color: #3d358b;">
    <div class="reward-shapes pt-70 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 itemprop="title" class="text-white font-40">
                            See What Awaits You with Learning and Practice!
                        </h2>
                    </div>
                </div>
                <div class="col-8 reward-holder mx-auto">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-7 col-lg-9">
                            <div class="reward-box d-flex align-items-center">
                                <div class="img-holder">
                                    <figure>
                                        <svg width="90px" height="90px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M27 6H5C3.34315 6 2 7.34315 2 9V23C2 24.6569 3.34315 26 5 26H27C28.6569 26 30 24.6569 30 23V9C30 7.34315 28.6569 6 27 6Z" fill="#388E3C"></path>
                                                <path
                                                    d="M16 6V26H5C4.20435 26 3.44129 25.6839 2.87868 25.1213C2.31607 24.5587 2 23.7956 2 23V9C2 8.20435 2.31607 7.44129 2.87868 6.87868C3.44129 6.31607 4.20435 6 5 6H16Z"
                                                    fill="#66BB6A"
                                                ></path>
                                                <path
                                                    d="M12 6V20C12 20.2652 11.8946 20.5196 11.7071 20.7071C11.5196 20.8946 11.2652 21 11 21C10.7348 21 10.4804 20.8946 10.2929 20.7071C10.1054 20.5196 10 20.2652 10 20V6H12Z"
                                                    fill="#F5F5F5"
                                                ></path>
                                                <path
                                                    d="M25 13H20C19.7348 13 19.4804 12.8946 19.2929 12.7071C19.1054 12.5196 19 12.2652 19 12C19 11.7348 19.1054 11.4804 19.2929 11.2929C19.4804 11.1054 19.7348 11 20 11H25C25.2652 11 25.5196 11.1054 25.7071 11.2929C25.8946 11.4804 26 11.7348 26 12C26 12.2652 25.8946 12.5196 25.7071 12.7071C25.5196 12.8946 25.2652 13 25 13Z"
                                                    fill="#E0E0E0"
                                                ></path>
                                                <path
                                                    d="M25 17H22C21.7348 17 21.4804 16.8946 21.2929 16.7071C21.1054 16.5196 21 16.2652 21 16C21 15.7348 21.1054 15.4804 21.2929 15.2929C21.4804 15.1054 21.7348 15 22 15H25C25.2652 15 25.5196 15.1054 25.7071 15.2929C25.8946 15.4804 26 15.7348 26 16C26 16.2652 25.8946 16.5196 25.7071 16.7071C25.5196 16.8946 25.2652 17 25 17Z"
                                                    fill="#E0E0E0"
                                                ></path>
                                                <path
                                                    d="M25 21H20C19.7348 21 19.4804 20.8946 19.2929 20.7071C19.1054 20.5196 19 20.2652 19 20C19 19.7348 19.1054 19.4804 19.2929 19.2929C19.4804 19.1054 19.7348 19 20 19H25C25.2652 19 25.5196 19.1054 25.7071 19.2929C25.8946 19.4804 26 19.7348 26 20C26 20.2652 25.8946 20.5196 25.7071 20.7071C25.5196 20.8946 25.2652 21 25 21Z"
                                                    fill="#E0E0E0"
                                                ></path>
                                            </g>
                                        </svg>
                                    </figure>
                                </div>
                                <div class="text-holder"><p itemprop="description">Practice and read to earn coins instantly with Rurera</p></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-3">
                            <div class="reward-box d-flex align-items-center justify-content-center">
                                <div class="text-holder text-center">
                                    <p itemprop="description">Redeem coins with one click!</p>
                                    <strong class="mt-10 font-30 font-weight-bold" itemprop="sub title">One Click!</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-3">
                            <div class="reward-box d-flex align-items-center justify-content-center">
                                <div class="text-holder text-center"><strong itemprop="sub title" class="font-19 font-weight-bold">Trade your coins for toys</strong></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-7 col-lg-9">
                            <div class="reward-box d-flex align-items-center">
                                <div class="img-holder">
                                    <figure>
                                        <svg height="90px" width="90px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path style="fill: #ffd15c;" d="M260.36,240.033c-62.686,0-113.683-50.998-113.683-113.683S197.674,12.665,260.36,12.665 s113.683,50.998,113.683,113.683S323.046,240.033,260.36,240.033z"></path>
                                                <g>
                                                    <path style="fill: #f8b64c;" d="M260.36,12.665v227.367c62.686,0,113.683-50.998,113.683-113.683S323.046,12.665,260.36,12.665z"></path>
                                                    <path style="fill: #f8b64c;" d="M260.36,188.458c-34.246,0-62.108-27.862-62.108-62.108S226.114,64.24,260.36,64.24 s62.107,27.862,62.107,62.108S294.606,188.458,260.36,188.458z"></path>
                                                </g>
                                                <path style="fill: #f59d00;" d="M260.36,64.24v124.217c34.246,0,62.107-27.862,62.107-62.108S294.606,64.24,260.36,64.24z"></path>
                                                <path
                                                    style="fill: #ffd15c;"
                                                    d="M122.565,279.919h169.288c30.772,0,55.529,25.314,54.686,56.229 c-0.457,16.668-8.682,31.568-21.158,41.327h20.25l76.753-64.403c23.574-19.782,58.816-16.3,78.034,7.924 c18.235,22.982,14.531,57.233-8.253,76.349l-100.964,84.714c-9.588,8.044-21.762,12.475-34.277,12.475H202.878 c-12.515,0-24.688-4.43-34.276-12.475l-59.184-49.654c-4.632-3.886-7.307-9.623-7.307-15.67V300.373 C102.11,289.077,111.268,279.919,122.565,279.919z"
                                                ></path>
                                                <g>
                                                    <path
                                                        style="fill: #f8b64c;"
                                                        d="M500.419,320.996c-19.218-24.223-54.461-27.705-78.034-7.924l-76.753,64.403h-20.249 c12.476-9.759,20.701-24.659,21.158-41.327c0.843-30.916-23.915-56.229-54.686-56.229H260.36v214.615h96.564 c12.515,0,24.689-4.431,34.277-12.475l100.964-84.714C514.95,378.229,518.654,343.978,500.419,320.996z"
                                                    ></path>
                                                    <path
                                                        style="fill: #f8b64c;"
                                                        d="M233.301,356.588c0-11.296,9.158-20.454,20.454-20.454h92.784c0,0.005,0,0.009,0,0.014 c-0.451,16.43-8.457,31.132-20.635,40.896h-72.149C242.458,377.044,233.301,367.886,233.301,356.588z"
                                                    ></path>
                                                </g>
                                                <path
                                                    style="fill: #169ed9;"
                                                    d="M20.454,248.022h102.11c11.296,0,20.454,9.158,20.454,20.454v210.405 c0,11.296-9.158,20.454-20.454,20.454H20.454C9.158,499.336,0,490.178,0,478.881V268.476C0,257.18,9.158,248.022,20.454,248.022z"
                                                ></path>
                                                <path style="fill: #f59d00;" d="M260.36,336.134v40.909h65.544c12.178-9.763,20.185-24.466,20.635-40.895c0-0.005,0-0.009,0-0.014 H260.36V336.134z"></path>
                                            </g>
                                        </svg>
                                    </figure>
                                </div>
                                <div class="text-holder"><p itemprop="description">Easily and flexibly use your earned coin points</p></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="reward-box d-flex align-items-center">
                                <div class="img-holder">
                                    <figure>
                                        <svg height="90px" width="90px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        style="fill: #ecf0f1;"
                                                        d="M256,225.627c-4.799,0-8.678-3.888-8.678-8.678V60.746c0-4.79,3.879-8.678,8.678-8.678 s8.678,3.888,8.678,8.678v156.203C264.678,221.739,260.799,225.627,256,225.627"
                                                    ></path>
                                                    <path style="fill: #d1d4d1;" d="M256,69.424c-19.144,0-34.712-15.568-34.712-34.712S236.856,0,256,0s34.712,15.568,34.712,34.712 S275.144,69.424,256,69.424"></path>
                                                    <path
                                                        style="fill: #556080;"
                                                        d="M351.458,512H160.542c-33.549,0-60.746-27.197-60.746-60.746V277.695 c0-33.549,27.197-60.746,60.746-60.746h190.915c33.549,0,60.746,27.197,60.746,60.746v173.559 C412.203,484.803,385.007,512,351.458,512"
                                                    ></path>
                                                    <g>
                                                        <polygon style="fill: #f0c419;" points="186.576,433.898 134.508,399.186 186.576,364.475 "></polygon>
                                                        <polygon style="fill: #f0c419;" points="221.288,433.898 273.356,399.186 221.288,364.475 "></polygon>
                                                        <polygon style="fill: #f0c419;" points="377.492,416.542 342.78,468.61 308.068,416.542 "></polygon>
                                                        <polygon style="fill: #f0c419;" points="377.492,381.831 342.78,329.763 308.068,381.831 "></polygon>
                                                        <path
                                                            style="fill: #f0c419;"
                                                            d="M238.644,312.407H169.22c-14.379,0-26.034-11.655-26.034-26.034s11.655-26.034,26.034-26.034 h69.424c14.379,0,26.034,11.654,26.034,26.034S253.023,312.407,238.644,312.407"
                                                        ></path>
                                                        <path
                                                            style="fill: #f0c419;"
                                                            d="M360.136,295.051h-52.068c-4.799,0-8.678-3.888-8.678-8.678c0-4.79,3.879-8.678,8.678-8.678h52.068 c4.799,0,8.678,3.888,8.678,8.678C368.814,291.163,364.935,295.051,360.136,295.051"
                                                        ></path>
                                                    </g>
                                                    <polygon style="fill: #bf9a22;" points="195.254,312.409 212.61,312.409 212.61,260.342 195.254,260.342 "></polygon>
                                                </g>
                                            </g>
                                        </svg>
                                    </figure>
                                </div>
                                <div class="text-holder ml-5"><p itemprop="description">Read and earn your favorite toys with each win.</p></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="reward-box d-flex align-items-center">
                                <div class="img-holder">
                                    <figure>
                                        <svg
                                            height="80px"
                                            width="90px"
                                            version="1.1"
                                            id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 491.52 491.52"
                                            xml:space="preserve"
                                            fill="#000000"
                                        >
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <polygon style="fill: #2d93ba;" points="234.4,293.665 164.439,445.283 192.544,491.52 275.161,312.474 "></polygon>
                                                <polygon style="fill: #27a2db;" points="193.638,274.857 111.022,453.904 164.439,445.283 234.4,293.665 "></polygon>
                                                <polygon style="fill: #3ea69b;" points="257.12,293.665 327.081,445.283 298.975,491.52 216.359,312.474 "></polygon>
                                                <polygon style="fill: #44c4a1;" points="297.882,274.857 380.498,453.904 327.081,445.283 257.12,293.665 "></polygon>
                                                <path
                                                    style="fill: #e56353;"
                                                    d="M397.161,128.236L397.161,128.236c-10.489-10.488-16.381-24.714-16.381-39.547l0,0 c0-30.888-25.04-55.927-55.927-55.927l0,0c-14.834,0-29.059-5.893-39.547-16.381h-0.001c-21.84-21.841-57.251-21.841-79.093,0l0,0 c-10.489,10.488-24.714,16.381-39.547,16.381l0,0c-30.887,0-55.927,25.039-55.927,55.927l0,0c0,14.832-5.892,29.058-16.381,39.546 v0.001c-21.84,21.841-21.84,57.252,0,79.093v0.001c10.489,10.488,16.381,24.714,16.381,39.546l0,0 c0,30.888,25.04,55.928,55.927,55.928l0,0c14.833,0,29.058,5.892,39.547,16.38v0.001c21.841,21.84,57.252,21.84,79.093,0 l0.001-0.001c10.488-10.488,24.713-16.38,39.547-16.38l0,0c30.887,0,55.927-25.04,55.927-55.928l0,0 c0-14.833,5.892-29.058,16.381-39.547C419.002,185.488,419.002,150.077,397.161,128.236z"
                                                ></path>
                                                <g>
                                                    <path
                                                        style="fill: #ebf0f3;"
                                                        d="M245.757,285.378c-64.835,0-117.587-52.751-117.587-117.595 c0-64.843,52.752-117.595,117.587-117.595c64.843,0,117.595,52.752,117.595,117.595 C363.351,232.627,310.599,285.378,245.757,285.378z M245.757,66.967c-55.586,0-100.809,45.223-100.809,100.816 c0,55.594,45.223,100.817,100.809,100.817c55.593,0,100.816-45.223,100.816-100.817C346.572,112.19,301.35,66.967,245.757,66.967z"
                                                    ></path>
                                                    <path style="fill: #ebf0f3;" d="M219.549,95.671h52.423v144.222h-23.122V117.332h-29.301V95.671z"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </figure>
                                </div>
                                <div class="text-holder ml-5"><p itemprop="description">Track all your rewards and coin points in one place</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="process-section mt-60 reward-process">
    <div class="process-holder">
        <div class="container position-relative">
            <div class="svg-shapes-top">
                <span class="icon-svg">
                    <svg width="64px" height="64px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"><path d="M3.415.189a1 1 0 011.1-.046l15 9a1 1 0 010 1.714l-15 9a1 1 0 01-1.491-1.074L4.754 11H10a1 1 0 100-2H4.753l-1.73-7.783A1 1 0 013.416.189z" fill="#5C5F62"></path></g>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title text-left mb-50">
                        <h2 itemprop="title" class="font-40">Redeem Rewards Like a Pro! 🎉</h2>
                        <h2 class="mt-10">Experience the thrill of victory with every win and feel excitement like never before!</h2>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-9 mx-auto">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="process-card process-one">
                                <div class="process-card-body d-flex align-items-center justify-content-between">
                                    <div class="text-holder mr-30">
                                        <h2 itemprop="title" class="post-title">Step 1:</h2>
                                        <p itemprop="description" class="mt-15">Embark on your journey by conquering quizzes,
                                        goals, mastering times tables, and diving into books.
                                        Start earning valuable coin points along the way!
                                        </p>
                                    </div>
                                    <div class="img-holder">
                                        <figure><img src="../assets/default/img/redeemstep-1.jpg" alt="redeemstep image" title="redeemstep image" width="420" height="auto" itemprop="image" loading="eager" /></figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="process-card process-two">
                                <div class="process-card-body d-flex align-items-center justify-content-between">
                                    <div class="img-holder">
                                        <figure><img src="../assets/default/img/redeemstep-2.jpg" alt="redeemstep image" title="redeemstep image" width="420" height="auto" itemprop="image" loading="eager" /></figure>
                                    </div>
                                    <div class="text-holder ml-30">
                                        <h2 itemprop="title" class="post-title">Step 2:</h2>
                                        <p itemprop="description" class="mt-15">Gather enough coin points through your activities
                                        and get ready for an exciting redemption journey! 
                                        It's time to turn your hard work into amazing rewards!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="process-card process-three">
                                <div class="process-card-body d-flex align-items-center justify-content-between">
                                    <div class="text-holder mr-30">
                                        <h2 itemprop="title" class="post-title">Step 3:</h2>
                                        <p itemprop="description" class="mt-15">Use your hard-earned coin points to choose 
                                        & purchase your favorite toys straight from our store! 
                                        It’s a chance to celebrate your wins with the toys you love!
                                        </p>
                                    </div>
                                    <div class="img-holder">
                                        <figure><img src="../assets/default/img/redeemstep-3.jpg" alt="redeemstep image" title="redeemstep image" width="420" height="auto" itemprop="image" loading="eager" /></figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="process-card process-foure">
                                <div class="process-card-body d-flex align-items-center justify-content-between">
                                    <div class="img-holder">
                                        <figure><img src="../assets/default/img/redeemstep-4.jpg" alt="redeemstep image" title="redeemstep image" width="420" height="auto" itemprop="image" loading="eager" /></figure>
                                    </div>
                                    <div class="text-holder ml-30">
                                        <h2 itemprop="title" class="post-title">Step 4:</h2>
                                        <p itemprop="description" class="mt-15">Dive into rewards with no additional payments
                                        just pure joy as you play with your exciting new toys.
                                        Enjoy the thrill of learning and celebrating your achievements!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="svg-shapes-bottom">
                <span class="icon-svg">
                    <svg width="64px" height="64px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"><path d="M3.415.189a1 1 0 011.1-.046l15 9a1 1 0 010 1.714l-15 9a1 1 0 01-1.491-1.074L4.754 11H10a1 1 0 100-2H4.753l-1.73-7.783A1 1 0 013.416.189z" fill="#5C5F62"></path></g>
                    </svg>
                </span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9 mx-auto">
                <div class="d-flex align-items-center" style="margin-left: 45px;">
                    <a href="{{url('/')}}/pricing" class="try-rurera-btn justify-content-center bg-primary text-white register-btn">Try Rurera for free</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="categories-section mt-90 pt-70 pb-50" style="background-color: #f60;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-50">
                    <h2 itemprop="title" class="text-white font-40">Rewards Categories</h2>
                    <p itemprop="description" class="mt-10 text-white">
                        Earn these amazing rewards as you embark on your learning journey with Rurera! The more you learn, the more you can win!
                    </p>
                </div>
            </div>
            <div class="col-12">
                <ul class="categories-list row">
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/design-tool-1.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="/pricing" class="text-white">Design Tools</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/science-tool.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="/pricing" class="text-white">Science Tools</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/ebook.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="/pricing" class="text-white">e-book</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/music.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="/pricing" class="text-white">Musical Instruments</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/book.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="/pricing" class="text-white">Books</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/toddler.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="/pricing" class="text-white">Baby and Toddler</a></h3>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="lms-faqs-section mb-80 mt-90">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-50">
                    <h2 class="mt-0 mb-10 font-40">Frequently Asked Questions</h2>
                </div>
            </div>
            <div class="col-12 mx-auto">
                <div class="mt-0">
                    <div class="lms-faqs mx-w-100 mt-0">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header active" id="headingon11" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">
                                            What are the ways I can earn coin points on Rurera?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapse11" class="collapse show" aria-labelledby="heading11" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">You can earn coin points by actively participating in various activities on our platform, such as practicing quizzes, completing goals, and reading books. Each activity contributes to your coin points balance based on its difficulty and completion level.</p>
                                    </div>
                                </div>
                            </div>
                            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingon12">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">
                                            Where can I check my current coin points balance?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">To check your coin points balance, log in to your Rurera account and navigate to the Rewards section in your dashboard. Your current balance will be displayed there, along with a history of your recent earning and redemption activities.</p>
                                    </div>
                                </div>
                            </div>
                            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="heading">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            How many coin points are required to redeem specific toys?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="heading" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">The number of coin points needed for each toy varies. You can find detailed information on the point requirements for each toy by visiting the Rewards Store section of our platform, where the points needed for each item are clearly listed.</p>
                                    </div>
                                </div>
                            </div>
                            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingThree">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                             What is the process for redeeming my coin points for toys?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">To redeem your coin points, go to the Rewards Store, select the toy you wish to purchase, and follow the on-screen instructions. You will be prompted to confirm your redemption and your toy will be added to your order. Ensure you have sufficient points before initiating the redemption.</p>
                                    </div>
                                </div>
                            </div>
                            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingfive">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                            Are there any limits on the number of toys I can redeem?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">There may be limits on the number of toys you can redeem depending on availability and your coin points balance. Each toy may also have a limit on how many can be redeemed per account or per month. Please check the Rewards Store for specific details and availability.</p>
                                    </div>
                                </div>
                            </div>
                            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingsix">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                                        Can I use my coin points to receive cash or other non-toy items?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">Coin points are exclusively for redeeming toys and rewards offered in the Rurera Rewards Store. They cannot be converted into cash or used for any non-toy items, ensuring the points are spent on the fun and educational rewards available on the platform.</p>
                                    </div>
                                </div>
                            </div>
							<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingsix">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapsesix">
                                            What should I do if I don’t have enough coin points to redeem a toy?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapse7" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">If you don’t have enough coin points to redeem the toy you want, you will need to continue engaging with quizzes, SATs, and reading to earn more points. Once you have accumulated the required amount, you can return to the Rewards Store to complete your redemption.</p>
                                    </div>
                                </div>
                            </div>
							<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingsix">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapsesix">
                                        Can I transfer my coin points to another Rurera account?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapse8" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">Coin points are linked to your personal account and are not transferable to other accounts. They are exclusively for use within your own account, where you can redeem them for rewards.</p>
                                    </div>
                                </div>
                            </div>
							<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingsix">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapsesix">
                                        How can I get support if I encounter issues with my rewards or redemption?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapse9" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">If you experience any issues with your rewards or redemption, you can contact our support team through the "Contact Us" section on the website or app. Provide detailed information about your issue, and our team will assist you as quickly as possible.</p>
                                    </div>
                                </div>
                            </div>
							<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="card">
                                <div class="card-header" id="headingsix">
                                    <h3 itemprop="name" class="mb-0">
                                        <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapsesix">
                                        What should I do if my toy hasn’t arrived after redemption?
                                        </button>
                                    </h3>
                                </div>
                                <div id="collapse10" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="card-body pb-0">
                                        <p itemprop="text" class="mb-15">If your toy hasn’t arrived within the expected timeframe after redemption, please reach out to our support team with your redemption details. We will investigate the issue and ensure that you receive your toy promptly.</p>
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

	
<section class="footer-banner pt-50 pb-50" style="background: #f6b801;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-7">
                <div class="banner-holder">
                    <div class="text-holder">
                        <h2 itemprop="title" class="text-white font-30">
                            Our rewards bring you excitement,<br >
                             letting you see the results of practice in real time!
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                <div class="banner-holder d-flex justify-content-end">
                    <ul class="education-icon-box">
                        <li>
                            <figure><img src="../assets/default/img/book-education.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                        </li>
                        <li>
                            <figure><img src="../assets/default/img/pencil-ruler.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                        </li>
                        <li>
                            <figure><img src="../assets/default/img/mathematics.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                        </li>
                        <li>
                            <figure><img src="../assets/default/img/book-education-study.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                        </li>
                        <li>
                            <figure><img src="../assets/default/img/coins-money.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                        </li>
                        <li>
                            <figure><img src="../assets/default/img/document-education-file.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/js/parts/counter.js"></script>
@endpush