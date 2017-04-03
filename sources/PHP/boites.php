

<!-- FORMULAIRE ENVOI ======================================================= -->
<div id="boite_envoi" class="boite" title="Envoyer un poster">
	<div>
	<form action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="action" value="envoi_poster"/>
		<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />

		<table>
			<tr>
				<td>
					<label for="liste_lycee">Choix du lycée :</label>
				</td>
				<td>
					<select id="liste_lycee" name="liste_lycee">
						<option value="defaut">-- Choisir un lycée --</option>
						<optgroup label="CÔTE D'OR">
							<option value="clos_maire">BEAUNE - Lycée Clos Maire</option>
							<option value="carnot">DIJON - Lycée Carnot</option>
							<option value="hyppo">DIJON - Lycée Hyppolyte Fontaine</option>
						</optgroup>
						<optgroup label="NIÈVRE">
							<option value="PG de Gennes">COSNE-SUR-LOIRE - Lycée Pierre-Gilles de Gennes</option>
							<option value="Renard">NEVERS - Lycée Jules Renard</option>
						</optgroup>
						<optgroup label="SAÔNE ET LOIRE">
							<option value="militaire">AUTUN - Lycée Militaire</option>
							<option value="Jeanne d'Arc">CHÂLON-SUR-SAONE - Lycée Nicéphore Nièpce</option>
							<option value="La Prat's">CLUNY - Lycée La Prat's</option>
							<option value="claudel">DIGOIN - Lycée Camille Claudel</option>
							<option value="vincenot">LOUHANS - Lycée Henri Vincenot</option>
							<option value="cassin">MÂCON - Lycée René Cassin</option>
							<option value="parriat">MONTCEAU-LES-MINES - Lycée Henri Parriat</option>
							<option value="Jeanne d'Arc">PARAY-LE-MONIAL - Lycée Jeanne d'Arc</option>
						</optgroup>
						<optgroup label="YONNE">
							<option value="fourier">AUXERRE - Lycée Joseph Fourier</option>
							<option value="janot">SENS - Lycée Janot et Curie</option>
							<option value="chevalier">TONNERRE - Lycée Chevalier d'Éon</option>
						</optgroup>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="liste_discipline">Filière :</label>
				</td>
				<td>
					<select id="liste_discipline" name="liste_discipline">
						<option value="defaut">-- Filière de l'équipe --</option>
						<option value="SSI">S-SI</option>
						<option value="STI2D">STI2D</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="nom_poster">Nom du projet :</label>
				</td>
				<td>
					<input type="text" required="required" name="nom_poster" id="nom_poster" placeholder="Nom du projet" size="30"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="mail_contact">Courriel de contact :</label>
				</td>
				<td>
					<input type="email" required="required" name="mail_contact" id="mail_contact" placeholder="votre-email@serveur.ext" size="30"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="fichier_poster">Fichier à téléverser :</label>
				</td>
				<td>
					<input type="file" name="fichier_poster" id="fichier_poster" />
					<br/><em>(Note : le fichier doit être un PDF composé d'une unique page)</em>
				</td>
			</tr>
		</table>
	</form>
	</div>
</div>

<script>
	$("#boite_envoi").dialog({
				modal: true,
				resizable: false,
				autoOpen:false,
				width: 700,
				buttons: {
					"Annuler": function() {
						$(this).dialog("close");
					},
					"Envoyer": function() {
						$("label[for='liste_lycee']").css('color','black');
						$("#liste_lycee").css('border','solid 1px gray');
						$("label[for='liste_discipline']").css('color','black');
						$("#liste_discipline").css('border','solid 1px gray');

						var valid=true;
						if($("#liste_lycee").val()=="defaut")
							{valid=false;
							$("label[for='liste_lycee']").css('color','red');
							$("#liste_lycee").css('border','solid 1px red');}
					else
							{$("label[for='liste_lycee']").css('color','black');
							$("#liste_lycee").css('border','solid 1px black');}

						if($("#liste_discipline").val()=="defaut")
							{valid=false;
							$("label[for='liste_discipline']").css('color','red');
							$("#liste_discipline").css('border','solid 1px red');}
					else
							{$("label[for='liste_discipline']").css('color','black');
							$("#liste_discipline").css('border','solid 1px black');}

						if($("#nom_poster").val()=="")
							{valid=false;
							$("label[for='nom_poster']").css('color','red');
							$("#nom_poster").css('border','solid 1px red');}
					else
							{$("label[for='nom_poster']").css('color','black');
							$("#nom_poster").css('border','solid 1px black');}

						var regex=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
						if($("#mail_contact").val()=="" || !regex.test($("#mail_contact").val()))
							{valid=false;
							$("label[for='mail_contact']").css('color','red');
							$("#mail_contact").css('border','solid 1px red');}
					else
							{$("label[for='mail_contact']").css('color','black');
							$("#mail_contact").css('border','solid 1px black');}


						if($("#fichier_poster").val()=="")
							{valid=false;
							$("label[for='fichier_poster']").css('color','red');
							$("#fichier_poster").css('border','solid 1px red');}
					else
							{$("label[for='fichier_poster']").css('color','black');
							$("#fichier_poster").css('border','solid 1px black');}

						if(valid)
						{
							$(this).dialog("close");
							$("#boite_envoi_en_cours").dialog("open");
							$("#boite_envoi form").submit();
						}
					}
				}
			});
</script>









<!-- BOITE ENVOI EN COURS ======================================================= -->
<div id="boite_envoi_en_cours" class="boite" title="Envoi du poster">
	<div class="icone_chargement">
		<object type="image/svg+xml" data="./sources/images/gears.svg" width="100" height="100">
    			[Chargement...]
		</object>
		Envoi du poster + Traitement du fichier PDF...
	</div>
</div>

<script>
	$("#boite_envoi_en_cours").dialog({
				modal: true,
				resizable: false,
				autoOpen: false,
				width: 800
			});
</script>




<!-- BOITE SUPPRESSION ======================================================= -->
<div id="boite_suppression" class="boite" title="Suppression Poster">
	<div>
		<p>Vous souhaitez supprimer ce poster ?</p>
		<table>
			<tr>
				<td id="SUPPR_poster"><img class="miniature_suppression" src="" alt=""/></td>
				<td id="SUPPR_titre"></td>
			</tr>
		</table>
		<form action="" method="POST">
			<label for="form_suppr_mdp">Mot de passe : </label>
			<input type="password" id="form_suppr_mdp" name="form_suppr_mdp" value=""/>
			<img class="boutonOeil" onmousedown="$('#form_suppr_mdp').attr('type','text');$(this).attr('src','sources/images/oeil_OUVERT.png');" onmouseup="$('#form_suppr_mdp').attr('type','password');$(this).attr('src','sources/images/oeil_FERME.png');" src="sources/images/oeil_FERME.png" alt="[<o>]" title="Voir le mot de passe."/>
			<input type="hidden" id="form_suppr_id" name="form_suppr_id" value="-1"/>
			<input type="hidden" name="action" value="supprimer_poster"/>
		</form>
	</div>
</div>

<script>
	$("#boite_suppression").dialog({
				modal: true,
				resizable: false,
				autoOpen: false,
				width: 500,
				buttons: {
					"Annuler": function() {
						$(this).dialog("close");
					},
					"Supprimer": function() {$("#boite_suppression form").submit();}
				}
			});
			
			
	ouvreBoiteSuppr =function(i)
	{
		$("#SUPPR_poster img").attr("src",$("#poster_"+i.toString()+" img.grande_icone").attr("src"));
		$("#SUPPR_titre").text($("#poster_"+i.toString()+" .titre_poster").text());
		$("#form_suppr_id").val(i);
		$("#boite_suppression").dialog("open");
	}
			
</script>




<!-- BOITE LOGIN ======================================================= -->
<div id="boite_login" class="boite" title="Se connecter">
	<div>
		<form action="" method="POST">
			<table>
				<tr>
					<td><label for="LOGIN_nom_equipe"><img src="sources/images/team.png" alt=""/>Équipe (Poster) : </label></td>
					<td><select id="LOGIN_id_poster" name="LOGIN_id_poster">
						<option value="admin"/>=== Administrateur ===</option>
						<?php
							$req=$bdd->query("SELECT id,nom FROM posters ORDER BY id");
							while($data=$req->fetch())
							{
								echo "
						<option value=\"".$data['id']."\">(".$data['id'].") ".$data['nom']."</option>";
							}
						?>
					</select></td>
				</tr>
				<tr>
					<td><label for="LOGIN_mdp"><img src="sources/images/cadenas_2.png" alt=""/> Mot de passe : </label></td>
					<td>
						<input type="password" id="LOGIN_mdp" name="LOGIN_mdp" value=""/>
						<img class="boutonOeil" onmousedown="$('#LOGIN_mdp').attr('type','text');$(this).attr('src','sources/images/oeil_OUVERT.png');" onmouseup="$('#LOGIN_mdp').attr('type','password');$(this).attr('src','sources/images/oeil_FERME.png');" src="sources/images/oeil_FERME.png" alt="[<o>]" title="Voir le mot de passe."/>
					</td>
				</tr>
			</table>
			
			
			<input type="hidden" name="action" value="login"/>
		</form>
	</div>
</div>

<script>
	$("#boite_login").dialog({
				modal: true,
				resizable: false,
				autoOpen: false,
				width: 700,
				buttons: {
					"Annuler": function() {
						$(this).dialog("close");
					},
					"Se connecter": login
				}
			});
</script>



<!-- BOITE LOGOUT ======================================================= -->
<div id="boite_unlog" class="boite" title="Se Déconnecter">
	<div>
		<p>Voulez-vous vous déconnecter ?</p>
		<form action="" method="POST">
			<input type="hidden" name="action" value="logout"/>
		</form>
	</div>
</div>

<script>
	$("#boite_unlog").dialog({
				modal: true,
				resizable: false,
				autoOpen: false,
				width: 500,
				buttons: {
					"Annuler": function() {
						$(this).dialog("close");
					},
					"Se déconnecter": logout
				}
			});
</script>


<!-- BOITE INDICATIONS UPLOAD ======================================================= -->
<div id="boite_info_upload" class="boite" title="Information sur la mise en ligne">
	<div>
		<p>Vous venez de téléverser votre poster.
		<strong>Celui-ci n'est toujours pas public !</strong>
		Il est en attente de validation par l'administrateur (il apparait en transparent).</p>

		<p>Le mot de passe qui vous est indiqué est <span style="color:red;">à concerver précieusement</span>.
		Il vous permettra de :
		<ul>
			<li>Vous connecter pour <strong>voter</strong> pour les autres posters (une fois validé...)</li>
			<li><strong>Supprimer</strong> votre poster (pour envoyer une version plus récente, par exemple)</li>
		</ul>
		En cas de perte de mot de passe, contactez l'administrateur : raphael.allais@ac-dijon.fr.</p>
	</div>
</div>

<script>
	$("#boite_info_upload").dialog({
				modal: true,
				resizable: false,
				autoOpen: false,
				width: 500,
				buttons: {
					"Fermer": function() {
						$(this).dialog("close");
					}
				}
			});
</script>
