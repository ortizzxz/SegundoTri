<script setup>
import { defineProps, computed, ref } from 'vue'
import Note from './Note.vue'
import NoteOrder from './NoteOrder.vue'

const props = defineProps({
  notes: Array
})

const sortOrder = ref('recent') 
const emit = defineEmits(['delete-note', 'sort', 'change-priority']);

function handleSort(order) {
  sortOrder.value = order;
  emit('sort', order);
}

function deleteSingleTask(pos){
  emit('delete-note', pos);
}

function changePriority(targetValue, note){
  emit('change-priority', targetValue, note);
}

function changeCompletition(note) {
    emit('change-completition', note);
}
</script>

<template>
  <div>
    <NoteOrder @sort="handleSort" />
    <div id="mainContainer">
      <transition-group name="fade" tag="div" id="mainContainer">
        <Note v-for="(note, index) in notes" :key="note.updateDate" :note="note" id="note" @delete-note="deleteSingleTask(note.id)" @change-priority="changePriority" @change-completition="changeCompletition"/>
      </transition-group>
      </div>
  </div>
</template>

<style scoped>
#mainContainer {
  width: 80dvw;
  max-height: 68dvh;
  min-height: 68dvh;
  background-color: #000;
  overflow: scroll;
  scrollbar-width: thin; 
  scrollbar-color: rgb(5,23,37) #000000; 
  overflow-x: hidden; 
  overflow-y: auto; 
  border: 0;
  margin: 0;
}

#note{
  background: rgb(5,23,37);
  background: radial-gradient(circle, rgba(5,23,37,1) 0%, rgba(7,0,65,1) 100%);
  padding: 0.5rem;
  border-radius: 0.3rem;
  margin: 3px 0px;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

.fade-leave-from,
.fade-enter-to {
  opacity: 1;
  transform: translateY(0);
}

</style>
