@php $rand_id = rand(999,99999); @endphp
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
@if($all_infolinks_checked == false)

<div class="flipbook-quiz">
    <div class="slide-menu-head">
        <div class="menu-controls">
            <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
        </div>
        <h4>Check all Info Links before Attempting Quiz</h4>
    </div>
</div>
@else

@php $data_values = json_decode($pageInfoLink->data_values);
$content = isset($data_values->infobox_value)? base64_decode(trim(stripslashes($data_values->infobox_value))) : '';

@endphp
<section class="lms-quiz-section">
<div class="flipbook-quiz">
    <div class="container-fluid questions-data-block read-quiz-content" data-total_questions="0">

        <div class="menu-controls">
            <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
        </div>


        <div class="question-area-block">
            @include('web.default.panel.questions.question_layout',['question'=> $question, 'question_no' =>
            $question_no, 'quizAttempt' => $quizAttempt, 'newQuestionResult' => $newQuestionResult, 'prev_question' => 0,'next_question' => 0,'quizResultObj' => $QuizzesResult])
        </div>

        <div class="question-area-temp hide"></div>

        <span class="quiz-pagnation">2 of 2</span>
        <span class="quiz-info">Lorem ipsum dolor, adipisicing elit.</span>
    </div>
</div>
</section>
@endif
<script>
    $("body").addClass("quiz-open");
</script>

<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_id}}"></script>
