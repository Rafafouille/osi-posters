<?php

$action="";
if(isset($_POST['action']))	$action=$_POST['action'];



// ENVOI ========================================
if($action=="envoi_poster")
{
	$lycee="";
	if(isset($_POST['liste_lycee'])) $lycee=$_POST['liste_lycee'];

	$filiere="";
	if(isset($_POST['liste_discipline'])) $filiere=$_POST['liste_discipline'];

	$nom_poster="";
	if(isset($_POST['nom_poster'])) $nom_poster=$_POST['nom_poster'];

	$mail=isset($_POST['mail_contact'])?$_POST['mail_contact']:"";


	$consonnes="bcdfgjklmnpqrstvwxz";
	$voyelles="aeiouy";
	$mdp="";
	for($i=0;$i<=2;$i++)
		$mdp.=substr($consonnes,rand(0,strlen($consonnes)-1),1).substr($voyelles,rand(0,strlen($voyelles)-1),1);

	if (isset($_FILES['fichier_poster']) AND $_FILES['fichier_poster']['error'] == 0)
	{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['fichier_poster']['size'] <= 30000000)
		{
		        // Testons si l'extension est autorisée
		        $infosfichier = pathinfo($_FILES['fichier_poster']['name']);
		        $extension_upload = strtolower($infosfichier['extension']);
		        $extensions_autorisees = array('pdf');
			$nouveau_nom=strval(time())."_".strval(rand(0,10000));

		        if (in_array($extension_upload, $extensions_autorisees))
		        {
		                // On peut valider le fichier et le stocker définitivement
		               if(move_uploaded_file($_FILES['fichier_poster']['tmp_name'], './POSTERS/originaux/'.$nouveau_nom.'.pdf'))// . basename($_FILES['fichier_poster']['name'])))
						{
							$req=$bdd->prepare("INSERT INTO posters(lycee,nom,filiere,fichier,mdp,ip,mail) VALUES(:lycee,:nom,:filiere,:fichier,:mdp,:ip,:mail)");
							$req->execute(array(
									"lycee"=>$lycee,
									"nom"=>$nom_poster,
									"filiere"=>$filiere,
									"fichier"=>$nouveau_nom,
									"mdp"=>$mdp,
									"ip"=>$_SERVER['REMOTE_ADDR'],
									"mail"=>$mail
								));
							exec('convert -background white -alpha remove "./POSTERS/originaux/'.$nouveau_nom.'.pdf" -colorspace RGB -resize 1500 -quality 100 "./POSTERS/bitmap_HD/'.$nouveau_nom.'.jpg"', $output, $return_var);
							exec('convert -background white -alpha remove "./POSTERS/bitmap_HD/'.$nouveau_nom.'.jpg" -colorspace RGB -resize 200 "./POSTERS/miniatures/'.$nouveau_nom.'.jpg"', $output, $return_var);
							if($return_var==0)
								{
								$laisserMessage=true;
								$retour=":)Le poster a bien été reçu et est en <strong>attente de validation</strong> !<br/><br/>
									<h1>Votre mot de passe : <span style=\"color:red;\">".$mdp."</span></h1>
									(Conservez le précieusement !)<br/>
									<span style=\"cursor:pointer;color:red;\" onclick=\"$('#boite_info_upload').dialog('open')\">[Plus d'infos, à lire !]</span>";

/*							Pour l'instant, les autres équipes ne peuvent pas le voir.<br/>
									Vous n'avez également pas encore la possibilité de voter pour vos posters favoris.<br/><br/>
									Vous pouvez néanmoins déjà vous connecter grâce au mot de passe suivant : <strong>".$mdp."</strong><br/>
									ATTENTION : Ce mot de passe est propre à l'équipe qui a conçu ce poster.
									Chaque équipe possède son propre mot de passe : Conservez-le précieusement !<br/>
									Il permettra à votre équipe de voter (quand le poster sera validé), et supprimer votre poster (si vous souhaitez téléverser une version plus récente).";*/
									mail("allais.raphael@free.fr,jean-paul.vincent@ac-dijon.fr","[OSI] Concours Poster","Un poster a ete envoye... http://osi.allais.eu\n\nLycee : ".$lycee."\nProjet : ".$nom_poster);

								deconnecte();
						}
					else
						$retour=":(Le poster a bien été reçu mais il y a eu un problème sur la création du bitmap associé !";
				}
				else
					$retour=":(Le poster a bien été envoyé, mais ne semble pas s'être correctement enregistré. Contactez l'administrateur.";
		        }
			else
			$retour=":(Le fichier n'est pas au format demandé (PDF).";
		}
		else
		$retour=":(Le fichier est trop lourd (>30 Mo) ! Si votre poster est si lourd, et que vous ne pouvez pas réduire sa taille, contactez les organisateurs.";
	}
	else
	$retour=":(Le fichier semble ne pas avoir été transmis.";
}



