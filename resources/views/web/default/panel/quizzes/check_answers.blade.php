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
    .field-holder.wrong, .form-field.wrong, .form-field.wrong label, .field-holder.wrong, .form-field.wrong, .form-field.wrong label, .editor-field.wrong {
        background: #ff4a4a;
        color: #fff !important;
    }
    .editor-field.correct{
        background: #70c17c !important;
    }
    .question-area{min-height:300px !important;}

</style>
@endpush
@section('content')
<div class="content-section">

    <section class="lms-quiz-section">



        <div class="container-fluid questions-data-block read-quiz-content"
             data-total_questions="10">

            <section class="quiz-topbar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <div class="quiz-top-info"><p>Test</p>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                                <div class="topbar-right">
                                    <div class="quiz-pagination">

                                    </div>
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

            <div class="question-area-block" data-questions_layout="{{json_encode($questions_layout)}}">

                @if( !empty( $questions_layout ))
                    @foreach( $questions_layout as $question_layout_template)
                        {!! $question_layout_template !!}
                    @endforeach
                @endif
            </div>

            <div class="question-area-temp hide"></div>

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
<script>
    init_question_functions();
    $('body').addClass('quiz-show');
    var header = document.getElementById("navbar");
    var headerOffset = (header != null) ? header.offsetHeight : 100;
    var header_height = parseInt(headerOffset) + parseInt(85) + "px";


    if(jQuery('.quiz-pagination .swiper-container').length > 0){
              console.log('slides-count');
              console.log($(".quiz-pagination ul li").length);
            const swiper = new Swiper('.quiz-pagination .swiper-container', {
              slidesPerView: ($(".quiz-pagination ul li").length > 20)? 20 : $(".quiz-pagination ul li").length,
              spaceBetween: 0,
              slidesPerGroup: 5,
              navigation: {
                  nextEl: ".swiper-button-next",
                  prevEl: ".swiper-button-prev",
              },
              breakpoints: {
                320: {
                  slidesPerView: 3,
                  spaceBetween: 5
                },

                480: {
                  slidesPerView: ($(".quiz-pagination ul li").length > 20)? 20 : $(".quiz-pagination ul li").length,
                  spaceBetween: 5
                },

                640: {
                  slidesPerView: ($(".quiz-pagination ul li").length > 20)? 20 : $(".quiz-pagination ul li").length,
                  spaceBetween: 5
                }
              }
            })
          }
</script>
@endpush
