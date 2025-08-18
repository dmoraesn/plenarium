<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfiguracaoController extends Controller
{
    /**
     * Exibe a página principal de configurações com os cards dos módulos.
     */
    public function index(): View
    {
        return view('configuracoes.index');
    }
}