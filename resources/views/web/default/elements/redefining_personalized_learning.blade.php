@php
$items = isset( $items )? $items : array();
$heading = isset( $heading )? $heading : "Unlock Success with Rurera's Key Features";
$description = isset( $description )? $description : "Rurera provides powerful resources that align with student's specific interests and learning goals.";
@endphp
<section class="pt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mb-50 text-center">
                        <h2 class="mb-10 font-40">{{$heading}}</h2>
                        <p class="font-16 font-weight-500" style="color: #000;">{{$description}}</p>
                    </div>
                </div>
                @if( in_array(10, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="#" itemprop="url">
                                <img src="../assets/default/img/national-curriculum.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">National Curriculum</a>
                        </h3>
                        <p itemprop="description">If offer Skill plans, Courses Topics and Test preparations as per defined curricula.</p>
                    </div>
                </div>
                @endif
                @if( in_array(2, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/11-plus" itemprop="url">
                                <img src="../assets/default/img/entrance-exams.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/11-plus" itemprop="url" class="text-dark-charcoal">Entrance Examination Preps</a>
                        </h3>
                        <p itemprop="description">Rurera offers a chance to prepare for 11+ Exam, Independent Exams, ISEB and CAT4.</p>
                    </div>
                </div>
                @endif
                @if( in_array(3, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/sats-preparation" itemprop="url">
                                <img src="../assets/default/img/sats-home-feature.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/sats-preparation" itemprop="url" class="text-dark-charcoal">SATs Exam Preps</a>
                        </h3>
                        <p itemprop="description">We are providing opportunity to practice SATs exam, SATs papers, SATs assessments SATs tests online.</p>
                    </div>
                </div>
                @endif
                @if( in_array(9, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/timestables-practice" itemprop="url">
                                <img src="../assets/default/img/timetables-feature.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/timestables-practice" itemprop="url" class="text-dark-charcoal">TimeTables Revision</a>
                        </h3>
                        <p itemprop="description">Offering interactive Multiplication and division Practices and challenges to Master TimesTables online.</p>
                    </div>
                </div>
                @endif
                @if( in_array(8, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/book-shelf" itemprop="url">
                                <img src="../assets/default/img/book-shelf-feature.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/book-shelf" itemprop="url" class="text-dark-charcoal">Children Books Online</a>
                        </h3>
                        <p itemprop="description">Discover vast collection of children books and track reading progress and activity, like percentage and time.</p>
                    </div>
                </div>
                @endif
                @if( in_array(15, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="#" itemprop="url">
                                <img src="../assets/default/img/teacher-empowerment-feature.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Teacher Empowerment Tools</a>
                        </h3>
                        <p itemprop="description">Immediate feedback and assessment tools allow teachers to monitor student progress and identify areas that require improvement.</p>
                    </div>
                </div>
                @endif
                @if( in_array(17, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/rewards-features.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Win Rewards</a>
                        </h3>
                        <p itemprop="description">Avail an awesome opportunity to Earn Rewards, Coin points, Win and later redeem to toys.</p>
                    </div>
                </div>
                @endif
                @if( in_array(5, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/quick-assesments.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Quick Assessments</a>
                        </h3>
                        <p itemprop="description">It offers quick assessments and answers to questions are automatically assessed for personalized feedback.</p>
                    </div>
                </div>
                @endif
                @if( in_array(6, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/feature-automated-marking.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Automated Marking</a>
                        </h3>
                        <p itemprop="description">Automated marking data allows for quick identification of students who may require additional support or challenges.</p>
                    </div>
                </div>
                @endif
                @if( in_array(11, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/performance-monitering.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Performance Monitoring</a>
                        </h3>
                        <p itemprop="description">It provides an easy overview of performance trends who may need additional support or recognition.</p>
                    </div>
                </div>
                @endif
                @if( in_array(7, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/insights-feature.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Breakthrough insights</a>
                        </h3>
                        <p itemprop="description">It significantly allows to identify student’s learning strengths and areas needing improvement.</p>
                    </div>
                </div>
                @endif
                @if( in_array(16, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/contact-us" itemprop="url">
                                <img src="../assets/default/img/protection-feature.webp" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/contact-us" itemprop="url" class="text-dark-charcoal">Security and Privacy</a>
                        </h3>
                        <p itemprop="description">Rurera protect student data, maintain trust and comply with data protection and privacy regulations.</p>
                    </div>
                </div>
                @endif

				@if( in_array(1, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20" class="mb-20">
                            <a href="#" itemprop="url">
                                <img src="../assets/default/img/ks1-year1-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">KS1, KS2 Courses</a>
                        </h3>
                        <p itemprop="description">Explore wide range of kS1, KS2 courses, Tests, practices, assessments, resources and much more.</p>
                    </div>
                </div>
				@endif
				
				
				@if( in_array(4, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="#" itemprop="url">
                                <img src="../assets/default/img/analytics-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Analytics</a>
                        </h3>
                        <p itemprop="description">It provides complete insights and data analysis of Total scores, Total attempts, Earned Scores and Earned Coins.</p>
                    </div>
                </div>
				@endif
				
				@if( in_array(12, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/register" itemprop="url">
                                <img src="../assets/default/img/progress-tracking.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/register" itemprop="url" class="text-dark-charcoal">Progress Tracking</a>
                        </h3>
                        <p itemprop="description">Rurera offers a user-friendly platform where teachers can analyze individual and group performance trends.</p>
                    </div>
                </div>
				@endif
				@if( in_array(13, $items))

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="#" itemprop="url">
                                <img src="../assets/default/img/skill-plans-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="#" itemprop="url" class="text-dark-charcoal">Skills Plan</a>
                        </h3>
                        <p itemprop="description">This involves setting goals, identifying the skills you want to acquire or improve, and planning to achieve those goals weekly or monthly.</p>
                    </div>
                </div>
				@endif
				@if( in_array(14, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/pricing" itemprop="url">
                                <img src="../assets/default/img/advance-learning-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/pricing" itemprop="url" class="text-dark-charcoal">Advance Learning</a>
                        </h3>
                        <p itemprop="description">Rurera empowers students through courses, interactive books, exams practices and rewarding experiences.</p>
                    </div>
                </div>
				@endif
				
				@if( in_array(18, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/products" itemprop="url">
                                <img src="../assets/default/img/rewards-store-feature.jpg" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/products" itemprop="url" class="text-dark-charcoal">Rewards Store</a>
                        </h3>
                        <p itemprop="description">Students can redeem coin points and exchange trending toys with every practice via Rurera toy store.</p>
                    </div>
                </div>
				@endif
				@if( in_array(19, $items))
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="feature-grid text-center mb-40" itemprop="feature learning course">
                        <figure class="mb-20">
                            <a href="{{url('/')}}/products" itemprop="url">
                                <img src="../assets/default/img/gamified-learning.png" alt="feature image" height="143" width="276">
                            </a>
                        </figure>
                        <h3 class="mb-5 font-20 font-weight-bold" itemprop="title">
                            <a target="_blank" href="{{url('/')}}/products" itemprop="url" class="text-dark-charcoal">Gamified Learning</a>
                        </h3>
                        <p itemprop="description">Make learning exciting with Rurera’s gamified approach, where vocabulary and spelling practice becomes a fun adventure.</p>
                    </div>
                </div>
				@endif
            </div>
        </div>
    </section>