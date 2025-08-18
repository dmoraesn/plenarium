<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReordenarOrdemRequest;
use App\Models\Materia;
use App\Models\OrdemItem;
use App\Models\Sessao;
use App\Models\TipoVotacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class OrdemDoDiaController extends Controller
{
    /**
     * GET /ordem-do-dia
     * Redireciona para a pauta da sessão mais recente.
     */
    public function root(Request $request)
    {
        $sessao = Sessao::orderByDesc('data')->firstOrFail();

        return $this->index($request, $sessao);
    }

    /**
     * GET /sessoes/{sessao}/ordem-do-dia
     * Exibe a Ordem do Dia para a sessão informada.
     */
    public function index(Request $request, Sessao $sessao)
    {
        $this->authorize('view', $sessao);

        $itens = $sessao->ordemDoDia()
            ->with('materia.tipo', 'materia.autores')
            ->get();

        $idsNaPauta = $itens->pluck('materia_id');

        $materiasDisponiveis = Materia::where('status', 'pronta_pauta')
            ->whereNotIn('id', $idsNaPauta)
            ->with('tipo', 'autores')
            ->orderBy('ano', 'desc')
            ->orderBy('numero', 'asc')
            ->get();

        $tiposVotacao = TipoVotacao::where('ativo', true)->orderBy('ordenacao')->get();

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
                        'autores' => $i->materia->autores->pluck('nome_parlamentar')->implode(', '),
                    ],
                ]),
                'materias_disponiveis' => $materiasDisponiveis->map(fn ($m) => [
                    'id'     => $m->id,
                    'tipo'   => $m->tipo->sigla ?? null,
                    'numero' => $m->numero,
                    'ano'    => $m->ano,
                    'ementa' => $m->ementa,
                    'autores' => $m->autores->pluck('nome_parlamentar')->implode(', '),
                ]),
            ]);
        }

        return view('sessoes.ordem.index', compact('sessao', 'itens', 'materiasDisponiveis', 'tiposVotacao'));
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
                    ->where('id', $i['ordem_item_id'])
                    ->update(['posicao' => $i['posicao']]);
            }
        });

        return response()->json(['success' => true]);
    }

    /**
     * PATCH /sessoes/{sessao}/ordem-do-dia/{item}/votar
     * Inicia a votação para um item da pauta.
     */
    public function iniciarVotacao(Request $request, Sessao $sessao, OrdemItem $item)
    {
        $this->authorize('update', $sessao);

        $item->materia->update(['status' => 'em_votacao']);

        return back()->with('success', 'Votação iniciada para a matéria: ' . $item->materia->identificacao);
    }
    
    /**
     * POST /sessoes/{sessao}/ordem-do-dia/{item}/retirar
     * Retira uma matéria da pauta com justificativa.
     */
    public function retirarDePauta(Request $request, Sessao $sessao, OrdemItem $item)
    {
        $this->authorize('update', $sessao);
        
        $request->validate(['justificativa' => 'required|string|max:255']);

        $item->delete();

        // TODO: Reordenar as posições para não deixar "buracos"

        // Log de auditoria da retirada
        // activity()->performedOn($item->materia)
        //     ->causedBy(auth()->user())
        //     ->log('Matéria retirada da pauta com justificativa: ' . $request->justificativa);

        return back()->with('success', 'Matéria retirada da pauta com sucesso.');
    }
}
