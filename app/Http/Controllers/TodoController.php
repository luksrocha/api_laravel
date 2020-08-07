<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Validator;
use App\Models\Role;

class TodoController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        if($user->hasRole('Admin')){
            $todos = Todo::get();
        }else{
            $todos = Todo::where('id_user',auth()->user()->id)->get();
        }
        return response($todos);
    }

    public function store(Request $request)
    {
        $todo = [
            'id_user' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description
        ];
        $created = Todo::create($todo);
        if($created){
            return response([$created],200);
        } else{
            return response(['message'=>'Não foi possível criar a atividade'],301);
        }
    }
    public function show(Request $request, $id)
    {
        $todo = Todo::find($id);
        if ($todo and $todo->id_user == auth()->user()->id) {
            return response($todo, 200);
        } else {
            return response(['message' => 'User not found'], 301);
        }
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        $dados = $request->only(['title', 'description']);
        if ($todo and $todo->id_user == auth()->user()->id) {
            $updated = $todo->update($dados);
            if ($updated) {
                return response(['message' => 'Tarefa atualizado com sucesso'], 200);
            } else {
                return response(['message' => 'Não foi possível atualizar a tarefa'], 301);
            }
        } else {
            return response(['message' => 'To do not found'], 301);
        }
    }
    public function destroy(Request $request, $id){
        $todo = Todo::find($id);
        if ($todo and $todo->id_user == auth()->user()->id) {
            $deleted = $todo->delete();
            if($deleted){
                return response(['message'=>'Tarefa deletada']);
            } else{
                return response(['message'=>'Tarefa não deletada']);
            }
        } else {
            return response(['message' => 'cant delete to do'], 301);
        }
    }
}
