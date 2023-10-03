<style>
    .hide{display:none !important;}
</style>
@if(isset( $weeklyPlanner->WeeklyPlannerItems) && !empty(
$weeklyPlanner->WeeklyPlannerItems ) )
@foreach( $weeklyPlanner->WeeklyPlannerItems as $WeeklyPlannerItemsData)
<div class="col-12 col-md-12 col-lg-12 curriculums-card">
    <div id="lms-numbers" class="lms-curriculums">
        <div class="row">
            <div class="col-12">
            </div>
            <div class="col-12">

                <div class="curriculums-list" id="weeklyplanner-{{$WeeklyPlannerItemsData->week_no}}">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="list-description">
                                <p> Week: {{$WeeklyPlannerItemsData->week_no}} </p>
                            </div>
                        </div>
                        <li class="hide lms-element-nav-li"><a href="#weeklyplanner-{{$WeeklyPlannerItemsData->week_no}}">{{$WeeklyPlannerItemsData->week_no}}</a></li>
                        <div class="col-lg-9 col-md-9 col-sm-12">

                            <ul>
                                <li><h2 class="font-19 font-weight-bold"> {{$WeeklyPlannerItemsData->title}} </h2></li>
                                @if(isset( $WeeklyPlannerItemsData->WeeklyPlannerTopics) && !empty(
                                $WeeklyPlannerItemsData->WeeklyPlannerTopics ) )
                                @foreach( $WeeklyPlannerItemsData->WeeklyPlannerTopics as
                                $WeeklyPlannerTopicData)
                                <li><a href="">{{$WeeklyPlannerTopicData->WeeklyPlannerTopicData->sub_chapter_title}}</a>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
<script type="text/javascript">
    $(document).ready(function () {
        $(".lms-element-nav-li").each(function(){
            $('.lms-element-nav ul').append('<li>'+$(this).html()+'</li>');
        });
    });

</script>