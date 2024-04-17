<template>
    <div>
      <h1>Edit Todo List</h1>
      <form @submit.prevent="updateTodoList">
        <input type="text" v-model="title">
        <button type="submit">Update</button>
      </form>
    </div>
  </template>
