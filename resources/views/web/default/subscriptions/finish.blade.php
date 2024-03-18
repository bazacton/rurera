@include('web.default.subscriptions.steps',['activeStep'=> 'finished'])
<div class="book-form-holder">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 col-md-9 col-sm-12 text-center">
                @if( isset( $custom_text ) )
                <h2>{{ $custom_text }}</h2>
                @else
                <h2>Successfully Subscribed for the Package "{{$packageObj->title}}" with amount {{ addCurrencyToPrice($payment_amount) }}</h2>
                @endif
            </div>

        </div>
    </div>
</div>