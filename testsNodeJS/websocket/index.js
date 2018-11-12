var http = require('http');
var fs = require('fs');
var ent = require('ent');
var mongoose = require('mongoose');


// DATABASE avec MONGODB
// mongoose.connect('mongodb://127.0.0.1:27017/test', { useNewUrlParser: true });
// mongoose.Promise = global.Promise;
// var db = mongoose.connection;
// db.on('error', console.error.bind(console, 'MongoDB connection error:'));
// var Schema = mongoose.Schema;
// var authorSchema = Schema({
// 	name: String,
// 	stories: [{ type: Schema.Types.ObjectId, ref: 'Story' }]
// });

// var storySchema = Schema({
// 	author: { type: Schema.Types.ObjectId, ref: 'Author' },
// 	title: String
// });

// var Story = mongoose.model('Story', storySchema);
// var Author = mongoose.model('Author', authorSchema);
// var bob = new Author({ name: 'Bob Smith' });

// bob.save(function (err) {
// 	if (err) return handleError(err);

// 	//Bob now exists, so lets create a story
// 	var story = new Story({
// 		title: "Bob goes sledding",
// 		author: bob._id    // assign the _id from the our author Bob. This ID is created by default!
// 	});

// 	story.save(function (err) {
// 		if (err) return handleError(err);
// 		// Bob now has his story
// 	});
// });
// mongoose.connection.close();



// SERVER

// Chargement du fichier index.html affiché au client
var server = http.createServer(function(req, res) {
    fs.readFile('./views/index.html', 'utf-8', function(error, content) {
        // res.setHeader('Access-Control-Allow-Origin', '*');
        // res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
        // res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        // res.setHeader('Access-Control-Allow-Credentials', true);

        res.writeHead(200, {"Content-Type": "text/html"});
        res.end(content);
    });
});

// Chargement de socket.io
var io = require('socket.io').listen(server);

// Quand un client se connecte, on le note dans la console
let increment = 0;
io.sockets.on('connection', function (socket) {
	let date = new Date();
	let color = Array();
	socket.on('newUser', function(pseudo) {
		socket.pseudo = pseudo;
		color[pseudo]= increment;
	    let curdate = date.getHours() + ":" + date.getMinutes();
	    socket.broadcast.emit('newUser',
	    					  {pseudo: 'Nouveau sur le forum : ' + pseudo,
	    					   date: curdate
							  });
		increment++;
	});
    
    socket.on('message', function(message){
		message = ent.encode(message);
		socket.pseudo = (socket.pseudo == undefined) ? 'visiteur' : socket.pseudo;
    	console.log(socket.pseudo + ' dit :' + message);

    	let curdate = date.getHours() + ":" + date.getMinutes();
    	let pseudo = socket.pseudo;

    	socket.broadcast.emit(
				    		'message',
				    		{
				    			other: pseudo,
				    			message: message,
								date: curdate,
								color: (color[pseudo] == undefined) ? 0 : color[pseudo]
				    		}
    		 			);
    })
});


server.listen(8082);