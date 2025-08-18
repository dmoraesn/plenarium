<?php echo csrf_field(); ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
        <input type="number" name="numero" id="numero" value="<?php echo e(old('numero', $model->numero)); ?>"
               class="mt-1 block w-full rounded border-gray-300">
        <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label for="data_eleicao" class="block text-sm font-medium text-gray-700">Data da eleição</label>
        <input type="date" name="data_eleicao" id="data_eleicao" value="<?php echo e(old('data_eleicao', optional($model->data_eleicao)->format('Y-m-d'))); ?>"
               class="mt-1 block w-full rounded border-gray-300">
        <?php $__errorArgs = ['data_eleicao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-gray-700">Ativa</label>
        <label class="inline-flex items-center mt-2">
            <input type="checkbox" name="ativo" value="1" class="rounded border-gray-300" <?php echo e(old('ativo', $model->ativo) ? 'checked' : ''); ?>>
            <span class="ml-2 text-sm text-gray-700">Legislatura em vigor</span>
        </label>
        <?php $__errorArgs = ['ativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="data_inicio" class="block text-sm font-medium text-gray-700">Início</label>
        <input type="date" name="data_inicio" id="data_inicio" value="<?php echo e(old('data_inicio', optional($model->data_inicio)->format('Y-m-d'))); ?>"
               class="mt-1 block w-full rounded border-gray-300" required>
        <?php $__errorArgs = ['data_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="data_fim" class="block text-sm font-medium text-gray-700">Fim</label>
        <input type="date" name="data_fim" id="data_fim" value="<?php echo e(old('data_fim', optional($model->data_fim)->format('Y-m-d'))); ?>"
               class="mt-1 block w-full rounded border-gray-300" required>
        <?php $__errorArgs = ['data_fim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="md:col-span-3">
        <label for="observacao" class="block text-sm font-medium text-gray-700">Observação</label>
        <textarea name="observacao" id="observacao" rows="3" class="mt-1 block w-full rounded border-gray-300"><?php echo e(old('observacao', $model->observacao)); ?></textarea>
        <?php $__errorArgs = ['observacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="<?php echo e(route('config.legislaturas.index')); ?>" class="px-3 py-2 rounded border border-gray-300 text-gray-700">Cancelar</a>
    <button class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar</button>
</div>
<?php /**PATH C:\xampp\htdocs\plenarium\resources\views/legislaturas/_form.blade.php ENDPATH**/ ?>