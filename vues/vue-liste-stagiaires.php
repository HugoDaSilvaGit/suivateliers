<?php session_start() ; ?>
<?php 
	if( isset($_GET[ 'atelier' ]) ){
		$atelier = $_GET[ 'atelier' ] ;
	} 
	else {
		$atelier = '' ;	
	} 
?>
<?php

	$stagiaires = array() ;

	try {
		$bd = new PDO(
						'mysql:host=localhost;dbname=sbateliers' ,
						'sanayabio' ,
						'sb2021'
			) ;
		$stagiaires=$bd->query("SELECT C.numero, C.nom, C.prenom, P.dateInscription, A.theme FROM `Atelier` as A, `Client` as C, `Participation` as P WHERE C.numero=P.numeroClient AND A.numero=P.numeroAtelier AND A.numero=".$atelier."");
		$stagiaires = $stagiaires -> fetchall() ;
        
		unset( $bd ) ;	
	}
	catch( PDOException $e ){
		
		session_unset() ;
		session_destroy() ;
		header( 'Location: ../vues/vue-connexion.php?echec=0' ) ;
	}


?>
<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8">
		<title>Suivis Ateliers - Listes Stagiaires</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	</head>

	<body>
		
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="vue-liste-ateliers.php">Suivis Ateliers</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="nav navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
							<a class="nav-link" href="vue-liste-ateliers.php">Liste des ateliers</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="vue-liste-ateliersResponsables.php">Mes ateliers</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="vue-liste-responsables.php">Les responsables</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item">
							<a class="nav-link" href="#"><?php echo $_SESSION[ 'prenom' ] . ' ' . $_SESSION[ 'nom' ]  ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../controleurs/ctrl-deconnecter.php">se déconnecter...</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="container-fluid">
		
			<h4 class="alert alert-primary" role="alert">
				Stagiaires
			</h4>
			
			<table class="table table-striped">
				<thead>
					<tr>
                        <td>Nom du stagiaire</td>
                        <td>Numero du stagiaire</td>
						<td>Date d'inscription</td>
						<td>Thème</td>
					</tr>
				</thead>
				<tbody>
					
					<?php foreach( $stagiaires as $unStagiaires ){ ?>
						<tr>
							<td><?php echo $unStagiaires[ 'prenom' ]." ".$unStagiaires[ 'nom'] ; ?></td>
                            <td><?php echo $unStagiaires[ 'numero' ] ; ?></td>
							<td><?php echo $unStagiaires[ 'dateInscription' ] ; ?></td>
                            <td><?php echo $unStagiaires[ 'theme' ] ; ?></td>
						</tr>
					<?php } ?>
					
				</tbody>
				
			</table>
		
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	</body>

</html>
