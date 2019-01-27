$(document).ready(function() {
    // $.fn.editable.defaults.mode = 'popup';
    // $('body').on("click", ".seeComm", function(){
    //     var echo = $(this);
    //     $(".voir-commentaire").toggle().css("position", "absolute");

    //     console.log(echo);
    // });
    // $('.voir-commentaire').on("click", function(){
    //     $(this).toggle();
    // });

    $("#numCmd").on('change', function(){
        var val = $(this).val();
        $("#addRow").html("");
        $.ajax({
          method: "POST",
          url: "models.php",
          data: {numcmd: val}
        }).done(function(data) {
            var result = JSON.parse(data);
            for (var i = 0; i < result.length; i++) {
                var numcmd = result[i]['numcmd'];
                var commentLast = "";
                var commentAll = "";
                if (result[i]['commentaire'].hasOwnProperty(0)) {
                    commentLast = "<table><tr>"+
                                        "<td>"+ result[i]['commentaire'][0]["date"] + "</td>"+
                                        "<td>"+ result[i]['commentaire'][0]["user"] + "</td>"+
                                        "<td>"+ result[i]['commentaire'][0]["comment"] + "</td>"+
                                        "</tr></table>";

                    commentAll= "<table>";
                    for(var coms in result[i]['commentaire'])
                        {
                            commentAll += "<tr>";
                            commentAll += "<td>"+result[i]['commentaire'][coms]["date"]+'</td>';
                            commentAll += "<td>"+result[i]['commentaire'][coms]["user"]+'</td>';
                            commentAll += "<td>"+result[i]['commentaire'][coms]["comment"]+'</td>';
                            commentAll += "</tr>";
                        }
                    commentAll += "</table>";
                }
                var id = result[i]['id'];
                $("#addRow").append(
                    "<tr>"+
                    "<td>"+numcmd+"</td>"+
                    "<td>"+
                        "<div>"+((commentLast==undefined)?"":commentLast)+"</div>"+
                        "<button class='addComm' value='"+id+"' title='Ajouter un commentaire'>+</button>"+
                        "<button class='seeComm' value='"+id+"' data-all='"+commentAll+"'>voir</button>" +
                    "</td>"+
                    "</tr>"
                    );
                $('.addComm').editable({
                                    type: 'text',
                                    url: 'models.php',
                                    placement: 'bottom',
                                    value: "Ajouter commentaire",
                                    success: function(response, commentaire) {
                                        addComm($(this).val(), commentaire);
                                    }
                                });
            }
        });

    });
    $('body').on("click", ".seeComm", function(){
        var val = $(this).attr("data-all");
        var pos = $(this).offset();
        $(".voir-commentaire").html(val + "<span class='close'>&#10006;</span>");
        $(".voir-commentaire").slideToggle("fast");
        $(".voir-commentaire").css("top", pos.top+20+"px");
        $(".voir-commentaire").css("left", pos.left+"px");

    });
    $("body").on("click",".close", function(){
        $(".voir-commentaire").slideToggle("fast");
    })
    function addComm(id, commentaire){
        $.ajax({
          method: "POST",
          url: "models.php",
          data: {idcmd: id, comment: commentaire},
          success: function(data) {
            $(".flashMsg").append("Commentaire ajouté");
            $(".flashMsg").css("background-color", "#5cb85c");
            setTimeout(function(){
                $('.flashMsg').addClass('removeflash');
                $('.flashMsg').css("background-color", "green");
            },5000);
          },
          error: function(er){
            $(".flashMsg").append("Erreur lors de l'ajout d'un commentaire");
            setTimeout(function(){
                $('.flashMsg').removeClass('flashMsg').addClass('removeflash');
            },5000);
          }
        })
    }
    function popup() {
      // ouvre une fenetre sans barre d'etat, ni d'ascenceur
      w=open("",'popup','width=400,height=200,toolbar=no,scrollbars=no,resizable=yes'); 
      w.document.write("<title>"+document.forms["f_popup"].elements["titre"].value+"</title>");
      w.document.write("<body> Bonjour "+document.forms["f_popup"].elements["nom"].value+"<br><br>");
      w.document.write("Ce popup n'est pas un fichier HTML, ");
      w.document.write("il est écrit directement par la fenêtre appelante");
      w.document.write("</body>");
      w.document.close();
    }
})