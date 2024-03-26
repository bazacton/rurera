<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">

@include('web.default.subscriptions.steps',['activeStep'=> 'packages'])
<section class="lms-setup-progress-section mb-0 pt-70 pb-60">
        <div class="container">
            <form class="package-register-form" method="post" action="javascript:;">
                      {{ csrf_field() }}
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="element-title text-center mb-40">
                        <h2 itemprop="title" class="font-40 text-dark-charcoal mb-0">Choose the right plan for {{isset($childObj->id)? $childObj->full_name : 'You'}}</h2>
                        <p class="font-16">Choose a plan that's right for you.</p>
                    </div>
                </div>

                @php
                    $is_checked = (isset($childObj->userSubscriptions->subscribe_for) && $childObj->userSubscriptions->subscribe_for == 12)? 'checked' : '';
                @endphp
                <div class="col-12 col-lg-12">
                    <div class="plan-switch-holder">
                        <div class="plan-switch-option">
                            <span class="switch-label font-18">Pay Monthly</span>
                            <div class="plan-switch">
                                <div class="custom-control custom-switch"><input type="checkbox" {{$is_checked}} name="subscribed_for" class="custom-control-input subscribed_for-field" id="subscribed_for" value="12"/><label class="custom-control-label" for="subscribed_for"></label></div>
                            </div>
                            <span class="switch-label">Pay Yearly</span>
                        </div>
                        <div class="save-plan"><span class="font-18 font-weight-500">Save 25%</span></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12 mx-auto">
                    <div class="row">
                        @if(!empty($subscribes) and !$subscribes->isEmpty())
                            @foreach($subscribes as $subscribe)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="subscribe-plan {{($selected_package == $subscribe->id)? 'active' : ''}} current-plan position-relative d-flex flex-column rounded-lg p-25 mb-30">
                                        <span class="subscribe-icon mb-20"><img src="{{ $subscribe->icon }}" height="auto" width="auto" alt="Box image" /></span>
                                        <div class="subscribe-title">
                                            <h3 itemprop="title" class="font-24 font-weight-500">{{ $subscribe->title }}</h3>
                                            <span>{{ $subscribe->description }}</span>
                                        </div>
                                        <div class="d-flex align-items-start text-dark-charcoal mt-10 subscribe-price">
                                            <span itemprop="price" class="font-36 line-height-1 packages-prices" data-package_price="{{$subscribe->price}}">{{ addCurrencyToPrice($subscribe->price) }}</span><span class="yearly-price">{{ addCurrencyToPrice($subscribe->price) }} / month</span>
                                        </div>
                                        <div class="package-label-area d-flex align-items-center justify-content-sm-between pt-30">
                                            <!-- <span class="plan-label d-block font-weight-500">For Students</span> -->
                                            <button itemprop="button" type="submit" data-user_id="{{isset($childObj->id)?$childObj->id : 0}}" data-type="package_selection" data-id="{{$subscribe->id}}" class="package-selection btn w-100">Try for free         </button>
                                        </div>
                                        <ul class="mt-20 plan-feature">
                                            @php $is_available = ($subscribe->is_courses > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">Courses</li>
                                            @php $is_available = ($subscribe->is_timestables > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">Timestables</li>
                                            @php $is_available = ($subscribe->is_vocabulary > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">Vocabulary</li>
                                            @php $is_available = ($subscribe->is_bookshelf > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">Bookshelf</li>
                                            @php $is_available = ($subscribe->is_sats > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">SATs</li>
                                            @php $is_available = ($subscribe->is_elevenplus > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">11Plus</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
    <section class="social-info-section pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="social-info-holder">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="social-info-card">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/cancel.svg" alt="">
                                </span>
                                <div class="text-box">
                                    <h5>No hassle cancellation.</h5>
                                    <p>End your subscription anytime, online, no phone call required</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="social-info-card">
                                <span class="icon-box" style="background-color: #fff3e3;">
                                    <img src="/assets/default/svgs/dots-two.svg" alt="">
                                </span>
                                <div class="text-box">
                                    <h5>Super-fast email support</h5>
                                    <p>Including 1:1 personalized help to fully leverage the tool</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="social-info-card">
                                <span class="icon-box" style="background-color: #ffcfcf;">
                                    <img src="/assets/default/svgs/version.svg" alt="">
                                </span>
                                <div class="text-box">
                                    <h5>Upgrade/Downgrade anytime:</h5>
                                    <p>Move to a different plan and duration with built-in pro-rating so you never pay extra</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="section-title text-center mb-50">
                <h2 class="font-40 text-dark-charcoal mb-10">Frequently asked questions</h2>
                <p class="font-19">Asking the right questions is indeed a skill that requires careful consideration.</p>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-md-12">
            <div class="mt-0">
                <div class="lms-faqs mx-w-100 mt-0 pb-50">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingonsix">
                                <button class="btn btn-link font-18 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">Is there a free version of Rurera?</button>
                            </div>
                            <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion"><div class="card-body">Yes, Free and paid both versions are available.</div></div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <button class="btn btn-link font-18 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How much does membership for student cost ?
                                </button>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion"><div class="card-body">It starts from 100$ per month and extended as per choice.</div></div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingseven">
                                <button class="btn btn-link font-18 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                    Which pricing plan is right for me?
                                </button>
                            </div>
                            <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                <div class="card-body">You can discuss with support and can have learning suggestions based on your skill set.</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading8">
                                <button class="btn btn-link font-18 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">Can i change my membership plan ?</button>
                            </div>
                            <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion"><div class="card-body">You can make changes to your plan at any time by changing your plan type.</div></div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading9">
                                <button class="btn btn-link font-18 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                    What payment methods do you accept?
                                </button>
                            </div>
                            <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion"><div class="card-body">You can use paypal, skrill and bank transfer method.</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="recent-reviews-section pt-70">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2 class="mb-10 font-40">Recent reviews</h2></div>
            </div>
            <div class="col-12">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="masonry-grid">
                                <div class="grid-item">
                                    <div class="reviews-card">
                                        <div class="reviews-top">
                                            <span class="user-img"><img src="/avatar/svgA32101282879304116.png" alt="" /></span>
                                            <div class="top-user-text">
                                                <a href="#" class="author-name">Lynn Burkitt</a>
                                                <span class="reviews-star">
                                                    <span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span><span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span>
                                                    <span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span><span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span>
                                                    <span class="icon-box"><img src="/assets/default/svgs/star-white.svg" alt="" /></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="reviews-text">
                                            <a href="#">Lynn Burkitt<span>reviewed</span>TENS Machines Australia</a>
                                            <p class="font-14">""Easy to order and fast free postage.""</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script type="text/javascript">

    $(document).on('change', '.subscribed_for-field', function (e) {
        var package_month = 1;
        if($(this).is(':checked')) {
            package_month = 12;
        }
        $(".packages-prices").each(function(){
           var package_price = $(this).attr('data-package_price');
           var package_price = parseInt(package_price)*package_month;
           package_price = '$'+package_price;
           $(this).html(package_price);
        });
    });
</script>