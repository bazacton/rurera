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
<section class="p-25 panel-border border-widht-2 border-bottom-4 border-radius-10 mb-30" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Year Students </h2></div>
            </div>
            <div class="col-12">
                    <div class="school-zone-students">

                        @if( $yearStudents->count() > 0)

                            @foreach( $yearStudents as $studentObj)
                                <div class="student-block">
                                    <img src="{{$studentObj->getAvatar()}}">
                                    {{isset( $studentObj->userYear->id) ? $studentObj->userYear->getTitleAttribute() : ''}}
                                    {{$studentObj->full_name}}
                                    Ranking: Test Rank - {{$studentObj->trophy_badge}}
                                    Ranking: Coins - 100

                                </div>
                            @endforeach

                        @endif



                    </div>
            </div>




        </div>
    </div>
</section>