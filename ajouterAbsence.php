<?php 
session_start();
if($_SESSION["autoriser"]!="oui"){
   header("location:login.php");
   exit();
}
else {
$classe=$_REQUEST['classe'];
$matiere=$_REQUEST['matiere'];
$semaine=$_REQUEST['debut'];
include("connexion.php");
$sel=$pdo->prepare("select cin from etudiant where Classe=?");
$sel->execute(array($classe));
$tab=$sel->fetchAll();
$nbrEtudiants=count($tab);
echo $nbrEtudiants;
$nbrCheckboxes=$nbrEtudiants*12;
$countDays=0;
$countEtudiant=0;
$nbrAbsence=0;
$tabEtudiant=[];
foreach($tab as $row){

    array_push($tabEtudiant, $row['cin']);
}
for($i=0;$i<$nbrEtudiants;$i++){
    echo $tabEtudiant[$i];
    echo "\n";
}
$firstDate= date(' Y/m/d', strtotime($semaine));
$dt=strtotime($firstDate);
$tabDates=array();
$nbreAbsJus=0;
for($i=0;$i<6;$i++){
  $increment=sprintf("+%u day",$i);
  $d=date("Y-m-d", strtotime($increment,$dt));
  echo $d;
  echo "\n";
  array_push($tabDates, $d);
}
$counter=0;
for($i=0;$i<$nbrCheckboxes;$i++){
    $pas=sprintf("%u",$i);
    $dd=$pas.$tabEtudiant[$countEtudiant];
    $check = isset($_POST[$pas.$tabEtudiant[$countEtudiant]]) ? "checked" : "unchecked";
echo $check;
    if(isset($_POST[$pas.$tabEtudiant[$countEtudiant]])){
        $nbrAbsence=1;
        $nbreAbsNonJus=$nbrAbsence;
        $req="insert into `absences` (`id`, `nomMatiere`, `cin_Etudiant`, `justification`, `dateAbsence`) VALUES (NULL,'$matiere','$tabEtudiant[$countEtudiant]','0','$tabDates[$countDays]')";
        $reponse = $pdo->exec($req) or die("error");
        
    }
    $counter+=1;
    
    if($counter==2){
        $counter=0;
        $countDays+=1;
        $nbrAbsence=0;
    }
    if($countDays==6){
        $countDays=0;
        $countEtudiant+=1;
    }
}

header("location:saisirAbsence.php");
exit();
}
         /*$sel=$pdo->prepare("select cin from etudiant where cin=? limit 1");
         $sel->execute(array($cin));
         $tab=$sel->fetchAll();
         if(count($tab)>0)
            $erreur="NOT OK";// Etudiant existe déja
         else{
            $req="insert into etudiant values ($cin,'$email',md5('$pwd'),md5('$cpwd'),'$nom','$prenom','$adresse','$classe')";
            $reponse = $pdo->exec($req) or die("error");
            $erreur ="OK";
         }  
         echo $erreur;*/

?>