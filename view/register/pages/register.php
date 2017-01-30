<?php
	require_once("model/User.php");
	$user = new User;
?>
<div class="logo">
	<h1>CAMAGRU</h1>
	<img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
</div>
<h4>Inscrivez-vous pour voir les photos de vos amis.</h4>
<form action="#" method="POST">
	<div class="log_register_but">
		Login:<br>
		<input type="text" name="login" value="<?php echo $user->login ?>">
		<br>	
	</div>
	<div class="mail_register_but">
		email:<br>
		<input type="text" name="email" value="<?php echo $user->email ?>">
		<br>	
	</div>
	<div class="paswrd_register_but">
		Password:<br>
		<input type="password" name="passwd" value="<?php echo $user->passwd ?>">
		<br>
	</div>
	<div class="repeat_paswrd_register_but">
		Repeat password:<br>
		<input type="password" name="repPasswd" value="<?php echo $user->repPasswd ?>">
		<br>
	</div>
	<p class="button1">
		<input type="submit" name="submit" value="Inscription">
	</p>
</form>
<?php
	if ($user->formOk === 1){
		echo "ca marche !";
		$user->addUser($user->login, $user->email, $user->hashPasswd);

	}
	echo $user->mess_error;
?>
<p>Vous avez un compte ?<a href="../">Connecter-vous</a></p>