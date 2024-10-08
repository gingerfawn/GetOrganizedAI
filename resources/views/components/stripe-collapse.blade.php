@push('styles')
<style type="text/css">
.StripeElement {
    box-sizing: border-box;
    heifght: 40px;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
    box-shadow: 0 1px 3px #e6ebf1;
    transition: box-shadow 150ms ease;
}

.StripeElement --focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement --invalid {
    border-color: #fa755a;
}

.StripeElement --webkit-autofill {
    background-color: #fefde5 !important;
}
</style>
@endpush
<label class="mt-3" for="card-element">
    Credit or Debit Card:
</label>

<div id="cardElement"></div>

<div id="cardErrors" role="alert"></div>

<small class="form-text text-muted" id="cardErrors" role="alert"></small>

<input type="hidden" name="payment_method" id="paymentMethod">

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');

    const elements = stripe.elements({ locale : 'en' });
    const cardElement = elements.create('card');

    cardElement.mount('#cardElement');
</script>
<script>
    const form = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');

    payButton.addEventListener('click', async(e) => {
        if (form.elements.payment_platform.value === "{{ $paymentPlatform->id }}"){
            e.preventDefault();
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: {
                        "name" : "{{ auth()->user()->name }}",
                        "email" : "{{ auth()->user()->email }}"
                    }
                }
            );

            if (error) {
                const displayError = document.getElementById('cardErrors');

                displayError.textContent = error.message;
            } else {
                const tokenInput = document.getElementById('paymentMethod');
                tokenInput.value = paymentMethod.id;
                form.submit();
            }
        }

    });
</script>
@endpush