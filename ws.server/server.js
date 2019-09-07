var io = require('socket.io')(6001);
    Redis = require('ioredis');
    redis = new Redis;

redis.psubscribe('chat', function (error, count) {
    console.log(error, count);
});

redis.on('pmessage', function (pattern, channel, message) {
    console.log(pattern, channel, message);

    message = JSON.parse(message);

    io.emit(channel + ':' + message.event, message.data.message);
});
