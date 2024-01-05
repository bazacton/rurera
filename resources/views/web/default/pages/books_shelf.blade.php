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
<section class="position-relative job-singup-sub-header gallery-sub-header p-0" style="min-height: 620px;">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-12 col-md-12 col-lg-7">
          <h1 itemprop="title" class="font-50 font-weight-bold"> Empower yourself through <br> reading <span class="text-scribble">books</span>
          </h1>
          <strong class="d-block font-36">Read to lead, read to succeed!</strong>
          <p itemprop="description" class="lms-subtitle font-19 font-weight-normal pt-20"> Access Rurera bookshelf anytime, anywhere, ensuring seamless <br> reading experiences and chance to get rewards. </p>
          <ul class="mt-40 mb-30 p-0 row">
            <li class="mb-10 font-19 col-lg-6 col-md-6 col-12">
              <img src="../assets/default/svgs/check-simple.svg" class="img-sm" height="18" width="18" alt="#">Book reading progress analytics
            </li>
            <li class="mb-10 font-19 col-lg-6 col-md-6 col-12">
              <img src="../assets/default/svgs/check-simple.svg" class="img-sm" height="18" width="18" alt="#">Reading time estimation
            </li>
            <li class="mb-10 font-19 col-lg-6 col-md-6 col-12">
              <img src="../assets/default/svgs/check-simple.svg" class="img-sm" height="18" width="18" alt="#">Reading activity &amp; assessments
            </li>
            <li class="mb-10 font-19 col-lg-6 col-md-6 col-12">
              <img src="../assets/default/svgs/check-simple.svg" class="img-sm" height="18" width="18" alt="#">Book Chapter Quizzes &amp; practices
            </li>
            <li class="mb-10 font-19 col-lg-6 col-md-6 col-12">
              <img src="../assets/default/svgs/check-simple.svg" class="img-sm" height="18" width="18" alt="#">Full Book Quiz &amp; assessments
            </li>
            <li class="mb-10 font-19 col-lg-6 col-md-6 col-12">
              <img src="../assets/default/svgs/check-simple.svg" class="img-sm" height="18" width="18" alt="#">Easy Search &amp; navigation
            </li>
          </ul>
          <div class="d-flex align-items-center">
            <a href="#" data-toggle="modal" data-target="#exampleModal" class="book-btn justify-content-center bg-primary text-white">Start Reading</a>
            <a href="#" data-toggle="modal" data-target="#exampleModal" class="book-btn justify-content-center ml-15">Continue Reading</a>
          </div>
        </div>
      </div>
    </div>
    <div class="masonry-grid-gallery">
      <div class="masonry-grid">
        <div class="row">
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="https:../assets/default/img/book-masonry1.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="../assets/default/img/book-masonry6.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="../assets/default/img/book-masonry4.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="../assets/default/img/book05.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="../assets/default/img/book02.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="../assets/default/img/book03.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="https:../assets/default/img/book-masonry6.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
          <div class="grid-item col-lg-3 col-md-3 col-sm-6">
            <div class="img-holder">
              <figure>
                <a href="#">
                  <img src="../assets/default/img/book05.png" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager">
                </a>
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="lms-services lms-contact-info mx-w-100 pt-80 pb-50 mb-80 lms-wave-shape-top" style="background-color: #f6b801;">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title text-center mb-50">
            <h2 class="mt-0 mb-10 font-40">Rurera tools for book reading validation</h2>
            <p class="font-19 pt-5 text-dark-charcoal">Reading stimulates critical thinking, analytical skills, and problem-solving abilities.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services-card text-center mb-30 pr-40 pl-40">
            <div class="services-card-body">
              <figure class="icon-md">
                <img src="../assets/default/svgs/book2.svg" alt="support" title="support" width="100" height="100" itemprop="image" loading="eager">
              </figure>
              <div class="services-text mt-20">
                <h2 itemprop="title" class="font-24 mb-10">Book Chapter Quizzes</h2>
                <p itemprop="description" class="text-dark-charcoal">Your ultimate resource help for resolving quizzes and practices.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services-card text-center mb-30 pr-40 pl-40">
            <div class="services-card-body">
              <figure class="icon-md">
                <img src="../assets/default/svgs/analysis.svg" alt="knowledge" title="knowledge" width="100" height="100" itemprop="image" loading="eager">
              </figure>
              <div class="services-text mt-20">
                <h2 itemprop="title" class="font-24 mb-10">Assessments &amp; Tests</h2>
                <p itemprop="description" class="text-dark-charcoal">Get assessments related to your reading interests and level.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services-card text-center mb-30 pr-40 pl-40">
            <div class="services-card-body">
              <figure class="icon-md">
                <img src="../assets/default/svgs/coins-money.svg" alt="technical" title="technical" width="100" height="100" itemprop="image" loading="eager">
              </figure>
              <div class="services-text mt-20">
                <h2 itemprop="title" class="font-24 mb-10">Earn Reading Rewards</h2>
                <p itemprop="description" class="text-dark-charcoal">The more you read, the more you'll earn Coin Points, giving you even more.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="lms-books-listing p-0" style="background-color: #ffff;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="books-listing-holder">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
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
                                                                  <a href="/books/{{$bookData->book_slug}}" class="read-btn" itemprop="url">
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
      </div>
    </div>
  </section>
  <section class="lms-blog lms-blog-grid mx-w-100 pt-80 pb-50 mb-80" style="background-color:#7679ee;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-12">
          <div class="section-title mb-50">
            <h2 itemprop="title" class="text-dark-charcoal text-white font-40">Inspiring every student to Read and show their <span class="text
  scribble">best.</span>
            </h2>
            <p class="font-19 pt-10 text-white"> Discover ebooks, fiction books, board books, kids stories , children books, and more from Rurera book shelf. <br> Truly Loved by millions of readers worldwide! </p>
          </div>
        </div>
        <div class="col-12 col-lg-12">
          <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
              <div class="mb-40">
                <div class="blog-grid-card pb-0">
                  <div class="blog-grid-detail pr-0">
                    <div class="blog-grid-image">
                      <img src="../assets/default/img/bookchoose-img1.png" width="370" height="250" class="img-cover" loading="eager" alt="#">
                    </div>
                    <h3 itemprop="title" class="blog-grid-title mt-15 text-dark-charcoal px-20">
                      <a itemprop="url" href="https://rurera.chimpstudio.co.uk/activity">Reading Progress and Statistics</a>
                    </h3>
                    <div itemprop="description" class="mt-5 blog-grid-desc px-20 pb-20"> It offers reading progress, like percentage of the book read or estimated time remaining to finish a chapter or the entire book along with reading speed or total reading time. </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
              <div class="mb-40">
                <div class="blog-grid-card pb-0">
                  <div class="blog-grid-detail pr-0">
                    <div class="blog-grid-image">
                      <img src="../assets/default/img/bookchoose-img2.png" width="370" height="250" loading="eager" class="img-cover" alt="#">
                    </div>
                    <h3 itemprop="title" class="blog-grid-title mt-15 text-dark-charcoal px-20">
                      <a itemprop="url" href="https://rurera.chimpstudio.co.uk/register">E-Book Formats</a>
                    </h3>
                    <div itemprop="description" class="mt-5 blog-grid-desc px-20 pb-20"> Another exciting feature is an out-stream book reading format for web. It provide an enticing, interactive, silent highlight and scroll through content. </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
              <div class="mb-40">
                <div class="blog-grid-card pb-0">
                  <div class="blog-grid-detail pr-0">
                    <div class="blog-grid-image">
                      <img src="../assets/default/img/bookchoose-img3.png" width="370" height="250" loading="eager" class="img-cover" alt="#">
                    </div>
                    <h3 itemprop="title" class="blog-grid-title mt-15 text-dark-charcoal px-20">
                      <a itemprop="url" href="https://rurera.chimpstudio.co.uk/rewards">Get Rewards</a>
                    </h3>
                    <div itemprop="description" class="mt-5 blog-grid-desc px-20 pb-20"> Continue Reading the books and earn Coin Points that can be later exchanged with your favorite toys. The more you read, the more you'll earn Coin Points, giving you even more. </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="lms-faqs">
    <h2 class="font-36 font-weight-bold mb-30" style="text-align: center; color: #27325e;">Common Questions</h2>
    <div id="accordion">
      <div class="card">
        <div class="card-header" id="heading">
          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">What are Rurera Collection Edition books?</button>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="heading" data-parent="#accordion">
          <div class="card-body">
            <p>Rurera Collection Editions are exclusive versions of children's books carefully selected from leading publishers and artistically redesigned as a stunning, cohesive set exclusively for Rurera Book Club members.</p>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">How do you make sure the books are good?</button>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
          <div class="card-body"> At Rurera, we maintain the quality of our books through expert curation, collaborating with renowned publishers, and considering reader feedback. Our team evaluates each book for engaging storytelling, educational value, captivating illustrations, and positive themes to ensure a high standard of excellence in our Collection Editions. </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Why not just buy books at the store or on Amazon?</button>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
          <div class="card-body"> Rurera Book Club offers exclusive curated Collection Editions not available in traditional stores or Amazon. Subscribing to Rurera provides a personalized and convenient reading experience, with carefully selected books delivered to your doorstep. It fosters a sense of community among book lovers. </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingfour">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">Can l order today but have my subscription start later?</button>
        </div>
        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
          <div class="card-body"> Yes, you can place an order with Rurera today and choose a future start date for your subscription. Simply specify your preferred start date during the ordering process, and we will ensure that your subscription begins accordingly. This allows you to secure your subscription in advance while having it activate at a later date of your choosing. </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingfive">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">Are there any initiation, cancellation, or hidden fees?</button>
        </div>
        <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
          <div class="card-body"> No, there are no extra fees to join or cancel your Rurera Book Club subscription. You only pay the advertised price, and you can cancel anytime without any additional charges. We believe in simplicity and transparency for a hassle-free experience. </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingsix">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">What if I have too many books?</button>
        </div>
        <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
          <div class="card-body"> If you have too many books from Rurera Book Club, you can contact customer support to make changes. They can help you receive books less often or pause your subscription until you're ready for more. We want to make sure you have a collection that works for you. </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="heading7">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">What if I have kids in multiple age ranges?</button>
        </div>
        <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion">
          <div class="card-body"> If you have children of different ages, Rurera Book Club can adjust to meet their reading needs. Just tell us the ages of your kids, and we will send books suitable for each child. This way, each child can enjoy books that are just right for them. </div>
        </div>
      </div>
    </div>
  </div>
  <section class="my-50 lms-blog mx-w-100 mt-30 mb-60 pt-50">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
          <div class="section-title text-center mb-50">
            <h2 itemprop="title" class="font-40 mb-10 text-dark-charcoal">Blog</h2>
            <p itemprop="description">Get to know more about latest news, resources and much more.</p>
          </div>
        </div>
        <div class="col-12 col-lg-12">
          <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
              <div class="blog-grid-card rurera-grid" itemscope="" itemtype="https://schema.org/Blog">
                <div class="blog-grid-detail">
                  <span class="badge created-at d-flex align-items-center">
                    <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
                    <span itemprop="datePublished" content="2023-04-05T08:00:00+08:00">13 Jun 2023</span>
                  </span>
                  <h3 class="blog-grid-title mt-10" itemprop="name">
                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">How Online Courses Benefit KS1 and KS2 Students</a>
                  </h3>
                  <div class="mt-10 blog-grid-desc" itemprop="description">In today's digital era, offering unique benefits and...</div>
                  <ul class="blog-tags">
                    <li itemprop="name">Learning</li>
                    <li itemprop="name">Online learning</li>
                  </ul>
                </div>
                <div class="blog-grid-image">
                  <img src="/store/1/default_images/blogs/blog-3.png" class="img-cover" alt="#" width="270" height="270" itemprop="image" loading="eager">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3">
              <div class="blog-grid-card rurera-grid" itemscope="" itemtype="https://schema.org/Blog">
                <div class="blog-grid-detail">
                  <span class="badge created-at d-flex align-items-center">
                    <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
                    <span itemprop="datePublished" content="2023-04-05T08:00:00+08:00">28 Apr 2023</span>
                  </span>
                  <h3 class="blog-grid-title mt-10" itemprop="name">
                    <a itemprop="url" href="/blog/Preparing-for-Success-Online-Courses-for-Year-5-Students">Online Courses for Year 5 Students</a>
                  </h3>
                  <div class="mt-10 blog-grid-desc" itemprop="description">Online courses are becoming increasingly. students have had...</div>
                  <ul class="blog-tags">
                    <li itemprop="name">Preparing for Success</li>
                  </ul>
                </div>
                <div class="blog-grid-image">
                  <img src="/store/1/default_images/blogs/blog-19.png" class="img-cover" alt="#" width="270" height="270" itemprop="image" loading="eager">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3">
              <div class="blog-grid-card rurera-grid" itemscope="" itemtype="https://schema.org/Blog">
                <div class="blog-grid-detail">
                  <span class="badge created-at d-flex align-items-center">
                    <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
                    <span itemprop="datePublished" content="2023-04-05T08:00:00+08:00">13 Jun 2023</span>
                  </span>
                  <h3 class="blog-grid-title mt-10" itemprop="name">
                    <a itemprop="url" href="/blog/Engaging-Students-through-Interactive-Technologies">Engaging Students through Interactive Technologies</a>
                  </h3>
                  <div class="mt-10 blog-grid-desc" itemprop="description">In recent years, the field of education has witnessed a significant transformation...</div>
                  <ul class="blog-tags">
                    <li itemprop="name">Engaging</li>
                    <li itemprop="name">Interactive</li>
                  </ul>
                </div>
                <div class="blog-grid-image">
                  <img src="/store/1/default_images/blogs/blog-38.png" class="img-cover" alt="#" width="270" height="270" itemprop="image" loading="eager">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3">
              <div class="blog-grid-card rurera-grid" itemscope="" itemtype="https://schema.org/Blog">
                <div class="blog-grid-detail">
                  <span class="badge created-at d-flex align-items-center">
                    <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
                    <span itemprop="datePublished" content="2023-04-05T08:00:00+08:00">28 Apr 2023</span>
                  </span>
                  <h3 class="blog-grid-title mt-10" itemprop="name">
                    <a itemprop="url" href="/blog/INTERACTIVE-LEARNING-MADE-FUN-ENGAGING-QUIZ-FORMATS-FOR-KS1-AND-KS2">Engaging Quiz Formats For Ks1 And Ks2</a>
                  </h3>
                  <div class="mt-10 blog-grid-desc" itemprop="description">Learning doesn't have to be boring. In fact, it should be fun and engaging...</div>
                  <ul class="blog-tags">
                    <li itemprop="name">Student</li>
                    <li itemprop="name">Lifelong Learning</li>
                  </ul>
                </div>
                <div class="blog-grid-image">
                  <img src="/store/1/default_images/blogs/blog-18.png" class="img-cover" alt="#" width="270" height="270" itemprop="image" loading="eager">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="lms-text-section w-100 py-70 mt-80" style="background-color: #f27530;">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="lms-text-holder d-flex flex-column justify-content-center text-center" itemscope="" itemtype="https://schema.org/lms-text-holder">
            <h2 itemprop="title" class="mb-20 text-white font-40">Find Your Next Book to Read!</h2>
            <p class="text-white font-19" itemprop="description"> In the digital realm, students have discovered the convenience and accessibility of online book reading, <br> allowing them to explore a vast library of resources anytime and anywhere. </p>
            <div class="lms-btn-group mt-30 justify-content-center">
              <a itemprop="url" href="https://rurera.chimpstudio.co.uk/register" class="lms-btn rounded-pill text-white border-white">Get Started</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade lms-choose-membership" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="modal-body">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="get" role="tabpanel" aria-labelledby="get-tab">
              <div class="membership-steps-holder">
                <div class="container">
                  <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-30">
                      <h2>Explore the details of your free trial experience.</h2>
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                      <div class="membership-steps text-center row">
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                          <ul class="membership-steps-list mb-20">
                            <li class="active">
                              <a href="#">
                                <span class="icon-svg">
                                  <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="lock-check" class="icon glyph">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                      <path d="M18,8H17V7A5,5,0,0,0,7,7V8H6a2,2,0,0,0-2,2V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V10A2,2,0,0,0,18,8ZM9,7a3,3,0,0,1,6,0V8H9Zm6.71,6.71-4,4a1,1,0,0,1-1.42,0l-2-2a1,1,0,0,1,1.42-1.42L11,15.59l3.29-3.3a1,1,0,0,1,1.42,1.42Z"></path>
                                    </g>
                                  </svg>
                                </span>
                              </a>
                            </li>
                            <li>
                              <a href="#">
                                <span class="icon-svg">
                                  <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                      <path fill-rule="evenodd" d="M6 8a6 6 0 1112 0v2.917c0 .703.228 1.387.65 1.95L20.7 15.6a1.5 1.5 0 01-1.2 2.4h-15a1.5 1.5 0 01-1.2-2.4l2.05-2.733a3.25 3.25 0 00.65-1.95V8zm6 13.5A3.502 3.502 0 018.645 19h6.71A3.502 3.502 0 0112 21.5z"></path>
                                    </g>
                                  </svg>
                                </span>
                              </a>
                            </li>
                            <li>
                              <a href="#">
                                <span class="icon-svg">
                                  <svg height="64px" width="64px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17.837 17.837" xml:space="preserve" fill="#fff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                      <g>
                                        <path d="M16.145,2.571c-0.272-0.273-0.718-0.273-0.99,0L6.92,10.804l-4.241-4.27 c-0.272-0.274-0.715-0.274-0.989,0L0.204,8.019c-0.272,0.271-0.272,0.717,0,0.99l6.217,6.258c0.272,0.271,0.715,0.271,0.99,0 L17.63,5.047c0.276-0.273,0.276-0.72,0-0.994L16.145,2.571z"></path>
                                      </g>
                                    </g>
                                  </svg>
                                </span>
                              </a>
                            </li>
                          </ul>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                          <div class="membership-steps">
                            <h3 class="mb-5">Today</h3>
                            <p>Begin your rurera journey and start reading for free.</p>
                          </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                          <div class="membership-steps">
                            <h3 class="mb-5">Day 5</h3>
                            <p>An email reminder will be sent as your free trial ends.</p>
                          </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                          <div class="membership-steps">
                            <h3 class="mb-5">Day 7</h3>
                            <p>Payment processed on 6th day, cancel anytime before date.</p>
                          </div>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                          <a href="#" class="nav-link mt-20 btn-primary rounded-pill" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> Start your 7-day free trial </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="form-login-reading">
                <div class="container">
                  <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-30">
                      <h2>Start Reading Today</h2>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 mx-auto">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                          <a href="/google" target="_blank" class="social-login mt-20 p-15 text-center d-flex align-items-center justify-content-center">
                            <img src="/assets/default/img/auth/google.svg" height="24" width="24" class="mr-auto" alt=" google svg">
                            <span class="flex-grow-1">Login with Google account</span>
                          </a>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                          <a href="#" target="_blank" class="social-login mt-20 p-15 text-center d-flex align-items-center justify-content-center">
                            <img src="/assets/default/img/auth/facebook.svg" height="24" width="24" class="mr-auto" alt="facebook svg">
                            <span class="flex-grow-1">Login with Facebook account</span>
                          </a>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                          <div class="form-separator">
                            <span>or</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                          <div class="input-field">
                            <input type="text" placeholder="Email Address">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-field">
                            <input type="text" placeholder="password">
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                          <a href="#" class="nav-link btn-primary rounded-pill mb-25 text-center" id="book-tab" data-toggle="tab" data-target="#book" type="button" role="tab" aria-controls="book" aria-selected="true"> continue </a>
                        </div>
                      </div>
                      <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                        <p class="mb-20">By Clicking on Start Free Trial, I agree to the <a href="#">Terms of Service</a>And <a href="#">Privacy Policy</a>
                        </p>
                        <div class="subscription mb-20">
                          <span>Already have a subscription? <a href="#" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">log in</a>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="book" role="tabpanel" aria-labelledby="book-tab">
              <div class="book-detail-holder">
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="book-detail">
                        <div class="img-holder">
                          <figure>
                            <img src="../assets/default/img/book-list1.png" height="192" width="152" alt="#">
                          </figure>
                        </div>
                        <div class="text-holder mt-20">
                          <h2>Consult a grownup for assistance.</h2>
                          <p class="mt-15">
                            <a href="#">
                              <span class="icon-svg">
                                <svg width="64px" height="64px" viewBox="0 0 48 48" id="b" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                  <g id="SVGRepo_iconCarrier">
                                    <path class="c" d="m32.017,16.7078c1.7678,1.3258,3.241,4.7141,2.9463,8.397-.2946,2.799-1.7678,5.1561-2.9463,6.04"></path>
                                    <path class="c" d="m5.5,17.7391v12.8165h8.5443l11.0487,8.839V8.6054l-11.0487,9.1336H5.5Z"></path>
                                    <path class="c" d="m37.173,10.9625c3.0936,2.3571,5.598,8.397,5.3034,15.0263-.4419,5.0088-2.9463,9.1336-5.3034,10.9014"></path>
                                  </g>
                                </svg>
                              </span>
                            </a> Upgrade to the Family Premium plan to read the rest of this book and enjoy unlimited access to our entire library.
                          </p>
                          <a href="#" class="nav-link btn-primary rounded-pill mb-25" id="subscribe-tab" data-toggle="tab" data-target="#subscribe" type="button" role="tab" aria-controls="subscribe" aria-selected="false"> Get Rurera </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="subscribe" role="tabpanel" aria-labelledby="subscribe-tab">
              <div class="subscribe-plan-holder">
                <div class="container">
                  <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center mb-40">
                      <h2>Select the rurera Family plan for your subscription.</h2>
                      <p class="mt-10">Pay monthly or save 44% annually after your free trial!</p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-30 pb-30 px-20 mb-30">
                        <div class="d-flex align-items-start text-primary mt-20">
                          <span class="font-36 line-height-1">$20</span>
                        </div>
                        <ul class="mt-20 plan-feature">
                          <li class="mt-10">15 days of subscription</li>
                        </ul>
                        <button type="submit" id="contact-tab" data-toggle="tab" data-target="#contact" role="tab" aria-controls="contact" aria-selected="false" class="btn btn-primary btn-block mt-30 rounded-pill bg-none"> Purchase </button>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-30 pb-30 px-20 mb-30">
                        <span class="badge badge-primary badge-popular px-15 py-5">Popular</span>
                        <div class="d-flex align-items-start text-primary mt-20">
                          <span class="font-36 line-height-1">$100</span>
                        </div>
                        <ul class="mt-20 plan-feature">
                          <li class="mt-10">30 days of subscription</li>
                        </ul>
                        <button type="submit" id="contact-tab" data-toggle="tab" data-target="#contact" role="tab" aria-controls="contact" aria-selected="false" class="btn btn-primary btn-block mt-30 rounded-pill"> Purchase </button>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 price-plan-image">
                      <img src="../assets/default/img/price-plan.png" alt="#" height="270" width="166">
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center bg-dark-green bg-dark-green">
                      <strong>96% of subscribing parents in rurera Family report significant improvement in their child's reading skills.</strong>
                      <div class="subscription mt-20">
                        <span>Already have a subscription? <a href="." id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">log in</a>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              <div class="book-form-holder">
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-12 col-lg-9 col-md-9 col-sm-12 text-center">
                      <h2>The Final Step to Reading!</h2>
                      <p>No need to worry! We won't ask for payment until after your 7-day free trial ends.</p>
                    </div>
                    <div class="col-12 col-lg-9 col-md-9 col-sm-12">
                      <div class="book-form mt-30">
                        <div class="row">
                          <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                              <div class="input-field">
                                <input type="text" placeholder="First Name">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                              <div class="input-field">
                                <input type="text" placeholder="Last Name">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <div class="input-field input-card">
                                <span class="icon-svg">
                                  <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                      <g>
                                        <path class="st0" d="M261.031,153.484h-5.375v7.484h5.375c1.25,0,2.266-0.344,3-1.031c0.766-0.688,1.156-1.594,1.156-2.719 c0-1.109-0.391-2-1.156-2.703C263.297,153.828,262.281,153.484,261.031,153.484z"></path>
                                        <path class="st0" d="M140.75,169.141c0.141-0.391,0.281-0.891,0.344-1.453c0.094-0.578,0.141-1.266,0.172-2.078 c0.031-0.797,0.031-1.766,0.031-2.891c0-1.109,0-2.063-0.031-2.875s-0.078-1.5-0.172-2.078c-0.063-0.578-0.203-1.047-0.344-1.453 c-0.156-0.406-0.375-0.75-0.641-1.078c-0.953-1.172-2.359-1.75-4.266-1.75H131.5v18.484h4.344c1.906,0,3.313-0.594,4.266-1.75 C140.375,169.891,140.594,169.531,140.75,169.141z"></path>
                                        <path class="st0" d="M88.219,159.938c0.75-0.688,1.141-1.594,1.141-2.719c0-1.109-0.391-2-1.141-2.703 c-0.75-0.688-1.75-1.031-3.016-1.031h-5.375v7.484h5.375C86.469,160.969,87.469,160.625,88.219,159.938z"></path>
                                        <polygon class="st0" points="229.875,167.219 237.141,167.219 233.563,156.906 "></polygon>
                                        <path class="st0" d="M466.656,88H45.344C20.313,88,0,108.313,0,133.344v245.313C0,403.688,20.313,424,45.344,424h421.313 C491.688,424,512,403.688,512,378.656V133.344C512,108.313,491.688,88,466.656,88z M435.656,138.313 c12.344,0,22.344,10,22.344,22.344S448,183,435.656,183s-22.344-10-22.344-22.344S423.313,138.313,435.656,138.313z M375.875,138.313c12.344,0,22.344,10,22.344,22.344S388.219,183,375.875,183s-22.344-10-22.344-22.344 S363.531,138.313,375.875,138.313z M276.781,148.531h10.547c2,0,3.703,0.344,5.141,1c1.406,0.672,2.625,1.719,3.688,3.156 c0.438,0.609,0.781,1.25,1.031,1.938c0.266,0.672,0.469,1.406,0.563,2.219s0.188,1.703,0.203,2.672 c0.031,0.969,0.047,2.047,0.047,3.203c0,1.172-0.016,2.25-0.047,3.219c-0.016,0.969-0.109,1.844-0.203,2.656 s-0.297,1.563-0.563,2.234c-0.25,0.672-0.594,1.328-1.031,1.938c-1.063,1.422-2.281,2.484-3.688,3.141 c-1.438,0.672-3.141,1-5.141,1h-10.547V148.531z M197.391,159.063c0.047-1.094,0.156-2.094,0.328-3.016 c0.188-0.922,0.469-1.766,0.859-2.516c0.406-0.781,0.969-1.531,1.703-2.25c1.016-0.938,2.156-1.688,3.406-2.203 c1.266-0.516,2.75-0.766,4.438-0.766c2.734,0,5.063,0.75,7,2.25s3.156,3.719,3.703,6.703H213c-0.281-1.172-0.813-2.141-1.594-2.891 s-1.875-1.125-3.281-1.125c-0.781,0-1.5,0.125-2.109,0.391c-0.625,0.266-1.125,0.625-1.547,1.078c-0.281,0.281-0.5,0.625-0.672,1 s-0.328,0.844-0.438,1.438c-0.109,0.578-0.203,1.313-0.234,2.203c-0.063,0.891-0.094,2.016-0.094,3.359 c0,1.359,0.031,2.484,0.094,3.375c0.031,0.891,0.125,1.625,0.234,2.219c0.109,0.563,0.266,1.063,0.438,1.422 c0.172,0.375,0.391,0.703,0.672,1c0.422,0.453,0.922,0.797,1.547,1.078c0.609,0.25,1.328,0.391,2.109,0.391 c1.406,0,2.531-0.375,3.297-1.141c0.797-0.75,1.328-1.719,1.625-2.875h5.781c-0.547,2.969-1.766,5.203-3.703,6.703 c-1.938,1.516-4.266,2.266-7,2.266c-1.688,0-3.172-0.281-4.438-0.781c-1.25-0.531-2.391-1.266-3.406-2.219 c-0.734-0.719-1.297-1.469-1.703-2.219c-0.391-0.781-0.672-1.625-0.859-2.531c-0.172-0.922-0.281-1.938-0.328-3.016 c-0.031-1.094-0.063-2.313-0.063-3.672C197.328,161.375,197.359,160.156,197.391,159.063z M163.172,148.531h20.969v4.953h-7.625 v23.422h-5.703v-23.422h-7.641V148.531z M152.844,148.531h5.688v28.375h-5.688V148.531z M125.797,148.531h10.547 c2,0,3.688,0.344,5.125,1c1.422,0.672,2.656,1.719,3.688,3.156c0.438,0.609,0.781,1.25,1.047,1.938 c0.266,0.672,0.453,1.406,0.563,2.219s0.172,1.703,0.203,2.672s0.031,2.047,0.031,3.203c0,1.172,0,2.25-0.031,3.219 s-0.094,1.844-0.203,2.656s-0.297,1.563-0.563,2.234s-0.609,1.328-1.047,1.938c-1.031,1.422-2.266,2.484-3.688,3.141 c-1.438,0.672-3.125,1-5.125,1h-10.547V148.531z M100.969,148.531h19.219v4.953h-13.531v6.641h11.531v4.953h-11.531v6.891h13.531 v4.938h-19.219V148.531z M74.125,148.531h11.453c1.484,0,2.797,0.25,3.969,0.703c1.172,0.469,2.172,1.094,3,1.875 s1.453,1.703,1.859,2.75c0.438,1.047,0.656,2.172,0.656,3.359c0,1.016-0.156,1.922-0.438,2.719c-0.297,0.797-0.688,1.5-1.156,2.125 c-0.5,0.625-1.063,1.156-1.719,1.594c-0.641,0.438-1.313,0.781-2.031,1.016l6.531,12.234h-6.625l-5.688-11.313h-4.109v11.313 h-5.703V148.531z M60.344,285.75v-21.875h33.25v21.875H60.344z M93.594,292.75v23.625H75.219c-8.219,0-14.875-6.656-14.875-14.875 v-8.75H93.594z M60.344,256.875V235h33.25v21.875H60.344z M60.344,228v-8.75c0-8.219,6.656-14.875,14.875-14.875h18.375V228H60.344 z M47.688,162.719c0-1.344,0.031-2.563,0.063-3.656c0.047-1.094,0.156-2.094,0.344-3.016c0.172-0.922,0.469-1.766,0.844-2.516 c0.406-0.781,0.969-1.531,1.719-2.25c1-0.938,2.125-1.688,3.406-2.203c1.25-0.516,2.734-0.766,4.422-0.766 c2.734,0,5.078,0.75,7.016,2.25c1.922,1.5,3.141,3.719,3.688,6.703h-5.813c-0.297-1.172-0.828-2.141-1.594-2.891 c-0.781-0.75-1.875-1.125-3.297-1.125c-0.797,0-1.484,0.125-2.109,0.391s-1.125,0.625-1.531,1.078c-0.281,0.281-0.5,0.625-0.688,1 c-0.172,0.375-0.313,0.844-0.438,1.438c-0.109,0.578-0.188,1.313-0.234,2.203s-0.078,2.016-0.078,3.359 c0,1.359,0.031,2.484,0.078,3.375s0.125,1.625,0.234,2.219c0.125,0.563,0.266,1.063,0.438,1.422c0.188,0.375,0.406,0.703,0.688,1 c0.406,0.453,0.906,0.797,1.531,1.078c0.625,0.25,1.313,0.391,2.109,0.391c1.422,0,2.531-0.375,3.297-1.141 c0.797-0.75,1.328-1.719,1.625-2.875h5.781c-0.547,2.969-1.766,5.203-3.688,6.703c-1.938,1.516-4.281,2.266-7.016,2.266 c-1.688,0-3.172-0.281-4.422-0.781c-1.281-0.531-2.406-1.266-3.406-2.219c-0.75-0.719-1.313-1.469-1.719-2.219 c-0.375-0.781-0.672-1.625-0.844-2.531c-0.188-0.922-0.297-1.938-0.344-3.016C47.719,165.297,47.688,164.078,47.688,162.719z M128,370.656H48v-16h80V370.656z M132.094,228v7v9.031v0.594v12.25v7v9.625v5.531v6.719v7v13.406v10.219h-31.5v-10.219V292.75v-7 v-6.719V273.5v-9.625v-7v-12.25v-0.594V235v-7v-7.594v-16.031h18.375h13.125h5.25h16.625h3.484c8.219,0,14.891,6.656,14.891,14.875 V228h-18.375h-16.625H132.094z M139.094,256.875V235h33.25v21.875H139.094z M172.344,263.875v21.875h-33.25v-21.875H172.344z M139.094,316.375V292.75h33.25v8.75c0,8.219-6.672,14.875-14.891,14.875H139.094z M240,370.656h-80v-16h80V370.656z M240.375,176.906l-1.719-5.016h-10.375l-1.781,5.016h-5.938l10.625-28.375h4.469l10.688,28.375H240.375z M259.75,165.594h-4.094 v11.313h-5.703v-28.375h11.453c1.469,0,2.797,0.25,3.969,0.703c1.172,0.469,2.172,1.094,3,1.875 c0.813,0.781,1.438,1.703,1.859,2.75c0.438,1.047,0.641,2.172,0.641,3.359c0,1.016-0.141,1.922-0.438,2.719 c-0.281,0.797-0.672,1.5-1.156,2.125c-0.5,0.625-1.063,1.156-1.703,1.594s-1.328,0.781-2.047,1.016l6.531,12.234h-6.609 L259.75,165.594z M352,370.656h-80v-16h80V370.656z M464,370.656h-80v-16h80V370.656z M464,322.656H304v-16h160V322.656z"></path>
                                        <path class="st0" d="M291.75,169.141c0.125-0.391,0.266-0.891,0.344-1.453c0.078-0.578,0.125-1.266,0.156-2.078 c0.031-0.797,0.031-1.766,0.031-2.891c0-1.109,0-2.063-0.031-2.875s-0.078-1.5-0.156-2.078s-0.219-1.047-0.344-1.453 c-0.156-0.406-0.375-0.75-0.656-1.078c-0.938-1.172-2.375-1.75-4.266-1.75h-4.344v18.484h4.344c1.891,0,3.328-0.594,4.266-1.75 C291.375,169.891,291.594,169.531,291.75,169.141z"></path>
                                      </g>
                                    </g>
                                  </svg>
                                </span>
                                <input type="text" placeholder="Card Number">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                            <p class="mb-25"> Once your 7-day free trial is over, we will automatically charge your chosen payment method $19.99 every month until you decide to cancel. You have the freedom to cancel at any time. Keep in mind that there may be sales tax added. For instructions on how to cancel, please refer to the provided guidelines </p>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                            <a href="/login" class="nav-link btn-primary rounded-pill mb-25">Sart Free Trial</a>
                          </div>
                          <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                            <p class="mb-20">By Clicking on Start Free Trial, I agree to the <a href="#">Terms of Service</a>And <a href="#">Privacy Policy</a>
                            </p>
                            <div class="subscription mb-20">
                              <span>Already have a subscription? <a href="#">log in</a>
                              </span>
                            </div>
                            <div class="secure-server">
                              <figure>
                                <svg fill="#000000" width="64px" height="64px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="lock-check" class="icon glyph">
                                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                  <g id="SVGRepo_iconCarrier">
                                    <path d="M18,8H17V7A5,5,0,0,0,7,7V8H6a2,2,0,0,0-2,2V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V10A2,2,0,0,0,18,8ZM9,7a3,3,0,0,1,6,0V8H9Zm6.71,6.71-4,4a1,1,0,0,1-1.42,0l-2-2a1,1,0,0,1,1.42-1.42L11,15.59l3.29-3.3a1,1,0,0,1,1.42,1.42Z"></path>
                                  </g>
                                </svg>
                              </figure>
                              <span> Secure Server <br> SSL Encrypted </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
@endpush
