<?php
header('Content-Type: text/html; charset=utf-8');

// header('Content-Type: text/html; charset=iso-8859-15');
$text = (isset($_POST['text']))? $_POST['text'] : 'Cet après-midi ls partis politiques doivent se 
prononcer sur le pacte migratoire lors d’un vote en séance plénière du Parlement. S’ils votent 
pour ou contre. Pour le PS, la N-VA a franchi la ligne Bart de wever grand de la guerre Di Rupo petit.';
$putDico = (isset($_POST['putDico']))?$_POST['putDico']:false;
$time = -microtime(true);
$db = new PDO("mysql:dbname=rss;host=localhost; charset=utf8", "root", "");
$a = $text;
$result = ['politicianFound' => [], 'wordFound' => [], 'partiFound' => [], 'time'];
function wordsAround($name, $text){
	preg_match('/\s*(\w+|\S*[\'-]([a-zA-Z\'-]+))?\s*\S*'.$name.'\S*\s*(\w+|\S*[\'-]([a-zA-Z\'-]+))?\s*/i', $text, $wordAround);
	// if (strripos($text, $name)) {
		// $wordAround['name'] = $name;
		echo "<pre>";
		var_dump($wordAround);
		echo "</pre>";
	// }
	// $wordAround= ['before'=> isset($wordAround[2])? (($wordAround[2] != '')?$wordAround[2]:'Debut de phrase'):'',
	// 			 'after'=> isset($wordAround[3])? (($wordAround[3] != '')?$wordAround[3]:'Fin de phrase'):''
	// 			];
	// return (isset($wordAround[2])? $wordAround[2]:((isset($wordAround[1]))? $wordAround[1]:''));
	// return $wordAround;
}

	$concatValue = "";
			// Politician 
			$sql2 = "SELECT firstname, lastname FROM politicians";
			$stmt2 = $db->prepare($sql2);
			$stmt2->execute();
			$i = 0;
			while ($row = $stmt2->fetch()) {
				// echo "<pre>";
				// var_dump($row);
				// echo "</pre>";
				// echo $row['lastname'];
				$nameComplete = $row['firstname'] . " " . $row['lastname'];
				$nameReverse = $row['lastname'] . " " . $row['firstname'];
				$text = " " . $text . " ";
				// var_dump(strripos($text, $row['firstname']));
				// var_dump(strripos($text, $row['lastname']));
				// var_dump(strripos($text, $nameComplete));
				// var_dump(strripos($text, $nameReverse));
				// $name = preg_match("/\Y\S+".$row['firstname']."|".$row['lastname']."|".$nameComplete."|".$nameReverse."\s+\Y/i", $text, $match);
				
				// $lastname = preg_match_all("/\b".$row['lastname']."\b/i", $text, $fnMatch);
				// $lastname = preg_match("#\s+{$row['lastname']}\s+#i", $text, $lnMatch, PREG_OFFSET_CAPTURE)? $matches2[0][0] : false;
				// var_dump($match);
			    if(strripos($text, $row['lastname'])){
					// echo "<pre>";
					// var_dump($match[0]);
					// echo "</pre>";
					$lastna = strripos($text, $row['lastname']);
					if ($lastna && !in_array($row['lastname'], $result['politicianFound'])) {
						$result['politicianFound'][] = $nameComplete;
						$result['wordAround'][$nameComplete] = wordsAround( $row['lastname'], $text);
					}
					// elseif(strripos($text, $nameComplete) && in_array($name, $result['politicianFound'])){
					// 	$result['wordAround'][$nameComplete] = wordsAround($nameComplete, $text);
					// }
			    }
			    // elseif(strripos($text, $nameReverse)){
				// 	if ( !in_array($nameReverse, $result['politicianFound'])) {
				// 		$result['politicianFound'][] = $nameReverse;
				// 		$result['wordAround'][$name][] = wordsAround($nameReverse, $text);
				// 	}
				// 	else{
				// 		$result['wordAround'][$name][] = wordsAround($nameReverse, $text);
				// 	}
			    // }
			    // elseif($lastname && !in_array($lastname, $result['politicianFound'])){
				// 	// $result['politicianFound'][] = $name;
			    // 	// $result['wordAround'][$name][] = wordsAround($lastname[0], $text);
				// 	if($firstname && !in_array($firstname, $result['politicianFound'])){
				// 		$result['politicianFound'][] = $name;
				// 		$result['wordAround'][$name][] = wordsAround($firstname[0], $text);

				// 	}
			    // }
			}

			// parti
			// $sqlParti = "SELECT nom, nomComplet FROM parti";
			// $partiStmt = $db->prepare($sqlParti);
			// $partiStmt->execute();
			// while ($parti = $partiStmt->fetch()) {
			// 	$partiAbv = $parti['nom'];
			// 	$partiComplete = $parti['nomComplet'];
			// 	$check = preg_match("/".$partiComplete ."|".$partiAbv."/", $text);

			//     if($check && !in_array($partiAbv, $result['partiFound'])){
			//     	$result['partiFound'][] = $partiAbv;
			//     }
			//     if(strripos($text, $partiComplete) && !in_array($partiComplete, $result['partiFound'])){
			//     	$result['partiFound'][] = $partiComplete;
			//     }
			// }

