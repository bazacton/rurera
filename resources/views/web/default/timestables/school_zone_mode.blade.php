<div class="section-title mb-20">
    <h2 itemprop="title" class="font-22 mb-0">School Zone</h2>
</div>
<div class="col-12 col-lg-12 col-md-12">
   <ul class="tests-list type-list mb-30">
       <li data-type="single-player" class="active"><img src="/assets/default/img/single.png" alt=""> My Year</li>
       <li data-type="single-player"><img src="/assets/default/img/single.png" alt=""> My Class</li>
       <li data-type="single-player"><img src="/assets/default/img/single.png" alt=""> Leaderboard</li>
   </ul>
</div>
<section class="p-20 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-30" style="background-color: #fff;">
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