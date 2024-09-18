@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
<section class="position-relative job-singup-sub-header gallery-sub-header find-instructor-section pt-80 pb-50 mb-0">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-12 col-md-7 col-lg-7">
                <h1 class="font-50 font-weight-bold" itemprop="title">Experience interactive <br />
                    <span class="text-scribble" itemprop="sub title">Courses</span> learning experience</h1>
                <p class="font-19" itemprop="description">
                Courses available for Maths, English, English Reading, science and computing
                that will surely help you grow and capture innovative ideas.
                </p>
                <div class="d-flex align-items-center">
                    <a href="{{url('/')}}/register" itemprop="url" class="btn-primary rounded-pill">View all courses</a>
                    <a href="{{url('/')}}/register" itemprop="url" class="btn-primary rounded-pill ml-15">Take course</a>
                </div>
                <ul class="pt-30" itemprop="courses list">
                    <li class="mb-10 font-19" itemprop="course short info">
                        <img src="../assets/default/svgs/check-simple.svg" itemprop="check image" class="img-sm mr-10" alt="#" height="18" width="18" />
                        KS1 & KS2 courses available
                    </li>
                    <li class="mb-10 font-19" itemprop="course short info">
                        <img src="../assets/default/svgs/check-simple.svg" itemprop="check image" class="img-sm mr-10" alt="#" height="18" width="18" />
                        Get detailed performance Reports
                    </li>
                    <li class="mb-10 font-19" itemprop="course short info">
                        <img src="../assets/default/svgs/check-simple.svg" itemprop="check image" class="img-sm mr-10" alt="#" height="18" width="18" />
                        Engage and captivate student attention
                    </li>
                    <li class="mb-10 font-19" itemprop="course short info">
                        <img src="../assets/default/svgs/check-simple.svg" itemprop="check image" class="img-sm mr-10" alt="#" height="18" width="18" />
                        Breakthrough insights
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-5 col-lg-5">
                <figure class="position-relative mt-30" style="z-index: 1;">
                    <img src="../assets/default/img/courses-banner-image.png" alt="courses banner image" title="courses" width="470" height="459" itemprop="image" loading="eager">
                    <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle" title="courses" itemprop="circle image" height="170" width="170">
                    <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots" style="bottom: 25px; left: 20px;" itemprop="dots image" height="110" width="70">
                </figure>
            </div>
        </div>
    </div>
</section>
<section class="lms-search-services mb-0 py-50" style="background-color: #f18700;">
    <div class="container">
        <div class="row">
        <div class="col-12 col-lg-12">
                <div class="lms-setup-progress w-100">
                    <ul class="d-flex align-items-center">
                        <li itemprop="member" class="lms-subscription-step d-flex align-items-center"><span itemprop="number" class="step-number d-flex align-items-center">1</span><span itemprop="become" class="step-name">Register / signup</span></li>
                        <li itemprop="member" class="separator"></li>
                        <li class="lms-account-setup d-flex align-items-center"><span itemprop="number" class="step-number d-flex align-items-center" style="border-color:#fff; color: #fff;border-width: 1px;">2</span><span itemprop="account" class="step-name">Choose desired key stage course</span></li>
                        <li itemprop="member" class="separator"></li>
                        <li itemprop="member" class="lms-confirmation-step d-flex align-items-center"><span itemprop="number" class="step-number d-flex align-items-center" style="border-color:#fff; color: #fff;border-width: 1px;">3</span><span itemprop="welcome" class="step-name">Take & Subscribe course</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mt-30">

    <section class="mt-lg-40 pt-lg-20 mt-md-40 pt-md-40">
        <form action="/classes" method="get" id="filtersForm">


            <div class="row mt-20">
                <div class="col-12 col-lg-12">

                    @if(!empty($webinarsData))
                    @foreach( $webinarsData as $parentCategory)
                    @if( !empty( $parentCategory->subCategories))
                    @foreach( $parentCategory->subCategories as $subCategory)
                    <div class="categories-element-title">
                        <h2 class="font-36" itemprop="title"><span>{{$parentCategory->getTitleAttribute()}} - {{$subCategory->getTitleAttribute()}}</span></h2>
                        <p itemprop="description">KS1 courses - Comprehensive list of courses for Children Aged 5, 6 and 7.</p></div>


                    @if( !empty( $subCategory->webinars))
                    <div class="row">
                        @foreach( $subCategory->webinars as $webinar)
                        <div class="col-12 col-lg-2 mt-20">
                            @include('web.default.includes.webinar.grid-card',['webinar' => $webinar])
                        </div>
                        @endforeach
                    </div>
                    @endif


                    @endforeach
                    @endif
                    @endforeach
                    @endif

                </div>
            </div>

        </form>
    </section>
