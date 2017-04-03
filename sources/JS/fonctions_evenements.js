//Affiche message
afficheMessage=function(message)
{
	if(message.affiche)
	{
		$("#message_retour").text(message.texte);
		if(message.type==":)")
			$("#message_retour").attr("class","message_retour_GOOD");
		else
			$("#message_retour").attr("class","message_retour_BAD");

		$("#message_retour").slideDown();
		setTimeout(function(){$("#message_retour").slideUp();},3000)
	}
}


// ==== CONNEXION ===================
login=function(id,mdp)
{
	$("#boite_login form").submit();
}




// ==== DÉCONNEXION ===================
logout=function()
{
	$("#boite_unlog form").submit();
}





// ========= Set stars note =============
//Affecte (graphiqement) la note "note" au poster id n°"id"
setNoteStars=function(id,note)
{
	if($("#poster_"+id).attr("data-etat")=="valide")
	{
		$("#poster_"+id+" .vote_box img").each(function(index){
										if(index<=note)
											$(this).attr("src","./sources/images/etoile_valide.png");
										else
											$(this).attr("src","./sources/images/etoile_vide.png");
						})
	}
}


// =========== Vote ======================
//Permet de voter sur un poster id avec une note note
vote=function(id,note)
{
	if($("#poster_"+id).attr("data-etat")=="valide")
	{
		$("#poster_"+id+" .vote_box").css("opacity",0.3);

		$.post(
				"sources/PHP/actionneur.php",
				{
					action:"vote",
					id:id,
					note:note
				},
				vote_callback,
				"json"
			);
	}
}

vote_callback=function(reponse)
{
	if(reponse.valide)//Si le vote est accepté
	{
		$("#poster_"+reponse.idPoster+" .vote_box").attr("data-vote",reponse.note);//On change la note dans la page
		setNoteStars(reponse.idPoster,reponse.note);	//On actualise les etoiles
	}

	$("#poster_"+reponse.idPoster+" .vote_box").css("opacity",1);//On rend opaque

	afficheMessage(reponse.message);
	console.debug(reponse.debug);

}



