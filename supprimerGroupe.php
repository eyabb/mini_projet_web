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
$id=$_GET['id'];
include("connexion.php");
    $sel=$pdo->prepare("delete from classe where id=?");
    $sel->execute(array($id));
    $sel->fetchAll();;
    header("location:index.php");
	  exit();
}

?>