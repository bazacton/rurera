<section class="lms-setup-progress-section mb-0 pt-70 pb-60" style="background-color: #fff;">
        <div class="container">
            <form class="package-register-form" method="post" action="javascript:;">
                      {{ csrf_field() }}
            <div class="row">
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
                                            <span itemprop="price" class="font-36 line-height-1">{{ addCurrencyToPrice($subscribe->price) }}</span><span class="yearly-price">{{ addCurrencyToPrice($subscribe->price) }} / year</span>
                                        </div>
                                        <span class="plan-label d-block font-weight-500 pt-20">For Students</span>
                                        <ul class="mt-20 plan-feature">
                                            @php $is_available = ($subscribe->is_courses > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">Courses</li>
                                            @php $is_available = ($subscribe->is_timestables > 0)? '' : 'subscribe-no'; @endphp
                                            <li class="mt-10 {{$is_available}}">Timestables</li>
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