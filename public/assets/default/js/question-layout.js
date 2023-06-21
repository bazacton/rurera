function chimp_utf8encode(string) {
    string = string.replace(/\x0d\x0a/g, "\x0a");
    var output = "";
    for (var n = 0; n < string.length; n++) {
        var c = string.charCodeAt(n);
        if (c < 128) {
            output += String.fromCharCode(c);
        } else if ((c > 127) && (c < 2048)) {
            output += String.fromCharCode((c >> 6) | 192);
            output += String.fromCharCode((c & 63) | 128);
        } else {
            output += String.fromCharCode((c >> 12) | 224);
            output += String.fromCharCode(((c >> 6) & 63) | 128);
            output += String.fromCharCode((c & 63) | 128);
        }
    }
    return output;
}


var quiz_user_data = [];
quiz_user_data[0] = {};
quiz_user_data[0]['attempt'] = {};
quiz_user_data[0]['incorrect'] = {};
quiz_user_data[0]['correct'] = {};
$(document).on('click', '.question-submit-btn', function (e) {
    e.preventDefault();
    clearInterval(Questioninterval);
    console.log('question-submit');

    var question_data = [];
    question_data[0] = {};
    var appricate_words_array = ['Wonderful', 'Excellent', 'Brilliant', 'Fantastic', 'Spectacular', 'Gorgeous', 'Exceptional', 'Marvelous', 'Extrodinary']
    var appricate_word = appricate_words_array[Math.floor(Math.random() * appricate_words_array.length)];
    var appricate_colors_array = ['red', 'orange', 'blue', 'green']
    var appricate_color = appricate_colors_array[Math.floor(Math.random() * appricate_colors_array.length)];
    var thisObj = $(this);
    var attempt_id = $(".question-area .question-step").attr('data-qattempt');
    var quiz_result_id = $(".question-area .question-step").attr('data-quiz_result_id');
    var time_consumed = $(".question-area .question-step").attr('data-elapsed');


    var total_elapsed_time = $(".range-price").attr('data-time_elapsed');
    var start_time = thisObj.closest('.question-step').attr('data-start_time');
    var time_consumed_bk = parseInt(total_elapsed_time) - parseInt(start_time);

    var question_no = $(this).attr('data-question_no');
    var total_questions = thisObj.closest('.questions-data-block').attr('data-total_questions');
    var thisForm = $(this).closest('form');
    var question_id = $(this).closest('form').data('question_id');
    var question_layout = thisForm.find('.question-layout').html();
    $('.question-all-good').remove();
    $(this).closest('form').find('.editor-field').each(function () {
        $(this).removeClass('validate-error');
        var field_name = $(this).attr('name');
        var field_id = $(this).attr('id');
        var field_identifier = field_id;
        var field_identifier = field_identifier.replace(/field-/g, '');
        var field_type = $(this).attr('type');
        var field_value = $(this).val();

        console.log(field_type);

        if (field_type == 'paragraph') {
            var field_value = $(this).html();
            //question_data[0][field_identifier]['user_input'] =  $(this).html();
        }

        if (field_type == 'text') {
            question_data[0][field_identifier] = field_value;

        } else if (field_type == 'checkbox' || field_type == 'radio') {
            var field_identifier = field_name.replace(/field-/g, '');
            var field_value = $("input[name='" + field_name + "']:checked").map(function () {
                return $(this).val();
            }).get();

            question_data[0][field_identifier] = field_value;
            $('#checkbox_id:checked').val();

        } else {
            question_data[0][field_identifier] = field_value;
        }

    });

    /*$(this).closest('form').find('.insert-into-sentense-holder').each(function() {
            var user_input = $(this).find('p').html();
            question_data[0]['user_input'] = user_input;
            question_data[0]['type'] = 'insert_into_sentense';

    });*/


    question_data_array = question_data;
    question_data = chimp_encode64(JSON.stringify(question_data));
    quiz_user_data[0]['attempt'][question_id] = question_data_array;
    var qresult_id = thisObj.closest('.question-step').attr('data-qresult');
    var qattempt_id = thisObj.closest('.question-step').attr('data-qattempt');

    jQuery.ajax({
        type: "POST",
        url: '/question_attempt/validation',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "question_id": question_id,
            "question_data": question_data,
            "qresult_id": qresult_id,s
            "qattempt_id": qattempt_id,
            "time_consumed": time_consumed
        },
        success: function (return_data) {
            if (return_data.incorrect_flag == true && return_data.show_fail_message == true) {

                var question_response_layout = return_data.question_response_layout;
                if (question_response_layout != '') {
                    var question_response_layout = return_data.question_response_layout;
                    $(".question-area-temp").html(question_response_layout);
                }
                var question_result_id = return_data.question_result_id;
                thisObj.closest('.question-step').attr('data-qresult', question_result_id);
                var qresult_id = thisObj.closest('.question-step').attr('data-qresult');
                quiz_user_data[0]['incorrect'][question_id] = question_data_array;

                var correct_answers_html = '';
                var user_answers_html = '';
                $.each(return_data.incorrect_array, function (field_id, value) {
                    thisForm.find('#field-' + field_id).addClass('validate-error');
                    $.each(value.correct, function (correct_index, correct_value) {
                        correct_answers_html += '<li><label class="lms-question-label" for="radio2"><span>' + correct_value + '</span></label></li>';
                    });
                    $.each(value.user_input, function (user_index, user_value) {
                        user_answers_html += '<li><label class="lms-question-label" for="radio2"><span>' + user_value + '</span></label></li>';
                    });

                });
                var fail_page_link = '/panel/questions/' + question_id + '/fail';
                fetch(fail_page_link)
                    .then((response) => response.text())
                    .then((html) => {
                        thisObj.closest('.question-step').append(html);
                        thisObj.closest('.question-step').find('.lms-explanation-block').html(question_layout);
                        thisObj.closest('.question-step').find('.lms-explanation-block').find('.editor-field').attr('disabled', 'disabled');
                        thisObj.closest('.question-step').find('.lms-explanation-block').find('.editor-field').attr('readonly', 'readonly');
                        thisObj.closest('.question-step').find('.lms-explanation-block').find('.editor-field').attr('name', 'disable_name');
                        thisObj.closest('.question-step').find('.lms-explanation-block').find('.marks').remove();
                        thisObj.closest('.question-step').find('.lms-explanation-block').find('label').attr('for', 'disable_for');
                        thisObj.closest('.question-step').find('.lms-correct-answer-block').html(correct_answers_html);
                        thisObj.closest('.question-step').find('.lms-user-answer-block').html(user_answers_html);
                        thisObj.closest('.question-layout-block').addClass('hide');
                        thisObj.closest('.questions-data-block').find('.right-content').addClass('hide');
                    })
                    .catch((error) => {
                        console.warn(error);
                    });


                thisForm.find('.form-btn').append('<span class="question-all-good">All Not Good</span>');
            } else {

                quiz_user_data[0]['correct'][question_id] = question_data_array;

                var marks_count = thisForm.find('.marks').attr('data-marks');
                var marks_counter = 1;
                var markscoin_html = '';
                if (marks_count > 0) {
                    while (marks_counter <= marks_count) {
                        markscoin_html += '<div class="markscoin">';
                        marks_counter++;
                    }

                }
                $btn = $('.coin-marks-label');
                var $coin = $(markscoin_html)
                    .insertAfter($btn)
                    .css({
                        "left": 150,
                        "top": 105
                    })
                    .animate({
                        "top": 93,
                        "left": 390
                    }, 1000, function () {
                        $coin.remove();
                        var points_value = $(".range-value-count span").html();
                        var points_value = parseInt(points_value) + parseInt(marks_count);
                        $(".range-value-count span").html(points_value);
                        $("#range").val(points_value);
                    });

                thisForm.find('.form-btn').append('<span class="question-all-good">All Good</span>');
                var next_question_no = parseInt(question_no) + 1;


                thisObj.closest('.questions-data-block').find('.question-fields').hide();
                thisObj.closest('.questions-data-block').find('.correct-appriciate').html(appricate_word);
                thisObj.closest('.questions-data-block').find('.correct-appriciate').addClass(appricate_color);
                thisObj.closest('.questions-data-block').find('.correct-appriciate').show(300).delay(2000).hide(300);

                var question_response_layout = return_data.question_response_layout;
                if (question_response_layout != '') {
                    $(".question-step").css({display: "none"}).hide().animate({opacity: 0});
                    thisObj.closest('.questions-data-block').find('.question-fields').show(2500);
                    $(".question-step.question-step-" + next_question_no).css({display: "block"}).show(3000).animate({opacity: 1});

                    var question_response_layout = return_data.question_response_layout;
                    $(".question-area-block").html(question_response_layout);

                    var total_elapsed_time = $(".range-price").attr('data-time_elapsed');
                    $(".question-step").attr('data-start_time', total_elapsed_time);

                } else {
                    thisObj.closest('.questions-data-block').find('.right-content').addClass('hide');
                    $(".quiz-complete").show(2000);

                    quiz_user_data = chimp_encode64(JSON.stringify(quiz_user_data));
                    //quiz_user_data = JSON.stringify(quiz_user_data);
                    jQuery.ajax({
                        type: "POST",
                        url: '/question_attempt/test_complete',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"attempt_id": qattempt_id, "quiz_user_data": quiz_user_data},
                        success: function (return_data) {
                            console.log(return_data);
                            $(".quiz-complete").css({display: "block"}).show(10).animate({opacity: 1});
                            $(".quiz-complete").find(".question-layout").html(return_data);
                            $(".quiz-complete").children().unbind('click');
                        }
                    });
                }

            }
        }
    });

});


