<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>popup</title>
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
	<style>
		.editable-popup{background: black; color: white;}
		.voir-commentaire{display: none; width: 200px; height: 400px;}
	</style>
</head>
<body>
	<div class="voir-commentaire">
		
	</div>
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
			<!-- <td></td> -->
<!-- 			<td>
				<div>date - user - commentaire</div><br>
				<button id="addComm" data-type="text" data-placement="bottom" data-title="Enter username">Ajouter</button>
			</td> -->
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
