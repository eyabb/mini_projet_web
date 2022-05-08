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
    <title>SCO-ENICAR Etat Absence</title>
    <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JS-JQUERY -->
<script src="./assets/dist/js/jquery.min.js"></script>
<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./assets/jumbotron.css" rel="stylesheet">

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
        
      
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Saisir un groupe" aria-label="Chercher un groupe">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Chercher Groupe</button>
          </form>
        </div>
      </nav>
      
<main role="main">
        <div class="jumbotron">
            <div class="container">
              <h1 class="display-4">État des absences pour un groupe</h1>
              <p>Pour afficher l'état des absences, choisissez d'abord le groupe  et la periode concernée!</p>
            </div>
          </div>

<div class="container">
<form>
  <table><tr><td>Date de début (j/m/a) : </td><td>
    <input id="debut" type="date" name="debut" size="10" value="01/09/2021" class="datepicker"/>
    </td></tr><tr><td>Date de fin : </td><td>
    <input id="fin" type="date" name="fin" size="10" value="12/03/2022" class="datepicker"/>
    </td></tr></table>

<div class="form-group">
<label for="classe">Choisir une classe:</label><br>
<!--
<input list="classe">
<datalist id="classe" name="classe">
    <option value="1-INFOA">1-INFOA</option>
    <option value="1-INFOB">1-INFOB</option>
    <option value="1-INFOC">1-INFOC</option>
    <option value="1-INFOD">1-INFOD</option>
    <option value="1-INFOE">1-INFOE</option>
</datalist>
-->
<select id="classe" name="classe"  class="custom-select custom-select-sm custom-select-lg">
<option value="" selected>All</option>
<?php 
       include("connexion.php");
       $req="SELECT * FROM classe ";
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

<div class="table-responsive"> 
  <table class="table table-striped table-hover">
  <thead>
  <tr class="gt_firstrow " >
      <th >Nom</th>
      <th>Justifiées</th>
      <th >Non justifiées</th
      ><th >Total</th>
    </tr>
  </thead>
  <tbody id="demo"></tbody>
  <!--<tr><td><b>M. SAAD WALID</b></td><td >0</td><td >0</td><td >0</td></tr>
  <tr ><td><b>M. SAAD WALID</b></td><td >0</td><td >0</td><td >0</td></tr> -->
  <tfoot>
  </tfoot>
  </table>
  </div>

</form>
</div>  
</main>

<footer class="container">
    <p>&copy; ENICAR 2021-2022</p>
  </footer>
  <script>

document.getElementById("debut").addEventListener("change", refresh)
document.getElementById("fin").addEventListener("change", refresh)
document.getElementById("classe").addEventListener("change", refresh)

    function refresh() {
        var debut=  document.getElementById("debut").value;
        var fin=  document.getElementById("fin").value;
        var classe=  document.getElementById("classe").value;
        var xmlhttp = new XMLHttpRequest();
        console.log("aaaaa",debut)
        console.log("aaaaa",fin)
        console.log("aaaaa",classe)
        var url = "http://localhost:81/info2/absencesList.php?debut="+debut+'&'+ "fin="+fin+'&'+"classe="+classe;

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
		var arr=obj.etudiants;
		var i;
    var out="";
		for ( i = 0; i < arr.length; i++) {
			out+="<tr><td>"+
			arr[i].nom+" "+arr[i].prenom +
			"</td><td>"+
			arr[i].nbrJustifie+
			"</td><td>"+
			arr[i].nbrNonJustifie+
			"</td><td>"+
            arr[i].total+
            "</td><tr>"
    
		}

  
		document.getElementById("demo").innerHTML=out;
       }
       else document.getElementById("demo").innerHTML="Aucun Etudiant!";

    }
}

function chercher(cin) {
  console.log(cin)
        var xmlhttp = new XMLHttpRequest();
        var url = "http://localhost:81/info2/chercher.php?cin="+cin;

    //Envoie de la requete
	xmlhttp.open("GET",url,true);
	xmlhttp.send();


     //Traiter la reponse
     xmlhttp.onreadystatechange=function()
            {  //alert(this.responseText);
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
		var arr=obj.etudiants;
		var i;
    var out="";
    for ( i = 0; i < arr.length; i++) {
			out+="<tr><td>"+
			arr[i].cin +
			"</td><td>"+
			arr[i].nom+
			"</td><td>"+
			arr[i].prenom+
			"</td><td>"+
			arr[i].email+
			"</td><td>"+
			arr[i].adresse+
            "</td><td>"+
            arr[i].classe+
      "</td><td><a href='http://localhost:81/info2/modifierEtudiant.php?cin="+arr[i].cin+'&'+ "nom="+arr[i].nom+'&'+"prenom="+arr[i].prenom+'&'+ "adresse="+arr[i].adresse+'&'+"email="+arr[i].email+'&'+"classe="+arr[i].classe_id+"' class='btn btn-primary'>modifier</a></td>"+
     // "<td><button class='btn btn-danger' onclick='supprimer("+arr[i].cin+")'>supprimer</button></td></tr>";
      "<td><a href='http://localhost:81/info2/supprimer.php?cin="+arr[i].cin+"' class='btn btn-danger'>supprimer</button></td></tr>";
		}

  
		document.getElementById("demo").innerHTML=out;
       }
       else document.getElementById("demo").innerHTML="Aucun Etudiant!";

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