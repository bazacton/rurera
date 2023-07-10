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
                seconds
                <div class="time-count-seconds">0</div>
                mili
                <div class="time-count-mili prevm active">0</div>

                mili 2
                <div class="time-count-mili nextm">0</div>

                <div class="col-12 col-lg-4 mx-auto">
                <div class="questions-block"> <div class="questions-status d-flex mb-20"> <span class="wrong"></span> <span class="successful"></span> <span class="successful"></span> <span class="successful"></span> <span class="successful"></span> <span class="successful"></span> <span class="successful"></span> <span class="successful"></span> <span class="successful"></span> <span></span> </div><div class="questions-arithmetic-box d-flex align-items-center justify-content-center mb-20"> <span>10 <span>÷</span> 10 <span>=</span></span> <input type="text"> </div><div class="questions-block-numbers"> <ul class="d-flex justify-content-center flex-wrap"> <li><span>7</span></li><li><span>8</span></li><li><span>9</span></li><li><span>4</span></li><li><span>5</span></li><li><span>6</span></li><li><span>1</span></li><li><span>2</span></li><li><span>3</span></li><li class="delete"><a href="#">Delete</a></li><li><span>0</span></li><li class="enter"><a href="#">Enter</a></li></ul> </div></div>
                </div>

                @if( is_array( $questions_list ))
                    @php $question_no = 1; @endphp

                    @foreach( $questions_list as $questionIndex => $questionObj)

                        @php $active  = ($questionIndex == 0)? 'active' : ''; @endphp


                        <form action="javascript:;" method="post">

                            {{$questionIndex}}
                                <div class="question-block {{$active}}" data-tconsumed="0">
                                {{$questionObj->from}} {{$questionObj->type}} {{$questionObj->to}} =  <input type="text" class="editor-field"> <br>
                                </div>

                        </form>






                    @php $question_no++; @endphp
                    @endforeach

                @endif
            </div>

                    <div class="next">Next</div>
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
    //init_question_functions();

    $(document).on('click', '.next', function (e) {
        $(".prevm").removeClass('active');
        $(".nextm").addClass('active');
    });

    var Questionintervals = setInterval(function() {
        var seconds_count = $(".question-block.active").attr('data-tconsumed');
        seconds_count = parseInt(seconds_count) + parseInt(1);
        $(".question-block.active").attr('data-tconsumed', seconds_count);
        $(".time-count-seconds").html(parseInt(seconds_count)/10);
    }, 100);


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
