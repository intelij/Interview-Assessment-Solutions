<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return inertia('Todo/Index', ['todos' => $todos]);
    }

    public function create()
    {
        return inertia('Todo/Create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

       // Create a new todo instance with the user_id
       $todo = new Todo();

       $todo->title = $request->title;
       $todo->user_id = auth()->id();

       $todo->save();

        return redirect()->route('todos.index');
    }

    public function show(Todo $todo)
    {
        $todo = Todo::with('items')->findOrFail($todo->id);

        return inertia('Todo/Show', ['todo' => $todo]);
    }

    public function edit(Todo $todo)
    {
        return inertia('Todo/Edit', ['todo' => $todo]);
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo->update($request->all());

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index');
    }
}
