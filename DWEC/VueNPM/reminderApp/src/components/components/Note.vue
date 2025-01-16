<script setup>
import { defineProps, computed } from "vue";

const props = defineProps({
  note: Object,
});

const emit = defineEmits([
  "delete-note",
  "change-priority",
  "change-completition",
]);

const timeElapsed = computed(() => getTimeElapsed(props.note.updateDate));

function deleteSingleTask() {
  emit("delete-note");
}

function changeCompletition(note) {
  emit("change-completition", note);
}

function perceiveClick(targetValue, note) {
  emit("change-priority", targetValue, note);
}

function getTimeElapsed(updateDate) {
  const now = Date.now();
  const updated = new Date(updateDate).getTime();
  const diff = now - updated;

  const minutes = Math.floor(diff / 60000);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);

  if (days > 0) return `hace ${days} día${days > 1 ? "s" : ""}`;
  if (hours > 0) return `hace ${hours} hora${hours > 1 ? "s" : ""}`;
  if (minutes > 0) return `hace ${minutes} minuto${minutes > 1 ? "s" : ""}`;
  return "hace un momento";
}
</script>

<template>
  <div>
    <div id="header">
      <div>
        <h1
          :class="{ 'highlight-title': props.note.completed }"
          @click="changeCompletition(props.note)"
        >
          <span
            class="checkball"
            :class="{ completed: props.note.completed }"
          ></span>
          {{ props.note.description }}
        </h1>
      </div>
        <font-awesome-icon class="deleteButton" icon="fa-solid fa-delete-left" @click="deleteSingleTask"/>
    </div>

    <div id="secondaryData">
      <p>
        Prioridad:
        <span
          v-for="priority in ['Low', 'Normal', 'High']"
          @click="perceiveClick(priority, props.note)"
          :key="priority"
          :class="{
            'bg-high': props.note.priority === 'High' && priority === 'High',
            'bg-low': props.note.priority === 'Low' && priority === 'Low',
            'bg-normal':
              props.note.priority === 'Normal' && priority === 'Normal',
            'unselected-priority': props.note.priority !== priority,
          }"
        >
          {{ priority }}
        </span>
      </p>
      <p id="lastUpdate">Actualizado {{ timeElapsed }}</p>
    </div>
  </div>
</template>

<style scoped>
h1,
p {
  text-align: left;
  word-wrap: break-word;
}

h1 {
  font-size: 1.8rem;
  cursor: pointer;
}

p {
  font-size: small;
}

#lastUpdate {
  margin: 0 5px;
}

span {
  padding: 3px 5px;
  margin: 2px;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  background: #464545;
}

.bg-high {
  background-color: #e74c3c;
}

.bg-normal {
  background-color: #3291d2;
}

.bg-low {
  background-color: #4a6e61;
}

.completed {
  background-color: #00bc8c;
}

.highlight-title {
  color: #00bc8c;
  text-decoration: line-through;
}

li {
  list-style: none;
}

.checkball {
  display: inline-block;
  width: 15px;
  height: 15px;
  border: 2px solid white;
  border-radius: 50%;
  margin-right: 10px;
  transition: background-color 0.3s ease;
}

.deleteButton {
  display: inline-block;
  width: 2rem;
  height: 2rem;
  margin-right: 10px;
  transition: background-color 0.3s ease;
  cursor: pointer;
  color: red;
}

.checkball.completed {
  background-color: #00bc8c;
}

#secondaryData {
  display: flex;
}

#header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
