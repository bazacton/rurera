<script>

    console.log('testing');
    var field_id = "{{$field_key}}";
    var user_selected_value = "{{$user_selected_value}}";
    var correct_value = "{{$correct_value}}";
    console.log(field_id);
    console.log(user_selected_value);
    if( user_selected_value != correct_value) {
        $("[name='field-" + field_id + "'][value='" + user_selected_value + "']").closest('.field-holder').addClass('wrong');
        $("[name='field-" + field_id + "'][value='" + user_selected_value + "']").closest('.form-field').addClass('wrong');

    }
    $("[name='field-"+field_id+"'][value='"+correct_value+"']").prop('checked', true);

</script>
