@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Parâmetros do Sistema</h1>
        <a href="{{ route('configuracoes.index') }}" class="text-indigo-600 hover:underline">Voltar para Configurações</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('config.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Dados da Casa Legislativa --}}
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Dados da Casa Legislativa</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome da Casa</label>
                    <input type="text" name="settings[casa.nome]" 
                           value="{{ old('settings.casa.nome', $settings['casa.nome'] ?? '') }}"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Endereço</label>
                    <input type="text" name="settings[casa.endereco]" 
                           value="{{ old('settings.casa.endereco', $settings['casa.endereco'] ?? '') }}"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Brasão (imagem)</label>
                    <input type="file" name="brasao" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @if ($settings['casa.brasao_path'] ?? false)
                        <img src="{{ asset('storage/' . $settings['casa.brasao_path']) }}" alt="Brasão" class="mt-2 h-16">
                    @endif
                </div>
            </div>
        </div>

        {{-- Parâmetros de Votação e Quórum --}}
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Parâmetros de Votação e Quórum</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Vereadores da legislatura atual</label>
                    <input type="number" name="settings[votacao.total_vereadores]" step="1" min="0"
                           value="{{ old('settings.votacao.total_vereadores', $settings['votacao.total_vereadores'] ?? '') }}"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quorum mínimo para iniciar a sessão</label>
                    <input type="number" name="settings[votacao.quorum_minimo_abertura]" step="1" min="0"
                           value="{{ old('settings.votacao.quorum_minimo_abertura', $settings['votacao.quorum_minimo_abertura'] ?? '') }}"
                           class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>
        </div>
        
        {{-- Configuração de Temporizador --}}
        <div class="bg-white rounded shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Configuração de Temporizador</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Tempo de Fala 1 --}}
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome (Tempo de Fala 1)</label>
                            <input type="text" name="settings[temporizador.fala1.nome]"
                                   value="{{ old('settings.temporizador.fala1.nome', $settings['temporizador.fala1.nome'] ?? '') }}"
                                   class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Minutagem (Tempo de Fala 1)</label>
                            <input type="number" name="settings[temporizador.fala1.minutagem]" step="1" min="0"
                                   value="{{ old('settings.temporizador.fala1.minutagem', $settings['temporizador.fala1.minutagem'] ?? '') }}"
                                   class="mt-1 block w-full rounded border-gray-300">
                        </div>
                    </div>
                </div>

                {{-- Tempo de Fala 2 --}}
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome (Tempo de Fala 2)</label>
                            <input type="text" name="settings[temporizador.fala2.nome]"
                                   value="{{ old('settings.temporizador.fala2.nome', $settings['temporizador.fala2.nome'] ?? '') }}"
                                   class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Minutagem (Tempo de Fala 2)</label>
                            <input type="number" name="settings[temporizador.fala2.minutagem]" step="1" min="0"
                                   value="{{ old('settings.temporizador.fala2.minutagem', $settings['temporizador.fala2.minutagem'] ?? '') }}"
                                   class="mt-1 block w-full rounded border-gray-300">
                        </div>
                    </div>
                </div>
                
                {{-- Tempo de Fala 3 --}}
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome (Tempo de Fala 3)</label>
                            <input type="text" name="settings[temporizador.fala3.nome]"
                                   value="{{ old('settings.temporizador.fala3.nome', $settings['temporizador.fala3.nome'] ?? '') }}"
                                   class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Minutagem (Tempo de Fala 3)</label>
                            <input type="number" name="settings[temporizador.fala3.minutagem]" step="1" min="0"
                                   value="{{ old('settings.temporizador.fala3.minutagem', $settings['temporizador.fala3.minutagem'] ?? '') }}"
                                   class="mt-1 block w-full rounded border-gray-300">
                        </div>
                    </div>
                </div>
                
                {{-- Tempo de Aparte e Opção de Interrupção --}}
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tempo de Aparte (segundos)</label>
                            <input type="number" name="settings[temporizador.aparte.tempo]" step="1" min="0"
                                   value="{{ old('settings.temporizador.aparte.tempo', $settings['temporizador.aparte.tempo'] ?? '') }}"
                                   class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        {{-- Dropdown para o aparte --}}
                        <div class="flex flex-col">
                            <label class="block text-sm font-medium text-gray-700">O aparte pausa o tempo do orador?</label>
                            <select name="settings[temporizador.aparte.pausa_orador]" class="mt-1 block w-full rounded border-gray-300">
                                <option value="1" {{ (old('settings.temporizador.aparte.pausa_orador', $settings['temporizador.aparte.pausa_orador'] ?? false) == '1') ? 'selected' : '' }}>Sim</option>
                                <option value="0" {{ (old('settings.temporizador.aparte.pausa_orador', $settings['temporizador.aparte.pausa_orador'] ?? false) == '0') ? 'selected' : '' }}>Não</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Tipo de Contagem Padrão --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Tipo de Contagem Padrão</label>
                    <select name="settings[temporizador.tipo_contagem_padrao]" class="mt-1 block w-full rounded border-gray-300">
                        <option value="regressivo" {{ (old('settings.temporizador.tipo_contagem_padrao', $settings['temporizador.tipo_contagem_padrao'] ?? '') == 'regressivo') ? 'selected' : '' }}>Regressivo</option>
                        <option value="progressivo" {{ (old('settings.temporizador.tipo_contagem_padrao', $settings['temporizador.tipo_contagem_padrao'] ?? '') == 'progressivo') ? 'selected' : '' }}>Progressivo</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar alterações</button>
        </div>
    </form>
</div>
@endsection