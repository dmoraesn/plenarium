<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Tipo de Votação</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                {{-- O controller deve passar a variável como $model --}}
                @include('tipos_votacao._form', ['model' => $model])
            </div>
        </div>
    </div>
</x-app-layout>