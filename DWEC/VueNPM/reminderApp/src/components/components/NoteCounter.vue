<script setup>
  import { defineProps, computed, defineEmits } from 'vue'

  const props = defineProps({
    completedTasks: Number,
    totalTasks: Number
  })

  const emit = defineEmits(['delete-completed', 'delete-all']);

  const pluralS = computed(() => props.completedTasks === 1 ? '' : 's')

  function deleteCompletedTasks() {
    emit('delete-completed');
  }

  function deleteAllTasks(){
    emit('delete-all');
  }
</script>

<template>
  <div>
    <p>
      {{ props.completedTasks }} tarea{{ pluralS }} completada{{ pluralS }} de un total de {{ props.totalTasks }} | 
    <a @click="deleteCompletedTasks">Borrar Tareas Completadas</a> |
    <a @click="deleteAllTasks"> Borrar todas las Tareas</a>
    </p>
  </div>
</template>

<style scoped>
  a:hover {
    cursor: pointer;
    padding: 0.5rem 0.5rem 0.2rem 0.5rem;
    border-radius: 1rem;
  }
</style>
