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
                                    <a href="#"><img src="{{$book->cover_image}}" alt=""/></a>
                                </figure>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-5">
                            <div class="text-holder">
                                <h3><a href="https://chimpstudio.co.uk/flipbook/">{{$book->book_title}}</a></h3>
                                <ul>
                                    <li><span>Book Opened :</span>{{ ($book_opened > 0)? dateTimeFormat($book_opened,'d F Y') : '' }}</li>
                                    <li><span>Time Read :</span>{{round($book->BooksUserReadings->sum('read_time') / 60, 2)}} mints</li>
                                    <li><span>Quiz :</span>27 Feb 2023 ----</li>
                                    <li><span>Points :</span>200/ 250 --- <img src="../../assets/default/svgs/coin-earn.svg"
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
										@php @info_link_icon = ($bookPageInfoLinkObj->info_type == 'map')? 'map.svg' : $bookPageInfoLinkObj->info_type.'.png'; @endphp
                                       <img src="/assets/default/img/book-icons/{{$info_link_icon}}">
                                   @endforeach
                                </div>
                            </li>
                        @endforeach
                    @endif
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
                @php $time_read = $activitiesData->sum('read_time');
                $time_read = ($time_read > 0) ? round($time_read / 60, 2) : 0;
                @endphp
                <div class="element-title">
                    <h2><span>{{ $activityDate }}</span></h2>
                </div>
                <div class="timeline-card">
                    <div class="text-holder">
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
