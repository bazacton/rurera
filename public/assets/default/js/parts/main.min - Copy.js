// !function(t){"use strict";if(t(".dropdown-toggle").dropdown(),t("body").on("click",".close-swl",function(t){t.preventDefault(),Swal.close()}),t(function(){t('[data-toggle="tooltip"]').tooltip()}),window.resetSelect2=function(){jQuery().select2&&t(".select2").select2({width:"100%"})},resetSelect2(),window.loadingSwl=function(){Swal.fire({html:'<div class="d-flex align-items-center justify-content-center my-50 "><img src="/assets/default/img/loading.gif" width="80" height="80"></div>',showCancelButton:!1,showConfirmButton:!1,width:"30rem"})},t("body").on("click",".delete-action",function(e){var n,i;e.preventDefault(),e.stopPropagation();var o=t(this).attr("href"),r='<div class="">\n    <p class="">'+(null!==(n=t(this).attr("data-title"))&&void 0!==n?n:deleteAlertHint)+'</p>\n    <div class="mt-30 d-flex align-items-center justify-content-center">\n        <button type="button" id="swlDelete" data-href="'+o+'" class="btn btn-sm btn-primary">'+(null!==(i=t(this).attr("data-confirm"))&&void 0!==i?i:deleteAlertConfirm)+'</button>\n        <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">'+deleteAlertCancel+"</button>\n    </div>\n</div>";Swal.fire({title:deleteAlertTitle,html:r,icon:"warning",showConfirmButton:!1,showCancelButton:!1,allowOutsideClick:function(){return!Swal.isLoading()}})}),t("body").on("click","#swlDelete",function(e){e.preventDefault();var n=t(this),i=n.attr("data-href");n.addClass("loadingbar primary").prop("disabled",!0),t.get(i,function(t){t&&200===t.code?(Swal.fire({title:void 0!==t.title?t.title:deleteAlertSuccess,text:void 0!==t.text?t.text:deleteAlertSuccessHint,showConfirmButton:!1,icon:"success"}),void 0===t.dont_reload&&setTimeout(function(){void 0!==t.redirect_to&&void 0!==t.redirect_to&&null!==t.redirect_to&&""!==t.redirect_to?window.location.href=t.redirect_to:window.location.reload()},1e3)):Swal.fire({title:deleteAlertFail,text:deleteAlertFailHint,icon:"error"})}).error(function(t){Swal.fire({title:deleteAlertFail,text:deleteAlertFailHint,icon:"error"})}).always(function(){n.removeClass("loadingbar primary").prop("disabled",!1)})}),t.fn.serializeObject=function(){var e={},n=this.serializeArray();return t.each(n,function(){e[this.name]?(e[this.name].push||(e[this.name]=[e[this.name]]),e[this.name].push(this.value||"")):e[this.name]=this.value||""}),e},window.serializeObjectByTag=function(e){var n={},i=e.find("input, textarea, select").serializeArray();return t.each(i,function(){n[this.name]?(n[this.name].push||(n[this.name]=[n[this.name]]),n[this.name].push(this.value||"")):n[this.name]=this.value||""}),n},t(".accordion-row").on("shown.bs.collapse",function(){var e=t(this).find(".collapse-chevron-icon:first");e.removeClass("feather-chevron-down"),e.addClass("feather-chevron-up")}),t(".accordion-row").on("hidden.bs.collapse",function(){var e=t(this).find(".collapse-chevron-icon:first");e.removeClass("feather-chevron-up"),e.addClass("feather-chevron-down")}),t("body").on("change","#userLanguages",function(e){t(this).closest("form").trigger("submit")}),t(document).on("ajaxError",function(e,n){401!==n.status&&403!==n.status||t.toast({heading:forbiddenRequestToastTitleLang,text:forbiddenRequestToastMsgLang,bgColor:"#f63c3c",textColor:"white",hideAfter:1e4,position:"bottom-right",icon:"error"})}),window.handleLimitedAccountModal=function(t){Swal.fire({html:t,showCancelButton:!1,showConfirmButton:!1,width:"30rem"})},window.randomString=function(){for(var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:5,e="",n="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",i=0;i<t;i++)e+=n.charAt(Math.floor(Math.random()*n.length));return e},jQuery().summernote){t(".main-summernote").summernote({dialogsInBody:!0,tabsize:2,height:300,toolbar:[["style",["style"]],["font",["bold","underline","clear"]],["color",["color"]],["para",["ul","ol","paragraph"]],["table",["table"]],["insert",["link","video"]],["view",["fullscreen","codeview","help"]],["popovers",["lfm"]]],buttons:{lfm:function(e){return t.summernote.ui.button({contents:'<i class="note-icon-picture"></i> ',tooltip:"Insert image with filemanager",click:function(){var t,n,i;n=function(t,n){t.forEach(function(t){e.invoke("insertImage",t.url)})},i=(t={type:"file",prefix:"/laravel-filemanager"})&&t.prefix?t.prefix:"/laravel-filemanager",window.open(i+"?type="+t.type||"file","FileManager","width=900,height=600"),window.SetUrl=n}}).render()}}})}var e=t("#advertisingModalSettings");e&&e.length&&Swal.fire({html:e.html(),showCancelButton:!1,showConfirmButton:!1,customClass:{content:"p-0 text-left"},width:"36rem"}),t("body").on("click",".btn-add-product-to-cart",function(e){e.preventDefault();var n=t(this).attr("data-id"),i='\n            <form action="/cart/store" method="post" class="" id="productAddToCartForm">\n                <input type="hidden" name="_token" value="'.concat(window.csrfToken,'">\n                <input type="hidden" name="item_id" value="').concat(n,'">\n                <input type="hidden" name="item_name" value="product_id">\n            </form>\n        ');t("body").append(i),t(this).addClass("loadingbar primary").prop("disabled",!0),t("#productAddToCartForm").trigger("submit")}),feather.replace()}(jQuery);

/* Quantity Funcation Start */

$(document).ready(function () {
    var quantitiy = 0;
    $('.quantity-right-plus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        // If is not undefined
        $('#quantity').val(quantity + 1);

        // Increment
    });
    $('.quantity-left-minus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });

});
/* Quantity Funcation End */

// $(document).ready(function(){
//     if(window.matchMedia("(max-width: 992px)").matches){
//         $('body').css("padding-top", $(".panel-right-sidebar").height());
//     } else{
//       $('body').css("padding-top: 0");
//     }
// });
// $(window).on("resize", function (e) {
//   if(window.matchMedia("(max-width: 992px)").matches){
//       $('body').css("padding-top", $(".panel-right-sidebar").height());
//   } else{
//     $('body').css("padding-top: 0");
//   }
// });


