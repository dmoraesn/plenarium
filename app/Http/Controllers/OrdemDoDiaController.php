<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReordenarOrdemRequest;
use App\Models\Materia;
use App\Models\OrdemItem;
use App\Models\Sessao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrdemDoDiaController extends Controller
{
    /**
     * GET /ordem-do-dia
     * Redireciona para a pauta da sessão mais recente (por data).
     */
    public function root(Request $request)
    {
        $sessao = Sessao::orderByDesc('data')->firstOrFail();

        // Reutiliza a lógica do index (o index faz a autorização)
        return $this->index($request, $sessao);
    }

    /**
     * GET /sessoes/{sessao}/ordem-do-dia
     * Exibe a Ordem do Dia para a sessão informada.
     */
    public function index(Request $request, Sessao $sessao)
    {
        $this->authorize('view', $sessao);

        // Itens já na pauta
        $itens = $sessao->ordemDoDia()
            ->with('materia.tipo')
            ->get();

        $idsNaPauta = $itens->pluck('materia_id');

        // Matérias "pronta_pauta" que NÃO estão na pauta atual
        $materiasDisponiveis = Materia::where('status', 'pronta_pauta')
            ->whereNotIn('id', $idsNaPauta)
            ->orderBy('ano', 'desc')
            ->orderBy('numero', 'asc')
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'sessao' => $sessao->only(['id','numero','ano','tipo','status','data']),
                'itens'  => $itens->map(fn ($i) => [
                    'id'       => $i->id,
                    'posicao'  => $i->posicao,
                    'situacao' => $i->situacao,
                    'materia'  => [
                        'id'     => $i->materia->id,
                        'tipo'   => $i->materia->tipo->sigla ?? null,
                        'numero' => $i->materia->numero,
                        'ano'    => $i->materia->ano,
                        'ementa' => $i->materia->ementa,
                    ],
                ]),
                'materias_disponiveis' => $materiasDisponiveis->map(fn ($m) => [
                    'id'     => $m->id,
                    'tipo'   => $m->tipo->sigla ?? null,
                    'numero' => $m->numero,
                    'ano'    => $m->ano,
                    'ementa' => $m->ementa,
                ]),
            ]);
        }

        return view('sessoes.ordem.index', compact('sessao', 'itens', 'materiasDisponiveis'));
    }

    /**
     * POST /sessoes/{sessao}/ordem-do-dia/itens
     * Adiciona uma matéria à pauta da sessão.
     */
    public function store(Request $request, Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        $validated = $request->validate([
            'materia_id' => [
                'required',
                'integer',
                Rule::exists('materias', 'id'),
                // Unicidade da matéria na pauta da MESMA sessão
                Rule::unique('ordem_itens', 'materia_id')
                    ->where(fn ($q) => $q->where('sessao_id', $sessao->id)),
            ],
        ], [
            'materia_id.unique' => 'Esta matéria já está na pauta desta sessão.',
        ]);

        // Próxima posição
        $nextPos = ((int) $sessao->ordemDoDia()->max('posicao')) + 1;

        $item = OrdemItem::create([
            'sessao_id'  => $sessao->id,
            'materia_id' => $validated['materia_id'],
            'posicao'    => $nextPos,
            'situacao'   => 'em_pauta', // Assumindo que 'situacao' existe no model OrdemItem
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'created' => true,
                'item_id' => $item->id,
                'posicao' => $item->posicao,
            ], 201);
        }

        // Redireciona com flash de sucesso
        return redirect()
            ->route('sessoes.ordem.index', $sessao)
            ->with('success', 'Matéria adicionada à pauta com sucesso!');
    }

    /**
     * DELETE /ordem-itens/{item}
     * Remove um item da pauta.
     */
    public function destroy(OrdemItem $item)
    {
        // Autoriza pela sessão "dona" do item
        $this->authorize('update', $item->sessao);

        $sessao = $item->sessao; // usado para redirecionar
        $item->delete();

        // TODO: Reordenar as posições para não deixar "buracos"

        if (request()->wantsJson()) {
            return response()->json(['deleted' => true]);
        }

        return redirect()
            ->route('sessoes.ordem.index', $sessao)
            ->with('success', 'Item removido da pauta com sucesso.');
    }

    /**
     * PATCH /sessoes/{sessao}/ordem-do-dia/reordenar
     * Reordena itens da pauta via payload validado.
     */
    public function reorder(ReordenarOrdemRequest $request, Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        $itens = collect($request->validated()['itens']);

        DB::transaction(function () use ($itens, $sessao) {
            foreach ($itens as $i) {
                OrdemItem::where('sessao_id', $sessao->id)
                    ->where('id', $i['id']) // Supondo que o payload envie 'id'
                    ->update(['posicao' => $i['posicao']]);
            }
        });

        return response()->json(['reordered' => true]);
    }
}
