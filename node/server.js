const express = require("express");
const socketIO = require("socket.io");
const fs = require('fs');
const https = require('https');
const http = require('http');


const app = express();
// Variables 
process.env.MODE = 'prod';

// Settings
app.set('port', process.env.PORT || 3000 );


// Middlewares
app.use(
    express.urlencoded({
        extended: false
    })
);


// Starting server
if(process.env.MODE == 'dev'){
    server = http.createServer(app).listen(app.get('port'), () =>{
        console.log(`Server running on ${app.get('port')}`);
    });
    console.log('dev'); // Running on localhost without https
}else{
    // certificados para constructivo.com
    server = https.createServer({
        key: fs.readFileSync('cert/my_cert.key'), 
        cert: fs.readFileSync('cert/my_cert.crt')
    }, app).listen(app.get('port'), () =>{
        console.log(`Server running on ${app.get('port')}`);
    });
    console.log('prod'); // Running on https://constructivo.com:3000
}



//Variable users para almacenar usuarios en linea
let users = [];

// WebSockets
const io = socketIO(server);
io.on('connection', (socket) =>{
    console.log('New connection', socket.id);
    socket.on('newuser', (user) =>{
        let user_exits = users.find(userFounded => {
            return userFounded.user_id === user.user_id;
        });

        if (!user_exits) {
            users.push({
                user_id: user.user_id,
                socketId : socket.id,
                user: user.user,
                role: user.role
            });
        }
        io.sockets.emit('online-users', users);

    })

    socket.on('chat:typing', (username) => {
        socket.broadcast.emit('chat:typing', username);
    });

    socket.on('chat:message', (data) =>{
        io.sockets.emit('chat:message', data);
    });

    // on disconnect
    socket.on('disconnect', function(){
        let users_update = users.filter(userFounded =>{
            return userFounded.socketId != socket.id;
        });
        users = users_update;
        console.log('One desconnetion', socket.id);
        io.sockets.emit('online-users', users);
    });

});

// Recibe el evento de Laravel por el metodo POST
/*app.post('/new-message', (req, res) =>{
    let params = req.body;
    
    res.end();
});*/