$(document).ready(function () {
    $(window).on("resize", function (e) {
        checkScreenSize();
    });

    checkScreenSize();

    function checkScreenSize() {
        var newWindowWidth = $(window).width();
        if (newWindowWidth < 992) {
            $('body').css("padding-top", $(".panel-right-sidebar").innerHeight());
        } else {
            $('body').css("padding-top", 0);
        }
    }
});

/* Show-more Less-more List Function Start */
if (jQuery('.show-more-btn').length > 0) {
    $(".show-more-btn").click(function () {
        if ($(".lms-chapter-ul-outer ul").hasClass("show-more-items")) {
            $(this).text("Show More");
        } else {
            $(this).text("Show Less");
        }
        ($(this).siblings(".lms-chapter-ul-outer ul").toggleClass("show-more-items"))
    });
}
/* Show-more Less-more List Function End */

/* Lms Sidebar  Click On Section Scroll  Funcation Start */
// document.querySelectorAll('a[href^="#"]').forEach(anchor => {
//     anchor.addEventListener('click', function (e) {
//         e.preventDefault();
//         document.querySelector(this.getAttribute('href')).scrollIntoView({
//             behavior: 'smooth'
//         });
//     });
// });
/* Lms Sidebar  Click On Section Scroll  Funcation End */
/* Lms Sidebar Sricky Funcation Start */
// (function ($) {
//     "use strict";
//     var $navbar = $(".lms-course-fixed"),
//         y_pos = $navbar.offset().top,
//         height = $navbar.height();

