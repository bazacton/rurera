<script>
    var field_type = "{{ $field_type }}";
    var field_id = "{{ $field_key }}";
    var user_selected_value = "{{ $user_selected_value }}";
    var user_selected_key = "{{ $user_selected_key }}";
    var correct_value = "{{ $correct_value }}";

    if (field_type === 'text') {
        var textField = document.getElementById('field-' + field_id);
        textField.value = user_selected_value;
        if (user_selected_value !== correct_value) {
            textField.classList.add('wrong');
        } else {
            textField.classList.add('correct');
        }
    } else {
        console.log(field_id);
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
