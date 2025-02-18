const express = require("express"); // Aplicacion de Express que utiliza node
const { createServer } = require("node:http");
const app = express();
const server = createServer(app);
const port = 3000;
const path = require("path");
const { Server } = require("socket.io");
const cors = require('cors'); 

app.use(cors());

const io = new Server(server, {
  cors: {
    origin: "http://localhost:5173", // Your Vue.js app's URL
    methods: ["GET", "POST"]
  }
});

// lista para almacenar los nombres de usuario por ID de socket
const users = {};

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "/public/index.html"));
});

io.on("connection", (socket) => {
  console.log("A user connected, total users connected: " + io.engine.clientsCount);

  socket.on('message', (data) =>{
    socket.broadcast.emit('messageServidor', data);
  });

  socket.on('name', (name) =>{
    console.log(name);
    users[socket.id] = name; // Almacena el nombre del usuario
    socket.broadcast.emit('usernameConnected', name);
  });

  socket.on("disconnect", () => {
    console.log("A user disconnected, total users connected: " + io.engine.clientsCount);
    const disconnectedUser = users[socket.id];
    if (disconnectedUser) {
      delete users[socket.id];
      socket.broadcast.emit('usernameDisconnected', disconnectedUser);
    }
  });
});
app.use(express.static(path.join(__dirname, "public")));

server.listen(port, '0.0.0.0', () => {
  console.log(`Server listening on http://localhost:${port}`);
});
