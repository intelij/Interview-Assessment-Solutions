<template>
    <div>
      <h1>Edit Todo Item</h1>
      <form @submit.prevent="updateTodoItem">
        <input type="text" v-model="content">
        <button type="submit">Update</button>
      </form>
    </div>
  </template>
