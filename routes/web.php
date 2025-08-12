<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdemDoDiaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Placeholders temporários (páginas em construção)
Route::view('/wip', 'wip')->name('wip');

Route::view('/vereadores', 'wip')->name('vereadores.index');
Route::view('/materias', 'wip')->name('materias.index');
Route::view('/sessoes', 'wip')->name('sessoes.index');
Route::view('/ordem-do-dia', 'wip')->name('sessoes.ordem.index');
Route::view('/presencas', 'wip')->name('sessoes.presencas.index');
Route::view('/configuracoes', 'wip')->name('configuracoes.index');
Route::view('/relatorios', 'wip')->name('relatorios.index');



Route::prefix('sessoes/{sessao}')->name('sessoes.')->group(function () {
    // Ordem do Dia
    Route::get('ordem-do-dia',        [OrdemDoDiaController::class, 'index'])->name('ordem.index');      // GET
    Route::post('ordem-do-dia',       [OrdemDoDiaController::class, 'store'])->name('ordem.store');      // POST
    Route::delete('ordem-do-dia/{item}', [OrdemDoDiaController::class, 'destroy'])
        ->whereNumber('item')->name('ordem.destroy');                                                     // DELETE
    Route::patch('ordem-do-dia/reordenar', [OrdemDoDiaController::class, 'reorder'])->name('ordem.reorder'); // PATCH
});
