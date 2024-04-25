<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343 !important;
    }
</style>
<div class="form-login-reading">
    <div class="container">
        <form class="signup-form" method="post" action="/signup-submit" autoComplete='off'>
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-30"><h2>Start Reading Today</h2></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 mx-auto row">
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <a href="/google" target="_blank" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center">
                                <img src="/assets/default/img/auth/google.svg" class="mr-auto" alt=" google svg">
                                <span class="flex-grow-1">Login with Google account</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <a href="/facebook/redirect" target="_blank" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center ">
                                <img src="/assets/default/img/auth/facebook.svg" class="mr-auto" alt="facebook svg">
                                <span class="flex-grow-1">Login with Facebook account</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">

                            <div class="input-field"><input type="text" name="first_name" disabled class="rurera-req-field" placeholder="First Name"/></div>
                        </div>
                        <div class="form-group">
                            <div class="input-field"><input type="text" name="last_name" disabled class="rurera-req-field" placeholder="Last Name"/></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <div class="input-field"><input type="text" autocomplete="new-password" name="email" disabled class="rurera-req-field" placeholder="Email Address"/></div>
                        </div>
                        <div class="form-group">
                            <div class="input-field mb-15"><input type="password" name="password" disabled placeholder="password" class="rurera-req-field password-field"/></div>
                            <button id="generateBtn" class="rurera-hide">Generate Password</button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <a href="javascript:;" class="nav-link btn-primary rounded-pill mb-25 text-center signup-btn-submit">
                                continue
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                        <p class="mb-20">By Clicking on Start Free Trial, I agree to the<a href="#">Terms of Service</a>And<a href="#">Privacy Policy</a></p>
                        <div class="subscription mb-20">
                            <span>Already have a subscription?<a href="#" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact"
                                                                 aria-selected="false">log in</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/assets/default/js/question-layout.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script>
$(document).on('click', 'body', function (e) {
    $(".rurera-req-field").removeAttr('disabled');
});
$( window ).on( "load", function() {
    $('body').click();
});
</script>