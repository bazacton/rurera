@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="position-relative text-center page-sub-header pt-80 pb-30">
  <div class="container h-100">
    <div class="row h-100 align-items-center text-left">
      <div class="col-12 col-md-12 col-lg-9">
        <p itemprop="sub title" class="lms-subtitle">How we've helped others</p>
        <h1 itemprop="title" class="font-72 font-weight-bold">
          Stories of Trust and <span class="text-scribble">Triumph!</span>
        </h1>
        <p itemprop="description" class="font-19">
          Rurera has earned the trust of parents, educators, and students by delivering personalized, engaging, and effective learning. From SATs prep to fun rewards, discover why so many confidently choose Rurera to enhance their learning journeys.
        </p>
      </div>
    </div>
  </div>
</section>
<section class="lms-testimonials testimonials-fancy">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-3 col-md-6 col-sm-12">
        <div class="testimonial-card fancy">
          <div class="testimonial-img text-center">
            <figure>
              <img src="../assets/default/img/bri-client2.jpg" alt="bran images" title="bran images" width="100%" height="auto" itemprop="image" loading="eager" />
            </figure>
          </div>
          <div class="testimonial-body">
            <h2 itemprop="title" class="post-title">Cristian Miller</h2>
            <span itemprop="sub title" class="sub-title">Teacher</span>
            <p itemprop="description">Rurera is an advance emerging learning platform. Love it!</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 col-md-6 col-sm-12">
        <div class="testimonial-card fancy">
          <div class="testimonial-img text-center">
            <figure>
              <img src="../assets/default/img/bri-client1.jpg" alt="bran images" title="bran images" width="100%" height="auto" itemprop="image" loading="eager" />
            </figure>
          </div>
          <div class="testimonial-body">
            <h2 itemprop="title" class="post-title">Peter J.</h2>
            <span itemprop="sub title" class="sub-title">Student</span>
            <p itemprop="description">
              My first choice is Rurera when it comes to pro level learning.
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 col-md-6 col-sm-12">
        <div class="testimonial-card fancy">
          <div class="testimonial-img text-center">
            <figure>
              <img src="../assets/default/img/bri-client3.jpg" alt="bran images" title="bran images" width="100%" height="auto" itemprop="image" loading="eager" />
            </figure>
          </div>
          <div class="testimonial-body">
            <h2 itemprop="title" class="post-title">Fiona Thompson</h2>
            <span itemprop="sub title" class="sub-title">Parent</span>
            <p itemprop="description">Rurera has recognized itself a great platform. Recommmended</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 col-md-6 col-sm-12">
        <div class="testimonial-card fancy">
          <div class="testimonial-img text-center">
            <figure>
              <img src="../assets/default/img/bri-client6.jpg" alt="bran images" title="bran images" width="100%" height="auto" itemprop="image" loading="eager" />
            </figure>
          </div>
          <div class="testimonial-body">
            <h2 itemprop="title" class="post-title">Kyle Matt</h2>
            <span itemprop="sub title" class="sub-title">Teacher</span>
            <p itemprop="description">As a teacher i would encourage to follow Rurera for sure.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="testimonials-fancy-bg">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="lms-text-section">
            <div class="lms-text-holder text-center">
              <small itemprop="best work">Shape your success story with </small><b>Rurera</b>
              <p itemprop="description" class="mt-10">
                Discover everything you need to guide learners toward success!
              </p>
              <div class="lms-btn-group mt-30">
                <a href="{{url('/')}}/register" class="lms-btn rounded-pill"
                  >Get Started<span class="svg-icon"
                    ><svg
                      width="10"
                      height="14"
                      viewBox="0 0 9 7"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.628.616a.5.5 0 1 0-.64.768L6.203 3.23H.5a.5.5 0 0 0 0 1h5.612L3.988 6a.5.5 0 1 0 .64.769l3.23-2.693a.5.5 0 0 0 0-.768L4.628.616z"
                      ></path></svg></span
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section
  class="home-sections home-sections-swiper find-instructor-section find-instructor-testimonial position-relative mt-20"
