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
