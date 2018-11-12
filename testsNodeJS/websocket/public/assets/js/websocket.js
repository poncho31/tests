var socket = io.connect('http://192.168.0.10:8082', { transports: ['websocket', 'polling', 'flashsocket'] });
var pseudo = prompt('Quel est votre pseudo ?');
if (pseudo != null && pseudo != '') {
    socket.emit('newUser', pseudo);
    socket.on('newUser', function (newUser) {
        if (newUser['pseudo'] != undefined) {
            $("<tr ><td class='newUser'><small>(" + newUser['date'] + ")</small> " + newUser['pseudo'] + "</td></tr>").hide().prependTo('.info').fadeIn();
        }
    })

    $('#submit').click(function () {
        let date = new Date();
        let curdate = date.getHours() + ":" + date.getMinutes();
        let val = $('#poke').val();
        socket.emit('message', val);
        $(lineChat(curdate, val, ['me', pseudo])).hide().prependTo(".info").fadeIn();
    });

    // Message envoyé aux autres utilisateur
    socket.on('message', function (message) {
        if (message['other'] != undefined) {
            $(lineChat(message['date'], message['message'], ['other', message['other']])).hide().prependTo(".info").fadeIn();
            var sound = new Audio('../sound/sound.mp3');
            sound.play();
        }
    });
}
else {
    window.location.replace('http://192.168.0.10:8082');
}

function lineChat(date, message, person = array()) {
    var echo = "<tr><td class='" + person[0] + "'><span>" + person[1] + "</span> " + message + " <small> (" + date + ")</small></td></tr>";
    return echo;
}