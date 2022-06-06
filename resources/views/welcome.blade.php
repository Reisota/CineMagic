@extends('layouts.app')


@section('content')


<div class="container">
    <h2>FILMES EM EXIBIÇÃO</h2>
    <form>
        <div class="form-row">

            <div class="col-md-3 mb-3">
                <label for="genero">Genero:</label>
                <select id="inputState" class="form-control">
                    <option selected>Escolha o genero</option>
                    <option>...</option>
                </select>

            </div>
            <div class="col-md-6 mb-3">
                <label for="pesquisa">Pesquisar por:</label>
                <input type="text" class="form-control" id="pesquisa" placeholder="Escreva algo">

            </div>
            <div class="col-md-4 mb-3">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>






    </div>
    @endsection