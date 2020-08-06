<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function createRole(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response(['message' => 'Campos inválidos']);
        } else {
            $created = Role::create([
                'name' => $request->name,
            ]);

            if ($created) {
                return response(['message' => 'Usuário criado com sucesso'], 200);
            } else {
                return response(['message' => 'Erro ao cadastrar cliente'], 301);
            }
        }
    }

    public function createPermission(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response(['message' => 'Campos inválidos']);
        } else {
            $created = Permission::create([
                'name' => $request->name,
            ]);

            if ($created) {
                return response(['message' => 'Permissão criado com sucesso'], 200);
            } else {
                return response(['message' => 'Erro ao cadastrar permissão'], 301);
            }
        }
    }

    public function addPermission(Request $request){
        $validator = Validator::make($request->all(), [
            'permission_id' => 'required',
            'role_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['message' => 'Campos inválidos']);
        } else {
            $role = Role::findById($request->role_id);
            $permission = Permission::findByiD($request->permission_id);
            $created = $role->givePermissionTo($permission);

            if ($created) {
                return response(['message' => 'Vinculado com sucesso'], 200);
            } else {
                return response(['message' => 'Erro ao vincular'], 301);
            }
        }
    }

    public function removePermission(Request $request){
        $validator = Validator::make($request->all(), [
            'permission_id' => 'required',
            'role_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['message' => 'Campos inválidos']);
        } else {
            $role = Role::findById($request->role_id);
            $permission = Permission::findByiD($request->permission_id);
            $removed = $role->revokePermissionTo($permission);

            if ($removed) {
                return response(['message' => 'Desvinculado com sucesso'], 200);
            } else {
                return response(['message' => 'Erro ao desvincular'], 301);
            }
        }
    }
}