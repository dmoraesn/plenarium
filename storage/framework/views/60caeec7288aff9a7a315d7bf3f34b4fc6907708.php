<?php
    /** @var \App\Models\Vereador $vereador */
    // props esperadas: $action (string), $isEdit (bool), $partidos (id=>sigla)
?>

<form
    x-data="vereadorForm({
        nome_parlamentar: <?php echo \Illuminate\Support\Js::from(old('nome_parlamentar', $vereador->nome_parlamentar))->toHtml() ?>,
        nome_completo:    <?php echo \Illuminate\Support\Js::from(old('nome_completo',    $vereador->nome_completo))->toHtml() ?>,
        partido_id:       <?php echo \Illuminate\Support\Js::from(old('partido_id',       $vereador->partido_id))->toHtml() ?>,
        ativo:            <?php echo \Illuminate\Support\Js::from(old('ativo',            $vereador->ativo ? 1 : 0))->toHtml() ?>,
        fotoUrl:          <?php echo \Illuminate\Support\Js::from($vereador->foto ? Storage::url($vereador->foto) : null)->toHtml() ?>,
    })"
    x-ref="form"
    method="POST"
    action="<?php echo e($action ?? route('vereadores.store')); ?>"
    enctype="multipart/form-data"
    @submit.prevent="if (validate()) $refs.form.submit()"
    class="grid grid-cols-1 lg:grid-cols-3 gap-6"
>
    <?php echo csrf_field(); ?>
    <?php if(!empty($isEdit) && $isEdit): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    
    <div class="bg-white rounded-lg shadow p-4 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Nome parlamentar
                <span class="ml-1 inline-flex items-center text-xs text-gray-400" title="Nome de uso público nas sessões, placas e site (ex.: 'Professora Sônia', 'Dr. José').">?</span>
            </label>
            <input type="text" name="nome_parlamentar" x-model="form.nome_parlamentar"
                   @input="touch('nome_parlamentar')"
                   :class="inputClass('nome_parlamentar')"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <p x-show="errors.nome_parlamentar" x-text="errors.nome_parlamentar" class="mt-1 text-sm text-red-600"></p>
            <?php $__errorArgs = ['nome_parlamentar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nome completo</label>
            <input type="text" name="nome_completo" x-model="form.nome_completo"
                   @input="touch('nome_completo')"
                   :class="inputClass('nome_completo')"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <p x-show="errors.nome_completo" x-text="errors.nome_completo" class="mt-1 text-sm text-red-600"></p>
            <?php $__errorArgs = ['nome_completo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Partido</label>
            <select name="partido_id" x-model="form.partido_id"
                    :class="inputClass('partido_id')"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">— selecione —</option>
                <?php $__currentLoopData = $partidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $sigla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($id); ?>"><?php echo e($sigla); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <p x-show="errors.partido_id" x-text="errors.partido_id" class="mt-1 text-sm text-red-600"></p>
            <?php $__errorArgs = ['partido_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow p-4 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Foto</label>
            <input type="file" name="foto" accept="image/*"
                   @change="preview($event)"
                   class="mt-1 block w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <template x-if="form.fotoUrl">
            <div class="space-y-2">
                <p class="text-sm text-gray-500">Pré-visualização:</p>
                <img :src="form.fotoUrl" alt="Foto do vereador" class="h-40 w-40 object-cover rounded-lg ring-1 ring-gray-200">
            </div>
        </template>
    </div>

    
    <div class="bg-white rounded-lg shadow p-4 space-y-6">
        <fieldset class="space-y-3">
            <legend class="text-sm font-medium text-gray-700">Status</legend>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="ativo" value="1" x-model="form.ativo"
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="text-sm text-gray-700">Ativo</span>
            </label>
        </fieldset>

        <div class="flex gap-2">
            <a href="<?php echo e(route('vereadores.index')); ?>"
               class="inline-flex items-center px-4 py-2 rounded-lg ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                <?php echo e(!empty($isEdit) && $isEdit ? 'Salvar alterações' : 'Cadastrar'); ?>

            </button>
        </div>
    </div>

    
    <script>
        function vereadorForm(init) {
            return {
                form: { ...init },
                touched: {},
                errors: {},
                inputClass(field) {
                    return 'mt-1 block w-full rounded-md shadow-sm ' + (
                        this.errors[field] ? 'border-red-300 focus:ring-red-500 focus:border-red-500' :
                        'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'
                    );
                },
                touch(field) {
                    this.touched[field] = true;
                    this.validateField(field);
                },
                validateField(field) {
                    // Regras simples no cliente
                    if (field === 'nome_parlamentar' && !this.form.nome_parlamentar?.trim()) {
                        this.errors.nome_parlamentar = 'Informe o nome parlamentar.';
                    } else if (field === 'nome_completo' && !this.form.nome_completo?.trim()) {
                        this.errors.nome_completo = 'Informe o nome completo.';
                    } else if (field === 'partido_id' && !this.form.partido_id) {
                        this.errors.partido_id = 'Selecione um partido.';
                    } else {
                        delete this.errors[field];
                    }
                },
                validate() {
                    ['nome_parlamentar','nome_completo','partido_id'].forEach(f => {
                        this.touched[f] = true; this.validateField(f);
                    });
                    return Object.keys(this.errors).length === 0;
                },
                preview(e) {
                    const file = e.target.files?.[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = (ev) => this.form.fotoUrl = ev.target.result;
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</form>
<?php /**PATH C:\xampp\htdocs\plenarium\resources\views/vereadores/_form.blade.php ENDPATH**/ ?>