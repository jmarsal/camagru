<?php
	 $user = new User;
?>
<div class="logo">
		<h1>CAMAGRU</h1>
		<img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
</div>
<hr>
<form action="#" method="POST">
	<div class="log_accueil_but">
		Login:<br>
		<input type="text" name="login" value="<?php echo $user->login ?>">
		<br>	
	</div>
	<div class="paswrd_accueil_but">
		Password:<br>
		<input type="password" name="passwd" value="<?php echo $user->passwd ?>">
		<br>
	</div>
	<p class="button2">
		<input type="submit" name="submit" value="Login">
	</p>
</form>
    <p class="forgetPass">
        <a class="forgetPass" href="forgetPass/">Forget Password ?</a>
    </p>

<?php
	if ($user->formOk === 1){
		if ($user->checkLogin($user->login, $user->hashPasswd) === TRUE){
			if ($_SESSION['loged'] === 1){
				require_once('controller/AppController.php');
				new AppController();
			}
		}
	}

	 echo $user->mess_error;
	?>
<hr>
<a class="registered" href="register/">Not yet registered ?</a>
<div class="footer"></div>