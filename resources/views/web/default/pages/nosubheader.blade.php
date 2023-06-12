@extends(getTemplate().'.layouts.app')

@push('styles_top')
@if($page->id == 11 || $page->id == 50 || $page->id == 15 || $page->id == 72)
        <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endif
@endpush

@section('content')
<section class="content-section">
    {!! nl2br($page->content) !!}
</section>

@endsection

@push('scripts_bottom')
@if($page->id == 11 || $page->id == 50 || $page->id == 15) || $page->id == 72)
                        <script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
                        <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
                    @endif
@if($page->id == 44)
                        <script src="/assets/default/vendors/draw-lines/draw-lines.js"></script>
                    @endif
@if($page->id == 16)
                        <script src="/assets/default/js/parts/counter.js"></script>
                    @endif
@endpush
