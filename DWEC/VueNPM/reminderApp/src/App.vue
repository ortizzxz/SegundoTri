<script setup>
import NotesList from './components/components/NotesList.vue'
import NoteContainerHeader from './components/components/NoteContainerHeader.vue'
import NoteWriter from './components/components/NoteWriter.vue'
import NoteCounter from './components/components/NoteCounter.vue'
import Footer from './components/components/Footer.vue'

import {  computed, onMounted } from 'vue';
import { useCollection, useFirestore } from 'vuefire';
import { collection, addDoc, deleteDoc, updateDoc, doc } from 'firebase/firestore';

const db = useFirestore();
const notesCollection = collection(db, 'notesApp');
const notes = useCollection(notesCollection);

async function addNote(newNote) {
  try {
    await addDoc(notesCollection, {
      ...newNote,
      completed: false,
      updateDate: Date.now(), 
    });
  } catch (error) {
    console.error('Error adding note: ', error);
  }
}

async function deleteCompletedTasks() {
  try {
    const completedNotes = notes.value.filter(note => note.completed);
    await Promise.all(completedNotes.map(note => deleteDoc(doc(notesCollection, note.id))));
  } catch (error) {
    console.error('Error deleting completed tasks: ', error);
  }
}

async function deleteAllTasks() {
  try {
    await Promise.all(notes.value.map(note => deleteDoc(doc(notesCollection, note.id))));
  } catch (error) {
    console.error('Error deleting all tasks: ', error);
  }
}

async function deleteSingleTask(noteId) {
  if (!noteId) {
    console.error("Error de id: " + noteId);
  }

  try {
    await deleteDoc(doc(notesCollection, noteId));
  } catch (error) {
    console.error("Error borrando la nota: ", error);
  }
}

const completedTasks = computed(() => notes.value.filter(note => note.completed).length);
const totalTasks = computed(() => notes.value.length);

function sortedNotes() {
  return [...notes.value].sort((a, b) => {
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
  <NoteCounter
    :completedTasks="completedTasks"
    :totalTasks="totalTasks"
    @delete-completed="deleteCompletedTasks"
    @delete-all="deleteAllTasks"
  ></NoteCounter>
  <NotesList :notes="notes" @sort="sortedNotes" @delete-note="deleteSingleTask"></NotesList>
  <Footer></Footer>
</template>

<style scoped>
</style>
