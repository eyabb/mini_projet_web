<?php
 session_start();
 if($_SESSION["autoriser"]!="oui"){
	header("location:login.php");
	exit();
 }
else {
$time1 = strtotime($_REQUEST['debut']);
$time2 = strtotime($_REQUEST['fin']);
$classe=$_REQUEST['classe'];    
$debut= date('Y-m-d', $time1);
$fin= date('Y-m-d', $time2);
include("connexion.php");
$req="SELECT * FROM etudiant WHERE Classe=$classe";
$reponse = $pdo->query($req);
if($reponse->rowCount()>0) {
	$outputs["etudiants"]=array();
while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
        $etudiant = array();
        $etudiant["cin"] = $row["cin"];
        $etudiant["nom"] = $row["nom"];
        $etudiant["prenom"] = $row["prenom"];
        $id=$row["cin"];
        $req2="SELECT * FROM absences WHERE cin_Etudiant=$id and dateAbsence BETWEEN '$debut' AND '$fin' ";
        $reponse2 = $pdo->query($req2); 
         $nbrJustifie=0;
         $nbrNonJustifie=0;    
        while ($donnees = $reponse2 ->fetch())
         {
            if($donnees["justification"]=='0') {
                $nbrNonJustifie+=1;
            }  else{
                $nbrJustifie+=1;
            }   
         }
         $etudiant["nbrJustifie"] =  $nbrJustifie;
            $etudiant["nbrNonJustifie"] =  $nbrNonJustifie;
            $etudiant["total"] =  $nbrNonJustifie+$nbrJustifie;
         array_push($outputs["etudiants"], $etudiant);
    }
    // success
    $outputs["success"] = 1;
     echo json_encode($outputs);
} else {
    $outputs["success"] = 0;
    $outputs["message"] = "Pas d'étudiants";
    // echo no users JSON
    echo json_encode($outputs);
}
}
?>