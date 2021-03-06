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
        <a class="dropdown-item" href="afficherEtudiants.php">Lister tous les ??tudiants</a>
          <a class="dropdown-item" href="ajouterEtudiant.php">Ajouter Etudiant</a>
          


        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-expanded="false">Gestion des Absences</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="saisirAbsence.php">Saisir Absence</a>
          <a class="dropdown-item" href="etatAbsence.php">??tat des absences pour un groupe</a>
        </div>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="deconnexion.php">Se D??connecter <span class="sr-only">(current)</span></a>
      </li>

    </ul>
        </div>
      </nav>
      
<main role="main">
        <div class="jumbotron">
            <div class="container">
              <h1 class="display-4">Modifier un ??tudiant</h1>
              <p>Remplir le formulaire ci-dessous afin de modifier un ??tudiant!</p>
            </div>
          </div>


<div class="container">
 <form id="myform" method="GET" action="modifier.php">
     <!--
                        TODO: Add form inputs
                        Prenom - required string with autofocus
                        Nom - required string
                        Email - required email address
                        CIN - 8 chiffres
                        Password - required password string, au moins 8 letters et chiffres
                        ConfirmPassword
                        Classe - Commence par la chaine INFO, un chiffre de 1 a 3, un - et une lettre MAJ de A ?? E
                        Adresse - required string
                    -->
      <!--CIN-->
      <div class="form-group">
     <label for="cin">CIN:</label><br>
     <input type="text" id="cin" name="cin"  class="form-control" value="<?php echo $_GET['cin']; ?>" required pattern="[0-9]{8}" title="8 chiffres" readonly="readonly"/>
    </div>               
     <!--Nom-->
     <div class="form-group">
     <label for="nom">Nom:</label><br>
     <input type="text" id="nom" name="nom" class="form-control" value="<?php echo $_GET['nom']; ?>" required autofocus>
    </div>
     <!--Pr??nom-->
     <div class="form-group">
     <label for="prenom">Pr??nom:</label><br>
     <input type="text" id="prenom" name="prenom" value="<?php echo $_GET['prenom']; ?>"  class="form-control" required>
    </div>
     <!--Email-->
     <div class="form-group">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $_GET['email']; ?>" class="form-control" required>
       </div>
     <!--Password-->
     <div class="form-group">
     <label for="pwd">Mot de passe:</label><br>
     <input type="password" id="pwd" name="pwd" class="form-control"  required pattern="[a-zA-Z0-9]{8,}" title="Au moins 8 lettres et nombres"/>
    </div>
    <!--ConfirmPassword-->
    <div class="form-group">
        <label for="cpwd">Confirmer Mot de passe:</label><br>
        <input type="password" id="cpwd" name="cpwd" class="form-control"  required/>
    </div>
     <!--Classe-->
     <div class="form-group">
    <label for="classe">Classe</label>
    <select class="form-control" id="classe" name="classe">
    <?php 
       include("connexion.php");
       $req="SELECT * FROM classe";
       $reponse = $pdo->query($req);
       if($reponse->rowCount()>0) {
       while ($row = $reponse ->fetch(PDO::FETCH_ASSOC)) {
             ?> 
             <option value="<?php echo $row['id']; ?>" <?php if($row['id']===$_GET['classe'])echo "selected"?>><?php echo $row['name']; ?></option><?php
               
      }
    }
    ?>
    
    </select>
  </div>
     <!--Adresse-->
     <div class="form-group">
     <label for="adresse">Adresse:</label><br>
     <textarea id="adresse" name="adresse" rows="10" cols="30" class="form-control"  required>
     <?php echo $_GET['adresse']; ?>
     </textarea>
    </div>
     <!--Bouton Ajouter-->
     <button  type="submit" class="btn btn-primary btn-block" onclick="modifier()">Modifier</button>
     <div id="demo"></div>

 </form> 
</div>  
</main>


<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>
  
<script>
    
    function modifier()
      {
       var xmlhttp = new XMLHttpRequest();
       var url = "http://localhost/info2/modifier.php";
          //Envoie Req
         xmlhttp.open("POST",url,true)
  
          form=document.getElementById("myForm");
          formdata=new FormData(form);
          window.alert(formdata);
          
          console.log("formdata",formdata)
          xmlhttp.send(formdata);
          
  
          //Traiter Res
  
          xmlhttp.onreadystatechange=function()
              {   
                  if(this.readyState==4 && this.status==200){
                  // alert(this.responseText);
                      if(this.responseText=="OK")
                      {
                          document.getElementById("demo").innerHTML="L'ajout de l'??tudiant a ??t?? bien effectu??";
                          document.getElementById("demo").style.backgroundColor="green";
                      }
                      else
                      {
                          document.getElementById("demo").innerHTML="L'??tudiant est d??j?? inscrit, merci de v??rifier le CIN";
                          document.getElementById("demo").style.backgroundColor="#fba";
                      }
                  }
              }
          
          
      }
      
</script>
<script  src="./assets/dist/js/inscrire.js"></script>
</body>
</html>

