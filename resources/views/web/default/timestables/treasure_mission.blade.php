<style>
    .hide{display:none;}
    .above_12{display:none;}
    .rurera-hide{display:none;}
</style>
@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<div class="timestables-mode-block">

<div class="timestables-mode-content">
<div class="section-title mb-20">
    <h2 itemprop="title" class="font-22 mb-0"><a href="/timestables-practice" class="timestables-back-btn"></a> Treasure Mission</h2>
</div>
<section class="p-0 mt-30 treasure-mission-layout">

    @php $get_treasure_missions  = get_treasure_missions(); @endphp


    @if( !empty( $get_treasure_missions ) )
        <div class="listing-search lms-jobs-form mb-20">
            <ul class="inline-filters">
            @foreach( $get_treasure_missions as $key => $missionData)
                @php $is_active = ($key == 0)? 'active' : '';
                $is_locked = isset( $missionData['is_locked'] )? $missionData['is_locked'] : false;
                $li_class = ($is_locked == true)? 'mission-locked' : 'treasure-mission-li';
                @endphp
                <li class=" {{$li_class}} {{$is_active}}" data-mission_id="{{isset( $missionData['id'])? $missionData['id'] : ''}}">
                    <a href="javascript:;">
                        <span class="icon-box">
                                <img src="{{isset( $missionData['img'])? $missionData['img'] : ''}}">
                        </span>
                        {{isset( $missionData['title'])? $missionData['title'] : ''}}
                    </a>
                </li>
            @endforeach
            </ul>
        </div>
    @endif


    <form action="/timestables/generate_treasure_mission" method="post" class="treasure_mission_form">
                        {{ csrf_field() }}
        <input type="hidden" name="nugget_id" id="nugget_id" value="0">
    </form>
    @if( !empty( $treasure_mission_data ) )
    @php $counter = 0; $last_stage_completed = false;@endphp
    @foreach( $treasure_mission_data as $levelObj)
        <div class="spell-levels border-0 rurera-hide" data-mission_id="{{isset( $levelObj['mission_id'] )? $levelObj['mission_id'] : ''}}">
            <div class="panel-subheader">
                <div class="title">
                    <h2 class="font-19 font-weight-bold">{{isset( $levelObj['title'] )? $levelObj['title'] : ''}}</h2>
                    <span class="info-modal-btn" data-toggle="modal" data-target="#{{$levelObj['id']}}"> <img src="/assets/default/svgs/info-icon2.svg" alt=""></span>
                </div>
                <div class="modal fade {{$levelObj['id']}}" id="{{$levelObj['id']}}" tabindex="-1" role="dialog" aria-labelledby="infomodalTitile" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-body">
                        <div class="modal-box">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <span class="icon-box d-block mb-15">
                                <img src="../assets/default/img/clock-modal-img.png" alt="">
                            </span>
                            <h3 class="font-24 font-weight-normal mb-10">Modal title</h3>
                            <span class="level-tool-tip">{{isset( $levelObj['description'] )? $levelObj['description'] : ''}}</span>
                        </div>
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
											$timestableResultObj = isset( $timestables_results[$nuggetObj['id']] )? $timestables_results[$nuggetObj['id']] : (object) array();
                                            $li_custom_class = ($li_count == 6) ? 'vertical-li' : '';
                                            $li_count = ($li_count >= 6)? 0 : $li_count;
                                            $last_stage = (isset( $nuggetObj['is_last_stage'] ) && $nuggetObj['is_last_stage'] == true)? 'last-stage' : '';
                                            $treasure_mission_class = ($is_active == 1 || ($last_stage_completed == 1 && $is_acheived != 1))? 'generate_treasure_mission' : 'locked_nugget';
                                        @endphp
                                        <li class="intermediate {{$li_custom_class}} {{($is_acheived == 1 || $is_active == 1 || $last_stage_completed == 1)? 'completed' : ''}} {{$last_stage}}" data-id="{{$nuggetObj['id']}}" data-quiz_level="medium">
                                            <a href="javascript:;" class="{{$treasure_mission_class}} rurera-tooltip dropup" data-id="{{$nuggetObj['id']}}">
                                                @if($is_acheived == 1 && isset( $timestableResultObj->id) )
                                                    <span class="dropdown-toggle h-100 w-100 d-flex align-items-center justify-content-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/default/img/tick-white.png" alt="">
                                                    </span>
													<div class="lms-tooltip dropdown-menu">
														<div class="tooltip-box">
															<h5 class="font-18 font-weight-bold text-white mb-5">															
															Active practice: {{isset( $timestableResultObj->total_time_consumed )? getTimeWithText($timestableResultObj->total_time_consumed) : 0}}<br> 
															Questions answered: {{$timestableResultObj->total_attempted}} <br>
															<img src="/assets/default/img/panel-sidebar/coins.svg" alt="" width="30">Coins earned:{{$timestableResultObj->total_coins_earned}}
															</h5>
															<button class="tooltip-button" onclick="window.location.href='/panel/results/{{$timestableResultObj->id}}/timetables';">Result</button>
														</div>
													</div>
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
                                                <a href="javascript:;" class="rurera-tooltip dropup">
                                                    
                                                    @if($is_acheived == 1)
                                                        <span class="thumb-box dropdown-toggle h-100 w-100 d-flex align-items-center justify-content-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <img src="/assets/default/img/treasure.png" alt="" title="{{$nuggetObj['treasure_box']}}">
                                                        </span>
                                                        <div class="lms-tooltip dropdown-menu">
                                                            <div class="tooltip-box">
                                                                <h5 class="font-18 font-weight-bold text-white mb-5"><img src="/assets/default/img/panel-sidebar/coins.svg" alt="" width="30"> {{$nuggetObj['treasure_box']}}</h5>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img src="/assets/default/img/treasure2.png" alt="">
                                                    @endif
                                                    
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


</div>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
<script src="/assets/default/vendors/chartjs/chart.min.js"></script>

<script>
$(document).on('click', '.generate_treasure_mission', function (e) {
    var nugget_id = $(this).attr('data-id');
    console.log(nugget_id);
    $("#nugget_id").val(nugget_id);
    $(".treasure_mission_form").submit();

});
$(document).on('click', '.treasure-mission-li', function (e) {
    $(".treasure-mission-li").removeClass('active');
    $(this).addClass('active');
    $('.spell-levels').addClass('rurera-hide');
    var mission_id = $(this).attr('data-mission_id');
    $('.spell-levels[data-mission_id="'+mission_id+'"]').removeClass('rurera-hide');

});
$(".treasure-mission-li.active").click();
</script>


@endpush