@extends(getTemplate().'.layouts.app')
<style>
    body{background-color: #fafafa !important;}
</style>
@section('content')
    <div class="container">
        <div class="text-center mb-30 mt-50"><a href="/"><img src="/store/1/logo.png"></a></div>
        @if(!empty(session()->has('msg')))
            <div class="alert alert-info alert-dismissible fade show mt-30" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row login-container">
            <div class="col-12 rurera-login-opt-block">

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
                                <a href="javascript:;" class="rurera-login-opt social-login" data-login_type="login-with-smartbadge">
                                    <img src="/store/1/default_images/qr-code.png" alt="login">
                                    <span>Login with Smart Badge</span>
                                </a>

                                <a href="javascript:;" class="rurera-login-opt social-login" data-login_type="login-with-emoji">
                                    <img src="/store/1/default_images/emoji.png" alt="login">
                                    <span>Login with Emoji</span>
                                </a>
                                
                                <a href="javascript:;" class="rurera-login-opt social-login" data-login_type="login-with-pin">
                                    <img src="/store/1/default_images/password_field.svg" alt="#">
                                    <span>Login with 6 - digit Pin</span>
                                </a>
                                <a href="javascript:;" class="rurera-login-opt social-login">
                                    <img src="/store/1/default_images/Wonde-Logo.svg" alt="#"> <span class="coming-soon">Coming Soon</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 login-opt-type rurera-hide login-with-smartbadge">
                <div class="login-holder">
                    <a href="javascript:;" class="login-back-btn">Back</a>
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

            <div class="col-12 login-opt-type rurera-hide login-with-pin">
                <div class="login-holder">
                    <a href="javascript:;" class="login-back-btn">Back</a>
                    <div class="col-12">
                        <div class="login-password">
                            <form>
                                <div class="form-group">
                                    <label class="input-label" for="username">Please enter your password</label>
                                    <input type="password" class="login_pin" value="" style="border: 1px solid;width: 300px;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 login-opt-type rurera-hide login-with-emoji">
                <div class="login-holder">
                    <a href="javascript:;" class="login-back-btn">Back</a>
                    <div class="col-12">
                        <div class="login-password">
                            <form>
                                <div class="form-group">
                                    <label class="input-label" for="username">Please enter your password</label>
                                    <div class="emoji-passwords">
                                        <span class="is_empty active"></span>
                                        <span class="is_empty"></span>
                                        <span class="is_empty"></span>
                                        <span class="is_empty"></span>
                                        <span class="is_empty"></span>
                                        <span class="is_empty"></span>
                                    </div>
                                    <input class="rurera-hide emoji-password-field" type="password" value="">
                                </div>
                            </form>
                            <div class="emoji-icons">
                                @if( !empty( emojisList() ))
                                    @foreach(emojisList() as $emojiRow)
                                        <a id="{{$emojiRow}}" href="javascript:;" class="emoji-icon">
                                            <img src="/assets/default/svgs/emojis/{{$emojiRow}}.svg" alt="{{$emojiRow}}">
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
<script>

    $(document).on('click', '.login-back-btn', function (e) {
        $(".login-opt-type").addClass('rurera-hide');
        $(".rurera-login-opt-block").removeClass('rurera-hide')
    });

    $(document).on('click', '.rurera-login-opt', function (e) {
        $(".rurera-login-opt-block").addClass('rurera-hide');
        $(".login-opt-type").addClass('rurera-hide');
        var login_type = $(this).attr('data-login_type');
        $("."+login_type).removeClass('rurera-hide');

    });

    $(document).on('keyup', '.login_pin', function (e) {

        var thisObj = $(this);
        var login_pin = $(this).val();
        var total_pin_count = $(this).val().length;
        if(total_pin_count == 6){
            rurera_loader($(".login-with-pin"), 'div');
            jQuery.ajax({
               type: "POST",
               url: '/login_pin',
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: {'login_pin':login_pin},
               success: function (return_data) {
                   if( return_data == 'loggedin'){
                       window.location.href = '/panel';
                   }else{
                       thisObj.val('');
                       rurera_remove_loader($(".login-with-pin"), 'div');
                       Swal.fire({
                           icon: 'error',
                           html: '<h3 class="font-20 text-center text-dark-blue py-25">Incorrect Pin</h3>',
                           showConfirmButton: !1
                       });
                   }
               }
           });
        }
    });





    $(document).on('dblclick', '.emoji-passwords span', function (e) {
        $(this).attr('data-emoji_id','');
        $(this).html('');
        $(this).addClass('is_empty');
        $(".emoji-passwords span").removeClass('active');
        $(this).addClass('active');
        $(this).nextAll('span').html('');
        $(this).nextAll('span').addClass('is_empty');
        $(this).nextAll('span').attr('data-emoji_id','');
        var password_field_value = '';
        $(".emoji-passwords span").each(function () {
            password_field_value += $(this).attr('data-emoji_id');
        });
        $(".emoji-password-field").val(password_field_value);
    });

    $(document).on('click', '.emoji-icon', function (e) {
        var current_pass = $(".emoji-passwords span.active");
        var current_val = $(this).attr('id');
        var password_value = $(".emoji-password-field").val();
        $(".emoji-password-field").val(password_value+current_val);
        current_pass.removeClass('is_empty');
        current_pass.html($(this).html());
        current_pass.attr('data-emoji_id', current_val);
        current_pass.removeClass('active');
        current_pass.next('span').addClass('active');
        if( current_pass.next('span').length == 0){
            rurera_loader($(".login-with-emoji"), 'div');
            var login_emoji = $(".emoji-password-field").val();

            jQuery.ajax({
               type: "POST",
               url: '/login_emoji',
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: {'login_emoji':login_emoji},
               success: function (return_data) {
                   if( return_data == 'loggedin'){
                       window.location.href = '/panel';
                   }else{
                       $(".emoji-password-field").val('');
                       $(".emoji-passwords span").addClass('is_empty');
                       $(".emoji-passwords span:first").addClass('active');
                       $(".emoji-passwords span").html('');
                       rurera_remove_loader($(".login-with-emoji"), 'div');
                       Swal.fire({
                           icon: 'error',
                           html: '<h3 class="font-20 text-center text-dark-blue py-25">Incorrect Emojis</h3>',
                           showConfirmButton: !1
                       });
                   }
               }
           });

        }

    });

</script>
@endpush