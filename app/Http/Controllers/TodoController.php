<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class TodoController extends Controller
{
    const ERROR_MESSAGES = [
        'required' => 'Your EVIL SCHEME is missing a :attribute!', 
        'max' => 'Your EVIL SCHEME is TOO LOOOOOOOONG',
        'boolean' => 'it must be TRUE or FALSE, is it that hard?'
    ];

    protected function responseWithErrorMessages($validator) {
        return response($validator->errors()->all(), 400);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(TodoResource::collection(Todo::all()), 200);
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
        ], self::ERROR_MESSAGES);
        if ($validator->fails()) {;
            return $this->responseWithErrorMessages($validator);
        }
        $validatedData = $validator->validate();
        $validatedData['todo_id'] = Uuid::uuid4();
        $todo = Todo::create($validatedData);

        return response(new TodoResource($todo), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return response(new TodoResource($todo), 200);
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
        // * code w/o validation
        // $todo->todo = $request->input('todo');
        // if ($request->boolean('completed')){
        //     $todo->completed = now();
        // } else {
        //     $todo->completed = null;
        // }
        // $todo->save();
        // return response($todo, 200);

        // * code w/ validation
        $validator = Validator::make($request->all(), [
            'todo' => ['required', 'max:255'],
            'completed' => ['nullable', 'boolean']
        ], self::ERROR_MESSAGES);
        if ($validator->fails()) {;
            return $this->responseWithErrorMessages($validator);
        }
        $validatedData = $validator->validate();
        if ($validatedData['completed']) {
            $validatedData['completed'] = now();
        } else {
            $validatedData['completed'] = null;
        }
        $todo->update($validatedData);

        return response(new TodoResource($todo), 201);
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
