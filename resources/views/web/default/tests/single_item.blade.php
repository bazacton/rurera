@php $resultData = $QuestionsAttemptController->get_result_data($rowObj->id);
$counter++;
$lock_image = ($counter > 2)? 'lock.svg' : 'unlock.svg';
$lock_unlock_class = ($counter > 2)? 'rurera-lock-item' : 'rurera-unlock-item';

$is_passed = isset( $resultData->is_passed )? $resultData->is_passed : false;
$in_progress = isset( $resultData->in_progress )? $resultData->in_progress : false;
$current_status = isset( $resultData->current_status )? $resultData->current_status : '';
$button_label = ($in_progress == true)? 'Resume' :'Practice Now';
$button_label = ($is_passed == true) ? 'Practice Again' : $button_label;
$button_label = ($in_progress == true)? 'Resume Test' :'Take Test';
$button_class = ($in_progress == true)? 'resume-test' :'';
$quiz_image = ($rowObj->quiz_image != '')? $rowObj->quiz_image : '/assets/default/img/assignment-logo/'.$rowObj->quiz_type.'.png';
@endphp
<tr>
    <td>
        <img src="{{$quiz_image}}" alt="">
        <h4 class="font-19 font-weight-bold"><a href="/sats/{{$rowObj->quiz_slug}}" class="{{ subscriptionCheckLink('bookshelf') }}">{{$rowObj->getTitleAttribute()}}</a>
            <br> <span class="sub_label">{{$rowObj->no_of_questions}} Question(s),</span> <span class="sub_label">Time:{{$rowObj->time}}m,</span> <span class="sub_label">{{getQuizTypeTitle($rowObj->quiz_type)}}</span>
			@if( $rowObj->time == 10)
				<img src="/assets/default/img/stop-watch.png">
			@endif

        </h4>
    </td>
    <td class="text-right {{$button_class}}">
        @if (auth()->check() && auth()->user()->isParent())
            <a href="javascript:;" class="rurera-list-btn">Assign</a>
        @endif
        @if (auth()->check() && auth()->user()->isUser())
            <a href="/sats/{{$rowObj->quiz_slug}}" class="rurera-list-btn {{ subscriptionCheckLink('bookshelf') }}">{{$button_label}}</a>
        @endif
    </td>
</tr>