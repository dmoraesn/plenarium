@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Novo vereador</h1>
        <a href="{{ route('vereadores.index') }}"
           class="inline-flex items-center px-3 py-2 rounded-lg ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">Voltar</a>
    </div>

    @include('vereadores._form', [
        'vereador' => $vereador,      // instância vazia no controller
        'partidos' => $partidos,      // [id => sigla]
        'action'   => route('vereadores.store'),  // **POST /vereadores**
        'isEdit'   => false,
    ])
</div>
@endsection