//     //scroll top 0 sticky
//     $(document).scroll(function () {
//         var scrollTop = $(this).scrollTop();
//         if (scrollTop > 0) {
//             $navbar.addClass("sticky");
//         } else {
//             $navbar.removeClass("sticky");
//         }
//     });
// })(jQuery, undefined);
/* Lms Sidebar Sricky Funcation End */
$(window).load(function () {
    if (jQuery('.masonry-grid').length > 0) {
        $('.masonry-grid').masonry({
            itemSelector: '.grid-item',
            isFitWidth: true
        });
    }
});
/*Lms Back to Top Button Function Start*/
$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 1200) {
            $('.scroll-btn').fadeIn();
        } else {
            $('.scroll-btn').fadeOut();
        }
    });


    // $(function() {
    //     $('.scroll-btn').click(function() {
    //       if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    //         var target = $(this.hash);
    //         target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
    //         if (target.length) {
    //           $('html,body').animate({
    //               //the 205 is a fixed header offset
    //             scrollTop: target.offset().top - 0
    //           }, 1000);
    //           return false;
    //         }
    //       }
    //     });
    //   });

    $('.round').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.arrow').toggleClass('bounceAlpha');
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });


    $(function () {
        $('.lms-element-nav li a').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        //the 205 is a fixed header offset
                        scrollTop: target.offset().top - 100
                    }, 1000);
                    return false;
                }
            }
        });
    });
    if (jQuery('.lms-testimonial-slider .swiper-container').length > 0) {
        const swiper = new Swiper('.lms-testimonial-slider .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 0,
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },

                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },

                640: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        })
    }
    if (jQuery('.lms-library-slider .swiper-container').length > 0) {
        const swiper2 = new Swiper('.lms-library-slider .swiper-container', {
            slidesPerView: 4,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },

                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },

                640: {
                    slidesPerView: 4,
                    spaceBetween: 30
                }
            }
        })
    }
    // if(jQuery('.quiz-pagination .swiper-container').length > 0){
    //     console.log('slides-count');
    //     console.log($(".quiz-pagination ul li").length);
    //   const swiper = new Swiper('.quiz-pagination .swiper-container', {
    //     slidesPerView: ($(".quiz-pagination ul li").length > 18)? 18 : $(".quiz-pagination ul li").length,
    //     spaceBetween: 5,
    //     // slidesPerGroup: 10,
    //      speed: 600,
    //     navigation: {
    //         nextEl: ".swiper-button-next",
    //         prevEl: ".swiper-button-prev",
    //     },
    //     breakpoints: {
    //       320: {
    //         slidesPerView: 3,
    //         spaceBetween: 5
    //       },

    //       480: {
    //         slidesPerView: ($(".quiz-pagination ul li").length > 18)? 18 : $(".quiz-pagination ul li").length,
    //         spaceBetween: 5
    //       },

    //       640: {
    //         slidesPerView: ($(".quiz-pagination ul li").length > 18)? 18 : $(".quiz-pagination ul li").length,
    //         spaceBetween: 5
    //       }
    //     }
    //   })
    // }
    if (jQuery('.open-controls-btn').length > 0) {
        $('.open-controls-btn').click(function () {
            $(this).parents('.textboard-holder').toggleClass('open')
        });
    }
    if (jQuery('.controls-close-btn').length > 0) {
        $('.controls-close-btn').click(function () {
            $(this).parents('.textboard-holder').toggleClass('open')
        });
    }

    if (jQuery('.testimonial-card .swiper-container').length > 0) {
        const swiper3 = new Swiper('.testimonial-card .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 1500,
            loop: true,
            autoplay: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },

                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },

                640: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        })
    }
    if (jQuery('.gallery-slider .swiper-container').length > 0) {
        const swiper3 = new Swiper('.gallery-slider .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 1500,
            loop: true,
            autoplay: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            }
        })
    }
    if (jQuery('.latest-webinars-swiper').length > 0) {
        const swiper = new Swiper(".latest-webinars-swiper", {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            autoplay: {delay: 5e3, disableOnInteraction: !1},
            pagination: {el: ".swiper-pagination", clickable: !0},
            breakpoints: {991: {slidesPerView: 4}, 660: {slidesPerView: 2}},
        });
    }
    if (jQuery('.testimonials-swiper.swiper-container').length > 0) {
        const swiper = new Swiper(".testimonials-swiper.swiper-container", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {delay: 5e3, disableOnInteraction: !1},
            pagination: {el: ".swiper-pagination", clickable: !0},
            breakpoints: {
                991: {
                    slidesPerView: 3
                },
                660: {
                    slidesPerView: 2,
                    spaceBetween: 0
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            },
        });
    }

    /* Product Tabs Slider Funcation Start */
    if (jQuery('.product-tabs-slider.swiper-container').length > 0) {
        const swiper = new Swiper(".product-tabs-slider.swiper-container", {
            slidesPerView: 3,
            spaceBetween: 30,
            observer: true,
            observeParents: true,
            loop: false,
            autoplay: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                991: {
                    slidesPerView: 2
                },
                660: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            },
        });
    }
    /* Product Tabs Slider Funcation End */

    // var scene = document.getElementById('parallax1');
    //   var parallaxInstance = new Parallax(scene, {
    //   relativeInput: true
    // });
    // var scene2 = document.getElementById('parallax2');
    //   var parallaxInstance = new Parallax(scene2, {
    //   relativeInput: true
    // });
    // var scene3 = document.getElementById('parallax3');
    //   var parallaxInstance = new Parallax(scene3, {
    //   relativeInput: true
    // });


    var fieldLinks;
    var inputOri;
    $(document).ready(function () {
        inputOri = {
            "localization": {},
            "options": {
                //"associationMode": "manyToMany", // oneToOne,manyToMany
                "lineStyle": "square-ends",
                //"buttonErase": "Erase Links",
                "displayMode": "original",
                "whiteSpace": $("input[name='whiteSpace']:checked").val(), //normal,nowrap,pre,pre-wrap,pre-line,break-spaces default => nowrap
                "mobileClickIt": false,
                "oneToMany": "off",
                "autoDetect": "off"
            },
            "Lists": [
                {
                    "name": "Columns in files",
                    "list": [
                        "1,0009,909",
                        "1,023,065",
                        "1,0009,908",
                        "1,230,650",
                        //"role",
                        //"Birthday",
                        //"Adress",
                        //"City"
                    ]
                },
                {
                    "name": "Available Fields",
                    "list": [
                        //"Company",
                        //"jobTitle",
                        //"adress",
                        //"adress",
                        //"adress",
                        "1st",
                        "2nd",
                        "4th",
                        "3rd",
                    ],
                    // "mandatories": [
                    // 	"last_name",
                    // 	"email_adress"
                    // ]
                }
            ],
            //"existingLinks": [{ "from": "lastName", "to": "last_name" }, { "from": "firstName", "to": "first_name" }, { "from": "role", "to": "jobTitle" }]
        };


        $(".fieldLinkerSave").on("click", function () {
            var results = fieldLinks.fieldsLinker("getLinks");
            $("#output").html("output => " + JSON.stringify(results));
        });
        if (jQuery('#original').length > 0) {
            fieldLinks = $("#original").fieldsLinker("init", inputOri);
        }
    });
    if (jQuery('.quiz-toggle-btn').length > 0) {
        $('.quiz-toggle-btn').click(function () {
            $(this).parents('body').toggleClass('quiz-show')
        });
    }
    if (jQuery('body').length > 0) {
        $("body").addClass('quiz-show');
    }


    if (jQuery('.read-text-btn').length > 0) {
        $('.read-text-btn').click(function () {
            curSize = parseInt($('.quiz-info-inner p').css('font-size')) + 1;
            if (curSize <= 24) {
                $('.quiz-info-inner p').css('font-size', curSize);
            } else {
                $('.quiz-info-inner p').css('font-size', '15px');
            }
        });
    }

    var lastSelection;
    document.addEventListener("selectionchange", function () {
        lastSelection = window.getSelection();
    });
    var highlights = document.getElementById("highlights");

    function getSelectionCharacterOffsetsWithin(btnColor) {
        var selectedText = "null";
        if (typeof window.getSelection != "undefined") {
            var selection = window.getSelection();
            selectedText = selection.toString();
            var range = selection.getRangeAt(0);
            //Strip trailing punctation
            selectedText = selectedText.replace(/[\s.,!?:;'"-]+$/, "");
            //Leading space / quotes
            var offset = 0;
            var match = selectedText.match(/^[\s"']+/);
            if (match)
                offset = match[0].length;
            selectedText = selectedText.replace(/^[\s"']+/, "");
            if (selectedText === "") {
                alert("Error: you must select at least one character");
                tartOffset = 0, endOffset = 0, selectedText = "null";
            } else {
                var newInputid = parseInt(Math.random() * 10000);
                //This is code to keep word highlighted after selecting
                var newNode = document.createElement("span");
                newNode.classList.add('chosen');
                var previd = ("i" + newInputid);
                newNode.setAttribute('data-cid', previd);
                newNode.appendChild(range.extractContents());
                newNode.style.backgroundColor = btnColor;
                range.insertNode(newNode);
            }
        }
        return {
            text: selectedText,
            cid: previd
        };
    }

    if (jQuery('.text-highlight-btn').length > 0) {
        $('.text-highlight-btn').on('click', function (e) {
            e.preventDefault();
            var btnColor = $(this)[0].style.color;
            var selOffsets = getSelectionCharacterOffsetsWithin(btnColor);
            var selectedText = selOffsets.text;
            var selectedID = selOffsets.cid
            var txt = document.createTextNode(selectedText);
            var span = document.createElement('span');
            span.appendChild(txt);
            span.setAttribute('data-cid', selectedID);
            span.classList.add('highlighted');
            highlights.appendChild(span);
        });
    }
    if (jQuery('.quiz-info-inner').length > 0) {
        $('.quiz-info-inner').on('dblclick', '.chosen', function () {
            var cid = this.getAttribute('data-cid');
            highlights.querySelector('[data-cid=' + cid + ']').remove();
            (this).replaceWith(this.innerText);
        });
    }

    /*Lms Back to Top Button Function End*/

// $(document).on('click', '.testimonial-tabs li', function (e) {
//     if(jQuery('.masonry-grid').length > 0){
//         $('.masonry-grid').masonry({
//           itemSelector: '.grid-item',
//         });
//         msnry.reloadItems();
//       }
// });


// $('.testimonial-tabs.nav-tabs .nav-link').click(function (e)
// {
//      $("[id^='tab']").hide();
//      e.preventDefault()
//      var ids=$(this).data('tab');
//      $("#"+ids).show();
//      $('.masonry-grid').masonry({
//       itemSelector: '.grid-item',

//     });
//  })
// $('.testimonial-tabs.nav-tabs .nav-link').on('click', function() {
//   // do async to allow menu to open
//   setTimeout( function() {
//      $('.masonry-grid').masonry({
//     itemSelector: '.grid-item'
//      }, 500);
//   });
// });
// init Isotope

    $(document).ready(function () {
        $('.lms-accordion-simple .card').click(function () {
            $('.lms-accordion-simple .card').removeClass("active");
            $(this).addClass("active");
        });
        $('.lms-accordion-modern .card').click(function () {
            $('.lms-accordion-modern .card').removeClass("active");
            $(this).addClass("active");
        });
        if (window.matchMedia("(max-width: 992px)").matches) {
            $(".navbar-nav .nav-link").click(function () {
                var target = $(this).parent().children(".sidenav-dropdown");
                $(target).slideToggle();
                $(this).toggleClass("collapsed");
            });
            $(".navbar-nav .nav-item").each(function () {
                if ($(this).has(".sidenav-dropdown").length) {
                    $(".navbar-nav .nav-item a").addClass("collapsed");
                }
            });
        }
        $(".has-mega-menu .nav-link").click(function (e) {
            $(".lms-mega-menu").slideToggle();
            $(".lms-mega-menu").toggleClass("menu-open");
            e.preventDefault();
        });

        // Tabs To Accordion Function Start
        var byt = $("body").width();
        if (byt < 992) {
            tabToAcor("#navbar");
        }

        function tabToAcor(id) {
            var link = "";
            var inn = "";
            var ic = "";
            var ic2 = "";
            $(id).addClass("panel-group");
            $(id).find(".mega-menu-nav li").each(function (e) {
                if (e < 1) {
                    inn = "in";
                } else {
                    inn = "";
                }
                link = $(this).find("a").attr("href");
                ic2 = $(this).find("a").html();
                $(link).removeAttr("role");
                $(link).removeClass();
                $(link).css("padding", "0");
                $(link).addClass("panel panel-default pull-left col-xs-12 nopadding");
                ic = $(link).html();
                $(link).html("");
                $(link).prepend('<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="' + link + '" href="' + link + '1">' + ic2 + '</a></h4></div>');
                $(link).append('<div id="' + link.substring(1, link.length) + '1" class="panel-collapse collapse ' + inn + '"><div class="panel-body"> ' + ic + '</div></div>');
            });
            $(id).find(".mega-menu-nav").remove();
        }

        $(".mega-menu-body .panel").each(function () {
            if ($(this).has(".panel-collapse").length) {
                $(".panel-heading .panel-title a").addClass("collapsed");
            }
        });
        // Tabs To Accordion Function End
        feather.replace()
    });


    $(document).on('click', '.mega-menu-nav a', function () {
        var value = $(this).attr('id');
        var category_color = $(this).attr('data-category_color');
        $("body").get(0).style.setProperty("--category-color", category_color);
        $('.mega-menu-head').attr('class', 'mega-menu-head');
        $('.mega-menu-head').addClass(value);
    });

    // if (jQuery('.rurera-tooltip').length > 0) {
    //     $('.rurera-tooltip').on('click', function() {
            
    //         $(this).find(".lms-tooltip").toggleClass("show");
            
    //     });
    // }
    if (jQuery('.spell-levels .panel-subheader + .treasure-stage .rurera-tooltip').length > 0) {
        $(".spell-levels .panel-subheader + .treasure-stage .rurera-tooltip").click(function() {
            $('html, body').animate({
                scrollTop: $(".lms-tooltip").offset().top - 100
            }, 100);
        });
    }

});



$(document).on('submit', '.create_student_form', function (e) {
    returnType = rurera_validation_process($(this));
    if (returnType == false) {
        return false;
    }
    rurera_loader($(this).find('.submit-button'), 'div');
    return true;
});

$(document).on('click', '.js-switch-user', function (e) {
    var child_id = $(this).attr('data-child');
    rurera_loader($(this), 'div');
    jQuery.ajax({
        type: "POST",
        url: '/switch_user',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {"child_id": child_id},
        success: function (return_data) {
            window.location.href = '/panel';
        }
    });
    //rurera_loader($(this), 'page');
});

$(document).on('click', '.cancel-subscription', function (e) {
    var child_id = $(this).attr('data-child');
    rurera_loader($(this), 'div');
    jQuery.ajax({
        type: "POST",
        url: '/panel/cancel_subscription',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {"child_id": child_id},
        success: function (return_data) {
            jQuery.growl.notice({
                title: '',
                message: 'Updated Successfully',
            });
            window.location.href = '/panel';
        }
    });
    //rurera_loader($(this), 'page');
});


function rurera_loader(thisObj, loader_type) {

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
            $('body').append('<div class="rurera-button-loader" style="display: block;">\n\
                        <div class="preloader"><img src="/assets/default/img/preloaders/' + loader_no + '.webp"><span class="preloader-text">Sharpen your wits and get ready to unravel mind-bending questions and brain teasers in our upcoming quiz</span></div>\n\
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
        case "div":
            thisObj.removeClass('rurera-processing');
            $('body').find('.rurera-button-loader').remove();
            break;
        case "page":
            $('body').removeClass('rurera-processing');
            $('body').find('.rurera-button-loader').remove();
            break;
    }
}

function FieldIsEmpty(dataValue) {
    is_empty = true;
    if (dataValue != '' && dataValue != 'undefined' && dataValue != undefined) {
        is_empty = false;
    }
    return is_empty;
}


$(document).on('click', '.user-assignments-tab', function (e) {
    var fetch_type = $(this).attr('data-type');
    var content_id = $(this).attr('data-content_id');
    rurera_loader($('#' + content_id), 'div');
    jQuery.ajax({
        type: "GET",
        url: '/panel/get_user_assignments',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {"fetch_type": fetch_type},
        success: function (return_data) {
            $('#' + content_id + ' .assignments-list ul').html(return_data);
            console.log(content_id);
            rurera_remove_loader($('#' + content_id), 'div');
            //window.location.href = '/panel';
        }
    });

});

$(document).ready(function () {
    if (jQuery('.panel-right-sidebar .navbar-toggler, .panel-sidebar .navbar-toggler').length > 0) {
        $('.panel-right-sidebar .navbar-toggler, .panel-sidebar .navbar-toggler').click(function () {
            $('.sidebar-menu-holder').toggleClass('show');
        });
    }
    if (jQuery('.levels-progress.circle').length > 0) {
        $(".levels-progress.circle").each(function () {
            var $this = $(this),
                $dataV = $this.data("percent"),
                $dataDeg = $dataV * 3.6,
                $round = $this.find(".progress-count");
            $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
            $this.append('<div class="circle_inbox"><span class="percent_text"></span></div>');
            $this.prop('Counter', 0).animate({Counter: $dataV},
                {
                    duration: 2000,
                    easing: 'swing',
                    step: function (now) {
                        $this.find(".percent_text").text(Math.ceil(now) + "%");
                    }
                });
            if ($dataV >= 51) {
                $round.css("transform", "rotate(" + 360 + "deg)");
                setTimeout(function () {
                    $this.addClass("percent_more");
                }, 1000);
                setTimeout(function () {
                    $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
                }, 1000);
            }
        });
    }

    // $(function() {
    //   var top = $('.panel-right-sidebar').offset().top - parseFloat($('.panel-right-sidebar').css('marginTop').replace(/auto/, 0));
    //   var footTop = $('.hidden-footer').offset().top - parseFloat($('.hidden-footer').css('marginTop').replace(/auto/, 0));

    //   var maxY = footTop - $('.panel-right-sidebar').outerHeight();

    //   $(window).scroll(function(evt) {
    //     var y = $(this).scrollTop();
    //     if (y < top) {
    //       if (y > maxY) {
    //         $('.panel-right-sidebar').addClass('fixed').removeAttr('style');
    //       } else {
    //         $('.panel-right-sidebar').removeClass('fixed').css({
    //           position: 'absolute',
    //           top: (maxY - top) + 'px'
    //         });
    //       }
    //     } else {
    //       $('.panel-right-sidebar').removeClass('fixed');
    //     }
    //   });
    // });

    //   $(window).scroll(function () {
    //     var threshold = 40;

    //     if ($(window).scrollTop() >= threshold)
    //         $('.panel-right-sidebar').addClass('fixed');
    //     else
    //         $('.panel-right-sidebar').removeClass('fixed');
    //     var check = $(".panel-page-section").height() - $(".panel-right-sidebar").height()+20;
    //     if ($(window).scrollTop() >= check)
    //         $('.panel-right-sidebar').addClass('bottom');
    //     else
    //         $('.panel-right-sidebar').removeClass('bottom');
    // });
    // if(jQuery('.panel-right-sidebar').length > 0){
    //   var stickySidebar = new StickySidebar('.panel-right-sidebar', {
    //     topSpacing: 20,
    //     bottomSpacing: 20,
    //     containerSelector: '.panel-page-section',
    //     innerWrapperSelector: '.panel-right-sidebar > .row'
    //   });
    // }
    if (jQuery('.key-statistics .swiper').length > 0) {
        var swiper = new Swiper(".key-statistics .swiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    }
    if (jQuery('.input').length > 0) {
        $(function () {
            var inputs = $('.input');
            var paras = $('.description-flex-container').find('p');
            inputs.click(function () {
                var t = $(this),
                    ind = t.index(),
                    matchedPara = paras.eq(ind);
                t.add(matchedPara).addClass('active');
                inputs.not(t).add(paras.not(matchedPara)).removeClass('active');
            });
        });
    }
    if (jQuery('.navbar-toggler').length > 0) {
        $('.navbar-toggler').click(function () {
            $('body').toggleClass('panel-sidebar-open')
        });
    }
    if (jQuery('.sidebar-menu .sidenav-item').length > 0) {
        $(".sidebar-menu .sidenav-item").on("click", ".dropdown-toggle", function (e) {
            e.preventDefault();
            $(this).parent().addClass("show");
            $(this).attr("aria-expanded", "true");
            $(this).next().addClass("show");
        });
    }

    /* Partner Logo Slider Funcation Start */
    if (jQuery('.partner-slider .swiper-container').length > 0) {
        const swiper = new Swiper(".partner-slider .swiper-container", {
            slidesPerView: 7,
            spaceBetween: 30,
            loop: true,
            autoplay: true,
            breakpoints: {
                991: {
                    slidesPerView: 7
                },
                660: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            },
        });
    }
    /* Partner Logo Slider Funcation End */
    // wow = new WOW(
    //   {
    //     animateClass: 'animated',
    //     offset:       0,
    //     callback:     function(box) {
    //       console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
    //     }
    //   }
    // );
    // wow.init();

    if (jQuery('.footer-dots-img').length > 0) {
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            $(".footer-dots-img").css({
                transform: 'scale(' + (145 - scroll / 100) / 100 + ')'
            });
        });
    }


    $.fn.moveIt = function () {
        var $window = $(window);
        var instances = [];

        $(this).each(function () {
            instances.push(new moveItItem($(this)));
        });

        window.addEventListener('scroll', function () {
            var scrollTop = $window.scrollTop();
            instances.forEach(function (inst) {
                inst.update(scrollTop);
            });
        }, {passive: true});
    }

    var moveItItem = function (el) {
        this.el = $(el);
        this.speed = parseInt(this.el.attr('data-scroll-speed'));
    };

    moveItItem.prototype.update = function (scrollTop) {
        this.el.css('transform', 'translateY(' + -(scrollTop / this.speed) + 'px)');
    };
    if (jQuery('[data-scroll-speed]').length > 0) {
        $(function () {
            $('[data-scroll-speed]').moveIt();
        });
    }
    if (jQuery(".recent-reviews-section .swiper-container").length > 0) {
        new Swiper(".recent-reviews-section .swiper-container", {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 2e3,
            loop: !0,
            breakpoints: {
                320: {slidesPerView: 1, spaceBetween: 0},
                480: {slidesPerView: 1, spaceBetween: 0},
                640: {slidesPerView: 1, spaceBetween: 0},
                992: {slidesPerView: 1, spaceBetween: 0}
            },
        });
    }

    if (jQuery(".filter-mobile-btn").length > 0) {
        $('.filter-mobile-btn').on('click', function (e) {
            $('.filters-list .analytics-type, .tests-list,  .inline-filters').toggleClass("open");
            e.preventDefault();
        });
    }

    if (jQuery(".tests-list > li").length > 0) {
        $('.tests-list > li').on('click', function (e) {
            $('.tests-list').toggleClass("open");
            e.preventDefault();
        });
    }

});

$('body').on('click', '.shortlist-btn', function (e) {
    var thisObj = $(this);
    var product_id = $(this).attr('data-product_id');
    var action_type = $(this).attr('data-type');
    rurera_loader(thisObj, 'div');
    jQuery.ajax({
        type: "POST",
        url: '/products/update-shortlist',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {"product_id": product_id, "action_type": action_type},
        success: function (return_data) {
            thisObj.find('img').removeClass('heart-fill');
            thisObj.find('img').removeClass('heart-alt');
            if (action_type == 'add') {
                thisObj.find('img').addClass('heart-fill');
                thisObj.find('img').attr('src', '/assets/default/svgs/heart-fill.svg');
                thisObj.attr('data-type', 'remove');
            }
            if (action_type == 'remove') {
                thisObj.find('img').addClass('heart-alt');
                thisObj.find('img').attr('src', '/assets/default/svgs/heart-alt.svg');
                thisObj.attr('data-type', 'add');
            }
            rurera_remove_loader(thisObj, 'div');
            jQuery.growl.notice({
                title: '',
                message: 'Updated Successfully',
            });
        }
    });
});

$("body").on("click", ".subscription-required", function (e) {
    e.preventDefault();
    $(".subscription-modal").modal('show');
});


/*
*Subscription Code
 */

var subscriptionRequest = null;
var userGenerateRequest = null;
var selectedPackage = null;
var subscribed_for = 0;
var CSRFTOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).on('click', '.subscription-modal', function (e) {
    var action_type = $(this).attr('data-type');
    var action_id = $(this).attr('data-id');
    var action_reason = $(this).attr('data-reason');
    selectedPackage = action_id;
    $(".subscription-content").html('');
    $("#subscriptionModal").modal('show');
    rurera_loader($('.subscription-content'), 'div');
    subscriptionRequest = jQuery.ajax({
        type: "GET",
        url: '/subscribes/apply-subscription',
        async: true,
        beforeSend: function () {
            if (subscriptionRequest != null) {
                subscriptionRequest.abort();
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {"action_type": action_type, "action_id": action_id, "action_reason": action_reason},
        success: function (return_data) {
            rurera_remove_loader($('.subscription-content'), 'div');
            $(".subscription-content").html(return_data);
        }
    });
});



if ($(".add-child-btn").length > 0) {
    $(".add-child-btn").click();
}
$(document).on('click', '.cancel-subscription-modal', function (e) {
    var child_id = $(this).attr('data-id');
	var package_data = $(this).closest('.list-group-item').find('.package-data').html();
	$(".cancel-package-data").html(package_data);
	$(".cancel-package-data .package-data").removeClass('rurera-hide');
    $(".cancel-subscription-btn").attr('data-child_id', child_id);
    $("#cancelsubscriptionModal").modal('show');
});
$(document).on('click', '.unlink-modal', function (e) {
    var child_id = $(this).attr('data-id');
    $(".unlink-btn").attr('data-child_id', child_id);
    $("#unlinkModal").modal('show');
});


$(document).on('click', '.unlink-btn', function (e) {
    var child_id = $(this).attr('data-child_id');
    rurera_loader($('.unlink-block'), 'div');
    $.ajax({
        type: "POST",
        url: '/subscribes/unlink-user',
        data: {"child_id": child_id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (return_data) {
			$("#unlinkModal").modal('hide');
            //rurera_remove_loader($('.unlink-block'), 'div');
            //window.location.href = '/parent/students';
			Swal.fire({
                icon: 'success',
                html: '<h3 class="font-20 text-center text-dark-blue py-25">Successfully Unlinked</h3>',
                showConfirmButton: false,
                width: '25rem'
            });
        }
    });
});
$(document).on('click', '.cancel-subscription-btn', function (e) {
    var child_id = $(this).attr('data-child_id');
    rurera_loader($('.cancel-membership-block'), 'div');
    $.ajax({
        type: "POST",
        url: '/subscribes/cancel-subscription',
        data: {"child_id": child_id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (return_data) {
            //rurera_remove_loader($('.cancel-membership-block'), 'div');
            window.location.href = '/panel/members';
        }
    });
});

$(document).on('click', '.signup-btn-submit', function (e) {
    returnType = rurera_validation_process($('.signup-form'), 'under_field');
    if (returnType == false) {
        return false;
    }
    rurera_loader($('.subscription-content'), 'div');
    //$(".signup-form").submit();
    var formData = new FormData($('.signup-form')[0]);
    rurera_loader($('.subscription-content'), 'div');
    $.ajax({
        type: "POST",
        url: '/signup-submit',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (return_data) {
            //rurera_remove_loader($('.subscription-content'), 'div');
            //$(".subscription-content").html(return_data);
            window.location.href = '/parent/students';

        }, error: function error(err) {
            rurera_remove_loader($('.subscription-content'), 'div');
            var errors = err.responseJSON.errors;
            var error_mesages = '';
            for (var key in errors) {
                if (errors.hasOwnProperty(key)) {
                    var errorMessages = errors[key];
                    errorMessages.forEach(function (errorMessage) {
                        error_mesages += errorMessage + '<br>';
                        console.log("Field: " + key + ", Error: " + errorMessage);
                        // Perform any other action you need with the error message
                    });
                }
            }
            Swal.fire({
                icon: 'error',
                html: '<h3 class="font-20 text-center text-dark-blue py-25">' + error_mesages + '</h3>',
                showConfirmButton: false,
                width: '25rem'
            });
        }
    });
});
$(document).on('click', '.signup-btn-submit1', function (e) {
    var formData = new FormData($('.signup-form')[0]);
    rurera_loader($('.subscription-content'), 'div');
    $.ajax({
        type: "POST",
        url: '/signup-submit',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (return_data) {
            //rurera_remove_loader($('.subscription-content'), 'div');
            //$(".subscription-content").html(return_data);
            //window.location.href = return_data;

        }
    });
});

$(document).on('click', '.subscription-tenure-btn', function (e) {
    var formData = new FormData($('.subscription-tenure-form')[0]);
    rurera_loader($('.subscription-content'), 'div');
    subscribed_for = $('input[name="subscribe_for"]:checked').val();
    $.ajax({
        type: "POST",
        url: '/subscribes/tenure-submit',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (return_data) {
            rurera_remove_loader($('.subscription-content'), 'div');
            $(".subscription-content").html(return_data);
        }
    });
});

function auto_generate_username(is_auto) {

    var first_name = $(".user-first-name").val();
    var last_name = $(".user-last-name").val();
    if ($('.username-auto-generate').prop('checked') || is_auto != 'auto') {
        $(".username-field").prop('readonly', true);
        //$(".password-field").prop('readonly', true);
        //rurera_loader($('.subscription-content'), 'div');
        userGenerateRequest = $.ajax({
            type: "GET",
            url: '/subscribes/autogenerte-username',
            beforeSend: function () {
                if (userGenerateRequest != null) {
                    userGenerateRequest.abort();
                }
            },
            data: {"first_name": first_name, "last_name": last_name, "autogenerate": 'yes'},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (return_data) {
                //rurera_remove_loader($('.subscription-content'), 'div');
                $(".usernames-suggestions").html('');
                $(".username-field").val(return_data);
                //$(".password-field").val('123456');
                $(".generatePassword").click();
                //$(".password-suggestions").html('123456');
            }
        });
    } else {

        $(".username-field").prop('readonly', false);
        $(".password-field").prop('readonly', false);
        $(".username-field").val('');
        $(".password-field").val('');
        $(".password-suggestions").html('');
        //rurera_loader($('.subscription-content'), 'div');
        userGenerateRequest = $.ajax({
            type: "GET",
            url: '/subscribes/autogenerte-username',
            beforeSend: function () {
                if (userGenerateRequest != null) {
                    userGenerateRequest.abort();
                }
            },
            data: {"first_name": first_name, "last_name": last_name},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (return_data) {
                //rurera_remove_loader($('.subscription-content'), 'div');
                $(".usernames-suggestions").html(return_data);
            }
        });
        //$(".usernames-suggestions").html('');
    }
}

$(document).on('change', '.username-auto-generate', function (e) {
    auto_generate_username('no');
});
$(document).on('click', '.username-auto-generate', function (e) {
    auto_generate_username('no');
});
$(document).on('keyup change', '.user-first-name, .user-last-name', function (e) {
    auto_generate_username('auto');
});


$(document).on('click', '.usernames-suggestions span', function (e) {
    var username_suggestion = $(this).attr('data-label');
    $(".username-field").val(username_suggestion);
});

$(document).on('click', '.packages-back-btn', function (e) {
    var user_id = $(this).attr('data-user_id');
    var subscribed_for = $(this).attr('data-subscribed_for');
    rurera_loader($('.subscription-content'), 'div');
    $.ajax({
        type: "GET",
        url: '/subscribes/packages-list',
        data: {"user_id": user_id, "subscribed_for": subscribed_for},
        success: function (return_data) {
            rurera_remove_loader($('.subscription-content'), 'div');
            $(".subscription-content").html(return_data);
			$('.subscribed_for-field').change();
        }
    });
});


$(document).on('submit', '.rurera-form-validation', function (e) {
	var formData = new FormData($('.rurera-form-validation')[0]);
	returnType = rurera_validation_process($(".rurera-form-validation"), 'under_field');
	if (returnType == false) {
		return false;
	}
	return true;
});

$(document).on('focusout', '.child-register-form .rurera-req-field', function (e) {
	var formData = new FormData($('.child-register-form')[0]);
    returnType = rurera_validation_process($(".child-register-form"), 'under_field');
    if (returnType == false) {
        return false;
    }
});
$(document).on('submit', '.child-register-form', function (e) {
    var formData = new FormData($('.child-register-form')[0]);
    returnType = rurera_validation_process($(".child-register-form"), 'under_field');
    if (returnType == false) {
        return false;
    }
    formData.append('selected_package', selectedPackage);
    rurera_loader($('.subscription-content'), 'div');
    $.ajax({
        type: "POST",
        url: '/subscribes/register-child',
        data: formData,
        processData: false,
        contentType: false,
        success: function (return_data) {
            rurera_remove_loader($('.subscription-content'), 'div');
            $(".subscription-content").html(return_data);
        }
    });
    return false;
});
$(document).on('submit', '.child-edit-form', function (e) {
    var formData = new FormData($('.child-edit-form')[0]);
	console.log('submission');
    returnType = rurera_validation_process($(".child-edit-form"), 'under_field');

    if (returnType == false) {
        return false;
    }
    rurera_loader($('.child-edit-form'), 'div');
    $.ajax({
        type: "POST",
        url: '/subscribes/edit-child',
        data: formData,
        processData: false,
        contentType: false,
        success: function (return_data) {
            location.reload();
        }
    });
});


$(document).on('click', '.package-selection', function (e) {
    var package_id = $(this).attr('data-id');
    var user_id = $(this).attr('data-user_id');
    var subscribed_for = $('input[name="subscribed_for"]:checked').val();
    var formData = new FormData($('.package-register-form')[0]);
    console.log(subscribed_for);
    selectedPackage = package_id;
    formData.append('selected_package', package_id);
    formData.append('subscribed_for', subscribed_for);
    formData.append('user_id', user_id);
    rurera_loader($('.subscription-content'), 'div');
    $.ajax({
        type: "POST",
        url: '/subscribes/payment-form',
        data: formData,
        processData: false,
        contentType: false,
        success: function (return_data) {
            rurera_remove_loader($('.subscription-content'), 'div');
            $(".subscription-content").html(return_data);
        }
    });
    return false;
});

$(document).on('click', '.process-payment', function (e) {
    rurera_loader($('.process-payment'), 'div');
    var subscribed_for = $(this).attr('data-subscribed_for');
    var coupon_code = $('.coupon_code').val();
    var user_id = $(this).attr('data-user_id');
    $.ajax({
        type: "POST",
        url: '/subscribes/pay',
        data: {"selectedPackage": selectedPackage, "user_id": user_id, "subscribe_for": subscribed_for, "coupon_code": coupon_code},
        success: function (return_data) {
            //rurera_remove_loader($('.process-payment'), 'div');
            $(".googlepay-gateway-fields").html(return_data);
        }
    });
});


$(document).on('click', '.generatePassword', function (e) {
    var passwordInput = $(this).attr("data-input_class");
    var newPassword = generatePassword(8);
    $("." + passwordInput).val(newPassword);
});

$(document).on('click', '#generateBtn', function (e) {
    var passwordInput = $(".password-field");
    var newPassword = generatePassword(8);
    passwordInput.val(newPassword);
});

function generatePassword(length) {
    var commonWords = ["fun", "sky", "joy", "star", "sun", "pet", "awe", "run", "gem", "toy", "win", "jam", "cup", "joy", "dino", "hero", "fairy", "baby", "treat", "find", "play", "home", "bot", "seek", "ninja", "fay", "king", "icy", "wiz", "snow", "rose", "rainbow", "unicorn", "star", "galaxy", "candy", "puppy", "kitten", "adventure", "magic", "smile", "happy", "sunshine", "beach", "butterfly", "dinosaur", "superhero", "princess", "dragon", "cookie", "treasure", "jungle", "mermaid", "spaceship", "robot", "pirate", "ninja", "fairy", "castle", "adventure", "ice", "cream", "rocket", "superhero", "spaceship", "skateboard", "popcorn", "cupcake", "rainbow", "magic", "wizard", "snowflake", "flower", "music", "sunset", "garden", "cake", "fish", "bird", "frog", "moon", "bug", "pie", "hat", "ball", "tree", "duck", "bee", "leaf", "shell", "car", "boat", "bike", "train", "bear", "lion", "tiger", "elephant", "giraffe", "snake", "butterfly", "robot", "rocket", "starfish", "rainbow", "jellyfish"];
    var commonFoods = ["Apple", "Banana", "Orange", "Grapes", "Pear", "Mango", "Strawberry", "Kiwi", "Pineapple", "Watermelon", "Blueberry", "Raspberry", "Peach", "Cherry", "Plum", "Lemon", "Lime", "Avocado", "Coconut", "Papaya", "Guava", "Apricot", "Fig", "Blackberry", "Cranberry", "Pomegranate", "Dragonfruit", "Cantaloupe", "Honeydew", "Lychee", "Passionfruit", "Tangerine", "Grapefruit", "Kiwifruit", "Persimmon", "Jackfruit", "Starfruit", "Cucumber", "Carrot", "Tomato", "Potato", "Broccoli", "Cauliflower", "Lettuce", "Spinach", "Kale", "Cabbage", "Celery", "Onion", "Garlic", "Parsnip", "Turnip", "Beet", "Asparagus", "Artichoke", "Radish", "Eggplant", "Zucchini", "Squash", "Pumpkin", "Peas", "Corn", "Mushroom", "Olive", "Pickle", "Ginger", "Radish", "Watercress", "Arugula", "Chives", "Basil", "Mint", "Cilantro", "Parsley", "Dill", "Rosemary", "Thyme", "Sage", "Oregano", "Tarragon", "Nutmeg", "Clove", "Cinnamon", "Vanilla", "Cocoa", "Coffee", "Tea", "Honey", "Maple", "Peanut", "Almond", "Cashew", "Walnut"];


    var randomNo = Math.floor(Math.random() * 90) + 10;
    var wordIndex = Math.floor(Math.random() * commonWords.length);
    var foodIndex = Math.floor(Math.random() * commonFoods.length);

    var randomWord = commonWords[wordIndex];
    var randomFood = commonFoods[foodIndex];

    var password = randomWord + randomFood + randomNo;
    return password;


    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}[]|;:<>,.?/";
    var password = "";
    for (var i = 0; i < length; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        password += charset[randomIndex];
    }
    return password;
}

window.resetRureraDatePickers = () => {
    if (jQuery().daterangepicker) {
        console.log('testdaterangepicker');

        if ($(".rureradatepicker").length > 0) {

            $(".rureradatepicker").each(function () {
                const $datepicker = $(this);
                const drops3 = $datepicker.attr('data-drops') ?? 'down';
                const minValue = $datepicker.attr('min');
                const maxValue = $datepicker.attr('max');

                var configOptions = {
                    'locale': {
                        format: 'YYYY-MM-DD',
                    },
                    'singleDatePicker': true,
                    'timePicker': false,
                    'autoApply': true, // Set autoApply to true to automatically apply the selected date
                    'autoUpdateInput': false,
                    'drops': drops3,
                };

                if (rurera_is_field(minValue)) {
                    configOptions['minDate'] = minValue;
                }
                if (rurera_is_field(maxValue)) {
                    configOptions['maxDate'] = maxValue;
                }

                $datepicker.daterangepicker(configOptions);

                $datepicker.on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD'));
                });

                $datepicker.on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                });
            });
        }
    }
};
resetRureraDatePickers();
var gameTimeRequest = null;
function update_user_game_time(updated_game_time) {
    gameTimeRequest = jQuery.ajax({
        type: "POST",
        url: '/subscribes/update-game-time',
        async: true,
        beforeSend: function () {
            if (gameTimeRequest != null) {
                gameTimeRequest.abort();
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {"updated_game_time": updated_game_time},
        success: function (return_data) {
            console.log(return_data);
        }
    });
}

$(document).on('click', '.alert-btn-close', function (e) {
	$(this).closest('.rurera-flash-msg').remove();
});


function createWordCloud(elementId, words, config) {
    /* ======================= SETUP ======================= */
    var cloud = document.getElementById(elementId);
    cloud.style.position = "relative";
    cloud.style.fontFamily = config.font;

    var traceCanvas = document.createElement("canvas");
    traceCanvas.width = cloud.offsetWidth;
    traceCanvas.height = cloud.offsetHeight;
    var traceCanvasCtx = traceCanvas.getContext("2d");
    cloud.appendChild(traceCanvas);

    var startPoint = {
        x: cloud.offsetWidth / 2,
        y: cloud.offsetHeight / 2
    };

    var wordsDown = [];
    /* ======================= END SETUP ======================= */

    /* =======================  PLACEMENT FUNCTIONS =======================  */
    function createWordObject(word, freq) {
        var wordContainer = document.createElement("div");
        wordContainer.style.position = "absolute";
        wordContainer.style.fontSize = freq + "px";
        wordContainer.style.lineHeight = config.lineHeight;
        wordContainer.appendChild(document.createTextNode(word));
        return wordContainer;
    }

    function placeWord(word, x, y) {
        cloud.appendChild(word);
        //word.style.left = x - word.offsetWidth / 2 + "px";
        //word.style.top = y - word.offsetHeight / 2 + "px";
		
		word.style.left = Math.floor(Math.random() * (100 - 2 + 1)) + 1 + "px";
		word.style.top = Math.floor(Math.random() * (100 - 1 + 1)) + 1 + "px";
		
        wordsDown.push(word.getBoundingClientRect());
    }

    function trace(x, y) {
        traceCanvasCtx.fillRect(x, y, 1, 1);
    }

    function spiral(i, callback) {
        var angle = config.spiralResolution * i;
        var x = (1 + angle) * Math.cos(angle);
        var y = (1 + angle) * Math.sin(angle);
        return callback ? callback(x, y) : null;
    }

    function intersect(word, x, y) { 
        cloud.appendChild(word);   
		//word.style.left = (parseInt(x) - 0 / 2) + "px";
		//word.style.top = (parseInt(y) - 0 / 2) + "px";
		word.style.left = Math.floor(Math.random() * (100 - 2 + 1)) + 1 + "px";
		word.style.top = Math.floor(Math.random() * (100 - 1 + 1)) + 1 + "px";
        //word.style.left = parseInt(x) - parseInt(word.offsetWidth) / 2 + "px";
        //word.style.top = y - word.offsetHeight / 2 + "px";
		console.log(word);
        var currentWord = word.getBoundingClientRect();
        cloud.removeChild(word);

        for (var i = 0; i < wordsDown.length; i += 1) {
            var comparisonWord = wordsDown[i];
            if (!(currentWord.right + config.xWordPadding < comparisonWord.left - config.xWordPadding ||
                  currentWord.left - config.xWordPadding > comparisonWord.right + config.xWordPadding ||
                  currentWord.bottom + config.yWordPadding < comparisonWord.top - config.yWordPadding ||
                  currentWord.top - config.yWordPadding > comparisonWord.bottom + config.yWordPadding)) {
                return true;
            }
        }
        return false;
    }
    /* ======================= END PLACEMENT FUNCTIONS ======================= */

    /* =======================  LETS GO! =======================  */
    (function placeWords() {
        for (var i = 0; i < words.length; i += 1) {
            var word = createWordObject(words[i].word, words[i].freq);
			
			//console.log(word);

            for (var j = 0; j < config.spiralLimit; j++) {
                if (spiral(j, function(xaxis, yaxis) {
					placeWord(word, startPoint.x + xaxis, startPoint.y + yaxis);
					return true;
                    /*if (!intersect(word, startPoint.x + xaxis, startPoint.y + yaxis)) {
                        placeWord(word, startPoint.x + xaxis, startPoint.y + yaxis);
                        return true;
                    }*/
                })) {
                    break;
                }
            }
        }
    })();
    /* ======================= WHEW. THAT WAS FUN. We should do that again sometime ... ======================= */

    /* =======================  Draw the placement spiral if trace lines is on ======================= */
    (function traceSpiral() {
        traceCanvasCtx.beginPath();
        if (config.trace) {
            var frame = 1;

            function animate() {
                spiral(frame, function(x, y) {
                    trace(startPoint.x + x, startPoint.y + y);
                });

                frame += 1;

                if (frame < config.spiralLimit) {
                    window.requestAnimationFrame(animate);
                }
            }

            animate();
        }
    })();
}