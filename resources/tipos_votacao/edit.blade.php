<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Tipo de Votação</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('config.tipos-votacao.update', $tipos_votacao) }}" class="bg-white p-6 rounded shadow">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome', $tipos_votacao->nome) }}" class="mt-1 block w-full border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Descrição</label>
                    <textarea name="descricao" class="mt-1 block w-full border-gray-300 rounded">{{ old('descricao', $tipos_votacao->descricao) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Turnos</label>
                    <input type="number" name="turnos" value="{{ old('turnos', $tipos_votacao->turnos) }}" min="1" class="mt-1 block w-full border-gray-300 rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Critério</label>
                    <select name="criterio" class="mt-1 block w-full border-gray-300 rounded">
                        <option value="maioria_simples" @selected($tipos_votacao->criterio == 'maioria_simples')>Maioria Simples</option>
                        <option value="maioria_absoluta" @selected($tipos_votacao->criterio == 'maioria_absoluta')>Maioria Absoluta</option>
                        <option value="unanimidade" @selected($tipos_votacao->criterio == 'unanimidade')>Unanimidade</option>
                        <option value="outro" @selected($tipos_votacao->criterio == 'outro')>Outro</option>
                    </select>
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="ativo" value="1" {{ $tipos_votacao->ativo ? 'checked' : '' }} class="mr-2">
                    <span>Ativo</span>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('config.tipos-votacao.index') }}" class="px-4 py-2 bg-gray-200 rounded mr-2">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
