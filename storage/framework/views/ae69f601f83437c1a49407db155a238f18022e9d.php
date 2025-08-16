

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
                            <?php echo e($m->tipo->sigla ?? 'N/A'); ?>/<?php echo e($m->numero); ?>/<?php echo e($m->ano); ?> — <?php echo e(\Illuminate\Support\Str::limit($m->ementa, 80)); ?>

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

    
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-4 py-2 w-16">Pos.</th>
                    <th class="text-left px-4 py-2 w-40">Matéria</th>
                    <th class="text-left px-4 py-2">Ementa</th>
                    <th class="text-right px-4 py-2 w-32">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="bg-white">
                    <td class="px-4 py-2 font-medium"><?php echo e($item->posicao); ?></td>
                    <td class="px-4 py-2"><?php echo e($item->materia->tipo->sigla ?? 'N/A'); ?> <?php echo e($item->materia->numero); ?>/<?php echo e($item->materia->ano); ?></td>
                    <td class="px-4 py-2 text-gray-800" title="<?php echo e($item->materia->ementa); ?>">
                        <?php echo e(\Illuminate\Support\Str::limit($item->materia->ementa, 120)); ?>

                    </td>
                    <td class="px-4 py-2 text-right">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $sessao)): ?>
                        <form method="POST" action="<?php echo e(route('sessoes.ordem.destroy', ['sessao' => $sessao, 'item' => $item])); ?>" onsubmit="return confirm('Remover este item da pauta?')" class="inline-block">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline text-xs">Remover</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                        Nenhum item na pauta desta sessão.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/sessoes/ordem/index.blade.php ENDPATH**/ ?>