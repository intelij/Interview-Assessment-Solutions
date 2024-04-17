// import Vue from 'vue';
// import VueRouter from 'vue-router';
// import TodoLists from './components/TodoLists.vue';
// import TodoList from './components/TodoList.vue';
// import CreateTodoList from './components/CreateTodoList.vue';
// import EditTodoList from './components/EditTodoList.vue';
// import CreateTodoItem from './components/CreateTodoItem.vue';
// import EditTodoItem from './components/EditTodoItem.vue';

// Vue.use(VueRouter);

// const routes = [
//     { path: '/', component: TodoLists },
//     { path: '/todo-lists/:id', component: TodoList, props: true },
//     { path: '/todo-lists/create', component: CreateTodoList },
//     { path: '/todo-lists/:id/edit', component: EditTodoList, props: true },
//     { path: '/todo-lists/:parentId/items/create', component: CreateTodoItem, props: true },
//     { path: '/todo-items/:id/edit', component: EditTodoItem, props: true }
// ];

// const router = new VueRouter({
//     mode: 'history',
//     routes
// });

// export default router;

import { createWebHistory, createRouter } from 'vue-router';
import TodoIndex from './Pages/Todo/Index.vue';
import TodoCreate from './Pages/Todo/Create.vue';
import TodoShow from './Pages/Todo/Show.vue';
import TodoEdit from './Pages/Todo/Edit.vue';
import TodoItemCreate from './Pages/TodoItem/Create.vue';
import TodoItemEdit from './Pages/TodoItem/Edit.vue';

const routes = [
    { path: '/todos', component: TodoIndex, name: 'todos.index' },
    { path: '/todos/create', component: TodoCreate, name: 'todos.create' },
    { path: '/todos/:id', component: TodoShow, name: 'todos.show' },
    { path: '/todos/:id/edit', component: TodoEdit, name: 'todos.edit' },
    { path: '/todos/:id/items/create', component: TodoItemCreate, name: 'todo-items.create' },
    { path: '/todo-items/:id/edit', component: TodoItemEdit, name: 'todo-items.edit' },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
