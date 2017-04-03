<?php include_once("./sources/PHP/init.php");?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8"/>
	<title>OSI 2017 - Concours Poster</title>
	<!-- <script src="sources/JS/libraries/easelJS/createjs-2015.11.26.min.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<!--<script src=" monCodeJS.js "></script>-->
	<script src="./sources/JS/fonctions_evenements.js"/></script>
	<link rel="stylesheet" href="./sources/style.css" />
	<script>

	</script>
</head>
<body>
	<header>
		<img id="logo_entete" alt="[OSI]" src="./sources/images/affiche-NO-LOGO.png" />
		<h1>Olympiades Académiques de Sciences de l'Ingénieur<br/>Concours Poster</h1>
	</header>



	<?php $retour="";
	include_once("./sources/PHP/actions.php");
	?>

	<?php
	include_once("./sources/PHP/message_retour.php");
	?>

	<?php
	include_once("./sources/PHP/menu.php");
	?>

	<?php
	include_once("./sources/PHP/posters.php");
	?>

	<?php
	include_once("./sources/PHP/boites.php");
	?>

</body>
</html> 
