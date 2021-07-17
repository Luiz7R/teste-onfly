<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // if ( Auth::check() )
        // {
        //     $usuario = Auth::user();

        //     return $usuario->despesas;
        // }
    }

    public function criarDespesa(Request $request)
    {
        //$data = $request->only(['descricao', 'anexo', 'id_usuario', 'valor']);
        $data = $request->all();

        if ( $request->hasFile('anexo'))
        {
             $destination_path = 'public/images/';
             $anexo = $request->file('anexo');
             $nomeAnexo = $anexo->getClientOriginalName();
             
             $data['anexo'] = $nomeAnexo;
        }

        $data['data_criacao'] = Carbon::now();

        Despesas::create($data);

        return redirect()->route('home.page');
    }
    
    public function getDespesa($id)
    {
        /*if ( Auth::check() )
        {
            $usuario = Auth::user();
            $despesa = Despesas::where('id_usuario', $usuario->id)->findOrFail($id);

            return compact('despesa');
        }*/
        return Despesas::findOrFail($id);
    }

    public function deletarDespesa($id)
    {
        $data = Despesas::find($id);
        $data->delete();

        return true;
    }

    public function updateDespesa(Request $request)
    {
        $update = Despesas::find($request->id);

        $update->fill($request->all());

        $update->save();
    }

}
