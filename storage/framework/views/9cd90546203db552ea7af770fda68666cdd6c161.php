
<form method="POST"
      action="<?php echo e($model->exists
                ? route('config.tipos-materia.update', $model)
                : route('config.tipos-materia.store')); ?>">
    <?php echo csrf_field(); ?>

    <?php if($model->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="space-y-6">
        <div>
            <label for="sigla" class="block text-sm font-medium text-gray-700">Sigla</label>
            <input type="text" name="sigla" id="sigla"
                   value="<?php echo e(old('sigla', $model->sigla ?? '')); ?>"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <?php $__errorArgs = ['sigla'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="nome" id="nome"
                   value="<?php echo e(old('nome', $model->nome ?? '')); ?>"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="ativo" id="ativo" value="1"
                   <?php echo e(old('ativo', $model->ativo ?? true) ? 'checked' : ''); ?>

                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
            <label for="ativo" class="ml-2 block text-sm text-gray-700">Ativo</label>
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <a href="<?php echo e(route('config.tipos-materia.index')); ?>"
           class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg shadow mr-2">
            Cancelar
        </a>
        <button type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
            <?php echo e($model->exists ? 'Atualizar' : 'Salvar'); ?>

        </button>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\plenarium\resources\views/tipos_materia/_form.blade.php ENDPATH**/ ?>