// Connexion ========================================
if($action=="login")
{
	$mdp=isset($_POST['LOGIN_mdp'])?$mdp=$_POST['LOGIN_mdp']:"";
	$id=isset($_POST['LOGIN_id_poster'])?$id=$_POST['LOGIN_id_poster']:"";
	
	if($id=="admin" && $mdp=="ev0n1")
	{
		$_SESSION['id']=-42;
		$_SESSION['statut']="admin";
		$retour=":)Vous allez être connecté en tant qu'administrateur...";
	}
	else
	{
		$req=$bdd->prepare("SELECT * FROM posters WHERE id=:id AND mdp=:mdp");
		$req->execute(array(	"id"=>$id,
							"mdp"=>$mdp));
		if($data=$req->fetch())
		{
			$_SESSION['id']=intval($data['id']);
			$_SESSION['statut']="candidat";
			$_SESSION['valide']=$data['valide'];
			$retour=":)Vous êtes connecté";
		}
		else
		{
			$retour=":(Mauvais mot de passe pour la connexion.";
		}
	}
}


//LOGOUT =====================================
if($action=="logout")
{	
	deconnecte();
}





// SUPPRESSION ========================================
if($action=="supprimer_poster")
{
	$id=-1;
	if(isset($_POST['form_suppr_id'])) $id=$_POST['form_suppr_id'];

	$mdp="";
	if(isset($_POST['form_suppr_mdp'])) $mdp=$_POST['form_suppr_mdp'];


	if($id!=-1)
	{
		if($mdp=="ev0n1")
		{
			$req=$bdd->prepare("SELECT * FROM posters WHERE id=:id");//
			$req->execute(array(
								"id"=>$id
							));
		}
		else
		{
			$req=$bdd->prepare("SELECT * FROM posters WHERE id=:id AND mdp=:mdp");//
			$req->execute(array(
								"mdp"=>$mdp,
								"id"=>$id
							));
		}
	
		if($poster=$req->fetch())//Si bon mot de passe
		{
			//Suppression du fichier
			unlink("./POSTERS/bitmap_HD/".$poster['fichier'].".jpg");
			unlink("./POSTERS/miniatures/".$poster['fichier'].".jpg");
			rename("./POSTERS/originaux/".$poster['fichier'].".pdf", "./POSTERS/trash/".$poster['fichier'].".pdf");

			//Suppression dans la BDD
			$req2=$bdd->prepare("DELETE FROM posters WHERE id=:id");
			$req2->execute(array(
							"id"=>$id
						));

			//Suppression des votes
			$req3=$bdd->prepare("DELETE FROM votes WHERE votant=:id");
			$req3->execute(array(
							"id"=>$id
						));

			$retour=":)Le poster été correctement supprimé.";
			if($_SESSION['statut']!="admin")
				deconnecte();
		}
		else
			$retour=":(Le poster et le mot de passe ne correspondent pas.";
	}
	else
		$retour=":(Le poster à supprimer n'est pas spécifié";
}






// check_unckeck ========================================
if($action=="chech_uncheck")
{
	if($_SESSION['statut']=="admin")
	{
		$id=-1;
		if(isset($_POST['id'])) $id=$_POST['id'];

		if($id!=-1)
		{
			$req=$bdd->prepare("SELECT valide FROM posters WHERE id=:id");//
			$req->execute(array("id"=>$id));
			if($data=$req->fetch())
			{
				if(intval($data['valide']))
				{
					$req2=$bdd->prepare("UPDATE posters SET valide=0 WHERE id=:id");//
					$req2->execute(array("id"=>$id));
					$retour=":)Le poster a bien été dévalidé.";
				}
				else
				{
					$req2=$bdd->prepare("UPDATE posters SET valide=1 WHERE id=:id");//
					$req2->execute(array("id"=>$id));
					$retour=":)Le poster a bien été validé.";
				}
			}
			else
				$retour=":(Le poster n'a pas été trouvé.";
		}
		else
			$retour=":(Pas de poster à modifier.";
	}
	else
		$retour=":(Vous n'êtes pas administrateur.";

}
?>
