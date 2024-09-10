"use strict";
var rureraform_sending = false;
var rureraform_context_menu_object = null;
var rureraform_form_pages = new Array();
var rureraform_form_page_active = null;
var rureraform_form_elements = new Array();
var rureraform_form_last_id = 0;
var rureraform_integration_last_id = 0;
var rureraform_payment_gateway_last_id = 0;
var rureraform_form_changed = false;
var rureraform_css_tools = [{}];
var rureraform_font_weights = {
    '100': 'Thin',
    '200': 'Extra-light',
    '300': 'Light',
    '400': 'Normal',
    '500': 'Medium',
    '600': 'Demi-bold',
    '700': 'Bold',
    '800': 'Heavy',
    '900': 'Black'
};
var rureraform_preview_loading = false;
/* Dialog Popup - begin */
var rureraform_dialog_buttons_disable = false;
function rureraform_dialog_open(_settings) {
    var settings = {
        width: 480,
        height: 210,
        title: rureraform_esc_html__('Confirm action'),
        close_enable: true,
        ok_enable: true,
        cancel_enable: true,
        ok_label: rureraform_esc_html__('Yes'),
        cancel_label: rureraform_esc_html__('Cancel'),
        echo_html: function () {
            this.html(rureraform_esc_html__('Do you really want to continue?'));
            this.show();
        },
        ok_function: function () {
            rureraform_dialog_close();
        },
        cancel_function: function () {
            rureraform_dialog_close();
        },
        html: function (_html) {
            jQuery("#rureraform-dialog .rureraform-dialog-content-html").html(_html);
        },
        show: function () {
            jQuery("#rureraform-dialog .rureraform-dialog-loading").fadeOut(300);
        }
    }
    var objects = [settings, _settings],
            settings = objects.reduce(function (r, o) {
                Object.keys(o).forEach(function (k) {
                    r[k] = o[k];
                });
                return r;
            }, {});

    rureraform_dialog_buttons_disable = false;
    jQuery("#rureraform-dialog .rureraform-dialog-loading").show();
    jQuery("#rureraform-dialog .rureraform-dialog-title h3 label").html(settings.title);
    if (settings.close_enable)
        jQuery("#rureraform-dialog .rureraform-dialog-title a").show();
    else
        jQuery("#rureraform-dialog .rureraform-dislog-title a").hide();

    settings.echo_html();
    var window_height = Math.min(2 * parseInt((jQuery(window).height() - 100) / 2, 10), settings.height);
    var window_width = Math.min(Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 880), 960), settings.width);
    jQuery("#rureraform-dialog").height(window_height);
    jQuery("#rureraform-dialog").width(window_width);
    jQuery("#rureraform-dialog .rureraform-dialog-inner").height(window_height);
    jQuery("#rureraform-dialog .rureraform-dialog-content").height(window_height - 104);

    jQuery("#rureraform-dialog .rureraform-dialog-button").off("click");
    jQuery("#rureraform-dialog .rureraform-dialog-button").removeClass("rureraform-dialog-button-disabled");

    if (settings.ok_enable) {
        jQuery("#rureraform-dialog .rureraform-dialog-button-ok").find("label").html(settings.ok_label);
        jQuery("#rureraform-dialog .rureraform-dialog-button-ok").on("click", function (e) {
            e.preventDefault();
            if (!rureraform_dialog_buttons_disable && typeof settings.ok_function == "function") {
                settings.ok_function();
            }
        });
        jQuery("#rureraform-dialog .rureraform-dialog-button-ok").show();
    } else
        jQuery("#rureraform-dialog .rureraform-dialog-button-ok").hide();

    if (settings.cancel_enable) {
        jQuery("#rureraform-dialog .rureraform-dialog-button-cancel").find("label").html(settings.cancel_label);
        jQuery("#rureraform-dialog .rureraform-dialog-button-cancel").on("click", function (e) {
            e.preventDefault();
            if (!rureraform_dialog_buttons_disable && typeof settings.cancel_function == "function") {
                settings.cancel_function();
            }
        });
        jQuery("#rureraform-dialog .rureraform-dialog-button-cancel").show();
    } else
        jQuery("#rureraform-dialog .rureraform-dialog-button-cancel").hide();

    jQuery("#rureraform-dialog-overlay").fadeIn(300);
    jQuery("#rureraform-dialog").css({
        'top': '50%',
        'transform': 'translate(-50%, -50%) scale(1)',
        '-webkit-transform': 'translate(-50%, -50%) scale(1)'
    });
}
function rureraform_dialog_close() {
    jQuery("#rureraform-dialog-overlay").fadeOut(300);
    jQuery("#rureraform-dialog").css({
        'transform': 'translate(-50%, -50%) scale(0)',
        '-webkit-transform': 'translate(-50%, -50%) scale(0)'
    });
    setTimeout(function () {
        jQuery("#rureraform-dialog").css("top", "-3000px")
    }, 300);
    return false;
}
/* Dialog Popup - end */

/* Settings - begin */
function rureraform_settings_save(_button) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var button_object = _button;
    jQuery(button_object).find("i").attr("class", "fas fa-spinner fa-spin");
    jQuery(button_object).addClass("rureraform-button-disabled");
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: jQuery(".rureraform-settings-form").serialize(),
        success: function (return_data) {
            jQuery(button_object).find("i").attr("class", "fas fa-check");
            jQuery(button_object).removeClass("rureraform-button-disabled");
            var data;
            try {
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_global_message_show('success', data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(button_object).find("i").attr("class", "fas fa-check");
            jQuery(button_object).removeClass("rureraform-button-disabled");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}
/* Settings - end */

/* Form Editor - begin */
function rureraform_create() {
    var name = jQuery("#rureraform-create-name").val();
    if (name.length < 1)
        name = rureraform_esc_html__("Untitled Form");
    rureraform_form_options["name"] = name;
    jQuery(".rureraform-admin-create-overlay").fadeOut(300);
    jQuery(".rureraform-admin-create").fadeOut(300);
    if (rureraform_gettingstarted_enable == "on")
        rureraform_gettingstarted("create-form", 0);
    return false;
}
function rureraform_save(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    //jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    var post_pages = new Array();
    jQuery(".rureraform-pages-bar-item, .rureraform-pages-bar-item-confirmation").each(function () {
        var page_id = jQuery(this).attr("data-id");
        for (var i = 0; i < rureraform_form_pages.length; i++) {
            if (rureraform_form_pages[i] != null && rureraform_form_pages[i]['id'] == page_id) {
                post_pages.push(rureraform_encode64(JSON.stringify(rureraform_form_pages[i])));
                break;
            }
        }
    });
    var post_elements = new Array();
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (jQuery("#rureraform-element-" + i).length && rureraform_form_elements[i] != null)
            post_elements.push(rureraform_encode64(JSON.stringify(rureraform_form_elements[i])));
    }
    var post_data = {"action": "rureraform-form-save", "form-id": jQuery("#rureraform-id").val(), "form-options": rureraform_encode64(JSON.stringify(rureraform_form_options)), "form-pages": post_pages, "form-elements": post_elements};
    console.log(post_data);
    jQuery.ajax({
        type: "POST",
        url: 'store_quiz',
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_form_changed = false;
                    jQuery("#rureraform-id").val(data.form_id);
                    var url = window.location.href;
                    if (url.indexOf("&id=") < 0) {
                        history.pushState(null, null, url + "&id=" + data.form_id);
                        if (rureraform_gettingstarted_enable == "on")
                            rureraform_gettingstarted("form-saved", 0);
                    }
                    jQuery(".rureraform-header-using span").attr("data-id", data.form_id);
                    jQuery(".rureraform-header-using span").fadeIn(300);
                    jQuery(".rureraform-header-preview span").attr("data-id", data.form_id);
                    jQuery(".rureraform-header-preview span").fadeIn(300);
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).find("i").attr("class", "far fa-save");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "far fa-save");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

function rureraform_preview(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    var post_pages = new Array();
    jQuery(".rureraform-pages-bar-item, .rureraform-pages-bar-item-confirmation").each(function () {
        var page_id = jQuery(this).attr("data-id");
        for (var i = 0; i < rureraform_form_pages.length; i++) {
            if (rureraform_form_pages[i] != null && rureraform_form_pages[i]['id'] == page_id) {
                post_pages.push(rureraform_encode64(JSON.stringify(rureraform_form_pages[i])));
                break;
            }
        }
    });
    var post_elements = new Array();
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (jQuery("#rureraform-element-" + i).length && rureraform_form_elements[i] != null)
            post_elements.push(rureraform_encode64(JSON.stringify(rureraform_form_elements[i])));
    }
    var post_data = {"action": "rureraform-form-preview", "form-id": jQuery("#rureraform-id").val(), "form-options": rureraform_encode64(JSON.stringify(rureraform_form_options)), "form-pages": post_pages, "form-elements": post_elements};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery("#rureraform-preview-iframe").attr("data-loading", "true");
                    jQuery("#rureraform-preview .rureraform-admin-popup-title h3 span").text(data.form_name);
                    jQuery("#rureraform-preview-iframe").attr("src", data.preview_url);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                    jQuery(_object).find("i").attr("class", "far fa-eye");
                    rureraform_sending = false;
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                    jQuery(_object).find("i").attr("class", "far fa-eye");
                    rureraform_sending = false;
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                jQuery(_object).find("i").attr("class", "far fa-eye");
                rureraform_sending = false;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "far fa-eye");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

/* Form Editor - end */

/* Element actions - begin */
function _rureraform_element_delete(_i) {
    if (rureraform_form_elements[_i] == null)
        return;
    if (rureraform_form_elements[_i]['type'] == "columns") {
        for (var i = 0; i < rureraform_form_elements.length; i++) {
            if (rureraform_form_elements[i] == null)
                continue;
            if (rureraform_form_elements[i]["_parent"] == rureraform_form_elements[_i]['id'])
                _rureraform_element_delete(i);
        }
    }
    rureraform_form_elements[_i] = null;
}
function rureraform_element_delete(_object) {
    var message;
    var i = jQuery(_object).attr("id");
    i = i.replace("rureraform-element-", "");
    if (rureraform_form_elements[i] == null)
        return false;
    if (rureraform_form_elements[i]['type'] == 'columns')
        message = rureraform_esc_html__('Please confirm that you want to delete the element and all sub-elements.');
    else
        message = rureraform_esc_html__('Please confirm that you want to delete the element.');
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + message + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            _rureraform_element_delete(i);
            rureraform_build();
            rureraform_dialog_close();
        }
    });
    return false;
}
function _rureraform_element_duplicate(_parent_id, _new_parent_id, _i) {
    if (rureraform_form_elements[_i] == null)
        return;

    var clone = Object.assign({}, rureraform_form_elements[_i]);
    var j = rureraform_form_elements.push(clone);
    rureraform_form_last_id++;
    rureraform_form_elements[j - 1]["id"] = rureraform_form_last_id;
    rureraform_form_elements[j - 1]["_parent"] = _new_parent_id;
    if (_parent_id != _new_parent_id) {
        rureraform_form_elements[j - 1]["_parent-col"] = "0";
        rureraform_form_elements[j - 1]["_seq"] = rureraform_form_last_id;
    }
    if (rureraform_form_elements[_i]['type'] == "columns") {
        for (var i = 0; i < rureraform_form_elements.length; i++) {
            if (rureraform_form_elements[i] == null)
                continue;
            if (rureraform_form_elements[i]["_parent"] == rureraform_form_elements[_i]['id'])
                _rureraform_element_duplicate(rureraform_form_elements[j - 1]["id"], rureraform_form_elements[j - 1]["id"], i);
        }
    }
}
function rureraform_element_duplicate(_object, _page_num) {
    var message;
    var i = jQuery(_object).attr("id");
    i = i.replace("rureraform-element-", "");
    if (rureraform_form_elements[i] == null)
        return false;
    if (rureraform_form_elements[i]['type'] == 'columns')
        message = rureraform_esc_html__('Please confirm that you want to duplicate the element and all sub-elements.');
    else
        message = rureraform_esc_html__('Please confirm that you want to duplicate the element.');
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + message + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Duplicate'),
        ok_function: function (e) {
            if (rureraform_is_numeric(_page_num) && _page_num < rureraform_form_pages.length && rureraform_form_pages[_page_num] != null) {
                _rureraform_element_duplicate(rureraform_form_elements[i]['_parent'], rureraform_form_pages[_page_num]['id'], i);
            } else {
                _rureraform_element_duplicate(rureraform_form_elements[i]['_parent'], rureraform_form_elements[i]['_parent'], i);
            }
            rureraform_build();
            rureraform_dialog_close();
        }
    });
    return false;
}
function _rureraform_element_move(_parent_id, _i) {
    if (rureraform_form_elements[_i] == null)
        return;
    rureraform_form_elements[_i]["_parent"] = _parent_id;
    rureraform_form_elements[_i]["_parent-col"] = "0";
    rureraform_form_elements[_i]["_seq"] = rureraform_form_last_id;
}
function rureraform_element_move(_object, _page_num) {
    var message;
    var i = jQuery(_object).attr("id");
    i = i.replace("rureraform-element-", "");
    if (rureraform_form_elements[i] == null)
        return false;
    if (rureraform_form_elements[i]['type'] == 'columns')
        message = rureraform_esc_html__('Please confirm that you want to move the element and all sub-elements to other page.');
    else
        message = rureraform_esc_html__('Please confirm that you want to move the element to other page.');
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + message + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Move'),
        ok_function: function (e) {
            if (rureraform_is_numeric(_page_num) && _page_num < rureraform_form_pages.length && rureraform_form_pages[_page_num] != null) {
                _rureraform_element_move(rureraform_form_pages[_page_num]['id'], i);
            }
            rureraform_build();
            rureraform_dialog_close();
        }
    });
    return false;
}
var rureraform_element_properties_active = null;
var rureraform_element_properties_data_changed = false;
function _rureraform_properties_prepare(_object) {
    var properties, i, id, input_fields = new Array();
    var html = "", tab_html = "", tooltip_html = "";
    var sections_opened = 0;
    var icon_left, icon_right, options, options2, fonts, selected, temp;
    var type = jQuery(_object).attr("data-type");
    if (typeof type == undefined || type == "")
        return false;

    if (type == "settings") {
        properties = rureraform_form_options;
        jQuery("#rureraform-element-properties").find(".rureraform-admin-popup-title h3").html("<i class='fas fa-cogs'></i> " + rureraform_esc_html__("Form Settings"));
    } else if (type == "page" || type == "page-confirmation") {
        id = jQuery(_object).closest("li").attr("data-id");
        properties = null;
        for (var i = 0; i < rureraform_form_pages.length; i++) {
            if (rureraform_form_pages[i] != null && rureraform_form_pages[i]["id"] == id) {
                properties = rureraform_form_pages[i];
                break;
            }
        }
        jQuery("#rureraform-element-properties").find(".rureraform-admin-popup-title h3").html("<i class='far fa-copy'></i> " + rureraform_esc_html__("Page Settings"));
    } else {
        i = jQuery(_object).attr("id");
        i = i.replace("rureraform-element-", "");
        properties = rureraform_form_elements[i];
        jQuery("#rureraform-element-properties").find(".rureraform-admin-popup-title h3").html("<i class='fas fa-cog'></i> " + rureraform_esc_html__("Element Properties") + "<span><i class='" + rureraform_toolbar_tools[properties["type"]]["icon"] + "'></i> " + rureraform_escape_html(properties["name"]) + "</span>");
    }

    input_fields = rureraform_input_sort();

    // Prepare editor state - begin
    for (var key in rureraform_meta[type]) {
        if (rureraform_meta[type].hasOwnProperty(key)) {
            tooltip_html = "";
            if (rureraform_meta[type][key].hasOwnProperty('tooltip')) {
                tooltip_html = "<i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_meta[type][key]['tooltip'] + "</div>";
            }
            switch (rureraform_meta[type][key]['type']) {
                case 'tab':
                    for (var j = 0; j < sections_opened; j++)
                        html += "</div>";
                    sections_opened = 0;
                    if (tab_html == "")
                        tab_html += "<div id='rureraform-properties-tabs' class='rureraform-tabs'>";
                    else
                        html += "</div>";
                    tab_html += "<a class='rureraform-tab' href='#rureraform-tab-" + rureraform_meta[type][key]['value'] + "'>" + rureraform_meta[type][key]['label'] + "</a>";
                    html += "<div id='rureraform-tab-" + rureraform_meta[type][key]['value'] + "' class='rureraform-tab-content'>";
                    break;

                case 'sections':
                    options = "";
                    for (var section_key in rureraform_meta[type][key]['sections']) {
                        if (rureraform_meta[type][key]['sections'].hasOwnProperty(section_key)) {
                            if (options == "")
                                selected = "rureraform-section-active";
                            else
                                selected = "";
                            options += "<a class='" + selected + "' href='#rureraform-section-" + rureraform_escape_html(section_key) + "'><i class='" + rureraform_meta[type][key]['sections'][section_key]['icon'] + "'></i> " + rureraform_escape_html(rureraform_meta[type][key]['sections'][section_key]['label']) + "</a>";
                        }
                    }
                    html += "<h3 id='rureraform-" + key + "' class='rureraform-sections'>" + options + "</h3>";
                    break;

                case 'section-start':
                    html += "<div id='rureraform-section-" + rureraform_escape_html(rureraform_meta[type][key]['section']) + "' class='rureraform-section-content'>";
                    sections_opened++;
                    break;

                case 'section-end':
                    if (sections_opened > 0) {
                        html += "</div>";
                        sections_opened--;
                    }
                    break;

                case 'style':
                    options = rureraform_styles_html();
                    temp = "<div class='rureraform-properties-content-9dimes'><div class='rureraform-styles-select-container'>" + options + "</div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['style']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><a class='rureraform-admin-button' href='#' onclick='return rureraform_stylemanager_open(this);'><i class='fas fa-cog'></i><label>" + rureraform_esc_html__("Theme Manager", "rureraform") + "</label></a></div>";
                    temp += "<div class='rureraform-properties-content-dime'><a class='rureraform-admin-button' href='#' onclick='return rureraform_styles_save(this);'><i class='fas fa-save'></i><label>" + rureraform_esc_html__("Save Current Theme", "rureraform") + "</label></a></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'key-fields':
                    options = "";
                    options2 = "";
                    temp = "";
                    if (input_fields.length > 0) {
                        for (var j = 0; j < input_fields.length; j++) {
                            if (temp != input_fields[j]['page-id']) {
                                if (temp != "") {
                                    options += "</optgroup>";
                                    options2 += "</optgroup>";
                                }
                                options += "<optgroup label='" + rureraform_escape_html(input_fields[j]['page-name']) + "'>";
                                options2 += "<optgroup label='" + rureraform_escape_html(input_fields[j]['page-name']) + "'>";
                                temp = input_fields[j]['page-id'];
                            }
                            options += "<option value='" + input_fields[j]['id'] + "'" + (input_fields[j]['id'] == properties[key + '-primary'] ? " selected='selected'" : "") + ">" + input_fields[j]['id'] + " | " + rureraform_escape_html(input_fields[j]['name']) + "</option>";
                            options2 += "<option value='" + input_fields[j]['id'] + "'" + (input_fields[j]['id'] == properties[key + '-secondary'] ? " selected='selected'" : "") + ">" + input_fields[j]['id'] + " | " + rureraform_escape_html(input_fields[j]['name']) + "</option>";
                        }
                        options += "</optgroup>";
                        options2 += "</optgroup>";
                    }
                    temp = "<div class='rureraform-properties-content-half'><select name='rureraform-" + key + "-primary' id='rureraform-" + key + "-primary'><option value=''>" + rureraform_meta[type][key]['placeholder']['primary'] + "</option>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['primary']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-half'><select name='rureraform-" + key + "-secondary' id='rureraform-" + key + "-secondary'><option value=''>" + rureraform_meta[type][key]['placeholder']['secondary'] + "</option>" + options2 + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['primary']) + "</label></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'personal-keys':
                    options = "";
                    if (input_fields.length > 0) {
                        for (var j = 0; j < input_fields.length; j++) {
                            options += "<input class='rureraform-properties-tile' type='checkbox' name='rureraform-" + key + "' id='rureraform-" + key + "-" + input_fields[j]['id'] + "' value='" + input_fields[j]['id'] + "'" + (properties[key].indexOf(input_fields[j]['id']) >= 0 ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-" + input_fields[j]['id'] + "'>" + input_fields[j]['id'] + " | " + rureraform_escape_html(input_fields[j]['name']) + "</label>";
                        }
                    } else
                        options = "No fields added.";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + options + "</div></div>";
                    break;

                case 'datetime-args':
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['date-format-options']) {
                        if (rureraform_meta[type][key]['date-format-options'].hasOwnProperty(option_key)) {
                            selected = "";
                            if (option_key == properties[key + "-date-format"])
                                selected = " selected='selected'";
                            options += "<option" + selected + " value='" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['date-format-options'][option_key]) + "</option>";
                        }
                    }
                    temp = "<div class='rureraform-properties-content-third'><select name='rureraform-" + key + "-date-format' id='rureraform-" + key + "-date-format'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['date-format-label']) + "</label></div>";
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['time-format-options']) {
                        if (rureraform_meta[type][key]['time-format-options'].hasOwnProperty(option_key)) {
                            selected = "";
                            if (option_key == properties[key + "-time-format"])
                                selected = " selected='selected'";
                            options += "<option" + selected + " value='" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['time-format-options'][option_key]) + "</option>";
                        }
                    }
                    temp += "<div class='rureraform-properties-content-third'><select name='rureraform-" + key + "-time-format' id='rureraform-" + key + "-time-format'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['time-format-label']) + "</label></div>";
                    options = "";
                    for (var j = 0; j < (rureraform_meta[type][key]['locale-options']).length; j++) {
                        selected = "";
                        if (rureraform_meta[type][key]['locale-options'][j] == properties[key + "-locale"])
                            selected = " selected='selected'";
                        options += "<option" + selected + " value='" + rureraform_escape_html(rureraform_meta[type][key]['locale-options'][j]) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['locale-options'][j]) + "</option>";
                    }
                    temp += "<div class='rureraform-properties-content-third'><select name='rureraform-" + key + "-locale' id='rureraform-" + key + "-locle'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['locale-label']) + "</label></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'color':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-content-color'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='...' /></div></div></div>";
                    break;

                case 'two-colors':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color1' id='rureraform-" + key + "-color1' value='" + rureraform_escape_html(properties[key + '-color1']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color1']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color2' id='rureraform-" + key + "-color2' value='" + rureraform_escape_html(properties[key + '-color2']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'three-colors':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color1' id='rureraform-" + key + "-color1' value='" + rureraform_escape_html(properties[key + '-color1']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color1']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color2' id='rureraform-" + key + "-color2' value='" + rureraform_escape_html(properties[key + '-color2']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color3' id='rureraform-" + key + "-color3' value='" + rureraform_escape_html(properties[key + '-color3']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color3']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'four-colors':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color1' id='rureraform-" + key + "-color1' value='" + rureraform_escape_html(properties[key + '-color1']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color1']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color2' id='rureraform-" + key + "-color2' value='" + rureraform_escape_html(properties[key + '-color2']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color3' id='rureraform-" + key + "-color3' value='" + rureraform_escape_html(properties[key + '-color3']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color3']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color4' id='rureraform-" + key + "-color4' value='" + rureraform_escape_html(properties[key + '-color4']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color4']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'five-colors':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color1' id='rureraform-" + key + "-color1' value='" + rureraform_escape_html(properties[key + '-color1']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color1']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color2' id='rureraform-" + key + "-color2' value='" + rureraform_escape_html(properties[key + '-color2']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color3' id='rureraform-" + key + "-color3' value='" + rureraform_escape_html(properties[key + '-color3']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color3']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color4' id='rureraform-" + key + "-color4' value='" + rureraform_escape_html(properties[key + '-color4']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color4']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='false' name='rureraform-" + key + "-color5' id='rureraform-" + key + "-color5' value='" + rureraform_escape_html(properties[key + '-color5']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color5']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'three-numbers':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value1' id='rureraform-" + key + "-value1' value='" + rureraform_escape_html(properties[key + '-value1']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value1']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value2' id='rureraform-" + key + "-value2' value='" + rureraform_escape_html(properties[key + '-value2']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value3' id='rureraform-" + key + "-value3' value='" + rureraform_escape_html(properties[key + '-value3']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value3']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'four-numbers':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value1' id='rureraform-" + key + "-value1' value='" + rureraform_escape_html(properties[key + '-value1']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value1']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value2' id='rureraform-" + key + "-value2' value='" + rureraform_escape_html(properties[key + '-value2']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value3' id='rureraform-" + key + "-value3' value='" + rureraform_escape_html(properties[key + '-value3']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value3']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value4' id='rureraform-" + key + "-value4' value='" + rureraform_escape_html(properties[key + '-value4']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value4']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'number-string-number':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value1' id='rureraform-" + key + "-value1' value='" + rureraform_escape_html(properties[key + '-value1']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value1']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'><input type='text' name='rureraform-" + key + "-value2' id='rureraform-" + key + "-value2' value='" + rureraform_escape_html(properties[key + '-value2']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "-value3' id='rureraform-" + key + "-value3' value='" + rureraform_escape_html(properties[key + '-value3']) + "' placeholder='...' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value3']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'block-width':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-value' id='rureraform-" + key + "-value' value='" + rureraform_escape_html(properties[key + '-value']) + "' placeholder='Ex. 960' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['value']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='px' name='rureraform-" + key + "-unit' id='rureraform-" + key + "-unit-px'" + (properties[key + '-unit'] == "px" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-unit-px'>px</label><input type='radio' value='%' name='rureraform-" + key + "-unit' id='rureraform-" + key + "-unit-percent'" + (properties[key + '-unit'] == "%" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-unit-percent'>%</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['unit']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-left'" + (properties[key + '-position'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-left'><i class='fas fa-align-left'></i></label><input type='radio' value='center' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-center'" + (properties[key + '-position'] == "center" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-center'><i class='fas fa-align-center'></i></label><input type='radio' value='right' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-right'" + (properties[key + '-position'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-right'><i class='fas fa-align-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'imageselect-style':
                    temp = "";
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['options']) {
                        if (rureraform_meta[type][key]['options'].hasOwnProperty(option_key)) {
                            options += "<option" + (option_key == properties[key + "-effect"] ? " selected='selected'" : "") + " value='" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['options'][option_key]) + "</option>";
                        }
                    }
                    temp += "<div class='rureraform-properties-content-two-third'><select name='rureraform-" + key + "-effect' id='rureraform-" + key + "-effect'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['effect']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-left'" + (properties[key + '-align'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-left'><i class='fas fa-align-left'></i></label><input type='radio' value='center' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-center'" + (properties[key + '-align'] == "center" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-center'><i class='fas fa-align-center'></i></label><input type='radio' value='right' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-right'" + (properties[key + '-align'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-right'><i class='fas fa-align-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'local-imageselect-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width' value='" + rureraform_escape_html(properties[key + '-width']) + "' placeholder='' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-height' id='rureraform-" + key + "-height' value='" + rureraform_escape_html(properties[key + '-height']) + "' placeholder='' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['height']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='auto' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-auto'" + (properties[key + '-size'] == "auto" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-auto'>Auto</label><input type='radio' value='contain' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-contain'" + (properties[key + '-size'] == "contain" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-contain'><i class='fas fa-compress-arrows-alt'></i></label><input type='radio' value='cover' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-cover'" + (properties[key + '-size'] == "cover" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-cover'><i class='fas fa-expand-arrows-alt'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'imageselect-mode':
                case 'tile-mode':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='radio' name='rureraform-" + key + "' id='rureraform-" + key + "-radio'" + (properties[key] == "radio" ? " checked='checked'" : "") + " onchange='rureraform_properties_imageselect_mode_set(this);'><label for='rureraform-" + key + "-radio'>Radio button</label><input type='radio' value='checkbox' name='rureraform-" + key + "' id='rureraform-" + key + "-checkbox'" + (properties[key] == "checkbox" ? " checked='checked'" : "") + " onchange='rureraform_properties_imageselect_mode_set(this);'><label for='rureraform-" + key + "-checkbox'>Checkbox</label></div></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'text-style':
                    temp = "";
                    options = "<option value=''>" + rureraform_esc_html__("Default") + "</option>";
                    options += "<optgroup label='" + rureraform_esc_html__("Standard Fonts") + "'>";
                    for (var j = 0; j < rureraform_localfonts.length; j++) {
                        options += "<option" + (rureraform_localfonts[j] == properties[key + '-family'] ? " selected='selected'" : "") + " value='" + rureraform_escape_html(rureraform_localfonts[j]) + "'>" + rureraform_escape_html(rureraform_localfonts[j]) + "</option>";
                    }
                    options += "</optgroup>";
                    if (rureraform_customfonts.length > 0) {
                        options += "<optgroup label='" + rureraform_esc_html__("Custom Fonts") + "'>";
                        for (var j = 0; j < rureraform_customfonts.length; j++) {
                            options += "<option" + (rureraform_customfonts[j] == properties[key + '-family'] ? " selected='selected'" : "") + " value='" + rureraform_escape_html(rureraform_customfonts[j]) + "'>" + rureraform_escape_html(rureraform_customfonts[j]) + "</option>";
                        }
                        options += "</optgroup>";
                    }
                    options += "<optgroup label='" + rureraform_esc_html__("Google Fonts") + "'>";
                    for (var j = 0; j < rureraform_webfonts.length; j++) {
                        options += "<option" + (rureraform_webfonts[j] == properties[key + '-family'] ? " selected='selected'" : "") + " value='" + rureraform_escape_html(rureraform_webfonts[j]) + "'>" + rureraform_escape_html(rureraform_webfonts[j]) + "</option>";
                    }
                    options += "</optgroup>";
                    temp += "<div class='rureraform-properties-content-two-third'><select name='rureraform-" + key + "-family' id='rureraform-" + key + "-family'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['family']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size' value='" + rureraform_escape_html(properties[key + '-size']) + "' placeholder='Ex. 15' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-left'" + (properties[key + '-align'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-left'><i class='fas fa-align-left'></i></label><input type='radio' value='center' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-center'" + (properties[key + '-align'] == "center" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-center'><i class='fas fa-align-center'></i></label><input type='radio' value='right' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-right'" + (properties[key + '-align'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-right'><i class='fas fa-align-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='checkbox' value='off' name='rureraform-" + key + "-bold' id='rureraform-" + key + "-bold'" + (properties[key + '-bold'] == "on" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-bold'><i class='fas fa-bold'></i></label><input type='checkbox' value='off' name='rureraform-" + key + "-italic' id='rureraform-" + key + "-italic'" + (properties[key + '-italic'] == "on" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-italic'><i class='fas fa-italic'></i></label><input type='checkbox' value='off' name='rureraform-" + key + "-underline' id='rureraform-" + key + "-underline'" + (properties[key + '-underline'] == "on" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-underline'><i class='fas fa-underline'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['style']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color' id='rureraform-" + key + "-color' value='" + rureraform_escape_html(properties[key + '-color']) + "' placeholder='Color' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color']) + "</label></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'background-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-line'>";
                    temp += "<div class='rureraform-properties-content-two-third rureraform-image-url'><input type='text' name='rureraform-" + key + "-image' id='rureraform-" + key + "-image' value='" + rureraform_escape_html(properties[key + '-image']) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['image']) + "</label><span><i class='far fa-image'></i></span></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='auto' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-auto'" + (properties[key + '-size'] == "auto" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-auto'>Auto</label><input type='radio' value='contain' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-contain'" + (properties[key + '-size'] == "contain" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-contain'><i class='fas fa-compress-arrows-alt'></i></label><input type='radio' value='cover' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-cover'" + (properties[key + '-size'] == "cover" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-cover'><i class='fas fa-expand-arrows-alt'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-horizontal-position' id='rureraform-" + key + "-horizontal-position-left'" + (properties[key + '-horizontal-position'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-horizontal-position-left'><i class='fas fa-arrow-left'></i></label><input type='radio' value='center' name='rureraform-" + key + "-horizontal-position' id='rureraform-" + key + "-horizontal-position-center'" + (properties[key + '-horizontal-position'] == "center" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-horizontal-position-center'><i class='far fa-dot-circle'></i></label><input type='radio' value='right' name='rureraform-" + key + "-horizontal-position' id='rureraform-" + key + "-horizontal-position-right'" + (properties[key + '-horizontal-position'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-horizontal-position-right'><i class='fas fa-arrow-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['horizontal-position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='top' name='rureraform-" + key + "-vertical-position' id='rureraform-" + key + "-vertical-position-top'" + (properties[key + '-vertical-position'] == "top" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-vertical-position-top'><i class='fas fa-arrow-up'></i></label><input type='radio' value='middle' name='rureraform-" + key + "-vertical-position' id='rureraform-" + key + "-vertical-position-middle'" + (properties[key + '-vertical-position'] == "middle" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-vertical-position-middle'><i class='far fa-dot-circle'></i></label><input type='radio' value='bottom' name='rureraform-" + key + "-vertical-position' id='rureraform-" + key + "-vertical-position-bottom'" + (properties[key + '-vertical-position'] == "bottom" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-vertical-position-bottom'><i class='fas fa-arrow-down'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['vertical-position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='repeat' name='rureraform-" + key + "-repeat' id='rureraform-" + key + "-repeat-repeat'" + (properties[key + '-repeat'] == "repeat" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-repeat-repeat'><i class='fas fa-arrows-alt'></i></label><input type='radio' value='repeat-x' name='rureraform-" + key + "-repeat' id='rureraform-" + key + "-repeat-repeat-x'" + (properties[key + '-repeat'] == "repeat-x" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-repeat-repeat-x'><i class='fas fa-arrows-alt-h'></i></label><input type='radio' value='repeat-y' name='rureraform-" + key + "-repeat' id='rureraform-" + key + "-repeat-repeat-y'" + (properties[key + '-repeat'] == "repeat-y" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-repeat-repeat-y'><i class='fas fa-arrows-alt-v'></i></label><input type='radio' value='no-repeat' name='rureraform-" + key + "-repeat' id='rureraform-" + key + "-repeat-no-repeat'" + (properties[key + '-repeat'] == "no-repeat" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-repeat-no-repeat'>No</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['repeat']) + "</label></div>";
                    temp += "</div>";
                    temp += "<div class='rureraform-properties-line'>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color' id='rureraform-" + key + "-color' value='" + rureraform_escape_html(properties[key + '-color']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='no' name='rureraform-" + key + "-gradient' id='rureraform-" + key + "-gradient-no'" + (properties[key + '-gradient'] == "no" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-gradient-no' onclick='jQuery(\"#rureraform-content-" + key + "-color2\").fadeOut(300);'>No</label><input type='radio' value='2shades' name='rureraform-" + key + "-gradient' id='rureraform-" + key + "-gradient-2shades'" + (properties[key + '-gradient'] == "2shades" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-gradient-2shades' onclick='jQuery(\"#rureraform-content-" + key + "-color2\").fadeOut(300);'>2 Shades</label><input type='radio' value='horizontal' name='rureraform-" + key + "-gradient' id='rureraform-" + key + "-gradient-horizontal'" + (properties[key + '-gradient'] == "horizontal" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-gradient-horizontal' onclick='jQuery(\"#rureraform-content-" + key + "-color2\").fadeIn(300);'>Horizontal</label><input type='radio' value='vertical' name='rureraform-" + key + "-gradient' id='rureraform-" + key + "-gradient-vertical'" + (properties[key + '-gradient'] == "vertical" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-gradient-vertical' onclick='jQuery(\"#rureraform-content-" + key + "-color2\").fadeIn(300);'>Vertical</label><input type='radio' value='diagonal' name='rureraform-" + key + "-gradient' id='rureraform-" + key + "-gradient-diagonal'" + (properties[key + '-gradient'] == "diagonal" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-gradient-diagonal' onclick='jQuery(\"#rureraform-content-" + key + "-color2\").fadeIn(300);'>Diagonal</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['gradient']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime' id='rureraform-content-" + key + "-color2'" + (properties[key + '-gradient'] != "horizontal" && properties[key + '-gradient'] != "vertical" && properties[key + '-gradient'] != "diagonal" ? " style='display:none;'" : "") + "><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color2' id='rureraform-" + key + "-color2' value='" + rureraform_escape_html(properties[key + '-color2']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color2']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    temp += "</div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;
                    

                case 'border-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width' value='" + rureraform_escape_html(properties[key + '-width']) + "' placeholder='Ex. 1' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='solid' name='rureraform-" + key + "-style' id='rureraform-" + key + "-style-solid'" + (properties[key + '-style'] == "solid" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-style-solid'>Solid</label><input type='radio' value='dashed' name='rureraform-" + key + "-style' id='rureraform-" + key + "-style-dashed'" + (properties[key + '-style'] == "dashed" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-style-dashed'>Dashed</label><input type='radio' value='dotted' name='rureraform-" + key + "-style' id='rureraform-" + key + "-style-dotted'" + (properties[key + '-style'] == "dotted" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-style-dotted'>Dotted</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['style']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='0' name='rureraform-" + key + "-radius' id='rureraform-" + key + "-radius-0'" + (properties[key + '-radius'] == "0" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-radius-0'>0px</label><input type='radio' value='3' name='rureraform-" + key + "-radius' id='rureraform-" + key + "-radius-3'" + (properties[key + '-radius'] == "3" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-radius-3'>3px</label><input type='radio' value='5' name='rureraform-" + key + "-radius' id='rureraform-" + key + "-radius-5'" + (properties[key + '-radius'] == "5" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-radius-5'>5px</label><input type='radio' value='10' name='rureraform-" + key + "-radius' id='rureraform-" + key + "-radius-10'" + (properties[key + '-radius'] == "10" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-radius-10'>10px</label><input type='radio' value='30' name='rureraform-" + key + "-radius' id='rureraform-" + key + "-radius-30'" + (properties[key + '-radius'] == "30" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-radius-30'>Max</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['radius']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='checkbox' value='off' name='rureraform-" + key + "-left' id='rureraform-" + key + "-left'" + (properties[key + '-left'] == "on" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-left'><i class='fas fa-arrow-left'></i></label><input type='checkbox' value='off' name='rureraform-" + key + "-top' id='rureraform-" + key + "-top'" + (properties[key + '-top'] == "on" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-top'><i class='fas fa-arrow-up'></i></label><input type='checkbox' value='off' name='rureraform-" + key + "-bottom' id='rureraform-" + key + "-bottom'" + (properties[key + '-bottom'] == "on" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-bottom'><i class='fas fa-arrow-down'></i></label><input type='checkbox' value='off' name='rureraform-" + key + "-right' id='rureraform-" + key + "-right'" + (properties[key + '-right'] == "on" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-right'><i class='fas fa-arrow-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['border']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color' id='rureraform-" + key + "-color' value='" + rureraform_escape_html(properties[key + '-color']) + "' placeholder='Color' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'global-tile-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='tiny' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-tiny'" + (properties[key + '-size'] == "tiny" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-tiny'>Tiny</label><input type='radio' value='small' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-small'" + (properties[key + '-size'] == "small" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-small'>Small</label><input type='radio' value='medium' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-medium'" + (properties[key + '-size'] == "medium" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-medium'>Medium</label><input type='radio' value='large' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-large'" + (properties[key + '-size'] == "large" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-large'>Large</label><input type='radio' value='huge' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-huge'" + (properties[key + '-size'] == "huge" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-huge'>Huge</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='default' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width-default'" + (properties[key + '-width'] == "default" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-width-default'>Default</label><input type='radio' value='full' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width-full'" + (properties[key + '-width'] == "full" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-width-full'>Full</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-left'" + (properties[key + '-position'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-left'><i class='fas fa-arrow-left'></i></label><input type='radio' value='right' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-right'" + (properties[key + '-position'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-right'><i class='fas fa-arrow-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='inline' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-inline'" + (properties[key + '-layout'] == "inline" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-inline'><i class='fas fa-arrow-right'></i></label><input type='radio' value='1' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-1'" + (properties[key + '-layout'] == "1" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-1'><i class='fas fa-arrow-down'></i></label><input type='radio' value='2' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-2'" + (properties[key + '-layout'] == "2" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-2'>2c</label><input type='radio' value='3' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-3'" + (properties[key + '-layout'] == "3" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-3'>3c</label><input type='radio' value='4' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-4'" + (properties[key + '-layout'] == "4" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-4'>4c</label><input type='radio' value='6' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-6'" + (properties[key + '-layout'] == "6" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-6'>6c</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['layout']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'local-tile-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-size']) + "' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size'><span class='" + (properties[key + '-size'] == "tiny" ? 'rureraform-bar-option-selected' : '') + "' data-value='tiny'>Tiny</span><span class='" + (properties[key + '-size'] == "small" ? 'rureraform-bar-option-selected' : '') + "' data-value='small'>Small</span><span class='" + (properties[key + '-size'] == "medium" ? 'rureraform-bar-option-selected' : '') + "' data-value='medium'>Medium</span><span class='" + (properties[key + '-size'] == "large" ? 'rureraform-bar-option-selected' : '') + "' data-value='large'>Large</span><span class='" + (properties[key + '-size'] == "huge" ? 'rureraform-bar-option-selected' : '') + "' data-value='huge'>Huge</span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-width']) + "' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width'><span class='" + (properties[key + '-width'] == "default" ? 'rureraform-bar-option-selected' : '') + "' data-value='default'>Default</span><span class='" + (properties[key + '-width'] == "full" ? 'rureraform-bar-option-selected' : '') + "' data-value='full'>Full</span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-position']) + "' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position'><span class='" + (properties[key + '-position'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-arrow-left'></i></span><span class='" + (properties[key + '-position'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-arrow-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-layout']) + "' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout'><span class='" + (properties[key + '-layout'] == "inline" ? 'rureraform-bar-option-selected' : '') + "' data-value='inline'><i class='fas fa-arrow-right'></i></span><span class='" + (properties[key + '-layout'] == "1" ? 'rureraform-bar-option-selected' : '') + "' data-value='1'><i class='fas fa-arrow-down'></i></span><span class='" + (properties[key + '-layout'] == "2" ? 'rureraform-bar-option-selected' : '') + "' data-value='2'>2c</span><span class='" + (properties[key + '-layout'] == "3" ? 'rureraform-bar-option-selected' : '') + "' data-value='3'>3c</span><span class='" + (properties[key + '-layout'] == "4" ? 'rureraform-bar-option-selected' : '') + "' data-value='4'>4c</span><span class='" + (properties[key + '-layout'] == "6" ? 'rureraform-bar-option-selected' : '') + "' data-value='6'>6c</span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['layout']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'global-button-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='tiny' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-tiny'" + (properties[key + '-size'] == "tiny" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-tiny'>Tiny</label><input type='radio' value='small' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-small'" + (properties[key + '-size'] == "small" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-small'>Small</label><input type='radio' value='medium' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-medium'" + (properties[key + '-size'] == "medium" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-medium'>Medium</label><input type='radio' value='large' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-large'" + (properties[key + '-size'] == "large" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-large'>Large</label><input type='radio' value='huge' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-huge'" + (properties[key + '-size'] == "huge" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-huge'>Huge</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='default' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width-default'" + (properties[key + '-width'] == "default" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-width-default'>Default</label><input type='radio' value='full' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width-full'" + (properties[key + '-width'] == "full" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-width-full'>Full</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-left'" + (properties[key + '-position'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-left'><i class='fas fa-align-left'></i></label><input type='radio' value='center' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-center'" + (properties[key + '-position'] == "center" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-center'><i class='fas fa-align-center'></i></label><input type='radio' value='right' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-right'" + (properties[key + '-position'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-right'><i class='fas fa-align-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'local-button-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-size']) + "' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size'><span class='" + (properties[key + '-size'] == "tiny" ? 'rureraform-bar-option-selected' : '') + "' data-value='tiny'>Tiny</span><span class='" + (properties[key + '-size'] == "small" ? 'rureraform-bar-option-selected' : '') + "' data-value='small'>Small</span><span class='" + (properties[key + '-size'] == "medium" ? 'rureraform-bar-option-selected' : '') + "' data-value='medium'>Medium</span><span class='" + (properties[key + '-size'] == "large" ? 'rureraform-bar-option-selected' : '') + "' data-value='large'>Large</span><span class='" + (properties[key + '-size'] == "huge" ? 'rureraform-bar-option-selected' : '') + "' data-value='huge'>Huge</span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-width']) + "' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width'><span class='" + (properties[key + '-width'] == "default" ? 'rureraform-bar-option-selected' : '') + "' data-value='default'>Default</span><span class='" + (properties[key + '-width'] == "full" ? 'rureraform-bar-option-selected' : '') + "' data-value='full'>Full</span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-position']) + "' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position'><span class='" + (properties[key + '-position'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-align-left'></i></span><span class='" + (properties[key + '-position'] == "center" ? 'rureraform-bar-option-selected' : '') + "' data-value='center'><i class='fas fa-align-center'></i></span><span class='" + (properties[key + '-position'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-align-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'icon-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='inside' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-inside'" + (properties[key + '-position'] == "inside" ? " checked='checked'" : "") + " /><label for='rureraform-" + key + "-position-inside' onclick='if (jQuery(this).parent().find(\"input\").is(\":checked\")) jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-properties-icon-inside-only\").fadeIn(200);'>Inside</i></label><input type='radio' value='outside' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-outside'" + (properties[key + '-position'] == "outside" ? " checked='checked'" : "") + " /><label for='rureraform-" + key + "-position-outside' onclick='if (jQuery(this).parent().find(\"input\").is(\":checked\")) jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-properties-icon-inside-only\").fadeOut(200);'>Outside</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size' value='" + rureraform_escape_html(properties[key + '-size']) + "' placeholder='Ex. 15' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color' id='rureraform-" + key + "-color' value='" + rureraform_escape_html(properties[key + '-color']) + "' placeholder='Color' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-properties-icon-inside-only'" + (properties[key + '-position'] == "outside" ? " style='display:none;'" : "") + "><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-background' id='rureraform-" + key + "-background' value='" + rureraform_escape_html(properties[key + '-background']) + "' placeholder='Color' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['background']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-properties-icon-inside-only'" + (properties[key + '-position'] == "outside" ? " style='display:none;'" : "") + "><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-border' id='rureraform-" + key + "-border' value='" + rureraform_escape_html(properties[key + '-border']) + "' placeholder='Color' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['border']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'star-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='tiny' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-tiny'" + (properties[key + '-size'] == "tiny" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-tiny'>Tiny</label><input type='radio' value='small' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-small'" + (properties[key + '-size'] == "small" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-small'>Small</label><input type='radio' value='medium' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-medium'" + (properties[key + '-size'] == "medium" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-medium'>Medium</label><input type='radio' value='large' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-large'" + (properties[key + '-size'] == "large" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-large'>Large</label><input type='radio' value='huge' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-huge'" + (properties[key + '-size'] == "huge" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-huge'>Huge</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-left'" + (properties[key + '-position'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-left'><i class='fas fa-align-left'></i></label><input type='radio' value='center' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-center'" + (properties[key + '-position'] == "center" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-center'><i class='fas fa-align-center'></i></label><input type='radio' value='right' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-right'" + (properties[key + '-position'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-right'><i class='fas fa-align-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color-rated' id='rureraform-" + key + "-color-rated' value='" + rureraform_escape_html(properties[key + '-color-rated']) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color-rated']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color-unrated' id='rureraform-" + key + "-color-unrated' value='" + rureraform_escape_html(properties[key + '-color-unrated']) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color-unrated']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'shadow':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime' id='rureraform-content-" + key + "-size'><div class='rureraform-bar-selector'><input type='radio' value='' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-no'" + (properties[key + '-size'] == "" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-no'>No</label><input type='radio' value='tiny' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-tiny'" + (properties[key + '-size'] == "tiny" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-tiny'><i class='fas fa-stop' style='font-size: 10px;'></i></label><input type='radio' value='small' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-small'" + (properties[key + '-size'] == "small" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-small'><i class='fas fa-stop' style='font-size: 12px;'></i></label><input type='radio' value='medium' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-medium'" + (properties[key + '-size'] == "medium" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-medium'><i class='fas fa-stop' style='font-size: 14px;'></i></label><input type='radio' value='large' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-large'" + (properties[key + '-size'] == "large" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-large'><i class='fas fa-stop' style='font-size: 16px;'></i></label><input type='radio' value='huge' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-huge'" + (properties[key + '-size'] == "huge" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-huge'><i class='fas fa-stop' style='font-size: 18px;'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='regular' name='rureraform-" + key + "-style' id='rureraform-" + key + "-style-regular'" + (properties[key + '-style'] == "regular" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-style-regular'>Regular</label><input type='radio' value='solid' name='rureraform-" + key + "-style' id='rureraform-" + key + "-style-solid'" + (properties[key + '-style'] == "solid" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-style-solid'>Solid</label><input type='radio' value='inset' name='rureraform-" + key + "-style' id='rureraform-" + key + "-style-inset'" + (properties[key + '-style'] == "inset" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-style-inset'>Inset</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['style']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-color' id='rureraform-" + key + "-color' value='" + rureraform_escape_html(properties[key + '-color']) + "' placeholder='Color' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['color']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'padding':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-top' id='rureraform-" + key + "-top' value='" + rureraform_escape_html(properties[key + '-top']) + "' placeholder='Ex. 10' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['top']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-right' id='rureraform-" + key + "-right' value='" + rureraform_escape_html(properties[key + '-right']) + "' placeholder='Ex. 10' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['right']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-bottom' id='rureraform-" + key + "-bottom' value='" + rureraform_escape_html(properties[key + '-bottom']) + "' placeholder='Ex. 10' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['bottom']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-left' id='rureraform-" + key + "-left' value='" + rureraform_escape_html(properties[key + '-left']) + "' placeholder='Ex. 10' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['left']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'label-position':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime' id='rureraform-content-" + key + "-position'><div class='rureraform-bar-selector'><input type='radio' value='top' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-top'" + (properties[key + '-position'] == "top" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-top' onclick='jQuery(\"#rureraform-content-" + key + "-width\").fadeOut(300);'><i class='fas fa-arrow-up'></i></label><input type='radio' value='left' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-left'" + (properties[key + '-position'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-left' onclick='jQuery(\"#rureraform-content-" + key + "-width\").fadeIn(300);'><i class='fas fa-arrow-left'></i></label><input type='radio' value='right' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-right'" + (properties[key + '-position'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-right' onclick='jQuery(\"#rureraform-content-" + key + "-width\").fadeIn(300);'><i class='fas fa-arrow-right'></i></label><input type='radio' value='none' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-none'" + (properties[key + '-position'] == "none" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-none' onclick='jQuery(\"#rureraform-content-" + key + "-width\").fadeOut(300);'><i class='far fa-eye-slash'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-properties-content-slider' id='rureraform-content-" + key + "-width'" + (properties[key + '-position'] != "left" && properties[key + '-position'] != "right" ? " style='display:none;'" : "") + "><div class='rureraform-slider-container'><input type='hidden' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width' value='" + rureraform_escape_html(properties[key + '-width']) + "' /><div class='rureraform-slider' data-min='1' data-max='11' data-step='1'><div class='ui-slider-handle'></div></div></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'label-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime' id='rureraform-content-" + key + "-position'><div class='rureraform-bar-options rureraform-label-position-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-position']) + "' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position'><span class='" + (properties[key + '-position'] == "top" ? 'rureraform-bar-option-selected' : '') + "' data-value='top'><i class='fas fa-arrow-up'></i></span><span class='" + (properties[key + '-position'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-arrow-left'></i></span><span class='" + (properties[key + '-position'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-arrow-right'></i></span><span class='" + (properties[key + '-position'] == "none" ? 'rureraform-bar-option-selected' : '') + "' data-value='none'><i class='far fa-eye-slash'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-properties-content-slider' id='rureraform-content-" + key + "-width'" + (properties[key + '-position'] != "left" && properties[key + '-position'] != "right" ? " style='display:none;'" : "") + "><div class='rureraform-slider-container'><input type='hidden' name='rureraform-" + key + "-width' id='rureraform-" + key + "-width' value='" + rureraform_escape_html(properties[key + '-width']) + "' /><div class='rureraform-slider' data-min='1' data-max='11' data-step='1'><div class='ui-slider-handle'></div></div></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['width']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-align']) + "' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align'><span class='" + (properties[key + '-align'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-align-left'></i></span><span class='" + (properties[key + '-align'] == "center" ? 'rureraform-bar-option-selected' : '') + "' data-value='center'><i class='fas fa-align-center'></i></span><span class='" + (properties[key + '-align'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-align-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'input-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-size']) + "' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size'><span class='" + (properties[key + '-size'] == "tiny" ? 'rureraform-bar-option-selected' : '') + "' data-value='tiny'>Tiny</span><span class='" + (properties[key + '-size'] == "small" ? 'rureraform-bar-option-selected' : '') + "' data-value='small'>Small</span><span class='" + (properties[key + '-size'] == "medium" ? 'rureraform-bar-option-selected' : '') + "' data-value='medium'>Medium</span><span class='" + (properties[key + '-size'] == "large" ? 'rureraform-bar-option-selected' : '') + "' data-value='large'>Large</span><span class='" + (properties[key + '-size'] == "huge" ? 'rureraform-bar-option-selected' : '') + "' data-value='huge'>Huge</span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-align']) + "' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align'><span class='" + (properties[key + '-align'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-align-left'></i></span><span class='" + (properties[key + '-align'] == "center" ? 'rureraform-bar-option-selected' : '') + "' data-value='center'><i class='fas fa-align-center'></i></span><span class='" + (properties[key + '-align'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-align-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'local-multiselect-style':
                case 'textarea-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-number rureraform-input-units rureraform-input-px'><input type='text' name='rureraform-" + key + "-height' id='rureraform-" + key + "-height' value='" + rureraform_escape_html(properties[key + '-height']) + "' placeholder='' /></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['height']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-align']) + "' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align'><span class='" + (properties[key + '-align'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-align-left'></i></span><span class='" + (properties[key + '-align'] == "center" ? 'rureraform-bar-option-selected' : '') + "' data-value='center'><i class='fas fa-align-center'></i></span><span class='" + (properties[key + '-align'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-align-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'checkbox-radio-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-left'" + (properties[key + '-position'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-left'><i class='fas fa-arrow-left'></i></label><input type='radio' value='right' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-right'" + (properties[key + '-position'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-right'><i class='fas fa-arrow-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='left' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-left'" + (properties[key + '-align'] == "left" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-left'><i class='fas fa-align-left'></i></label><input type='radio' value='center' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-center'" + (properties[key + '-align'] == "center" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-center'><i class='fas fa-align-center'></i></label><input type='radio' value='right' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align-right'" + (properties[key + '-align'] == "right" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-align-right'><i class='fas fa-align-right'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='small' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-small'" + (properties[key + '-size'] == "small" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-small'>Small</label><input type='radio' value='medium' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-medium'" + (properties[key + '-size'] == "medium" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-medium'>Medium</label><input type='radio' value='large' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-large'" + (properties[key + '-size'] == "large" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-large'>Large</label><input type='radio' value='huge' name='rureraform-" + key + "-size' id='rureraform-" + key + "-size-huge'" + (properties[key + '-size'] == "huge" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-size-huge'>Huge</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-selector'><input type='radio' value='inline' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-inline'" + (properties[key + '-layout'] == "inline" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-inline'><i class='fas fa-arrow-right'></i></label><input type='radio' value='1' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-1'" + (properties[key + '-layout'] == "1" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-1'><i class='fas fa-arrow-down'></i></label><input type='radio' value='2' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-2'" + (properties[key + '-layout'] == "2" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-2'>2c</label><input type='radio' value='3' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-3'" + (properties[key + '-layout'] == "3" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-3'>3c</label><input type='radio' value='4' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-4'" + (properties[key + '-layout'] == "4" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-4'>4c</label><input type='radio' value='6' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout-6'" + (properties[key + '-layout'] == "6" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-layout-6'>6c</label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['layout']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'local-checkbox-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-position']) + "' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position'><span class='" + (properties[key + '-position'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-arrow-left'></i></span><span class='" + (properties[key + '-position'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-arrow-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-align']) + "' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align'><span class='" + (properties[key + '-align'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-align-left'></i></span><span class='" + (properties[key + '-align'] == "center" ? 'rureraform-bar-option-selected' : '') + "' data-value='center'><i class='fas fa-align-center'></i></span><span class='" + (properties[key + '-align'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-align-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-layout']) + "' name='rureraform-" + key + "-layout' id='rureraform-" + key + "-layout'><span class='" + (properties[key + '-layout'] == "inline" ? 'rureraform-bar-option-selected' : '') + "' data-value='inline'><i class='fas fa-arrow-right'></i></span><span class='" + (properties[key + '-layout'] == "1" ? 'rureraform-bar-option-selected' : '') + "' data-value='1'><i class='fas fa-arrow-down'></i></span><span class='" + (properties[key + '-layout'] == "2" ? 'rureraform-bar-option-selected' : '') + "' data-value='2'>2c</span><span class='" + (properties[key + '-layout'] == "3" ? 'rureraform-bar-option-selected' : '') + "' data-value='3'>3c</span><span class='" + (properties[key + '-layout'] == "4" ? 'rureraform-bar-option-selected' : '') + "' data-value='4'>4c</span><span class='" + (properties[key + '-layout'] == "6" ? 'rureraform-bar-option-selected' : '') + "' data-value='6'>6c</span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['layout']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'checkbox-view':
                    options = "";
                    for (var j = 0; j < rureraform_meta[type][key]['options'].length; j++) {
                        selected = "";
                        if (properties[key] == rureraform_meta[type][key]['options'][j])
                            selected = " checked='checked'";
                        options += "<div class='rureraform-properties-preview-option rureraform-properties-preview-option-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'><input type='radio' name='rureraform-" + key + "' id='rureraform-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "' value='" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'" + selected + " /><label class='far' for='rureraform-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'></label><div><input class='rureraform-checkbox rureraform-checkbox-large rureraform-checkbox-" + rureraform_meta[type][key]['options'][j] + "' type='checkbox' id='rureraform-demo-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "' checked='checked' /><label for='rureraform-demo-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'></label></div></div>";
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + options + "</div></div>";
                    break;

                case 'radio-view':
                    options = "";
                    for (var j = 0; j < rureraform_meta[type][key]['options'].length; j++) {
                        selected = "";
                        if (properties[key] == rureraform_meta[type][key]['options'][j])
                            selected = " checked='checked'";
                        options += "<div class='rureraform-properties-preview-option rureraform-properties-preview-option-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'><input type='radio' name='rureraform-" + key + "' id='rureraform-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "' value='" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'" + selected + " /><label class='far' for='rureraform-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'></label><div><input class='rureraform-radio rureraform-radio-large rureraform-radio-" + rureraform_meta[type][key]['options'][j] + "' type='radio' id='rureraform-demo-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "' name='rureraform-demo-" + key + "'" + selected + " /><label for='rureraform-demo-" + key + "-" + rureraform_escape_html(rureraform_meta[type][key]['options'][j]) + "'></label></div></div>";
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + options + "</div></div>";
                    break;

                case 'multiselect-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-align']) + "' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align'><span class='" + (properties[key + '-align'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-align-left'></i></span><span class='" + (properties[key + '-align'] == "center" ? 'rureraform-bar-option-selected' : '') + "' data-value='center'><i class='fas fa-align-center'></i></span><span class='" + (properties[key + '-align'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-align-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-height' id='rureraform-" + key + "-height' value='" + rureraform_escape_html(properties[key + '-height']) + "' placeholder='Ex. 120' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['height']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-properties-group'><div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-hover-background' id='rureraform-" + key + "-hover-background' value='" + rureraform_escape_html(properties[key + '-hover-background']) + "' /></div><div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-hover-color' id='rureraform-" + key + "-hover-color' value='" + rureraform_escape_html(properties[key + '-hover-color']) + "' /></div></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['hover-color']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-properties-group'><div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-selected-background' id='rureraform-" + key + "-selected-background' value='" + rureraform_escape_html(properties[key + '-selected-background']) + "' /></div><div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-selected-color' id='rureraform-" + key + "-selected-color' value='" + rureraform_escape_html(properties[key + '-selected-color']) + "' /></div></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['selected-color']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'description-position':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime' id='rureraform-content-" + key + "-position'><div class='rureraform-bar-selector'><input type='radio' value='bottom' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-bottom'" + (properties[key + '-position'] == "bottom" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-bottom'><i class='fas fa-arrow-down'></i></label><input type='radio' value='none' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position-none'" + (properties[key + '-position'] == "none" ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-position-none'><i class='far fa-eye-slash'></i></label></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'description-style':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime' id='rureraform-content-" + key + "-position'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-position']) + "' name='rureraform-" + key + "-position' id='rureraform-" + key + "-position'><span class='" + (properties[key + '-position'] == "bottom" ? 'rureraform-bar-option-selected' : '') + "' data-value='bottom'><i class='fas fa-arrow-down'></i></span><span class='" + (properties[key + '-position'] == "none" ? 'rureraform-bar-option-selected' : '') + "' data-value='none'><i class='far fa-eye-slash'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['position']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><div class='rureraform-bar-options'><input type='hidden' value='" + rureraform_escape_html(properties[key + '-align']) + "' name='rureraform-" + key + "-align' id='rureraform-" + key + "-align'><span class='" + (properties[key + '-align'] == "left" ? 'rureraform-bar-option-selected' : '') + "' data-value='left'><i class='fas fa-align-left'></i></span><span class='" + (properties[key + '-align'] == "center" ? 'rureraform-bar-option-selected' : '') + "' data-value='center'><i class='fas fa-align-center'></i></span><span class='" + (properties[key + '-align'] == "right" ? 'rureraform-bar-option-selected' : '') + "' data-value='right'><i class='fas fa-align-right'></i></span></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['align']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'units':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-number rureraform-input-units rureraform-input-" + rureraform_meta[type][key]['unit'] + "'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='' /></div></div></div>";
                    break;

                case 'id':
                    html += "<div class='rureraform-properties-noitem'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + properties["id"] + "' readonly='readonly' onclick='this.focus();this.select();' /></div></div></div>";
                    break;

                case 'text':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='' /></div></div>";
                    break;
                    
                case 'number':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input type='number' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='' /></div></div>";
                    break;    

                case 'integer':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='' /></div></div></div>";
                    break;

                case 'from':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'><div class='rureraform-properties-content-half rureraform-input-shortcode-selector'><input type='text' name='rureraform-" + key + "-email' id='rureraform-" + key + "-email' value='" + rureraform_escape_html(properties[key + "-email"]) + "' placeholder='Email address...' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div><div class='rureraform-properties-content-half rureraform-input-shortcode-selector'><input type='text' name='rureraform-" + key + "-name' id='rureraform-" + key + "-name' value='" + rureraform_escape_html(properties[key + "-name"]) + "' placeholder='Name...' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div></div>";
                    break;

                case 'text-shortcodes':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group rureraform-input-shortcode-selector'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div>";
                    break;

                case 'html':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'>\n\
                    \n\
                    <div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div>\n\
                    <div class='lms-tools-bar'>\n\
                    <ul class='rureraform-toolbar-list'>\n\
                    <li><a href='javascript:;'><img src='/assets/default/img/quiz/symbols/square-root.png' title='Square root' class='editor-add-field lms-tools-item' data-field_type='sq_root' data-id='"+key+"' onclick='document.getElementById(\"rureraform-content\").focus();' /></a></li>\n\
                    <li><a href='javascript:;'><img src='/assets/default/img/quiz/symbols/cube.png' title='Cube root' class='editor-add-field lms-tools-item' data-field_type='cube_root' data-id='"+key+"' onclick='document.getElementById(\"rureraform-content\").focus();' /></a></li>\n\
                    <li><a href='javascript:;'><img src='/assets/default/img/quiz/symbols/percentage.png' title='Fraction' class='editor-add-field lms-tools-item' data-field_type='fraction' data-id='"+key+"' onclick='document.getElementById(\"rureraform-content\").focus();' /></a></li>                    \n\
                    <li><a href='javascript:;'><img src='/assets/default/img/quiz/symbols/input.png' title='Blank' class='editor-add-field lms-tools-item' data-field_type='blank' data-id='"+key+"' onclick='document.getElementById(\"rureraform-content\").focus();' /></a></li>\n\
                    <li><a href='javascript:;'><img src='/assets/default/img/quiz/symbols/select-field.png' title='Select' class='editor-add-field lms-tools-item' data-field_type='select' data-id='"+key+"' onclick='document.getElementById(\"rureraform-content\").focus();' /></a></li>\n\
                    </ul>\n\
                    </div>\n\
                    <div class='rureraform-properties-content rureraform-wysiwyg'><div class='content-data' id='rureraform-" + key + "' contenteditable='true'>" + properties[key] + "</div>\n\
                    <textarea class='content-area hide' name='rureraform-" + key + "' id='rureraform-" + key + "'>" + properties[key] + "</textarea>\n\
                    <div class='field-options field-options-"+key+"'>\n\
                    </div>\n\
                    </div></div>"; 
                
                break;
                
                case 'elements_data':
                    html += "<input type='hidden' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='' />";
                    break;
                    
                case 'ajax_select':
                   options = "";
                   html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-third'><select name='rureraform-" + key + "' class='"+rureraform_meta[type][key]['class']+"' id='rureraform-" + key + "'>" + options + "</select></div></div></div>";
                   html += "<script type='text/javascript'>$('."+rureraform_meta[type][key]['class']+"').select2({\n\
                        placeholder: $(this).data('placeholder'),\n\
                        minimumInputLength: 3,\n\
                        allowClear: true,\n\
                        ajax: {\n\
                            url: '"+rureraform_meta[type][key]['ajax_url']+"',\n\
                            dataType: 'json',\n\
                            type: 'POST',\n\
                            quietMillis: 50,\n\
                            data: function (params) {\n\
                                return {\n\
                                    term: params.term,\n\
                                    option: $('."+rureraform_meta[type][key]['class']+"').attr('data-search-option'),\n\
                                };\n\
                            },\n\
                            processResults: function (data) {\n\
                                return {\n\
                                    results: $.map(data, function (item) {\n\
                                        return {\n\
                                            text: item.title,\n\
                                            id: item.id\n\
                                        }\n\
                                    })\n\
                                };\n\
                            }\n\
                        }\n\
                    });</script>";
                   break;   
              
                
                case 'html_bk':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'>\n\
                \n\
                <div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div>\n\
                <input class='editor-add-field' data-field_type='select' data-id='"+key+"' type='button' value='Add Select' onclick='document.getElementById(\"rureraform-content\").focus();'>\n\
                <input class='editor-add-field' data-field_type='blank' data-id='"+key+"' type='button' value='Add Blank' onclick='document.getElementById(\"rureraform-content\").focus();'>\n\
                <input class='editor-add-field' data-field_type='fraction' data-id='"+key+"' type='button' value='Fraction' onclick='document.getElementById(\"rureraform-content\").focus();'>\n\
                <div class='rureraform-properties-content rureraform-wysiwyg'><textarea class='content-data rureraform-tinymce tinymceEditor rureraform-tinymce-pre' name='rureraform-" + key + "' id='rureraform-" + key + "'>" + properties[key] + "</textarea>\n\
                <div class='field-options field-options-"+key+"'>\n\
                </div>\n\
                </div></div>";
                   
                                                                                                                                                                                                                    
                    break;

                case 'textarea':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><textarea name='rureraform-" + key + "' id='rureraform-" + key + "'>" + rureraform_escape_html(properties[key]) + "</textarea></div></div>";
                    break;

                case 'text-number':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-number'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='' /></div></div></div>";
                    break;

                case 'checkbox':
                    selected = "";
                    if (properties[key] == "on")
                        selected = " checked='checked'";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' name='rureraform-" + key + "' id='rureraform-" + key + "'" + selected + "' /><label for='rureraform-" + key + "'></label></div></div>";
                    break;

                case 'select':
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['options']) {
                        if (rureraform_meta[type][key]['options'].hasOwnProperty(option_key)) {
                            selected = "";
                            if (option_key == properties[key])
                                selected = " selected='selected'";
                            options += "<option" + selected + " value='" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['options'][option_key]) + "</option>";
                        }
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-third'><select name='rureraform-" + key + "' id='rureraform-" + key + "'>" + options + "</select></div></div></div>";
                    break;
                    
                 case 'select_sub':
                    options = "";
                    var chapters = rureraform_meta[type][key]['options'];   
                    Object.keys(chapters).forEach(function(chapter_id){
                        var chapter_title = chapters[chapter_id]['title'];
                        var sub_chapters = chapters[chapter_id]['chapters'];
                        options += "<optgroup label='"+chapter_title+"'>";
                        Object.keys(sub_chapters).forEach(function(sub_chapter_id){
                            var sub_chapter_title = sub_chapters[sub_chapter_id];
                            selected = "";
                            if (sub_chapter_id == properties[key])
                                selected = " selected='selected'";
                            
                            options += "<option" + selected + " value='"+sub_chapter_id+"'>"+sub_chapter_title+"</option>";
                            
                        });
                        options += "</optgroup>";
                        
                        
                    });
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-third'><select name='rureraform-" + key + "' id='rureraform-" + key + "'>" + options + "</select></div></div></div>";
                    break;   

                case 'select-image':
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['options']) {
                        if (rureraform_meta[type][key]['options'].hasOwnProperty(option_key)) {
                            selected = "";
                            if (option_key == properties[key])
                                selected = " checked='checked'";
                            options += "<input class='rureraform-radio-image' type='radio'" + selected + " value='" + rureraform_escape_html(option_key) + "' name='rureraform-" + key + "' id='rureraform-" + key + "-" + option_key + "' /><label for='rureraform-" + key + "-" + option_key + "' style='width:" + rureraform_meta[type][key]['width'] + "px;height:" + rureraform_meta[type][key]['height'] + "px;background-image:url(" + rureraform_escape_html(rureraform_meta[type][key]['options'][option_key]) + ");'></label>";
                        }
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + options + "</div></div>";
                    break;

                case 'mask':
                    options = "<option value=''>None</option>";
                    for (var option_key in rureraform_meta[type][key]['preset-options']) {
                        if (rureraform_meta[type][key]['preset-options'].hasOwnProperty(option_key)) {
                            selected = "";
                            if (option_key == properties[key + "-preset"])
                                selected = " selected='selected'";
                            options += "<option" + selected + " value='" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['preset-options'][option_key]) + "</option>";
                        }
                    }
                    temp = "<div class='rureraform-properties-content-half'><select name='rureraform-" + key + "-preset' id='rureraform-" + key + "-preset' onchange='rureraform_properties_mask_preset_changed(this);'>" + options + "</select></div>";
                    temp += "<div class='rureraform-properties-content-half'><input type='text' name='rureraform-" + key + "-mask' id='rureraform-" + key + "-mask' value='" + rureraform_escape_html(properties[key + "-mask"]) + "'" + (properties[key + "-preset"] == "custom" ? "" : " readonly='readonly'") + " /></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'radio-bar':
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['options']) {
                        if (rureraform_meta[type][key]['options'].hasOwnProperty(option_key)) {
                            selected = "";
                            if (option_key == properties[key])
                                selected = " checked='checked'";
                            options += "<input type='radio' value='" + rureraform_escape_html(option_key) + "' name='rureraform-" + key + "' id='rureraform-" + key + "-" + rureraform_escape_html(option_key) + "'" + (option_key == properties[key] ? " checked='checked'" : "") + "><label for='rureraform-" + key + "-" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['options'][option_key]) + "</label>";
                        }
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-bar-selector'>" + options + "</div></div></div>";
                    break;

                case 'select-size':
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['options']) {
                        if (rureraform_meta[type][key]['options'].hasOwnProperty(option_key)) {
                            selected = "";
                            if (option_key == properties[key + "-size"]) {
                                selected = " selected='selected'";
                            }
                            options += "<option" + selected + " value='" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_meta[type][key]['options'][option_key]) + "</option>";
                        }
                    }
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime rureraform-240'><div><select name='rureraform-" + key + "-size' id='rureraform-" + key + "-size' onchange='if(jQuery(this).val()==\"custom\"){jQuery(\"#rureraform-content-" + key + "-custom\").fadeIn(300);}else{jQuery(\"#rureraform-content-" + key + "-custom\").fadeOut(300);}'>" + options + "</select></div><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['size']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'" + (properties[key + "-size"] == "custom" ? "" : " style='display:none;'") + " id='rureraform-content-" + key + "-custom'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-custom' id='rureraform-" + key + "-custom' value='" + rureraform_escape_html(properties[key + '-custom']) + "' placeholder='Ex. 480' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['custom']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'input-icons':
                    temp = "";
                    icon_left = properties[key + "-left-icon"];
                    if (icon_left == "")
                        icon_left = "rureraform-fa-noicon";
                    icon_right = properties[key + "-right-icon"];
                    if (icon_right == "")
                        icon_right = "rureraform-fa-noicon";
                    temp += "<div class='rureraform-properties-content-dime'><a class='rureraform-fa-selector-button' href='#' onclick=\"return rureraform_fa_selector_open(this);\" data-id='" + key + "-left-icon'><i class='" + icon_left + "'></i></a><input type='hidden' name='rureraform-" + key + "-left-icon' id='rureraform-" + key + "-left-icon' value='" + rureraform_escape_html(properties[key + "-left-icon"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['left']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-left-size' id='rureraform-" + key + "-left-size' value='" + rureraform_escape_html(properties[key + '-left-size']) + "' placeholder='Ex. 10' /></div>";
                    temp += "<div class='rureraform-properties-content-dime'></div>";
                    temp += "<div class='rureraform-properties-content-dime'><a class='rureraform-fa-selector-button' href='#' onclick=\"return rureraform_fa_selector_open(this);\" data-id='" + key + "-right-icon'><i class='" + icon_right + "'></i></a><input type='hidden' name='rureraform-" + key + "-right-icon' id='rureraform-" + key + "-right-icon' value='" + rureraform_escape_html(properties[key + "-right-icon"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['right']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime rureraform-input-units rureraform-input-px'><input type='text' class='rureraform-ta-right' name='rureraform-" + key + "-right-size' id='rureraform-" + key + "-right-size' value='" + rureraform_escape_html(properties[key + '-right-size']) + "' placeholder='Ex. 10' /></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'button-icons':
                    temp = "";
                    icon_left = properties[key + "-left"];
                    if (icon_left == "")
                        icon_left = "rureraform-fa-noicon";
                    icon_right = properties[key + "-right"];
                    if (icon_right == "")
                        icon_right = "rureraform-fa-noicon";
                    temp += "<div class='rureraform-properties-content-dime'><a class='rureraform-fa-selector-button' href='#' onclick=\"return rureraform_fa_selector_open(this);\" data-id='" + key + "-left'><i class='" + icon_left + "'></i></a><input type='hidden' name='rureraform-" + key + "-left' id='rureraform-" + key + "-left' value='" + rureraform_escape_html(properties[key + "-left"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['left']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><a class='rureraform-fa-selector-button' href='#' onclick=\"return rureraform_fa_selector_open(this);\" data-id='" + key + "-right'><i class='" + icon_right + "'></i></a><input type='hidden' name='rureraform-" + key + "-right' id='rureraform-" + key + "-right' value='" + rureraform_escape_html(properties[key + "-right"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['right']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-9dimes'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'css':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-content-css'></div><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_css_add(\"" + type + "\", null);'><i class='fas fa-plus'></i><label>Add a style</label></a></div></div>";
                    break;

                case 'confirmations':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><em>" + rureraform_meta[type][key]['message'] + "</em><div class='rureraform-properties-content-confirmations'></div><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_confirmations_add(null);'><i class='fas fa-plus'></i><label>Add confirmation</label></a></div></div>";
                    break;

                case 'math-expressions':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-content-math-expressions'></div><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_math_add(null);'><i class='fas fa-plus'></i><label>Add math expression</label></a></div></div>";
                    break;

                case 'notifications':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><em>" + rureraform_meta[type][key]['message'] + "</em><div class='rureraform-properties-content-notifications'></div><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_notifications_add(null);'><i class='fas fa-plus'></i><label>Add notification</label></a></div></div>";
                    break;

                case 'integrations':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><em>" + rureraform_meta[type][key]['message'] + "</em><div class='rureraform-properties-content-integrations'></div><div class='rureraform-properties-content-integrations-providers'>";
                    if (rureraform_integration_providers.length == 0) {
                        html += "<div class='rureraform-properties-inline-error'>Activate at least one marketing/CRM system on Advanced Settings page.</div>";
                    } else {
                        for (var provider_key in rureraform_integration_providers) {
                            if (rureraform_integration_providers.hasOwnProperty(provider_key)) {
                                html += "<a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_integrations_add(null, -1, \"" + rureraform_escape_html(provider_key) + "\");'><i class='fas fa-plus'></i><label>" + rureraform_escape_html(rureraform_integration_providers[provider_key]) + "</label></a>";
                            }
                        }
                    }
                    html += "</div></div></div>";
                    break;

                case 'payment-gateways':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><em>" + rureraform_meta[type][key]['message'] + "</em><div class='rureraform-properties-content-payment-gateways'></div><div class='rureraform-properties-content-payment-gateways-providers'>";
                    if (rureraform_payment_providers.length == 0) {
                        html += "<div class='rureraform-properties-inline-error'>Activate at least one payment provider on Advanced Settings page.</div>";
                    } else {
                        for (var provider_key in rureraform_payment_providers) {
                            if (rureraform_payment_providers.hasOwnProperty(provider_key)) {
                                html += "<a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_payment_gateways_add(null, -1, \"" + rureraform_escape_html(provider_key) + "\");'><i class='fas fa-plus'></i><label>" + rureraform_escape_html(rureraform_payment_providers[provider_key]) + "</label></a>";
                            }
                        }
                    }
                    html += "</div></div></div>";
                    break;

                case 'validators':
                    options = "";
                    for (var j = 0; j < rureraform_meta[type][key]['allowed-values'].length; j++) {
                        if (rureraform_validators.hasOwnProperty(rureraform_meta[type][key]['allowed-values'][j])) {
                            options += "<a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' title='" + rureraform_validators[rureraform_meta[type][key]['allowed-values'][j]]["tooltip"] + "' onclick='return rureraform_properties_validators_add(\"" + properties["id"] + "\", \"" + type + "\", \"" + rureraform_meta[type][key]['allowed-values'][j] + "\", null);'><i class='fas fa-plus'></i><label>" + rureraform_validators[rureraform_meta[type][key]['allowed-values'][j]]["label"] + "</label></a> ";
                        }
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-content-validators'></div><div class='rureraform-properties-content-validators-allowed'>" + options + "</div></div></div>";
                    break;

                case 'filters':
                    options = "";
                    for (var j = 0; j < rureraform_meta[type][key]['allowed-values'].length; j++) {
                        if (rureraform_filters.hasOwnProperty(rureraform_meta[type][key]['allowed-values'][j])) {
                            options += "<a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' title='" + rureraform_filters[rureraform_meta[type][key]['allowed-values'][j]]["tooltip"] + "' onclick='return rureraform_properties_filters_add(\"" + type + "\", \"" + rureraform_meta[type][key]['allowed-values'][j] + "\", null);'><i class='fas fa-plus'></i><label>" + rureraform_filters[rureraform_meta[type][key]['allowed-values'][j]]["label"] + "</label></a> ";
                        }
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-content-filters'></div><div class='rureraform-properties-content-filters-allowed'>" + options + "</div></div></div>";
                    break;

                case 'error':
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label class='rureraform-red'>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' placeholder='" + rureraform_escape_html(rureraform_meta[type][key]['value']) + "' /><em>Default message: " + rureraform_escape_html(rureraform_meta[type][key]['value']) + "</em></div></div>";
                    break;

                case 'options':
                    options = "";
                    for (var j = 0; j < properties[key].length; j++) {
                        selected = false;
                        if (properties[key][j].hasOwnProperty("default") && properties[key][j]["default"] == "on")
                            selected = true;
                        options += rureraform_properties_options_item_get(properties[key][j]["label"], properties[key][j]["value"], selected);
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-options-table-header'><div>Label</div><div>Value</div><div></div></div><div class='rureraform-properties-options-box'><div class='rureraform-properties-options-container' data-multi='" + rureraform_escape_html(rureraform_meta[type][key]['multi-select']) + "'>" + options + "</div></div><div class='rureraform-properties-options-table-footer'><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_options_new(null);'><i class='fas fa-plus'></i><label>Add option</label></a><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_bulk_options_open(this);'><i class='fas fa-plus'></i><label>Add bulk options</label></a></div></div></div>";
                    break;

                case 'image-options':
                    options = "";
                    for (var j = 0; j < properties[key].length; j++) {
                        selected = "";
                        if (properties[key][j].hasOwnProperty("default") && properties[key][j]["default"] == "on")
                            selected = " rureraform-properties-options-item-default";
                        options += "<div class='rureraform-properties-options-item" + selected + "'><div class='rureraform-properties-options-table'><div class='rureraform-image-url'><input class='rureraform-properties-options-image' type='text' value='" + rureraform_escape_html(properties[key][j]["image"]) + "' placeholder='URL'><span><i class='far fa-image'></i></span></div><div><input class='rureraform-properties-options-label' type='text' value='" + rureraform_escape_html(properties[key][j]["label"]) + "' placeholder='Label'></div><div><input class='rureraform-properties-options-value' type='text' value='" + rureraform_escape_html(properties[key][j]["value"]) + "' placeholder='Value'></div><div><span onclick='return rureraform_properties_options_default(this);' title='Set the option as a default value'><i class='fas fa-check'></i></span><span onclick='return rureraform_properties_options_new(this);' title='Add the option after this one'><i class='fas fa-plus'></i></span><span onclick='return rureraform_properties_options_copy(this);' title='Duplicate the option'><i class='far fa-copy'></i></span><span onclick='return rureraform_properties_options_delete(this);' title='Delete the option'><i class='fas fa-trash-alt'></i></span><span title='Move the option'><i class='fas fa-arrows-alt rureraform-properties-options-item-handler'></i></span></div></div></div>";
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content rureraform-properties-image-options-table'><div class='rureraform-properties-options-table-header'><div>Image</div><div>Label</div><div>Value</div><div></div></div><div class='rureraform-properties-options-box'><div class='rureraform-properties-options-container' data-multi='" + (properties['mode'] == "radio" ? "off" : "on") + "'>" + options + "</div></div><div class='rureraform-properties-options-table-footer'><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_options_new(null);'><i class='fas fa-plus'></i><label>Add option</label></a></div></div></div>";
                    break;

                case 'logic-rules':
                    var input_ids = new Array();
                    for (var j = 0; j < rureraform_form_elements.length; j++) {
                        if (rureraform_form_elements[j] == null)
                            continue;
                        //if (rureraform_form_elements[j]["id"] == properties["id"]) continue;
                        if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[j]['type']) && rureraform_toolbar_tools[rureraform_form_elements[j]['type']]['type'] == 'input') {
                            input_ids.push(rureraform_form_elements[j]["id"]);
                        }
                    }
                    if (input_ids.length > 0) {
                        temp = "<div class='rureraform-properties-group rureraform-properties-logic-header'>";
                        options = "";
                        for (var option_key in rureraform_meta[type][key]['actions']) {
                            if (rureraform_meta[type][key]['actions'].hasOwnProperty(option_key)) {
                                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (properties[key]["action"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_meta[type][key]['actions'][option_key]) + "</option>";
                            }
                        }
                        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-" + key + "-action' id='rureraform-" + key + "-action'>" + options + "</select></div>";
                        options = "";
                        for (var option_key in rureraform_meta[type][key]['operators']) {
                            if (rureraform_meta[type][key]['operators'].hasOwnProperty(option_key)) {
                                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (properties[key]["operator"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_meta[type][key]['operators'][option_key]) + "</option>";
                            }
                        }
                        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-" + key + "-operator' id='rureraform-" + key + "-operator'>" + options + "</select></div>";
                        temp += "</div>";
                        options = "";
                        for (var j = 0; j < properties[key]["rules"].length; j++) {
                            if (input_ids.indexOf(parseInt(properties[key]["rules"][j]["field"], 10)) != -1) {
                                options += rureraform_properties_logic_rule_get(properties["id"], properties[key]["rules"][j]["field"], properties[key]["rules"][j]["rule"], properties[key]["rules"][j]["token"]);
                            }
                        }
                        temp += "<div class='rureraform-properties-logic-rules'>" + options + "</div><div class='rureraform-properties-logic-buttons'><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_logic_rule_new(this, \"" + properties["id"] + "\");'><i class='fas fa-plus'></i><label>Add rule</label></a></div>";
                    } else {
                        temp = "<div class='rureraform-properties-inline-error'>There are no elements available to use for logic rules.</div>";
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'column-width':
                    temp = "";
                    for (var j = 0; j < properties["_cols"]; j++) {
                        temp += "<div class='rureraform-col-width'>";
                        temp += "<label>#" + (parseInt(j + 1, 10)) + "</label>";
                        temp += "<div class='rureraform-slider-container'><input type='hidden' name='rureraform-" + key + "-" + j + "' id='rureraform-" + key + "-" + j + "' value='" + properties[key + "-" + j] + "' /><div class='rureraform-slider' data-min='1' data-max='11' data-step='1'><div class='ui-slider-handle'></div></div></div>";
                        temp += "</div>";
                    }
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'>" + temp + "</div></div>";
                    break;

                case 'colors':
                    temp = "";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-background' id='rureraform-" + key + "-background' value='" + rureraform_escape_html(properties[key + '-background']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['background']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-border' id='rureraform-" + key + "-border' value='" + rureraform_escape_html(properties[key + '-border']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['border']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-dime'><input type='text' class='rureraform-color' data-alpha='true' name='rureraform-" + key + "-text' id='rureraform-" + key + "-text' value='" + rureraform_escape_html(properties[key + '-text']) + "' placeholder='...' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['text']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'date':
                    temp = "<div class='rureraform-properties-content-third rureraform-date'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' /><span><i class='far fa-calendar-alt'></i></span></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'date-limit':
                    options2 = "";
                    for (var j = 0; j < rureraform_form_elements.length; j++) {
                        if (rureraform_form_elements[j] == null)
                            continue;
                        if (rureraform_form_elements[j]["id"] == properties["id"])
                            continue;
                        if (rureraform_form_elements[j]["type"] == "date") {
                            options2 += "<option value='" + rureraform_form_elements[j]["id"] + "'" + (properties[key + "-field"] == rureraform_form_elements[j]["id"] ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_form_elements[j]["id"] + " | " + rureraform_form_elements[j]["name"]) + "</option>";
                        }
                    }
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['type-values']) {
                        if (rureraform_meta[type][key]['type-values'].hasOwnProperty(option_key)) {
                            if (option_key != "field" || options2 != "") {
                                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (properties[key + "-type"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_meta[type][key]['type-values'][option_key]) + "</option>";
                            }
                        }
                    }
                    temp = "<div class='rureraform-properties-content-third'><select name='rureraform-" + key + "-type' id='rureraform-" + key + "-type' onchange='var date = jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-date-limit-date\"); var field = jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-date-limit-field\"); var offset = jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-date-limit-offset\"); if (jQuery(this).val() == \"date\") {jQuery(date).show();} else {jQuery(date).hide();} if (jQuery(this).val() == \"field\") {jQuery(field).show();} else {jQuery(field).hide();} if (jQuery(this).val() == \"offset\") {jQuery(offset).show();} else {jQuery(offset).hide();}'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['type']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-third rureraform-date-limit-date rureraform-date'" + (properties[key + "-type"] == "date" ? "" : " style='display: none;'") + "><input type='text' name='rureraform-" + key + "-date' id='rureraform-" + key + "-date' value='" + rureraform_escape_html(properties[key + "-date"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['date']) + "</label><span><i class='far fa-calendar-alt'></i></span></div>";
                    temp += "<div class='rureraform-properties-content-third rureraform-date-limit-field'" + (properties[key + "-type"] == "field" ? "" : " style='display: none;'") + "><select name='rureraform-" + key + "-field' id='rureraform-" + key + "-field'>" + options2 + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['field']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-third rureraform-date-limit-offset'" + (properties[key + "-type"] == "offset" ? "" : " style='display: none;'") + "><input type='text' name='rureraform-" + key + "-offset' id='rureraform-" + key + "-offset' value='" + rureraform_escape_html(properties[key + "-offset"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['offset']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'date-default':
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['type-values']) {
                        if (rureraform_meta[type][key]['type-values'].hasOwnProperty(option_key)) {
                            if (option_key != "field") {
                                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (properties[key + "-type"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_meta[type][key]['type-values'][option_key]) + "</option>";
                            }
                        }
                    }
                    temp = "<div class='rureraform-properties-content-third'><select name='rureraform-" + key + "-type' id='rureraform-" + key + "-type' onchange='var date = jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-date-default-date\"); var offset = jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-date-default-offset\"); if (jQuery(this).val() == \"date\") {jQuery(date).show();} else {jQuery(date).hide();} if (jQuery(this).val() == \"offset\") {jQuery(offset).show();} else {jQuery(offset).hide();}'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['type']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-third rureraform-date-default-date rureraform-date'" + (properties[key + "-type"] == "date" ? "" : " style='display: none;'") + "><input type='text' name='rureraform-" + key + "-date' id='rureraform-" + key + "-date' value='" + rureraform_escape_html(properties[key + "-date"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['date']) + "</label><span><i class='far fa-calendar-alt'></i></span></div>";
                    temp += "<div class='rureraform-properties-content-third rureraform-date-default-offset'" + (properties[key + "-type"] == "offset" ? "" : " style='display: none;'") + "><input type='text' name='rureraform-" + key + "-offset' id='rureraform-" + key + "-offset' value='" + rureraform_escape_html(properties[key + "-offset"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['offset']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'time':
                    temp = "<div class='rureraform-properties-content-third rureraform-time'><input type='text' name='rureraform-" + key + "' id='rureraform-" + key + "' value='" + rureraform_escape_html(properties[key]) + "' /><span><i class='far fa-clock'></i></span></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'time-limit':
                    options2 = "";
                    for (var j = 0; j < rureraform_form_elements.length; j++) {
                        if (rureraform_form_elements[j] == null)
                            continue;
                        if (rureraform_form_elements[j]["id"] == properties["id"])
                            continue;
                        if (rureraform_form_elements[j]["type"] == "time") {
                            options2 += "<option value='" + rureraform_form_elements[j]["id"] + "'" + (properties[key + "-field"] == rureraform_form_elements[j]["id"] ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_form_elements[j]["id"] + " | " + rureraform_form_elements[j]["name"]) + "</option>";
                        }
                    }
                    options = "";
                    for (var option_key in rureraform_meta[type][key]['type-values']) {
                        if (rureraform_meta[type][key]['type-values'].hasOwnProperty(option_key)) {
                            if (option_key != "field" || options2 != "") {
                                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (properties[key + "-type"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_meta[type][key]['type-values'][option_key]) + "</option>";
                            }
                        }
                    }
                    temp = "<div class='rureraform-properties-content-third'><select name='rureraform-" + key + "-type' id='rureraform-" + key + "-type' onchange='var time = jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-time-limit-time\"); var field = jQuery(this).closest(\".rureraform-properties-content\").find(\".rureraform-time-limit-field\"); if (jQuery(this).val() == \"time\") {jQuery(time).show();} else {jQuery(time).hide();} if (jQuery(this).val() == \"field\") {jQuery(field).show();} else {jQuery(field).hide();}'>" + options + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['type']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-third rureraform-time-limit-time rureraform-time'" + (properties[key + "-type"] == "time" ? "" : " style='display: none;'") + "><input type='text' name='rureraform-" + key + "-time' id='rureraform-" + key + "-time' value='" + rureraform_escape_html(properties[key + "-time"]) + "' /><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['time']) + "</label><span><i class='far fa-clock'></i></span></div>";
                    temp += "<div class='rureraform-properties-content-third rureraform-time-limit-field'" + (properties[key + "-type"] == "field" ? "" : " style='display: none;'") + "><select name='rureraform-" + key + "-field' id='rureraform-" + key + "-field'>" + options2 + "</select><label>" + rureraform_escape_html(rureraform_meta[type][key]['caption']['field']) + "</label></div>";
                    temp += "<div class='rureraform-properties-content-two-third'></div>";
                    html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_meta[type][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-properties-group'>" + temp + "</div></div></div>";
                    break;

                case 'hr':
                    html += '<hr>';
                    break;

                default:
                    break;
            }
        }
    }
    for (var j = 0; j < sections_opened; j++)
        html += "</div>";
    sections_opened = 0;
    if (tab_html != "") {
        tab_html += "</div>";
        html += "</div>";
    }
    jQuery("#rureraform-element-properties .rureraform-admin-popup-content-form").html(tab_html + html);

    
    if (type == "settings") {
        for (var j = 0; j < rureraform_form_elements.length; j++) {
            if (rureraform_form_elements[j] == null)
                continue;
            if (rureraform_form_elements[j]['type'] == 'signature') {
                var xd = jQuery("#rureraform-element-properties .rureraform-admin-popup-content-form").find("[name='rureraform-cross-domain']");
                jQuery(xd).prop("checked", false);
                jQuery(xd).prop("disabled", true);
                break;
            }
        }
    }
    jQuery("#rureraform-properties-tabs a").first().addClass("rureraform-tab-active");
    jQuery(jQuery("#rureraform-properties-tabs a").first().attr("href")).show();
    if (properties.hasOwnProperty("css") && Array.isArray(properties["css"])) {
        for (var j = 0; j < properties["css"].length; j++) {
            rureraform_properties_css_add(type, properties["css"][j])
        }
    }
    if (properties.hasOwnProperty("validators") && Array.isArray(properties["validators"])) {
        for (var j = 0; j < properties["validators"].length; j++) {
            rureraform_properties_validators_add(properties["id"], type, properties["validators"][j]["type"], properties["validators"][j]);
        }
    }
    if (properties.hasOwnProperty("filters") && Array.isArray(properties["filters"])) {
        for (var j = 0; j < properties["filters"].length; j++) {
            rureraform_properties_filters_add(type, properties["filters"][j]["type"], properties["filters"][j]);
        }
    }
    if (properties.hasOwnProperty("confirmations") && Array.isArray(properties["confirmations"])) {
        for (var j = 0; j < properties["confirmations"].length; j++) {
            rureraform_properties_confirmations_add(properties["confirmations"][j])
        }
        jQuery(".rureraform-properties-content-confirmations").sortable({
            items: ".rureraform-properties-sub-item",
            forcePlaceholderSize: true,
            dropOnEmpty: true,
            placeholder: "rureraform-properties-sub-item-placeholder",
            start: function (e, ui) {
                if (typeof wp != 'undefined' && wp.hasOwnProperty('editor') && typeof wp.editor.initialize == 'function') {
                    jQuery(ui.item).find('.rureraform-tinymce').each(function () {
                        jQuery(this).addClass("rureraform-tinymce-pre");
                        wp.editor.remove(jQuery(this).attr("id"));
                    });
                }
            },
            stop: function (e, ui) {
                rureraform_init_tinymce();
            }
        });
        jQuery(".rureraform-properties-sub-item").disableSelection();
    }
    if (properties.hasOwnProperty("notifications") && Array.isArray(properties["notifications"])) {
        for (var j = 0; j < properties["notifications"].length; j++) {
            rureraform_properties_notifications_add(properties["notifications"][j])
        }
    }
    if (properties.hasOwnProperty("math-expressions") && Array.isArray(properties["math-expressions"])) {
        for (var j = 0; j < properties["math-expressions"].length; j++) {
            rureraform_properties_math_add(properties["math-expressions"][j])
        }
    }
    if (properties.hasOwnProperty("integrations") && Array.isArray(properties["integrations"])) {
        for (var j = 0; j < properties["integrations"].length; j++) {
            if (properties["integrations"][j]['id'] > rureraform_integration_last_id)
                rureraform_integration_last_id = properties["integrations"][j]['id'];
            rureraform_properties_integrations_add(properties["integrations"][j], j);
        }
    }
    if (properties.hasOwnProperty("payment-gateways") && Array.isArray(properties["payment-gateways"])) {
        for (var j = 0; j < properties["payment-gateways"].length; j++) {
            if (properties["payment-gateways"][j]['id'] > rureraform_payment_gateway_last_id)
                rureraform_payment_gateway_last_id = properties["payment-gateways"][j]['id'];
            rureraform_properties_payment_gateways_add(properties["payment-gateways"][j], j);
        }
    }
    if (properties.hasOwnProperty("options")) {
        jQuery(".rureraform-properties-options-box").resizable({
            grid: [5, 5],
            handles: "s"
        });

        jQuery(".rureraform-properties-options-container").sortable({
            items: ".rureraform-properties-options-item",
            forcePlaceholderSize: true,
            dropOnEmpty: true,
            placeholder: "rureraform-properties-options-item-placeholder",
            handle: ".rureraform-properties-options-item-handler"
        });
        jQuery(".rureraform-properties-options-item").disableSelection();
    }
    jQuery(".rureraform-properties-content .rureraform-date input").each(function () {
        var object = this;
        var airdatepicker = jQuery(object).airdatepicker().data('airdatepicker');
        airdatepicker.destroy();
        jQuery(object).airdatepicker({
            inline_popup: true,
            autoClose: true,
            timepicker: false,
            dateFormat: rureraform_form_options["datetime-args-date-format"]
        });
    });
    jQuery(".rureraform-properties-content .rureraform-date span").on("click", function (e) {
        e.preventDefault();
        var input = jQuery(this).parent().children("input");
        var airdatepicker = jQuery(input).airdatepicker().data('airdatepicker');
        airdatepicker.show();
    });
    jQuery(".rureraform-properties-content .rureraform-time input").each(function () {
        var object = this;
        var airdatepicker = jQuery(object).airdatepicker().data('airdatepicker');
        airdatepicker.destroy();
        jQuery(object).airdatepicker({
            inline_popup: true,
            autoClose: true,
            timepicker: true,
            onlyTimepicker: true,
            timeFormat: rureraform_form_options["datetime-args-time-format"]
        });
    });
    jQuery(".rureraform-properties-content .rureraform-time span").on("click", function (e) {
        e.preventDefault();
        var input = jQuery(this).parent().children("input");
        var airdatepicker = jQuery(input).airdatepicker().data('airdatepicker');
        airdatepicker.show();
    });
    jQuery("#rureraform-properties-tabs a").on("click", function (e) {
        e.preventDefault();
        if (jQuery(this).hasClass("rureraform-tab-active"))
            return;
        var tab_set = jQuery(this).parent();
        var active_tab = jQuery(tab_set).find(".rureraform-tab-active").attr("href");
        jQuery(tab_set).find(".rureraform-tab-active").removeClass("rureraform-tab-active");
        var tab = jQuery(this).attr("href");
        jQuery(this).addClass("rureraform-tab-active");
        jQuery(active_tab).fadeOut(300, function () {
            jQuery(tab).fadeIn(300);
        });
    });
    jQuery(".rureraform-bar-options span").on("click", function (e) {
        var parent = jQuery(this).parent();
        var value = jQuery(this).attr("data-value");
        var current_value = jQuery(parent).find("input").val();
        jQuery(parent).children("span").removeClass("rureraform-bar-option-selected");
        if (current_value == value) {
            value = "";
            jQuery(parent).find("input").val(value);
        } else {
            jQuery(this).addClass("rureraform-bar-option-selected");
            jQuery(parent).find("input").val(value);
        }
        if (jQuery(parent).find("input").attr("name") == "rureraform-label-style-position") {
            if (value == "left" || value == "right")
                jQuery("#rureraform-content-label-style-width").fadeIn(300);
            else
                jQuery("#rureraform-content-label-style-width").fadeOut(300);
        }
    });
    jQuery(".rureraform-image-url span").on("click", function (e) {
        e.preventDefault();
        var input = jQuery(this).parent().children("input");
        var media_frame = wp.media({
            title: 'Select Image',
            library: {
                type: 'image'
            },
            multiple: false
        });
        media_frame.on("select", function () {
            var attachment = media_frame.state().get("selection").first();
            jQuery(input).val(attachment.attributes.url);
        });
        media_frame.open();
    });
    jQuery(".rureraform-sections").each(function () {
        jQuery(this).find("a").on("click", function (e) {
            e.preventDefault();
            if (jQuery(this).hasClass("rureraform-section-active"))
                return;
            var sections_set = jQuery(this).parent();
            var active_section = jQuery(sections_set).find(".rureraform-section-active").attr("href");
            jQuery(sections_set).find(".rureraform-section-active").removeClass("rureraform-section-active");
            var section = jQuery(this).attr("href");
            jQuery(this).addClass("rureraform-section-active");
            if (jQuery(active_section).length > 0) {
                jQuery(active_section).fadeOut(300, function () {
                    jQuery(section).fadeIn(300);
                });
            } else
                jQuery(section).fadeIn(300);
        });
        jQuery(jQuery(this).find("a").first().attr("href")).show();
    });
    
    jQuery(".rureraform-slider").each(function () {
        var input = jQuery(this).parent().children("input");
        jQuery(this).slider({
            min: parseInt(jQuery(this).attr("data-min"), 10),
            max: parseInt(jQuery(this).attr("data-max"), 10),
            step: parseInt(jQuery(this).attr("data-step"), 10),
            value: rureraform_is_numeric(jQuery(input).val()) ? parseInt(jQuery(input).val(), 10) : 4,
            create: function () {
                jQuery(this).find(".ui-slider-handle").text(jQuery(this).slider("value"));
            },
            slide: function (event, ui) {
                jQuery(this).find(".ui-slider-handle").text(ui.value);
                jQuery(input).val(ui.value);
            }
        });
    });
    jQuery(".rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
        contentAsHTML: true,
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom",
        content: "Default",
        functionFormat: function (instance, helper, content) {
            return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
        }
    });
    jQuery(".rureraform-properties-content-validators-allowed a[title], .rureraform-properties-content-filters-allowed a[title]").tooltipster({
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom"
    });

    jQuery(".rureraform-properties-content input").on("keyup", function (e) {
        rureraform_properties_change();
    });
    jQuery(".rureraform-properties-content input, .rureraform-properties-content select").on("change", function (e) {
        rureraform_properties_change();
    });
    rureraform_init_tinymce();
    rureraform_properties_visible_conditions(_object);
    // Prepare editor state - end
    return false;
}
function rureraform_properties_open(_object) {
    jQuery("#rureraform-element-properties .rureraform-admin-popup-content-form").html("");
    var window_height = 500;//2 * parseInt((jQuery(window).height() - 100) / 2, 10);
    var window_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 880), 1080);
    jQuery("#rureraform-element-properties").height(window_height);
    jQuery("#rureraform-element-properties").width(window_width);
    jQuery("#rureraform-element-properties .rureraform-admin-popup-inner").height(window_height);
    jQuery("#rureraform-element-properties .rureraform-admin-popup-content").height(window_height - 104);
    jQuery("#rureraform-element-properties-overlay").fadeIn(300);
    jQuery("#rureraform-element-properties").fadeIn(300);
    rureraform_element_properties_active = _object;
    rureraform_element_properties_data_changed = false;
    jQuery("#rureraform-element-properties .rureraform-admin-popup-loading").show();

    setTimeout(function () {
        _rureraform_properties_prepare(_object);
        jQuery("#rureraform-element-properties .rureraform-admin-popup-loading").hide();
    }, 500);
    return false;
}
function rureraform_styles_html() {
    var html = "<select onchange='rureraform_styles_load(this);'><option value=''>" + rureraform_esc_html__("Select theme...") + "</option>";
    var type = -1;
    var user_options = "", native_options = "";
    for (var j = 0; j < rureraform_styles.length; j++) {
        if (rureraform_styles[j]["type"] == 1)
            native_options += "<option value='" + rureraform_escape_html(rureraform_styles[j]["id"]) + "'>" + rureraform_escape_html(rureraform_styles[j]["name"]) + "</option>";
        else
            user_options += "<option value='" + rureraform_escape_html(rureraform_styles[j]["id"]) + "'>" + rureraform_escape_html(rureraform_styles[j]["name"]) + "</option>";
    }
    html += (native_options == "" ? "" : "<optgroup label='" + rureraform_esc_html__("Native Themes") + "'>" + native_options + "</optgroup>") + (user_options == "" ? "" : "<optgroup label='" + rureraform_esc_html__("User Themes") + "'>" + user_options + "</optgroup>") + "</select>";
    return html;
}
function rureraform_styles_save(_object) {
    var html = '';
    rureraform_dialog_open({
        title: rureraform_esc_html__('Save As...'),
        echo_html: function () {
            var html = "";
            var options = "<option value='0'>" + rureraform_esc_html__("Create new theme...", "rureraform") + "</option>";
            for (var i = 0; i < rureraform_styles.length; i++) {
                if (rureraform_styles[i]['type'] == 0) {
                    options += "<option value='" + rureraform_escape_html(rureraform_styles[i]['id']) + "'>" + rureraform_escape_html(rureraform_styles[i]['name']) + "</option>";
                }
            }
            html += "<div class='rureraform-style-save-row'><label>" + rureraform_esc_html__("Save as", "rureraform") + ":</label><select id='rureraform-style-id' onchange='jQuery(this).val() == 0 ? jQuery(\"#rureraform-style-save-row-name\").show() : jQuery(\"#rureraform-style-save-row-name\").hide();'>" + options + "</select></div>"
            html += "<div class='rureraform-style-save-row' id='rureraform-style-save-row-name'><label>" + rureraform_esc_html__("Name", "rureraform") + ":</label><input type='text' value='" + rureraform_escape_html(rureraform_form_options['name'] + " theme") + "' placeholder='" + rureraform_esc_html__("Enter theme name...", "rureraform") + "' id='rureraform-style-name' /></div>"
            this.html(html);
            this.show();
        },
        height: 320,
        ok_label: rureraform_esc_html__('Save Theme'),
        ok_function: function (e) {
            _rureraform_styles_save(jQuery("#rureraform-dialog .rureraform-dialog-button-ok"));
        }
    });
}
function _rureraform_styles_save(_object) {
    var input, key, key2, style_options = {};
    if (rureraform_element_properties_active == null)
        return false;
    var type = jQuery(rureraform_element_properties_active).attr("data-type");
    if (typeof type == undefined || type != "settings")
        return false;
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var icon = jQuery(_object).find("i").attr("class");
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    for (var key in rureraform_form_options) {
        if (rureraform_form_options.hasOwnProperty(key)) {
            input = jQuery("[name='rureraform-" + key + "']");
            if (input.length == 0)
                continue;
            key2 = jQuery(input[0]).closest(".rureraform-properties-item").attr("data-id");
            if (typeof type == typeof undefined)
                continue;
            if ((rureraform_meta["settings"][key2]).hasOwnProperty('group') && rureraform_meta["settings"][key2]['group'] == 'style') {
                if (input.length > 1) {
                    jQuery(input).each(function () {
                        if (jQuery(this).is(":checked")) {
                            style_options[key] = jQuery(this).val();
                            return false;
                        }
                    });
                } else if (input.length > 0) {
                    if (jQuery(input).is(":checked"))
                        style_options[key] = "on";
                    else
                        style_options[key] = jQuery(input).val();
                }
            }
        }
    }
    var post_data = {"action": "rureraform-style-save", "id": jQuery("#rureraform-style-id").val(), "name": rureraform_encode64(jQuery("#rureraform-style-name").val()), "options": rureraform_encode64(JSON.stringify(style_options)), "form-name": rureraform_encode64(rureraform_form_options['name'])};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_styles = data.styles;
                    var html = rureraform_styles_html();
                    jQuery(".rureraform-styles-select-container").html(html);
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).find("i").attr("class", icon);
            rureraform_sending = false;
            rureraform_dialog_close();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", icon);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_styles_load(_object) {
    var style_id = jQuery(_object).val();
    if (style_id == "")
        return false;
    jQuery(_object).val("");
    rureraform_dialog_open({
        title: rureraform_esc_html__('Apply theme'),
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Do you want to apply new theme?", "rureraform") + "<br />" + rureraform_esc_html__("Important! Existing style parameters will be overwritten by new ones.", "rureraform") + "</div>");
            this.show();
        },
        height: 240,
        ok_label: rureraform_esc_html__('Apply Theme'),
        ok_function: function (e) {
            _rureraform_styles_load(jQuery("#rureraform-dialog .rureraform-dialog-button-ok"), style_id);
        }
    });
}
function _rureraform_styles_load(_object, _style_id) {
    var input, key, key2, style_options = {};
    if (rureraform_element_properties_active == null)
        return false;
    var type = jQuery(rureraform_element_properties_active).attr("data-type");
    if (typeof type == undefined || type != "settings")
        return false;
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var icon = jQuery(_object).find("i").attr("class");
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");

    var post_data = {"action": "rureraform-style-load", "id": _style_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    for (var key in data.options) {
                        if (data.options.hasOwnProperty(key)) {
                            input = jQuery("[name='rureraform-" + key + "']");
                            if (input.length == 0)
                                continue;
                            key2 = jQuery(input[0]).closest(".rureraform-properties-item").attr("data-id");
                            if (typeof type == typeof undefined)
                                continue;
                            if ((rureraform_meta["settings"][key2]).hasOwnProperty('group') && rureraform_meta["settings"][key2]['group'] == 'style') {
                                jQuery(input).each(function () {
                                    var input_type = jQuery(this).attr("type");
                                    var input_value = jQuery(this).val();
                                    if (typeof input_type !== typeof undefined) {
                                        if (input_type == "radio") {
                                            if (input_value == (data.options)[key])
                                                jQuery(this).prop("checked", true);
                                            else
                                                jQuery(this).prop("checked", false);
                                        } else if (input_type == "checkbox") {
                                            if ((data.options)[key] == "on")
                                                jQuery(this).prop("checked", true);
                                            else
                                                jQuery(this).prop("checked", false);
                                        } else
                                            jQuery(this).val((data.options)[key]);
                                    } else
                                        jQuery(this).val((data.options)[key]);
                                });
                            }
                        }
                    }
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).find("i").attr("class", icon);
            rureraform_sending = false;
            rureraform_dialog_close();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", icon);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
            rureraform_dialog_close();
        }
    });
    return false;
}

function rureraform_properties_save() {
    var properties, logic, attachments, input, page_i, temp, id;
    if (rureraform_element_properties_active == null)
        return false;
    var type = jQuery(rureraform_element_properties_active).attr("data-type");
    if (typeof type == undefined || type == "")
        return false;

    jQuery("#rureraform-element-properties .rureraform-admin-popup-buttons .rureraform-admin-button").find("i").attr("class", "fas fa-spin fa-spinner");
    if (type == "settings") {
        properties = rureraform_form_options;
    } else if (type == "page" || type == "page-confirmation") {
        id = jQuery(rureraform_element_properties_active).closest("li").attr("data-id");
        properties = null;
        for (var i = 0; i < rureraform_form_pages.length; i++) {
            if (rureraform_form_pages[i] != null && rureraform_form_pages[i]["id"] == id) {
                page_i = i;
                properties = rureraform_form_pages[i];
                break;
            }
        }
    } else {
        i = jQuery(rureraform_element_properties_active).attr("id");
        i = i.replace("rureraform-element-", "");
        properties = rureraform_form_elements[i];
    }
    for (var key in properties) {
        if (properties.hasOwnProperty(key)) {
            input = jQuery("[name='rureraform-" + key + "']");
            if (key == "personal-keys") {
                properties[key] = new Array();
                jQuery(input).each(function () {
                    if (jQuery(this).is(":checked")) {
                        properties[key].push(parseInt(jQuery(this).val(), 10));
                    }
                });
            } else if (input.length > 1) {
                jQuery(input).each(function () {
                    if (jQuery(this).is(":checked")) {
                        properties[key] = jQuery(this).val();
                        return false;
                    }
                });
            } else if (input.length > 0) {
                if (jQuery(input).hasClass("rureraform-tinymce") && typeof wp != 'undefined' && wp.hasOwnProperty('editor') && typeof wp.editor.initialize == 'function') {
                    properties[key] = wp.editor.getContent(jQuery(input).attr("id"));
                } else if (jQuery(input).is(":checked"))
                    properties[key] = "on";
                else
                    properties[key] = jQuery(input).val();
            }
        }
    }

    if (properties.hasOwnProperty("css")) {
        properties["css"] = new Array();
        jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item").each(function () {
            (properties["css"]).push({"selector": jQuery(this).find(".rureraform-properties-sub-item-body select").val(), "css": jQuery(this).find(".rureraform-properties-sub-item-body textarea").val()});
        });
    }
    if (properties.hasOwnProperty("validators")) {
        properties["validators"] = new Array();
        jQuery(".rureraform-properties-content-validators .rureraform-properties-sub-item").each(function () {
            var validator_type = jQuery(this).attr("data-type");
            if (rureraform_validators.hasOwnProperty(validator_type)) {
                var validator = {"type": validator_type, "properties": {}};
                for (var key in rureraform_validators[validator_type]["properties"]) {
                    if (rureraform_validators[validator_type]["properties"].hasOwnProperty(key)) {
                        if (jQuery(this).find("[name=rureraform-validators-" + key + "]").length > 0) {
                            if (jQuery(this).find("[name=rureraform-validators-" + key + "]").is(":checked"))
                                validator["properties"][key] = "on";
                            else
                                validator["properties"][key] = jQuery(this).find("[name=rureraform-validators-" + key + "]").val();
                        }
                    }
                }
                (properties["validators"]).push(validator);
            }
        });
    }
    if (properties.hasOwnProperty("filters")) {
        properties["filters"] = new Array();
        jQuery(".rureraform-properties-content-filters .rureraform-properties-sub-item").each(function () {
            var filter_type = jQuery(this).attr("data-type");
            if (rureraform_filters.hasOwnProperty(filter_type)) {
                var filter = {"type": filter_type, "properties": {}};
                for (var key in rureraform_filters[filter_type]["properties"]) {
                    if (rureraform_filters[filter_type]["properties"].hasOwnProperty(key)) {
                        if (jQuery(this).find("[name=rureraform-filters-" + key + "]").length > 0) {
                            if (jQuery(this).find("[name=rureraform-filters-" + key + "]").is(":checked"))
                                filter["properties"][key] = "on";
                            else
                                filter["properties"][key] = jQuery(this).find("[name=rureraform-filters-" + key + "]").val();
                        }
                    }
                }
                (properties["filters"]).push(filter);
            }
        });
    }
    if (properties.hasOwnProperty("options")) {
        properties["options"] = new Array();
        jQuery(".rureraform-properties-options-container .rureraform-properties-options-item").each(function () {
            var selected = "off";
            if (jQuery(this).hasClass("rureraform-properties-options-item-default"))
                selected = "on";
            (properties["options"]).push({"default": selected, "label": jQuery(this).find(".rureraform-properties-options-label").val(), "value": jQuery(this).find(".rureraform-properties-options-value").val(), "image": jQuery(this).find(".rureraform-properties-options-image").val()});
        });
    }
    if (properties.hasOwnProperty("confirmations")) {
        properties["confirmations"] = new Array();
        jQuery(".rureraform-properties-content-confirmations .rureraform-properties-sub-item").each(function () {
            logic = {
                "action": jQuery(this).find("[name='rureraform-confirmations-logic-action']").val(),
                "operator": jQuery(this).find("[name='rureraform-confirmations-logic-operator']").val(),
                "rules": new Array()
            };
            jQuery(this).find(".rureraform-properties-logic-rule").each(function () {
                (logic["rules"]).push({"field": parseInt(jQuery(this).find(".rureraform-properties-logic-rule-field").val(), 10), "rule": jQuery(this).find(".rureraform-properties-logic-rule-rule").val(), "token": jQuery(this).find(".rureraform-properties-logic-rule-token").val()});
            });
            var temp = "";
            input = jQuery(this).find("[name='rureraform-confirmations-message']");
            if (jQuery(input).hasClass("rureraform-tinymce") && typeof wp != 'undefined' && wp.hasOwnProperty('editor') && typeof wp.editor.initialize == 'function') {
                temp = wp.editor.getContent(jQuery(input).attr("id"));
            } else
                temp = jQuery(input).val();
            (properties["confirmations"]).push({
                "name": jQuery(this).find("[name='rureraform-confirmations-name']").val(),
                "type": jQuery(this).find("[name='rureraform-confirmations-type']").val(),
                "message": temp,
                "url": jQuery(this).find("[name='rureraform-confirmations-url']").val(),
                "delay": jQuery(this).find("[name='rureraform-confirmations-delay']").val(),
                "payment-gateway": jQuery(this).find("[name='rureraform-confirmations-payment-gateway']").val(),
                "reset-form": jQuery(this).find("[name='rureraform-confirmations-reset-form']").is(":checked") ? "on" : "off",
                "logic-enable": jQuery(this).find("[name='rureraform-confirmations-logic-enable']").is(":checked") ? "on" : "off",
                "logic": logic
            });
        });
    }
    if (properties.hasOwnProperty("notifications")) {
        properties["notifications"] = new Array();
        jQuery(".rureraform-properties-content-notifications .rureraform-properties-sub-item").each(function () {
            logic = {
                "action": jQuery(this).find("[name='rureraform-notifications-logic-action']").val(),
                "operator": jQuery(this).find("[name='rureraform-notifications-logic-operator']").val(),
                "rules": new Array()
            };
            jQuery(this).find(".rureraform-properties-logic-rule").each(function () {
                (logic["rules"]).push({"field": parseInt(jQuery(this).find(".rureraform-properties-logic-rule-field").val(), 10), "rule": jQuery(this).find(".rureraform-properties-logic-rule-rule").val(), "token": jQuery(this).find(".rureraform-properties-logic-rule-token").val()});
            });
            attachments = new Array();
            jQuery(this).find(".rureraform-properties-attachment").each(function () {
                attachments.push({"source": jQuery(this).find(".rureraform-properties-attachment-source").val(), "token": jQuery(this).find(".rureraform-properties-attachment-token").val()});
            });

            var temp = "";
            input = jQuery(this).find("[name='rureraform-notifications-message']");
            if (jQuery(input).hasClass("rureraform-tinymce") && typeof wp != 'undefined' && wp.hasOwnProperty('editor') && typeof wp.editor.initialize == 'function') {
                temp = wp.editor.getContent(jQuery(input).attr("id"));
            } else
                temp = jQuery(input).val();
            (properties["notifications"]).push({
                "name": jQuery(this).find("[name='rureraform-notifications-name']").val(),
                "enabled": jQuery(this).find("[name='rureraform-notifications-enabled']").is(":checked") ? "on" : "off",
                "action": jQuery(this).find("[name='rureraform-notifications-action']").val(),
                "recipient-email": jQuery(this).find("[name='rureraform-notifications-recipient-email']").val(),
                "subject": jQuery(this).find("[name='rureraform-notifications-subject']").val(),
                "message": temp,
                "attachments": attachments,
                "reply-email": jQuery(this).find("[name='rureraform-notifications-reply-email']").val(),
                "from-email": jQuery(this).find("[name='rureraform-notifications-from-email']").val(),
                "from-name": jQuery(this).find("[name='rureraform-notifications-from-name']").val(),
                "logic-enable": jQuery(this).find("[name='rureraform-notifications-logic-enable']").is(":checked") ? "on" : "off",
                "logic": logic
            });
        });
    }
    if (properties.hasOwnProperty("math-expressions")) {
        properties["math-expressions"] = new Array();
        jQuery(".rureraform-properties-content-math-expressions .rureraform-properties-sub-item").each(function () {
            (properties["math-expressions"]).push({
                "id": jQuery(this).find("[name='rureraform-math-id']").val(),
                "name": jQuery(this).find("[name='rureraform-math-name']").val(),
                "expression": jQuery(this).find("[name='rureraform-math-expression']").val(),
                "decimal-digits": parseInt(jQuery(this).find("[name='rureraform-math-decimal-digits']").val(), 10),
                "default": jQuery(this).find("[name='rureraform-math-default']").val()
            });
        });
    }
    var integrations;
    if (properties.hasOwnProperty("integrations")) {
        integrations = new Array();
        jQuery(".rureraform-properties-content-integrations .rureraform-properties-sub-item").each(function () {
            logic = {
                "action": jQuery(this).find("[name='rureraform-integrations-logic-action']").val(),
                "operator": jQuery(this).find("[name='rureraform-integrations-logic-operator']").val(),
                "rules": new Array()
            };
            jQuery(this).find(".rureraform-properties-logic-rule").each(function () {
                (logic["rules"]).push({"field": parseInt(jQuery(this).find(".rureraform-properties-logic-rule-field").val(), 10), "rule": jQuery(this).find(".rureraform-properties-logic-rule-rule").val(), "token": jQuery(this).find(".rureraform-properties-logic-rule-token").val()});
            });
            var content = jQuery(this).find(".rureraform-integrations-content");
            var data = {};
            var idx = jQuery(this).find("[name='rureraform-integrations-idx']").val();
            var data_loaded = jQuery(this).attr("data-loaded");
            if (properties["integrations"][idx] !== void 0 && data_loaded == "off") {
                data = properties["integrations"][idx]["data"];
            } else {
                jQuery(content).find("input, select, textarea").each(function () {
                    if (jQuery(this).attr("data-skip") == "on")
                        return;
                    if (jQuery(this).attr("data-custom") == "on")
                        return;
                    var input_type = jQuery(this).attr("type");
                    var name = jQuery(this).attr("name");
                    var include_empty = jQuery(this).attr("data-empty");
                    var name_parts = name.split(/(.*?)\[(.*?)\]/);
                    if (name_parts.length > 2) {
                        if (!data.hasOwnProperty(name_parts[1]))
                            data[name_parts[1]] = {};
                        if (input_type == "checkbox") {
                            if (jQuery(this).is(":checked"))
                                (data[name_parts[1]])[name_parts[2]] = jQuery(this).val();
                        } else if (jQuery(this).val().length > 0 || include_empty == "on")
                            (data[name_parts[1]])[name_parts[2]] = jQuery(this).val();
                    } else {
                        if (input_type == "checkbox") {
                            if (jQuery(this).is(":checked"))
                                data[name_parts[0]] = "on";
                            else
                                data[name_parts[0]] = "off";
                        } else if (jQuery(this).val().length > 0 || include_empty == "on")
                            data[name_parts[0]] = jQuery(this).val();
                    }
                });
                jQuery(content).find(".rureraform-integrations-custom").each(function () {
                    var name, value;
                    var param_names = jQuery(this).attr("data-names");
                    var param_values = jQuery(this).attr("data-values");
                    var param_all = jQuery(this).attr("data-all");
                    if (param_all != "on")
                        param_all = "off";
                    data[param_names] = new Array();
                    data[param_values] = new Array();
                    var names = jQuery(this).find("input.rureraform-integrations-custom-name");
                    var values = jQuery(this).find("input.rureraform-integrations-custom-value");
                    for (var j = 0; j < names.length; j++) {
                        name = jQuery(names[j]).val();
                        value = jQuery(values[j]).val();
                        if (name.length > 0 && (value.length > 0 || param_all == "on")) {
                            (data[param_names]).push(name);
                            (data[param_values]).push(value);
                        }
                    }
                });
            }
            integrations.push({
                "name": jQuery(this).find("[name='rureraform-integrations-name']").val(),
                "enabled": jQuery(this).find("[name='rureraform-integrations-enabled']").is(":checked") ? "on" : "off",
                "action": jQuery(this).find("[name='rureraform-integrations-action']").val(),
                "provider": jQuery(this).find("[name='rureraform-integrations-provider']").val(),
                "data": data,
                "logic-enable": jQuery(this).find("[name='rureraform-integrations-logic-enable']").is(":checked") ? "on" : "off",
                "logic": logic
            });
        });
        properties["integrations"] = integrations;
    }
    if (properties.hasOwnProperty("payment-gateways")) {
        integrations = new Array();
        jQuery(".rureraform-properties-content-payment-gateways .rureraform-properties-sub-item").each(function () {
            var content = jQuery(this).find(".rureraform-payment-gateways-content");
            var data = {};
            var idx = jQuery(this).find("[name='rureraform-payment-gateways-idx']").val();
            var data_loaded = jQuery(this).attr("data-loaded");
            if (properties["payment-gateways"][idx] !== void 0 && data_loaded == "off") {
                data = properties["payment-gateways"][idx]["data"];
            } else {
                jQuery(content).find("input, select, textarea").each(function () {
                    if (jQuery(this).attr("data-skip") == "on")
                        return;
                    var input_type = jQuery(this).attr("type");
                    var name = jQuery(this).attr("name");
                    if (name) {
                        var name_parts = name.split(/(.*?)\[(.*?)\]/);
                        if (name_parts.length > 2) {
                            if (!data.hasOwnProperty(name_parts[1]))
                                data[name_parts[1]] = {};
                            if (input_type == "checkbox") {
                                if (jQuery(this).is(":checked"))
                                    (data[name_parts[1]])[name_parts[2]] = jQuery(this).val();
                            } else if (jQuery(this).val().length > 0)
                                (data[name_parts[1]])[name_parts[2]] = jQuery(this).val();
                        } else {
                            if (input_type == "checkbox") {
                                if (jQuery(this).is(":checked"))
                                    data[name_parts[0]] = jQuery(this).val();
                            } else if (jQuery(this).val().length > 0)
                                data[name_parts[0]] = jQuery(this).val();
                        }
                    }
                });
            }
            integrations.push({
                "id": jQuery(this).find("[name='rureraform-payment-gateways-id']").val(),
                "name": jQuery(this).find("[name='rureraform-payment-gateways-name']").val(),
                "provider": jQuery(this).find("[name='rureraform-payment-gateways-provider']").val(),
                "data": data
            });
        });
        properties["payment-gateways"] = integrations;
    }

    if (properties.hasOwnProperty("logic")) {
        properties["logic"] = {};
        if (jQuery("#rureraform-logic-action").length > 0)
            properties["logic"]["action"] = jQuery("#rureraform-logic-action").val();
        else
            properties["logic"]["action"] = rureraform_meta[properties['type']]['logic']['values']['action'];
        if (jQuery("#rureraform-logic-operator").length > 0)
            properties["logic"]["operator"] = jQuery("#rureraform-logic-operator").val();
        else
            properties["logic"]["operator"] = rureraform_meta[properties['type']]['logic']['values']['operator'];
        properties["logic"]["rules"] = new Array();
        jQuery(".rureraform-properties-logic-rules .rureraform-properties-logic-rule").each(function () {
            (properties["logic"]["rules"]).push({"field": parseInt(jQuery(this).find(".rureraform-properties-logic-rule-field").val(), 10), "rule": jQuery(this).find(".rureraform-properties-logic-rule-rule").val(), "token": jQuery(this).find(".rureraform-properties-logic-rule-token").val()});
        });
    }
    if (type == "settings") {
        rureraform_form_options = properties;
    } else if (type == "page" || type == "page-confirmation") {
        rureraform_form_pages[page_i] = properties;
        jQuery(".rureraform-pages-bar-item, .rureraform-pages-bar-item-confirmation").each(function () {
            var page_id = jQuery(this).attr("data-id");
            if (page_id == properties['id'])
                jQuery(this).find("label").text(properties['name']);
        });
    } else {
        rureraform_form_elements[i] = properties;
    }
    rureraform_form_changed = true;
    _rureraform_properties_close();
    rureraform_build();
    return false;
}
function rureraform_properties_close() {
    if (rureraform_element_properties_data_changed) {
        rureraform_dialog_open({
            echo_html: function () {
                this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Seems you didn't save changes. Are you sure, you want to close Properties?", "rureraform") + "</div>");
                this.show();
            },
            ok_label: 'Close Properties',
            ok_function: function (e) {
                _rureraform_properties_close();
                rureraform_dialog_close();
            }
        });
    } else
        _rureraform_properties_close();
    return false;
}
function _rureraform_properties_close() {
    rureraform_element_properties_data_changed = false;
    rureraform_element_properties_active = null;
    jQuery("#rureraform-element-properties-overlay").fadeOut(300);
    jQuery("#rureraform-element-properties").fadeOut(300, function () {
        if (typeof wp != 'undefined' && wp.hasOwnProperty('editor') && typeof wp.editor.initialize == 'function') {
            jQuery(".rureraform-tinymce").each(function () {
                wp.editor.remove(jQuery(this).attr("id"));
            });
        }
        jQuery("#rureraform-element-properties .rureraform-admin-popup-content-form").html("");
        jQuery("#rureraform-element-properties .rureraform-admin-popup-buttons .rureraform-admin-button").find("i").attr("class", "fas fa-check");
        jQuery("body").removeClass("rureraform-static");
    });
}
function rureraform_properties_change() {
    if (rureraform_element_properties_active == null)
        return false;
    rureraform_element_properties_data_changed = true;
    rureraform_properties_visible_conditions(rureraform_element_properties_active);
    return false;
}
function rureraform_properties_visible_conditions(_object) {
    var type = jQuery(_object).attr("data-type");
    var input;
    if (typeof type == undefined || type == "")
        return false;
    var visible, value = "";
    for (var key in rureraform_meta[type]) {
        if (rureraform_meta[type].hasOwnProperty(key)) {
            if (rureraform_meta[type][key].hasOwnProperty('visible')) {
                visible = false;
                for (var condition_key in rureraform_meta[type][key]['visible']) {
                    if (rureraform_meta[type][key]['visible'].hasOwnProperty(condition_key)) {
                        input = jQuery("[name='rureraform-" + condition_key + "']");
                        if (input.length > 1) {
                            jQuery(input).each(function () {
                                if (jQuery(this).is(":checked")) {
                                    value = jQuery(this).val();
                                    return false;
                                }
                            });
                        } else if (jQuery(input).is(":checked"))
                            value = "on";
                        else
                            value = jQuery(input).val();
                        if (Array.isArray(rureraform_meta[type][key]['visible'][condition_key])) {
                            if (jQuery.inArray(value, rureraform_meta[type][key]['visible'][condition_key]) != -1)
                                visible = true;
                        } else if (value == rureraform_meta[type][key]['visible'][condition_key])
                            visible = true;
                    }
                }
                if (visible)
                    jQuery(".rureraform-properties-item[data-id='" + key + "']").fadeIn(300);
                else
                    jQuery(".rureraform-properties-item[data-id='" + key + "']").fadeOut(300);
            }
        }
    }
}
function rureraform_properties_mask_preset_changed(_object) {
    var preset = jQuery(_object).val();
    var mask_object = jQuery(_object).closest(".rureraform-properties-content").find("input");
    if (preset == "custom") {
        jQuery(mask_object).removeAttr("readonly");
        jQuery(mask_object).focus();
    } else {
        jQuery(mask_object).val(preset);
        jQuery(mask_object).attr("readonly", "readonly");
    }
    return false;
}
function rureraform_properties_options_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-options-item").fadeOut(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_options_copy(_object) {
    var option = jQuery(_object).closest(".rureraform-properties-options-item").clone();
    jQuery(option).removeClass("rureraform-properties-options-item-default");
    jQuery(_object).closest(".rureraform-properties-options-item").after(option);
    jQuery(option).find(".rureraform-image-url span").on("click", function (e) {
        e.preventDefault();
        var input = jQuery(this).parent().children("input");
        var media_frame = wp.media({
            title: 'Select Image',
            library: {
                type: 'image'
            },
            multiple: false
        });
        media_frame.on("select", function () {
            var attachment = media_frame.state().get("selection").first();
            jQuery(input).val(attachment.attributes.url);
        });
        media_frame.open();
    });

    rureraform_element_properties_data_changed = true;
    return false;
}
function rureraform_properties_options_default(_object) {
    var multi = jQuery(_object).closest(".rureraform-properties-options-container").attr("data-multi");
    var option = jQuery(_object).closest(".rureraform-properties-options-item");
    if (jQuery(option).hasClass("rureraform-properties-options-item-default")) {
        jQuery(option).removeClass("rureraform-properties-options-item-default");
    } else {
        if (multi != "on")
            jQuery(_object).closest(".rureraform-properties-options-container").find(".rureraform-properties-options-item").removeClass("rureraform-properties-options-item-default");
        jQuery(option).addClass("rureraform-properties-options-item-default");
    }
    rureraform_element_properties_data_changed = true;
    return false;
}
function rureraform_properties_options_new(_object) {
    var option;
    if (_object != null) {
        option = jQuery(_object).closest(".rureraform-properties-options-item").clone();
        jQuery(option).removeClass("rureraform-properties-options-item-default");
        jQuery(option).find("input").val("");
        jQuery(_object).closest(".rureraform-properties-options-item").after(option);
    } else {
        //option = jQuery(".rureraform-properties-options-container .rureraform-properties-options-item").first().clone();
        //jQuery(option).removeClass("rureraform-properties-options-item-default");
        //jQuery(option).find("input").val("");
        option = rureraform_properties_options_item_get("", "", false);
        jQuery(".rureraform-properties-options-container").append(option);
    }
    jQuery(option).find(".rureraform-image-url span").on("click", function (e) {
        e.preventDefault();
        var input = jQuery(this).parent().children("input");
        var media_frame = wp.media({
            title: 'Select Image',
            library: {
                type: 'image'
            },
            multiple: false
        });
        media_frame.on("select", function () {
            var attachment = media_frame.state().get("selection").first();
            jQuery(input).val(attachment.attributes.url);
        });
        media_frame.open();
    });
    rureraform_element_properties_data_changed = true;
    return false;
}
function rureraform_properties_options_item_get(_label, _value, _selected) {
    var html, selected = "";
    if (_selected)
        selected = " rureraform-properties-options-item-default";
    html = "<div class='rureraform-properties-options-item" + selected + "'><div class='rureraform-properties-options-table'><div><input class='rureraform-properties-options-label' type='text' value='" + rureraform_escape_html(_label) + "' placeholder='Label'></div><div><input class='rureraform-properties-options-value' type='text' value='" + rureraform_escape_html(_value) + "' placeholder='Value'></div><div><span onclick='return rureraform_properties_options_default(this);' title='Set the option as a default value'><i class='fas fa-check'></i></span><span onclick='return rureraform_properties_options_new(this);' title='Add the option after this one'><i class='fas fa-plus'></i></span><span onclick='return rureraform_properties_options_copy(this);' title='Duplicate the option'><i class='far fa-copy'></i></span><span onclick='return rureraform_properties_options_delete(this);' title='Delete the option'><i class='fas fa-trash-alt'></i></span><span title='Move the option'><i class='fas fa-arrows-alt rureraform-properties-options-item-handler'></i></span></div></div></div>";
    return html;
}
function rureraform_properties_imageselect_mode_set(_object) {
    var value = jQuery(_object).val();
    var options = jQuery(_object).closest(".rureraform-properties-item").parent().find(".rureraform-properties-options-container");
    if (value == 'radio') {
        jQuery(options).attr("data-multi", "off");
        var first_selected = jQuery(options).find(".rureraform-properties-options-item-default").first();
        jQuery(options).find(".rureraform-properties-options-item").removeClass("rureraform-properties-options-item-default");
        if (first_selected.length > 0)
            jQuery(first_selected).addClass("rureraform-properties-options-item-default");
    } else {
        jQuery(options).attr("data-multi", "on");
    }
}

function rureraform_properties_css_add(_type, _values) {
    var extra_class = "", html = "", tools = "";
    if (rureraform_meta[_type].hasOwnProperty("css")) {
        if (_values == null) {
            extra_class = " rureraform-properties-sub-item-new";
            rureraform_element_properties_data_changed = true;
        } else
            extra_class = " rureraform-properties-sub-item-exist";
        html += "<div class='rureraform-properties-sub-item" + extra_class + "'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_css_delete(this);'><i class='fas fa-trash-alt'></i></span><span onclick='return rureraform_properties_css_details_toggle(this);'><i class='fas fa-cog'></i></span></div><label></label></div><div class='rureraform-properties-sub-item-body'><div class='rureraform-properties-item'><div class='rureraform-properties-label'><label>Selector</label></div><div class='rureraform-properties-content'><select onchange='return rureraform_properties_css_selector_change(this);'><option value=''>Please select</option>";
        for (var key in rureraform_meta[_type]["css"]["selectors"]) {
            if (rureraform_meta[_type]["css"]["selectors"].hasOwnProperty(key)) {
                html += "<option value='" + key + "'>" + rureraform_meta[_type]["css"]["selectors"][key]['label'] + "</option>"
            }
        }
        tools = "<div class='rureraform-properties-css-toolbar'><span onclick='return rureraform_properties_css_style_add(this);' data-css='background-color: ;' title='Background color'><i class='material-icons'>format_color_fill</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='background: url() top left no-repeat;' title='Background'><i class='material-icons'>wallpaper</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='border-color: ;' title='Border color'><i class='material-icons'>border_color</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='color: ;' title='Text color'><i class='material-icons'>format_color_text</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='padding: ;' title='Padding'><i class='fas fa-external-link-alt'></i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='margin: ;' title='Margin'><i class='fas fa-external-link-alt'></i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='border-radius: ;' title='Border radius'><i class='material-icons'>crop_free</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='font-size: ;' title='Font size'><i class='material-icons'>format_size</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='line-height: ;' title='Line height'><i class='material-icons'>format_line_spacing</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='font-weight: bold;' title='Bold'><i class='material-icons'>format_bold</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='text-decoration: underline;' title='Underline'><i class='material-icons'>format_underlined</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='text-transform: uppercase;' title='Uppercase'><i class='material-icons'>title</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='text-align: left;' title='Text align left'><i class='material-icons'>format_align_left</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='text-align: center;' title='Text align center'><i class='material-icons'>format_align_center</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='text-align: right;' title='Text align right'><i class='material-icons'>format_align_right</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='width: ;' title='Width'><i class='material-icons'>keyboard_tab</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='height: ;' title='Height'><i class='material-icons'>vertical_align_top</i></span><span onclick='return rureraform_properties_css_style_add(this);' data-css='display: none;' title='Hide'><i class='material-icons'>visibility_off</i></span></div>";
        html += "</select></div></div><div class='rureraform-properties-item'><div class='rureraform-properties-label'><label>CSS</label></div><div class='rureraform-properties-content'><textarea></textarea>" + tools + "</div></div></div></div>";
        if (_values == null)
            jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item-body").slideUp(300);
        jQuery(".rureraform-properties-content-css").append(html);
        if (_values != null) {
            jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item:last").find(".rureraform-properties-sub-item-body select").val(_values["selector"]);
            if (_values["selector"] == "")
                jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item:last").find(".rureraform-properties-sub-item-header label").html("");
            else
                jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item:last").find(".rureraform-properties-sub-item-header label").html(jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item:last").find(".rureraform-properties-sub-item-body select option:selected").text());
            jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item:last").find(".rureraform-properties-sub-item-body textarea").val(_values["css"]);
        }
        jQuery(".rureraform-properties-sub-item-new").slideDown(300);
        jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    }
    return false;
}
function rureraform_properties_css_style_add(_object) {
    var value = jQuery(_object).closest(".rureraform-properties-content").find("textarea").val();
    if (value != "")
        value += "\r\n";
    value += jQuery(_object).attr("data-css");
    jQuery(_object).closest(".rureraform-properties-content").find("textarea").val(value);
    return false;
}
function rureraform_properties_css_selector_change(_object) {
    if (jQuery(_object).val() == "")
        jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-header label").html("");
    else
        jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-header label").html(jQuery(_object).find("option:selected").text());
    return false;
}
function rureraform_properties_css_details_toggle(_object) {
    jQuery(_object).closest(".rureraform-properties-sub-item").addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-css .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(_object).closest(".rureraform-properties-sub-item").removeClass("rureraform-freeze");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-body").slideToggle(300);
    return false;
}
function rureraform_properties_css_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_validators_add(_field_id, _type, _validator, _values) {
    var extra_class = "", html = "", tooltip_html, selected, options, property_value;
    var seq = 0, last;
    last = jQuery(".rureraform-properties-content-validators .rureraform-properties-sub-item").last();
    if (jQuery(last).length)
        seq = parseInt(jQuery(last).attr("data-seq"), 10) + 1;
    if (rureraform_meta[_type].hasOwnProperty("validators") && rureraform_validators.hasOwnProperty(_validator)) {
        if (_values == null) {
            extra_class = " rureraform-properties-sub-item-new";
            rureraform_element_properties_data_changed = true;
        } else
            extra_class = " rureraform-properties-sub-item-exist";
        html += "<div class='rureraform-properties-sub-item" + extra_class + "' data-type='" + _validator + "' data-seq='" + seq + "'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_validators_delete(this);'><i class='fas fa-trash-alt'></i></span><span onclick='return rureraform_properties_validators_details_toggle(this);'><i class='fas fa-cog'></i></span></div><label>" + rureraform_validators[_validator]["label"] + "</label></div><div class='rureraform-properties-sub-item-body'>";
        for (var key in rureraform_validators[_validator]["properties"]) {
            if (rureraform_validators[_validator]["properties"].hasOwnProperty(key)) {
                tooltip_html = "";
                if (rureraform_validators[_validator]["properties"][key].hasOwnProperty('tooltip')) {
                    tooltip_html = "<i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_validators[_validator]["properties"][key]['tooltip'] + "</div>";
                }
                property_value = "";
                if (_values != null && _values.hasOwnProperty("properties") && _values["properties"].hasOwnProperty(key))
                    property_value = _values["properties"][key];
                switch (rureraform_validators[_validator]["properties"][key]['type']) {
                    case 'error':
                        html += "<hr /><div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label class='rureraform-red'>" + rureraform_validators[_validator]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input type='text' name='rureraform-validators-" + key + "' id='rureraform-validators-" + seq + "-" + key + "' value='" + rureraform_escape_html(property_value) + "' placeholder='" + rureraform_escape_html(rureraform_validators[_validator]["properties"][key]['value']) + "' /><em>Default message: " + rureraform_escape_html(rureraform_validators[_validator]["properties"][key]['value']) + "</em></div></div>";
                        break;

                    case 'text':
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_validators[_validator]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input type='text' name='rureraform-validators-" + key + "' id='rureraform-validators-" + seq + "-" + key + "' value='" + rureraform_escape_html(property_value) + "' placeholder='" + rureraform_escape_html(property_value) + "' /></div></div>";
                        break;

                    case 'field':
                        options = "<option value=''>---</option>";
                        for (var i = 0; i < rureraform_form_elements.length; i++) {
                            if (rureraform_form_elements[i] == null)
                                continue;
                            if (rureraform_form_elements[i]["id"] == _field_id)
                                continue;
                            if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[i]['type']) && rureraform_toolbar_tools[rureraform_form_elements[i]['type']]['type'] == 'input') {
                                options += "<option value='" + rureraform_form_elements[i]['id'] + "'" + (rureraform_form_elements[i]['id'] == property_value ? " selected='selected'" : "") + ">" + rureraform_form_elements[i]['id'] + " | " + rureraform_escape_html(rureraform_form_elements[i]['name']) + "</option>";
                            }
                        }
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_validators[_validator]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><select name='rureraform-validators-" + key + "' id='rureraform-validators-" + seq + "-" + key + "'>" + options + "</select></div></div>";
                        break;

                    case 'textarea':
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_validators[_validator]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><textarea name='rureraform-validators-" + key + "' id='rureraform-validators-" + seq + "-" + key + "'>" + rureraform_escape_html(property_value) + "</textarea></div></div>";
                        break;

                    case 'integer':
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_validators[_validator]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-number'><input type='text' name='rureraform-validators-" + key + "' id='rureraform-validators-" + seq + "-" + key + "' value='" + rureraform_escape_html(property_value) + "' placeholder='' /></div></div></div>";
                        break;

                    case 'checkbox':
                        selected = "";
                        if (property_value == "on")
                            selected = " checked='checked'";
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_validators[_validator]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' name='rureraform-validators-" + key + "' id='rureraform-validators-" + seq + "-" + key + "'" + selected + "' /><label for='rureraform-validators-" + seq + "-" + key + "'></label></div></div>";
                        break;

                    default:
                        break;
                }
            }
        }
        html += "</div></div>";
        if (_values == null)
            jQuery(".rureraform-properties-content-validators .rureraform-properties-sub-item-body").slideUp(300);
        jQuery(".rureraform-properties-content-validators").append(html);
        jQuery(".rureraform-properties-sub-item-new .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
            contentAsHTML: true,
            maxWidth: 360,
            theme: "tooltipster-dark",
            side: "bottom",
            content: "Default",
            functionFormat: function (instance, helper, content) {
                return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
            }
        });
        jQuery(".rureraform-properties-sub-item-new").slideDown(300);
        jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    }
    return false;
}
function rureraform_properties_validators_details_toggle(_object) {
    jQuery(_object).closest(".rureraform-properties-sub-item").addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-validators .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(_object).closest(".rureraform-properties-sub-item").removeClass("rureraform-freeze");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-body").slideToggle(300);
    return false;
}
function rureraform_properties_validators_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}

function rureraform_properties_integrations_name_changed(_object) {
    var label = jQuery(_object).val().substring(0, 52) + (jQuery(_object).val().length > 52 ? "..." : "");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-header>label").text(label);
    return false;
}
function rureraform_properties_integrations_logic_enable_changed(_object) {
    var parent = jQuery(_object).closest(".rureraform-properties-sub-item");
    if (jQuery(_object).is(":checked"))
        jQuery(parent).find(".rureraform-properties-item[data-id='logic']").fadeIn(300);
    else
        jQuery(parent).find(".rureraform-properties-item[data-id='logic']").fadeOut(300);
    return false;
}
function rureraform_integrations_ajax_options_selected(_object) {
    var item_id = jQuery(_object).attr("data-id");
    var item_title = jQuery(_object).attr("data-title");
    jQuery(_object).closest(".rureraform-integrations-ajax-options").find("input[type='text']").val(item_title);
    jQuery(_object).closest(".rureraform-integrations-ajax-options").find("input[type='hidden']").val(item_id);
    return false;
}
function rureraform_integrations_custom_add(_object) {
    var template = jQuery(_object).closest("table").find(".rureraform-integrations-custom-template");
    if (jQuery(template).length > 0) {
        jQuery(template).before("<tr>" + jQuery(template).html() + "</tr>");
    }
}
function rureraform_integrations_ajax_options_focus(_object) {
    var item = jQuery(_object).closest(".rureraform-properties-sub-item");
    var provider = jQuery(item).find("input[name='rureraform-integrations-provider']").val();
    var field = jQuery(_object).attr("name");
    var deps = {};
    if (jQuery(_object).attr("data-deps")) {
        var deps_array = jQuery(_object).attr("data-deps").split(",");
        for (var i = 0; i < deps_array.length; i++) {
            if (jQuery(item).find("input[name='" + deps_array[i] + "']").is(":checked"))
                deps[deps_array[i]] = 'on';
            else
                deps[deps_array[i]] = jQuery(item).find("input[name='" + deps_array[i] + "'], select[name='" + deps_array[i] + "']").val();
        }
    }
    var post_data = {
        action: "rureraform-" + provider + "-" + field,
        deps: rureraform_encode64(JSON.stringify(deps))
    };
    if (jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list").length == 0) {
        jQuery(_object).parent().append("<div class='rureraform-integrations-ajax-options-list'><div class='rureraform-integrations-ajax-options-list-data'></div><i class='fas fa-spin fa-spinner'></i></div>");
    }
    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list i").show();
    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").hide();
    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list").fadeIn(300);
    var default_error = jQuery(_object).attr("data-default-error");
    if (typeof default_error === typeof undefined || default_error === false)
        default_error = 'Unexpected server response.';

    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            var data;
            try {
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    var items_html = "";
                    for (var key in data.items) {
                        if (data.items.hasOwnProperty(key)) {
                            var title = rureraform_escape_html(key) + (data.items[key] == "" ? "" : " | " + rureraform_escape_html(data.items[key]));
                            items_html += "<a href='#' data-id='" + rureraform_escape_html(key) + "' data-title='" + title + "' onclick='return rureraform_integrations_ajax_options_selected(this);'>" + title + "</a>";
                        }
                    }
                    if (Object.keys(data.items).length > 4)
                        jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list").addClass("rureraform-vertical-scroll");
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").html(items_html);
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list i").hide();
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").show();
                } else if (data.status == "ERROR") {
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").html('<div class="rureraform-integrations-ajax-options-list-data-error">' + data.message + '</div>');
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list i").hide();
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").show();
                } else {
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").html("<div class='rureraform-integrations-ajax-options-list-data-error'>" + default_error + "</div>");
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list i").hide();
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").show();
                }
            } catch (error) {
                jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").html("<div class='rureraform-integrations-ajax-options-list-data-error'>" + default_error + "</div>");
                jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list i").hide();
                jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").show();
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").html("<div class='rureraform-integrations-ajax-options-list-data-error'>" + default_error + "</div>");
            jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list i").hide();
            jQuery(_object).parent().find(".rureraform-integrations-ajax-options-list-data").show();
        }
    });
}
function rureraform_integrations_ajax_multiselect_scroll(_object) {
    if (jQuery(_object).attr("data-next-offset") == "-1")
        return;
    var content_height = jQuery(_object).prop('scrollHeight');
    var position = jQuery(_object).scrollTop();
    var height = jQuery(_object).height();
    if (content_height - height - position < 20) {
        if (rureraform_sending)
            return false;
        rureraform_sending = true;
        var item = jQuery(_object).closest(".rureraform-properties-sub-item");
        var provider = jQuery(item).find("input[name='rureraform-integrations-provider']").val();
        var sub_action = jQuery(_object).attr("data-action");
        var deps = {"offset": parseInt(jQuery(_object).attr("data-next-offset"), 10)};
        if (jQuery(_object).attr("data-deps")) {
            var deps_array = jQuery(_object).attr("data-deps").split(",");
            for (var i = 0; i < deps_array.length; i++) {
                deps[deps_array[i]] = jQuery(item).find("input[name='" + deps_array[i] + "'], select[name='" + deps_array[i] + "']").val();
            }
        }
        var post_data = {
            "action": "rureraform-" + provider + "-" + sub_action,
            "deps": rureraform_encode64(JSON.stringify(deps))
        };
        jQuery(_object).find(".rureraform-integrations-ajax-multiselect-loading").slideDown(300);
        jQuery.ajax({
            type: "POST",
            url: rureraform_ajax_handler,
            data: post_data,
            success: function (return_data) {
                jQuery(_object).find(".rureraform-integrations-ajax-multiselect-loading").slideUp(300)
                var data;
                try {
                    if (typeof return_data == "object")
                        data = return_data;
                    else
                        data = jQuery.parseJSON(return_data);
                    if (data.status == "OK") {
                        jQuery(_object).find(".rureraform-integrations-ajax-multiselect-loading").before(data.html);
                        jQuery(_object).attr("data-next-offset", data.offset);
                    } else if (data.status == "ERROR") {
                        jQuery(_object).attr("data-next-offset", "-1");
                        rureraform_global_message_show("danger", data.message);
                    } else {
                        jQuery(_object).attr("data-next-offset", "-1");
                        rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                    }
                } catch (error) {
                    jQuery(_object).attr("data-next-offset", "-1");
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
                rureraform_sending = false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                jQuery(_object).find(".rureraform-integrations-ajax-multiselect-loading").slideUp(300)
                jQuery(_object).attr("data-next-offset", "-1");
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                rureraform_sending = false;
            }
        });
    }
}

function rureraform_integrations_ajax_inline_html(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var item = jQuery(_object).closest(".rureraform-properties-sub-item");
    var provider = jQuery(item).find("input[name='rureraform-integrations-provider']").val();
    var inline_action = jQuery(_object).attr("data-inline");
    var deps = {};

    if (jQuery(_object).attr("data-deps")) {
        var deps_array = jQuery(_object).attr("data-deps").split(",");
        for (var i = 0; i < deps_array.length; i++) {
            if (jQuery(item).find("input[name='" + deps_array[i] + "']").is(":checked"))
                deps[deps_array[i]] = 'on';
            else
                deps[deps_array[i]] = jQuery(item).find("input[name='" + deps_array[i] + "'], select[name='" + deps_array[i] + "']").val();
        }
    }

    var post_data = {
        action: "rureraform-" + provider + "-" + inline_action,
        deps: rureraform_encode64(JSON.stringify(deps))
    };
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    jQuery(_object).addClass("rureraform-button-disabled");
    jQuery(_object).parent().find(".rureraform-integrations-ajax-inline").slideUp(300);

    var default_error = jQuery(_object).attr("data-default-error");
    if (typeof default_error === typeof undefined || default_error === false)
        default_error = rureraform_esc_html__("Something went wrong. We got unexpected server response.");

    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            jQuery(_object).find("i").attr("class", "fas fa-download");
            jQuery(_object).removeClass("rureraform-button-disabled");
            var data;
            try {
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-inline").html(data.html);
                    jQuery(_object).parent().find(".rureraform-integrations-ajax-inline").slideDown(300);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", default_error);
                }
            } catch (error) {
                rureraform_global_message_show("danger", default_error);
            }
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "fas fa-download");
            jQuery(_object).removeClass("rureraform-button-disabled");
            rureraform_global_message_show("danger", default_error);
            rureraform_sending = false;
        }
    });
}
/*function rureraform_integrations_field_add(_object) {
 var template_class = jQuery(_object).attr("data-template");
 var template_object = jQuery(_object).parent().find("."+template_class);
 if (template_object.length > 0) {
 jQuery(template_object).before("<tr>"+jQuery(template_object).html()+"</tr>");
 }
 return false;
 }
 function rureraform_integrations_field_remove(_object) {
 var row = jQuery(_object).closest("tr");
 jQuery(row).fadeOut(300, function() {
 jQuery(row).remove();
 });
 return false;
 }*/
function rureraform_properties_integrations_details_toggle(_object) {
    if (typeof _object == "undefined")
        return;
    var item = jQuery(_object).closest(".rureraform-properties-sub-item");
    jQuery(item).addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-integrations .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(item).removeClass("rureraform-freeze");
    jQuery(item).find(".rureraform-properties-sub-item-body").slideToggle(300);
    if (jQuery(item).attr("data-loaded") != "on") {
        var provider = jQuery(item).find("input[name='rureraform-integrations-provider']").val();
        if (rureraform_sending)
            return false;
        rureraform_sending = true;
        var post_data = {
            action: "rureraform-" + provider + "-settings-html"
        };
        var idx = jQuery(item).find("input[name='rureraform-integrations-idx']").val();
        if (idx >= 0 && idx <= rureraform_form_options["integrations"].length) {
            post_data["data"] = rureraform_encode64(JSON.stringify(rureraform_form_options["integrations"][idx]["data"]));
        }
        jQuery.ajax({
            type: "POST",
            url: rureraform_ajax_handler,
            data: post_data,
            success: function (return_data) {
                var data;
                try {
                    if (typeof return_data == 'object')
                        data = return_data;
                    else
                        data = jQuery.parseJSON(return_data);
                    if (data.status == "OK") {
                        jQuery(item).attr("data-loaded", "on");
                        jQuery(item).find(".rureraform-integrations-content").html(data.html);
                        jQuery(item).find(".rureraform-integrations-content .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
                            contentAsHTML: true,
                            maxWidth: 360,
                            theme: "tooltipster-dark",
                            side: "bottom",
                            content: "Default",
                            functionFormat: function (instance, helper, content) {
                                return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
                            }
                        });
                        jQuery(item).find(".rureraform-integrations-ajax-options input[type='text']").on("focus", function () {
                            rureraform_integrations_ajax_options_focus(this);
                        });
                        jQuery(item).find(".rureraform-integrations-ajax-options input[type='text']").on("blur", function () {
                            jQuery(this).parent().find(".rureraform-integrations-ajax-options-list").fadeOut(300);
                        });
                        jQuery(item).find(".rureraform-properties-sub-item-body-loading").hide();
                        jQuery(item).find(".rureraform-properties-sub-item-body-content").slideDown(300);
                    } else if (data.status == "ERROR") {
                        jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                        rureraform_global_message_show("danger", data.message);
                    } else {
                        jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                        rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                    }
                } catch (error) {
                    jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
                rureraform_sending = false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                rureraform_sending = false;
            }
        });
    }
    return false;
}
function rureraform_properties_integrations_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_integrations_add(_values, _idx, _provider) {
    var extra_class = "", html = "", temp = "", property_value, enabled, logic_enable, logic_enable_id, provider = "", label = "";

    if (typeof _provider != "undefined") {
        provider = _provider;
        label = (rureraform_integration_providers.hasOwnProperty(provider) ? rureraform_integration_providers[provider] : 'Integration');
    } else if (typeof _values == "object") {
        provider = _values["provider"];
        label = _values["name"];
    }

    if (_values == null) {
        extra_class = " rureraform-properties-sub-item-new";
        rureraform_element_properties_data_changed = true;
    } else
        extra_class = " rureraform-properties-sub-item-exist";
    html += "<div class='rureraform-properties-sub-item" + extra_class + "' data-loaded='off'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_integrations_delete(this);'><i class='fas fa-trash-alt'></i></span><span onclick='return rureraform_properties_integrations_details_toggle(this);'><i class='fas fa-cog'></i></span></div><label></label></div><div class='rureraform-properties-sub-item-body' style='display: none;'><div class='rureraform-properties-sub-item-body-content' style='display: none;'>";

    html += "<div class='rureraform-properties-item' data-id='name'><div class='rureraform-properties-label'><label>" + rureraform_integrations['name']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_integrations['name']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input type='text' name='rureraform-integrations-name' value='" + rureraform_escape_html(label) + "' oninput='return rureraform_properties_integrations_name_changed(this);' /></div></div>";

    if (_values != null && _values.hasOwnProperty('enabled'))
        enabled = _values['enabled'];
    else
        enabled = rureraform_integrations['enabled']['value'];
    var enabled_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='enabled'><div class='rureraform-properties-label'><label>" + rureraform_integrations['enabled']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_integrations['enabled']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' id='rureraform-integrations-enabled-" + enabled_id + "' name='rureraform-integrations-enabled'" + (enabled == "on" ? ' checked="checked"' : '') + "' /><label for='rureraform-integrations-enabled-" + enabled_id + "'></label></div></div>";

    if (_values != null && _values.hasOwnProperty('action'))
        property_value = _values['action'];
    else
        property_value = rureraform_integrations['action']['value'];
    var options = "";
    for (var option_key in rureraform_integrations['action']['options']) {
        if (rureraform_integrations['action']['options'].hasOwnProperty(option_key)) {
            options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_integrations['action']['options'][option_key]) + "</option>";
        }
    }
    html += "<div class='rureraform-properties-item' data-id='action'><div class='rureraform-properties-label'><label>" + rureraform_integrations['action']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_integrations['action']['tooltip'] + "</div></div><div class='rureraform-properties-content'><select name='rureraform-integrations-action'>" + options + "</select></div></div>";

    html += "<input type='hidden' name='rureraform-integrations-idx' value='" + _idx + "' /><input type='hidden' name='rureraform-integrations-provider' value='" + rureraform_escape_html(provider) + "' /><div class='rureraform-integrations-content'></div>";

    if (_values != null && _values.hasOwnProperty('logic-enable'))
        logic_enable = _values['logic-enable'];
    else
        logic_enable = rureraform_integrations['logic-enable']['value'];
    logic_enable_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='logic-enable'><div class='rureraform-properties-label'><label>" + rureraform_integrations['logic-enable']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_integrations['logic-enable']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' id='rureraform-integrations-logic-enable-" + logic_enable_id + "' name='rureraform-integrations-logic-enable'" + (logic_enable == "on" ? ' checked="checked"' : '') + " onchange='return rureraform_properties_integrations_logic_enable_changed(this);' /><label for='rureraform-integrations-logic-enable-" + logic_enable_id + "'></label></div></div>";

    if (_values != null && _values.hasOwnProperty('logic'))
        property_value = _values['logic'];
    else
        property_value = rureraform_integrations['logic']['value'];
    var input_ids = new Array();
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[i]['type']) && rureraform_toolbar_tools[rureraform_form_elements[i]['type']]['type'] == 'input') {
            input_ids.push(rureraform_form_elements[i]["id"]);
        }
    }
    if (input_ids.length > 0) {
        temp = "<div class='rureraform-properties-group rureraform-properties-logic-header'>";
        options = "";
        for (var option_key in rureraform_integrations['logic']['actions']) {
            if (rureraform_integrations['logic']['actions'].hasOwnProperty(option_key)) {
                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value["action"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_integrations['logic']['actions'][option_key]) + "</option>";
            }
        }
        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-integrations-logic-action' id='rureraform-logic-action'>" + options + "</select></div>";
        options = "";
        for (var option_key in rureraform_integrations['logic']['operators']) {
            if (rureraform_integrations['logic']['operators'].hasOwnProperty(option_key)) {
                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value["operator"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_integrations['logic']['operators'][option_key]) + "</option>";
            }
        }
        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-integrations-logic-operator' id='rureraform-logic-operator'>" + options + "</select></div>";
        temp += "</div>";
        options = "";
        for (var j = 0; j < property_value["rules"].length; j++) {
            if (input_ids.indexOf(parseInt(property_value["rules"][j]["field"], 10)) != -1) {
                options += rureraform_properties_logic_rule_get(null, property_value["rules"][j]["field"], property_value["rules"][j]["rule"], property_value["rules"][j]["token"]);
            }
        }
        temp += "<div class='rureraform-properties-logic-rules'>" + options + "</div><div class='rureraform-properties-logic-buttons'><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_logic_rule_new(this, null);'><i class='fas fa-plus'></i><label>Add rule</label></a></div>";
    } else {
        temp = "<div class='rureraform-properties-inline-error'>There are no elements available to use for logic rules.</div>";
    }
    html += "<div class='rureraform-properties-item' data-id='logic'" + (logic_enable == "on" ? "" : " style='display:none;'") + "><div class='rureraform-properties-label'><label>" + rureraform_integrations['logic']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_integrations['logic']['tooltip'] + "</div></div><div class='rureraform-properties-content'>" + temp + "</div></div>";
    html += "</div><div class='rureraform-properties-sub-item-body-loading'><i class='fas fa-spin fa-spinner'></i></div></div></div>";

    if (_values == null)
        jQuery(".rureraform-properties-content-integrations .rureraform-properties-sub-item-body").slideUp(300);
    jQuery(".rureraform-properties-content-integrations").append(html);
    jQuery(".rureraform-properties-sub-item-new .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
        contentAsHTML: true,
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom",
        content: "Default",
        functionFormat: function (instance, helper, content) {
            return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
        }
    });
    rureraform_properties_integrations_name_changed(jQuery(".rureraform-properties-content-integrations .rureraform-properties-sub-item").last().find("[name='rureraform-integrations-name']"));
    if (jQuery(".rureraform-properties-sub-item-new").length > 0)
        rureraform_properties_integrations_details_toggle(jQuery(".rureraform-properties-sub-item-new").find(".rureraform-properties-sub-item-header-tools"));
    jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    return false;
}
function rureraform_integrations_zapier_connect(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var item = jQuery(_object).closest(".rureraform-properties-sub-item");
    var content = jQuery(item).find(".rureraform-integrations-custom");
    var deps = {};

    var fields = new Array();

    var name;
    var names = jQuery(content).find("input.rureraform-integrations-custom-name");
    for (var j = 0; j < names.length; j++) {
        name = jQuery(names[j]).val();
        if (name.length > 0) {
            fields.push(name);
        }
    }
    var post_data = {
        "action": "rureraform-zapier-connect",
        "webhook-url": rureraform_encode64(jQuery(item).find("[name='webhook-url']").val()),
        "fields": rureraform_encode64(JSON.stringify(fields))
    };
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    jQuery(_object).addClass("rureraform-button-disabled");
    jQuery(_object).parent().find(".rureraform-integrations-ajax-inline").slideUp(300);

    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            jQuery(_object).find("i").attr("class", "fas fa-download");
            jQuery(_object).removeClass("rureraform-button-disabled");
            var data;
            try {
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "fas fa-download");
            jQuery(_object).removeClass("rureraform-button-disabled");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });

}
function rureraform_properties_integrations_constantcontact_apikey_changed(_object) {
    jQuery(_object).closest(".rureraform-properties-sub-item").find("input[name=token]").val("");
    var token_link = jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-constantcontact-token-link");
    jQuery(token_link).attr("href", jQuery(token_link).attr("data-href").replace("{api-key}", jQuery(_object).closest(".rureraform-properties-item").find("input").val()));
}

function rureraform_properties_payment_gateways_details_toggle(_object) {
    if (typeof _object == "undefined")
        return;
    var item = jQuery(_object).closest(".rureraform-properties-sub-item");
    jQuery(item).addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-payment-gateways .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(item).removeClass("rureraform-freeze");
    jQuery(item).find(".rureraform-properties-sub-item-body").slideToggle(300);
    if (jQuery(item).attr("data-loaded") != "on") {
        var provider = jQuery(item).find("input[name='rureraform-payment-gateways-provider']").val();
        if (rureraform_sending)
            return false;
        rureraform_sending = true;
        var post_data = {
            action: "rureraform-" + provider + "-settings-html"
        };
        var idx = jQuery(item).find("input[name='rureraform-payment-gateways-idx']").val();
        if (idx >= 0 && idx <= rureraform_form_options["payment-gateways"].length) {
            post_data["data"] = rureraform_encode64(JSON.stringify(rureraform_form_options["payment-gateways"][idx]["data"]));
        }
        jQuery.ajax({
            type: "POST",
            url: rureraform_ajax_handler,
            data: post_data,
            success: function (return_data) {
                var data;
                try {
                    if (typeof return_data == 'object')
                        data = return_data;
                    else
                        data = jQuery.parseJSON(return_data);
                    if (data.status == "OK") {
                        jQuery(item).attr("data-loaded", "on");
                        jQuery(item).find(".rureraform-payment-gateways-content").html(data.html);
                        jQuery(item).find(".rureraform-payment-gateways-content .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
                            contentAsHTML: true,
                            maxWidth: 360,
                            theme: "tooltipster-dark",
                            side: "bottom",
                            content: "Default",
                            functionFormat: function (instance, helper, content) {
                                return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
                            }
                        });
                        jQuery(item).find(".rureraform-properties-sub-item-body-loading").hide();
                        jQuery(item).find(".rureraform-properties-sub-item-body-content").slideDown(300);
                    } else if (data.status == "ERROR") {
                        jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                        rureraform_global_message_show("danger", data.message);
                    } else {
                        jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                        rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                    }
                } catch (error) {
                    jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
                rureraform_sending = false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                jQuery(item).find(".rureraform-properties-sub-item-body").slideUp(300);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                rureraform_sending = false;
            }
        });
    }
    return false;
}
function rureraform_properties_payment_gateways_name_changed(_object) {
    var label = jQuery(_object).val().substring(0, 52) + (jQuery(_object).val().length > 52 ? "..." : "");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-header>label").text(label);
    rureraform_properties_payment_gateways_select_update();
    return false;
}
function rureraform_properties_payment_gateways_select_update() {
    var payment_gateways = new Array();
    jQuery(".rureraform-properties-content-payment-gateways .rureraform-properties-sub-item").each(function () {
        payment_gateways.push({"id": jQuery(this).find("[name='rureraform-payment-gateways-id']").val(), "name": jQuery(this).find("[name='rureraform-payment-gateways-name']").val()});
    });
    jQuery(".rureraform-payment-gateways-select").each(function () {
        var value = jQuery(this).val();
        var options = "<option value=''" + (value == "" ? " selected='selected'" : "") + ">Select payment gateway</option>";
        for (var i = 0; i < payment_gateways.length; i++) {
            options += "<option value='" + rureraform_escape_html(payment_gateways[i]['id']) + "'" + (value == payment_gateways[i]['id'] ? " selected='selected'" : "") + ">" + rureraform_escape_html(payment_gateways[i]['name']) + "</option>";
        }
        jQuery(this).html(options);
    });
}
function rureraform_properties_payment_gateways_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
                rureraform_properties_payment_gateways_select_update();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_payment_gateways_add(_values, _idx, _provider) {
    var extra_class = "", html = "", property_value, enabled, provider = "", label = "";

    if (typeof _provider != "undefined") {
        provider = _provider;
        label = (rureraform_payment_providers.hasOwnProperty(provider) ? rureraform_payment_providers[provider] : 'Payment Gateway');
    } else if (typeof _values == "object") {
        provider = _values["provider"];
        label = _values["name"];
    }

    var label_beauty = label.substring(0, 52) + (label.length > 52 ? "..." : "");

    if (_values == null) {
        extra_class = " rureraform-properties-sub-item-new";
        rureraform_element_properties_data_changed = true;
    } else
        extra_class = " rureraform-properties-sub-item-exist";
    html += "<div class='rureraform-properties-sub-item" + extra_class + "' data-loaded='off'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_payment_gateways_delete(this);'><i class='fas fa-trash-alt'></i></span><span onclick='return rureraform_properties_payment_gateways_details_toggle(this);'><i class='fas fa-cog'></i></span></div><label>" + rureraform_escape_html(label_beauty) + "</label></div><div class='rureraform-properties-sub-item-body' style='display: none;'><div class='rureraform-properties-sub-item-body-content' style='display: none;'>";

    html += "<div class='rureraform-properties-item' data-id='name'><div class='rureraform-properties-label'><label>" + rureraform_payment_gateway['name']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_payment_gateway['name']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input type='text' name='rureraform-payment-gateways-name' value='" + rureraform_escape_html(label) + "' oninput='return rureraform_properties_payment_gateways_name_changed(this);' /></div></div>";
    if (_values != null && _values.hasOwnProperty('id'))
        property_value = _values['id'];
    else {
        rureraform_form_last_id++;
        property_value = rureraform_form_last_id;
    }
    html += "<input type='hidden' name='rureraform-payment-gateways-id' value='" + property_value + "' /><input type='hidden' name='rureraform-payment-gateways-idx' value='" + _idx + "' /><input type='hidden' name='rureraform-payment-gateways-provider' value='" + rureraform_escape_html(provider) + "' /><div class='rureraform-payment-gateways-content'></div>";

    html += "</div><div class='rureraform-properties-sub-item-body-loading'><i class='fas fa-spin fa-spinner'></i></div></div></div>";

    if (_values == null)
        jQuery(".rureraform-properties-content-payment-gateways .rureraform-properties-sub-item-body").slideUp(300);
    jQuery(".rureraform-properties-content-payment-gateways").append(html);

    jQuery(".rureraform-properties-sub-item-new .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
        contentAsHTML: true,
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom",
        content: "Default",
        functionFormat: function (instance, helper, content) {
            return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
        }
    });
    if (_values == null)
        rureraform_properties_payment_gateways_select_update();

    if (jQuery(".rureraform-properties-sub-item-new").length > 0)
        rureraform_properties_payment_gateways_details_toggle(jQuery(".rureraform-properties-sub-item-new").find(".rureraform-properties-sub-item-header-tools"));
    jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    return false;
}

function rureraform_properties_notifications_name_changed(_object) {
    var label = jQuery(_object).val().substring(0, 52) + (jQuery(_object).val().length > 52 ? "..." : "");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-header>label").text(label);
    return false;
}
function rureraform_properties_notifications_logic_enable_changed(_object) {
    var parent = jQuery(_object).closest(".rureraform-properties-sub-item");
    if (jQuery(_object).is(":checked"))
        jQuery(parent).find(".rureraform-properties-item[data-id='logic']").fadeIn(300);
    else
        jQuery(parent).find(".rureraform-properties-item[data-id='logic']").fadeOut(300);
    return false;
}
function rureraform_properties_notifications_details_toggle(_object) {
    jQuery(_object).closest(".rureraform-properties-sub-item").addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-notifications .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(_object).closest(".rureraform-properties-sub-item").removeClass("rureraform-freeze");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-body").slideToggle(300);
    return false;
}
function rureraform_properties_notifications_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_notifications_add(_values) {
    var extra_class = "", html = "", temp = "", tooltip_html, selected, property_value, enabled, logic_enable, logic_enable_id;

    var input_ids = new Array();
    var file_ids = new Array();
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[i]['type']) && rureraform_toolbar_tools[rureraform_form_elements[i]['type']]['type'] == 'input') {
            input_ids.push(rureraform_form_elements[i]["id"]);
            if (rureraform_form_elements[i]['type'] == 'file') {
                file_ids.push(rureraform_form_elements[i]["id"]);
            }
        }
    }

    if (_values == null) {
        extra_class = " rureraform-properties-sub-item-new";
        rureraform_element_properties_data_changed = true;
    } else
        extra_class = " rureraform-properties-sub-item-exist";
    html += "<div class='rureraform-properties-sub-item" + extra_class + "'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_notifications_delete(this);'><i class='fas fa-trash-alt'></i></span><span onclick='return rureraform_properties_notifications_details_toggle(this);'><i class='fas fa-cog'></i></span></div><label></label></div><div class='rureraform-properties-sub-item-body'>";

    html += "<div class='rureraform-properties-item' data-id='name'><div class='rureraform-properties-label'><label>" + rureraform_notifications['name']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['name']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input type='text' name='rureraform-notifications-name' value='" + (_values != null && _values.hasOwnProperty('name') ? rureraform_escape_html(_values['name']) : rureraform_escape_html(rureraform_notifications['name']['value'])) + "' oninput='return rureraform_properties_notifications_name_changed(this);' /></div></div>";

    if (_values != null && _values.hasOwnProperty('enabled'))
        enabled = _values['enabled'];
    else
        enabled = rureraform_notifications['enabled']['value'];
    var enabled_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='enabled'><div class='rureraform-properties-label'><label>" + rureraform_notifications['enabled']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['enabled']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' id='rureraform-notifications-enabled-" + enabled_id + "' name='rureraform-notifications-enabled'" + (enabled == "on" ? ' checked="checked"' : '') + "' /><label for='rureraform-notifications-enabled-" + enabled_id + "'></label></div></div>";

    if (_values != null && _values.hasOwnProperty('action'))
        property_value = _values['action'];
    else
        property_value = rureraform_notifications['action']['value'];
    var options = "";
    for (var option_key in rureraform_notifications['action']['options']) {
        if (rureraform_notifications['action']['options'].hasOwnProperty(option_key)) {
            options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_notifications['action']['options'][option_key]) + "</option>";
        }
    }
    html += "<div class='rureraform-properties-item' data-id='action'><div class='rureraform-properties-label'><label>" + rureraform_notifications['action']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['action']['tooltip'] + "</div></div><div class='rureraform-properties-content'><select name='rureraform-notifications-action'>" + options + "</select></div></div>";

    html += "<div class='rureraform-properties-item' data-id='recipient-email'><div class='rureraform-properties-label'><label>" + rureraform_notifications['recipient-email']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['recipient-email']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-properties-group rureraform-input-shortcode-selector'><input type='text' name='rureraform-notifications-recipient-email' value='" + (_values != null && _values.hasOwnProperty('recipient-email') ? rureraform_escape_html(_values['recipient-email']) : rureraform_escape_html(rureraform_notifications['recipient-email']['value'])) + "' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div>";
    html += "<div class='rureraform-properties-item' data-id='subject'><div class='rureraform-properties-label'><label>" + rureraform_notifications['subject']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['subject']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-properties-group rureraform-input-shortcode-selector'><input type='text' name='rureraform-notifications-subject' value='" + (_values != null && _values.hasOwnProperty('subject') ? rureraform_escape_html(_values['subject']) : rureraform_escape_html(rureraform_notifications['subject']['value'])) + "' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div>";
    var message_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='message'><div class='rureraform-properties-label'><label>" + rureraform_notifications['message']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['message']['tooltip'] + "</div></div><div class='rureraform-properties-content rureraform-wysiwyg'><textarea class='rureraform-tinymce rureraform-tinymce-pre' name='rureraform-notifications-message' id='rureraform-notifications-message-" + message_id + "'>" + (_values != null && _values.hasOwnProperty('message') ? rureraform_escape_html(_values['message']) : rureraform_escape_html(rureraform_notifications['message']['value'])) + "</textarea></div></div>";

    if (_values != null && _values.hasOwnProperty('attachments'))
        property_value = _values['attachments'];
    else
        property_value = rureraform_notifications['attachments']['value'];
    options = "";
    for (var j = 0; j < property_value.length; j++) {
        options += rureraform_properties_attachment_get(property_value[j]["source"], property_value[j]["token"]);
    }
    html += "<div class='rureraform-properties-item' data-id='attachments'><div class='rureraform-properties-label'><label>" + rureraform_notifications['attachments']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['attachments']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-properties-attachments'>" + options + "</div><div class='rureraform-properties-attachment-buttons'><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_attachment_new(this);'><i class='fas fa-plus'></i><label>Add file</label></a></div></div></div>";

    html += "<div class='rureraform-properties-item' data-id='reply-email'><div class='rureraform-properties-label'><label>" + rureraform_notifications['reply-email']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['reply-email']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-properties-group rureraform-input-shortcode-selector'><input type='text' name='rureraform-notifications-reply-email' value='" + (_values != null && _values.hasOwnProperty('reply-email') ? rureraform_escape_html(_values['reply-email']) : rureraform_escape_html(rureraform_notifications['reply-email']['value'])) + "' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div>";
    html += "<div class='rureraform-properties-item' data-id='from'><div class='rureraform-properties-label'><label>" + rureraform_notifications['from']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['from']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-properties-group'><div class='rureraform-properties-content-half rureraform-input-shortcode-selector'><input type='text' name='rureraform-notifications-from-email' value='" + (_values != null && _values.hasOwnProperty('from-email') ? rureraform_escape_html(_values['from-email']) : rureraform_escape_html(rureraform_notifications['from']['value']['email'])) + "' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div><div class='rureraform-properties-content-half rureraform-input-shortcode-selector'><input type='text' name='rureraform-notifications-from-name' value='" + (_values != null && _values.hasOwnProperty('from-name') ? rureraform_escape_html(_values['from-name']) : rureraform_escape_html(rureraform_notifications['from']['value']['name'])) + "' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div></div>";

    if (_values != null && _values.hasOwnProperty('logic-enable'))
        logic_enable = _values['logic-enable'];
    else
        logic_enable = rureraform_notifications['logic-enable']['value'];
    logic_enable_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='logic-enable'><div class='rureraform-properties-label'><label>" + rureraform_notifications['logic-enable']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['logic-enable']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' id='rureraform-notifications-logic-enable-" + logic_enable_id + "' name='rureraform-notifications-logic-enable'" + (logic_enable == "on" ? ' checked="checked"' : '') + "' onchange='return rureraform_properties_notifications_logic_enable_changed(this);' /><label for='rureraform-notifications-logic-enable-" + logic_enable_id + "'></label></div></div>";

    if (_values != null && _values.hasOwnProperty('logic'))
        property_value = _values['logic'];
    else
        property_value = rureraform_notifications['logic']['value'];
    if (input_ids.length > 0) {
        temp = "<div class='rureraform-properties-group rureraform-properties-logic-header'>";
        options = "";
        for (var option_key in rureraform_notifications['logic']['actions']) {
            if (rureraform_notifications['logic']['actions'].hasOwnProperty(option_key)) {
                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value["action"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_notifications['logic']['actions'][option_key]) + "</option>";
            }
        }
        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-notifications-logic-action' id='rureraform-logic-action'>" + options + "</select></div>";
        options = "";
        for (var option_key in rureraform_notifications['logic']['operators']) {
            if (rureraform_notifications['logic']['operators'].hasOwnProperty(option_key)) {
                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value["operator"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_notifications['logic']['operators'][option_key]) + "</option>";
            }
        }
        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-notifications-logic-operator' id='rureraform-logic-operator'>" + options + "</select></div>";
        temp += "</div>";
        options = "";
        for (var j = 0; j < property_value["rules"].length; j++) {
            if (input_ids.indexOf(parseInt(property_value["rules"][j]["field"], 10)) != -1) {
                options += rureraform_properties_logic_rule_get(null, property_value["rules"][j]["field"], property_value["rules"][j]["rule"], property_value["rules"][j]["token"]);
            }
        }
        temp += "<div class='rureraform-properties-logic-rules'>" + options + "</div><div class='rureraform-properties-logic-buttons'><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_logic_rule_new(this, null);'><i class='fas fa-plus'></i><label>Add rule</label></a></div>";
    } else {
        temp = "<div class='rureraform-properties-inline-error'>There are no elements available to use for logic rules.</div>";
    }
    html += "<div class='rureraform-properties-item' data-id='logic'" + (logic_enable == "on" ? "" : " style='display:none;'") + "><div class='rureraform-properties-label'><label>" + rureraform_notifications['logic']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_notifications['logic']['tooltip'] + "</div></div><div class='rureraform-properties-content'>" + temp + "</div></div>";
    html += "</div></div>";

    if (_values == null)
        jQuery(".rureraform-properties-content-notifications .rureraform-properties-sub-item-body").slideUp(300);
    jQuery(".rureraform-properties-content-notifications").append(html);

    jQuery(".rureraform-properties-sub-item-new .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
        contentAsHTML: true,
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom",
        content: "Default",
        functionFormat: function (instance, helper, content) {
            return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
        }
    });

    rureraform_init_tinymce();
    rureraform_properties_notifications_name_changed(jQuery(".rureraform-properties-content-notifications .rureraform-properties-sub-item").last().find("[name='rureraform-notifications-name']"));
    jQuery(".rureraform-properties-sub-item-new").slideDown(300);
    jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    return false;
}

function rureraform_properties_math_name_changed(_object) {
    var label = jQuery(_object).val().substring(0, 52) + (jQuery(_object).val().length > 52 ? "..." : "");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-header>label").text(label);
    return false;
}
function rureraform_properties_math_details_toggle(_object) {
    jQuery(_object).closest(".rureraform-properties-sub-item").addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-math-expressions .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(_object).closest(".rureraform-properties-sub-item").removeClass("rureraform-freeze");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-body").slideToggle(300);
    return false;
}
function rureraform_properties_math_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
                jQuery(".rureraform-shortcode-selector-list-input").remove();
                jQuery(".rureraform-shortcode-selector-list-wysiwyg").replaceWith(rureraform_shortcode_selector_list_html("rureraform-shortcode-selector-list-wysiwyg"));
                jQuery(".rureraform-shortcode-selector-list-wysiwyg").replaceWith(rureraform_shortcode_selector_list_html("rureraform-shortcode-selector-list-wysiwyg"));
                jQuery(".rureraform-shortcode-selector-list-wysiwyg").each(function () {
                    var textarea = jQuery(this).closest(".rureraform-wysiwyg").find(".rureraform-tinymce");
                    if (textarea.length > 0) {
                        if (typeof tinymce != typeof undefined) {
                            var editor = tinymce.get(jQuery(textarea).attr("id"));
                            jQuery(textarea).closest(".rureraform-wysiwyg").find(".rureraform-shortcode-selector-list-item").on("click", function () {
                                editor.insertContent(jQuery(this).attr("data-code"));
                            });
                        }
                    }
                });
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_math_add(_values) {
    var extra_class = "", html = "", tooltip_html, property_value;

    if (_values == null) {
        extra_class = " rureraform-properties-sub-item-new";
        rureraform_element_properties_data_changed = true;
    } else
        extra_class = " rureraform-properties-sub-item-exist";
    html += "<div class='rureraform-properties-sub-item" + extra_class + "'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_math_delete(this);'><i class='fas fa-trash-alt'></i></span><span onclick='return rureraform_properties_math_details_toggle(this);'><i class='fas fa-cog'></i></span></div><label></label></div><div class='rureraform-properties-sub-item-body'>";

    if (_values != null && _values.hasOwnProperty('id'))
        property_value = _values['id'];
    else {
        rureraform_form_last_id++;
        property_value = rureraform_form_last_id;
    }
    html += "<div class='rureraform-properties-item' data-id='id'><div class='rureraform-properties-label'><label>" + rureraform_math_expressions_meta['id']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_math_expressions_meta['id']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-number'><input type='text' name='rureraform-math-id' value='" + property_value + "' readonly='readonly' onclick='this.focus();this.select();' /></div></div></div>";
    html += "<div class='rureraform-properties-item' data-id='name'><div class='rureraform-properties-label'><label>" + rureraform_math_expressions_meta['name']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_math_expressions_meta['name']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input type='text' name='rureraform-math-name' value='" + (_values != null && _values.hasOwnProperty('name') ? rureraform_escape_html(_values['name']) : rureraform_escape_html(rureraform_math_expressions_meta['name']['value'])) + "' oninput='return rureraform_properties_math_name_changed(this);' /></div></div>";
    html += "<div class='rureraform-properties-item' data-id='expression'><div class='rureraform-properties-label'><label>" + rureraform_math_expressions_meta['expression']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_math_expressions_meta['expression']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-properties-group rureraform-input-shortcode-selector'><input type='text' name='rureraform-math-expression' value='" + (_values != null && _values.hasOwnProperty('expression') ? rureraform_escape_html(_values['expression']) : rureraform_escape_html(rureraform_math_expressions_meta['expression']['value'])) + "' /><div class='rureraform-shortcode-selector' data-disabled-groups='math' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div>";
    html += "<div class='rureraform-properties-item' data-id='default'><div class='rureraform-properties-label'><label>" + rureraform_math_expressions_meta['default']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_math_expressions_meta['default']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input type='text' name='rureraform-math-default' value='" + (_values != null && _values.hasOwnProperty('default') ? rureraform_escape_html(_values['default']) : rureraform_escape_html(rureraform_math_expressions_meta['default']['value'])) + "' /></div></div>";
    if (_values != null && _values.hasOwnProperty('decimal-digits'))
        property_value = _values['decimal-digits'];
    else
        property_value = rureraform_math_expressions_meta['decimal-digits']['value'];
    html += "<div class='rureraform-properties-item' data-id='decimal-digits'><div class='rureraform-properties-label'><label>" + rureraform_math_expressions_meta['decimal-digits']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_math_expressions_meta['decimal-digits']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-number'><select name='rureraform-math-decimal-digits'><option value='0'" + (property_value == 0 ? " selected='selected'" : "") + ">0</option><option value='1'" + (property_value == 1 ? " selected='selected'" : "") + ">1</option><option value='2'" + (property_value == 2 ? " selected='selected'" : "") + ">2</option><option value='3'" + (property_value == 3 ? " selected='selected'" : "") + ">3</option><option value='4'" + (property_value == 4 ? " selected='selected'" : "") + ">4</option><option value='5'" + (property_value == 5 ? " selected='selected'" : "") + ">5</option><option value='6'" + (property_value == 6 ? " selected='selected'" : "") + ">6</option><option value='7'" + (property_value == 7 ? " selected='selected'" : "") + ">7</option><option value='8'" + (property_value == 8 ? " selected='selected'" : "") + ">8</option></select></div></div></div>";
    html += "</div></div>";

    if (_values == null)
        jQuery(".rureraform-properties-content-math-expressions .rureraform-properties-sub-item-body").slideUp(300);
    jQuery(".rureraform-properties-content-math-expressions").append(html);

    jQuery(".rureraform-properties-sub-item-new .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
        contentAsHTML: true,
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom",
        content: "Default",
        functionFormat: function (instance, helper, content) {
            return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
        }
    });

    rureraform_properties_math_name_changed(jQuery(".rureraform-properties-content-math-expressions .rureraform-properties-sub-item").last().find("[name='rureraform-math-name']"));
    jQuery(".rureraform-properties-sub-item-new").slideDown(300);
    jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    jQuery(".rureraform-shortcode-selector-list-input").remove();
    jQuery(".rureraform-shortcode-selector-list-wysiwyg").replaceWith(rureraform_shortcode_selector_list_html("rureraform-shortcode-selector-list-wysiwyg"));
    jQuery(".rureraform-shortcode-selector-list-wysiwyg").each(function () {
        var textarea = jQuery(this).closest(".rureraform-wysiwyg").find(".rureraform-tinymce");
        if (textarea.length > 0) {
            if (typeof tinymce != typeof undefined) {
                var editor = tinymce.get(jQuery(textarea).attr("id"));
                jQuery(textarea).closest(".rureraform-wysiwyg").find(".rureraform-shortcode-selector-list-item").on("click", function () {
                    editor.insertContent(jQuery(this).attr("data-code"));
                });
            }
        }
    });
    return false;
}

function rureraform_properties_confirmations_name_changed(_object) {
    var label = jQuery(_object).val().substring(0, 52) + (jQuery(_object).val().length > 52 ? "..." : "");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-header>label").text(label);
    return false;
}
function rureraform_properties_confirmations_logic_enable_changed(_object) {
    var parent = jQuery(_object).closest(".rureraform-properties-sub-item");
    if (jQuery(_object).is(":checked"))
        jQuery(parent).find(".rureraform-properties-item[data-id='logic']").fadeIn(300);
    else
        jQuery(parent).find(".rureraform-properties-item[data-id='logic']").fadeOut(300);
    return false;
}
function rureraform_properties_confirmations_type_changed(_object) {
    var parent = jQuery(_object).closest(".rureraform-properties-sub-item");
    switch (jQuery(_object).val()) {
        case 'page':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").hide();
            break;
        case 'page-redirect':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").hide();
            break;
        case 'page-payment':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").show();
            break;
        case 'message':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").hide();
            break;
        case 'message-redirect':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").hide();
            break;
        case 'message-payment':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").show();
            break;
        case 'redirect':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").show();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").hide();
            break;
        case 'payment':
            jQuery(parent).find(".rureraform-properties-item[data-id='message']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='url']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='delay']").hide();
            jQuery(parent).find(".rureraform-properties-item[data-id='payment-gateway']").show();
            break;
        default:
            break;
    }
    return false;
}
function rureraform_properties_confirmations_details_toggle(_object) {
    jQuery(_object).closest(".rureraform-properties-sub-item").addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-confirmations .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(_object).closest(".rureraform-properties-sub-item").removeClass("rureraform-freeze");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-body").slideToggle(300);
    return false;
}
function rureraform_properties_confirmations_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_confirmations_add(_values) {
    var extra_class = "", html = "", temp = "", tooltip_html, selected, property_value, logic_enable, logic_enable_id;

    if (_values == null) {
        extra_class = " rureraform-properties-sub-item-new";
        rureraform_element_properties_data_changed = true;
    } else
        extra_class = " rureraform-properties-sub-item-exist";
    html += "<div class='rureraform-properties-sub-item" + extra_class + "'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_confirmations_delete(this);'><i class='fas fa-trash-alt'></i></span><span onclick='return rureraform_properties_confirmations_details_toggle(this);'><i class='fas fa-cog'></i></span></div><label></label></div><div class='rureraform-properties-sub-item-body'>";
    html += "<div class='rureraform-properties-item' data-id='name'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['name']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['name']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input type='text' name='rureraform-confirmations-name' value='" + (_values != null && _values.hasOwnProperty('name') ? rureraform_escape_html(_values['name']) : rureraform_escape_html(rureraform_confirmations['name']['value'])) + "' oninput='return rureraform_properties_confirmations_name_changed(this);' /></div></div>";
    var options = "";
    if (_values != null && _values.hasOwnProperty('type'))
        property_value = _values['type'];
    else
        property_value = rureraform_confirmations['type']['value'];
    for (var option_key in rureraform_confirmations['type']['options']) {
        if (rureraform_confirmations['type']['options'].hasOwnProperty(option_key)) {
            selected = "";
            if (option_key == property_value)
                selected = " selected='selected'";
            options += "<option" + selected + " value='" + rureraform_escape_html(option_key) + "'>" + rureraform_escape_html(rureraform_confirmations['type']['options'][option_key]) + "</option>";
        }
    }
    html += "<div class='rureraform-properties-item' data-id='type'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['type']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['type']['tooltip'] + "</div></div><div class='rureraform-properties-content'><select name='rureraform-confirmations-type' onchange='return rureraform_properties_confirmations_type_changed(this);'>" + options + "</select></div></div>";
    var message_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='message'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['message']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['message']['tooltip'] + "</div></div><div class='rureraform-properties-content rureraform-wysiwyg'><textarea class='rureraform-tinymce rureraform-tinymce-pre' name='rureraform-confirmations-message' id='rureraform-confirmations-message-" + message_id + "'>" + (_values != null && _values.hasOwnProperty('message') ? rureraform_escape_html(_values['message']) : rureraform_escape_html(rureraform_confirmations['message']['value'])) + "</textarea></div></div>";
    html += "<div class='rureraform-properties-item' data-id='url'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['url']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['url']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div class='rureraform-properties-group rureraform-input-shortcode-selector'><input type='text' name='rureraform-confirmations-url' value='" + (_values != null && _values.hasOwnProperty('url') ? rureraform_escape_html(_values['url']) : rureraform_escape_html(rureraform_confirmations['url']['value'])) + "' /><div class='rureraform-shortcode-selector' onmouseover='rureraform_shortcode_selector_set(this)';><span><i class='fas fa-code'></i></span></div></div></div></div>";

    html += "<div class='rureraform-properties-item' data-id='delay'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['delay']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['delay']['tooltip'] + "</div></div><div class='rureraform-properties-content'><div><input class='rureraform-number' type='text' name='rureraform-confirmations-delay' value='" + (_values != null && _values.hasOwnProperty('delay') ? rureraform_escape_html(_values['delay']) : rureraform_escape_html(rureraform_confirmations['delay']['value'])) + "' />" + (rureraform_confirmations['delay'].hasOwnProperty("unit") ? " " + rureraform_confirmations['delay']["unit"] : "") + "</div></div></div>";

    property_value = (_values != null && _values.hasOwnProperty('payment-gateway') ? rureraform_escape_html(_values['payment-gateway']) : rureraform_escape_html(rureraform_confirmations['payment-gateway']['value']));
    options = "<option value=''>Select payment gateway</option>";
    for (var key in rureraform_form_options['payment-gateways']) {
        selected = "";
        if (rureraform_form_options['payment-gateways'][key]['id'] == property_value)
            selected = " selected='selected'";
        options += "<option" + selected + " value='" + rureraform_escape_html(rureraform_form_options['payment-gateways'][key]['id']) + "'>" + rureraform_escape_html(rureraform_form_options['payment-gateways'][key]['name']) + "</option>";
    }
    html += "<div class='rureraform-properties-item' data-id='payment-gateway'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['payment-gateway']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['payment-gateway']['tooltip'] + "</div></div><div class='rureraform-properties-content'><select class='rureraform-payment-gateways-select' name='rureraform-confirmations-payment-gateway'>" + options + "</select></div></div>";

    var reset_form;
    if (_values != null && _values.hasOwnProperty('reset-form'))
        reset_form = _values['reset-form'];
    else
        reset_form = rureraform_confirmations['reset-form']['value'];
    var reset_form_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='reset-form'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['reset-form']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['reset-form']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' id='rureraform-confirmations-reset-form-" + reset_form_id + "' name='rureraform-confirmations-reset-form'" + (reset_form == "on" ? ' checked="checked"' : '') + "' /><label for='rureraform-confirmations-reset-form-" + reset_form_id + "'></label></div></div>";

    if (_values != null && _values.hasOwnProperty('logic-enable'))
        logic_enable = _values['logic-enable'];
    else
        logic_enable = rureraform_confirmations['logic-enable']['value'];
    logic_enable_id = rureraform_random_string(16);
    html += "<div class='rureraform-properties-item' data-id='logic-enable'><div class='rureraform-properties-label'><label>" + rureraform_confirmations['logic-enable']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['logic-enable']['tooltip'] + "</div></div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' id='rureraform-confirmations-logic-enable-" + logic_enable_id + "' name='rureraform-confirmations-logic-enable'" + (logic_enable == "on" ? ' checked="checked"' : '') + "' onchange='return rureraform_properties_confirmations_logic_enable_changed(this);' /><label for='rureraform-confirmations-logic-enable-" + logic_enable_id + "'></label></div></div>";

    if (_values != null && _values.hasOwnProperty('logic'))
        property_value = _values['logic'];
    else
        property_value = rureraform_confirmations['logic']['value'];
    var input_ids = new Array();
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[i]['type']) && rureraform_toolbar_tools[rureraform_form_elements[i]['type']]['type'] == 'input') {
            input_ids.push(rureraform_form_elements[i]["id"]);
        }
    }
    if (input_ids.length > 0) {
        temp = "<div class='rureraform-properties-group rureraform-properties-logic-header'>";
        options = "";
        for (var option_key in rureraform_confirmations['logic']['actions']) {
            if (rureraform_confirmations['logic']['actions'].hasOwnProperty(option_key)) {
                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value["action"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_confirmations['logic']['actions'][option_key]) + "</option>";
            }
        }
        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-confirmations-logic-action' id='rureraform-logic-action'>" + options + "</select></div>";
        options = "";
        for (var option_key in rureraform_confirmations['logic']['operators']) {
            if (rureraform_confirmations['logic']['operators'].hasOwnProperty(option_key)) {
                options += "<option value='" + rureraform_escape_html(option_key) + "'" + (property_value["operator"] == option_key ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_confirmations['logic']['operators'][option_key]) + "</option>";
            }
        }
        temp += "<div class='rureraform-properties-content-half'><select name='rureraform-confirmations-logic-operator' id='rureraform-logic-operator'>" + options + "</select></div>";
        temp += "</div>";
        options = "";
        for (var j = 0; j < property_value["rules"].length; j++) {
            if (input_ids.indexOf(parseInt(property_value["rules"][j]["field"], 10)) != -1) {
                options += rureraform_properties_logic_rule_get(null, property_value["rules"][j]["field"], property_value["rules"][j]["rule"], property_value["rules"][j]["token"]);
            }
        }
        temp += "<div class='rureraform-properties-logic-rules'>" + options + "</div><div class='rureraform-properties-logic-buttons'><a class='rureraform-admin-button rureraform-admin-button-gray rureraform-admin-button-small' href='#' onclick='return rureraform_properties_logic_rule_new(this, null);'><i class='fas fa-plus'></i><label>Add rule</label></a></div>";
    } else {
        temp = "<div class='rureraform-properties-inline-error'>There are no elements available to use for logic rules.</div>";
    }
    html += "<div class='rureraform-properties-item' data-id='logic'" + (logic_enable == "on" ? "" : " style='display:none;'") + "><div class='rureraform-properties-label'><label>" + rureraform_confirmations['logic']['label'] + "</label></div><div class='rureraform-properties-tooltip'><i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_confirmations['logic']['tooltip'] + "</div></div><div class='rureraform-properties-content'>" + temp + "</div></div>";
    html += "</div></div>";

    if (_values == null)
        jQuery(".rureraform-properties-content-confirmations .rureraform-properties-sub-item-body").slideUp(300);
    jQuery(".rureraform-properties-content-confirmations").append(html);

    jQuery(".rureraform-properties-sub-item-new .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
        contentAsHTML: true,
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom",
        content: "Default",
        functionFormat: function (instance, helper, content) {
            return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
        }
    });

    rureraform_init_tinymce();
    rureraform_properties_confirmations_name_changed(jQuery(".rureraform-properties-content-confirmations .rureraform-properties-sub-item").last().find("[name='rureraform-confirmations-name']"));
    rureraform_properties_confirmations_type_changed(jQuery(".rureraform-properties-content-confirmations .rureraform-properties-sub-item").last().find("[name='rureraform-confirmations-type']"));
    jQuery(".rureraform-properties-sub-item-new").slideDown(300);
    jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    return false;
}
function rureraform_properties_filters_add(_type, _filter, _values) {
    var extra_class = "", html = "", tooltip_html, selected, property_value = "";
    var seq = 0, last;
    last = jQuery(".rureraform-properties-content-filters .rureraform-properties-sub-item").last();
    if (jQuery(last).length)
        seq = parseInt(jQuery(last).attr("data-seq"), 10) + 1;
    if (rureraform_meta[_type].hasOwnProperty("filters") && rureraform_filters.hasOwnProperty(_filter)) {
        if (_values == null) {
            extra_class = " rureraform-properties-sub-item-new";
            rureraform_element_properties_data_changed = true;
        } else
            extra_class = " rureraform-properties-sub-item-exist";
        if (rureraform_filters[_filter].hasOwnProperty("properties"))
            property_value = "<span onclick='return rureraform_properties_filters_details_toggle(this);'><i class='fas fa-cog'></i></span>";
        html += "<div class='rureraform-properties-sub-item" + extra_class + "' data-type='" + _filter + "' data-seq='" + seq + "'><div class='rureraform-properties-sub-item-header'><div class='rureraform-properties-sub-item-header-tools'><span onclick='return rureraform_properties_filters_delete(this);'><i class='fas fa-trash-alt'></i></span>" + property_value + "</div><label>" + rureraform_filters[_filter]["label"] + "</label></div><div class='rureraform-properties-sub-item-body'>";
        for (var key in rureraform_filters[_filter]["properties"]) {
            if (rureraform_filters[_filter]["properties"].hasOwnProperty(key)) {
                tooltip_html = "";
                if (rureraform_filters[_filter]["properties"][key].hasOwnProperty('tooltip')) {
                    tooltip_html = "<i class='fas fa-question-circle rureraform-tooltip-anchor'></i><div class='rureraform-tooltip-content'>" + rureraform_filters[_filter]["properties"][key]['tooltip'] + "</div>";
                }
                property_value = "";
                if (_values != null && _values.hasOwnProperty("properties") && _values["properties"].hasOwnProperty(key))
                    property_value = _values["properties"][key];
                switch (rureraform_filters[_filter]["properties"][key]['type']) {
                    case 'text':
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_filters[_filter]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input type='text' name='rureraform-filters-" + key + "' id='rureraform-filters-" + seq + "-" + key + "' value='" + rureraform_escape_html(property_value) + "' placeholder='" + rureraform_escape_html(property_value) + "' /></div></div>";
                        break;

                    case 'integer':
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_filters[_filter]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><div class='rureraform-number'><input type='text' name='rureraform-filters-" + key + "' id='rureraform-filters-" + seq + "-" + key + "' value='" + rureraform_escape_html(property_value) + "' placeholder='' /></div></div></div>";
                        break;

                    case 'checkbox':
                        selected = "";
                        if (property_value == "on")
                            selected = " checked='checked'";
                        html += "<div class='rureraform-properties-item' data-id='" + key + "'><div class='rureraform-properties-label'><label>" + rureraform_filters[_filter]["properties"][key]['label'] + "</label></div><div class='rureraform-properties-tooltip'>" + tooltip_html + "</div><div class='rureraform-properties-content'><input class='rureraform-checkbox-toggle' type='checkbox' value='off' name='rureraform-filters-" + key + "' id='rureraform-filters-" + seq + "-" + key + "'" + selected + "' /><label for='rureraform-filters-" + seq + "-" + key + "'></label></div></div>";
                        break;

                    default:
                        break;
                }
            }
        }
        html += "</div></div>";
        if (_values == null)
            jQuery(".rureraform-properties-content-filters .rureraform-properties-sub-item-body").slideUp(300);
        jQuery(".rureraform-properties-content-filters").append(html);
        jQuery(".rureraform-properties-sub-item-new .rureraform-properties-tooltip .rureraform-tooltip-anchor").tooltipster({
            contentAsHTML: true,
            maxWidth: 360,
            theme: "tooltipster-dark",
            side: "bottom",
            content: "Default",
            functionFormat: function (instance, helper, content) {
                return jQuery(helper.origin).parent().find('.rureraform-tooltip-content').html();
            }
        });

        jQuery(".rureraform-properties-sub-item-new").slideDown(300);
        jQuery(".rureraform-properties-sub-item-new").removeClass("rureraform-properties-sub-item-new");
    }
    return false;
}
function rureraform_properties_filters_details_toggle(_object) {
    jQuery(_object).closest(".rureraform-properties-sub-item").addClass("rureraform-freeze");
    jQuery(".rureraform-properties-content-filters .rureraform-properties-sub-item").each(function () {
        if (!jQuery(this).hasClass("rureraform-freeze"))
            jQuery(this).find(".rureraform-properties-sub-item-body").slideUp(300);
    });
    jQuery(_object).closest(".rureraform-properties-sub-item").removeClass("rureraform-freeze");
    jQuery(_object).closest(".rureraform-properties-sub-item").find(".rureraform-properties-sub-item-body").slideToggle(300);
    return false;
}
function rureraform_properties_filters_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-sub-item").slideUp(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_logic_rule_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to delete the item.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Delete'),
        ok_function: function (e) {
            jQuery(_object).closest(".rureraform-properties-logic-rule").slideUp(300, function () {
                jQuery(this).remove();
            });
            rureraform_element_properties_data_changed = true;
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_properties_logic_rule_token_change(_object) {
    var rule = jQuery(_object).closest(".rureraform-properties-logic-rule");
    var html = rureraform_properties_logic_rule_token_get(jQuery(rule).find(".rureraform-properties-logic-rule-field").val(), jQuery(rule).find(".rureraform-properties-logic-rule-rule").val(), "");
    jQuery(rule).find(".rureraform-properties-logic-rule-token-container").html(html);
    return false;
}
function rureraform_properties_logic_rule_token_get(_field, _rule, _token) {
    var html = "", input = null, options = "";

    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_form_elements[i]['id'] == _field) {
            input = rureraform_form_elements[i];
            break;
        }
    }
    if (input == null)
        html = "<input class='rureraform-properties-logic-rule-token' type='text' placeholder='Enter your value...' value='" + (_token ? rureraform_escape_html(_token) : "") + "' />";
    else {
        if (_rule == 'is-empty' || _rule == 'is-not-empty')
            html = "<input class='rureraform-properties-logic-rule-token' type='hidden' value='' />";
        else if (_rule == 'is' || _rule == 'is-not') {
            if (input.hasOwnProperty("options") && input["options"].length > 0) {
                for (var i = 0; i < input["options"].length; i++) {
                    options += "<option value='" + rureraform_escape_html(input["options"][i]["value"]) + "'" + (input["options"][i]["value"] == _token ? " selected='selected'" : "") + ">" + rureraform_escape_html(input["options"][i]["label"]) + "</option>";
                }
                html = "<select class='rureraform-properties-logic-rule-token'>" + options + "</select>";
            } else
                html = "<input class='rureraform-properties-logic-rule-token' type='text' placeholder='Enter your value...' value='" + (_token ? rureraform_escape_html(_token) : "") + "' />";
        } else
            html = "<input class='rureraform-properties-logic-rule-token' type='text' placeholder='Enter your value...' value='" + (_token ? rureraform_escape_html(_token) : "") + "' />";
    }
    return html;
}
function rureraform_properties_logic_rule_get(_field_id, _field, _rule, _token) {
    var temp = "", html = "", field_options = "", rule_options = "";

    var field_selected = null, rule_selected = null;
    var input_fields = rureraform_input_sort();
    if (input_fields.length > 0) {
        for (var j = 0; j < input_fields.length; j++) {
            if (temp != input_fields[j]['page-id']) {
                if (temp != "")
                    field_options += "</optgroup>";
                field_options += "<optgroup label='" + rureraform_escape_html(input_fields[j]['page-name']) + "'>";
                temp = input_fields[j]['page-id'];
            }
            if (field_selected == null || _field == input_fields[j]['id'])
                field_selected = input_fields[j]['id'];
            field_options += "<option value='" + input_fields[j]['id'] + "'" + (input_fields[j]['id'] == _field ? " selected='selected'" : "") + ">" + input_fields[j]['id'] + " | " + rureraform_escape_html(input_fields[j]['name']) + "</option>";
        }
        field_options += "</optgroup>";
    }
    for (var key in rureraform_logic_rules) {
        if (rule_selected == null || _rule == key)
            rule_selected = key;
        if (rureraform_logic_rules.hasOwnProperty(key)) {
            rule_options += "<option value='" + key + "'" + (key == _rule ? " selected='selected'" : "") + ">" + rureraform_escape_html(rureraform_logic_rules[key]) + "</option>";
        }
    }
    var field_token = rureraform_properties_logic_rule_token_get(field_selected, rule_selected, _token);
    html = "<div class='rureraform-properties-logic-rule'><div class='rureraform-properties-logic-rule-table'><div><select class='rureraform-properties-logic-rule-field' onchange='rureraform_properties_logic_rule_token_change(this);'>" + field_options + "</select></div><div><select class='rureraform-properties-logic-rule-rule' onchange='rureraform_properties_logic_rule_token_change(this);'>" + rule_options + "</select></div><div class='rureraform-properties-logic-rule-token-container'>" + field_token + "</div><div><span onclick='return rureraform_properties_logic_rule_delete(this);' title='Delete the option'><i class='fas fa-trash-alt'></i></span></div></div></div>";
    return html;
}
function rureraform_properties_logic_rule_new(_object, _field_id) {
    var rule_html = rureraform_properties_logic_rule_get(_field_id, null, null, null);
    jQuery(_object).closest(".rureraform-properties-content").find(".rureraform-properties-logic-rules").append(rule_html);
    rureraform_element_properties_data_changed = true;
    return false;
}

function rureraform_properties_attachment_media(_object) {
    var input = jQuery(_object).parent().children("input");
    var media_frame = wp.media({
        title: 'Select Media',
        multiple: false
    });
    media_frame.on("select", function () {
        var attachment = media_frame.state().get("selection").first();
        jQuery(input).val(attachment.attributes.id + " | " + attachment.attributes.filename);
    });
    media_frame.open();
}
function rureraform_properties_attachment_delete(_object) {
    var attachment = jQuery(_object).closest(".rureraform-properties-attachment");
    jQuery(attachment).slideUp(300, function () {
        jQuery(attachment).remove();
    });
    rureraform_element_properties_data_changed = true;
    return false;
}
function rureraform_properties_attachment_token_change(_object) {
    var attachment = jQuery(_object).closest(".rureraform-properties-attachment");
    var html = rureraform_properties_attachment_token_get(jQuery(attachment).find(".rureraform-properties-attachment-source").val(), "");
    jQuery(attachment).find(".rureraform-properties-attachment-token-container").html(html);
    return false;
}
function rureraform_properties_attachment_token_get(_source, _token) {
    var html = "", input = null, options = "";
    if (_source == "media-library")
        html = "<div class='rureraform-media-id'><input class='rureraform-properties-attachment-token' type='text' placeholder='' readonly='readonly' value='" + rureraform_escape_html(_token) + "' onclick='rureraform_properties_attachment_media(this);' /><span onclick='rureraform_properties_attachment_media(this);'><i class='far fa-file'></i></span></div>";
    else if (_source == "file")
        html = "<input class='rureraform-properties-attachment-token' type='text' placeholder='Enter the FULL path of the file on the server (not URL!).' value='" + rureraform_escape_html(_token) + "' />";
    else {
        for (var i = 0; i < rureraform_form_elements.length; i++) {
            if (rureraform_form_elements[i] == null)
                continue;
            if (rureraform_form_elements[i]['type'] == 'file') {
                options += "<option value='" + rureraform_form_elements[i]['id'] + "'" + (rureraform_form_elements[i]['id'] == _token ? " selected='selected'" : "") + ">" + rureraform_form_elements[i]['id'] + " | " + rureraform_escape_html(rureraform_form_elements[i]['name']) + "</option>";
            }
        }
        if (options != "")
            html = "<select class='rureraform-properties-attachment-token'>" + options + "</select>";
        else
            html = "No form elements (files) found.";
    }
    return html;
}
function rureraform_properties_attachment_get(_source, _token) {
    var token = rureraform_properties_attachment_token_get(_source, _token);
    var html = "<div class='rureraform-properties-attachment'><div class='rureraform-properties-attachment-table'><div><select class='rureraform-properties-attachment-source' onchange='rureraform_properties_attachment_token_change(this);'><option value='form-element'" + (_source == "form-element" ? " selected='selected'" : "") + ">Form Element</option>" + (typeof UAP_CORE == typeof undefined ? "<option value='media-library'" + (_source == "media-library" ? " selected='selected'" : "") + ">Media Library</option>" : "") + "<option value='file'" + (_source == "file" ? " selected='selected'" : "") + ">File on Server</option></select></div><div class='rureraform-properties-attachment-token-container'>" + token + "</div><div><span onclick='return rureraform_properties_attachment_delete(this);' title='Delete the attachment'><i class='fas fa-trash-alt'></i></span></div></div></div>";
    return html;
}
function rureraform_properties_attachment_new(_object) {
    var attachment_html = rureraform_properties_attachment_get(null, null);
    jQuery(_object).closest(".rureraform-properties-content").find(".rureraform-properties-attachments").append(attachment_html);
    rureraform_element_properties_data_changed = true;
    return false;
}

function rureraform_init_tinymce() {
    var label;
    var temp = rureraform_shortcode_selector_list_html("rureraform-shortcode-selector-list-wysiwyg");
    temp = "<div class='rureraform-shortcode-selector'><span class='rureraform-shortcode-selector-button'><i class='fas fa-code'></i></span>" + temp + "</div>";

    jQuery(".rureraform-tinymce-pre").each(function () {
        if (jQuery(this).find(".rureraform-shortcode-selector").length == 0)
            jQuery(this).after(temp);
        jQuery("body").addClass("rureraform-static");
        var textarea = this;
        if (typeof wp != 'undefined' && wp.hasOwnProperty('editor') && typeof wp.editor.initialize == 'function') {
            wp.editor.initialize(
                    jQuery(this).attr("id"),
                    {
                        tinymce: {
                            content_css: rureraform_plugin_url + "/css/tiny-content.css",
                            wpautop: false,
                            fontsize_formats: 'inherit 10px 12px 14px 15px 16px 18px 20px 24px 28px 32px 36px',
                            block_formats: 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5;Header 6=h6',
                            plugins: 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                            toolbar: [
                                'formatselect fontsizeselect bold italic underline | bullist numlist | indent outdent | alignleft aligncenter alignright | link unlink | image | forecolor backcolor | hr | pastetext undo redo | lefrom-fields'
                            ],
                            height: '200',
                            setup: function (editor) {
                                jQuery(textarea).closest(".rureraform-wysiwyg").find(".rureraform-shortcode-selector-list-item").on("click", function () {
                                    editor.insertContent(jQuery(this).attr("data-code"));
                                });
                            }

                        },
                        quicktags: {buttons: '.'}
                    }
            );
        } else {
            jQuery(textarea).closest(".rureraform-wysiwyg").find(".rureraform-shortcode-selector-list-item").on("click", function (e) {
                var input = jQuery(this).closest(".rureraform-input-shortcode-selector").find("textarea");
                input = textarea;
                var caret_pos = input.selectionStart;
                var current_value = jQuery(input).val();
                jQuery(input).val(current_value.substring(0, caret_pos) + jQuery(this).attr("data-code") + current_value.substring(caret_pos));
            });
        }
        jQuery(this).removeClass("rureraform-tinymce-pre");
    });
}
var rureraform_shortcode_selector_setting = false;
function rureraform_shortcode_selector_set(_object) {
    if (rureraform_shortcode_selector_setting)
        return;
    rureraform_shortcode_selector_setting = true;
    jQuery(".rureraform-shortcode-selector-list-input").find("li").show();
    var disabled_groups_raw = jQuery(_object).attr("data-disabled-groups");
    if (typeof disabled_groups_raw == typeof "string") {
        if (disabled_groups_raw.length > 0) {
            var disabled_groups = disabled_groups_raw.split(",");
            for (var j = 0; j < disabled_groups.length; j++) {
                if (disabled_groups[j].length > 0)
                    jQuery(".rureraform-shortcode-selector-list-input").find("li.rureraform-shortcode-selector-list-item-" + disabled_groups[j]).hide();
            }
        }
    }
    if (jQuery(_object).find(".rureraform-shortcode-selector-list-input").length > 0) {
        rureraform_shortcode_selector_setting = false;
        return;
    }
    if (jQuery(".rureraform-shortcode-selector-list-input").length > 0) {
        jQuery(".rureraform-shortcode-selector-list-input").appendTo(_object);
        rureraform_shortcode_selector_setting = false;
        return;
    }
    var html = rureraform_shortcode_selector_list_html("rureraform-shortcode-selector-list-input");
    jQuery(_object).append(html);
    jQuery(_object).find(".rureraform-shortcode-selector-list-item").on("click", function (e) {
        var input = jQuery(this).closest(".rureraform-input-shortcode-selector").find("input, textarea");
        var caret_pos = input[0].selectionStart;
        var current_value = jQuery(input).val();
        jQuery(input).val(current_value.substring(0, caret_pos) + jQuery(this).attr("data-code") + current_value.substring(caret_pos));
    });
    rureraform_shortcode_selector_setting = false;
    return;
}
function rureraform_shortcode_selector_list_html(_class) {
    var type, items, label, id;

    var temp = "<ul class='" + _class + "'><li class='rureraform-shortcode-selector-group rureraform-shortcode-selector-list-item-field'>Form values</li>";
    for (var j = 0; j < rureraform_form_elements.length; j++) {
        if (rureraform_form_elements[j] == null)
            continue;
        if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[j]['type']) && rureraform_toolbar_tools[rureraform_form_elements[j]['type']]['type'] == 'input') {
            label = rureraform_form_elements[j]['name'].replace(new RegExp("}", 'g'), ")");
            label = label.replace(new RegExp("{", 'g'), "(");
            temp += "<li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-field' data-code='{{" + rureraform_form_elements[j]['id'] + "|" + rureraform_escape_html(label) + "}}'>" + rureraform_form_elements[j]['id'] + " | " + rureraform_escape_html(rureraform_form_elements[j]['name']) + "</li>";
        }
    }

    var math_from_window = false;
    if (rureraform_element_properties_active != null) {
        var type = jQuery(rureraform_element_properties_active).attr("data-type");
        if (type == "settings")
            math_from_window = true;
    }
    if (math_from_window) {
        items = jQuery(".rureraform-properties-content-math-expressions .rureraform-properties-sub-item");
        if (items.length > 0) {
            temp += "<li class='rureraform-shortcode-selector-group rureraform-shortcode-selector-list-item-math'>Math expressions</li>";
            jQuery(items).each(function () {
                label = jQuery(this).find("[name='rureraform-math-name']").val();
                label = label.replace(new RegExp("}", 'g'), ")");
                label = label.replace(new RegExp("{", 'g'), "(");
                id = jQuery(this).find("[name='rureraform-math-id']").val();
                temp += "<li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-math' data-code='{{" + id + "|" + rureraform_escape_html(label) + "}}'>" + id + " | " + jQuery(this).find("[name='rureraform-math-name']").val() + "</li>";
            });
        }
    } else {
        if (rureraform_form_options.hasOwnProperty("math-expressions")) {
            if (rureraform_form_options["math-expressions"].length > 0) {
                temp += "<li class='rureraform-shortcode-selector-group'>Math expressions</li>";
                for (var j = 0; j < rureraform_form_options["math-expressions"].length; j++) {
                    label = rureraform_form_options["math-expressions"][j]['name'].replace(new RegExp("}", 'g'), ")");
                    label = label.replace(new RegExp("{", 'g'), "(");
                    temp += "<li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-math' data-code='{{" + rureraform_form_options["math-expressions"][j]['id'] + "|" + rureraform_escape_html(label) + "}}'>" + rureraform_form_options["math-expressions"][j]['id'] + " | " + rureraform_escape_html(rureraform_form_options["math-expressions"][j]['name']) + "</li>";
                }
            }
        }
    }
    temp += "<li class='rureraform-shortcode-selector-group rureraform-shortcode-selector-list-item-general'>General</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general rureraform-shortcode-selector-list-item-form-data' data-code='{{form-data}}'>All Form Data</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general rureraform-shortcode-selector-list-item-record-id' data-code='{{record-id}}'>Record ID</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{ip}}'>IP Address</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{user-agent}}'>User Agent</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{date}}'>Date</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{time}}'>Time</li>" + (typeof rureraform_uap_core != typeof undefined && rureraform_uap_core === true ? "" : "<li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{wp-user-login}}'>WP User Login</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{wp-user-email}}'>WP User Email</li>") + "<li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{url}}'>Current URL</li><li class='rureraform-shortcode-selector-list-item rureraform-shortcode-selector-list-item-general' data-code='{{page-title}}'>Current Page Title</li>";
    temp += "</ul>";
    return temp;
}
/* Element actions - end */

/* Bulk Options - begin */
var rureraform_bulk_options_object = null;
function rureraform_bulk_options_open(_object) {
    rureraform_bulk_options_object = jQuery(_object).closest(".rureraform-properties-item");
    if (rureraform_bulk_options_object) {
        var window_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var window_width = Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 600);
        jQuery("#rureraform-bulk-options").height(window_height);
        jQuery("#rureraform-bulk-options").width(window_width);
        jQuery("#rureraform-bulk-options .rureraform-admin-popup-inner").height(window_height);
        jQuery("#rureraform-bulk-options .rureraform-admin-popup-content").height(window_height - 104);
        jQuery("#rureraform-bulk-options-overlay").fadeIn(300);
        jQuery("#rureraform-bulk-options").fadeIn(300);
        jQuery(".rureraform-bulk-editor textarea").val("");
    }
    return false;
}
function rureraform_bulk_options_close() {
    rureraform_bulk_options_object = null;
    jQuery("#rureraform-bulk-options-overlay").fadeOut(300);
    jQuery("#rureraform-bulk-options").fadeOut(300);
}
function rureraform_bulk_category_add(_object) {
    var category = jQuery(_object).attr("data-category");
    if (!category)
        return false;
    var value = jQuery(".rureraform-bulk-editor textarea").val();
    if (category == "existing") {
        if (rureraform_bulk_options_object) {
            jQuery(rureraform_bulk_options_object).find(".rureraform-properties-options-item").each(function () {
                var option_label = jQuery(this).find('.rureraform-properties-options-label').val();
                var option_value = jQuery(this).find('.rureraform-properties-options-value').val();
                if (value != "")
                    value += "\r\n";
                if (option_label != option_value)
                    value += option_label + "|" + option_value;
                else
                    value += option_label;
            });
        }
    } else {
        if (rureraform_predefined_options != null && rureraform_predefined_options.hasOwnProperty(category)) {
            for (var i = 0; i < rureraform_predefined_options[category]["options"].length; i++) {
                if (value != "")
                    value += "\r\n";
                value += rureraform_predefined_options[category]["options"][i];
            }
        }
    }
    jQuery(".rureraform-bulk-editor textarea").val(value);
    return false;
}
function rureraform_bulk_options_add() {
    var option;
    var html = "";
    if (rureraform_bulk_options_object) {
        if (jQuery("#rureraform-bulk-options-overwrite").is(":checked")) {
            jQuery(rureraform_bulk_options_object).find(".rureraform-properties-options-container .rureraform-properties-options-item").remove();
        }
        var options_str = jQuery(".rureraform-bulk-editor textarea").val();
        var options = options_str.split("\n");
        for (var i = 0; i < options.length; i++) {
            option = options[i].split("|");
            if (option.length == 1)
                html += rureraform_properties_options_item_get(option[0], option[0], false);
            else
                html += rureraform_properties_options_item_get(option[0], option[1], false);
        }
        jQuery(rureraform_bulk_options_object).find(".rureraform-properties-options-container").append(html);
    }
    rureraform_element_properties_data_changed = true;
    rureraform_bulk_options_close();
}
/* Bulk Options - end */

/* Font Awesome selector - begin */
var rureraform_fa_selector_active = null;
function rureraform_fa_selector_open(_object) {
    var window_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
    var window_width = Math.max(40 * parseInt((jQuery(window).width() - 300) / 40, 10) + 6, 606);
    jQuery(".rureraform-fa-selector").height(window_height);
    jQuery(".rureraform-fa-selector").width(window_width);
    jQuery(".rureraform-fa-selector-inner").height(window_height);
    jQuery(".rureraform-fa-selector-content").height(window_height - 72 - 20);
    jQuery(".rureraform-fa-selector-overlay").show();
    jQuery(".rureraform-fa-selector").show();
    rureraform_fa_selector_active = _object;
    return false;
}
function rureraform_fa_selector_close() {
    rureraform_fa_selector_active = null;
    jQuery(".rureraform-fa-selector-overlay").hide();
    jQuery(".rureraform-fa-selector").hide();
}
function rureraform_fa_selector_set(_object) {
    var icon_class;
    if (rureraform_fa_selector_active == null)
        return false;
    var icon = jQuery(_object).find("i").attr("class");
    if (icon == "")
        icon_class = "rureraform-fa-noicon";
    else
        icon_class = icon;
    var icon_element = jQuery(rureraform_fa_selector_active).attr("data-id");
    jQuery("#rureraform-" + icon_element).val(icon);
    jQuery(rureraform_fa_selector_active).find("i").attr("class", icon_class);
    rureraform_properties_change();
    rureraform_fa_selector_close();
    return false;
}
/* Font Awesome selector - end */

/* Pages - start */
function rureraform_pages_add() {
    if (rureraform_meta.hasOwnProperty("page")) {
        rureraform_form_last_id++;
        var page = {"id": rureraform_form_last_id, "type": "page"};
        for (var key in rureraform_meta["page"]) {
            if (rureraform_meta["page"].hasOwnProperty(key)) {
                switch (rureraform_meta["page"][key]['type']) {
                    default:
                        if (rureraform_meta["page"][key].hasOwnProperty('value')) {
                            if (typeof rureraform_meta["page"][key]['value'] == 'object') {
                                for (var option_key in rureraform_meta["page"][key]['value']) {
                                    if (rureraform_meta["page"][key]['value'].hasOwnProperty(option_key)) {
                                        page[key + "-" + option_key] = rureraform_meta["page"][key]['value'][option_key];
                                    }
                                }
                            } else
                                page[key] = rureraform_meta["page"][key]['value'];
                        } else if (rureraform_meta["page"][key].hasOwnProperty('values'))
                            page[key] = rureraform_meta["page"][key]['values'];
                        break;
                }
            }
        }
        rureraform_form_pages.push(page);
        rureraform_form_changed = true;

        if (jQuery(".rureraform-pages-bar-item-confirmation").length > 0)
            jQuery(".rureraform-pages-bar-item-confirmation").before("<li class='rureraform-pages-bar-item' data-id='" + page["id"] + "' data-name='" + rureraform_escape_html(page['name']) + "'><label onclick='return rureraform_pages_activate(this);'>" + rureraform_escape_html(page['name']) + "</label><span><a href='#' data-type='page' onclick='return rureraform_properties_open(this);'><i class='fas fa-cog'></i></a><a href='#' class='rureraform-pages-bar-item-delete' onclick='return rureraform_pages_delete(this);'><i class='fas fa-trash-alt'></i></a></span></li>");
        else
            jQuery(".rureraform-pages-add").before("<li class='rureraform-pages-bar-item' data-id='" + page["id"] + "' data-name='" + rureraform_escape_html(page['name']) + "'><label onclick='return rureraform_pages_activate(this);'>" + rureraform_escape_html(page['name']) + "</label><span><a href='#' data-type='page' onclick='return rureraform_properties_open(this);'><i class='fas fa-cog'></i></a><a href='#' class='rureraform-pages-bar-item-delete' onclick='return rureraform_pages_delete(this);'><i class='fas fa-trash-alt'></i></a></span></li>");
        if (jQuery(".rureraform-pages-bar-item").length == 1)
            jQuery(".rureraform-pages-bar-item").find(".rureraform-pages-bar-item-delete").addClass("rureraform-pages-bar-item-delete-disabled");
        else
            jQuery(".rureraform-pages-bar-item").find(".rureraform-pages-bar-item-delete").removeClass("rureraform-pages-bar-item-delete-disabled");

        jQuery(".rureraform-builder").append("<div id='rureraform-form-" + page['id'] + "' class='rureraform-form rureraform-elements' _data-parent='" + page['id'] + "' _data-parent-col='0'></div>");
        rureraform_build_progress();
    }
    return false;
}
function _rureraform_pages_delete(_object) {
    var page_id = jQuery(_object).closest("li").attr("data-id");
    for (var i = 0; i < rureraform_form_pages.length; i++) {
        if (rureraform_form_pages[i] != null && rureraform_form_pages[i]['id'] == page_id) {
            rureraform_form_pages[i] = null;
            break;
        }
    }
    jQuery(_object).closest("li").remove();
    jQuery("#rureraform-form-" + page_id).remove();

    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] != null && rureraform_form_elements[i]["_parent"] == page_id) {
            _rureraform_element_delete(i);
        }

    }
    if (jQuery(".rureraform-pages-bar-item").length == 1)
        jQuery(".rureraform-pages-bar-item").find(".rureraform-pages-bar-item-delete").addClass("rureraform-pages-bar-item-delete-disabled");
    else
        jQuery(".rureraform-pages-bar-item").find(".rureraform-pages-bar-item-delete").removeClass("rureraform-pages-bar-item-delete-disabled");

    if (rureraform_form_page_active == page_id)
        rureraform_pages_activate(jQuery(".rureraform-pages-bar-item").first().find("label"));
    rureraform_build_progress();
}
function rureraform_pages_delete(_object) {
    if (jQuery(".rureraform-pages-bar-item").length <= 1)
        return false;
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Please confirm that you want to delete the page and all sub-elements.", "rureraform") + "</div>");
            this.show();
        },
        ok_label: 'Delete',
        ok_function: function (e) {
            _rureraform_pages_delete(_object);
            rureraform_dialog_close();
        }
    });
    return false;
}
function rureraform_pages_activate(_object) {
    var page_id = jQuery(_object).closest("li").attr("data-id");
    if (rureraform_form_page_active == page_id)
        return false;
    if (rureraform_form_page_active != null && jQuery("#rureraform-form-" + rureraform_form_page_active).length > 0) {
        if (rureraform_form_options["progress-position"] == "outside") {
            jQuery("#rureraform-progress-" + rureraform_form_page_active).fadeOut(300);
        }
        jQuery("#rureraform-form-" + rureraform_form_page_active).fadeOut(300, function () {
            jQuery("#rureraform-form-" + page_id).fadeIn(300);
            jQuery("#rureraform-progress-" + page_id).fadeIn(300);
        });
    } else {
        if (rureraform_form_options["progress-position"] == "outside")
            jQuery("#rureraform-progress-" + page_id).fadeIn(300);
        jQuery("#rureraform-form-" + page_id).fadeIn(300);
    }
    rureraform_form_page_active = page_id;
    jQuery(".rureraform-pages-bar-item-active").removeClass("rureraform-pages-bar-item-active");
    jQuery(".rureraform-pages-bar-item[data-id='" + page_id + "'], .rureraform-pages-bar-item-confirmation[data-id='" + page_id + "']").addClass("rureraform-pages-bar-item-active");
    if (page_id == "confirmation")
        jQuery(".rureraform-toolbar-tool-input, .rureraform-toolbar-tool-submit").hide();
    else
        jQuery(".rureraform-toolbar-tool-input, .rureraform-toolbar-tool-submit").show();
    return false;
}
/* Pages - end */

function _rureraform_sync_elements() {
    jQuery(".rureraform-elements").css({"min-height": "60px"});
    jQuery(".rureraform-row").each(function () {
        var max_height = 0;
        jQuery(this).children(".rureraform-col").each(function () {
            var height = jQuery(this).children(".rureraform-elements").height();
            if (height > max_height)
                max_height = height;
        });
        jQuery(this).children(".rureraform-col").each(function () {
            jQuery(this).children(".rureraform-elements").css({"min-height": max_height + "px"});
        });
    });
    jQuery(".rureraform-elements").each(function () {
        var parent = jQuery(this).attr("_data-parent");
        var column = jQuery(this).attr("_data-parent-col");
        var seq = 0;
        jQuery(this).children(".rureraform-element").each(function () {
            var i = jQuery(this).attr("id");
            i = i.replace("rureraform-element-", "");
            rureraform_form_elements[i]["_parent"] = parent;
            rureraform_form_elements[i]["_parent-col"] = column;
            rureraform_form_elements[i]["_seq"] = seq;
            seq++;
        });
    });
}
function _rureraform_build_hidden_list(_parent) {
    var html = "";
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_form_elements[i]["type"] != "hidden")
            continue;
        if (rureraform_form_elements[i]["_parent"] != _parent)
            continue;
        html += "<div class='rureraform-hidden-element' id='rureraform-element-" + i + "' data-type='" + rureraform_form_elements[i]["type"] + "'>" + rureraform_escape_html(rureraform_form_elements[i]["name"]) + "</div>";
    }
    if (html != "")
        html = "<div class='rureraform-hidden-container'><label>Hidden fields:</label>" + html + "</div>";
    return html;
}
function _rureraform_build_children(_parent, _parent_col) {
    var adminbar_height = parseInt(jQuery("#wpadminbar").height(), 10);
    var resizable_handle = "all";
    var html = "", style = "";
    var label, options, selected, icon, option, extra_class, style_attr;
    var column_label_class, column_input_class;
    var properties = {};

    var idxs = new Array();
    var seqs = new Array();
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_form_elements[i]["_parent"] == _parent && (rureraform_form_elements[i]["_parent-col"] == _parent_col || _parent == "")) {
            idxs.push(i);
            seqs.push(parseInt(rureraform_form_elements[i]["_seq"], 10));
        }
    }

    if (idxs.length == 0)
        return {"html": "", "style": ""};
    var sorted;
    for (var i = 0; i < seqs.length; i++) {
        sorted = -1;
        for (var j = 0; j < seqs.length - 1; j++) {
            if (seqs[j] > seqs[j + 1]) {
                sorted = seqs[j];
                seqs[j] = seqs[j + 1];
                seqs[j + 1] = sorted;
                sorted = idxs[j];
                idxs[j] = idxs[j + 1];
                idxs[j + 1] = sorted;
            }
        }
        if (sorted == -1)
            break;
    }
    for (var k = 0; k < idxs.length; k++) {
        i = idxs[k];
        icon = "";
        options = "";
        extra_class = "";
        column_label_class = "";
        column_input_class = "";
        properties = {};
        if (rureraform_form_elements[i] == null)
            continue;

        if (rureraform_form_elements[i].hasOwnProperty("label-style-position")) {
            properties["label-style-position"] = rureraform_form_elements[i]["label-style-position"];
            if (properties["label-style-position"] == "")
                properties["label-style-position"] = rureraform_form_options["label-style-position"];
            if (properties["label-style-position"] == "")
                properties["label-style-position"] = "top";
            if (rureraform_form_elements[i]["label-style-position"] == "left" || rureraform_form_elements[i]["label-style-position"] == "right")
                properties["label-style-width"] = rureraform_form_elements[i]["label-style-width"];
            else
                properties["label-style-width"] = "";
            if (properties["label-style-width"] == "")
                properties["label-style-width"] = rureraform_form_options["label-style-width"];
            if (!rureraform_is_numeric(properties["label-style-width"]) || parseInt(properties["label-style-width"], 10) < 1 || parseInt(properties["label-style-width"], 10) > 11)
                properties["label-style-width"] = 3;
            if (properties["label-style-position"] == "left" || properties["label-style-position"] == "right") {
                column_label_class = " rureraform-col-" + properties["label-style-width"];
                column_input_class = " rureraform-col-" + (12 - properties["label-style-width"]);
            }
        }
        if (rureraform_form_elements[i].hasOwnProperty("icon-left-icon")) {
            if (rureraform_form_elements[i]["icon-left-icon"] != "") {
                extra_class += " rureraform-icon-left";
                icon += "<i class='rureraform-icon-left " + rureraform_form_elements[i]["icon-left-icon"] + "'></i>";
                options = "";
                if (rureraform_form_elements[i]["icon-left-size"] != "") {
                    options += "font-size:" + rureraform_form_elements[i]["icon-left-size"] + "px;";
                }
                if (options != "")
                    style += "#rureraform-element-" + i + " div.rureraform-input>i.rureraform-icon-left{" + options + "}";
            }
        }
        if (rureraform_form_elements[i].hasOwnProperty("icon-right-icon")) {
            if (rureraform_form_elements[i]["icon-right-icon"] != "") {
                extra_class += " rureraform-icon-right";
                icon += "<i class='rureraform-icon-right " + rureraform_form_elements[i]["icon-right-icon"] + "'></i>";
                options = "";
                if (rureraform_form_elements[i]["icon-right-size"] != "") {
                    options += "font-size:" + rureraform_form_elements[i]["icon-right-size"] + "px;";
                }
                if (options != "")
                    style += "#rureraform-element-" + i + " div.rureraform-input>i.rureraform-icon-right{" + options + "}";
            }
        }
        if (rureraform_form_elements[i].hasOwnProperty("css") && rureraform_form_elements[i]["css"].length > 0) {
            if (rureraform_meta.hasOwnProperty(rureraform_form_elements[i]["type"]) && rureraform_meta[rureraform_form_elements[i]["type"]].hasOwnProperty("css")) {
                for (var j = 0; j < rureraform_form_elements[i]["css"].length; j++) {
                    if (rureraform_form_elements[i]["css"][j]["css"] != "" && rureraform_form_elements[i]["css"][j]["selector"] != "") {
                        if (rureraform_meta[rureraform_form_elements[i]["type"]]["css"]["selectors"].hasOwnProperty(rureraform_form_elements[i]["css"][j]["selector"])) {
                            properties["css-class"] = rureraform_meta[rureraform_form_elements[i]["type"]]["css"]["selectors"][rureraform_form_elements[i]["css"][j]["selector"]]["admin-class"];
                            properties["css-class"] = properties["css-class"].replace(new RegExp("{element-id}", 'g'), i);
                            style += properties["css-class"] + "{" + rureraform_form_elements[i]["css"][j]["css"] + "}";
                        }
                    }
                }
            }
        }
        properties["tooltip-label"] = "";
        properties["tooltip-description"] = "";
        properties["tooltip-input"] = "";
        if (rureraform_form_elements[i].hasOwnProperty("tooltip") && rureraform_form_elements[i]["tooltip"].length > 0) {
            if (rureraform_form_options.hasOwnProperty("tooltip-anchor") && rureraform_form_options["tooltip-anchor"] != "" && rureraform_form_options["tooltip-anchor"] != "none") {
                switch (rureraform_form_options["tooltip-anchor"]) {
                    case 'description':
                        properties["tooltip-description"] = " <span class='rureraform-tooltip-anchor rureraform-if rureraform-if-help-circled' title='" + rureraform_escape_html(rureraform_form_elements[i]["tooltip"]) + "'></span>";
                        break;
                    case 'input':
                        properties["tooltip-input"] = " title='" + rureraform_escape_html(rureraform_form_elements[i]["tooltip"]) + "'";
                        break;
                    default:
                        properties["tooltip-label"] = " <span class='rureraform-tooltip-anchor rureraform-if rureraform-if-help-circled' title='" + rureraform_escape_html(rureraform_form_elements[i]["tooltip"]) + "'></span>";
                        break;
                }
            }
        }
        properties["required-label-left"] = "";
        properties["required-label-right"] = "";
        properties["required-description-left"] = "";
        properties["required-description-right"] = "";
        if (rureraform_form_elements[i].hasOwnProperty("required") && rureraform_form_elements[i]["required"] == "on") {
            if (rureraform_form_options.hasOwnProperty("required-position") && rureraform_form_options["required-position"] != "" && rureraform_form_options["required-position"] != "none" && rureraform_form_options.hasOwnProperty("required-text") && rureraform_form_options["required-text"] != "") {
                switch (rureraform_form_options["required-position"]) {
                    case 'label-left':
                    case 'label-right':
                    case 'description-left':
                    case 'description-right':
                        properties["required-" + rureraform_form_options["required-position"]] = "<span class='rureraform-required-symbol rureraform-required-symbol-" + rureraform_form_options["required-position"] + "'>" + rureraform_escape_html(rureraform_form_options["required-text"]) + "</span>";
                        break;
                    default:
                        break;
                }
            }
        }
        if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[i]["type"])) {
            switch (rureraform_form_elements[i]["type"]) {
                case "button":
                case "link-button":
                    icon = "";
                    if (rureraform_form_elements[i].hasOwnProperty("button-style-size") && rureraform_form_elements[i]['button-style-size'] != "")
                        properties['size'] = rureraform_form_elements[i]['button-style-size'];
                    else
                        properties['size'] = rureraform_form_options['button-style-size'];
                    if (rureraform_form_elements[i].hasOwnProperty("button-style-width") && rureraform_form_elements[i]['button-style-width'] != "")
                        properties['width'] = rureraform_form_elements[i]['button-style-width'];
                    else
                        properties['width'] = rureraform_form_options['button-style-width'];
                    if (rureraform_form_elements[i].hasOwnProperty("button-style-position") && rureraform_form_elements[i]['button-style-position'] != "")
                        properties['position'] = rureraform_form_elements[i]['button-style-position'];
                    else
                        properties['position'] = rureraform_form_options['button-style-position'];
                    label = "<span>" + rureraform_escape_html(rureraform_form_elements[i]["label"]) + "</span>";
                    if (rureraform_form_elements[i].hasOwnProperty("icon-left") && rureraform_form_elements[i]["icon-left"] != "")
                        label = "<i class='rureraform-icon-left " + rureraform_form_elements[i]["icon-left"] + "'></i>" + label;
                    if (rureraform_form_elements[i].hasOwnProperty("icon-right") && rureraform_form_elements[i]["icon-right"] != "")
                        label += "<i class='rureraform-icon-right " + rureraform_form_elements[i]["icon-right"] + "'></i>";

                    properties['style-attr'] = "";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-background") && rureraform_form_elements[i]["colors-background"] != "")
                        properties['style-attr'] += "background-color:" + rureraform_form_elements[i]["colors-background"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-border") && rureraform_form_elements[i]["colors-border"] != "")
                        properties['style-attr'] += "border-color:" + rureraform_form_elements[i]["colors-border"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-text") && rureraform_form_elements[i]["colors-text"] != "")
                        properties['style-attr'] += "color:" + rureraform_form_elements[i]["colors-text"] + ";";
                    if (properties['style-attr'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-button{" + properties['style-attr'] + "}";

                    properties['style-attr'] = "";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-hover-background") && rureraform_form_elements[i]["colors-hover-background"] != "")
                        properties['style-attr'] += "background-color:" + rureraform_form_elements[i]["colors-hover-background"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-hover-border") && rureraform_form_elements[i]["colors-hover-border"] != "")
                        properties['style-attr'] += "border-color:" + rureraform_form_elements[i]["colors-hover-border"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-hover-text") && rureraform_form_elements[i]["colors-hover-text"] != "")
                        properties['style-attr'] += "color:" + rureraform_form_elements[i]["colors-hover-text"] + ";";
                    if (properties['style-attr'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-button:hover{" + properties['style-attr'] + "}";

                    properties['style-attr'] = "";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-active-background") && rureraform_form_elements[i]["colors-active-background"] != "")
                        properties['style-attr'] += "background-color:" + rureraform_form_elements[i]["colors-active-background"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-active-border") && rureraform_form_elements[i]["colors-active-border"] != "")
                        properties['style-attr'] += "border-color:" + rureraform_form_elements[i]["colors-active-border"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-active-text") && rureraform_form_elements[i]["colors-active-text"] != "")
                        properties['style-attr'] += "color:" + rureraform_form_elements[i]["colors-active-text"] + ";";
                    if (properties['style-attr'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-button:active{" + properties['style-attr'] + "}";

                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element rureraform-ta-" + properties['position'] + "' data-type='" + rureraform_form_elements[i]["type"] + "'><a class='rureraform-button rureraform-button-" + rureraform_form_options["button-active-transform"] + " rureraform-button-" + properties['width'] + " rureraform-button-" + properties['size'] + " " + rureraform_form_elements[i]["css-class"] + "' href='#' onclick='return false;'>" + label + "</a><div class='rureraform-element-cover'></div></div>";
                    break;

                case "email":
                case "text":
                    if (rureraform_form_elements[i]['input-style-size'] != "")
                        extra_class += " rureraform-input-" + rureraform_form_elements[i]['input-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + icon + "<input type='text' class='" + (rureraform_form_elements[i]['input-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['input-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "' placeholder='" + rureraform_escape_html(rureraform_form_elements[i]["placeholder"]) + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["default"]) + "' /></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "number":
                    if (rureraform_form_elements[i]['input-style-size'] != "")
                        extra_class += " rureraform-input-" + rureraform_form_elements[i]['input-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + icon + "<input type='text' class='" + (rureraform_form_elements[i]['input-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['input-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "' placeholder='" + rureraform_escape_html(rureraform_form_elements[i]["placeholder"]) + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["number-value3"]) + "' /></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "numspinner":
                    properties['value'] = parseFloat(rureraform_form_elements[i]["number-value2"]).toFixed(rureraform_form_elements[i]["decimal"]);
                    if (rureraform_form_elements[i]['input-style-size'] != "")
                        extra_class += " rureraform-input-" + rureraform_form_elements[i]['input-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input rureraform-icon-left rureraform-icon-right" + extra_class + "'" + properties["tooltip-input"] + "><i class='rureraform-icon-left rureraform-if rureraform-if-minus rureraform-numspinner-minus'></i><i class='rureraform-icon-right rureraform-if rureraform-if-plus rureraform-numspinner-plus'></i><input type='text' class='" + (rureraform_form_elements[i]['input-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['input-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "' placeholder='...' value='" + rureraform_escape_html(properties["value"]) + "' readonly='readonly' /></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "password":
                    if (rureraform_form_elements[i]['input-style-size'] != "")
                        extra_class += " rureraform-input-" + rureraform_form_elements[i]['input-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + icon + "<input type='password' class='" + (rureraform_form_elements[i]['input-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['input-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "' placeholder='" + rureraform_escape_html(rureraform_form_elements[i]["placeholder"]) + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["default"]) + "' /></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "textarea":
                    properties["textarea-height"] = rureraform_form_elements[i]["textarea-style-height"];
                    if (properties["textarea-height"] == "")
                        properties["textarea-height"] = rureraform_form_options["textarea-height"];
                    if (properties["textarea-height"] == "")
                        properties["textarea-height"] = 160;
                    style += "#rureraform-element-" + i + " div.rureraform-input {height:" + properties["textarea-height"] + "px; line-height:2.5;} #rureraform-element-" + i + " div.rureraform-input textarea{line-height:1.4;}";
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties['label-style-position'] != "" ? " rureraform-element-label-" + properties['label-style-position'] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + icon + "<textarea class='" + (rureraform_form_elements[i]['textarea-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['textarea-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "' placeholder='" + rureraform_escape_html(rureraform_form_elements[i]["placeholder"]) + "'>" + rureraform_escape_html(rureraform_form_elements[i]["default"]) + "</textarea></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "signature":
                    properties["height"] = rureraform_form_elements[i]["height"];
                    if (properties["height"] == "")
                        properties["height"] = 120;
                    style += "#rureraform-element-" + i + " div.rureraform-input {height:auto;} #rureraform-element-" + i + " div.rureraform-input div.rureraform-signature-box {height:" + properties["height"] + "px;}";
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties['label-style-position'] != "" ? " rureraform-element-label-" + properties['label-style-position'] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + "><div class='rureraform-signature-box'><canvas class='rureraform-signature'></canvas><span><i class='rureraform-if rureraform-if-eraser'></i></span></div></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "rangeslider":
                    style += "#rureraform-element-" + i + " div.rureraform-input{height:auto;line-height:1;}";
                    options = (rureraform_form_elements[i]["readonly"] == "on" ? "data-from-fixed='true' data-to-fixed='true'" : "") + " " + (rureraform_form_elements[i]["double"] == "on" ? "data-type='double'" : "data-type='single'") + " " + (rureraform_form_elements[i]["grid-enable"] == "on" ? "data-grid='true'" : "data-grid='false'") + " " + (rureraform_form_elements[i]["min-max-labels"] == "on" ? "data-hide-min-max='false'" : "data-hide-min-max='true'") + " data-skin='" + rureraform_form_options['rangeslider-skin'] + "' data-min='" + rureraform_form_elements[i]["range-value1"] + "' data-max='" + rureraform_form_elements[i]["range-value2"] + "' data-step='" + rureraform_form_elements[i]["range-value3"] + "' data-from='" + rureraform_form_elements[i]["handle"] + "' data-to='" + rureraform_form_elements[i]["handle2"] + "' data-prefix='" + rureraform_form_elements[i]["prefix"] + "' data-postfix='" + rureraform_form_elements[i]["postfix"] + "'";
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input rureraform-rangeslider" + extra_class + "'" + properties["tooltip-input"] + "><input type='text' class='rureraform-rangeslider " + rureraform_form_elements[i]["css-class"] + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["default"]) + "' " + options + " /></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "select":
                    options = "";
                    if (rureraform_form_elements[i]["please-select-option"] == "on")
                        options += "<option value=''>" + rureraform_escape_html(rureraform_form_elements[i]["please-select-text"]) + "</option>";
                    for (var j = 0; j < rureraform_form_elements[i]["options"].length; j++) {
                        selected = "";
                        if (rureraform_form_elements[i]["options"][j].hasOwnProperty("default") && rureraform_form_elements[i]["options"][j]["default"] == "on")
                            selected = " selected='selected'";
                        options += "<option value='" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["value"]) + "'" + selected + ">" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["label"]) + "</option>";
                    }
                    if (rureraform_form_elements[i]['input-style-size'] != "")
                        extra_class += " rureraform-input-" + rureraform_form_elements[i]['input-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + "><select class='" + (rureraform_form_elements[i]['input-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['input-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "'>" + options + "</select></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "checkbox":
                    style += "#rureraform-element-" + i + " div.rureraform-input{height:auto;line-height:1;}";
                    properties['checkbox-size'] = rureraform_form_options['checkbox-radio-style-size'];
                    if (rureraform_form_elements[i]['checkbox-style-position'] == "")
                        properties['checkbox-position'] = rureraform_form_options['checkbox-radio-style-position'];
                    else
                        properties['checkbox-position'] = rureraform_form_elements[i]['checkbox-style-position'];
                    if (rureraform_form_elements[i]['checkbox-style-align'] == "")
                        properties['checkbox-align'] = rureraform_form_options['checkbox-radio-style-align'];
                    else
                        properties['checkbox-align'] = rureraform_form_elements[i]['checkbox-style-align'];
                    if (rureraform_form_elements[i]['checkbox-style-layout'] == "")
                        properties['checkbox-layout'] = rureraform_form_options['checkbox-radio-style-layout'];
                    else
                        properties['checkbox-layout'] = rureraform_form_elements[i]['checkbox-style-layout'];
                    extra_class = " rureraform-cr-layout-" + properties['checkbox-layout'] + " rureraform-cr-layout-" + properties['checkbox-align'];

                    for (var j = 0; j < rureraform_form_elements[i]["options"].length; j++) {
                        selected = "";
                        if (rureraform_form_elements[i]["options"][j].hasOwnProperty("default") && rureraform_form_elements[i]["options"][j]["default"] == "on")
                            selected = " checked='checked'";
                        option = "<div class='rureraform-cr-box'><input class='rureraform-checkbox rureraform-checkbox-" + rureraform_form_options["checkbox-view"] + " rureraform-checkbox-" + properties["checkbox-size"] + "' type='checkbox' id='rureraform-checkbox-" + i + "-" + j + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["value"]) + "'" + selected + " /><label for='rureraform-checkbox-" + i + "-" + j + "'></label></div>";
                        if (properties['checkbox-position'] == "left")
                            option += "<div class='rureraform-cr-label rureraform-ta-" + properties['checkbox-align'] + "'><label for='rureraform-checkbox-" + i + "-" + j + "'>" + rureraform_form_elements[i]["options"][j]["label"] + "</label></div>";
                        else
                            option = "<div class='rureraform-cr-label rureraform-ta-" + properties['checkbox-align'] + "'><label for='rureraform-checkbox-" + i + "-" + j + "'>" + rureraform_form_elements[i]["options"][j]["label"] + "</label></div>" + option;
                        options += "<div class='rureraform-cr-container rureraform-cr-container-" + properties["checkbox-size"] + " rureraform-cr-container-" + properties["checkbox-position"] + "'>" + option + "</div>";
                    }
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + options + "</div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "radio":
                    style += "#rureraform-element-" + i + " div.rureraform-input{height:auto;line-height:1;}";
                    properties['radio-size'] = rureraform_form_options['checkbox-radio-style-size'];
                    if (rureraform_form_elements[i]['radio-style-position'] == "")
                        properties['radio-position'] = rureraform_form_options['checkbox-radio-style-position'];
                    else
                        properties['radio-position'] = rureraform_form_elements[i]['radio-style-position'];
                    if (rureraform_form_elements[i]['radio-style-align'] == "")
                        properties['radio-align'] = rureraform_form_options['checkbox-radio-style-align'];
                    else
                        properties['radio-align'] = rureraform_form_elements[i]['radio-style-align'];
                    if (rureraform_form_elements[i]['radio-style-layout'] == "")
                        properties['radio-layout'] = rureraform_form_options['checkbox-radio-style-layout'];
                    else
                        properties['radio-layout'] = rureraform_form_elements[i]['radio-style-layout'];
                    extra_class = " rureraform-cr-layout-" + properties['radio-layout'] + " rureraform-cr-layout-" + properties['radio-align'];

                    for (var j = 0; j < rureraform_form_elements[i]["options"].length; j++) {
                        selected = "";
                        if (rureraform_form_elements[i]["options"][j].hasOwnProperty("default") && rureraform_form_elements[i]["options"][j]["default"] == "on")
                            selected = " checked='checked'";
                        option = "<div class='rureraform-cr-box'><input class='rureraform-radio rureraform-radio-" + rureraform_form_options["radio-view"] + " rureraform-radio-" + properties["radio-size"] + "' type='radio' name='rureraform-radio-" + i + "' id='rureraform-radio-" + i + "-" + j + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["value"]) + "'" + selected + " /><label for='rureraform-radio-" + i + "-" + j + "'></label></div>";
                        if (properties['radio-position'] == "left")
                            option += "<div class='rureraform-cr-label rureraform-ta-" + properties['radio-align'] + "'><label for='rureraform-radio-" + i + "-" + j + "'>" + rureraform_form_elements[i]["options"][j]["label"] + "</label></div>";
                        else
                            option = "<div class='rureraform-cr-label rureraform-ta-" + properties['radio-align'] + "'><label for='rureraform-radio-" + i + "-" + j + "'>" + rureraform_form_elements[i]["options"][j]["label"] + "</label></div>" + option;
                        options += "<div class='rureraform-cr-container rureraform-cr-container-" + properties["radio-size"] + " rureraform-cr-container-" + properties["radio-position"] + "'>" + option + "</div>";
                    }
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + options + "</div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "imageselect":
                    style += "#rureraform-element-" + i + " div.rureraform-input{height:auto;line-height:1;}";

                    properties['image-size'] = rureraform_form_elements[i]['image-style-size'];
                    properties["image-width"] = rureraform_form_elements[i]['image-style-width'];
                    if (!rureraform_is_numeric(properties["image-width"]))
                        properties["image-width"] = 120;
                    properties["image-height"] = rureraform_form_elements[i]['image-style-height'];
                    if (!rureraform_is_numeric(properties["image-height"]))
                        properties["image-height"] = 120;
                    properties["label-height"] = rureraform_form_elements[i]['label-height'];
                    if (!rureraform_is_numeric(properties["label-height"]) || rureraform_form_elements[i]['label-enable'] != "on")
                        properties["label-height"] = 0;
                    properties["image-width"] = parseInt(properties["image-width"], 10);
                    properties["image-height"] = parseInt(properties["image-height"], 10);
                    properties["label-height"] = parseInt(properties["label-height"], 10);

                    if (rureraform_form_options.hasOwnProperty('imageselect-selected-scale') && rureraform_form_options['imageselect-selected-scale'] == "on") {
                        var scale = 1.10;
                        if (properties["image-width"] > 0 && properties["image-height"] > 0)
                            scale = Math.min(parseFloat((properties["image-width"] + 8) / properties["image-width"]), parseFloat((properties["image-height"] + 8) / properties["image-height"]));
                        style += "#rureraform-element-" + i + " div.rureraform-input .rureraform-imageselect:checked+label {transform: scale(" + scale + ");}";
                    }
                    extra_class += ' rureraform-ta-' + rureraform_form_options['imageselect-style-align'] + ' rureraform-imageselect-' + rureraform_form_options['imageselect-style-effect'];
                    style += "#rureraform-element-" + i + " div.rureraform-input .rureraform-imageselect+label {width:" + properties["image-width"] + "px;height:" + parseInt(properties["image-height"] + properties["label-height"], 10) + "px;}";
                    style += "#rureraform-element-" + i + " div.rureraform-input .rureraform-imageselect+label span.rureraform-imageselect-image {height:" + properties["image-height"] + "px;background-size:" + properties['image-size'] + ";}";
                    for (var j = 0; j < rureraform_form_elements[i]["options"].length; j++) {
                        selected = "";
                        if (rureraform_form_elements[i]["options"][j].hasOwnProperty("default") && rureraform_form_elements[i]["options"][j]["default"] == "on")
                            selected = " checked='checked'";
                        properties['image-label'] = "";
                        if (properties["label-height"] > 0) {
                            properties['image-label'] = "<span class='rureraform-imageselect-label'>" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["label"]) + "</span>";
                        }
                        options += "<input class='rureraform-imageselect' type='" + rureraform_form_elements[i]['mode'] + "' name='rureraform-image-" + i + "' id='rureraform-image-" + i + "-" + j + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["value"]) + "'" + selected + " /><label for='rureraform-image-" + i + "-" + j + "'><span class='rureraform-imageselect-image' style='background-image: url(" + rureraform_form_elements[i]["options"][j]["image"] + ");'></span>" + properties['image-label'] + "</label>";
                    }

                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + options + "</div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "tile":
                    style += "#rureraform-element-" + i + " div.rureraform-input{height:auto;line-height:1;}";
                    if (rureraform_form_elements[i].hasOwnProperty("tile-style-size") && rureraform_form_elements[i]['tile-style-size'] != "")
                        properties['size'] = rureraform_form_elements[i]['tile-style-size'];
                    else
                        properties['size'] = rureraform_form_options['tile-style-size'];
                    if (rureraform_form_elements[i].hasOwnProperty("tile-style-width") && rureraform_form_elements[i]['tile-style-width'] != "")
                        properties['width'] = rureraform_form_elements[i]['tile-style-width'];
                    else
                        properties['width'] = rureraform_form_options['tile-style-width'];
                    if (rureraform_form_elements[i].hasOwnProperty("tile-style-position") && rureraform_form_elements[i]['tile-style-position'] != "")
                        properties['position'] = rureraform_form_elements[i]['tile-style-position'];
                    else
                        properties['position'] = rureraform_form_options['tile-style-position'];
                    if (rureraform_form_elements[i].hasOwnProperty("tile-style-layout") && rureraform_form_elements[i]['tile-style-layout'] != "")
                        properties['layout'] = rureraform_form_elements[i]['tile-style-layout'];
                    else
                        properties['layout'] = rureraform_form_options['tile-style-layout'];
                    extra_class = " rureraform-tile-layout-" + properties['layout'] + " rureraform-tile-layout-" + properties['position'] + " rureraform-tile-transform-" + rureraform_form_options['tile-selected-transform'];

                    for (var j = 0; j < rureraform_form_elements[i]["options"].length; j++) {
                        selected = "";
                        if (rureraform_form_elements[i]["options"][j].hasOwnProperty("default") && rureraform_form_elements[i]["options"][j]["default"] == "on")
                            selected = " checked='checked'";
                        option = "<div class='rureraform-tile-box'><input class='rureraform-tile rureraform-tile-" + properties["size"] + "' type='" + rureraform_form_elements[i]['mode'] + "' name='rureraform-tile-" + i + "' id='rureraform-tile-" + i + "-" + j + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["value"]) + "'" + selected + " /><label for='rureraform-tile-" + i + "-" + j + "'>" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["label"]) + "</label></div>";
                        options += "<div class='rureraform-tile-container rureraform-tile-" + properties["width"] + "'>" + option + "</div>";
                    }
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + options + "</div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "multiselect":
                    style += "#rureraform-element-" + i + " div.rureraform-input{height:auto;line-height:1;}";
                    if (rureraform_form_elements[i]['multiselect-style-height'] != "")
                        style += "#rureraform-element-" + i + " div.rureraform-multiselect {height:" + parseInt(rureraform_form_elements[i]['multiselect-style-height'], 10) + "px;}";
                    if (rureraform_form_elements[i]['multiselect-style-align'] != "")
                        properties['align'] = rureraform_form_elements[i]['multiselect-style-align'];
                    else if (rureraform_form_options['multiselect-style-align'] != "")
                        properties['align'] = rureraform_form_options['multiselect-style-align'];
                    else
                        properties['align'] = 'left';

                    for (var j = 0; j < rureraform_form_elements[i]["options"].length; j++) {
                        selected = "";
                        if (rureraform_form_elements[i]["options"][j].hasOwnProperty("default") && rureraform_form_elements[i]["options"][j]["default"] == "on")
                            selected = " checked='checked'";
                        options += "<input type='checkbox' id='rureraform-checkbox-" + i + "-" + j + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["value"]) + "'" + selected + " /><label for='rureraform-checkbox-" + i + "-" + j + "'>" + rureraform_escape_html(rureraform_form_elements[i]["options"][j]["label"]) + "</label>";
                    }
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input'" + properties["tooltip-input"] + "><div class='rureraform-multiselect rureraform-ta-" + properties["align"] + "'>" + options + "</div></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "file":
                    icon = "";
                    if (rureraform_form_elements[i].hasOwnProperty("button-style-size") && rureraform_form_elements[i]['button-style-size'] != "")
                        properties['size'] = rureraform_form_elements[i]['button-style-size'];
                    else
                        properties['size'] = rureraform_form_options['button-style-size'];
                    if (rureraform_form_elements[i].hasOwnProperty("button-style-width") && rureraform_form_elements[i]['button-style-width'] != "")
                        properties['width'] = rureraform_form_elements[i]['button-style-width'];
                    else
                        properties['width'] = rureraform_form_options['button-style-width'];
                    if (rureraform_form_elements[i].hasOwnProperty("button-style-position") && rureraform_form_elements[i]['button-style-position'] != "")
                        properties['position'] = rureraform_form_elements[i]['button-style-position'];
                    else
                        properties['position'] = rureraform_form_options['button-style-position'];
                    label = "<span>" + rureraform_escape_html(rureraform_form_elements[i]["button-label"]) + "</span>";
                    if (rureraform_form_elements[i].hasOwnProperty("icon-left") && rureraform_form_elements[i]["icon-left"] != "")
                        label = "<i class='rureraform-icon-left " + rureraform_form_elements[i]["icon-left"] + "'></i>" + label;
                    if (rureraform_form_elements[i].hasOwnProperty("icon-right") && rureraform_form_elements[i]["icon-right"] != "")
                        label += "<i class='rureraform-icon-right " + rureraform_form_elements[i]["icon-right"] + "'></i>";

                    properties['style-attr'] = "";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-background") && rureraform_form_elements[i]["colors-background"] != "")
                        properties['style-attr'] += "background-color:" + rureraform_form_elements[i]["colors-background"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-border") && rureraform_form_elements[i]["colors-border"] != "")
                        properties['style-attr'] += "border-color:" + rureraform_form_elements[i]["colors-border"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-text") && rureraform_form_elements[i]["colors-text"] != "")
                        properties['style-attr'] += "color:" + rureraform_form_elements[i]["colors-text"] + ";";
                    if (properties['style-attr'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-button{" + properties['style-attr'] + "}";

                    properties['style-attr'] = "";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-hover-background") && rureraform_form_elements[i]["colors-hover-background"] != "")
                        properties['style-attr'] += "background-color:" + rureraform_form_elements[i]["colors-hover-background"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-hover-border") && rureraform_form_elements[i]["colors-hover-border"] != "")
                        properties['style-attr'] += "border-color:" + rureraform_form_elements[i]["colors-hover-border"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-hover-text") && rureraform_form_elements[i]["colors-hover-text"] != "")
                        properties['style-attr'] += "color:" + rureraform_form_elements[i]["colors-hover-text"] + ";";
                    if (properties['style-attr'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-button:hover{" + properties['style-attr'] + "}";

                    properties['style-attr'] = "";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-active-background") && rureraform_form_elements[i]["colors-active-background"] != "")
                        properties['style-attr'] += "background-color:" + rureraform_form_elements[i]["colors-active-background"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-active-border") && rureraform_form_elements[i]["colors-active-border"] != "")
                        properties['style-attr'] += "border-color:" + rureraform_form_elements[i]["colors-active-border"] + ";";
                    if (rureraform_form_elements[i].hasOwnProperty("colors-active-text") && rureraform_form_elements[i]["colors-active-text"] != "")
                        properties['style-attr'] += "color:" + rureraform_form_elements[i]["colors-active-text"] + ";";
                    if (properties['style-attr'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-button:active{" + properties['style-attr'] + "}";

                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-upload-input rureraform-ta-" + properties['position'] + extra_class + "'" + properties["tooltip-input"] + "><a class='rureraform-button rureraform-button-" + rureraform_form_options["button-active-transform"] + " rureraform-button-" + properties['width'] + " rureraform-button-" + properties['size'] + " " + rureraform_form_elements[i]["css-class"] + "' href='#' onclick='return false;'>" + label + "</a></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "date":
                    if (rureraform_form_elements[i]['input-style-size'] != "")
                        extra_class += " rureraform-input-" + rureraform_form_elements[i]['input-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + icon + "<input type='text' class='rureraform-date " + (rureraform_form_elements[i]['input-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['input-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "' placeholder='" + rureraform_escape_html(rureraform_form_elements[i]["placeholder"]) + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["default-date"]) + "' /></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "time":
                    if (rureraform_form_elements[i]['input-style-size'] != "")
                        extra_class += " rureraform-input-" + rureraform_form_elements[i]['input-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input" + extra_class + "'" + properties["tooltip-input"] + ">" + icon + "<input type='text' class='rureraform-time " + (rureraform_form_elements[i]['input-style-align'] != "" ? "rureraform-ta-" + rureraform_form_elements[i]['input-style-align'] + " " : "") + rureraform_form_elements[i]["css-class"] + "' placeholder='" + rureraform_escape_html(rureraform_form_elements[i]["placeholder"]) + "' value='" + rureraform_escape_html(rureraform_form_elements[i]["default"]) + "' /></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "star-rating":
                    style += "#rureraform-element-" + i + " div.rureraform-input{height:auto;line-height:1;}";
                    if (rureraform_form_elements[i]['star-style-color-unrated'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-star-rating>label{color:" + rureraform_form_elements[i]['star-style-color-unrated'] + " !important;}";
                    if (rureraform_form_elements[i]['star-style-color-rated'] != "")
                        style += "#rureraform-element-" + i + " .rureraform-star-rating>input:checked~label, #rureraform-element-" + i + " .rureraform-star-rating:not(:checked)>label:hover, #rureraform-element-" + i + " .rureraform-star-rating:not(:checked)>label:hover~label{color:" + rureraform_form_elements[i]['star-style-color-rated'] + " !important;}";
                    options = "";
                    for (var j = rureraform_form_elements[i]['total-stars']; j > 0; j--) {
                        options += "<input type='radio' id='rureraform-stars-" + i + "-" + j + "' name='rureraform-stars-" + i + "' value='" + j + "'" + (rureraform_form_elements[i]['default'] == j ? " checked='checked'" : "") + " /><label for='rureraform-stars-" + i + "-" + j + "'></label>";
                    }
                    extra_class = "";
                    if (rureraform_form_elements[i]['star-style-size'] != "")
                        extra_class += " rureraform-star-rating-" + rureraform_form_elements[i]['star-style-size'];
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element" + (properties["label-style-position"] != "" ? " rureraform-element-label-" + properties["label-style-position"] : "") + (rureraform_form_elements[i]['description-style-position'] != "" ? " rureraform-element-description-" + rureraform_form_elements[i]['description-style-position'] : "") + "' data-type='" + rureraform_form_elements[i]["type"] + "'><div class='rureraform-column-label" + column_label_class + "'><label class='rureraform-label" + (rureraform_form_elements[i]['label-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['label-style-align'] : "") + "'>" + properties["required-label-left"] + rureraform_escape_html(rureraform_form_elements[i]["label"]) + properties["required-label-right"] + properties["tooltip-label"] + "</label></div><div class='rureraform-column-input" + column_input_class + "'><div class='rureraform-input rureraform-ta-" + rureraform_form_elements[i]['star-style-position'] + "'" + properties["tooltip-input"] + "><fieldset class='rureraform-star-rating" + extra_class + "'>" + options + "</fieldset></div><label class='rureraform-description" + (rureraform_form_elements[i]['description-style-align'] != "" ? " rureraform-ta-" + rureraform_form_elements[i]['description-style-align'] : "") + "'>" + properties["required-description-left"] + rureraform_escape_html(rureraform_form_elements[i]["description"]) + properties["required-description-right"] + properties["tooltip-description"] + "</label></div><div class='rureraform-element-cover'></div></div>";
                    break;

                case "html":
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element quiz-group rureraform-element-html' data-type='" + rureraform_form_elements[i]["type"] + "'>" + rureraform_form_elements[i]["content"] + "<div class='rureraform-element-cover'></div></div>";
                    break;
                    
                case "sum_quiz":
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element quiz-group rureraform-element-html' data-type='" + rureraform_form_elements[i]["type"] + "'>" + rureraform_form_elements[i]["content"] + "<div class='rureraform-element-cover'></div></div>";
                    break;
                    
                case "sqroot_quiz":
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-element quiz-group rureraform-element-html' data-type='" + rureraform_form_elements[i]["type"] + "'>" + rureraform_form_elements[i]["content"] + "<div class='rureraform-element-cover'></div></div>";
                    break;

                case "columns":
                    options = "";
                    for (var j = 0; j < rureraform_form_elements[i]['_cols']; j++) {
                        properties = _rureraform_build_children(rureraform_form_elements[i]['id'], j);
                        style += properties["style"];
                        options += "<div class='rureraform-col rureraform-col-" + rureraform_form_elements[i]["widths-" + j] + "'><div class='rureraform-elements' _data-parent='" + rureraform_form_elements[i]['id'] + "' _data-parent-col='" + j + "'>" + properties["html"] + "</div></div>";
                    }
                    html += "<div id='rureraform-element-" + i + "' class='rureraform-element-" + i + " rureraform-row rureraform-element' data-type='" + rureraform_form_elements[i]["type"] + "'>" + options + "</div>";
                    break;

                default:
                    break;
            }
        }
    }
    return {"html": html, "style": style};
}

function rureraform_build_style_text(_properties, _key) {
    var style = "", webfont = "";
    var integer;
    if (_properties.hasOwnProperty(_key + "-family") && _properties[_key + "-family"] != "") {
        style += "font-family:'" + _properties[_key + "-family"] + "','arial';";
        if (rureraform_localfonts.indexOf(_properties[_key + "-family"]) == -1 && rureraform_customfonts.indexOf(_properties[_key + "-family"]) == -1)
            webfont = _properties[_key + "-family"];
    }
    if (_properties.hasOwnProperty(_key + "-size")) {
        integer = parseInt(_properties[_key + "-size"], 10);
        if (integer >= 8 && integer <= 64)
            style += "font-size:" + integer + "px;";
    }
    if (_properties.hasOwnProperty(_key + "-color") && _properties[_key + "-color"] != "")
        style += "color:" + _properties[_key + "-color"] + ";";
    if (_properties.hasOwnProperty(_key + "-bold") && _properties[_key + "-bold"] == "on")
        style += "font-weight:bold;";
    else
        style += "font-weight:normal;";
    if (_properties.hasOwnProperty(_key + "-italic") && _properties[_key + "-italic"] == "on")
        style += "font-style:italic;";
    else
        style += "font-style:normal;";
    if (_properties.hasOwnProperty(_key + "-underline") && _properties[_key + "-underline"] == "on")
        style += "text-decoration:underline;";
    else
        style += "text-decoration:none;";
    if (_properties.hasOwnProperty(_key + "-align") && _properties[_key + "-align"] != "")
        style += "text-align:" + _properties[_key + "-align"] + ";";
    return {"style": style, "webfont": webfont};
}
function rureraform_build_style_background(_properties, _key) {
    var style = "";
    var integer, hposition = "left", vposition = "top";
    var direction = "to bottom", color1 = "transparent", color2 = "transparent";
    if (_properties.hasOwnProperty(_key + "-color") && _properties[_key + "-color"] != "")
        color1 = _properties[_key + "-color"];

    if (_properties.hasOwnProperty(_key + "-gradient") && _properties[_key + "-gradient"] == "2shades") {
        style += "background-color:" + color1 + "; background-image:linear-gradient(to bottom,rgba(255,255,255,.05) 0,rgba(255,255,255,.05) 50%,rgba(0,0,0,.05) 51%,rgba(0,0,0,.05) 100%);";
    } else if (_properties.hasOwnProperty(_key + "-gradient") && (_properties[_key + "-gradient"] == "horizontal" || _properties[_key + "-gradient"] == "vertical" || _properties[_key + "-gradient"] == "diagonal")) {
        if (_properties.hasOwnProperty(_key + "-color2") && _properties[_key + "-color2"] != "")
            color2 = _properties[_key + "-color2"];
        if (_properties[_key + "-gradient"] == "horizontal")
            direction = "to right";
        else if (_properties[_key + "-gradient"] == "diagonal")
            direction = "to bottom right";
        style += "background-image:linear-gradient(" + direction + "," + color1 + "," + color2 + ");";
    } else if (_properties.hasOwnProperty(_key + "-image") && _properties[_key + "-image"] != "") {
        style += "background-color:" + color1 + "; background-image:url('" + _properties[_key + "-image"] + "');";
        if (_properties.hasOwnProperty(_key + "-size") && _properties[_key + "-size"] != "")
            style += "background-size:" + _properties[_key + "-size"] + ";";
        if (_properties.hasOwnProperty(_key + "-repeat") && _properties[_key + "-repeat"] != "")
            style += "background-repeat:" + _properties[_key + "-repeat"] + ";";
        if (_properties.hasOwnProperty(_key + "-horizontal-position") && _properties[_key + "-horizontal-position"] != "") {
            switch (_properties[_key + "-horizontal-position"]) {
                case 'center':
                    hposition = "center";
                    break;
                case 'right':
                    hposition = "right";
                    break;
                default:
                    hposition = "left";
                    break;
            }
        }
        if (_properties.hasOwnProperty(_key + "-vertical-position") && _properties[_key + "-vertical-position"] != "") {
            switch (_properties[_key + "-vertical-position"]) {
                case 'center':
                    vposition = "center";
                    break;
                case 'bottom':
                    vposition = "bottom";
                    break;
                default:
                    vposition = "top";
                    break;
            }
        }
        style += "background-position: " + hposition + " " + vposition + ";";
    } else
        style += "background-color:" + color1 + "; background-image:none;";
    return style;
}
function rureraform_build_style_border(_properties, _key) {
    var style = "";
    var integer;
    if (_properties.hasOwnProperty(_key + "-width")) {
        integer = parseInt(_properties[_key + "-width"], 10);
        if (integer >= 0 && integer <= 16)
            style += "border-width:" + integer + "px;";
    }
    if (_properties.hasOwnProperty(_key + "-style") && _properties[_key + "-style"] != "")
        style += "border-style:" + _properties[_key + "-style"] + ";";
    if (_properties.hasOwnProperty(_key + "-color") && _properties[_key + "-color"] != "")
        style += "border-color:" + _properties[_key + "-color"] + ";";
    if (_properties.hasOwnProperty(_key + "-radius")) {
        integer = parseInt(_properties[_key + "-radius"], 10);
        if (integer >= 0 && integer <= 100)
            style += "border-radius:" + integer + "px;";
    }
    if (_properties.hasOwnProperty(_key + "-top") && _properties[_key + "-top"] != "on")
        style += "border-top:none !important;";
    if (_properties.hasOwnProperty(_key + "-left") && _properties[_key + "-left"] != "on")
        style += "border-left:none !important;";
    if (_properties.hasOwnProperty(_key + "-right") && _properties[_key + "-right"] != "on")
        style += "border-right:none !important;";
    if (_properties.hasOwnProperty(_key + "-bottom") && _properties[_key + "-bottom"] != "on")
        style += "border-bottom:none !important;";
    return style;
}
function rureraform_build_shadow(_properties, _key) {
    var style = "box-shadow:none;";
    var color = "transparent";
    var shadow_style = "regular";
    if (_properties.hasOwnProperty(_key + "-size") && _properties[_key + "-size"] != "") {
        if (_properties.hasOwnProperty(_key + "-color") && _properties[_key + "-color"] != "")
            color = _properties[_key + "-color"];
        if (_properties.hasOwnProperty(_key + "-style") && _properties[_key + "-style"] != "")
            shadow_style = _properties[_key + "-style"];
        switch (shadow_style) {
            case 'solid':
                if (_properties[_key + "-size"] == "tiny")
                    style = "box-shadow: 1px 1px 0px 0px " + color + ";";
                else if (_properties[_key + "-size"] == "small")
                    style = "box-shadow: 2px 2px 0px 0px " + color + ";";
                else if (_properties[_key + "-size"] == "medium")
                    style = "box-shadow: 4px 4px 0px 0px " + color + ";";
                else if (_properties[_key + "-size"] == "large")
                    style = "box-shadow: 6px 6px 0px 0px " + color + ";";
                else if (_properties[_key + "-size"] == "huge")
                    style = "box-shadow: 8px 8px 0px 0px " + color + ";";
                break;
            case 'inset':
                if (_properties[_key + "-size"] == "tiny")
                    style = "box-shadow: inset 0px 0px 15px -9px " + color + ";";
                else if (_properties[_key + "-size"] == "small")
                    style = "box-shadow: inset 0px 0px 15px -8px " + color + ";";
                else if (_properties[_key + "-size"] == "medium")
                    style = "box-shadow: inset 0px 0px 15px -7px " + color + ";";
                else if (_properties[_key + "-size"] == "large")
                    style = "box-shadow: inset 0px 0px 15px -6px " + color + ";";
                else if (_properties[_key + "-size"] == "huge")
                    style = "box-shadow: inset 0px 0px 15px -5px " + color + ";";
                break;
            default:
                if (_properties[_key + "-size"] == "tiny")
                    style = "box-shadow: 1px 1px 15px -9px " + color + ";";
                else if (_properties[_key + "-size"] == "small")
                    style = "box-shadow: 1px 1px 15px -8px " + color + ";";
                else if (_properties[_key + "-size"] == "medium")
                    style = "box-shadow: 1px 1px 15px -7px " + color + ";";
                else if (_properties[_key + "-size"] == "large")
                    style = "box-shadow: 1px 1px 15px -6px " + color + ";";
                else if (_properties[_key + "-size"] == "huge")
                    style = "box-shadow: 1px 1px 15px -5px " + color + ";";
                break;
        }
    }
    return style;
}
function rureraform_build_style_padding(_properties, _key) {
    var style = "";
    var integer;
    if (_properties.hasOwnProperty(_key + "-top")) {
        integer = parseInt(_properties[_key + "-top"], 10);
        if (integer >= 0 && integer <= 300)
            style += "padding-top:" + integer + "px;";
    }
    if (_properties.hasOwnProperty(_key + "-right")) {
        integer = parseInt(_properties[_key + "-right"], 10);
        if (integer >= 0 && integer <= 300)
            style += "padding-right:" + integer + "px;";
    }
    if (_properties.hasOwnProperty(_key + "-bottom")) {
        integer = parseInt(_properties[_key + "-bottom"], 10);
        if (integer >= 0 && integer <= 300)
            style += "padding-bottom:" + integer + "px;";
    }
    if (_properties.hasOwnProperty(_key + "-left")) {
        integer = parseInt(_properties[_key + "-left"], 10);
        if (integer >= 0 && integer <= 300)
            style += "padding-left:" + integer + "px;";
    }
    return style;
}

function rureraform_build_progress() {
    var html = "";
    jQuery(".rureraform-progress").remove();
    if (rureraform_form_options["progress-enable"] != "on")
        return;
    var pages = ".rureraform-pages-bar-item";
    if (rureraform_form_options["progress-confirmation-enable"] == "on")
        pages += ",.rureraform-pages-bar-item-confirmation";
    var total_pages = jQuery(pages).length;
    var idx = 0;
    jQuery(pages).each(function () {
        var page_id = jQuery(this).attr("data-id");
        var page_name = jQuery(this).attr("data-name");
        if (rureraform_form_options["progress-type"] == 'progress-2') {
            html = "<div class='rureraform-progress rureraform-progress-" + rureraform_form_options["progress-position"] + "' id='rureraform-progress-" + page_id + "'><ul class='rureraform-progress-t2" + (rureraform_form_options["progress-striped"] == "on" ? " rureraform-progress-stripes" : "") + "'>";
            var i = 0;
            jQuery(pages).each(function () {
                var page_name = jQuery(this).attr("data-name");
                html += "<li" + (i < idx ? " class='rureraform-progress-t2-passed'" : (i == idx ? " class='rureraform-progress-t2-active'" : "")) + " style='width:" + (Math.floor(10000 / total_pages) / 100) + "%;'><span>" + (i + 1) + "</span>" + (rureraform_form_options["progress-label-enable"] == "on" ? "<label>" + rureraform_escape_html(page_name) + "</label>" : "") + "</li>";
                i++;
            });
            html += "</ul></div>";
        } else {
            var width = parseInt(Math.round(100 * (idx + 1) / total_pages), 10);
            html = "<div class='rureraform-progress rureraform-progress-" + rureraform_form_options["progress-position"] + "' id='rureraform-progress-" + page_id + "'><div class='rureraform-progress-t1" + (rureraform_form_options["progress-striped"] == "on" ? " rureraform-progress-stripes" : "") + "'><div><div style='width:" + width + "%'>" + width + "%</div></div>" + (rureraform_form_options["progress-label-enable"] == "on" ? "<label>" + rureraform_escape_html(page_name) + "</label>" : "") + "</div></div>";
        }
        if (rureraform_form_options["progress-position"] == "outside") {
            jQuery(".rureraform-builder").prepend(html);
        } else {
            jQuery("#rureraform-form-" + page_id).prepend(html);
        }
        idx++;
    });

    if (rureraform_form_options["progress-position"] == "outside") {
        if (rureraform_form_page_active != null) {
            jQuery("#rureraform-progress-" + rureraform_form_page_active).show();
        }
    }
    return;
}

function rureraform_build() {
    var adminbar_height;
    if (jQuery("#wpadminbar").length > 0)
        adminbar_height = parseInt(jQuery("#wpadminbar").height(), 10);
    else
        adminbar_height = 0;
    var text_style, style_attr, style = "";
    var webfonts = new Array();
    jQuery(".rureraform-form").html("");
    jQuery(".rureraform-form").attr("class", jQuery(".rureraform-form").attr("class").replace(/\brureraform-form-input-[a-z]+\b/g, ""));
    jQuery(".rureraform-form").addClass("rureraform-form-input-" + rureraform_form_options["input-size"]);
    jQuery(".rureraform-form").attr("class", jQuery(".rureraform-form").attr("class").replace(/\brureraform-form-icon-[a-z]+\b/g, ""));
    jQuery(".rureraform-form").addClass("rureraform-form-icon-" + rureraform_form_options["input-icon-position"]);
    jQuery(".rureraform-form").attr("class", jQuery(".rureraform-form").attr("class").replace(/\brureraform-form-description-[a-z]+\b/g, ""));
    jQuery(".rureraform-form").addClass("rureraform-form-description-" + rureraform_form_options["description-style-position"]);

    if (rureraform_form_options["progress-enable"] == "on") {
        if (rureraform_form_options["progress-type"] == 'progress-2') {
            if (rureraform_form_options.hasOwnProperty("progress-color-color1") && rureraform_form_options['progress-color-color1'] != "")
                style += "ul.rureraform-progress-t2,ul.rureraform-progress-t2>li>span{background-color:" + rureraform_form_options['progress-color-color1'] + ";}ul.rureraform-progress-t2>li>label{color:" + rureraform_form_options['progress-color-color1'] + ";}";
            if (rureraform_form_options.hasOwnProperty("progress-color-color2") && rureraform_form_options['progress-color-color2'] != "")
                style += "ul.rureraform-progress-t2>li.rureraform-progress-t2-active>span,ul.rureraform-progress-t2>li.rureraform-progress-t2-passed>span{background-color:" + rureraform_form_options['progress-color-color2'] + ";}";
            if (rureraform_form_options.hasOwnProperty("progress-color-color3") && rureraform_form_options['progress-color-color3'] != "")
                style += "ul.rureraform-progress-t2>li>span{color:" + rureraform_form_options['progress-color-color3'] + ";}";
            if (rureraform_form_options.hasOwnProperty("progress-color-color4") && rureraform_form_options['progress-color-color4'] != "")
                style += "ul.rureraform-progress-t2>li.rureraform-progress-t2-active>label{color:" + rureraform_form_options['progress-color-color4'] + ";}";
        } else {
            if (rureraform_form_options.hasOwnProperty("progress-color-color1") && rureraform_form_options['progress-color-color1'] != "")
                style += "div.rureraform-progress-t1>div{background-color:" + rureraform_form_options['progress-color-color1'] + ";}";
            if (rureraform_form_options.hasOwnProperty("progress-color-color2") && rureraform_form_options['progress-color-color2'] != "")
                style += "div.rureraform-progress-t1>div>div{background-color:" + rureraform_form_options['progress-color-color2'] + ";}";
            if (rureraform_form_options.hasOwnProperty("progress-color-color3") && rureraform_form_options['progress-color-color3'] != "")
                style += "div.rureraform-progress-t1>div>div{color:" + rureraform_form_options['progress-color-color3'] + ";}";
            if (rureraform_form_options.hasOwnProperty("progress-color-color4") && rureraform_form_options['progress-color-color4'] != "")
                style += "div.rureraform-progress-t1>label{color:" + rureraform_form_options['progress-color-color4'] + ";}";
        }
        style += ".rureraform-progress{max-width:" + rureraform_form_options["max-width-value"] + rureraform_form_options["max-width-unit"] + ";}";
    }

    text_style = rureraform_build_style_text(rureraform_form_options, "text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style_attr = text_style["style"];
    style += ".rureraform-form *, .rureraform-progress {" + style_attr + "}";
    style_attr += rureraform_build_style_background(rureraform_form_options, "inline-background-style");
    style_attr += rureraform_build_style_border(rureraform_form_options, "inline-border-style");
    style_attr += rureraform_build_shadow(rureraform_form_options, "inline-shadow");
    style_attr += rureraform_build_style_padding(rureraform_form_options, "inline-padding");
    style_attr += "max-width:" + rureraform_form_options["max-width-value"] + rureraform_form_options["max-width-unit"] + ";";
    style += ".rureraform-form{" + style_attr + "}";

    text_style = rureraform_build_style_text(rureraform_form_options, "label-text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style_attr = text_style["style"];
    style += ".rureraform-element label.rureraform-label, .rureraform-element label.rureraform-label .rureraform-required-symbol {" + style_attr + "}";
    text_style = rureraform_build_style_text(rureraform_form_options, "description-text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style_attr = text_style["style"];
    style += ".rureraform-element label.rureraform-description, .rureraform-element label.rureraform-description .rureraform-required-symbol{" + style_attr + "}";

    text_style = rureraform_build_style_text(rureraform_form_options, "required-text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style_attr = text_style["style"];
    style += ".rureraform-element label.rureraform-label span.rureraform-required-symbol, .rureraform-element label.rureraform-description span.rureraform-required-symbol {" + style_attr + "}";

    text_style = rureraform_build_style_text(rureraform_form_options, "input-text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style_attr = text_style["style"];
    style += ".rureraform-element div.rureraform-input div.rureraform-signature-box span i{" + style_attr + "}";
    style_attr += rureraform_build_style_background(rureraform_form_options, "input-background-style");
    style_attr += rureraform_build_style_border(rureraform_form_options, "input-border-style");
    style_attr += rureraform_build_shadow(rureraform_form_options, "input-shadow");
    style += ".rureraform-element div.rureraform-input div.rureraform-signature-box,.rureraform-element div.rureraform-input div.rureraform-signature-box,.rureraform-element div.rureraform-input div.rureraform-multiselect,.rureraform-element div.rureraform-input input[type='text'],.rureraform-element div.rureraform-input input[type='email'],.rureraform-element div.rureraform-input input[type='password'],.rureraform-element div.rureraform-input select,.rureraform-element div.rureraform-input select option,.rureraform-element div.rureraform-input textarea{" + style_attr + "}";
    style += ".rureraform-element div.rureraform-input ::placeholder{color:" + rureraform_form_options['input-text-style-color'] + "; opacity: 0.9;}";
    style += ".rureraform-element div.rureraform-input div.rureraform-multiselect::-webkit-scrollbar-thumb{background-color:" + rureraform_form_options["input-border-style-color"] + ";}"
    if (rureraform_form_options["input-hover-inherit"] == "off") {
        text_style = rureraform_build_style_text(rureraform_form_options, "input-hover-text-style");
        if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
            webfonts.push(text_style["webfont"]);
        style_attr = text_style["style"];
        style_attr += rureraform_build_style_background(rureraform_form_options, "input-hover-background-style");
        style_attr += rureraform_build_style_border(rureraform_form_options, "input-hover-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "input-hover-shadow");
        style += ".rureraform-element div.rureraform-input input[type='text']:hover,.rureraform-element div.rureraform-input input[type='email']:hover,.rureraform-element div.rureraform-input input[type='password']:hover,.rureraform-element div.rureraform-input select:hover,.rureraform-element div.rureraform-input select:hover option,.rureraform-element div.rureraform-input textarea:hover{" + style_attr + "}";
    }
    if (rureraform_form_options["input-focus-inherit"] == "off") {
        text_style = rureraform_build_style_text(rureraform_form_options, "input-focus-text-style");
        if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
            webfonts.push(text_style["webfont"]);
        style_attr = text_style["style"];
        style_attr += rureraform_build_style_background(rureraform_form_options, "input-focus-background-style");
        style_attr += rureraform_build_style_border(rureraform_form_options, "input-focus-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "input-focus-shadow");
        style += ".rureraform-element div.rureraform-input input[type='text']:focus,.rureraform-element div.rureraform-input input[type='email']:focus,.rureraform-element div.rureraform-input input[type='password']:focus,.rureraform-element div.rureraform-input select:focus,.rureraform-element div.rureraform-input select:focus option,.rureraform-element div.rureraform-input textarea:focus{" + style_attr + "}";
    }

    style_attr = rureraform_build_style_border(rureraform_form_options, "imageselect-border-style");
    style_attr += rureraform_build_shadow(rureraform_form_options, "imageselect-shadow");
    style += ".rureraform-element div.rureraform-input .rureraform-imageselect+label{" + style_attr + "}";
    if (rureraform_form_options["imageselect-hover-inherit"] == "off") {
        style_attr = rureraform_build_style_border(rureraform_form_options, "imageselect-hover-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "imageselect-hover-shadow");
        style += ".rureraform-element div.rureraform-input .rureraform-imageselect+label:hover{" + style_attr + "}";
    }
    if (rureraform_form_options["imageselect-selected-inherit"] == "off") {
        style_attr = rureraform_build_style_border(rureraform_form_options, "imageselect-selected-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "imageselect-selected-shadow");
        style += ".rureraform-element div.rureraform-input .rureraform-imageselect:checked+label{" + style_attr + "}";
    }
    text_style = rureraform_build_style_text(rureraform_form_options, "imageselect-text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style += ".rureraform-element div.rureraform-input .rureraform-imageselect+label span.rureraform-imageselect-label{" + text_style["style"] + "}";

    style_attr = "";
    if (rureraform_form_options["input-icon-size"] != "") {
        style_attr += "font-size:" + rureraform_form_options["input-icon-size"] + "px;";
    }
    if (rureraform_form_options["input-icon-color"] != "") {
        style_attr += "color:" + rureraform_form_options["input-icon-color"] + ";";
    }
    if (rureraform_form_options["input-icon-position"] != "outside") {
        if (rureraform_form_options["input-icon-background"] != "") {
            style_attr += "background:" + rureraform_form_options["input-icon-background"] + ";";
        }
        if (rureraform_form_options["input-icon-border"] != "") {
            style_attr += "border-color:" + rureraform_form_options["input-icon-border"] + ";border-style:solid;";
            if (rureraform_form_options.hasOwnProperty("input-border-style-width")) {
                integer = parseInt(rureraform_form_options["input-border-style-width"], 10);
                if (integer >= 0 && integer <= 16)
                    style_attr += "border-width:" + integer + "px;";
            }
        }
        if (rureraform_form_options.hasOwnProperty("input-border-style-radius")) {
            var integer = parseInt(rureraform_form_options["input-border-style-radius"], 10);
            if (integer >= 0 && integer <= 100)
                style_attr += "border-radius:" + integer + "px;";
        }
        if (rureraform_form_options["input-icon-background"] != "" || rureraform_form_options["input-icon-border"] != "") {
            style += "div.rureraform-input.rureraform-icon-left input[type='text'], div.rureraform-input.rureraform-icon-left input[type='email'],div.rureraform-input.rureraform-icon-left input[type='password'],div.rureraform-input.rureraform-icon-left textarea {padding-left: 56px !important;}";
            style += "div.rureraform-input.rureraform-icon-right input[type='text'], div.rureraform-input.rureraform-icon-right input[type='email'],div.rureraform-input.rureraform-icon-right input[type='password'],div.rureraform-input.rureraform-icon-right textarea {padding-right: 56px !important;}";
        }
    }
    if (style_attr != "") {
        style += "div.rureraform-input>i.rureraform-icon-left, div.rureraform-input>i.rureraform-icon-right {" + style_attr + "}";
    }

    text_style = rureraform_build_style_text(rureraform_form_options, "button-text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style_attr = text_style["style"];
    style_attr += rureraform_build_style_background(rureraform_form_options, "button-background-style");
    style_attr += rureraform_build_style_border(rureraform_form_options, "button-border-style");
    style_attr += rureraform_build_shadow(rureraform_form_options, "button-shadow");
    style += ".rureraform-element .rureraform-button{" + style_attr + "}";
    if (rureraform_form_options["button-hover-inherit"] == "off") {
        text_style = rureraform_build_style_text(rureraform_form_options, "button-hover-text-style");
        if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
            webfonts.push(text_style["webfont"]);
        style_attr = text_style["style"];
        style_attr += rureraform_build_style_background(rureraform_form_options, "button-hover-background-style");
        style_attr += rureraform_build_style_border(rureraform_form_options, "button-hover-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "button-hover-shadow");
        style += ".rureraform-element .rureraform-button:hover,.rureraform-element .rureraform-button:focus{" + style_attr + "}";
    }
    if (rureraform_form_options["button-active-inherit"] == "off") {
        text_style = rureraform_build_style_text(rureraform_form_options, "button-active-text-style");
        if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
            webfonts.push(text_style["webfont"]);
        style_attr = text_style["style"];
        style_attr += rureraform_build_style_background(rureraform_form_options, "button-active-background-style");
        style_attr += rureraform_build_style_border(rureraform_form_options, "button-active-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "button-active-shadow");
        style += ".rureraform-element .rureraform-button:active{" + style_attr + "}";
    }

    text_style = rureraform_build_style_text(rureraform_form_options, "tile-text-style");
    if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
        webfonts.push(text_style["webfont"]);
    style_attr = text_style["style"];
    style_attr += rureraform_build_style_background(rureraform_form_options, "tile-background-style");
    style_attr += rureraform_build_style_border(rureraform_form_options, "tile-border-style");
    style_attr += rureraform_build_shadow(rureraform_form_options, "tile-shadow");
    style += ".rureraform-element input[type='checkbox'].rureraform-tile+label,.rureraform-element input[type='radio'].rureraform-tile+label{" + style_attr + "}";
    if (rureraform_form_options["tile-hover-inherit"] == "off") {
        text_style = rureraform_build_style_text(rureraform_form_options, "tile-hover-text-style");
        if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
            webfonts.push(text_style["webfont"]);
        style_attr = text_style["style"];
        style_attr += rureraform_build_style_background(rureraform_form_options, "tile-hover-background-style");
        style_attr += rureraform_build_style_border(rureraform_form_options, "tile-hover-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "tile-hover-shadow");
        style += ".rureraform-element input[type='checkbox'].rureraform-tile+label:hover,.rureraform-element input[type='radio'].rureraform-tile+label:hover{" + style_attr + "}";
    }
    if (rureraform_form_options["tile-selected-inherit"] == "off") {
        text_style = rureraform_build_style_text(rureraform_form_options, "tile-selected-text-style");
        if (text_style["webfont"] != "" && webfonts.indexOf(text_style["webfont"]) == -1)
            webfonts.push(text_style["webfont"]);
        style_attr = text_style["style"];
        style_attr += rureraform_build_style_background(rureraform_form_options, "tile-selected-background-style");
        style_attr += rureraform_build_style_border(rureraform_form_options, "tile-selected-border-style");
        style_attr += rureraform_build_shadow(rureraform_form_options, "tile-selected-shadow");
        style += ".rureraform-element input[type='checkbox'].rureraform-tile:checked+label,.rureraform-element input[type='radio'].rureraform-tile:checked+label{" + style_attr + "}";
    }

    style_attr = "";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color2") && rureraform_form_options["checkbox-radio-unchecked-color-color2"] != "")
        style_attr += "background-color:" + rureraform_form_options["checkbox-radio-unchecked-color-color2"] + ";";
    else
        style_attr += "background-color:transparent;";
    style += ".rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-tgl:checked+label:after{" + style_attr + "}";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color1") && rureraform_form_options["checkbox-radio-unchecked-color-color1"] != "")
        style_attr += "border-color:" + rureraform_form_options["checkbox-radio-unchecked-color-color1"] + ";";
    else
        style_attr += "border-color:transparent;";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color3") && rureraform_form_options["checkbox-radio-unchecked-color-color3"] != "")
        style_attr += "color:" + rureraform_form_options["checkbox-radio-unchecked-color-color3"] + ";";
    else
        style_attr += "color:#ccc;";
    style += ".rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-classic+label,.rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-fa-check+label,.rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-square+label,.rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-tgl+label{" + style_attr + "}";
    style_attr = "";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color3") && rureraform_form_options["checkbox-radio-unchecked-color-color3"] != "")
        style_attr += "background-color:" + rureraform_form_options["checkbox-radio-unchecked-color-color3"] + ";";
    else
        style_attr += "background-color:#ccc;";
    style += ".rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-square:checked+label:after{" + style_attr + "}";
    style += ".rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-tgl:checked+label,.rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-tgl+label:after{" + style_attr + "}";
    if (rureraform_form_options["checkbox-radio-checked-inherit"] == "off") {
        style_attr = "";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color2") && rureraform_form_options["checkbox-radio-checked-color-color2"] != "")
            style_attr += "background-color:" + rureraform_form_options["checkbox-radio-checked-color-color2"] + ";";
        else
            style_attr += "background-color:transparent;";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color1") && rureraform_form_options["checkbox-radio-checked-color-color1"] != "")
            style_attr += "border-color:" + rureraform_form_options["checkbox-radio-checked-color-color1"] + ";";
        else
            style_attr += "border-color:transparent;";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color3") && rureraform_form_options["checkbox-radio-checked-color-color3"] != "")
            style_attr += "color:" + rureraform_form_options["checkbox-radio-checked-color-color3"] + ";";
        else
            style_attr += "color:#ccc;";
        style += ".rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-classic:checked+label,.rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-fa-check:checked+label,.rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-square:checked+label,.rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-tgl:checked+label{" + style_attr + "}";
        style_attr = "";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color3") && rureraform_form_options["checkbox-radio-checked-color-color3"] != "")
            style_attr += "background-color:" + rureraform_form_options["checkbox-radio-checked-color-color3"] + ";";
        else
            style_attr += "background-color:#ccc;";
        style += ".rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-square:checked+label:after{" + style_attr + "}";
        style += ".rureraform-element div.rureraform-input input[type='checkbox'].rureraform-checkbox-tgl:checked+label:after{" + style_attr + "}";
    }

    style_attr = "";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color2") && rureraform_form_options["checkbox-radio-unchecked-color-color2"] != "")
        style_attr += "background-color:" + rureraform_form_options["checkbox-radio-unchecked-color-color2"] + ";";
    else
        style_attr += "background-color:transparent;";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color1") && rureraform_form_options["checkbox-radio-unchecked-color-color1"] != "")
        style_attr += "border-color:" + rureraform_form_options["checkbox-radio-unchecked-color-color1"] + ";";
    else
        style_attr += "border-color:transparent;";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color3") && rureraform_form_options["checkbox-radio-unchecked-color-color3"] != "")
        style_attr += "color:" + rureraform_form_options["checkbox-radio-unchecked-color-color3"] + ";";
    else
        style_attr += "color:#ccc;";
    style += ".rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-classic+label,.rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-fa-check+label,.rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-dot+label{" + style_attr + "}";
    style_attr = "";
    if (rureraform_form_options.hasOwnProperty("checkbox-radio-unchecked-color-color3") && rureraform_form_options["checkbox-radio-unchecked-color-color3"] != "")
        style_attr += "background-color:" + rureraform_form_options["checkbox-radio-unchecked-color-color3"] + ";";
    else
        style_attr += "background-color:#ccc;";
    style += ".rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-dot:checked+label:after{" + style_attr + "}";
    if (rureraform_form_options["checkbox-radio-checked-inherit"] == "off") {
        style_attr = "";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color2") && rureraform_form_options["checkbox-radio-checked-color-color2"] != "")
            style_attr += "background-color:" + rureraform_form_options["checkbox-radio-checked-color-color2"] + ";";
        else
            style_attr += "background-color:transparent;";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color1") && rureraform_form_options["checkbox-radio-checked-color-color1"] != "")
            style_attr += "border-color:" + rureraform_form_options["checkbox-radio-checked-color-color1"] + ";";
        else
            style_attr += "border-color:transparent;";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color3") && rureraform_form_options["checkbox-radio-checked-color-color3"] != "")
            style_attr += "color:" + rureraform_form_options["checkbox-radio-checked-color-color3"] + ";";
        else
            style_attr += "color:#ccc;";
        style += ".rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-classic:checked+label,.rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-fa-check:checked+label,.rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-dot:checked+label{" + style_attr + "}";
        style_attr = "";
        if (rureraform_form_options.hasOwnProperty("checkbox-radio-checked-color-color3") && rureraform_form_options["checkbox-radio-checked-color-color3"] != "")
            style_attr += "background-color:" + rureraform_form_options["checkbox-radio-checked-color-color3"] + ";";
        else
            style_attr += "background-color:#ccc;";
        style += ".rureraform-element div.rureraform-input input[type='radio'].rureraform-radio-dot:checked+label:after{" + style_attr + "}";
    }

    style_attr = "";
    if (rureraform_form_options.hasOwnProperty("multiselect-style-hover-background") && rureraform_form_options["multiselect-style-hover-background"] != "")
        style_attr += "background-color:" + rureraform_form_options['multiselect-style-hover-background'] + ";";
    if (rureraform_form_options.hasOwnProperty("multiselect-style-hover-color") && rureraform_form_options["multiselect-style-hover-color"] != "")
        style_attr += "color:" + rureraform_form_options['multiselect-style-hover-color'] + ";";
    if (style_attr != "")
        style += ".rureraform-element div.rureraform-input div.rureraform-multiselect>input[type='checkbox']+label:hover{" + style_attr + "}";
    style_attr = "";
    if (rureraform_form_options.hasOwnProperty("multiselect-style-selected-background") && rureraform_form_options["multiselect-style-selected-background"] != "")
        style_attr += "background-color:" + rureraform_form_options['multiselect-style-selected-background'] + ";";
    if (rureraform_form_options.hasOwnProperty("multiselect-style-selected-color") && rureraform_form_options["multiselect-style-selected-color"] != "")
        style_attr += "color:" + rureraform_form_options['multiselect-style-selected-color'] + ";";
    if (style_attr != "")
        style += ".rureraform-element div.rureraform-input div.rureraform-multiselect>input[type='checkbox']:checked+label{" + style_attr + "}";
    if (rureraform_form_options.hasOwnProperty("multiselect-style-height") && rureraform_form_options["multiselect-style-height"] != "")
        style += ".rureraform-element div.rureraform-input div.rureraform-multiselect{height:" + parseInt(rureraform_form_options['multiselect-style-height'], 10) + "px;}";

    if (typeof jQuery.fn.ionRangeSlider != typeof undefined && jQuery.fn.ionRangeSlider) {
        if (rureraform_form_options.hasOwnProperty("rangeslider-color-color1") && rureraform_form_options["rangeslider-color-color1"] != "")
            style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs-line, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-min, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-max, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-grid-pol{background-color:" + rureraform_form_options["rangeslider-color-color1"] + " !important;}";
        if (rureraform_form_options.hasOwnProperty("rangeslider-color-color2") && rureraform_form_options["rangeslider-color-color2"] != "")
            style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs-grid-text, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-min, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-max{color:" + rureraform_form_options["rangeslider-color-color2"] + " !important;}";
        if (rureraform_form_options.hasOwnProperty("rangeslider-color-color3") && rureraform_form_options["rangeslider-color-color3"] != "")
            style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs-bar{background-color:" + rureraform_form_options["rangeslider-color-color3"] + " !important;}";
        if (rureraform_form_options.hasOwnProperty("rangeslider-color-color4") && rureraform_form_options["rangeslider-color-color4"] != "") {
            style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs-single, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-from, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-to{background-color:" + rureraform_form_options["rangeslider-color-color4"] + " !important;}";
            style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs-single:before, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-from:before, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-to:before{border-top-color:" + rureraform_form_options["rangeslider-color-color4"] + " !important;}";
            switch (rureraform_form_options["rangeslider-skin"]) {
                case 'sharp':
                    style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs--sharp .irs-handle, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--sharp .irs-handle:hover, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--sharp .irs-handle.state_hover{background-color:" + rureraform_form_options["rangeslider-color-color4"] + " !important;}";
                    style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs--sharp .irs-handle > i:first-child, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--sharp .irs-handle:hover > i:first-child, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--sharp .irs-handle.state_hover > i:first-child{border-top-color:" + rureraform_form_options["rangeslider-color-color4"] + " !important;}";
                    break;
                case 'round':
                    style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs--round .irs-handle, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--round .irs-handle:hover, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--round .irs-handle.state_hover{border-color:" + rureraform_form_options["rangeslider-color-color4"] + " !important;}";
                    break;
                default:
                    style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs--flat .irs-handle > i:first-child, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--flat .irs-handle:hover > i:first-child, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--flat .irs-handle.state_hover > i:first-child{background-color:" + rureraform_form_options["rangeslider-color-color4"] + " !important;}";
                    break;
            }
        }
        if (rureraform_form_options.hasOwnProperty("rangeslider-color-color5") && rureraform_form_options["rangeslider-color-color5"] != "") {
            style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs-single, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-from, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs-to{color:" + rureraform_form_options["rangeslider-color-color5"] + " !important;}";
            if (rureraform_form_options["rangeslider-skin"] == "round") {
                style += ".rureraform-element div.rureraform-input.rureraform-rangeslider .irs--round .irs-handle, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--round .irs-handle:hover, .rureraform-element div.rureraform-input.rureraform-rangeslider .irs--round .irs-handle.state_hover{background-color:" + rureraform_form_options["rangeslider-color-color5"] + " !important;}";
            }
        }
    }

    text_style = "";
    for (var i = 0; i < webfonts.length; i++) {
        text_style += "<link href='//fonts.googleapis.com/css?family=" + webfonts[i].replace(" ", "+") + ":100,200,300,400,500,600,700,800,900&subset=arabic,vietnamese,hebrew,thai,bengali,latin,latin-ext,cyrillic,cyrillic-ext,greek' rel='stylesheet' type='text/css'>";
    }
    jQuery(".rureraform-form-global-style").html(text_style + "<style>" + style + "</style>");

    var output;
    for (var i = 0; i < rureraform_form_pages.length; i++) {
        if (rureraform_form_pages[i] != null) {
            output = _rureraform_build_children(rureraform_form_pages[i]['id'], 0);
            jQuery("#rureraform-form-" + rureraform_form_pages[i]['id']).append("<style>" + output["style"] + "</style>" + output["html"]);
            output = _rureraform_build_hidden_list(rureraform_form_pages[i]['id']);
            jQuery("#rureraform-form-" + rureraform_form_pages[i]['id']).append(output);
        }
    }

    jQuery(".rureraform-form").each(function () {
        var id = jQuery(this).attr("id");
        jQuery("#" + id + " .rureraform-elements, #" + id + ".rureraform-elements").sortable({
            connectWith: "#" + id + " .rureraform-elements, #" + id + ".rureraform-elements",
            items: ".rureraform-element",
            forcePlaceholderSize: true,
            dropOnEmpty: true,
            placeholder: "rureraform-element-placeholder",
            start: function (event, ui) {
                jQuery(ui.helper).addClass("rureraform-element-helper");
                jQuery(".rureraform-context-menu").hide();
            },
            stop: function (event, ui) {
                jQuery(".rureraform-element-helper").removeClass("rureraform-element-helper");
                _rureraform_sync_elements();
            }
        });
    });
    _rureraform_sync_elements();
    rureraform_build_progress();
    if (typeof jQuery.fn.ionRangeSlider != typeof undefined && jQuery.fn.ionRangeSlider)
        jQuery("input.rureraform-rangeslider").ionRangeSlider();
    jQuery(".rureraform-element, .rureraform-hidden-element").on("contextmenu", function (e) {
        e.preventDefault();
        jQuery(".rureraform-context-menu").hide();
        rureraform_context_menu_object = this;
        jQuery(".rureraform-context-menu").css({"top": (e.pageY - adminbar_height), "left": e.pageX});
        jQuery(".rureraform-context-menu-multi-page").remove();
        var li_duplicate_pages = new Array();
        var li_move_pages = new Array();
        for (var i = 0; i < rureraform_form_pages.length; i++) {
            if (rureraform_form_pages[i] != null && rureraform_form_pages[i]['id'] != "confirmation" && rureraform_form_pages[i]['id'] != rureraform_form_page_active) {
                li_duplicate_pages.push("<li><a href='#' onclick='return rureraform_element_duplicate(rureraform_context_menu_object, " + i + ");'>" + rureraform_escape_html(rureraform_form_pages[i]["name"]) + "</a></li>");
                li_move_pages.push("<li><a href='#' onclick='return rureraform_element_move(rureraform_context_menu_object, " + i + ");'>" + rureraform_escape_html(rureraform_form_pages[i]["name"]) + "</a></li>");
            }
        }
        if (li_duplicate_pages.length > 0) {
            jQuery(".rureraform-context-menu-last").after("<li class='rureraform-context-menu-multi-page'><a href='#' onclick='return false;'><i class='fas fa-caret-right'></i><i class='far fa-copy'></i>Duplicate to</a><ul>" + li_duplicate_pages.join("") + "</ul></li><li class='rureraform-context-menu-multi-page'><a href='#' onclick='return false;'><i class='fas fa-caret-right'></i><i class='far fa-arrow-alt-circle-right'></i>Move to</a><ul>" + li_move_pages.join("") + "</ul></li>");
        }
        jQuery(".rureraform-context-menu").show();
        return false;
    });
}
function rureraform_log_resize() {
    if (rureraform_record_active) {
        var popup_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 1080);
        jQuery("#rureraform-record-details").height(popup_height);
        jQuery("#rureraform-record-details").width(popup_width);
        jQuery("#rureraform-record-details .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-record-details .rureraform-admin-popup-content").height(popup_height - 52);
    }
}
function rureraform_log_ready() {
    rureraform_log_resize();
    jQuery(window).resize(function () {
        rureraform_log_resize();
    });
}
function rureraform_forms_resize() {
    if (rureraform_more_active) {
        var popup_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 840);
        jQuery("#rureraform-more-using").height(popup_height);
        jQuery("#rureraform-more-using").width(popup_width);
        jQuery("#rureraform-more-using .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-more-using .rureraform-admin-popup-content").height(popup_height - 52);
    }
}
function rureraform_forms_ready() {
    jQuery("span[title]").tooltipster({
        contentAsHTML: true,
        maxWidth: 360,
        theme: "tooltipster-dark",
        side: "bottom"
    });
    rureraform_forms_resize();
    jQuery(window).resize(function () {
        rureraform_forms_resize();
    });
}
function rureraform_form_resize() {
    var window_height = jQuery(window).height();
    var adminbar_height = jQuery("#wpadminbar").height();
    if (!rureraform_is_numeric(adminbar_height))
        adminbar_height = 0;
    var toolbar_height = jQuery(".rureraform-toolbar").height();
    var top_padding = 20;
    var header_height = jQuery(".rureraform-header").height();
    //var builder_height = parseInt(window_height, 10) - parseInt(adminbar_height, 10) - parseInt(header_height, 10) - parseInt(toolbar_height, 10) - parseInt(top_padding, 10);
    var builder_height = parseInt(window_height, 10);
    var toolbars_height = jQuery(".rureraform-toolbars").height();
    jQuery(".rureraform-builder").css({"min-height": builder_height + "px", "padding-top": parseInt(toolbars_height + 20, 10) + "px"});
    jQuery(".rureraform-form").css({"min-height": parseInt(builder_height - 20, 10) + "px"});
    var builder_width = jQuery(".rureraform-builder").outerWidth();
    jQuery(".rureraform-toolbars").css({"width": builder_width + "px"});
    if (rureraform_element_properties_active) {
        var popup_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 880), 1080);
        jQuery("#rureraform-element-properties").height(popup_height);
        jQuery("#rureraform-element-properties").width(popup_width);
        jQuery("#rureraform-element-properties .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-element-properties .rureraform-admin-popup-content").height(popup_height - 104);
    }
    if (rureraform_bulk_options_object) {
        var popup_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 880), 1080);
        jQuery("#rureraform-bulk-options").height(popup_height);
        jQuery("#rureraform-bulk-options").width(popup_width);
        jQuery("#rureraform-bulk-options .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-bulk-options .rureraform-admin-popup-content").height(popup_height - 104);
    }
    if (rureraform_record_active) {
        var popup_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 1080);
        jQuery("#rureraform-record-details").height(popup_height);
        jQuery("#rureraform-record-details").width(popup_width);
        jQuery("#rureraform-record-details .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-record-details .rureraform-admin-popup-content").height(popup_height - 52);
    }
    if (rureraform_more_active) {
        var popup_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 840);
        jQuery("#rureraform-more-using").height(popup_height);
        jQuery("#rureraform-more-using").width(popup_width);
        jQuery("#rureraform-more-using .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-more-using .rureraform-admin-popup-content").height(popup_height - 52);
    }
    if (rureraform_preview_active) {
        var max_width = parseInt(jQuery("#rureraform-preview").attr("data-width"), 10);
        var popup_height = 2 * parseInt((jQuery(window).height() - 40) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 40) / 2, 10), 480), max_width);
        jQuery("#rureraform-preview").height(popup_height);
        jQuery("#rureraform-preview").width(popup_width);
        jQuery("#rureraform-preview .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-preview .rureraform-admin-popup-content").height(popup_height - 52);
        jQuery("#rureraform-preview-iframe").height(popup_height - 52);
    }
    if (rureraform_stylemanager_active) {
        var popup_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
        var popup_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 840);
        jQuery("#rureraform-stylemanager").height(popup_height);
        jQuery("#rureraform-stylemanager").width(popup_width);
        jQuery("#rureraform-stylemanager .rureraform-admin-popup-inner").height(popup_height);
        jQuery("#rureraform-stylemanager .rureraform-admin-popup-content").height(popup_height - 52);
    }
}
function rureraform_form_ready() {
    rureraform_form_resize();
    jQuery(window).resize(function () {
        rureraform_form_resize();
    });
    jQuery(window).scroll(function (e) {
        var position = jQuery(window).scrollTop();
        var adminbar_height = jQuery("#wpadminbar").height();
        if (!rureraform_is_numeric(adminbar_height))
            adminbar_height = 0;
        var offset = jQuery(".rureraform-builder").offset().top - adminbar_height;
        if (position > offset) {
            jQuery("html").addClass("rureraform-toolbars-fixed");
        } else {
            jQuery("html").removeClass("rureraform-toolbars-fixed");
        }
    });

    for (var i = 0; i < rureraform_form_pages_raw.length; i++) {
        if (typeof rureraform_form_pages_raw[i] == 'object') {
            if (parseInt(rureraform_form_pages_raw[i]['id'], 10) > rureraform_form_last_id)
                rureraform_form_last_id = parseInt(rureraform_form_pages_raw[i]['id'], 10);
            rureraform_form_pages.push(rureraform_form_pages_raw[i]);
        }
    }

    if (rureraform_form_options.hasOwnProperty("math-expressions")) {
        for (var i = 0; i < rureraform_form_options["math-expressions"].length; i++) {
            if (typeof rureraform_form_options["math-expressions"][i] == 'object') {
                if (parseInt(rureraform_form_options["math-expressions"][i]['id'], 10) > rureraform_form_last_id)
                    rureraform_form_last_id = parseInt(rureraform_form_options["math-expressions"][i]['id'], 10);
            }
        }
    }
    if (rureraform_form_options.hasOwnProperty("payment-gateways")) {
        for (var i = 0; i < rureraform_form_options["payment-gateways"].length; i++) {
            if (typeof rureraform_form_options["payment-gateways"][i] == 'object') {
                if (parseInt(rureraform_form_options["payment-gateways"][i]['id'], 10) > rureraform_form_last_id)
                    rureraform_form_last_id = parseInt(rureraform_form_options["payment-gateways"][i]['id'], 10);
            }
        }
    }

    if (jQuery(".rureraform-pages-bar-item").length == 1)
        jQuery(".rureraform-pages-bar-item").find(".rureraform-pages-bar-item-delete").addClass("rureraform-pages-bar-item-delete-disabled");
    else
        jQuery(".rureraform-pages-bar-item").find(".rureraform-pages-bar-item-delete").removeClass("rureraform-pages-bar-item-delete-disabled");
    rureraform_pages_activate(jQuery(".rureraform-pages-bar-item").first().find("label"));

    var tmp;
    for (var i = 0; i < rureraform_form_elements_raw.length; i++) {
        tmp = JSON.parse(rureraform_form_elements_raw[i]);
        if (typeof tmp == 'object') {
            if (parseInt(tmp['id'], 10) > rureraform_form_last_id)
                rureraform_form_last_id = parseInt(tmp['id'], 10);
            rureraform_form_elements.push(tmp);
        }
    }
    jQuery(".rureraform-toolbar-list>li>a[title]").tooltipster({
        maxWidth: 360,
        theme: "tooltipster-dark rureraform-toolbar-tooltipster",
        side: "bottom"
    });

    jQuery(".rureraform-toolbar-list li a").on("click", function (e) {
        e.preventDefault();
        var type = jQuery(this).parent().attr("data-type");
        if (typeof type == undefined || type == "")
            return false;
        var columns = 2;
        if (rureraform_meta.hasOwnProperty(type)) {
            rureraform_form_last_id++;
            var element = {"type": type, "resize": "both", "height": "auto", "_parent": rureraform_form_page_active, "_parent-col": 0, "_seq": rureraform_form_last_id, "id": rureraform_form_last_id};
            if (type == "columns") {
                columns = parseInt(jQuery(this).parent().attr("data-option"), 10);
                if (columns != 2 && columns != 3 && columns != 4 && columns != 6)
                    columns = 2;
                element['_cols'] = columns;
            }
            for (var key in rureraform_meta[type]) {
                if (rureraform_meta[type].hasOwnProperty(key)) {
                    switch (rureraform_meta[type][key]['type']) {
                        case 'column-width':
                            for (var i = 0; i < columns; i++) {
                                element[key + "-" + i] = parseInt(12 / columns, 10);
                            }
                            break;

                        default:
                            if (rureraform_meta[type][key].hasOwnProperty('value')) {
                                if (typeof rureraform_meta[type][key]['value'] == 'object') {
                                    for (var option_key in rureraform_meta[type][key]['value']) {
                                        if (rureraform_meta[type][key]['value'].hasOwnProperty(option_key)) {
                                            element[key + "-" + option_key] = rureraform_meta[type][key]['value'][option_key];
                                        }
                                    }
                                } else
                                    element[key] = rureraform_meta[type][key]['value'];
                            } else if (rureraform_meta[type][key].hasOwnProperty('values'))
                                element[key] = rureraform_meta[type][key]['values'];
                            break;
                    }
                }
            }
            rureraform_form_elements.push(element);
            rureraform_form_changed = true;
            rureraform_build();
            if (rureraform_gettingstarted_enable == "on" && rureraform_form_elements.length <= 2)
                rureraform_gettingstarted("element-properties", 0);
        }
    });
    jQuery("body").append('<div class="rureraform-context-menu"><ul><li><a href="#" onclick="return rureraform_properties_open(rureraform_context_menu_object);"><i class="fas fa-pencil-alt"></i>Properties</a></li><li class="rureraform-context-menu-last"><a href="#" onclick="return rureraform_element_duplicate(rureraform_context_menu_object);"><i class="far fa-copy"></i>Duplicate</a></li><li class="rureraform-context-menu-line"></li><li><a href="#" onclick="return rureraform_element_delete(rureraform_context_menu_object);"><i class="fas fa-trash-alt"></i>Delete</a></li></ul></div>');
    jQuery("body").on("click", function (e) {
        jQuery(".rureraform-context-menu").hide();
    });
    jQuery(".rureraform-fa-selector-header input").on("keyup", function (e) {
        var needle = jQuery(this).val().toLowerCase();
        if (needle == "") {
            jQuery(this).parent().parent().find(".rureraform-fa-selector-content span").show();
        } else {
            var icons = jQuery(this).parent().parent().find(".rureraform-fa-selector-content");
            jQuery(icons).find("span").each(function () {
                if (jQuery(this).attr("title").toLowerCase().indexOf(needle) === -1)
                    jQuery(this).hide();
                else
                    jQuery(this).show();
            });
        }
        return false;
    });
    jQuery(window).on('beforeunload', function (e) {
        if (rureraform_element_properties_data_changed || rureraform_form_changed)
            return 'Form changed!';
        return;
    });
    jQuery(".rureraform-pages-bar-items").sortable({
        items: "li.rureraform-pages-bar-item",
        containment: "parent",
        forcePlaceholderSize: true,
        dropOnEmpty: true,
        placeholder: "rureraform-pages-bar-item-placeholder",
        start: function (event, ui) {
            jQuery(ui.helper).addClass("rureraform-pages-bar-item-helper");
            jQuery(".rureraform-context-menu").hide();
        },
        stop: function (event, ui) {
            jQuery(".rureraform-pages-bar-item-helper").removeClass("rureraform-pages-bar-item-helper");
            rureraform_build_progress();
        }
    });
    jQuery(".rureraform-pages-bar-items, .rureraform-pages-bar-items-confirmation").disableSelection();
    jQuery(".rureraform-element").disableSelection();
    rureraform_build();
}

function rureraform_forms_status_toggle(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var form_id = jQuery(_object).attr("data-id");
    var form_status = jQuery(_object).attr("data-status");
    var form_status_label = jQuery(_object).closest("tr").find("td.column-active").html();
    var doing_label = jQuery(_object).attr("data-doing");
    var do_label = jQuery(_object).html();
    jQuery(_object).html("<i class='fas fa-spinner fa-spin'></i> " + doing_label);
    jQuery(_object).closest("tr").find(".row-actions").addClass("visible");
    jQuery(_object).closest("tr").find("td.column-active").html("<i class='fas fa-spinner fa-spin'></i>");
    var post_data = {"action": "rureraform-forms-status-toggle", "form-id": form_id, "form-status": form_status};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            jQuery(_object).html(do_label);
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).html(data.form_action);
                    jQuery(_object).attr("data-status", data.form_status);
                    jQuery(_object).attr("data-doing", data.form_action_doing);
                    if (data.form_status == "active")
                        jQuery(_object).closest("tr").find(".rureraform-table-list-badge-status").html("");
                    else
                        jQuery(_object).closest("tr").find(".rureraform-table-list-badge-status").html("<span class='rureraform-badge rureraform-badge-danger'>Inactive</span>");
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    jQuery(_object).closest("tr").find("td.column-active").html(form_status_label);
                    rureraform_global_message_show("danger", data.message);
                } else {
                    jQuery(_object).closest("tr").find("td.column-active").html(form_status_label);
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                jQuery(_object).closest("tr").find("td.column-active").html(form_status_label);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            jQuery(_object).html(do_label);
            jQuery(_object).closest("tr").find("td.column-active").html(form_status_label);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

function rureraform_forms_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Please confirm that you want to delete the form.", "rureraform") + "</div>");
            this.show();
        },
        ok_label: 'Delete',
        ok_function: function (e) {
            _rureraform_forms_delete(_object);
            rureraform_dialog_close();
        }
    });
    return false;
}

function _rureraform_forms_delete(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var form_id = jQuery(_object).attr("data-id");
    var doing_label = jQuery(_object).attr("data-doing");
    var do_label = jQuery(_object).html();
    jQuery(_object).html("<i class='fas fa-spinner fa-spin'></i> " + doing_label);
    jQuery(_object).closest("tr").find(".row-actions").addClass("visible");
    var post_data = {"action": "rureraform-forms-delete", "form-id": form_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).closest("tr").fadeOut(300, function () {
                        jQuery(_object).closest("tr").remove();
                    });
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).html(do_label);
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            jQuery(_object).html(do_label);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

function rureraform_forms_duplicate(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Please confirm that you want to duplicate the form.", "rureraform") + "</div>");
            this.show();
        },
        ok_label: 'Duplicate',
        ok_function: function (e) {
            _rureraform_forms_duplicate(_object);
            rureraform_dialog_close();
        }
    });
    return false;
}

function _rureraform_forms_duplicate(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var form_id = jQuery(_object).attr("data-id");
    var doing_label = jQuery(_object).attr("data-doing");
    var do_label = jQuery(_object).html();
    jQuery(_object).html("<i class='fas fa-spinner fa-spin'></i> " + doing_label);
    jQuery(_object).closest("tr").find(".row-actions").addClass("visible");
    var post_data = {"action": "rureraform-forms-duplicate", "form-id": form_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_global_message_show("success", data.message);
                    location.reload();
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).html(do_label);
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            jQuery(_object).html(do_label);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}
function rureraform_columns_toggle(_object) {
    var columns = {};
    var json_columns = "";
    if (typeof _object === 'string' || _object instanceof String) {
        json_columns = rureraform_read_cookie("rureraform-" + _object + "-columns");
        if (json_columns != null) {
            try {
                columns = JSON.parse(json_columns);
                if (typeof columns == "object" && !jQuery.isEmptyObject(columns)) {
                    jQuery("ul.rureraform-" + _object + "-columns input").each(function () {
                        var id = jQuery(this).attr("data-id");
                        if (columns.hasOwnProperty(id)) {
                            if (columns[id] == "on") {
                                jQuery(this).prop("checked", true);
                                jQuery(".rureraform-column-" + id).show();
                            } else {
                                jQuery(this).prop("checked", false);
                                jQuery(".rureraform-column-" + id).hide();
                            }
                        }
                    });
                    rureraform_write_cookie("rureraform-" + _object + "-columns", json_columns, 365);
                }
            } catch (error) {
                console.log(error);
            }
        }
    } else {
        var columns_set = jQuery(_object).closest("ul");
        if (columns_set) {
            jQuery(columns_set).find("input").each(function () {
                var id = jQuery(this).attr("data-id");
                if (jQuery(this).is(":checked")) {
                    columns[id] = "on";
                    jQuery(".rureraform-column-" + id).show();
                } else {
                    columns[id] = "off";
                    jQuery(".rureraform-column-" + id).hide();
                }
            });
            rureraform_write_cookie("rureraform-" + jQuery(columns_set).attr("data-id") + "-columns", JSON.stringify(columns), 365);
        }
    }

    return false;
}
var rureraform_more_active = null;
function rureraform_more_using_open(_object) {
    jQuery("#rureraform-more-using .rureraform-admin-popup-content-form").html("");
    var window_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
    var window_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 840);
    jQuery("#rureraform-more-using").height(window_height);
    jQuery("#rureraform-more-using").width(window_width);
    jQuery("#rureraform-more-using .rureraform-admin-popup-inner").height(window_height);
    jQuery("#rureraform-more-using .rureraform-admin-popup-content").height(window_height - 52);
    jQuery("#rureraform-more-using-overlay").fadeIn(300);
    jQuery("#rureraform-more-using").fadeIn(300);
    jQuery("#rureraform-more-using .rureraform-admin-popup-title h3 span").html("");
    jQuery("#rureraform-more-using .rureraform-admin-popup-loading").show();
    rureraform_more_active = jQuery(_object).attr("data-id");
    var post_data = {"action": "rureraform-using", "form-id": rureraform_more_active};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery("#rureraform-more-using .rureraform-admin-popup-content-form").html(data.html);
                    jQuery("#rureraform-more-using .rureraform-admin-popup-title h3 span").html(data.form_name);
                    jQuery("#rureraform-more-using .rureraform-admin-popup-loading").hide();
                } else if (data.status == "ERROR") {
                    rureraform_more_using_close();
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_more_using_close();
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_more_using_close();
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            rureraform_more_using_close();
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
        }
    });

    return false;
}

function rureraform_more_using_close() {
    jQuery("#rureraform-more-using-overlay").fadeOut(300);
    jQuery("#rureraform-more-using").fadeOut(300);
    rureraform_more_active = null;
    setTimeout(function () {
        jQuery("#rureraform-more-using .rureraform-admin-popup-content-form").html("");
    }, 1000);
    return false;
}

var rureraform_stylemanager_active = null;
function rureraform_stylemanager_open(_object) {
    var actions_html, html = "";
    jQuery("#rureraform-stylemanager .rureraform-admin-popup-content-form").html("");
    var window_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
    var window_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 840);
    jQuery("#rureraform-stylemanager").height(window_height);
    jQuery("#rureraform-stylemanager").width(window_width);
    jQuery("#rureraform-stylemanager .rureraform-admin-popup-inner").height(window_height);
    jQuery("#rureraform-stylemanager .rureraform-admin-popup-content").height(window_height - 52);
    jQuery("#rureraform-stylemanager-overlay").fadeIn(300);
    jQuery("#rureraform-stylemanager").fadeIn(300);
    jQuery("#rureraform-stylemanager .rureraform-admin-popup-loading").show();
    rureraform_stylemanager_active = true;
    html = "<div class='rureraform-stylemanager-details" + (rureraform_styles.length > 0 ? "" : " rureraform-stylemanager-empty") + "'><div class='rureraform-stylemanager-buttons'><a href='#' class='rureraform-button' onclick='jQuery(\"#rureraform-import-style-file\").click(); return false;'><i class='fas fa-upload'></i><label>" + rureraform_esc_html__("Import Theme", "rureraform") + "</label></a></div><table>";
    if (rureraform_styles.length > 0) {
        for (var i = 0; i < rureraform_styles.length; i++) {
            if (rureraform_styles[i]["type"] == 0 || rureraform_styles[i]["type"] == "0") {
                actions_html = "<div class='rureraform-table-list-actions'><span><i class='fas fa-ellipsis-v'></i></span><div class='rureraform-table-list-menu'><ul><li><a href='#' data-id='" + rureraform_escape_html(rureraform_styles[i]["id"]) + "' onclick='return rureraform_stylemanager_rename(this);'>" + rureraform_esc_html__("Rename", "rureraform") + "</a></li><li><a href='?page=rureraform&rureraform-action=export-style&id=" + rureraform_escape_html(rureraform_styles[i]["id"]) + "' target='_blank'>" + rureraform_esc_html__("Export", "rureraform") + "</a></li><li class='rureraform-table-list-menu-line'></li><li><a href='#' data-id='" + rureraform_escape_html(rureraform_styles[i]["id"]) + "' data-doing='" + rureraform_esc_html__("Deleting...", "rureraform") + "' onclick='return rureraform_stylemanager_delete(this);'>" + rureraform_esc_html__("Delete", "rureraform") + "</a></li></ul></div></div>";
                html += "<tr><th>" + rureraform_escape_html(rureraform_styles[i]["name"]) + "</th><td>" + actions_html + "</td></tr>";
            }
        }
    } else {
        html += "<tr><th>" + rureraform_esc_html__("No user styles found.", "rureraform") + "</th></tr>";
    }
    html += "</table></div>";

    jQuery("#rureraform-stylemanager .rureraform-admin-popup-content-form").html(html);
    jQuery("#rureraform-stylemanager .rureraform-admin-popup-loading").hide();

    return false;
}

function rureraform_stylemanager_close() {
    jQuery("#rureraform-stylemanager-overlay").fadeOut(300);
    jQuery("#rureraform-stylemanager").fadeOut(300);
    rureraform_stylemanager_active = null;
    setTimeout(function () {
        jQuery("#rureraform-stylemanager .rureraform-admin-popup-content-form").html("");
    }, 1000);
    return false;
}

function rureraform_stylemanager_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Please confirm that you want to delete the theme.", "rureraform") + "</div>");
            this.show();
        },
        ok_label: 'Delete',
        ok_function: function (e) {
            _rureraform_stylemanager_delete(_object);
            rureraform_dialog_close();
        }
    });
    return false;
}

function _rureraform_stylemanager_delete(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var style_id = jQuery(_object).attr("data-id");
    var doing_label = jQuery(_object).attr("data-doing");
    var do_label = jQuery(_object).html();
    jQuery(_object).html("<i class='fas fa-spinner fa-spin'></i> " + doing_label);
    var post_data = {"action": "rureraform-stylemanager-delete", "style-id": style_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).closest("tr").fadeOut(300, function () {
                        jQuery(_object).closest("tr").remove();
                    });
                    rureraform_styles = data.styles;
                    var html = rureraform_styles_html();
                    jQuery(".rureraform-styles-select-container").html(html);
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).html(do_label);
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).html(do_label);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

function rureraform_stylemanager_rename(_object) {
    var style_id = jQuery(_object).attr("data-id");
    rureraform_dialog_open({
        echo_html: function () {
            var name = rureraform_form_options['name'] + " style";
            for (var i = 0; i < rureraform_styles.length; i++) {
                if (rureraform_styles[i]['id'] == style_id) {
                    name = rureraform_styles[i]['name'];
                    break;
                }
            }
            var html = "<div class='rureraform-style-save-row' id='rureraform-style-save-row-name'><label>" + rureraform_esc_html__("Name", "rureraform") + ":</label><input type='text' value='" + rureraform_escape_html(name) + "' placeholder='" + rureraform_esc_html__("Enter style name...", "rureraform") + "' id='rureraform-style-name' /></div>"
            this.html(html);
            this.show();
        },
        height: 270,
        title: rureraform_esc_html__('Rename the theme', 'rureraform'),
        ok_label: rureraform_esc_html__('Rename', 'rureraform'),
        ok_function: function (e) {
            _rureraform_stylemanager_rename(_object, jQuery("#rureraform-dialog .rureraform-dialog-button-ok"), style_id);
        }
    });
    return false;
}

function _rureraform_stylemanager_rename(_object, _button, _style_id) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var icon = jQuery(_button).find("i").attr("class");
    jQuery(_button).find("i").attr("class", "fas fa-spinner fa-spin");
    var post_data = {"action": "rureraform-stylemanager-save", "style-id": _style_id, "name": rureraform_encode64(jQuery("#rureraform-style-name").val())};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_styles = data.styles;
                    var html = rureraform_styles_html();
                    jQuery(".rureraform-styles-select-container").html(html);
                    jQuery(_object).closest("tr").find("th").html(data.name);
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_button).find("i").attr("class", icon);
            rureraform_sending = false;
            rureraform_dialog_close();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_button).find("i").attr("class", icon);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
            rureraform_dialog_close();
        }
    });
    return false;
}

function rureraform_stylemanager_imported(_object) {
    if (jQuery(_object).attr("data-loading") != "true")
        return;
    jQuery(_object).attr("data-loading", "false");
    var return_data = jQuery(_object).contents().find("body").html();
    try {
        var data;
        if (typeof return_data == 'object')
            data = return_data;
        else
            data = jQuery.parseJSON(return_data);
        if (data.status == "OK") {
            rureraform_styles.push({"id": data.id, "name": data.name, "type": data.type});
            var html = rureraform_styles_html();
            jQuery(".rureraform-styles-select-container").html(html);
            var row = "<tr><th>" + rureraform_escape_html(data.name) + "</th><td><div class='rureraform-table-list-actions'><span><i class='fas fa-ellipsis-v'></i></span><div class='rureraform-table-list-menu'><ul><li><a href='#' data-id='" + rureraform_escape_html(data.id) + "' onclick='return rureraform_stylemanager_rename(this);'>" + rureraform_esc_html__("Rename", "rureraform") + "</a></li><li><a href='?page=rureraform&rureraform-action=export-style&id=" + rureraform_escape_html(data.id) + "' target='_blank'>" + rureraform_esc_html__("Export", "rureraform") + "</a></li><li class='rureraform-table-list-menu-line'></li><li><a href='#' data-id='" + rureraform_escape_html(data.id) + "' data-doing='" + rureraform_esc_html__("Deleting...", "rureraform") + "' onclick='return rureraform_stylemanager_delete(this);'>" + rureraform_esc_html__("Delete", "rureraform") + "</a></li></ul></div></div></td></tr>";
            if (jQuery(".rureraform-stylemanager-details").hasClass("rureraform-stylemanager-empty")) {
                jQuery(".rureraform-stylemanager-details").removeClass("rureraform-stylemanager-empty");
                jQuery(".rureraform-stylemanager-details table").html(row);
            } else
                jQuery(".rureraform-stylemanager-details table").prepend(row);
            rureraform_global_message_show("success", data.message);
        } else if (data.status == "ERROR") {
            rureraform_global_message_show("danger", data.message);
        } else {
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
        }
    } catch (error) {
        console.log(error);
        rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
    }
    return;
}

var rureraform_preview_active = null;
function rureraform_preview_size(_object) {
    if (jQuery(_object).hasClass("rureraform-preview-size-active"))
        return;
    jQuery(".rureraform-preview-size-active").removeClass("rureraform-preview-size-active");
    jQuery(_object).addClass("rureraform-preview-size-active");
    var max_width = parseInt(jQuery(_object).attr("data-width"), 10);
    jQuery("#rureraform-preview").attr("data-width", max_width);
    var window_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 40) / 2, 10), 480), max_width);
    jQuery("#rureraform-preview").width(window_width);

}
function rureraform_preview_loaded(_object) {
    if (jQuery(_object).attr("data-loading") != "true")
        return;
    jQuery(_object).attr("data-loading", "false");
    rureraform_preview_open();
    jQuery(".rureraform-header-preview").find("i").attr("class", "far fa-eye");
    rureraform_sending = false;
    return;
}
function rureraform_preview_open() {
    var max_width = parseInt(jQuery("#rureraform-preview").attr("data-width"), 10);
    var window_height = 2 * parseInt((jQuery(window).height() - 40) / 2, 10);
    var window_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 40) / 2, 10), 480), max_width);
    jQuery("#rureraform-preview").height(window_height);
    jQuery("#rureraform-preview").width(window_width);
    jQuery("#rureraform-preview .rureraform-admin-popup-inner").height(window_height);
    jQuery("#rureraform-preview .rureraform-admin-popup-content").height(window_height - 52);
    jQuery("#rureraform-preview-iframe").height(window_height - 52);
    jQuery("#rureraform-preview-overlay").fadeIn(300);
    jQuery("#rureraform-preview").fadeIn(300);
    rureraform_preview_active = true;
    return false;
}

function rureraform_preview_close() {
    jQuery("#rureraform-preview-overlay").fadeOut(300);
    jQuery("#rureraform-preview").fadeOut(300);
    rureraform_preview_active = null;
    setTimeout(function () {
        jQuery("#rureraform-preview-iframe").attr("src", "about:blank");
    }, 1000);
    return false;
}

function rureraform_stats_reset(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Please confirm that you want to reset form statistics.", "rureraform") + "</div>");
            this.show();
        },
        ok_label: 'Reset',
        ok_function: function (e) {
            _rureraform_stats_reset(_object);
            rureraform_dialog_close();
        }
    });
    return false;
}

function _rureraform_stats_reset(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var form_id = jQuery(_object).attr("data-id");
    var doing_label = jQuery(_object).attr("data-doing");
    var do_label = jQuery(_object).html();
    jQuery(_object).html("<i class='fas fa-spinner fa-spin'></i> " + doing_label);
    jQuery(_object).closest("tr").find(".row-actions").addClass("visible");
    var post_data = {"action": "rureraform-stats-reset", "form-id": form_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).html(do_label);
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            jQuery(_object).html(do_label);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

var rureraform_record_active = null;
function rureraform_record_details_open(_object) {
    var href;
    jQuery("#rureraform-record-details .rureraform-admin-popup-content-form").html("");
    var window_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
    var window_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 1080);
    jQuery("#rureraform-record-details").height(window_height);
    jQuery("#rureraform-record-details").width(window_width);
    jQuery("#rureraform-record-details .rureraform-admin-popup-inner").height(window_height);
    jQuery("#rureraform-record-details .rureraform-admin-popup-content").height(window_height - 52);
    jQuery("#rureraform-record-details-overlay").fadeIn(300);
    jQuery("#rureraform-record-details").fadeIn(300);
    jQuery("#rureraform-record-details .rureraform-admin-popup-title h3 span").html("");
    jQuery("#rureraform-record-details .rureraform-admin-popup-loading").show();
    rureraform_record_active = jQuery(_object).attr("data-id");
    var pdf_button = jQuery("#rureraform-record-details .rureraform-admin-popup-title span.rureraform-export-pdf");
    if (pdf_button.length > 0) {
        href = jQuery(pdf_button).attr("data-url");
        href = href.replace(/{ID}/g, rureraform_record_active);
        jQuery(pdf_button).find("a").attr("href", href);
    }
    var print_button = jQuery("#rureraform-record-details .rureraform-admin-popup-title span.rureraform-print");
    if (print_button.length > 0) {
        href = jQuery(print_button).attr("data-url");
        href = href.replace(/{ID}/g, rureraform_record_active);
        jQuery(print_button).find("a").attr("href", href);
    }
    var post_data = {"action": "rureraform-record-details", "record-id": rureraform_record_active};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery("#rureraform-record-details .rureraform-admin-popup-content-form").html(data.html);
                    jQuery("#rureraform-record-details .rureraform-admin-popup-title h3 span").html(data.form_name);
                    jQuery("#rureraform-record-details .rureraform-admin-popup-loading").hide();
                } else if (data.status == "ERROR") {
                    rureraform_record_details_close();
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_record_details_close();
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_record_details_close();
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            rureraform_record_details_close();
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
        }
    });

    return false;
}

function rureraform_record_details_close() {
    jQuery("#rureraform-record-details-overlay").fadeOut(300);
    jQuery("#rureraform-record-details").fadeOut(300);
    rureraform_record_active = null;
    setTimeout(function () {
        jQuery("#rureraform-record-details .rureraform-admin-popup-content-form").html("");
    }, 1000);
    return false;
}

function rureraform_records_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Please confirm that you want to delete the record.", "rureraform") + "</div>");
            this.show();
        },
        ok_label: 'Delete',
        ok_function: function (e) {
            _rureraform_records_delete(_object);
            rureraform_dialog_close();
        }
    });
    return false;
}

function _rureraform_records_delete(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var record_id = jQuery(_object).attr("data-id");
    var doing_label = jQuery(_object).attr("data-doing");
    var do_label = jQuery(_object).html();
    jQuery(_object).html("<i class='fas fa-spinner fa-spin'></i> " + doing_label);
    jQuery(_object).closest("tr").find(".row-actions").addClass("visible");
    var post_data = {"action": "rureraform-records-delete", "record-id": record_id};
    console.log(post_data);
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).closest("tr").fadeOut(300, function () {
                        jQuery(_object).closest("tr").remove();
                    });
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).html(do_label);
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            jQuery(_object).html(do_label);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

function rureraform_transaction_details_open(_object) {
    jQuery("#rureraform-record-details .rureraform-admin-popup-content-form").html("");
    var window_height = 2 * parseInt((jQuery(window).height() - 100) / 2, 10);
    var window_width = Math.min(Math.max(2 * parseInt((jQuery(window).width() - 300) / 2, 10), 640), 1080);
    jQuery("#rureraform-record-details").height(window_height);
    jQuery("#rureraform-record-details").width(window_width);
    jQuery("#rureraform-record-details .rureraform-admin-popup-inner").height(window_height);
    jQuery("#rureraform-record-details .rureraform-admin-popup-content").height(window_height - 52);
    jQuery("#rureraform-record-details-overlay").fadeIn(300);
    jQuery("#rureraform-record-details").fadeIn(300);
    jQuery("#rureraform-record-details .rureraform-admin-popup-title h3 span").html("");
    jQuery("#rureraform-record-details .rureraform-admin-popup-loading").show();
    rureraform_record_active = jQuery(_object).attr("data-id");
    var href;
    var pdf_button = jQuery("#rureraform-record-details .rureraform-admin-popup-title span.rureraform-export-pdf");
    if (pdf_button.length > 0) {
        href = jQuery(pdf_button).attr("data-url");
        href = href.replace(/{ID}/g, rureraform_record_active);
        jQuery(pdf_button).find("a").attr("href", href);
    }
    var print_button = jQuery("#rureraform-record-details .rureraform-admin-popup-title span.rureraform-print");
    if (print_button.length > 0) {
        href = jQuery(print_button).attr("data-url");
        href = href.replace(/{ID}/g, rureraform_record_active);
        jQuery(print_button).find("a").attr("href", href);
    }
    var post_data = {"action": "rureraform-transaction-details", "transaction-id": rureraform_record_active};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery("#rureraform-record-details .rureraform-admin-popup-content-form").html(data.html);
                    jQuery("#rureraform-record-details .rureraform-admin-popup-loading").hide();
                } else if (data.status == "ERROR") {
                    rureraform_record_details_close();
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_record_details_close();
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_record_details_close();
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            rureraform_record_details_close();
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
        }
    });

    return false;
}

function rureraform_transaction_details_close() {
    jQuery("#rureraform-record-details-overlay").fadeOut(300);
    jQuery("#rureraform-record-details").fadeOut(300);
    rureraform_record_active = null;
    setTimeout(function () {
        jQuery("#rureraform-record-details .rureraform-admin-popup-content-form").html("");
    }, 1000);
}

function rureraform_transactions_delete(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__("Please confirm that you want to delete the transaction.", "rureraform") + "</div>");
            this.show();
        },
        ok_label: 'Delete',
        ok_function: function (e) {
            _rureraform_transactions_delete(_object);
            rureraform_dialog_close();
        }
    });
    return false;
}

function _rureraform_transactions_delete(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var record_id = jQuery(_object).attr("data-id");
    var doing_label = jQuery(_object).attr("data-doing");
    var do_label = jQuery(_object).html();
    jQuery(_object).html("<i class='fas fa-spinner fa-spin'></i> " + doing_label);
    jQuery(_object).closest("tr").find(".row-actions").addClass("visible");
    var post_data = {"action": "rureraform-transactions-delete", "transaction-id": record_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).closest("tr").fadeOut(300, function () {
                        jQuery(_object).closest("tr").remove();
                    });
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).html(do_label);
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).closest("tr").find(".row-actions").removeClass("visible");
            jQuery(_object).html(do_label);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

function rureraform_field_analytics_load(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    jQuery(_object).addClass("rureraform-stats-button-disabled");
    var post_data = {"action": "rureraform-field-analytics-load", "form-id": jQuery("#rureraform-stats-form").val(), "start-date": jQuery("#rureraform-stats-date-start").val(), "end-date": jQuery("#rureraform-stats-date-end").val(), "period": (jQuery("#rureraform-stats-period").is(":checked") ? "on" : "off")};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    rureraform_field_analytics_build_charts(data.data);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).find("i").attr("class", "fas fa-check");
            jQuery(_object).removeClass("rureraform-stats-button-disabled");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "fas fa-check");
            jQuery(_object).removeClass("rureraform-stats-button-disabled");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;
}

function rureraform_field_analytics_ready() {
    var airdatepicker = jQuery("#rureraform-stats-date-start").airdatepicker().data('airdatepicker');
    airdatepicker.destroy();
    jQuery("#rureraform-stats-date-start").airdatepicker({
        autoClose: true,
        timepicker: false,
        dateFormat: 'yyyy-mm-dd',
        onShow: function (inst, animationCompleted) {
            var max_date_string = jQuery("#rureraform-stats-date-end").val() ? jQuery("#rureraform-stats-date-end").val() : "2030-12-31";
            inst.update('maxDate', new Date(max_date_string));
        }
    });
    airdatepicker = jQuery("#rureraform-stats-date-end").airdatepicker().data('airdatepicker');
    airdatepicker.destroy();
    jQuery("#rureraform-stats-date-end").airdatepicker({
        autoClose: true,
        timepicker: false,
        dateFormat: 'yyyy-mm-dd',
        onShow: function (inst, animationCompleted) {
            var min_date_string = jQuery("#rureraform-stats-date-start").val() ? jQuery("#rureraform-stats-date-start").val() : "2018-01-01";
            inst.update('minDate', new Date(min_date_string));
        }
    });
    jQuery("#rureraform-stats-period").on("change", function (e) {
        if (jQuery("#rureraform-stats-period").is(":checked")) {
            jQuery(".rureraform-stats-input-container").fadeIn(300);
        } else {
            jQuery(".rureraform-stats-input-container").fadeOut(300);
        }
    });

    var data = JSON.parse(jQuery("#rureraform-field-analytics-initial-data").val());
    if (jQuery("#rureraform-stats-form").val() != 0)
        rureraform_field_analytics_build_charts(data);
}

function rureraform_field_analytics_build_charts(_charts) {
    var colors = new Array(
            {
                backgroundColor: 'rgb(255, 99, 132, 0.7)',
                borderColor: 'rgb(255, 99, 132)',
            },
            {
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgb(75, 192, 192)',
            },
            {
                backgroundColor: 'rgba(255, 205, 86, 0.7)',
                borderColor: 'rgb(255, 205, 86)',
            },
            {
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgb(54, 162, 235)',
            },
            {
                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                borderColor: 'rgb(153, 102, 255)',
            },
            {
                backgroundColor: 'rgba(201, 203, 207, 0.7)',
                borderColor: 'rgb(201, 203, 207)',
            }
    );
    if (_charts.length == 0) {
        jQuery(".rureraform-field-analytics-container").html("<div class='rureraform-field-analytics-noform'>No data found.</div>");
    } else {
        var column1_height = 0, column2_height = 0, height = 0, chart_html = "";
        var labels = new Array();
        var values = new Array();
        jQuery(".rureraform-field-analytics-container").html("");
        if (_charts.length > 1)
            jQuery(".rureraform-field-analytics-container").html("<div class='rureraform-field-analytics-columns'><div id='rureraform-field-analytics-column1'></div><div id='rureraform-field-analytics-column2'></div></div>");
        else
            jQuery(".rureraform-field-analytics-container").html("");
        for (var i = 0; i < _charts.length; i++) {
            labels = new Array();
            values = new Array();
            for (var j = 0; j < _charts[i]['chart'].length; j++) {
                if (_charts[i]['chart'][j]['label'].length > 24)
                    labels.push(_charts[i]['chart'][j]['label'].substring(0, 20) + "...");
                else
                    labels.push(_charts[i]['chart'][j]['label']);
                values.push(parseInt(_charts[i]['chart'][j]['value'], 10));
            }
            height = 128 + 24 * labels.length;
            chart_html = "<div class='rureraform-field-analytics-chart-box'><canvas id='rureraform-field-" + _charts[i]["form-id"] + "-" + _charts[i]["id"] + "'></canvas></div>";
            if (_charts.length > 1) {
                if (column1_height > column2_height) {
                    jQuery("#rureraform-field-analytics-column2").append(chart_html);
                    column2_height += height + 32;
                } else {
                    jQuery("#rureraform-field-analytics-column1").append(chart_html);
                    column1_height += height + 32;
                }
            } else
                jQuery(".rureraform-field-analytics-container").append(chart_html);

            jQuery("#rureraform-field-" + _charts[i]["form-id"] + "-" + _charts[i]["id"]).height(height);
            rureraform_chart = new Chart("rureraform-field-" + _charts[i]["form-id"] + "-" + _charts[i]["id"], {
                type: "horizontalBar",
                data: {
                    labels: labels,
                    datasets: [{
                            label: _charts[i]["title"],
                            data: values,
                            backgroundColor: colors[i % colors.length]["backgroundColor"],
                            borderColor: colors[i % colors.length]["borderColor"],
                            borderWidth: 1
                        }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: _charts[i]["title"]
                    },
                    scales: {
                        yAxes: [{
                                maxBarThickness: 32
                            }],
                        xAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                    }
                }
            });

        }
    }
}

function rureraform_stats_load(_object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    jQuery(_object).addClass("rureraform-stats-button-disabled");
    var post_data = {"action": "rureraform-stats-load", "form-id": jQuery("#rureraform-stats-form").val(), "start-date": jQuery("#rureraform-stats-date-start").val(), "end-date": jQuery("#rureraform-stats-date-end").val()};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    var labels = new Array();
                    var impressions = new Array();
                    var submits = new Array();
                    var confirmed = new Array();
                    var payments = new Array();
                    for (var key in data.data) {
                        if (data.data.hasOwnProperty(key)) {
                            labels.push(data.data[key]["label"]);
                            impressions.push(data.data[key]["impressions"]);
                            confirmed.push(data.data[key]["confirmed"]);
                            submits.push(data.data[key]["submits"]);
                            payments.push(data.data[key]["payments"]);
                        }
                    }
                    rureraform_stats_build_chart(labels, impressions, submits, confirmed, payments);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_object).find("i").attr("class", "fas fa-check");
            jQuery(_object).removeClass("rureraform-stats-button-disabled");
            rureraform_sending = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "fas fa-check");
            jQuery(_object).removeClass("rureraform-stats-button-disabled");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
        }
    });
    return false;

}

function rureraform_stats_ready() {
    var airdatepicker = jQuery("#rureraform-stats-date-start").airdatepicker().data('airdatepicker');
    airdatepicker.destroy();
    jQuery("#rureraform-stats-date-start").airdatepicker({
        autoClose: true,
        timepicker: false,
        dateFormat: 'yyyy-mm-dd',
        onShow: function (inst, animationCompleted) {
            var max_date_string = jQuery("#rureraform-stats-date-end").val() ? jQuery("#rureraform-stats-date-end").val() : "2030-12-31";
            inst.update('maxDate', new Date(max_date_string));
        }
    });
    airdatepicker = jQuery("#rureraform-stats-date-end").airdatepicker().data('airdatepicker');
    airdatepicker.destroy();
    jQuery("#rureraform-stats-date-end").airdatepicker({
        autoClose: true,
        timepicker: false,
        dateFormat: 'yyyy-mm-dd',
        onShow: function (inst, animationCompleted) {
            var min_date_string = jQuery("#rureraform-stats-date-start").val() ? jQuery("#rureraform-stats-date-start").val() : "2018-01-01";
            inst.update('minDate', new Date(min_date_string));
        }
    });
    var labels = new Array();
    var impressions = new Array();
    var submits = new Array();
    var confirmed = new Array();
    var payments = new Array();
    var data = JSON.parse(jQuery("#rureraform-stats-initial-data").val());
    for (var key in data) {
        if (data.hasOwnProperty(key)) {
            labels.push(data[key]["label"]);
            impressions.push(data[key]["impressions"]);
            submits.push(data[key]["submits"]);
            confirmed.push(data[key]["confirmed"]);
            payments.push(data[key]["payments"]);
        }
    }
    rureraform_stats_build_chart(labels, impressions, submits, confirmed, payments);
}

var rureraform_chart = null;
function rureraform_stats_build_chart(_labels, _impressions, _submits, _confirmed, _payments) {
    if (rureraform_chart)
        rureraform_chart.destroy();
    rureraform_chart = new Chart("rureraform-stats", {
        type: "line",
        data: {
            labels: _labels,
            datasets: [{
                    label: "Impressions",
                    lineTension: 0,
                    fill: false,
                    data: _impressions,
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 2
                },
                {
                    label: "Submits",
                    lineTension: 0,
                    fill: false,
                    data: _submits,
                    backgroundColor: 'rgb(255, 159, 64)',
                    borderColor: 'rgb(255, 159, 64)',
                    borderWidth: 2
                },
                {
                    label: "Confirmed",
                    lineTension: 0,
                    fill: false,
                    data: _confirmed,
                    backgroundColor: 'rgb(75, 192, 192)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 2
                },
                {
                    label: "Payments",
                    lineTension: 0,
                    fill: false,
                    data: _payments,
                    backgroundColor: 'rgb(204, 125, 188)',
                    borderColor: 'rgb(204, 125, 188)',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            /*			hover: {
             mode: 'nearest',
             intersect: true
             },*/
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
}

function rureraform_record_field_empty(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to empty this field.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Empty Field'),
        ok_function: function (e) {
            _rureraform_record_field_empty(jQuery("#rureraform-dialog .rureraform-dialog-button-ok"), _object);
        }
    });
}

function _rureraform_record_field_empty(_button, _object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var field_id = jQuery(_object).closest(".rureraform-record-details-table-value").attr("data-id");
    var record_id = jQuery(_object).closest(".rureraform-record-details").attr("data-id");
    var icon = jQuery(_button).find("i").attr("class");
    jQuery(_button).find("i").attr("class", "fas fa-spinner fa-spin");
    var post_data = {"action": "rureraform-record-field-empty", "record-id": record_id, "field-id": field_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-value").text("-");
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_button).find("i").attr("class", icon);
            rureraform_sending = false;
            rureraform_dialog_close();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_button).find("i").attr("class", icon);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
            rureraform_dialog_close();
        }
    });
    return false;
}

function rureraform_record_field_remove(_object) {
    rureraform_dialog_open({
        echo_html: function () {
            this.html("<div class='rureraform-dialog-message'>" + rureraform_esc_html__('Please confirm that you want to remove this field.') + "</div>");
            this.show();
        },
        ok_label: rureraform_esc_html__('Remove Field'),
        ok_function: function (e) {
            _rureraform_record_field_remove(jQuery("#rureraform-dialog .rureraform-dialog-button-ok"), _object);
        }
    });
}

function _rureraform_record_field_remove(_button, _object) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var field_id = jQuery(_object).closest(".rureraform-record-details-table-value").attr("data-id");
    var record_id = jQuery(_object).closest(".rureraform-record-details").attr("data-id");
    var icon = jQuery(_button).find("i").attr("class");
    jQuery(_button).find("i").attr("class", "fas fa-spinner fa-spin");
    var post_data = {"action": "rureraform-record-field-remove", "record-id": record_id, "field-id": field_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_object).closest("tr").fadeOut(300, function () {
                        jQuery(_object).closest("tr").remove();
                    });
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_button).find("i").attr("class", icon);
            rureraform_sending = false;
            rureraform_dialog_close();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_button).find("i").attr("class", icon);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
            rureraform_dialog_close();
        }
    });
    return false;
}

function rureraform_record_field_load_editor(_button) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var field_id = jQuery(_button).closest(".rureraform-record-details-table-value").attr("data-id");
    var record_id = jQuery(_button).closest(".rureraform-record-details").attr("data-id");
    var icon = jQuery(_button).find("i").attr("class");
    jQuery(_button).find("i").attr("class", "fas fa-spinner fa-spin");
    var post_data = {"action": "rureraform-record-field-load-editor", "record-id": record_id, "field-id": field_id};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-value").fadeOut(300, function () {
                        jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-editor").html(data.html);
                        jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-editor").fadeIn(300);
                    });
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_button).find("i").attr("class", icon);
            rureraform_sending = false;
            rureraform_dialog_close();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_button).find("i").attr("class", icon);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
            rureraform_dialog_close();
        }
    });
    return false;
}

function rureraform_record_field_cancel_editor(_button) {
    jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-editor").fadeOut(300, function () {
        jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-value").fadeIn(300);
        jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-editor").html("");
    });
}

function rureraform_record_field_save(_button) {
    if (rureraform_sending)
        return false;
    rureraform_sending = true;
    var field_id = jQuery(_button).closest(".rureraform-record-details-table-value").attr("data-id");
    var record_id = jQuery(_button).closest(".rureraform-record-details").attr("data-id");
    var icon = jQuery(_button).find("i").attr("class");
    jQuery(_button).find("i").attr("class", "fas fa-spinner fa-spin");
    var post_data = {"action": "rureraform-record-field-save", "record-id": record_id, "field-id": field_id, "value": rureraform_encode64(jQuery(_button).closest(".rureraform-record-field-editor").find("textarea, input, select").serialize())};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            try {
                var data;
                if (typeof return_data == 'object')
                    data = return_data;
                else
                    data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-editor").fadeOut(300, function () {
                        jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-value").html(data.html);
                        jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-value").fadeIn(300);
                        jQuery(_button).closest(".rureraform-record-details-table-value").find(".rureraform-record-field-editor").html("");
                    });
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                console.log(error);
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            jQuery(_button).find("i").attr("class", icon);
            rureraform_sending = false;
            rureraform_dialog_close();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_button).find("i").attr("class", icon);
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_sending = false;
            rureraform_dialog_close();
        }
    });
    return false;
}

function rureraform_input_sort() {
    var input_fields = new Array();
    var fields = new Array();
    for (var i = 0; i < rureraform_form_pages.length; i++) {
        if (rureraform_form_pages[i] != null) {
            fields = _rureraform_input_sort(rureraform_form_pages[i]['id'], 0, rureraform_form_pages[i]['id'], rureraform_form_pages[i]['name']);
            if (fields.length > 0)
                input_fields = input_fields.concat(fields);
        }
    }
    return input_fields;
}
function _rureraform_input_sort(_parent, _parent_col, _page_id, _page_name) {
    var input_fields = new Array();
    var fields = new Array();
    var idxs = new Array();
    var seqs = new Array();
    for (var i = 0; i < rureraform_form_elements.length; i++) {
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_form_elements[i]["_parent"] == _parent && (rureraform_form_elements[i]["_parent-col"] == _parent_col || _parent == "")) {
            idxs.push(i);
            seqs.push(parseInt(rureraform_form_elements[i]["_seq"], 10));
        }
    }
    if (idxs.length == 0)
        return input_fields;
    var sorted;
    for (var i = 0; i < seqs.length; i++) {
        sorted = -1;
        for (var j = 0; j < seqs.length - 1; j++) {
            if (seqs[j] > seqs[j + 1]) {
                sorted = seqs[j];
                seqs[j] = seqs[j + 1];
                seqs[j + 1] = sorted;
                sorted = idxs[j];
                idxs[j] = idxs[j + 1];
                idxs[j + 1] = sorted;
            }
        }
        if (sorted == -1)
            break;
    }
    for (var k = 0; k < idxs.length; k++) {
        i = idxs[k];
        if (rureraform_form_elements[i] == null)
            continue;
        if (rureraform_toolbar_tools.hasOwnProperty(rureraform_form_elements[i]['type']) && rureraform_toolbar_tools[rureraform_form_elements[i]['type']]['type'] == 'input') {
            input_fields.push({"id": rureraform_form_elements[i]['id'], "name": rureraform_form_elements[i]['name'], "page-id": _page_id, "page-name": _page_name});
        } else if (rureraform_form_elements[i]["type"] == "columns") {
            for (var j = 0; j < rureraform_form_elements[i]['_cols']; j++) {
                fields = _rureraform_input_sort(rureraform_form_elements[i]['id'], j, _page_id, _page_name);
                if (fields.length > 0)
                    input_fields = input_fields.concat(fields);
            }
        }
    }
    return input_fields;
}

var rureraform_htmlform_connecting = false;
function rureraform_htmlform_connect(_object) {
    if (rureraform_htmlform_connecting)
        return false;
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    jQuery(_object).addClass("rureraform-button-disabled");
    rureraform_htmlform_connecting = true;
    var post_data = {"action": "rureraform-htmlform-connect", "html": jQuery(_object).parent().find("textarea").val()};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            jQuery(_object).find("i").attr("class", "fas fa-random");
            jQuery(_object).removeClass("rureraform-button-disabled");
            try {
                var data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    var container = jQuery(_object).closest(".rureraform-htmlform-form");
                    jQuery(container).fadeOut(300, function () {
                        jQuery(container).html(data.html);
                        jQuery(container).fadeIn(300);
                    });
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            rureraform_htmlform_connecting = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "fas fa-random");
            jQuery(_object).removeClass("rureraform-button-disabled");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_htmlform_connecting = false;
        }
    });
    return false;
}
function rureraform_htmlform_disconnect(_object) {
    if (rureraform_htmlform_connecting)
        return false;
    jQuery(_object).find("i").attr("class", "fas fa-spinner fa-spin");
    jQuery(_object).addClass("rureraform-button-disabled");
    rureraform_htmlform_connecting = true;
    var post_data = {"action": "rureraform-htmlform-disconnect", "html": jQuery(_object).closest(".rureraform-htmlform-form").find("input[name='html']").val()};
    jQuery.ajax({
        type: "POST",
        url: rureraform_ajax_handler,
        data: post_data,
        success: function (return_data) {
            jQuery(_object).find("i").attr("class", "fas fa-times");
            jQuery(_object).removeClass("rureraform-button-disabled");
            try {
                var data = jQuery.parseJSON(return_data);
                if (data.status == "OK") {
                    var container = jQuery(_object).closest(".rureraform-htmlform-form");
                    jQuery(container).fadeOut(300, function () {
                        jQuery(container).html(data.html);
                        jQuery(container).fadeIn(300);
                    });
                    rureraform_global_message_show("success", data.message);
                } else if (data.status == "ERROR") {
                    rureraform_global_message_show("danger", data.message);
                } else {
                    rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
                }
            } catch (error) {
                rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            }
            rureraform_htmlform_connecting = false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            jQuery(_object).find("i").attr("class", "fas fa-times");
            jQuery(_object).removeClass("rureraform-button-disabled");
            rureraform_global_message_show("danger", rureraform_esc_html__("Something went wrong. We got unexpected server response."));
            rureraform_htmlform_connecting = false;
        }
    });
    return false;
}

var rureraform_gettingstarted_steps = {};
function rureraform_gettingstarted(_screen, _step) {
    var screen_cookie = rureraform_read_cookie("rureraform-gettingstarted-" + _screen);
    if (screen_cookie == "off")
        return;
    if (jQuery(".rureraform-gettingstarted-overlay").length < 1) {
        jQuery("body").append("<div class='rureraform-gettingstarted-overlay'></div>");
        jQuery(".rureraform-gettingstarted-overlay").fadeIn(1000);
    }
    if (rureraform_gettingstarted_steps.hasOwnProperty(_screen) && _step < rureraform_gettingstarted_steps[_screen].length) {
        jQuery(".rureraform-gettingstarted-highlight").removeClass("rureraform-gettingstarted-highlight");
        jQuery(".rureraform-gettingstarted-bubble").remove();

        jQuery(rureraform_gettingstarted_steps[_screen][_step]["selector"]).addClass("rureraform-gettingstarted-highlight");
        var html = "<div class='rureraform-gettingstarted-bubble rureraform-gettingstarted-bubble-" + rureraform_gettingstarted_steps[_screen][_step]["class"] + "' style='" + rureraform_gettingstarted_steps[_screen][_step]["style"] + "'><p>" + rureraform_gettingstarted_steps[_screen][_step]["text"] + "</p><span onclick=\"rureraform_gettingstarted('" + _screen + "', " + (_step + 1) + ");\">Got it!</span></div>";
        jQuery(".rureraform-gettingstarted-highlight").append(html);
        jQuery(".rureraform-gettingstarted-bubble").fadeIn(300);
    } else {
        jQuery(".rureraform-gettingstarted-overlay").fadeOut(300, function () {
            jQuery(".rureraform-gettingstarted-overlay").remove();
        });
        jQuery(".rureraform-gettingstarted-bubble").fadeOut(300, function () {
            jQuery(".rureraform-gettingstarted-bubble").remove();
        });
        jQuery(".rureraform-gettingstarted-highlight").removeClass("rureraform-gettingstarted-highlight");
        rureraform_write_cookie("rureraform-gettingstarted-" + _screen, "off", 365);
    }
}

function rureraform_email_validator_changed(_object) {
    var value = jQuery(_object).val();
    jQuery(".rureraform-email-validator-options").hide();
    jQuery(".rureraform-email-validator-" + value).fadeIn(200);
    return false;
}

var rureraform_global_message_timer;
function rureraform_global_message_show(_type, _message) {
    clearTimeout(rureraform_global_message_timer);
    jQuery("#rureraform-global-message").fadeOut(300, function () {
        jQuery("#rureraform-global-message").attr("class", "");
        jQuery("#rureraform-global-message").addClass("rureraform-global-message-" + _type).html(_message);
        jQuery("#rureraform-global-message").fadeIn(300);
        rureraform_global_message_timer = setTimeout(function () {
            jQuery("#rureraform-global-message").fadeOut(300);
        }, 5000);
    });
}

function rureraform_escape_html(_text) {
    if (typeof _text != typeof "string")
        return _text;
    if (!_text)
        return "";
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return _text.replace(/[&<>"']/g, function (m) {
        return map[m];
    });
}
function rureraform_is_numeric(_text) {
    return !isNaN(parseInt(_text)) && isFinite(_text);
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
function rureraform_read_cookie(key) {
    var pairs = document.cookie.split("; ");
    for (var i = 0, pair; pair = pairs[i] && pairs[i].split("="); i++) {
        if (pair[0] === key)
            return pair[1] || "";
    }
    return null;
}
function rureraform_write_cookie(key, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else
        var expires = "";
    document.cookie = key + "=" + value + expires + "; path=/";
}

/*
 * Custom Code
 */
$(document).on('click','.editor-add-field',function(){
    
    var field_id = $(this).attr('data-id');
    var field_type = $(this).attr('data-field_type');
    var random_id = Math.floor((Math.random() * 99999) + 1);
    var editorData =  $(".jqte_editor").html();
    var field_data = '';
    if( field_type == 'blank'){
        field_data = '<span class="quiz-input-group"><input type="text" data-field_type="text" size="1" readonly="readonly" class="editor-field field_small" data-id="'+random_id+'" id="field-'+random_id+'"></span>';
    }
    if( field_type == 'select'){
        field_data = '<span class="quiz-input-group">\n\
        <select class="editor-field small" data-id="'+random_id+'" data-field_type="select" id="field-'+random_id+'"></select>\n\</span>';
    }
    
    if( field_type == 'fraction'){
        field_data = '<span class="quiz-input-group" data-id="'+random_id+'" data-field_type="select" id="field-'+random_id+'"><div class="field-group"><span class="divide-numbers"><span contentEditable="true">X</span><em class="divider"></em><span contentEditable="true">X</span></span></div></span>&nbsp;';
    }
    
    if( field_type == 'sq_root'){
        field_data = '<span class="block-holder" data-id="'+random_id+'" data-field_type="select" id="field-'+random_id+'"><span class="lms-root-block">&nbsp;<span class="lms-scaled"><span class="lms-sqrt-prefix lms-scaled" contentEditable="false">&radic;</span><span class="lms-sqrt-stem lms-non-leaf lms-empty" contentEditable="true">X</span></span></span></span>&nbsp;';
    }
    
    if( field_type == 'cube_root'){
        field_data = '<span class="block-holder" data-id="'+random_id+'" data-field_type="select" id="field-'+random_id+'"><span class="lms-root-block"><sup class="lms-nthroot lms-non-leaf"><span contentEditable="true">X</span></sup><span class="lms-scaled"><span class="lms-sqrt-prefix lms-scaled">&radic;</span><span class="lms-sqrt-stem lms-non-leaf lms-empty" contentEditable="true">X</span></span></span></span></span>&nbsp;';
    }
    
    
    pasteHtmlAtCaret(field_data);
    $(".content-data").focus();
    //$(".content-data").append(field_data);
    
});



$(document).on('click','.editor-field',function(){
    var thisObj = $(this);
    var field_id = $(this).attr('data-id');
    var field_type = $(this).attr('data-field_type');
    //var current_value = $(this).attr('data-'+field_type, $(this).val());
    //$(".field-options").html('');
    $(".field-options-all").slideUp();
    if( $("#field-options-"+field_id+"").length < 1){
        var field_layout_html = "<div class='"+field_type+"-field-options field-options-all' id='field-options-"+field_id+"'>"+$('.fields-layout-options').find('.'+field_type+'-field-options').clone().html()+'</div>';
        var field_layout_html = field_layout_html.replace(/field_dynamic_id/g, field_id);
        
        $('.field-options').append(field_layout_html);
        
        $('.field-options').find('.element-field').each(function () {
            var element_field_type = $(this).attr('data-field_type');
            var current_value = thisObj.attr('data-'+element_field_type);
            $(this).val(current_value);
        });
        
    }
    $('.field-options-content #field-options-'+field_id).slideDown();
});

$(document).on('click','.repeater-class',function(){
    var field_type = $(this).attr('data-field_type');
    var field_id = $(this).attr('data-field_id');
    var field_layout_html = "<div class='"+field_type+"-field-options field-options-all' id='field-options-"+field_id+"'>"+$('.fields-layout-options').find('.'+field_type+'-field-options').find('.repeater-fields').html()+'</div>';
     var field_layout_html = field_layout_html.replace(/field_dynamic_id/g, field_id);
    $( ".field-options-content .repeater-fields" ).append(field_layout_html);
    $('.field-options-content #field-options-'+field_id).slideDown();
});

$(document).on('click','.remove-repeater-field',function(){
    $(this).closest('.quiz-form-control').remove();
});

$(document).on('keyup change','.element-field',function(){
    var field_id = $(this).attr('data-field_id');
    var field_type = $(this).attr('data-field_type');
    $(".content-data #field-"+field_id).attr('data-'+field_type, $(this).val());
    
    if( field_type == 'select_option'){
        var options_html = '';
        jQuery(this).closest('.repeater-fields').find('.element-field').each(function (index) {
            options_html += '<option value="' + $(this).val() + '">' + $(this).val() + '</option>';
        });
        $(".content-data #field-"+field_id).html(options_html);
    }else if( field_type == 'field_size'){
        
        $(".content-data #field-"+field_id).removeClass('field_extra_small');
        $(".content-data #field-"+field_id).removeClass('field_small');
        $(".content-data #field-"+field_id).removeClass('field_medium');
        $(".content-data #field-"+field_id).removeClass('field_large');
        $(".content-data #field-"+field_id).addClass($(this).val());
        
        
        
    }else{
         $(".content-data #field-"+field_id).attr(field_type, $(this).val());
    }
});

function update_content_data(){
    var thisVal = $('.content-data').html();
    if( thisVal != 'undefined' && thisVal != undefined){
        var thisVal = thisVal.replace(/readonly="readonly"/g, '');
        var thisVal = thisVal.replace(/contenteditable="true"/g, 'contenteditable="false"');
        $(".content-area").val(thisVal);
    }
}

$(document).on('keyup focus blur change','.content-data',function(){
    update_content_data();
});

$(document).on('click','.generate-question-code',function(){
    update_content_data();
    var thisParentObj = $(this).closest('.rureraform-admin-popup-inner');
    var editorObj =  thisParentObj.find(".content-data");
    var question_fields_obj = [];
    question_fields_obj[0] = {};
    editorObj.find('.editor-field').each(function (index) {
       var field_id = $(this).attr('data-id');
       var field_type = $(this).attr('data-field_type');
       question_fields_obj[0][field_id] = {};
       question_fields_obj[0][field_id]['field_type'] = field_type;
       
       var fieldsListObj = thisParentObj.find('#field-options-'+field_id);
       
       var select_options = [];
       fieldsListObj.find('.element-field').each(function (index) {
           var opt_field_type = $(this).attr('data-field_type');
           var opt_field_value = $(this).val();
           question_fields_obj[0][field_id][opt_field_type] = opt_field_value;
           
           if( opt_field_type == 'select_option'){
               if( opt_field_value != ''){
                  select_options.push(opt_field_value);
               }
           }        
           
       });
        //console.log(select_options);
       
       if( field_type == 'select'){
           if(select_options.length > 0 ){
                question_fields_obj[0][field_id]['select_option']  = select_options;
           }
       }
    });
    
    thisParentObj.find('#rureraform-elements_data').val(rureraform_encode64(JSON.stringify(question_fields_obj)));
    
    rureraform_properties_save();
    
    //console.log(JSON.stringify(question_fields_obj));
    //console.log(question_fields_obj);
    //console.log(editorObj.html());
});

function pasteHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);
            
            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}


$(document).on('click','.quiz-stage-generate',function(){
    
    rureraform_save(this);
    
    
    /*jQuery(".quiz-group").each(function () {
        var group_id = $(this).attr('id');
        console.log(group_id);
        console.log($(this).html());
    });*/
    
});


