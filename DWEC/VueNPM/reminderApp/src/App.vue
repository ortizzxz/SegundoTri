<script setup>
import NotesList from './components/components/NotesList.vue'
import NoteContainerHeader from './components/components/NoteContainerHeader.vue'
import NoteWriter from './components/components/NoteWriter.vue'
import NoteCounter from './components/components/NoteCounter.vue'
import Footer from './components/components/Footer.vue'

import { ref } from 'vue'
import { countCompletedTasks } from './components/utilities/TaskUtilites';

const notes = ref([
    {
        'description': 'Tengo que estudiar',
        'priority': 'Low',
        'updateDate': '2025-01-06T10:29:34.892Z',
        'completed': false
    },
    {
        'description': 'No quiero estudiar',
        'priority': 'Normal',
        'updateDate': '2025-01-07T10:29:34.892Z',
        'completed': true
    },
    {
        'description': 'No voy estudiar',
        'priority': 'High',
        'updateDate': '2025-01-08T10:29:34.892Z',
        'completed': false
    },
])

const completedTasks = ref(countCompletedTasks(notes))
console.log(completedTasks.value)
</script>

<template>
    <NoteContainerHeader></NoteContainerHeader>
    <NoteWriter></NoteWriter>
    <NoteCounter :completedTasks="completedTasks"></NoteCounter>
    <NotesList :notes="notes"></NotesList>
    <Footer></Footer>
  </template>
  

<style scoped>

</style>
