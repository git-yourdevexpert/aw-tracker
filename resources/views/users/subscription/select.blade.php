@extends('users.partials._layout')

@section('title_meta')
    <title>Select Subsription | {{ config('app.name') }}</title>
@endsection

@section('pageStyle')
    <style>
        .cardElement {
            min-width: 40rem;
        }
    </style>
@endsection

@section('content')
    <section class="px-6 py-6">
        <div class="container mx-auto flex-1 flex flex-col items-center justify-center px-2 w-full">
            <h1 class="text-3xl text-center">Select Subsription</h1>

            @if (session('successMessage'))
                <div class="w-full bg-green-300 text-green-800 py-2 px-4 mt-4">
                    {{ session('successMessage') }}
                </div>
            @endif

            @if (session('errorMessage'))
                <div class="w-full bg-red-300 text-red-800 py-2 px-4 mt-4">
                    {{ session('errorMessage') }}
                </div>
            @endif

            @include('users.subscription._plan')

            @include('users.subscription._add_card_details')
        </div>
    </section>
@endsection

@section('pageScript')
{!! JsValidator::formRequest('App\Http\Requests\PlanChangeRequest', '#formPlanChange'); !!}
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script>
        $('#formMakeSubscriptionPayment').on('submit', function (e) {
            $('#btnMakeSubscriptionPayment').attr('disabled', true).addClass('opacity-50');
            $('#btnMakeSubscriptionPayment .spinner').removeClass('hidden');
            $('#btnMakeSubscriptionPayment .btnText').text('Storing...');
        });

        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var options = {
            appearance: {
                theme: 'stripe',
                labels: 'floating'
            }
        }
        var elements = stripe.elements(options);

        var style = {
            base: {
                fontSize: '16px',
                color: '#32325d',
            },
        };

        var card = elements.create('card', {style: style});

        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    </script>
@endsection
