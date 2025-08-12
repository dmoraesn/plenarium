<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdemDoDiaController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\VereadorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------------------
    // Sessões
    // ---------------------------
    Route::get('/sessoes', [SessaoController::class, 'index'])->name('sessoes.index');
    Route::get('/sessoes/{sessao}', [SessaoController::class, 'show'])->name('sessoes.show');

    // ---------------------------
    // Ordem do Dia
    // ---------------------------
    // nível 0 (sem redirect)
    Route::get('/ordem-do-dia', [OrdemDoDiaController::class, 'root'])->name('ordem.index');

    // por sessão
    Route::get('/sessoes/{sessao}/ordem-do-dia', [OrdemDoDiaController::class, 'index'])
        ->name('sessoes.ordem.index');

    Route::post('/sessoes/{sessao}/ordem-do-dia/itens', [OrdemDoDiaController::class, 'store'])
        ->name('sessoes.ordem.store');

    Route::delete('/ordem-itens/{item}', [OrdemDoDiaController::class, 'destroy'])
        ->whereNumber('item')
        ->name('sessoes.ordem.destroy');

    // ---------------------------
    // Vereadores (resource com parâmetro e nomes padronizados)
    // ---------------------------
    Route::resource('vereadores', VereadorController::class)
        ->parameters(['vereadores' => 'vereador'])
        ->names('vereadores');

    Route::patch('vereadores/{vereador}/toggle', [VereadorController::class, 'toggle'])
        ->name('vereadores.toggle');
});

// Páginas WIP (não colidem com controladores acima)
Route::view('/wip', 'wip')->name('wip');
Route::view('/materias', 'wip')->name('materias.index');
Route::view('/presencas', 'wip')->name('sessoes.presencas.index');
Route::view('/configuracoes', 'wip')->name('configuracoes.index');
Route::view('/relatorios', 'wip')->name('relatorios.index');

require __DIR__.'/auth.php';
