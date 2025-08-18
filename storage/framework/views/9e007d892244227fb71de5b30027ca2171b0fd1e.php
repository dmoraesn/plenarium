

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Cargos da Mesa Diretora</h1>
        
        <a href="<?php echo e(route('config.cargos-mesa.create')); ?>" class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Novo Cargo</a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 px-4 py-3">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

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
                <?php $__empty_1 = true; $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-2"><?php echo e($i->descricao); ?></td>
                        <td class="px-4 py-2"><?php echo e($i->posicao_ordenacao ?? '—'); ?></td>
                        <td class="px-4 py-2"><?php echo e($i->cargo_unico ? 'Sim' : 'Não'); ?></td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs <?php echo e($i->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e($i->ativo ? 'Sim' : 'Não'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex gap-2">
                                
                                <a href="<?php echo e(route('config.cargos-mesa.edit', $i)); ?>" class="px-3 py-1 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm">Editar</a>
                                
                                <form method="POST" action="<?php echo e(route('config.cargos-mesa.destroy', $i)); ?>" onsubmit="return confirm('Remover este cargo?');">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhum cargo cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($itens->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/cargo_mesa/index.blade.php ENDPATH**/ ?>