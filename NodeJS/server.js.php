var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);
io.on('connection', function (socket) {

    console.log("Nuevo cliente conectado");
    var redisClient = redis.createClient();
    redisClient.subscribe('message');
    redisClient.subscribe('post');

    redisClient.on("message", function(channel, message) {
        console.log("Nuevo mensaje enviado por el canal "+channel);
        socket.emit(channel, message);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });

});