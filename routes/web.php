<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdemDoDiaController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PresencaController;
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
    // --------------------------------------------------
    // Perfil
    // --------------------------------------------------
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --------------------------------------------------
    // Sessões
    // --------------------------------------------------
    // CRUD padrão (parâmetro singular explícito {sessao})
    Route::resource('sessoes', SessaoController::class)
        ->parameters(['sessoes' => 'sessao']);

    // Ações de status (idempotentes)
    Route::put('/sessoes/{sessao}/open',  [SessaoController::class, 'open'])->name('sessoes.open');
    Route::put('/sessoes/{sessao}/close', [SessaoController::class, 'close'])->name('sessoes.close');

    // --------------------------------------------------
    // Ordem do Dia
    // --------------------------------------------------
    Route::get('/ordem-do-dia', [OrdemDoDiaController::class, 'root'])->name('ordem.index');
    Route::get('/sessoes/{sessao}/ordem-do-dia', [OrdemDoDiaController::class, 'index'])->name('sessoes.ordem.index');
    Route::post('/sessoes/{sessao}/ordem-do-dia/itens', [OrdemDoDiaController::class, 'store'])->name('sessoes.ordem.store');
    Route::delete('/ordem-itens/{item}', [OrdemDoDiaController::class, 'destroy'])
        ->whereNumber('item')
        ->name('sessoes.ordem.destroy');

    // --------------------------------------------------
    // Presenças
    // --------------------------------------------------
    // Raiz → sessão mais recente
    Route::get('/presencas', [PresencaController::class, 'root'])->name('presencas.index');

    // Presenças por sessão + ações
    Route::prefix('/sessoes/{sessao}/presencas')->name('sessoes.presencas.')->group(function () {
        Route::get('/', [PresencaController::class, 'index'])->name('index');

        // Ações individuais
        Route::patch('/{vereador}/toggle', [PresencaController::class, 'toggle'])->name('toggle');
        Route::patch('/{vereador}/justificar', [PresencaController::class, 'justificar'])->name('justificar');
        Route::delete('/{vereador}/justificar', [PresencaController::class, 'removerJustificativa'])->name('justificar.delete');

        // Ações em massa
        Route::patch('/bulk/presentes', [PresencaController::class, 'bulkPresentes'])->name('bulk.presentes');
        Route::patch('/bulk/reset', [PresencaController::class, 'bulkReset'])->name('bulk.reset');
    });

    // --------------------------------------------------
    // Vereadores e Matérias
    // --------------------------------------------------
    Route::resource('vereadores', VereadorController::class)
        ->parameters(['vereadores' => 'vereador'])
        ->names('vereadores');
    Route::patch('vereadores/{vereador}/toggle', [VereadorController::class, 'toggle'])->name('vereadores.toggle');

    Route::resource('materias', MateriaController::class)->names('materias');
    Route::patch('materias/{materia}/status', [MateriaController::class, 'updateStatus'])->name('materias.status');
});

// --------------------------------------------------
// Páginas WIP (Work in Progress)
// --------------------------------------------------
Route::view('/wip', 'wip')->name('wip');
Route::view('/configuracoes', 'wip')->name('configuracoes.index');
Route::view('/relatorios', 'wip')->name('relatorios.index');

require __DIR__.'/auth.php';
