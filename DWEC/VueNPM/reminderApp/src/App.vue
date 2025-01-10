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
    function deleteSingleTask(pos){
        notes.value.splice(pos, 1);
    }

    const completedTasks = computed(() => notes.value.filter((note) => note.completed).length);
    const totalTasks = computed(() => notes.value.length);

    function sortedNotes() {
        return [notes].sort((a, b) => {
            if (sortOrder.value === 'recent') {
            return b.updateDate - a.updateDate;
            } else if (sortOrder.value === 'prior') {
            const priorityOrder = { high: 0, normal: 1, low: 2 };
            return priorityOrder[a.priority] - priorityOrder[b.priority];
            } else {
            return a.updateDate - b.updateDate;
            }
        });
    }
</script>

<template>
    <NoteContainerHeader></NoteContainerHeader>
    <NoteWriter @add-note="addNote"></NoteWriter>
    <NoteCounter :completedTasks="completedTasks" :totalTasks="totalTasks" @delete-completed="deleteCompletedTasks" @delete-all="deleteAllTasks"></NoteCounter>
    <NotesList :notes="notes" @sort="sortedNotes" @delete-note="deleteSingleTask"></NotesList>
    <Footer></Footer>
  </template>


<style scoped>

</style>
