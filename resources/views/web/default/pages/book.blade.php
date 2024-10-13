
@php $random_id = rand(999,99999);@endphp

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></scrip>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/assets/default/css/app.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
<script src="/assets/vendors/flipbook/js/flipbook.min.js?ver={{$random_id}}"></script>
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
<script src="/assets/default/js/book.js?ver={{$random_id}}"></script>
<script src="/assets/default/js/question-layout.js?ver={{$random_id}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .page-content-area{
        position: absolute;
        width: max-content;
    }
    .page-content-area div{
        position: relative;
    }
</style>

<script type="text/javascript" >

    $(document).ready(function () {

        var pages = []

        pages[1] = {
           htmlContent:'<div style="color:#fff;position:absolute;left: 250px;font-size: 33px;width: 250px;top: 800px;"><a href="https://google.com" style="color:red;">Chimp Test Link</a></div>'
        }

        $("#container").flipBook({
            //pdfUrl:"pdf/learning.pdf",
            //pages:pages,
			pages:[
                /*{
                    src:"/assets/vendors/flipbook/images/book2/page1.jpg",
					thumb:"/assets/vendors/flipbook/images/book2/thumb1.jpg",
					title:"Cover",
					htmlContent:'<div class="flipbook-data"> <div class="flipbook-listing"> <div class="listing-card"> <div class="card-body"> <div class="img-holder"> <figure> <a href="#"> <img src="/assets/vendors/flipbook/images/listing-img2.png" alt=""> </a> </figure> </div><div class="text-holder"> <h4>The Phantom Tollbooth</h4> <span class="listing-sub-title">Written by <strong>Norton Juster</strong> and illustrated by <strong>Jules Feiffer</strong></span> <div class="listing-tags"> <ul> <li> <span>8 - 12</span> <em>reading <br/> age</em> </li><li> <span>288</span> <em>Page <br/> count</em> </li><li> <span>1000L</span> <em>Lexile <br/> measure</em> </li><li> <span>Oct 12, 1998</span> <em>Publication <br/> date</em> </li></ul> </div><div class="people-reading"> <span> <img src="/assets/vendors/flipbook/images/reading-peo-img1.png" alt=""> 30k people are currently reading </span> </div></div></div><div class="card-footer"> <div class="btn-options"> <a href="#" class="listing-btn"><i class="fa-book fa"></i>Read the eBook</a> <a href="#" class="listing-btn"><i class="fa-question-circle fa"></i>Take the quiz</a> <a href="#" class="remove-btn">Remove from reading </a> </div></div></div></div><div class="author-book-types"> <h5>What kind of book is The Phantom Tollbooth</h5> <ul> <li><a href="#">imaginary places</a></li><li><a href="#">rescues and rescuing</a></li><li><a href="#">magic</a></li><li><a href="#">word play</a></li><li><a href="#">curiosity</a></li><li><a href="#">action and adventure</a></li><li><a href="#">fantasy and magic</a></li><li><a href="#">classics</a></li><li><a href="#">fiction</a></li></ul> </div><div class="book-title-img-holder"> <figure> <img src="/assets/vendors/flipbook/images/book-title-img.png" alt=""> </figure> </div></div>'
				},*/

                @php $page_count = 1;

                $book_title = isset( $book->book_title )? $book->book_title : '';
                $cover_image = isset( $book->cover_image )? $book->cover_image : '';
                $written_by = isset( $book->written_by )? $book->written_by : '';
                $illustrated_by = isset( $book->illustrated_by )? $book->illustrated_by : '';

                $publication_date = isset( $book->publication_date )? dateTimeFormat($book->publication_date, 'Y-n-d') : '';
                $no_of_pages = isset( $book->no_of_pages )? $book->no_of_pages : '';
                $age_group = isset( $book->age_group )? $book->age_group : '';
                $interest_area_array = isset( $book->interest_area )? explode(',', $book->interest_area) : '';
                $skill_set = isset( $book->skill_set )? $book->skill_set : '';
                $words_bank = isset( $book->words_bank )? $book->words_bank : '';
                $reading_level = isset( $book->reading_level )? $book->reading_level : '';


                $landing_page = '<div class="flipbook-data">' .
                '<div class="flipbook-listing"> ' .
                '<div class="listing-card"> ' .
                '<div class="card-body"> ' .
                '<div class="img-holder"> <figure> <a href="#"> <img src="'. $cover_image .'" alt=""> </a> </figure> </div>' .
                '<div class="text-holder"> ' .
                '<h4>'. $book_title .'</h4> ' .
                '<span class="listing-sub-title">Written by <strong>'. $written_by .'</strong> and illustrated by <strong>'. $illustrated_by .'</strong></span> ' .
                '<div class="listing-tags"> ' .
                '<ul> ' .
                '<li> <span>'. $age_group .'</span> <em>reading <br/> age</em> </li>' .
                '<li> <span>'. $no_of_pages .'</span> <em>Page <br/> count</em> </li>' .
                '<li> <span>1000L</span> <em>Lexile <br/> measure</em> </li>' .
                '<li> <span>'. $publication_date .'</span> <em>Publication <br/> date</em> </li>' .
                '</ul> ' .
                '</div>' .
                '<div class="people-reading"> <span> <img src="/assets/vendors/flipbook/images/reading-peo-img1.png" alt=""> 30k people are currently reading </span> </div>' .
                '</div></div>' .
                '<div class="card-footer"> <div class="btn-options"> ' .
                '<a href="#" class="listing-btn try-rurera-btn"><i class="fa-book fa"></i>Read the eBook</a> ' .
                '<a href="#" class="listing-btn try-rurera-btn"><i class="fa-question-circle fa"></i>Take the quiz</a> ' .
                '</div></div></div></div>' .
                '<div class="author-book-types"> <h5>What kind of book is The '.$book_title.'</h5> ' .
                '<ul> ';

                if( !empty( $interest_area_array ) )
                {
                    foreach( $interest_area_array as $interest_area)
                    {
                        $landing_page .= '<li><a href="#">'. $interest_area .'</a></li>';
                    }
                }
                $landing_page .= '</ul> </div><div class="book-title-img-holder"> <figure> <img src="/assets/vendors/flipbook/images/book-title-img.png" alt=""> </figure> </div></div>';
                $pages_count = 0;

                @endphp
                @if(!empty( $book->bookPages ) )
                    {
                        @php $read_time = 0; @endphp
                        src:"/store/1/books/landing.jpg",
                        thumb:"/store/1/books/landing.jpg",
                        title:"Landing Page",
                        htmlContent: '<div class="loadedDiv" data-page_id="0" data-time_lapsed="{{$read_time}}" data-start_time="0">{!! $landing_page !!}</div>'
                    },
                    @foreach( $book->bookPages as $bookPage)
                         @php $pages_count++;
                           if(!auth()->check())
                           {
                               if ($pages_count >= $pagesLimit) {
                                   continue;
                               }
                           }
                           @endphp
                        {
                            @php $page_content_data = isset( $page_content[$bookPage->id])? $page_content[$bookPage->id] : ''; @endphp
                            @php $read_time = isset( $bookPage->BooksPageUserReadings->read_time )? $bookPage->BooksPageUserReadings->read_time : 0 @endphp
                            src:"/{{$bookPage->page_path}}",
        					thumb:"/{{$bookPage->page_path}}",
        					title:"{{$bookPage->page_title}}",
        					htmlContent: `<div class="loadedDiv" data-page_id="{{ $bookPage->id }}" data-time_lapsed="{{ $read_time }}" data-start_time="0">{!! $page_content_data !!}</div>`,
        				},
                    @php $page_count++; @endphp
                    @endforeach
                @endif
                @if(!auth()->check())
                {
                    src:"/store/1/books/subscribe.jpg",
                    thumb:"/store/1/books/subscribe.jpg",
                    title:"Subscribe to View More",
                    htmlContent: ''
                },
                @endif
            ],
            btnToc : {enabled:false},
			btnShare : {enabled:false},
			btnDownloadPages : {enabled:false},
			btnDownloadPdf : {enabled:false},
			btnSound : {enabled:false},
            btnAutoplay: {enabled:false},
            btnSelect: {enabled:false},
            btnBookmark: {enabled:false},
            btnThumbs: {enabled:false},
            btnExpand: {enabled:false},
            btnPrint: {enabled:false},
            // rightToLeft: [false],
			viewMode:"2d",
			//singlePageMode:true,
            buttons:[
                {
                    icon:'fa-list-ol',
                    title:'Custom 5',
                    onclick:function(){
                        $("body").toggleClass("menu-open");
                        $("body").removeClass("book-open");
                        $("body").removeClass("quiz-open");
                    }
                },
                {
                    icon:'fa-question',
                    title:'Custom 4',
                    onclick:function(){
                        $("body").toggleClass("quiz-open");
                        $("body").removeClass("book-open");
                        $("body").removeClass("menu-open");
                        $("body").removeClass("vocabulary-open");
                    }
                },
                {
                    icon:'fa-bookmark',
                    title:'Custom 3',
                    onclick:function(){
                        $("body").toggleClass("book-open");
                        $("body").removeClass("menu-open");
                        $("body").removeClass("quiz-open");
                        $("body").removeClass("vocabulary-open");
                    }
                },
                {
                    icon:'fa-sticky-note',
                    title:'vocabulary button',
                    onclick:function(){
                        $("body").toggleClass("vocabulary-open");
                        $("body").removeClass("book-open");
                        $("body").removeClass("menu-open");
                        $("body").removeClass("quiz-open");
                    }
                },
                // {
                //     icon:'fa-cog',
                //     title:'setting',
                //     onclick:function(){
                //         $("body").toggleClass("active-hide-buttons");
                //     }
                // }

            ],
        });

        $(".close-btn").on("click", function(a) {
            $("body").removeClass("book-open");
            $("body").removeClass("menu-open");
            $("body").removeClass("quiz-open");
            $("body").removeClass("vocabulary-open");
        });

        $('.flipbook-parent-ul li a').click(function() {
            $(this).closest('li').siblings('.flipbook-parent-ul li').removeClass('active');
            $(this).closest('li').addClass('active');
        })
        $('.flipbook-child-ul li a').click(function() {
            $(this).closest('li').siblings('.flipbook-child-ul li').removeClass('active');
            $(this).closest('li').addClass('active');
        })

        $(".view-more-btn").on("click", function(a) {
            $('.flipbook-child-ul').toggleClass("hide");
        });

        $(".close-feature-btn").on("click", function(a) {
            $(this).closest('li').removeClass('active');
        });
    })
