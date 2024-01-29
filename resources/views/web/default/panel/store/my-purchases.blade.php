@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section>
        <h2 class="section-title font-24">{{ trans('update.purchases_statistics') }}</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <div class="row">
                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/physical_product3.png" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $totalOrders }}</strong>
                        <span class="font-16 font-weight-500 text-gray">{{ trans('update.total_orders') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/physical_product2.png" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $pendingOrders }}</strong>
                        <span class="font-16 font-weight-500 text-gray">{{ trans('update.pending_orders') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/physical_product1.png" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $canceledOrders }}</strong>
                        <span class="font-16 font-weight-500 text-gray">{{ trans('update.canceled_orders') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/img/activity/33.png" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ !empty($totalPurchase) ? addCurrencyToPrice($totalPurchase) : 0 }}</strong>
                        <span class="font-16 font-weight-500 text-gray">{{ trans('update.total_purchase') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    
    @if(!empty($orders) and !$orders->isEmpty())
        <section class="mt-35">
            <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
                <h2 class="section-title font-24">{{ trans('update.purchases_history') }}</h2>
            </div>

            <div class="panel-section-card p-0 mt-20">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table text-center custom-table simple-table">
                                <thead>
                                <tr>
                                    <th class=" text-left">Title</th>
                                    <th class="text-center">{{ trans('public.status') }}</th>
                                    <th class="text-center">{{ trans('public.date') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($orders as $order)
                                    <tr>

                                        <td class="text-left">
                                            @if(!empty($order) and !empty($order->product))
                                            <span><a href="/products/{{ $order->product->slug }}" target="_blank">{{ $order->product->title }}</a>
                                                Order #{{ $order->id }},
                                                @if(!empty($order) and !empty($order->product))
                                                    {{ $order->product->point }}
                                                @endif
                                            </span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if($order->status == \App\Models\ProductOrder::$waitingDelivery)
                                                <span class="text-warning">{{ trans('update.product_order_status_waiting_delivery') }}</span>
                                            @elseif($order->status == \App\Models\ProductOrder::$success)
                                                <span class="text-dark-blue">{{ trans('update.product_order_status_success') }}</span>
                                            @elseif($order->status == \App\Models\ProductOrder::$shipped)
                                                <span class="text-warning">{{ trans('update.product_order_status_shipped') }}</span>
                                            @elseif($order->status == \App\Models\ProductOrder::$canceled)
                                                <span class="text-danger">{{ trans('update.product_order_status_canceled') }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span>{{ dateTimeFormat($order->created_at, 'j M Y H:i') }}</span>
                                        </td>

                                        <td class="text-center align-middle">
                                            @if(!empty($order) and $order->status != \App\Models\ProductOrder::$canceled)
                                                <div class="btn-group dropdown table-actions">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="more-vertical" height="20"></i>
                                                    </button>
                                                    <div class="dropdown-menu font-weight-normal">
                                                        <a href="/panel/store/purchases/{{ $order->sale_id }}/productOrder/{{ $order->id }}/invoice" target="_blank" class="webinar-actions d-block mt-10">{{ trans('public.invoice') }}</a>

                                                        @if(!empty($order->product) and $order->status == \App\Models\ProductOrder::$success)
                                                            <a href="{{ $order->product->getUrl() }}" class="webinar-actions d-block mt-10" target="_blank">{{ trans('public.feedback') }}</a>
                                                        @endif

                                                        @if($order->status == \App\Models\ProductOrder::$shipped)
                                                            <button type="button" data-sale-id="{{ $order->sale_id }}" data-product-order-id="{{ $order->id }}" class="js-view-tracking-code webinar-actions btn-transparent d-block mt-10">{{ trans('update.view_tracking_code') }}</button>

                                                            <button type="button" data-sale-id="{{ $order->sale_id }}" data-product-order-id="{{ $order->id }}" class="js-got-the-parcel webinar-actions btn-transparent d-block mt-10">{{ trans('update.i_got_the_parcel') }}</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-30">
                {{ $orders->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>

        </section>
    @else
        @include(getTemplate() . '.includes.no-result',[
              'file_name' => 'sales.png',
              'title' => trans('update.product_purchases_no_result'),
              'hint' => nl2br(trans('update.product_purchases_no_result_hint')),
          ])
    @endif

@endsection

@push('scripts_bottom')
    <script>
        var viewTrackingCodeModalTitleLang = '{{ trans('update.view_tracking_code') }}';
        var trackingCodeLang = '{{ trans('update.tracking_code') }}';
        var closeLang = '{{ trans('public.close') }}';
        var confirmLang = '{{ trans('update.confirm') }}';
        var gotTheParcelLang = '{{ trans('update.i_got_the_parcel') }}';
        var gotTheParcelConfirmTextLang = '{{ trans('update.i_got_the_parcel_confirm') }}';
        var gotTheParcelSaveSuccessLang = '{{ trans('update.i_got_the_parcel_success_save') }}';
        var gotTheParcelSaveErrorLang = '{{ trans('update.i_got_the_parcel_error_save') }}';
        var shippingTrackingUrlLang = '{{ trans('update.track_shipping') }}';
        var addressLang = '{{ trans('update.address') }}';
    </script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/js/panel/store/my-purchase.min.js"></script>
@endpush
