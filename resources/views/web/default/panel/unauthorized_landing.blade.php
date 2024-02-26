@extends('web.default.panel.layouts.panel_layout')
@php use App\Models\Webinar; @endphp

@push('styles_top')

@endpush

@section('content')

<div class="learning-page">


    <div class="d-flex position-relative">


        <div class="learning-page-content flex-grow-1 bg-info-light p-15 mt-50">
            <div class="learning-content" id="learningPageContent">
                <div class="d-flex align-items-center justify-content-center w-100">



                    <div class="learning-content-box d-flex align-items-center justify-content-center flex-column p-15 p-lg-30 rounded-lg">
                        <div class="learning-content-box-icon">
                            <img src="/assets/default/img/learning/quiz.svg" alt="downloadable icon">
                        </div>

                        <p>{{$unauthorized_text}}</p>

                        <a href="{{$unauthorized_link}}" class="btn btn-primary btn-sm mt-15">Return</a>
                        <div class="learning-content-quiz"></div>

                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')

@endpush
