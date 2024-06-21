@extends('web.default.panel.layouts.panel_layout')
@php use App\Models\Webinar; @endphp

@push('styles_top')

@endpush

@section('content')
@php $is_new_added = false; @endphp
<section class="p-0 mt-30 treasure-mission-layout">

	@if( !empty( $items_data ) )
		@php $level_count = 0; @endphp
		@foreach($items_data as $level_id => $itemsRow)
			@php $level_count++; @endphp
			<div class="spell-levels border-0" data-mission_id="mission_1">
				<div class="panel-subheader">
					<div class="title">
						<h2 class="font-19 font-weight-bold">Level {{$level_count}}</h2>
						<span class="info-modal-btn" data-toggle="modal" data-target="#level_1"> <img src="/assets/default/svgs/info-icon2.svg" alt=""></span>
					</div>
					<div class="stats-list">
						<ul>
							<li>
								<div class="list-box">
									<strong>Tables</strong>
									<span>30 Questions per Stage</span>
								</div>
							</li>
							<li>
								<div class="list-box">
									<strong>Speed</strong>
									<span>5 Seconds per Question</span>
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
				<div class="treasure-stage">
					<ul class="justify-content-start horizontal-list p-0 " style="display: block;">
						@php $item_counter = 0; $ul_class = 'ul-rtl'; @endphp
						@foreach($itemsRow as $itemObj)
							@php $item_counter++;  $is_completed = isset( $itemObj->is_completed )? $itemObj->is_completed : false; @endphp
							@include('web.default.learning_journey.journey_item', ['item_counter' => $item_counter, 'itemObj' => $itemObj])
							
							@if( $item_counter == 6)
								@php $item_counter = 0; @endphp
								</ul></div>
								<div class="treasure-stage">
								<ul class="justify-content-start horizontal-list p-0 {{$ul_class}}" style="display: block;">
							@endif
							
							@if( !empty( $new_added_stages ) )
								@if( $is_new_added == false && $is_completed == false)
									@foreach($new_added_stages as $stageItemObj)
										@php $item_counter++;  @endphp
										@include('web.default.learning_journey.journey_item', ['item_counter' => $item_counter, 'itemObj' => $stageItemObj])
									@endforeach
								@endif
							@endif
							
							@if( $item_counter == 6)
								@php $item_counter = 0; @endphp
								</ul></div>
								<div class="treasure-stage">
								<ul class="justify-content-start horizontal-list p-0 {{$ul_class}}" style="display: block;">
							@endif
							@php $ul_class	= ($ul_class == 'ul-rtl')? '' : 'ul-rtl'; @endphp
							
						@endforeach
					</ul>
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
