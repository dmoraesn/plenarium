

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8 px-4">

    
    <div class="flex items-center justify-between mb-4">
        <nav aria-label="breadcrumb" class="text-sm text-gray-500">
            <ol class="flex items-center gap-2">
                <li><a href="<?php echo e(route('dashboard')); ?>" class="hover:text-gray-700">Dashboard</a></li>
                <li>/</li>
                <li><a href="<?php echo e(route('sessoes.index')); ?>" class="hover:text-gray-700">Sessões</a></li>
                <li>/</li>
                <li class="text-gray-700 font-medium">Ordem do Dia</li>
            </ol>
        </nav>
        <a href="<?php echo e(route('sessoes.index')); ?>" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
            &larr; Voltar
        </a>
    </div>

    
    <h1 class="text-2xl font-semibold mb-1">
        Ordem do Dia — Sessão <?php echo e($sessao->numero); ?>/<?php echo e($sessao->ano); ?> (<?php echo e($sessao->tipo_label); ?>)
    </h1>
    <p class="text-sm text-gray-600 mb-6 flex items-center gap-2">
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($sessao->status_class); ?>">
            Status: <?php echo e($sessao->status_label); ?>

        </span>
        <span>•</span>
        <span>Data: <?php echo e($sessao->data->format('d/m/Y')); ?></span>
    </p>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $sessao)): ?>
    <div class="bg-white rounded-xl shadow p-4 mb-6 ring-1 ring-gray-200">
        <form method="POST" action="<?php echo e(route('sessoes.ordem.store', $sessao)); ?>" class="flex flex-col sm:flex-row sm:items-center gap-3">
            <?php echo csrf_field(); ?>
            <label for="materia_id" class="text-sm font-medium text-gray-700">Adicionar matéria:</label>
            <div class="flex-1 min-w-[280px]">
                <select id="materia_id" name="materia_id" required class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- selecione uma matéria --</option>
                    <?php $__currentLoopData = $materiasDisponiveis ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($m->id); ?>">
                            <?php echo e($m->tipo->sigla ?? 'N/A'); ?> <?php echo e($m->numero); ?>/<?php echo e($m->ano); ?> — <?php echo e(\Illuminate\Support\Str::limit($m->ementa, 80)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
                Adicionar à Pauta
            </button>
        </form>
        <?php $__errorArgs = ['materia_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <?php endif; ?>

    
    <div class="flex items-center justify-between mt-8 mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Pauta da Sessão</h2>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $sessao)): ?>
        <button type="button" id="salvar-reordenacao" class="px-3 py-2 rounded-lg text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 hidden">
            Salvar Reordenação
        </button>
        <?php endif; ?>
    </div>
    <div id="ordem-pauta-list" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-4 relative" draggable="true" data-id="<?php echo e($item->id); ?>">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-500">Posição: <span class="posicao-label text-gray-900"><?php echo e($item->posicao); ?></span></span>
                </div>
                <h3 class="text-lg font-bold">
                    <?php echo e($item->materia->tipo->sigla ?? 'N/A'); ?> <?php echo e($item->materia->numero); ?>/<?php echo e($item->materia->ano); ?>

                </h3>
                <p class="text-sm text-gray-600"><?php echo e(\Illuminate\Support\Str::limit($item->materia->ementa, 100)); ?></p>
                <div class="mt-2 text-sm text-gray-500">
                    <span class="font-medium">Autores:</span> <?php echo e($item->materia->autores->pluck('nome_parlamentar')->implode(', ')); ?>

                </div>
                
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $sessao)): ?>
                <div class="mt-4 flex flex-col sm:flex-row items-center gap-2 justify-end">
                    
                    <a href="<?php echo e(route('materias.show', $item->materia)); ?>" class="px-3 py-1 rounded-lg text-xs bg-gray-200 text-gray-700 hover:bg-gray-300">Detalhes</a>
                    
                    <button type="button" 
                            class="px-3 py-1 rounded-lg text-xs bg-indigo-600 text-white hover:bg-indigo-700" 
                            data-id="<?php echo e($item->id); ?>"
                            data-materia-tipo="<?php echo e($item->materia->tipo->sigla ?? 'N/A'); ?>"
                            data-materia-numero="<?php echo e($item->materia->numero); ?>"
                            data-materia-ano="<?php echo e($item->materia->ano); ?>"
                            data-materia-ementa="<?php echo e($item->materia->ementa); ?>"
                            data-materia-autores="<?php echo e($item->materia->autores->pluck('nome_parlamentar')->implode(', ')); ?>"
                            onclick="openVotacaoModal(this)">
                        Enviar para Votação
                    </button>
                    
                    <form method="POST" action="<?php echo e(route('sessoes.ordem.destroy', ['sessao' => $sessao, 'item' => $item])); ?>" onsubmit="return confirm('Remover este item da pauta?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="px-3 py-1 rounded-lg text-xs bg-red-600 text-white hover:bg-red-700">Remover</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="md:col-span-3 text-center py-6 text-gray-500">
                Nenhum item na pauta desta sessão.
            </div>
        <?php endif; ?>
    </div>

    
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
                    <?php $__empty_1 = true; $__currentLoopData = $itens->where('materia.status', '!=', 'pronta_pauta'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="bg-white">
                            <td class="px-4 py-2"><?php echo e($item->materia->tipo->sigla ?? 'N/A'); ?> <?php echo e($item->materia->numero); ?>/<?php echo e($item->materia->ano); ?></td>
                            <td class="px-4 py-2 text-gray-800" title="<?php echo e($item->materia->ementa); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($item->materia->ementa, 120)); ?>

                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <?php echo e($item->materia->status_label); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                Nenhuma matéria votada nesta sessão ainda.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php echo $__env->make('sessoes.ordem._votar-modal', ['tiposVotacao' => $tiposVotacao, 'sessao' => $sessao], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
            // const url = "<?php echo e(route('sessoes.ordem.reorder', ['sessao' => $sessao])); ?>";
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
        <?php $__currentLoopData = $tiposVotacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            const option = document.createElement('option');
            option.value = "<?php echo e($tipo->id); ?>";
            option.textContent = "<?php echo e($tipo->descricao); ?>";
            if ("<?php echo e($tipo->descricao); ?>" === "Maioria Simples") {
                option.selected = true;
            }
            tiposVotacaoSelect.appendChild(option);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        // Atualizar o action do formulário para o item correto
        const formVotacao = document.getElementById('form-votacao');
        const votacaoUrl = "<?php echo e(route('sessoes.ordem.votar', ['sessao' => $sessao, 'item' => ':id'])); ?>";
        formVotacao.setAttribute('action', votacaoUrl.replace(':id', itemId));

        const formRetirar = document.getElementById('form-retirar');
        const retirarUrl = "<?php echo e(route('sessoes.ordem.retirar', ['sessao' => $sessao, 'item' => ':id'])); ?>";
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/sessoes/ordem/index.blade.php ENDPATH**/ ?>