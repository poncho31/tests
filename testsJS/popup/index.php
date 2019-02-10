<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>popup</title>
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
	<style>
		.editable-popup{background: #DFEEFC; color: white; padding: 1%;border: solid black 1px;}
		.voir-commentaire{
			display: none;
			position: absolute;
			width: auto; 
			height: auto; 
			background-color: #DFEEFC; 
			right: 0; 
			border: solid black 1px;
			padding: 1%;
			text-align: justify;

		}
		.addComm, .seeComm {margin: 1%;}
		.close{position: relative; top: 100%; float: right;}
		.close:hover{cursor: pointer;}
		.removeflash{display: none}
		.flashMsg{display: block; position: absolute; text-align: center; top: 0; right: 0%; padding: 1%; margin: 1%; }
	</style>
</head>
<body>
	<div class="voir-commentaire"></div>
	<div class="flashMsg"></div>
	<table>
		<thead>
			<td>Numéro</td>
			<td>Commentaire</td>
		</thead>
		<tbody>
			<td><input type="text" id="numCmd"></td>
			<td></td>
		</tbody>
		<tbody id="addRow"></tbody>
	</table>
	<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous">		  	
	</script>
	<script src="http://vitalets.github.io/x-editable/assets/poshytip/jquery.poshytip.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
	<script src="main.js"></script>
</body>
</html>
