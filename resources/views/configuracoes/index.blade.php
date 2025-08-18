
<x-app-layout>
    <x-slot name="header">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-reset flex">
                <li><a href="{{ route('dashboard') }}" class="text-indigo-600">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Configurações</li>
            </ol>
        </nav>

        <h2 class="font-semibold text-xl text-gray-800">Configurações</h2>
    </x-slot>

    @php
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
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($modules as $mod)
                    @if (Route::has($mod['route']))
                        <a href="{{ route($mod['route']) }}" class="{{ $cardBase }}">
                            <div class="{{ $iconWrap }}">
                                <i data-lucide="{{ $mod['icon'] }}" class="{{ $iconCls }}"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 text-xs uppercase">Configurações</div>
                                <div class="text-lg font-semibold">{{ $mod['label'] }}</div>
                                <div class="text-sm text-gray-500">{{ $mod['desc'] }}</div>
                            </div>
                        </a>
                    @else
                        <div class="{{ $cardBase }} opacity-60 cursor-not-allowed" title="Módulo não habilitado">
                            <div class="{{ $iconWrap }}">
                                <i data-lucide="{{ $mod['icon'] }}" class="{{ $iconCls }}"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 text-xs uppercase">Configurações</div>
                                <div class="text-lg font-semibold">{{ $mod['label'] }}</div>
                                <div class="text-sm text-gray-400">Módulo ainda não instalado</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
