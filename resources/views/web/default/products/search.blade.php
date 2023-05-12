@extends('web.default.layouts.app')

@section('content')
    <section class="site-top-banner products-top-header search-top-banner opacity-04 position-relative">

        <div class="container h-100">
            <div class="row h-100 justify-content-center text-center">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="top-search-categories-form">
                        <h1 class="font-30 mb-15">Browse Rewards</h1>

                        <div class="search-input bg-white flex-grow-1">
                            <form action="{{ (!empty($isRewardProducts) and $isRewardProducts) ? '/reward-products' : '/products' }}" method="get">
                                <div class="form-group d-flex align-items-center m-0">
                                    <span class="search-icon"><i data-feather="search" width="20" height="20" class=""></i></span>
                                    <input type="text" name="search" class="form-control border-0" placeholder="I am looking for...."/>
                                    <button type="submit" class="btn btn-primary">{{ trans('home.find') }}</button>
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
    <script src="/assets/default/js/parts/products_lists.min.js"></script>
@endpush
