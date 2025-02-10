@extends('home.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Payment') }}</div>

                    <div class="card-body">
                        <form action="{{ route('user.charge') }}" method="POST" id="payment-form">
                            @csrf
                            @method('post')
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="shipping_id" value="{{ $shippingid }}">
                            <div id="card-element"></div>
                            <div id="card-errors" role="alert"></div>

                            <button type="submit" class="btn btn-primary">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Retrieve the Stripe public key from the Laravel configuration
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Insert the token ID into the form
                    var tokenInput = document.createElement('input');
                    tokenInput.setAttribute('type', 'hidden');
                    tokenInput.setAttribute('name', 'stripeToken');
                    tokenInput.setAttribute('value', result.token.id);
                    form.appendChild(tokenInput);

                    // Submit the form
                    form.submit();
                }
            });
        });
    </script>
@endpush