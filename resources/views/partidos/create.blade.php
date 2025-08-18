@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Novo Partido</h1>
        <a href="{{ route('config.partidos.index') }}" class="text-sm text-indigo-600">Voltar para a lista</a>
    </div>
    <div class="bg-white rounded shadow p-6">
        {{-- A tag <form> foi movida para dentro do _form --}}
        @include('partidos._form')
    </div>
</div>
@endsection