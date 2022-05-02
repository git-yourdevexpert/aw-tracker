@extends('partials._layout')

@section('title_meta')
    <title>Login | {{ config('app.name') }}</title>
@endsection

@section('content')
    <section class="px-6 py-6">
        <div class="container max-w-lg mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-8 text-3xl text-center">Login</h1>

                <form method="POST" action="#" id="formLogin">
                    @csrf

                    <div class="mt-4">
                        <label for="email" class="block text-gray-700">E-Mail:</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="block border border-gray-300 w-full p-3 rounded"
                        />
                        @include('partials._validation_error_field', ['field' => 'email'])
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block text-gray-700">Password:</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="block border border-gray-300 w-full p-3 rounded"
                        />
                        @include('partials._validation_error_field', ['field' => 'password'])
                    </div>

                    <button
                        type="submit"
                        id="btnLogin"
                        class="mt-4 w-full py-2 px-4 rounded text-white bg-green-700 hover:bg-gray-900 focus:bg-gray-900 text-center transition ease-in-out duration-300"
                    >
                        <span class="spinner hidden">
                            <svg role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="btnText">Login</span>
                    </button>
                </form>

                <div class="text-center text-sm text-gray-700 mt-4">
                    By signing up, you agree to the
                    <a href="#" class="text-green-700 hover:text-green-800 transition ease-in-out duration-300">
                        Terms of Service
                    </a> and
                    <a href="#" class="text-green-700 hover:text-green-800 transition ease-in-out duration-300">
                        Privacy Policy
                    </a>
                </div>
            </div>

            <div class="text-gray-700 mt-6">
                Already have an account?
                <a href="#" class="text-green-700 hover:text-green-800 transition ease-in-out duration-300">
                    Log in
                </a>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    <script>
        $('#formLogin').on('submit', function (e) {
            $('#btnLogin').attr('disabled', true).addClass('opacity-50');
            $('#btnLogin .spinner').removeClass('hidden');
            $('.btnText').text('Logining...');
        });
    </script>
@endsection
