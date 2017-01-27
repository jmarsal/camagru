<?php
session_start();
?>
<div class="logo">
		<h1>CAMAGRU</h1>
		<img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
</div>
<form action="<?php echo BASE_URL.DS.'camagru/camagru' ?>" methode="POST">
	<div class="log_accueil_but">
		Login:<br>
		<input type="text" name="login" value="">
		<br>	
	</div>
	<div class="paswrd_accueil_but">
		Password:<br>
		<input type="password" name="passwd" value="">
		<br>
	</div>
	<p class="button1">
		<input type="submit" name="submit" value="Se connecter">
	</p>

</form>
<a href="#">Not yet registered ?</a>