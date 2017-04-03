<div id="liste_posters">
<?php

	$req=$bdd->query("SELECT * FROM posters ".($_SESSION['statut']!="admin"?"WHERE valide=1 OR ip='".$_SERVER['REMOTE_ADDR']."' OR id=".strval($_SESSION['id']):"")." ORDER BY date DESC");



	//POUR CHAQUE POSTER =================================
	while($poster=$req->fetch())
	{
		echo "
	<div id=\"poster_".$poster['id']."\" class=\"poster".($poster['valide']==0?" invalide":"")."\" data-id=\"".$poster['id']."\" data-etat=\"".($poster['valide']==0?"invalide":"valide")."\" onmouseover=\"ouvreIcones(".$poster['id'].")\" onmouseout=\"setNoteStars(".strval($poster['id']).",$('#poster_".$poster['id']." .vote_box').attr('data-vote'))\">";


	//BOITE POUR VOTER ******************
	if($_SESSION['statut']=="candidat" && $_SESSION['valide']==true && $poster['id']!=$_SESSION['id']) //Si on est un cadidat connecté et que son poster est validé
	{
		$req2=$bdd->query("SELECT note FROM votes WHERE votant=".$_SESSION['id']." AND poster=".$poster['id']);
		$note=0;
		if($vote=$req2->fetch())//Si le vote existe deja
			$note=intval($vote['note']);//On recupere la note
		echo "
		<div class=\"vote_box\" data-vote=\"".strval($note)."\">
					";
			$noteMax=3;

			for($i=0;$i<=$noteMax;$i++)
			{
				if($i<=$note)
					{echo "<img class=\"etoile_valide\" src=\"sources/images/etoile_valide.png\" alt=\"[*]\" title=\"Vote : ".strval($note+1)."/".strval($noteMax+1)."\" onmouseover=\"setNoteStars(".strval($poster['id']).",".strval($i).");\" onclick=\"vote(".strval($poster['id']).",".strval($i).");\"/>";}
				else
					{echo "<img class=\"etoile_vide\" src=\"sources/images/etoile_vide.png\" alt=\"[ ]\" title=\"Vote : ".strval($note+1)."/".strval($noteMax+1)."\" onmouseover=\"setNoteStars(".strval($poster['id']).",".strval($i).")\" onclick=\"vote(".strval($poster['id']).",".strval($i).");\"/>";}
			}
		echo "
		</div>";
	}
	else
		echo "<div class=\"vote_box\"></div>";//Fin boite pour voter

	//BOITE POUR RECAPITULER LES VOTES*****
	if($_SESSION['statut']=="admin") //Si on est un cadidat connecté
	{
		$req2=$bdd->query("SELECT SUM(note) as total FROM votes WHERE poster=".$poster['id']);
		$note=0;
		if($vote=$req2->fetch())//Si le vote existe deja
			$note=intval($vote['total']);//On recupere la note
		echo "
		<div class=\"vote_box\" data-vote=\"".strval($note)."\">
					".strval($note)." pt".($note>1?"s":"")."
		</div>";		
	}


	//POSTER ******************************
echo "
		<a class=\"lien_grande_icone\" href=\"./POSTERS/bitmap_HD/".$poster['fichier'].".jpg\" target=\"_blank\">
				<img class=\"grande_icone\" src=\"./POSTERS/miniatures/".$poster['fichier'].".jpg\" />
			<div class=\"numero_poster".(intval($_SESSION['id'])==intval($poster["id"])?" own":"")."\"><span>".$poster['id']."</span></div>
		</a>
		<span class=\"titre_poster\">".$poster['nom']."</span>".($poster['valide']==0?"<br/>(En cours de validation)":"")."
		<br/>";

		if($_SESSION['statut']=="admin")
		{echo "
		<div class=\"nom_lycee\">Lycée ".$poster['lycee']." - ".strtoupper($poster['filiere'])."</div>
		<div class=\"affiche_mdp\">(<img src=\"./sources/images/lock_mdp.png\" alt=\"Mot de passe :\" title=\"Mot de passe\"/> ".$poster['mdp'].")</div>
		<div class=\"affiche_mail\"><a href=\"mailto:".$poster['mail']."\">".$poster['mail']."</a></div>";
		}

		echo "
		<div class=\"groupe_icon_sous_poster\">
			<a href=\"./POSTERS/originaux/".$poster['fichier'].".pdf\" target=\"_blank\">
				<img class=\"icon_sous_poster\" src=\"./sources/images/pdf-icon.png\" alt=\"[PDF]\" title=\"Télécharger le fichier original .PDF\"/>
			</a>";
		//Bouton supprimer
		if(intval($_SESSION['id'])==intval($poster["id"]) || $_SESSION['statut']=="admin")
			{echo "
			<img class=\"icon_sous_poster\" src=\"./sources/images/poubelle.png\" alt=\"[Suppr.]\" title=\"Supprimer le poster (Nécessite un mot de passe)\" onclick=\"ouvreBoiteSuppr(".$poster['id'].");\"/>";
			}
		//Bouton Valider
		if($_SESSION['statut']=="admin")
			{echo "
			<form action=\"\" method=\"POST\" id=\"valide_".$poster['id']."\">
					<input type=\"checkbox\" name=\"valide_".$poster['id']."\" ".($poster['valide']==1?"checked":"")." onChange=\"$('#valide_".$poster['id']."').submit();\"/>
					<input type=\"hidden\" name=\"action\" value=\"chech_uncheck\"/>
					<input type=\"hidden\" name=\"id\" value=\"".$poster['id']."\"/>
			</form>";}


/*	if(intval($_SESSION['id'])==intval($poster["id"]))
			{echo "
			<img class=\"icon_sous_poster\" src=\"./sources/images/poubelle.png\" alt=\"[Suppr.]\" title=\"Supprimer le poster (Nécessite un mot de passe)\" onclick=\"ouvreBoiteSuppr(".$poster['id'].");\"/>
			".($_SESSION['statut']=="admin"?"<form action=\"\" method=\"POST\" id=\"valide_".$poster['id']."\">
					<input type=\"checkbox\" name=\"valide_".$poster['id']."\" ".($poster['valide']==1?"checked":"")." onChange=\"$('#valide_".$poster['id']."').submit();\"/>
					<input type=\"hidden\" name=\"action\" value=\"chech_uncheck\"/>
					<input type=\"hidden\" name=\"id\" value=\"".$poster['id']."\"/>
			</form>":"");}*/

		echo "
		</div>
		
	</div>";
	}//FIN DE "POUR CHAQUE POSTER"
?>


<script>
ouvreIcones=function(i)
{
	/*$("#poster_"+i+" .groupe_icon_sous_poster img").hide();*/
	//$("#poster_"+i+" .groupe_icon_sous_poster img").show(1000);//find('.groupe_icon_sous_poster img').each(function(i,v){var ceci=this;setTimeout(function(){$(ceci).show(100)},100*i);});//
}
fermeIcones=function(i)
{
	$("#poster_"+i+" .groupe_icon_sous_poster").hide(100);//find('.groupe_icon_sous_poster img').each(function(i,v){var ceci=this;setTimeout(function(){$(ceci).show(100)},100*i);});//
}
</script>
</div>
