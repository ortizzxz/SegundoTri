<!-- NotesList.vue -->
<script setup>
import { defineProps, computed, ref } from 'vue'
import Note from './Note.vue'
import NoteOrder from './NoteOrder.vue'

const props = defineProps({
  notes: Array
})

const sortOrder = ref('recent') 

const sortedNotes = computed(() => {
  return [...props.notes].sort((a, b) => {
    if (sortOrder.value === 'recent') {
      return b.updateDate - a.updateDate
    } else {
      return a.updateDate - b.updateDate
    }
  })
})

function handleSort(order) {
  sortOrder.value = order;
}
</script>

<template>
  <div>
    <NoteOrder @sort="handleSort" />
    <div id="mainContainer">
      <Note v-for="(note, index) in sortedNotes" :key="index" :note="note" id="note" />
    </div>
  </div>
</template>

<style scoped>
#mainContainer {
  width: 80dvw;
  max-height: 70dvh;
  min-height: 70dvh;
  border: 0;
  background-color: #000;
  overflow: scroll;

  overflow-x: hidden; 
  overflow-y: auto; 
}

#note{
  background: rgb(5,23,37);
  background: radial-gradient(circle, rgba(5,23,37,1) 0%, rgba(7,0,65,1) 100%);
  padding: 0.5rem;
  border-radius: 0.3rem;
  margin: 3px 0px;
}

#mainContainer {
  scrollbar-width: thin; 
  scrollbar-color: rgb(5,23,37) #000000; 
}
</style>
