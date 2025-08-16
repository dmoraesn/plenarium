<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartidoRequest;
use App\Models\Partido;

class PartidoController extends Controller
{
    public function index()
    {
        $itens = Partido::orderByDesc('ativo')->orderBy('sigla')->paginate(15);
        return view('partidos.index', compact('itens'));
    }

    public function create()
    {
        $model = new Partido(['ativo' => true]);
        return view('partidos.create', compact('model'));
    }

    public function store(PartidoRequest $request)
    {
        Partido::create($request->validated());
        return redirect()->route('partidos.index')->with('success', 'Partido criado.');
    }

    public function edit(Partido $partido)
    {
        $model = $partido;
        return view('partidos.edit', compact('model'));
    }

    public function update(PartidoRequest $request, Partido $partido)
    {
        $partido->update($request->validated());
        return redirect()->route('partidos.index')->with('success', 'Partido atualizado.');
    }

    public function destroy(Partido $partido)
    {
        $partido->delete();
        return redirect()->route('partidos.index')->with('success', 'Partido removido.');
    }
}
