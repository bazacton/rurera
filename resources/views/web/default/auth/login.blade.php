@extends(getTemplate().'.layouts.app')

@section('content')
    <div class="container">
        @if(!empty(session()->has('msg')))
            <div class="alert alert-info alert-dismissible fade show mt-30" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row login-container">
            <div class="col-12">
                <div class="login-holder">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="login-card">
                                <h1 class="font-24 font-weight-bold">{{ trans('auth.login_h1') }}</h1>
                                <form method="Post" action="/login" class="mt-20">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <label class="input-label" for="username">{{ trans('auth.email_or_mobile') }}:</label>
                                        <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                                            value="{{ old('username') }}" aria-describedby="emailHelp">
                                        @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
                                        <input name="password" type="password" class="form-control @error('password')  is-invalid @enderror" id="password" aria-describedby="passwordHelp">

                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block mt-20">{{ trans('auth.login') }}</button>
                                    <!-- <p>By logging in to wonde you confirm you have read and agree <a href="#">terms of <br /> Use</a> and <a href="#">Privacy Notice</a></p>
                                    <a href="#" class="login-next">Next</a> -->
                                    <div class="login-option">
                                        <span>Login with</span>
                                        <a href="https://google.com/" target="_blank" class="social-login">
                                            <img src="/assets/default/img/auth/google.svg" class="mr-auto" alt=" google svg"/>
                                            <!-- <span class="flex-grow-1">{{ trans('auth.google_login') }}</span> -->
                                        </a>
                                        <a href="https://www.facebook.com/" target="_blank" class="social-login">
                                            <img src="/assets/default/img/auth/facebook.svg" class="mr-auto" alt="facebook svg"/>
                                            <!-- <span class="flex-grow-1">{{ trans('auth.facebook_login') }}</span> -->
                                        </a>
                                        <div class="text-center">
                                            <a href="/forget-password" target="_blank">{{ trans('auth.forget_your_password') }}</a>
                                        </div>
                                    </div>
                                    <div class="login-controls">
                                        <div>
                                            <span>{{ trans('auth.dont_have_account') }}</span>
                                            <a href="/register" class="text-secondary font-weight-bold">{{ trans('auth.signup') }}</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="login-options">
                                <!-- <div class="text-center mt-20">
                                    <span class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center">{{ trans('auth.or') }}</span>
                                </div> -->
                                <a href="#" class="social-login">
                                    <img src="/store/1/default_images/qr-code.png" alt="login">
                                    <span>Login with Smart Badge</span>
                                </a>

                                <a href="#" class="social-login">
                                    <img src="/store/1/default_images/emoji.png" alt="login">
                                    <span>Login with Emoji</span>
                                </a>
                                
                                <a href="#" target="_blank" class="social-login">
                                    <img src="/store/1/default_images/password_field.svg" alt="#">
                                    <span>Login with 6 - digit Pin</span>
                                </a>
                                <a href="#" target="_blank" class="social-login">
                                    <img src="/store/1/default_images/Wonde-Logo.svg" alt="#">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="login-holder">
                    <div class="col-12">
                        <div class="login-magic-code">
                            <p>To login with your Magic Code please hold it up to the screen and center the <br /> code inside the square.</p>
                            <div class="error-msg">
                                <span>To login with Magic Code please allow camera access in your browser</span>
                            </div>
                            <div class="qr-code-box">
                                <a href="#">
                                    <img src="/store/1/default_images/permission.png" alt="">
                                    <span>Waiting for camera permission...</span>
                                </a>
                            </div>
                            <div class="login-help-box">
                                <p>Having trouble logging in? Click <a href="#">here</a> to find your school and login with your Emoji <br /> password.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="login-holder">
                    <div class="col-12">
                        <div class="login-password">
                            <form>
                                <div class="form-group">
                                    <label class="input-label" for="username">Please enter your password</label>
                                    <input type="password" value="pass..">
                                </div>
                            </form>
                            <div class="emoji-icons">
                                <a id="icon1" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/adhesive-bandage-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon2" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/bright-button-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon3" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/broccoli-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon4" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/broken-heart-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon5" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/broom-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon6" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/butterfly-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon7" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/cake-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon8" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/carrot-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon9" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/cheese-wedge-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon10" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/cherries-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon11" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/chicken-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon12" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/christmas-tree-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon13" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/cobra-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon14" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/collision-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon15" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/cookie-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon16" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/cooking-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon17" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/croissant-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon18" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/cut-of-meat-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon19" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/dagger-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon20" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/deciduous-tree-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon21" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/desktop-computer-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon22" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/dog-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon23" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/dolphin-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon24" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/doughnut-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon25" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/dress-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon26" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/drum-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon27" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/eight-thirty-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon28" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/elephant-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon29" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/fish-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon30" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/fox-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon31" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/ice-cream-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon32" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/lollipop-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon33" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/mianyang-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon34" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/monkey-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon35" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/soft-drink-svgrepo-com.svg" alt="#">
                                </a>

                                <a id="icon36" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/baby-bottle-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon37" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/baby-chick-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon38" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/banana-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon39" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/bathtub-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon40" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/bat-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon41" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/books-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon42" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/bouquet-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon43" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/broom-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon44" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/flag-in-hole-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon45" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/french-fries-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon46" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/fried-shrimp-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon47" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/globe-showing-europe-africa-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon48" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/hamburger-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon49" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/handshake-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon50" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/honeybee-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon51" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/hot-beverage-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon52" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/hot-dog-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon53" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/hot-pepper-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon54" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/kick-scooter-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon55" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/kiwi-fruit-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon56" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/lady-beetle-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon57" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/light-bulb-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon58" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/meat-on-bone-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon59" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/monkey-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon60" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/motor-scooter-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon61" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/office-worker-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon62" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/old-woman-medium-light-skin-tone-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon63" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/party-popper-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon64" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/person-in-lotus-position-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon65" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/person-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon66" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/pig-face-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon67" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/pizza-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon68" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/popcorn-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon69" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/ring-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon70" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/rose-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon71" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/sauropod-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon72" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/scorpion-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon73" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/steaming-bowl-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon74" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/strawberry-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon75" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/tent-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon76" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/thermometer-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon77" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/world-map-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon78" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/worm-svgrepo-com.svg" alt="#">
                                </a>
                                <a id="icon79" href="#" class="emoji-icon">
                                    <img src="/store/1/default_images/svgs/wrapped-gift-svgrepo-com.svg" alt="#">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
