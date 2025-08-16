<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdemDoDiaController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\TipoNormaController;
use App\Http\Controllers\NormaJuridicaController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\LegislaturaController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\TipoExpedienteController;
use App\Http\Controllers\CargoMesaController;
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
    Route::resource('sessoes', SessaoController::class)
        ->parameters(['sessoes' => 'sessao']);

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
    Route::get('/presencas', [PresencaController::class, 'root'])->name('presencas.index');

    Route::prefix('/sessoes/{sessao}/presencas')->name('sessoes.presencas.')->group(function () {
        Route::get('/', [PresencaController::class, 'index'])->name('index');

        Route::patch('/{vereador}/toggle', [PresencaController::class, 'toggle'])->name('toggle');
        Route::patch('/{vereador}/justificar', [PresencaController::class, 'justificar'])->name('justificar');
        Route::delete('/{vereador}/justificar', [PresencaController::class, 'removerJustificativa'])->name('justificar.delete');

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

    // --------------------------------------------------
    // Partidos
    // --------------------------------------------------
    Route::resource('partidos', PartidoController::class)->except(['show']);

    // --------------------------------------------------
    // Configurações
    // --------------------------------------------------
    Route::get('/configuracoes', [ConfiguracoesController::class, 'index'])->name('config.index');

    Route::prefix('configuracoes')->name('config.')->group(function () {
        // Tipos de Normas
        Route::resource('tipo-normas', TipoNormaController::class)
            ->parameters(['tipo-normas' => 'tipoNorma'])
            ->names('tipo_normas')
            ->except(['show']);

        // Normas Jurídicas
        Route::resource('normas', NormaJuridicaController::class)
            ->parameters(['normas' => 'norma'])
            ->names('normas')
            ->except(['show']);

        // Legislaturas
        Route::resource('legislaturas', LegislaturaController::class)->except(['show']);

        // Parâmetros do Sistema
        Route::get('parametros', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('parametros', [SettingController::class, 'update'])->name('settings.update');

        // Tipos de Expediente
        Route::resource('tipos-expediente', TipoExpedienteController::class)
            ->parameters(['tipos-expediente' => 'tipoExpediente'])
            ->names('tipo_expediente')
            ->except(['show']);

        // Cargos da Mesa
        Route::resource('cargos-mesa', CargoMesaController::class)
            ->parameters(['cargos-mesa' => 'cargoMesa'])
            ->names('cargo_mesa')
            ->except(['show']);
    });
});

// --------------------------------------------------
// Páginas WIP
// --------------------------------------------------
Route::view('/wip', 'wip')->name('wip');
// Route::view('/configuracoes', 'wip')->name('configuracoes.index'); // removida/substituída
Route::view('/relatorios', 'wip')->name('relatorios.index');

require __DIR__.'/auth.php';
