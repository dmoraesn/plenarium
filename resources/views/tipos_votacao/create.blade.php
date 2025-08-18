<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Novo Tipo de Votação</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                {{-- Passando um novo model para o formulário saber que está em modo "create" --}}
                @include('tipos_votacao._form', ['model' => new \App\Models\TipoVotacao(['ativo' => true])])
            </div>
        </div>
    </div>
</x-app-layout>