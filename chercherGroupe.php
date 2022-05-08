<?php
 session_start();
 if($_SESSION["autoriser"]!="oui"){
	header("location:login.php");
	exit();
 }
else {
$name=$_REQUEST['name'];   
include("connexion.php");
$reponse= $pdo->prepare("select * from classe where name=? ");
$reponse->execute(array($name));
if($reponse->rowCount()>0) {
	$outputs["groupes"]=array();
while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
        $groupe = array();
        $groupe["id"] = $row["id"];
        $groupe["name"] = $row["name"];
         array_push($outputs["groupes"], $groupe);
    }
    // success
    $outputs["success"] = 1;
     echo json_encode($outputs);
} else {
    $outputs["success"] = 0;
    $outputs["message"] = "Pas de groupes";
    // echo no users JSON
    echo json_encode($outputs);
}
}
?>