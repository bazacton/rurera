@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343;
    }
</style>
@endpush

@section('content')
<section class="">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
        <h1 class="section-title">{{ trans('panel.dashboard') }}</h1>
    </div>
</section>

<section class="dashboard">

    <div class="row">
        <div class="col-12 col-lg-12 mt-35">
            <div class="bg-white noticeboard rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                <h3 class="font-16 text-dark-blue font-weight-bold">Edit Child</h3>


                <form method="Post" action="/panel/parent/update_child/{{$userData->id}}" class="create_student_form mt-35">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="input-label" for="full_name">Full Name:</label>
                        <input name="full_name" type="text" class="form-control rurera-req-field" value="{{$userData->get_full_name()}}" id="full_name">
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="email">Email :</label>
                        <input name="email" type="text" class="form-control rurera-req-field rurera-email-field" value="{{$userData->email}}" id="email">
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="password">New Password :</label>
                        <input name="password" type="password" class="form-control rurera-req-field" id="password">
                    </div>


                    <button type="submit" class="btn btn-primary btn-block mt-20 submit-button">Submit</button>
                </form>

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
