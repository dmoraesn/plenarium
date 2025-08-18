<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tipos de Votação
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('config.tipos-votacao.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
                    Adicionar Novo
                </a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Turnos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Critério</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($tiposVotacao as $tipo)
                            <tr>
                                <td class="px-6 py-4">{{ $tipo->nome }} <br><span class="text-gray-500 text-sm">{{ $tipo->descricao }}</span></td>
                                <td class="px-6 py-4">{{ $tipo->turnos }}</td>
                                <td class="px-6 py-4">{{ ucfirst(str_replace('_',' ',$tipo->criterio)) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded {{ $tipo->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $tipo->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('config.tipos-votacao.edit', $tipo) }}" class="text-indigo-600 hover:underline mr-2">Editar</a>
                                    <form method="POST" action="{{ route('config.tipos-votacao.destroy', $tipo) }}" class="inline" onsubmit="return confirm('Tem certeza?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tiposVotacao->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
