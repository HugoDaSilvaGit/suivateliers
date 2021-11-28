<?php

	session_start() ;
	
	$nomConnexion = $_SESSION[ 'nomConnexion' ] ;
	
	session_unset() ;
	session_destroy() ;
	
	header( 'Location: ../vues/vue-connexion.php?nomConnexion=' . $nomConnexion ) ;
?>