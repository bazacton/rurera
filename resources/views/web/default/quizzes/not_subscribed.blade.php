@extends('web.default.layouts.appstart',['appFooter' => false, 'appHeader' => false])
@php
$rand_id = rand(99,9999);
@endphp
@push('styles_top')
<link rel="stylesheet" href="/assets/default/learning_page/styles.css?var={{$rand_id}}"/>
<link rel="stylesheet" href="/assets/default/css/panel.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
<style>
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate{display:none !important;}
</style>
@endpush

@section('content')

<div class="learning-page">


    <div class="d-flex position-relative">


        <div class="learning-page-content flex-grow-1 bg-info-light p-15">
            <div class="learning-content" id="learningPageContent">
                <div class="learning-title">
                    <h3 class="mb-5"></h3>
                    <span class="font-12 font-weight-400 text-gray">Go to the quiz page for more information</span>
                </div>
                <div class="d-flex align-items-center justify-content-center w-100">



                    <div class="learning-content-box d-flex align-items-center justify-content-center flex-column p-15 p-lg-30 rounded-lg">
                        <div class="learning-content-box-icon">
                            <img src="/assets/default/img/learning/quiz.svg" alt="downloadable icon">
                        </div>

                        <p>You are not subscribed for this</p>

                        <a href="/panel" class="btn btn-primary btn-sm mt-15">Return to Dashboard</a>
                        <div class="learning-content-quiz"></div>

                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/video/youtube.min.js"></script>
<script src="/assets/default/vendors/video/vimeo.js"></script>


<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs"
        data-app-key="v5gxvm7qj1ku9la"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
<script src="/assets/learning_page/scripts.min.js?var={{$rand_id}}"></script>


@endpush
