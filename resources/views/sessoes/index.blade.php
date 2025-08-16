@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    {{-- Título da Página e Botão de Agendar --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sessões</h1>
        @can('create', \App\Models\Sessao::class)
            <a href="{{ route('sessoes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Agendar nova sessão
            </a>
        @endcan
    </div>

    {{-- Flash Messages --}}
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
            @php
                // Fallback seguro para contagem de presentes
                $presentesCount = $sessaoEmAndamento->presentes_count
                    ?? optional($sessaoEmAndamento->presencas)->where('status','presente')->count()
                    ?? 0;
                $rawEA = strtolower($sessaoEmAndamento->normalized_status ?? (string) $sessaoEmAndamento->status);
            @endphp
            <div class="bg-white rounded-lg shadow-md border border-yellow-300 flex flex-col">
                <div class="p-4 border-b">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Em andamento
                            </span>
                            <h2 class="text-lg font-semibold text-gray-800 mt-1">Sessão {{ $sessaoEmAndamento->numero }}/{{ $sessaoEmAndamento->ano }}</h2>
                            <p class="text-sm text-gray-500">{{ $sessaoEmAndamento->tipo_label ?? $sessaoEmAndamento->tipo }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500">Presença</div>
                            <div class="text-lg font-bold text-gray-900">{{ $presentesCount }} / {{ $totalVereadores }}</div>
                        </div>
                    </div>
                </div>
                <div class="p-4 space-y-4 flex-grow">
                    <!-- Presença -->
                    <div>
                        <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Vereadores Presentes</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($sessaoEmAndamento->presencas as $presenca)
                                @php $nome = $presenca->vereador->nome_parlamentar ?? $presenca->vereador->nome ?? '—'; @endphp
                                <span title="{{ $nome }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">
                                    {{ strtoupper(substr($nome, 0, 2)) }}
                                </span>
                            @empty
                                <p class="text-xs text-gray-500">Nenhum vereador com presença registrada.</p>
                            @endforelse
                        </div>
                    </div>
                    <!-- Ordem do Dia -->
                    <div>
                        <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Ordem do Dia (Prévia)</h3>
                        <ul class="space-y-2">
                            @forelse($sessaoEmAndamento->ordemDoDia as $item)
                                <li class="text-sm text-gray-600 truncate" title="{{ $item->materia->ementa ?? '' }}">
                                    <span class="font-semibold">{{ $item->materia->tipo->sigla ?? 'N/A' }} {{ $item->materia->numero_ano ?? ($item->materia->numero.'/'.$item->materia->ano ?? '') }}</span>
                                    - {{ \Illuminate\Support\Str::limit($item->materia->ementa ?? '', 80) }}
                                </li>
                            @empty
                                <li class="text-sm text-gray-500 italic">Pauta vazia.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-b-lg flex items-center justify-end gap-3">
                    <a href="{{ route('sessoes.ordem.index', $sessaoEmAndamento) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Ver Pauta Completa</a>

                    {{-- Botão novo: Presenças (rota parametrizada) --}}
                    <a href="{{ route('sessoes.presencas.index', $sessaoEmAndamento) }}"
                       class="inline-flex items-center px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                       Presenças
                    </a>

                    @can('update', $sessaoEmAndamento)
                        <form method="POST" action="{{ route('sessoes.close', $sessaoEmAndamento) }}" onsubmit="return confirm('Encerrar a sessão {{ $sessaoEmAndamento->numero }}/{{ $sessaoEmAndamento->ano }}?');">
                            @csrf @method('PUT')
                            <button type="submit" class="px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">Encerrar Sessão</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endif

        <!-- CARD: PRÓXIMA SESSÃO -->
        @if ($proximaSessao)
            @php $rawPS = strtolower($proximaSessao->normalized_status ?? (string) $proximaSessao->status); @endphp
            <div class="bg-white rounded-lg shadow-md border border-gray-200 flex flex-col">
                <div class="p-4 border-b">
                    <div class="flex justify-between items-start">
                        <div>
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Agendada
                            </span>
                            <h2 class="text-lg font-semibold text-gray-800 mt-1">Próxima Sessão</h2>
                            <p class="text-sm text-gray-500">{{ $proximaSessao->tipo_label ?? $proximaSessao->tipo }} - {{ $proximaSessao->numero }}/{{ $proximaSessao->ano }}</p>
                        </div>
                        <div class="text-right">
                           <div class="text-xs text-gray-500">Data</div>
                           <div class="text-lg font-bold text-gray-900">{{ optional($proximaSessao->data)->format('d/m') ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="p-4 flex-grow">
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Ordem do Dia (Prévia)</h3>
                    <ul class="space-y-2">
                        @forelse($proximaSessao->ordemDoDia as $item)
                            <li class="text-sm text-gray-600 truncate" title="{{ $item->materia->ementa ?? '' }}">
                                <span class="font-semibold">{{ $item->materia->tipo->sigla ?? 'N/A' }} {{ $item->materia->numero_ano ?? ($item->materia->numero.'/'.$item->materia->ano ?? '') }}</span>
                                - {{ \Illuminate\Support\Str::limit($item->materia->ementa ?? '', 80) }}
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 italic">Pauta ainda não definida.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="p-4 bg-gray-50 rounded-b-lg flex items-center justify-end gap-3">
                    @can('update', $proximaSessao)
                        <a href="{{ route('sessoes.ordem.index', $proximaSessao) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Gerenciar Pauta</a>
                        <form method="POST" action="{{ route('sessoes.open', $proximaSessao) }}" onsubmit="return confirm('Abrir a sessão {{ $proximaSessao->numero }}/{{ $proximaSessao->ano }} agora?');">
                            @csrf @method('PUT')
                            <button type="submit" class="px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">Abrir Sessão</button>
                        </form>
                    @else
                        <a href="{{ route('sessoes.ordem.index', $proximaSessao) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Ver Pauta</a>
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

    <!-- LISTAGEM PRINCIPAL DE SESSÕES -->
    <h2 class="text-xl font-bold text-gray-900 mb-4">Histórico de Sessões</h2>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
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
                @php
                    $raw = strtolower($sessao->normalized_status ?? (string) $sessao->status);
                    $statusLabel = match ($raw) {
                        'planejada' => 'Agendada',
                        'aberta'    => 'Em andamento',
                        'encerrada' => 'Encerrada',
                        'publicada' => 'Publicada',
                        'rascunho'  => 'Rascunho',
                        default     => ($sessao->status ?? '—'),
                    };
                    $statusClass = match ($raw) {
                        'planejada' => 'bg-blue-100 text-blue-800',
                        'aberta'    => 'bg-yellow-100 text-yellow-800',
                        'encerrada' => 'bg-green-100 text-green-800',
                        'publicada' => 'bg-green-100 text-green-800',
                        default     => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">{{ $sessao->numero }}/{{ $sessao->ano }}</td>
                    <td class="px-4 py-2">{{ $sessao->tipo_label ?? $sessao->tipo }}</td>
                    <td class="px-4 py-2">{{ optional($sessao->data)->format('d/m/Y') ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <div class="inline-flex items-center gap-3">
                            <a href="{{ route('sessoes.ordem.index', $sessao) }}" class="font-semibold text-indigo-600 hover:underline">Ver Pauta</a>

                            @can('update', $sessao)
                                <a href="{{ route('sessoes.ordem.index', $sessao) }}" class="text-indigo-600 hover:underline">Gerenciar</a>

                                @if ($raw === 'planejada')
                                    <form method="POST" action="{{ route('sessoes.open', $sessao) }}" class="inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-green-600 hover:underline">Abrir</button>
                                    </form>
                                @elseif ($raw === 'aberta')
                                    <form method="POST" action="{{ route('sessoes.close', $sessao) }}" class="inline" onsubmit="return confirm('Encerrar a sessão {{ $sessao->numero }}/{{ $sessao->ano }}?');">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-red-600 hover:underline">Encerrar</button>
                                    </form>
                                @endif

                                <a href="{{ route('sessoes.edit', $sessao) }}" class="text-gray-700 hover:underline">Editar</a>
                            @endcan

                            @can('delete', $sessao)
                                <form method="POST" action="{{ route('sessoes.destroy', $sessao) }}" class="inline" onsubmit="return confirm('Confirmar exclusão desta sessão?')">
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
    <div class="mt-4">{{ $sessoes->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
  // Previne duplo clique nos formulários
  document.addEventListener('submit', function (e) {
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
      submitButton.disabled = true;
      submitButton.classList.add('opacity-50', 'cursor-not-allowed');
      submitButton.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        A processar...
      `;
    }
  });
</script>
@endpush
