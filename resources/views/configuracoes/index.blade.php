@extends('layouts.app')

@section('content')
@php
    $hasPartidos     = \Route::has('partidos.index');
    $hasTipoMaterias = \Route::has('tipo_materias.index');
    $hasVereadores   = \Route::has('vereadores.index');

    $cardBase = 'flex items-start gap-4 bg-white rounded shadow p-5 hover:shadow-md';
    $iconWrap = 'shrink-0 rounded-xl bg-indigo-50 p-2';
    $iconCls  = 'w-6 h-6 text-indigo-600';
@endphp

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Configurações</h1>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        {{-- Legislaturas --}}
        <a href="{{ route('config.legislaturas.index') }}" class="{{ $cardBase }}">
            <div class="{{ $iconWrap }}"><i data-lucide="calendar" class="{{ $iconCls }}"></i></div>
            <div>
                <div class="text-gray-500 text-xs uppercase">Cadastros</div>
                <div class="text-lg font-semibold">Legislaturas</div>
                <div class="text-sm text-gray-500">Períodos legislativos (2025–2028…)</div>
            </div>
        </a>

        {{-- Partidos --}}
        @if ($hasPartidos)
            <a href="{{ route('partidos.index') }}" class="{{ $cardBase }}">
                <div class="{{ $iconWrap }}"><i data-lucide="megaphone" class="{{ $iconCls }}"></i></div>
                <div>
                    <div class="text-gray-500 text-xs uppercase">Cadastros</div>
                    <div class="text-lg font-semibold">Partidos</div>
                    <div class="text-sm text-gray-500">Sigla e nome completo</div>
                </div>
            </a>
        @else
            <div class="{{ $cardBase }} opacity-60 cursor-not-allowed" title="Módulo não habilitado">
                <div class="{{ $iconWrap }}"><i data-lucide="megaphone" class="{{ $iconCls }}"></i></div>
                <div>
                    <div class="text-gray-500 text-xs uppercase">Cadastros</div>
                    <div class="text-lg font-semibold">Partidos</div>
                    <div class="text-sm text-gray-400">Módulo ainda não instalado</div>
                </div>
            </div>
        @endif

        {{-- Tipos de Matéria --}}
        @if ($hasTipoMaterias)
            <a href="{{ route('tipo_materias.index') }}" class="{{ $cardBase }}">
                <div class="{{ $iconWrap }}"><i data-lucide="file-text" class="{{ $iconCls }}"></i></div>
                <div>
                    <div class="text-gray-500 text-xs uppercase">Cadastros</div>
                    <div class="text-lg font-semibold">Tipos de Matéria</div>
                    <div class="text-sm text-gray-500">Projeto de Lei, Requerimento…</div>
                </div>
            </a>
        @else
            <div class="{{ $cardBase }} opacity-60 cursor-not-allowed" title="Módulo não habilitado">
                <div class="{{ $iconWrap }}"><i data-lucide="file-text" class="{{ $iconCls }}"></i></div>
                <div>
                    <div class="text-gray-500 text-xs uppercase">Cadastros</div>
                    <div class="text-lg font-semibold">Tipos de Matéria</div>
                    <div class="text-sm text-gray-400">Módulo ainda não instalado</div>
                </div>
            </div>
        @endif

        {{-- Vereadores --}}
        @if ($hasVereadores)
            <a href="{{ route('vereadores.index') }}" class="{{ $cardBase }}">
                <div class="{{ $iconWrap }}"><i data-lucide="users" class="{{ $iconCls }}"></i></div>
                <div>
                    <div class="text-gray-500 text-xs uppercase">Pessoas</div>
                    <div class="text-lg font-semibold">Vereadores</div>
                    <div class="text-sm text-gray-500">Cadastro e vínculos</div>
                </div>
            </a>
        @else
            <div class="{{ $cardBase }} opacity-60 cursor-not-allowed" title="Módulo não habilitado">
                <div class="{{ $iconWrap }}"><i data-lucide="users" class="{{ $iconCls }}"></i></div>
                <div>
                    <div class="text-gray-500 text-xs uppercase">Pessoas</div>
                    <div class="text-lg font-semibold">Vereadores</div>
                    <div class="text-sm text-gray-400">Módulo ainda não instalado</div>
                </div>
            </div>
        @endif

        {{-- Parâmetros --}}
        <a href="{{ route('config.settings.edit') }}" class="{{ $cardBase }}">
            <div class="{{ $iconWrap }}"><i data-lucide="settings" class="{{ $iconCls }}"></i></div>
            <div>
                <div class="text-gray-500 text-xs uppercase">Sistema</div>
                <div class="text-lg font-semibold">Parâmetros</div>
                <div class="text-sm text-gray-500">Quórum, máscaras, dados da casa…</div>
            </div>
        </a>

        {{-- Tipos de Norma --}}
        <a href="{{ route('config.tipo_normas.index') }}" class="{{ $cardBase }}">
            <div class="{{ $iconWrap }}"><i data-lucide="scale" class="{{ $iconCls }}"></i></div>
            <div>
                <div class="text-gray-500 text-xs uppercase">Normas</div>
                <div class="text-lg font-semibold">Tipos de Norma</div>
                <div class="text-sm text-gray-500">Lei, Decreto, Resolução…</div>
            </div>
        </a>

        {{-- Normas Jurídicas --}}
        <a href="{{ route('config.normas.index') }}" class="{{ $cardBase }}">
            <div class="{{ $iconWrap }}"><i data-lucide="book-open" class="{{ $iconCls }}"></i></div>
            <div>
                <div class="text-gray-500 text-xs uppercase">Normas</div>
                <div class="text-lg font-semibold">Normas Jurídicas</div>
                <div class="text-sm text-gray-500">Cadastro e consulta</div>
            </div>
        </a>

        {{-- Tipos de Expediente --}}
        <a href="{{ route('config.tipo_expediente.index') }}" class="{{ $cardBase }}">
            <div class="{{ $iconWrap }}"><i data-lucide="clock" class="{{ $iconCls }}"></i></div>
            <div>
                <div class="text-gray-500 text-xs uppercase">Sessões</div>
                <div class="text-lg font-semibold">Tipos de Expediente</div>
                <div class="text-sm text-gray-500">Configurar itens do expediente</div>
            </div>
        </a>

        {{-- Cargos da Mesa --}}
        <a href="{{ route('config.cargo_mesa.index') }}" class="{{ $cardBase }}">
            <div class="{{ $iconWrap }}"><i data-lucide="user-cog" class="{{ $iconCls }}"></i></div>
            <div>
                <div class="text-gray-500 text-xs uppercase">Pessoas</div>
                <div class="text-lg font-semibold">Cargos da Mesa</div>
                <div class="text-sm text-gray-500">Presidente, Secretários…</div>
            </div>
        </a>
    </div>
</div>
@endsection
