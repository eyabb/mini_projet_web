<?php
 session_start();
 if($_SESSION["autoriser"]!="oui"){
	header("location:login.php");
	exit();
 }
else {
$cin=$_GET['cin'];
$nom=$_GET['nom'];
$prenom=$_GET['prenom'];
$email=$_GET['email'];
$adresse=$_GET['adresse'];
$pwd=md5($_GET['pwd']);
$cpwd=md5($_GET['cpwd']);
$classe=$_GET['classe'];

include("connexion.php");
         $sel=$pdo->prepare("select cin from etudiant where cin=? limit 1");
         $sel->execute(array($cin));
         $tab=$sel->fetchAll();
         if(count($tab)>0){ 
            echo($nom);
            $req="update etudiant set nom='$nom',prenom='$prenom',email='$email',adresse='$adresse',password='$pwd',cpassword='$cpwd',Classe='$classe' where cin='$cin' ";
            $reponse = $pdo->exec($req) or die("aaaa");
            header("location:afficherEtudiants.php");
	         exit();}
           
         else{
            echo("Not OK");
         }  
         
}
?>