<?php

namespace App\Http\Controllers;

use App\Models\TipoVotacao;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TipoVotacaoController extends Controller
{
    public function index()
    {
        $tiposVotacao = TipoVotacao::orderBy('created_at', 'desc')->paginate(10);
        return view('tipos_votacao.index', compact('tiposVotacao'));
    }

    public function create()
    {
        $model = new TipoVotacao(['ativo' => true]);
        return view('tipos_votacao.create', compact('model'));
    }

    // Se estiver usando Form Requests, substitua Request por StoreTipoVotacaoRequest
    public function store(Request $request)
    {
        // A validação deve ser movida para um Form Request
        $data = $request->validate([
            'nome' => 'required|string|max:255|unique:tipos_votacao',
            'descricao' => 'nullable|string',
            'criterio' => 'required|in:maioria_simples,maioria_absoluta,maioria_qualificada,personalizado',
            'percentual' => 'nullable|numeric|min:1|max:100',
            'min_votos' => 'nullable|numeric|min:1',
            'condicoes_adicionais' => 'nullable|string',
        ]);
        
        $data['ativo'] = $request->has('ativo');

        TipoVotacao::create($data);

        return redirect()
            ->route('config.tipos-votacao.index')
            ->with('success', 'Tipo de Votação criado com sucesso.');
    }
    
    // Variável padronizada para $model
    public function edit(TipoVotacao $model)
    {
        return view('tipos_votacao.edit', compact('model'));
    }

    // Se estiver usando Form Requests, substitua Request por UpdateTipoVotacaoRequest
    public function update(Request $request, TipoVotacao $model)
    {
        // A validação deve ser movida para um Form Request
        $data = $request->validate([
            'nome' => 'required|string|max:255|unique:tipos_votacao,nome,' . $model->id,
            'descricao' => 'nullable|string',
            'criterio' => 'required|in:maioria_simples,maioria_absoluta,maioria_qualificada,personalizado',
            'percentual' => 'nullable|numeric|min:1|max:100',
            'min_votos' => 'nullable|numeric|min:1',
            'condicoes_adicionais' => 'nullable|string',
        ]);
        
        $data['ativo'] = $request->has('ativo');

        $model->update($data);

        return redirect()
            ->route('config.tipos-votacao.index')
            ->with('success', 'Tipo de Votação atualizado com sucesso.');
    }
    
    // Variável padronizada para $model
    public function destroy(TipoVotacao $model)
    {
        $model->delete();

        return redirect()
            ->route('config.tipos-votacao.index')
            ->with('success', 'Tipo de Votação excluído com sucesso.');
    }

    /**
     * Alterna o status 'ativo' de um Tipo de Votação.
     */
    public function toggle(TipoVotacao $model): RedirectResponse
    {
        $model->update([
            'ativo' => !$model->ativo
        ]);

        $status = $model->ativo ? 'ativado' : 'desativado';

        return redirect()
            ->route('config.tipos-votacao.index')
            ->with('success', "Tipo de Votação {$status} com sucesso.");
    }
}
