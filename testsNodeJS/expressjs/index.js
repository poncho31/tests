var express = require('express');
var morgan = require('morgan'); //middleware pour le login
var favicon = require('serve-favicon'); //middleware pour la favicon
var session = require('cookie-session'); // middleware de session
var bodyParser = require('body-parser'); // middleware de gestion de paramètres
var urlencodedParser = bodyParser.urlencoded({ extended: false });
var app = express();



app.use(session({secret: 'todotopsecret'})) // Utilise les sessions
.use(function(req, res, next){ // créé la session si n'existe pas
    if (typeof(req.session.todolist) == 'undefined') {
        req.session.todolist = [];
    }
    next();
})


.use(morgan('combined')) // active middleware de login
.use(express.static(__dirname + '/public')) // /public contient fichiers statiques
.use(favicon(__dirname + '/public/favicon.ico')) // active favicon


// TODO list
.get('/todolist', function(req, res){
	res.render('toDoList.ejs', {todolist: req.session.todolist});
})
.post('/todolist/ajouter', urlencodedParser, function(req, res){
	if (req.body.newtodo != '') {
		req.session.todolist.push(req.body.newtodo);
	}
	res.redirect('/todolist');
})
.get('/todolist/supprimer/:id', function(req, res){
	if (req.params.id != '') {
		req.session.todolist.splice(req.params.id, 1);
	}
	res.redirect('/todolist');
})
// end TODO list


.get('/', function(req, res) {
    res.setHeader('Content-Type', 'text/plain');
    res.send('Vous êtes à l\'accueil');
})
.get('/page/:num', function(req, res) {
	const num = req.params.num;
	if (parseInt(num)) {
		const noms = ['robert', 'alfred', 'romelo', 'David'];
	    res.render('page.ejs', {compteur: req.params.num, noms: noms});
	}
	else{
		res.setHeader('Content-Type', 'text/plain');
    	res.status(404).send('Page introuvable !');
	}
})

.use(function(req, res, next){
    res.setHeader('Content-Type', 'text/plain');
    res.status(404).send('Page introuvable !');
});

app.listen(8082);