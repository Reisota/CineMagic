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

Route::get('index/clientes', [ClienteController::class, 'index'])->name('clientes');


//Apenas funcionarios
Route::middleware('funcionario')->group(function () {
});

//Apenas Administradores
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //Utilizadores
    Route::get('utilizadores', [UserController::class, 'admin_index'])->name('utilizadores');
       
    Route::get('utilizadores/{user}/edit', [UserController::class, 'edit'])->name('utilizadores.edit');
      
    Route::get('utilizadores/create', [UserController::class, 'create'])->name('utilizadores.create');
       
    Route::post('utilizadores', [UserController::class, 'store'])->name('utilizadores.store');
       
    Route::put('utilizadores/{user}', [UserController::class, 'update'])->name('utilizadores.update');
        
    Route::delete('utilizadores/{user}', [UserController::class, 'destroy'])->name('utilizadores.destroy');
      
});
