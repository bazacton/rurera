@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .book-library-sub-header {
        background-color: #333399;
        background-image: linear-gradient(transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px), linear-gradient(90deg, transparent 11px, rgba(255, 255, 255, 0.2) 12px, transparent 12px);
        background-size: 100% 12px, 12px 100%;
    }
    .lms-books-listing {
        background-color: #f1f1f1;
    }
</style>
@endpush

@section('content')
<section class="text-center pages-sub-header book-library-sub-header lms-wave-shape-bottom">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-12 col-md-9 col-lg-7">
                <div class="text-holder">
                    <h1 class="font-50 font-weight-bold" itemprop="title">NEW</h1>
                    <p class="lms-subtitle" itemprop="description">Start Reading with confidence</p>
                    <div class="ask-msg">
                        <span itemprop="read again">
                            Want to read this book<br/>
                            again?
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="lms-library-slider pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="swiper-container swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper" style="transform: translate3d(0, 0, 0);">
                        <div class="swiper-slide swiper-slide-active" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book1.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="swiper-slide swiper-slide-next" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book2.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book3.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book4.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book1.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book2.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book3.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="swiper-slide" style="width: 250px;">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../assets/default/img/book4.png" alt="#" height="321" width="227" itemprop="image"/></a>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true" itemprop="notification"></span>
                </div>
                <div class="swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-disabled="true">
                    <img src="../assets/default/img/slider-arrow-left.png" alt="#" itemprop="arrow image" width="37" height="52"/>
                </div>
                <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false">
                    <img src="../assets/default/img/slider-arrow-right.png" alt="#" itemprop="arrow image" width="37" height="52"/>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="home-sections home-sections-swiper find-instructor-section find-instructor-testimonial position-relative pt-50 pb-50 mt-10">
    <div class="container">
        <div class="row" style="margin-top: 100px;">
            <div class="col-12 col-lg-6">
                <div class="position-relative left" style="z-index: 3;">
                    <div class="find-instructor-circle gradient-green">
                        <span class="lms-serial-no" itemprop="number">#1</span>
                    </div>
                    <h2 class="font-30 font-weight-bold text-dark" itemprop="title">Reading Progress and Statistics</h2>
                    <p class="font-16 font-weight-normal text-gray mt-10" itemprop="description">
                        Rurera offer reading progress, such as the percentage of the book read or estimated time remaining to finish a chapter or the entire book. Additionally, it may also provide
                        statistics on reading habits, such as
                        reading speed or total reading time.
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative float-right">
                    <img src="../assets/default/img/find-instructor-img1.png" class="find-instructor-section-hero" alt="Find the best instructor" itemprop="image" height="250" width="379"/>
                </div>
            </div>
        </div>
        <div class="row mb-50" style="margin-top: 150px;">
            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative">
                    <img src="../assets/default/img/find-instructor-img1.png" class="find-instructor-section-hero" alt="Find the best instructor" itemprop="image" height="250" width="379"/>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="position-relative right" style="z-index: 3;">
                    <div class="find-instructor-circle gradient-green"><span class="lms-serial-no">#2</span></div>
                    <h2 class="font-30 font-weight-bold text-dark" itemprop="title">E-Book Formats</h2>
                    <p class="font-16 font-weight-normal text-gray mt-10" itemprop="description">
                        Another exciting feature is flipbook which is an out-stream book reading format for web. It provide an enticing, interactive, silent highlight and scroll through content. These
                        formats allow for easy distribution and
                        compatibility across different devices.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="lms-books-listing pb-0 pt-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="books-listing-holder">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-12"></div>
                        <div class="col-lg-10 col-md-10 col-sm-12">
                            <div class="row">
                                @if( !empty( $books ))
                                @foreach( $books as $book_category => $category_books)
                                <div class="col-lg-12">
                                    <h3 class="mb-10 font-36" itemprop="title">{{$book_category}}</h3>
                                    <span class="mb-35 d-block" itemprop="sub title">For kids ages 0-3</span>
                                </div>
                                @if( !empty( $category_books ))
                                @foreach( $category_books as $bookData)
                                <div class="col-lg-12">
                                    <div class="listing-card">
                                        <div class="row">
                                            <div class="col-12 col-lg-2 col-md-3">
                                                <div class="img-holder">
                                                    <figure>
                                                        <a href="#" itemprop="url">
                                                            <img src="{{$bookData->cover_image }}" alt="#" height="182" width="137" itemprop="image"/>
                                                        </a>
                                                    </figure>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-6 col-md-5">
                                                <div class="text-holder">
                                                    <h3 itemprop="title"><a href="/books/{{$bookData->book_slug}}" itemprop="url">{{$bookData->book_title}}</a></h3>
                                                    <ul itemprop="books info list">
                                                        <li><span itemprop="info text">Reading Level :</span>{{$bookData->reading_level }}</li>
                                                        <li><span itemprop="info text">Interest Area :</span>{{$bookData->interest_area }}</li>
                                                        <li><span itemprop="info text">Pages :</span>{{$bookData->no_of_pages }}</li>
                                                        <li><span itemprop="info text">Points :</span>{{$bookData->reading_points }} <img src="../assets/default/svgs/coin-earn.svg" itemprop="svg image" width="20" height="24" alt="#"/></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="btn-holder">
                                                <a href=""/books/{{$bookData->book_slug}}" class="read-btn" itemprop="url">
                                                    <span class="btn-icon">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            version="1.1"
                                                            id="Layer_1"
                                                            x="0px"
                                                            y="0px"
                                                            viewBox="0 0 122.88 101.37"
                                                            style="enable-background: new 0 0 122.88 101.37;"
                                                            xml:space="preserve"
                                                        >
                                                            <g>
                                                                <path
                                                                    d="M12.64,77.27l0.31-54.92h-6.2v69.88c8.52-2.2,17.07-3.6,25.68-3.66c7.95-0.05,15.9,1.06,23.87,3.76 c-4.95-4.01-10.47-6.96-16.36-8.88c-7.42-2.42-15.44-3.22-23.66-2.52c-1.86,0.15-3.48-1.23-3.64-3.08 C12.62,77.65,12.62,77.46,12.64,77.27L12.64,77.27z M103.62,19.48c-0.02-0.16-0.04-0.33-0.04-0.51c0-0.17,0.01-0.34,0.04-0.51V7.34 c-7.8-0.74-15.84,0.12-22.86,2.78c-6.56,2.49-12.22,6.58-15.9,12.44V85.9c5.72-3.82,11.57-6.96,17.58-9.1 c6.85-2.44,13.89-3.6,21.18-3.02V19.48L103.62,19.48z M110.37,15.6h9.14c1.86,0,3.37,1.51,3.37,3.37v77.66 c0,1.86-1.51,3.37-3.37,3.37c-0.38,0-0.75-0.06-1.09-0.18c-9.4-2.69-18.74-4.48-27.99-4.54c-9.02-0.06-18.03,1.53-27.08,5.52 c-0.56,0.37-1.23,0.57-1.92,0.56c-0.68,0.01-1.35-0.19-1.92-0.56c-9.04-4-18.06-5.58-27.08-5.52c-9.25,0.06-18.58,1.85-27.99,4.54 c-0.34,0.12-0.71,0.18-1.09,0.18C1.51,100.01,0,98.5,0,96.64V18.97c0-1.86,1.51-3.37,3.37-3.37h9.61l0.06-11.26 c0.01-1.62,1.15-2.96,2.68-3.28l0,0c8.87-1.85,19.65-1.39,29.1,2.23c6.53,2.5,12.46,6.49,16.79,12.25 c4.37-5.37,10.21-9.23,16.78-11.72c8.98-3.41,19.34-4.23,29.09-2.8c1.68,0.24,2.88,1.69,2.88,3.33h0V15.6L110.37,15.6z M68.13,91.82c7.45-2.34,14.89-3.3,22.33-3.26c8.61,0.05,17.16,1.46,25.68,3.66V22.35h-5.77v55.22c0,1.86-1.51,3.37-3.37,3.37 c-0.27,0-0.53-0.03-0.78-0.09c-7.38-1.16-14.53-0.2-21.51,2.29C79.09,85.15,73.57,88.15,68.13,91.82L68.13,91.82z M58.12,85.25 V22.46c-3.53-6.23-9.24-10.4-15.69-12.87c-7.31-2.8-15.52-3.43-22.68-2.41l-0.38,66.81c7.81-0.28,15.45,0.71,22.64,3.06 C47.73,78.91,53.15,81.64,58.12,85.25L58.12,85.25z"
                                                                ></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    Read the eBook
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-12"></div>
        </div>
    </div>
