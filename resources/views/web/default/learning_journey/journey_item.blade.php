@php
$li_type_class = '';
$is_completed_class = isset( $itemObj->is_completed )? $itemObj->is_completed : false;
$is_completed_class = ($is_completed_class == true)? 'completed' : '';
$stage_icon = ($is_completed_class == true)? 'tick-white.png' : 'panel-lock.png';
$treasure_icon = ($is_completed_class == true)? 'treasure.png' : 'treasure2.png';
$stage_icon = ($is_active == true)? 'stepon.png' : $stage_icon;
$is_completed_class = ($is_active == true)? 'completed' : $is_completed_class;

if( $item_counter == 6){
	$li_type_class = 'vertical-li';
	
}
@endphp
@if($itemObj->item_type == 'treasure')
	<li class="treasure {{$li_type_class}}">
		<a href="javascript:;">
			<span class="thumb-box rurera-tooltip"><img src="/assets/default/img/{{$treasure_icon}}" alt=""></span>
		</a>
	</li>
@else
	<li class="intermediate {{$is_completed_class}} {{$li_type_class}}" data-id="nugget_1_1_1" data-quiz_level="medium">
		<a href="/{{$category_slug}}/{{$subject_slug}}/{{$itemObj->topic->sub_chapter_slug}}/{{$itemObj->id}}/journey" class="locked_nugget" data-id="nugget_1_1_1" title="{{$item_counter}}{{$itemObj->topic->sub_chapter_title}}"><img src="/assets/default/img/{{$stage_icon}}" alt=""></a>
	</li>
@endif

