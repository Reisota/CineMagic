<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\ClienteController;
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