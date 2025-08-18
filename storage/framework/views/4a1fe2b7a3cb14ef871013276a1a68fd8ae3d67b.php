

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Nova matéria</h1>
        <a href="<?php echo e(route('materias.index')); ?>" class="inline-flex items-center px-3 py-2 rounded-lg ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">Voltar</a>
    </div>

    <?php echo $__env->make('materias._form', [
        'materia' => $materia,
        'tipos'   => $tipos,
        'autores' => $autores,
        'action'  => route('materias.store'),
        'isEdit'  => false,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/materias/create.blade.php ENDPATH**/ ?>