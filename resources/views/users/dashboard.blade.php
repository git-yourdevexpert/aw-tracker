@extends('users.partials._layout')

@section('title_meta')
    <title>Dashboard | {{ config('app.name') }}</title>
@endsection

@section('content')
    <section class="px-6 py-6">
        <div class="container max-w-lg mx-auto flex-1 flex flex-col items-center justify-center px-2">
            <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
                <h1 class="mb-8 text-3xl text-center">Welcome {{ auth()->user()->getFullName() }}</h1>
            </div>
        </div>
    </section>
@endsection
