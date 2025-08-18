<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Tipo de Tramitação') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('config.tipos-tramitacao.update', $tipoTramitacao) }}">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="nome" :value="__('Nome')" />
                            <x-text-input id="nome" class="block mt-1 w-full" type="text" name="nome" :value="old('nome', $tipoTramitacao->nome)" required autofocus />
                            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="descricao" :value="__('Descrição')" />
                            <textarea id="descricao" name="descricao" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('descricao', $tipoTramitacao->descricao) }}</textarea>
                            <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="prazo_dias" :value="__('Prazo em Dias')" />
                            <x-text-input id="prazo_dias" class="block mt-1 w-full" type="number" name="prazo_dias" :value="old('prazo_dias', $tipoTramitacao->prazo_dias)" required min="0" />
                            <x-input-error :messages="$errors->get('prazo_dias')" class="mt-2" />
                        </div>

                        <div class="block mt-4">
                            <label for="ativo" class="inline-flex items-center">
                                <input id="ativo" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="ativo" value="1" @checked(old('ativo', $tipoTramitacao->ativo))>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Ativo') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                             <a href="{{ route('config.tipos-tramitacao.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Atualizar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>