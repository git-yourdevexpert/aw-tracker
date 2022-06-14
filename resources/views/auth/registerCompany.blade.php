@extends('partials._layout')

@section('title_meta')
    <title>Register | {{ config('app.name') }}</title>
@endsection

@section('content')
    <section class="px-6 py-6">
        <div class="container max-w-lg mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-6 text-3xl text-center">Registration</h1>
                <h1 class="mb-4 text-2xl text-center">Add Company and Select Plan</h1>
                <form method="POST" action="{{ route('pages.registerCompany.store') }}" id="formCompanyRegister">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div>
                        <label for="name" class="block text-gray-700">Company Name:</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="block border border-gray-300 w-full p-3 rounded"
                        />
                    </div>
                    <br />
                    <div>
                        <label for="" class="block text-gray-700">Select Plan:</label>
                        @foreach ($allProducts as $prdId => $product)
                            <input type="radio" name="product_id" id="product_id" value="{{ $prdId }}">  {{ $product['name'] }}<br/>
                            Amount: ${{ $product['amount'] }}<br/>
                        @endforeach
                    </div>
                    <button
                        type="submit"
                        id="btnRegister"
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
{!! JsValidator::formRequest('App\Http\Requests\CompanyRegistrationRequest', '#formCompanyRegister'); !!}
@endsection
