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
            <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-30"><h1>Parent or guardian details</h1>
            <p>Please  set up your account</p></div>
            <div class="bg-white panel-border p-25 rounded-sm mt-30 mx-auto w-80">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mx-auto row">
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <a onclick="openPopup()" return false;" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center">
                                <img src="/assets/default/img/auth/google.svg" class="mr-auto" alt=" google svg">
                                <span class="flex-grow-1">Signup with Google account</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <a href="/facebook/redirect" target="_blank" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center ">
                                <img src="/assets/default/img/auth/facebook.svg" class="mr-auto" alt="facebook svg">
                                <span class="flex-grow-1">Signup with Facebook account</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <div class="form-separator"><span>or</span></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
						<span class="form-label">First Name</span>
                        <div class="form-group">
                            <div class="input-field"><input type="text" name="first_name" disabled class="rurera-req-field" placeholder="First Name"/></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
						<span class="form-label">Last Name</span>
                        <div class="form-group">
                            <div class="input-field"><input type="text" name="last_name" disabled class="rurera-req-field" placeholder="Last Name"/></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
						<span class="form-label">Email Address</span>
                        <div class="form-group">
                            <div class="input-field"><input type="text" autocomplete="new-password" name="email" disabled class="rurera-req-field rurera-email-field" placeholder="Email Address"/></div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
						<span class="form-label">Password</span>
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
                        <div class="subscription mb-20">
                            <span>Already have an Account? <a href="/login" id="contact-tab">log in</a></span>
                        </div>
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
$(document).on('click', 'body, .form-group', function (e) {
    $(".rurera-req-field").removeAttr('disabled');
});
$( window ).on( "load", function() {
    $(".rurera-req-field").removeAttr('disabled');
    $('body').click();
});


var popup;

function openPopup() {
    popup = window.open('/google', 'popup', 'location=0,width=750,height=650,left=500,top=55');
}

function handlePopupResponse(response) {
    if( response == 'google-login'){
        window.location.href = '/parent/students';
    }else {
        Swal.fire({
            icon: 'error',
            html: '<h3 class="font-20 text-center text-dark-blue py-25">' + response + '</h3>',
            showConfirmButton: false,
            width: '25rem'
        });
    }
}

// Listen for messages from the popup
window.addEventListener('message', function(event) {
    // Ensure that the message is from the popup and from the same origin
    if (event.source === popup && event.origin === window.location.origin) {
        handlePopupResponse(event.data);
    }
});
</script>