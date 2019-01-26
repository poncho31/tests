<?php
 $numcmd = isset($_POST['numcmd'])?true:false;
 $idcmd = isset($_POST['idcmd'])?true:false;
 $comment = isset($_POST['comment'])?true:false;
 $db = new PDO('mysql:host=localhost;dbname=test', "root", "");

 if ($numcmd) {
 	 $stmt = $db->prepare("SELECT * FROM popup_num");
 	 $stmt->execute();
 	 $result = array();
 	 while ($row = $stmt->fetch()) {
 	 	$stmt2 = $db->prepare("SELECT * FROM popup_commentaire WHERE fk_numcmd = ".$row['id']);
		$stmt2->execute();
		$comment = array();
		while ($row2 = $stmt2->fetch()) {
			$comment [] = $row2["commentaire"];
		}
	 	$result []=
	 		[
	 			"id"=> $row['id'],
	 			"numcmd"=> $row['numcmd'],
	 			"commentaire" => $comment
	 		];
 	 }
 	 echo json_encode($result);
 }
 elseif($idcmd && $comment){
 	$idcmd = $_POST['idcmd'];
 	$comment = $_POST['comment'];
 	$date = date("Y-m-d"); 
 	$user = "user";
 	$stmt = $db->prepare("INSERT INTO popup_commentaire (fk_numcmd, user, commentaire, date) VALUES (:fk_numcmd, :user, :commentaire, :date)");
 	$stmt->bindParam(":fk_numcmd", $idcmd);
 	$stmt->bindParam(":user", $user);
 	$stmt->bindParam(":commentaire", $comment);
 	$stmt->bindParam(":date", $date);
 	$stmt->execute();
 	if ($stmt) {
 		echo json_encode(["success"]);
 	}
 	else{
 		echo json_encode(["error"]);
 	}
 }

// echo "hello";
?>