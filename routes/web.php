<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('filmes', [FilmeController::class, 'index'])->name('filmes'); //get de todos os filmes em exibição

Route::get('filmes/{id}', [FilmeController::class, 'info'])->name('info'); // get do filme pelo id

Route::get('filmes/sessao/{id}', [FilmeController::class, 'sessao'])->name('sessao'); // get do filme pelo id

Route::get('filmes/{id}', [FilmeController::class, 'info'])->name('info'); // get do filme pelo id

Route::get('filmes/sessao/{id}', [FilmeController::class, 'sessao'])->name('sessao'); // get do filme pelo id



//clientes
Route::get('index/clientes', [ClienteController::class, 'index'])->name('clientes');

Route::get('clientes/{user}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');

Route::put('clientes/{user}', [ClienteController::class, 'update'])->name('clientes.update');

Route::delete('clientes/{user}', [ClienteController::class, 'destroy'])->name('clientes.destroy');



//Apenas funcionarios
Route::middleware('funcionario')->group(function () {
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

    Route::put('funcionarios/{user}/bloqueado', [UserController::class, 'bloquiar_desbloquiar'])->name('funcionarios.bloquiar_desbloquiar');

    Route::delete('funcionarios/{user}', [UserController::class, 'destroy'])->name('funcionarios.destroy');
});
