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
    // GET /sessoes/{sessao}/ordem-do-dia
    public function index(\Illuminate\Http\Request $request, Sessao $sessao)
{
    $itens = $sessao->ordemItens()->with('materia.tipo')->get();

    if ($request->wantsJson()) {
        return response()->json([
            'sessao' => $sessao->only(['id','numero','ano','tipo','status','data']),
            'itens'  => $itens->map(fn($i) => [
                'id' => $i->id,
                'posicao' => $i->posicao,
                'situacao' => $i->situacao,
                'materia' => [
                    'id' => $i->materia->id,
                    'tipo' => $i->materia->tipo->sigla ?? null,
                    'numero' => $i->materia->numero,
                    'ano' => $i->materia->ano,
                    'ementa' => $i->materia->ementa,
                ],
            ]),
        ]);
    }

    // HTML (Blade)
    $materiasDisponiveis = \App\Models\Materia::where('status', 'pronta_pauta')
        ->whereNotIn('id', $itens->pluck('materia_id'))
        ->orderBy('ano', 'desc')->orderBy('numero')
        ->with('tipo')
        ->get();

    return view('sessoes.ordem.index', compact('sessao', 'itens', 'materiasDisponiveis'));
}


    // POST /sessoes/{sessao}/ordem-do-dia
    public function store(Request $request, Sessao $sessao)
    {
        $data = $request->validate([
            'materia_id' => ['required','integer', Rule::exists('materias','id')],
        ]);

        // impedir duplicidade na sessão
        $exists = OrdemItem::where('sessao_id', $sessao->id)
            ->where('materia_id', $data['materia_id'])
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'Matéria já está na pauta desta sessão.'], 422);
        }

        $nextPos = (int) OrdemItem::where('sessao_id', $sessao->id)->max('posicao') + 1;

        $item = OrdemItem::create([
            'sessao_id' => $sessao->id,
            'materia_id' => $data['materia_id'],
            'posicao' => $nextPos,
            'situacao' => 'em_pauta',
        ]);

        return response()->json(['created' => true, 'item_id' => $item->id, 'posicao' => $item->posicao], 201);
    }

    // DELETE /sessoes/{sessao}/ordem-do-dia/{item}
    public function destroy(Sessao $sessao, $item)
    {
        $ordem = OrdemItem::where('sessao_id', $sessao->id)->where('id', $item)->first();
        if (!$ordem) {
            return response()->json(['message' => 'Item não encontrado para esta sessão.'], 404);
        }
        $ordem->delete();

        return response()->json(['deleted' => true]);
    }

    // PATCH /sessoes/{sessao}/ordem-do-dia/reordenar
    public function reorder(ReordenarOrdemRequest $request, Sessao $sessao)
    {
        $itens = collect($request->validated()['itens']);

        DB::transaction(function () use ($itens, $sessao) {
            foreach ($itens as $i) {
                OrdemItem::where('sessao_id', $sessao->id)
                    ->where('id', $i['id'])
                    ->update(['posicao' => $i['posicao']]);
            }
        });

        return response()->json(['reordered' => true]);
    }
}
