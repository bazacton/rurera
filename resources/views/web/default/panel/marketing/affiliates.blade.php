@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
    <section class="">
        <div class="section-title mb-30">
            <h2 itemprop="title" class="font-22 mb-0">Referral program</h2>
        </div>
        <div class="referral-holder panel-border bg-white rounded-sm px-25 pt-25">
              <div class="row">
                  <div class="col-12 col-lg-6">
                      <div class="referral-text mb-30">
                          <h3 class="font-18 font-weight-bold mb-5" itemprop="title">How to use Referral Program</h3>
                          <p class="text-gray mb-15">Use images to enhance your post, improve its folow, add humor and explain complex topics</p>
                          <a href="#" class="started-btn font-16 font-weight-500">Get Started</a>
                      </div>
                  </div>
                  <div class="col-12 col-lg-6">
                      <div class="referral-text mb-30">
                          <h3 class="font-18 font-weight-bold mb-5" itemprop="title">Your Referral Link</h3>
                          <p class="text-gray mb-15">Plan your blog post by choosing a topic, creating an outline conduct <br> research, and checking facts</p>
                          <div class="referral-link">
                              <input type="text" class="link-address font-16 font-weight-500" name="affiliate_url" value="{{ $affiliateCode->getAffiliateUrl() }}">
                              <a href="javascript:;" class="link-btn font-16 font-weight-500 js-copy" data-input="affiliate_url">Copy Link</a>
                          </div>
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="referral-price-lists mb-30">
                          <div class="row">
                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="referral-price-card text-center">
                                      <span class="font-16 d-block mb-5" style="color: #624abc;">{{ trans('panel.referred_users') }}</span>
                                      <strong class="font-30">{{ $referredUsersCount }}</strong>
                                  </div>
                              </div>
                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="referral-price-card text-center">
                                      <span class="font-16 d-block mb-5" style="color: #5fa66e;">Bonus</span>
                                      <strong class="font-30">{{ addCurrencyToPrice(round($registrationBonus, 2)) }}</strong>
                                  </div>
                              </div>
                              <div class="col-12 col-lg-4 col-md-4">
                                  <div class="referral-price-card text-center">
                                      <span class="font-16 d-block mb-5" style="color: #d13b61;">{{ trans('panel.affiliate_bonus') }}</span>
                                      <strong class="font-30">{{ addCurrencyToPrice(round($affiliateBonus, 2)) }}</strong>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="referral-text mb-30">
                          @if(!empty($referralSettings))
                              <div class="mt-15 text-gray">
                                  @if(!empty($referralSettings['affiliate_user_amount']))<p>- {{ trans('panel.user_registration_reward') }}: {{ addCurrencyToPrice($referralSettings['affiliate_user_amount']) }}</p>@endif
                                  @if(!empty($referralSettings['referred_user_amount']))<p>- {{ trans('panel.referred_user_registration_reward') }}: {{ addCurrencyToPrice($referralSettings['referred_user_amount']) }}</p>@endif
                                  @if(!empty($referralSettings['affiliate_user_commission']))<p>- {{ trans('panel.referred_user_purchase_commission') }}: {{ $referralSettings['affiliate_user_commission'] }}%</p>@endif
                                  <p>- {{ trans('panel.your_affiliate_code') }}: {{ $affiliateCode->code }}</p>
                                  @if(!empty($referralSettings['referral_description']))<p>- {{ $referralSettings['referral_description'] }}</p>@endif
                              </div>
                          @endif
                      </div>
                  </div>
                  <div class="col-12">
                    <div class="referral-withdraw mb-30">
                      <div class="withdraw-card p-20 d-flex align-items-center flex-wrap">
                          <div class="icon-box">
                              <img src="/assets/default/img/withdraw-icon.png" alt="">
                          </div>
                          <div class="withdraw-text">
                              <h3 class="blog-grid-title font-18 font-weight-bold mb-5" itemprop="title">Withdraw Your Money to a Bank Account</h3>
                              <p class="font-16">Withdraw money securily to your bank account. Commision is $25 per transaction under $50,000</p>
                          </div>
                          <div class="withdraw-btn-holder">
                              <a href="#" class="withdraw-btn">Withdraw Money</a>
                          </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
    </section>

    <section class="mt-25">
        <h2 class="section-title">{{ trans('panel.earnings') }}</h2>

        <div class="panel-section-card rounded-sm mt-20">
            <div class="row">
                <div class="col-12 ">
                    <div class="table-responsive transactions-table">
                        <table class="table text-center custom-table">
                            <thead>
                            <tr>
                                <th class="font-16 font-weight-500">{{ trans('panel.user') }}</th>
                                <th class="font-16 font-weight-500">{{ trans('panel.registration_bonus') }}</th>
                                <th class="font-16 font-weight-500">{{ trans('panel.affiliate_bonus') }}</th>
                                <th class="font-16 font-weight-500">{{ trans('panel.registration_date') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($affiliates->count() > 0)
                            @foreach($affiliates as $affiliate)
                                <tr>
                                    <td class="text-left">
                                        <div class="user-inline-avatar d-flex align-items-center">
                                            <div class="avatar bg-gray200">
                                                <img src="{{ $affiliate->referredUser->getAvatar() }}" class="img-cover" alt="{{ $affiliate->referredUser->get_full_name() }}">
                                            </div>
                                            <div class=" ml-5">
                                                <span class="d-block font-weight-500">{{ $affiliate->referredUser->get_full_name() }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ addCurrencyToPrice($affiliate->getAffiliateRegistrationAmountsOfEachReferral()) }}</td>

                                    <td>{{ addCurrencyToPrice($affiliate->getTotalAffiliateCommissionOfEachReferral()) }}</td>

                                    <td>{{ dateTimeFormat($affiliate->created_at, 'Y M j | H:i') }}</td>
                                </tr>
                            @endforeach
                            @else
                            <tr class="no-record-found">
                                <td class="text-left" colspan="5">No Records Found</td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="my-30">
                        {{ $affiliates->appends(request()->input())->links('vendor.pagination.panel') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
