<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdemDoDiaController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\TipoNormaController;
use App\Http\Controllers\NormaJuridicaController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\LegislaturaController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\TipoExpedienteController;
use App\Http\Controllers\CargoMesaController;
use App\Http\Controllers\TipoMateriaController;
use App\Http\Controllers\TipoTramitacaoController;
use App\Http\Controllers\TipoVotacaoController;
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
    // Ordem do Dia (ATUALIZADO)
    // --------------------------------------------------
    Route::get('/ordem-do-dia', [OrdemDoDiaController::class, 'root'])->name('ordem-do-dia.index');
    Route::get('/sessoes/{sessao}/ordem-do-dia', [OrdemDoDiaController::class, 'index'])->name('sessoes.ordem.index');
    Route::post('/sessoes/{sessao}/ordem-do-dia/itens', [OrdemDoDiaController::class, 'store'])->name('sessoes.ordem.store');
    Route::delete('/ordem-itens/{item}', [OrdemDoDiaController::class, 'destroy'])
        ->whereNumber('item')
        ->name('sessoes.ordem.destroy');
    // Rota para a reordenação (PATCH)
    Route::patch('/sessoes/{sessao}/ordem-do-dia/reordenar', [OrdemDoDiaController::class, 'reorder'])
        ->name('sessoes.ordem.reorder');
    Route::patch('/sessoes/{sessao}/ordem-do-dia/{item}/votar', [OrdemDoDiaController::class, 'iniciarVotacao'])
        ->whereNumber('item')
        ->name('sessoes.ordem.votar');
    Route::post('/sessoes/{sessao}/ordem-do-dia/{item}/retirar', [OrdemDoDiaController::class, 'retirarDePauta'])
        ->whereNumber('item')
        ->name('sessoes.ordem.retirar');

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
        ->parameters(['vereadores' => 'vereador']);
    Route::patch('vereadores/{vereador}/toggle', [VereadorController::class, 'toggle'])->name('vereadores.toggle');

    Route::resource('materias', MateriaController::class);
    Route::patch('materias/{materia}/status', [MateriaController::class, 'updateStatus'])->name('materias.status');

    // --------------------------------------------------
    // Configurações
    // --------------------------------------------------
    Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');

    Route::prefix('configuracoes')
        ->name('config.')
        ->group(function () {

            Route::resource('tipos-materia', TipoMateriaController::class)
                ->parameters(['tipos-materia' => 'tipoMateria'])
                ->except(['show']);
            Route::patch('tipos-materia/{tipoMateria}/toggle', [TipoMateriaController::class, 'toggle'])->name('tipos-materia.toggle');

            Route::resource('tipos-votacao', TipoVotacaoController::class)
                ->parameters(['tipos-votacao' => 'tipoVotacao'])
                ->except(['show']);
            Route::patch('tipos-votacao/{tipoVotacao}/toggle', [TipoVotacaoController::class, 'toggle'])->name('tipos-votacao.toggle');

            Route::resource('tipos-expediente', TipoExpedienteController::class)
                ->parameters(['tipos-expediente' => 'tipoExpediente'])
                ->except(['show']);
            Route::patch('tipos-expediente/{tipoExpediente}/toggle', [TipoExpedienteController::class, 'toggle'])->name('tipos-expediente.toggle');

            Route::resource('tipos-tramitacao', TipoTramitacaoController::class)
                ->parameters(['tipos-tramitacao' => 'tipoTramitacao'])
                ->except(['show']);

            Route::resource('legislaturas', LegislaturaController::class)
                ->parameters(['legislaturas' => 'legislatura'])
                ->except(['show']);

            Route::resource('partidos', PartidoController::class)
                ->parameters(['partidos' => 'partido'])
                ->except(['show']);

            Route::resource('tipo-normas', TipoNormaController::class)
                ->parameters(['tipo-normas' => 'tipoNorma'])
                ->except(['show']);

            Route::resource('normas', NormaJuridicaController::class)
                ->parameters(['normas' => 'normaJuridica'])
                ->except(['show']);

            Route::resource('cargos-mesa', CargoMesaController::class)
                ->parameters(['cargos-mesa' => 'cargoMesa'])
                ->except(['show']);

            // --------------------------------------------
            // Parâmetros (mantido como PUT para compatibilidade)
            // --------------------------------------------
            Route::get('parametros', [SettingController::class, 'edit'])->name('settings.edit');
            Route::put('parametros', [SettingController::class, 'update'])->name('settings.update');
        });

    // --------------------------------------------------
    // Páginas WIP
    // --------------------------------------------------
    Route::view('/wip', 'wip')->name('wip');
    Route::view('/relatorios', 'wip')->name('relatorios.index');
});

require __DIR__.'/auth.php';
