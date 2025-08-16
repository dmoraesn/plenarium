

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-8 px-4">
    <?php if(session('success')): ?>
        <div class="mb-4 rounded bg-green-50 text-green-700 px-4 py-2">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Matérias</h1>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Materia::class)): ?>
            <a href="<?php echo e(route('materias.create')); ?>" class="inline-flex items-center px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                Nova matéria
            </a>
        <?php endif; ?>
    </div>

    
    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="<?php echo e($q); ?>" placeholder="Buscar por ementa / número / ano" class="rounded-md border-gray-300">

        <select name="tipo" class="rounded-md border-gray-300">
            <option value="">Tipo (todos)</option>
            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $sigla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($id); ?>" <?php if($tipoId == $id): echo 'selected'; endif; ?>><?php echo e($sigla); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="status" class="rounded-md border-gray-300">
            <option value="">Status (todos)</option>
            <?php $__currentLoopData = \App\Models\Materia::STATUS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($st); ?>" <?php if($status === $st): echo 'selected'; endif; ?>><?php echo e(ucfirst(str_replace('_',' ', $st))); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button class="rounded-md bg-gray-800 text-white px-3 py-2 hover:bg-gray-900">Filtrar</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600">
                    <th class="text-left px-4 py-2 w-28">Tipo</th>
                    <th class="text-left px-4 py-2 w-28">Número/Ano</th>
                    <th class="text-left px-4 py-2">Ementa</th>
                    <th class="text-left px-4 py-2 w-40">Autores</th>
                    <th class="text-left px-4 py-2 w-32">Status</th>
                    <th class="text-right px-4 py-2 w-44">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t">
                    <td class="px-4 py-2"><?php echo e($m->tipo->sigla ?? '-'); ?></td>
                    <td class="px-4 py-2"><?php echo e($m->numero); ?>/<?php echo e($m->ano); ?></td>
                    
                    
                    
                    <td class="px-4 py-2 ementa-truncada" title="<?php echo e($m->ementa); ?>">
                        <?php echo e($m->ementa); ?>

                    </td>
                    
                    <td class="px-4 py-2">
                        <?php if($m->autores->isEmpty()): ?>
                            <span class="text-gray-400">—</span>
                        <?php else: ?>
                            <?php echo e($m->autores->pluck('nome_parlamentar')->join(', ')); ?>

                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs
                            <?php if($m->status === 'pronta_pauta'): ?> bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200
                            <?php elseif($m->status === 'arquivada'): ?> bg-gray-100 text-gray-600 ring-1 ring-gray-200
                            <?php else: ?> bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200 <?php endif; ?>">
                            <?php echo e(ucfirst(str_replace('_',' ', $m->status))); ?>

                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <div class="inline-flex items-center gap-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $m)): ?>
                                <a href="<?php echo e(route('materias.edit', $m)); ?>" class="text-indigo-600 hover:underline">Editar</a>
                            <?php endif; ?>

                            
                            

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $m)): ?>
                                <form method="POST" action="<?php echo e(route('materias.destroy', $m)); ?>" class="inline-block" onsubmit="return confirm('Remover esta matéria?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Nenhuma matéria encontrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($materias->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/materias/index.blade.php ENDPATH**/ ?>