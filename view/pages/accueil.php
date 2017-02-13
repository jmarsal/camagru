<div class="logo">
		<h1>CAMAGRU</h1>
		<img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
</div>
<hr>
<form action="#" method="POST">
	<div class="log_accueil_but">
		Login:<br>
		<input type="text" name="login" value="<?php echo $this->login ?>">
		<br>	
	</div>
	<div class="paswrd_accueil_but">
		Password:<br>
		<input type="password" name="passwd" value="<?php echo $this->passwd
        ?>">
		<br>
	</div>
	<p class="button2">
		<input type="submit" name="submit" value="Login">
	</p>
</form>
    <p class="forgetPass">
        <a class="forgetPass" href="forgetId/">Forget Password ?</a>
    </p>
<hr>
<a class="registered" href="register/">Not yet registered ?</a>
<?php if (!empty($this->mess_error)){
    echo '<p class="form_error">'.$this->mess_error.'</p>';
} ?>
<div class="footer"></div>