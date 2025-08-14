@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    {{-- Título da Página --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sessões</h1>
        @can('create', \App\Models\Sessao::class)
            <a href="{{ route('sessoes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Agendar nova sessão
            </a>
        @endcan
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-3"><p class="text-sm font-medium text-green-800">{{ session('success') }}</p></div>
            </div>
        </div>
    @endif

    {{-- Grid para os cards de resumo --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <!-- CARD: SESSÃO EM ANDAMENTO -->
        @if ($sessaoEmAndamento)
            <div class="bg-white rounded-lg shadow-md border border-yellow-300">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">Sessão em Andamento</h2>
                    <p class="text-sm text-gray-500">{{ $sessaoEmAndamento->tipo_label }} - {{ $sessaoEmAndamento->numero }}/{{ $sessaoEmAndamento->ano }}</p>
                </div>
                <div class="p-4">
                    <!-- Presença -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-sm font-medium text-gray-700">Presença</h3>
                            <span class="text-sm font-bold text-gray-900">{{ $sessaoEmAndamento->presencas_count }} / {{ $totalVereadores }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @forelse($sessaoEmAndamento->presencas as $presenca)
                                <span title="{{ $presenca->vereador->nome_parlamentar }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">
                                    {{-- TODO: Adicionar lógica para foto do vereador --}}
                                    {{ strtoupper(substr($presenca->vereador->nome_parlamentar, 0, 2)) }}
                                </span>
                            @empty
                                <p class="text-xs text-gray-500">Nenhum vereador com presença registrada.</p>
                            @endforelse
                        </div>
                    </div>
                    <!-- Ordem do Dia -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Ordem do Dia (Prévia)</h3>
                        <ul class="space-y-2">
                            @forelse($sessaoEmAndamento->ordemDoDia as $item)
                                <li class="text-xs text-gray-600 truncate">
                                    <span class="font-bold">{{ $item->materia->tipo->sigla }} {{ $item->materia->numero_ano }}</span> - {{ $item->materia->ementa }}
                                </li>
                            @empty
                                <li class="text-xs text-gray-500">Pauta vazia.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-b-lg flex items-center justify-end gap-3">
                    <a href="{{ route('sessoes.ordem.index', $sessaoEmAndamento) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Ver Pauta Completa</a>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Ver Presenças</a>
                    @can('update', $sessaoEmAndamento)
                        <form method="POST" action="{{ route('sessoes.encerrar', $sessaoEmAndamento) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">Encerrar Sessão</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endif

        <!-- CARD: PRÓXIMA SESSÃO -->
        @if ($proximaSessao)
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">Próxima Sessão Agendada</h2>
                    <p class="text-sm text-gray-500">{{ $proximaSessao->tipo_label }} - {{ $proximaSessao->numero }}/{{ $proximaSessao->ano }}</p>
                </div>
                <div class="p-4">
                    <p class="text-sm text-gray-600 mb-4">Data: <span class="font-bold">{{ $proximaSessao->data->format('d/m/Y') }}</span></p>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Ordem do Dia (Prévia)</h3>
                    <ul class="space-y-2">
                        @forelse($proximaSessao->ordemDoDia as $item)
                            <li class="text-xs text-gray-600 truncate">
                                <span class="font-bold">{{ $item->materia->tipo->sigla }} {{ $item->materia->numero_ano }}</span> - {{ $item->materia->ementa }}
                            </li>
                        @empty
                            <li class="text-xs text-gray-500">Pauta ainda não definida.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="p-4 bg-gray-50 rounded-b-lg flex items-center justify-end gap-3">
                    <a href="{{ route('sessoes.ordem.index', $proximaSessao) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Gerenciar Pauta</a>
                    @can('update', $proximaSessao)
                        <form method="POST" action="{{ route('sessoes.abrir', $proximaSessao) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">Abrir Sessão</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endif
    </div>

    {{-- Mensagem de estado vazio para os cards --}}
    @if (!$sessaoEmAndamento && !$proximaSessao)
        <div class="text-center bg-gray-50 rounded-lg p-8 mb-8">
            <h3 class="text-sm font-medium text-gray-900">Nenhuma sessão em andamento ou agendada</h3>
            <p class="mt-1 text-sm text-gray-500">Quando uma sessão for aberta ou agendada, ela aparecerá aqui.</p>
        </div>
    @endif

    <!-- LISTAGEM PRINCIPAL DE SESSÕES (INALTERADA) -->
    <h2 class="text-xl font-bold text-gray-900 mb-4">Histórico de Sessões</h2>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            {{-- O conteúdo da sua tabela de listagem existente entra aqui... --}}
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="text-left px-4 py-2">Sessão</th>
                    <th class="text-left px-4 py-2">Tipo</th>
                    <th class="text-left px-4 py-2">Data</th>
                    <th class="text-left px-4 py-2 w-32">Status</th>
                    <th class="text-right px-4 py-2 w-52">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($sessoes as $sessao)
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">{{ $sessao->numero }}/{{ $sessao->ano }}</td>
                    <td class="px-4 py-2">{{ $sessao->tipo_label }}</td>
                    <td class="px-4 py-2">{{ $sessao->data->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $sessao->status_class }}">
                            {{ $sessao->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <div class="inline-flex items-center gap-3">
                            <a href="{{ route('sessoes.ordem.index', $sessao) }}" class="font-semibold text-indigo-600 hover:underline">Ver Pauta</a>
                            @can('update', $sessao)
                                <a href="{{ route('sessoes.edit', $sessao) }}" class="text-gray-700 hover:underline">Editar</a>
                            @endcan
                            @can('delete', $sessao)
                                <form method="POST" action="{{ route('sessoes.destroy', $sessao) }}" onsubmit="return confirm('Confirmar exclusão desta sessão?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Nenhuma sessão encontrada no histórico.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $sessoes->links() }}
    </div>
</div>
@endsection
