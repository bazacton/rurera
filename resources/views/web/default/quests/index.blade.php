<style>
    .hide{display:none;}
    .above_12{display:none;}
</style>
@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
@endpush

@section('content')

<section class="content-section">
    <section class="pt-10">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="section-title text-left mb-30">
                        <h2 class="mt-0 font-22">Daily Quests</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-12 mb-30">
                    @if( $quests->count() > 0 )
                    <div class="quests-list panel-border bg-white rounded-sm p-30">
                        <ul>

                                @foreach( $quests as $questObj)
                                    @php $questUserData = $DailyQuestsController->getQuestUserData($questObj);

                                    $quest_icon = '/assets/default/img/types/'.$questObj->quest_topic_type.'.svg';
                                    $quest_icon = ( $questObj->quest_icon != '')? $questObj->quest_icon : $quest_icon;
                                    @endphp
                                    <li>
                                            <div class="quests-item">
                                                <div class="icon-box">
                                                    <img src="{{$quest_icon}}" alt="">
                                                </div>
                                                <div class="item-text">
                                                    <h5 class="font-18 font-weight-bold">{{$questObj->title}}</h5>
                                                    <div class="levels-progress horizontal">
                                                        <span class="progress-box">
                                                            <span class="progress-count" style="width: {{isset( $questUserData['completion_percentage'] )? $questUserData['completion_percentage'] : 0}}%;"></span>
                                                        </span>
                                                        <span class="progress-numbers">{{isset( $questUserData['quest_bar_label'] )? $questUserData['quest_bar_label'] : ''}}</span>
                                                    </div>
                                                    <span class="progress-icon font-14">
                                                        <img src="/assets/default/img/quests-coin.png" alt="">
                                                        +{{isset( $questUserData['questScore'] )? $questUserData['questScore'] : 0}}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                @endforeach
                        </ul>

                    </div>
                    @else
                        @php $no_records_data = ''; @endphp
                        @include('web.default.default.list_no_record',['no_records_data' => $no_records_data])
                    @endif
                </div>
                <div class="col-12 col-lg-12 mb-30">
                    <div class="quests-list quests-learning">
                        <div class="section-title text-left mb-30">
                            <h2 class="font-22">Learning Journeys</h2>
                        </div>
                        <ul>
                            <li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-20 bg-danger">
                                <div class="quests-item">
                                    <div class="icon-box">
                                        <img src="/assets/default/img/types/timestables.svg" alt="">
                                    </div>
                                    <div class="item-text">
                                        <h5 class="font-18 font-weight-bold">English</h5>
                                        <div class="levels-progress horizontal">
                                            <span class="progress-box">
                                                <span class="progress-count" style="width: 0%;"></span>
                                            </span>
                                        </div>
                                        <span class="progress-icon font-16 font-weight-normal">
                                            <img src="/assets/default/img/quests-coin.png" alt="">
                                            +20
                                        </span>
                                        <span class="progress-info d-block pt-5">
                                            <strong>0/38</strong> correct questions this week
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-20 bg-success">
                                <div class="quests-item">
                                    <div class="icon-box">
                                        <img src="/assets/default/img/types/timestables.svg" alt="">
                                    </div>
                                    <div class="item-text">
                                        <h5 class="font-18 font-weight-bold">Verbal Reasoning</h5>
                                        <div class="levels-progress horizontal">
                                            <span class="progress-box">
                                                <span class="progress-count" style="width: 0%;"></span>
                                            </span>
                                        </div>
                                        <span class="progress-icon circle">
                                            <img src="/assets/default/svgs/check-border.svg" alt="" class="check-icon">
                                        </span>
                                        <span class="progress-info d-block pt-5">
                                            <strong>76/29</strong> correct questions this week
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-20">
                                <div class="quests-item">
                                    <div class="icon-box">
                                        <img src="/assets/default/img/types/timestables.svg" alt="">
                                    </div>
                                    <div class="item-text">
                                        <h5 class="font-18 font-weight-bold">Maths</h5>
                                        <div class="levels-progress horizontal">
                                            <span class="progress-box">
                                                <span class="progress-count" style="width: 0%;"></span>
                                            </span>
                                        </div>
                                        <span class="progress-icon font-16 font-weight-normal">
                                            <img src="/assets/default/img/quests-coin.png" alt="">
                                            +20
                                        </span>
                                        <span class="progress-info d-block pt-5">
                                            <strong>0/39</strong> correct questions this week
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center justify-content-between flex-wrap bg-white p-20 mb-0 bg-warning">
                                <div class="quests-item">
                                    <div class="icon-box">
                                        <img src="/assets/default/img/types/timestables.svg" alt="">
                                    </div>
                                    <div class="item-text">
                                        <h5 class="font-18 font-weight-bold">Non-Verbal Reasoning</h5>
                                        <div class="levels-progress horizontal">
                                            <span class="progress-box">
                                                <span class="progress-count" style="width: 0%;"></span>
                                            </span>
                                        </div>
                                        <span class="progress-icon circle">
                                            <img src="/assets/default/svgs/check-border.svg" alt="" class="check-icon">
                                        </span>
                                        <span class="progress-info d-block pt-5">
                                            <strong>58/29</strong> correct questions this week
                                        </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

@endsection

@push('scripts_bottom')
@endpush