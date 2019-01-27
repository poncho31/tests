<?php
 $numcmd = isset($_POST['numcmd'])?true:false;
 $idcmd = isset($_POST['idcmd'])?true:false;
 $comment = isset($_POST['comment'])?true:false;
 $db = new PDO('mysql:host=localhost;dbname=test', "root", "");
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 if ($numcmd) {
 	 $stmt = $db->prepare("SELECT * FROM popup_num");
 	 $stmt->execute();
 	 $result = array();
 	 while ($row = $stmt->fetch()) {
 	 	$stmt2 = $db->prepare("SELECT * FROM popup_commentaire WHERE fk_numcmd = ".$row['id']." ORDER BY id DESC");
		$stmt2->execute();
		$comment = array();
		while ($row2 = $stmt2->fetch()) {
			$comment [] = ["date"=>$row2["date"], "user"=>$row2["user"], "comment" => htmlentities($row2["commentaire"], ENT_QUOTES)];
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
 	$sql = "INSERT INTO popup_commentaire (fk_numcmd, user, commentaire, date) VALUES (?, ?, ?, ?)";
 	$stmt = $db->prepare($sql);
 	$stmt->execute([$idcmd, $user, $comment, $date]);
 	if ($stmt) {
 		echo json_encode([$idcmd]);
 	}
 	else{
 		echo json_encode(["error"]);
 	}
 }
?>