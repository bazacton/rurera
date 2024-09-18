@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="position-relative job-singup-sub-header gallery-sub-header">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-12 col-md-12 col-lg-6">
                <h1 itemprop="title" class="font-72 font-weight-bold"><span class="text-scribble mr-10">Job</span>Opportunities at Rurera</h1>
                <p itemprop="description">We are a dynamic and innovative company, constantly striving for excellence in everything we do. Joining our team <br> means joining a diverse and inclusive learning environment where collaboration and creativity are valued.</p>
                <a itemprop="url" href="#job-options" class="btn-primary rounded-pill">Find new positions</a>
            </div>
        </div>
    </div>
    <div class="masonry-grid-gallery">
        <div class="masonry-grid">
        <div class="row">
            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="https:../assets/default/img/staff-1.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>
            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="../assets/default/img/staff-6.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>
            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="../assets/default/img/staff-4.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>
            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="../assets/default/img/staff-5.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>

            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="../assets/default/img/staff-2.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>
            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="../assets/default/img/staff-3.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>
            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="https:../assets/default/img/staff-7.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>

            <div class="grid-item col-lg-3 col-md-3 col-sm-6">
                <div class="img-holder">
                    <figure>
                        <a href="#"><img src="../assets/default/img/staff-5.jpg" alt="default staff image" title="default staff image" width="100%" height="auto" itemprop="image" loading="eager"></a>
                    </figure>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
