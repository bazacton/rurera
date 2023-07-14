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
    var user_question_layout = thisForm.find('.question-layout').html();
    var user_question_layout = leform_encode64(JSON.stringify(user_question_layout));
    $('.question-all-good').remove();
    $(this).closest('form').find('.editor-field').each(function () {
        $(this).removeClass('validate-error');
        var field_name = $(this).attr('name');
        var field_id = $(this).attr('id');
        var field_identifier = field_id;
        var field_identifier = field_identifier.replace(/field-/g, '');
        var field_type = $(this).attr('type');
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
            "qresult_id": qresult_id,
            "qattempt_id": qattempt_id,
            "user_question_layout": user_question_layout,
            "time_consumed": time_consumed
        },
        success: function (return_data) {
            console.log(return_data);
            var question_status_class = (return_data.incorrect_flag == true) ? 'incorrect' : 'correct';
            $(".quiz-pagination ul li[data-question_id='" + question_id + "']").addClass(question_status_class);
            if (return_data.incorrect_flag == true && return_data.show_fail_message == true) {

                /*var question_response_layout = return_data.question_response_layout;
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

                thisForm.find('.question-submit-btn').remove();
                thisForm.find('.form-btn').append('<span class="question-all-good">All Not Good</span>');
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

                thisForm.find('.question-submit-btn').remove();
                if (return_data.incorrect_flag == true) {
                    thisForm.find('.form-btn').append('<span class="question-all-good">All Not Good</span>');
                }else {

                    thisForm.find('.form-btn').append('<span class="question-all-good">All Good</span>');

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

    jQuery('.question-layout').find(".lms-sorting-fields").each(function () {
        var this_id = $(this).attr('id');
        new Sortable(this_id, {
            animation: 150
        });
    });

}



function init_question_functions() {

    console.log('init_question_functions');



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

        stem_lines.each(function() {
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
        $("#"+data_id).val(selected_value);
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
        if(stem_lines.length>0){
          stem.addClass('matched');
        } else{
          stem.removeClass('matched');
        }

      }
    });


    function lineDistance(x, y, x0, y0) {
        return Math.sqrt((x -= x0) * x + (y -= y0) * y);
      }

      function line_exists(stem, option) {
        var $exists = false;
        $(".line").each(function() {
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
          $(line).offset({ top: pointA.top, left: pointA.left });
        } else {
          $(line).offset({ top: pointB.top, left: pointA.left });
        }
      }




    $("p.given").html(chunkWords($("p.given").text()));
    $("span.given").draggable({
        helper: "clone",
        revert: "invalid"
    });
    makeDropText($("p.given span.w"));

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





    var currentRequest = null;
    $(document).on('click', '.quiz-pagination ul li, .questions-nav-controls .prev-btn, .questions-nav-controls .next-btn', function (e) {
        console.log('testing4444');
        if( $(this).hasClass('correct') || $(this).hasClass('incorrect')){
            return;
        }
        $(".quiz-pagination ul li").removeClass('active');
        $(this).addClass('active');
        var question_id = $(this).attr('data-question_id');
        //$('.quiz-pagination ul li[data-question_id="'+question_id+'"]').click();
        var qattempt_id = $(".question-area .question-step").attr('data-qattempt');

        var questions_layout_obj = JSON.parse($('.question-area-block').attr('data-questions_layout'));
        var questions_layout = [];
        var questions_layout_obj = $.map(questions_layout_obj, function (value, index) {
            questions_layout[index] = value;
        });

        var question_layout = leform_decode64(questions_layout[question_id]);
        var question_layout = JSON.parse(question_layout);
        $(".question-area-block").html(question_layout);

        currentRequest = jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: '/question_attempt/mark_as_active',
            beforeSend : function()    {
                console.log(currentRequest);
                if(currentRequest != null) {
                    currentRequest.abort();
                }
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"question_id": question_id, "qattempt_id": qattempt_id},
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
    $('.quiz-pagination ul li[data-question_id="' + active_question_id + '"]').click();

    function rurera_lookup(array, prop, value) {
        for (var i = 0, len = array.length; i < len; i++) {
            if (array[i] && array[i][prop] === value) {
                return array[i];
            }
        }
    }

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
                    //$(".question-area-block").html(question_response_layout);
                    $(".question-step").html(question_response_layout);

                    //$(".quiz-pagination").remove();
                    //$(".right-content").remove();
                }
            }
        });
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

function leform_random_string(_length) {
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

function leform_utf8encode(string) {
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

function leform_encode64(input) {
    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;
    input = leform_utf8encode(input);
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

function leform_utf8decode(input) {
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

function leform_decode64(input) {
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
    output = leform_utf8decode(output);
    return output;
}

function leform_esc_html__(_string) {
    var string;
    if (typeof leform_translations == typeof {} && leform_translations.hasOwnProperty(_string)) {
        string = leform_translations[_string];
        if (string.length == 0)
            string = _string;
    } else
        string = _string;
    return leform_escape_html(string);
}

//Match Draw


function lineDistance(x, y, x0, y0) {
    return Math.sqrt((x -= x0) * x + (y -= y0) * y);
  }

  function line_exists(stem, option) {
    var $exists = false;
    $(".line").each(function() {
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
      $(line).offset({ top: pointA.top, left: pointA.left });
    } else {
      $(line).offset({ top: pointB.top, left: pointA.left });
    }
  }
