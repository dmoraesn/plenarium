@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <h1 class="text-2xl font-semibold">Vereadores</h1>

        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('vereadores.index') }}" class="hidden sm:block">
                <input name="q" value="{{ $q ?? '' }}" placeholder="Pesquisar..."
                       class="w-64 rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
            </form>

            <a href="{{ route('vereadores.create') }}"
               class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Novo vereador
            </a>
        </div>
    </div>

    {{-- Tabela --}}
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left w-20">Foto</th>
                    <th class="px-4 py-3 text-left">Nome parlamentar</th>
                    <th class="px-4 py-3 text-left">Nome completo</th>
                    <th class="px-4 py-3 text-left w-24">Partido</th>
                    <th class="px-4 py-3 text-left w-28">Status</th>
                    <th class="px-4 py-3 text-right w-64">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse ($vereadores as $v)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <img src="{{ $v->foto_url ?? asset('images/avatar-vereador.svg') }}"
                             alt="" class="h-9 w-9 rounded-full object-cover ring-1 ring-gray-200">
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $v->nome_parlamentar }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $v->nome_completo }}</td>
                    <td class="px-4 py-3">{{ $v->partido->sigla ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                            {{ $v->ativo ? 'bg-green-50 text-green-700 ring-1 ring-green-200'
                                         : 'bg-gray-50 text-gray-700 ring-1 ring-gray-200' }}">
                            {{ $v->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('vereadores.edit', $v) }}"
                               class="inline-flex items-center rounded-md px-3 py-1.5 text-sm ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('vereadores.toggle', $v) }}">
                                @csrf @method('PATCH')
                                <button
                                  class="inline-flex items-center rounded-md px-3 py-1.5 text-sm ring-1 hover:bg-opacity-50
                                         {{ $v->ativo
                                            ? 'text-amber-700 ring-amber-200 hover:bg-amber-50'
                                            : 'text-green-700 ring-green-200 hover:bg-green-50' }}">
                                    {{ $v->ativo ? 'Desativar' : 'Ativar' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('vereadores.destroy', $v) }}"
                                  onsubmit="return confirm('Excluir {{ $v->nome_parlamentar }}?')">
                                @csrf @method('DELETE')
                                <button
                                  class="inline-flex items-center rounded-md px-3 py-1.5 text-sm ring-1 ring-red-300 text-red-700 hover:bg-red-50">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                        Nenhum vereador cadastrado. <a href="{{ route('vereadores.create') }}" class="text-indigo-600 hover:underline">Cadastrar agora</a>.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="bg-white px-4 py-3">
            {{ $vereadores->appends(['q' => $q ?? null])->links() }}
        </div>
    </div>
</div>
@endsection
