<script setup>
    import NoteCounter from './components/NoteCounter.vue'
</script>

<template>
  <input type="text" name="note" id="note" placeholder="I'd like to..." />
  <NoteCounter></NoteCounter>
</template>

<style scoped>
input {
  font-size: 1.2rem;
  width: 100%;
  padding: 0.7rem;
  margin: 1rem 0 1rem 0;
  border-radius: 0.3rem;
  border: 0px;
  outline: none;
  transition: transform 0.2s ease;
}

input::placeholder {
  font-size: medium;
}

input:focus {
  transform: scale(1.05);
}
</style>
