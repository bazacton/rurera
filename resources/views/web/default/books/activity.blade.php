@extends(getTemplate().'.layouts.app')

@push('styles_top')

@endpush

@section('content')
<section class="lms-performace-section lms-books-listing mt-10">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="listing-card">
                    <div class="row">
                        <div class="col-12 col-lg-2 col-md-3">
                            <div class="img-holder">
                                <figure>
                                    <a href="#"><img src="../../assets/default/img/book-list6.png" alt=""/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-5">
                            <div class="text-holder">
                                <h3><a href="https://chimpstudio.co.uk/flipbook/">{{$book->book_title}}</a></h3>
                                <ul>
                                    <li><span>Book Opened :</span>25 Feb 2023</li>
                                    <li><span>Time Read :</span>{{round($book->BooksUserReadings->sum('read_time') / 60, 2)}} mints</li>
                                    <li><span>Quiz :</span>27 Feb 2023</li>
                                    <li><span>Points :</span>200/ 250 <img src="../../assets/default/svgs/coin-earn.svg"
                                                                           alt=""/></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="book-percentage"><span>96%</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 offset-lg-1">
                <ul class="lms-performace-table">
                    @if( !empty( $bookPageInfoLinks) )
                        @php $count = 0; @endphp
                        @foreach($bookPageInfoLinks as $page_no => $bookPageInfoLinkData)
                            @php $count++; @endphp
                            <li class="lms-performace-des">
                                <div class="sr-no"><span>#{{$count}}</span></div>
                                <div class="score-des">
                                    <span><a href="javascript:;">Page #{{$page_no}}:</a></span>
                                </div>
                                <div class="badge-btn text-right" style="width: 52%;">
                                    @foreach( $bookPageInfoLinkData as $bookPageInfoLinkObj)
                                       <img src="/assets/default/img/book-icons/{{$bookPageInfoLinkObj->info_type}}.png">
                                   @endforeach
                                </div>
                            </li>
                        @endforeach
                    @endif
                    <li class="lms-performace-des">
                        <div class="sr-no"><span>#1</span></div>
                        <div class="score-des">
                            <span><a href="#">Chapter #1:</a></span>
                        </div>
                        <div class="badge-btn text-right" style="width: 52%;">
                            <span style="background-color: #dc3545;">PW</span><span style="background-color: #ffc107;">TT</span><span
                                    style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                            <span style="background-color: #ffc107;">TT</span><span style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                        </div>
                    </li>
                    <li class="lms-performace-des">
                        <div class="sr-no"><span>#2</span></div>
                        <div class="score-des">
                            <span> <a href="#">Chapter #2:</a></span>
                        </div>
                        <div class="badge-btn text-right" style="width: 52%;">
                            <span style="background-color: #dc3545;">PW</span><span style="background-color: #ffc107;">TT</span><span
                                    style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                            <span style="background-color: #ffc107;">TT</span><span style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                        </div>
                    </li>
                    <li class="lms-performace-des">
                        <div class="sr-no"><span>#3</span></div>
                        <div class="score-des">
                            <span><a href="#">Chapter #3:</a></span>
                        </div>
                        <div class="badge-btn text-right" style="width: 52%;">
                            <span style="background-color: #dc3545;">PW</span><span style="background-color: #ffc107;">TT</span><span
                                    style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                            <span style="background-color: #ffc107;">TT</span><span style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                        </div>
                    </li>
                    <li class="lms-performace-des">
                        <div class="sr-no"><span>#4</span></div>
                        <div class="score-des">
                            <span><a href="#">Chapter #4:</a></span>
                        </div>
                        <div class="badge-btn text-right" style="width: 52%;">
                            <span style="background-color: #dc3545;">PW</span><span style="background-color: #ffc107;">TT</span><span
                                    style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                            <span style="background-color: #ffc107;">TT</span><span style="background-color: #1b83fc;">CC</span><span
                                    style="background-color: #1b83fc;">RI</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="lms-activity-timeline">
    <div class="container">
        <div class="row">
            <div class="col-12"></div>
            <div class="col-lg-1 col-md-12 col-sm-12"></div>
            <div class="col-lg-10 col-md-12 col-sm-12">


                @if( !empty( $bookUserActivities ) )
                @foreach( $bookUserActivities as $activityDate => $activitiesData)
                <div class="element-title">
                    <h2><span>{{ $activityDate }}</span></h2>
                </div>
                <div class="timeline-card">
                    <div class="text-holder">
                        <span class="activity-time"><strong>Time read:</strong>16 mints</span>
                        <ul class="timeline-list">
                            @if( !empty($activitiesData))
                            @foreach( $activitiesData as $activityObj)
                            @php $data_values = json_decode($activityObj->bookInfoLinkDetail->data_values);
                            $info_content = isset($data_values->infobox_value)?
                            base64_decode(trim(stripslashes($data_values->infobox_value))) : '';
                            @endphp
                            <li>
                                <div class="timeline-icon">
                                    <img src="../../assets/default/svgs/timeline-icon1.svg" alt="">
                                </div>
                                <div class="timeline-text">
                                    <p>
                                        <strong>{{$activityObj->bookInfoLinkDetail->info_title}}</strong>,<a
                                                href="javascript:;" class="page-no">Page No
                                            {{$activityObj->bookInfoLinkDetail->BooksInfoLinkPage->page_no}}
                                            -</a>{!! $info_content !!}<span
                                                class="info-time">{{ dateTimeFormat($activityObj->created_at,'H:i A') }}</span>
                                    </p>
                                </div>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
            <div class="col-lg-1 col-md-12 col-sm-12"></div>
        </div>
    </div>
</section>
<a href="#" class="scroll-btn" style="display: block;">
    <div class="round">
        <div id="cta"><span class="arrow primera next"></span> <span class="arrow segunda next"></span></div>
    </div>
</a>


@endsection

@push('scripts_bottom')

@endpush
