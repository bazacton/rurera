@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endpush

    @section('content')
    <section class="pages-sub-header about-sub-header has-bg mb-50 pt-50 pb-50" style="background:url(../assets/default/img/about-image.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center text-left"><div class="col-12 col-md-9 col-lg-9">
                    <h1 itemprop="title" class="font-30 font-weight-bold text-white">{{ trans('site.contact_us') }}</h1>
                    <p itemprop="description" class="text-white font-19">Whether you have a question, feedback, or any other inquiry, we are here to assist you. We have a contact form on our website that you can fill out. This method allows us to gather the necessary details to assist you effectively.</p>
                </div>
                <div class="col-12 col-md-9 col-lg-3">
                    <figure><img src="../assets/default/img/rocket.png" alt="rocket" itemprop="image" width="100%" height="auto" ></figure>
                </div>
            </div>
        </div>
        <div class="svg-container"></div>
    </section>
        <section class="lms-services lms-contact-form pt-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="services-card text-left has-bg mb-30">
                            <div class="services-card-body">
                                <span class="icon-box"><svg fill="#000" viewBox="0 0 32 32" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" stroke="#000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M16.114-0.011c-6.559 0-12.114 5.587-12.114 12.204 0 6.93 6.439 14.017 10.77 18.998 0.017 0.020 0.717 0.797 1.579 0.797h0.076c0.863 0 1.558-0.777 1.575-0.797 4.064-4.672 10-12.377 10-18.998 0-6.618-4.333-12.204-11.886-12.204zM16.515 29.849c-0.035 0.035-0.086 0.074-0.131 0.107-0.046-0.032-0.096-0.072-0.133-0.107l-0.523-0.602c-4.106-4.71-9.729-11.161-9.729-17.055 0-5.532 4.632-10.205 10.114-10.205 6.829 0 9.886 5.125 9.886 10.205 0 4.474-3.192 10.416-9.485 17.657zM16.035 6.044c-3.313 0-6 2.686-6 6s2.687 6 6 6 6-2.687 6-6-2.686-6-6-6zM16.035 16.044c-2.206 0-4.046-1.838-4.046-4.044s1.794-4 4-4c2.207 0 4 1.794 4 4 0.001 2.206-1.747 4.044-3.954 4.044z">
                                            </path>
                                        </g>
                                    </svg></span>
                                <div class="services-text mt-20">
                                    <h2 itemprop="title" class="font-24">Address</h2>
                                    <p itemprop="description">64 Kildare Crescent Allerton Bradford, BD15 7EQ Uk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="services-card text-left has-bg mb-30">
                            <div class="services-card-body"><span class="icon-box">
                                <svg fill="#000000" width="26px" height="26px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z">
                                        </path>
                                        <path d="M13 7h-2v6h6v-2h-4z"></path>
                                    </g>
                                </svg>
                            </span>
                                <div class="services-text mt-20">
                                    <h2 itemprop="title" class="font-24">Time schedule</h2>
                                    <p itemprop="description">Office Hours 09:00-05:00PM Sunday Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="services-card text-left has-bg mb-30">
                            <div class="services-card-body">
                                <span class="icon-box"><svg fill="#000000" width="26px" height="26px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M8.194 1.156c1.169 1.612 2.563 3.694 4.175 6.237 0.406 0.688 0.344 1.512-0.181 2.481-0.2 0.406-0.706 1.331-1.512 2.787 0.887 1.25 2.238 2.787 4.056 4.6s3.331 3.169 4.538 4.056c1.45-0.85 2.381-1.369 2.788-1.575 0.525-0.281 1.031-0.425 1.512-0.425 0.363 0 0.688 0.081 0.969 0.244 1.856 1.131 3.956 2.525 6.294 4.175 0.444 0.325 0.694 0.769 0.756 1.331 0.063 0.569-0.113 1.169-0.512 1.819-0.2 0.281-0.525 0.694-0.969 1.244-0.444 0.544-1.113 1.231-2 2.056s-1.613 1.244-2.181 1.244h-0.063c-4.269-0.169-9.531-3.369-15.762-9.6-6.237-6.238-9.438-11.494-9.6-15.769 0-0.563 0.412-1.3 1.244-2.212 0.825-0.906 1.506-1.563 2.025-1.969 0.525-0.4 0.969-0.725 1.331-0.969 0.444-0.325 0.95-0.481 1.513-0.481 0.694 0 1.212 0.244 1.581 0.725zM6.194 2.425c-0.85 0.606-1.644 1.287-2.394 2.031-0.744 0.75-1.181 1.3-1.3 1.662 0.163 3.756 3.156 8.537 8.988 14.35s10.625 8.819 14.375 9.019c0.325-0.119 0.856-0.563 1.606-1.331s1.425-1.575 2.025-2.419c0.119-0.163 0.163-0.3 0.119-0.425-2.419-1.694-4.438-3.044-6.056-4.056-0.163 0-0.363 0.063-0.606 0.181-0.363 0.2-1.269 0.706-2.725 1.512l-1.031 0.606-1.031-0.669c-1.331-0.925-2.944-2.363-4.844-4.3-1.894-1.894-3.306-3.512-4.238-4.844l-0.725-0.969 0.606-1.088c0.806-1.45 1.313-2.363 1.512-2.725 0.119-0.244 0.181-0.444 0.181-0.606-1.438-2.294-2.769-4.313-3.981-6.050h-0.063c-0.156 0-0.3 0.044-0.419 0.119z">
                                        </path>
                                    </g>
                                </svg></span>
                                <div class="services-text mt-20">
                                    <h2 itemprop="title" class="font-24">Call us</h2>
                                    <p itemprop="description">+44 127 448 1886</p>
                                    <p itemprop="description">+1 204 962 7186</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-map-section mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="element-title mb-50 text-center">
                            <h2 itemprop="title" class="mb-5">Get in Touch</h2>
                            <p itemprop="description">Explore and locate us to find the right course for you.</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="lms-map-holder">
                            <iframe class="gmap_iframe w-100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=University of Oxford&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-jobsform-section lms-contact-form-section mt-50 pt-50 pb-50">
            <div class="lms-contact-box">
                <span class="message-box"><img src="../assets/default/img/text-arrow.png" alt="text arrow" itemprop="image" width="100%" height="auto"  >Have something to ask ?</span>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="lms-jobs-form lms-contact-form mb-40">
                            <div class="lms-jobs-form-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-element-title text-center">
                                            <h2 itemprop="title">Contact form</h2>
                                            <p itemprop="description">Let's explore how Rurera works for you?</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group d-flex">
                                            <label class="input-label">I have a question for :</label>
                                            <div class="input-field select-arrow">
                                                <select class="lms-jobs-select">
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
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group d-flex">
                                            <label class="input-label">First name</label>
                                            <div class="input-field">
                                                <input type="text" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group d-flex">
                                            <label class="input-label">Last name</label>
                                            <div class="input-field">
                                                <input type="text" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group d-flex">
                                            <label class="input-label">E-mail*</label>
                                            <div class="input-field">
                                                <input type="text" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group d-flex">
                                            <label class="input-label">Mobile</label>
                                            <div class="input-field">
                                                <input type="text" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group d-flex">
                                            <label class="input-label">Which course:</label>
                                            <div class="input-field select-arrow">
                                                <select class="lms-jobs-select">
                                                    <option value="" selected="selected">Maths
                                                    </option>
                                                    <option value="">Design And Technology</option>
                                                    <option value="">Science</option>
                                                    <option value="">English</option>
                                                    <option value="">Computing</option>
                                                    <option value="">English Reading For Pleasure</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group d-flex">
                                            <label class="input-label">My questions</label>
                                            <div class="input-field">
                                                <textarea class="field-textarea" placeholder="Detail here"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group text-right">
                                            <div class="input-field w-100">
                                                <input type="submit" value="Send enquiry">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="lms-column-section lms-text-section mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="lms-text-holder"><strong itemprop="text" class="mb-20">24/7 customer support</strong>
                            <h2 itemprop="title">Need Help ?<br> We're Here for You.</h2>
                            <p itemprop="description" class="mt-15 mb-0">Our highly trained support geeks<br>are always ready to help you.</p>
                            <p itemprop="courses" class="mt-15 mb-0">New courses available !</p>
                            <ul class="lms-img-list">
                                <li><img src="../assets/default/img/bran-img-1.jpg" alt="bran image" itemprop="image" width="100%" height="auto"></li>
                                <li><img src="../assets/default/img/bran-img-2.jpg" alt="bran image" itemprop="image" width="100%" height="auto"></li>
                                <li><img src="../assets/default/img/bran-img-3.jpg" alt="bran image" itemprop="image" width="100%" height="auto"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="lms-img-holder">
                            <figure><img class="w-100 fade-in-image" src="../assets/default/img/best-support.jpg" alt="best support" width="100%" height="auto" itemprop="image">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <a itemprop="url" href="#" class="scroll-btn" style="display: block;">
            <div class="round">
                <div id="cta">
                    <span class="arrow primera next"></span>
                    <span class="arrow segunda next"></span>
                </div>
            </div>
        </a>
    @endsection

    @push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    @endpush
