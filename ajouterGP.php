<?php
 session_start();
 if($_SESSION["autoriser"]!="oui"){
	header("location:login.php");
	exit();
 }
else {
$name=$_REQUEST['name'];


include("connexion.php");
         $sel=$pdo->prepare("select * from classe where name=? limit 1");
         $sel->execute(array($name));
         $tab=$sel->fetchAll();
         if(count($tab)>0)
            $erreur="NOT OK";// Groupe existe déja
         else{
            $req="insert into classe (name) values ('$name')";
            $reponse = $pdo->exec($req) or die("error");
            $erreur="OK";
         }  
         echo($erreur);
}
?>