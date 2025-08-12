@extends('layouts.app') {{-- usa o layout do Breeze --}}

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold mb-1">
        Ordem do Dia — Sessão {{ $sessao->numero }}/{{ $sessao->ano }} ({{ ucfirst($sessao->tipo) }})
    </h1>
    <p class="text-sm text-gray-500 mb-6">Status: {{ ucfirst(str_replace('_',' ', $sessao->status)) }} • Data: {{ \Illuminate\Support\Carbon::parse($sessao->data)->format('d/m/Y') }}</p>

    {{-- Adicionar matéria à pauta --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="POST" action="{{ route('sessoes.ordem.store', $sessao) }}" class="flex items-center gap-3">
            @csrf
            <label class="text-sm font-medium">Adicionar matéria:</label>
            <select name="materia_id" class="border rounded px-2 py-1 w-full max-w-xl" required>
                <option value="">-- selecione --</option>
                @foreach($materiasDisponiveis as $m)
                    <option value="{{ $m->id }}">
                        {{ $m->tipo->sigla }}/{{ $m->numero }}/{{ $m->ano }} — {{ \Illuminate\Support\Str::limit($m->ementa, 80) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Adicionar</button>
        </form>
        @error('materia_id')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tabela da pauta --}}
    <div class="bg-white rounded-lg shadow">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="text-left px-4 py-2 w-16">Pos.</th>
                    <th class="text-left px-4 py-2 w-40">Matéria</th>
                    <th class="text-left px-4 py-2">Ementa</th>
                    <th class="text-left px-4 py-2 w-32">Situação</th>
                    <th class="text-right px-4 py-2 w-28">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($itens as $item)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $item->posicao }}</td>
                    <td class="px-4 py-2">
                        {{ $item->materia->tipo->sigla }}/{{ $item->materia->numero }}/{{ $item->materia->ano }}
                    </td>
                    <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($item->materia->ementa, 120) }}</td>
                    <td class="px-4 py-2">{{ ucfirst(str_replace('_',' ', $item->situacao)) }}</td>
                    <td class="px-4 py-2 text-right">
                        <form method="POST" action="{{ route('sessoes.ordem.destroy', [$sessao, $item]) }}"
                              onsubmit="return confirm('Remover este item da pauta?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Remover</button>
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
