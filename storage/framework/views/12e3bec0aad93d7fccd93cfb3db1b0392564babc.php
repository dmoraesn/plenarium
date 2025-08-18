

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Novo Tipo de Expediente</h1>
    <div class="bg-white rounded shadow p-6">
        <form method="POST" action="<?php echo e(route('config.tipos-expediente.store')); ?>">
            
            <?php echo $__env->make('tipo_expediente._form', ['model' => new App\Models\TipoExpediente()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/tipo_expediente/create.blade.php ENDPATH**/ ?>