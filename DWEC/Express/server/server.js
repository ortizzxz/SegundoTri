const express = require("express"); // Aplicacion de Express que utiliza node
const { createServer } = require("node:http");
const app = express();
const server = createServer(app);
const port = 3000;
const path = require("path");
const { Server } = require("socket.io");
const io = new Server(server);

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "/public/index.html"));
});

io.on("connection", (socket) => {
  console.log("A user connected, total users connected: " + io.engine.clientsCount);

  socket.on('message', (data) =>{
    socket.broadcast.emit('messageServidor', data);
  });

  socket.on("disconnect", () => {
    console.log("A user disconnected, total users connected: " + io.engine.clientsCount);
  });
});

app.use(express.static(path.join(__dirname, "public")));

server.listen(port, () => {
  console.log(`Example app listening on port ${port}`);
});
