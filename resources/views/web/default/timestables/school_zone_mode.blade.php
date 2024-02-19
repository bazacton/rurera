<div class="section-title mb-20">
    <h2 itemprop="title" class="font-22 mb-0">School Zone</h2>
</div>
<div class="col-12 col-lg-12 col-md-12">
   <ul class="tests-list school-zone-list mb-30">
       <li data-type="my-year" class="active"><img src="/assets/default/img/single.png" alt=""> My Year</li>
       <li data-type="my-class"><img src="/assets/default/img/single.png" alt=""> My Class</li>
       <li data-type="leaderboard"><img src="/assets/default/img/single.png" alt=""> Leaderboard</li>
   </ul>
</div>
<section class="p-20 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-30 school-zone-data my-year-data" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="school-zone-students row">

                    @if( $yearStudents->count() > 0)

                        @foreach( $yearStudents as $studentObj)
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
                                        <span class="font-14 font-weight-normal d-block">
                                            Ranking: Test Rank - {{$studentObj->trophy_badge}}
                                            Ranking: Coins - 100
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
<section class="p-20 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-30 school-zone-data my-class-data rurera-hide" style="background-color: #fff;">
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
                                        <span class="font-14 font-weight-normal d-block">
                                            Ranking: Test Rank - {{$studentObj->trophy_badge}}
                                            Ranking: Coins - 100
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
<section class="p-25 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-0 school-zone-data leaderboard-data rurera-hide" style="background-color: #fff;">
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

<script>
    $(document).on('click', '.school-zone-list li', function (e) {
        $(".school-zone-list li").removeClass('active');
        $(this).addClass('active');
        var data_type = $(this).attr('data-type');
        $(".school-zone-data").addClass('rurera-hide');
        $("."+data_type+"-data").removeClass('rurera-hide');

    });
</script>