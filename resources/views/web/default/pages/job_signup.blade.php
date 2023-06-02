@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="position-relative text-center job-singup-sub-header">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-12 col-md-9 col-lg-7">
                <h1 class="font-30 font-weight-bold">{{ $page->title }}</h1>
                <p>Maximize Your Earnings ,Strategies to Help You Reach Your Full Potential.</p>
                <a href="#" class="btn-primary">Lets Start Your Journey</a>
            </div>
        </div>
    </div>
</section>
<div class="lms-job-search">
    <section class="lms-search-services">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="services-inner">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="services-card">
                                    <div class="img-holder">
                                        <figure>
                                            <a href="#"><img src="/store/1/default_images/number_images/1.png"
                                                    alt="" /></a>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h5 class="service-title">
                                            <a href="#">Become a Content Creator</a>
                                        </h5>
                                        <p>
                                            become a content creator passion, <br />
                                            meets world inspiring, engaging <br />
                                            a community craving your perspective
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="services-card">
                                    <div class="img-holder">
                                        <figure>
                                            <a href="#"><img src="/store/1/default_images/number_images/2.png"
                                                    alt="" /></a>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h5 class="service-title">
                                            <a href="#">Register yourself</a>
                                        </h5>
                                        <p>
                                            Register yourself with us,<br />
                                            and unlock a world of opportunities <br />and creative
                                            possibilities.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="services-card">
                                    <div class="img-holder">
                                        <figure>
                                            <a href="#"><img src="/store/1/default_images/number_images/number-3.png"
                                                    alt="" /></a>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h5 class="service-title">
                                            <a href="#">Simple Identity verification</a>
                                        </h5>
                                        <p>
                                            Streamline your experience with,<br />
                                            simple identity verification,<br />
                                            ensuring security and peace of mind
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="services-card">
                                    <div class="img-holder">
                                        <figure>
                                            <a href="#"><img src="/store/1/default_images/number_images/number-4.png"
                                                    alt="" /></a>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h5 class="service-title">
                                            <a href="#">Meet &amp; greet</a>
                                        </h5>
                                        <p>
                                            Experience the thrill of meet &amp; greet,<br />connecting
                                            with your favorite creators <br />
                                            on our platform.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="services-card">
                                    <div class="img-holder">
                                        <figure>
                                            <a href="#"><img src="/store/1/default_images/number_images/number-5.png"
                                                    alt="" /></a>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h5 class="service-title">
                                            <a href="#">Submit your content</a>
                                        </h5>
                                        <p>
                                            Submit your content and,<br />
                                            unlock the power of our platform services <br />
                                            for maximum exposure.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="services-card">
                                    <div class="img-holder">
                                        <figure>
                                            <a href="#"><img src="/store/1/default_images/number_images/(six)6.png"
                                                    alt="" /></a>
                                        </figure>
                                    </div>
                                    <div class="text-holder">
                                        <h5 class="service-title">
                                            <a href="#">Fast review process</a>
                                        </h5>
                                        <p>
                                            Experience our fast review process, <br />ensuring prompt
                                            evaluation and <br />timely feedback for your content.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-testimonial-slider">
        <div class="container">
            <div class="row">
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
                                                        alt="" /></a>
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
                                                        alt="" /></a>
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
                                                        alt="" /></a>
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
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-accordion-job-section mt-50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3"></div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="element-title text-center">
                        <h2 class="mt-0" style="font-size: 40px;">Open Positions</h2>
                    </div>
                    <div class="lms-accordion-job accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="heading_1">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapse_1" aria-expanded="false" aria-controls="collapse_1">Web Design
                                    Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_1" class="collapse" aria-labelledby="heading_1"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_2">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_2" aria-expanded="false"
                                    aria-controls="collapse_2">
                                    Social Media Marketing Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_2" class="collapse" aria-labelledby="heading_2"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility
                                        will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also
                                        working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_3">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_3" aria-expanded="false"
                                    aria-controls="collapse_3">
                                    Photography Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_3" class="collapse" aria-labelledby="heading_3"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility
                                        will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also
                                        working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_4">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_4" aria-expanded="false"
                                    aria-controls="collapse_4">
                                    Photography Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_4" class="collapse" aria-labelledby="heading_4"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility
                                        will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also
                                        working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_5">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_5" aria-expanded="false"
                                    aria-controls="collapse_5">
                                    Photography Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_5" class="collapse" aria-labelledby="heading_5"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility
                                        will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also
                                        working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_6">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_6" aria-expanded="false"
                                    aria-controls="collapse_6">
                                    Photography Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_6" class="collapse" aria-labelledby="heading_6"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility
                                        will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also
                                        working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_7">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_7" aria-expanded="false"
                                    aria-controls="collapse_7">
                                    Photography Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_7" class="collapse" aria-labelledby="heading_7"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility
                                        will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also
                                        working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_8">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_8" aria-expanded="false"
                                    aria-controls="collapse_8">
                                    Photography Teacher
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_8" class="collapse" aria-labelledby="heading_8"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="mb-20">
                                        <img src="../assets/default/img/find-instructor-img1.png" alt="#">
                                    </div>
                                    <h4>Overview</h4>
                                    <p>You will be teaching photography theory and practice in group and private
                                        environment.
                                        Your key
                                        responsibility
                                        will be
                                        supporting students during their course and answering questions in a positive and
                                        constructive
                                        manner and also
                                        working
                                        with our content team to create and update courses.</p>
                                    <ul class="lms-disc-list">
                                        <li>Thai / International</li>
                                        <li>Full-time position</li>
                                        <li>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</li>
                                        <li>40,000 – 60,000 baht per month standard salary</li>
                                        <li>Work Permit Available</li>
                                        <li>National Thai holidays & Christmas and New Years</li>
                                        <li>Bonus scheme for filling Bootcamps and Pro courses</li>
                                    </ul>
                                    <h4>Managing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Marketing</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                        <li>Managing the company Trello for overall company management and assigning of
                                            tasks to
                                            both
                                            owners
                                            administration
                                            staff</li>
                                        <li>Helping sell to prospective students and supporting administration staff with
                                            any
                                            online
                                            questions</li>
                                        <li>Performance reviews for teachers, remote and administration team members</li>
                                    </ul>
                                    <h4>Teacher management</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Managing and coordinating projects such as new course development, marketing and
                                            administration tasks</li>
                                        <li>Identify any materials, resources or stationary needed to improve the quality of
                                            teaching
                                        </li>
                                        <li>Working with administration staff to create reports on academy occupation,
                                            course
                                            attendance
                                        </li>
                                    </ul>
                                    <h4>Teaching</h4>
                                    <ul class="lms-disc-list">
                                        <li>Manage the day to day running of the school to ensure our high quality of
                                            service
                                            remains
                                            and improves</li>
                                        <li>Works proactively with the administration team to ensure they have support and
                                            all
                                            the
                                            details they need to
                                            suggest</li>
                                        <li>courses and take bookings</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                    </ul>
                                    <h4>Hours and schedule</h4>
                                    <p>9am to 6pm (12-1 lunch & 3:00 to 3:30pm break)</p>
                                    <h4>Pay and bonuses</h4>
                                    <p>40,000 – 60,000 baht per month standard salary</p>
                                    <p><a href="#" class="lms-apply-btn">Apply for this teaching position</a></p>
                                    <p><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3"></div>
            </div>
        </div>
    </section>
    <section class="lms-jobsform-section mt-50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3"></div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="element-title text-center">
                        <h2 class="mt-0" style="font-size: 40px;">Application Form</h2>
                    </div>
                    <div class="lms-jobs-form">
                        <div class="lms-jobs-form-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-element-title">
                                        <h2>Stage 1 : Instructor application form</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="lms-form-description">
                                        <b>Thank you for your interest in joining our instructor team.</b>
                                        <P>Please complete the form below to give us as much information as possible to help
                                            move to the next step. Once you
                                            send
                                            in your application we will review and get back to you with a date and time for
                                            a chat online.</P>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">Position applying for</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option value="" selected="selected">Content Creator/Instructional Designer
                                                </option>
                                                <option value="">Subject Matter Expert (SME)</option>
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
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">List your main skills</label>
                                        <div class="input-field">
                                            <input type="text" placeholder="Html Css etc" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">Training experience</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option value="" selected="selected">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                                <option value="">4</option>
                                                <option value="">5</option>
                                                <option value="">6</option>
                                                <option value="">7</option>
                                                <option value="">8</option>
                                                <option value="">9</option>
                                                <option value="">10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-element-title">
                                        <h2>My preferences and availability</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="checkbox-group">
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="checkbox1">
                                            <label for="checkbox1">Full Time Availability</label>
                                        </div>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="checkbox2">
                                            <label for="checkbox2">Extra-curricular activities</label>
                                        </div>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="checkbox3">
                                            <label for="checkbox3">Meetings and collaboration</label>
                                        </div>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="checkbox4">
                                            <label for="checkbox4">Grade level specialization</label>
                                        </div>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="checkbox5">
                                            <label for="checkbox5">Teaching methods</label>
                                        </div>
                                        <div class="checkbox-field">
                                            <input type="checkbox" id="checkbox6">
                                            <label for="checkbox6">Professional development</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">Explain your availability to teach</label>
                                        <div class="input-field">
                                            <textarea class="field-textarea" placeholder="Detail here"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-element-title">
                                        <h2>Stage 3 : Instructor application form</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">First and last name</label>
                                        <div class="input-field">
                                            <input type="text" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">E-mail</label>
                                        <div class="input-field">
                                            <input type="text" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">Mobile/messenger ID</label>
                                        <div class="input-field">
                                            <input type="text" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">Tell us about yourself and why you feel your a good
                                            fit</label>
                                        <div class="input-field">
                                            <textarea class="field-textarea" placeholder="Detail here"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group text-right">
                                        <div class="input-field">
                                            <input type="sumit" value="Send Application" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3"></div>
            </div>
        </div>
    </section>
    <section class="lms-work-list mt-50 pt-30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>How it works</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/mem-fee.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>Is there any cost associated with joining the platform?</h5>
                            <p>
                                Joining our platform is completely free. There are no
                                subscription fees or charges for writing content. You retain
                                100% of each transaction ...
                            </p>
                            <ul class="list-tags">
                                <li>Any cost</li>
                                <li>Subscription Fee</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/5.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>What are the available topics I can write about?</h5>
                            <p>
                                There is a wide range of topics available for writing content.
                                You can explore subjects such as Mathematics, English, Science,
                                Geography, History, and many more. The platform provides
                                opportunities to write on various academic subjects and beyond
                                ...
                            </p>
                            <ul class="list-tags">
                                <li>Topics</li>
                                <li>Writing</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/6.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>How much money can I make?</h5>
                            <p>
                                The amount of money you can make is up to you. You can work as
                                much as you want. Some writers work full-time, while others use
                                the platform to earn extra income alongside their regular jobs
                                ...
                            </p>
                            <ul class="list-tags">
                                <li>Money</li>
                                <li>Earn</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/4.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>Any guidelines accepting written content?</h5>
                            <p>
                                We have guidelines regarding written content acceptance, which
                                can be found in our writer-related information. While we strive
                                to provide constructive feedback ...
                            </p>
                            <ul class="list-tags">
                                <li>Guide Line</li>
                                <li>Content</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/cont-rate.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>How content rate is decided?</h5>
                            <p>
                                The current content rates are outlined in our rates schedule
                                which will be shared after registration ...
                            </p>
                            <ul class="list-tags">
                                <li>Plagirisam</li>
                                <li>References</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/7.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>Is it permissible to copy content from elsewhere?</h5>
                            <p>
                                No, copying content from elsewhere is not allowed. However, you
                                can draw inspiration from the topic you are working on. It is
                                important to create original content and ensure it is free from
                                plagiarism. You can provide links or resources as references
                                when submitting your work ...
                            </p>
                            <ul class="list-tags">
                                <li>copying content</li>
                                <li>content originality</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/8.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>
                                Is there a specific time commitment required for this
                                opportunity?
                            </h5>
                            <p>
                                The time commitment for this opportunity is very flexible.
                                Initially, you will need to invest some time and effort to learn
                                the platform. Afterward, you can determine the amount of work
                                you want to undertake based on your own preferences ...
                            </p>
                            <ul class="list-tags">
                                <li>Time</li>
                                <li>Commitment</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="list-card border-0">
                        <div class="img-holder">
                            <figure>
                                <img src="/store/1/default_images/how_it_work/3.png" alt="" />
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5>How long is the review process?</h5>
                            <p>
                                It depends on work but it normally gets reviewed within 24 hours
                                ...
                            </p>
                            <ul class="list-tags">
                                <li>Reviews</li>
                                <li>Feedback</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="btn-holder">
                    <a href="#" class="create-btn">Create your profile</a>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="action-card">
                        <div class="img-holder">
                            <figure>
                                <a href="#"><img src="/store/1/default_images/how_it_work/get-ready-to-start.jpg"
                                        alt="" /></a>
                            </figure>
                        </div>
                        <div class="text-holder">
                            <h5><a href="#">Ready To Start</a></h5>
                            <p>
                                Start your journey now and explore a wide range of possibilities
                                that are customized to match your career progression, regardless
                                of where you stand in your professional life. Discover
                                opportunities that align with your skills and interests and
                                propel you forward on your career path.
                            </p>
                            <a href="#" class="call-to-action-btn">START NOW FOR FREE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
@endpush
