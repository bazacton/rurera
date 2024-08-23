@extends('web.default.panel.layouts.panel_layout')
@php use App\Models\Webinar; @endphp

@push('styles_top')

@endpush

@section('content')
@php $is_new_added = false; @endphp
<style>
.learning-journey-item{
	position:absolute;
}
.level-stage{position:relative;}
</style>
<section class="p-0 mt-30 treasure-mission-layout">

	@if( !empty( $items_data ) )
		@php $level_count = 0; @endphp
		@foreach($items_data as $level_id => $itemsRow)
			@php $level_count++; @endphp
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
				<div class="level-stage">
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
