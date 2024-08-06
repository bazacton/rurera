@extends(getTemplate() .'.panel.layouts.panel_layout_full')


@section('content')
        <section>
            <h2 class="section-title">{{ trans('financial.financial_documents') }}</h2>

            <div class="panel-section-card py-20">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive transactions-table">
                            <table class="table text-center custom-table">
                                <thead>
                                <tr>
                                    <th class="font-16 font-weight-500">{{ trans('public.title') }}</th>
                                    <th class="font-16 font-weight-500">{{ trans('public.description') }}</th>
                                    <th class="text-center font-16 font-weight-500">{{ trans('panel.amount') }} ({{ $currency }})</th>
                                    <th class="text-center font-16 font-weight-500">{{ trans('public.creator') }}</th>
                                    <th class="text-center font-16 font-weight-500">{{ trans('public.date') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if($accountings->count() > 0)
                                @foreach($accountings as $accounting)
                                    <tr>
                                        <td class="text-left">
                                            <div class="d-flex flex-column">
                                            <span class="font-16 font-weight-normal">
                                                @if(!empty($accounting->webinar_id) and !empty($accounting->webinar))
                                                    {{ $accounting->webinar->title }}
                                                @elseif(!empty($accounting->meeting_time_id))
                                                    {{ trans('meeting.reservation_appointment') }}
                                                @elseif(!empty($accounting->subscribe_id) and !empty($accounting->subscribe))
                                                    {{ $accounting->subscribe->title }}
                                                @elseif(!empty($accounting->promotion_id) and !empty($accounting->promotion))
                                                    {{ $accounting->promotion->title }}
                                                @elseif(!empty($accounting->registration_package_id) and !empty($accounting->registrationPackage))
                                                    {{ $accounting->registrationPackage->title }}
                                                @elseif($accounting->store_type == \App\Models\Accounting::$storeManual)
                                                    {{ trans('financial.manual_document') }}
                                                @elseif($accounting->type == \App\Models\Accounting::$addiction and $accounting->type_account == \App\Models\Accounting::$asset)
                                                    {{ trans('financial.charge_account') }}
                                                @elseif($accounting->type == \App\Models\Accounting::$deduction and $accounting->type_account == \App\Models\Accounting::$income)
                                                    {{ trans('financial.payout') }}
                                                @else
                                                    ---
                                                @endif
                                            </span>

                                                <span class="font-16 font-weight-normal">
                                                @if(!empty($accounting->webinar_id) and !empty($accounting->webinar))
                                                        {{ $accounting->webinar->id }}
                                                    @elseif(!empty($accounting->meeting_time_id) and !empty($accounting->meetingTime))
                                                        {{ $accounting->meetingTime->meeting->creator->get_full_name() }}
                                                    @elseif(!empty($accounting->subscribe_id) and !empty($accounting->subscribe))
                                                        {{ $accounting->subscribe->id }}
                                                    @elseif(!empty($accounting->promotion_id) and !empty($accounting->promotion))
                                                        {{ $accounting->promotion->id }}
                                                    @elseif(!empty($accounting->registration_package_id) and !empty($accounting->registrationPackage))
                                                        {{ $accounting->registrationPackage->id }}
                                                    @else
                                                        ---
                                                    @endif
                                            </span>
                                            </div>
                                        </td>
                                        <td class="text-left align-middle">
                                            <span class="font-16 font-weight-normal">{{ $accounting->description }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @switch($accounting->type)
                                                @case(\App\Models\Accounting::$addiction)
                                                <span class="font-16 font-weight-normal">+{{ handlePriceFormat($accounting->amount) }}</span>
                                                @break;
                                                @case(\App\Models\Accounting::$deduction)
                                                <span class="font-16 font-weight-normal">-{{ handlePriceFormat($accounting->amount) }}</span>
                                                @break;
                                            @endswitch
                                        </td>
                                        <td class="text-center align-middle font-16 font-weight-normal">{{ trans('public.'.$accounting->store_type) }}</td>
                                        <td class="text-center align-middle font-16 font-weight-normal text-gray">
                                            <span>{{ dateTimeFormat($accounting->created_at, 'j M Y') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr class="no-record-found">
                                    <td class="text-left font-16 font-weight-normal" colspan="5">No Records Found</td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    <div class="my-30">
        {{ $accountings->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>
@endsection
