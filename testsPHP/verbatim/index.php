<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Verbatim</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
	<h1 class="jumbotron text-center">Verbatim</h1>
	<form action="" style="margin: 5px;">
		<div class="input-group">
		    <textarea class="form-control custom-control text" rows="15" style="resize:none" placeholder="Texte à analyser"></textarea>     
		    <span class="input-group-addon btn btn-warning submit">Envoyer</span>
		</div>
	</form>
	
	<div class="bg-warning text-center ">Result</div>
	<div class="result container"></div>
	<div class="info container"></div>


	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
			$('.submit').on('click', function(){
				var textValue = $('.text').val();
				gram = {"PRO":"pronom", "ADJ:num" : "adjectif numérique", "ART:ind":"article indéfini", "NOM":"nom", "PRO:ind":"pronom indéfini"};
				$('.result').html("<img src='anim.gif' width='200px' style='margin: 0 40%;'>");
				$.ajax({
				  method: "POST",
				  url: "analyse.php",
				  data: { text: textValue, putDico: false},
				  async: true
				})
				.done(function( msg ) {
					console.log(msg);
					checkPol = "";

					// found politician
					for (var politician in msg['politicianFound']) {
						pol = msg['politicianFound'][politician];
						if(checkPol.indexOf(pol) == -1){
							checkPol += pol + " ";
							titleTagPol = "<span title='politician' style='background-color: red'>"+pol +"</span>";
							regex = new RegExp('\\b' + pol + '\\b', "gi");
							textValue = textValue.replace(regex, titleTagPol);
							$('.info').append('<p>Politician : '+pol+'</p>');

							// if(checkPol.indexOf(pol) == -1){
								wordBefore = msg['wordAround'][pol]['before'];
								wordAfter = msg['wordAround'][pol]['after'];
								titleTagWordBefore = "<span title='Word before "+ pol+"' style='background-color: yellow'>"+wordBefore +"</span>";
								regex1 = new RegExp('\\b' + wordBefore + '\\b', "gi");
								textValue = textValue.replace(regex1, titleTagWordBefore);

								titleTagWordAfter = "<span title='Word after "+ pol+"' style='background-color: yellow'>"+wordAfter +"</span>";
								regex2 = new RegExp('\\b' + wordAfter + '\\b', "gi");
								textValue = textValue.replace(regex2, titleTagWordAfter);
								// $('.info').append('<p>Word around : '+word+'</p>');
							// }
						}
					}
					// wordAround politician
					// for (var wordAround in msg['wordAround']) {
					// 	wordBefore = msg['wordAround'][wordAround]['before'];
					// 	wordAfter = msg['wordAround'][wordAround]['after'];
					// 	if(checkPol.indexOf(wordAround) == -1){
					// 		alert('fff');
					// 		titleTagWordBefore = "<span title='wordAround' style='background-color: yellow'>"+wordBefore +"</span>";
					// 		regex1 = new RegExp('\\b' + wordBefore + '\\b', "gi");
					// 		textValue = textValue.replace(regex1, titleTagWordBefore);

					// 		titleTagWordAfter = "<span title='wordAround' style='background-color: yellow'>"+wordAfter +"</span>";
					// 		regex2 = new RegExp('\\b' + wordAfter + '\\b', "gi");
					// 		textValue = textValue.replace(regex2, titleTagWordAfter);
					// 		$('.info').append('<p>Word around : '+word+'</p>');
					// 	}
					// }

					// found parti
					for (var politician in msg['partiFound']) {
						parti = msg['partiFound'][politician];
						if(checkPol.indexOf(parti) == -1){
							checkPol += parti + " ";
							titleTagPol = "<span title='parti' style='background-color: green'>"+parti +"</span>";
							regex = new RegExp('\\b' + parti + '\\b', "gi");
							textValue = textValue.replace(regex, titleTagPol);
							$('.info').append('<p>Parti : '+parti+'</p>');
						}
					}

					// found grammar word
					for (var word in msg['wordFound']) {
						if(checkPol.indexOf(word) == -1){
							grammar = msg['wordFound'][word];
							titleTagWord = "<span title='"+grammar+"'>"+word +"</span>";
							regex = new RegExp('\\b' + word + '\\b', "gi");
							textValue = textValue.replace(regex, titleTagWord);
						}
					}
					$('.result').html(textValue);
				})
				.fail(function(e){
					alert("Failed: " + e);
				})

			})

		})
	</script>
</body>
</html>