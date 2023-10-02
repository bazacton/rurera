$(document).ready(function(){
    $('.assign-topic-btn').on("click", function() {
        rurera_loader($(this), 'div');
        var thisParent = $(this).closest('.user-assign-topics');
        var topic_type = thisParent.attr('data-topic_type');
        var topic_id = thisParent.attr('data-topic_id');
        var deadline_date = thisParent.find('.deadline').val();
        var child_ids = [];
        thisParent.find('.child_ids:checked').each(function () {
            child_ids.push($(this).val());
        });
        jQuery.ajax({
           type: "POST",
           url: '/assign_user_topic',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {"child_ids": child_ids, "topic_id": topic_id, "topic_type": topic_type, "deadline_date" : deadline_date},
           success: function (return_data) {
               jQuery.growl.notice({
                  title: '',
                  message: 'Updated Successfully',
              });
           }
       });

    });
});