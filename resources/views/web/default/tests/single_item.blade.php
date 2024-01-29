@php $resultData = $QuestionsAttemptController->get_result_data($rowObj->id);
$counter++;
$lock_image = ($counter > 2)? 'lock.svg' : 'unlock.svg';
$lock_unlock_class = ($counter > 2)? 'rurera-lock-item' : 'rurera-unlock-item';

$is_passed = isset( $resultData->is_passed )? $resultData->is_passed : false;
$in_progress = isset( $resultData->in_progress )? $resultData->in_progress : false;
$current_status = isset( $resultData->current_status )? $resultData->current_status : '';
$button_label = ($in_progress == true)? 'Resume' :'Practice Now';
$button_label = ($is_passed == true) ? 'Practice Again' : $button_label;
$quiz_image = ($rowObj->quiz_image != '')? $rowObj->quiz_image : '/assets/default/img/assignment-logo/'.$rowObj->quiz_type.'.png';
@endphp
<tr>
    <td>
        <img src="{{$quiz_image}}" alt="">
        <h4 class="font-19 font-weight-bold"><a href="/sats/{{$rowObj->quiz_slug}}">{{$rowObj->getTitleAttribute()}}</a>
            <br> <span class="sub_label">{{count($rowObj->quizQuestionsList)}} Question(s),</span> <span class="sub_label">Time:{{getTimeWithText(($rowObj->time*60), false)}},</span> <span class="sub_label">Accuracy: 5%,</span> <span class="sub_label">{{getQuizTypeTitle($rowObj->quiz_type)}}</span>
        </h4>
    </td>
    <td class="text-right">
        <a href="/sats/{{$rowObj->quiz_slug}}" class="rurera-list-btn">Take Test</a>
    </td>
</tr>