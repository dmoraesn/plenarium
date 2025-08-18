@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">

    {{-- Cabeçalho com Breadcrumb e Ações --}}
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
        <a href="{{ route('sessoes.index') }}" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
            &larr; Voltar
        </a>
    </div>

    {{-- Título e Status da Sessão --}}
    <h1 class="text-2xl font-semibold mb-1">
        Ordem do Dia — Sessão {{ $sessao->numero }}/{{ $sessao->ano }} ({{ $sessao->tipo_label }})
    </h1>
    <p class="text-sm text-gray-600 mb-6 flex items-center gap-2">
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $sessao->status_class }}">
            Status: {{ $sessao->status_label }}
        </span>
        <span>•</span>
        <span>Data: {{ $sessao->data->format('d/m/Y') }}</span>
    </p>

    {{-- Formulário para Adicionar Matéria --}}
    @can('update', $sessao)
    <div class="bg-white rounded-xl shadow p-4 mb-6 ring-1 ring-gray-200">
        <form method="POST" action="{{ route('sessoes.ordem.store', $sessao) }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
            @csrf
            <label for="materia_id" class="text-sm font-medium text-gray-700">Adicionar matéria:</label>
            <div class="flex-1 min-w-[280px]">
                <select id="materia_id" name="materia_id" required class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- selecione uma matéria --</option>
                    @foreach($materiasDisponiveis ?? [] as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->tipo->sigla ?? 'N/A' }} {{ $m->numero }}/{{ $m->ano }} — {{ \Illuminate\Support\Str::limit($m->ementa, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
                Adicionar à Pauta
            </button>
        </form>
        @error('materia_id')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </div>
    @endcan

    {{-- Cards da Ordem do Dia para Reordenar --}}
    <div class="flex items-center justify-between mt-8 mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Pauta da Sessão</h2>
        @can('update', $sessao)
        <button type="button" id="salvar-reordenacao" class="px-3 py-2 rounded-lg text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 hidden">
            Salvar Reordenação
        </button>
        @endcan
    </div>
    <div id="ordem-pauta-list" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse($itens as $item)
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-4 relative" draggable="true" data-id="{{ $item->id }}">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-500">Posição: <span class="posicao-label text-gray-900">{{ $item->posicao }}</span></span>
                </div>
                <h3 class="text-lg font-bold">
                    {{ $item->materia->tipo->sigla ?? 'N/A' }} {{ $item->materia->numero }}/{{ $item->materia->ano }}
                </h3>
                <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->materia->ementa, 100) }}</p>
                <div class="mt-2 text-sm text-gray-500">
                    <span class="font-medium">Autores:</span> {{ $item->materia->autores->pluck('nome_parlamentar')->implode(', ') }}
                </div>
                
                {{-- Botões de ação na parte inferior do card --}}
                @can('update', $sessao)
                <div class="mt-4 flex flex-col sm:flex-row items-center gap-2 justify-end">
                    {{-- Botão "Detalhes" --}}
                    <a href="{{ route('materias.show', $item->materia) }}" class="px-3 py-1 rounded-lg text-xs bg-gray-200 text-gray-700 hover:bg-gray-300">Detalhes</a>
                    {{-- Botão "Enviar para Votação" --}}
                    <button type="button" 
                            class="px-3 py-1 rounded-lg text-xs bg-indigo-600 text-white hover:bg-indigo-700" 
                            data-id="{{ $item->id }}"
                            data-materia-tipo="{{ $item->materia->tipo->sigla ?? 'N/A' }}"
                            data-materia-numero="{{ $item->materia->numero }}"
                            data-materia-ano="{{ $item->materia->ano }}"
                            data-materia-ementa="{{ $item->materia->ementa }}"
                            data-materia-autores="{{ $item->materia->autores->pluck('nome_parlamentar')->implode(', ') }}"
                            onclick="openVotacaoModal(this)">
                        Enviar para Votação
                    </button>
                    {{-- Botão "Remover" --}}
                    <form method="POST" action="{{ route('sessoes.ordem.destroy', ['sessao' => $sessao, 'item' => $item]) }}" onsubmit="return confirm('Remover este item da pauta?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 rounded-lg text-xs bg-red-600 text-white hover:bg-red-700">Remover</button>
                    </form>
                </div>
                @endcan
            </div>
        @empty
            <div class="md:col-span-3 text-center py-6 text-gray-500">
                Nenhum item na pauta desta sessão.
            </div>
        @endforelse
    </div>

    {{-- Lista de Matérias Votadas --}}
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-900">Matérias Votadas</h2>
        <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 mt-4 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-4 py-2 w-40">Matéria</th>
                        <th class="text-left px-4 py-2">Ementa</th>
                        <th class="text-left px-4 py-2 w-32">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($itens->where('materia.status', '!=', 'pronta_pauta') as $item)
                        <tr class="bg-white">
                            <td class="px-4 py-2">{{ $item->materia->tipo->sigla ?? 'N/A' }} {{ $item->materia->numero }}/{{ $item->materia->ano }}</td>
                            <td class="px-4 py-2 text-gray-800" title="{{ $item->materia->ementa }}">
                                {{ \Illuminate\Support\Str::limit($item->materia->ementa, 120) }}
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $item->materia->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                Nenhuma matéria votada nesta sessão ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Incluir o modal de votação --}}
@include('sessoes.ordem._votar-modal', ['tiposVotacao' => $tiposVotacao, 'sessao' => $sessao])

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pautaList = document.getElementById('ordem-pauta-list');
        const saveOrderBtn = document.getElementById('salvar-reordenacao');

        // Inicializar Sortable.js para reordenação
        const sortable = new Sortable(pautaList, {
            animation: 150,
            ghostClass: 'bg-indigo-100',
            onEnd: function (evt) {
                updatePositions();
                saveOrderBtn.classList.remove('hidden');
            }
        });

        // Atualizar as posições dos itens
        function updatePositions() {
            let itens = [];
            pautaList.querySelectorAll('div[data-id]').forEach((row, index) => {
                const id = row.dataset.id;
                const newPosition = index + 1;
                
                row.querySelector('.posicao-label').textContent = newPosition;
                
                itens.push({
                    ordem_item_id: id,
                    posicao: newPosition
                });
            });
            // TODO: Enviar a requisição PATCH para salvar a nova ordem no backend
            // const url = "{{ route('sessoes.ordem.reorder', ['sessao' => $sessao]) }}";
            // fetch(url, {
            //     method: 'PATCH',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: JSON.stringify({ itens: itens })
            // }).then(response => response.json()).then(data => {
            //     if (data.success) {
            //         console.log('Reordenação salva com sucesso!');
            //         saveOrderBtn.classList.add('hidden');
            //     }
            // });
        }

        // Salvar a reordenação quando o botão é clicado
        saveOrderBtn.addEventListener('click', function() {
            // TODO: Implementar o envio da requisição PATCH
            alert('Lógica de salvamento de reordenação a ser implementada.');
            saveOrderBtn.classList.add('hidden');
        });
    });

    // Lógica para o modal de votação (único item)
    function openVotacaoModal(button) {
        const modal = document.getElementById('votacao-modal');
        const itemId = button.dataset.id;
        const materiaTipo = button.dataset.materiaTipo;
        const materiaNumero = button.dataset.materiaNumero;
        const materiaAno = button.dataset.materiaAno;
        const materiaEmenta = button.dataset.materiaEmenta;
        const autores = button.dataset.materiaAutores;

        document.getElementById('materia-tipo').textContent = materiaTipo;
        document.getElementById('materia-numero-ano').textContent = `${materiaNumero}/${materiaAno}`;
        document.getElementById('materia-ementa').textContent = materiaEmenta;
        document.getElementById('materia-autores').textContent = autores || 'N/A';
        document.getElementById('materia-status').textContent = 'Em Pauta'; // TODO: Buscar o status real se necessário

        // Popula o dropdown de tipos de votação
        const tiposVotacaoSelect = document.getElementById('criterio_votacao');
        // Limpar opções antigas
        tiposVotacaoSelect.innerHTML = '';
        
        // Adicionar opções do PHP
        @foreach ($tiposVotacao as $tipo)
            const option = document.createElement('option');
            option.value = "{{ $tipo->id }}";
            option.textContent = "{{ $tipo->descricao }}";
            if ("{{ $tipo->descricao }}" === "Maioria Simples") {
                option.selected = true;
            }
            tiposVotacaoSelect.appendChild(option);
        @endforeach

        // Atualizar o action do formulário para o item correto
        const formVotacao = document.getElementById('form-votacao');
        const votacaoUrl = "{{ route('sessoes.ordem.votar', ['sessao' => $sessao, 'item' => ':id']) }}";
        formVotacao.setAttribute('action', votacaoUrl.replace(':id', itemId));

        const formRetirar = document.getElementById('form-retirar');
        const retirarUrl = "{{ route('sessoes.ordem.retirar', ['sessao' => $sessao, 'item' => ':id']) }}";
        formRetirar.setAttribute('action', retirarUrl.replace(':id', itemId));
        
        // Exibir o modal
        modal.classList.remove('hidden');
    }

    // Função para abrir o modal de justificativa
    function openRetirarModal() {
        const votacaoModal = document.getElementById('votacao-modal');
        const retirarModal = document.getElementById('retirar-modal');
        votacaoModal.classList.add('hidden');
        retirarModal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('votacao-modal').classList.add('hidden');
        document.getElementById('retirar-modal').classList.add('hidden');
    }

    document.getElementById('close-votacao-modal').addEventListener('click', closeModal);
    // TODO: Adicionar um ID 'close-retirar-modal' ao botão de fechar do modal de retirada
</script>
@endpush
