@extends('web.default.panel.layouts.panel_layout')
@php use App\Models\Webinar; @endphp

@push('styles_top')

@endpush

@section('content')
@php $is_new_added = false; @endphp
<style>

:root {
  --bg-color: #fff;
  --line-color-1: #366;
  --line-color-2: #a9a9a9;
}

*, *::before, *::after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}



.learning-journey-item{
	position:absolute;
	margin: 0px 15px
}
.level-stage{position:relative;}




.graph-background {
	background-color: var(--bg-color);
	background-image: linear-gradient(var(--line-color-1) 1.5px, transparent 1.5px), linear-gradient(90deg, var(--line-color-1) 1.5px, transparent 1.5px), linear-gradient(var(--line-color-2) 1px, transparent 1px), linear-gradient(90deg, var(--line-color-2) 1px, transparent 1px) !important;
	background-position: -1.5px -1.5px, -1.5px -1.5px, -1px -1px, -1px -1px !important;
	background-size: 100px 100px, 100px 100px, 20px 20px, 20px 20px !important;
}


.field-data svg {
    height: auto;
    width: 100%;
}

</style>
<section class="p-0 mt-30 treasure-mission-layout">

	@if( !empty( $items_data ) )
		@php $level_count = 0; @endphp
		@foreach($items_data as $level_id => $itemsRow)
			@php $level_count++; $levelObj = isset( $levels_data[$level_id] )? $levels_data[$level_id] : array();
			
			$level_data_values = isset( $levelObj->data_values )? json_decode($levelObj->data_values) : array();
			$level_background = isset( $level_data_values->background ) ? $level_data_values->background : '#FFFFFF';
			$level_height = isset( $level_data_values->height ) ? $level_data_values->height : '800';
			$page_graph = isset( $level_data_values->page_graph ) ? $level_data_values->page_graph : 0;
			$page_graph = ( $page_graph == 1)? 'graph-background' : '';
			
			@endphp
			<div class="learning-journey-levels border-0" data-mission_id="mission_1">
				<div class="panel-subheader">
					<div class="title">
						<h2 class="font-19 font-weight-bold">{{$course->getTitleAttribute()}}</h2>
						<span class="info-modal-btn" data-toggle="modal" data-target="#level_1"> <img src="/assets/default/svgs/info-icon2.svg" alt=""></span>
					</div>
					<div class="stats-list">
						<ul>
							<li>
								<div class="list-box">
									<strong>Lessons</strong>
									<span>{{$topicCount}}</span>
								</div>
							</li>
							<li>
								<div class="list-box">
									<strong>Treasures</strong>
									<span>{{$treasureCount}}</span>
								</div>
							</li>
							<li>
								<div class="list-box">
									<strong>Coins</strong>
									<span>1 per Correct Answer</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				@if(!empty( $itemsRow ) )
				<div class="level-stage {{$page_graph}}" style="height:{{$level_height}}px; background:{{$level_background}}">
					@php $item_counter = 0; $total_count = 0; $ul_class = 'ul-rtl'; $already_active = false; $is_active = false; @endphp
					@foreach($itemsRow as $itemObj)
						@php $item_counter++;  $total_count++; $is_completed = isset( $itemObj->is_completed )? $itemObj->is_completed : false; 
						$percentage = isset( $itemObj->percentage )? $itemObj->percentage : false; 
						$is_completed = ($percentage >= 70)? true : $is_completed;
						
						$is_last = ($total_count >= count($itemsRow))? true : false;
						
						$is_active = ( $is_active == false && $is_completed != true)? true : $is_active;
						$is_active = ($already_active == false)? $is_active : false;
						$already_active = ($is_active == true)? true : $already_active;
						@endphp
						@include('web.default.learning_journey.journey_item', ['site_url' => $site_url, 'item_counter' => $item_counter, 'is_last' => $is_last, 'total_count' => $total_count, 'itemObj' => $itemObj])
						
					@endforeach
				</div>
				@endif
			</div>
		@endforeach
	@endif

</section>

@endsection

@push('scripts_bottom')
@if (!auth()->subscription('courses'))
    <script>
        if( $(".subscription-modal").length > 0){
            $(".subscription-modal").modal('show');
        }
    </script>
@endif

@endpush
