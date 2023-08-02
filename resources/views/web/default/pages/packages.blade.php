@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">

@endpush

@section('content')

<section class="content-section">

    @if(!empty($subscribes) and !$subscribes->isEmpty())
    <div class="position-relative subscribes-container pe-none user-select-none">
        <div id="parallax4" class="ltr d-none d-md-block">
            <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
        </div>

        <section class="container home-sections home-sections-swiper">
            <div class="text-center">
                <h2 class="section-title">{{ trans('home.subscribe_now') }}</h2>
                <p class="section-hint">{{ trans('home.subscribe_now_hint') }}</p>
            </div>

            <div class="position-relative mt-30">
                <div class="subscribes-block px-12">
                    <div class="row">

                        @foreach($subscribes as $subscribe)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-50 pb-20 px-20">
                                @if($subscribe->is_popular)
                                <span class="badge badge-primary badge-popular px-15 py-5">{{ trans('panel.popular') }}</span>
                                @endif

                                <div class="plan-icon">
                                    <img src="{{ $subscribe->icon }}" class="img-cover" alt="">
                                </div>

                                <h3 class="mt-20 font-30 text-secondary">{{ $subscribe->title }}</h3>
                                <p class="font-weight-500 text-gray mt-10">{{ $subscribe->description }}</p>

                                <div class="d-flex align-items-start text-primary mt-30">
                                    <span class="font-36 line-height-1">{{ addCurrencyToPrice($subscribe->price) }}</span>
                                </div>

                                <ul class="mt-20 plan-feature">
                                    @if($subscribe->is_courses > 0)
                                    <li class="mt-10">Courses</li>
                                    @endif
                                    @if($subscribe->is_timestables > 0)
                                    <li class="mt-10">Timestables</li>
                                    @endif
                                    @if($subscribe->is_bookshelf > 0)
                                    <li class="mt-10">Bookshelf</li>
                                    @endif
                                    @if($subscribe->is_sats > 0)
                                    <li class="mt-10">SATs</li>
                                    @endif
                                    @if($subscribe->is_elevenplus > 0)
                                    <li class="mt-10">11Plus</li>
                                    @endif
                                </ul>

                                @if(auth()->check())
                                <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                                    {{ csrf_field() }}
                                    <input name="amount" value="{{ $subscribe->price }}" type="hidden">
                                    <input name="id" value="{{ $subscribe->id }}" type="hidden">
                                    <button type="submit" class="btn btn-primary btn-block mt-50">{{
                                        trans('financial.purchase') }}
                                    </button>
                                </form>
                                @else
                                <a href="/login" class="btn btn-primary btn-block mt-50">{{
                                    trans('financial.purchase') }}</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </section>

    </div>
    @endif


</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/parallax/parallax.min.js"></script>
@endpush
