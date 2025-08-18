<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoTramitacaoRequest;
use App\Http\Requests\UpdateTipoTramitacaoRequest;
use App\Models\TipoTramitacao;
use Illuminate\Http\Request;

class TipoTramitacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiposTramitacao = TipoTramitacao::latest()->paginate(10);
        return view('tipos_tramitacao.index', compact('tiposTramitacao'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipos_tramitacao.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoTramitacaoRequest $request)
    {
        $data = $request->validated();
        $data['ativo'] = $request->has('ativo');

        TipoTramitacao::create($data);

        return redirect()->route('config.tipos-tramitacao.index')
            ->with('success', 'Tipo de Tramitação criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoTramitacao $tipos_tramitacao)
    {
        // Normalmente não utilizado em CRUDs de recurso simples. Redirecionar para edição.
        return redirect()->route('config.tipos-tramitacao.edit', $tipos_tramitacao);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoTramitacao $tipos_tramitacao)
    {
        return view('tipos_tramitacao.edit', ['tipoTramitacao' => $tipos_tramitacao]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoTramitacaoRequest $request, TipoTramitacao $tipos_tramitacao)
    {
        $data = $request->validated();
        $data['ativo'] = $request->has('ativo');

        $tipos_tramitacao->update($data);

        return redirect()->route('config.tipos-tramitacao.index')
            ->with('success', 'Tipo de Tramitação atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoTramitacao $tipos_tramitacao)
    {
        $tipos_tramitacao->delete();

        return redirect()->route('config.tipos-tramitacao.index')
            ->with('success', 'Tipo de Tramitação excluído com sucesso.');
    }
}