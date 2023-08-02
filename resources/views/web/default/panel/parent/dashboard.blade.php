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
            <button type="button" class="add-child btn btn-sm btn-border-white" data-toggle="modal"
                    data-target="#addChildModal">Add Child
            </button>
            <div class="bg-white noticeboard rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                <h3 class="font-16 text-dark-blue font-weight-bold">Childs</h3>


                @if( !empty( $childs ) )
                    @foreach($childs as $childObj)
                    <div class="noticeboard-item py-15">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="js-noticeboard-title font-weight-500 text-secondary">{{$childObj->full_name}}</h4>
                                <div class="font-12 text-gray mt-5">
                                    <span class="mr-5">{{$childObj->email}}</span>
                                    |
                                    <span class="js-noticeboard-time ml-5">{{ dateTimeFormat($childObj->created_at,'j M Y | H:i') }}</span>
                                </div>
                            </div>

                            <div>
                                <button type="button" data-child="{{$childObj->id}}" class="js-switch-user btn btn-sm btn-border-white">Switch
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>

        </div>

    </div>
</section>

<div class="modal fade" id="addChildModal" tabindex="-1" aria-labelledby="addChildModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            <div class="modal-body">

                <form method="Post" action="panel/parent/create_student" class="create_student_form mt-35">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="input-label" for="full_name">Full Name:</label>
                        <input name="full_name" type="text" class="form-control rurera-req-field" id="full_name">
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="email">Email :</label>
                        <input name="email" type="text" class="form-control rurera-req-field rurera-email-field"
                               id="email">
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="password">Password :</label>
                        <input name="password" type="password" class="form-control rurera-req-field" id="password">
                    </div>


                    <button type="submit" class="btn btn-primary btn-block mt-20 submit-button">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>

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
