@extends('partials._layout')

@section('title_meta')
    <title>Register | {{ config('app.name') }}</title>
@endsection

@section('content')
    <section class="px-6 py-6">
        <div class="container max-w-lg mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-6 text-3xl text-center">Registration</h1>
                <h1 class="mb-4 text-2xl text-center">Enter Your Billing Information</h1>

                <form method="POST" action="/registerBilling/{{ $company->id }}" id="formBillingInfoRegister">
                    @csrf
                    <input type="hidden" name="id" value="{{ $company->id }}">
                    <input type="hidden" name="product_id" value="{{ $product_id }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="address1" class="block text-gray-700">Address 1:</label>
                            <input
                                type="text"
                                name="address1"
                                id="address1"
                                class="block border border-gray-300 w-full p-3 rounded"
                            />
                        </div>

                        <div>
                            <label for="address2" class="block text-gray-700">Address 2:</label>
                            <input
                                type="text"
                                name="address2"
                                id="address2"
                                class="block border border-gray-300 w-full p-3 rounded"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="city" class="block text-gray-700">City:</label>
                            <input
                                type="text"
                                name="city"
                                id="city"
                                class="block border border-gray-300 w-full p-3 rounded"
                            />
                        </div>

                        <div>
                            <label for="state" class="block text-gray-700">State:</label>
                            <input
                                type="text"
                                name="state"
                                id="state"
                                class="block border border-gray-300 w-full p-3 rounded"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="zip" class="block text-gray-700">Zip:</label>
                            <input
                                type="text"
                                name="zip"
                                id="zip"
                                class="block border border-gray-300 w-full p-3 rounded"
                            />
                        </div>

                        <div>
                            <label for="country" class="block text-gray-700">Country:</label>
                            <input
                                type="text"
                                name="country"
                                id="country"
                                class="block border border-gray-300 w-full p-3 rounded"
                            />
                        </div>
                    </div>
                    <br>
                    <label for="card-element" class="block text-gray-700 mb-4">Card Details</label>
                    <!-- <input type="hidden" name="payment_method" class="payment-method"> -->
                    <input id="card-holder-name" name="card-holder-name" type="text" placeholder="Card holder name">
                    <div class="cardElement mt-4" id="card-element"></div>
                    <div id="card-errors" role="alert"></div>
                    <br />
                    <button
                        type="button"
                        id="card-button"
                        data-secret="{{ $intent->client_secret }}"
                        class="mt-4 w-full py-2 px-4 rounded text-white bg-green-700 hover:bg-gray-900 focus:bg-gray-900 text-center transition ease-in-out duration-300"
                    >
                        <span class="spinner hidden">
                            <svg role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="btnText">Next</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
<span style="color:red;">{!! JsValidator::formRequest('App\Http\Requests\BillingInfoRegistrationRequest', '#formBillingInfoRegister'); !!}</span>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script>

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
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        e.preventDefault();
        // $("#formBillingInfoRegister").submit();
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: { name: cardHolderName.value }
                }
            }
            );
       
            console.log(setupIntent);
            console.log(setupIntent.payment_method);
            paymentMethodHandler(setupIntent.payment_method);
    });

    // var form = document.getElementById('formBillingInfoRegister');
    // form.addEventListener('submit', function(event) {
    //     event.preventDefault();

    //     stripe.createToken(card).then(function(result) {
    //         if (result.error) {
    //             var errorElement = document.getElementById('card-errors');
    //             errorElement.textContent = result.error.message;
    //         } else {
    //             stripeTokenHandler(result.token);
    //         }
    //     });
    // });

    function paymentMethodHandler(payment_method) {
        alert(payment_method);
        var form = document.getElementById('formBillingInfoRegister');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>
@endsection
