@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tipos de Expediente</h1>
        <a href="{{ route('config.tipos-expediente.create') }}" class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Novo Tipo</a>
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
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descrição</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ordenação</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ativo</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($itens as $i)
                    <tr>
                        <td class="px-4 py-2">{{ $i->descricao }}</td>
                        <td class="px-4 py-2">{{ $i->ordenacao ?? '—' }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $i->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $i->ativo ? 'Sim' : 'Não' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('config.tipos-expediente.edit', $i) }}" class="px-3 py-1 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('config.tipos-expediente.destroy', $i) }}" onsubmit="return confirm('Remover este tipo?');">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Nenhum tipo cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($itens instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">{{ $itens->links() }}</div>
    @endif
</div>
@endsection