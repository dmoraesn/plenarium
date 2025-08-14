@php
    $isEdit = $isEdit ?? false;
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
            <select name="tipo_materia_id" class="w-full rounded-md border-gray-300" required>
                <option value="">-- selecione --</option>
                @foreach($tipos as $id => $sigla)
                    <option value="{{ $id }}" @selected(old('tipo_materia_id', $materia->tipo_materia_id) == $id)>{{ $sigla }}</option>
                @endforeach
            </select>
            @error('tipo_materia_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Número</label>
            <input type="number" name="numero" value="{{ old('numero', $materia->numero) }}" class="w-full rounded-md border-gray-300" required>
            @error('numero') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
            <input type="number" name="ano" value="{{ old('ano', $materia->ano ?? now()->year) }}" class="w-full rounded-md border-gray-300" required>
            @error('ano') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Ementa</label>
        <textarea name="ementa" rows="4" class="w-full rounded-md border-gray-300" required>{{ old('ementa', $materia->ementa) }}</textarea>
        @error('ementa') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Autores (opcional)</label>
        <select name="autores[]" multiple class="w-full rounded-md border-gray-300">
            @foreach($autores as $id => $nome)
                <option value="{{ $id }}"
                    @selected( in_array($id, old('autores', isset($materia) ? $materia->autores->pluck('id')->all() : [])) )>
                    {{ $nome }}
                </option>
            @endforeach
        </select>
        @error('autores.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-md border-gray-300" required>
                @foreach(\App\Models\Materia::STATUS as $st)
                    <option value="{{ $st }}" @selected(old('status', $materia->status) === $st)>
                        {{ ucfirst(str_replace('_',' ', $st)) }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="ativo" value="1" @checked(old('ativo', $materia->ativo))>
                <span class="text-sm text-gray-700">Ativo</span>
            </label>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
            {{ $isEdit ? 'Salvar alterações' : 'Cadastrar' }}
        </button>

        <a href="{{ route('materias.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg ring-1 ring-gray-300 text-gray-700 hover:bg-gray-50">
            Cancelar
        </a>
    </div>
</form>
