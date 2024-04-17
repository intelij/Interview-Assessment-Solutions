<template>
    <div>
      <h1>Create New Todo Item</h1>
      <form @submit.prevent="createTodoItem">
        <input type="text" v-model="content" placeholder="Enter content">
        <button type="submit">Create</button>
      </form>
    </div>
  </template>
