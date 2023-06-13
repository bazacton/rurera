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

<div class="flipbook-quiz">
    <div class="slide-menu-head">
        <div class="menu-controls">
            <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
        </div>
        <span class="quiz-pagnation">2 of 2</span>
        <span class="quiz-info">Lorem ipsum dolor, adipisicing elit.</span>
    </div>
    <div class="slide-menu-body">
        <div class="flipbook-content-box">
            <div class="quiz-select">
                <form>
                    <div class="quiz-form-field">
                        <input type="radio" id="quiz1" name="quiz">
                        <label for="quiz1">Lorem ipsum dolor</label>
                    </div>
                    <div class="quiz-form-field">
                        <input type="radio" id="quiz2" name="quiz">
                        <label for="quiz2">Lorem ipsum dolor</label>
                    </div>
                    <div class="quiz-form-field">
                        <input type="radio" id="quiz3" name="quiz">
                        <label for="quiz3">Lorem ipsum dolor</label>
                    </div>
                    <div class="quiz-form-field">
                        <input type="radio" id="quiz4" name="quiz">
                        <label for="quiz4">Lorem ipsum dolor</label>
                    </div>
                    <div class="quiz-form-btn">
                        <button type="submit">Check answers</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
<script>
    $("body").addClass("quiz-open");
</script>
