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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Walid SAAD">
    <meta name="generator" content="Hugo 0.88.1">
    <title>SCO-ENICAR</title>
    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JS-JQUERY -->
<script src="./assets/dist/js/jquery.min.js"></script>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./assets/jumbotron.css" rel="stylesheet">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

  </head>
  <body onload="refresh()">
    
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
  
    <form  id="myform" onsubmit="chercher(this.name.value)" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" name="name" placeholder="Saisir un groupe" aria-label="Chercher un groupe">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Chercher Groupe</button>
          </form>
  </div>
</nav>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3"><?php echo $bienvenue?></h1>
      <p>Cliquez sur le bouton ci dessous pour consulter la liste des groupe</p>
      <p><button class="btn btn-primary btn-lg"  onclick="refresh()" >Mes Groupes &raquo;</button></p>
    </div>
  </div>

  <div class="container">
    <!-- Example row of columns -->
    <div id="demo" class="row"></div>
    </div>

    <hr>

  </div> <!-- /container -->

</main>



<footer class="container">
  <p>&copy; ENICAR 2021-2022</p>
</footer>
<!--<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div> -->
<script>

document.getElementById("myform").addEventListener("submit", function(event){
    event.preventDefault();
});

    function refresh() {
        var xmlhttp = new XMLHttpRequest();
        var url = "http://localhost:81/info2/afficherGroupes.php";

    //Envoie de la requete
	xmlhttp.open("GET",url,true);
	xmlhttp.send();


     //Traiter la reponse
     xmlhttp.onreadystatechange=function()
            {  // alert(this.readyState+" "+this.status);
                if(this.readyState==4 && this.status==200){
                
                    myFunction(this.responseText);
                    console.log(this.responseText);
                    //console.log(this.responseText);
                }
            }


    //Parse la reponse JSON
	function myFunction(response){
		var obj=JSON.parse(response);
        //alert(obj.success);

        if (obj.success==1)
        {
         
		var arr=obj.groupes;
		var i;
    var out="<div class='row'>";
		for ( i = 0; i < arr.length; i++) {
			out+="<div class='col-sm-4'><div class='card border-primary mb-3'><div class='card-body'><h5 class='card-title'>"+
			arr[i].name +"</h5>"
      +"<p class='card-text'> Voici un groupe que vous enseignez.Pour faire une modification/suppression à ce groupe  veuillez cliquez sur le bouton modifier/supprimer..</p>"+
      "<p><a href='http://localhost:81/info2/modifierGroupe.php?id="+arr[i].id+'&'+ "name="+arr[i].name+"' class='btn btn-primary'>modifier</a><span>  </span>"+
     // "<td><button class='btn btn-danger' onclick='supprimer("+arr[i].cin+")'>supprimer</button></td></tr>";
      "<a href='http://localhost:81/info2/supprimerGroupe.php?id="+arr[i].id+"' class='btn btn-danger'>supprimer</a></p></span></div></div></div>";
		}
    out+="</div>";
  
		document.getElementById("demo").innerHTML=out;
       }
       else document.getElementById("demo").innerHTML="Aucune groupe!";

    }
}

function chercher(name) {
        var xmlhttp = new XMLHttpRequest();
        var url = "http://localhost:81/info2/chercherGroupe.php?name="+name;

    //Envoie de la requete
	xmlhttp.open("GET",url,true);
	xmlhttp.send();


     //Traiter la reponse
     xmlhttp.onreadystatechange=function()
            {   //alert(this.responseText);
                if(this.readyState==4 && this.status==200){
                
                    myFunction(this.responseText);
                    console.log(this.responseText);
                    //console.log(this.responseText);
                }
            }


    //Parse la reponse JSON
		function myFunction(response){
		var obj=JSON.parse(response);
        //alert(obj.success);

        if (obj.success==1)
        {
         
		var arr=obj.groupes;
		var i;
    var out="<div class='row'>";
		for ( i = 0; i < arr.length; i++) {
			out+="<div class='col-sm-4'><div class='card border-primary mb-3'><div class='card-body'><h5 class='card-title'>"+
			arr[i].name +"</h5>"
      +"<p class='card-text'>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>"+
      "<p><a href='http://localhost:81/info2/modifierGroupe.php?id="+arr[i].id+'&'+ "name="+arr[i].name+"' class='btn btn-primary'>modifier</a><span>  </span>"+
     // "<td><button class='btn btn-danger' onclick='supprimer("+arr[i].cin+")'>supprimer</button></td></tr>";
      "<a href='http://localhost:81/info2/supprimerGroupe.php?id="+arr[i].id+"' class='btn btn-danger'>supprimer</a></p></span></div></div></div>";
		}
    out+="</div>";
  
		document.getElementById("demo").innerHTML=out;
       }
       else document.getElementById("demo").innerHTML="Aucune groupe!";

    }
}

const supprimer=(cin)=>{
      console.log(cin)
        if(confirm('Are you sure you want to delete it?')) {
          $.ajax({    
        type: "GET",
        url: "supprimer.php", 
        data:{deleteCin:cin},            
        dataType: "html",                  
        success: function(data){   
        $('#msg').html(data);
       $('#table-container').load(refresh());
           
        }
    });
          
    }
  }
  
</script>  
   
      
  </body>
</html>
