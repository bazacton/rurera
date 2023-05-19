$(document).on('click', '.control-tool-item', function () {
    $(".field-options").addClass('hide');
    $('.control-tool-item').removeClass('active');
    $(this).addClass('active');
});


$(document).on('click', '.book-dropzone', function (e) {
    var dropZonObj = $(this);
    var drag_type = $('.control-tool-item.active').attr('data-drag_type');
    var shape_type = $('.control-tool-item.active').attr('data-shape_type');

    var attribute_type = $('.control-tool-item.active').attr('data-attribute_type');
    var attribute_value = $('.control-tool-item.active').attr('data-attribute_value');

    $('.control-tool-item').removeClass('active');
    var field_random_number = 'rand_' + Math.floor((Math.random() * 99999) + 1);

    if (drag_type == "text") {
        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="p-fields" data-paragraph_value="Test text here..." data-color="#000000"><div class="field-data customizable-field data_style_field data_html_field" data-html_id="text_html" data-style_id="text_color" contenteditable="true">Test text here...</div>');
        $el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
            $el.attr('data-' + attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "highlighter") {

        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="highlighter-fields" data-background=""><div class="field-data"><div class="stage-shapes resizeable data_style_field" data-style_id="highlighter_size"><div class="customizable-field text-highlighter data_style_field" data-style_id="highlighter_background"></div></div></div>');
        $el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
            $el.attr('data-' + attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "check_it_makes_sense") {

        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-check_it_makes_sense-fields" data-paragraph_value="Test text here..."><div class="field-data"><img src="/assets/default/img/book-icons/infobox.png"></div>');
        $el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }


    /*
    * Draggable
    */
    $('.draggable_field_' + field_random_number).draggable({
        preventCollision: true,
        containment: dropZonObj,
        handle: ".field-handle",
    });

});

$(document).on('click', '.field_settings', function (e) {
    $(".field-options").html('');
    $(".field-options").addClass('hide');
    var fieldObj = $(this);
    var field_id = fieldObj.data('id');
    var parent_field_id = field_id;
    var trigger_class = fieldObj.data('trigger_class');
    $(".field-options").html($('.' + trigger_class).html());

    $('.field-options .trigger_field').each(function () {
        var field_id = $(this).data('field_id');
        var field_type = $(this).data('field_type');
        var field_value = fieldObj.attr('data-' + field_id);
        if (field_type != 'image') {
            $(this).val(field_value);
        }
        if (field_type == 'texteditor') {
            if (!EditorIsEmpty(field_value)) {
                $(this).val(EditorValueDecode(field_value));
            }
            $(this).addClass('summernote-editor_' + parent_field_id);
        }

        $('.summernote-editor_' + parent_field_id).summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
            ],
            callbacks: {
                onChange: function (contents, $editable) {
                    $('.summernote-editor_' + parent_field_id).val(EditorValueEnocde(contents));
                    trigger_field_change($('.summernote-editor_' + parent_field_id));
                }
            }
        });

    });

    if (!EditorIsEmpty($('.' + trigger_class).html())) {
        $(".field-options").removeClass('hide');
    }
    $(".field-options .trigger_field").attr('data-id', field_id);
});

$(document).on('keyup', '.field-options .trigger_field', function (e) {
    trigger_field_change($(this));
});


function trigger_field_change(thisObj) {
    var data_id = thisObj.data('id');
    var field_type = thisObj.data('field_type');
    var field_id = thisObj.data('field_id');
    var this_value = thisObj.val().replace(/\n/g, '<br />');

    $(".draggable_field_" + data_id).attr('data-' + field_id, this_value);
    if (field_type == 'text') {
        $(".draggable_field_" + data_id + ' .field-data').html(this_value);
    }
}


jQuery(document).ready(function () {
    $('.book-dropzone .field_settings').each(function () {
        var dropZonObj = $(this).closest('.book-dropzone');
        var field_id = $(this).attr('data-id');
        $('.draggable_field_' + field_id).draggable({
            preventCollision: true,
            containment: dropZonObj,
            handle: ".field-handle",
        });
    });

    $(document).on('click', '.book-dropzone .remove', function (e) {
        $(this).parent().detach();
        $(".field-options").addClass('hide');
    });

    $(document).on('stylechanged', '.resizeable', function (e) {
        console.log('height-changed');
    });


});


function EditorValueEnocde(input) {
    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;
    input = EditorUtf8Encode(input);
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
    return JSON.stringify(output);
}


function EditorUtf8Encode(string) {
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


function EditorValueDecode(input) {
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
    output = EditorUtf8Decode(output);
    return output;
}

function EditorUtf8Decode(input) {
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

function EditorIsEmpty(dataValue) {
    is_empty = true;
    if (dataValue != '' && dataValue != 'undefined' && dataValue != undefined) {
        is_empty = false;
    }
    return is_empty;
}


$(document).on('click', '.generate', function (e) {
    var book_page_id = $(".book-dropzone ").attr('data-page_id');
    var posted_data = [];
    $(".book-dropzone ").find(".field_settings").each(function (index) {
        var fieldObj = $(this);
        var data_values = [];
        var field_style = field_position_top = field_position_left = '';
        var field_position = fieldObj.position();
        if (field_position != undefined && field_position != 'undefined') {
            var field_style = 'style="top:' + field_position.top + 'px;left:' + field_position.left + 'px;position: absolute;width: max-content;"';
            var field_position_top = field_position.top;
            var field_position_left = field_position.left;
        }

        var field_style = fieldObj.attr('style');


        var field_id = fieldObj.data('id');
        var field_type = fieldObj.data('field_type');
        var trigger_class = fieldObj.data('trigger_class');
        var is_new = fieldObj.attr('data-is_new');


        posted_data[field_id] = [];

        /*question_fields_obj[group_id]['fields'][field_id] = {};
        question_fields_obj[group_id]['fields'][field_id]['field_style'] = field_style;
        question_fields_obj[group_id]['fields'][field_id]['field_position_top'] = field_position_top;
        question_fields_obj[group_id]['fields'][field_id]['field_position_left'] = field_position_left;
        question_fields_obj[group_id]['fields'][field_id]['field_type'] = field_type;*/


        $(this).find(".data_style_field").each(function (index) {
            var style_id = $(this).attr('data-style_id');
            var style_value = $(this).attr('style');
            data_values[style_id] = style_value;
        });

        $(this).find(".data_html_field").each(function (index) {
            var html_id = $(this).attr('data-html_id');
            var html_value = $(this).html();
            data_values[html_id] = html_value;
        });




        $('.' + trigger_class).find(".trigger_field").each(function (index) {
            var triggerObj = $(this);

            var attr_id = triggerObj.data('field_id');
            var attr_value = fieldObj.attr('data-' + triggerObj.data('field_id'));
            data_values[attr_id] = attr_value;
            //question_fields_obj[group_id]['fields'][field_id][attr_id] = attr_value;
        });

        posted_data[field_id]['book_page_id'] = book_page_id;
        posted_data[field_id]['field_type'] = field_type;
        posted_data[field_id]['field_style'] = field_style;
        posted_data[field_id]['data_values'] = data_values;
        posted_data[field_id]['is_new'] = is_new;





    });
    console.log(posted_data);
    //var post_data = {'book_page_id': book_page_id,'field_type':field_type, 'field_style':field_style, 'data_values' : data_values };
    /*$.ajax({
       type: "POST",
       url: '/admin/books/store_page',
       data: post_data,
       success: function (return_data) {
          console.log(return_data);
       }
   });*/

})
;
