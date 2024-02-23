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
<a href="/timestables-practice" class="timestables-back-btn">Back</a>
<div class="timestables-mode-content">
<div class="section-title mb-20">
    <h2 itemprop="title" class="font-22 mb-0">School Zone</h2>
</div>
<ul class="tests-list school-zone-list mb-30">
    <li data-type="my-class" class="active">My Class</li>
    @if( $classSections->count() > 1)
        <li data-type="my-year">My Year</li>
    @endif
    <li data-type="leaderboard">Leaderboard</li>
</ul>
<section class="mb-30 school-zone-data my-class-data">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="school-zone-students row">

                    @if( $classStudents->count() > 0)

                        @foreach( $classStudents as $studentObj)
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="student-block mb-15">
                                    <img src="{{$studentObj->getAvatar()}}">
                                    <span class="student-block-text d-block font-18 font-weight-bold">
                                        <span class="user-year-info font-15 font-weight-bold d-block mt-0">
                                            {{isset( $studentObj->userYear->id) ? $studentObj->userYear->getTitleAttribute() : ''}}
                                        </span>
                                        <span class="user-name d-block mt-0">
                                            {{$studentObj->full_name}}
                                        </span>
                                        <span class="student-rank font-14 font-weight-normal d-block">
                                            <span>Ranking: Test Rank {{$studentObj->trophy_badge}} <img src="/assets/default/svgs/trophy-rank.svg" alt=""></span>
                                            <span>Ranking: Coins - {{$studentObj->getRewardPoints()}} <img src="/assets/default/svgs/stats-coins.svg" alt=""></span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endforeach

                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mb-30 school-zone-data my-year-data rurera-hide">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="school-zone-students row">

                    @php $section_counter = 1; $selected_section = 0; @endphp
                    @if( $classSections->count() > 0)
                        <ul class="tests-list sections-list mb-30">
                            @foreach( $classSections as $classSectionObj)
                                @php $selected_section = ($section_counter == 1)? $classSectionObj->id : $selected_section; @endphp
                                <li data-type="section-{{$classSectionObj->id}}" class="{{($section_counter==1)? 'active' : ''}}">{{$classSectionObj->title}}</li>
                                @php $section_counter++; @endphp
                            @endforeach
                        </ul>
                    @endif

                    @if( $yearStudents->count() > 0)

                        @foreach( $yearStudents as $studentObj)
                            @php $studentClass = ($studentObj->section_id == $selected_section)? '' : 'rurera-hide'; @endphp
                            <div class="col-lg-4 col-md-6 col-12 sections-users-list section-{{$studentObj->section_id}} {{$studentClass}}">
                                <div class="student-block mb-15">
                                    <img src="{{$studentObj->getAvatar()}}">
                                    <span class="student-block-text d-block font-18 font-weight-bold">
                                        <span class="user-year-info font-15 font-weight-bold d-block mt-0">
                                            {{isset( $studentObj->userYear->id) ? $studentObj->userYear->getTitleAttribute() : ''}}
                                        </span>
                                        <span class="user-name d-block mt-0">
                                            {{$studentObj->full_name}}
                                        </span>
                                        <span class="student-rank font-14 font-weight-normal d-block">
                                            <span>Ranking: Test Rank {{$studentObj->trophy_badge}} <img src="/assets/default/svgs/trophy-rank.svg" alt=""></span>
                                            <span>Ranking: Coins - {{$studentObj->getRewardPoints()}} <img src="/assets/default/svgs/stats-coins.svg" alt=""></span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endforeach

                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-0 school-zone-data leaderboard-data rurera-hide">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Ranking</h2></div>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                <ul class="lms-performace-table leaderboard mt-30">
                    <li class="lms-performace-head leaderboard-title" style="background-color: #fff;">
                        <div><h2 class="text-center font-18">Rank#</h2></div>
                        <div class="text-left"><span>User</span></div>
                        <div class="text-center"><span>Average</span></div>
                        <div class="text-center"><span>Badge</span></div>
                    </li>
                    @php $user_counter = 1; @endphp
                    @if( $trophyLeaderboard->count() > 0 )
                        @foreach( $trophyLeaderboard as $leaderboardRow)
                            @php $is_active = ''; @endphp
                            <li class="lms-performace-des leaderboard-des {{$is_active}}">
                                <div class="sr-no text-center"><span>{{$user_counter}}</span></div>
                                <div class="score-des">
                                    <figure><img src="{{$leaderboardRow->getAvatar()}}" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                                    <span><a href="#">{{$leaderboardRow->full_name}}</a></span>
                                </div>
                                <div class="level-up text-center"><span>{{$leaderboardRow->trophy_average}}</span></div>
                                <div class="level-up text-center"><span>{{$leaderboardRow->trophy_badge}}</span></div>
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
<script>
    $(document).on('click', '.school-zone-list li', function (e) {
        $(".school-zone-list li").removeClass('active');
        $(this).addClass('active');
        var data_type = $(this).attr('data-type');
        $(".school-zone-data").addClass('rurera-hide');
        $("."+data_type+"-data").removeClass('rurera-hide');

    });
    $(document).on('click', '.sections-list li', function (e) {
            $(".sections-list li").removeClass('active');
            $(this).addClass('active');
            var data_type = $(this).attr('data-type');
            $(".sections-users-list").addClass('rurera-hide');
            $("."+data_type+"").removeClass('rurera-hide');

        });

</script>
@endpush