 <div class="heatmap-heading mb-30 pl-15">
	<h2 class="font-weight-normal m-0 font-18">Average per Table</h2>
</div>
<div class="heatmap-table-boxes mb-30">
	<ul class="d-flex">
		<li>
			<div class="heatmap-box">
				<div class="box-top">
					<span>10 <span>&#215;</span></span>
					<span>2 <span>&#215;</span></span>
					<span>5 <span>&#215;</span></span>
				</div>
				<div class="box-body">
					<strong>@php $average_time_consumed = isset( $average_time[10]['average_time'] )? $average_time[10]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
					<strong>@php $average_time_consumed = isset( $average_time[2]['average_time'] )? $average_time[2]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
					<strong>@php $average_time_consumed = isset( $average_time[5]['average_time'] )? $average_time[5]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
				</div>
			</div>
		</li>
		<li>
			<div class="heatmap-box">
				<div class="box-top">
					<span>3 <span>&#215;</span></span>
					<span>4 <span>&#215;</span></span>
					<span>8 <span>&#215;</span></span>
				</div>
				<div class="box-body">
					<strong>@php $average_time_consumed = isset( $average_time[3]['average_time'] )? $average_time[3]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
					<strong>@php $average_time_consumed = isset( $average_time[4]['average_time'] )? $average_time[4]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
					<strong>@php $average_time_consumed = isset( $average_time[8]['average_time'] )? $average_time[8]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
				</div>
			</div>
		</li>
		<li>
			<div class="heatmap-box">
				<div class="box-top">
					<span>6 <span>&#215;</span></span>
					<span>7 <span>&#215;</span></span>
					<span>9 <span>&#215;</span></span>
				</div>
				<div class="box-body">
					<strong>@php $average_time_consumed = isset( $average_time[6]['average_time'] )? $average_time[6]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
					<strong>@php $average_time_consumed = isset( $average_time[7]['average_time'] )? $average_time[7]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
					<strong>@php $average_time_consumed = isset( $average_time[9]['average_time'] )? $average_time[9]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
				</div>
			</div>
		</li>
		<li>
			<div class="heatmap-box" style="background-color: #84b741;">
				<div class="box-top">
					<span>11 <span>&#215;</span></span>
					<span>12 <span>&#215;</span></span>
				</div>
				<div class="box-body">
					<strong>@php $average_time_consumed = isset( $average_time[11]['average_time'] )? $average_time[11]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
					<strong>@php $average_time_consumed = isset( $average_time[12]['average_time'] )? $average_time[12]['average_time'] : 0; @endphp {{$average_time_consumed}}s</strong>
				</div>
			</div>
		</li>
	</ul>
</div>