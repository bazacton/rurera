@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
<section class="content-section mt-10">
    <div class="panel-subheader">
        <div class="title">
            <h2 class="font-19 font-weight-bold">Pricing</h2>
        </div>
        <ul class="panel-breadcrumbs">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pricing</a></li>
        </ul>
    </div>
    <div class="panel-stats">
        <div class="stats-user">
            <a href="#">
                <img src="/assets/default/img/stats-thumb.png" alt="">
                <span>Welcome back Mathew Anderson</span>
            </a>
        </div>
        <div class="stats-list">
            <ul>
                <li>
                    <div class="list-box">
                        <strong>$2,340</strong>
                        <span>Today's Sales</span>
                    </div>
                </li>
                <li>
                    <div class="list-box">
                        <strong>35%</strong>
                        <span>Overall Performance</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="panel-membership">
        <div class="membership-top">
            <p>
                <span>Your free trial expired in 17 days.</span>
                <a href="#">Upgrade</a>
            </p>
        </div>
        <div class="membership-text">
            <p>Upgrade your plan from a <b>free trial,</b> to 'premium <br /> plan'<a href="#">&#8594;</a></p>
            <a href="#">Upgrade Account</a>
        </div>
    </div>
    <div class="panel-popup">
        <div class="popup-text">
            <h3 class="font-19 font-weight-bold">Haven't found an answer to your question
                <span>Connect with us either on discord or email us</span>    
            </h3>
            <div class="popup-controls">
                <a href="#" class="discord-btn">Ask on Discord</a>
                <a href="#" class="submit-btn">Submit Ticket</a>
            </div>
        </div>
    </div>
    <div class="categories-element-title">
        <h2 class="font-24"><span>{{$categoryObj->category->getTitleAttribute()}} - {{$categoryObj->getTitleAttribute()}}</span></h2>
        <p>{{$categoryObj->category->getTitleAttribute()}} courses - Comprehensive list of courses for Children Aged 5, 6 and 7.</p>
    </div>

    <div class="categories-boxes row">
        <div class="col-12">
            <div class="subjects-heading">
                <h2 class="font-24">Subjects</h2>
            </div>
        </div>

        <div class="col-12">

            <div class="spell-levels levels-grouping">
                <div class="spell-levels-top">
                    <h3 class="font-19 font-weight-bold">Unite 3 : Grouping and identifying organisms</h3>
                </div>
                <ul>
                    <li>
                        <a href="#">
                            <div class="levels-progress circle" data-percent="85">
                                <span class="progress-box">
                                    <span class="progress-count"></span>
                                </span>
                            </div>
                            <span class="thumb-box">
                                <img src="/assets/default/img/thumb1.png" alt="">
                            </span>
                        </a>
                        <div class="spell-tooltip">
                            <div class="spell-tooltip-text">
                                <h4 class="font-19 font-weight-bold">Hello!</h4>
                                <span>Learn greetings for meeting people</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#">
                            <div class="levels-progress circle" data-percent="55">
                                <span class="progress-box">
                                    <span class="progress-count"></span>
                                </span>
                            </div>
                            <span class="thumb-box">
                                <img src="/assets/default/img/thumb1.png" alt="">
                            </span>
                        </a>
                        <div class="spell-tooltip">
                            <div class="spell-tooltip-text">
                                <h4 class="font-19 font-weight-bold">Introducing yourself</h4>
                                <span>Say your name</span>
                            </div>
                        </div>
                    </li>
                    <li class="treasure">
                        <a href="#">
                            <span class="thumb-box">
                                <img src="/assets/default/img/treasure.png" alt="">
                            </span>
                        </a>
                    </li>

                    <li>

                        <a href="#">
                            <div class="levels-progress circle" data-percent="75">
                                <span class="progress-box">
                                    <span class="progress-count"></span>
                                </span>
                            </div>
                            <span class="thumb-box">
                                <img src="/assets/default/img/thumb1.png" alt="">
                            </span>
                        </a>
                        <div class="spell-tooltip">
                            <div class="spell-tooltip-text">
                                <h4 class="font-19 font-weight-bold">Saying how you are</h4>
                                <span>Complete all Topics above to unlock this!</span>
                            </div>
                        </div>
                    </li><li>
                        <a href="#">
                            <div class="levels-progress circle" data-percent="30">
                                <span class="progress-box">
                                    <span class="progress-count"></span>
                                </span>
                            </div>
                            <span class="thumb-box">
                                <img src="/assets/default/img/thumb1.png" alt="">
                            </span>
                        </a>
                        <div class="spell-tooltip">
                            <div class="spell-tooltip-text">
                                <h4 class="font-19 font-weight-bold">Developing fluency</h4>
                                <span>Complete all Topics above to unlock this!</span>
                            </div>
                        </div>
                    </li>
            </ul>
            </div>



            <div class="categories-card medium">
                <div class="categories-icon" style="background-color: #f29b32;">
                    <img src="/store/1/subjects_images/history.png" alt="">
                </div>
                <div class="categories-text">
                    <h4 class="categories-title font-19 font-weight-bold"><a href="#">History</a></h4>
                    <div class="levels-progress horizontal">
                        <span class="progress-numbers">02/40 Skills</span>
                        <span class="progress-box">
                            <span class="progress-count" style="width: 10%;"></span>
                        </span>
                    </div>
                    <span class="subject-info">08 Units and 40 Lessons</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="categories-card medium">
                <div class="categories-icon" style="background-color: #5391de;">
                    <img src="/store/1/subjects_images/science2.png" alt="">
                </div>
                <div class="categories-text">
                    <h4 class="categories-title font-19 font-weight-bold"><a href="#">Science</a></h4>
                    <a href="#" class="learning-btn">Start Learning</a>
                    <span class="subject-info">08 Units and 40 Lessons</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="categories-card medium">
                <div class="categories-icon" style="background-color: #f29b32;">
                    <img src="/store/1/subjects_images/history.png" alt="">
                </div>
                <div class="categories-text">
                    <h4 class="categories-title font-19 font-weight-bold"><a href="#">History</a></h4>
                    <div class="levels-progress horizontal">
                        <span class="progress-numbers">02/40 Skills</span>
                        <span class="progress-box">
                            <span class="progress-count" style="width: 30%;"></span>
                        </span>
                    </div>
                    <span class="subject-info">08 Units and 40 Lessons</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="categories-card medium border-0">
                <div class="categories-icon" style="background-color: #5391de;">
                    <img src="/store/1/subjects_images/science2.png" alt="">
                </div>
                <div class="categories-text">
                    <h4 class="categories-title font-19 font-weight-bold"><a href="#">Science</a></h4>
                    <a href="#" class="learning-btn">Start Learning</a>
                    <span class="subject-info">08 Units and 40 Lessons</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="subjects-heading">
                <h2 class="font-24">Additional Subjects</h2>
            </div>
        </div>
        <div class="col-12">
            <div class="categories-card medium border-0">
                <div class="categories-icon" style="background-color: #f29b32;">
                    <img src="/store/1/subjects_images/history.png" alt="">
                </div>
                <div class="categories-text">
                    <h4 class="categories-title font-19 font-weight-bold"><a href="#">History</a></h4>
                    <div class="levels-progress horizontal">
                        <span class="progress-numbers">02/40 Skills</span>
                        <span class="progress-box">
                            <span class="progress-count" style="width: 50%;"></span>
                        </span>
                    </div>
                    <span class="subject-info">08 Units and 40 Lessons</span>
                </div>
            </div>
        </div>
    </div>
    <div class="categories-boxes row">
        @if( !empty( $courses_list ) )
            @foreach( $courses_list as $courseObj)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="categories-card">
                        <a href="/{{$categoryObj->slug}}/{{$courseObj->slug}}">
                        <div class="categories-icon" style="background:{{$courseObj->background_color}}">
                            @if($courseObj->icon_code != '')
                                {!! $courseObj->icon_code !!}
                            @else
                                <img src="{!! $courseObj->thumbnail !!}">
                            @endif
                        </div>
                        <h4 class="categories-title">{{$courseObj->getTitleAttribute()}}</h4>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</section>
@endsection

@push('scripts_bottom')

@endpush
