
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tipos de Matéria
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensagem de sucesso --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Botão novo tipo --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('config.tipos-materia.create') }}"
                   class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg shadow-md transition-colors duration-200">
                    Novo Tipo de Matéria
                </a>
            </div>

            {{-- Tabela --}}
            <div class="bg-white shadow-md rounded-lg p-4 sm:p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-4 py-3 font-medium text-gray-600">Sigla</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Nome</th>
                            <th class="px-4 py-3 font-medium text-gray-600">Status</th>
                            <th class="px-4 py-3 font-medium text-gray-600 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tiposMateria as $tipo)
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2">{{ $tipo->sigla }}</td>
                                <td class="px-4 py-2">{{ $tipo->nome }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tipo->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $tipo->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('config.tipos-materia.edit', $tipo) }}"
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    <form action="{{ route('config.tipos-materia.destroy', $tipo) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este tipo de matéria?')"
                                                class="text-red-600 hover:text-red-900">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                                    Nenhum tipo de matéria encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Paginação --}}
                <div class="mt-4">
                   {{ $tiposMateria->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
