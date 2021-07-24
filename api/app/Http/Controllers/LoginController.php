<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {

        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
       ]);

       if ( Auth::attempt(['email' => $request->email, 'password' => $request->password]) )
       {
            return Auth::user();
       }
       else
       {
           return response()->json(['error' => 'error error'], 404);
       }  
    }

    public function registrar (Request $request)
    {
           $request->validate([
                 'email' => 'required|string|email|max:100|unique:users',
                 'password' => 'required'
           ]);

           $user = User::create([
               'name' => $request->name,
               'email' => $request->email,  
               'email_verified_at' => Carbon::now(),
               'password' => Hash::make($request->password),
               'remember_token' => Str::random(10),
           ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return true;
    }    

    public function getDespesa($id)
    {
        if ( Auth::check() )
        {
            $usuario = Auth::user();
            $despesa = Despesas::where('id_usuario', $usuario->id)->findOrFail($id);

            return compact('despesa');
        }
        return Despesas::findOrFail($id);
    }

}