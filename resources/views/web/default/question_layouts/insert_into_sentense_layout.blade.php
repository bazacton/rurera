<div id="rureraform-element-{{$element_id}}" class="rureraform-element-{{$element_id}} rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="{{$elementObj->type}}">
	<span class="insert-into-sentense-holder" data-into_type="{{$elementObj->insert_into_type}}">
		<div class="insert-options">
			<span class="given">,</span>
		</div>
		<p data-field_type="insert_into_sentense" type="paragraph" class="editor-field given" data-id="{{$element_unique_id}}" id="field-{{$element_unique_id}}">
		{!! strip_tags($elementObj->content) !!}
		</p>
	</span>
</div>


<script>


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
    
    if (into_type == 'words') {
        var words = p.split(" ");
    }
    
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

$("p.given").html(chunkWords($("p.given").text()));
    $("span.given").draggable({
        helper: "clone",
        revert: "invalid"
    });
    makeDropText($("p.given span.w"));

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
</script>