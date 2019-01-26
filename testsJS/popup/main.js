$(document).ready(function() {
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';     
    
    //make username editable
    // $('.addComm').editable({
    //     type: 'text',
    //     url: '/post',    
    //     pk: 1,    
    //     placement: 'top',
    //     title: 'Comment'
    // });


    //make status editable
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
                var comment = result[i]['commentaire'][0];
                var id = result[i]['id'];
                $("#addRow").append(
                    "<tr>"+
                    "<td>"+numcmd+"</td>"+
                    "<td><div>"+((comment==undefined)?"":comment)+"</div>"+
                        "<button class='addComm'>+</button><button>voir</button>" +
                    "</td>"+
                    "</tr>"
                    );
                $('.addComm').editable({
                                    type: 'text',
                                    url: 'models.php',
                                    placement: 'bottom',
                                    value: "Ajouter commentaire",
                                    success: function(response, commentaire) {
                                        addComm(id, commentaire);
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
        })
    }
})