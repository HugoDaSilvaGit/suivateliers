<?php
	
	$nomConnexion = $_GET[ 'nomConnexion' ] ;
	$mdp = $_GET[ 'mdp' ] ;
	
	try {

		$bd = new PDO(
						'mysql:host=localhost;dbname=sbateliers' ,
						'sanayabio' ,
						'sb2021'
			) ;
			
		$sql = 'select numero , nom , prenom '
			 . 'from ResponsableAteliers '
			 . 'where nomConnexion = :nomConnexion '
			 . 'and mdp = :mdp' ;
			 
		$st = $bd -> prepare( $sql ) ;
		
		$st -> execute( array( 
								':nomConnexion' => $nomConnexion ,
								':mdp' => $mdp 
						) 
					) ;
		$resultat = $st -> fetchall() ;
			
		unset( $bd ) ;
		
		if( count( $resultat ) == 1 ) {
			session_start() ;
			$_SESSION[ 'numero' ] = $resultat[0]['numero'] ;
			$_SESSION[ 'nom' ] = $resultat[0]['nom'] ;
			$_SESSION[ 'prenom' ] = $resultat[0]['prenom'] ;
			
			$_SESSION[ 'nomConnexion' ] = $nomConnexion ;
			
			header( 'Location: ../vues/vue-liste-ateliers.php' ) ;
		}
		else {
			header( 'Location: ../vues/vue-connexion.php?echec=1&nomConnexion=' . $nomConnexion ) ;
		}
	}
	catch( PDOException $e ){
		
		header( 'Location: ../vues/vue-connexion.php?echec=0' ) ;
	}

?>
