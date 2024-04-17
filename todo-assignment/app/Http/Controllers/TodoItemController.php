<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Models\TodoItem;
use Inertia\Inertia;

class TodoItemController extends Controller
{
    public function create($todoId)
    {
        $todo = Todo::findOrFail($todoId);

        // Pass the todo data to the Vue component
        return inertia('TodoItem/Create', [
            'todo' => $todo->only('id', 'title') // Pass only necessary todo data
        ]);
    }

    public function store(Request $request, Todo $todo)
    {
        // Validate the request data
        $request->validate([
            'content' => 'required|string|max:255',
            'todo_id' => 'required'
        ]);

        // Create a new todo item associated with the parent Todo
        $todoItem = new TodoItem();
        $todoItem->title = $request->content;
        $todoItem->todo_id = $request->todo_id; // Associate the TodoItem with the Todo
        $todoItem->save();

        // Redirect the user to the Todo details page
        return redirect()->route('todos.show', ['todo' => $todo->id]);
    }

    public function edit(TodoItem $item)
    {
        return inertia('TodoItem/Edit', ['item' => $item]);
    }

    public function update(Request $request, TodoItem $item)
    {
        // Validate the request data
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Update the content of the TodoItem
        $item->update([
            'title' => $request->content,
        ]);

        // Redirect back to the todo details page
        return redirect()->route('todos.show', $item->todo);
    }

    public function destroy(TodoItem $item)
    {
        $item->delete();
        return redirect()->route('todos.show', $item->todo);
    }
}
