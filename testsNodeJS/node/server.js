var http = require('http');
var url = require('url');
var querystring = require('querystring');
var EventEmitter = require('events').EventEmitter;
var jeu = new EventEmitter();

var testModule = require('testModuleNode');
var markdown = require('markdown').markdown;


var server = http.createServer();

server.on('request',function(req, res) {
	var page = url.parse(req.url).pathname;
	var params = querystring.parse(url.parse(req.url).query);
	var echo = '<!DOCTYPE html>'+
				'<html>'+
				'    <head>'+
				'        <meta charset="utf-8" />'+
				'        <title>Ma page Node.js !</title>'+
				'    </head>'+ 
				'    <body>';

	console.log(page);
	var mess;
	jeu.on('nom', function(message, message2){
		console.log(message, message2);
		mess = message + " " + message2;
	})
	jeu.emit('nom', 'Vous avez perdu', 35);
	testModule.direBonjour();
	if (page == '/') {
		echo += 'Homepage';
	}
	else if(page == '/page2' || 'prenom' in params && 'nom' in params){
		var nom = ('nom' in params)? params['nom'] : 'Nouveau';
		var prenom = ('prenom' in params)? params['prenom'] : 'visiteur';
		echo += 'Page 2 <br>';
		echo += 'Enchanté ' + nom + " " + prenom + mess;
	}
	else{
		echo += "Page introuvable" + markdown.toHTML('Un paragraphe en **markdown** !');
	}
	echo += '</body>'+ '</html>';
	res.writeHead(200, {"Content-Type":"text/html"});
	res.write(echo);
	res.end();
});

server.on('close', function(){
	console.log('Je vais me fumer une clope');
})
server.listen(8082);
// server.close();