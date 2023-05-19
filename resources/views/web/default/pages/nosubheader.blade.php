@extends(getTemplate().'.layouts.app')

@push('styles_top')
@endpush

@section('content')
<section class="content-section">
    {!! nl2br($page->content) !!}
</section>

@endsection

@push('scripts_bottom')
@endpush
