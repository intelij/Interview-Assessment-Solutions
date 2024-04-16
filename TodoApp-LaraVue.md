# ToDo Laravel Vue App Solution
First, we'll set up the Laravel backend with Laravel Breeze for authentication and Spatie Laravel Permission for managing roles and permissions. Then, we'll create the necessary models, migrations, controllers, and views for the todo list functionality. Finally, we'll integrate Vue.js for the frontend.

### Step 1: Laravel Setup

#### Install Laravel Breeze and Spatie Laravel Permission:

```
composer require laravel/breeze
composer require spatie/laravel-permission
```

#### Set up Breeze for authentication:

```
php artisan breeze:install
php artisan migrate
```

#### Publish Spatie permissions config:

```
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
```

#### Migrate the database:

```
php artisan migrate
```


### Step 2: Models and Migrations

#### Create models and migrations for TodoParent and TodoItem:

```
php artisan make:model TodoParent -m
php artisan make:model TodoItem -m
```

#### Define the structure of the migrations according to the project requirements. 

### TodoParent Migration:

database/migrations/create_todo_parents_table.php

```

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoParentsTable extends Migration
{
    public function up()
    {
        Schema::create('todo_parents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('todo_parents');
    }
}
```

### TodoItem Migration:

database/migrations/create_todo_items_table.php

```

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoItemsTable extends Migration
{
    public function up()
    {
        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_parent_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->boolean('completed')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('todo_items');
    }
}
```

#### Run migrations:

```
php artisan migrate
```

### Step 3: Roles and Permissions

#### Set up roles and permissions using Spatie Laravel Permission. Define roles and permissions in the `AppServiceProvider`.

I am including a link to a valuable online resource below. Please note that I have no affiliation with this website; I simply found it to be useful in this particular context.

https://codingoblin.com/roles-and-permissions-in-laravel-jetstream-inertiajs-using-spatie-package/

### Step 4: Controllers

#### Create controllers for managing todo lists and items:

```
php artisan make:controller TodoParentController --resource
php artisan make:controller TodoItemController --resource
```

#### TodoParentController:

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoParent;
use App\Http\Requests\TodoParentRequest;

class TodoParentController extends Controller
{
    public function index()
    {
        $todoParents = auth()->user()->todoParents()->with('items')->get();
        return view('todo_parents.index', compact('todoParents'));
    }

    public function store(TodoParentRequest $request)
    {
        $todoParent = new TodoParent();
        $todoParent->title = $request->title;
        $todoParent->user_id = auth()->id();
        $todoParent->save();

        return redirect()->route('todo-parents.index')->with('success', 'Todo list created successfully.');
    }

    public function show(TodoParent $todoParent)
    {
        $this->authorize('view', $todoParent);
        return view('todo_parents.show', compact('todoParent'));
    }

    public function edit(TodoParent $todoParent)
    {
        $this->authorize('update', $todoParent);
        return view('todo_parents.edit', compact('todoParent'));
    }

    public function update(TodoParentRequest $request, TodoParent $todoParent)
    {
        $this->authorize('update', $todoParent);
        $todoParent->update($request->validated());
        return redirect()->route('todo-parents.index')->with('success', 'Todo list updated successfully.');
    }

    public function destroy(TodoParent $todoParent)
    {
        $this->authorize('delete', $todoParent);
        $todoParent->delete();
        return redirect()->route('todo-parents.index')->with('success', 'Todo list deleted successfully.');
    }
}
```

#### TodoItemController:

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoItem;
use App\Http\Requests\TodoItemRequest;

class TodoItemController extends Controller
{
    public function store(TodoItemRequest $request)
    {
        $todoItem = new TodoItem();
        $todoItem->todo_parent_id = $request->todo_parent_id;
        $todoItem->content = $request->content;
        $todoItem->user_id = auth()->id();
        $todoItem->save();

        return redirect()->route('todo-parents.index')->with('success', 'Todo item created successfully.');
    }

    public function update(TodoItemRequest $request, TodoItem $todoItem)
    {
        $this->authorize('update', $todoItem);
        $todoItem->update($request->validated());
        return redirect()->route('todo-parents.index')->with('success', 'Todo item updated successfully.');
    }

    public function destroy(TodoItem $todoItem)
    {
        $this->authorize('delete', $todoItem);
        $todoItem->delete();
        return redirect()->route('todo-parents.index')->with('success', 'Todo item deleted successfully.');
    }
}
```

