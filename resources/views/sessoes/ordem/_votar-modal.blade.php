{{-- O modal será criado dinamicamente via JS --}}
{{-- TODO: Incluir este arquivo na view index.blade.php --}}
<div id="votacao-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Votação de Matéria</h3>
            <div class="mt-2 px-7 py-3">
                <div class="text-left mb-4">
                    <p class="text-sm font-semibold">Tipo: <span id="materia-tipo" class="font-normal"></span></p>
                    <p class="text-sm font-semibold">Número/Ano: <span id="materia-numero-ano" class="font-normal"></span></p>
                    <p class="text-sm font-semibold">Ementa: <span id="materia-ementa" class="font-normal"></span></p>
                    <p class="text-sm font-semibold">Autores: <span id="materia-autores" class="font-normal"></span></p>
                </div>

                <form id="form-votacao" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4 text-left">
                        <label for="criterio_votacao" class="block text-sm font-medium text-gray-700">Critério de Votação</label>
                        <select id="criterio_votacao" name="criterio_votacao" class="mt-1 block w-full rounded border-gray-300">
                            {{-- Os tipos de votação serão populados por JS --}}
                        </select>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <button type="submit" formaction="{{ route('sessoes.ordem.votar', ['sessao' => $sessao, 'item' => ':id']) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Iniciar Votação
                        </button>
                        <button type="button" class="text-sm text-red-600 hover:underline" onclick="openRetirarModal()">
                            Retirar de Pauta
                        </button>
                    </div>
                </form>
            </div>
            <div class="items-center px-4 py-3">
                <button id="close-modal" class="px-4 py-2 bg-gray-200 text-black rounded-md hover:bg-gray-300">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>