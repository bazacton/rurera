@extends(getTemplate().'.layouts.app')

@push('styles_top')
@endpush

@section('content')

<div class="lms-membership-section" data-currency_sign="{{getCurrencySign()}}">
    <section class="lms-setup-progress-section mb-0 pt-70 pb-60 page-sub-header" style="background-color: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 text-center">
                    <div class="element-title text-center mb-40">
                        <h1 itemprop="title" class="font-72 text-dark-charcoal mb-0">Choose the right plan for you</h1>
                        <p class="font-16 pt-10">Save more with annual pricing</p>
                    </div>
                </div>
                <div class="col-12 col-lg-12 text-center">
                    <div class="plan-switch-holder">
                        <div class="plan-switch-option">
                            <span class="switch-label">Pay Monthly</span>
                            <div class="plan-switch">
                                <div class="custom-control custom-switch"><input type="checkbox" name="disabled" class="custom-control-input subscribed_for-field" value="12" id="iNotAvailable" /><label class="custom-control-label" for="iNotAvailable"></label></div>
                            </div>
                            <span class="switch-label">Pay Yearly</span>
                        </div>
                        <div class="save-plan"><span class="font-18 font-weight-500">Save 25%</span></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12 mx-auto">
                    <div class="row">

                        @include('web.default.pricing.packages_list',['subscribes' => $subscribes])

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
                    <div class="lms-faqs mx-w-100 mt-0">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingonsix">
                                    <button class="btn btn-link font-18 font-weight-bold" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">What payment methods do you accept?</button>
                                </div>
                                <div id="collapsesix" class="collapse show" aria-labelledby="headingsix" data-parent="#accordion"><div class="card-body">We accept a variety of payment methods to make it convenient for you, including all major credit and debit cards, PayPal, Skrill and other secure online payment options. This flexibility ensures that you can choose the payment method that works best for you.</div></div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Is there a free trial available?
                                    </button>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion"><div class="card-body">Yes, we offer a free trial period of five days that allows you to explore all the features and resources available on Rurera. During this trial, you can experience the full functionality of our platform and determine if it's the right fit for your child's educational needs before making any commitment.</div></div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingseven">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                        How much does a Rurera subscription cost?
                                    </button>
                                </div>
                                <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                    <div class="card-body">Rurera offers three subscription options:
                                    English, Maths, and Science: £39.99 per month, or £383.90 if paid annually.
                                    Exam Prep: £59.99 per month, or £575.90 if paid annually.
                                    Exam Prep Plus: £69.99 per month, or £671.90 if paid annually.</div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading8">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">What is your cancellation policy?</button>
                                </div>
                                <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion"><div class="card-body">You can cancel your Rurera subscription at any time through your Parent account. Even after cancellation, you'll retain full access to all features until the end of your current billing cycle, right up to the day before your subscription is set to renew.</div></div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading9">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                        Are there any additional fees or hidden charges?
                                    </button>
                                </div>
                                <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion"><div class="card-body">No, with Rurera, the price you see is the price you pay. There are no hidden fees, surprise charges, or additional costs. We believe in transparent pricing so you can budget confidently without worrying about unexpected expenses.</div></div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="heading10">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                        Can I have two children on one subscription, or do they need separate accounts?
                                    </button>
                                </div>
                                <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion"><div class="card-body">Each child needs their own subscription to ensure that the content is appropriately tailored to their individual learning needs. However, you can easily manage multiple students under one parent portal by signing in and clicking the "+" icon to add another child. If you require more than one subscription, feel free to contact us, and we’ll provide you with a sibling discount code to help with the cost.</div></div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="heading11">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                        Can I upgrade or downgrade my plan?
                                    </button>
                                </div>
                                <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion"><div class="card-body">es, we understand that your needs may change over time. That’s why we make it easy to upgrade or downgrade your plan whenever you need. Simply go to your account settings, and you can adjust your subscription to better fit your current requirements.</div></div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="heading12">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                        Which devices are compatible with Rurera?
                                    </button>
                                </div>
                                <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion"><div class="card-body">Rurera is compatible with a wide range of modern devices and browsers, both in the UK and internationally. Whether using a desktop, laptop, Chromebook, or iPad, your child can easily access Rurera's features and resources on any of these platforms for a smooth learning experience.</div></div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="heading13">
                                    <button class="btn btn-link font-18 font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                        Can I switch from a monthly to an annual plan?
                                    </button>
                                </div>
                                <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion"><div class="card-body">Yes, you can switch from a monthly to an annual plan at any time. This option allows you to take advantage of the discounted annual rate, providing you with substantial savings over the course of the year. You can make this change through your account settings, and the new plan will take effect immediately or at the end of your current billing cycle, depending on your preference.</div></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-results-revenue pt-50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="element-title text-center mb-40">
                        <h2 itemprop="title" class="font-40 text-dark-charcoal mb-0">Real-life results and revenue</h2>
                        <p class="font-16">See how companies like yours have smashed their sales success goals</p>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-md-12 mx-auto">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="results-revenue-card">
                                <div class="results-info"><strong class="font-72">$2.5M</strong><span class="font-20 font-weight-bold">Generated sales</span></div>
                                <div class="text-box">
                                    <p class="font-30 font-weight-500">
                                        Using Lumi CRM is one of the best decisions we've<br />
                                        ever made. we've seen our annual revenue explode.<br />
                                        and the outlook just keeps getting sunnier.
                                    </p>
                                    <a href="#" class="author-info">
                                        <img src="/assets/default/img/stats-thumb.png" alt="pricing-thumb" />
                                        <span class="font-18 font-weight-500">Nellie Foster<em class="font-16 d-block">Founder &amp; CEO, Foster Business Strategies</em></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12">
                            <div class="results-revenue-card">
                                <div class="results-info"><strong class="font-72">45%</strong><span class="font-20 font-weight-bold">Growth revenue</span></div>
                                <div class="text-box">
                                    <p class="font-30 font-weight-500">
                                        Lumi is created for sales people. It’s the kind of<br />
                                        software that just works. I don’t have to try to make<br />
                                        it work. It already does. It’s just perfect.
                                    </p>
                                    <a href="#" class="author-info">
                                        <img src="/assets/default/img/pricing-thumb.jpg" alt="pricing-thumb" /><span class="font-18 font-weight-500">Lawrence Gibbs<em class="font-16 d-block">Digital Marketing Director</em></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-have-question pt-100 pb-100 mt-50" style="background-color: #f3f6ff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 mx-auto">
                    <div class="have-question-card">
                        <div class="media-holder">
                            <figure><img src="/assets/default/img/About-Us-CTA-Image.jpg" alt="" /> <img class="attachment-img" src="/assets/default/img/hero-ornament.png" alt="" /></figure>
                        </div>
                        <div class="text-box">
                            <div class="section-title">
                            <h2 class="font-40 mb-20 font-weight-500">Got Questions? Our team is here to help reach out and let us assist you!</h2>
                            <span>Need help? Rurera's customer support team is here to assist with subscriptions, features, or technical issues. Contact us for quick and friendly support to ensure you get the most from your Rurera experience.</span>
                            </div>
                            <div class="contact-info"><a href="#" class="contact-btn">Contact Us</a><span>Or call +12 3456 7890</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade lms-choose-membership" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div class="modal-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="get" role="tabpanel" aria-labelledby="get-tab">
                        <div class="membership-steps-holder">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-30"><h2>Explore the details of your free trial experience.</h2></div>
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="membership-steps text-center row">
                                            <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                                <ul class="membership-steps-list mb-20">
                                                    <li class="active">
                                                        <a href="#">
                                                            <span class="icon-svg">
                                                                <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="lock-check" class="icon glyph">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            d="M18,8H17V7A5,5,0,0,0,7,7V8H6a2,2,0,0,0-2,2V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V10A2,2,0,0,0,18,8ZM9,7a3,3,0,0,1,6,0V8H9Zm6.71,6.71-4,4a1,1,0,0,1-1.42,0l-2-2a1,1,0,0,1,1.42-1.42L11,15.59l3.29-3.3a1,1,0,0,1,1.42,1.42Z"
                                                                        ></path>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span class="icon-svg">
                                                                <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            fill-rule="evenodd"
                                                                            d="M6 8a6 6 0 1112 0v2.917c0 .703.228 1.387.65 1.95L20.7 15.6a1.5 1.5 0 01-1.2 2.4h-15a1.5 1.5 0 01-1.2-2.4l2.05-2.733a3.25 3.25 0 00.65-1.95V8zm6 13.5A3.502 3.502 0 018.645 19h6.71A3.502 3.502 0 0112 21.5z"
                                                                        ></path>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span class="icon-svg">
                                                                <svg
                                                                    height="64px"
                                                                    width="64px"
                                                                    version="1.1"
                                                                    id="Capa_1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    viewBox="0 0 17.837 17.837"
                                                                    xml:space="preserve"
                                                                    fill="#fff"
                                                                >
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <g>
                                                                            <path
                                                                                d="M16.145,2.571c-0.272-0.273-0.718-0.273-0.99,0L6.92,10.804l-4.241-4.27 c-0.272-0.274-0.715-0.274-0.989,0L0.204,8.019c-0.272,0.271-0.272,0.717,0,0.99l6.217,6.258c0.272,0.271,0.715,0.271,0.99,0 L17.63,5.047c0.276-0.273,0.276-0.72,0-0.994L16.145,2.571z"
                                                                            ></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                                                <div class="membership-steps">
                                                    <h3 class="mb-5">Today</h3>
                                                    <p>Begin your rurera journey and start reading for free.</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                                                <div class="membership-steps">
                                                    <h3 class="mb-5">Day 5</h3>
                                                    <p>An email reminder will be sent as your free trial ends.</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                                                <div class="membership-steps">
                                                    <h3 class="mb-5">Day 7</h3>
                                                    <p>Payment processed on 6th day, cancel anytime before date.</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                                <a href="#" class="nav-link mt-20 btn-primary rounded-pill" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                                    Start your 7-day free trial
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="form-login-reading">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-30"><h2>Start Reading Today</h2></div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 mx-auto">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <a href="/google" target="_blank" class="social-login mt-20 p-15 text-center d-flex align-items-center justify-content-center">
                                                    <img src="/assets/default/img/auth/google.svg" class="mr-auto" height="24" width="24" alt=" google svg" /><span class="flex-grow-1">Login with Google account</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <a href="#" target="_blank" class="social-login mt-20 p-15 text-center d-flex align-items-center justify-content-center">
                                                    <img src="/assets/default/img/auth/facebook.svg" height="24" width="24" class="mr-auto" alt="facebook svg" /><span class="flex-grow-1">Login with Facebook account</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <div class="form-separator"><span>or</span></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <div class="input-field"><input type="text" placeholder="Email Address" /></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-field"><input type="text" placeholder="password" /></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <a href="#" class="nav-link btn-primary rounded-pill mb-25 text-center" id="book-tab" data-toggle="tab" data-target="#book" type="button" role="tab" aria-controls="book" aria-selected="true">
                                                    continue
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                                            <p class="mb-20">By Clicking on Start Free Trial, I agree to the<a href="#">Terms of Service</a>And<a href="#">Privacy Policy</a></p>
                                            <div class="subscription mb-20">
                                                <span>Already have a subscription?<a href="#" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">log in</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="book" role="tabpanel" aria-labelledby="book-tab">
                        <div class="book-detail-holder">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="book-detail">
                                            <div class="img-holder">
                                                <figure><img src="../assets/default/img/book-list1.png" width="152" height="192" alt="#" /></figure>
                                            </div>
                                            <div class="text-holder mt-20">
                                                <h2>Consult a grownup for assistance.</h2>
                                                <p class="mt-15">
                                                    <a href="#">
                                                        <span class="icon-svg">
                                                            <svg width="64px" height="64px" viewBox="0 0 48 48" id="b" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                <g id="SVGRepo_iconCarrier">
                                                                    <path class="c" d="m32.017,16.7078c1.7678,1.3258,3.241,4.7141,2.9463,8.397-.2946,2.799-1.7678,5.1561-2.9463,6.04"></path>
                                                                    <path class="c" d="m5.5,17.7391v12.8165h8.5443l11.0487,8.839V8.6054l-11.0487,9.1336H5.5Z"></path>
                                                                    <path class="c" d="m37.173,10.9625c3.0936,2.3571,5.598,8.397,5.3034,15.0263-.4419,5.0088-2.9463,9.1336-5.3034,10.9014"></path>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    Upgrade to the Family Premium plan to read the rest of this book and enjoy unlimited access to our entire library.
                                                </p>
                                                <a
                                                    href="#"
                                                    class="nav-link btn-primary rounded-pill mb-25"
                                                    id="subscribe-tab"
                                                    data-toggle="tab"
                                                    data-target="#subscribe"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="subscribe"
                                                    aria-selected="false"
                                                >
                                                    Get Rurera
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="subscribe" role="tabpanel" aria-labelledby="subscribe-tab">
                        <div class="subscribe-plan-holder">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-40">
                                        <h2>Select the rurera Family plan for your subscription.</h2>
                                        <p class="mt-10">Pay monthly or save 44% annually after your free trial!</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-30 pb-30 px-20 mb-30">
                                            <div class="d-flex align-items-start text-primary mt-20"><span class="font-36 line-height-1">$20</span></div>
                                            <ul class="mt-20 plan-feature">
                                                <li class="mt-10">15 days of subscription</li>
                                            </ul>
                                            <button
                                                type="submit"
                                                id="contact-tab"
                                                data-toggle="tab"
                                                data-target="#contact"
                                                role="tab"
                                                aria-controls="contact"
                                                aria-selected="false"
                                                class="btn btn-primary btn-block mt-30 rounded-pill bg-none"
                                            >
                                                Purchase
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-30 pb-30 px-20 mb-30">
                                            <span class="badge badge-primary badge-popular px-15 py-5">Popular</span>
                                            <div class="d-flex align-items-start text-primary mt-20"><span class="font-36 line-height-1">$100</span></div>
                                            <ul class="mt-20 plan-feature">
                                                <li class="mt-10">30 days of subscription</li>
                                            </ul>
                                            <button type="submit" id="contact-tab" data-toggle="tab" data-target="#contact" role="tab" aria-controls="contact" aria-selected="false" class="btn btn-primary btn-block mt-30 rounded-pill">
                                                Purchase
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 price-plan-image"><img src="../assets/default/img/price-plan.png" height="166" width="270" alt="#" /></div>
                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center bg-dark-green bg-dark-green">
                                        <strong>96% of subscribing parents in rurera Family report significant improvement in their child's reading skills.</strong>
                                        <div class="subscription mt-20">
                                            <span>Already have a subscription?<a href="." id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">log in</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="book-form-holder">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-lg-9 col-md-9 col-sm-12 text-center">
                                        <p>No need to worry! We won't ask for payment until after your 7-day free trial ends.</p>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-9 col-sm-12">
                                        <div class="book-form mt-30">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="input-field"><input type="text" placeholder="First Name" /></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="input-field"><input type="text" placeholder="Last Name" /></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="input-field input-card">
                                                            <span class="icon-svg">
                                                                <svg
                                                                    version="1.1"
                                                                    id="_x32_"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="64px"
                                                                    height="64px"
                                                                    viewBox="0 0 512 512"
                                                                    xml:space="preserve"
                                                                    fill="#000000"
                                                                >
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <g>
                                                                            <path
                                                                                class="st0"
                                                                                d="M261.031,153.484h-5.375v7.484h5.375c1.25,0,2.266-0.344,3-1.031c0.766-0.688,1.156-1.594,1.156-2.719 c0-1.109-0.391-2-1.156-2.703C263.297,153.828,262.281,153.484,261.031,153.484z"
                                                                            ></path>
                                                                            <path
                                                                                class="st0"
                                                                                d="M140.75,169.141c0.141-0.391,0.281-0.891,0.344-1.453c0.094-0.578,0.141-1.266,0.172-2.078 c0.031-0.797,0.031-1.766,0.031-2.891c0-1.109,0-2.063-0.031-2.875s-0.078-1.5-0.172-2.078c-0.063-0.578-0.203-1.047-0.344-1.453 c-0.156-0.406-0.375-0.75-0.641-1.078c-0.953-1.172-2.359-1.75-4.266-1.75H131.5v18.484h4.344c1.906,0,3.313-0.594,4.266-1.75 C140.375,169.891,140.594,169.531,140.75,169.141z"
                                                                            ></path>
                                                                            <path
                                                                                class="st0"
                                                                                d="M88.219,159.938c0.75-0.688,1.141-1.594,1.141-2.719c0-1.109-0.391-2-1.141-2.703 c-0.75-0.688-1.75-1.031-3.016-1.031h-5.375v7.484h5.375C86.469,160.969,87.469,160.625,88.219,159.938z"
                                                                            ></path>
                                                                            <polygon class="st0" points="229.875,167.219 237.141,167.219 233.563,156.906 "></polygon>
                                                                            <path
                                                                                class="st0"
                                                                                d="M466.656,88H45.344C20.313,88,0,108.313,0,133.344v245.313C0,403.688,20.313,424,45.344,424h421.313 C491.688,424,512,403.688,512,378.656V133.344C512,108.313,491.688,88,466.656,88z M435.656,138.313 c12.344,0,22.344,10,22.344,22.344S448,183,435.656,183s-22.344-10-22.344-22.344S423.313,138.313,435.656,138.313z M375.875,138.313c12.344,0,22.344,10,22.344,22.344S388.219,183,375.875,183s-22.344-10-22.344-22.344 S363.531,138.313,375.875,138.313z M276.781,148.531h10.547c2,0,3.703,0.344,5.141,1c1.406,0.672,2.625,1.719,3.688,3.156 c0.438,0.609,0.781,1.25,1.031,1.938c0.266,0.672,0.469,1.406,0.563,2.219s0.188,1.703,0.203,2.672 c0.031,0.969,0.047,2.047,0.047,3.203c0,1.172-0.016,2.25-0.047,3.219c-0.016,0.969-0.109,1.844-0.203,2.656 s-0.297,1.563-0.563,2.234c-0.25,0.672-0.594,1.328-1.031,1.938c-1.063,1.422-2.281,2.484-3.688,3.141 c-1.438,0.672-3.141,1-5.141,1h-10.547V148.531z M197.391,159.063c0.047-1.094,0.156-2.094,0.328-3.016 c0.188-0.922,0.469-1.766,0.859-2.516c0.406-0.781,0.969-1.531,1.703-2.25c1.016-0.938,2.156-1.688,3.406-2.203 c1.266-0.516,2.75-0.766,4.438-0.766c2.734,0,5.063,0.75,7,2.25s3.156,3.719,3.703,6.703H213c-0.281-1.172-0.813-2.141-1.594-2.891 s-1.875-1.125-3.281-1.125c-0.781,0-1.5,0.125-2.109,0.391c-0.625,0.266-1.125,0.625-1.547,1.078c-0.281,0.281-0.5,0.625-0.672,1 s-0.328,0.844-0.438,1.438c-0.109,0.578-0.203,1.313-0.234,2.203c-0.063,0.891-0.094,2.016-0.094,3.359 c0,1.359,0.031,2.484,0.094,3.375c0.031,0.891,0.125,1.625,0.234,2.219c0.109,0.563,0.266,1.063,0.438,1.422 c0.172,0.375,0.391,0.703,0.672,1c0.422,0.453,0.922,0.797,1.547,1.078c0.609,0.25,1.328,0.391,2.109,0.391 c1.406,0,2.531-0.375,3.297-1.141c0.797-0.75,1.328-1.719,1.625-2.875h5.781c-0.547,2.969-1.766,5.203-3.703,6.703 c-1.938,1.516-4.266,2.266-7,2.266c-1.688,0-3.172-0.281-4.438-0.781c-1.25-0.531-2.391-1.266-3.406-2.219 c-0.734-0.719-1.297-1.469-1.703-2.219c-0.391-0.781-0.672-1.625-0.859-2.531c-0.172-0.922-0.281-1.938-0.328-3.016 c-0.031-1.094-0.063-2.313-0.063-3.672C197.328,161.375,197.359,160.156,197.391,159.063z M163.172,148.531h20.969v4.953h-7.625 v23.422h-5.703v-23.422h-7.641V148.531z M152.844,148.531h5.688v28.375h-5.688V148.531z M125.797,148.531h10.547 c2,0,3.688,0.344,5.125,1c1.422,0.672,2.656,1.719,3.688,3.156c0.438,0.609,0.781,1.25,1.047,1.938 c0.266,0.672,0.453,1.406,0.563,2.219s0.172,1.703,0.203,2.672s0.031,2.047,0.031,3.203c0,1.172,0,2.25-0.031,3.219 s-0.094,1.844-0.203,2.656s-0.297,1.563-0.563,2.234s-0.609,1.328-1.047,1.938c-1.031,1.422-2.266,2.484-3.688,3.141 c-1.438,0.672-3.125,1-5.125,1h-10.547V148.531z M100.969,148.531h19.219v4.953h-13.531v6.641h11.531v4.953h-11.531v6.891h13.531 v4.938h-19.219V148.531z M74.125,148.531h11.453c1.484,0,2.797,0.25,3.969,0.703c1.172,0.469,2.172,1.094,3,1.875 s1.453,1.703,1.859,2.75c0.438,1.047,0.656,2.172,0.656,3.359c0,1.016-0.156,1.922-0.438,2.719c-0.297,0.797-0.688,1.5-1.156,2.125 c-0.5,0.625-1.063,1.156-1.719,1.594c-0.641,0.438-1.313,0.781-2.031,1.016l6.531,12.234h-6.625l-5.688-11.313h-4.109v11.313 h-5.703V148.531z M60.344,285.75v-21.875h33.25v21.875H60.344z M93.594,292.75v23.625H75.219c-8.219,0-14.875-6.656-14.875-14.875 v-8.75H93.594z M60.344,256.875V235h33.25v21.875H60.344z M60.344,228v-8.75c0-8.219,6.656-14.875,14.875-14.875h18.375V228H60.344 z M47.688,162.719c0-1.344,0.031-2.563,0.063-3.656c0.047-1.094,0.156-2.094,0.344-3.016c0.172-0.922,0.469-1.766,0.844-2.516 c0.406-0.781,0.969-1.531,1.719-2.25c1-0.938,2.125-1.688,3.406-2.203c1.25-0.516,2.734-0.766,4.422-0.766 c2.734,0,5.078,0.75,7.016,2.25c1.922,1.5,3.141,3.719,3.688,6.703h-5.813c-0.297-1.172-0.828-2.141-1.594-2.891 c-0.781-0.75-1.875-1.125-3.297-1.125c-0.797,0-1.484,0.125-2.109,0.391s-1.125,0.625-1.531,1.078c-0.281,0.281-0.5,0.625-0.688,1 c-0.172,0.375-0.313,0.844-0.438,1.438c-0.109,0.578-0.188,1.313-0.234,2.203s-0.078,2.016-0.078,3.359 c0,1.359,0.031,2.484,0.078,3.375s0.125,1.625,0.234,2.219c0.125,0.563,0.266,1.063,0.438,1.422c0.188,0.375,0.406,0.703,0.688,1 c0.406,0.453,0.906,0.797,1.531,1.078c0.625,0.25,1.313,0.391,2.109,0.391c1.422,0,2.531-0.375,3.297-1.141 c0.797-0.75,1.328-1.719,1.625-2.875h5.781c-0.547,2.969-1.766,5.203-3.688,6.703c-1.938,1.516-4.281,2.266-7.016,2.266 c-1.688,0-3.172-0.281-4.422-0.781c-1.281-0.531-2.406-1.266-3.406-2.219c-0.75-0.719-1.313-1.469-1.719-2.219 c-0.375-0.781-0.672-1.625-0.844-2.531c-0.188-0.922-0.297-1.938-0.344-3.016C47.719,165.297,47.688,164.078,47.688,162.719z M128,370.656H48v-16h80V370.656z M132.094,228v7v9.031v0.594v12.25v7v9.625v5.531v6.719v7v13.406v10.219h-31.5v-10.219V292.75v-7 v-6.719V273.5v-9.625v-7v-12.25v-0.594V235v-7v-7.594v-16.031h18.375h13.125h5.25h16.625h3.484c8.219,0,14.891,6.656,14.891,14.875 V228h-18.375h-16.625H132.094z M139.094,256.875V235h33.25v21.875H139.094z M172.344,263.875v21.875h-33.25v-21.875H172.344z M139.094,316.375V292.75h33.25v8.75c0,8.219-6.672,14.875-14.891,14.875H139.094z M240,370.656h-80v-16h80V370.656z M240.375,176.906l-1.719-5.016h-10.375l-1.781,5.016h-5.938l10.625-28.375h4.469l10.688,28.375H240.375z M259.75,165.594h-4.094 v11.313h-5.703v-28.375h11.453c1.469,0,2.797,0.25,3.969,0.703c1.172,0.469,2.172,1.094,3,1.875 c0.813,0.781,1.438,1.703,1.859,2.75c0.438,1.047,0.641,2.172,0.641,3.359c0,1.016-0.141,1.922-0.438,2.719 c-0.281,0.797-0.672,1.5-1.156,2.125c-0.5,0.625-1.063,1.156-1.703,1.594s-1.328,0.781-2.047,1.016l6.531,12.234h-6.609 L259.75,165.594z M352,370.656h-80v-16h80V370.656z M464,370.656h-80v-16h80V370.656z M464,322.656H304v-16h160V322.656z"
                                                                            ></path>
                                                                            <path
                                                                                class="st0"
                                                                                d="M291.75,169.141c0.125-0.391,0.266-0.891,0.344-1.453c0.078-0.578,0.125-1.266,0.156-2.078 c0.031-0.797,0.031-1.766,0.031-2.891c0-1.109,0-2.063-0.031-2.875s-0.078-1.5-0.156-2.078s-0.219-1.047-0.344-1.453 c-0.156-0.406-0.375-0.75-0.656-1.078c-0.938-1.172-2.375-1.75-4.266-1.75h-4.344v18.484h4.344c1.891,0,3.328-0.594,4.266-1.75 C291.375,169.891,291.594,169.531,291.75,169.141z"
                                                                            ></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <input type="text" placeholder="Card Number" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                                                    <p class="mb-25">
                                                        Once your 7-day free trial is over, we will automatically charge your chosen payment method $19.99 every month until you decide to cancel. You have the freedom to cancel at any time.
                                                        Keep in mind that there may be sales tax added. For instructions on how to cancel, please refer to the provided guidelines
                                                    </p>
                                                </div>
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center"><a href="/login" class="nav-link btn-primary rounded-pill mb-25">Sart Free Trial</a></div>
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                                                    <p class="mb-20">By Clicking on Start Free Trial, I agree to the<a href="#">Terms of Service</a>And<a href="#">Privacy Policy</a></p>
                                                    <div class="subscription mb-20">
                                                        <span>Already have a subscription?<a href="#">log in</a></span>
                                                    </div>
                                                    <div class="secure-server">
                                                        <figure>
                                                            <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="lock-check" class="icon glyph">
                                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                <g id="SVGRepo_iconCarrier">
                                                                    <path
                                                                        d="M18,8H17V7A5,5,0,0,0,7,7V8H6a2,2,0,0,0-2,2V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V10A2,2,0,0,0,18,8ZM9,7a3,3,0,0,1,6,0V8H9Zm6.71,6.71-4,4a1,1,0,0,1-1.42,0l-2-2a1,1,0,0,1,1.42-1.42L11,15.59l3.29-3.3a1,1,0,0,1,1.42,1.42Z"
                                                                    ></path>
                                                                </g>
                                                            </svg>
                                                        </figure>
                                                        <span>
                                                            Secure Server<br />
                                                            SSL Encrypted
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade lms-choose-membership" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div class="modal-body">
                <div class="tab-content subscription-content" id="nav-tabContent">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')


@endpush

