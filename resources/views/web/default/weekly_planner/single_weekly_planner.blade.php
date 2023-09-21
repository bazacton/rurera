<section class="lms-planner-section">
    <div class="container">
        <div class="row">

            @if(isset( $weeklyPlanner->WeeklyPlannerItems) && !empty(
            $weeklyPlanner->WeeklyPlannerItems ) )
            @foreach( $weeklyPlanner->WeeklyPlannerItems as $WeeklyPlannerItemsData)
            <div class="col-12 col-md-12 col-lg-12 curriculums-card">
                <div id="lms-numbers" class="lms-curriculums">
                    <div class="row">
                        <div class="col-12">
                        </div>
                        <div class="col-12">

                            <div class="curriculums-list">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <div class="list-description">
                                            <p> {{$WeeklyPlannerItemsData->title}} </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-12">
                                        <ul>
                                            @if(isset( $WeeklyPlannerItemsData->WeeklyPlannerTopics) && !empty(
                                            $WeeklyPlannerItemsData->WeeklyPlannerTopics ) )
                                            @foreach( $WeeklyPlannerItemsData->WeeklyPlannerTopics as
                                            $WeeklyPlannerTopicData)
                                            <li><a href="javascript:;">{{$WeeklyPlannerTopicData->WeeklyPlannerTopicData->sub_chapter_title}}</a>
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
        </div>
    </div>
</section>