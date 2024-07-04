<style>
    .hide{display:none;}
    .above_12{display:none;}
</style>
@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
@endpush

@section('content')

<section class="p-25 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-0" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Weekly Ranking</h2></div>
                <h4 class="text-center mb-20">{{ dateTimeFormat($week_start,'j F Y') }} to  {{ dateTimeFormat($week_end,'j F Y') }}</h4>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                <a href="javascript:;" class="rurera-list-btn week-selection-btn" data-week_no="{{$currentWeek}}">Current Week</a>
                <a href="javascript:;" class="rurera-list-btn week-selection-btn" data-week_no="{{$previousWeek}}">Last Week {{$previousWeek}}</a>
                <ul class="lms-performace-table leaderboard mt-30">
                    <li class="lms-performace-head leaderboard-title" style="background-color: #fff;">
                        <div><h2 class="text-center font-18">Attempt#</h2></div>
                        <div class="text-left"><span>Topic</span></div>
                        <div class="text-center"><span>Total Correct</span></div>
                        <div class="text-center"><span>Time Spent</span></div>
                    </li>
                    @php $user_counter = 1; @endphp
                    @if( $QuizzesResults->count() > 0 )
                        @foreach( $QuizzesResults as $resultObj)
                            <li class="lms-performace-des leaderboard-des">
                                <div class="sr-no text-center"><span>{{$user_counter}}</span></div>
                                <div class="score-des">
                                    <span><a href="#">{{$resultObj->student_journey->learningJourneyItem->topic->sub_chapter_title}}</a></span>
                                </div>
                                <div class="level-up text-center"><span>{{$resultObj->quizz_result_questions_list->where('status', '!=', 'waiting')->count()}}</span></div>
                                <div class="time-sepen text-center"><span>{{getTimeWithText($resultObj->quizz_result_questions_list->where('status', '!=', 'waiting')->sum('time_consumed'))}}</span></div>
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

@endsection

@push('scripts_bottom')
@endpush