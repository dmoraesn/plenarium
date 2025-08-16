

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Normas Jurídicas</h1>
        <a href="<?php echo e(route('config.normas.create')); ?>" class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Nova Norma</a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 px-4 py-3">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-4 rounded border border-red-300 bg-red-50 text-red-800 px-4 py-3">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <form method="GET" class="mb-4">
        <div class="bg-white rounded shadow p-4 grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" class="mt-1 block w-full rounded border-gray-300">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->id); ?>" <?php if(request('tipo') == $t->id): echo 'selected'; endif; ?>><?php echo e($t->descricao); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Ano</label>
                <input type="number" name="ano" value="<?php echo e(request('ano')); ?>" class="mt-1 block w-full rounded border-gray-300">
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
                <?php $__empty_1 = true; $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-2"><?php echo e($n->tipoNorma->descricao ?? '—'); ?></td>
                        <td class="px-4 py-2"><?php echo e($n->numero); ?>/<?php echo e($n->ano); ?></td>
                        <td class="px-4 py-2"><?php echo e(\Illuminate\Support\Str::limit($n->ementa, 60)); ?></td>
                        <td class="px-4 py-2"><?php echo e(optional($n->data_publicacao)->format('d/m/Y') ?? '—'); ?></td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex gap-2">
                                <a href="<?php echo e(route('config.normas.edit', $n)); ?>" class="px-3 py-1 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm">Editar</a>
                                <form method="POST" action="<?php echo e(route('config.normas.destroy', $n)); ?>" onsubmit="return confirm('Remover esta norma?');">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhuma norma cadastrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($itens->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/normas/index.blade.php ENDPATH**/ ?>