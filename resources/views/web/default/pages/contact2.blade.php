@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endpush

    @section('content')
            <section class="contact-sub-header pt-70 pb-0 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="text-holder has-bg text-white"><strong class="sub-title">24/7 customer support</strong>
                            <h1 class="mt-20 font-36 font-weight-light">Need Help ?<br>We're Here for You.<br>Contact us</h1>
                            <p class="mt-20">Whether you have a question, feedback, or any other inquiry, we are here to assist
                                you. We have a contact form on our website that you can fill out.</p><a href="#"
                                class="rounded-pill mt-30">Register Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-services lms-contact-info mx-w-100 mt-0 mt-0 mb-0 pt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="services-card text-center mb-30 pr-40 pl-40">
                            <div class="services-card-body">
                                <figure><img src="../assets/default/img/support.jpg" alt="#"></figure>
                                <div class="services-text mt-0">
                                    <h6 class="font-20 mb-15 text-dark-charcoal">24/7 Support</h6>
                                    <p>Experience Uninterrupted 24/7 Support.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="services-card text-center mb-30 pr-40 pl-40">
                            <div class="services-card-body">
                                <figure><img src="../assets/default/img/knowledge.jpg" alt="#"></figure>
                                <div class="services-text mt-0">
                                    <h6 class="font-20 mb-15 text-dark-charcoal">Knowledge Base</h6>
                                    <p>your key resource for resolving doubts and getting instant guidance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="services-card text-center mb-30 pr-40 pl-40">
                            <div class="services-card-body">
                                <figure><img src="../assets/default/img/technical.jpg" alt="#"></figure>
                                <div class="services-text mt-0">
                                    <h6 class="font-20 mb-15 text-dark-charcoal">Technical Assistance</h6>
                                    <p>Unlocking solutions for your challenges.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-column-section lms-text-section mx-w-100 mt-50 mb-0 pt-10 pb-40 pr-30 pl-30">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="lms-text-holder d-flex justify-content-center flex-column align-items-center pt-50 pb-50 has-box-shadow">
                            <h4 class="mb-10 font-24 text-dark-charcoal">Talk To Us</h4>
                            <p class="font-16 mt-0 mb-20">Our Support team supports customers in whole over Uk and would love to
                                answer your queries.</p>
                            <div class="lms-btn-group mb-10"><a href="https://rurera.chimpstudio.co.uk/pages/contact_us"
                                    class="lms-btn rounded-pill">Send Enquiry</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-jobsform-section lms-contact-form-section mt-50 pt-70 pb-70" style="background-color:#f8f8f8">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="section-title text-center mb-50 mt-20">
                            <h2 class="font-40 mb-10 text-dark-charcoal">Get In Touch</h2>
                            <p>Explore and locate us to find the right course for you.</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-20">
                        <div class="lms-jobs-form lms-contact-form">
                            <div class="lms-jobs-form-body pb-10">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-element-title text-left pr-0 pl-0">
                                            <h2 class="font-40 mb-5 text-dark-charcoal">Contact form</h2>
                                            <p>Let's explore how Rurera works for you?</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"><label class="input-label w-100 pt-0">First name</label>
                                            <div class="input-field w-100"><input type="text" placeholder=""></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"><label class="input-label w-100 pt-0">Last name</label>
                                            <div class="input-field w-100"><input type="text" placeholder=""></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"><label class="input-label w-100 pt-0">E-mail*</label>
                                            <div class="input-field w-100"><input type="text" placeholder=""></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group"><label class="input-label w-100 pt-0">Mobile</label>
                                            <div class="input-field w-100"><input type="text" placeholder=""></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group"><label class="input-label w-100 pt-0">Which course:</label>
                                            <div class="input-field select-arrow w-100"><select class="lms-jobs-select">
                                                    <option value="" selected="selected">Maths</option>
                                                    <option value="">Design And Technology</option>
                                                    <option value="">Science</option>
                                                    <option value="">English</option>
                                                    <option value="">Computing</option>
                                                    <option value="">English Reading For Pleasure</option>
                                                </select></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group"><label class="input-label w-100 pt-0">How Can We Help
                                                You?</label>
                                            <div class="input-field select-arrow w-100"><select class="lms-jobs-select">
                                                    <option value="" selected="selected">Content Creator/Instructional Designer
                                                    </option>
                                                    <option value="">Online Instructor/Educator</option>
                                                    <option value="">Curriculum Developer</option>
                                                    <option value="">Learning Experience Designer</option>
                                                    <option value="">Administrator</option>
                                                    <option value="">Quality Assurance Specialist</option>
                                                    <option value="">Marketing and Enrollment Manager</option>
                                                    <option value="">Technical Support Specialist</option>
                                                    <option value="">Data Analyst</option>
                                                </select></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group"><label class="input-label w-100 pt-0">Message</label>
                                            <div class="input-field w-100"><textarea class="field-textarea"
                                                    placeholder="Detail here"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <div class="input-field w-100 pt-0"><input type="submit" value="Send Message"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-20">
                        <div class="lms-map-holder h-100"><iframe class="gmap_iframe w-100 h-100" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=University of Oxford&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-testimonial-slider mt-40 pt-50 pb-10">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center mb-50">
                            <h2 class="mt-0 mb-10 text-dark-charcoal" style="font-size: 40px;">Explore our customers’ success stories</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-card">
                                        <div class="testimonial-body">
                                            <div class="img-holder">
                                                <figure>
                                                    <a href="#"><img
                                                            src="/store/1/default_images/testimonials/profile_picture (50).jpg"
                                                            alt=""></a>
                                                </figure>
                                            </div>
                                            <div class="text-holder">
                                                <div class="testimonial-top">
                                                    <h5 class="testimonial-title">
                                                        <a href="#">Thriving as a Content Creator with an Exceptional
                                                            Team.</a>
                                                    </h5>
                                                    <strong>
                                                        A Life-Changing Discovery I'm Forever Grateful
                                                        For</strong>
                                                </div>
                                                <p>
                                                    "As a content creator, it is pleasure of working with
                                                    the team , I can confidently say that it has been an
                                                    amazing experience. Working as a content writer for this
                                                    platform, I have been able to generate a good income
                                                    while collaborating with a fantastic team of
                                                    professionals"
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-card">
                                        <div class="testimonial-body">
                                            <div class="img-holder">
                                                <figure>
                                                    <a href="#"><img
                                                            src="/store/1/default_images/testimonials/profile_picture (28).jpg"
                                                            alt=""></a>
                                                </figure>
                                            </div>
                                            <div class="text-holder">
                                                <div class="testimonial-top">
                                                    <h5 class="testimonial-title">
                                                        <a href="#">Unleashing the Power of Collaboration in Content
                                                            Creation".</a>
                                                    </h5>
                                                    <strong>Exceeding Expectations with User-Friendly Interface
                                                        and Seamless Navigation</strong>
                                                </div>
                                                <p>
                                                    "As a content writer, I have had the pleasure of
                                                    collaborating with a talented and dedicated team that
                                                    truly understands the value of quality content. Their
                                                    guidance and support have been instrumental in helping
                                                    me refine my skills and explore new horizons in the
                                                    world of content creation."
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-card">
                                        <div class="testimonial-body">
                                            <div class="img-holder">
                                                <figure>
                                                    <a href="#"><img
                                                            src="/store/1/default_images/testimonials/profile_picture (30).jpg"
                                                            alt=""></a>
                                                </figure>
                                            </div>
                                            <div class="text-holder">
                                                <div class="testimonial-top">
                                                    <h5 class="testimonial-title">
                                                        <a href="#">Collaborating with an Exceptional Team of Talented
                                                            Professionals as a Content Creator</a>
                                                    </h5>
                                                    <strong>
                                                        A Game-Changer in my Educational Journey for Busy
                                                        Professionals</strong>
                                                </div>
                                                <p>
                                                    "Working with this exceptional team of talented
                                                    professionals as a content creator has been an absolute
                                                    pleasure. From the moment I joined, I've enjoyed
                                                    collaborating with them and have gained invaluable
                                                    insights and knowledge along the way."
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="swiper-notification"></span>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination swiper-pagination-bullets"><span
                                class="swiper-pagination-bullet"></span><span
                                class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span
                                class="swiper-pagination-bullet"></span></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-services lms-contact-info mx-w-100 mt-30 mb-60 pt-50">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="section-title text-center mb-50">
                            <h2 class="font-40 mb-10 text-dark-charcoal">Resources </h2>
                            <p>Get to know more about Rurera</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="services-card has-shadow text-center mb-30 pb-30">
                            <div class="services-card-body">
                                <figure class="w-100"><img src="../assets/default/img/info-box-1.jpg" alt="#"></figure>
                                <div class="services-text mt-20 pr-30 pl-30">
                                    <p>Cooperative and associated relationship between parents and teachers</p>
                                    <h6 class="font-16 mt-15 mb-0 text-primary">Mutual Collaboration</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="services-card has-shadow text-center mb-30 pb-30">
                            <div class="services-card-body">
                                <figure class="w-100"><img src="../assets/default/img/info-box-2.jpg" alt="#"></figure>
                                <div class="services-text mt-20 pr-30 pl-30">
                                    <p>Promoting socialization and fostering a sense of community</p>
                                    <h6 class="font-16 mt-15 mb-0 text-primary">Social Activities</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="services-card has-shadow text-center mb-30 pb-30">
                            <div class="services-card-body">
                                <figure class="w-100"><img src="../assets/default/img/info-box-3.jpg" alt="#"></figure>
                                <div class="services-text mt-20 pr-30 pl-30">
                                    <p>Leverages digital tools, platforms, and interactive resources for learning</p>
                                    <h6 class="font-16 mt-15 mb-0 text-primary">Smart Learning</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="services-card has-shadow text-center mb-30 pb-30">
                            <div class="services-card-body">
                                <figure class="w-100"><img src="../assets/default/img/info-box-4.jpg" alt="#"></figure>
                                <div class="services-text mt-20 pr-30 pl-30">
                                    <p>Vast repository of information, data, and resources that</p>
                                    <h6 class="font-16 mt-15 mb-0 text-primary">Global Knowledge base</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-newsletter py-70">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="newsletter-inner">
                            <div class="row">
                                <div class="col-12 col-lg-6 col-md-6 mb-20"><strong class="mb-10 text-white font-24">Subscribe our
                                        newsletter</strong>
                                    <p class="mb-0 text-white">Discover a growing collection of ready-made training courses
                                        delivered through Rurera, and gear up your people for success at work</p>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6"><label class="mb-10 text-white">Your E-mail Address</label>
                                    <div class="form-field position-relative"><input type="text"
                                            placeholder="Enter Your E-mail"><button type="submit">Subscribe</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <a href="#" class="scroll-btn" style="display: none;">
            <div class="round">
                <div id="cta"><span class="arrow primera next"></span><span class="arrow segunda next"></span></div>
            </div>
        </a>
    @endsection

    @push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    @endpush
