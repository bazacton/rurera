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

<div class="learning-page type-{{$quiz->quiz_type}}">


    <div class="d-flex position-relative">


        <div class="learning-page-content flex-grow-1 bg-info-light p-15">
            <div class="learning-content" id="learningPageContent">

                <div class="d-flex align-items-center justify-content-center w-100 h-100">

                    <div class="learning-content-box d-flex align-items-center justify-content-center flex-column p-15 p-lg-30 rounded-lg">

                        <a href="javascript:;" data-id="{{$quiz->id}}" id="quiz-start-btn" data-quiz_url="/panel/quizzes/{{$quiz->id}}/start"
                           class="quiz-start-btn ">&nbsp;</a>
                        <div class="learning-content-quiz"></div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/learning_page/scripts.min.js?var={{$rand_id}}"></script>

<script>
    $(document).ready(function () {
        $("#quiz-start-btn").trigger("click");
    });
</script>
@endpush
