<script setup>
import NotesList from "./NotesList.vue";
import NoteContainerHeader from "./NoteContainerHeader.vue";
import NoteWriter from "./NoteWriter.vue";
import NoteCounter from "./NoteCounter.vue";
import Footer from "./Footer.vue";

import { ref, computed, onMounted } from "vue";
import { useCollection, useFirestore } from "vuefire";
import {
  collection,
  addDoc,
  deleteDoc,
  updateDoc,
  doc,
  query,
  orderBy,
} from "firebase/firestore";
const db = useFirestore();
const notesCollection = collection(db, "notesApp");
const notes = useCollection(query(notesCollection, orderBy("description")));
const currentSortOrder = ref('recent'); 

function addNote(newNote) {
  addDoc(notesCollection, {
    ...newNote,
    completed: false,
    updateDate: Date.now(),
  })
    .then(() => console.log("Success addNote"))
    .catch((error) => {
      console.error("Error adding note: ", error);
    });
}

function deleteCompletedTasks() {
  const completedNotes = notes.value.filter((note) => note.completed);
  Promise.all(
    completedNotes.map((note) => deleteDoc(doc(notesCollection, note.id)))
  )
    .then(() => console.log("Success deleteCompletedTasks"))
    .catch((error) => console.error("Error deleting completed tasks: ", error));
}

function deleteAllTasks() {
  Promise.all(
    notes.value.map((note) => deleteDoc(doc(notesCollection, note.id)))
  )
    .then(() => console.log("Success deleteAllTasks"))
    .catch((error) => console.error("Error deleting all tasks: ", error));
}

function deleteSingleTask(noteId) {
  if (!noteId) {
    console.error("Error de id: " + noteId);
  }

  deleteDoc(doc(notesCollection, noteId))
    .then(() => console.log("Success deleteSingleTask"))
    .catch((error) => console.error("Error deleting singleTask: ", error));
}

const completedTasks = computed(
  () => notes.value.filter((note) => note.completed).length
);
const totalTasks = computed(() => notes.value.length);

const sortedNotesList = computed(() => {
  return [...notes.value].sort((a, b) => {
    if (currentSortOrder.value === "recent") {
      return b.updateDate - a.updateDate;
    } else if (currentSortOrder.value === "prior") {
      const priorityOrder = { high: 0, normal: 1, low: 2 };
      return priorityOrder[a.priority] - priorityOrder[b.priority];
    } else {
      return a.updateDate - b.updateDate;
    }
  });
});

function updateSortOrder(newSortOrder) {
  currentSortOrder.value = newSortOrder;
}

function changeNotePriority(targetValue, note){
  const noteRef = doc(db, 'notesApp', note.id);
  updateDoc(noteRef, {
    priority: targetValue,
    updateDate: Date.now()
  }).then(() => {
    note.priority = targetValue;
    note.updateDate = Date.now();
  }).catch((error) => {
    console.error("Error updating document: ", error);
  });
}

function changeCompletition(note){
  const noteRef = doc(db, 'notesApp', note.id);
  updateDoc(noteRef, {
    completed: !note.completed,
    updateDate: Date.now()
  }).then(() => {
    note.completed = !note.completed;
    note.updateDate = Date.now();
  }).catch((error) => {
    console.error("Error updating document: ", error);
  });
}
</script>

<template>
  <NoteContainerHeader></NoteContainerHeader>
  <NoteWriter @add-note="addNote"></NoteWriter>
  <NoteCounter :completedTasks="completedTasks" :totalTasks="totalTasks" @delete-completed="deleteCompletedTasks" @delete-all="deleteAllTasks"></NoteCounter>
  <NotesList :notes="sortedNotesList" @sort="updateSortOrder" @delete-note="deleteSingleTask" @change-priority="changeNotePriority" @change-completition="changeCompletition"></NotesList>
  <Footer></Footer>
</template>

<style scoped>
</style>
