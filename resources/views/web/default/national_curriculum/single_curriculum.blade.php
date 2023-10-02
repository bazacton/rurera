<style>
    .hide{display:none !important;}
</style>
<section class="lms-curriculums-section">
    <div class="container">
        <div class="row">

            @if(isset( $nationalCurriculum->NationalCurriculumItems) && !empty(
            $nationalCurriculum->NationalCurriculumItems ) )
            @foreach( $nationalCurriculum->NationalCurriculumItems as $CurriculumItemsData)
            <div class="col-12 col-md-12 col-lg-12" id="nationcurriculum-{{$CurriculumItemsData->id}}">
                <div id="lms-numbers" class="lms-curriculums">
                    <div class="row">
                        <div class="col-12">
                            <div class="element-title">
                                <h2>{{$CurriculumItemsData->title}}</h2>
                            </div>
                            <li class="hide lms-element-nav-li"><a href="#nationcurriculum-{{$CurriculumItemsData->id}}">{{$CurriculumItemsData->title}}</a></li>
                        </div>
                        <div class="col-12">
                            <div class="curriculums-card">
                                <div class="curriculums-head">
                                    <h3>{{$CurriculumItemsData->sub_title}}</h3>
                                </div>
                            </div>
                            @if(isset( $CurriculumItemsData->NationalCurriculumChapters) && !empty(
                            $CurriculumItemsData->NationalCurriculumChapters ) )
                            @foreach( $CurriculumItemsData->NationalCurriculumChapters as
                            $CurriculumChapterData)
                            <div class="curriculums-card">
                                <div class="curriculums-list">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="list-description">
                                                <p> {{$CurriculumChapterData->title}} </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-12">
                                            <ul>
                                                @if(isset( $CurriculumChapterData->NationalCurriculumTopics) && !empty(
                                                $CurriculumChapterData->NationalCurriculumTopics ) )
                                                @foreach( $CurriculumChapterData->NationalCurriculumTopics as
                                                $CurriculumTopicData)
                                                <li><a href="javascript:;">{{$CurriculumTopicData->NationalCurriculumTopicData->sub_chapter_title}}</a>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $(".lms-element-nav-li").each(function(){
            $('.lms-element-nav ul').append('<li>'+$(this).html()+'</li>');
        });
    });

</script>