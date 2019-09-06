var io = require('socket.io')(6001);

io.on('connection', function (socket) {
    console.log('connection');

    socket.on('message', function (data) {
        console.log(data);

        io.emit('new_message', data);
    });
});

