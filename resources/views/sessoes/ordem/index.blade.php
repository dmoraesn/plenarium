@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">

    {{-- Breadcrumb + ações rápidas --}}
    @php
        $hasSessoesIndex = \Illuminate\Support\Facades\Route::has('sessoes.index');
        $hasSessoesShow  = \Illuminate\Support\Facades\Route::has('sessoes.show');
    @endphp

    <div class="flex items-center justify-between mb-4">
        <nav aria-label="breadcrumb" class="text-sm text-gray-500">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a></li>
                <li>/</li>
                @if ($hasSessoesIndex)
                    <li><a href="{{ route('sessoes.index') }}" class="hover:text-gray-700">Sessões</a></li>
                    <li>/</li>
                @endif
                <li class="text-gray-700">Ordem do Dia</li>
            </ol>
        </nav>

        <div class="flex gap-2">
            @if ($hasSessoesShow)
                <a href="{{ route('sessoes.show', $sessao) }}"
                   class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
                    Detalhes da sessão
                </a>
            @endif

            @if ($hasSessoesIndex)
                <a href="{{ route('sessoes.index') }}"
                   class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
                    Voltar
                </a>
            @else
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
                    Voltar
                </a>
            @endif
        </div>
    </div>

    {{-- Título --}}
    <h1 class="text-2xl font-semibold mb-1">
        Ordem do Dia — Sessão {{ $sessao->numero }}/{{ $sessao->ano }} ({{ ucfirst($sessao->tipo) }})
    </h1>

    {{-- Status + data (badge) --}}
    @php
        $statusLabel = ucfirst(str_replace('_',' ', $sessao->status));
        $statusClass = match ($sessao->status) {
            'aberta'    => 'bg-emerald-100 text-emerald-800',
            'encerrada' => 'bg-gray-200 text-gray-700',
            default     => 'bg-amber-100 text-amber-800', // planejada / etc
        };
    @endphp
    <p class="text-sm text-gray-600 mb-6 flex items-center gap-2">
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
            Status: {{ $statusLabel }}
        </span>
        <span>•</span>
        <span>Data: {{ \Illuminate\Support\Carbon::parse($sessao->data)->format('d/m/Y') }}</span>
    </p>

    {{-- Adicionar matéria à pauta --}}
    <div class="bg-white rounded-xl shadow p-4 mb-6 ring-1 ring-gray-200">
        <form method="POST" action="{{ route('sessoes.ordem.store', $sessao) }}"
              class="flex flex-col sm:flex-row sm:items-center gap-3">
            @csrf

            <label for="materia_id" class="text-sm font-medium text-gray-700">
                Adicionar matéria:
            </label>

            <div class="flex-1 min-w-[280px]">
                <select id="materia_id" name="materia_id" required autofocus
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- selecione --</option>
                    @foreach($materiasDisponiveis as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->tipo->sigla }}/{{ $m->numero }}/{{ $m->ano }} — {{ \Illuminate\Support\Str::limit($m->ementa, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium
                           bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none
                           focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                {{-- ícone + --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/>
                </svg>
                Adicionar
            </button>
        </form>

        @error('materia_id')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tabela da pauta --}}
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
                @php
                    $sitLabel = ucfirst(str_replace('_',' ', $item->situacao));
                    $sitClass = $item->situacao === 'em_pauta'
                        ? 'bg-blue-100 text-blue-800'
                        : 'bg-gray-200 text-gray-700';
                @endphp
                <tr class="bg-white">
                    <td class="px-4 py-2">{{ $item->posicao }}</td>
                    <td class="px-4 py-2">
                        {{ $item->materia->tipo->sigla }}/{{ $item->materia->numero }}/{{ $item->materia->ano }}
                    </td>
                    <td class="px-4 py-2 text-gray-800">
                        {{ \Illuminate\Support\Str::limit($item->materia->ementa, 120) }}
                    </td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $sitClass }}">
                            {{ $sitLabel }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <form method="POST" action="{{ route('sessoes.ordem.destroy', [$sessao, $item]) }}"
                              onsubmit="return confirm('Remover este item da pauta?')"
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium
                                           bg-rose-600 text-white hover:bg-rose-700 focus:outline-none
                                           focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                Remover
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                        Nenhum item na pauta.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <p class="text-xs text-gray-400 mt-4">
        TODO: drag & drop para reordenar (PATCH), adiar/retirar com justificativa.
    </p>
</div>
@endsection
