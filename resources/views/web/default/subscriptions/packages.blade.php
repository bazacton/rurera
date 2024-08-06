<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">

@include('web.default.subscriptions.steps',['activeStep'=> 'packages'])
@php $update_package_confirm = isset( $update_package_confirm )? $update_package_confirm : false; 

$subscribed_childs = isset( $subscribed_childs) ? $subscribed_childs : 0;
@endphp
@if( $update_package_confirm == true)
<section class="lms-setup-progress-section mb-0 pt-20 pb-60 package-confirm-modal">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="element-title text-center mb-40">
                        @if(isset($action_reason))
                            @if( $action_reason == 'module_access')
                                <p class="font-16">Subscribed package for {{isset($childObj->id)? $childObj->get_full_name() : ''}} dont have access to this module.</p>
                            @endif
                        @endif
                        <p class="font-16">Do you want to update the package for student {{isset($childObj->id)? $childObj->get_full_name() : ''}}?</p>
                        <div class="package-controls">
                            <a href="javascript:;" data-dismiss="modal" aria-label="Close">Never Mind</a>
                            <a href="javascript:;" class="package-confirm-btn">Continue</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endif
@php $packages_list_class = ($update_package_confirm == true)? 'rurera-hide' : ''; 

$subscribed_for = isset( $subscribed_for)? $subscribed_for : 1;
$user_subscribed_for = isset( $user_subscribed_for)? $user_subscribed_for : 1;
@endphp
<section class="lms-setup-progress-section mb-0 pt-20 pb-60 packages-list-modal {{$packages_list_class}}">
        <div class="container">
            <form class="package-register-form" method="post" action="javascript:;" data-user_subscribed_for="{{isset( $user_subscribed_for )? $user_subscribed_for : 1}}">
                      {{ csrf_field() }}
                <div class="row">
                        <div class="col-12 col-lg-12 text-center">
                            <div class="element-title text-center mb-40">	
                                <h2 itemprop="title" class="font-50 text-dark-charcoal mb-0">Choose the right plan for {{isset($childObj->id)? $childObj->get_full_name() : ''}}</h2>
                                <p class="font-16 pt-10">Save more with annual pricing</p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 text-center">
                            <div class="plan-switch-holder">
                                <div class="plan-switch-option">
                                    <span class="switch-label">Pay Monthly</span>
                                    <div class="plan-switch">
                                        <div class="custom-control custom-switch"><input type="checkbox" name="subscribed_for" class="custom-control-input subscribed_for-field" value="12" id="iNotAvailable" {{($subscribed_for == 12)? 'checked' : '' }} /><label class="custom-control-label" for="iNotAvailable"></label></div>
                                    </div>
                                    <span class="switch-label">Pay Yearly</span>
                                </div>
                                <div class="save-plan"><span class="font-18 font-weight-500">Save 25%</span></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mx-auto lms-membership-section" data-currency_sign="{{getCurrencySign()}}">
                            <div class="row">

                                @include('web.default.pricing.packages_list',['subscribes' => $subscribes, 'selected_package' => $selected_package, 'subscribed_childs' => $subscribed_childs, 'user_subscribed_for' => $user_subscribed_for])

                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </section>
    <section class="social-info-section pb-60 packages-list-modal {{$packages_list_class}}">
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
<section class="container packages-list-modal {{$packages_list_class}}">
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
<section class="recent-reviews-section pt-70 packages-list-modal {{$packages_list_class}}">
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
                                            <p class="font-16">""Easy to order and fast free postage.""</p>
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


    $(document).on('click', '.package-confirm-btn', function (e) {
        $(".packages-list-modal").removeClass('rurera-hide');
        $(".package-confirm-modal").addClass('rurera-hide');

    });
</script>