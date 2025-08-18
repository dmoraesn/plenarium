
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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tipos de Matéria
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            
            <div class="flex justify-end mb-4">
                <a href="<?php echo e(route('config.tipos-materia.create')); ?>"
                   class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg shadow-md transition-colors duration-200">
                    Novo Tipo de Matéria
                </a>
            </div>

            
            <div class="bg-white shadow-md rounded-lg p-4 sm:p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-4 py-3 font-medium text-gray-600">Sigla</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Nome</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Status</th>
                            <th class="px-4 py-3 font-medium text-gray-600 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tiposMateria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2"><?php echo e($tipo->sigla); ?></td>
                                <td class="px-4 py-2"><?php echo e($tipo->nome); ?></td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($tipo->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($tipo->ativo ? 'Ativo' : 'Inativo'); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a href="<?php echo e(route('config.tipos-materia.edit', $tipo)); ?>"
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    <form action="<?php echo e(route('config.tipos-materia.destroy', $tipo)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este tipo de matéria?')"
                                                class="text-red-600 hover:text-red-900">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                                    Nenhum tipo de matéria encontrado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                
                <div class="mt-4">
                   <?php echo e($tiposMateria->links()); ?>

                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\plenarium\resources\views/tipos_materia/index.blade.php ENDPATH**/ ?>