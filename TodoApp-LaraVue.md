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



### Step 6: Vue.js Integration

Integrate Vue.js for dynamic frontend interactions. Use Axios or Laravel Sanctum for API requests if necessary.

Below is a basic example of how the Vue component for todo items might look like:

