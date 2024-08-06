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
                                    <th class="font-16 font-weight-500">Student</th>
                                    <th class="text-center font-16 font-weight-500">{{ trans('panel.amount') }} ({{ $currency }})</th>
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
												{{isset( $accounting->orderItem->order->package->title )? $accounting->orderItem->order->package->title : ''}}
                                            </span>
                                            </div>
                                        </td>
                                        <td class="text-left align-middle">
                                            <span class="font-16 font-weight-normal">{{isset( $accounting->orderItem->order->student->id )? $accounting->orderItem->order->student->get_full_name() : ''}}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @switch($accounting->type)
                                                @case(\App\Models\Accounting::$addiction)
                                                <span class="font-16 font-weight-normal">+{{ $accounting->amount }}</span>
                                                @break;
                                                @case(\App\Models\Accounting::$deduction)
                                                <span class="font-16 font-weight-normal">-{{ $accounting->amount }}</span>
                                                @break;
                                            @endswitch
                                        </td>
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