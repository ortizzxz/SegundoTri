<script setup>
    import NotesList from './components/components/NotesList.vue'
    import NoteContainerHeader from './components/components/NoteContainerHeader.vue'
    import NoteWriter from './components/components/NoteWriter.vue'
    import NoteCounter from './components/components/NoteCounter.vue'
    import Footer from './components/components/Footer.vue'

    import { ref, computed, onMounted, watch } from 'vue'

    const notes = ref([]);

    onMounted(() => {
    const savedNotes = localStorage.getItem('notes');
    if (savedNotes) {
        notes.value = JSON.parse(savedNotes);
    }
    })

    function countCompletedTasks(notes){
        var count = 0;
        notes.forEach(note => {
            if(note.completed){ 
                count++ 
            }
        });
        return count;
    }

    watch(notes, (newNotes) => {
        localStorage.setItem('notes', JSON.stringify(newNotes));
    }, { deep: true })

    function addNote(newNote) {
        notes.value.push(newNote);
    }

    function deleteCompletedTasks() {
        notes.value = notes.value.filter(note => !note.completed);
    }
    function deleteAllTasks() {
        notes.value = [];
    }

    const completedTasks = computed(() => countCompletedTasks(notes.value));
    const totalTasks = computed(() => notes.value.length);
</script>

<template>
    <NoteContainerHeader></NoteContainerHeader>
    <NoteWriter @add-note="addNote"></NoteWriter>
    <NoteCounter :completedTasks="completedTasks" :totalTasks="totalTasks" @delete-completed="deleteCompletedTasks" @delete-all="deleteAllTasks"></NoteCounter>
    <NotesList :notes="notes"></NotesList>
    <Footer></Footer>
  </template>
  

<style scoped>

</style>
