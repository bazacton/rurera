<div id="rureraform-element-{{$element_id}}" class="rureraform-element-{{$element_id}} rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="{{$elementObj->type}}">
	<div id="button-container">
		<button id="startRecord" class="btn-icon">
			<i class="fas fa-play"></i>
		</button>
		<button id="stopRecord" class="btn-icon" disabled="">
			<i class="fas fa-stop"></i>
		</button>
		<span id="timer" class="time-left">Time remaining: <span id="timeLeft">{{$elementObj->content}}</span> seconds</span>
		<audio id="audioPlayer" data-id="98361" type="audio_record" data-field_type="audio_record" controls="" class="audio-control rurera-hide editor-field"></audio>
	</div>
</div>
