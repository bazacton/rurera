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
                                <div class="custom-control custom-switch"><input type="checkbox" {{$is_checked}} name="subscribed_for" class="custom-control-input" id="subscribed_for" value="12"/><label class="custom-control-label" for="subscribed_for"></label></div>
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
                                    <div class="subscribe-plan {{($selected_package == $subscribe->id)? 'active' : ''}} current-plan position-relative d-flex flex-column rounded-lg pb-25 pt-60 px-20 mb-30">
                                        <span class="subscribe-icon mb-20"><img src="{{ $subscribe->icon }}" height="auto" width="auto" alt="Box image" /></span>
                                        <div class="subscribe-title">
                                            <h3 itemprop="title" class="font-24 font-weight-500">{{ $subscribe->title }}</h3>
                                            <span>{{ $subscribe->description }}</span>
                                        </div>
                                        <div class="d-flex align-items-start text-dark-charcoal mt-10 subscribe-price">
                                            <span itemprop="price" class="font-36 line-height-1">{{ addCurrencyToPrice($subscribe->price) }}</span><span class="yearly-price">{{ addCurrencyToPrice($subscribe->price) }} / month</span>
                                        </div>
                                        <span class="plan-label d-block font-weight-500 pt-20">For Students</span>
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
                                        <button itemprop="button" type="submit" data-user_id="{{isset($childObj->id)?$childObj->id : 0}}" data-type="package_selection" data-id="{{$subscribe->id}}" class="package-selection btn btn-outline-primary btn-block mt-30">Select</button>
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
                                    <button class="btn btn-link font-22 font-weight-normal" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">Is there a free version of Rurera?</button>
                                </div>
                                <div id="collapsesix" class="collapse show" aria-labelledby="headingsix" data-parent="#accordion"><div class="card-body">Yes, Free and paid both versions are available.</div></div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How much does membership for student cost ?
                                    </button>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion"><div class="card-body">It starts from 100$ per month and extended as per choice.</div></div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingseven">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                        Which pricing plan is right for me?
                                    </button>
                                </div>
                                <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                    <div class="card-body">You can discuss with support and can have learning suggestions based on your skill set.</div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading8">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">Can i change my membership plan ?</button>
                                </div>
                                <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion"><div class="card-body">You can make changes to your plan at any time by changing your plan type.</div></div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading9">
                                    <button class="btn btn-link font-22 font-weight-normal collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
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