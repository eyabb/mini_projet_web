<?php
$classe=$_GET['classe'];
$debut=$_GET['debut'];
if(!isset($classe)||!isset($debut)){
  $outputs["success"] = 0;
  $outputs["message"] = "Pas d'étudiants";

  echo json_encode($outputs);
  echo"do me a favor and work";

}else{
  include("connexion.php");
  $req=$pdo->prepare("select cin,nom,prenom from etudiant where Classe=?");
  $req->execute([$classe]);
  $reponse=$req->fetchAll();
  if(count($reponse)>0){
    $outputs["etudiants"]=array();
	  $outputs["days"]=array();
    $firstDate= date(' Y/m/d', strtotime($debut));
    $dt=strtotime($firstDate);
    $outputs["dates"]=array();
    for($i=0;$i<6;$i++){
      $increment=sprintf("+%u day",$i);
      $d=date("Y-m-d", strtotime($increment,$dt));
      $day=date('l', strtotime($d));
      array_push($outputs["dates"], $d);
      array_push($outputs["days"], $day);
    }
      //while ($row = $reponse->fetch(PDO::FETCH_ASSOC)) {
        foreach($reponse as $row){
       // $etudiant = array();
        //$etudiant["nom"] = $row["nom"];
        //$etudiant["prenom"] = $row["prenom"];
        //array_push($outputs["etudiants"], $etudiant);
        $etudiant["nom"]=$row['nom'];
        $etudiant["cin"]=$row['cin'];
        $etudiant["prenom"]=$row['prenom'];
        array_push($outputs["etudiants"], $etudiant);

      }
    // success
    
    $outputs["success"] = 1;
     echo json_encode($outputs);
  }else{
    $outputs["success"] = 0;
    $outputs["message"] = "Pas d'étudiants";
    // echo no users JSON
    echo json_encode($outputs);
  }
}

  
?>
