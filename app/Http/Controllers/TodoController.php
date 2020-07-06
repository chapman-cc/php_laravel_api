<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Todo::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // * code w/o validation
        // $todo = new Todo();
        // $todo->todo = $request->todo;
        // $todo->todo_id = Uuid::uuid4();
        // $todo->save();
        
        // return response($todo,201);

        // * code w/ validation
        $validator = Validator::make($request->all(), [
            'todo' => ['required', 'max:255']
        ]);
        if ($validator->fails()) {;
            return redirect('/')->withErrors($validator)->withInput();
        }
        $validatedData = $validator->validate();
        $validatedData['todo_id'] = Uuid::uuid4();
        $todo = Todo::create($validatedData);

        return response($todo, 201);
    
        // $validatedData['todo_id'] = Uuid::uuid4();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return response($todo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->todo = $request->input('todo');
        if ($request->boolean('completed')){
            $todo->completed = now();
        } else {
            $todo->completed = null;
        }
        $todo->save();
        return response($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response(null, 204);
    }
}
