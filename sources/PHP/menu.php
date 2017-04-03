<div id="menu">

	<div id="boutonOuvreLogin" class="boutonLogin_<?php echo $_SESSION['statut']=="visiteur"?"unloged":"loged";?>" onclick="$('<?php echo $_SESSION['statut']=="visiteur"?"#boite_login":"#boite_unlog"; ?>').dialog('open');">
		<?php echo $_SESSION['statut']=="visiteur"?"Se connecter":"Se déconnecter";?>
	</div>

	<?php
	if($_SESSION['statut']=="visiteur")
	echo "
	<div id=\"boutonOuvreFormulaireEnvoi\" onclick=\"$('#boite_envoi').dialog('open');\">
		<img src=\"./sources/images/plus.png\" alt=\"[+]\"/>
		Envoyer votre poster
	</div>";
	?>
</div>
