<?php

namespace App\Http\Controllers;

use App\Models\Presenca;
use App\Models\Sessao;
use App\Models\Vereador;
use Illuminate\Http\Request;

class PresencaController extends Controller
{
    /**
     * GET /presencas → sessão mais recente
     */
   public function root(Request $request)
{
    // 1) Se existir sessão "aberta", pega a mais recente por aberta_em
    $sessao = \App\Models\Sessao::where('status', 'aberta')
        ->orderByDesc('aberta_em')
        ->first();

    // 2) Senão, pega a sessão mais recente por data
    if (!$sessao) {
        $sessao = \App\Models\Sessao::orderByDesc('data')->firstOrFail();
    }

    return $this->index($request, $sessao);
}


    /**
     * Garante que exista uma linha de presenca para cada vereador ATIVO.
     * Evita duplicidade via upsert em (sessao_id, vereador_id).
     */
    private function ensureLinhasParaAtivos(Sessao $sessao): void
    {
        $ativos = Vereador::where('ativo', true)->pluck('id');
        $ja     = Presenca::where('sessao_id', $sessao->id)->pluck('vereador_id');
        $faltas = $ativos->diff($ja);

        if ($faltas->isEmpty()) {
            return;
        }

        $payload = $faltas->map(fn ($vid) => [
            'sessao_id'            => $sessao->id,
            'vereador_id'          => $vid,
            'status'               => 'ausente',           // padrão
            'marcado_por_user_id'  => auth()->id(),
            'created_at'           => now(),
            'updated_at'           => now(),
        ])->all();

        Presenca::upsert(
            $payload,
            ['sessao_id', 'vereador_id'],
            ['status', 'updated_at']
        );
    }

    /**
     * GET /sessoes/{sessao}/presencas
     */
    public function index(Request $request, Sessao $sessao)
    {
        $this->authorize('view', $sessao);

        // Garante linhas para todos os ativos
        $this->ensureLinhasParaAtivos($sessao);

        // Lista apenas vereadores ATIVOS e ordena por nome parlamentar
        $idsAtivos = Vereador::where('ativo', true)->pluck('id');

        $presencas = Presenca::with('vereador')
            ->where('sessao_id', $sessao->id)
            ->whereIn('vereador_id', $idsAtivos)
            ->join('vereadores', 'presencas.vereador_id', '=', 'vereadores.id')
            ->orderBy('vereadores.nome_parlamentar')
            ->select('presencas.*')
            ->get();

        $totais = [
            'presentes' => $presencas->where('status', 'presente')->count(),
            'ausentes'  => $presencas->where('status', 'ausente')->count(),
            'total'     => $presencas->count(),
        ];

        return view('presencas.index', compact('sessao', 'presencas', 'totais'));
    }

    /**
     * PATCH /sessoes/{sessao}/presencas/{vereador}/toggle
     */
    public function toggle(Request $request, Sessao $sessao, Vereador $vereador)
    {
        $this->authorize('update', $sessao);

        $p = Presenca::firstOrCreate(
            ['sessao_id' => $sessao->id, 'vereador_id' => $vereador->id],
            ['status' => 'ausente', 'marcado_por_user_id' => auth()->id()]
        );

        $novo = $p->status === 'presente' ? 'ausente' : 'presente';

        $p->fill([
            'status'               => $novo,
            'alterado_em'          => now(),
            'alterado_por_user_id' => auth()->id(),
        ]);

        if ($novo === 'presente') {
            $p->marcado_em    = now();
            $p->justificativa = null; // limpa justificativa ao marcar presença
        }

        $p->save();

        return back()->with('success', 'Presença atualizada.');
    }

    /**
     * PATCH /sessoes/{sessao}/presencas/{vereador}/justificar
     */
    public function justificar(Request $request, Sessao $sessao, Vereador $vereador)
    {
        $this->authorize('update', $sessao);

        $data = $request->validate([
            'justificativa' => ['required', 'string', 'max:255'],
        ]);

        $p = Presenca::firstOrCreate(
            ['sessao_id' => $sessao->id, 'vereador_id' => $vereador->id],
            ['status' => 'ausente', 'marcado_por_user_id' => auth()->id()]
        );

        $p->fill([
            'status'               => 'ausente',
            'justificativa'        => $data['justificativa'],
            'alterado_em'          => now(),
            'alterado_por_user_id' => auth()->id(),
        ])->save();

        return back()->with('success', 'Justificativa registrada.');
    }

    /**
     * DELETE /sessoes/{sessao}/presencas/{vereador}/justificar
     */
    public function removerJustificativa(Request $request, Sessao $sessao, Vereador $vereador)
    {
        $this->authorize('update', $sessao);

        $p = Presenca::where('sessao_id', $sessao->id)
            ->where('vereador_id', $vereador->id)
            ->firstOrFail();

        $p->fill([
            'justificativa'        => null,
            'alterado_em'          => now(),
            'alterado_por_user_id' => auth()->id(),
        ])->save();

        return back()->with('success', 'Justificativa removida.');
    }

    /**
     * PATCH /sessoes/{sessao}/presencas/bulk/presentes
     */
    public function bulkPresentes(Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        // Garante que existam linhas para todos os ativos antes da ação em massa
        $this->ensureLinhasParaAtivos($sessao);

        Presenca::where('sessao_id', $sessao->id)->update([
            'status'               => 'presente',
            'justificativa'        => null,
            'marcado_em'           => now(),
            'alterado_em'          => now(),
            'alterado_por_user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Todos marcados como presentes.');
    }

    /**
     * PATCH /sessoes/{sessao}/presencas/bulk/reset
     */
    public function bulkReset(Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        // Garante que existam linhas para todos os ativos antes da ação em massa
        $this->ensureLinhasParaAtivos($sessao);

        Presenca::where('sessao_id', $sessao->id)->update([
            'status'               => 'ausente',
            'justificativa'        => null,
            'alterado_em'          => now(),
            'alterado_por_user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Todos resetados para ausente.');
    }
}
