<!-- NoteCounter.vue -->
<script setup>
import { defineProps } from 'vue'

// Definir el prop para recibir el número de tareas completadas
const props = defineProps({
  completedTasks: Number
})
</script>

<template>
  <div>
      {{  props.completedTasks  }} Tarea/s pendientes de un total de {{ 0 }} | <a>Borrar Tareas Completadas</a>
  </div>
</template>

<style scoped>
/* Aquí puedes agregar estilos para el contador */
</style>
