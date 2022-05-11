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

            <div class="bg-white px-6 py-6 mt-6 rounded-md shadow-md text-gray-700 w-full">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/3">
                        <h2 class="text-xl">Details</h2>
                        <p class="mt-4 text-sm text-gray-600 tracking-wider pr-4">Select your subscription in order to continue using this application. The invoice will also be sent to you on registered email address.</p>
                    </div>

                    {{-- <div class="mt-6 md:mt-0 w-full md:w-2/3">
                        <form action="{{ route('users.subscription.pay') }}" method="POST" id="formMakeSubscriptionPayment" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" class="validation">
                            @csrf

                            <div>
                                <label for="name_on_card" class="block text-gray-700">Name on Card:</label>
                                <input
                                    type="text"
                                    name="name_on_card"
                                    id="name_on_card"
                                    value="{{ old('name_on_card') }}"
                                    class="block border border-gray-300 w-full p-3 rounded"
                                />
                                @include('partials._validation_error_field', ['field' => 'name_on_card'])
                            </div>

                            <div class="mt-4">
                                <label for="card_number" class="block text-gray-700">Card Number:</label>
                                <input
                                    type="text"
                                    name="card_number"
                                    id="card_number"
                                    value="{{ old('card_number') }}"
                                    class="block border border-gray-300 w-full p-3 rounded"
                                />
                                @include('partials._validation_error_field', ['field' => 'card_number'])
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-4">
                                <div>
                                    <label for="cvc" class="block text-gray-700">CVC:</label>
                                    <input
                                        type="text"
                                        name="cvc"
                                        id="cvc"
                                        value="{{ old('cvc') }}"
                                        class="block border border-gray-300 w-full p-3 rounded"
                                    />
                                    @include('partials._validation_error_field', ['field' => 'cvc'])
                                </div>

                                <div>
                                    <label for="expiry_month" class="block text-gray-700">Expiry Month:</label>
                                    <input
                                        type="text"
                                        name="expiry_month"
                                        id="expiry_month"
                                        value="{{ old('expiry_month') }}"
                                        class="block border border-gray-300 w-full p-3 rounded"
                                    />
                                    @include('partials._validation_error_field', ['field' => 'expiry_month'])
                                </div>

                                <div>
                                    <label for="expiry_year" class="block text-gray-700">Expiry Year:</label>
                                    <input
                                        type="text"
                                        name="expiry_year"
                                        id="expiry_year"
                                        value="{{ old('expiry_year') }}"
                                        class="block border border-gray-300 w-full p-3 rounded"
                                    />
                                    @include('partials._validation_error_field', ['field' => 'expiry_year'])
                                </div>
                            </div>

                            <div class="w-full bg-red-300 text-red-800 py-2 px-4 my-4 hidden error"></div>

                            <div class="flex items-center">
                                <button
                                    type="submit"
                                    id="btnMakeSubscriptionPayment"
                                    class="mt-6 w-1/2 sm:w-48 py-2 px-4 rounded text-white bg-green-700 hover:bg-gray-900 focus:bg-gray-900 text-center transition ease-in-out duration-300"
                                >
                                    <span class="spinner hidden">
                                        <svg role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    <span class="btnText">Make Payment</span>
                                </button>

                                <a href="{{ route('users.dashboard') }}" class="ml-4 mt-6 text-red-400 hover:text-red-700 focus:text-red-700 transition ease-in-out duration-300">Cancel</a>
                            </div>
                        </form>
                    </div> --}}

                    <form action="{{ route('users.subscription.pay') }}" method="post" id="payment-form">
                        @csrf

                        <select name="product_id" id="product_id" class="w-full px-3 py-2 bg-gray-100 my-3" required>
                            <option value="">Select</option>
                            @foreach ($allProducts as $prdId => $product)
                                <option value="{{ $prdId }}">{{ $product['name'] }}</option>
                            @endforeach
                        </select>

                        <div class="cardElement" id="card-element"></div>

                        <div id="card-errors" role="alert"></div>

                        <button
                            type="submit"
                            id="btnMakePayment"
                            class="mt-4 w-full py-2 px-4 rounded text-white bg-green-700 hover:bg-gray-900 focus:bg-gray-900 text-center transition ease-in-out duration-300"
                        >
                            <span class="spinner hidden">
                                <svg role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                            </span>
                            <span class="btnText">Submit Payment</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
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
                // Add your base input styles here. For example:
                fontSize: '16px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the customer that there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
          // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        /*$(function() {
            var $form = $(".validation");

            $('form.validation').bind('submit', function(e) {
                var $form = $(".validation"),
                    inputVal = ['input[type=email]', 'input[type=password]',
                                 'input[type=text]', 'input[type=file]',
                                 'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputVal),
                $errorStatus = $form.find('div.error'),
                valid = true;

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.addClass('border-red-300');
                        $errorStatus.removeClass('hidden');
                        e.preventDefault();
                    }
                });

                if (! $form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('#card_number').val(),
                        cvc: $('#cvc').val(),
                        exp_month: $('#expiry_month').val(),
                        exp_year: $('#expiry_year').val()
                    }, stripeHandleResponse);
                }
          });

          function stripeHandleResponse(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hidden')
                        .text(response.error.message);
                } else {
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });*/
    </script>
@endsection
