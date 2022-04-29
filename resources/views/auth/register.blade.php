@extends('partials._layout')

@section('title_meta')
    <title>Register | {{ config('app.name') }}</title>
@endsection

@section('content')
    <section class="px-6 py-6">
        <div class="container max-w-lg mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-8 text-3xl text-center">Sign up</h1>

                <form method="POST" action="{{ route('pages.register.store') }}">
                    @csrf

                    <div>
                        <label for="first_name" class="block text-gray-700">First Name:</label>
                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            class="block border border-gray-300 w-full p-3 rounded"
                        />
                        @include('partials._validation_error_field', ['field' => 'first_name'])
                    </div>

                    <div class="mt-4">
                        <label for="last_name" class="block text-gray-700">Last Name:</label>
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            class="block border border-gray-300 w-full p-3 rounded"
                        />
                        @include('partials._validation_error_field', ['field' => 'last_name'])
                    </div>

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

                    <div class="mt-4">
                        <label for="confirm_password" class="block text-gray-700">Confirm Password:</label>
                        <input
                            type="password"
                            name="confirm_password"
                            id="confirm_password"
                            class="block border border-gray-300 w-full p-3 rounded"
                        />
                        @include('partials._validation_error_field', ['field' => 'confirm_password'])
                    </div>

                    <button
                        type="submit"
                        class="mt-4 w-full py-2 px-4 rounded text-white bg-green-700 hover:bg-gray-900 focus:bg-gray-900 text-center transition ease-in-out duration-300"
                    >Create Account</button>
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
