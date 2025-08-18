<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartidoRequest; // Supondo que você tenha um Form Request
use App\Models\Partido;
use Illuminate\Http\Request;

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

    public function store(PartidoRequest $request) // Usando o Form Request
    {
        Partido::create($request->validated());
        
        // ROTA CORRIGIDA
        return redirect()->route('config.partidos.index')->with('success', 'Partido criado com sucesso.');
    }

    public function edit(Partido $partido)
    {
        $model = $partido;
        return view('partidos.edit', compact('model'));
    }

    public function update(PartidoRequest $request, Partido $partido) // Usando o Form Request
    {
        $partido->update($request->validated());

        // ROTA CORRIGIDA
        return redirect()->route('config.partidos.index')->with('success', 'Partido atualizado com sucesso.');
    }

    public function destroy(Partido $partido)
    {
        $partido->delete();

        // ROTA CORRIGIDA
        return redirect()->route('config.partidos.index')->with('success', 'Partido removido com sucesso.');
    }
}