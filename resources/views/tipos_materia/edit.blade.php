
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Tipo de Matéria
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-4 sm:p-6">
                @include('tipos_materia._form', ['model' => $model])
            </div>
        </div>
    </div>
</x-app-layout>
