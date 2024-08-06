@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
@endpush

@section('content')
    <div class="container product-show-special-offer position-relative mt-30">
        @if(!empty($activeSpecialOffer))
            @include('web.default.course.special_offer')
        @endif
    </div>

    <div class="container {{ !empty($activeSpecialOffer) ? 'mt-50' : 'mt-30' }}">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="lazyImage product-show-image-card position-relative">
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}" class="main-s-image img-cover rounded-lg" loading="lazy" width="100%" height="auto" itemprop="image">

                    @if(!empty($product->video_demo))
                        <button id="productDemoVideoBtn"
                                data-video-path="{{ url($product->video_demo) }}"
                                class="product-video-demo-icon cursor-pointer btn-transparent d-flex align-items-center justify-content-center">
                            <img src="/assets/default/img/icons/play-bold.svg" alt="play icon" title="play icon" width="100%" height="auto" itemprop="image" loading="eager" class=""/>
                        </button>
                    @endif
                </div>

                <div class="product-show-thumbnail-card d-flex align-items-center mt-20">
                    <div class="thumbnail-card is-first-thumbnail-card cursor-pointer position-relative">
                        <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}" class="img-cover rounded-sm" loading="lazy" width="100%" height="auto" itemprop="image">

                        @if(!empty($product->video_demo))
                            <span class="product-video-demo-thumb-icon d-flex align-items-center justify-content-center">
                                <img src="/assets/default/img/icons/play-bold.svg" alt="play icon"  title="play icon" width="100%" height="auto" itemprop="image" loading="eager" class=""/>
                            </span>
                        @endif
                    </div>

                    @if(!empty($product->images) and count($product->images))
                        @foreach($product->images as $image)
                            <div class="thumbnail-card cursor-pointer ml-20 ml-lg-35">
                                <img src="{{ $image->path }}" alt="{{ $product->title }}" class="img-cover rounded-sm" loading="lazy" width="100%" height="auto" itemprop="image">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <form action="/cart/store" method="post" id="productAddToCartForm">
                    {{ csrf_field() }}
                    <input type="hidden" name="item_id" value="{{ $product->id }}">
                    <input type="hidden" name="item_name" value="product_id">

                    <div class="product-show-info-card p-15 p-md-25 rounded-lg">
                        <h1 class="font-30">
                            {{ $product->title }}
                        </h1>

                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between mt-20">

                            <div class="d-flex align-items-center mt-15 mt-md-0">
                                <span class="mr-5">{{ trans('update.availability') }}</span>
                                @if(($product->getAvailability() > 0))
                                    @if(!empty($product->inventory) and !empty($product->inventory_warning) and $product->inventory_warning > $product->getAvailability())
                                        <span class="product-availability-badge badge-warning">{{ trans('update.only_n_left',['count' => $product->getAvailability()]) }}</span>
                                    @else
                                        <span class="product-availability-badge badge-primary">{{ trans('update.in_stock') }}</span>
                                    @endif
                                @else
                                    <span class="product-availability-badge badge-danger">{{ trans('update.out_of_stock') }}</span>
                                @endif
                            </div>
                        </div>

                        @if(!empty($selectableSpecifications) and count($selectableSpecifications))
                            @foreach($selectableSpecifications as $selectableSpecification)
                                <div class="product-show-selectable-specification mt-10">
                                    <span class="font-16 font-weight-bold text-dark">{{ $selectableSpecification->specification->title }}</span>

                                    <div class="d-flex align-items-center flex-wrap">
                                        @foreach($selectableSpecification->selectedMultiValues as $specificationValue)
                                            @if(!empty($specificationValue->multiValue))
                                                <div class="selectable-specification-item mr-5 mt-5">
                                                    <input type="radio" name="specifications[{{ $selectableSpecification->specification->createName() }}]" value="{{ $specificationValue->multiValue->createName() }}" id="{{ $specificationValue->multiValue->createName() }}" class="" {{ ($loop->iteration == 1) ? 'checked' : '' }}>
                                                    <label class="font-12 cursor-pointer px-10 py-5" for="{{ $specificationValue->multiValue->createName() }}">{{ $specificationValue->multiValue->title }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif



                        <input type="hidden" id="productAvailabilityCount" value="{{ $product->getAvailability() }}">
                        <input type="hidden" name="quantity" value="1" {{ ($product->getAvailability() < 1) ? 'disabled' : '' }}>
                        <div class="product-show-cart-actions d-flex align-items-center flex-wrap ">

                            <div class="d-flex flex-column flex-md-row align-itemsmd-center w-100 mt-20">


                                @if($product->getAvailability() > 0 and !empty($product->point) and $product->point > 0)
                                    <input type="hidden" class="js-product-points" value="{{ $product->point }}">

                                    <a href="{{ !(auth()->check()) ? '/login' : '#!' }}" class="{{ (auth()->check()) ? 'js-buy-with-point' : '' }} js-buy-with-point-show-btn btn btn-outline-warning mt-10 mt-md-0 ml-0 ml-md-10" rel="nofollow">
                                        {!! trans('update.buy_with_n_points',['points' => $product->point]) !!}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-md-center w-100 mt-35">
                            @if($product->isPhysical() and !empty($product->delivery_estimated_time))
                                <div class="product-show-info-footer-items d-flex align-items-center mb-10 mb-md-0 mr-0 mr-md-10">
                                    <div class="icon-box">
                                        <i data-feather="package" class="" width="20" height="20"></i>
                                    </div>
                                    <div class="ml-5">
                                        <span class="d-block font-16 font-weight-bold text-dark">{{ trans('update.physical_product') }}</span>
                                        <span class="d-block font-12 text-gray">{{ trans('update.delivery_estimated_time_days_alert',['days' => $product->delivery_estimated_time]) }}</span>
                                    </div>
                                </div>
                            @elseif($product->isVirtual())
                                <div class="product-show-info-footer-items d-flex align-items-center mb-10 mb-md-0 mr-0 mr-md-10">
                                    <div class="icon-box">
                                        <i data-feather="package" class="" width="20" height="20"></i>
                                    </div>
                                    <div class="ml-5">
                                        <span class="d-block font-16 font-weight-bold text-dark">{{ trans('update.virtual_product') }}</span>
                                        <span class="d-block font-12 text-gray">{{ trans('update.download_all_files_after_payment') }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="js-share-product product-show-info-footer-items d-flex align-items-center cursor-pointer">
                                <div class="icon-box">
                                    <i data-feather="share-2" class="" width="20" height="20"></i>
                                </div>
                                <div class="ml-5">
                                    <span class="d-block font-16 font-weight-bold text-dark">{{ trans('public.share') }}</span>
                                    <span class="d-block font-12 text-gray">{{ trans('update.product_share_text') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-30">

            <div class="tab-content" id="nav-tabContent">
                @include('web.default.products.includes.tabs.files')
                <br>
                <h3>Description</h3>

                @include('web.default.products.includes.tabs.description')

                @include('web.default.products.includes.tabs.specifications')


                <div class="tab-pane fade {{ (request()->get('tab') == 'description') ? 'show active' : '' }} " id="description" role="tabpanel"
                     aria-labelledby="description-tab">
                    @include('web.default.products.includes.tabs.description')
                </div>

                <div class="tab-pane fade {{ (request()->get('tab') == 'seller') ? 'show active' : '' }} " id="seller" role="tabpanel"
                     aria-labelledby="seller-tab">
                    @include('web.default.products.includes.tabs.seller')
                </div>

                <div class="tab-pane fade {{ (request()->get('tab') == 'specifications') ? 'show active' : '' }} " id="specifications" role="tabpanel"
                     aria-labelledby="specifications-tab">
                    @include('web.default.products.includes.tabs.specifications')
                </div>

                <div class="tab-pane fade {{ (request()->get('tab') == 'files') ? 'show active' : '' }} " id="files" role="tabpanel"
                     aria-labelledby="files-tab">
                    @include('web.default.products.includes.tabs.files')
                </div>

                <div class="tab-pane fade {{ (request()->get('tab') == 'reviews') ? 'show active' : '' }} " id="reviews" role="tabpanel"
                     aria-labelledby="reviews-tab">
                    @include('web.default.products.includes.tabs.reviews')
                </div>
            </div>

        </div>


        {{-- Ads Bannaer --}}
        @if(!empty($advertisingBanners) and count($advertisingBanners))
            <div class="mt-30 mt-md-50">
                <div class="row">
                    @foreach($advertisingBanners as $banner)
                        <div class="col-{{ $banner->size }}">
                            <a href="{{ $banner->link }}">
                                <img src="{{ $banner->image }}" class="img-cover rounded-sm" alt="{{ $banner->title }}" width="100%" height="auto" itemprop="image" loading="eager">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- ./ Ads Bannaer --}}

    </div>

    @include('web.default.products.includes.share_modal')
    @include('web.default.user.send_message_modal',['user' => $seller])
    @include('web.default.products.includes.buy_with_point_modal')
@endsection

@push('scripts_bottom')
    <script>
        feather.replace();
        var replyLang = '{{ trans('panel.reply') }}';
        var closeLang = '{{ trans('public.close') }}';
        var saveLang = '{{ trans('public.save') }}';
        var reportLang = '{{ trans('panel.report') }}';
        var reportSuccessLang = '{{ trans('panel.report_success') }}';
        var reportFailLang = '{{ trans('panel.report_fail') }}';
        var messageToReviewerLang = '{{ trans('public.message_to_reviewer') }}';
        var unFollowLang = '{{ trans('panel.unfollow') }}';
        var followLang = '{{ trans('panel.follow') }}';
        var messageSuccessSentLang = '{{ trans('site.message_success_sent') }}';
        var productDemoLang = '{{ trans('update.product_demo') }}';
        var onlineViewerModalTitleLang = '{{ trans('update.online_viewer') }}';
    </script>

    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/profile.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/product_show.min.js"></script>
@endpush
