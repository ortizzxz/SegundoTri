// const http = require('node:http');

// const hostname = '127.0.0.1';
// const port = 3000;

// const server = http.createServer((req, res) => {
//   res.statusCode = 200;
//   res.setHeader('Content-Type', 'text/plain');
//   res.end('OOOOOOOOOOOOOOOOOOOOOOOOOO\n');
// });

// server.listen(port, hostname, () => {
//   console.log(Server running at http://${hostname}:${port}/);
// });

const express = require('express')
const { createServer } = require('node:http');
const app = express()
const server = createServer(app);
const port = 3000
const path = require('path')
const { Server } = require('socket.io');
const io = new Server(server);

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, '/public/api.html'));
  });

io.on('connection', (socket) => {
    console.log('a user connected');
  });

app.use(express.static(path.join(__dirname, 'public')))

server.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})