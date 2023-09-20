@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="pages-sub-header lms-course-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-9">
                <p class="lms-subtitle">Programme of study</p>
                <h1 class="font-30 font-weight-bold">National Curriculum</h1>
                <p>Skills available for England key stage 2, Year 5 maths objectives</p>
                <div class="lms-course-select">
                    <form>
                        <div class="form-inner">
                            <div class="form-select-field">
                                <select>
                                    <option>Key Stage</option>
                                </select>
                            </div>
                            <div class="form-select-field">
                                <select>
                                    <option>Maths</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-3 sub-header-img">
                <figure>
                    <img src="../assets/default/img/ukflag-img.png">
                </figure>

            </div>
            <div class="col-12 col-md-12 col-lg-12">
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
<section class="lms-curriculums-section">
    <div class="container">
        <div class="row">

            @if(isset( $nationalCurriculum->NationalCurriculumItems) && !empty(
            $nationalCurriculum->NationalCurriculumItems ) )
            @foreach( $nationalCurriculum->NationalCurriculumItems as $CurriculumItemsData)
            <div class="col-12 col-md-12 col-lg-12">
                <div id="lms-numbers" class="lms-curriculums">
                    <div class="row">
                        <div class="col-12">
                            <div class="element-title">
                                <h2>{{$CurriculumItemsData->title}}</h2>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="curriculums-card">
                                <div class="curriculums-head">
                                    <h4>{{$CurriculumItemsData->sub_title}}</h4>
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
                                                <li><a href="javascript:;">{{$CurriculumTopicData->NationalCurriculumTopicData->sub_chapter_title}}</a></li>
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
<a href="#" class="scroll-btn">
    <div class="round">
        <div id="cta"><span class="arrow primera next "></span> <span class="arrow segunda next "></span></div>
    </div>
</a>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
@endpush