</div>
<section class="mt-60 pt-80 pb-90 find-instructor-section" style="background-color: #3d358b;">
    <div class="container">
       <div class="row">
          <div class="col-12">
            <div class="section-title mb-50">
                <h2 class="mb-10 text-white font-40" itemprop="title">The next-generation e-learning platform</h2>
                <p class="font-19 text-white" itemprop="description">Track progress, manage time effectively,<br> and access detailed answer explanations.</p>
            </div>
          </div>
          <div class="col-12 col-lg-5 col-md-5">
             <figure class="position-relative mb-80">
                <img src="../assets/default/img/courseabout-1.jpg" class="rounded-sm" alt="The next-generation e-learning platform" itemprop="image" height="521" width="470">
                <img src="../assets/default/img/courseabout-2.jpg" class="rounded-sm sub-thumb" alt="sub image" itemprop="image" height="257" width="220">
                <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" itemprop="image" style="right: -70px;" alt="circle" height="170" width="170">
                <img src="/assets/default/img/home/dot.png" itemprop="image" class="find-instructor-section-dots" alt="dots" height="110" width="70">
             </figure>
          </div>
          <div class="col-12 col-lg-7 col-md-7 pl-30">
            <div class="pl-50 ml-50">
                <h3 class="font-24 mb-5 text-white" itemprop="title">KS1 &amp; KS2 courses available</h3>
                <p class="mb-25 text-white font-18" itemprop="description">create courses, or drip feed your content to build and nurture any students you want.</p>
                <h3 class="font-24 mb-5 text-white" itemprop="title">Get detailed performance Reports</h3>
                <p class="mb-25 text-white font-18" itemprop="description">Rurera offers a user-friendly platform where teachers can analyze individual and group performance trends.</p>
                <h3 class="font-24 mb-5 text-white" itemprop="title">Engage and captivate student attention</h3>
                <p class="mb-0 text-white font-18 mb-25" itemprop="description">It helps identify students who may need additional support or recognition.</p>
                <h3 class="font-24 mb-5 text-white" itemprop="title">Learn From Anywhere</h3>
                <p class="mb-0 text-white font-18" itemprop="description">Whether you a student or parent have option to study from home easily.</p>
            </div>
          </div>
       </div>
    </div>
</section>
<section class="pt-80">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-30">
                    <h2 itemprop="title" class="font-40">Frequently asked questions</h2>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-md-12 mx-auto">
            <div class="lms-faqs mx-w-100 mt-0">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingonsix">
                            <button class="btn btn-link font-18 font-weight-bold" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix" itemprop="collapse button">What is the difference between KS1 and KS2?</button>
                        </div>
                        <div id="collapsesix" class="collapse show" aria-labelledby="headingsix" data-parent="#accordion">
                            <div class="card-body">
                                <p class="mb-0" itemprop="description">KS1 stands for Key Stage 1 and covers the first two years of primary school education for children aged 5 to 7 (Year 1 and Year 2). KS2 stands for Key Stage 2 and covers the next four years of primary education for children aged 7 to 11 (Year 3 to Year 6).</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" itemprop="collapse button">What subjects are typically covered in KS1 and KS2 courses?</button>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <p class="mb-0" itemprop="description">In both KS1 and KS2 courses, the core subjects include English, mathematics, and science.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingseven">
                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven" itemprop="collapse button">How are KS1 and KS2 courses taught?</button>
                        </div>
                        <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                            <div class="card-body">
                                <p class="mb-0" itemprop="description">Rurera provides an inclusive and stimulating learning environment that promotes active participation, critical thinking, and independent learning skills.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading8">
                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8" itemprop="collapse button">How long do KS1 and KS2 courses last?</button>
                        </div>
                        <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                            <div class="card-body"></div>
                            <div class="card-body">
                                <p class="mb-0" itemprop="description">KS1 courses cover two school years (Year 1 and Year 2), and KS2 courses cover four school years (Year 3 to Year 6).</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading9">
                            <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9" itemprop="collapse button">Can parents support KS1 and KS2 learning at home?</button>
                        </div>
                        <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                            <div class="card-body">
                                <p class="mb-0" itemprop="description">Yes, parents can support their child's KS1 and KS2 learning at home. They can reinforce concepts taught at school by providing additional practice activities, helping with homework, engaging in discussions, and encouraging reading.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
<section class="lms-column-section lms-text-section mx-w-100 py-70 mt-70" style="background-color: #7679ee;">
    <div class="container">
       <div class="row">
          <div class="col-12">
            <div class="lms-text-holder">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-8 col-md-8">
                        <h2 itemprop="title" class="mb-20 text-white font-40">Ready to start learning?</h2>
                        <p itemprop="description" class="mb-0 text-white">Discover a growing collection of resources
                            delivered through Rurera.</p>
                    </div>
                    <div class="col-12 col-lg-4 col-md-4">
                        <div class="lms-btn-group">
                            <a itemprop="url" href="{{url('/')}}/register" class="lms-btn rounded-pill text-white border-white ml-auto">Join Rurera Today</a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
       </div>
    </div>
 </section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/select2/select2.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

<script src="/assets/default/js/parts/categories.min.js"></script>
@endpush
