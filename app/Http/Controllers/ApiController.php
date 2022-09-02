<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;


class ApiController extends Controller
{
    public function createTodo(Request $request){
        $array = ['Status' => 'Tarefa salva com sucesso'];

        $rules = [
            'title' => 'required|min:3'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array = ['error' => ''];
            $array['error'] = $validator->messages();
            return $array;
        };

        $title =  $request->input('title');

        $todo = new Todo();
        $todo->title = $title;
        $todo->save();

        return $array;
    }

    public function readAllTodos(){
        $array = ['error' => ''];

        $todos = Todo::Paginate(3);

        $array['list'] = $todos->items();
        $array['current_page'] = $todos->currentPage();
        $array['last_page'] = $todos->lastPage();

        return $array;
    }

    public function readTodo($id){
        $array = ['error' => ''];

        $todo = Todo::find($id);

        if($todo) {
            $array['todo'] = $todo;
            $array['error'] = 'none';
        } else {
            $array['error'] = 'A tarefa de ID:'.$id.' não existe';
        }

        return $array;
    }

    public function updateTodo($id, Request $request){
        $array = ['error' => ''];
        
        $rules = [
            'title' => 'min:3',
            'done' => 'boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array = ['error' => ''];
            $array['error'] = $validator->messages();
            return $array;
        };
      
        $title =  $request->input('title');
        $done =  $request->input('done');

        $todo = Todo::find($id);
        if($todo) {

            if($title) {
                $todo->title = $title;
            }
            if($done) {
                $todo->done = intval($done);
            }

            $todo->save();
            $array['status'] = 'Sua tarefa de ID:'.$id.' foi atualizada com sucesso ';

        } else {
            $array['error'] = 'A tarefa de ID:'.$id.' não existe, logo, não pode ser atualizada.';
        }
        

        return $array;
    }

    public function deleteTodo($id){
        $array = ['sucess' => 'Tarefa Deletada com sucesso'];

        $todo = Todo::find($id);
        $todo->delete();


        return $array;
    }
}
