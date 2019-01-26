<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Organizer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .title{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="title">Organizer</h1>
    <hr>
        <label for="folder">Dossier</label>
        <input type="text" id="folder" name="folder">

        <label for="mimetype">Type de fichier</label>
        <input type="text" id="mimetype" name="mimetype">

        <button type="submit" name="submit" id="submitPath">Récupérer fichier</button>
    <hr>
    <div class="result">
        
    </div>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#submitPath").click(function(){
            $(".result").html("<img src='loader.gif'></img>");
			$.ajax({
			  method: "POST",
			  url: "music.php",
              dataType: "json",
			  data: {
                  folder: $("#folder").val(),
                  mimetype: $("#mimetype").val()
                  }
			})
			.done(function( msg ) {
                console.log(msg);
                // elem.html(msg);
                $(".result").html(msg);
            })
            .fail(function(err){
                console.log('error');
            })
        });
        
        $(".result").on("click", ".getMusic", function(){
            var val = $(this).attr('id');
            var elem = $(this);
            elem.html("<img src='loader.gif'></img>");
			$.ajax({
			  method: "POST",
			  url: "music.php",
              dataType: "json",
			  data: { getMusic: val}
			})
			.done(function( msg ) {
                elem.html(msg);
                elem.removeClass("getMusic");
            })
            .fail(function(err){
                console.log('error');
            })
        })
    })
</script>
</body>
</html>