### We have to validate all our requests, below are the basic validation rules, but can modify as you see fit to resonate with your project

### TodoParentRequest:

```
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoParentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
        ];
    }
}
```

### TodoItemRequest:

```
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'todo_parent_id' => 'required|exists:todo_parents,id',
            'content' => 'required|string|max:255',
        ];
    }
}

```



```
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\TodoParent;
use App\Models\TodoItem;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_todo_list()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/todo-parents', [
            'title' => 'My Todo List',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('todo_parents', ['title' => 'My Todo List', 'user_id' => $user->id]);
    }

    // Create more tests for the full CRUD oparations.

}

```

### Step 5: Views

Create Blade views for displaying and managing todo lists and items. Ensure that the views reflect the permissions of the authenticated user.

#### Todo Parent Views:

#### Index View (`todo_parents.index.blade.php`):

```
@extends('layouts.app')

@section('content')
    <div>
        <h1>Your Todo Lists</h1>
        <ul>
            @foreach ($todoParents as $todoParent)
                <li><a href="{{ route('todo-parents.show', $todoParent) }}">{{ $todoParent->title }}</a></li>
            @endforeach
        </ul>
        <a href="{{ route('todo-parents.create') }}">Create New Todo List</a>
    </div>
@endsection
```

#### Create View (`todo_parents.create.blade.php`):

```
@extends('layouts.app')

@section('content')
    <div>
        <h1>Create New Todo List</h1>
        <form action="{{ route('todo-parents.store') }}" method="post">
            @csrf
            <input type="text" name="title" placeholder="Enter title">
            <button type="submit">Create</button>
        </form>
    </div>
@endsection

```

#### Show View (`todo_parents.show.blade.php`):

```
@extends('layouts.app')

@section('content')
    <div>
        <h1>{{ $todoParent->title }}</h1>
        <ul>
            @foreach ($todoParent->items as $item)
                <li>{{ $item->content }}</li>
            @endforeach
        </ul>
        <a href="{{ route('todo-parents.edit', $todoParent) }}">Edit</a>
        <form action="{{ route('todo-parents.destroy', $todoParent) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
@endsection

```

#### Edit View (`todo_parents.edit.blade.php`):

```
@extends('layouts.app')

@section('content')
    <div>
        <h1>Edit Todo List</h1>
        <form action="{{ route('todo-parents.update', $todoParent) }}" method="post">
            @csrf
            @method('PUT')
            <input type="text" name="title" value="{{ $todoParent->title }}">
            <button type="submit">Update</button>
        </form>
    </div>
@endsection

```

#### Todo Item Views:

#### Create View (`todo_items.create.blade.php`):

```
@extends('layouts.app')

@section('content')
    <div>
        <h1>Create New Todo Item</h1>
        <form action="{{ route('todo-items.store') }}" method="post">
            @csrf
            <input type="hidden" name="todo_parent_id" value="{{ $todoParent->id }}">
            <input type="text" name="content" placeholder="Enter content">
            <button type="submit">Create</button>
        </form>
    </div>
@endsection

```

#### Edit View (`todo_items.edit.blade.php`):

```
@extends('layouts.app')

@section('content')
    <div>
        <h1>Edit Todo Item</h1>
        <form action="{{ route('todo-items.update', $todoItem) }}" method="post">
            @csrf
            @method('PUT')
            <input type="text" name="content" value="{{ $todoItem->content }}">
            <button type="submit">Update</button>
        </form>
    </div>
@endsection
```

These blade templates cover the basic functionality of managing todo lists and items. You may need to customize them further based on your specific requirements, such as styling, additional fields, or validation error handling. 

