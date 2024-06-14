<script>
    var field_type = "{{ $field_type }}";
    var field_id = "{{ $field_key }}";
    var user_selected_value = "{{ $user_selected_value }}";
    var user_selected_key = "{{ $user_selected_key }}";
    var correct_value = "{{ $correct_value }}";
	var is_result_question = "{{$is_result_question}}";

    if (field_type === 'text' || field_type === 'number') {
        var textField = document.getElementById('field-' + field_id);
        textField.value = user_selected_value;
		if( is_result_question == true){
			if (user_selected_value !== correct_value) {
				textField.classList.add('wrong');
			} else {
				textField.classList.add('correct');
			}
		}
    } else if (field_type === 'radio') {
        var textField = document.getElementById('field-' + field_id);
        var correctClass = (user_selected_value !== correct_value) ? 'wrong' : 'correct';
		if( is_result_question == true){
			document.querySelector('[name="field-' + field_id + '"][value="' + user_selected_value + '"]').closest('.field-holder').classList.add(correctClass);
			document.querySelector('[name="field-' + field_id + '"][value="' + correct_value + '"]').closest('.field-holder').classList.add('correct');
		}
		document.querySelector('[name="field-' + field_id + '"][value="' + user_selected_value + '"]').checked = true;
    } else if (field_type === 'checkbox') {
        var textField = document.getElementById('field-' + field_id);
        var correctClass = (user_selected_value !== correct_value) ? 'wrong' : 'correct';
		if( is_result_question == true){
			document.querySelector('[name="field-' + field_id + '"][value="' + user_selected_value + '"]').closest('.form-field').classList.add(correctClass);
			document.querySelector('[name="field-' + field_id + '"][value="' + correct_value + '"]').closest('.form-field').classList.add('correct');
		}
		document.querySelector('[name="field-' + field_id + '"][value="' + user_selected_value + '"]').checked = true;
    } else if (field_type === 'textarea') {
		var textField = document.getElementById('field-' + field_id);
		textField.value = user_selected_value;
		if( is_result_question == true){
			if (user_selected_value !== correct_value) {
				textField.classList.add('wrong');
			} else {
				textField.classList.add('correct');
			}
		}
	} else {
        var fieldInputs = document.querySelectorAll('[name="field-' + field_id + '"]');
        var correctInput = document.querySelector('[name="field-' + field_id + '"][value="' + correct_value + '"]');

        if (user_selected_value !== correct_value) {
            fieldInputs.forEach(function(input) {
                input.closest('.field-holder').classList.add('wrong');
                input.closest('.form-field').classList.add('wrong');
            });
        }

        correctInput.classList.add('correct-mark');
        correctInput.checked = true;
    }

</script>
