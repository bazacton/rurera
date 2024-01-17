<section class="p-25">
    <form action="/timestables/generate_treasure_mission" method="post" class="treasure_mission_form">
                        {{ csrf_field() }}
        <input type="hidden" name="nugget_id" id="nugget_id" value="0">
    </form>
    @if( !empty( $treasure_mission_data ) )
    @php $counter = 0; $last_stage_completed = false;@endphp
    @foreach( $treasure_mission_data as $levelObj)
        <div class="spell-levels ">
            <div class="spell-levels-top">
                <div class="spell-top-left">
                    <h3 class="font-19 font-weight-bold">{{isset( $levelObj['title'] )? $levelObj['title'] : ''}}</h3>
                </div>
            </div>
            @if( isset( $levelObj['stages'] ) && !empty( $levelObj['stages'] ) )
                @foreach( $levelObj['stages'] as $stage_key => $stageObj)
                    <h5 class="font-19 font-weight-bold">{{isset( $stageObj['title'] )? $stageObj['title'] : ''}}</h5>

                        @if( isset( $stageObj['nuggets'] ) && !empty( $stageObj['nuggets'] ) )
                            <ul class="justify-content-start" style="display: block;">
                                @foreach( $stageObj['nuggets'] as $nuggetObj)
                                    @php $counter++; @endphp
                                    @php $is_acheived = in_array( $nuggetObj['id'], $user_timetables_levels)? true : false;
                                        $is_active = (empty($user_timetables_levels) && $counter == 1)? true : false;
                                    @endphp
                                    <li class="intermediate {{($is_acheived == 1 || $is_active == 1 || $last_stage_completed == 1)? 'completed' : ''}}" data-id="{{$nuggetObj['id']}}" data-quiz_level="medium">
                                        <a href="javascript:;" class="generate_treasure_mission" data-id="{{$nuggetObj['id']}}">
                                            @if($is_acheived == 1 )
                                                <img src="/assets/default/img/flag-complete.png" alt="">
                                            @elseif($is_active == 1 )
                                                <img src="/assets/default/img/stepon.png" alt="">
                                            @else
                                                @if($last_stage_completed == 1)
                                                    <img src="/assets/default/img/stepon.png" alt="">
                                                @else
                                                    <img src="/assets/default/img/panel-lock.png" alt="">
                                                @endif
                                            @endif
                                        </a>
                                    </li>
                                    @if( isset( $nuggetObj['treasure_box'] ))
                                        <li class="treasure">
                                            <a href="#">
                                                <span class="thumb-box">
                                                    @if($is_acheived == 1)
                                                        <img src="/assets/default/img/treasure.png" alt="">
                                                    @else
                                                        <img src="/assets/default/img/treasure2.png" alt="">
                                                    @endif
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @php $last_stage_completed = $is_acheived; @endphp
                                @endforeach
                            </ul>
                        @endif

                @endforeach
            @endif
        </div>
    @endforeach
    @endif

</section>
<script>
$(document).on('click', '.generate_treasure_mission', function (e) {
    var nugget_id = $(this).attr('data-id');
    console.log(nugget_id);
    $("#nugget_id").val(nugget_id);
    $(".treasure_mission_form").submit();

});
</script>