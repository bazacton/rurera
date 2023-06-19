@extends('web.default.layouts.app')

@section('content')
<section class="products-top-header search-top-banner position-relative job-singup-sub-header gallery-sub-header pb-0"
        style="min-height: 680px;">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 col-md-12 col-lg-4">
                    <h1 class="font-50 font-weight-bold">Rewards</h1>
                    <p>We are a dynamic and innovative company, constantly striving for excellence in everything we do.
                        Joining our team <br> means joining a diverse and inclusive learning environment where collaboration
                        and creativity are valued.</p>
                    <a href="#" class="btn-primary rounded-pill">Find new positions</a>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 gallery-frame-section pl-30">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="gallery-frame">
                                        <figure><img src="../assets/default/img/fram-image-2.jpg" alt="fram images" title="fram images"
                                                width="100%" height="auto" itemprop="image"></figure>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-12">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-3.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-12">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-4.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-5.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-6.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-12">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-1.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-7.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-8.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-12">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-9.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-12">
                                            <div class="gallery-frame">
                                                <figure><img src="../assets/default/img/fram-image-10.jpg" alt="fram images"
                                                        title="fram images" width="100%" height="auto" itemprop="image"></figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="gallery-frame">
                                        <figure><img src="../assets/default/img/fram-image-11.jpg" alt="fram images" title="fram images"
                                                width="100%" height="auto" itemprop="image"></figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12">
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
                </div>
            </div>
        </div>
    </section>

<div class="container mt-30">
    <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
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
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/js/parts/products_lists.min.js"></script>
@endpush
