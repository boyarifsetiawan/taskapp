<script setup>

defineEmits(['deleteTask'])
</script>

<template>
      <div class="modal fade"
        id="modalDelete"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <p>Are you sure you want to delete this item?</p>
        <!-- <button @click="emit(deleteTask)">Yes</button>
        <button @click="cancelDelete">No</button> -->
      </div>
  </template>