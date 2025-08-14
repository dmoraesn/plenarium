@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    @if (session('success'))
        <div class="mb-4 rounded bg-green-50 text-green-700 px-4 py-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Matérias</h1>
        @can('create', \App\Models\Materia::class)
            <a href="{{ route('materias.create') }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                Nova matéria
            </a>
        @endcan
    </div>

    {{-- O formulário de filtros permanece inalterado --}}
    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por ementa / número / ano" class="rounded-md border-gray-300">

        <select name="tipo" class="rounded-md border-gray-300">
            <option value="">Tipo (todos)</option>
            @foreach($tipos as $id => $sigla)
                <option value="{{ $id }}" @selected($tipoId == $id)>{{ $sigla }}</option>
            @endforeach
        </select>

        <select name="status" class="rounded-md border-gray-300">
            <option value="">Status (todos)</option>
            @foreach(\App\Models\Materia::STATUS as $st)
                <option value="{{ $st }}" @selected($status === $st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
            @endforeach
        </select>

        <button class="rounded-md bg-gray-800 text-white px-3 py-2 hover:bg-gray-900">Filtrar</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="text-left px-4 py-2 w-28">Tipo</th>
                    <th class="text-left px-4 py-2 w-28">Número/Ano</th>
                    <th class="text-left px-4 py-2">Ementa</th>
                    <th class="text-left px-4 py-2 w-40">Autores</th>
                    <th class="text-left px-4 py-2 w-32">Status</th>
                    <th class="text-right px-4 py-2 w-44">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($materias as $m)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $m->tipo->sigla ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $m->numero }}/{{ $m->ano }}</td>
                    
                    {{-- ===== 1. ALTERAÇÃO NA EMENTA ===== --}}
                    {{-- Adicionada a classe CSS e o atributo title. Removido o Str::limit. --}}
                    <td class="px-4 py-2 ementa-truncada" title="{{ $m->ementa }}">
                        {{ $m->ementa }}
                    </td>
                    
                    <td class="px-4 py-2">
                        @if($m->autores->isEmpty())
                            <span class="text-gray-400">—</span>
                        @else
                            {{ $m->autores->pluck('nome_parlamentar')->join(', ') }}
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs
                            @if($m->status === 'pronta_pauta') bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200
                            @elseif($m->status === 'arquivada') bg-gray-100 text-gray-600 ring-1 ring-gray-200
                            @else bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200 @endif">
                            {{ ucfirst(str_replace('_',' ', $m->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <div class="inline-flex items-center gap-2">
                            @can('update', $m)
                                <a href="{{ route('materias.edit', $m) }}" class="text-indigo-600 hover:underline">Editar</a>
                            @endcan

                            {{-- ===== 2. REMOÇÃO DA AÇÃO DE PAUTA ===== --}}
                            {{-- O bloco de código que estava aqui foi removido. --}}

                            @can('delete', $m)
                                <form method="POST" action="{{ route('materias.destroy', $m) }}" class="inline-block" onsubmit="return confirm('Remover esta matéria?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Nenhuma matéria encontrada.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $materias->links() }}
    </div>
</div>
@endsection