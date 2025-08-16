<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoNormaRequest;
use App\Models\TipoNorma;

class TipoNormaController extends Controller
{
    /**
     * Lista os tipos de norma.
     */
    public function index()
    {
        $itens = TipoNorma::orderBy('descricao')->paginate(15);
        return view('tipo_normas.index', compact('itens'));
    }

    /**
     * Exibe o formulário de criação.
     */
    public function create()
    {
        $model = new TipoNorma(['ativo' => true]);
        return view('tipo_normas.create', compact('model'));
    }

    /**
     * Salva um novo tipo de norma.
     */
    public function store(TipoNormaRequest $request)
    {
        TipoNorma::create($request->validated());
        return redirect()
            ->route('config.tipo_normas.index')
            ->with('success', 'Tipo de norma criado.');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(TipoNorma $tipoNorma)
    {
        $model = $tipoNorma;
        return view('tipo_normas.edit', compact('model'));
    }

    /**
     * Atualiza o tipo de norma.
     */
    public function update(TipoNormaRequest $request, TipoNorma $tipoNorma)
    {
        $tipoNorma->update($request->validated());
        return redirect()
            ->route('config.tipo_normas.index')
            ->with('success', 'Tipo de norma atualizado.');
    }

    /**
     * Remove o tipo de norma.
     */
    public function destroy(TipoNorma $tipoNorma)
    {
        $tipoNorma->delete();
        return redirect()
            ->route('config.tipo_normas.index')
            ->with('success', 'Tipo de norma removido.');
    }
}
