<script setup>
import { ref, computed, onMounted } from "vue";
import { registerTask, isDescriptionValid } from "../utilities/TaskUtilites.js";

const inputValue = ref("");
const isInputActive = ref(false); 

const inputBorderClass = computed(() => {
  if (!isInputActive.value) return ""; 
  return isDescriptionValid(inputValue.value) ? "valid" : "invalid";
});

const handleKeydown = (e) => {
  if (e.key === 'Enter') {
    isInputActive.value = false;
    if (isDescriptionValid(inputValue.value)) {
      let a = registerTask(inputValue.value);
      console.log(a);
      inputValue.value = '';
    } else {
      inputValue.value = '';
      console.log('Vacia');
    }
  }
};

const handleInputFocus = () => {
  isInputActive.value = true; 
};

const handleInputBlur = () => {
  isInputActive.value = false;
};

onMounted(() => {
  document.addEventListener("keydown", handleKeydown);
});
</script>

<template>
  <input 
    type="text" 
    name="note" 
    id="note" 
    placeholder="I'd like to..." 
    v-model="inputValue" 
    :class="inputBorderClass" 
    @focus="handleInputFocus" 
    @blur="handleInputBlur" 
  />
</template>

<style scoped>
input {
  font-size: 1.2rem;
  width: 100%;
  padding: 0.7rem;
  margin: 1rem 0 1rem 0;
  border-radius: 0.3rem;
  border: 2px solid transparent; 
  outline: none;
  transition: transform 0.2s ease, border-color 0.2s ease;
}

input::placeholder {
  font-size: medium;
}

input:focus {
  transform: scale(1.05);
}

input.valid {
  border-color: green;
}

input.invalid {
  border-color: red;
}
</style>
