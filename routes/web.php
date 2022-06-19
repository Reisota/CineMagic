<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\EstatisticasController;

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
    return redirect()->route('filmes');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Filmes
Route::get('filmes', [FilmeController::class, 'index'])->name('filmes'); //get de todos os filmes em exibição

Route::get('filmes/{id}', [FilmeController::class, 'info'])->name('info'); // get do filme pelo id

Route::get('filmes/sessao/{id}', [FilmeController::class, 'sessao'])->name('sessao'); // get do filme pelo id

Route::get('filmes/add-to-cart/{id}', [BilheteController::class, 'addToCart'])->name('add.to.cart'); 

Route::get('carrinho', [BilheteController::class, 'carrinho'])->name('carrinho');

Route::delete('remove-from-cart/{id}', [BilheteController::class, 'removeCart'])->name('remove.from.cart');

//Apenas Clientes
Route::middleware('cliente')->group(function () {

//clientes
Route::get('clientes', [ClienteController::class, 'index'])->name('clientes');

Route::get('clientes/{user}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');

Route::put('clientes/{user}', [ClienteController::class, 'update'])->name('clientes.update');


});




//Apenas funcionarios
Route::middleware('funcionario')->group(function () {
    Route::get('verificacao', [BilheteController::class, 'verificacao_index'])->name('verificacao');
    Route::put('verificacao/{bilhete}', [BilheteController::class, 'update'])->name('verificacao.edit');
    Route::get('verificacao/{sessao}', [BilheteController::class, 'verificacao'])->name('verificacao.sessao');
});

//Apenas Administradores
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //Utilizadores
    Route::get('funcionarios', [UserController::class, 'admin_index'])->name('funcionarios');

    Route::get('funcionarios/{user}/edit', [UserController::class, 'edit'])->name('funcionarios.edit');

    Route::get('funcionarios/create', [UserController::class, 'create'])->name('funcionarios.create');

    Route::post('funcionarios', [UserController::class, 'store'])->name('funcionarios.store');

    Route::put('funcionarios/{user}', [UserController::class, 'update'])->name('funcionarios.update');

    Route::put('funcionarios/{user}/bloqueado', [UserController::class, 'bloquear_desbloquear'])->name('funcionarios.bloquear_desbloquear');

    Route::delete('funcionarios/{user}', [UserController::class, 'destroy'])->name('funcionarios.destroy');

    //Clientes
    Route::get('clientes', [ClienteController::class, 'admin_index'])->name('clientes');
    
    Route::put('clientes/{user}', [ClienteController::class, 'bloquear_desbloquear'])->name('clientes.bloquear_desbloquear');
    
    Route::delete('clientes/{user}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    //Filmes
    Route::get('filmes', [FilmeController::class, 'admin_index'])->name('filmes');

    Route::get('filmes/{filme}/edit', [FilmeController::class, 'edit'])->name('filmes.edit');

    Route::get('filmes/create', [FilmeController::class, 'create'])->name('filmes.create');

    Route::post('filmes', [FilmeController::class, 'store'])->name('filmes.store');

    Route::put('filmes/{filme}', [FilmeController::class, 'update'])->name('filmes.update');

    Route::delete('filmes/{filme}', [FilmeController::class, 'destroy'])->name('filmes.destroy');

    //Sessões
    Route::get('sessoes/{filme}', [SessaoController::class, 'admin_index'])->name('sessoes');
    
    Route::get('sessoes/{sessao}/edit', [SessaoController::class, 'edit'])->name('sessoes.edit');

    Route::get('sessoes/create/{filme}', [SessaoController::class, 'create'])->name('sessoes.create');

    Route::post('sessoes', [SessaoController::class, 'store'])->name('sessoes.store');

    Route::put('sessoes/{sessao}', [SessaoController::class, 'update'])->name('sessoes.update');

    Route::delete('sessoes/{sessao}', [SessaoController::class, 'destroy'])->name('sessoes.destroy');

    //Salas
    Route::get('salas', [SalaController::class, 'admin_index'])->name('salas');

    Route::get('salas/{sala}/edit', [SalaController::class, 'edit'])->name('salas.edit');

    Route::get('salas/create', [SalaController::class, 'create'])->name('salas.create');

    Route::post('salas', [SalaController::class, 'store'])->name('salas.store');

    Route::put('salas/{sala}', [SalaController::class, 'update'])->name('salas.update');

    Route::delete('salas/{sala}', [SalaController::class, 'destroy'])->name('salas.destroy');


    //Configuracao
    Route::get('configuracao', [ConfiguracaoController::class, 'admin_index'])->name('configuracao');

    Route::put('configuracao', [ConfiguracaoController::class, 'update'])->name('configuracao.update');

    //Estatisticas
    Route::get('estatisticas', [EstatisticasController::class, 'admin_index'])->name('estatisticas');
});

