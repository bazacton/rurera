@extends(getTemplate().'.layouts.app')

@push('styles_top')
<script src="https://js.stripe.com/v3/"></script>

@endpush

@section('content')
<div class="lms-membership-section">
    <section class="lms-setup-progress-section mb-0 pt-70 pb-60" style="background-color: #fff;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 text-center">
<form id="payment-form">
    @csrf
    <div id="elements"></div>
</form>
</div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts_bottom')

    
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}'); // Replace with your Stripe public key

    const session = JSON.parse('{!! $sessionId !!}'); // Access session ID passed from controller

    const elements = stripe.elements();

    const paymentElement = elements.create('card', {
	  iconStyle: "default",
	  hideIcon: false,
	  style: {
		base: {
		  iconColor: "#666EE8",
		  color: "#31325F",
		  fontWeight: 400,
		  fontFamily: "Arial, sans-serif",
		  fontSize: "16px",
		  fontSmoothing: "antialiased",
		  "::placeholder": {
			color: "#CFD7E0",
		  },
		},
	  },
	  classes: {
		base: 'my-card-class', // Add your custom class if needed
		complete: 'my-card-complete-class', // Class applied when the element is complete
		empty: 'my-card-empty-class', // Class applied when the element is empty
		focus: 'my-card-focus-class', // Class applied when the element is focused
		invalid: 'my-card-invalid-class', // Class applied when the element is invalid
		webkitAutofill: 'my-card-autofill-class', // Class applied when the element is autofilled by the browser
	  },
	  hidePostalCode: true, // Whether to hide the postal code field
	});

    paymentElement.mount('#elements');

    const paymentForm = document.getElementById('payment-form');

    paymentForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        try {
            const { paymentIntent, error } = await stripe.confirmCardPayment(
                session.id, {
                    
                }
            );

            if (error) {
                // Handle payment errors
                console.error(error);
                // Display error message to user
            } else {
                // Payment successful, handle on the same page
                console.log('Payment successful!', paymentIntent);
                fetch('/handle-payment', { // Replace with your actual route
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ intentId: paymentIntent.id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Display success message to user
                        console.log(data.success);
                    } else {
                        // Display error message to user
                        console.error(data.error);
                    }
                })
                .catch(error => {
                    console.error(error);
                    // Handle unexpected errors
                });
            }
        } catch (error) {
            console.error(error);
            // Handle unexpected errors
		}
	});
</script>

@endpush


