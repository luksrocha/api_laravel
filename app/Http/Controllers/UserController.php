<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
/**
 * @group Users
 * @authenticated
 * 
 * group for users
 */
class UserController extends Controller
{
    /**
     * Route getUsers
     * Route to get all users from DB. 
     * 
     * @response{
     *  "id": 1,
     * "name": "1",
     * "email": "1",
     * "email_verified_at": null,
     * "type": "Admin",
     * "created_at": "2020-08-06 14:34:10",
     * "updated_at": "2020-08-06 14:34:10"
     * }
     * 
     */
    public function getUsers(Request $request)
    {
        $users = User::get();
        return response(['users' => $users]);
    }

    public function meProfile()
    {
        if (auth()->check()) {
            return auth()->user();
        }
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            return response(['user' => $user], 200);
        } else {
            return response(['message' => 'User not found'], 301);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $dados = $request->only(['name', 'email']);
        if ($user) {
            $updated = $user->update($dados);
            if ($updated) {
                return response(['message' => 'Usuário atualizado com sucesso'], 200);
            } else {
                return response(['message' => 'Não foi possível atualizar o usuário'], 301);
            }
            // return response(['user' => $user], 200);
        } else {
            return response(['message' => 'User not found'], 301);
        }
    }
}
