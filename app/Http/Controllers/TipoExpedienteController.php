<?php

namespace App\Http\Controllers;

use App\Models\TipoExpediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreTipoExpedienteRequest;
use App\Http\Requests\UpdateTipoExpedienteRequest;

class TipoExpedienteController extends Controller
{
    /**
     * GET /configuracoes/tipos-expediente
     * Nome: config.tipos-expediente.index
     */
    public function index(Request $request)
    {
        $q = TipoExpediente::query();

        // Filtro simples por termo (opcional)
        if ($term = trim((string) $request->get('q'))) {
            $q->where(function ($w) use ($term) {
                $w->where('descricao', 'like', "%{$term}%")
                    ->orWhere('observacao', 'like', "%{$term}%");
            });
        }

        // Ordenação padrão: ordenacao ASC, depois descricao ASC
        $itens = $q->orderByRaw('COALESCE(ordenacao, 2147483647) asc')
                    ->orderBy('descricao')
                    ->paginate(10)
                    ->withQueryString();

        return view('tipo_expediente.index', compact('itens'));
    }

    /**
     * GET /configuracoes/tipos-expediente/create
     * Nome: config.tipos-expediente.create
     */
    public function create()
    {
        // Variável padronizada para 'model'
        $model = new TipoExpediente(['ativo' => true]);
        return view('tipo_expediente.create', compact('model'));
    }

    /**
     * POST /configuracoes/tipos-expediente
     * Nome: config.tipos-expediente.store
     */
    public function store(StoreTipoExpedienteRequest $request)
    {
        $data = $request->validated();
        $data['ativo'] = (bool)($data['ativo'] ?? false); // Ajuste para valor padrão caso não venha

        DB::transaction(function () use ($data) {
            TipoExpediente::create($data);
        });

        return redirect()
            // Rota corrigida
            ->route('config.tipos-expediente.index')
            ->with('ok', 'Tipo de Expediente criado com sucesso.');
    }

    /**
     * GET /configuracoes/tipos-expediente/{tipoExpediente}/edit
     * Nome: config.tipos-expediente.edit
     */
    public function edit(TipoExpediente $tipoExpediente)
    {
        // Variável padronizada para 'model'
        $model = $tipoExpediente;
        return view('tipo_expediente.edit', compact('model'));
    }

    /**
     * PUT/PATCH /configuracoes/tipos-expediente/{tipoExpediente}
     * Nome: config.tipos-expediente.update
     */
    public function update(UpdateTipoExpedienteRequest $request, TipoExpediente $tipoExpediente)
    {
        $data = $request->validated();
        // A lógica de cast para boolean já está no Model, então podemos simplificar
        if (!array_key_exists('ativo', $data)) {
            $data['ativo'] = false;
        }

        DB::transaction(function () use ($tipoExpediente, $data) {
            $tipoExpediente->update($data);
        });

        return redirect()
            // Rota corrigida
            ->route('config.tipos-expediente.index')
            ->with('ok', 'Tipo de Expediente atualizado com sucesso.');
    }

    /**
     * DELETE /configuracoes/tipos-expediente/{tipoExpediente}
     * Nome: config.tipos-expediente.destroy
     */
    public function destroy(TipoExpediente $tipoExpediente)
    {
        try {
            DB::transaction(function () use ($tipoExpediente) {
                $tipoExpediente->delete();
            });

            return redirect()
                // Rota corrigida
                ->route('config.tipos-expediente.index')
                ->with('ok', 'Tipo de Expediente excluído.');
        } catch (QueryException $e) {
            if ((int) $e->getCode() === 23000) {
                $tipoExpediente->update(['ativo' => false]);
                return redirect()
                    // Rota corrigida
                    ->route('config.tipos-expediente.index')
                    ->with('ok', 'Registro possui vínculos. Foi inativado em vez de excluído.');
            }

            throw $e;
        }
    }

    /**
     * PATCH /configuracoes/tipos-expediente/{tipoExpediente}/toggle
     * Nome: config.tipos-expediente.toggle
     */
    public function toggle(TipoExpediente $tipoExpediente)
    {
        $novo = ! $tipoExpediente->ativo;

        $tipoExpediente->update(['ativo' => $novo]);

        return redirect()
            // Rota corrigida
            ->route('config.tipos-expediente.index')
            ->with('ok', 'Status atualizado para: ' . ($novo ? 'Ativo' : 'Inativo'));
    }
}