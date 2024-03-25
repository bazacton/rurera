@php $rand_id = rand(999,99999); @endphp
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css?var={{$rand_id}}">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css?var={{$rand_id}}">
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
<style>
    .rurera-hide{
        display:none;
    }

</style>
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


            <div class="question-area-block" data-quiz_type="book" data-active_question_id="0" data-questions_layout="{{json_encode($questions_layout)}}">


                @php $first_question = rurera_decode($questions_layout[$first_question_id]);
                echo $first_question;
                @endphp
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></scrip>
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<script src="/assets/default/js/question-layout.js?ver={{$rand_id}}"></script>
<script>
    init_question_functions();
</script>
