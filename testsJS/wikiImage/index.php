<?php
// header('Content-Type: application/json');
$url = 'https://fr.wikipedia.org/w/api.php?action=query&format=json&prop=pageimages%7Cpageterms&generator=prefixsearch&redirects=1&formatversion=2&piprop=thumbnail&pithumbsize=250&pilimit=20&wbptterms=description&gpssearch=bart_de_wever';
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$resultJSON = curl_exec($ch);
curl_close($ch);
// echo '<pre>';
// print_r($resultJSON);
// echo '</pre>';
$resultAsocArray = json_decode($resultJSON,true);
for($i = 0; $i < 20; $i++) {
	if (!empty($resultAsocArray['query']['pages'][$i])) {
		echo $resultAsocArray['query']['pages'][$i]['title'] . "<br>";
		if (!empty($resultAsocArray['query']['pages'][$i]['thumbnail']['source'])) {
			echo "<img src='".$resultAsocArray['query']['pages'][$i]['thumbnail']['source']."'>". "<br>";
		}
		else{
			echo "<img src='https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg'>". "<br>";
		}
		if (!empty($resultAsocArray['query']['pages'][$i]['terms']['description'])) {
			// $length = count($resultAsocArray['query']['pages'][$i]['terms']['description']);
			foreach ($resultAsocArray['query']['pages'][$i]['terms']['description'] as $value) {
				echo $value . "<br>";
			}
		}
		else{
			echo 'no description <br>';
		}
		echo "<hr>";
	}
}
 ?>