</section>
<div class="lms-faqs pt-70">
    <h2 class="font-36 font-weight-bold mb-30" style="text-align: center; color: #27325e;">Common Questions</h2>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="heading">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" itemprop="collapse button">What are Rurera Collection Edition books?
                        </button>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="heading" data-parent="#accordion">
                        <div class="card-body">
                            <p itemprop="description">
                                Rurera Collection Editions are exclusive versions of children's books carefully selected from leading publishers and artistically redesigned as a stunning, cohesive set
                                exclusively for Rurera Book Club
                                members.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" itemprop="collapse button">How do you make sure the books
                            are good?
                        </button>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <p itemprop="description">
                                At Rurera, we maintain the quality of our books through expert curation, collaborating with renowned publishers, and considering reader feedback. Our team evaluates each
                                book for engaging storytelling,
                                educational value, captivating illustrations, and positive themes to ensure a high standard of excellence in our Collection Editions.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" itemprop="collapse button">Why not just buy books at the
                            store or on Amazon?
                        </button>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <p itemprop="description">
                                Rurera Book Club offers exclusive curated Collection Editions not available in traditional stores or Amazon. Subscribing to Rurera provides a personalized and convenient
                                reading experience, with carefully
                                selected books delivered to your doorstep. It fosters a sense of community among book lovers.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingfour">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour" itemprop="collapse button">Can l order today but have my
                            subscription start later?
                        </button>
                    </div>
                    <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
                        <div class="card-body">
                            <p itemprop="description">
                                Yes, you can place an order with Rurera today and choose a future start date for your subscription. Simply specify your preferred start date during the ordering process,
                                and we will ensure that your subscription
                                begins accordingly. This allows you to secure your subscription in advance while having it activate at a later date of your choosing.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingfive">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive" itemprop="collapse button">Are there any initiation,
                            cancellation, or hidden fees?
                        </button>
                    </div>
                    <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                        <div class="card-body">
                            <p itemprop="description">
                                No, there are no extra fees to join or cancel your Rurera Book Club subscription. You only pay the advertised price, and you can cancel anytime without any additional
                                charges. We believe in simplicity and
                                transparency for a hassle-free experience.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingsix">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix" itemprop="collapse button">What if I have too many books?
                        </button>
                    </div>
                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                        <div class="card-body">
                            <p itemprop="description">
                            If you have too many books from Rurera Book Club, you can contact customer support to make changes. They can help you receive books less often or pause your subscription
                            until you're ready for more. We want to
                            make sure you have a collection that works for you.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="heading7">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7" itemprop="collapse button">What if I have kids in multiple age
                            ranges?
                        </button>
                    </div>
                    <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion">
                        <div class="card-body">
                            <p itemprop="description">
                                If you have children of different ages, Rurera Book Club can adjust to meet their reading needs. Just tell us the ages of your kids, and we will send books suitable for
                                each child. This way, each child can enjoy
                                books that are just right for them.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-100">
    <div class="row">
        <div class="col-lg-12">
            <div class="lms-reading-progress pb-0">
                <div class="progress-card">
                    <div class="-icon-holder">
                        <img src="../assets/default/img/progress-icon.png" alt="#" height="24" width="28"/>
                    </div>
                    <div class="text-holder">
                        <h3 itemprop="title">Reading progress</h3>
                        <p itemprop="description">
                            it can b challenging to identfy and understand progress and<br/>
                            growth as readers. You're likely wondring: Am I doing this right?<br/>
                            Are we making progress? How will i know?
                        </p>
                        <div class="btn-holder">
                            <a href="https://chimpstudio.co.uk/flipbook/" itemprop="url" class="progress-btn">
                                <span class="icon-svg">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        enable-background="new 0 0 512 512"
                                        height="40px"
                                        id="Layer_1"
                                        version="1.1"
                                        viewBox="0 0 512 512"
                                        width="40px"
                                        xml:space="preserve">
                                        <g>
                                            <path d="M332.814,128.443c18.344-3.174,36.689-6.349,55.644-9.63c-3.584,18.716-7.116,37.157-10.763,56.203   c-3.383-3.377-6.688-6.333-9.561-9.667c-2.013-2.333-3.262-1.854-5.156,0.014c-11.943,11.787-23.961,23.5-35.968,35.225   c-21.427,20.927-42.893,41.818-64.249,62.818c-1.783,1.753-2.672,1.471-4.26-0.055c-8.962-8.601-18.065-17.057-26.999-25.686   c-1.742-1.679-2.663-1.808-4.456,0.002c-19.619,19.758-39.359,39.395-58.979,59.146c-1.789,1.81-2.733,2.113-4.661,0.125   c-5.69-5.871-11.6-11.533-17.511-17.187c-1.306-1.251-1.302-1.938-0.009-3.221c27.524-27.321,55.029-54.664,82.438-82.102   c1.946-1.946,2.805-0.747,4.012,0.394c8.873,8.386,17.778,16.743,26.56,25.225c1.445,1.399,2.092,1.29,3.475-0.046   c24.447-23.598,48.961-47.132,73.46-70.678c2.144-2.058,4.199-4.23,6.504-6.094c2.063-1.669,1.683-2.779-0.089-4.355   c-3.456-3.081-6.744-6.351-10.098-9.542C332.369,129.038,332.595,128.742,332.814,128.443z"></path>
                                            <rect height="66.678" width="68.539" x="141.113" y="315.244"></rect>
                                            <rect height="98.111" width="68.542" x="229.854" y="283.811"></rect>
                                            <rect height="140.924" width="68.541" x="318.274" y="241.075"></rect>
                                        </g>
                                    </svg>
                                </span>
                                Progress
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
@endpush
