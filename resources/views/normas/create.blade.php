@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Nova Norma Jurídica</h1>
    <div class="bg-white rounded shadow p-6">
        <form method="POST" action="{{ route('config.normas.store') }}">
            @include('normas._form')
        </form>
    </div>
</div>
@endsection
