@extends(getTemplate().'.layouts.app')
@php $rand_no = rand(99,9999); @endphp
@if( isset($_GET['email'] ) && $_GET['email'] == 'true')
    <script>window.opener.postMessage('You already have an account with us. Please <a href="/login">Login</a> to access.', window.location.origin);window.close();</script>
@endif
@push('styles_top')
<style>
    body{background-color: #fafafa !important;}
    .login_pin {
        border: 1px solid #ddd;
        max-width: 50px;
        width: auto;
        display: inline-block;
        margin: 0 5px;
        border-radius: 2px;
        letter-spacing: 1px;
        font-family: auto;
    }

    .login_pin::-webkit-credentials-auto-fill-button {
        visibility: hidden;
        display: none;
    }

    .login_pin:-webkit-autofill {
        -webkit-text-security: disc;
    }
</style>
@endpush
@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-30 mt-50">
            <a href="/" class="login-logo d-inline-flex justify-content-center align-items-center">
                <img src="/assets/default/img/sidebar/logo.svg" class="img-cover" alt="Rurera Logo" title="Rurera Logo" width="68" height="67" itemprop="image" loading="eager">
                <span class="logo-text font-30 font-weight-bold ml-10">Rurera</span>
            </a>
        </div>
        @if(!empty(session()->has('msg')))
            <div class="alert alert-info alert-dismissible fade show mt-30" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row login-container mt-0">
            <div class="col-12 rurera-login-opt-block">

                <div class="login-holder">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="login-card">

                                <h1 class="font-24 font-weight-bold">{{ trans('auth.login_h1') }}</h1>
                                <form method="Post" action="/login" class="mt-20">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <label class="input-label" for="username">Username:</label>
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
                <a href="javascript:;" class="login-back-btn">Back</a>
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

            <div class="col-12 login-opt-type login-with-pin mx-auto rurera-hide">
                <a href="javascript:;" class="login-back-btn">Back</a>
                <div class="login-holder d-flex flex-column justify-content-center align-items-center">
                    <div class="col-12">
                        <div class="login-password">
                            <form class="mb-10">
                                <div class="form-group d-inline-flex align-items-start justify-content-start flex-row flex-wrap">
                                    <label class="input-label" for="username">
                                        Enter Pin Code
                                        <span class="d-block font-16 font-weight-normal pt-5">If your teacher has given you a PIN code to access Rurera Go, enter <br> it in the form below..</span>
                                    </label>
                                    <input type="hidden" class="login_pin_final" value="">
                                    <input type="text" name="pincode" class="login_pin focused_field" autocomplete="pincode" value="" maxlength="1" style="border: 1px solid #ddd;max-width: 50px;width: auto;display: inline-block;margin: 0 5px;border-radius: 2px;letter-spacing: 1px;font-family: auto;">
                                    <input type="text" name="pincode1" class="login_pin" autocomplete="pincode1" value="" maxlength="1" style="border: 1px solid #ddd;max-width: 50px;width: auto;display: inline-block;margin: 0 5px;border-radius: 2px;letter-spacing: 1px;font-family: auto;">
                                    <input type="text" name="pincode2" class="login_pin" autocomplete="pincode2" value="" maxlength="1" style="border: 1px solid #ddd;max-width: 50px;width: auto;display: inline-block;margin: 0 5px;border-radius: 2px;letter-spacing: 1px;font-family: auto;">
                                    <input type="text" name="pincode3" class="login_pin" autocomplete="pincode3" value="" maxlength="1" style="border: 1px solid #ddd;max-width: 50px;width: auto;display: inline-block;margin: 0 5px;border-radius: 2px;letter-spacing: 1px;font-family: auto;">
                                    <input type="text" name="pincode4" class="login_pin" autocomplete="pincode4" value="" maxlength="1" style="border: 1px solid #ddd;max-width: 50px;width: auto;display: inline-block;margin: 0 5px;border-radius: 2px;letter-spacing: 1px;font-family: auto;">
                                    <input type="text" name="pincode5" class="login_pin" autocomplete="pincode5" value="" maxlength="1" style="border: 1px solid #ddd;max-width: 50px;width: auto;display: inline-block;margin: 0 5px;border-radius: 2px;letter-spacing: 1px;font-family: auto;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 login-opt-type rurera-hide login-with-emoji">
                <a href="javascript:;" class="login-back-btn">Back</a>
                <div class="login-holder">
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
                                            <img src="/assets/default/svgs/emojis/{{$emojiRow}}.svg?ver={{$rand_no}}" alt="{{$emojiRow}}">
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
        if(login_type == 'login-with-pin') {
            $(".focused_field").focus();
        }

    });
    var loginSubmitRequest = null;

    $(document).on('keyup change', '.login_pin_final', function (e) {

        var thisObj = $(this);
        var login_pin_final = $(this).val();
        var total_pin_count = $(this).val().length;
        if(total_pin_count == 6){
            rurera_loader($(".login-with-pin"), 'div');
            loginSubmitRequest = jQuery.ajax({
               type: "POST",
               url: '/login_pin',
                beforeSend: function () {
                    if (loginSubmitRequest != null) {
                        loginSubmitRequest.abort();
                    }
                },
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: {'login_pin':login_pin_final},
               success: function (return_data) {
                   if( return_data == 'loggedin'){
                       window.location.href = '/panel';
                   }else{
                       thisObj.val('');
                       rurera_remove_loader($(".login-with-pin"), 'div');
                       $(".login_pin").val('');
                       $(".focused_field").focus();
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

            loginSubmitRequest = jQuery.ajax({
               type: "POST",
               url: '/login_emoji',
                beforeSend: function () {
                    if (loginSubmitRequest != null) {
                        loginSubmitRequest.abort();
                    }
                },
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
                       $(".login_pin").val('');
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
    $(document).on('input keydown paste', ".login_pin", function (event) {
        var keyCode = event.keyCode || event.which;
        if (!((keyCode >= 48 && keyCode <= 57) || // Allow numeric keys
              (keyCode >= 96 && keyCode <= 105) || // Allow numpad keys
              keyCode == 8 || // Allow backspace
              keyCode == 46 || // Allow delete
              (keyCode >= 37 && keyCode <= 40))) { // Allow arrow keys
            event.preventDefault();
        }
        var $this = $(this);
        var value = $this.val();

        if (event.type === 'paste') {
            event.preventDefault(); // Prevent default paste behavior

            // Get the pasted text
            var pastedText = (event.originalEvent || event).clipboardData.getData('text');

            // Split the pasted text into individual characters
            var characters = pastedText.split('');

            // Distribute each character into successive input fields
            characters.forEach(function(char) {
                $this.val(char);
                $this = $this.next('.login_pin');
            });

            // Ensure focus is on the last input field
            $this.focus();
        } else if ((event.type === 'input' || event.type === 'keydown') && value.length === 1) {
            $this.next('.login_pin').focus();
        } else if (event.type === 'keydown' && event.which === 8 && value === "") {
            $this.prev('.login_pin').focus();
        }


        allFilled = true;
        var login_pin_code = '';
        $(".login_pin").each(function(){
            login_pin_code += $(this).val();
            if($(this).val() === ''){
                allFilled = false;
                return false;
            }
        });
        if(allFilled){
            $(".login_pin_final").val(login_pin_code);
            $(".login_pin_final").change();
        }
    });
    function sendResponseToParent() {
            // Access the parent window and post a message
            window.opener.postMessage("Response from popup", window.location.origin);
        }

</script>
@endpush