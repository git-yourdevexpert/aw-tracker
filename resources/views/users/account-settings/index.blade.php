@extends('users.partials._layout')

@section('title_meta')
    <title>Account Settings | {{ config('app.name') }}</title>
@endsection

@section('content')
    <section class="px-6 py-6">
        <div class="container mx-auto flex-1 flex flex-col items-center justify-center px-2 w-full">
            <h1 class="text-3xl text-center">Account Settings</h1>

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

            @include('users.account-settings._general')

            @include('users.account-settings._password')
        </div>
    </section>
@endsection

@section('pageScript')
    <script>
        $('#formGeneralSettings').on('submit', function (e) {
            $('#btnGeneralSettings').attr('disabled', true).addClass('opacity-50');
            $('#btnGeneralSettings .spinner').removeClass('hidden');
            $('.btnText').text('Updating...');
        });

        $('#formChangePassword').on('submit', function (e) {
            $('#btnChangePassword').attr('disabled', true).addClass('opacity-50');
            $('#btnChangePassword .spinner').removeClass('hidden');
            $('#btnChangePassword .btnText').text('Changing...');
        });
    </script>
@endsection
