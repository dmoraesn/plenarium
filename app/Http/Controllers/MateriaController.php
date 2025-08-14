<?php

namespace App\Http\Controllers;

use App\Http\Requests\MateriaStoreRequest;
use App\Http\Requests\MateriaUpdateRequest;
use App\Http\Requests\MateriaStatusRequest;
use App\Models\Materia;
use App\Models\TipoMateria;
use App\Models\Vereador;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Materia::class);

        $q      = trim($request->get('q', ''));
        $status = $request->get('status');
        $tipoId = $request->get('tipo');

        $materias = Materia::with(['tipo','autores'])
            ->search($q)
            ->status($status)
            ->tipo($tipoId)
            ->orderByDesc('ano')
            ->orderBy('numero')
            ->paginate(10)
            ->withQueryString();

        $tipos = TipoMateria::orderBy('sigla')->pluck('sigla', 'id');

        return view('materias.index', compact('materias','q','status','tipoId','tipos'));
    }

    public function create()
    {
        $this->authorize('create', Materia::class);

        $materia = new Materia([
            'status' => 'rascunho',
            'ativo'  => true,
        ]);

        $tipos    = TipoMateria::orderBy('sigla')->pluck('sigla','id');
        $autores  = Vereador::orderBy('nome_parlamentar')->pluck('nome_parlamentar','id');

        return view('materias.create', compact('materia','tipos','autores'));
    }

    public function store(MateriaStoreRequest $request)
    {
        $this->authorize('create', Materia::class);

        // Obtém todos os dados validados
        $data = $request->validated();

        // Separa o array de autores do restante dos dados
        $autores = $data['autores'] ?? [];
        unset($data['autores']);

        // Cria a matéria com os dados que correspondem às colunas da tabela
        $materia = Materia::create($data);
        
        // Sincroniza os autores com a matéria recém-criada
        $materia->autores()->sync($autores);

        return redirect()
            ->route('materias.index')
            ->with('success', 'Matéria cadastrada com sucesso.');
    }

    public function edit(Materia $materia)
    {
        $this->authorize('update', $materia);

        $tipos   = TipoMateria::orderBy('sigla')->pluck('sigla','id');
        $autores = Vereador::orderBy('nome_parlamentar')->pluck('nome_parlamentar','id');

        $materia->load('autores');

        return view('materias.edit', compact('materia','tipos','autores'));
    }

    public function update(MateriaUpdateRequest $request, Materia $materia)
    {
        $this->authorize('update', $materia);

        $data = $request->validated();
        $autores = $data['autores'] ?? [];
        unset($data['autores']);

        $materia->update($data);
        $materia->autores()->sync($autores);

        return redirect()
            ->route('materias.index')
            ->with('success', 'Matéria atualizada.');
    }

    public function destroy(Materia $materia)
    {
        $this->authorize('delete', $materia);
        $materia->delete();

        return redirect()
            ->route('materias.index')
            ->with('success', 'Matéria removida.');
    }

    public function updateStatus(MateriaStatusRequest $request, Materia $materia)
    {
        $materia->update(['status' => $request->string('status')]);

        return back()->with('success', 'Status atualizado.');
    }
}
