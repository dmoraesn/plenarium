<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Vereador;
use App\Http\Requests\SessaoStoreRequest;

class SessaoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Sessao::class);

        // Sessão em andamento com a sua lógica de contagem correta
        $sessaoEmAndamento = Sessao::where('status', 'aberta')
            ->with([
                'ordemDoDia' => fn ($q) => $q->limit(3),
                'ordemDoDia.materia.tipo',
                // Carrega apenas os registros de presença com status 'presente'
                'presencas' => fn ($q) => $q->where('status', 'presente')->with('vereador'),
            ])
            ->withCount([
                // Conta apenas os presentes e dá um alias para o resultado
                'presencas as presentes_count' => fn ($q) => $q->where('status', 'presente'),
            ])
            ->first();

        // Próxima sessão agendada
        $proximaSessao = Sessao::where('status', 'planejada')
            ->where('data', '>=', now())
            ->orderBy('data', 'asc')
            ->with([
                'ordemDoDia' => fn ($q) => $q->limit(3),
                'ordemDoDia.materia.tipo',
            ])
            ->first();

        // Lista paginada e total de vereadores
        $sessoes = Sessao::latest('data')->paginate(10);
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
        $sessao = new Sessao(['data' => now()->format('Y-m-d'), 'ano' => now()->year]);
        return view('sessoes.create', compact('sessao'));
    }

    public function store(SessaoStoreRequest $request)
    {
        $this->authorize('create', Sessao::class);
        Sessao::create($request->validated());
        return redirect()->route('sessoes.index')->with('success', 'Sessão agendada com sucesso.');
    }

    public function abrir(Sessao $sessao)
    {
        $this->authorize('update', $sessao);
        $sessao->update(['status' => 'aberta', 'aberta_em' => now()]);
        return back()->with('success', 'Sessão aberta com sucesso!');
    }

    public function encerrar(Sessao $sessao)
    {
        $this->authorize('update', $sessao);
        $sessao->update(['status' => 'encerrada', 'encerrada_em' => now()]);
        return back()->with('success', 'Sessão encerrada com sucesso!');
    }

    // ... outros métodos ...
}
