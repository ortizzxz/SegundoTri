<template>
  <div class="container">
    <div class="chat-list">
      <h2>Chats</h2>
      <ul id="chat-history">
        <!-- Chat history will be added dynamically -->
      </ul>
    </div>
    <div class="chat-area">
      <div class="chat-header">
        <img src="../assets/img/whatsappLogo.png" alt="Imagen del grupo" />
        <h1>Grupo General</h1>
      </div>

      <div id="user-notifications">
        <div v-for="notification in notifications" :key="notification.id" :class="['user-notification', notification.type]">
          {{ notification.message }}
        </div>
      </div>

      <div class="messages-container" ref="messagesContainer">
        <div v-for="message in messages" :key="message.id" :class="['message', message.type]">
          <template v-if="message.type === 'other'">
            {{ message.user }}: {{ message.data }}
          </template>
          <template v-else>
            {{ message.data }}
          </template>
        </div>
      </div>

      <div class="input-area">
        <input v-model="newMessage" @keydown.enter="sendMessage" id="data" type="text" placeholder="Escribe un mensaje..." />
        <button @click="sendMessage" id="send">
          <img src="../assets/img/enviar.png" alt="Enviar" />
        </button>
      </div>
    </div>
  </div>
</template>


<script>
import { io } from 'socket.io-client';

export default {
  data() {
    return {
      socket: null,
      name: '',
      newMessage: '',
      messages: [],
      notifications: []
    };
  },
  mounted() {
    this.socket = io('http://localhost:3000');
    this.name = prompt("Escribe tu nombre: ");

    if (this.name) {
      this.socket.emit("name", this.name);
    }

    this.socket.on("usernameConnected", (name) => {
      this.showUserNotification(`${name} se ha conectado`, "connected");
    });

    this.socket.on("usernameDisconnected", (name) => {
      this.showUserNotification(`${name} se ha desconectado`, "disconnected");
    });

    this.socket.on("messageServidor", (data) => {
      const receivedData = JSON.parse(data);
      this.receiveMessageData(receivedData, "other");
    });
  },
  methods: {
    sendMessage() {
      const messageText = this.newMessage.trim();
      if (messageText) {
        const messageData = { user: this.name, data: messageText };
        this.socket.emit("message", JSON.stringify(messageData));
        this.addMessageData(messageData, "user");
        this.newMessage = "";
      }
    },
    showUserNotification(message, type) {
      const notification = { id: Date.now(), message, type };
      this.notifications.push(notification);
      setTimeout(() => {
        const index = this.notifications.findIndex(n => n.id === notification.id);
        if (index !== -1) {
          this.notifications.splice(index, 1);
        }
      }, 3000);
    },
    addMessageData(messageData, type) {
      this.messages.push({ ...messageData, type });
      this.$nextTick(() => {
        this.scrollToBottom();
      });
    },
    receiveMessageData(messageData, type) {
      this.messages.push({ ...messageData, type });
      this.$nextTick(() => {
        this.scrollToBottom();
      });
    },
    scrollToBottom() {
      const container = this.$refs.messagesContainer;
      container.scrollTop = container.scrollHeight;
    }
  }
};
</script>

<style scoped>
</style>
