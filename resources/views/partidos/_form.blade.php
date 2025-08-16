@csrf
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Sigla</label>
        <input type="text" name="sigla" value="{{ old('sigla', $model->sigla) }}" class="mt-1 block w-full rounded border-gray-300 uppercase" required>
        @error('sigla') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="nome" value="{{ old('nome', $model->nome) }}" class="mt-1 block w-full rounded border-gray-300" required>
        @error('nome') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-3">
        <label class="inline-flex items-center">
            <input type="checkbox" name="ativo" value="1" class="rounded border-gray-300" {{ old('ativo', $model->ativo) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700">Ativo</span>
        </label>
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('partidos.index') }}" class="px-3 py-2 rounded border border-gray-300 text-gray-700">Cancelar</a>
    <button class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar</button>
</div>
