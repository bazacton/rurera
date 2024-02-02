@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343;
    }

    .hide {
        display: none;
    }
</style>
@endpush

@section('content')
<section class="">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
        <h1 class="section-title">Change Password</h1>
        <br><br><br>
    </div>
</section>

<section class="dashboard">

    <div class="db-form-tabs">
        <div class="db-billing">
                <div class="row">

                    <div class="col-12 col-lg-12 col-md-12">
                        <form action="/panel/setting/update-user-password" method="post" class="w-100">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title fw-normal">Change your password</h5>
                                    <p class="text-muted">We will email you a confirmation when changing your
                                        password,
                                        so please expect that email after submitting.</p>
                                    <button class="btn btn-warning">Forgot your password?</button>
                                </div>
                                <div class="card-footer">

                                    <div class="row justify-content-between">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Current password</label>
                                                <input type="password" name="old_password" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New password</label>
                                                <input type="password" name="new_password" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Confirm password</label>
                                                <input type="password" name="new_re_password" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Password</button>
                                            <button type="button" class="btn btn-link">Cancel</button>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="bg-body border dashed p-3 mt-20">
                                                <h6 class="mb-2">Password requirements</h6>
                                                <p class="text-muted mb-2">To create a new password, you have to
                                                    meet
                                                    all of the following requirements:</p>
                                                <!--[ List group ]-->
                                                <ul class="small text-muted lh-lg mb-0">
                                                    <li>Minimum 8 character</li>
                                                    <li>At least one special character</li>
                                                    <li>At least one number</li>
                                                    <li>Can’t be the same as a previous password</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>



</section>










@endsection

@push('scripts_bottom')

@endpush

@if(!empty($giftModal))
@push('scripts_bottom2')
<script>
    (function () {
        "use strict";

        handleLimitedAccountModal('{!! $giftModal !!}', 40)
    })(jQuery)
</script>

@endpush
@endif
