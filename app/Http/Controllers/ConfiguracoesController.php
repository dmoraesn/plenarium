<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function index(Request $request)
    {
        return view('configuracoes.index'); // <-- não 'wip'
    }
}
