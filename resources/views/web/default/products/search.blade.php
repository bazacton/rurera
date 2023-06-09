@extends('web.default.layouts.app')

@section('content')
    <section class="products-sub-header products-top-header search-top-banner position-relative">
        <div class="container h-100">
            <div class="row h-100 justify-content-center text-center text-white">
                <div class="col-12 col-md-12 col-lg-12">
                    <h1 class="font-48 mb-15">Browse Rewards</h1>
                </div>
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="top-search-categories-form">
                        <div class="search-input bg-white flex-grow-1">
                            <form action="/products" method="get">
                                <div class="form-group d-flex align-items-center m-0">
                                    <span class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-search">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg></span>
                                    <input type="text" name="search" class="form-control border-0" placeholder="I am looking for....">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="svg-container"></div>
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
    <script src="/assets/default/js/parts/products_lists.min.js"></script>
@endpush
