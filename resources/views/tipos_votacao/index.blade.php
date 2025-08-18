<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tipos de Votação</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('config.tipos-votacao.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
                    Adicionar Novo
                </a>
            </div>

            {{-- ✅ Mensagem de sucesso --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Critério</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($tiposVotacao as $tipo)
                            <tr>
                                <td class="px-6 py-4">
                                    <strong>{{ $tipo->nome }}</strong><br>
                                    <span class="text-gray-500 text-sm">{{ $tipo->descricao }}</span>
                                </td>
                                <td class="px-6 py-4">{{ ucfirst(str_replace('_',' ',$tipo->criterio)) }}</td>

                                {{-- Coluna Status agora é apenas informativa --}}
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $tipo->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $tipo->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>

                                {{-- Coluna Ações agora inclui Editar e Ativar/Desativar --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        {{-- Botão Editar --}}
                                        <a href="{{ route('config.tipos-votacao.edit', $tipo) }}" class="px-3 py-1 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 text-sm font-medium">Editar</a>

                                        {{-- Botão Ativar/Desativar --}}
                                        <form method="POST" action="{{ route('config.tipos-votacao.toggle', $tipo) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            @if ($tipo->ativo)
                                                <button type="submit" class="px-3 py-1 rounded-lg bg-yellow-400 text-yellow-800 hover:bg-yellow-500 text-sm font-medium">Desativar</button>
                                            @else
                                                <button type="submit" class="px-3 py-1 rounded-lg bg-green-400 text-green-800 hover:bg-green-500 text-sm font-medium">Ativar</button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Nenhum tipo de votação encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if ($tiposVotacao->hasPages())
                <div class="mt-4">
                    {{ $tiposVotacao->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
