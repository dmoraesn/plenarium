<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdemDoDiaController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\MateriaController;
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
    // CRUD padrão
    Route::resource('sessoes', SessaoController::class);

    // Ações rápidas
    Route::patch('/sessoes/{sessao}/abrir',    [SessaoController::class, 'abrir'])->name('sessoes.abrir');
    Route::patch('/sessoes/{sessao}/encerrar', [SessaoController::class, 'encerrar'])->name('sessoes.encerrar');

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
Route::view('/presencas', 'wip')->name('sessoes.presencas.index');
Route::view('/configuracoes', 'wip')->name('configuracoes.index');
Route::view('/relatorios', 'wip')->name('relatorios.index');

require __DIR__.'/auth.php';
