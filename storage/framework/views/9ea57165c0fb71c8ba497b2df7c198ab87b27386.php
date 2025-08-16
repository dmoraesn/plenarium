

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Parâmetros do Sistema</h1>
        <a href="<?php echo e(route('config.index')); ?>" class="text-indigo-600 hover:underline">Voltar para Configurações</a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 px-4 py-3">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('config.settings.update')); ?>" class="space-y-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Dados da Casa Legislativa</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome da Casa</label>
                    <input type="text" name="settings[casa.nome]" value="<?php echo e(old('settings.casa.nome', optional(\App\Models\Setting::where('key','casa.nome')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Endereço</label>
                    <input type="text" name="settings[casa.endereco]" value="<?php echo e(old('settings.casa.endereco', optional(\App\Models\Setting::where('key','casa.endereco')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Brasão (path/URL)</label>
                    <input type="text" name="settings[casa.brasao_path]" value="<?php echo e(old('settings.casa.brasao_path', optional(\App\Models\Setting::where('key','casa.brasao_path')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Parâmetros de Votação e Quórum</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quórum de abertura</label>
                    <input type="number" name="settings[votacao.quorum_abertura]" step="1" min="0"
                           value="<?php echo e(old('settings.votacao.quorum_abertura', optional(\App\Models\Setting::where('key','votacao.quorum_abertura')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quórum de votação</label>
                    <input type="number" name="settings[votacao.quorum_votacao]" step="1" min="0"
                           value="<?php echo e(old('settings.votacao.quorum_votacao', optional(\App\Models\Setting::where('key','votacao.quorum_votacao')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Maioria simples (%)</label>
                    <input type="number" name="settings[votacao.maioria_simples]" step="1" min="0" max="100"
                           value="<?php echo e(old('settings.votacao.maioria_simples', optional(\App\Models\Setting::where('key','votacao.maioria_simples')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Numeração de Matérias</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Máscara de numeração</label>
                    <input type="text" name="settings[materias.mascara_numero]"
                           value="<?php echo e(old('settings.materias.mascara_numero', optional(\App\Models\Setting::where('key','materias.mascara_numero')->first())->value ?? 'PL {numero}/{ano}')); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                    <p class="text-xs text-gray-500 mt-1">Use placeholders: {numero}, {ano}</p>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Parâmetros de Sessão</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempo de fala (min)</label>
                    <input type="number" name="settings[sessao.tempo_fala.min]" step="1" min="0"
                           value="<?php echo e(old('settings.sessao.tempo_fala.min', optional(\App\Models\Setting::where('key','sessao.tempo_fala.min')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prorrogação (min)</label>
                    <input type="number" name="settings[sessao.tempo_fala.prorrogacao_min]" step="1" min="0"
                           value="<?php echo e(old('settings.sessao.tempo_fala.prorrogacao_min', optional(\App\Models\Setting::where('key','sessao.tempo_fala.prorrogacao_min')->first())->value)); ?>"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar alterações</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\plenarium\resources\views/configuracoes/settings.blade.php ENDPATH**/ ?>