<?php

namespace App\Http\Controllers;

use App\Http\Requests\LegislaturaRequest;
use App\Models\Legislatura;

class LegislaturaController extends Controller
{
    public function index()
    {
        $itens = Legislatura::orderByDesc('ativo')->orderByDesc('data_inicio')->paginate(15);
        return view('legislaturas.index', compact('itens'));
    }

    public function create()
    {
        $model = new Legislatura();
        return view('legislaturas.create', compact('model'));
    }

    public function store(LegislaturaRequest $request)
    {
        Legislatura::create($request->validated());
        return redirect()->route('config.legislaturas.index')->with('success', 'Legislatura criada com sucesso.');
    }

    public function edit(Legislatura $legislatura)
    {
        $model = $legislatura;
        return view('legislaturas.edit', compact('model'));
    }

    public function update(LegislaturaRequest $request, Legislatura $legislatura)
    {
        $legislatura->update($request->validated());
        return redirect()->route('config.legislaturas.index')->with('success', 'Legislatura atualizada com sucesso.');
    }

    public function destroy(Legislatura $legislatura)
    {
        $legislatura->delete();
        return redirect()->route('config.legislaturas.index')->with('success', 'Legislatura removida.');
    }
}
