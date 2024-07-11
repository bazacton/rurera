<link rel="stylesheet" href="/assets/default/css/quiz-layout.css">
<div class="finish-steps">
	<div class="col-12 question-layout-block">
		<div class="chart-summary-fields result-layout-summary">
			<h3 class="text-center font-30 mb-50">
				Congratulation
				<span class="icon-box">
					<img src="/assets/default/svgs/event-gift.svg">
				</span>
			</h3>
			<p> You have successfully Completed the quest {{$questObj->title}}</p>
			<img src="/assets/default/img/panel-sidebar/coins.svg" alt="" width="30"> {{$RewardAccounting->score}}
		</div>
		
		
		<div class="prev-next-controls text-center mb-50 questions-nav-controls">
			<a href="javascript:;" class="review-btn finish-next-step">
				NEXT
			</a>
		</div>
	</div>
</div>