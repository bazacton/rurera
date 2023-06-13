@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endpush

    @section('content')
    <section class="lms-call-to-action sub-header position-relative pt-70 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cell-card">
                        <div class="cell-body">
                            <div class="row">
                                <div class="col-12 col-lg-8 col-md-8 mx-auto">
                                    <div class="cell-inner text-center">
                                        <span class="icon-svg mb-30">
                                            <svg fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve" width="64px" height="64px"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="question--and--answer_1_" d="M10.7,31.199l-3.893-5.844H3c-1.301,0-2.36-1.059-2.36-2.36v-10 c0-1.301,1.059-2.36,2.36-2.36h11.64V3c0-1.301,1.059-2.36,2.36-2.36h12c1.302,0,2.36,1.059,2.36,2.36v8 c0,1.301-1.059,2.36-2.36,2.36h-2.777l-1.9,3.801l-0.645-0.322l2-4C25.74,12.717,25.864,12.64,26,12.64h3 c0.904,0,1.64-0.736,1.64-1.64V3c0-0.904-0.735-1.64-1.64-1.64H17c-0.904,0-1.64,0.736-1.64,1.64v7.635H18 c1.181,0,2.161,0.871,2.333,2.005H23v0.72h-2.64v9.635c0,1.302-1.059,2.36-2.36,2.36h-7v-0.721h7c0.904,0,1.64-0.735,1.64-1.64v-10 c0-0.904-0.735-1.64-1.64-1.64H3c-0.904,0-1.64,0.736-1.64,1.64v10c0,0.904,0.736,1.64,1.64,1.64h4c0.121,0,0.233,0.061,0.3,0.161 l4,6.005L10.7,31.199z M23.378,8.495h-0.721c0-1.219,0.217-1.677,1.008-2.129c0.555-0.317,0.78-0.666,0.78-1.205 c0-0.962-0.776-1.303-1.441-1.303c-0.812,0-1.449,0.573-1.449,1.303h-0.721c0-1.134,0.953-2.023,2.17-2.023 c1.272,0,2.162,0.832,2.162,2.023c0,1.055-0.653,1.549-1.144,1.83C23.5,7.29,23.378,7.464,23.378,8.495z M11.5,18 c0,0.552-0.448,1-1,1s-1-0.448-1-1s0.448-1,1-1S11.5,17.448,11.5,18z M15.5,17c-0.552,0-1,0.448-1,1s0.448,1,1,1s1-0.448,1-1 S16.052,17,15.5,17z M5.5,17c-0.552,0-1,0.448-1,1s0.448,1,1,1s1-0.448,1-1S6.052,17,5.5,17z M23,10.625 c0.345,0,0.625-0.28,0.625-0.625S23.345,9.375,23,9.375S22.375,9.655,22.375,10S22.655,10.625,23,10.625z"></path> <rect id="_Transparent_Rectangle" style="fill:none;" width="32" height="32"></rect> </g></svg>
                                        </span>
                                        <h1 class="font-50 mb-15">Frequently asked questions</h1>
                                        <p class="mb-50">Asking the right questions is indeed a skill that requires careful consideration and thought. Discover a growing collection of ready-made training courses delivered through Rurera.</p>
                                        <form>
                                            <div class="field-holder d-flex">
                                                <input class="px-15" type="text" placeholder="What we can help you find ?">
                                                    <button type="submit">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container mt-0 mt-md-0 pt-30">
        <div class="row">
            <div class="col-12">
                <div class="mt-0">
                    <div class="lms-faqs mx-w-100 mt-0">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Student</a></li>
                            <li class="nav-item"><a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent" role="tab" aria-controls="parent" aria-selected="true">Parents</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Teachers</a></li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div id="accordion">
                                    <div class="accordion-section-title"><h2 class="text-dark-charcoal">General</h2></div>
                                    <div class="card">
                                        <div class="card-header" id="headingon11">
                                            <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">How many Courses are available at Rurera ?</button></h5>
                                        </div>
                                        <div id="collapse11" class="collapse show" aria-labelledby="heading11" data-parent="#accordion">
                                            <div class="card-body"><p>Available courses are :English reading, Computing, Science , English and Maths</p></div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingon12">
                                            <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">How does the learning works ?</button></h5>
                                        </div>
                                        <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                            <div class="card-body"><p>Rurera provides more information on what the learning experience is and how you can expect to interact with your selected course.</p></div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading">
                                            <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Why create an account with us?</button></h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="heading" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>
                                                    Create an account with Rurera for personalized learning experiences, exclusive course, sats , books material, and progress tracking. Join a vibrant community, collaborate with instructors, and unleash the
                                                    full potential of our educational platform. Start your learning journey today by signing up with us.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">How does Rurera manage my personal information?</button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body">
                                                Rurera ensures the utmost care and security of your personal information. We collect and store only necessary data for our services. Your information is treated confidentially and not shared with third parties
                                                without your consent, except when required by law.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingfive">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">What can I do if I don t receive the email verification code?</button>
                                            </h5>
                                        </div>
                                        <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                                            <div class="card-body">
                                                If you haven't received the email verification code, check your spam folder and request a new code if needed. For further assistance, contact our support team, who will help you resolve the issue promptly.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">Login</h2></div>
                                <div class="card">
                                    <div class="card-header" id="headingonsix">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">I forgot my password  how can I reset it?</button></h5>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                        <div class="card-body">
                                            To reset your password, click on the "Forgot Password" option on the login page. Enter your registered email and click the password reset link sent to your email to proceed with resetting your password. Follow the
                                            instructions provided to set a new password for your account.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">What can I do if I didn t complete mobile phone number verification?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            If you haven't completed the phone number verification, there are a few steps you can take. Firstly, ensure that you have entered the correct phone number and try the verification process again. If you're still
                                            experiencing difficulties, reach out to our support team for assistance. They will guide you through alternative verification methods or provide further instructions to help you complete the process successfully.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingseven">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">My phone was stolen. How can I access my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                        <div class="card-body">
                                            If your phone was stolen, contact Rurera's support team immediately to secure your account and change your login credentials. Provide the necessary information to verify your identity and regain access to your
                                            account safely.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">Account management</h2></div>
                                <div class="card">
                                    <div class="card-header" id="heading8">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">How can I change the mobile number linked to my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                        <div class="card-body">To change the mobile number linked to your Rurera account, access your account settings, update the mobile number field, and verify the new number for successful linkage.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading9">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapse9">How can I update my personal information on my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                        <div class="card-body">
                                            To update your personal information on your Rurera account, log in and navigate to your account settings or profile section. Make the necessary changes to your name, email, or contact details, and save the updates to
                                            ensure your account reflects the latest information.
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header" id="heading10">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="true" aria-controls="collapse10">What are the technical requirements for Rurera?</button></h5>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                        <div class="card-body">
                                            To access Rurera, ensure your device has a stable internet connection and meets the technical requirements, such as compatible operating systems (Windows, macOS, iOS, Android), up-to-date web browsers (Chrome, Firefox, Safari,
                                            Edge), and any required plugins or software.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading11">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">What should I do if I forget my username?</button></h5>
                                    </div>
                                    <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                        <div class="card-body">
                                            To retrieve your forgotten Rurera username, click on the "Forgot Username" option on the login page. Enter your email address and follow the instructions sent to your email inbox for username recovery. For additional assistance,
                                            contact Rurera's support team.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading12">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">How can I change my profile icon?</button></h5>
                                    </div>
                                    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                        <div class="card-body">To change your profile icon on Rurera, access your account settings. Look for the option to edit your profile or avatar and upload a new image. Save the changes to update your profile icon.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading13">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="true" aria-controls="collapse13">Why can't I sign in?</button></h5>
                                    </div>
                                    <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                                        <div class="card-body">
                                            If you're having trouble signing in to your Rurera account, first check that you're using the correct username and password. Make sure your account is active and your internet connection is working properly. If the problem
                                            persists, reach out to Rurera's support team for help.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading14">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse14" aria-expanded="true" aria-controls="collapse14">How do I contact technical support?</button></h5>
                                    </div>
                                    <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                                        <div class="card-body">To contact Rurera's technical support, visit the contact us on the website. Use the provided contact information, such as email or phone, to reach out for assistance.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading15">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse15" aria-expanded="true" aria-controls="collapse15">How do I renew my membership billed?</button></h5>
                                    </div>
                                    <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion">
                                        <div class="card-body">
                                            To renew your billed membership on Rurera, log in to your account and go to the membership section. Select the desired membership plan, follow the instructions, and complete the payment process to successfully renew your
                                            membership. Enjoy continued access to Rurera's educational resources.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading16">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse16" aria-expanded="true" aria-controls="collapse16">How can I make sure my child uses their correct profile on our family account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion">
                                        <div class="card-body">
                                            To ensure your child uses the correct profile on the family account, create separate profiles, instruct them to select their profile, and monitor their usage to maintain individualized learning experiences.
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="tab-pane fade" id="parent" role="tabpanel" aria-labelledby="parent-tab">
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">General</h2></div>
                                <div id="accordion2">
                                    <div class="card">
                                        <div class="card-header" id="heading4">
                                            <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">What is the best way to get started?</button></h5>
                                        </div>
                                        <div id="collapse4" class="collapse show" aria-labelledby="heading4" data-parent="#accordion2">
                                            <div class="card-body">
                                                At Rurera we believe a key to successfully coaching your child new skills is knowing what they are ready to handle. That s why we suggest you Get Started with a conversation. Find out your child interests and
                                                capabilities.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">What if I have an idea to make rurera better?</button></h5>
                                        </div>
                                        <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion2"><div class="card-body">We are always open to suggestions. Share your idea with administrators.</div></div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">Is my child information kept private?</button></h5>
                                        </div>
                                        <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion2"><div class="card-body">Yes, Information is completely private and confidential.</div></div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading7">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                    My child is following rurera, how do I get their sign-in information?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion2">
                                            <div class="card-body">If your child account is associated with your email address, you will be able to recover their username and reset their password using the forget password link given on login form.</div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading8">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">What resources do you propose to help me support my child at home?</button>
                                            </h5>
                                        </div>
                                        <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion2">
                                            <div class="card-body">All kind of resources are available such as including getting guide books, skill plans, sats and fun printable!</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">Login</h2></div>
                                <div class="card">
                                    <div class="card-header" id="headingonsix">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">I forgot my password how can I reset it?</button></h5>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                        <div class="card-body">
                                            To reset your password, click on the "Forgot Password" option on the login page. Enter your registered email and click the password reset link sent to your email to proceed with resetting your password. Follow the
                                            instructions provided to set a new password for your account.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">What can I do if I didnt complete mobile phone number verification?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            If you haven't completed the phone number verification, there are a few steps you can take. Firstly, ensure that you have entered the correct phone number and try the verification process again. If you're still
                                            experiencing difficulties, reach out to our support team for assistance. They will guide you through alternative verification methods or provide further instructions to help you complete the process successfully.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingseven">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">My phone was stolen. How can I access my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                        <div class="card-body">
                                            If your phone was stolen, contact Rurera's support team immediately to secure your account and change your login credentials. Provide the necessary information to verify your identity and regain access to your
                                            account safely.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">Account management</h2></div>
                                <div class="card">
                                    <div class="card-header" id="heading8">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">How can I change the mobile number linked to my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                        <div class="card-body">To change the mobile number linked to your Rurera account, access your account settings, update the mobile number field, and verify the new number for successful linkage.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading9">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapse9">How can I update my personal information on my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                        <div class="card-body">
                                            To update your personal information on your Rurera account, log in and navigate to your account settings or profile section. Make the necessary changes to your name, email, or contact details, and save the updates to
                                            ensure your account reflects the latest information.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading10">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="true" aria-controls="collapse10">What are the technical requirements for Rurera?</button></h5>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                        <div class="card-body">
                                            To access Rurera, ensure your device has a stable internet connection and meets the technical requirements, such as compatible operating systems (Windows, macOS, iOS, Android), up-to-date web browsers (Chrome, Firefox, Safari,
                                            Edge), and any required plugins or software.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading11">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">What should I do if I forget my username?</button></h5>
                                    </div>
                                    <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                        <div class="card-body">
                                            To retrieve your forgotten Rurera username, click on the "Forgot Username" option on the login page. Enter your email address and follow the instructions sent to your email inbox for username recovery. For additional assistance,
                                            contact Rurera's support team.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading12">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">How can I change my profile icon?</button></h5>
                                    </div>
                                    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                        <div class="card-body">To change your profile icon on Rurera, access your account settings. Look for the option to edit your profile or avatar and upload a new image. Save the changes to update your profile icon.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading13">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="true" aria-controls="collapse13">Why can't I sign in?</button></h5>
                                    </div>
                                    <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                                        <div class="card-body">
                                            If you're having trouble signing in to your Rurera account, first check that you're using the correct username and password. Make sure your account is active and your internet connection is working properly. If the problem
                                            persists, reach out to Rurera's support team for help.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading14">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse14" aria-expanded="true" aria-controls="collapse14">How do I contact technical support?</button></h5>
                                    </div>
                                    <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                                        <div class="card-body">To contact Rurera's technical support, visit the contact us on the website. Use the provided contact information, such as email or phone, to reach out for assistance.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading15">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse15" aria-expanded="true" aria-controls="collapse15">How do I renew my membership billed?</button></h5>
                                    </div>
                                    <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion">
                                        <div class="card-body">
                                            To renew your billed membership on Rurera, log in to your account and go to the membership section. Select the desired membership plan, follow the instructions, and complete the payment process to successfully renew your
                                            membership. Enjoy continued access to Rurera's educational resources.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading16">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse16" aria-expanded="true" aria-controls="collapse16">How can I make sure my child uses their correct profile on our family account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion">
                                        <div class="card-body">
                                            To ensure your child uses the correct profile on the family account, create separate profiles, instruct them to select their profile, and monitor their usage to maintain individualized learning experiences.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">General</h2></div>
                                <div id="accordion2">
                                    <div class="card">
                                        <div class="card-header" id="heading4">
                                            <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">How do I access the Rurera platform as a teacher?</button></h5>
                                        </div>
                                        <div id="collapse4" class="collapse show" aria-labelledby="heading4" data-parent="#accordion2">
                                            <div class="card-body">
                                                To access Rurera as a teacher, go to the website provided by your institution or Rurera. Use your username and password to log in. Once logged in, you can manage your courses.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading5">
                                            <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">How can I upload course materials such as documents, presentations, or videos?</button></h5>
                                        </div>
                                        <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion2"><div class="card-body">
                                            To upload course materials on Rurera, click on "Upload" or "Add Content" in your course section. Select the files from your computer and organize them into folders for easy access by students.
                                        </div></div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading6">
                                            <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">How do I set up quizzes and assessments in the Rurera?</button></h5>
                                        </div>
                                        <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion2"><div class="card-body">
                                            Setting up quizzes and assessments on Rurera is easy. Access the assessment tool, click on "Create Assessment," and follow the steps to add questions, set points, and configure settings like time limits and question types.
                                        </div></div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading7">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                    Can I track student progress and performance in the Rurera?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion2">
                                            <div class="card-body">Yes, Rurera allows you to track student progress. Access the gradebook or analytics section in your course, where you can view individual grades,
                                                track assignment completion, and monitor overall course progress.</div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading8">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">What technical support is available if I encounter issues with the Rurera?</button>
                                            </h5>
                                        </div>
                                        <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion2">
                                            <div class="card-body">
                                                If you have technical issues with Rurera, check the platform's support section for helpful resources. You can also contact your institution's IT department or Rurera's support team via email, live chat, or phone for further assistance.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">Login</h2></div>
                                <div class="card">
                                    <div class="card-header" id="headingonsix">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">How can I customize the appearance and layout of my course in the Rurera?</button></h5>
                                    </div>
                                    <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                                        <div class="card-body">
                                            Customize your course's appearance on Rurera by accessing the course settings or design options. Choose themes or templates or adjust colors, fonts, and layouts to match your preferences. Add banners, logos, and personalize the navigation menu for a visually appealing and user-friendly course interface.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">What can I do if I didn t complete mobile phone number verification?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            If you haven't completed the phone number verification, there are a few steps you can take. Firstly, ensure that you have entered the correct phone number and try the verification process again. If you're still
                                            experiencing difficulties, reach out to our support team for assistance. They will guide you through alternative verification methods or provide further instructions to help you complete the process successfully.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingseven">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">My phone was stolen. How can I access my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
                                        <div class="card-body">
                                            If your phone was stolen, contact Rurera's support team immediately to secure your account and change your login credentials. Provide the necessary information to verify your identity and regain access to your
                                            account safely.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-section-title"><h2 class="text-dark-charcoal">Account management</h2></div>
                                <div class="card">
                                    <div class="card-header" id="heading8">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">How can I change the mobile number linked to my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                                        <div class="card-body">To change the mobile number linked to your Rurera account, access your account settings, update the mobile number field, and verify the new number for successful linkage.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading9">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapse9">How can I update my personal information on my Rurera account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                                        <div class="card-body">
                                            To update your personal information on your Rurera account, log in and navigate to your account settings or profile section. Make the necessary changes to your name, email, or contact details, and save the updates to
                                            ensure your account reflects the latest information.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading10">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="true" aria-controls="collapse10">What are the technical requirements for Rurera?</button></h5>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion">
                                        <div class="card-body">
                                            To access Rurera, ensure your device has a stable internet connection and meets the technical requirements, such as compatible operating systems (Windows, macOS, iOS, Android), up-to-date web browsers (Chrome, Firefox, Safari,
                                            Edge), and any required plugins or software.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading11">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">What should I do if I forget my username?</button></h5>
                                    </div>
                                    <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion">
                                        <div class="card-body">
                                            To retrieve your forgotten Rurera username, click on the "Forgot Username" option on the login page. Enter your email address and follow the instructions sent to your email inbox for username recovery. For additional assistance,
                                            contact Rurera's support team.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading12">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">How can I change my profile icon?</button></h5>
                                    </div>
                                    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion">
                                        <div class="card-body">To change your profile icon on Rurera, access your account settings. Look for the option to edit your profile or avatar and upload a new image. Save the changes to update your profile icon.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading13">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="true" aria-controls="collapse13">Why can't I sign in?</button></h5>
                                    </div>
                                    <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion">
                                        <div class="card-body">
                                            If you're having trouble signing in to your Rurera account, first check that you're using the correct username and password. Make sure your account is active and your internet connection is working properly. If the problem
                                            persists, reach out to Rurera's support team for help.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading14">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse14" aria-expanded="true" aria-controls="collapse14">How do I contact technical support?</button></h5>
                                    </div>
                                    <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion">
                                        <div class="card-body">To contact Rurera's technical support, visit the contact us on the website. Use the provided contact information, such as email or phone, to reach out for assistance.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading15">
                                        <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse15" aria-expanded="true" aria-controls="collapse15">How do I renew my membership billed?</button></h5>
                                    </div>
                                    <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion">
                                        <div class="card-body">
                                            To renew your billed membership on Rurera, log in to your account and go to the membership section. Select the desired membership plan, follow the instructions, and complete the payment process to successfully renew your
                                            membership. Enjoy continued access to Rurera's educational resources.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading16">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse16" aria-expanded="true" aria-controls="collapse16">How can I make sure my child uses their correct profile on our family account?</button>
                                        </h5>
                                    </div>
                                    <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion">
                                        <div class="card-body">
                                            To ensure your child uses the correct profile on the family account, create separate profiles, instruct them to select their profile, and monitor their usage to maintain individualized learning experiences.
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
<section class="lms-newsletter py-70 mt-70" style="background-color:#f8f8f8;">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="newsletter-inner">
          <div class="row">
            <div class="col-12 col-lg-6 col-md-6">
              <h2 class="mb-15 font-40"
                >Need some support<br>who can i contact with ?</h2
              >
              <p class="mb-0 font-16">
                Our highly trained support geeks<br>are always ready to help you.
              </p>
            <div class="lms-btn-group mt-30 ">
                <a href="#." class="lms-btn rounded-pill">Get Started</a>
                <a href="#." class="lms-btn rounded-pill">Signup</a>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-md-6">
            <div class="img-holder has-circle-bg"><figure><a href="#"><img src="../assets/default/img/faq-img-1.png" alt="#"></a></figure></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



    @endsection

    @push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    @endpush
