@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Tipo</label>
        <select name="tipo" class="mt-1 block w-full rounded border-gray-300" required>
            <option value="">Selecione...</option>
            @foreach ($tipos as $t)
                <option value="{{ $t->id }}" @selected(old('tipo', $model->tipo) == $t->id)>{{ $t->descricao }}</option>
            @endforeach
        </select>
        @error('tipo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Número</label>
            <input type="number" name="numero" value="{{ old('numero', $model->numero) }}" class="mt-1 block w-full rounded border-gray-300" required>
            @error('numero') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Ano</label>
            <input type="number" name="ano" value="{{ old('ano', $model->ano) }}" class="mt-1 block w-full rounded border-gray-300" required>
            @error('ano') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Ementa</label>
        <textarea name="ementa" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('ementa', $model->ementa) }}</textarea>
        @error('ementa') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Texto integral (ou link)</label>
        <textarea name="texto_integral" rows="6" class="mt-1 block w-full rounded border-gray-300">{{ old('texto_integral', $model->texto_integral) }}</textarea>
        @error('texto_integral') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Data de publicação</label>
        <input type="date" name="data_publicacao" value="{{ old('data_publicacao', optional($model->data_publicacao)->format('Y-m-d')) }}" class="mt-1 block w-full rounded border-gray-300">
        @error('data_publicacao') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('config.normas.index') }}" class="px-3 py-2 rounded border border-gray-300 text-gray-700">Cancelar</a>
    <button class="px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Salvar</button>
</div>