</script>

<div id="container">
        <div class="menu-cross-btn">
            <a href="/books"><i class="fa fa-times"></i></a>
        </div>
        <div class="infolinks-data"></div>



        <div class="flipbook-chapter">
            <div class="slide-menu-head">
                <div class="menu-controls">
                    <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="slide-menu-body">
                <h6>Quiz Index</h6>
                <div class="flipbook-content-box">
                    <span class="chapter-title">Chapter 1</span>
                    <ul class="flipbook-list">
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Sorting</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Column</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Tables</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Pagination</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Checkbox ?</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Search</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Export ?</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Single Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Chooser</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Sorting</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Column</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Tables</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Pagination</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Checkbox ?</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Search</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Export ?</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Single Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Chooser</a></li>
                    </ul>
                    <span class="chapter-title">Chapter 2</span>
                    <ul class="flipbook-list">
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Single Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Chooser</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Sorting</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Column</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Tables</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Pagination</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Checkbox ?</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Search</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Single Header</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Chooser</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Sorting</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Column</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Tables</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Pagination</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Checkbox ?</a></li>
                        <li><a href="#"><i class="fa fa-lightbulb"></i>Search</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="flipbook-tags">
            <div class="slide-menu-head">
                <div class="menu-controls">
                    <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
                </div>
                <h4>Vocabulary Cloud</h4>
            </div>
            <div class="slide-menu-body">
                <h6>Chapter 1</h6>
                <div class="flipbook-content-box">
                    <ul class="flipbook-tags-list flipbook-parent-ul">
                        <li >
                            <a href="#">Android</a>
                            <div class="feature-box">
                                <div class="feature-header">
                                    <span class="icon-box">
                                        <i class="fa fa-volume-up"></i>
                                    </span>
                                    <h3>Feature</h3>
                                </div>
                                <div class="feature-body">
                                    <div class="feature-noun">
                                        <span>Feature Noun <em>(Quality)</em></span>
                                    </div>
                                    <div class="feature-text">
                                        <strong>A typical quality or an important part of <br /> something:</strong>
                                        <ul class="feature-list">
                                            <li>The town's main features are its beautiful <br /> Mosque and ancient marketplace.</li>
                                            <li>Our latest model of phone has several new <br /> features.</li>
                                            <li>A unique feature of these rock shelters was <br /> that they were dry.</li>
                                        </ul>
                                        <div class="synonyms-box">
                                            <h4>Synonyms</h4>
                                            <ul class="synonyms-list">
                                                <li>
                                                    <a href="#">angle</a>
                                                    <span>(Way of thinking)</span>
                                                </li>
                                                <li>
                                                    <a href="#">aspect</a>
                                                    <span>(Feature)</span>
                                                </li>
                                                <li>
                                                    <a href="#">facet</a>
                                                </li>
                                                <li>
                                                    <a href="#">ingredient</a>
                                                </li>
                                                <li>
                                                    <a href="#">point</a>
                                                    <span>(Characteristic)</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="#">Articles</a>
                        </li>
                        <li>
                            <a href="#">Blogger</a>
                        </li>
                        <li>
                            <a href="#">Cms</a>
                        </li>
                        <li>
                            <a href="#">Computers</a>
                        </li>
                        <li>
                            <a href="#">Drupal</a>
                        </li>
                        <li>
                            <a href="#">Ebooks</a>
                        </li>
                    </ul>
                    <h6>Chapter 2</h6>
                    <ul class="flipbook-tags-list flipbook-parent-ul">
                        <li >
                            <a href="#">Android</a>
                        </li>
                        <li>
                            <a href="#">Articles</a>
                        </li>
                        <li>
                            <a href="#">Blogger</a>
                        </li>
                        <li>
                            <a href="#">Cms</a>
                        </li>
                        <li>
                            <a href="#">Computers</a>
                        </li>
                        <li>
                            <a href="#">Drupal</a>
                        </li>
                        <li>
                            <a href="#">Ebooks</a>
                        </li>
                    </ul>
                    <div class="flipbook-divider"></div>

                </div>
            </div>
        </div>
        <div class="hide-buttons-wrapper">
            <span data-name="btnZoomIn" title="Zoom in" style="opacity: 1; pointer-events: auto;">
                <span aria-hidden="true" class="fa-plus flipbook-icon-fa flipbook-menu-btn skin-color fa flipbook-color-light" style="width: 38px; font-size: 14px; margin: 2px; border-radius: 2px; background: none;"></span>
            </span>
        </div>
    </div>


