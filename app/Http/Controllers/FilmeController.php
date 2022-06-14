<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use App\Models\Genero;
use App\Models\Sessao;
use Faker\Core\File;
use Illuminate\Http\Request;

class FilmeController extends Controller
{
    public function index(Request $request)
    {
        $generos = Genero::pluck('nome', 'code');

        $pesquisa = $request->query('pesquisa', '');
        $genero = $request->genero;



        if ($genero != null) {
            $filmes = Filme::with('sessoes')
                ->where(function ($query) use ($pesquisa) {
                    $query->where('sumario', 'like', '%' . $pesquisa . '%')
                        ->orWhere('titulo', 'like', '%' . $pesquisa . '%');
                })
                ->where('genero_code', $genero)
                ->whereHas('sessoes', function ($query) {
                    $query->where('data', '>=', date("Y-m-d"));
                })
                ->get();
        } else {
            $filmes = Filme::with(['sessoes'])
                ->where(function ($query) use ($pesquisa) {
                    $query->where('sumario', 'like', '%' . $pesquisa . '%')
                        ->orWhere('titulo', 'like', '%' . $pesquisa . '%');
                })
                ->whereHas('sessoes', function ($query) {
                    $query->where('data', '>=', date("Y-m-d"));
                })
                ->get();
        }

        return view('filmes.index')
            ->with('filmes', $filmes)
            ->with('generos', $generos)
            ->with('genero', $genero)
            ->with('pesquisa', $pesquisa);
    }

    public function admin_index(Request $request)
    {
        $pesquisa = $request->query('pesquisa', '');
        $filmes = Filme::with('genero')
            ->whereHas('genero', function ($query) use ($pesquisa) {
                $query->where('nome', 'like', '%' . $pesquisa . '%');
            })
            ->orWhere('titulo', 'like', '%' . $pesquisa . '%')
            ->get();


        return view('filmes.admin')
            ->with('filmes', $filmes)
            ->with('pesquisa', $pesquisa);
    }


    public function info($filme_id)
    {

        $filme = Filme::findOrFail($filme_id);
        $genero = Genero::where("code", $filme->genero_code)->get();
        $sessoes = Sessao::where("filme_id", $filme_id)
            ->where('data', '>=', date("Y-m-d"))
            ->get();

        return view('filmes.detalhes')
            ->with('filme', $filme)
            ->with('genero', $genero)
            ->with('sessoes', $sessoes);
    }

    public function sessao($sessao_id)
    {

        $sessao_escolhida = Sessao::findOrFail($sessao_id); //info da sessão escolhida
        $filme = Filme::findOrFail($sessao_escolhida->filme_id); //filme da sessão escolhida
        $genero = Genero::where("code", $filme->genero_code)->get(); //genero do filme
        $sessoes = Sessao::where("filme_id", $sessao_escolhida->filme_id) //sessoes disponiveis do filme
            ->where('data', '>=', date("Y-m-d"))
            ->get();

        return view('filmes.sessao')
            ->with('sessao_escolhida', $sessao_escolhida)
            ->with('sessoes', $sessoes)
            ->with('genero', $genero)
            ->with('filme', $filme);
    }

    public function edit(Filme $filme)
    {

        $filme = Filme::findOrFail($filme->id);
        $genero = Genero::where("code", $filme->genero_code)->get();
        $sessoes = Sessao::where("filme_id", $filme->id);
        dd($sessoes);
        return view('filmes.edit')
            ->with('filme', $filme)
            ->with('genero', $genero)
            ->with('sessoes', $sessoes);
    }

    public function create()
    {
        $filme = new Filme();
        return view('filmes.create')
            ->with('filme', $filme);
    }

    public function store(Request $request)
    {

        $validated_data = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'tipo' => 'required|in:A,F',
        ]);
        $newUser = new Filme;
        $newUser->fill($validated_data);
        $newUser->password = Hash::make('123');
        if ($request->hasFile('foto')) {
            $path = $request->foto->store('public/fotos');
            $newUser->foto_url = basename($path);
        }
        $newUser->save();

        return redirect()->route('admin.filmes')
            ->with('alert-msg', 'Funcionários "' . $validated_data['name'] . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(Request $request, Filme $filme)
    {


        $validated_data = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'tipo' => 'required|in:A,F',
        ]);
        $filme->fill($validated_data);

        if ($request->hasFile('foto')) {

            Storage::delete('public/fotos/' . $filme->foto_url);

            $path = $request->foto->store('public/fotos');

            $filme->foto_url = basename($path);
        }

        $filme->save();

        return redirect()->route('admin.filmes')
            ->with('alert-msg', 'Funcionários "' . $filme->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function bloquiar_desbloquiar(Request $request, Filme $filme)
    {
        $validated_data = $request->validate([
            'bloqueado' => 'required|in:0,1',
        ]);

        $filme->fill($validated_data);

        $filme->save();
        if ($request->bloqueado == '1') {
            return redirect()->route('admin.filmes')
                ->with('alert-msg', 'Utilizador "' . $filme->name . '" foi bloquiado com sucesso!')
                ->with('alert-type', 'success');
        } else {
            return redirect()->route('admin.filmes')
                ->with('alert-msg', 'Utilizador "' . $filme->name . '" foi desbloquiado com sucesso!')
                ->with('alert-type', 'success');
        }
    }

    public function destroy(Filme $filme)
    {
        $oldName = $filme->name;
        $oldUrlFoto = $filme->foto_url;
        try {
            $filme->delete();
            Storage::delete('public/fotos/' . $oldUrlFoto);
            return redirect()->route('admin.funcionarios')
                ->with('alert-msg', 'Funcionarios "' . $filme->name . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('admin.funcionarios')
                    ->with('alert-msg', 'Não foi possível apagar o Funcionários "' . $oldName . '", porque este funcionário está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.funcionarios')
                    ->with('alert-msg', 'Não foi possível apagar o Funcionários "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

}
