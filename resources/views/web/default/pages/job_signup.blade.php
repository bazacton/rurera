@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="position-relative text-center job-singup-sub-header">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-12 col-md-9 col-lg-7">
                <h1 class="font-30 font-weight-bold">{{ $page->title }}</h1>
                <p>Maximize Your Earnings ,Strategies to Help You Reach Your Full Potential.</p>
                <a href="#" class="btn-primary">Lets Start Your Journey</a>
            </div>
        </div>
    </div>
</section>
{!! nl2br($page->content) !!}
                @endsection

                @push('scripts_bottom')
                <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
                @endpush
