@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endpush

    @section('content')
            <section class="contact-sub-header pt-70 pb-0 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="text-holder has-bg text-white">
                            <strong class="sub-title font-20" itemprop="sub title">contact us</strong>
                            <h1 itemprop="title" class="mt-15 font-36 font-weight-light">Need Support ?<br>Get the help you need.</h1>
                            <p itemprop="description" class="mt-20">Whether you have a question, feedback, or any other inquiry, we are here to assist
                                you. We have a contact form on our website that you can fill out.</p>
                                <a itemprop="url" href="#jobsform-section" class="rounded-pill mt-30">Send Inquiry</a>
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
                                <figure><img src="../assets/default/img/support.jpg" alt="support" title="support"  width="100%" height="auto" itemprop="image"  loading="eager"></figure>
                                <div class="services-text mt-0">
                                    <h2 itemprop="title" class="font-20 mb-15 text-dark-charcoal"><a href="{{url('/')}}/pricing">24/7 Support</a></h2>
                                    <p itemprop="description">Experience Uninterrupted 24/7 Support in whole UK</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="services-card text-center mb-30 pr-40 pl-40">
                            <div class="services-card-body">
                                <figure><img src="../assets/default/img/knowledge.jpg" alt="knowledge" title="knowledge"  width="100%" height="auto" itemprop="image"  loading="eager"></figure>
                                <div class="services-text mt-0">
                                    <h2 itemprop="title" class="font-20 mb-15 text-dark-charcoal"><a href="{{url('/')}}/pricing">Knowledge Base</a></h2>
                                    <p itemprop="description">your key resource for resolving doubts and getting instant guidance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="services-card text-center mb-30 pr-40 pl-40">
                            <div class="services-card-body">
                                <figure><img src="../assets/default/img/technical.jpg" alt="technical" title="technical"  width="100%" height="auto" itemprop="image"  loading="eager"></figure>
                                <div class="services-text mt-0">
                                    <h2 itemprop="title" class="font-20 mb-15 text-dark-charcoal"><a href="#jobsform-section">Feedback / Suggestions</a></h2>
                                    <p itemprop="description">Help us to improve rurera with your valuable suggestions</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="jobsform-section" class="lms-jobsform-section lms-contact-form-section mt-50 pt-70 pb-70" style="background-color:#f8f8f8">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="section-title text-center mb-50 mt-20">
                            <h2 itemprop="title" class="font-40 mb-10 text-dark-charcoal">Get In Touch</h2>
                            <p itemprop="description">Explore and locate us to find the right resource for you.</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-20">
                        <div class="lms-contact-form-tabs">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="inquires-tab" data-toggle="tab" href="#inquires" role="tab" aria-controls="inquires" aria-selected="true">Inquires</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab" aria-controls="feedback" aria-selected="false">Feedback</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="inquires" role="tabpanel" aria-labelledby="inquires-tab">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="lms-jobs-form lms-contact-form">
                                                <div class="lms-jobs-form-body pb-10">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-element-title text-left pr-0 pl-0">
                                                                <p itemprop="description">Whether you have a question, need assistance, or want to share your thoughts, we're here to listen and help.</p>
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
                                                            <div class="form-group"><label class="input-label w-100 pt-0">What type of query you are having ?</label>
                                                                <div class="input-field select-arrow w-100">
                                                                    <select class="lms-jobs-select">
                                                                        <option value="" selected="selected">About Courses</option>
                                                                        <option value="">About Courses</option>
                                                                        <option value="">About Online Tests(SAT, 11 plus)</option>
                                                                        <option value="">About membership</option>
                                                                        <option value="">About Books</option>
                                                                        <option value="">About Features</option>
                                                                        <option value="">About payments</option>
                                                                    </select>
                                                                </div>
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
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="lms-jobs-form lms-contact-form">
                                                <div class="lms-jobs-form-body pb-10">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-element-title text-left pr-0 pl-0">
                                                                <p itemprop="description">Help us to improve rurera with your valuable suggestions. we will appreciate it.</p>
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
                                                            <div class="form-group"><label class="input-label w-100 pt-0">What type of feedback/suggestion you are having ?</label>
                                                                <div class="input-field select-arrow w-100">
                                                                    <select class="lms-jobs-select">
                                                                        <option value="" selected="selected">About Courses</option>
                                                                        <option value="">About Courses</option>
                                                                        <option value="">About Online Tests(SAT, 11 plus)</option>
                                                                        <option value="">About membership</option>
                                                                        <option value="">About Books</option>
                                                                        <option value="">About Features</option>
                                                                        <option value="">About payments</option>
                                                                    </select>
                                                                </div>
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
                                                                <div class="input-field w-100 pt-0"><input type="submit" value="Send Feedback"></div>
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
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-20">
                        <div class="lms-map-holder h-100">
                            <iframe class="gmap_iframe w-100 h-100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=University of Oxford&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
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
                            <h2 itemprop="title" class="mt-0 mb-10 text-dark-charcoal" style="font-size: 40px;">Explore our success stories</h2>
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
                                                    <a itemprop="url" href="{{url('/')}}"><img
                                                            src="/store/1/default_images/testimonials/teacher-testimonial.jpg"
                                                            alt="profile" title="profile" width="100%" height="auto" itemprop="image"  loading="eager"></a>
                                                </figure>
                                            </div>
                                            <div class="text-holder">
                                                <div class="testimonial-top">
                                                    <h3 itemprop="title" class="testimonial-title">
                                                        <a itemprop="url" href="{{url('/')}}">Rurera's Extraordinary Team: A Teacher's Story</a>
                                                    </h3>
                                                    <strong itemprop="Exceeding">A Game-Changer to diagnose and monitor performance</strong>
                                                </div>
                                                <p itemprop="description">Rurera's core alignment makes it easier for me to assign work. I also like the immediate feedback and large bank of questions. My students' skill levels have increased dramatically over the past three years; they see it, and so do their parents. This is an outstanding program. I love Rurera. I'm so grateful that our school continues to find the resources to keep us online. It is worth it!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-card">
                                        <div class="testimonial-body">
                                            <div class="img-holder">
                                                <figure>
                                                    <a itemprop="url" href="{{url('/')}}"><img src="/store/1/default_images/testimonials/parent-testimonial.jpg"
                                                            alt="testimonials" title="testimonials"  width="100%" height="auto" itemprop="image"  loading="eager"></a>
                                                </figure>
                                            </div>
                                            <div class="text-holder">
                                                <div class="testimonial-top">
                                                    <h3 itemprop="title" class="testimonial-title">
                                                        <a itemprop="url" href="{{url('/')}}">Collaborating with an Exceptional Team of Rurera as a Parent</a>
                                                    </h3>
                                                    <strong itemprop="Forever">A Game-Changer for Busy Parents to engage with Child studies.</strong>
                                                </div>
                                                <p itemprop="description">As a parent, I want to share my incredible experience that has made a significant impact on my child's education. Rurera has truly transformed the way my child learns and engages with educational content. Recommended!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="swiper-notification"></span>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination swiper-pagination-bullets">
                            <span
                                class="swiper-pagination-bullet"></span><span
                                class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span
                                class="swiper-pagination-bullet"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
		@foreach($homeSections as $homeSection)
		@if($homeSection->name == \App\Models\HomeSection::$blog and !empty($blog) and !$blog->isEmpty())
			   <section class="home-sections container">
				   <div class="d-flex justify-content-between">
					   <div class="section-title">
						   <h2 class="mt-0 mb-10 font-40">Resources</h2>
						   <p class="section-hint">Get to know more about latest news, resources and much more.</p>
					   </div>
					   <a href="/blog" class="btn btn-border-white">{{ trans('home.all_blog') }}</a>
				   </div>
				   <div class="row mt-35">
					   @foreach($blog as $post)
						   <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
							   @include('web.default.blog.rurera-grid-list',['post' =>$post])
						   </div>
					   @endforeach

				   </div>
			   </section>
		   @endif
		@endforeach

        <section class="lms-column-section lms-text-section py-70 mx-w-100" style="background-color: var(--primary);">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="lms-text-holder">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-8 col-md-8">
                                    <h2 itemprop="title" class="mb-20 text-white font-40">Ready to start learning?</h2>
                                    <p itemprop="description" class="mb-0 text-white">Discover a growing collection of resources
                                        delivered through Rurera.</p>
                                </div>
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="lms-btn-group">
                                        <a itemprop="url" href="{{url('/')}}/register" class="lms-btn rounded-pill text-white border-white ml-auto">Join Rurera Today</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div  class="scroll-btn" style="display: block;">
            <div class="round">
                <div id="cta"><span class="arrow primera next"></span><span class="arrow segunda next"></span></div>
            </div>
        </div>
    @endsection

    @push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    @endpush
