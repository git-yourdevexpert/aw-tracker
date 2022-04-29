@extends('partials._layout')

@section('title_meta')
    <title>{{ config('app.name') }}</title>
@endsection

@section('content')
    @if (session('successMessage'))
        <div class="container mx-auto">
            <div class="bg-green-300 text-green-800 py-2 px-4 mt-4">
                Done!
            </div>
        </div>
    @endif
@endsection
