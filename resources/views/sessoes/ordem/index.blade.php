@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">

    {{-- Breadcrumb foi simplificado --}}
    <div class="flex items-center justify-between mb-4">
        <nav aria-label="breadcrumb" class="text-sm text-gray-500">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('sessoes.index') }}" class="hover:text-gray-700">Sessões</a></li>
                <li>/</li>
                <li class="text-gray-700 font-medium">Ordem do Dia</li>
            </ol>
        </nav>
        <div>
            <a href="{{ route('sessoes.index') }}" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
                Voltar para Sessões
            </a>
        </div>
    </div>

    {{-- Título agora usa os novos accessors do Model Sessao --}}
    <h1 class="text-2xl font-semibold mb-1">
        Ordem do Dia — Sessão {{ $sessao->numero }}/{{ $sessao->ano }} ({{ $sessao->tipo_label }})
    </h1>

    {{-- Status e data usando os accessors --}}
    <p class="text-sm text-gray-600 mb-6 flex items-center gap-2">
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $sessao->status_class }}">
            Status: {{ $sessao->status_label }}
        </span>
        <span>•</span>
        <span>Data: {{ $sessao->data_abertura->format('d/m/Y') }}</span>
    </p>

    {{-- Formulário de adição permanece similar, mas agora faz parte de um layout mais limpo --}}
    <div class="bg-white rounded-xl shadow p-4 mb-6 ring-1 ring-gray-200">
        <form method="POST" action="{{ route('sessoes.ordem.store', $sessao) }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
            @csrf
            <label for="materia_id" class="text-sm font-medium text-gray-700">Adicionar matéria:</label>
            <div class="flex-1 min-w-[280px]">
                <select id="materia_id" name="materia_id" required class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- selecione uma matéria pronta para pauta --</option>
                    @foreach($materiasDisponiveis as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->tipo->sigla }}/{{ $m->numero }}/{{ $m->ano }} — {{ \Illuminate\Support\Str::limit($m->ementa, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
                Adicionar
            </button>
        </form>
        @error('materia_id')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tabela da pauta refatorada --}}
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="text-left px-4 py-2 w-16">Pos.</th>
                    <th class="text-left px-4 py-2 w-40">Matéria</th>
                    <th class="text-left px-4 py-2">Ementa</th>
                    <th class="text-left px-4 py-2 w-32">Situação</th>
                    <th class="text-right px-4 py-2 w-32">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($itens as $item)
                <tr class="bg-white">
                    <td class="px-4 py-2">{{ $item->posicao }}</td>
                    <td class="px-4 py-2">{{ $item->materia->tipo->sigla }}/{{ $item->materia->numero }}/{{ $item->materia->ano }}</td>
                    {{-- Ementa agora usa a classe CSS para truncar, como na outra tela --}}
                    <td class="px-4 py-2 text-gray-800 ementa-truncada" title="{{ $item->materia->ementa }}">
                        {{ $item->materia->ementa }}
                    </td>
                    <td class="px-4 py-2">
                        {{-- Badge de situação agora usa os accessors do model OrdemItem --}}
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $item->situacao_class }}">
                            {{ $item->situacao_label }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <form method="POST" action="{{ route('sessoes.ordem.destroy', [$sessao, $item]) }}" onsubmit="return confirm('Remover este item da pauta?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium bg-rose-600 text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                Remover
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhum item na pauta.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <p class="text-xs text-gray-400 mt-4">
        TODO: drag & drop para reordenar (PATCH), adiar/retirar com justificativa.
    </p>
</div>
@endsection