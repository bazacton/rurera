@php namespace App\Http\Controllers\Web; @endphp
@extends(getTemplate().'.layouts.appstart')
@php
$i = 0; $j = 1;
$rand_id = rand(99,9999);

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>

<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">

<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<style>
    .ui-state-highlight {
        margin: 0px 10px;
    }

    .field-holder.wrong, .form-field.wrong, .form-field.wrong label {
        background: #ff4a4a;
        color: #fff;
    }
    .rurera-hide{
        display:none;
    }

</style>
@endpush
@section('content')
<div class="content-section">

    <section class="lms-quiz-section">

        @if( $quiz->quiz_pdf != '')
        <script type="text/javascript">
            $(document).ready(function () {
                $(".read-quiz-info").flipBook({
                    pdfUrl: '{{$quiz->quiz_pdf}}',
                    btnZoomIn: {enabled: true},
                    btnZoomOut: {enabled: true},
                    btnToc: {enabled: false},
                    btnShare: {enabled: false},
                    btnDownloadPages: {enabled: false},
                    btnDownloadPdf: {enabled: false},
                    btnSound: {enabled: false},
                    btnAutoplay: {enabled: false},
                    btnSelect: {enabled: false},
                    btnBookmark: {enabled: false},
                    btnThumbs: {enabled: false},
                    btnPrint: {enabled: false},
                    currentPage: {enabled: false},
                    viewMode: "swipe",
                    singlePageMode: true,
                    skin: 'dark',
                    menuMargin: 10,
                    menuBackground: 'none',
                    menuShadow: 'none',
                    menuAlignHorizontal: 'right',
                    menuOverBook: true,
                    btnRadius: 40,
                    btnMargin: 4,
                    btnSize: 14,
                    btnPaddingV: 16,
                    btnPaddingH: 16,
                    btnBorder: '2px solid rgba(255,255,255,.7)',
                    btnBackground: "rgba(0,0,0,.3)",
                    btnColor: 'rgb(255,120,60)',
                    sideBtnRadius: 60,
                    sideBtnSize: 60,
                    sideBtnBackground: "rgba(0,0,0,.7)",
                    sideBtnColor: 'rgb(255,120,60)',
                });
            });

        </script>
        <div class="read-quiz-info quiz-show"></div>
        <script>


        </script>
        @endif

        <div class="container-fluid questions-data-block read-quiz-content"
             data-total_questions="{{$quizQuestions->count()}}">
            @php $top_bar_class = ($quiz->quiz_type == 'vocabulary')? 'rurera-hide' : ''; @endphp

            <section class="quiz-topbar {{$top_bar_class}}">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="quiz-top-info"><p>{{$quiz->getTitleAttribute()}}</p>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">

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
                                <div id="rureraform-form-1"
                                     class="rureraform-form rureraform-elements rureraform-form-input-medium rureraform-form-icon-inside rureraform-form-description-bottom ui-sortable"
                                     _data-parent="1"
                                     _data-parent-col="0" style="display: block;">
                                    <div class="question-layout">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="question-area-block" data-quiz_type="practice" data-active_question_id="{{$active_question_id}}" data-questions_layout="{{json_encode($questions_layout)}}">

                        @if( is_array( $question ))
                        @php $question_no = 1; @endphp

                        @foreach( $question as $questionObj)
                        @include('web.default.panel.questions.question_layout',[
                        'question'=> $questionObj,
                        'prev_question' => 0,
                        'next_question' => 0,
                        'question_no' => $question_no,
                        'quizAttempt' => $quizAttempt,
                        'newQuestionResult' => $newQuestionResult,
                        'quizResultObj' => $newQuizStart
                        ])
                        @php $question_no++; @endphp
                        @endforeach
                        @else
                        @php $first_question = rurera_decode($questions_layout[$first_question_id]);
                        echo $first_question;
                        @endphp

                        @endif
                    </div>

                    <div class="question-area-temp hide"></div>

                </div>
            </div>
        </div>
    </section>


</div>

@if($quiz->quiz_type == 'vocabulary')
<div class="question-status-modal">
  <div class="modal fade question_status_modal" id="question_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-box">
            <div class="modal-title">
              <h3>Incorrect!</h3>
              <span class="inc" style="text-decoration: line-through;">are</span>
              <span class="cor">are</span>
            </div>
            <p>
              <span>verb</span> when more than one person is being something
            </p>
            <a href="javascript:;" class="confirm-btn" data-dismiss="modal" aria-label="Close">Okay</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<div class="modal fade review_submit" id="review_submit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
           <div class="modal-body">
               <p></p>
               <a href="javascript:;" class="submit_quiz_final nav-link mt-20 btn-primary rounded-pill" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> Submit </a>
           </div>
       </div>
   </div>
</div>
<div class="modal fade validation_error" id="validation_error" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
           <div class="modal-body">
               <p>Please fill all the required fields before submitting.</p>
           </div>
       </div>
   </div>
</div>
<a href="#" data-toggle="modal" class="hide review_submit_btn" data-target="#review_submit">modal button</a>
@endsection
@push('scripts_bottom')

<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_id}}"></script>

<script>
    //init_question_functions();
    $('body').addClass('quiz-show');
    var header = document.getElementById("navbar");
    var headerOffset = (header != null) ? header.offsetHeight : 100;
    var header_height = parseInt(headerOffset) + parseInt(85) + "px";


    $(document).ready(function () {

    });

</script>
@endpush
