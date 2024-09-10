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
const startRecordButton = $('#startRecord');
const stopRecordButton = $('#stopRecord');
const saveRecordButton = $('#saveRecord');
const audioPlayer = $('#audioPlayer')[0];
const timer = $('#timer');
const timeLeftElement = $('#timeLeft');

let mediaRecorder;
let timerInterval;
let audioChunks = [];
let timeLimit = 60; // Set the time limit in seconds

var quiz_user_data = [];
var attempted_questions = 0;
quiz_user_data[0] = {};
quiz_user_data[0]['attempt'] = {};
quiz_user_data[0]['incorrect'] = {};
quiz_user_data[0]['correct'] = {};
var QuestionSubmitRequest = null;
var question_submit_process = false;
var Questioninterval = null;


$("body").off("click", ".question-submit-btn").on("click", ".question-submit-btn", function (e) {
//$(document).on('click', '.question-submit-btn', function (e) {
    e.preventDefault();
    var bypass_validation = $(".question-submit-btn").attr('data-bypass_validation');
    if( question_submit_process == true){
        return false;
    }
    question_submit_process = true;
    returnType = rurera_validation_process($(this).closest('form'));

    if( rurera_is_field(bypass_validation) && bypass_validation == 'yes' ){
        returnType = true;
    }
    if (returnType == false) {
        //jQuery.noConflict();
        //$("#validation_error").modal('show');
        /*var error_message = $.growl.error({
           message: 'Please fill all the required fields before submitting.',
           duration: 10000,
        });*/
        question_submit_process = false;
        return false;
    }

    //question_submit_process = false;
    if(rurera_is_field(Questioninterval)) {
        clearInterval(Questioninterval);
    }

    rurera_loader($(this), 'div');

    var quiz_type = $(".question-area-block").attr('data-type');
    if (!rurera_is_field(quiz_type)) {
        quiz_type = 'quiz';
    }

    var question_data = [];
    question_data[0] = {};
    var appricate_words_array = ['Wonderful', 'Excellent', 'Brilliant', 'Fantastic', 'Spectacular', 'Gorgeous', 'Exceptional', 'Marvelous', 'Extrodinary'];
    var appricate_word = appricate_words_array[Math.floor(Math.random() * appricate_words_array.length)];
    var appricate_colors_array = ['red', 'orange', 'blue', 'green'];
    var appricate_color = appricate_colors_array[Math.floor(Math.random() * appricate_colors_array.length)];
    var thisObj = $(this);
    var attempt_id = $(".question-area .question-step").attr('data-qattempt');
    var quiz_result_id = $(".question-area .question-step").attr('data-quiz_result_id');
    var time_consumed = $(".question-area .question-step").attr('data-elapsed');
    console.log(time_consumed);


    var total_elapsed_time = $(".range-price").attr('data-time_elapsed');
    var start_time = thisObj.closest('.question-step').attr('data-start_time');
    var time_consumed_bk = parseInt(total_elapsed_time) - parseInt(start_time);

    var question_no = $(this).attr('data-question_no');
    var total_questions = thisObj.closest('.questions-data-block').attr('data-total_questions');
    var thisForm = $(this).closest('form');
    var question_id = $(this).closest('form').data('question_id');
    var defination_text = $(this).closest('form').data('defination');
    var user_question_layout = thisForm.find('.question-layout').html();
    var user_question_layout = rureraform_encode64(JSON.stringify(user_question_layout));
    $('.question-all-good').remove();
    $(this).closest('form').find('.editor-field').each(function () {
        $(this).removeClass('validate-error');
        var field_name = $(this).attr('name');
        var field_id = $(this).attr('id');
        var field_identifier = field_id;
        var field_identifier = field_identifier.replace(/field-/g, '');
        var field_type = $(this).attr('type');
        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
        var field_value = $(this).val();


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

    QuestionSubmitRequest = jQuery.ajax({
        type: "POST",
        url: '/question_attempt/validation',
        dataType: 'json',
        beforeSend: function () {
            if (QuestionSubmitRequest != null) {
                QuestionSubmitRequest.abort();
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "question_id": question_id,
            "question_data": question_data,
            "qresult_id": qresult_id,
            "qattempt_id": qattempt_id,
            "user_question_layout": user_question_layout,
            "time_consumed": time_consumed
        },
        success: function (return_data) {
            attempted_questions = parseInt(attempted_questions)+1;
            question_submit_process = false;
            var question_status_class = (return_data.incorrect_flag == true) ? 'incorrect' : 'correct';


            if (rurera_is_field(return_data.updated_questions_layout) && return_data.updated_questions_layout != '') {
                var updated_questions_layout = return_data.updated_questions_layout;

                $(".question-area-block").attr('data-questions_layout', updated_questions_layout);
            }
            if (rurera_is_field(return_data.next_question_id) && return_data.next_question_id != 0) {
               var next_question_id = return_data.next_question_id;
               console.log(next_question_id);
                $('.next-btn').attr('data-question_id', next_question_id);
           }

            if (rurera_is_field(return_data.total_points)) {
                $(".lms-quiz-section").attr('data-total_points', return_data.total_points);
            }
            var quiz_type = return_data.quiz_type;
            $(".quiz-pagination ul li[data-question_id='" + question_id + "']").addClass(question_status_class);
            if( return_data.is_complete == true) {
                $(".question-area-block").html('Thank you for attempting!');


                thisObj.closest('.questions-data-block').find('.right-content').addClass('hide');
                $(".quiz-complete").show(2000);


                quiz_user_data = chimp_encode64(JSON.stringify(quiz_user_data));

                


                if (quiz_type != 'book_page' && quiz_type != 'vocabulary') {
                    window.location.href = '/panel/quizzes/' + quiz_result_id + '/check_answers';
                }
                if (quiz_type == 'vocabulary') {
                    $("#spell_test_complete_modal").modal('show');
                }



            } else {

            if (return_data.incorrect_flag == true && return_data.show_fail_message == true) {
                var question_response_layout = return_data.question_response_layout;
                /*
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
                */
                /*var fail_page_link = '/panel/questions/' + question_id + '/fail';
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
                    });*/

                if (quiz_type == 'book') {
                    if (question_response_layout != '') {
                        var question_response_layout = return_data.question_response_layout;
                        $(".question-area-block").html(question_response_layout);
                    }
                } else {
                    //$(".question-layout-block").html(return_data.question_response_layout);


                    if (quiz_type == 'vocabulary') {
                        if (rurera_is_field(return_data.question_correct_answere)) {
                            if (return_data.question_correct_answere != '') {
                                //$(".question-correct-answere").html(return_data.question_correct_answere);
                                $(".editor-field").addClass(question_status_class);
                                //$(".nub-of-sec").html('');
                                clearInterval(Questioninterval);
                                //jQuery.noConflict();
                                $(".question-status-modal .modal-box .modal-title span.inc").html(return_data.question_user_input);
                                $(".question-status-modal .modal-box .modal-title span.cor").html(return_data.question_correct_answere);

                                $(".question-status-modal .modal-box p").html(defination_text);
                                $(".question-status-modal .modal-box p").html(defination_text+'<audio autoPlay="" className="player-box-audio" id="audio_file_4492" src="/speech-audio/wrong-answer.mp3"></audio>');

                                $("#question_status_modal").modal('show');
                                $(".confirm-btn").focus();
                            }
                        }
                    } else{

                        //thisForm.find('.question-submit-btn').remove();
                        if (quiz_type == 'practice') {
                            //$("#quiz_question_status_modal").modal('show');
                            thisForm.find('.show-notifications').html('<span class="question-status-wrong">Thats incorrect, but well done for trying</span>');
                            thisForm.find('.show-notifications').append('<audio autoPlay="" className="player-box-audio" id="audio_file_4492" src="/speech-audio/wrong-answer.mp3"></audio>');
                            if (rurera_is_field(return_data.question_solution)) {
                                thisForm.find('.show-notifications').append(return_data.question_solution);
                            }
                            thisForm.find('.question-submit-btn').addClass('rurera-hide');
                            thisForm.find('.question-next-btn').removeClass('rurera-hide');
                            $(".quiz-status-bar").removeClass('rurera-hide');


                        }else {
                            const interval = setInterval(() => {
                                console.log('interval-test');
                                $('#next-btn')[0].click();
                                clearInterval(interval);
                            }, 3000);
                        }
                    }
                }
            } else {

                quiz_user_data[0]['correct'][question_id] = question_data_array;

                /*var marks_count = thisForm.find('.marks').attr('data-marks');
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
                thisObj.closest('.question-area').find('.correct-appriciate').html(appricate_word);
                thisObj.closest('.question-area').find('.correct-appriciate').addClass(appricate_color);
                thisObj.closest('.question-area').find('.correct-appriciate').show(300).delay(2000).hide(300);*/
                var next_question_no = parseInt(question_no) + 1;

                if (quiz_type == 'vocabulary') {
                    $(".spells-quiz-sound").append('<audio autoPlay="" className="player-box-audio" id="audio_file_4492" src="/speech-audio/correct-answer.mp3"></audio>');
                }else{
                    if (quiz_type == 'practice') {
                        $(".question-layout-block").append('<audio autoPlay="" className="player-box-audio" id="audio_file_4492" src="/speech-audio/correct-answer.mp3"></audio>');
                    }
                }

                if (quiz_type != 'book') {
                    //thisForm.find('.question-submit-btn').remove();
                }
                if (return_data.incorrect_flag == true) {

                    if (quiz_type == 'practice') {
                        thisForm.find('.show-notifications').html('<span class="question-status-wrong">Thats incorrect, but well done for trying</span>');

                    }else {
                        if (quiz_type == 'book') {
                            if (question_response_layout != '') {
                                var question_response_layout = return_data.question_response_layout;
                                $(".question-area-block").html(question_response_layout);
                            }
                        } else {
                            const interval = setInterval(() => {
                                $('#next-btn')[0].click();
                                clearInterval(interval);
                            }, 3000);
                        }
                    }

                } else {

                    if (quiz_type == 'book') {
                        if (question_response_layout != '') {
                            var question_response_layout = return_data.question_response_layout;
                            $(".question-area-block").html(question_response_layout);
                        }
                    }

                    if (quiz_type == 'practice' || quiz_type == 'vocabulary') {
                        thisForm.find('.show-notifications').html('<span class="question-status-correct">Well done! Thats exactly right.</span>');
                        if (rurera_is_field(return_data.question_solution)) {
                            thisForm.find('.show-notifications').append(return_data.question_solution);
                        }
                        thisForm.find('.question-submit-btn').addClass('rurera-hide');
                        thisForm.find('.question-next-btn').removeClass('rurera-hide');
                        $(".quiz-status-bar").removeClass('rurera-hide');
                    }
                    else {
                        const interval = setInterval(() => {
                            $('#next-btn')[0].click();
                            clearInterval(interval);
                        }, 3000);
                    }


                    /*
                    var question_response_layout = return_data.question_response_layout;
                    if (question_response_layout != '') {
                        $(".question-step").css({display: "none"}).hide().animate({opacity: 0});
                        thisObj.closest('.questions-data-block').find('.question-fields').show(2500);
                        $(".question-step.question-step-" + next_question_no).css({display: "block"}).show(3000).animate({opacity: 1});

                        var question_response_layout = return_data.question_response_layout;
                        var messageInterval = setTimeout(function () {
                            $(".question-area-block").html(question_response_layout);
                            clearInterval(messageInterval);
                        }, 2000);


                        var total_elapsed_time = $(".range-price").attr('data-time_elapsed');
                        $(".question-step").attr('data-start_time', total_elapsed_time);
                        */

                    if (question_response_layout == '') {
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
    makeDropText($("p.given span.w"));

}


function init_question_functions() {


    sort_init();


    $(document).on('click', '.match-question .stems li', function (e) {
        stem = $(this);
        stem.toggleClass("selected");

        $(".match-question .stems li")
            .not(stem)
            .removeClass("selected");

        $(".match-question .options li").removeClass("selected");
        $(".match-question .line").removeClass("highlighted");

        if (stem.hasClass("selected")) {
            var stem_lines = $('.match-question .line[data-stem="' + stem.attr("id") + '"]');
            stem_lines.addClass("highlighted");

            stem_lines.each(function () {
                var $option = $(this).data("option");
                $('.match-question .options li[id="' + $option + '"]').addClass("selected");
            });
            $(".options").addClass("ready");
        } else {
            $(".options").removeClass("ready");
            $('.match-question .line[data-stem="' + stem.attr("id") + '"]').removeClass(
                "highlighted"
            );
        }
    });

    $(document).on('click', '.match-question .options li', function (e) {
        if ($(".options").hasClass("ready")) {
            $(this).toggleClass("selected");
            var stem = $(".match-question .stems li.selected");
            var selected_value = stem.attr('id');
            var data_id = $(this).attr('data-id');
            $("#" + data_id).val(selected_value);
            var option = $(this);
            if (!line_exists(stem, option)) {
                $('.match-question .line[data-stem="' + stem.attr("id") + '"]').remove();
                drawLine(stem, option);
            } else {
                $(
                    '.match-question .line[data-stem="' +
                    stem.attr("id") +
                    '"][data-option="' +
                    option.attr("id") +
                    '"]'
                ).remove();
            }

            var stem_lines = $('.match-question .line[data-stem="' + stem.attr("id") + '"]');
            if (stem_lines.length > 0) {
                stem.addClass('matched');
            } else {
                stem.removeClass('matched');
            }

        }
    });


    function lineDistance(x, y, x0, y0) {
        return Math.sqrt((x -= x0) * x + (y -= y0) * y);
    }

    function line_exists(stem, option) {
        var $exists = false;
        $(".line").each(function () {
            if (
                $(this).data("stem") === stem.attr("id") &&
                $(this).data("option") === option.attr("id")
            ) {
                $exists = true;
            }
        });
        return $exists;
    }

    function drawLine(stem, option) {
        var pointA = stem.offset();
        pointA.left = pointA.left + stem.outerWidth();
        pointA.top = pointA.top + stem.outerHeight() / 2;
        var pointB = option.offset();
        pointB.top = pointB.top + option.outerHeight() / 2;
        var angle =
            Math.atan2(pointB.top - pointA.top, pointB.left - pointA.left) *
            180 /
            Math.PI;
        var distance = lineDistance(
            pointA.left,
            pointA.top,
            pointB.left,
            pointB.top
        );

        var line = $('<div class="line highlighted"/>');
        line.append($('<div class="point"/>'))
        line.attr("data-stem", stem.attr("id"));
        line.attr("data-option", option.attr("id"));
        $(".match-question").append(line);
        line.css("transform", "rotate(" + angle + "deg)");

        // Set Width
        line.css("width", distance + "px");

        // Set Position
        line.css("position", "absolute");

        if (pointB.top > pointA.top) {
            $(line).offset({top: pointA.top, left: pointA.left});
        } else {
            $(line).offset({top: pointB.top, left: pointA.left});
        }
    }


    $("p.given").html(chunkWords($("p.given").text()));
    $("span.given").draggable({
        helper: "clone",
        revert: "invalid"
    });
    makeDropText($("p.given span.w"));

    if( $(".droppable_area").length > 0) {
    console.log('droppable-area-test');
    $(".droppable_area").droppable({
        drop: function (event, ui) {
            // Clone the dropped element
            var clone = ui.helper.clone();
            if ($(this).html() == '') {
                $(this).append($(clone).html());
                $(".droppable_area .draggable-option").on("dblclick", function () {
                    $(this).remove();
                });
            }
        }
    });
    $(".draggable-items li").draggable({revert: "invalid", helper: "clone"});
}

    //sort_init();
    $(document).on('click', '.flag-question.notflaged', function (e) {
        var question_id = $(this).attr('data-question_id');
        var qresult_id = $(this).attr('data-qresult_id');

        var thisObj = $(this);
        jQuery.ajax({
            type: "POST",
            url: '/question_attempt/flag_question',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"question_id": question_id, "qresult_id": qresult_id, "flag_type": 'flag'},
            success: function (return_data) {
                $(".quiz-pagination li[data-question_id='" + question_id + "']").addClass('has-flag');
                thisObj.removeClass('notflaged');
                thisObj.addClass('flaged');
            }
        });
    });



    $(document).on('click', '.flag-question.flaged', function (e) {
        var question_id = $(this).attr('data-question_id');
        var qresult_id = $(this).attr('data-qresult_id');
        var thisObj = $(this);
        jQuery.ajax({
            type: "POST",
            url: '/question_attempt/flag_question',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"question_id": question_id, "qresult_id": qresult_id, "flag_type": 'unflag'},
            success: function (return_data) {
                $(".quiz-pagination li[data-question_id='" + question_id + "']").removeClass('has-flag');
                thisObj.removeClass('flaged');
                thisObj.addClass('notflaged');
            }
        });
    });
    $(document).on('click', '.confirm-btn', function (e) {
        $('#next-btn')[0].click();
    });
    $(document).on('click', '.question-next-btn', function (e) {
        $('#next-btn')[0].click();
    });

    $(document).on('keyup', 'body', function (evt) {
        if( $(".question-area").hasClass('spell-question-area')){
            return;
        }
        if (evt.key === 'ArrowLeft') {
            $('#prev-btn')[0].click();
        }
        if (evt.key === 'ArrowRight') {
            $('#next-btn')[0].click();
        }
        if (evt.key === 'Enter') {
            if(rurera_is_field(Questionintervals)) {
                console.log('inner enter');
                console.log(Questionintervals);
                clearInterval(Questionintervals);
            }
            $('#question-submit-btn')[0].click();
        }
    });

    $(document).on('click', '.marking-quiz-data .Selectable', function (e) {
        $(this).addClass('marking-selected');
    });
    $(document).on('dblclick', '.marking-quiz-data .Selectable', function (e) {
        $(this).removeClass('marking-selected');
    });

    var currentRequest = null;
    $("body").on('click', '.quiz-pagination ul li, .questions-nav-controls .prev-btn, .questions-nav-controls .next-btn', function (e) {

        if ($(this).hasClass('disable-btn')) {
            return;
        }
        console.log('pagination-test-click-auto');


        if (!$(this).hasClass('swiper-slide')) {
            rurera_loader($(this), 'div');
        }

        var question_id = $(this).attr('data-question_id');
        var actual_question_id = $(this).attr('data-actual_question_id');
        var li_obj = $('.quiz-pagination ul li[data-question_id="' + question_id + '"]');
        if ($(this).hasClass('correct') || $(this).hasClass('incorrect')) {
            return;
        }
        if (li_obj.hasClass('correct') || li_obj.hasClass('incorrect')) {
            li_obj.click();
            return;
        }
        $(".quiz-pagination ul li").removeClass('active');
        $(this).addClass('active');
        $('.quiz-pagination ul li[data-question_id="' + question_id + '"]').addClass('active');
        var qattempt_id = $(".question-area .question-step").attr('data-qattempt');

        var questions_layout_obj = JSON.parse($('.question-area-block').attr('data-questions_layout'));
        var questions_layout = [];
        var questions_layout_obj = $.map(questions_layout_obj, function (value, index) {
            questions_layout[index] = value;
        });




        var question_layout = rureraform_decode64(questions_layout[question_id]);

        var question_layout = JSON.parse(question_layout);


        $(".question-area-block").html(question_layout);
        var quizQuestionID = $(".question-area-block").find('.question-fields').attr('data-question_id');

        var total_points = $(".lms-quiz-section").attr('data-total_points');
        if( rurera_is_field(total_points) == true && total_points != ''){
            $(".spells-quiz-info .total-points span").html(total_points+' ');
        }

        $("p.given").html(chunkWords($("p.given").text()));
        $("span.given").draggable({
            helper: "clone",
            revert: "invalid"
        });
        makeDropText($("p.given span.w"));

        if($(".lms-sorting-fields").length > 0) {
            $('.lms-sorting-fields').sortable({
                animation: 150
            });
        }

        if( $(".droppable_area").length > 0) {
            $(".droppable_area").droppable({
                drop: function (event, ui) {
                    // Clone the dropped element
                    var clone = ui.helper.clone();
                    if ($(this).html() == '') {
                        $(this).append($(clone).html());
                        $(".droppable_area .draggable-option").on("dblclick", function () {
                            $(this).remove();
                        });
                    }
                }
            });
            $(".draggable-items li").draggable({revert: "invalid", helper: "clone"});
        }
       var duration_type = $(".question-area-block").attr('data-duration_type');
       var time_interval = $(".question-area-block").attr('data-time_interval');
       var practice_time = $(".question-area-block").attr('data-practice_time');
       var time_counter = $(".question-step-"+quizQuestionID).attr('data-time_counter');
       if(rurera_is_field(time_counter)){
           time_interval = time_counter;
       }


        if( rurera_is_field(duration_type) && duration_type == 'per_question') {
                clearInterval(Quizintervals);
                $('.quiz-timer-counter').html(time_interval);
                $('.quiz-timer-counter').attr('data-time_counter', time_interval);
                Quizintervals = setInterval(function () {
                    var quiz_timer_counter = $('.quiz-timer-counter').attr('data-time_counter');
                    quiz_timer_counter = parseInt(quiz_timer_counter) - parseInt(1);
                    $('.quiz-timer-counter').html(getTime(quiz_timer_counter));
                    if($('.nub-of-sec').length > 0){
                        $('.nub-of-sec').html(getTime(quiz_timer_counter));
                    }
                    $('.quiz-timer-counter').attr('data-time_counter', quiz_timer_counter);

                    if (duration_type == 'per_question') {
                        if (parseInt(quiz_timer_counter) == 0) {
                            clearInterval(Quizintervals);
                            $('.question-submit-btn').attr('data-bypass_validation', 'yes');
                            $('#question-submit-btn')[0].click();
                        }
                    }

                }, 1000);
            }

        //question_layout_functions();

        if(rurera_is_field(Questioninterval)) {
            clearInterval(Questioninterval);
        }
        var Questioninterval = setInterval(function () {
            var seconds_count = $(".question-step-"+quizQuestionID).attr('data-elapsed');
            seconds_count = parseInt(seconds_count) + parseInt(1);
            $(".question-step-"+quizQuestionID).attr('data-elapsed', seconds_count);
        }, 1000);

        if( $('#sound-icon-'+quizQuestionID).length > 0) {
            $('#sound-icon-'+quizQuestionID).removeClass('pause');
            $('#sound-icon-'+quizQuestionID).click();
        }


        //Temporary Commented
        currentRequest = jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: '/question_attempt/mark_as_active1',
            async: true,
            beforeSend: function () {
                console.log(currentRequest);
                if (currentRequest != null) {
                    currentRequest.abort();
                }
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"question_id": question_id, "qattempt_id": qattempt_id, "actual_question_id": actual_question_id},
            success: function (return_data) {
                console.log(return_data);
            }
        });

    });

    $(document).on('click', '.quiz-pagination ul li.correct, .quiz-pagination ul li.incorrect', function (e) {
        var question_id = $(this).attr('data-question_id');
        $(".quiz-pagination ul li").removeClass('active');
        $(this).addClass('active');
        var qattempt_id = $(".question-area .question-step").attr('data-qattempt');
        var qresult_id = $(this).attr('data-qresult_id');
        var thisObj = $(this);
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: '/question_attempt/jump_question',
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
    var active_question_id = $(".question-area-block").attr('data-active_question_id');
    console.log('active_question_id-'+active_question_id);
    if( rurera_is_field(active_question_id)) {
        console.log('is_field-active_question_id-'+active_question_id);
        $('.active-question-btn[data-question_id="' + active_question_id + '"]').click();
    }

    function rurera_lookup(array, prop, value) {
        for (var i = 0, len = array.length; i < len; i++) {
            if (array[i] && array[i][prop] === value) {
                return array[i];
            }
        }
    }




    $(document).on('click', '.questions-nav-controls .review-btn', function (e) {
        var qattempt_id = $(".question-area .question-step").attr('data-qattempt');
        var total_questions = $(".question-area").attr('data-total_questions');

        $(".review_submit .modal-body p").html('You have attempted ' + attempted_questions + ' questions out of ' + total_questions + '. Are you sure you want to submit?');


        /*var thisObj = $(this);
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
                    $(".question-step").html(question_response_layout);
                }
            }
        });*/
    });

    $(document).on('click', '.question-review-btn', function (e) {
        var question_id = $(this).attr('data-id');
        var element = document.getElementById('review-btn_'+question_id);
        if (element) {
            var event = new MouseEvent("click", {
                bubbles: true,
                cancelable: true,
                view: window
            });
            element.dispatchEvent(event);
        }
    });

    $(document).on('click', '.submit_quiz_final', function (e) {
        var qattempt_id = $(".question-area .question-step").attr('data-qattempt');
        var quiz_result_id = $(".question-area .question-step").attr('data-quiz_result_id');
        rurera_loader($(this), 'div');
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
                window.location.href = '/panel/quizzes/' + quiz_result_id + '/check_answers';
            }
        });
    });




    startRecordButton.on('click', async () => {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

        mediaRecorder = new MediaRecorder(stream);
        mediaRecorder.ondataavailable = event => {
            if (event.data.size > 0) {
                audioChunks.push(event.data);
            }
        };

        mediaRecorder.onstop = () => {
            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
            const audioUrl = URL.createObjectURL(audioBlob);
            audioPlayer.src = audioUrl;
        };

        timerInterval = setInterval(function () {
            timeLimit--;
            console.log(timeLimit);
            timeLeftElement.text(timeLimit);
            if (timeLimit <= 0) {
                clearInterval(timerInterval);
                stopRecording();
            }
        }, 1000);

        mediaRecorder.start();
        startRecordButton.prop('disabled', true);
        stopRecordButton.prop('disabled', false);
        saveRecordButton.prop('disabled', true);
    });

    function stopRecording() {
        mediaRecorder.stop();
        console.log(timerInterval);
        clearInterval(timerInterval);
        startRecordButton.prop('disabled', false);
        stopRecordButton.prop('disabled', true);
        saveRecordButton.prop('disabled', false);
        timeLeftElement.text('0');
    }

    stopRecordButton.on('click', stopRecording);

    saveRecordButton.on('click', () => {
        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });

        // Send the audio blob to a PHP script for MP3 conversion and saving.
        const formData = new FormData();
        formData.append('audio', audioBlob);

        $.ajax({
            type: 'POST',
            url: 'convert.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Handle the response from the server if needed.
            }
        });

        audioChunks = [];
        saveRecordButton.prop('disabled', true);
    });




}


function textWrapper(str, sp) {
    if (sp == undefined) {
        sp = [
            0,
            0
        ];
    }
    var txt = str;
    if (sp[0]) {
        txt = "&nbsp;" + txt;
    }
    if (sp[1]) {
        txt = txt + "&nbsp;";
    }
    return "<span class='w'>" + txt + "</span>";
}

function makeDropText(obj) {
    return obj.droppable({
        drop: function (e, ui) {
            var txt = ui.draggable.text();
            var newSpan = textWrapper(txt, [1, 0]);
            $(this).after(newSpan);
            makeBtn($(this).next("span.w"));
            makeDropText($(this).next("span.w"));
            $("span.w.ui-state-highlight").removeClass("ui-state-highlight");
        },
        over: function (e, ui) {
            $(this).add($(this).next("span.w")).addClass("ui-state-highlight");
        },
        out: function () {
            $(this).add($(this).next("span.w")).removeClass("ui-state-highlight");
        }
    });
}

function chunkWords(p) {
    var into_type = $(".insert-into-sentense-holder").attr('data-into_type');
    var words = p.split("");
    console.log(p);
    if (into_type == 'words') {
        var words = p.split(" ");
    }
    console.log(words);
    words[0] = textWrapper(words[0], [0, 1]);
    var i;
    for (i = 1; i < words.length; i++) {
        if (words[0].indexOf(".")) {
            words[i] = textWrapper(words[i], [1, 0]);
        } else {
            words[i] = textWrapper(words[i], [1, 1]);
        }
    }
    return words.join("");
}

function rureraform_random_string(_length) {
    var length, text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    if (typeof _length == "undefined")
        length = 16;
    else
        length = _length;
    for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

function rureraform_utf8encode(string) {
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

function rureraform_encode64(input) {
    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;
    input = rureraform_utf8encode(input);
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

function rureraform_utf8decode(input) {
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

function rureraform_decode64(input) {
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
    output = rureraform_utf8decode(output);
    return output;
}

function rureraform_esc_html__(_string) {
    var string;
    if (typeof rureraform_translations == typeof {} && rureraform_translations.hasOwnProperty(_string)) {
        string = rureraform_translations[_string];
        if (string.length == 0)
            string = _string;
    } else
        string = _string;
    return rureraform_escape_html(string);
}

//Match Draw


function lineDistance(x, y, x0, y0) {
    return Math.sqrt((x -= x0) * x + (y -= y0) * y);
}

function line_exists(stem, option) {
    var $exists = false;
    $(".line").each(function () {
        if (
            $(this).data("stem") === stem.attr("id") &&
            $(this).data("option") === option.attr("id")
        ) {
            $exists = true;
        }
    });
    return $exists;
}

function drawLine(stem, option) {
    var pointA = stem.offset();
    pointA.left = pointA.left + stem.outerWidth();
    pointA.top = pointA.top + stem.outerHeight() / 2;
    var pointB = option.offset();
    pointB.top = pointB.top + option.outerHeight() / 2;
    var angle =
        Math.atan2(pointB.top - pointA.top, pointB.left - pointA.left) *
        180 /
        Math.PI;
    var distance = lineDistance(
        pointA.left,
        pointA.top,
        pointB.left,
        pointB.top
    );

    var line = $('<div class="line highlighted"/>');
    line.append($('<div class="point"/>'))
    line.attr("data-stem", stem.attr("id"));
    line.attr("data-option", option.attr("id"));
    $(".question").append(line);
    line.css("transform", "rotate(" + angle + "deg)");

    // Set Width
    line.css("width", distance + "px");

    // Set Position
    line.css("position", "absolute");

    if (pointB.top > pointA.top) {
        $(line).offset({top: pointA.top, left: pointA.left});
    } else {
        $(line).offset({top: pointB.top, left: pointA.left});
    }
}

function rurera_loader(thisObj, loader_type, display_text = null) {

    switch (loader_type) {
        case "div":
            thisObj.addClass('rurera-processing');
            thisObj.append('<div class="rurera-button-loader" style="display: block;">\n\
                   <div class="spinner">\n\
                       <div class="double-bounce1"></div>\n\
                       <div class="double-bounce2"></div>\n\
                   </div>\n\
               </div>');

            break;

        case "button":
            thisObj.wrap('<div class="rurera-loader-holder"></div>');
            thisObj.closest('.rurera-loader-holder').addClass('rurera-processing');
            thisObj.closest('.rurera-loader-holder').append('<div class="rurera-button-loader" style="display: block;">\n\
                    <div class="spinner">\n\
                        <div class="double-bounce1"></div>\n\
                        <div class="double-bounce2"></div>\n\
                    </div>\n\
                </div>');

            break;

        case "page":
            $('body').addClass('rurera-processing');
            $('body').append('<div class="rurera-button-loader" style="display: block;">\n\
                <div class="spinner">\n\
                    <div class="double-bounce1"></div>\n\
                    <div class="double-bounce2"></div>\n\
                </div>\n\
            </div>');

            break;

        case "animation":
                $('body').addClass('rurera-processing');
                var loader_no = Math.floor(Math.random() * (3 - 1 + 1)) + 1;
                loader_no = 4;
                var preloader_text = '';
                if( display_text != null && display_text != ''){
                    preloader_text = '<span class="preloader-text">'+display_text+'</span>';
                }
                $('body').append('<div class="rurera-button-loader" style="display: block;">\n\
                    <div class="preloader"><img src="/assets/default/img/preloaders/'+loader_no+'.webp">'+preloader_text+'</div>\n\
                </div>');
            break;
    }
}

function rurera_remove_loader(thisObj, loader_type) {
    switch (loader_type) {
        case "button":
            thisObj.removeClass('rurera-processing');
            thisObj.unwrap('.rurera-loader-holder');
            $('body').removeClass('rurera-processing');
            $('body').find('.rurera-button-loader').remove();
            break;
        case "page":
            $('body').removeClass('rurera-processing');
            $('body').find('.rurera-button-loader').remove();
            break;
    }
}

/*
 * Validation Process by Form
 */
function rurera_validation_process(form_name) {
    var has_empty = new Array();
    var alert_messages = new Array();
    var radio_fields = new Array();
    var checkbox_fields = new Array();
    form_name.find('.rurera-req-field, .editor-field, .editor-fields').each(function (index_no) {
        is_visible = true;
        var thisObj = jQuery(this);
        index_no = rurera_is_field(index_no) ? index_no : 0;
        var visible_id = thisObj.data('visible');
        has_empty[index_no] = false;
        checkbox_fields[index_no] = false;
        if (rurera_is_field(visible_id) == true) {
            is_visible = jQuery("#" + visible_id).is(':hidden');
            if (jQuery("#" + visible_id).css('display') !== 'none') {
                is_visible = true;
            } else {
                is_visible = false;
            }
        }
        /*if (thisObj.attr('type') == 'checkbox') {
            thisObj = jQuery("#" + thisObj.attr('name'));
            if (thisObj.val() == 'off') {
                thisObj.val('');
            }
        }*/
        if (thisObj.attr('type') == 'radio') {
            var field_name = thisObj.attr('name');
            var is_field_checked = jQuery('input[name="' + field_name + '"]').is(':checked');
            if (is_field_checked == false) {
                radio_fields[index_no] = thisObj;
            }
            //has_empty[index_no] = true;
            is_visible = false;
        }
        if (thisObj.attr('type') == 'checkbox') {
            var field_name = thisObj.attr('name');
            var is_field_checked = jQuery('input[name="' + field_name + '"]').is(':checked');
            if (is_field_checked == false) {
                checkbox_fields[index_no] = thisObj;
            }
            //has_empty[index_no] = true;
            is_visible = false;
        }
        if (!thisObj.val() && is_visible == true) {
            if (thisObj.hasClass('rurera-req-field') || thisObj.hasClass('editor-field') || thisObj.hasClass('editor-fields')) {
                array_length = alert_messages.length;
                alert_messages[array_length] = rurera_insert_error_message(thisObj, alert_messages, '');
                has_empty[index_no] = true;
            }
        } else {
            if (is_visible == true) {
                has_empty[index_no] = rurera_check_field_type(thisObj, alert_messages, has_empty[index_no]);
            }
        }
        if (has_empty[index_no] == false) {
            thisObj.next('.chosen-container').removeClass('frontend-field-error');
            thisObj.next('.rurera-req-field').next('.pbwp-box').removeClass('frontend-field-error');
            thisObj.removeClass('frontend-field-error');
            thisObj.closest('.jqte').removeClass('frontend-field-error');
        }
    });
    if (radio_fields.length > 0) {
        for (i = 0; i < radio_fields.length; i++) {
            var thisnewObj = radio_fields[i];
            array_length = alert_messages.length;
            alert_messages[array_length] = rurera_insert_error_message(thisnewObj, alert_messages, '', 'radio');
            has_empty[i] = true;
        }
    }
    if (checkbox_fields.length > 0) {
        for (i = 0; i < checkbox_fields.length; i++) {
            var thisnewObj = checkbox_fields[i];
            if (rurera_is_field(thisnewObj)) {
                array_length = alert_messages.length;
                alert_messages[array_length] = rurera_insert_error_message(thisnewObj, alert_messages, '', 'checkbox');
                has_empty[i] = true;
            }
        }
    }
    var error_messages = ' test error message<br><br>';
    if (has_empty.length > 0 && jQuery.inArray(true, has_empty) != -1) {
        array_length = alert_messages.length;
        for (i = 0; i < array_length; i++) {
            if (i > 0) {
                error_messages = error_messages + '<br>';
            }
            error_messages = error_messages + alert_messages[i];
        }
        //jQuery.growl.remove();
        console.log(error_messages);
        /*var error_message = jQuery.growl.error({
            message: error_messages,
            duration: 10000,
        });*/
        return false;
    }
}

function rurera_is_field(field_value) {
    if (field_value != 'undefined' && field_value != undefined && field_value != '') {
        return true;
    } else {
        return false;
    }
}


/*
 * Making list of errors
 */
function rurera_insert_error_message(thisObj, alert_messages, error_msg, field_type = '') {
    thisObj.addClass('frontend-field-error');
    if (field_type == 'checkbox' || field_type == 'radio') {

        var field_name = thisObj.attr('name');
        $('[name="' + field_name + '"]').addClass('frontend-field-error');
    }

    if (thisObj.is('select')) {
        thisObj.next('.chosen-container').addClass('frontend-field-error');
        var field_label = thisObj.closest('.field-holder').children('label').html();
        if (rurera_is_field(field_label) == false) {
            var field_label = thisObj.find(":selected").text();
        }
        if (rurera_is_field(field_label) == false) {
            var field_label = thisObj.closest('.rurera-dev-appended-cats').children().children().children('label').html();
        }
    } else {
        var field_label = thisObj.closest('.field-holder').children('label').html();
        if (typeof field_label === 'undefined') {
            var field_label = thisObj.attr('placeholder');
        }
    }
    if (thisObj.is(':hidden')) {
        thisObj.next('.rurera-req-field').next('.pbwp-box').addClass('frontend-field-error');
    }
    if (thisObj.hasClass('rurera_editor')) {
        thisObj.closest('.jqte').addClass('frontend-field-error');
    }

    var res = '';
    if (typeof field_label !== "undefined") {
        res = field_label.replace("*", " ");
    } else {
        res = 'Label / Placeholder is missing';
    }
    return '* ' + res + error_msg;
}

/*
 * Check if Provided data for field is valid
 */

function rurera_check_field_type(thisObj, alert_messages, has_empty) {
    /*
     * Check for Email Field
     */
    if (thisObj.hasClass('rurera-email-field')) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        if (!pattern.test(thisObj.val())) {
            array_length = alert_messages.length;
            alert_messages[array_length] = rurera_insert_error_message(thisObj, alert_messages, ' is not valid Email!');
            has_empty = true;
        }
    }
    /*
     * Check for Number Field
     */
    if (thisObj.hasClass('rurera-number-field')) {
        var pattern = /[0-9 -()+]+$/;
        if (!pattern.test(thisObj.val())) {
            array_length = alert_messages.length;
            alert_messages[array_length] = rurera_insert_error_message(thisObj, alert_messages, 'is not valid Number!');
            has_empty = true;
        }
    }
    /*
     * Check for URL Field
     */
    if (thisObj.hasClass('rurera-url-field')) {
        var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
        if (!pattern.test(thisObj.val())) {
            array_length = alert_messages.length;
            alert_messages[array_length] = rurera_insert_error_message(thisObj, alert_messages, 'is not valid URL!');
            has_empty = true;
        }
    }
    /*
     * Check for Date Field
     */
    if (thisObj.hasClass('rurera-date-field')) {
        //var pattern = /([0-9][1-2])\/([0-2][0-9]|[3][0-1])\/((19|20)[0-9]{2})/;
        var pattern = /^\d{1,2}.\d{1,2}.\d{4} \d{2}:\d{2}$/;
        if (!pattern.test(thisObj.val())) {
            array_length = alert_messages.length;
            alert_messages[array_length] = rurera_insert_error_message(thisObj, alert_messages, 'is not valid Date!');
            has_empty = true;
        }
    }
    /*
     * Check for Range Field
     */
    if (thisObj.hasClass('rurera-range-field')) {
        var min_val = thisObj.data('min');
        var max_val = thisObj.data('max');
        if (!(thisObj.val() >= min_val) || !(thisObj.val() <= max_val)) {
            array_length = alert_messages.length;
            alert_messages[array_length] = rurera_insert_error_message(thisObj, alert_messages, 'is not in Range! ( ' + min_val + ' - ' + max_val + ' )');
            has_empty = true;
        }
    }
    return has_empty;
}

$(document).ready(function () {

});
