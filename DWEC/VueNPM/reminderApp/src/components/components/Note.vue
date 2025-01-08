<script setup>
 import { defineProps, computed } from 'vue';

  const props = defineProps({
    note: Object
  })

  function changeCompletition() {
    props.note.completed = !props.note.completed
    props.note.updateDate = Date.now();
  }

  const timeElapsed = computed(() => getTimeElapsed(props.note.updateDate))

  function perceiveClick(targetValue, note){
    console.log(note.priority = targetValue);
  }

  function getTimeElapsed(updateDate) {
    const now = Date.now();
    const updated = new Date(updateDate).getTime();
    const diff = now - updated;

    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) return `hace ${days} día${days > 1 ? 's' : ''}`;
    if (hours > 0) return `hace ${hours} hora${hours > 1 ? 's' : ''}`;
    if (minutes > 0) return `hace ${minutes} minuto${minutes > 1 ? 's' : ''}`;
    return 'hace un momento';
  }


  const emit = defineEmits(['update']);

  function changeCompletion() {
    const updatedNote = {
      ...props.note,
      completed: !props.note.completed,
      updateDate: Date.now()
    };
    emit('update', updatedNote);
  }

</script>

<template>
  <div>
    <h1 :class="{'highlight-title': props.note.completed}" @click="changeCompletition">
      <span class="checkball" :class="{'completed': props.note.completed}"></span>
      {{ props.note.description }}
    </h1>

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
            'bg-normal': props.note.priority === 'Normal' && priority === 'Normal',
            'unselected-priority': props.note.priority !== priority
          }"
          >
          {{ priority }}
        </span>
      </p>
      <p id="lastUpdate">
        Actualizado {{timeElapsed}} 
      </p>
    </div>
  </div>
</template>

<style scoped>
h1, p {
  text-align: left;
}

h1 {
  font-size: 1.8rem;
  cursor: pointer;
}

p {
  font-size: small;
}

#lastUpdate{
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
  background-color: #E74C3C;
}

.bg-normal {
  background-color: #3291D2;
}

.bg-low {
  background-color: #4a6e61;
}

.completed {
  background-color: #00BC8C ;
}

.highlight-title {
  color: #00BC8C;
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

.checkball.completed {
  background-color: #00BC8C; 
}

#secondaryData{
  display: flex;
}
</style>