## Step 6: Vue Router and Vue Components

### Install Vue Router

Integrate Vue.js for dynamic frontend interactions.

We'll have views for displaying todo lists, creating new lists, viewing individual lists, editing lists, creating todo items, and editing todo items.

```
npm install vue-router
```

### Set up Vue Router

`Create a router.js file in the resources/js directory:`

```
// resources/js/router.js

import Vue from 'vue';
import VueRouter from 'vue-router';
import TodoLists from './components/TodoLists.vue';
import TodoList from './components/TodoList.vue';
import CreateTodoList from './components/CreateTodoList.vue';
import EditTodoList from './components/EditTodoList.vue';
import CreateTodoItem from './components/CreateTodoItem.vue';
import EditTodoItem from './components/EditTodoItem.vue';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: TodoLists },
    { path: '/todo-lists/:id', component: TodoList, props: true },
    { path: '/todo-lists/create', component: CreateTodoList },
    { path: '/todo-lists/:id/edit', component: EditTodoList, props: true },
    { path: '/todo-lists/:parentId/items/create', component: CreateTodoItem, props: true },
    { path: '/todo-items/:id/edit', component: EditTodoItem, props: true }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;

```

### Create Vue Components

Create Vue components in the resources/js/components directory:

- `TodoLists.vue`
- `TodoList.vue`
- `CreateTodoList.vue`
- `EditTodoList.vue`
- `CreateTodoItem.vue`
- `EditTodoItem.vue`

### Define Vue Templates

Define the templates for each Vue component, paste each section to the corresponding file name from the previous list above.

```
<!-- TodoLists.vue -->
<template>
  <div>
    <h1>Your Todo Lists</h1>
    <router-link to="/todo-lists/create">Create New Todo List</router-link>
    <ul>
      <li v-for="todoParent in todoParents" :key="todoParent.id">
        <router-link :to="{ name: 'todo-list', params: { id: todoParent.id }}">{{ todoParent.title }}</router-link>
      </li>
    </ul>
  </div>
</template>

<!-- TodoList.vue -->
<template>
  <div>
    <h1>{{ todoParent.title }}</h1>
    <ul>
      <li v-for="todoItem in todoParent.items" :key="todoItem.id">
        {{ todoItem.content }}
      </li>
    </ul>
    <router-link :to="{ name: 'edit-todo-list', params: { id: todoParent.id }}">Edit</router-link>
    <button @click="deleteTodoList(todoParent.id)">Delete</button>
    <router-link :to="{ name: 'create-todo-item', params: { parentId: todoParent.id }}">Add Todo Item</router-link>
  </div>
</template>

<!-- CreateTodoList.vue -->
<template>
  <div>
    <h1>Create New Todo List</h1>
    <form @submit.prevent="createTodoList">
      <input type="text" v-model="title" placeholder="Enter title">
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<!-- EditTodoList.vue -->
<template>
  <div>
    <h1>Edit Todo List</h1>
    <form @submit.prevent="updateTodoList">
      <input type="text" v-model="title">
      <button type="submit">Update</button>
    </form>
  </div>
</template>

<!-- CreateTodoItem.vue -->
<template>
  <div>
    <h1>Create New Todo Item</h1>
    <form @submit.prevent="createTodoItem">
      <input type="text" v-model="content" placeholder="Enter content">
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<!-- EditTodoItem.vue -->
<template>
  <div>
    <h1>Edit Todo Item</h1>
    <form @submit.prevent="updateTodoItem">
      <input type="text" v-model="content">
      <button type="submit">Update</button>
    </form>
  </div>
</template>

```

### Wire up Vue Components with Vue Router

```
// main.js
import Vue from 'vue';
import App from './App.vue';
import router from './router';

new Vue({
  router,
  render: h => h(App)
}).$mount('#app');

```

### Update app.blade.php to load Vue app

```
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

```

All done :) Yeepee! you have a fully functional Vue frontend for managing todo lists and items, integrated with Vue Router. 

