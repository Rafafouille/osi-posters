<?php

include_once("init.php");

//On recupere l'action a effectuer
$action=isset($_POST['action'])?$_POST['action']:"";



$reponse=array();
$reponse["message"]=array("type"=>":(","texte"=>"rien à signaler","affiche"=>false);
$reponse["valide"]=false;
$reponse["debug"]="";


if($action=="vote")
{
	$idPoster=isset($_POST['id'])?intval($_POST['id']):0;
	$note=isset($_POST['note'])?intval($_POST['note']):-1;

	$reponse["debug"]="Vous (id=".strval($_SESSION['id'])." - Statut=".$_SESSION['statut'].") votez pour le poster n°".strval($idPoster)." : ".strval($note)."/4";

	if($_SESSION['statut']=="candidat" && $_SESSION['valide']==true)//Si on est candidat
	{
		if($idPoster)//S'il y a un poster d'envoyé
		{

			$req0=$bdd->prepare("SELECT valide FROM posters WHERE id=:id");//On verifie que le poster est valide...
			$req0->execute(array("id"=>$idPoster));
			if($poster=$req0->fetch())//Si le poster existe
			{
				if($poster['valide'])
				{
					if($note!=-1)//S'il y a une note
					{
						$req=$bdd->prepare("SELECT id FROM votes WHERE votant=:idVotant AND poster=:idPoster");
						$req->execute(array("idVotant"=>$_SESSION['id'],"idPoster"=>$idPoster));
						if($vote=$req->fetch())//Si on a deja voté
						{
							$req2=$bdd->prepare("UPDATE votes SET note=:note, date=NOW() WHERE votant=:idVotant AND poster=:idPoster");
							$req2->execute(array("note"=>$note,"idVotant"=>$_SESSION['id'],"idPoster"=>$idPoster));
							$reponse["message"]=array("type"=>":)","texte"=>"deja voté","affiche"=>false);
							$reponse["valide"]=true;
						}
						else//Si on n'a pas deja voté
						{
							$req2=$bdd->prepare("INSERT INTO votes (note,votant,poster,date) VALUES (:note,:idVotant,:idPoster,NOW())");
							$req2->execute(array("note"=>$note,"idVotant"=>$_SESSION['id'],"idPoster"=>$idPoster));
							$reponse["message"]=array("type"=>":)","texte"=>"nouveau vote","affiche"=>false);
							$reponse["valide"]=true;
						}
						//Retours
						$reponse['idPoster']=$idPoster;
						$reponse['note']=$note;
					}
					else
					{
						$reponse["message"]=array("type"=>":(","texte"=>"Aucune note n'a été transmise","affiche"=>true);
						$reponse["valide"]=false;
					}
				}
				else
				{
						$reponse["message"]=array("type"=>":(","texte"=>"Le poster n'a pas été validé","affiche"=>true);
						$reponse["valide"]=false;
				}
			}
			else
			{
					$reponse["message"]=array("type"=>":(","texte"=>"Le poster n'existe pas","affiche"=>true);
					$reponse["valide"]=false;
			}
		}	
		else
		{
			$reponse["message"]=array("type"=>":(","texte"=>"Aucun poster n'a été transmis","affiche"=>true);
			$reponse["valide"]=false;
		}
	}
	else
	{
		$reponse["message"]=array("type"=>":(","texte"=>"Vous n'êtes pas un candidat. Vous n'avez pas le droit de voter.","affiche"=>true);
		$reponse["valide"]=false;
	}

}

// déconnexion ========================================
//Voir les actions au chargement

 echo json_encode($reponse)
?>
