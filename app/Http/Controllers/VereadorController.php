<?php

namespace App\Http\Controllers;

use App\Models\Vereador;
use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\VereadorStoreRequest;
use App\Http\Requests\VereadorUpdateRequest;

class VereadorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Vereador::class);

        $q = trim($request->get('q', ''));
        $vereadores = Vereador::with('partido')
            ->when($q, fn ($w) =>
                $w->where('nome_parlamentar', 'like', "%{$q}%")
                  ->orWhere('nome_completo', 'like', "%{$q}%")
            )
            ->orderBy('nome_parlamentar')
            ->paginate(10);

        return view('vereadores.index', compact('vereadores', 'q'));
    }

    public function create()
    {
        $this->authorize('create', Vereador::class);

        $partidos = Partido::orderBy('sigla')->pluck('sigla', 'id');
        // Apenas na tela de criação criamos uma instância “em branco”
        $vereador = new Vereador(['ativo' => true]);

        return view('vereadores.create', compact('vereador', 'partidos'));
    }

    public function store(VereadorStoreRequest $request)
    {
        $this->authorize('create', Vereador::class);

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('vereadores', 'public');
        }

        Vereador::create($data);

        return redirect()
            ->route('vereadores.index')
            ->with('ok', 'Vereador criado com sucesso.');
    }

    // Edit não recria o modelo; usa o recebido via route model binding
    public function edit(Vereador $vereador)
    {
        $this->authorize('update', $vereador);

        $partidos = Partido::orderBy('sigla')->pluck('sigla', 'id');

        return view('vereadores.edit', compact('vereador', 'partidos'));
    }

    public function update(VereadorUpdateRequest $request, Vereador $vereador)
    {
        $this->authorize('update', $vereador);

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($vereador->foto) {
                Storage::disk('public')->delete($vereador->foto);
            }
            $data['foto'] = $request->file('foto')->store('vereadores', 'public');
        }

        $vereador->update($data);

        return redirect()
            ->route('vereadores.index')
            ->with('ok', 'Vereador atualizado.');
    }

    public function destroy(Vereador $vereador)
    {
        $this->authorize('delete', $vereador);

        if ($vereador->foto) {
            Storage::disk('public')->delete($vereador->foto);
        }

        $vereador->delete();

        return back()->with('ok', 'Removido com sucesso.');
    }

    public function toggle(Vereador $vereador)
    {
        $this->authorize('update', $vereador);

        $vereador->update(['ativo' => ! $vereador->ativo]);

        return back()->with('ok', 'Status atualizado.');
    }
}
