@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
<section class="content-section">

    <div class="categories-element-title">
        <h2 class="font-24"><span>{{$categoryObj->category->getTitleAttribute()}} - {{$categoryObj->getTitleAttribute()}}</span></h2>
        <p>{{$categoryObj->category->getTitleAttribute()}} courses - Comprehensive list of courses for Children Aged 5, 6 and 7.</p>
    </div>

    <div class="col-12 col-lg-12">
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
    </div>

</section>
@endsection

@push('scripts_bottom')

@endpush
