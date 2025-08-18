<?php
    $isEdit = $isEdit ?? false;
?>

<form method="POST" action="<?php echo e($action); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
            <select name="tipo_materia_id" class="w-full rounded-md border-gray-300" required>
                <option value="">-- selecione --</option>
                <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $sigla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($id); ?>" <?php if(old('tipo_materia_id', $materia->tipo_materia_id) == $id): echo 'selected'; endif; ?>><?php echo e($sigla); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['tipo_materia_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Número</label>
            <input type="number" name="numero" value="<?php echo e(old('numero', $materia->numero)); ?>" class="w-full rounded-md border-gray-300" required>
            <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
            <input type="number" name="ano" value="<?php echo e(old('ano', $materia->ano ?? now()->year)); ?>" class="w-full rounded-md border-gray-300" required>
            <?php $__errorArgs = ['ano'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Ementa</label>
        <textarea name="ementa" rows="4" class="w-full rounded-md border-gray-300" required><?php echo e(old('ementa', $materia->ementa)); ?></textarea>
        <?php $__errorArgs = ['ementa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Autores (opcional)</label>
        <select name="autores[]" multiple class="w-full rounded-md border-gray-300">
            <?php $__currentLoopData = $autores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($id); ?>"
                    <?php if( in_array($id, old('autores', isset($materia) ? $materia->autores->pluck('id')->all() : [])) ): echo 'selected'; endif; ?>>
                    <?php echo e($nome); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['autores.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-md border-gray-300" required>
                <?php $__currentLoopData = \App\Models\Materia::STATUS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($st); ?>" <?php if(old('status', $materia->status) === $st): echo 'selected'; endif; ?>>
                        <?php echo e(ucfirst(str_replace('_',' ', $st))); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex items-center">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="ativo" value="1" <?php if(old('ativo', $materia->ativo)): echo 'checked'; endif; ?>>
                <span class="text-sm text-gray-700">Ativo</span>
            </label>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
            <?php echo e($isEdit ? 'Salvar alterações' : 'Cadastrar'); ?>

        </button>

        <a href="<?php echo e(route('materias.index')); ?>" class="inline-flex items-center px-4 py-2 rounded-lg ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
            Cancelar
        </a>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\plenarium\resources\views/materias/_form.blade.php ENDPATH**/ ?>