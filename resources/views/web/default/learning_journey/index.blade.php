@extends('web.default.panel.layouts.panel_layout')
@push('styles_top')
@endpush

@section('content')


<div class="quests-list quests-learning">
	<div class="section-title text-left mb-30">
		<h2 class="font-22">Learning Journeys</h2>
	</div>
	@if( $LearningJourneys->count() > 0)
	<ul>
		@foreach( $LearningJourneys as $learningJourneyObj)
			@php $level_stages = $learningJourneyObj->learningJourneyStages->pluck('id')->toArray();
			$completed_stages = $user->studentJourneyItems->where('status', 'completed')->whereIn('learning_journey_item_id', $level_stages)->count() @endphp
			<li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-20 bg-danger">
				<div class="quests-item">
					<div class="icon-box">
						@if($learningJourneyObj->subject->icon_code != '')
							   {!! $learningJourneyObj->subject->icon_code !!}
						@else
						   <img src="{!! $learningJourneyObj->subject->thumbnail !!}">
						@endif
					</div>
					<div class="item-text">
						<h5 class="font-18 font-weight-bold"><a href="/learning-journey/{{$learningJourneyObj->subject->slug}}">{{$learningJourneyObj->subject->getTitleAttribute()}}</a></h5>
						<div class="levels-progress horizontal">
							<span class="progress-box">
								<span class="progress-count" style="width: 0%;"></span>
							</span>
						</div>
						<span class="progress-icon font-16 font-weight-normal">
							<img src="/assets/default/img/quests-coin.png" alt="">
							+20
						</span>
						<span class="progress-info d-block pt-5">
							<strong>{{$completed_stages}}/{{$learningJourneyObj->learningJourneyStages->count()}}</strong> Stages Completed
						</span>
					</div>
				</div>
			</li>
		@endforeach
		
	</ul>
	@endif
</div>

@endsection

@push('scripts_bottom')
@endpush
