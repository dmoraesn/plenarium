<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800">Tipos de Votação</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="<?php echo e(route('config.tipos-votacao.create')); ?>"
                   class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
                    Adicionar Novo
                </a>
            </div>

            
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Critério</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $tiposVotacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <strong><?php echo e($tipo->nome); ?></strong><br>
                                    <span class="text-gray-500 text-sm"><?php echo e($tipo->descricao); ?></span>
                                </td>
                                <td class="px-6 py-4"><?php echo e(ucfirst(str_replace('_',' ',$tipo->criterio))); ?></td>

                                
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($tipo->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700'); ?>">
                                        <?php echo e($tipo->ativo ? 'Ativo' : 'Inativo'); ?>

                                    </span>
                                </td>

                                
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        
                                        <a href="<?php echo e(route('config.tipos-votacao.edit', $tipo)); ?>" class="px-3 py-1 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 text-sm font-medium">Editar</a>

                                        
                                        <form method="POST" action="<?php echo e(route('config.tipos-votacao.toggle', $tipo)); ?>" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <?php if($tipo->ativo): ?>
                                                <button type="submit" class="px-3 py-1 rounded-lg bg-yellow-400 text-yellow-800 hover:bg-yellow-500 text-sm font-medium">Desativar</button>
                                            <?php else: ?>
                                                <button type="submit" class="px-3 py-1 rounded-lg bg-green-400 text-green-800 hover:bg-green-500 text-sm font-medium">Ativar</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Nenhum tipo de votação encontrado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($tiposVotacao->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($tiposVotacao->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\plenarium\resources\views/tipos_votacao/index.blade.php ENDPATH**/ ?>