<div class="lms-job-search">
<section class="lms-search-services mb-0 pt-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-50">
                    <h2 itemprop="title" class="mt-0 mb-10 font-40">Hiring<span class="text-scribble ml-10">Process</span></h2>
                    <p itemprop="description">Interested candidates can submit their applications and can apply jobs. The hiring team will review the received <br> resumes and shortlist candidates based on their qualifications, relevant experience, and skills.</p>
                </div>
            </div>
            <div class="col-12">
                <div class="process-holder">
                    <ul itemprop="process"  class="process-list d-flex justify-content-center">
                        <li itemprop="item" class="process-item">
                            <a href="#.">step 1</a>
                        </li>
                        <li itemprop="item" class="process-item">
                            <a href="#.">step 2</a>
                        </li>
                        <li itemprop="item" class="process-item">
                            <a href="#.">step 3</a>
                        </li>
                        <li itemprop="item" class="process-item">
                            <a href="#.">step 4</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="process-card mt-40 mb-30 text-center">
                    <div class="process-card-body">
                        <div class="text-holder">
                            <h2 itemprop="title" class="post-title">Fill Application</h2>
                            <p itemprop="description" class="mt-15">thoroughly with personal info, work experience, and qualifications.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="process-card mt-40 mb-30 text-center">
                    <div class="process-card-body">
                        <div class="text-holder">
                            <h2 itemprop="title" class="post-title">Get Shortlisted</h2>
                            <p itemprop="description" class="mt-15">if you meet requirements, stay informed about next steps.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="process-card mt-40 mb-30 text-center">
                    <div class="process-card-body">
                        <div class="text-holder">
                            <h2 itemprop="title" class="post-title">Prepare For Interview</h2>
                            <p itemprop="description" class="mt-15">research company, practice common questions, show enthusiasm.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <div class="process-card mt-40 mb-30 text-center">
                    <div class="process-card-body">
                        <div class="text-holder">
                            <h2 itemprop="title" class="post-title">Get Hired</h2>
                            <p itemprop="description" class="mt-15">await official offer letter, join our team. Congratulations!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <div class="stats-container mb-50 pb-10 pt-20">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 itemprop="title" class="mt-0 mb-10 font-40">Job perks</h2>
                        <p itemprop="description">Joining a company dedicated to reshaping the teaching and learning process means <br> you have the opportunity to make a meaningful impact on education.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box teacher">
                            <img src="../assets/default/svgs/healthcare.svg" width="60" height="70" itemprop="svg image" alt="Healthcare">
                        </div>
                        <h2 itemprop="title" class="stat-title">Healthcare benefits</h2>
                        <p itemprop="description" class="stat-desc mt-10">100% medical facility, maternity, and vision</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box student">
                            <img src="../assets/default/svgs/flextime.svg" title="default staff image" width="60" height="70" itemprop="svg image" alt="Healthcare">
                        </div>
                        <h2 itemprop="title" class="stat-title">Flextime</h2>
                        <p itemprop="description" class="stat-desc mt-10">Full time remote and online work opportunity</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box video">
                            <img src="../assets/default/svgs/vacations.svg" width="60" height="70" itemprop="svg image" alt="Vacations">    
                        </div>
                        <h2 itemprop="title" class="stat-title">Vacations</h2>
                        <p itemprop="description" class="stat-desc mt-10">Predetermined amount of days each year.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box course">
                            <img src="../assets/default/svgs/competitive.svg" width="60" height="70" itemprop="svg image" alt="Competitive salaries">
                        </div>
                        <h2 itemprop="title" class="stat-title">Competitive salaries </h2>
                        <p itemprop="description" class="stat-desc mt-10">It help and retain valuable employees</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box teacher">
                            <img src="../assets/default/svgs/free-meals.svg" width="60" height="70" itemprop="svg image" alt="Free meals">
                        </div>
                        <h2 itemprop="title" class="stat-title">Free meals</h2>
                        <p itemprop="description" class="stat-desc mt-10">Offering healthy meal for employees</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box student">
                            <img src="../assets/default/svgs/mental-health.svg" width="60" height="70" itemprop="svg image" alt="Mental health">
                        </div>
                        <h2 itemprop="title" class="stat-title">Mental health support</h2>
                        <p itemprop="description" class="stat-desc mt-10">Provides counseling services with big changes</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box video">
                            <img src="../assets/default/svgs/continuing-edu.svg" width="60" height="70" itemprop="svg image" alt="Continuing education">
                        </div>
                        <h2 itemprop="title" class="stat-title">Continuing education</h2>
                        <p itemprop="description" class="stat-desc mt-10">Provide opportunities to complete studies</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-30">
                    <div class="stats-item simple d-flex flex-column align-items-center text-center py-30 px-15 w-100">
                        <div class="stat-icon-box course">
                            <img src="../assets/default/svgs/travel-fund.svg" width="60" height="70" itemprop="svg image" alt="Travel Fund">
                        </div>
                        <h2 itemprop="title" class="stat-title">Freedom fund to travel</h2>
                        <p itemprop="description" class="stat-desc mt-10">Chance to travel and enjoy hotel free credits</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="job-options" class="lms-accordion-job-section pt-80 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                    <div class="section-title text-center mb-50">
                        <h2 itemprop="title" class="mb-10 font-40">Open Positions</h2>
                        <p itemprop="description">We are always seeking talented individuals to join our team and contribute <br /> to our success. Explore some new positions:</p>
                    </div>
                    <div class="lms-accordion-job accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="heading_1">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_1" aria-expanded="false" aria-controls="collapse_1">Senior Software Developer
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_1" class="collapse" aria-labelledby="heading_1" data-parent="#accordionExample">
                                <div class="card-body">
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a skilled and experienced Senior Software Developer to join our dynamic team. As a Senior Software Developer, you will be responsible for designing, developing, and implementing high-quality software solutions. You will collaborate with cross-functional teams to analyze user requirements, create technical specifications, and deliver robust software applications.</p>
                                
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Design, develop, and maintain efficient and scalable software solutions in accordance with project requirements and coding standards.</li>
                                        <li>Collaborate with product managers, business analysts, and software engineers to gather and analyze user requirements and translate them into technical specifications.</li>
                                        <li>Develop high-quality, clean, and reusable code using industry best practices and modern software development methodologies.</li>
                                        <li>Conduct code reviews to ensure adherence to coding standards, software design principles, and performance optimization.</li>
                                        <li>Troubleshoot and debug complex software issues, identify root causes, and implement effective solutions.</li>
                                        <li>Participate in Agile/Scrum development processes, including sprint planning, daily stand-ups, and retrospectives.</li>
                                
                                        <li>Collaborate with quality assurance teams to ensure software meets quality standards and is thoroughly tested.</li>
                                        
                                    
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's or Master's degree in Computer Science, Software Engineering, or a related field.</li>
                                        <li>Proven work experience as a Senior Software Developer or similar role.</li>
                                        <li>Strong proficiency in multiple programming languages (e.g., Java, C++, Python) and software development frameworks.</li>
                                        <li>In-depth knowledge of software development principles, methodologies, and best practices.</li>
                                        <li>Experience with front-end and back-end development, including web development frameworks, APIs, and databases.</li>
                                        <li>Familiarity with Agile/Scrum development methodologies and tools (e.g., JIRA, Confluence).</li>
                                        
                                        <li>Excellent problem-solving and analytical skills, with the ability to quickly understand complex systems and troubleshoot issues. </li>
                                       
                                        <li>Strong communication and collaboration skills, with the ability to effectively convey technical concepts to both technical and non-technical stakeholders.</li>
                                        <li>Proven ability to work on multiple projects simultaneously and deliver high-quality results within deadlines.</li>
                                        <li>A passion for continuous learning and staying up-to-date with emerging technologies and industry trends.</li>
                                    </ul>

                                    <p itemprop="description">Join our team and contribute to the development of innovative and impactful software solutions. As a Senior Software Developer, you will have the opportunity to make a significant impact, lead technical initiatives, and contribute to the growth and success of our organization.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_2">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_2" aria-expanded="false" aria-controls="collapse_2">
                                    Database Administrator
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_2" class="collapse" aria-labelledby="heading_2" data-parent="#accordionExample">
                                <div class="card-body">
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a skilled and experienced Database Administrator to join our team. As a Database Administrator, you will be responsible for the performance, integrity, and security of our databases. You will work closely with software developers, system administrators, and other stakeholders to ensure the efficient operation of our database systems.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Install, configure, and maintain database management systems (DBMS) to ensure optimal performance, availability, and security.</li>
                                        <li>Design and implement database structures, schemas, and tables based on application requirements and best practices.</li>
                                        <li>Monitor database systems to identify and resolve performance issues, capacity bottlenecks, and other problems.</li>
                                        <li>Develop and implement backup and recovery strategies to ensure data integrity and minimize data loss.</li>
                                        <li>Perform regular database maintenance tasks such as indexing, defragmentation, and statistics updates.</li>
                                        <li>Monitor database security and implement access controls, user roles, and permissions to protect sensitive data. </li>
                                       <li>Collaborate with software developers to optimize database queries and improve application performance.</li>
                                        <li>Perform data migrations and upgrades, ensuring minimal downtime and data integrity.</li>
                                        <li>Troubleshoot and resolve database-related issues, working closely with cross-functional teams to identify root causes and implement solutions.</li>
                                        <li>Document database configurations, procedures, and troubleshooting steps for reference and knowledge sharing.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's degree in Computer Science, Information Technology, or a related field.</li>
                                        <li>Proven work experience as a Database Administrator or in a similar role.</li>
                                        <li>In-depth knowledge of database management systems (e.g., Oracle, MySQL, SQL Server) and their associated tools.</li>
                                        <li>Proficiency in writing and optimizing SQL queries for performance and efficiency.</li>
                                        <li>Strong understanding of database design principles, normalization, and indexing techniques.</li>
                                        <li>Experience in database performance tuning, capacity planning, and monitoring.</li>
                                        <li>Familiarity with database security best practices and data protection regulations (e.g., GDPR).</li>
                                        <li>Knowledge of database backup and recovery strategies.</li>
                                        <li>Excellent problem-solving and analytical skills, with the ability to diagnose and resolve complex database issues.</li>
                                        <li>Strong communication and collaboration skills, with the ability to work effectively with cross-functional teams.</li>
                                    </ul>
                                    <p itemprop="description">In summary, as a Database Administrator, you will play a crucial role in designing, implementing, and maintaining efficient and secure database systems. You will monitor performance, troubleshoot issues, optimize queries, ensure data integrity, and collaborate with various stakeholders to meet the organization's data management needs.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                   
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_3">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_3" aria-expanded="false" aria-controls="collapse_3">
                                    Math Assessment Specialist
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_3" class="collapse" aria-labelledby="heading_3" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a skilled and experienced Math Assessment Specialist to join our team. As a Math Assessment Specialist, you will play a crucial role in developing and implementing effective math assessment strategies and materials. You will work closely with curriculum developers, educators, and other stakeholders to ensure high-quality math assessments that align with educational standards.</p>
                                
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Design and develop math assessment materials, including test items, rubrics, scoring guides, and performance tasks.</li>
                                        <li>Collaborate with curriculum developers to align assessments with educational standards and learning objectives.</li>
                                        <li>Conduct research and stay updated on best practices in math assessment design and implementation.</li>
                                        <li>Review and analyze existing math assessments to identify areas for improvement and make necessary revisions.</li>
                                        <li>Develop assessment blueprints and item specifications to guide the creation of math assessments.</li>
                                        <li>Ensure that math assessments are valid, reliable, and appropriately measure students' math knowledge and skills.</li>
                                        
                                        <li>Collaborate with subject matter experts and educators to gather feedback on assessments and incorporate their insights.
                                        </li>
                                        <li>Conduct item analysis and statistical analysis of assessment data to evaluate item quality and inform future improvements.</li>
                                        <li>Provide insights and recommendations based on assessment data to inform instructional decisions and improve teaching practices.</li>
                                        <li>Generate reports and visualizations to communicate assessment findings to educators, administrators, and other stakeholders.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's or Master's degree in Mathematics, Education, or a related field.</li>
                                        <li>Strong knowledge of mathematics curriculum, instructional practices, and educational standards.</li>
                                        <li>Experience in designing and developing math assessments, including item writing, test specifications, and scoring rubrics.</li>
                                        <li>Proficiency in data analysis and reporting tools, such as Excel, SPSS, or other statistical software.</li>
                                        <li>Familiarity with psychometric principles and practices in assessment development.</li>
                                        <li>Excellent analytical and problem-solving skills to interpret assessment data and provide meaningful insights.</li>
                                        <li>Strong communication and collaboration skills to work effectively with diverse stakeholders.</li>
                                        <li>Attention to detail and commitment to maintaining high standards of assessment validity and reliability.</li>
                                        <li>Familiarity with educational assessment technology and online assessment platforms is a plus.</li>
                                        
                                    </ul>
                                    <p itemprop="description">We offer a competitive salary and benefits package. This is an exciting opportunity to contribute to the improvement of math education through the development and analysis of high-quality assessments. Join our team and make a positive impact on students' learning outcomes.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_4">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_4" aria-expanded="false" aria-controls="collapse_4">
                                    Math Curriculum Designer
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_4" class="collapse" aria-labelledby="heading_4" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a Math Curriculum Designer to join our education team. As a Math Curriculum Designer, you will play a key role in developing and designing a comprehensive and effective math curriculum that aligns with educational standards and meets the needs of students and educators. You will collaborate with subject matter experts, instructional designers, and educators to create engaging and rigorous math curricula that promote conceptual understanding and support student learning.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Design and develop a standards-based math curriculum for specific grade levels or courses.</li>
                                        <li>Create detailed curriculum maps, scope and sequence documents, and lesson plans that outline learning objectives, instructional strategies, and assessments.</li>
                                        <li>Incorporate best practices in math education, pedagogy, and research-based approaches into the curriculum design.</li>
                                        <li>Develop and create math instructional materials, including worksheets, activities, assessments, and multimedia resources.</li>
                                        <li>Write clear and concise explanations, examples, and practice problems to support student understanding and mastery of math concepts.</li>
                                        <li>Ensure the alignment of curriculum content with educational standards, learning progressions, and assessment frameworks.</li>
                                        <li>Collaborate with subject matter experts, instructional designers, and educators to gather input, review content, and ensure the curriculum meets educational goals.</li>
                                        <li>Coordinate with cross-functional teams, including graphic designers, editors, and production staff, to ensure high-quality and visually appealing curriculum materials.</li>
                                        <li>Integrate formative and summative assessments into the curriculum to monitor student progress and provide timely feedback.</li>
                                        <li>Design and align assessments with learning objectives and curriculum content to measure student mastery of math concepts and skills.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's or Master's degree in Mathematics, Education, or a related field.</li>
                                        <li>Strong knowledge of math education principles, curriculum development, and educational standards.</li>
                                        <li>Experience in designing and developing math curricula for specific grade levels or courses.</li>
                                        <li>Familiarity with instructional design models, learning theories, and assessment practices.</li>
                                        <li>Proficiency in creating engaging and interactive instructional materials, including worksheets, activities, and multimedia resources.</li>
                                        <li>Excellent written and verbal communication skills to convey complex math concepts in a clear and understandable manner.</li>
                                        <li>Attention to detail and ability to maintain a high level of accuracy and quality in curriculum materials.</li>
                                        <li>Strong collaboration and teamwork skills to work effectively with subject matter experts, educators, and instructional designers.</li>
                                        <li>Familiarity with educational technology tools and platforms used in math instruction is a plus.</li>
                                        
                                    </ul>
                                     <p itemprop="description">We offer a competitive salary and benefits package. This is an exciting opportunity to contribute to the development of a high-quality math curriculum that empowers students and supports effective teaching. Join our team and make a positive impact on math education.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_5">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_5" aria-expanded="false" aria-controls="collapse_5">
                                    Associate Digital Designer
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_5" class="collapse" aria-labelledby="heading_5" data-parent="#accordionExample">
                                <div class="card-body">
                                   
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking an Associate Digital Designer to join our creative team. As an Associate Digital Designer, you will support the design and production of digital assets for various digital platforms. Your role will involve collaborating with the design team to create visually appealing and engaging digital materials that effectively communicate our brand's message and enhance user experience.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Assist in the creation and execution of digital designs, including website graphics, social media assets, email templates, banners, and display ads.</li>
                                        <li>Follow brand guidelines and design principles to ensure consistency and alignment with the brand identity.</li>
                                        <li>Collaborate with the design team to brainstorm ideas and concepts for digital projects.</li>
                                        <li>Create visually compelling graphics, illustrations, icons, and other visual elements for digital platforms.</li>
                                        <li>Optimize and resize images and graphics for various digital channels, ensuring they are web-ready and optimized for performance.</li>
                                        <li>Contribute to the development of user-friendly and intuitive digital experiences through thoughtful design choices. </li>
                                        <li>Collaborate with UX designers to create wireframes, prototypes, and mockups for digital projects.</li>
                                        <li>Work closely with the design team, marketing team, and other stakeholders to understand project requirements and objectives.</li>
                                        <li>Participate in design discussions, share ideas, and provide input on creative concepts.</li>
                                        <li>Communicate design ideas effectively and present work to internal teams for feedback and review.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's degree in Graphic Design, Digital Design, or a related field (or equivalent experience).</li>
                                        <li>Strong portfolio showcasing digital design skills and proficiency in design software such as Adobe Creative Suite (Photoshop, Illustrator, InDesign).</li>
                                        <li>Understanding of design principles, composition, typography, and color theory.</li>
                                        <li>Familiarity with responsive design principles and designing for various digital platforms (web, mobile, social media).</li>
                                        <li>Basic understanding of UX/UI design principles and user-centered design concepts. Knowledge of HTML and CSS is a plus.</li>
                                        <li>Strong attention to detail and ability to multitask in a fast-paced environment.</li>
                                        <li>Excellent communication skills and ability to collaborate effectively with team members and stakeholders.
                                        </li>
                                        <li>Passion for staying updated with industry trends and emerging digital design techniques.</li>
                                    
                                    </ul>
                                    <p itemprop="description">Join our creative team and contribute to the development of visually stunning digital assets that engage and inspire our audience. This is an excellent opportunity to grow your digital design skills and make a significant impact on our brand's digital presence.</p>
                                
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_6">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_6" aria-expanded="false" aria-controls="collapse_6">
                                    Science Curriculum Designer
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_6" class="collapse" aria-labelledby="heading_6" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    <h3 itemprop="title" class="font-24">Overview</h4>
                                    <p itemprop="description">We are seeking a Science Curriculum Designer to join our education team. As a Science Curriculum Designer, you will play a critical role in developing and designing a comprehensive and engaging science curriculum that aligns with educational standards and promotes inquiry-based learning. You will collaborate with subject matter experts, instructional designers, and educators to create curriculum materials that foster scientific understanding, critical thinking, and hands-on exploration.</p>

                                
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Design and develop a standards-based science curriculum for specific grade levels or courses.</li>
                                        <li>Create detailed curriculum maps, scope and sequence documents, and lesson plans that outline learning objectives, instructional strategies, and assessments.</li>
                                        <li>Incorporate inquiry-based learning approaches, hands-on activities, and real-world applications into the curriculum design.</li>
                                        <li>Develop and create science instructional materials, including lesson plans, worksheets, experiments, and multimedia resources.</li>
                                        <li>Write clear and concise explanations, examples, and guided questions to support student understanding and engagement with science concepts.</li>
                                        <li>Ensure the alignment of curriculum content with educational standards, learning progressions, and assessment frameworks.</li>
                                        <li>Collaborate with subject matter experts, instructional designers, and educators to gather input, review content, and ensure the curriculum meets educational goals.</li>
                                        <li>Coordinate with cross-functional teams, including graphic designers, editors, and production staff, to ensure high-quality and visually appealing curriculum materials.</li>
                                        <li>Integrate formative and summative assessments into the curriculum to monitor student progress and provide timely feedback.</li>
                                        <li>Design and align assessments with learning objectives and curriculum content to measure student mastery of science concepts and skills.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's or Master's degree in Science Education, Biology, Chemistry, Physics, or a related field.</li>
                                        <li>Strong knowledge of science education principles, curriculum development, and educational standards.</li>
                                        <li>Experience in designing and developing science curricula for specific grade levels or courses.</li>
                                        <li>Familiarity with inquiry-based learning approaches, hands-on experimentation, and scientific investigations.</li>
                                        <li>Proficiency in creating engaging and interactive instructional materials, including lesson plans, worksheets, and multimedia resources.</li>
                                        <li>Excellent written and verbal communication skills to convey complex science concepts in a clear and understandable manner.</li>
                                        <li>Attention to detail and ability to maintain a high level of accuracy and quality in curriculum materials.</li>
                                        <li>Strong collaboration and teamwork skills to work effectively with subject matter experts, educators, and instructional designers.</li>
                                        <li>Familiarity with educational technology tools and platforms used in science instruction is a plus.</li>
                                        
                                    </ul>
                                    <p itemprop="description">Join our team and contribute to the development of a high-quality science curriculum that sparks students' curiosity, promotes scientific literacy, and fosters a love for learning. This is an exciting opportunity to make a positive impact on science education.</p>
                    
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_7">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_7" aria-expanded="false" aria-controls="collapse_7">
                                    Content Production Specialist
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_7" class="collapse" aria-labelledby="heading_7" data-parent="#accordionExample">
                                <div class="card-body">
                                   
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a talented and detail-oriented Content Production Specialist to join our team. As a Content Production Specialist, you will be responsible for creating, editing, and managing various types of content across multiple platforms. Your role will involve working closely with the content team to ensure the production of high-quality and engaging content that meets our brand standards and resonates with our target audience.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Create original content, including articles, blog posts, social media posts, videos, and other multimedia materials.</li>
                                        <li>Edit and proofread content for grammar, clarity, style, and adherence to brand guidelines.</li>
                                        <li>Collaborate with subject matter experts and stakeholders to gather information and ensure content accuracy and relevance.</li>
                                        <li>Ensuring the environment is maintained to a high quality</li>
                                        <li>Assist in developing content plans and editorial calendars to ensure a consistent flow of content.</li>
                                        <li>Coordinate content production timelines and deadlines to meet project objectives.</li>
                                        <li>Maintain content repositories and databases to organize and manage content assets.</li>
                                        <li>Optimize content for search engine optimization (SEO) by incorporating relevant keywords and following SEO best practices.</li>
                                        <li>Ensure content is mobile-friendly, accessible, and optimized for different platforms and devices.</li>
                                        <li>Implement strategies to maximize content engagement, reach, and conversion.</li>
                                        <li>Generate reports and provide insights to guide content strategy and optimization efforts.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's degree in Communications, Journalism, Marketing, or a related field (or equivalent experience).</li>
                                        <li>Proven experience in content creation, writing, editing, or related roles.</li>
                                        <li>Excellent writing, editing, and proofreading skills with a keen eye for detail.</li>
                                        <li>Proficiency in content management systems (CMS), SEO tools, and analytics platforms.</li>
                                        <li>Basic understanding of graphic design principles and visual content creation.</li>
                                        <li>Familiarity with social media platforms, content distribution, and community management.</li>
                                        <li>Knowledge of SEO best practices and keyword research.</li>
                                        <li>Strong organizational and project management skills to meet deadlines and manage multiple tasks simultaneously.</li>
                                        <li>Ability to work independently and collaboratively in a fast-paced environment.</li>
                                        <li>Good communication skills and ability to work effectively with cross-functional teams.</li>
                                    </ul>
                                <p itemprop="description">Join our team and contribute to the production of compelling and engaging content that captivates our audience and supports our brand goals. This is an exciting opportunity to showcase your creativity, writing skills, and attention to detail in a dynamic content production role.</p>
                                
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_7">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_7" aria-expanded="false" aria-controls="collapse_7">
                                    Language Arts Curriculum Designer
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_7" class="collapse" aria-labelledby="heading_7" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a Language Arts Curriculum Designer to join our education team. As a Language Arts Curriculum Designer, you will play a crucial role in developing and designing a comprehensive and engaging language arts curriculum that aligns with educational standards and promotes literacy and language development. You will collaborate with subject matter experts, instructional designers, and educators to create curriculum materials that foster reading, writing, communication, and critical thinking skills.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Design and develop a standards-based language arts curriculum for specific grade levels or courses.</li>
                                        <li>Create detailed curriculum maps, scope and sequence documents, and lesson plans that outline learning objectives, instructional strategies, and assessments.</li>
                                        <li>Incorporate a variety of literacy experiences, including reading, writing, speaking, listening, and language development, into the curriculum design.</li>
                                        <li>Develop and create language arts instructional materials, including lesson plans, worksheets, writing prompts, and multimedia resources.</li>
                                        <li>Write clear and concise explanations, examples, and activities to support student understanding and application of language arts concepts.</li>
                                        <li>Collaborate with subject matter experts, instructional designers, and educators to gather input, review content, and ensure the curriculum meets educational goals.</li>
                                        <li>Maintain content repositories and databases to organize and manage content assets.</li>
                                        <li>ntegrate formative and summative assessments into the curriculum to monitor student progress and provide timely feedback.</li>
                                        <li>Stay current with research and developments in language arts education to continuously improve and enhance the curriculum content and instructional strategies.</li>
                                        <li>Review and evaluate the effectiveness of the language arts curriculum, solicit feedback from educators, and make revisions as necessary.</li>
                                        <li>Generate reports and provide insights to guide content strategy and optimization efforts.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's or Master's degree in Education, English, or a related field.</li>
                                        <li>Strong knowledge of language arts education principles, curriculum development, and educational standards.</li>
                                        <li>Experience in designing and developing language arts curricula for specific grade levels or courses.</li>
                                        <li>Proficiency in creating engaging and interactive instructional materials, including lesson plans, worksheets, and multimedia resources.</li>
                                        <li>Basic understanding of graphic design principles and visual content creation.</li>
                                        <li>Excellent written and verbal communication skills to convey language arts concepts in a clear and engaging manner./li>
                                        <li>Strong collaboration and teamwork skills to work effectively with subject matter experts, educators, and instructional designers.</li>
                                        <li>Attention to detail and ability to maintain a high level of accuracy and quality in curriculum materials.</li>
                                        <li>Ability to work independently and collaboratively in a fast-paced environment.</li>
                                        <li>Familiarity with educational technology tools and platforms used in language arts instruction is a plus.</li>
                                    </ul>
                                <p itemprop="description">Join our team and contribute to the development of a high-quality language arts curriculum that nurtures literacy skills and fosters a love for reading and writing. This is an exciting opportunity to make a positive impact on language arts education.</p>
                                
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_7">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_7" aria-expanded="false" aria-controls="collapse_7">
                                    QA Analyst
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_7" class="collapse" aria-labelledby="heading_7" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a skilled and detail-oriented QA Analyst to join our quality assurance team. As a QA Analyst, you will be responsible for ensuring the quality and reliability of our software products through rigorous testing and defect identification. Your role will involve designing and executing test plans, conducting functional and regression testing, and collaborating with cross-functional teams to deliver high-quality software solutions.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Collaborate with product managers, business analysts, and developers to understand project requirements and define test objectives.</li>
                                        <li>Develop comprehensive test plans, test cases, and test scripts based on functional specifications and user stories.</li>
                                        <li>Identify and prioritize test cases based on risk assessment and business impact.</li>
                                        <li>Execute test cases, record and document test results, and log defects in a defect tracking system.</li>
                                        <li>Perform functional, integration, system, and regression testing to ensure software quality and stability.</li>
                                        <li>Conduct exploratory testing to uncover defects and identify potential usability issues.</li>
                                        <li>Identify opportunities for test automation and develop automated test scripts using appropriate testing frameworks and tools.</li>
                                        <li>Maintain and enhance existing test automation frameworks and scripts.</li>
                                        <li>Collaborate with developers to implement automated tests into the continuous integration and delivery (CI/CD) pipeline.</li>
                                        <li>Analyze and troubleshoot defects to identify root causes and provide detailed defect reports.</li>
                                        <li>Collaborate with developers to reproduce and debug defects, ensuring accurate and thorough defect information is communicated.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h3>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's degree in Computer Science, Information Technology, or a related field.</li>
                                        <li>Proven experience as a QA Analyst or in a similar quality assurance role.</li>
                                        <li>Solid understanding of software development life cycle (SDLC) and testing methodologies.</li>
                                        <li>Proficiency in manual testing techniques and experience with test case management tools.</li>
                                        <li>Basic understanding of graphic design principles and visual content creation.</li>
                                        <li>Experience with test automation frameworks and tools, such as Selenium, JUnit, or TestNG, is a plus.</li>
                                        <li>Familiarity with Agile/Scrum methodologies and working in an agile development environment.</li>
                                        <li>Strong analytical and problem-solving skills to identify and debug issues effectively.</li>
                                        <li>Excellent attention to detail and ability to work with minimal supervision.</li>
                                        <li>Strong communication and collaboration skills to work effectively in a team environment.</li>
                                    </ul>
                                <p itemprop="description">Join our team and contribute to the delivery of high-quality software solutions. As a QA Analyst, you will have the opportunity to ensure the reliability and functionality of our products through comprehensive testing and quality assurance practices.</p>
                                
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="heading_8">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse_8" aria-expanded="false" aria-controls="collapse_8">
                                    Senior UI/UX Designer
                                    <small>Freelance / online / on-site</small>
                                </button>
                            </div>
                            <div id="collapse_8" class="collapse" aria-labelledby="heading_8" data-parent="#accordionExample">
                                <div class="card-body">
                                    
                                    <h3 itemprop="title" class="font-24">Overview</h3>
                                    <p itemprop="description">We are seeking a highly skilled and experienced Senior UI/UX Designer to join our design team. As a Senior UI/UX Designer, you will be responsible for creating intuitive and visually appealing user interfaces and seamless user experiences across various digital platforms. Your role will involve leading the UI/UX design process, collaborating with cross-functional teams, and ensuring the delivery of exceptional design solutions that meet user needs and business objectives.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Responsibilities</h3>
                                    <ul class="lms-disc-list">
                                        <li>Lead the end-to-end UI/UX design process, from conceptualization to execution, for digital products and experiences.</li>
                                        <li>Create wireframes, interactive prototypes, and high-fidelity designs that effectively communicate user flows, interactions, and visual designs.</li>
                                        <li>Conduct user research, usability testing, and gather user feedback to inform design decisions and optimize user experiences.</li>
                                        <li>Conduct user research to understand user behaviors, needs, and preferences.</li>
                                        <li>Analyze user data and insights to inform UI/UX design strategies and decision-making.</li>
                                        <li>Stay updated with industry trends, best practices, and emerging technologies related to UI/UX design and user-centered design processes.</li>
                                        <li>Collaborate with cross-functional teams, including product managers, developers, and stakeholders, to ensure alignment on project goals, requirements, and design objectives.</li>
                                        <li>Communicate design concepts, ideas, and rationale to stakeholders, advocating for user-centered design principles.</li>
                                        <li>Develop visually stunning and cohesive user interfaces that align with brand guidelines and enhance user engagement.</li>
                                        <li>Create design assets, including icons, graphics, and visual elements, to support the UI/UX design.</li>
                                        <li>Iteratively refine UI/UX designs based on user feedback, usability findings, and analytics data.</li>
                                    </ul>
                                    <h3 itemprop="title" class="font-24">Requirements</h4>
                                    <ul class="lms-disc-list">
                                        <li>Bachelor's or Master's degree in Design, Human-Computer Interaction, or a related field.</li>
                                        <li>Extensive experience in UI/UX design, including wireframing, prototyping, and visual design.</li>
                                        <li>Proficiency in design tools such as Sketch, Figma, Adobe XD, or similar.</li>
                                        <li>Strong portfolio showcasing expertise in UI/UX design and problem-solving skills.</li>
                                        <li>Solid understanding of user-centered design principles, user research methodologies, and usability testing.</li>
                                        <li>Knowledge of responsive design, mobile-first design principles, and accessibility standards.
                                        </li>
                                        <li>Excellent visual and communication skills to present design concepts and rationale to stakeholders.</li>
                                        <li>Ability to work in a collaborative, agile environment and manage multiple projects simultaneously.</li>
                                        <li>Experience with design systems and familiarity with front-end development concepts are a plus.</li>
                                       
                                    </ul>

                                    <p itemprop="description">Join our team and contribute to creating exceptional user experiences through innovative UI/UX design. As a Senior UI/UX Designer, you will have the opportunity to shape the digital landscape of our curriculum, champion user-centered design, and drive positive impact for our users and business.</p>
                                    
                                    <h3 itemprop="title" class="font-24">Hours and schedule</h3>
                                    <p itemprop="description">9am to 6pm (12-1 lunch &amp; 3:00 to 3:30pm break)</p>
                                    
                                    <p itemprop="description"><a href="#" class="lms-apply-btn">Apply for this position</a></p>
                                    <p itemprop="description"><a href="#" class="lms-contact-btn">Contact us</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-testimonial-slider pt-80 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <h2 itemprop="title" class="mt-0 mb-10 font-40">Explore our success storiess</h2>
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
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-counter-section pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-title text-center mb-40">
                        <h2 itemprop="title" class="mt-0 mb-10 font-40">Our impact</h2>
                        <p itemprop="description">We truly Understand the challenges and limitations faced by educators and learners <br> in the current system.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30">
                    <div class="lms-counter-card">
                        <strong itemprop="number" class="custom-counter">100</strong><span class="plus-icons">+</span>
                        <p itemprop="description" class="font-16 font-weight-normal">Sats Practices</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30">
                    <div class="lms-counter-card">
                        <strong itemprop="number" class="custom-counter">60</strong><span class="plus-icons">+</span>
                        <p itemprop="description" class="font-16 font-weight-normal">Cities</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30">
                    <div class="lms-counter-card">
                        <strong itemprop="number" class="custom-counter">5000</strong><span class="plus-icons">+</span>
                        <p itemprop="description" class="font-16 font-weight-normal">Questions</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30">
                    <div class="lms-counter-card">
                        <strong itemprop="number" class="custom-counter">100</strong><span class="plus-icons">+</span>
                        <p itemprop="description" class="font-16 font-weight-normal">Books</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lms-jobsform-section mb-0 pt-80 pb-90" style="background: url(../assets/default/svgs/diagonal-lines.svg) #f8f8f8;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="section-title text-center mb-40">
                        <h2 itemprop="title" class="mt-0 font-40">Application Form</h2>
                    </div>
                    <div class="lms-jobs-form">
                        <div class="lms-jobs-form-body">
                            <div class="accordion" id="accordionExample2">
                                <div class="card">
                                <div class="card-header" id="headingOne">
                                        <button class="text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <span class="icon-box">
                                                <svg id="Layer_1" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32"><style type="text/css">
                                                    .st0{fill:none;stroke:#000000;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                                </style><g><path class="st0" d="M30.3,3.2v9.5c0,1.2-1,2.2-2.2,2.2H13.3c0-0.2,0-0.4,0-0.6c0-2.3-1.9-4.2-4.2-4.2V3.2c0-1.2,1-2.2,2.2-2.2   h16.8C29.3,1,30.3,2,30.3,3.2z"/><line class="st0" x1="16.6" x2="22.9" y1="5.6" y2="5.6"/><line class="st0" x1="13.8" x2="25.7" y1="10.3" y2="10.3"/><path class="st0" d="M15.1,31H3.4c-0.9,0-1.7-0.7-1.7-1.7l0,0c0-3.3,2.7-6,6-6h3c3.3,0,6,2.7,6,6l0,0C16.7,30.3,16,31,15.1,31z"/><path class="st0" d="M9.2,10.1C6.9,10.1,5,12,5,14.3s1.9,5.9,4.2,5.9s4.2-3.6,4.2-5.9S11.5,10.1,9.2,10.1z"/></g></svg>
                                            </span>
                                            Stage 1 : Rurera application form
                                        </button>
                                        <div class="form-field-counter">
                                            <span class="counts-bar-box">
                                                <span class="counts-bar" style="width: 20%;"></span>
                                            </span>
                                            <span itemprop="counter" class="counter-counts"><em>0</em> of 3 tasks</span>
                                        </div>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="lms-form-description">
                                                    <b itemprop="description">Thanks for your interest in joining Team Rurera.</b>
                                                    <p itemprop="description">Please complete the form below to give us as much information as possible to help
                                                        move to the next step. Once you
                                                        send
                                                        in your application we will review and get back to you with a date and time for
                                                        a chat online.</p>
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
                                                        <input type="text" placeholder="Html Css etc">
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
                                    </div>
                                </div>
                                </div>
                                <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <button class="text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span class="icon-box">
                                            <svg style="enable-background:new 0 0 16 16;" version="1.1" viewBox="0 0 16 16" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Guide"/><g id="Layer_2"><g><path d="M6,6c0-0.93-0.64-1.71-1.5-1.93V2.5C4.5,2.22,4.28,2,4,2S3.5,2.22,3.5,2.5v1.57C2.64,4.29,2,5.07,2,6s0.64,1.71,1.5,1.93    v5.57C3.5,13.78,3.72,14,4,14s0.5-0.22,0.5-0.5V7.93C5.36,7.71,6,6.93,6,6z M4,7C3.45,7,3,6.55,3,6s0.45-1,1-1s1,0.45,1,1    S4.55,7,4,7z"/><path d="M8.5,9.07V2.5C8.5,2.22,8.28,2,8,2S7.5,2.22,7.5,2.5v6.57C6.64,9.29,6,10.07,6,11s0.64,1.71,1.5,1.93v0.57    C7.5,13.78,7.72,14,8,14s0.5-0.22,0.5-0.5v-0.57c0.86-0.22,1.5-1,1.5-1.93S9.36,9.29,8.5,9.07z M8,12c-0.55,0-1-0.45-1-1    s0.45-1,1-1s1,0.45,1,1S8.55,12,8,12z"/><path d="M14,5c0-0.93-0.64-1.71-1.5-1.93V2.5C12.5,2.22,12.28,2,12,2s-0.5,0.22-0.5,0.5v0.57C10.64,3.29,10,4.07,10,5    s0.64,1.71,1.5,1.93v6.57c0,0.28,0.22,0.5,0.5,0.5s0.5-0.22,0.5-0.5V6.93C13.36,6.71,14,5.93,14,5z M12,6c-0.55,0-1-0.45-1-1    s0.45-1,1-1s1,0.45,1,1S12.55,6,12,6z"/></g></g></svg>
                                        </span>
                                        Stage 2 : My preferences and availability
                                    </button>
                                    <div class="form-field-counter">
                                        <span class="counts-bar-box">
                                            <span class="counts-bar"></span>
                                        </span>
                                        <span class="counter-counts"><em>0</em> of 2 tasks</span>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample2">
                                    <div class="card-body">
                                        <div class="row">

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
                                    </div>
                                </div>
                                </div>
                                <div class="card">
                                <div class="card-header" id="headingThree">
                                    <button class="text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <span class="icon-box">
                                            <svg id="Layer_1" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
                                                .st0{fill:none;stroke:#000000;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                            </style><g><path class="st0" d="M30.3,3.2v9.5c0,1.2-1,2.2-2.2,2.2H13.3c0-0.2,0-0.4,0-0.6c0-2.3-1.9-4.2-4.2-4.2V3.2c0-1.2,1-2.2,2.2-2.2   h16.8C29.3,1,30.3,2,30.3,3.2z"/><line class="st0" x1="16.6" x2="22.9" y1="5.6" y2="5.6"/><line class="st0" x1="13.8" x2="25.7" y1="10.3" y2="10.3"/><path class="st0" d="M15.1,31H3.4c-0.9,0-1.7-0.7-1.7-1.7l0,0c0-3.3,2.7-6,6-6h3c3.3,0,6,2.7,6,6l0,0C16.7,30.3,16,31,15.1,31z"/><path class="st0" d="M9.2,10.1C6.9,10.1,5,12,5,14.3s1.9,5.9,4.2,5.9s4.2-3.6,4.2-5.9S11.5,10.1,9.2,10.1z"/></g></svg>
                                        </span>
                                        Stage 3 : Contact Details
                                    </button>
                                    <div class="form-field-counter">
                                        <span class="counts-bar-box">
                                            <span class="counts-bar"></span>
                                        </span>
                                        <span class="counter-counts"><em>0</em> of 4 tasks</span>
                                    </div>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample2">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="input-label">First and last name</label>
                                                    <div class="input-field">
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="input-label">E-mail</label>
                                                    <div class="input-field">
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="input-label">Mobile/messenger ID</label>
                                                    <div class="input-field">
                                                        <input type="text" placeholder="">
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
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="form-group text-right mb-0 mt-20">
                                <div class="input-field">
                                    <input type="submit" value="Send Application">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    
</div>
<div class="scroll-btn" style="display: block;">
    <div class="round">
        <div id="cta"><span class="arrow primera next"></span><span class="arrow segunda next"></span></div>
    </div>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
@endpush
