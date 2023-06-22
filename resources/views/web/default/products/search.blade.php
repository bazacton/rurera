@extends('web.default.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="products-top-header search-top-banner position-relative pb-0 flex-column pt-70">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 col-md-6 col-lg-6 mx-auto text-center">
                    <h1 itemprop="title" class="font-50 font-weight-bold">Learn, Practice and Win with Rurera</h1>
                    <p itemprop="description" class="mt-10">Unlock Knowledge and Reward Yourself with Exciting Toys. It implies through continuous learning and improvement, students can increase their chances of winning playful toys.</p>
                    <a href="#" class="btn btn-outline-primary rounded-pill mt-25">Find new positions</a>
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
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/js/parts/products_lists.min.js"></script>
@endpush
