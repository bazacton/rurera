
<section class="p-25 panel-border border-radius-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Select Practice Time </h2></div>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                <form action="/timestables/generate_showdown_mode" method="post">
                    {{ csrf_field() }}
                    <h3>It will be five minutes, try to answer the maximum questions.</h3>

                    <div class="form-btn">
                        <button type="submit" class="questions-submit-btn btn"><span>Play</span></button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-lg-12 mx-auto">
                <ul class="lms-performace-table leaderboard">
                    <li class="lms-performace-head leaderboard-title" style="background-color: #fff;">
                        <div><h2 class="text-center font-18">Serial#</h2></div>
                        <div class="text-left"><span>User</span></div>
                        <div class="text-center"><span>Total Correct</span></div>
                        <div class="text-center"><span>Time Spent</span></div>
                        <div class="text-center"><span>Earned Points</span></div>
                    </li>
                    @php $user_counter = 1; @endphp
                    @if( !empty( $usersList ) )
                        @foreach( $usersList as $userObj)
                            @php $is_active = ($userObj->id == auth()->user()->id)? 'active' : ''; @endphp
                            <li class="lms-performace-des leaderboard-des {{$is_active}}">
                                <div class="sr-no text-center"><span>{{$user_counter}}</span></div>
                                <div class="score-des w-25">
                                    <figure><img src="{{$userObj->getAvatar()}}" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager"></figure>
                                    <span><a href="#">{{$userObj->full_name}}</a></span>
                                </div>
                                <div class="level-up text-center"><span>{{$userObj->showdown_correct}}</span></div>
                                <div class="time-sepen text-center"><span>{{getTimeWithText($userObj->showdown_time_consumed)}}</span></div>
                                <div class="coin-earn text-center"><span>{{$userObj->showdown_correct}}</span></div>
                            </li>
                            @php $user_counter++; @endphp
                        @endforeach
                    @endif
                </ul>
            </div>

        </div>
    </div>
</section>