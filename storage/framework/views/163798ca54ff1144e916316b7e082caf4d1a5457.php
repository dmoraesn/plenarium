

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Novo Partido</h1>
        <a href="<?php echo e(route('config.partidos.index')); ?>" class="text-sm text-indigo-600">Voltar para a lista</a>
    </div>
    <div class="bg-white rounded shadow p-6">
        
        <?php echo $__env->make('partidos._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/partidos/create.blade.php ENDPATH**/ ?>