<div class="modal fade review_submit" id="review_submit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
           <div class="modal-body">
               <p></p>
               <a href="javascript:;" class="submit_quiz_final nav-link mt-20 btn-primary rounded-pill" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> Submit </a>
           </div>
       </div>
   </div>
</div>
<div class="modal fade validation_error" id="validation_error" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
           <div class="modal-body">
               <p>Please fill all the required fields before submitting.</p>
           </div>
       </div>
   </div>
</div>
<a href="#" data-toggle="modal" class="hide review_submit_btn" data-target="#review_submit">modal button</a>


<div class="modal fade question_inactivity_modal" id="question_inactivity_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-box">
        <div class="modal-title rurera-hide">
            <span class="inactivity-timer">30</span>
        </div>
        <h3 class="font-24">Session End</h3>
        <p>
            Looks like you're inactive. <br> Your session has been closed.
        </p>
       <a href="javascript:;" class="continue-btn mt-15" data-dismiss="modal" aria-label="Close">Continue Reading</a>
      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
    var startTime = new Date();
    var interval;
    var is_stopped = false;

    var InactivityInterval = null;
    var focusInterval = null;
    var focusIntervalCount = 60;
    var timerStop = false;

    window.addEventListener('blur', function () {
        if( focusInterval == null) {
            focusInterval = setInterval(function () {
                var focus_count = focusIntervalCount-1;
                console.log('focusout--'+focus_count);
                focusIntervalCount = focus_count;
                if (focus_count <= 0) {
                    timerStop = true;
                    $(".question_inactivity_modal").modal('show');
                    if( InactivityInterval == null) {
                        InactivityInterval = setInterval(function () {
                            var inactivity_timer = parseInt($(".inactivity-timer").html() - 1);
                            $(".inactivity-timer").html(inactivity_timer);
                            if (parseInt(inactivity_timer) <= 0) {
                                //$(".question_inactivity_modal").modal('hide');
                                $(".inactivity-timer").html(30);
                                //$(".submit_quiz_final").click();
                                clearInterval(InactivityInterval);
                                InactivityInterval = null;
                            }
                        }, 1000);
                    }
                    focusIntervalCount = 60;
                    clearInterval(focusInterval);
                    focusInterval = null;
                }
            }, 1000);

        }
    });

    $(document).on('click', '.continue-btn', function (e) {
        timerStop = false;
        focusIntervalCount = 60;
        focusInterval = null;
        $(".inactivity-timer").html(30);
        clearInterval(InactivityInterval);
        InactivityInterval = null;
    });



    // Start the timer
    function startTimer() {
        interval = setInterval(updateTime, 5000); // Update every 10 seconds (5000 milliseconds)
    }

    // Update the displayed time and send to server
    function updateTime() {
        //loadedDiv
        if( is_stopped == true || timerStop == true){
            return;
        }
        $(".loadedDiv:visible").addClass('testing444');
        var page_ids = [];
        $(".loadedDiv:visible").each(function(){
            page_ids.push($(this).attr('data-page_id'));
        });

        var elapsedSeconds = $(".loadedDiv:visible").attr('data-time_lapsed');
        $(".loadedDiv:visible").attr('data-time_lapsed', parseInt(elapsedSeconds)+5);


        var divVal = $(".loadedDiv:visible").attr('data-time_lapsed');
        if( divVal == 0 || divVal == undefined || divVal == 'undefined'){
            $(".loadedDiv:visible").attr('data-start_time', new Date());
        }

        $.ajax({
            type: "POST",
            url: '/books/update_reading',
            headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
            data: {'page_ids': page_ids, 'time_lapsed': $(".loadedDiv:visible").attr('data-time_lapsed')},
            success: function (return_data) {
                console.log(return_data);
            }
        });

    }

    // Stop the timer and send the final time to server
    function stopTimer() {
        clearInterval(interval);
        updateTime(); // Send the final time before stopping
    }

    window.addEventListener('blur', function () {
        is_stopped = true;
        clearInterval(interval);
    });

    window.addEventListener('focus', function () {
        is_stopped = false;
        startTimer();
    });


</script>
<img src="/assets/default/img/icons/sidebar/dashboard.svg" onload="startTimer()" onbeforeunload="stopTimer()" style="display:none;">