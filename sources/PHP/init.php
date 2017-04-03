<?php
 session_start();
 
 if(!isset($_SESSION['statut']))
	{
	 $_SESSION['statut']="visiteur";//Statut de l'utilisateur
	 $_SESSION['id']=0;	//Id de l'utilisateur
	 $_SESSION['valide']=false;	//Son poster est-il validé ?
	}

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=osi;charset=utf8', 'osi', 'Tr1pT0Th3M0une');
	//$bdd = new PDO('mysql:host=fogg.ensgt.u-bourgogne.fr;dbname=ol-poster;charset=utf8;port=3307', 'ol-poster', 'retsop2017');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}



function deconnecte()
{
	$_SESSION['statut']="visiteur";
	$_SESSION['id']=0;
	$_SESSION['valide']=false;
	$retour=":)Vous êtes déconnecté.";
}

?>
