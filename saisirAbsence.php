<?php
   session_start();
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }
   if(date("H")<18)
      $bienvenue="Bonjour et bienvenue ".
      $_SESSION["prenomNom"].
      " dans votre espace personnel";
   else
      $bienvenue="Bonsoir et bienvenue ".
      $_SESSION["prenomNom"].
      " dans votre espace personnel";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCO-ENICAR Saisir Absence</title>
    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JS-JQUERY -->
<script src="./assets/dist/js/jquery.min.js"></script>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./assets/dist/css/jumbotron.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#">SCO-Enicar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="index.html" id="dropdown01" data-toggle="dropdown" aria-expanded="false">Gestion des Groupes</a>        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="afficherEtudiantsParClasse.php">Etudiants par Groupe</a>
          <a class="dropdown-item" href="ajouterGroupe.php">Ajouter Groupe</a>

        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-expanded="false">Gestion des Etudiants</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
        <a class="dropdown-item" href="afficherEtudiants.php">Lister tous les étudiants</a>
          <a class="dropdown-item" href="ajouterEtudiant.php">Ajouter Etudiant</a>
          


        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-expanded="false">Gestion des Absences</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="saisirAbsence.php">Saisir Absence</a>
          <a class="dropdown-item" href="etatAbsence.php">État des absences pour un groupe</a>
        </div>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="deconnexion.php">Se Déconnecter <span class="sr-only">(current)</span></a>
      </li>

    </ul>
        
      
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Saisir un groupe" aria-label="Chercher un groupe">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Chercher Groupe</button>
          </form>
        </div>
      </nav>
      
<main role="main">
        <div class="jumbotron">
            <div class="container">
              <h1 class="display-4">Signaler l'absence pour tout un groupe</h1>
              <p>Pour signaler, annuler ou justifier une absence, choisissez d'abord le groupe, le module puis l'étudiant concerné!</p>
            </div>
          </div>

<div class="container">
  <form id="Postform" method="POST" action="ajouterAbsence.php">
    <div class="form-group">
      <label for="semaine">Choisir une semaine:</label><br>
      <input id="semaine" type="week" name="debut" size="10" class="datepicker"/>
    </div>
  <div class="form-group">
    <label for="classe">Choisir un groupe:</label><br>

    <select id="classe" name="classe"  onchange="chercher(this.value);"  class="custom-select custom-select-sm custom-select-lg">
<!--<option value="" selected>All</option>-->
      <?php 
       include("connexion.php");
       $req="SELECT * FROM classe";
       $reponse = $pdo->query($req);
       if($reponse->rowCount()>0) {
       while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
             ?> 
             <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php
               
      }
    }
 ?>
</select>
  </div>

  <div class="form-group">
    <label for="matiere">Choisir un module:</label><br>
    <select id="matiere" name="matiere"  class="custom-select custom-select-sm custom-select-lg">
        <option value="TECHWEB">Tech. Web</option>
        <option value="SGBD">SGBD</option>
    </select>
  </div>
  <div id="tab"></div>
 <!--Bouton Valider-->
  <button type="submit" onclick="ajouter()" class="btn btn-primary btn-block">Valider</button>
  </form>
</div>
<div id="result"></div>  
<script>
  document.getElementById('matiere').addEventListener('change',affichertableau);
  document.getElementById('semaine').addEventListener('change',affichertableau);
  document.getElementById('classe').addEventListener('change',affichertableau);
  function affichertableau(){
      var debut =document.getElementById('semaine').value;
      var classe =document.getElementById('classe').value;
      console.log(debut);
      console.log(classe);
      var  xhr=new XMLHttpRequest();
      xhr.open('GET','http://localhost:81/info2/afficherAbsence.php?debut='+debut+'&classe='+classe,true);
      xhr.send();
      xhr.onreadystatechange=function(){  
      if(this.readyState==4 && this.status==200){
        myFunction(this.responseText);
       }
      }
    
    function myFunction(response){
		    var obj=JSON.parse(response);       
        //alert(obj.success);
          if (obj.success==1){
		    var arr=obj.etudiants;
            let arrName=[];
            let l=arr.length*12;
          for(let i=0;i<l;i++){
            checkBoxName=`${i}`;
            arrName.push(checkBoxName);
          }
            var arr2=obj.dates;
            var arr3=obj.days;
            let out=[];
            out.push('<table rules="cols" frame="box"><tr><th>'+arr.length.toString()+'&nbsp'+'étudiants'+'</th>');
            for(let i=0;i<6;i++){
              out.push('<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">'+arr3[i]+'</th>');
            }
            out.push('</tr><tr><td>&nbsp;</td>');
            for(let i=0;i<6;i++){
              out.push('<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">'+arr2[i]+'</th>');
            }
            out.push('</tr><tr><td>&nbsp</td>');
            for(let i=0;i<6;i++){
              out.push('<th>AM</th><th>PM</th>')
            }
            out.push('</tr>');
            let lastPositionInRow=12;
            let firstPositionInRow=0;
            for (let i = 0; i < arr.length; i++) {
              out.push('<tr class="row_3"><td><b>'+arr[i].nom+'&nbsp'+arr[i].prenom+'</b></td>');
              for(let j=firstPositionInRow;j<lastPositionInRow;j++){
                out.push('<td><input type="checkbox" name='+arrName[j].toString()+arr[i].cin+'  value='+arr[i].cin+'  </td>');
                console.log(arrName[j].toString()+arr[i].cin);
              }
              out.push('</tr>');
              lastPositionInRow+=12;
              firstPositionInRow+=12;
            }  
		        out.push('</table><br>');

		        document.getElementById("tab").innerHTML=out.join("");
       }
       else{
          document.getElementById("tab").innerHTML="Pas d'étudiants!";
       }
    }
  }
  function chercher(a){
      
  }
  /*function ajouter()
    {
        var xmlhttp = new XMLHttpRequest();
        var url="http://localhost:81/new/ajouterAbsence.php";
        
        //Envoie Req
        xmlhttp.open("POST",url,true);

        form=document.getElementById("Postform");
        formdata=new FormData(form);

        xmlhttp.send(formdata);

        //Traiter Res

        xmlhttp.onreadystatechange=function()
            {   
                if(this.readyState==4 && this.status==200){
                // alert(this.responseText);
                    if(this.responseText=="OK")
                    {
                        document.getElementById("result").innerHTML="L'ajout des absences est effectué avec succès";
                        document.getElementById("result").style.backgroundColor="green";
                        console.log("test");
                    }
                    else
                    {
                        document.getElementById("result").innerHTML="L'étudiant est déjà inscrit, merci de vérifier le CIN";
                        document.getElementById("result").style.backgroundColor="#fba";
                    }
                }
            }
        
        
    }*/
  

</script>
<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>
</main>
</body>
</html>