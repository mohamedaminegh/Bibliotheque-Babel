<?php
session_start();
if(!isset($_SESSION['babel']))
   header("Location:authentifier.php");
?>
<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>La liste noire</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
  

    <link href="css/clean-blog.min.css" rel="stylesheet">

 <style>
 th {
    background-color: #ecc6c6;
    color: white;
	font-family: American Typewriter, serif;
}
tr:hover {background-color: #f5f5f5;
}
td {font-family: DejaVu Sans Mono, monospace;}
td, th { padding: 15px;
}
table {
    border-spacing: 5px;
}
table#t01 {
    width: 100%; 
    background-color: #f1f1c1;
	
}


 </style>
  
  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="BABEL.php">INSAT BIBLIOTHEQUE</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="BABEL.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropbtn" >Abonnées</a>
                <div class="dropdown-content" ><ul>
                <li> <a href="consulter.php">Consulter</a></li>
                <li><a href="ajouter.php">Ajouter</a></li>
                </ul> </div>
            </li>
            <li class="nav-item dropdown">
              <a id="cat" class="nav-link dropbtn" >Categories</a> 
                <div class="dropdown-content" ><ul>
                <li> <a href="consultercategorie.php">Consulter</a></li>
                <li><a href="ajouterCategorie.php">Ajouter</a></li>
                <li> <a href="modifiercategorie.php">Modifier</a></li>
                <li> <a href="supprimerCategorie.php">Supprimer</a></li>
                </ul> </div>
            </li>
             
            <li class="nav-item dropdown">
              <a class="nav-link dropbtn" >Livres</a>
                <div class="dropdown-content" ><ul>
                <li><a href="ajoutlivre.php">Ajouter</a></li>
                <li> <a href="afficherlivres.php">Afficher</a></li>
                <li> <a href="emettre.php">Emettre</a></li>
                <li> <a href="retour.php">Retour</a></li>
                <li> <a href="livredelivre.php">Délivrées</a></li>
                </ul> </div>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="blacklist.php">Liste Noire</a>
            </li>
			 </li>
              <li class="nav-item">
              <a class="nav-link" href="logout.php">Log out</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <header class="masthead" style="background-image: url('img/blacklist.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <h1>La liste noire</h1>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
	<form method="post" action="#" >
	<input type="text" name="nom" placeholder="Search By Name" value="">
	<input type="submit" value="Rechercher">
	</form>
     <table border =1 align = center id="t01">
<tr>
<th>CIN</th>
<th>Nom</th>
<th>Prenom</th>
<th>Adresse</th>
<th>N° Téléphone</th>
<th>E-mail</th>
<th>Reference Livre</th>
<th>Date D'emprunt</th>
</tr>

<?php
require "ConnexionBD.php";
$bd=ConnexionBD::getInstance();
if (count($_POST)==0)
{
$req="SELECT * FROM prendre_livre p, client c where c.cin=p.cin_client and CURDATE()-date > 7" ;
$res=$bd->query($req);
$blacklisted = $res->fetchAll(PDO::FETCH_OBJ);
foreach ($blacklisted as $listed) 
{echo "<tr>" ;
echo "<td>".$listed->cin."</td>";
echo "<td>".$listed->nom."</td>";
echo "<td>".$listed->prenom."</td>";
echo "<td>".$listed->adresse."</td>";
echo "<td>".$listed->num_tel."</td>";
echo "<td>".$listed->mail."</td>";
echo "<td>".$listed->ref_livre."</td>";
echo "<td>".$listed->date."</td>";

echo "</tr>";
}
}
else
{
$param = "%{$_POST['nom']}%";
$req1="SELECT * FROM prendre_livre p, client c where c.cin=p.cin_client AND CURDATE()-date > 7 AND c.nom LIKE :nom " ;
$res2=$bd->prepare($req1);
$res2->execute(array('nom'=>$param)) ;
$blacklisted = $res2->fetchAll(PDO::FETCH_OBJ);
foreach ($blacklisted as $listed) 
{echo "<tr>" ;
echo "<td>".$listed->cin."</td>";
echo "<td>".$listed->nom."</td>";
echo "<td>".$listed->prenom."</td>";
echo "<td>".$listed->adresse."</td>";
echo "<td>".$listed->num_tel."</td>";
echo "<td>".$listed->mail."</td>";
echo "<td>".$listed->ref_livre."</td>";
echo "<td>".$listed->date."</td>";

echo "</tr>";
}
}
?>
</table>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; Babel 2018</p>
          </div>
        </div>
      </div>
    </footer>

   

  </body>

</html>
