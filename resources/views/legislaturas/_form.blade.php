@csrf
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
        <input type="number" name="numero" id="numero" value="{{ old('numero', $model->numero) }}"
               class="mt-1 block w-full rounded border-gray-300">
        @error('numero') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="data_eleicao" class="block text-sm font-medium text-gray-700">Data da eleição</label>
        <input type="date" name="data_eleicao" id="data_eleicao" value="{{ old('data_eleicao', optional($model->data_eleicao)->format('Y-m-d')) }}"
               class="mt-1 block w-full rounded border-gray-300">
        @error('data_eleicao') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-gray-700">Ativa</label>
        <label class="inline-flex items-center mt-2">
            <input type="checkbox" name="ativo" value="1" class="rounded border-gray-300" {{ old('ativo', $model->ativo) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700">Legislatura em vigor</span>
        </label>
        @error('ativo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="data_inicio" class="block text-sm font-medium text-gray-700">Início</label>
        <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio', optional($model->data_inicio)->format('Y-m-d')) }}"
               class="mt-1 block w-full rounded border-gray-300" required>
        @error('data_inicio') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="data_fim" class="block text-sm font-medium text-gray-700">Fim</label>
        <input type="date" name="data_fim" id="data_fim" value="{{ old('data_fim', optional($model->data_fim)->format('Y-m-d')) }}"
               class="mt-1 block w-full rounded border-gray-300" required>
        @error('data_fim') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-3">
        <label for="observacao" class="block text-sm font-medium text-gray-700">Observação</label>
        <textarea name="observacao" id="observacao" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('observacao', $model->observacao) }}</textarea>
        @error('observacao') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('config.legislaturas.index') }}" class="px-3 py-2 rounded border border-gray-300 text-gray-700">Cancelar</a>
    <button class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar</button>
</div>
