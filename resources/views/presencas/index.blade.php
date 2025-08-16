@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Presenças</h1>
            <p class="text-sm text-gray-500">
                Sessão {{ $sessao->numero }}/{{ $sessao->ano }} — {{ $sessao->tipo_label ?? $sessao->tipo }}
            </p>
        </div>
        <a href="{{ route('sessoes.index') }}" class="text-indigo-600 hover:underline">Voltar para Sessões</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded border border-red-300 bg-red-50 text-red-800 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    @php $rawStatus = strtolower($sessao->normalized_status ?? (string) $sessao->status); @endphp
    @if ($rawStatus !== 'aberta')
        <div class="mb-6 rounded border border-yellow-300 bg-yellow-50 text-yellow-800 px-4 py-3">
            Presenças bloqueadas — a sessão não está aberta.
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-xs text-gray-500">Presentes</div>
            <div class="text-2xl font-bold">{{ $totais['presentes'] }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-xs text-gray-500">Ausentes</div>
            <div class="text-2xl font-bold">{{ $totais['ausentes'] }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-xs text-gray-500">Total</div>
            <div class="text-2xl font-bold">{{ $totais['total'] }}</div>
        </div>
    </div>

    @can('update', $sessao)
        <div class="flex flex-wrap gap-3 mb-6">
            <form method="POST" action="{{ route('sessoes.presencas.bulk.presentes', $sessao) }}">
                @csrf @method('PATCH')
                <button class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">Marcar todos presentes</button>
            </form>
            <form method="POST" action="{{ route('sessoes.presencas.bulk.reset', $sessao) }}">
                @csrf @method('PATCH')
                <button class="px-3 py-2 rounded bg-gray-600 text-white hover:bg-gray-700">Resetar para ausente</button>
            </form>
        </div>
    @endcan

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vereador</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Justificativa</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($presencas as $p)
                    @php
                        $isPresente = ($p->status === 'presente');
                        $nome = $p->vereador->nome_parlamentar ?? $p->vereador->nome_completo ?? '—';
                        $foto = $p->vereador->foto_url ?? asset('images/avatar-vereador.svg');
                    @endphp
                    <tr>
                        <td class="px-4 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ $foto }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                <div class="font-medium text-gray-900">{{ $nome }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $isPresente ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $isPresente ? 'Presente' : 'Ausente' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @if ($p->justificativa)
                                <span class="text-sm text-gray-700">{{ $p->justificativa }}</span>
                            @elseif(!$isPresente)
                                <form method="POST" action="{{ route('sessoes.presencas.justificar', [$sessao, $p->vereador]) }}" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <input
                                        type="text"
                                        name="justificativa"
                                        maxlength="255"
                                        placeholder="Informar justificativa"
                                        class="border-gray-300 rounded w-64 text-sm"
                                        required
                                    >
                                    <button class="px-2 py-1 rounded bg-amber-600 text-white text-sm hover:bg-amber-700">Salvar</button>
                                </form>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex items-center gap-2">
                                @can('update', $sessao)
                                    <form method="POST" action="{{ route('sessoes.presencas.toggle', [$sessao, $p->vereador]) }}">
                                        @csrf @method('PATCH')
                                        <button class="px-3 py-1 rounded {{ $isPresente ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700' }} text-white text-sm">
                                            {{ $isPresente ? 'Marcar ausente' : 'Marcar presente' }}
                                        </button>
                                    </form>

                                    @if ($p->justificativa)
                                        <form
                                            method="POST"
                                            action="{{ route('sessoes.presencas.justificar.delete', [$sessao, $p->vereador]) }}"
                                            onsubmit="return confirm('Remover justificativa?');"
                                        >
                                            @csrf @method('DELETE')
                                            <button class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">
                                                Remover justificativa
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