>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-lg-12 mb-50">
        <div class="element-title text-center">
          <h2 itemprop="title"  class="font-weight-bold mb-15">Trusted by Many, Loved by All</h2>
          <p itemprop="description"  class="text-center mb-10">
            Hear heartfelt stories from students, teachers, <br> and parents about their experiences.
          </p>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="position-relative left">
          <div class="find-instructor-circle">
            <span itemprop="number" class="lms-serial-no">#1</span>
          </div>
          <p itemprop="datePublished" content="2023-06-05">Happy parent / 4 June 2023</p>
          <h3 itemprop="title" class="font-36 font-weight-bold text-dark">Cristian Miller</h3>
          <p itemprop="description" class="font-16 font-weight-normal text-gray mt-10">As a parent, I want to share my incredible experience that has made a significant impact on my child's education. Rurera has truly transformed the way my child learns and engages with educational content. Recommended!</p>
        </div>
      </div>
      <div class="col-12 col-lg-6 mt-20 mt-lg-0">
        <div class="video-box d-flex flex-column align-items-center justify-content-center position-relative">
            <a href="javascript:;" id="play-vidio" class="home-video-play-button d-flex align-items-center justify-content-center position-relative">
                <img id="poster-img" src="/store/1/default_images/home_video_section.png" alt="home video section" title="home video section" width="100%" height="auto" itemprop="image" loading="eager">
                <span class="play-btn-holder">
                    <svg class="feather feather-play" fill="#fff" height="64px" width="64px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M45.563,29.174l-22-15c-0.307-0.208-0.703-0.231-1.031-0.058C22.205,14.289,22,14.629,22,15v30 c0,0.371,0.205,0.711,0.533,0.884C22.679,45.962,22.84,46,23,46c0.197,0,0.394-0.059,0.563-0.174l22-15 C45.836,30.64,46,30.331,46,30S45.836,29.36,45.563,29.174z M24,43.107V16.893L43.225,30L24,43.107z"></path> <path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M30,58C14.561,58,2,45.439,2,30 S14.561,2,30,2s28,12.561,28,28S45.439,58,30,58z"></path> </g> </g></svg>
                </span>
            </a>
            <video controls="true" id="video" preload="metadata" poster="/store/1/default_images/home_video_section.png">
                <source src="//cdn.jsdelivr.net/npm/big-buck-bunny-1080p@0.0.6/video.mp4" type="video/mp4">
            </video>
        </div>
      </div>
    </div>
  </div>
</section>

<section
  class="home-sections home-sections-swiper find-instructor-section find-instructor-testimonial position-relative"
