<!-- NotesList.vue -->
<script setup>
import { defineProps } from 'vue'
import Note from './Note.vue'

const props = defineProps({
  notes: Array
})
</script>

<template>
  <div>
    <Note v-for="(note, index) in props.notes" :key="index" :note="note" />
  </div>
</template>

<style scoped>
div {
  width: 80dvw;
}
</style>
