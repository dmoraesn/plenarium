<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoMateriaRequest;
use App\Http\Requests\UpdateTipoMateriaRequest;
use App\Models\TipoMateria;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TipoMateriaController extends Controller
{
    /**
     * Lista todos os Tipos de Matéria.
     */
    public function index(): View
    {
        $tiposMateria = TipoMateria::orderBy('nome')->paginate(10);

        return view('tipos_materia.index', compact('tiposMateria'));
    }

    /**
     * Mostra o formulário de criação.
     */
    public function create(): View
    {
        $model = new TipoMateria(['ativo' => true]);

        return view('tipos_materia.create', compact('model'));
    }

    /**
     * Salva um novo registro.
     */
    public function store(StoreTipoMateriaRequest $request): RedirectResponse
    {
        TipoMateria::create($request->validated());

        return redirect()
            ->route('config.tipos-materia.index')
            ->with('success', 'Tipo de Matéria criado com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(TipoMateria $model): View
    {
        return view('tipos_materia.edit', compact('model'));
    }

    /**
     * Atualiza um registro.
     */
    public function update(UpdateTipoMateriaRequest $request, TipoMateria $model): RedirectResponse
    {
        $model->update($request->validated());

        return redirect()
            ->route('config.tipos-materia.index')
            ->with('success', 'Tipo de Matéria atualizado com sucesso.');
    }

    /**
     * Remove um registro.
     */
    public function destroy(TipoMateria $model): RedirectResponse
    {
        $model->delete();

        return redirect()
            ->route('config.tipos-materia.index')
            ->with('success', 'Tipo de Matéria removido com sucesso.');
    }
}