function chimp_encode64(input) {
    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;
    input = chimp_utf8encode(input);
    while (i < input.length) {
        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);
        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;
        if (isNaN(chr2)) {
            enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
            enc4 = 64;
        }
        output = output + keyString.charAt(enc1) + keyString.charAt(enc2) + keyString.charAt(enc3) + keyString.charAt(enc4);
    }
    return output;
}

function chimp_utf8decode(input) {
    var string = "";
    var i = 0;
    var c = 0, c1 = 0, c2 = 0;
    while (i < input.length) {
        c = input.charCodeAt(i);
        if (c < 128) {
            string += String.fromCharCode(c);
            i++;
        } else if ((c > 191) && (c < 224)) {
            c2 = input.charCodeAt(i + 1);
            string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = input.charCodeAt(i + 1);
            c3 = input.charCodeAt(i + 2);
            string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }
    return string;
}

function chimp_decode64(input) {
    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var output = "";
    var chr1, chr2, chr3;
    var enc1, enc2, enc3, enc4;
    var i = 0;
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
    while (i < input.length) {
        enc1 = keyString.indexOf(input.charAt(i++));
        enc2 = keyString.indexOf(input.charAt(i++));
        enc3 = keyString.indexOf(input.charAt(i++));
        enc4 = keyString.indexOf(input.charAt(i++));
        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;
        output = output + String.fromCharCode(chr1);
        if (enc3 != 64) {
            output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }
    }
    output = chimp_utf8decode(output);
    return output;
}


$(document).on('click', '.lms-quest-btn', function (e) {
    $(this).closest('.question-step').find('.question-layout-block').removeClass('hide');
    $(this).closest('.questions-data-block').find('.right-content').removeClass('hide');
    $(this).closest('.question-fail-block').remove();
    $(".question-area-block").html($(".question-area-temp").html());
});


function sort_init() {
    $("p.given").html(chunkWords($("p.given").text()));
    $("span.given").draggable({
        helper: "clone",
        revert: "invalid"
    });

    makeDropText($("p.given span.w"));

    jQuery('.question-layout').find(".lms-sorting-fields").each(function () {
        var this_id = $(this).attr('id');
        new Sortable(this_id, {
            animation: 150
        });
    });

}



function init_question_functions() {

    //sort_init();
    $(document).on('click', '.flag-question', function (e) {
        var question_id = $(this).attr('data-question_id');
        var qresult_id = $(this).attr('data-qresult_id');

        var thisObj = $(this);
        jQuery.ajax({
            type: "POST",
            url: '/question_attempt/flag_question',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"question_id": question_id, "qresult_id": qresult_id},
            success: function (return_data) {
                $(".quiz-pagination li[data-question_id='" + question_id + "']").addClass('has-flag');
                thisObj.remove();
            }
        });
    });

    $(document).on('click', '.quiz-pagination ul li, .questions-nav-controls .prev-btn, .questions-nav-controls .next-btn', function (e) {
        var question_id = $(this).attr('data-question_id');
        var qattempt_id = $(".question-area .question-step").attr('data-qattempt');
        var thisObj = $(this);
        jQuery.ajax({
            type: "POST",
            url: '/question_attempt/jump_question',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"question_id": question_id, "qattempt_id": qattempt_id},
            success: function (return_data) {
                var question_response_layout = return_data.question_response_layout;
                if (question_response_layout != '') {
                    $(".question-area-block").html(question_response_layout);
                }
            }
        });
    });

    $(document).on('click', '.questions-nav-controls .review-btn', function (e) {
        var qattempt_id = $(".question-area .question-step").attr('data-qattempt');
        var thisObj = $(this);
        jQuery.ajax({
            type: "POST",
            url: '/question_attempt/jump_review',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"qattempt_id": qattempt_id},
            success: function (return_data) {
                var question_response_layout = return_data.question_response_layout;
                if (question_response_layout != '') {
                    $(".question-area-block").html(question_response_layout);
                    $(".quiz-pagination").remove();
                    $(".right-content").remove();
                }
            }
        });
    });


}







