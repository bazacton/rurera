@extends('web.default.panel.layouts.panel_layout')

@section('content')
    <section>
        <h2 class="section-title font-24">{{ trans('update.points_statistics') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/trophy_cup.png" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $availablePoints }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('update.available_points') }}</span>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/rank.png" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $totalPoints }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('update.total_points') }}</span>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/spent.png" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $spentPoints }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('update.spent_points') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="mt-35">
        <h2 class="section-title font-24">{{ trans('update.points_statistics') }}</h2>

        @if(!empty($rewards))

            <div class="panel-section-card mt-20">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive rewards-table">
                            <table class="table text-center custom-table simple-table">
                                <thead>
                                <tr>
                                    <th class="text-left font-16 font-weight-500">{{ trans('public.title') }}</th>
                                    <th class="text-center font-16 font-weight-500">{{ trans('update.points') }}</th>
                                    <th class="text-center font-16 font-weight-500">{{ trans('public.type') }}</th>
                                    <th class="text-center font-16 font-weight-500">{{ trans('public.date_time') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($rewards as $reward)
                                    @php $rewardTitle = getRewardTitle($reward); @endphp
                                    <tr>
                                        <td data-label="{{ trans('public.title') }}" class="text-left">{{ $rewardTitle }}</td>
                                        <td data-label="{{ trans('update.points') }}" class="text-center align-middle">{{ $reward->score }}</td>
                                        <td data-label="{{ trans('public.type') }}" class="text-center align-middle">
                                            @if($reward->status == \App\Models\RewardAccounting::ADDICTION)
                                                <span class="text-primary">{{ trans('update.add') }}</span>
                                            @else
                                                <span class="text-danger">{{ trans('update.minus') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ trans('public.date_time') }}" class="text-center align-middle">{{ dateTimeFormat($reward->created_at, 'j F Y H:i') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-30">
                {{ $rewards->links('vendor.pagination.panel') }}
            </div>
        @else

            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'quiz.png',
                'title' => trans('update.reward_no_result'),
                'hint' => nl2br(trans('update.reward_no_result_hint')),
            ])

        @endif
    </section>

    @if(!empty($rewardsSettings) and !empty($rewardsSettings['exchangeable']) and $rewardsSettings['exchangeable'] == '1')
        @include('web.default.panel.rewards.exchange_modal')
    @endif
@endsection

@push('scripts_bottom')
    <script>
        var exchangeSuccessAlertTitleLang = '{{ trans('update.exchange_success_alert_title') }}';
        var exchangeSuccessAlertDescLang = '{{ trans('update.exchange_success_alert_desc') }}';
        var exchangeErrorAlertTitleLang = '{{ trans('update.exchange_error_alert_title') }}';
        var exchangeErrorAlertDescLang = '{{ trans('update.exchange_error_alert_desc') }}';
    </script>
    <script src="/assets/default/js/panel/reward.min.js"></script>
@endpush
