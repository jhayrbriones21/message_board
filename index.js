const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");

const io = require('socket.io')(server, {
    cors: {
        origin: '*',
    }
});

io.on('connection', (socket) => {

    socket.on('send-reply', (reply, room) => {
        io.sockets.in(room).emit('receive_reply', reply);
    });

    socket.on('send-reply-edited', (reply_edited, room) => {
        io.sockets.in(room).emit('receive_reply_edited', reply_edited);
    });

    socket.on('send-reply-deleted', (reply_deleted, room) => {
        io.sockets.in(room).emit('receive_reply_deleted', reply_deleted);
    });

    socket.on('send-message-edited', (message_edited, room) => {
        io.sockets.in(room).emit('receive_message_edited', message_edited);
    });

    socket.on('send-message-deleted', (message_deleted, room) => {
        console.log(message_deleted);
        io.sockets.in(room).emit('receive_message_deleted', message_deleted);
    });

    // joining to the room
    socket.on('join-room', room => {
        socket.join(room);
    })

    socket.on('disconnect', () => {
        console.log('user disconnected');
    });
});

server.listen(3000, () => {
    console.log('listening on *:3000');
});