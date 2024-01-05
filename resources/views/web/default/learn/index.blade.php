@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
<section class="content-section">

    <div class="categories-element-title">
        <h2 class="font-40"><span>{{$categoryObj->category->getTitleAttribute()}} - {{$categoryObj->getTitleAttribute()}}</span></h2>
        <p>{{$categoryObj->category->getTitleAttribute()}} courses - Comprehensive list of courses for Children Aged 5, 6 and 7.</p>
    </div>

    <div class="col-12 col-lg-12">
        <div class="categories-boxes row">

            @if( !empty( $courses_list ) )
                @foreach( $courses_list as $courseObj)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="categories-card">
                            <a href="/{{$categoryObj->slug}}/{{$courseObj->slug}}">
                            <div class="categories-icon" style="background:{{$courseObj->background_color}}">
                                {!! $courseObj->icon_code !!}
                            </div>
                            <h4 class="categories-title">{{$courseObj->getTitleAttribute()}}</h4>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</section>
@endsection

@push('scripts_bottom')

@endpush
