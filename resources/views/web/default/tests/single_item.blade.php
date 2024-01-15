@php $resultData = $QuestionsAttemptController->get_result_data($rowObj->id);
$counter++;
$lock_image = ($counter > 2)? 'lock.svg' : 'unlock.svg';
$lock_unlock_class = ($counter > 2)? 'rurera-lock-item' : 'rurera-unlock-item';

$is_passed = isset( $resultData->is_passed )? $resultData->is_passed : false;
$in_progress = isset( $resultData->in_progress )? $resultData->in_progress : false;
$current_status = isset( $resultData->current_status )? $resultData->current_status : '';
$button_label = ($in_progress == true)? 'Resume' :'Practice Now';
$button_label = ($is_passed == true) ? 'Practice Again' : $button_label;

@endphp
<tr>
    <td class="{{$lock_unlock_class}}">
        <img src="/assets/default/img/{{$lock_image}}">
    </td>
    <td>
        <img src="/assets/default/img/assignment-logo/{{$rowObj->quiz_type}}.png" alt="">
        <h4><a href="/sats/{{$rowObj->quiz_slug}}">{{$rowObj->getTitleAttribute()}}</a>
            <br> <span class="sub_label">{{count($rowObj->quizQuestionsList)}} Question(s)</span>
        </h4>
    </td>
    <td>0</td>
    <td>12</td>
    <td>
        <div class="attempt-progress">
            <span class="progress-number">0%</span>
            <span class="progress-holder">
                                            <span class="progressbar"
                                                  style="width: 0%;"></span>
                                        </span>
        </div>
    </td>
</tr>