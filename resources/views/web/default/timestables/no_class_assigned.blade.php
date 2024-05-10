<style>
    .hide{display:none;}
    .above_12{display:none;}
</style>
@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<div class="timestables-mode-block">

<div class="timestables-mode-content">
<section class="mb-30 school-zone-data my-class-data">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="school-zone-students row">

                    <h2>Class is not assigned</h2>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
@endsection

@push('scripts_bottom')

@endpush