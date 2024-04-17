<template>
    <div>
      <h1>Create New Todo List</h1>
      <form @submit.prevent="createTodoList">
        <input type="text" v-model="title" placeholder="Enter title">
        <button type="submit">Create</button>
      </form>
    </div>
  </template>
