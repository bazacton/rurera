@php namespace App\Http\Controllers\Web; @endphp
@extends(getTemplate().'.layouts.appstart')
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">


<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
<script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .ui-state-highlight {
        margin: 0px 10px;
    }

    .field-holder.wrong, .form-field.wrong, .form-field.wrong label {
        background: #ff4a4a;
        color: #fff;
    }
    .incorrect{
        background: #ff0202;
        padding: 10px;
        border-radius: 10px;
        color: #fff !important;
    }
    .correct{
        background: #58bd5b;
        padding: 10px;
        border-radius: 10px;
        color: #fff !important;
    }

</style>
@endpush
@section('content')
<div class="content-section">

    <section class="lms-quiz-section">


        <div class="container-fluid questions-data-block read-quiz-content"
             data-total_questions="30">

            <section class="quiz-topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="quiz-top-info"><p>Test</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 col-sm-12 mt-50">
                    <div class="question-step quiz-complete" style="display:none">
                        <div class="question-layout-block">
                            <div class="left-content has-bg">
                                <h2>&nbsp;</h2>
                                <div id="leform-form-1"
                                     class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable"
                                     _data-parent="1"
                                     _data-parent-col="0" style="display: block;">
                                    <div class="question-layout">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="question-area-block">
                        <div class="col-12 col-lg-8 mx-auto">

                            @if( !empty( $results ))
                            @foreach( $results as $table_name => $tableData)
                            @if( !empty( $tableData ) )
                            @foreach( $tableData as $rowObj)
                            @php $is_correct = isset( $rowObj->is_correct )? $rowObj->is_correct : 'false';
                            $check_class = ($is_correct == 'true')? 'correct' : 'incorrect';
                            $check_label = ($is_correct == 'true')? 'Correct' : 'Wrong';
                            @endphp

                            <div class="questions-block active">
                                <form action="javascript:;" class="question-form" method="post">
                                    <div class="questions-status d-flex mb-15">
                                    </div>
                                    <div class="questions-arithmetic-box d-flex align-items-center justify-content-center">
                                        <span>{{$rowObj->from}} <span>x</span> {{$rowObj->to}} <span>=</span></span>
                                        <input type="text" readonly disabled data-from="5" data-type="x"
                                               data-table_no="5" data-to="10"
                                               class="editor-fields" id="editor-fields-0" value="{{$rowObj->answer}}">
                                        <div class="questions-controls">
                                            <span class="{{$check_class}}">{{$check_label}}</span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endforeach
                            @endif

                            @endforeach
                            @endif


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


</div>

@endsection

@push('scripts_bottom')

<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_id}}"></script>

@endpush
