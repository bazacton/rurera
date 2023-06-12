


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
<script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
<style>
    .page-content-area{
        position: absolute;
        width: max-content;
    }
    .page-content-area div{
        position: relative;
    }
</style>
<script type="text/javascript">

    $(document).ready(function () {

        var pages = []

        pages[1] = {
           htmlContent:'<div style="color:#fff;position:absolute;left: 250px;font-size: 33px;width: 250px;top: 800px;"><a href="https://google.com" style="color:red;">Chimp Test Link</a></div>'
        }

        $("#container").flipBook({
            //pdfUrl:"pdf/learning.pdf",
            //pages:pages,
			pages:[
                {
                    src:"/assets/vendors/flipbook/images/book2/page1.jpg",
					thumb:"/assets/vendors/flipbook/images/book2/thumb1.jpg",
					title:"Cover",
					htmlContent:'<div class="flipbook-data"> <div class="flipbook-listing"> <div class="listing-card"> <div class="card-body"> <div class="img-holder"> <figure> <a href="#"> <img src="/assets/vendors/flipbook/images/listing-img2.png" alt=""> </a> </figure> </div><div class="text-holder"> <h4>The Phantom Tollbooth</h4> <span class="listing-sub-title">Written by <strong>Norton Juster</strong> and illustrated by <strong>Jules Feiffer</strong></span> <div class="listing-tags"> <ul> <li> <span>8 - 12</span> <em>reading <br/> age</em> </li><li> <span>288</span> <em>Page <br/> count</em> </li><li> <span>1000L</span> <em>Lexile <br/> measure</em> </li><li> <span>Oct 12, 1998</span> <em>Publication <br/> date</em> </li></ul> </div><div class="people-reading"> <span> <img src="/assets/vendors/flipbook/images/reading-peo-img1.png" alt=""> 30k people are currently reading </span> </div></div></div><div class="card-footer"> <div class="btn-options"> <a href="#" class="listing-btn"><i class="fa-book fa"></i>Read the eBook</a> <a href="#" class="listing-btn"><i class="fa-question-circle fa"></i>Take the quiz</a> <a href="#" class="remove-btn">Remove from reading </a> </div></div></div></div><div class="author-book-types"> <h5>What kind of book is The Phantom Tollbooth</h5> <ul> <li><a href="#">imaginary places</a></li><li><a href="#">rescues and rescuing</a></li><li><a href="#">magic</a></li><li><a href="#">word play</a></li><li><a href="#">curiosity</a></li><li><a href="#">action and adventure</a></li><li><a href="#">fantasy and magic</a></li><li><a href="#">classics</a></li><li><a href="#">fiction</a></li></ul> </div><div class="book-title-img-holder"> <figure> <img src="/assets/vendors/flipbook/images/book-title-img.png" alt=""> </figure> </div></div>'
				},

                @if(!empty( $book->bookPages ) )
                    @foreach( $book->bookPages as $bookPage)
                        {
                            src:"/{{$bookPage->page_path}}",
        					thumb:"/{{$bookPage->page_path}}",
        					title:"{{$bookPage->page_title}}",
        					htmlContent: '{!! isset( $page_content[$bookPage->id])? $page_content[$bookPage->id] : '' !!}'
        				},
                    @endforeach
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
                {
                    icon:'fa-cog',
                    title:'setting',
                    onclick:function(){
                        $("body").toggleClass("active-hide-buttons");
                    }
                }

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
            <a href="#"><i class="fa fa-times"></i></a>
        </div>
        <div class="flipbook-slide-menu">
            <div class="slide-menu-head">
                <div class="menu-controls">
                    <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
                </div>
                <h4>Down to Earth</h4>
                <span class="label">By Carmel Reilly</span>
                <span class="label">Illustrated yy Steve May</span>
            </div>
            <div class="slide-menu-body">
                <h6>Contents</h6>
                <div class="flipbook-content-box">
                    <ul class="flipbook-list">
                        <li><a href="#">Order Sorting</a></li>
                        <li><a href="#">Multi Column</a></li>
                        <li><a href="#">Multiple Tables</a></li>
                        <li><a href="#">Alt. Pagination</a></li>
                        <li><a href="#">Checkbox</a></li>
                        <li><a href="#">Range Search</a></li>
                        <li><a href="#">Export</a></li>
                        <li><a href="#">Sticky Header</a></li>
                        <li><a href="#">Clone Header</a></li>
                        <li><a href="#">Column Chooser</a></li>
                    </ul>
                </div>
            </div>
        </div>
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
        <div class="flipbook-quiz">
            <div class="slide-menu-head">
                <div class="menu-controls">
                    <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
                </div>
                <span class="quiz-pagnation">2 of 2</span>
                <span class="quiz-info">Lorem ipsum dolor, adipisicing elit.</span>
            </div>
            <div class="slide-menu-body">
                <div class="flipbook-content-box">
                    <div class="quiz-select">
                        <form>
                            <div class="quiz-form-field">
                                <input type="radio" id="quiz1" name="quiz">
                                <label for="quiz1">Lorem ipsum dolor</label>
                            </div>
                            <div class="quiz-form-field">
                                <input type="radio" id="quiz2" name="quiz">
                                <label for="quiz2">Lorem ipsum dolor</label>
                            </div>
                            <div class="quiz-form-field">
                                <input type="radio" id="quiz3" name="quiz">
                                <label for="quiz3">Lorem ipsum dolor</label>
                            </div>
                            <div class="quiz-form-field">
                                <input type="radio" id="quiz4" name="quiz">
                                <label for="quiz4">Lorem ipsum dolor</label>
                            </div>
                            <div class="quiz-form-btn">
                                <button type="submit">Check answers</button>
                            </div>
                        </form>
                    </div>
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
