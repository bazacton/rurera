@php
    $checkSequenceContent = $quiz->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp


<li><a href="https://chimpstudio.co.uk/course/learning/maths?quiz={{$quiz->id}}">{{ $quiz->title }}</a></li>
