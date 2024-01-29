@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
<section class="content-section mt-10">

<div class="panel-help-center mb-30">
        <div class="help-search">
            <div class="help-title">
                <span class="title-num">1</span>
                <h2 class="font-22 font-weight-bold">How can we help you?</h2>
            </div>
            <form>
                <div class="search-input">
                    <i class="search-icon">&#9906;</i>
                    <input type="text" placeholder="Describe your issue">
                </div>
            </form>
        </div>
        <div class="help-topics">
            <span class="topics-label">Browse help topics</span>
            <div class="topics-accordion">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Find answers to your top Google one issues
                            </button>
                        </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                            <li>Can't sign in to your Google Account</li>
                            <li>Tips to complete account recovery steps</li>
                            <li>Change or reset your password</li>
                            <li>Get support and ask a Google Expert</li>
                            <li>Change or update your browser for a better experience</li>
                            <li>Get help with payment issues for Google one storage</li>
                            </ul>
                        </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Get started with Google one
                            </button>
                        </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                            <li>Can't sign in to your Google Account</li>
                            <li>Tips to complete account recovery steps</li>
                            <li>Change or reset your password</li>
                            <li>Get support and ask a Google Expert</li>
                            <li>Change or update your browser for a better experience</li>
                            <li>Get help with payment issues for Google one storage</li>
                            </ul>
                        </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Get more storage
                            </button>
                        </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                            <li>Can't sign in to your Google Account</li>
                            <li>Tips to complete account recovery steps</li>
                            <li>Change or reset your password</li>
                            <li>Get support and ask a Google Expert</li>
                            <li>Change or update your browser for a better experience</li>
                            <li>Get help with payment issues for Google one storage</li>
                            </ul>
                        </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header" id="headingfour">
                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                Share with your family
                            </button>
                            </h5>
                        </div>
                        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
                            <div class="card-body">
                            <ul>
                                <li>Can't sign in to your Google Account</li>
                                <li>Tips to complete account recovery steps</li>
                                <li>Change or reset your password</li>
                                <li>Get support and ask a Google Expert</li>
                                <li>Change or update your browser for a better experience</li>
                                <li>Get help with payment issues for Google one storage</li>
                            </ul>
                            </div>
                        </div>
                        </div>

                        <div class="card">
                        <div class="card-header" id="headingfive">
                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                Manage your purchases
                            </button>
                            </h5>
                        </div>
                        <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                            <div class="card-body">
                            <ul>
                                <li>Can't sign in to your Google Account</li>
                                <li>Tips to complete account recovery steps</li>
                                <li>Change or reset your password</li>
                                <li>Get support and ask a Google Expert</li>
                                <li>Change or update your browser for a better experience</li>
                                <li>Get help with payment issues for Google one storage</li>
                            </ul>
                            </div>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header" id="headingsix">
                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                                Ask for help or get back into your account
                            </button>
                            </h5>
                        </div>
                        <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                            <div class="card-body">
                            <ul>
                                <li>Can't sign in to your Google Account</li>
                                <li>Tips to complete account recovery steps</li>
                                <li>Change or reset your password</li>
                                <li>Get support and ask a Google Expert</li>
                                <li>Change or update your browser for a better experience</li>
                                <li>Get help with payment issues for Google one storage</li>
                            </ul>
                            </div>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header" id="headingseven">
                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                Get the most out of your Google one benefits
                            </button>
                            </h5>
                        </div>
                        <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                            <div class="card-body">
                            <ul>
                                <li>Can't sign in to your Google Account</li>
                                <li>Tips to complete account recovery steps</li>
                                <li>Change or reset your password</li>
                                <li>Get support and ask a Google Expert</li>
                                <li>Change or update your browser for a better experience</li>
                                <li>Get help with payment issues for Google one storage</li>
                            </ul>
                            </div>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header" id="headingeight">
                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
                                Get safe & stay online
                            </button>
                            </h5>
                        </div>
                        <div id="collapseeight" class="collapse" aria-labelledby="headingeight" data-parent="#accordion">
                            <div class="card-body">
                            <ul>
                                <li>Can't sign in to your Google Account</li>
                                <li>Tips to complete account recovery steps</li>
                                <li>Change or reset your password</li>
                                <li>Get support and ask a Google Expert</li>
                                <li>Change or update your browser for a better experience</li>
                                <li>Get help with payment issues for Google one storage</li>
                            </ul>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="panel-morehelp">
            <div class="morehelp-text">
                <h3 class="morehelp-title">
                    Need more help?
                    <span>Try these next steps</span>
                </h3>
                <a href="#" class="contact-btn">
                    <span class="icon-box">
                        <img src="/assets/default/svgs/headphone.svg" alt="">
                    </span>
                    <p>
                        Contact us
                        <span>Tell us more and we'll help you get there</span>
                    </p>
                </a>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts_bottom')

@endpush
