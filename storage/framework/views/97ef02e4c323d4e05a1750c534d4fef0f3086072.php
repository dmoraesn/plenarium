
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
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-reset flex">
                <li><a href="<?php echo e(route('dashboard')); ?>" class="text-indigo-600">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Configurações</li>
            </ol>
        </nav>

        <h2 class="font-semibold text-xl text-gray-800">Configurações</h2>
     <?php $__env->endSlot(); ?>

    <?php
        $modules = [
            [
                'route' => 'config.legislaturas.index',
                'label' => 'Legislaturas',
                'desc'  => 'Períodos legislativos (2025–2028…)',
                'icon'  => 'calendar',
            ],
            [
                'route' => 'config.partidos.index',
                'label' => 'Partidos',
                'desc'  => 'Sigla e nome completo',
                'icon'  => 'megaphone',
            ],
            [
                'route' => 'config.tipos-materia.index',
                'label' => 'Tipos de Matéria',
                'desc'  => 'Projeto de Lei, Requerimento…',
                'icon'  => 'file-text',
            ],
            [
                'route' => 'config.tipos-tramitacao.index',
                'label' => 'Tipos de Tramitação',
                'desc'  => 'Define os fluxos e prazos dos processos',
                'icon'  => 'git-branch-plus',
            ],
            [
                'route' => 'config.tipos-votacao.index',
                'label' => 'Tipos de Votação',
                'desc'  => 'Configure como as matérias são votadas (padrão ou personalizado)',
                'icon'  => 'check-square',
            ],
            [
                'route' => 'config.tipo-normas.index',
                'label' => 'Tipos de Norma',
                'desc'  => 'Lei, Decreto, Resolução…',
                'icon'  => 'scale',
            ],
            [
                'route' => 'config.normas.index',
                'label' => 'Normas Jurídicas',
                'desc'  => 'Cadastro e consulta',
                'icon'  => 'book-open',
            ],
            [
                'route' => 'config.tipos-expediente.index',
                'label' => 'Tipos de Expediente',
                'desc'  => 'Configurar itens do expediente',
                'icon'  => 'clock',
            ],
            [
                'route' => 'config.cargos-mesa.index',
                'label' => 'Cargos da Mesa',
                'desc'  => 'Presidente, Secretários…',
                'icon'  => 'user-cog',
            ],
            [
                'route' => 'config.settings.edit',
                'label' => 'Parâmetros do Sistema',
                'desc'  => 'Quórum, máscaras, dados da casa…',
                'icon'  => 'settings',
            ],
        ];

        $cardBase = 'flex items-start gap-4 bg-white rounded shadow p-5 hover:shadow-md';
        $iconWrap = 'shrink-0 rounded-xl bg-indigo-50 p-2';
        $iconCls  = 'w-6 h-6 text-indigo-600';
    ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Route::has($mod['route'])): ?>
                        <a href="<?php echo e(route($mod['route'])); ?>" class="<?php echo e($cardBase); ?>">
                            <div class="<?php echo e($iconWrap); ?>">
                                <i data-lucide="<?php echo e($mod['icon']); ?>" class="<?php echo e($iconCls); ?>"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 text-xs uppercase">Configurações</div>
                                <div class="text-lg font-semibold"><?php echo e($mod['label']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($mod['desc']); ?></div>
                            </div>
                        </a>
                    <?php else: ?>
                        <div class="<?php echo e($cardBase); ?> opacity-60 cursor-not-allowed" title="Módulo não habilitado">
                            <div class="<?php echo e($iconWrap); ?>">
                                <i data-lucide="<?php echo e($mod['icon']); ?>" class="<?php echo e($iconCls); ?>"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 text-xs uppercase">Configurações</div>
                                <div class="text-lg font-semibold"><?php echo e($mod['label']); ?></div>
                                <div class="text-sm text-gray-400">Módulo ainda não instalado</div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\plenarium\resources\views/configuracoes/index.blade.php ENDPATH**/ ?>