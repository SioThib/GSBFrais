<?php
	$this->load->helper('url');
	$path = base_url();
?>

<div id="contenu">
	<h2>Identification utilisateur</h2>

	<?php if (isset($erreur))	echo '<div class ="erreur"><ul><li>'.$erreur.'</li></ul></div>'; ?>

	<form method="post" action="<?php echo $path.'c_default/connecter';?>">
		<p>
			<label for="login">Login*</label>
			<input id="login" type="text" name="login"  size="30" maxlength="45"/>
		</p>
		<p>
			<label for="nom">Mot de passe*</label>
			<input id="mdp"  type="password"  name="mdp" size="30" maxlength="45"/>
		</p>
		<p>
			<input type="submit" value="Valider" name="valider"/>
			<input type="reset" value="Annuler" name="annuler"/> 
		</p>
		
		<p>
			<a href="http://validator.w3.org/check?uri=referer"><img
			src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
		</p>
	</form>

</div>

