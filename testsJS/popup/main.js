$(document).ready(function() {
    $.fn.editable.defaults.mode = 'popup';
    $('#status').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'status 1'},
            {value: 2, text: 'status 2'},
            {value: 3, text: 'status 3'}
        ]
    });
    $('body').on("click", ".seeComm", function(){
        var echo = $(this);
        console.log(echo);
    })

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
                var commentLast = result[i]['commentaire'][0];
                var commentAll= "";
                for(var coms in result[i]['commentaire'])
                    {
                        commentAll += result[i]['commentaire'][coms]+"\n";
                    }
                var id = result[i]['id'];
                $("#addRow").append(
                    "<tr>"+
                    "<td>"+numcmd+"</td>"+
                    "<td><div>"+((commentLast==undefined)?"":commentLast)+"</div>"+
                        "<button class='addComm' value='"+id+"'>+</button>"+
                        "<button class='seeComm' value='"+id+"' title='"+commentAll+"'>voir</button>" +
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
                                    // title: 'Ajouter commentaire',
                                });
            }
        });

    });

    function addComm(id, commentaire){
        $.ajax({
          method: "POST",
          url: "models.php",
          data: {idcmd: id, comment: commentaire}
        }).done(function(data) {
            console.log("data => " + data);
            $("body").append(data);
        })
    }
})