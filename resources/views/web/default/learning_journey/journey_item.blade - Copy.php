@php use App\Models\QuizzesResult;
$li_type_class = '';
$is_completed = isset( $itemObj->is_completed )? $itemObj->is_completed : false;
$percentage = isset( $itemObj->percentage )? $itemObj->percentage : 0;
$is_completed = ($percentage >= 70)? true : $is_completed;
$resultObj = (object) array();
if( $is_completed == true){
	$result_id = isset( $itemObj->completed_result )? $itemObj->completed_result : 0;
	$resultObj = QuizzesResult::find($result_id);
}
$is_completed_class = isset( $itemObj->is_completed )? $itemObj->is_completed : false;
$is_completed_class = ($percentage >= 70)? true : $is_completed_class;
$is_completed_class = ($is_completed_class == true)? 'completed' : '';
$stage_icon = ($is_completed_class == true)? 'tick-white.png' : 'panel-lock.png';
$treasure_icon = ($is_completed_class == true)? 'treasure.png' : 'treasure2.png';
$stage_icon = ($is_active == true)? 'stepon.png' : $stage_icon;

$stage_icon = ($is_last == true)? 'flag-grey.png' : $stage_icon;

$is_last_class = ($is_last == true)? 'last_stage' : '';
$is_completed_class = ($is_active == true)? 'completed' : $is_completed_class;

if( $item_counter == 6){
	$li_type_class = 'vertical-li';
	
}
$stage_link = 'javascript:;';
$stage_link = '/learning-journey/'.$category_slug.'/'.$subject_slug.'/'.$itemObj->topic->sub_chapter_slug.'/'.$itemObj->id.'/';
@endphp
@if($itemObj->item_type == 'treasure')
	<li class="treasure {{$li_type_class}} {{$is_last_class}}">
		<a href="javascript:;">
			<span class="thumb-box rurera-tooltip dropup"><img src="/assets/default/img/{{$treasure_icon}}" alt=""></span>
		</a>
	</li>
@else
	<li class="intermediate {{$is_completed_class}} {{$li_type_class}} {{$is_last_class}}" data-id="nugget_1_1_1" data-quiz_level="medium">

        @if($is_active == true || $is_completed == true)
		<div class="rurera-stars">
			@php $star_icon = ($percentage >= 81)? 'color-star.svg' : 'grey-star.svg'; @endphp
			<span class="first-star"><img src="/assets/default/img/learning/{{$star_icon}}" width="50"></span>
			@php $star_icon = ($percentage >= 70)? 'color-star.svg' : 'grey-star.svg'; @endphp
			<span class="second-star"><img src="/assets/default/img/learning/{{$star_icon}}" width="50"></span>
			@php $star_icon = ($percentage >= 86)? 'color-star.svg' : 'grey-star.svg'; @endphp
			<span class="third-star"><img src="/assets/default/img/learning/{{$star_icon}}" width="50"></span>
		</div>
		@endif

		<a href="javascript:;" class="locked_nugget rurera-tooltip dropup" data-id="nugget_1_1_1" title="{{$item_counter}}{{$itemObj->topic->sub_chapter_title}}">
		
		<span class="dropdown-toggle h-100 w-100 d-flex align-items-center justify-content-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img src="/assets/default/img/{{$stage_icon}}" alt=""></span>		
		
		<div class="lms-tooltip dropdown-menu">
			<div class="tooltip-box">
			
				@if($is_active == true)
					<h5 class="font-18 font-weight-bold text-white mb-5">			
					<span class="topic-title">{{$itemObj->topic->sub_chapter_title}}</span>
					</h5>
					<button class="tooltip-button" onclick="window.location.href='{{$stage_link}}';">Play</button>
				@endif
				@if($is_completed == true && isset( $resultObj->id))
					<h5 class="font-18 font-weight-bold text-white mb-5">															
					<span class="topic-title">{{$itemObj->topic->sub_chapter_title}}</span>
					Active practice: {{getTimeWithText($resultObj->quizz_result_questions_list->where('status', '!=', 'waiting')->sum('time_consumed'))}}<br> 
					Questions answered: {{$resultObj->quizz_result_questions_list->where('status', '!=', 'waiting')->count()}} <br>	
					<img src="/assets/default/img/panel-sidebar/coins.svg" alt="" width="30">Coins earned:{{$resultObj->quizz_result_questions_list->where('status', 'correct')->sum('quiz_grade')}}
					</h5>
					<button class="tooltip-button" onclick="window.location.href='{{$stage_link}}';">Play</button>
					<button class="tooltip-button" onclick="window.location.href='/panel/quizzes/{{$resultObj->id}}/check_answers';">Track</button>
				@endif
				
				@if($is_completed == false && $is_active == false)
					<h5 class="font-18 font-weight-bold text-white mb-5">			
					<span class="topic-title">{{$itemObj->topic->sub_chapter_title}}</span>
					Complete all above stages to unlock!<br> 
					</h5>
				@endif
			</div>
		</div>
		</a>
	</li>
@endif

