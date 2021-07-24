<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DespesasController extends Controller
{
    public function getDespesas( )
    {   
        if ( Auth::check() )
        {
            $user = User::find(Auth::user()->id);
            $despesas = $user->despesas;

            return $despesas;
        }
    }

    public function criarDespesa(Request $request)
    {
        $id = Auth::user()->id;

        $data = $request->only(['descricao', 'anexo', 'id_usuario', 'valor']);
        $data['data_criacao'] = Carbon::now();
        $data['id_usuario'] = $id;

        Despesas::create($data);

        return true;
    }

    public function deletarDespesa($id)
    {
        $data = Despesas::find($id);

        if ( $data->anexo != 'semimage.jpg' )
        {
             Storage::delete('public/images/'.$data->anexo);
        }

        $data->delete();

        return true;
    }

    public function updateDespesa(Request $request)
    {
        $update = Despesas::find($request->id);

        $update->descricao = $request->descricao;
        $update->data_criacao = $request->data_criacao;
        $update->anexo = $request->anexo;
        $update->valor = $request->valor;

        $update->save();

        return true;
    }

}
