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
