<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Campos inválidos']);
        } else {
            $created = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            if ($created) {
                return response(['message' => 'Usuário criado com sucesso'], 200);
            } else {
                return response(['message' => 'Erro ao cadastrar cliente'], 301);
            }
        }
    }

    public function login(Request $request)
    {
        return response()->json($request->all());
    }
}
