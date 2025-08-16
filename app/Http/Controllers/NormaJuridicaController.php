<?php

namespace App\Http\Controllers;

use App\Http\Requests\NormaJuridicaRequest;
use App\Models\NormaJuridica;
use App\Models\TipoNorma;
use Illuminate\Http\Request;

class NormaJuridicaController extends Controller
{
    public function index(Request $request)
    {
        $q = NormaJuridica::with('tipoNorma')
            ->when($request->filled('tipo'), fn($qr) => $qr->where('tipo', (int)$request->input('tipo')))
            ->when($request->filled('ano'), fn($qr) => $qr->where('ano', (int)$request->input('ano')))
            ->orderByDesc('ano')->orderByDesc('numero');

        $itens = $q->paginate(15)->withQueryString();
        $tipos = TipoNorma::orderBy('descricao')->get();

        return view('normas.index', compact('itens', 'tipos'));
    }

    public function create()
    {
        $model = new NormaJuridica();
        $tipos = TipoNorma::orderBy('descricao')->get();
        return view('normas.create', compact('model', 'tipos'));
    }

    public function store(NormaJuridicaRequest $request)
    {
        $data = $request->validated();

        $exists = NormaJuridica::where('tipo', $data['tipo'])
            ->where('numero', $data['numero'])
            ->where('ano', $data['ano'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Já existe norma com este Tipo/Número/Ano.');
        }

        NormaJuridica::create($data);
        return redirect()->route('config.normas.index')->with('success', 'Norma jurídica criada.');
    }

    public function edit(NormaJuridica $norma)
    {
        $model = $norma;
        $tipos = TipoNorma::orderBy('descricao')->get();
        return view('normas.edit', compact('model', 'tipos'));
    }

    public function update(NormaJuridicaRequest $request, NormaJuridica $norma)
    {
        $data = $request->validated();

        $exists = NormaJuridica::where('tipo', $data['tipo'])
            ->where('numero', $data['numero'])
            ->where('ano', $data['ano'])
            ->where('id', '!=', $norma->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Já existe norma com este Tipo/Número/Ano.');
        }

        $norma->update($data);
        return redirect()->route('config.normas.index')->with('success', 'Norma jurídica atualizada.');
    }

    public function destroy(NormaJuridica $norma)
    {
        $norma->delete();
        return redirect()->route('config.normas.index')->with('success', 'Norma jurídica removida.');
    }
}