>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-lg-6 mb-30">
        <div class="position-relative">
          <div class="vidio-holder">
            <img
              src="../assets/default/img/testimonial-2.jpg"
              class="find-instructor-section-hero"
              alt="Find the best instructor" title="Find the best instructor" width="100%" height="auto" itemprop="image" loading="eager"
            />
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="position-relative right">
          <div class="find-instructor-circle">
            <span itemprop="number" class="lms-serial-no">#2</span>
          </div>
            <p itemprop="datePublished" content="2023-06-05">Experienced Teacher / 30 May 2023</p>
          <h3 itemprop="title" class="font-36 font-weight-bold text-dark">Peter J.</h3>
          <p itemprop="description" class="font-16 font-weight-normal text-gray mt-10">One of the standout features of Rurera is its assessment and analytics capabilities. It provides real-time data on student performance, allowing me to track their progress and identify areas where additional support is needed.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="lms-column-section lms-text-section container-w mt-50 mb-0 pt-30 pb-30 pr-30 pl-30"
    style="background-color: #eaf7f0;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="lms-text-holder d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <h3 class="mb-10 font-24 align-items-center d-flex"> <span class="icon-svg mr-20">
                                <svg height="30px" width="30px" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 279.682 279.682" xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <path style="fill:#000002;"
                                                d="M143.25,55.486c-41.06,0-74.465,33.405-74.465,74.465c0,16.824,5.511,32.711,15.938,45.939 c1.998,2.536,4.15,5.033,6.23,7.448c6.212,7.208,12.078,14.017,14.166,21.675c0.045,0.165,0.438,1.773,0.38,7.247l-0.01,0.791 c-0.063,4.444-0.147,10.528,4.352,15.091c3.081,3.125,7.399,4.645,13.204,4.645h40.272c6.268,0,10.774-1.534,13.776-4.689 c4.061-4.267,3.789-9.779,3.608-13.427c-0.032-0.645-0.066-1.296-0.074-1.944c-0.065-5.48,0.345-7.025,0.362-7.09 c2.121-7.657,8.993-15.732,15.057-22.855c2.023-2.377,3.934-4.622,5.714-6.879c10.431-13.23,15.944-29.12,15.944-45.951 C217.705,88.892,184.305,55.486,143.25,55.486z M189.982,166.614c-1.607,2.036-3.429,4.178-5.358,6.445 c-7.07,8.307-15.084,17.722-18.089,28.572c-0.429,1.546-0.988,4.395-0.905,11.273c0.01,0.835,0.049,1.675,0.091,2.507 c0.032,0.657,0.075,1.523,0.071,2.209c-0.528,0.086-1.325,0.166-2.475,0.166h-40.272c-1.276,0-2.022-0.135-2.405-0.237 c-0.198-0.977-0.17-3.007-0.152-4.287l0.012-0.844c0.072-6.919-0.483-9.789-0.907-11.348c-2.98-10.936-10.575-19.749-17.275-27.524 c-2.066-2.398-4.019-4.664-5.813-6.942c-8.32-10.557-12.718-23.232-12.718-36.654c0-32.789,26.676-59.465,59.465-59.465 c32.783,0,59.455,26.676,59.455,59.465C202.705,143.379,198.306,156.058,189.982,166.614z">
                                            </path>
                                            <path style="fill:#000002;"
                                                d="M161.766,239.564h-37.041c-7.995,0-14.5,6.505-14.5,14.5v11.117c0,7.995,6.505,14.5,14.5,14.5 h37.041c7.995,0,14.5-6.505,14.5-14.5v-11.117C176.266,246.069,169.761,239.564,161.766,239.564z M161.266,264.682h-36.041v-10.117 h36.041V264.682z">
                                            </path>
                                            <path style="fill:#000002;"
                                                d="M143.245,45.779c4.143,0,7.5-3.357,7.5-7.5V7.5c0-4.143-3.357-7.5-7.5-7.5 c-4.143,0-7.5,3.357-7.5,7.5v30.779C135.745,42.422,139.103,45.779,143.245,45.779z">
                                            </path>
                                            <path style="fill:#000002;"
                                                d="M241.917,34.598c-2.858-2.995-7.606-3.106-10.604-0.248l-22.77,21.73 c-2.997,2.859-3.107,7.607-0.248,10.604c1.474,1.544,3.448,2.322,5.427,2.322c1.86,0,3.725-0.688,5.177-2.074l22.77-21.731 C244.666,42.342,244.776,37.594,241.917,34.598z">
                                            </path>
                                            <path style="fill:#000002;"
                                                d="M264.273,109.599c-0.004,0-0.008,0-0.012,0l-29.311,0.047c-4.143,0.007-7.495,3.37-7.488,7.512 c0.007,4.139,3.363,7.488,7.5,7.488c0.004,0,0.008,0,0.012,0l29.311-0.047c4.143-0.007,7.495-3.37,7.488-7.512 C271.767,112.948,268.41,109.599,264.273,109.599z">
                                            </path>
                                            <path style="fill:#000002;"
                                                d="M74.386,64.684c2.859-2.996,2.749-7.743-0.248-10.604l-22.77-21.73 c-2.994-2.858-7.742-2.749-10.604,0.248c-2.859,2.996-2.749,7.743,0.248,10.604l22.77,21.731c1.452,1.386,3.315,2.074,5.177,2.074 C70.937,67.006,72.912,66.228,74.386,64.684z">
                                            </path>
                                            <path style="fill:#000002;"
                                                d="M44.729,109.646l-29.31-0.047c-0.004,0-0.008,0-0.012,0c-4.137,0-7.493,3.351-7.5,7.488 c-0.007,4.142,3.346,7.505,7.488,7.512l29.31,0.047c0.004,0,0.008,0,0.012,0c4.137,0,7.493-3.351,7.5-7.488 C52.225,113.016,48.872,109.652,44.729,109.646z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </span>Step into Success—Join the Rurera Family Today!</h3>
                        <p itemprop="description" class="font-16">Be part of a thriving community where learners excel—experience the support and inspiration that can transform your journey today!</p>
                    </div>
                    <div class="lms-btn-group justify-content-center">
                      <a href="{{url('/')}}/pricing" class="lms-btn rounded-pill">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="lms-testimonial-tabs pt-50 pb-50" style="margin-top:80px">
  <div class="container">
    <div class="lms-testimonials row">
      <div class="col-12 mb-20">
        <h2 itemprop="title"
          class="font-weight-bold text-center w-100 mb-10 font-40 pt-0 text-dark-charcoal"
          style="text-align:center;padding-top:20px">Discover What Makes Rurera Loved!</h2>
        <p itemprop="description" class="mb-25 text-center">
          Read heartfelt testimonials from our community and see how Rurera has <br > transformed their learning experiences.
        </p>
      </div>
      <div class="col-12">
        <div class="testimonial-filters">
          <ul class="testimonial-tabs filters-button">
            <li class="active"><a href="#.">All Testimonials</a></li>
            <li><a href="#.">Student</a></li>
            <li><a href="#.">Parent</a></li>
            <li><a href="#.">Teacher</a></li>
          </ul>
        </div>
        <div class="lms-masonry">
          <div class="masonry-grid row">

             @foreach($testimonials as $testimonial)
                <div class="grid-item col-lg-4 col-md-4 col-sm-6 student">

                    <div class="testimonial-card">
                        <div class="testimonial-body">
                          <p itemprop="description">{!! nl2br($testimonial->comment) !!}</p>
                          <div itemprop="author" class="author-name">
                            <span>{{ $testimonial->user_name }}</span><small><em>|</em>{{ $testimonial->testimonial_by }}</small>
                          </div>
                        </div>
                      </div>
                </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="scroll-btn" style="display:block"
  ><div class="round">
    <div id="cta">
      <span class="arrow primera next"></span
      ><span class="arrow segunda next"></span>
    </div></div
></div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script>
  // Play Video Function
  $(document).ready(function () {
    var video = document.getElementById("video");
    var circlePlayButton = document.getElementById("play-vidio");
    var posterImg = document.getElementById("poster-img");

    function togglePlay() {
      if (video.paused || video.ended) {
        video.play();
      } else {
        video.pause();
      }
    }

    circlePlayButton.addEventListener("click", togglePlay);
    video.addEventListener("playing", function () {
      circlePlayButton.style.opacity = 0;
      posterImg.style.opacity = 0
    });

    video.addEventListener("pause", function () {
      circlePlayButton.style.opacity = 1;
      posterImg.style.opacity = 0
    });
  });
</script>
@endpush
