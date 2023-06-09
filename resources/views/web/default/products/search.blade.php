@extends('web.default.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="products-top-header lms-call-to-action search-top-banner position-relative pb-0 flex-column pt-70 pb-50" style="background-color: #333399; background-image: linear-gradient(transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px), linear-gradient(90deg, transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px); background-size: 100% 12px, 12px 100%;">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 col-md-10 col-lg-10 mx-0 text-left">
                    <h1 itemprop="title" class="font-50 font-weight-bold text-white">Exchange Rewards <br />Get more <span class="text-scribble">toys</span> with every practice</h1>
                    <p itemprop="description" class="mt-15 mb-40 text-white font-19">Unlock Knowledge and Reward Yourself with Exciting Toys.<br />
Access to the rewards with 3 simple steps</p>
                    <form class="w-75 mx-0 mb-50">
                        <div class="field-holder has-icon d-flex">
                            <span class="search-icon">
                                <img src="../assets/default/svgs/search.svg" alt="default search" title="default search" width="100%" height="auto" loading="eager">
                            </span>
                            <input class="px-45" type="text" placeholder="Search your favorite toys">
                            <button type="submit">Search</button>
                        </div>
                    </form>
                    <div class="banner-holder d-flex justify-content-end">
                        <ul class="education-icon-box">
                            <li>
                                <figure><img src="../assets/default/img/book-education.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </li>
                            <li>
                                <figure><img src="../assets/default/img/pencil-ruler.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </li>
                            <li>
                                <figure><img src="../assets/default/img/mathematics.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </li>
                            <li>
                                <figure><img src="../assets/default/img/book-education-study.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </li>
                            <li>
                                <figure><img src="../assets/default/img/coins-money.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </li>
                            <li>
                                <figure><img src="../assets/default/img/document-education-file.svg" alt="education icon-box" title="education icon-box" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-12">
                    <div class="lms-setup-progress mx-0 pb-lg-40">
                    <ul class="d-flex align-items-center">
                        <li itemprop="member" class="lms-subscription-step d-flex align-items-center">
                            <span itemprop="number" class="step-number d-flex align-items-center">1</span>
                            <span itemprop="become" class="step-name">Learn & Practice</span></li>
                        <li itemprop="member" class="separator"></li>
                        <li class="lms-account-setup d-flex align-items-center">
                            <span itemprop="number" class="step-number d-flex align-items-center">2</span>
                            <span itemprop="account" class="step-name">Earn Coin Points</span>
                        </li>
                        <li itemprop="member" class="separator"></li>
                        <li itemprop="member" class="lms-confirmation-step d-flex align-items-center">
                            <span itemprop="number" class="step-number d-flex align-items-center">3</span>
                            <span itemprop="welcome" class="step-name">Exchange Coins to buy toys</span>
                        </li>
                    </ul>
                    </div>
                </div>
                <!-- <div class="col-12 col-md-12 col-lg-12">
                    <div class="top-search-categories-form">
                        <div class="search-input bg-white flex-grow-1">
                            <form action="/products" method="get">
                                <div class="form-group d-flex align-items-center m-0">
                                    <span class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg></span>
                                    <input type="text" name="search" class="form-control border-0"
                                        placeholder="I am looking for....">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <section class="categories-section pt-80 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                    <h2 itemprop="title">Explore Categories</h2>
                    <p itemprop="description" class="mt-10">It implies through continuous learning and improvement, students can increase<br>their chances of winning playful toys.</p>
                    </div>
                </div>
                <div class="col-12">
                    <ul class="categories-list row">
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/design-tool-1.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="#.">Design Tools</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/science-tool.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="#.">Science Tools</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/ebook.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="#.">e-book</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/music.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="#.">Musical Instruments</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/ebook.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="#.">Books</a></h3>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-box mb-30">
                            <div class="img-holder">
                                <figure><img src="../assets/default/img/toddler.png" alt="category image" title="category image" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                            </div>
                            <div class="text-holder">
                                <h3 itemprop="title" class="post-title text-white"><a href="#.">Baby and Toddler</a></h3>
                            </div>
                        </div>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <section class="pt-lg-20 pt-md-40">
            <form action="{{ (!empty($isRewardProducts) and $isRewardProducts) ? '/reward-products' : '/products' }}" method="get" id="filtersForm">

                @include('web.default.products.includes.top_filters')

                <div class="row">
                    <div class="col-12 col-md-9">
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-12 col-md-6 col-lg-4 mt-20">
                                @include('web.default.products.includes.card')
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-50 pt-30">
                            {{ $products->appends(request()->input())->links('vendor.pagination.panel') }}
                        </div>
                    </div>


                    <div class="col-12 col-md-3">
                        @include('web.default.products.includes.right_filters')
                    </div>
                </div>

            </form>


        </section>
    </div>
    <section class="lms-newsletter py-70 mt-80" style="background:url(assets/default/svgs/bank-note-white.svg) #f6b801;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="newsletter-inner">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6 mb-20">
                                <h2 itemprop="title" class="mb-10 text-white font-40">Subscribe our
                                    newsletter</h2>
                                <p itemprop="description" class="mb-0 text-white">Discover a growing collection of ready-made training courses
                                    delivered through Rurera, and gear up your people for success at work</p>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6"><label class="mb-10 text-white">Your E-mail Address</label>
                                <div class="form-field position-relative"><input type="text" placeholder="Enter Your E-mail"><button type="submit">Subscribe</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/js/parts/products_lists.min.js"></script>
<script>
  feather.replace()
</script>
@endpush
