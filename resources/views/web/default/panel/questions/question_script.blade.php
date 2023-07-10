<script>

    var field_type = "{{$field_type}}";
    var field_id = "{{$field_key}}";
    var user_selected_value = "{{$user_selected_value}}";
    var user_selected_key = "{{$user_selected_key}}";
    var correct_value = "{{$correct_value}}";
    if (field_type == 'text') {
        $("[id='field-" + field_id + "']").val(user_selected_value);

        if (user_selected_value != correct_value) {
            $("[id='field-" + field_id + "']").addClass('wrong');
        }else{
            $("[id='field-" + field_id + "']").addClass('correct');
        }
    } else {
        var field_id_cont = field_id + '-' + user_selected_key;
        if (user_selected_value != correct_value) {
            $("[name='field-" + field_id + "'][value='" + user_selected_value + "']").closest('.field-holder').addClass('wrong');
            $("[name='field-" + field_id + "'][value='" + user_selected_value + "']").closest('.form-field').addClass('wrong');

        }
        $("[name='field-" + field_id + "'][value='" + correct_value + "']").prop('checked', true);
    }

</script>
