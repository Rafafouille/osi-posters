		<div style="display:none" id="message_retour" class="message_retour_<?php echo substr($retour,0,2)==":)"?"GOOD":"BAD"; ?>">
			<?php echo substr($retour,2,strlen($retour)-2); ?>
		</div>

	<?php
		if($retour!="")
			{?>
		<script>
			$("#message_retour").slideDown();
			<?php
				if(!isset($laisserMessage))
			{?>
				setTimeout(function(){$("#message_retour").slideUp()},5000);
			<?php
			}
			?>
		</script>
		<?php }
	?>
