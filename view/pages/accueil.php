<div class="logo">
        <img class="img_logo_Principal" src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' alt="logo">
		<h1>CAMAGRU</h1>
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
	<div>
		<input class="button" type="submit" name="submit" value="Login">
	</div>
</form>
    <p class="forgetPass">
        <a class="forgetPass" href="forgetId/">Forget Password or Account not Active ?</a>
    </p>
<hr>
<a class="registered" href="register/">Not yet registered ?</a>
<?php if (!empty($this->mess_error)){
    echo '<p class="form_error">'.$this->mess_error.'</p>';
} ?>

