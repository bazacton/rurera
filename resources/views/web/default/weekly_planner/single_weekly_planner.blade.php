<section class="lms-planner-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-9">
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
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="list-description">
                                                <p> {{$WeeklyPlannerItemsData->title}} </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
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
            <div class="col-lg-3 col-md-3 col-12 lms-planner-sidebar">
                <div class="lms-course-select">
                    <form>
                        <div class="form-inner flex-column mx-0">
                            <div class="form-field mb-20">
                                <h5>Key Stages</h5>
                                <ul>
                                    <li>
                                        <input type="radio" name="key-stage" id="year3">
                                        <label for="year3">Year 3</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="key-stage" id="year4">
                                        <label for="year4">Year 4</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="key-stage" id="year5">
                                        <label for="year5">Year 5</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="key-stage" id="year6">
                                        <label for="year6">Year 6</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="category_subjects_list mb-20"> 
                                <h5>Select Subject</h5>
                                <ul>
                                    <li>
                                        <input type="radio" name="subject" id="science">
                                        <label for="science">Science</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="subject" id="history">
                                        <label for="history">History</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="subject" id="education">
                                        <label for="education">Religious Education</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="subject" id="art">
                                        <label for="art">Art</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="subject" id="sats">
                                        <label for="sats">Art</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="subject" id="maths">
                                        <label for="maths">maths</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="lms-element-nav">
                    <ul>
                        <li>
                            <a href="#lms-numbers">Numbers</a>
                        </li>
                        <li>
                            <a href="#lms-measurement">Measurement</a>
                        </li>
                        <li>
                            <a href="#">Geometry</a>
                        </li>
                        <li>
                            <a href="#">Statistics</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>