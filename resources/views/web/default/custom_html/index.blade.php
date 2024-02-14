@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
<section class="content-section mt-10">
    <div class="rewards-layout mb-50">
        <div class="row">
            <div class="col-12">
                <div class="rewards-header p-20 mb-30">
                    <div class="text-holder d-flex align-items-center justify-content-sm-center flex-wrap text-center flex-column">
                        <p class="mb-20">Join Loyalty Points and get rewarded while you shop. You'll <br> get <strong>250 points</strong> for signing up. What are you waiting for?</p>
                        <div class="header-controls">
                            <a href="#" class="join-btn">Join now</a>
                            <a href="#" class="login-btn">Log in</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="rewards-heading text-center mb-30">
                    <h2 class="rewards-heading-text font-24 font-weight-normal">Earn points</h2>
                </div>
                <div class="rewards-layout-box column-3 p-20 mb-30">
                    <div class="row">
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/bag.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Make a purchase</h5>
                                    <span class="item-points">10 points per $1</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/signup.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Create an account</h5>
                                    <span class="item-points">250 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Happy Birthday</h5>
                                    <span class="item-points">500 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/bubble-star.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Leave a Review</h5>
                                    <span class="item-points">100 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/bubble-star.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Add a photo in your Review</h5>
                                    <span class="item-points">200 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/reward-facebook.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Like us on Facebook</h5>
                                    <span class="item-points">100 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/newsletter.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Sign up to our mailing list</h5>
                                    <span class="item-points">100 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/reward-instagram.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Follow us on Instagram</h5>
                                    <span class="item-points">100 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/bag.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Carbon Neutral Order</h5>
                                    <span class="item-points">50 points</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/visit.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Read Our Latest Blog</h5>
                                    <span class="item-points">50 points</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="rewards-heading text-center mb-30">
                    <h2 class="rewards-heading-text font-24 font-weight-normal">Rewards</h2>
                </div>
                <div class="rewards-layout-box column-3 p-20 mb-30">
                    <div class="row">
                        <div class="col-12">
                            <div class="rewards-item item-left d-flex align-items-center justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/bag.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Redeem your points when you checkout</h5>
                                    <span class="item-points">100 points per $1</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">House Plant Invigorator</h5>
                                    <span class="item-points">100% off . 500 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Digital Plant Thermometer 🌡️</h5>
                                    <span class="item-points">100% off . 1,800 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Pride Plant Magnets</h5>
                                    <span class="item-points">100% off . 600 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Coco Coir Pole</h5>
                                    <span class="item-points">100% off . 1,200 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Plant Picks For A Purpose</h5>
                                    <span class="item-points">100% off . 600 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Arber Organic Plant Food</h5>
                                    <span class="item-points">100% off . 2,200 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Arber Organic Bio Insecticide</h5>
                                    <span class="item-points">100% off . 2,200 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="rewards-item d-flex align-items-center flex-column justify-content-center">
                                <span class="icon-box">
                                    <img src="/assets/default/svgs/birthday.svg" alt="">
                                </span>
                                <div class="item-text">
                                    <h5 class="item-title">Lively Root Icon Dad Hat</h5>
                                    <span class="item-points">100% off . 2,200 points</span>
                                    <a href="#" class="view-btn font-14 font-weight-normal">View product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="rewards-heading text-center mb-30">
                    <h2 class="rewards-heading-text font-24 font-weight-normal">Tiers</h2>
                </div>
                <div class="rewards-layout-box p-20">
                    <div class="rewards-tier-box">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="tier-item">
                                    <div class="tier-item-header">
                                        <span class="tier-number">1</span>
                                        <h5 class="item-title">Sprout Squad</h5>
                                        <span class="item-sub-title">Start here</span>
                                    </div>
                                    <div class="tier-points">
                                        <span>10 points per $1</span>
                                    </div>
                                    <div class="tier-item-footer"></div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="tier-item">
                                    <div class="tier-item-header">
                                        <span class="tier-number">2</span>
                                        <h5 class="item-title">Bloomer Bunch</h5>
                                        <span class="item-sub-title">Spend $250</span>
                                    </div>
                                    <div class="tier-points">
                                        <span>12 points per $1</span>
                                    </div>
                                    <div class="tier-item-footer"></div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="tier-item">
                                    <div class="tier-item-header">
                                        <span class="tier-number">3</span>
                                        <h5 class="item-title">Evergreen Group</h5>
                                        <span class="item-sub-title">Start here</span>
                                    </div>
                                    <div class="tier-points">
                                        <span>15 points per $1</span>
                                    </div>
                                    <div class="tier-item-footer">
                                      <span class="font-14">Subscribe to any product</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-4">
                                <div class="tier-item">
                                    <div class="tier-item-header">
                                        <span class="tier-number">4</span>
                                        <h5 class="item-title">V.I.P.P</h5>
                                        <span class="item-sub-title">Start here</span>
                                    </div>
                                    <div class="tier-points">
                                        <span>10 points per $1</span>
                                    </div>
                                    <div class="tier-item-footer">
                                      <span class="font-14">Subscribe to any product</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="referral-holder">
      <div class="section-title mb-20">
          <h2 itemprop="title" class="font-22 mb-0">Referral program</h2>
      </div>
      <div class="row">
          <div class="col-12 col-lg-6">
              <div class="referral-text mb-30">
                  <h3 class="font-18 font-weight-bold mb-5" itemprop="title">How to use Referral Program</h3>
                  <p class="text-gray mb-15">Use images to enhance your post, improve its folow, add humor and explain complex topics</p>
                  <a href="#" class="started-btn font-15 font-weight-500">Get Started</a>
              </div>
          </div>
          <div class="col-12 col-lg-6">
              <div class="referral-text mb-30">
                  <h3 class="font-18 font-weight-bold mb-5" itemprop="title">Your Referral Link</h3>
                  <p class="text-gray mb-15">Plan your blog post by choosing a topic, creating an outline conduct <br> research, and checking facts</p>
                  <div class="referral-link">
                      <input type="text" class="link-address font-15 font-weight-500" value="https://keenthemes.com/referral/?refid=345re">
                      <a href="#" class="link-btn font-15 font-weight-500">Copy Link</a>
                  </div>
              </div>
          </div>
          <div class="col-12">
              <div class="referral-price-lists mb-30">
                  <div class="row">
                      <div class="col-12 col-lg-3 col-md-4">
                          <div class="referral-price-card text-center">
                              <span class="font-18 d-block mb-5" style="color: #624abc;">Net Earnings</span>
                              <strong class="font-30">$63,240</strong>
                          </div>
                      </div>
                      <div class="col-12 col-lg-3 col-md-4">
                          <div class="referral-price-card text-center">
                              <span class="font-18 d-block mb-5" style="color: #5fa66e;">Balance</span>
                              <strong class="font-30">$8,530</strong>
                          </div>
                      </div>
                      <div class="col-12 col-lg-3 col-md-4">
                          <div class="referral-price-card text-center">
                              <span class="font-18 d-block mb-5" style="color: #d13b61;">Avg Deal Size</span>
                              <strong class="font-30">$2,600</strong>
                          </div>
                      </div>
                      <div class="col-12 col-lg-3 col-md-4">
                          <div class="referral-price-card text-center">
                              <span class="font-18 d-block mb-5" style="color: #5175cd;">Referral Signups</span>
                              <strong class="font-30">$783</strong>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-12">
              <div class="referral-text mb-30">
                  <p class="text-gray">Writing headlines for blog posts is as much an art as it is a science, and probably warrants its own post, but for now, all I'd advise is experimenting with what works for your audience, especially if it's not resonating with your audience </p>
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
                      <p class="font-15">Withdraw money securily to your bank account. Commision is $25 per transaction under $50,000</p>
                  </div>
                  <div class="withdraw-btn-holder">
                      <a href="#" class="withdraw-btn">Withdraw Money</a>
                  </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="spell-levels levels-grouping">
        <div class="spell-levels-top">
            <h3 class="font-19 font-weight-bold">Unite 3 : Grouping and identifying organisms</h3>
        </div>
        <ul>
            <li>
                <a href="#">
                    <div class="levels-progress circle" data-percent="85">
                        <span class="progress-box">
                            <span class="progress-count"></span>
                        </span>
                    </div>
                    <span class="thumb-box">
                        <img src="/assets/default/img/thumb1.png" alt="">
                    </span>
                </a>
                <div class="spell-tooltip">
                    <div class="spell-tooltip-text">
                        <h4 class="font-19 font-weight-bold">Hello!</h4>
                        <span>Learn greetings for meeting people</span>
                    </div>
                </div>
            </li>
            <li>
                <a href="#">
                    <div class="levels-progress circle" data-percent="55">
                        <span class="progress-box">
                            <span class="progress-count"></span>
                        </span>
                    </div>
                    <span class="thumb-box">
                        <img src="/assets/default/img/thumb1.png" alt="">
                    </span>
                </a>
                <div class="spell-tooltip">
                    <div class="spell-tooltip-text">
                        <h4 class="font-19 font-weight-bold">Introducing yourself</h4>
                        <span>Say your name</span>
                    </div>
                </div>
            </li>
            <li class="treasure">
                <a href="#">
                    <span class="thumb-box">
                        <img src="/assets/default/img/treasure.png" alt="">
                    </span>
                </a>
            </li>

            <li>

                <a href="#">
                    <div class="levels-progress circle" data-percent="75">
                        <span class="progress-box">
                            <span class="progress-count"></span>
                        </span>
                    </div>
                    <span class="thumb-box">
                        <img src="/assets/default/img/thumb1.png" alt="">
                    </span>
                </a>
                <div class="spell-tooltip">
                    <div class="spell-tooltip-text">
                        <h4 class="font-19 font-weight-bold">Saying how you are</h4>
                        <span>Complete all Topics above to unlock this!</span>
                    </div>
                </div>
            </li><li>
                <a href="#">
                    <div class="levels-progress circle" data-percent="30">
                        <span class="progress-box">
                            <span class="progress-count"></span>
                        </span>
                    </div>
                    <span class="thumb-box">
                        <img src="/assets/default/img/thumb1.png" alt="">
                    </span>
                </a>
                <div class="spell-tooltip">
                    <div class="spell-tooltip-text">
                        <h4 class="font-19 font-weight-bold">Developing fluency</h4>
                        <span>Complete all Topics above to unlock this!</span>
                    </div>
                </div>
            </li>
    </ul>
    </div>
    
    <div class="spell-levels-top">
       <h3 class="font-19 font-weight-bold">Unite 3 : Grouping and identifying organisms</h3>
   </div>
    <div class="lms-performace-section mb-50">
        <ul class="lms-performace-table leaderboard">
            <li class="lms-performace-head">
                <div>
                    <h5>Serial</h5>
                </div>
                <div><span class="font-14">User</span></div>
                <div><span class="font-14">Total Books Read</span></div>
                <div><span class="font-14">Time spent</span></div>
                <div><span class="coin-icon"><svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="800.000000pt" height="970.000000pt" viewBox="0 0 800.000000 970.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,970.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M3202 9689 c-116 -17 -180 -51 -390 -206 -192 -141 -289 -176 -429 -156 -43 6 -143 30 -221 52 -243 69 -343 76 -428 33 -57 -29 -120 -102 -134 -154 -35 -128 37 -287 179 -390 194 -143 257 -193 350 -283 57 -55 149 -156 204 -225 125 -156 139 -173 304 -347 l135 -143 1177 0 1178 0 159 163 c88 89 221 239 297 334 165 206 277 313 457 437 150 103 216 172 251 265 58 157 19 276 -113 340 -124 60 -223 57 -402 -13 -188 -74 -313 -91 -430 -61 -76 20 -119 47 -250 154 -181 149 -314 205 -491 206 -153 0 -231 -35 -400 -181 -93 -80 -166 -134 -213 -158 -32 -16 -34 -16 -70 5 -96 58 -191 127 -261 189 -42 37 -95 77 -117 88 -92 47 -229 67 -342 51z"></path><path d="M2624 7203 c-324 -422 -710 -815 -1218 -1243 -501 -422 -846 -852 -1086 -1354 -214 -446 -314 -880 -313 -1356 1 -553 137 -1037 423 -1510 142 -235 290 -419 507 -630 148 -146 207 -196 357 -309 489 -367 1137 -628 1833 -736 606 -95 1314 -83 1933 30 758 139 1401 427 1900 850 105 90 304 293 390 400 163 200 337 500 433 745 193 492 259 1152 171 1715 -81 520 -305 1015 -660 1460 -117 147 -446 474 -614 610 -425 344 -554 458 -831 734 -228 229 -378 394 -524 579 l-80 102 -1277 0 -1277 0 -67 -87z m2120 -1027 c31 -30 50 -121 41 -195 -3 -31 -67 -483 -141 -1004 -74 -522 -134 -960 -134 -973 l0 -24 488 0 c521 0 548 -2 629 -51 103 -63 96 -212 -15 -349 -143 -175 -2213 -2508 -2250 -2535 -128 -94 -202 -50 -202 119 0 63 250 1892 276 2018 l5 27 -503 3 c-432 3 -510 6 -551 20 -144 49 -184 153 -112 294 27 54 114 159 406 489 342 386 784 888 1509 1710 344 390 362 409 425 446 61 35 98 37 129 5z"></path></g></svg></span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#225</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>805</span></div>
                <div class="time-sepen"><span>38 minutes</span></div>
                <div class="coin-earn"><span>560</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#252</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up"><span>30</span></div>
                <div class="time-sepen"><span>318 minutes</span></div>
                <div class="coin-earn"><span>310</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#125</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>-</span></div>
                <div class="time-sepen"><span>81 minutes</span></div>
                <div class="coin-earn"><span>22</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#ALP</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up"><span>47</span></div>
                <div class="time-sepen"><span>47 minutes</span></div>
                <div class="coin-earn"><span>55</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#ALP2</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>42</span></div>
                <div class="time-sepen"><span>21 minutes</span></div>
                <div class="coin-earn"><span>88</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#225</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba<i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" id="IconChangeColor" height="200" width="200"><rect width="256" height="256" fill="none"></rect><path d="M45.1,196a8.1,8.1,0,0,0,10,5.9,273,273,0,0,1,145.7,0,8.1,8.1,0,0,0,10-5.9L236.3,87.7a8,8,0,0,0-11-9.2L174.7,101a8.1,8.1,0,0,1-10.3-3.4L135,44.6a8,8,0,0,0-14,0l-29.4,53A8.1,8.1,0,0,1,81.3,101L30.7,78.5a8,8,0,0,0-11,9.2Z" fill="none" stroke="#ffa900" stroke-linecap="round" stroke-linejoin="round" stroke-width="24" id="mainIconPathAttribute"></path></svg></i></a></span></div>
                <div class="level-up text-center"><span>24</span></div>
                <div class="time-sepen"><span>120 minutes</span></div>
                <div class="coin-earn"><span>390</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#352</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>41</span></div>
                <div class="time-sepen"><span>30 minutes</span></div>
                <div class="coin-earn"><span>500</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#125</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>38</span></div>
                <div class="time-sepen"><span>22 minutes</span></div>
                <div class="coin-earn"><span>520</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#APL</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>40</span></div>
                <div class="time-sepen"><span>38 minutes</span></div>
                <div class="coin-earn"><span>280</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#APL2</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>21</span></div>
                <div class="time-sepen"><span>47 minutes</span></div>
                <div class="coin-earn"><span>320</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#APZ</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>55</span></div>
                <div class="time-sepen"><span>52 minutes</span></div>
                <div class="coin-earn"><span>318</span></div>
            </li>
            <li class="lms-performace-des">
                <div class="sr-no"><span>#225</span></div>
                <div class="score-des">
                    <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure><span><a href="#">jessica alba</a></span></div>
                <div class="level-up text-center"><span>47</span></div>
                <div class="time-sepen"><span>38 minutes</span></div>
                <div class="coin-earn"><span>414</span></div>
            </li>
        </ul>
    </div>
    <div class="panel-subheader">
        <div class="title">
            <h2 class="font-19 font-weight-bold">Pricing</h2>
        </div>
        <ul class="panel-breadcrumbs">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pricing</a></li>
        </ul>
    </div>
    <div class="panel-stats">
        <div class="stats-user">
            <a href="#">
                <img src="/assets/default/img/stats-thumb.png" alt="">
                <span>Welcome back Mathew Anderson</span>
            </a>
        </div>
        <div class="stats-list">
            <ul>
                <li>
                    <div class="list-box">
                        <strong>$2,340</strong>
                        <span>Today's Sales</span>
                    </div>
                </li>
                <li>
                    <div class="list-box">
                        <strong>35%</strong>
                        <span>Overall Performance</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="panel-membership">
        <div class="membership-top">
            <p>
                <span>Your free trial expired in 17 days.</span>
                <a href="#">Upgrade</a>
            </p>
        </div>
        <div class="membership-text">
            <p>Upgrade your plan from a <b>free trial,</b> to 'premium <br /> plan'<a href="#">&#8594;</a></p>
            <a href="#" data-toggle="modal" data-target="#exampleModal">Upgrade Account</a>
        </div>
    </div>
    <div class="panel-popup">
        <div class="popup-text">
            <h3 class="font-19 font-weight-bold">Haven't found an answer to your question
                <span>Connect with us either on discord or email us</span>    
            </h3>
            <div class="popup-controls">
                <a href="#" class="discord-btn">Ask on Discord</a>
                <a href="#" class="submit-btn">
                  Submit Ticket
                  <div class="lms-tooltip">
                    <div class="tooltip-box">
                        <h5 class="font-18 font-weight-bold text-white mb-5">Use basic phrases</h5>
                        <span class="d-block mb-15 text-white">Prove yor proficiency with Legendary</span>
                        <button class="tooltip-btn practice font-14 d-block mb-15 text-center" onclick='window.location.href = ""'>practice +5 XP</button>
                        <button class="tooltip-btn legendary d-block font-14 text-center" onclick='window.location.href = ""'>Legendary +4 XP</button>
                    </div>
                  </div>
                </a>
            </div>
        </div>
    </div>
