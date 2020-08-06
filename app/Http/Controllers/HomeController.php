<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
/**
 * Route register
 * Route to register a new user
 * 
 * @bodyParam name string required name to register a user. Example:
 */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required|confirmed',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Campos inválidos']);
        } else {
            $created = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => $request->type,
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
