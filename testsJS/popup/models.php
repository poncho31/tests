<?php
 $numcmd = isset($_POST['numcmd'])?true:false;
 $db = new PDO('mysql:host=localhost;dbname=test', "root", "");

 if ($numcmd) {
 	 $stmt = $db->prepare("SELECT * FROM popup_num");
 	 $stmt->execute();
 	 $result = array();
 	 while ($row = $stmt->fetch()) {
	 	 $result []=
	 	 	[
	 	 		"id"=> $row['id'],
	 	 		"numcmd"=> $row['numcmd']
	 	 	];
 	 }
 	 echo json_encode($result);
 }

?>