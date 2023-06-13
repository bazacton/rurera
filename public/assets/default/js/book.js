$(document).on('click', '.book-info-link', function () {
    $("body").removeClass("menu-open");
    var info_id = $(this).attr('data-id');
    var info_type = $(this).attr('data-type');
    $.ajax({
        type: "GET",
        url: '/books/' + info_id + '/info_detail/',
        data: {},
        success: function (return_data) {
            $(".infolinks-data").html(return_data);


            $(".close-btn").on("click", function (a) {
                $("body").removeClass("book-open");
                $("body").removeClass("menu-open");
                $("body").removeClass("quiz-open");
                $("body").removeClass("vocabulary-open");
            });
        }
    });

});
/*$.ajax({
        type: "POST",
        url: '/admin/books/'+book_page_id+'/store_page/',
        data: posted_data,
        success: function (return_data) {
            Swal.fire({icon: "success", html: '<h3 class="font-20 text-center text-dark-blue">Page Successfully Updated</h3>', showConfirmButton: !1});
        }
    });
*/
