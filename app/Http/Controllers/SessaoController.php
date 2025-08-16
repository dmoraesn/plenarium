<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Vereador;
use App\Models\Presenca;
use App\Http\Requests\SessaoStoreRequest;
use App\Http\Requests\SessaoUpdateRequest;

class SessaoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Sessao::class);

        // Sessão em andamento (mais recente por data)
        $sessaoEmAndamento = Sessao::where('status', Sessao::ST_ABERTA)
            ->orderByDesc('data')
            ->with([
                'ordemDoDia' => fn ($q) => $q->limit(3)->with('materia.tipo'),
                'presencas'  => fn ($q) => $q->where('status', 'presente')->with('vereador'),
            ])
            ->withCount(['presencas as presentes_count' => fn ($q) => $q->where('status', 'presente')])
            ->first();

        // Próxima sessão planejada (mais próxima no futuro)
        $proximaSessao = Sessao::where('status', Sessao::ST_PLANEJADA)
            ->whereDate('data', '>=', now()->toDateString())
            ->orderBy('data', 'asc')
            ->with(['ordemDoDia' => fn ($q) => $q->limit(3)->with('materia.tipo')])
            ->first();

        // Histórico paginado
        $sessoes = Sessao::orderByDesc('data')->paginate(10);

        // Total de vereadores ativos
        $totalVereadores = Vereador::where('ativo', true)->count();

        return view('sessoes.index', compact(
            'sessaoEmAndamento',
            'proximaSessao',
            'sessoes',
            'totalVereadores'
        ));
    }

    public function create()
    {
        $this->authorize('create', Sessao::class);

        $sessao = new Sessao([
            'data' => now()->format('Y-m-d'),
            'ano'  => now()->year,
        ]);

        return view('sessoes.create', compact('sessao'));
    }

    public function store(SessaoStoreRequest $request)
    {
        $this->authorize('create', Sessao::class);

        // O mutator de status no Model garante normalização.
        Sessao::create($request->validated());

        return redirect()->route('sessoes.index')
            ->with('success', 'Sessão agendada com sucesso.');
    }

    public function edit(Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        return view('sessoes.edit', compact('sessao'));
    }

    public function update(SessaoUpdateRequest $request, Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        // O mutator de status normaliza caso esteja no payload.
        $sessao->update($request->validated());

        return redirect()->route('sessoes.index')
            ->with('success', 'Sessão atualizada com sucesso.');
    }

    /**
     * PUT /sessoes/{sessao}/open
     * Patch solicitado: tornar idempotente e inicializar presenças.
     */
    public function open(Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        // Garante status aberto (idempotente)
        if ($sessao->status !== 'aberta') {
            $sessao->update([
                'status'    => 'aberta',
                'aberta_em' => now(),
            ]);
        }

        // Inicializa presenças como "ausente" para todos os vereadores ativos
        $ativos = Vereador::where('ativo', 1)->pluck('id');
        $ja     = Presenca::where('sessao_id', $sessao->id)->pluck('vereador_id');
        $faltam = $ativos->diff($ja);

        if ($faltam->isNotEmpty()) {
            Presenca::upsert(
                $faltam->map(fn ($vid) => [
                    'sessao_id'           => $sessao->id,
                    'vereador_id'         => $vid,
                    'status'              => 'ausente',
                    'marcado_por_user_id' => auth()->id(),
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ])->all(),
                ['sessao_id', 'vereador_id'],
                ['status', 'updated_at']
            );
        }

        return back()->with('success', 'Sessão aberta e presenças inicializadas.');
    }

    /**
     * PUT /sessoes/{sessao}/close
     * Usar status canônicos.
     */
    public function close(Sessao $sessao)
    {
        $this->authorize('update', $sessao);

        if ($sessao->normalized_status !== Sessao::ST_ABERTA) {
            return back()->with('error','Apenas sessões abertas podem ser encerradas.');
        }

        // grava normalizado
        $sessao->forceFill(['status' => Sessao::ST_ENCERRADA])->save();

        return redirect()->route('sessoes.index')->with('success','Sessão encerrada com sucesso!');
    }

    /**
     * DELETE /sessoes/{sessao}
     */
    public function destroy(Sessao $sessao)
    {
        $this->authorize('delete', $sessao);

        $sessao->delete();

        return redirect()->route('sessoes.index')
            ->with('success', 'Sessão excluída com sucesso.');
    }
}