if(false) {
	$sql = "SELECT orthographe, grammaire FROM lexique";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$lexique = $stmt->fetchAll();

	$text = preg_replace('/([^a-zA-Z0-9_éèêàç])/', '-', $text);
    $text = preg_replace('/(-)+/', '-', $text);
    $textArray = explode('-', $text);
	foreach ($textArray as $word) {
	  $word = mb_strtolower($word, 'UTF-8');
		foreach($lexique as $row) {
			$dico = mb_strtolower($row['orthographe']);
			$grammaire = mb_strtolower($row['grammaire']);
			if($dico == $word ){
				if(stripos($value, $dico)){
					if(isset($result['wordFound'][$dico])){
						if (!in_array($grammaire, $result['wordFound'][$dico])) {
							$result['wordFound'][$dico][] = $grammaire;
						}
					}
					else{
						$result['wordFound'][$dico] = [$grammaire];
					}
					// echo json_encode($result);
				}
			}
		}
	}
	
}
$time += microtime(true);
// echo $time;
$result['time'] = $time;
// header("Content-Type: application/json");
// echo json_encode($result);






// header('Content-Type: text/html; charset=utf-8');
// // header('Content-Type: text/html; charset=iso-8859-15');
// $text = (isset($_POST['text']))? $_POST['text'] : "Le parquet général de Mons a confirmé lundi dans un communiqué l'inculpation du député bruxellois MR Armand De Decker pour trafic d'influence dans le cadre du dossier du 'Kazakhgate'. 'Dans le cadre de l'affaire dite du Kazakhgate, le magistrat mouvement réformateur MR";

// $time = -microtime(true);
// $db = new PDO("mysql:dbname=rss;host=localhost; charset=utf8", "root", "");
// // $text = preg_replace('/([^a-zA-Z0-9_éèêàç])/', '-', $text);
// // $text = preg_replace('/(-)+/', '-', $text);
// $textArray = $text;
// $result = ['politicianFound' => [], 'wordFound' => [], 'partiFound' => [], 'time', 'text' => $text];


// $sql = "SELECT orthographe, grammaire FROM lexique";
// $stmt = $db->prepare($sql);
// $stmt->execute();
// $lexique = $stmt->fetchAll();

// 	$concatValue = "";
// 	// foreach ($textArray as $value) {
// 		// if(!array_key_exists(mb_strtolower($value, 'UTF-8'), $result['wordFound'])){
// 			$value = $textArray;
// 			$sql2 = "SELECT firstname, lastname FROM politicians";
// 			$stmt2 = $db->prepare($sql2);
// 			$stmt2->execute();
// 			$concatValue .= $value . " ";
// 			while ($row = $stmt2->fetch()) {
// 				$name = $row['firstname'] . " " . $row['lastname'];
// 				$nameReverse = $row['lastname'] . " " . $row['firstname'];
// 			    if(strripos($concatValue, $name) && !in_array($name, $result['politicianFound'])){
// 			    	$result['politicianFound'][] = $name;
// 			    }
// 			    elseif(strripos($concatValue, $nameReverse) && !in_array($nameReverse, $result['politicianFound'])){
// 			    	$result['politicianFound'][] = $nameReverse;
// 			    }
// 			}
// 			$sql3 = "SELECT nom, nomComplet FROM parti";
// 			$stmt3 = $db->prepare($sql3);
// 			$stmt3->execute();
// 			while ($row = $stmt3->fetch()) {
// 				$parti = $row['nom'];
// 				$partiComplete = $row['nomComplet'];
// 			    if(strripos($concatValue, $parti) && !in_array($parti, $result['partiFound'])){
// 			    	$result['partiFound'][] = $parti;
// 			    }
// 			    elseif(strripos($concatValue, $partiComplete) && !in_array($partiComplete, $result['partiFound'])){
// 			    	$result['partiFound'][] = $partiComplete;
// 			    }
// 			}
// 	// }
// 	// foreach ($textArray as $word) {
// 	    // $word = mb_strtolower($word, 'UTF-8');

// 		foreach($lexique as $row) {
// 			$dico = mb_strtolower($row['orthographe']);
// 			$grammaire = mb_strtolower($row['grammaire']);
// 			// if($dico == $word ){
// 			if(stripos($value, $dico)){
// 				if(isset($result['wordFound'][$dico])){
// 					if (!in_array($grammaire, $result['wordFound'][$dico])) {
// 						$result['wordFound'][$dico][] = $grammaire;
// 					}
// 				}
// 				else{
// 					$result['wordFound'][$dico] = [$grammaire];
// 				}
// 			}
// 		}
// 	// }
// 	// var_dump($result);
// $time += microtime(true);
// // echo $time;
// $result['time'] = $time;
// header("Content-Type: application/json");
// echo json_encode($result);