<?php
 /*session_start();
 if($_SESSION["autoriser"]!="oui"){
	header("location:login.php");
	exit();
 }
else {

include("connexion.php");
        if(isset($_GET['deleteCin'])){
    $cin= $_GET['deleteId'];
    $sel=$pdo->prepare("delete from etudiant where cin=?");
    $sel->execute(array($cin));
    $sel->fetchAll();;
}
        
}


*/
  
 session_start();
 if($_SESSION["autoriser"]!="oui"){
	header("location:login.php");
	exit();
 }
else {
$cin=$_GET['cin'];
include("connexion.php");
    $sel=$pdo->prepare("delete from etudiant where cin=?");
    $sel->execute(array($cin));
    $sel->fetchAll();;
    header("location:afficherEtudiants.php");
	  exit();
}

?>