</section>
<div class="modal fade lms-choose-membership" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="modal-body">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="get" role="tabpanel" aria-labelledby="get-tab">
              <div class="membership-steps-holder">
                <div class="container">
                  <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-30">
                      <h2>Explore the details of your free trial experience.</h2>
                    </div>
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
                                      <path d="M18,8H17V7A5,5,0,0,0,7,7V8H6a2,2,0,0,0-2,2V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V10A2,2,0,0,0,18,8ZM9,7a3,3,0,0,1,6,0V8H9Zm6.71,6.71-4,4a1,1,0,0,1-1.42,0l-2-2a1,1,0,0,1,1.42-1.42L11,15.59l3.29-3.3a1,1,0,0,1,1.42,1.42Z"></path>
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
                                      <path fill-rule="evenodd" d="M6 8a6 6 0 1112 0v2.917c0 .703.228 1.387.65 1.95L20.7 15.6a1.5 1.5 0 01-1.2 2.4h-15a1.5 1.5 0 01-1.2-2.4l2.05-2.733a3.25 3.25 0 00.65-1.95V8zm6 13.5A3.502 3.502 0 018.645 19h6.71A3.502 3.502 0 0112 21.5z"></path>
                                    </g>
                                  </svg>
                                </span>
                              </a>
                            </li>
                            <li>
                              <a href="#">
                                <span class="icon-svg">
                                  <svg height="64px" width="64px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17.837 17.837" xml:space="preserve" fill="#fff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                      <g>
                                        <path d="M16.145,2.571c-0.272-0.273-0.718-0.273-0.99,0L6.92,10.804l-4.241-4.27 c-0.272-0.274-0.715-0.274-0.989,0L0.204,8.019c-0.272,0.271-0.272,0.717,0,0.99l6.217,6.258c0.272,0.271,0.715,0.271,0.99,0 L17.63,5.047c0.276-0.273,0.276-0.72,0-0.994L16.145,2.571z"></path>
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
                          <a href="#" class="nav-link mt-20 btn-primary rounded-pill" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> Start your 7-day free trial </a>
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
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-10">
                      <h2 class="font-22">Student's details</h2>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mx-auto">
                      <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <span class="fomr-label">Student's first name</span>
                                <div class="input-field">
                                    <input type="text" placeholder="Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <span class="fomr-label">Student's last name</span>
                                <div class="input-field">
                                    <input type="text" placeholder="Last name">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group mb-20">
                                <span class="fomr-label">Student's date of birth</span>
                                <div class="input-field">
                                    <input class="input-date" type="text" placeholder="DD">
                                    <input class="input-month" type="text" placeholder="MM">
                                    <input class="input-year" type="text" placeholder="YYYY">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <h5>What type of school are they applying for?</h5>
                                <span class="select-sub-label">If you are unsure, please select Independent and Grammar</span>
                                <div class="select-field">
                                    <input type="radio" id="independent" name="school-type">
                                    <label for="independent">Independent</label>
                                </div>
                                <div class="select-field">
                                    <input type="radio" id="grammar" name="school-type">
                                    <label for="grammar">Grammar</label>
                                </div>
                                <div class="select-field">
                                    <input type="radio" id="independent-grammar" name="school-type">
                                    <label for="independent-grammar">Independent and Grammar</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <h5>Students's account details</h5>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <span class="fomr-label">User name</span>
                                <div class="input-field">
                                    <input type="text" placeholder="User name">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <span class="fomr-label">Password</span>
                                <div class="input-field">
                                    <input type="password" placeholder="Create a password">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group mt-30">
                                <div class="btn-field">
                                    <button type="submit" class="nav-link" id="book-tab" data-toggle="tab" data-target="#book" type="button" role="tab" aria-controls="book" aria-selected="true">Create student's profile</button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <a href="#" class="nav-link btn-primary rounded-pill mb-25 text-center" id="book-tab" data-toggle="tab" data-target="#book" type="button" role="tab" aria-controls="book" aria-selected="true"> continue </a>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                            <p class="mb-20">By Clicking on Start Free Trial, I agree to the <a href="#">Terms of Service</a>And <a href="#">Privacy Policy</a>
                            </p>
                            <div class="subscription mb-20">
                            <span>Already have a subscription? <a href="#" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">log in</a>
                            </span>
                        </div> -->
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
                          <figure>
                            <img src="../assets/default/img/book-list1.png" height="192" width="152" alt="#">
                          </figure>
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
                            </a> Upgrade to the Family Premium plan to read the rest of this book and enjoy unlimited access to our entire library.
                          </p>
                          <a href="#" class="nav-link btn-primary rounded-pill mb-25" id="subscribe-tab" data-toggle="tab" data-target="#subscribe" type="button" role="tab" aria-controls="subscribe" aria-selected="false"> Get Rurera </a>
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
                        <div class="d-flex align-items-start text-primary mt-20">
                          <span class="font-36 line-height-1">$20</span>
                        </div>
                        <ul class="mt-20 plan-feature">
                          <li class="mt-10">15 days of subscription</li>
                        </ul>
                        <button type="submit" id="contact-tab" data-toggle="tab" data-target="#contact" role="tab" aria-controls="contact" aria-selected="false" class="btn btn-primary btn-block mt-30 rounded-pill bg-none"> Purchase </button>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-30 pb-30 px-20 mb-30">
                        <span class="badge badge-primary badge-popular px-15 py-5">Popular</span>
                        <div class="d-flex align-items-start text-primary mt-20">
                          <span class="font-36 line-height-1">$100</span>
                        </div>
                        <ul class="mt-20 plan-feature">
                          <li class="mt-10">30 days of subscription</li>
                        </ul>
                        <button type="submit" id="contact-tab" data-toggle="tab" data-target="#contact" role="tab" aria-controls="contact" aria-selected="false" class="btn btn-primary btn-block mt-30 rounded-pill"> Purchase </button>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 price-plan-image">
                      <img src="../assets/default/img/price-plan.png" alt="#" height="270" width="166">
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center bg-dark-green bg-dark-green">
                      <strong>96% of subscribing parents in rurera Family report significant improvement in their child's reading skills.</strong>
                      <div class="subscription mt-20">
                        <span>Already have a subscription? <a href="." id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">log in</a>
                        </span>
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
                      <h2>The Final Step to Reading!</h2>
                      <p>No need to worry! We won't ask for payment until after your 7-day free trial ends.</p>
                    </div>
                    <div class="col-12 col-lg-9 col-md-9 col-sm-12">
                      <div class="book-form mt-30">
                        <div class="row">
                          <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                              <div class="input-field">
                                <input type="text" placeholder="First Name">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                              <div class="input-field">
                                <input type="text" placeholder="Last Name">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <div class="input-field input-card">
                                <span class="icon-svg">
                                  <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                      <g>
                                        <path class="st0" d="M261.031,153.484h-5.375v7.484h5.375c1.25,0,2.266-0.344,3-1.031c0.766-0.688,1.156-1.594,1.156-2.719 c0-1.109-0.391-2-1.156-2.703C263.297,153.828,262.281,153.484,261.031,153.484z"></path>
                                        <path class="st0" d="M140.75,169.141c0.141-0.391,0.281-0.891,0.344-1.453c0.094-0.578,0.141-1.266,0.172-2.078 c0.031-0.797,0.031-1.766,0.031-2.891c0-1.109,0-2.063-0.031-2.875s-0.078-1.5-0.172-2.078c-0.063-0.578-0.203-1.047-0.344-1.453 c-0.156-0.406-0.375-0.75-0.641-1.078c-0.953-1.172-2.359-1.75-4.266-1.75H131.5v18.484h4.344c1.906,0,3.313-0.594,4.266-1.75 C140.375,169.891,140.594,169.531,140.75,169.141z"></path>
                                        <path class="st0" d="M88.219,159.938c0.75-0.688,1.141-1.594,1.141-2.719c0-1.109-0.391-2-1.141-2.703 c-0.75-0.688-1.75-1.031-3.016-1.031h-5.375v7.484h5.375C86.469,160.969,87.469,160.625,88.219,159.938z"></path>
                                        <polygon class="st0" points="229.875,167.219 237.141,167.219 233.563,156.906 "></polygon>
                                        <path class="st0" d="M466.656,88H45.344C20.313,88,0,108.313,0,133.344v245.313C0,403.688,20.313,424,45.344,424h421.313 C491.688,424,512,403.688,512,378.656V133.344C512,108.313,491.688,88,466.656,88z M435.656,138.313 c12.344,0,22.344,10,22.344,22.344S448,183,435.656,183s-22.344-10-22.344-22.344S423.313,138.313,435.656,138.313z M375.875,138.313c12.344,0,22.344,10,22.344,22.344S388.219,183,375.875,183s-22.344-10-22.344-22.344 S363.531,138.313,375.875,138.313z M276.781,148.531h10.547c2,0,3.703,0.344,5.141,1c1.406,0.672,2.625,1.719,3.688,3.156 c0.438,0.609,0.781,1.25,1.031,1.938c0.266,0.672,0.469,1.406,0.563,2.219s0.188,1.703,0.203,2.672 c0.031,0.969,0.047,2.047,0.047,3.203c0,1.172-0.016,2.25-0.047,3.219c-0.016,0.969-0.109,1.844-0.203,2.656 s-0.297,1.563-0.563,2.234c-0.25,0.672-0.594,1.328-1.031,1.938c-1.063,1.422-2.281,2.484-3.688,3.141 c-1.438,0.672-3.141,1-5.141,1h-10.547V148.531z M197.391,159.063c0.047-1.094,0.156-2.094,0.328-3.016 c0.188-0.922,0.469-1.766,0.859-2.516c0.406-0.781,0.969-1.531,1.703-2.25c1.016-0.938,2.156-1.688,3.406-2.203 c1.266-0.516,2.75-0.766,4.438-0.766c2.734,0,5.063,0.75,7,2.25s3.156,3.719,3.703,6.703H213c-0.281-1.172-0.813-2.141-1.594-2.891 s-1.875-1.125-3.281-1.125c-0.781,0-1.5,0.125-2.109,0.391c-0.625,0.266-1.125,0.625-1.547,1.078c-0.281,0.281-0.5,0.625-0.672,1 s-0.328,0.844-0.438,1.438c-0.109,0.578-0.203,1.313-0.234,2.203c-0.063,0.891-0.094,2.016-0.094,3.359 c0,1.359,0.031,2.484,0.094,3.375c0.031,0.891,0.125,1.625,0.234,2.219c0.109,0.563,0.266,1.063,0.438,1.422 c0.172,0.375,0.391,0.703,0.672,1c0.422,0.453,0.922,0.797,1.547,1.078c0.609,0.25,1.328,0.391,2.109,0.391 c1.406,0,2.531-0.375,3.297-1.141c0.797-0.75,1.328-1.719,1.625-2.875h5.781c-0.547,2.969-1.766,5.203-3.703,6.703 c-1.938,1.516-4.266,2.266-7,2.266c-1.688,0-3.172-0.281-4.438-0.781c-1.25-0.531-2.391-1.266-3.406-2.219 c-0.734-0.719-1.297-1.469-1.703-2.219c-0.391-0.781-0.672-1.625-0.859-2.531c-0.172-0.922-0.281-1.938-0.328-3.016 c-0.031-1.094-0.063-2.313-0.063-3.672C197.328,161.375,197.359,160.156,197.391,159.063z M163.172,148.531h20.969v4.953h-7.625 v23.422h-5.703v-23.422h-7.641V148.531z M152.844,148.531h5.688v28.375h-5.688V148.531z M125.797,148.531h10.547 c2,0,3.688,0.344,5.125,1c1.422,0.672,2.656,1.719,3.688,3.156c0.438,0.609,0.781,1.25,1.047,1.938 c0.266,0.672,0.453,1.406,0.563,2.219s0.172,1.703,0.203,2.672s0.031,2.047,0.031,3.203c0,1.172,0,2.25-0.031,3.219 s-0.094,1.844-0.203,2.656s-0.297,1.563-0.563,2.234s-0.609,1.328-1.047,1.938c-1.031,1.422-2.266,2.484-3.688,3.141 c-1.438,0.672-3.125,1-5.125,1h-10.547V148.531z M100.969,148.531h19.219v4.953h-13.531v6.641h11.531v4.953h-11.531v6.891h13.531 v4.938h-19.219V148.531z M74.125,148.531h11.453c1.484,0,2.797,0.25,3.969,0.703c1.172,0.469,2.172,1.094,3,1.875 s1.453,1.703,1.859,2.75c0.438,1.047,0.656,2.172,0.656,3.359c0,1.016-0.156,1.922-0.438,2.719c-0.297,0.797-0.688,1.5-1.156,2.125 c-0.5,0.625-1.063,1.156-1.719,1.594c-0.641,0.438-1.313,0.781-2.031,1.016l6.531,12.234h-6.625l-5.688-11.313h-4.109v11.313 h-5.703V148.531z M60.344,285.75v-21.875h33.25v21.875H60.344z M93.594,292.75v23.625H75.219c-8.219,0-14.875-6.656-14.875-14.875 v-8.75H93.594z M60.344,256.875V235h33.25v21.875H60.344z M60.344,228v-8.75c0-8.219,6.656-14.875,14.875-14.875h18.375V228H60.344 z M47.688,162.719c0-1.344,0.031-2.563,0.063-3.656c0.047-1.094,0.156-2.094,0.344-3.016c0.172-0.922,0.469-1.766,0.844-2.516 c0.406-0.781,0.969-1.531,1.719-2.25c1-0.938,2.125-1.688,3.406-2.203c1.25-0.516,2.734-0.766,4.422-0.766 c2.734,0,5.078,0.75,7.016,2.25c1.922,1.5,3.141,3.719,3.688,6.703h-5.813c-0.297-1.172-0.828-2.141-1.594-2.891 c-0.781-0.75-1.875-1.125-3.297-1.125c-0.797,0-1.484,0.125-2.109,0.391s-1.125,0.625-1.531,1.078c-0.281,0.281-0.5,0.625-0.688,1 c-0.172,0.375-0.313,0.844-0.438,1.438c-0.109,0.578-0.188,1.313-0.234,2.203s-0.078,2.016-0.078,3.359 c0,1.359,0.031,2.484,0.078,3.375s0.125,1.625,0.234,2.219c0.125,0.563,0.266,1.063,0.438,1.422c0.188,0.375,0.406,0.703,0.688,1 c0.406,0.453,0.906,0.797,1.531,1.078c0.625,0.25,1.313,0.391,2.109,0.391c1.422,0,2.531-0.375,3.297-1.141 c0.797-0.75,1.328-1.719,1.625-2.875h5.781c-0.547,2.969-1.766,5.203-3.688,6.703c-1.938,1.516-4.281,2.266-7.016,2.266 c-1.688,0-3.172-0.281-4.422-0.781c-1.281-0.531-2.406-1.266-3.406-2.219c-0.75-0.719-1.313-1.469-1.719-2.219 c-0.375-0.781-0.672-1.625-0.844-2.531c-0.188-0.922-0.297-1.938-0.344-3.016C47.719,165.297,47.688,164.078,47.688,162.719z M128,370.656H48v-16h80V370.656z M132.094,228v7v9.031v0.594v12.25v7v9.625v5.531v6.719v7v13.406v10.219h-31.5v-10.219V292.75v-7 v-6.719V273.5v-9.625v-7v-12.25v-0.594V235v-7v-7.594v-16.031h18.375h13.125h5.25h16.625h3.484c8.219,0,14.891,6.656,14.891,14.875 V228h-18.375h-16.625H132.094z M139.094,256.875V235h33.25v21.875H139.094z M172.344,263.875v21.875h-33.25v-21.875H172.344z M139.094,316.375V292.75h33.25v8.75c0,8.219-6.672,14.875-14.891,14.875H139.094z M240,370.656h-80v-16h80V370.656z M240.375,176.906l-1.719-5.016h-10.375l-1.781,5.016h-5.938l10.625-28.375h4.469l10.688,28.375H240.375z M259.75,165.594h-4.094 v11.313h-5.703v-28.375h11.453c1.469,0,2.797,0.25,3.969,0.703c1.172,0.469,2.172,1.094,3,1.875 c0.813,0.781,1.438,1.703,1.859,2.75c0.438,1.047,0.641,2.172,0.641,3.359c0,1.016-0.141,1.922-0.438,2.719 c-0.281,0.797-0.672,1.5-1.156,2.125c-0.5,0.625-1.063,1.156-1.703,1.594s-1.328,0.781-2.047,1.016l6.531,12.234h-6.609 L259.75,165.594z M352,370.656h-80v-16h80V370.656z M464,370.656h-80v-16h80V370.656z M464,322.656H304v-16h160V322.656z"></path>
                                        <path class="st0" d="M291.75,169.141c0.125-0.391,0.266-0.891,0.344-1.453c0.078-0.578,0.125-1.266,0.156-2.078 c0.031-0.797,0.031-1.766,0.031-2.891c0-1.109,0-2.063-0.031-2.875s-0.078-1.5-0.156-2.078s-0.219-1.047-0.344-1.453 c-0.156-0.406-0.375-0.75-0.656-1.078c-0.938-1.172-2.375-1.75-4.266-1.75h-4.344v18.484h4.344c1.891,0,3.328-0.594,4.266-1.75 C291.375,169.891,291.594,169.531,291.75,169.141z"></path>
                                      </g>
                                    </g>
                                  </svg>
                                </span>
                                <input type="text" placeholder="Card Number">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                            <p class="mb-25"> Once your 7-day free trial is over, we will automatically charge your chosen payment method $19.99 every month until you decide to cancel. You have the freedom to cancel at any time. Keep in mind that there may be sales tax added. For instructions on how to cancel, please refer to the provided guidelines </p>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                            <a href="#" class="nav-link btn-primary rounded-pill mb-25" id="get-tab" data-toggle="tab" data-target="#get" type="button" role="tab" aria-controls="get" aria-selected="false">Sart Free Trial</a>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                            <p class="mb-20">By Clicking on Start Free Trial, I agree to the <a href="#">Terms of Service</a>And <a href="#">Privacy Policy</a>
                            </p>
                            <div class="subscription mb-20">
                              <span>Already have a subscription? <a href="#">log in</a>
                              </span>
                            </div>
                            <div class="secure-server">
                              <figure>
                                <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="lock-check" class="icon glyph">
                                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                  <g id="SVGRepo_iconCarrier">
                                    <path d="M18,8H17V7A5,5,0,0,0,7,7V8H6a2,2,0,0,0-2,2V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V10A2,2,0,0,0,18,8ZM9,7a3,3,0,0,1,6,0V8H9Zm6.71,6.71-4,4a1,1,0,0,1-1.42,0l-2-2a1,1,0,0,1,1.42-1.42L11,15.59l3.29-3.3a1,1,0,0,1,1.42,1.42Z"></path>
                                  </g>
                                </svg>
                              </figure>
                              <span> Secure Server <br> SSL Encrypted </span>
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
@endsection

@push('scripts_bottom')

@endpush
