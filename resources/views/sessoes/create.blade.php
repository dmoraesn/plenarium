@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Agendar Nova Sessão</h1>
            <p class="text-sm text-gray-500">Preencha os detalhes para agendar uma nova sessão legislativa.</p>
        </div>
        <a href="{{ route('sessoes.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
            &larr; Voltar para a lista
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ route('sessoes.store') }}">
            @csrf
            <div class="p-6 space-y-6">
                {{-- Linha 1: Número, Ano e Tipo --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
                        <input type="number" name="numero" id="numero" value="{{ old('numero', $sessao->numero) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('numero') border-red-500 @enderror">
                        @error('numero')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="ano" class="block text-sm font-medium text-gray-700">Ano</label>
                        <input type="number" name="ano" id="ano" value="{{ old('ano', $sessao->ano) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('ano') border-red-500 @enderror">
                        @error('ano')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <select name="tipo" id="tipo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('tipo') border-red-500 @enderror">
                            <option value="ordinaria" @selected(old('tipo', $sessao->tipo) == 'ordinaria')>Ordinária</option>
                            <option value="extraordinaria" @selected(old('tipo', $sessao->tipo) == 'extraordinaria')>Extraordinária</option>
                            <option value="solene" @selected(old('tipo', $sessao->tipo) == 'solene')>Solene</option>
                            <option value="especial" @selected(old('tipo', $sessao->tipo) == 'especial')>Especial</option>
                        </select>
                        @error('tipo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Linha 2: Data --}}
                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700">Data da Sessão</label>
                    <input type="date" name="data" id="data" value="{{ old('data', $sessao->data) }}" required class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('data') border-red-500 @enderror">
                    @error('data')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Linha 3: Observações --}}
                <div>
                    <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações (opcional)</label>
                    <textarea name="observacoes" id="observacoes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('observacoes') border-red-500 @enderror">{{ old('observacoes', $sessao->observacoes) }}</textarea>
                    @error('observacoes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Rodapé com Ações --}}
            <div class="px-6 py-4 bg-gray-50 text-right rounded-b-lg">
                <a href="{{ route('sessoes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Cancelar</a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Agendar Sessão
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
