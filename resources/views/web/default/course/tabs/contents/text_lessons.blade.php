@php
    $checkSequenceContent = $textLesson->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) and (!empty($checkSequenceContent['all_passed_items_error']) or !empty($checkSequenceContent['access_after_day_error'])));
@endphp
<li><a href="https://chimpstudio.co.uk/course/learning/maths?quiz={{$textLesson->id}}" class="testing-12">{{ $textLesson->title }}</a></li>