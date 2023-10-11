@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="content-section">

<section class="pt-80 pb-30" style="background-color: #f8f8f8;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-50 text-center"><h2>Questions select fields</h2></div>
            </div>
            <div class="col-12 col-lg-8 mx-auto mb-50">
                <form action="/timestables/generate" method="post">
                    {{ csrf_field() }}
                    <div class="questions-select-option">
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input  type="radio" value="multiplication_division" id="multi-divi" name="question_type" />
                                <label for="multi-divi" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">
                                    8 per correct answer
                                </span>
                                <strong>Multiplication and Division</strong>
                                </label>
                            </li>
                            <li>
                                <input checked type="radio" value="multiplication" id="multi-only" name="question_type" />
                                <label for="multi-only" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">4 per correct answer</span>
                                <strong>Multiplication only</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" value="division" id="divi-only" name="question_type" />
                                <label for="divi-only" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">4 per correct answer</span>
                                <strong>Division only</strong>
                                </label>
                            </li>
                        </ul>
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input checked type="radio" id="ten-questions" value="10" name="no_of_questions" />
                                <label for="ten-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>10 questions</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="twenty-questions" value="20" name="no_of_questions" />
                                <label for="twenty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>20 questions</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="thirty-questions" value="30" name="no_of_questions" />
                                <label for="thirty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>30 questions</strong>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="questions-select-number">
                        <ul class="d-flex justify-content-center flex-wrap mb-30">
                        <li><input type="checkbox" value="10" name="question_values[]" id="ten" /> <label for="ten" >10</label></li>
                        <li><input type="checkbox" value="2" name="question_values[]" id="two" /> <label for="two">2</label></li>
                        <li><input type="checkbox" value="5" name="question_values[]" id="five" /> <label for="five" >5</label></li>
                        <li><input type="checkbox" value="3" name="question_values[]" checked id="three" /> <label for="three">3</label></li>
                        <li><input type="checkbox" value="4" name="question_values[]" checked id="four" /> <label for="four">4</label></li>
                        <li><input type="checkbox" value="8" name="question_values[]" id="eight" /> <label for="eight">8</label></li>
                        <li><input type="checkbox" value="6" name="question_values[]" id="six" /> <label for="six">6</label></li>
                        <li><input type="checkbox" value="7" name="question_values[]" id="seven" /> <label for="seven">7</label></li>
                        <li><input type="checkbox" value="9" name="question_values[]" id="nine" /> <label for="nine">9</label></li>
                        <li><input type="checkbox" value="11" name="question_values[]" id="eleven" /> <label for="eleven">11</label></li>
                        <li><input type="checkbox" value="12" name="question_values[]" id="twelve" /> <label for="twelve" >12</label></li>
                        <li><input type="checkbox" value="13" name="question_values[]" id="thirteen" /> <label for="thirteen" >13</label></li>
                        <li><input type="checkbox" value="14" name="question_values[]" id="fourteen" /> <label for="fourteen" >14</label></li>
                        <li><input type="checkbox" value="15" name="question_values[]" id="fifteen" /> <label for="fifteen" >15</label></li>
                        <li><input type="checkbox" value="16" name="question_values[]" id="sixteen" /> <label for="sixteen" >16</label></li>
                        </ul>
                    </div>
                    <div class="form-btn">
                        <button type="submit" class="questions-submit-btn btn"><span>Play</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="mb-50 mt-20 template-grid mx-w-100 mb-60 pt-50">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-title mb-30 d-flex justify-content-between align-items-center">
                    <h2 itemprop="title" class="font-30 mb-0 text-dark-charcoal">Templates</h2>
                    <a href="#" itemprop="button" class="seemore-btn">See More <span>›</span> </a>
                </div>
            </div>
            <div class="col-12 col-lg-12 mb-30">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-3.png" class="img-cover" alt="How Online Courses Benefit KS1 and KS2 Students" title="How Online Courses Benefit KS1 and KS2 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Daily Check-in</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">4 Questions</li>
                                    <li itemprop="name">11.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-19.png" class="img-cover" alt="Preparing for Success: Online Courses for Year 5 Students" title="Preparing for Success: Online Courses for Year 5 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Lesson</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Gratitude Lesson - SEL (Inspired by..) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">2 Questions</li>
                                    <li itemprop="name">15.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-38.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 6th Grade (with new question) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">5 Questions</li>
                                    <li itemprop="name">8.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-18.png" class="img-cover" alt="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" title="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 3rd Grade (with new question)</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">3 Questions</li>
                                    <li itemprop="name">12.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-title mb-30 d-flex justify-content-between align-items-center">
                    <h2 itemprop="title" class="font-30 mb-0 text-dark-charcoal">Mathematics</h2>
                    <a href="#" itemprop="button" class="seemore-btn">See More <span>›</span> </a>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-3.png" class="img-cover" alt="How Online Courses Benefit KS1 and KS2 Students" title="How Online Courses Benefit KS1 and KS2 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Daily Check-in</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">4 Questions</li>
                                    <li itemprop="name">11.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-19.png" class="img-cover" alt="Preparing for Success: Online Courses for Year 5 Students" title="Preparing for Success: Online Courses for Year 5 Students" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Lesson</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Gratitude Lesson - SEL (Inspired by..) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">2 Questions</li>
                                    <li itemprop="name">15.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-38.png" class="img-cover" alt="Engaging Students through Interactive Technologies" title="Engaging Students through Interactive Technologies" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Quiz</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 6th Grade (with new question) </a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">5 Questions</li>
                                    <li itemprop="name">8.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="grid-card" itemtype="https://schema.org/NewsArticle">
                            <div class="img-holder">
                                <img src="/store/1/default_images/blogs/blog-18.png" class="img-cover" alt="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" title="Interactive Learning Made Fun: Engaging Quiz Formats For Ks1 And Ks2" width="100%" height="160" itemprop="image" loading="eager">
                            </div>
                            <div class="text-holder">
                                <span><span class="sub-title">Lesson</span></span>
                                <h3 class="blog-grid-title my-10" itemprop="title">
                                    <a itemprop="url" href="/blog/How-Online-Courses-Benefit-KS1-and-KS2-Students">Math: 3rd Grade (with new question)</a>
                                </h3>
                                <ul class="general-info">
                                    <li itemprop="name">3 Questions</li>
                                    <li itemprop="name">12.5k plays</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="lms-column-section lms-text-section w-100 pt-50 pb-50" style="background: url(assets/default/svgs/bank-note.svg) #f27530;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="lms-text-holder d-flex flex-column justify-content-center text-center">
                    <h2 itemprop="title" class="mb-20 text-white">Get Started</h2> <strong itemprop="description" class="text-white">Want to find out more or arrange a free trial ?</strong>
                    <div class="lms-btn-group mt-30 justify-content-center"><a itemprop="url" href="{{url('/')}}/register" class="lms-btn rounded-pill text-white border-white">Join Rurera today</a></div>
                </div>
            </div>
        </div>
    </div>
</section>
</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
@endpush
