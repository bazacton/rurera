@php
$li_type_class = '';
$is_completed_class = isset( $itemObj->is_completed )? $itemObj->is_completed : false;
$is_completed_class = ($is_completed_class == true)? 'completed' : '';
$stasge_icon = ($is_completed_class == true)? 'tick-white.png' : 'panel-lock.png';
if( $item_counter == 6){
	$li_type_class = 'vertical-li';
	
}
@endphp
@if($itemObj->item_type == 'treasure')
	<li class="treasure {{$li_type_class}} {{$is_completed_class}}">
		<a href="#">
			<span class="thumb-box rurera-tooltip"><img src="/assets/default/img/treasure2.png" alt=""></span>
		</a>
	</li>
@else
	<li class="intermediate {{$is_completed_class}} {{$li_type_class}}" data-id="nugget_1_1_1" data-quiz_level="medium">
		<a href="javascript:;" class="locked_nugget" data-id="nugget_1_1_1" title="{{$item_counter}}{{$itemObj->topic->sub_chapter_title}}"><img src="/assets/default/img/{{$stasge_icon}}" alt=""></a>
	</li>
@endif

