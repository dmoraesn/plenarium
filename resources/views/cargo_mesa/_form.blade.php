@csrf
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Descrição</label>
        <input type="text" name="descricao" value="{{ old('descricao', $model->descricao) }}" class="mt-1 block w-full rounded border-gray-300" required>
        @error('descricao') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Posição</label>
        <input type="number" name="posicao_ordenacao" value="{{ old('posicao_ordenacao', $model->posicao_ordenacao) }}" class="mt-1 block w-full rounded border-gray-300">
        @error('posicao_ordenacao') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-3">
        <label class="block text-sm font-medium text-gray-700">Observação</label>
        <textarea name="observacao" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('observacao', $model->observacao) }}</textarea>
        @error('observacao') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-3 flex items-center gap-6">
        <label class="inline-flex items-center">
            <input type="checkbox" name="cargo_unico" value="1" class="rounded border-gray-300" {{ old('cargo_unico', $model->cargo_unico) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700">Cargo único</span>
        </label>
        <label class="inline-flex items-center">
            <input type="checkbox" name="ativo" value="1" class="rounded border-gray-300" {{ old('ativo', $model->ativo) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700">Ativo</span>
        </label>
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('config.cargo_mesa.index') }}" class="px-3 py-2 rounded border border-gray-300 text-gray-700">Cancelar</a>
    <button class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar</button>
</div>
