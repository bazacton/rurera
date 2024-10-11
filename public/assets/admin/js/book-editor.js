var stage_created = false;
$(document).on('click', '.control-tool-item', function () {
    //$(".field-options").addClass('hide');
    $('.control-tool-item').removeClass('active');
    $(this).addClass('active');
    //$('body').css('cursor', "pointer");
});

$(document).on('click', '.next-page', function () {
    var thisObj = $(".book-dropzone.active");
    if (thisObj.next().hasClass('book-dropzone') == true) {
        thisObj.next().removeClass('hide');
        thisObj.next().addClass('active');
        thisObj.addClass('hide');
        thisObj.removeClass('active');
    }
});
$(document).on('click', '.prev-page', function () {
    var thisObj = $(".book-dropzone.active");
    if (thisObj.prev().hasClass('book-dropzone') == true) {
        thisObj.prev().removeClass('hide');
        thisObj.prev().addClass('active');
        thisObj.addClass('hide');
        thisObj.removeClass('active');
    }
});


$(document).on('click', '.book-dropzone', function (e) {
    var dropZonObj = $(this);
    var drag_type = $('.control-tool-item.active').attr('data-drag_type');
    var drag_object = $('.control-tool-item.active').attr('data-drag_object');
    var shape_type = $('.control-tool-item.active').attr('data-shape_type');
    var item_path = $('.control-tool-item.active').attr('data-item_path');

    var attribute_type = $('.control-tool-item.active').attr('data-attribute_type');
    var attribute_value = $('.control-tool-item.active').attr('data-attribute_value');
    var item_title = $('.control-tool-item.active').attr('title');
	

    $('.control-tool-item').removeClass('active');
	var unique_id = Math.floor((Math.random() * 99999) + 1);
    var field_random_number = 'rand_' + unique_id;
	

    if (drag_type == "text") {
        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="p-fields" data-paragraph_value="Test text here..." data-color="#000000"><div class="field-data customizable-field data_style_field data_html_field" data-html_id="text_html" data-style_id="text_color" contenteditable="true">Test text here...</div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
            $el.attr('data-' + attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "highlighter") {

        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="highlighter-fields" data-background=""><div class="field-data"><div class="stage-shapes resizeable data_style_field" data-style_id="highlighter_size"><div class="customizable-field text-highlighter data_style_field" data-style_id="highlighter_background"></div></div></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
            $el.attr('data-' + attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "stage" || drag_type == "path" || drag_type == "stage_objects" || drag_type == "topic" || drag_type == "infolink" || drag_type == "misc") {
		
		
		var svg_code = $(".svgs-data ."+drag_object+"_svg").html();

        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px; width:42px;" data-info_width="42" data-item_title="'+item_title+'" data-unique_id="'+unique_id+'" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-item_path="' + item_path + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-'+drag_object+'-fields" data-item_type="'+drag_object+'" data-paragraph_value="Test text here..."><div class="field-data">'+svg_code+'</div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "look_for_clues") {
        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-look_for_clues-fields" data-paragraph_value="Test text here..."><div class="field-data"><img src="/assets/default/img/book-icons/look_for_clues.png"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "picture_in_your_mind") {
        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-picture_in_your_mind-fields" data-paragraph_value="Test text here..."><div class="field-data"><img src="/assets/default/img/book-icons/picture_in_your_mind.png"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "try_do_it_yourself") {
        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-try_do_it_yourself-fields" data-paragraph_value="Test text here..."><div class="field-data"><img src="/assets/default/img/book-icons/try_do_it_yourself.png"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "think_and_remember") {
        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-think_and_remember-fields" data-paragraph_value="Test text here..."><div class="field-data"><img src="/assets/default/img/book-icons/think_and_remember.png"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "facts") {
        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-facts-fields" data-paragraph_value="Test text here..."><div class="field-data"><img src="/assets/default/img/book-icons/facts.png"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "quiz") {

        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-trigger_class="infobox-quiz-fields"><div class="field-data"><img src="/assets/default/img/book-icons/quiz.png"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "topicsss") {

        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-topic_title="" data-trigger_class="infobox-topic-fields"><div class="field-data"><img src="/assets/default/img/book-icons/quiz.png"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }

    if (drag_type == "map") {

        var $el = $('<div style="left:' + e.offsetX + 'px; top:' + e.offsetY + 'px;" data-is_new="yes" class="drop-item form-group draggablecl field_settings draggable_field_' + field_random_number + '" data-id="' + field_random_number + '" data-field_type="' + drag_type + '" data-topic_title="" data-trigger_class="infobox-map-fields"><div class="field-data"><img src="/assets/default/img/book-icons/map.svg" width="500"></div>');
        //$el.append('<span class="field-handle fas fa-arrows-alt"></span><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('<a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a>');
        $el.append('</div>');
        if (!EditorIsEmpty(attribute_type)) {
            $el.find('.customizable-field').css(attribute_type, attribute_value);
        }
        dropZonObj.append($el);
    }


    /*
    * Draggable
    */
    $('.draggable_field_' + field_random_number)
    .rotatable()
    .draggable({
        preventCollision: true,
        containment: dropZonObj
    })
    .off('wheel'); // Unbinds all wheel events from this element

	$('.draggable_field_' + field_random_number).resizable({
        resize: function(event, ui) {
			$(".field-options").find('.trigger_field[data-field_name="width"]').val(ui.size.width);
			$(".field-options").find('.trigger_field[data-field_name="width"]').change();
        }
    });
	
	$('.colorpickerinput').colorpicker({
		format: 'hex',
	});
	
	var z_index = $(".editor-objects-list li").length+1;
	if( item_title != undefined){
		$(".editor-objects-list").append('<li data-id="'+field_random_number+'" data-field_postition="'+z_index+'">'+item_title+' <i class="fa fa-trash"></i><i class="fa fa-lock"></i><i class="fa fa-sort"></i><i class="fa fa-copy"></i></li>');
		$(".editor-objects-list").sortable({
			update: function(event, ui) {
				sorting_render(); // Call your function here
			}
		});
	}
	
	sorting_render();
	
	
	$(".field_settingss").rotatable({
        angle: 0,
        rotation: function(event, ui) {
        }
    });
	

});

function sorting_render(){
	$('.editor-objects-list li').each(function (index_id, thisObj) {
		index_id++;
		$(thisObj).attr('data-field_postition', index_id);
		var data_id = $(thisObj).attr('data-id');
		$(".draggable_field_" + data_id).css('z-index', index_id);
		$(".draggable_field_" + data_id).attr('data-field_postition', index_id);
	});
}

$(document).on('click', '.page_settings', function (e) {
	if (!$(e.target).is($(this))) {
		return false;
	}
	$('.page_settings').removeClass('active');
	$(this).addClass('active');
    $(".field-options").html('');
    var fieldObj = $(this);
    var field_id = fieldObj.data('id');
    var parent_field_id = field_id;
    var trigger_class = fieldObj.data('trigger_class');
    $(".field-options").html('<h4 class="properties-title">Page Properties</h4> '+$('.' + trigger_class).html());
	$('.field_settings').removeClass('active');
    $(".field-options .trigger_field").attr('data-id', field_id);
	
	$('.field-options .trigger_field').each(function () {
        var field_id = $(this).data('field_id');
        var field_type = $(this).data('field_type');
        var field_value = fieldObj.attr('data-' + field_id);
        if (field_type != 'image') {
			
			if( field_id == 'page_graph'){
				if( field_value == 1){
					$(this).closest('.custom-switch').find(".custom-switch-input").prop('checked', true);
				}
			}
			$(this).val(field_value);
        }

    });
	
	$('.field-options .trigger_field').change();
	$('.colorpickerinput').colorpicker({
		format: 'hex',
	});
});
var subject_topics_list = [];
$(document).on('click', '.field_settings', function (e) {
    $(".field-options").html('');
    var fieldObj = $(this);
    var field_id = fieldObj.data('id');
	var item_title = fieldObj.attr('data-item_title');
	var parent_field_id = field_id;
    var trigger_class = fieldObj.data('trigger_class');
	console.log(trigger_class);
    $(".field-options").html('<h4 class="properties-title">'+item_title+' Properties</h4> '+$('.' + trigger_class).html());
	
	$('.field_settings').removeClass('active');
	$(this).addClass('active');
	$('.editor-objects-list li').removeClass('active');
	$('.editor-objects-list li[data-id="'+field_id+'"]').addClass('active');

    $('.field-options .trigger_field').each(function () {
		var currentFieldObj = $(this);
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
		
		if (field_type == 'select') {
            $(this).addClass('search-questions-select2_' + parent_field_id);
            var select_data = [];
            if (!EditorIsEmpty(field_value)) {
                $.ajax({
                    type: "GET",
                    url: '/admin/questions_bank/get_questions_by_ids',
                    data: {'questions_ids': field_value},
                    success: function (return_data) {
                        var select_data = return_data;
                        handleMultiSelect2('search-questions-select2_' + parent_field_id, '/admin/questions_bank/search', 'title', select_data);
                        var selected_values = [];
                        $.each(select_data, function (index, valueObj) {
                            selected_values.push(valueObj.id);
                        });
                        $('.search-questions-select2_' + parent_field_id).val(selected_values).trigger('change');
                    }
                });
            } else {
                handleMultiSelect2('search-questions-select2_' + parent_field_id, '/admin/questions_bank/search', 'title', select_data);
            }

        }
		

		if (field_type == 'select_topic') {
			
			
			$.each(subject_topics_list, function(title, id) {
				currentFieldObj.append($('<option>', {
					value: id,
					text: title,
					selected: id == field_value
				}));
			});
			
		}
        if (field_type == 'select_info') {
            var book_page_id = $(".book-dropzone.active").attr('data-page_id');
            $(this).addClass('search-infobox-select2_' + parent_field_id);
            var select_data = [];
            if (!EditorIsEmpty(field_value)) {
                $.ajax({
                    type: "GET",
                    url: '/admin/books/get_infobox_by_ids',
                    data: {'book_page_id': book_page_id, 'infobox_ids': field_value},
                    success: function (return_data) {
                        var select_data = return_data;
                        handleMultiSelect2('search-infobox-select2_' + parent_field_id, '/admin/books/' + book_page_id + '/searchinfobox', 'title', select_data);
                        var selected_values = [];
                        $.each(select_data, function (index, valueObj) {
                            selected_values.push(valueObj.id);
                        });
                        $('.search-infobox-select2_' + parent_field_id).val(selected_values).trigger('change');
                    }
                });
            } else {
                handleMultiSelect2('search-infobox-select2_' + parent_field_id, '/admin/books/' + book_page_id + '/searchinfobox', 'title', select_data);
            }

        }

        $("ul.select2-selection__rendered").sortable({});

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
	$('.field-options .trigger_field').change();
	$('.colorpickerinput').colorpicker({
		format: 'hex',
	});
});

$(document).on('keyup change keydown click', '.field-options .trigger_field', function (e) {
    trigger_field_change($(this));
});

$(document).on('click', '.editor-objects-list li .fa-trash', function (e) {
	if( $(this).closest('li').hasClass('locked-object')){
		return false;
	}
    var data_id  = $(this).closest('li').attr('data-id');
	$('.field_settings[data-id="'+data_id+'"]').remove();
	$(this).closest('li').remove();
	sorting_render();
});

$(document).on('click', '.editor-objects-list li .fa-unlock', function (e) {
	$(this).removeClass('fa-unlock');
	$(this).addClass('fa-lock');
	$(this).closest('li').addClass('locked-object');
    var data_id  = $(this).closest('li').attr('data-id');
	$('.field_settings[data-id="'+data_id+'"]').addClass('locked-object');
	$('.draggable_field_' + data_id).resizable("disable");
	$('.draggable_field_' + data_id).draggable("disable");
	$('.draggable_field_' + data_id).rotatable("disable");
});

$(document).on('click', '.editor-objects-list li .fa-lock', function (e) {
	$(this).removeClass('fa-lock');
	$(this).addClass('fa-unlock');
	$(this).closest('li').removeClass('locked-object');
    var data_id  = $(this).closest('li').attr('data-id');
	$('.field_settings[data-id="'+data_id+'"]').removeClass('locked-object');
	$('.draggable_field_' + data_id).resizable("enable");
	$('.draggable_field_' + data_id).draggable("enable");
	$('.draggable_field_' + data_id).rotatable("enable");
	
});


function trigger_field_change(thisObj) {
    var data_id = thisObj.attr('data-id');
    var field_type = thisObj.attr('data-field_type');
    var field_id = thisObj.attr('data-field_id');
    var field_name = thisObj.attr('data-field_name');
    var this_value = thisObj.val();
	var inner_style = $(".draggable_field_" + data_id).attr('data-inner_style');
	inner_style  = ( inner_style == undefined)? '' : inner_style;
    if (field_type == 'select' || field_type == 'select_info') {

        this_value = this_value.join(",");
    }
	
	if (field_type == 'select_topic') {
		
		if( this_value === null){
			this_value = '';
		}
    }

    this_value = this_value.replace(/\n/g, '<br />');

    $(".draggable_field_" + data_id).attr('data-' + field_id, this_value);
    if (field_type == 'text') {
        $(".draggable_field_" + data_id + ' .field-data').html(this_value);
    }
	
	if (field_type == 'style') {
		$(".draggable_field_" + data_id).css(field_name,this_value);
        //$(".draggable_field_" + data_id + ' .field-data').html(this_value);
    }
	
	if (field_type == 'page_style') {
		var this_value_number = this_value;	
		if( field_name == 'height'){
			this_value = this_value+'px';	
		}
		if( field_name == 'graph'){
			if( this_value == 1){
				$(".page_settings.active").addClass('graph-background');
			}else{
				$(".page_settings.active").removeClass('graph-background');
			}
		}else{
			$(".page_settings.active").css(field_name,this_value);
		}
        //$(".draggable_field_" + data_id + ' .field-data').html(this_value);
		$(".page_settings.active").attr('data-'+field_id, this_value_number);
    }
	
	if (field_type == 'svg_style') {
		if( field_name == 'width'){
			this_value = this_value+'px';	
		}
		$(".draggable_field_" + data_id).find('svg').css(field_name,this_value);
        //$(".draggable_field_" + data_id + ' .field-data').html(this_value);
		$(".draggable_field_" + data_id).attr('data-inner_style', $(".draggable_field_" + data_id).find('svg').attr('style'));
    }
	
	if (field_type == 'svg_path_style') {
		
		$(".draggable_field_" + data_id).find('svg').find('path').css(field_name,this_value);
		$(".draggable_field_" + data_id).find('svg').find('rect').css(field_name,this_value);
		$(".draggable_field_" + data_id).attr('data-inner_style', $(".draggable_field_" + data_id).find('svg').find('path').attr('style'));
		$(".draggable_field_" + data_id).attr('data-inner_style', $(".draggable_field_" + data_id).find('svg').find('rect').attr('style'));
    }
	
	
	
	if (field_type == 'topic_checkbox') {
		var field_title = thisObj.attr('data-topic_title');
		$(".draggable_field_" + data_id).attr('data-' + field_id, field_title);
        $(".draggable_field_" + data_id + ' .field-data').html(field_title);
    }
	
	
}


jQuery(document).ready(function () {
    $(".editor-zone").on("contextmenu", function () {
        return false;
    });
	
	
		$('.saved-item-class').click();
		
		
		
	
		
		

    $('.book-dropzone .field_settings').each(function () {
        var dropZonObj = $(this).closest('.book-dropzone');
        var field_id = $(this).attr('data-id');
		
		
		$(document).on('keydown', function(event) {
			const $activeElement = $('.draggable_field_' + field_id + '.active');
			
			if( $activeElement.hasClass('locked-object')){
				return false;
			}
			
			if ($activeElement.length) {
				if ($(event.target).attr('class') == '') {
					event.preventDefault(); // Prevent the default scroll action
				}

				let leftPos = parseInt($activeElement.css('left'));
				let topPos = parseInt($activeElement.css('top'));
				
				switch(event.which) {
					case 37: // Left arrow key
						$activeElement.css('left', leftPos - 1 + 'px');
						break;
						
					case 39: // Right arrow key
						$activeElement.css('left', leftPos + 1 + 'px');
						break;
						
					case 38: // Up arrow key
						$activeElement.css('top', topPos - 1 + 'px');
						break;
						
					case 40: // Down arrow key
						$activeElement.css('top', topPos + 1 + 'px');	
						break;
				}
			}
		});
		
		$('.draggable_field_' + field_id)
			.rotatable()
			.draggable({
				preventCollision: true,
				containment: dropZonObj
			})
			.off('wheel'); // Unbinds all wheel events from this element
			$('.draggable_field_' + field_id).resizable({
				resize: function(event, ui) {
					$(".field-options").find('.trigger_field[data-field_name="width"]').val(ui.size.width);
					$(".field-options").find('.trigger_field[data-field_name="width"]').change();
				}

			});
		
    });

    $(document).on('click', '.book-dropzone .remove', function (e) {
		if( $(this).closest('.field_settings').hasClass('locked-object')){
			return false;
		}
		var data_id = $(this).closest('.field_settings').attr('data-id');
		$('.editor-objects-list li[data-id="'+data_id+'"]').remove();
		sorting_render();
        $(this).parent().detach();
        //$(".field-options").addClass('hide');
    });

    $(document).on('stylechanged', '.resizeable', function (e) {
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


$(document).on('change', '.custom-switch-input', function (e) {
	var this_value = 0;
	 if ($(this).is(':checked')) {
		 this_value = 1;
	 }
	$(this).closest('.custom-switch').find('.trigger_field').val(this_value);
	$(this).closest('.custom-switch').find('.trigger_field').change();
});
$(document).on('click', '.generate', function (e) {
	
	
	var posted_data = generate_stage_area();
	var book_page_id = $(".book-dropzone.active").attr('data-page_id');

    $.ajax({
        type: "POST",
        url: '/admin/books/'+book_page_id+'/store_page',
        data: posted_data,
        success: function (return_data) {
            Swal.fire({icon: "success", html: '<h3 class="font-20 text-center text-dark-blue">Page Successfully Updated</h3>', showConfirmButton: !1});
        }
    });

});


$(document).on('change', 'select[name="subject_id"]', function (e) {
	
	var year_id = $(".category-id-field").val();
	var subject_id = $(this).val();

    $.ajax({
		type: "GET",
		url: '/admin/learning_journey/get_topics',
		data: {'year_id': year_id, 'subject_id': subject_id},
		success: function (return_data) {
			subject_topics_list = JSON.parse(return_data);
			if( stage_created == false){
				$('.saved-item-class').click();
				stage_created = true;
			}
			
		}
	});

});


function generate_stage_area(){
	var posted_data = {};
	//posted_data['levels'] = {};
	$(".book-dropzone.active").each(function (index) {
		var page_id = $(this).attr('data-page_id');
		//posted_data['levels'][page_id] = {};
		
		//posted_data['levels'][page_id]['background'] = $(this).attr('data-page_background');
		//posted_data['levels'][page_id]['height'] = $(this).attr('data-page_height');
		//posted_data['levels'][page_id]['page_graph'] = $(this).attr('data-page_graph');
		$(this).find(".field_settings").each(function (index) {
			var fieldObj = $(this);
			var data_values = {};
			var field_style = field_position_top = field_position_left = '';
			var field_position = fieldObj.position();
			if (field_position != undefined && field_position != 'undefined') {
				var field_style = 'style="top:' + field_position.top + 'px;left:' + field_position.left + 'px;position: absolute;width: max-content;"';
				var field_position_top = field_position.top;
				var field_position_left = field_position.left;
			}

			var field_style = fieldObj.attr('style');
			var inner_style = fieldObj.attr('data-inner_style');

			var field_id = fieldObj.data('id');
			var field_type = fieldObj.data('field_type');
			var trigger_class = fieldObj.data('trigger_class');
			var is_new = fieldObj.attr('data-is_new');
			var item_type = fieldObj.attr('data-item_type');
			var item_path = fieldObj.attr('data-item_path');
			var unique_id = fieldObj.attr('data-unique_id');
			var item_title = fieldObj.attr('data-item_title');
			


			posted_data[field_id] = {};


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
			});

			posted_data[field_id]['page_id'] = page_id;
			posted_data[field_id]['field_type'] = field_type;
			posted_data[field_id]['field_style'] = field_style;
			posted_data[field_id]['data_values'] = data_values;
			posted_data[field_id]['item_type'] = item_type;
			posted_data[field_id]['item_path'] = item_path;
			posted_data[field_id]['inner_style'] = inner_style;
			posted_data[field_id]['unique_id'] = unique_id;
			posted_data[field_id]['item_title'] = item_title;
			posted_data[field_id]['is_new'] = is_new;
		});
	});
	
	return posted_data;
}
