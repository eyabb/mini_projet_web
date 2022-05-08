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
    <title>SCO-ENICAR Ajouter Etudiant</title>
    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JS-JQUERY -->
<script src="./assets/dist/js/jquery.min.js"></script>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./assets/jumbotron.css" rel="stylesheet">

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
        
      
         
        </div>
      </nav>
      
<main role="main">
        <div class="jumbotron">
            <div class="container">
              <h1 class="display-4">Ajouter un groupe</h1>
              <p>Remplir le formulaire ci-dessous afin d'ajouter un groupe!</p>
            </div>
          </div>


<div class="container">
 <form id="myform" onsubmit="ajouter(this.name.value)" >
    
     <!--Classe-->
     <div class="form-group">
     <label for="name">nom Classe:</label><br>
     <input type="text" id="name" name="name" class="form-control" required pattern="INFO[1-3]{1}-[A-E]{1}"
     title="Pattern INFOX-X. Par Exemple: INFO1-A, INFO2-E, INFO3-C">
    </div>

     <!--Bouton Ajouter-->
     <button  type="submit" class="btn btn-primary btn-block" >Ajouter</button>
     <div id="demo"></div>

 </form> 
</div>  
</main>


<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>
  
<script>
    document.getElementById("myform").addEventListener("submit", function(event){
    event.preventDefault();
});
      function ajouter(name)
      {
          console.log(name)
        var xmlhttp = new XMLHttpRequest();
        var url = "http://localhost:81/info2/ajouterGP.php?name="+name;
          
          //Envoie Req
          xmlhttp.open("POST",url,true);
          xmlhttp.send();
  
          //Traiter Res
  
          xmlhttp.onreadystatechange=function()
              {   
                  if(this.readyState==4 && this.status==200){
                   
                      if(this.responseText=="OK")
                      {
                          document.getElementById("demo").innerHTML="L'ajout de groupe a été bien effectué";
                          document.getElementById("demo").style.backgroundColor="green";
                          window.location.href = 'http://localhost:81/info2/index.php';
                      }
                      else
                      {
                          document.getElementById("demo").innerHTML="Le groupe est déjà existé, merci de taper un autre";
                          document.getElementById("demo").style.backgroundColor="#fba";
                      }
                  }
              }
          
          
      }
</script>
<script  src="./assets/dist/js/inscrire.js"></script>
</body>
</html>