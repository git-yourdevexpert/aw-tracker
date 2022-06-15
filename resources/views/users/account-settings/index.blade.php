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

            @include('users.account-settings._manage_card')
        </div>
    </section>
@endsection

@section('pageScript')
{!! JsValidator::formRequest('App\Http\Requests\GeneralSettingRequest', '#formGeneralSettings'); !!}
{!! JsValidator::formRequest('App\Http\Requests\ChangePasswordRequest', '#formChangePassword'); !!}
<script>
    function defaultCard(card){
        Swal.fire({
            title: 'Are you sure?',
            text: "This card change to Default Card",
            showCancelButton: true,
            confirmButtonColor: 'green',
            confirmButtonText: 'Make as Default!'
        }).then((result) => {
            if(result.isConfirmed){
                axios.get("{{ route('users.accountSettings.changeDefaultCard') }}", {
                params: { card: card } }, { headers: { "Content-Type": "application/json"}
                })
                .then(function (response) {
                    console.log(response.data.message);
                    Swal.fire(
                    'Changed!',
                    response.data.message,
                    'success'
                    )
                })
                .catch(function (error) {
                    Swal.fire(
                    'Sorry Not Changed!',
                    response.data.message,
                    'error'
                    )
                })
            }
        })
    }
</script>
@endsection
