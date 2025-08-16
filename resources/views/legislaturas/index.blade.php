@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Legislaturas</h1>
        <a href="{{ route('config.legislaturas.create') }}" class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Nova Legislatura</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Número</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Eleição</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Início</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fim</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ativa</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($itens as $l)
                    <tr>
                        <td class="px-4 py-2">{{ $l->numero ?? '—' }}</td>
                        <td class="px-4 py-2">{{ optional($l->data_eleicao)->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-4 py-2">{{ optional($l->data_inicio)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ optional($l->data_fim)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $l->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $l->ativo ? 'Sim' : 'Não' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('config.legislaturas.edit', $l) }}" class="px-3 py-1 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('config.legislaturas.destroy', $l) }}" onsubmit="return confirm('Tem certeza que deseja remover?');">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Nenhuma legislatura cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $itens->links() }}
    </div>
</div>
@endsection
