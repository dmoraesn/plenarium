<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoExpedienteRequest;
use App\Models\TipoExpediente;

class TipoExpedienteController extends Controller
{
    public function index()
    {
        $itens = TipoExpediente::orderBy('ordenacao')->orderBy('descricao')->paginate(15);
        return view('tipo_expediente.index', compact('itens'));
    }

    public function create()
    {
        $model = new TipoExpediente(['ativo' => true]);
        return view('tipo_expediente.create', compact('model'));
    }

    public function store(TipoExpedienteRequest $request)
    {
        TipoExpediente::create($request->validated());
        return redirect()->route('config.tipo_expediente.index')->with('success', 'Tipo de expediente criado.');
    }

    public function edit(TipoExpediente $tipoExpediente)
    {
        $model = $tipoExpediente;
        return view('tipo_expediente.edit', compact('model'));
    }

    public function update(TipoExpedienteRequest $request, TipoExpediente $tipoExpediente)
    {
        $tipoExpediente->update($request->validated());
        return redirect()->route('config.tipo_expediente.index')->with('success', 'Tipo de expediente atualizado.');
    }

    public function destroy(TipoExpediente $tipoExpediente)
    {
        $tipoExpediente->delete();
        return redirect()->route('config.tipo_expediente.index')->with('success', 'Tipo de expediente removido.');
    }
}
