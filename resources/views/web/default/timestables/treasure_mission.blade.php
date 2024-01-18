<section class="p-0 mt-30 treasure-mission-layout">

    <h3>Treasure Mission</h3>
    <form action="/timestables/generate_treasure_mission" method="post" class="treasure_mission_form">
                        {{ csrf_field() }}
        <input type="hidden" name="nugget_id" id="nugget_id" value="0">
    </form>
    @if( !empty( $treasure_mission_data ) )
    @php $counter = 0; $last_stage_completed = false;@endphp
    @foreach( $treasure_mission_data as $levelObj)
        <div class="spell-levels border-0">
            <div class="panel-subheader">
                <div class="title">
                    <h2 class="font-19 font-weight-bold">{{isset( $levelObj['title'] )? $levelObj['title'] : ''}}</h2>
                    <span class="info-modal-btn" data-toggle="modal" data-target="#{{$levelObj['id']}}"> <img src="/assets/default/svgs/info-icon2.svg" alt=""></span>
                </div>
                <div class="modal fade {{$levelObj['id']}}" id="{{$levelObj['id']}}" tabindex="-1" role="dialog" aria-labelledby="infomodalTitile" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="infomodalTitile">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <span class="level-tool-tip">{{isset( $levelObj['description'] )? $levelObj['description'] : ''}}</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="stats-list">
                    <ul>
                        <li>
                            <div class="list-box">
                                <strong>Tables</strong>
                                <span>{{isset( $levelObj['per_stage_questions'] )? $levelObj['per_stage_questions'] : 0}} Questions per Stage</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-box">
                                <strong>Speed</strong>
                                <span>{{isset( $levelObj['time_interval'] )? $levelObj['time_interval'] : 0}} Seconds per Question</span>
                            </div>
                        </li>
                        <li>
                            <div class="list-box">
                                <strong>Coins</strong>
                                <span>{{isset( $levelObj['coins'] )? $levelObj['coins'] : 0}} per Correct Answer</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @if( isset( $levelObj['stages'] ) && !empty( $levelObj['stages'] ) )
                @foreach( $levelObj['stages'] as $stage_key => $stageObj)

                        @php $ul_custom_class = isset( $stageObj['custom_class'] )? $stageObj['custom_class'] : ''; $li_count = 0; @endphp
                        @if( isset( $stageObj['nuggets'] ) && !empty( $stageObj['nuggets'] ) )
                            <div class="treasure-stage">
                                <ul class="justify-content-start horizontal-list p-0 {{$ul_custom_class}}" style="display: block;">
                                    @foreach( $stageObj['nuggets'] as $nuggetObj)
                                        @php $counter++; $li_count++ @endphp
                                        @php $is_acheived = in_array( $nuggetObj['id'], $user_timetables_levels)? true : false;
                                            $is_active = (empty($user_timetables_levels) && $counter == 1)? true : false;
                                            $li_custom_class = ($li_count == 6) ? 'vertical-li' : '';
                                            $li_count = ($li_count >= 6)? 0 : $li_count;
                                            $last_stage = (isset( $nuggetObj['is_last_stage'] ) && $nuggetObj['is_last_stage'] == true)? 'last-stage' : '';
                                        @endphp
                                        <li class="intermediate {{$li_custom_class}} {{($is_acheived == 1 || $is_active == 1 || $last_stage_completed == 1)? 'completed' : ''}} {{$last_stage}}" data-id="{{$nuggetObj['id']}}" data-quiz_level="medium">
                                            <a href="javascript:;" class="generate_treasure_mission" data-id="{{$nuggetObj['id']}}">
                                                @if($is_acheived == 1 )
                                                    <img src="/assets/default/img/tick-white.png" alt="">
                                                @elseif($is_active == 1 )
                                                    <img src="/assets/default/img/stepon.png" alt="">
                                                @else
                                                    @if($last_stage_completed == 1)
                                                        <img src="/assets/default/img/stepon.png" alt="">
                                                    @else
                                                        @if( isset( $nuggetObj['is_last_stage'] ) && $nuggetObj['is_last_stage'] == true)
                                                            <img src="/assets/default/img/flag-grey.png" alt="">
                                                        @else
                                                            <img src="/assets/default/img/panel-lock.png" alt="">
                                                        @endif
                                                    @endif
                                                @endif
                                            </a>
                                        </li>
                                        @if( isset( $nuggetObj['treasure_box'] ))
                                            @php $li_count++;
                                                $li_custom_class = ($li_count == 6) ? 'vertical-li' : '';
                                                $li_count = ($li_count >= 6)? 0 : $li_count;
                                            @endphp
                                            <li class="treasure {{$li_custom_class}}">
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
                            </div>
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