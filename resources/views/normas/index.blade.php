@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Normas Jurídicas</h1>
        <a href="{{ route('config.normas.create') }}" class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Nova Norma</a>
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

    <form method="GET" class="mb-4">
        <div class="bg-white rounded shadow p-4 grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" class="mt-1 block w-full rounded border-gray-300">
                    <option value="">Todos</option>
                    @foreach ($tipos as $t)
                        <option value="{{ $t->id }}" @selected(request('tipo') == $t->id)>{{ $t->descricao }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Ano</label>
                <input type="number" name="ano" value="{{ request('ano') }}" class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="flex items-end">
                <button class="px-3 py-2 rounded bg-gray-600 text-white hover:bg-gray-700">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Número/Ano</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ementa</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Publicação</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($itens as $n)
                    <tr>
                        <td class="px-4 py-2">{{ $n->tipoNorma->descricao ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $n->numero }}/{{ $n->ano }}</td>
                        <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($n->ementa, 60) }}</td>
                        <td class="px-4 py-2">{{ optional($n->data_publicacao)->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('config.normas.edit', $n) }}" class="px-3 py-1 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('config.normas.destroy', $n) }}" onsubmit="return confirm('Remover esta norma?');">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhuma norma cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $itens->links() }}</div>
</div>
@endsection
