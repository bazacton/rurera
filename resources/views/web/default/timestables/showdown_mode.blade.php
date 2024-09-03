<style>
    .hide{display:none;}
    .above_12{display:none;}
</style>
@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<div class="timestables-mode-block">

<div class="timestables-mode-content">
<div class="section-title mb-20">
    <h2 itemprop="title" class="font-22 mb-0"><a href="/timestables-practice" class="timestables-back-btn"></a> Showdown Mode</h2>
</div>
<section class="p-25 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-30" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Select Practice Time </h2></div>
            </div>
            @if($alreadyAttempt != true)
            <div class="col-12 col-lg-12 mx-auto">
                <form action="/timestables/generate_showdown_mode" method="post">
                    {{ csrf_field() }}
                    <h3>It will be five minutes, try to answer the maximum questions.</h3>

                    <div class="form-btn">
                        <button type="submit" class="questions-submit-btn btn"><span>Play</span></button>
                    </div>
                </form>
            </div>
            @else
               <div class="col-12 col-lg-12 mx-auto">
                   <h4 class="text-center">You have already attempted this week.<br>Please return next week to make another attempt.</h4>
               </div>
            @endif



        </div>
    </div>
</section>
<section class="p-25 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-0" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Weekly Ranking</h2></div>
                <h4 class="text-center mb-20">{{ dateTimeFormat($lastMonday,'j F Y') }} to  {{ dateTimeFormat($nextSunday,'j F Y') }}</h4>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                <div class="rurera-list-controls d-flex justify-content-center align-items-center">
                    <a href="javascript:;" class="rurera-list-btn week-selection-btn" data-week_no="{{$currentWeek}}">Current Week</a>
                    <a href="javascript:;" class="rurera-list-btn week-selection-btn" data-week_no="{{$previousWeek}}">Last Week {{$previousWeek}}</a>
                </div>
                <ul class="lms-performace-table leaderboard mt-30">
                    <li class="lms-performace-head leaderboard-title" style="background-color: #fff;">
                        <div><h2 class="text-center font-18">Rank#</h2></div>
                        <div class="text-left"><span>User</span></div>
                        <div class="text-center"><span>Total Correct</span></div>
                        <div class="text-center"><span>Time Spent</span></div>
                    </li>
                    @php $user_counter = 1; @endphp
                    @if( $leaderboardResults->count() > 0 )
                        @foreach( $leaderboardResults as $leaderboardRow)
                            @php $is_active = ($leaderboardRow->user->id == auth()->user()->id)? 'active' : ''; @endphp
                            <li class="lms-performace-des leaderboard-des {{$is_active}}">
                                <div class="sr-no text-center"><span>{{$user_counter}}</span></div>
                                <div class="score-des">
                                    <figure><img src="{{$leaderboardRow->user->getAvatar()}}" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                                    <span><a href="#">{{$leaderboardRow->user->get_full_name()}}</a></span>
                                </div>
                                <div class="level-up text-center"><span>{{$leaderboardRow->showdown_correct}}</span></div>
                                <div class="time-sepen text-center"><span>{{getTimeWithText($leaderboardRow->showdown_time_consumed)}}</span></div>
                            </li>
                            @php $user_counter++; @endphp
                        @endforeach
                    @else
                    <li class="lms-performace-des leaderboard-des">
                       <div class="sr-no text-center"><span>No records found</span></div>
                   </li>
                       @endif
                </ul>
            </div>
        </div>
            </div>
        </section>


</div>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
<script src="/assets/default/vendors/chartjs/chart.min.js"></script>
@endpush