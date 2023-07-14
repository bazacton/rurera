@extends(getTemplate().'.layouts.app')

@push('styles_top')
@if($page->id == 11 || $page->id == 50 || $page->id == 15 || $page->id == 72 || $page->id == 94 || $page->id == 96 || $page->id == 115)
        <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endif
@if($page->id == 44)
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
        <link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
        <script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
        <link rel="stylesheet" href="/assets/default/css/quiz-layout.css">

    @endif
@endpush

@section('content')
<section class="content-section">
    {!! nl2br($page->content) !!}
</section>

@endsection

@push('scripts_bottom')
@if($page->id == 11 || $page->id == 50 || $page->id == 15 || $page->id == 72 || $page->id == 39 || $page->id == 94 || $page->id == 96 || $page->id == 115)
                        <script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
                        <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
                    @endif
@if($page->id == 44)
                        <script src="/assets/default/vendors/draw-lines/draw-lines.js"></script>
                    @endif
@if($page->id == 49)
<script src="/assets/default/vendors/data-table/dataTables.min.js"></script>
@endif
@if($page->id == 114)
<script src="/assets/default/vendors/jquery-ui/jquery-ui.min.js"></script>
@endif


@if($page->id == 16)
                        <script src="/assets/default/js/parts/counter.js"></script>
                    @endif
@endpush
