@extends('web.default.panel.layouts.panel_layout')
@php use App\Models\Webinar; @endphp

@push('styles_top')

@endpush

@section('content')

<div class="learning-page">


    <div class="d-flex position-relative">


        <div class="learning-page-content flex-grow-1 bg-info-light p-15">
            <div class="learning-content" id="learningPageContent">
                <div class="d-flex align-items-center justify-content-center w-100">



                    <!-- <div class="learning-content-box d-flex align-items-center justify-content-center flex-column p-15 p-lg-30 rounded-lg">
                        <div class="learning-content-box-icon">
                            <img src="/assets/default/img/learning/quiz.svg" alt="downloadable icon">
                        </div>

                        <p>{{$unauthorized_text}}</p>

                        <a href="{{$unauthorized_link}}" class="btn btn-primary btn-sm mt-15">Return</a>
                        <div class="learning-content-quiz"></div>

                    </div> -->
                    <div class="learning-content-box">
                        <div class="learning-icon">
                            <span><img src="/assets/default/svgs/croun-img.svg" width="111" height="80" alt=""></span>
                            <span><img src="/assets/default/svgs/croun-plus.svg" width="192" height="40" alt=""></span>
                        </div>
                        <div class="learning-text">
                            <h5>Access Real-time Student Activity</h5>
                            <p>Get PLUS today for accsecc to live student activity and progress from the freedom of your desk.</p>
                            <button class="get-btn">
                                <span class="btn-animate-left">
                                    <span class="shadow-sm">
                                        <span class="shadow-animate"><img src="/assets/default/img/twinkle-w-shadow.png" alt=""></span>
                                        <span class="shadow-animate"><img src="/assets/default/img/twinkle-w-shadow.png" alt=""></span>
                                    </span>
                                    <span class="shadow-lg">
                                        <span class="shadow-animate"><img src="/assets/default/img/twinkle-w-shadow.png" alt=""></span>
                                    </span>
                                </span>
                                <span class="btn-text"> <img src="/assets/default/svgs/croun-btn.svg" width="20" height="20" alt=""> Get <strong>PLUS</strong> Today</span>
                                <span class="btn-animate-right">
                                    <span class="shadow-sm">
                                        <span class="shadow-animate"><img src="/assets/default/img/twinkle-w-shadow.png" alt=""></span>
                                        <span class="shadow-animate"><img src="/assets/default/img/twinkle-w-shadow.png" alt=""></span>
                                    </span>
                                    <span class="shadow-lg">
                                        <span class="shadow-animate"><img src="/assets/default/img/twinkle-w-shadow.png" alt=""></span>
                                    </span>
                                </span>
                            </button>
                            <div class="learn-option">
                                <span>Want to learn more about PLUS?</span>
                                <a href="#" class="learn-book-btn">Book a demo</a>
                            </div>
                        </div>
                        <div class="learning-table-holder">
                            <div class="learning-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Class</th>
                                            <th>Current Activity</th>
                                            <th>Last Active</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bob Simons</td>
                                            <td>4th Grade</td>
                                            <td>Typing lesson 'U,R, K Keys'</td>
                                            <td>Online Now</td>
                                        </tr>
                                        <tr>
                                            <td>Search Bonnetti</td>
                                            <td>4th Grade</td>
                                            <td>Typing lesson 'J,F, Keys'</td>
                                            <td>Online Now</td>
                                        </tr>
                                        <tr>
                                            <td>Bob Simons</td>
                                            <td>4th Grade</td>
                                            <td>Typing lesson 'U,R, K Keys'</td>
                                            <td>Online Now</td>
                                        </tr>
                                        <tr>
                                            <td>Search Bonnetti</td>
                                            <td>4th Grade</td>
                                            <td>Typing lesson 'J,F, Keys'</td>
                                            <td>Online Now</td>
                                        </tr>
                                        <tr>
                                            <td>Bob Simons</td>
                                            <td>4th Grade</td>
                                            <td>Typing lesson 'U,R, K Keys'</td>
                                            <td>Online Now</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')

@endpush
