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
                                                    <span class="progress-icon font-16">
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
            </div>
        </div>
    </section>
</section>

@endsection

@push('scripts_bottom')
@endpush