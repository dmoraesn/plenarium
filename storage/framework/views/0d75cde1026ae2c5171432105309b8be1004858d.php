<?php echo csrf_field(); ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Descrição</label>
        <input type="text" name="descricao" value="<?php echo e(old('descricao', $model->descricao)); ?>" class="mt-1 block w-full rounded border-gray-300" required>
        <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Ordenação</label>
        <input type="number" name="ordenacao" value="<?php echo e(old('ordenacao', $model->ordenacao)); ?>" class="mt-1 block w-full rounded border-gray-300">
        <?php $__errorArgs = ['ordenacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="md:col-span-3">
        <label class="block text-sm font-medium text-gray-700">Observação</label>
        <textarea name="observacao" rows="3" class="mt-1 block w-full rounded border-gray-300"><?php echo e(old('observacao', $model->observacao)); ?></textarea>
        <?php $__errorArgs = ['observacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="md:col-span-3">
        <label class="inline-flex items-center">
            <input type="checkbox" name="ativo" value="1" class="rounded border-gray-300" <?php echo e(old('ativo', $model->ativo) ? 'checked' : ''); ?>>
            <span class="ml-2 text-sm text-gray-700">Ativo</span>
        </label>
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    
    <a href="<?php echo e(route('config.tipos-expediente.index')); ?>" class="px-3 py-2 rounded border border-gray-300 text-gray-700">Cancelar</a>
    <button class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar</button>
</div><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/tipo_expediente/_form.blade.php ENDPATH**/ ?>