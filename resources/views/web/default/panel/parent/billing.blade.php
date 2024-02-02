@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343;
    }

    .hide {
        display: none;
    }
</style>
@endpush

@section('content')
<section class="">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
        <h1 class="section-title">Billing</h1>
        <br><br><br>
    </div>
</section>

<section class="dashboard">

    <div class="db-form-tabs">
        <div class="db-billing">
                <div class="row">

                    <div class="col-12 col-lg-12 col-md-12">
                        <div class="billing-card">
                            <div class="card-header">
                                <div>
                                    <h5 class="card-title fw-normal mb-0">Invoices</h5>
                                    <small class="text-muted">Showing data from</small>
                                </div>
                            </div>
                            @if( !empty( $Sales ) && $Sales->count() > 0 )
                            <div class="table-responsive">
                                <table class="table table-border table-hover table-nowrap card-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody class="font-size-base">
                                    @foreach( $Sales as $saleObj)
                                    <tr>
                                        <td><a href="javascript:;">Invoice #{{$saleObj->id}}</a></td>
                                        <td>{{ dateTimeFormat($saleObj->created_at,'j F Y') }}</td>
                                        <td>${{$saleObj->total_amount}}</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
    </div>



</section>










@endsection

@push('scripts_bottom')

@endpush

@if(!empty($giftModal))
@push('scripts_bottom2')
<script>
    (function () {
        "use strict";

        handleLimitedAccountModal('{!! $giftModal !!}', 40)
    })(jQuery)
</script>

@endpush
@endif
