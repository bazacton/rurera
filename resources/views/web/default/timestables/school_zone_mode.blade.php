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
    <h2 itemprop="title" class="font-22 mb-0"><a href="/timestables-practice" class="timestables-back-btn"></a> School Zone</h2>
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
                                        <span class="user-name d-block mt-0">
                                            {{$studentObj->get_full_name()}}
                                        </span>
                                        <span class="student-rank font-16 font-weight-normal d-block">
                                            <span>Ranking: {{($studentObj->trophy_badge != '')? $studentObj->trophy_badge : '-'}} <img src="/assets/default/svgs/trophy-rank.svg" alt=""></span>
                                            <span>Coins: {{$studentObj->getRewardPoints()}} <img src="/assets/default/svgs/stats-coins.svg" alt=""></span>
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
                        <div class="col-12">
                            <ul class="tests-list sections-list mb-30">
                                @foreach( $classSections as $classSectionObj)
                                    @php $selected_section = ($section_counter == 1)? $classSectionObj->id : $selected_section; @endphp
                                    <li data-type="section-{{$classSectionObj->id}}" class="{{($section_counter==1)? 'active' : ''}}">{{$classSectionObj->title}}</li>
                                    @php $section_counter++; @endphp
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if( $yearStudents->count() > 0)

                        @foreach( $yearStudents as $studentObj)
                            @php $studentClass = ($studentObj->section_id == $selected_section)? '' : 'rurera-hide'; @endphp
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="student-block mb-15">
                                    <img src="{{$studentObj->getAvatar()}}">
                                    <span class="student-block-text d-block font-18 font-weight-bold">
                                        <span class="user-name d-block mt-0">
                                            {{$studentObj->get_full_name()}}
                                        </span>
                                        <span class="student-rank font-16 font-weight-normal d-block">
                                            <span>Ranking: {{($studentObj->trophy_badge != '')? $studentObj->trophy_badge : '-'}} <img src="/assets/default/svgs/trophy-rank.svg" alt=""></span>
                                            <span>Coins: {{$studentObj->getRewardPoints()}} <img src="/assets/default/svgs/stats-coins.svg" alt=""></span>
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
            @if( (5 - $results_data->count()) > 0)
                <div class="col-12">
                    <div class="referral-withdraw mb-30">
                      <div class="withdraw-card p-15 d-flex align-items-center flex-wrap">
                          <div class="icon-box">
                              <img src="/assets/default/svgs/shuttlecock.svg" alt="">
                          </div>
                              <div class="withdraw-text">
                                  <h3 class="blog-grid-title font-18 font-weight-bold mb-5" itemprop="title">You need to play Timestables Trophy Mode {{(5 - $results_data->count())}} more games to display in leaderboard.</h3>
                              </div>
                      </div>
                    </div>
                  </div>
            @endif
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
                                    <span><a href="#">{{$leaderboardRow->get_full_name()}}</a></span>
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