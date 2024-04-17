# Interview-Assessment-Solutions
I will be creating tutorials for possible interview practical questions I have come across.

### First on the list will be Todo App in Laravel
### Question

#### The app will be a todo list. Below is a spec outlining the project.

#### Must haves:
-  Build a Laravel todo list app. You are free to use any frontend technologies to display this data. Vuejs/React/Livewire/Svelte etc, with or without api calls (you are free to decide).
- The todo items must persist as models via SQLite or MySQL
- Ideally a model structure of todo parent and todo Items.
- The todo list must only be editable by users with a permission of 'editable'. You are free to use roles/permissions to achieve this.
- You must be logged in to edit the todo list.

#### Nice to haves:
- Create an admin section to create users. Each user can create/edit/delete their own todos.
- A visual representation of who edited/updated a todo last. 


### Detailed solution with tutorials how you can implement the same can be found here: 

### [TodoApp-LaraVue](TodoApp-LaraVue.md)

## Project Files

All the files are inside todo-assignment folder, which is a Laravel Application using SQLITE DB.

## USER SEEDERS

```
$users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Karen',
                'email' => 'user@user.com',
                'password' => 'password',
                'role' => 'standard',
            ]
        ];

```

### You have the option to Register a new user once you start up the project.