
<section class="container mt-45 hide">
    <h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>
	
	

    <form action="/payments/payment-request" method="post" class=" mt-25 gateway-payment-form">
	
        {{ csrf_field() }}
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="row">
            @if(!empty($paymentChannels))
            @foreach($paymentChannels as $paymentChannel)
            <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                <input type="radio" checked="checked" name="gateway" id="{{ $paymentChannel->title }}" data-class="{{ $paymentChannel->class_name }}" value="{{ $paymentChannel->id }}">
                <label for="{{ $paymentChannel->title }}" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                    <img src="{{ $paymentChannel->image }}" width="120" height="60" alt="">


                </label>
                <p class="font-weight-500 text-dark-blue">
                    {{ trans('financial.pay_via') }}
                    <span class="font-weight-bold font-16">{{ $paymentChannel->title }}</span>
                </p>
            </div>
            @endforeach
            @endif

            <div class="col-6 col-lg-4 mb-40 charge-account-radio hide">
                <input type="radio" @if(empty($userCharge) or ($total> $userCharge)) disabled @endif name="gateway" id="offline" value="credit">
                <label for="offline" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                    <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">

                    <span class="mt-5">{{ addCurrencyToPrice($userCharge) }}</span>
                </label>

                <p class="font-weight-500 text-dark-blue">
                    {{ trans('financial.account') }}
                    <span class="font-weight-bold">{{ trans('financial.charge') }}</span>
                </p>
            </div>
        </div>


        <div class="d-flex align-items-center justify-content-between mt-45">
            <span class="font-16 font-weight-500 text-gray">{{ trans('financial.total_amount') }} {{ addCurrencyToPrice($total) }}</span>
            <button type="button" id="paymentSubmit" disabled class="btn btn-sm btn-primary">Sart Free Trial</button>
        </div>
    </form>

    @if(!empty($razorpay) and $razorpay)
    <form action="/payments/verify/Razorpay" method="get">
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <script src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="{{ env('RAZORPAY_API_KEY') }}"
                data-amount="{{ (int)($order->total_amount * 100) }}"
                data-buttontext="product_price"
                data-description="Rozerpay"
                data-currency="{{ currency() }}"
                data-image="{{ $generalSettings['logo'] }}"
                data-prefill.name="{{ $order->user->get_full_name() }}"
                data-prefill.email="{{ $order->user->email }}"
                data-theme.color="#43d477">
        </script>
    </form>
    @endif
</section>
<script src="/assets/default/js/parts/payment.min.js"></script>

<script>
    $(".gateway-payment-form").submit();
	
</script>