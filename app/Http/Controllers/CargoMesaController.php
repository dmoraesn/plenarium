<?php

namespace App\Http\Controllers;

use App\Http\Requests\CargoMesaRequest;
use App\Models\CargoMesa;

class CargoMesaController extends Controller
{
    public function index()
    {
        $itens = CargoMesa::orderBy('posicao_ordenacao')->orderBy('descricao')->paginate(15);
        return view('cargo_mesa.index', compact('itens'));
    }

    public function create()
    {
        $model = new CargoMesa(['ativo' => true, 'cargo_unico' => true]);
        return view('cargo_mesa.create', compact('model'));
    }

    public function store(CargoMesaRequest $request)
    {
        CargoMesa::create($request->validated());
        return redirect()->route('config.cargo_mesa.index')->with('success', 'Cargo criado.');
    }

    public function edit(CargoMesa $cargoMesa)
    {
        $model = $cargoMesa;
        return view('cargo_mesa.edit', compact('model'));
    }

    public function update(CargoMesaRequest $request, CargoMesa $cargoMesa)
    {
        $cargoMesa->update($request->validated());
        return redirect()->route('config.cargo_mesa.index')->with('success', 'Cargo atualizado.');
    }

    public function destroy(CargoMesa $cargoMesa)
    {
        $cargoMesa->delete();
        return redirect()->route('config.cargo_mesa.index')->with('success', 'Cargo removido.');
    }
}
