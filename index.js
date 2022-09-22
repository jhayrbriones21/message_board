const express = require('express');
const app = express();
const http = require('http');
const { exit } = require('process');
const server = http.createServer(app);
const { Server } = require("socket.io");

const io = require('socket.io')(server, {
    cors: {
        origin: '*',
    }
});
const connectedUsers = new Map();

const privateNamespace = io.of("/private_message");

privateNamespace.on("connection", (socket) => {
    socket.join("private_chat"); // distinct from the room in the "orders" namespace
    console.log('namespace: ' + socket.id);


    // joining to the private room
    socket.on('join-private-room', room => {
        socket.join(room);
    });

    socket.on('send-private-message', (message, room) => {
        console.log(room);
        socket.broadcast.to(room).emit('receive_private_message', message);

        privateNamespace.to("private_chat").emit("has_new_chat_users");
    });
    // privateNamespace.to("private_chat").emit("has chated users");
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
    socket.on('join-room', (room, user) => {
        socket.join(room);
        // console.log(socket.id + ' join');

        // broadcast to the user connected to this room
        user.socket_id = socket.id;
        io.sockets.in(room).emit('users_connected_to_this_room', joinToRoom(room, user));
    });

    socket.on("disconnecting", () => {
        socket.rooms.forEach(function (room) {
            // console.log('room: ' + room);
            // console.log('socket_id: ' + socket.id);
            io.sockets.in(room).emit('users_connected_to_this_room', disconnectToRoom(room, socket.id));
        });

    });
});

function joinToRoom(room, user) {
    // create users array, if key not exists
    if (!connectedUsers.has(room)) {
        connectedUsers.set(room, []);
    }

    connectedUsers.get(room).push(user)
    return connectedUsers.get(room);
}

function disconnectToRoom(room, socket_id) {
    // create users array, if key not exists
    if (!connectedUsers.has(room)) {
        connectedUsers.set(room, []);
    }
    // get user to this room
    let userList = connectedUsers.get(room);

    // filter and remove existing
    userList.filter((u, i) => {
        if (u.socket_id == socket_id) {
            connectedUsers.get(room).splice(i, 1);
        }
    });

    return connectedUsers.get(room);
}

server.listen(3000, () => {
    console.log('listening on *:3000');
});