@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Cargos da Mesa Diretora</h1>
        {{-- Rota corrigida para 'config.cargos-mesa.create' --}}
        <a href="{{ route('config.cargos-mesa.create') }}" class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Novo Cargo</a>
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
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Posição</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cargo único</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ativo</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($itens as $i)
                    <tr>
                        <td class="px-4 py-2">{{ $i->descricao }}</td>
                        <td class="px-4 py-2">{{ $i->posicao_ordenacao ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $i->cargo_unico ? 'Sim' : 'Não' }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $i->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $i->ativo ? 'Sim' : 'Não' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex gap-2">
                                {{-- Rota corrigida para 'config.cargos-mesa.edit' --}}
                                <a href="{{ route('config.cargos-mesa.edit', $i) }}" class="px-3 py-1 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm">Editar</a>
                                {{-- Rota corrigida para 'config.cargos-mesa.destroy' --}}
                                <form method="POST" action="{{ route('config.cargos-mesa.destroy', $i) }}" onsubmit="return confirm('Remover este cargo?');">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        {{-- Colspan corrigido de 4 para 5 --}}
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhum cargo cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $itens->links() }}</div>
</div>
@endsection