<div class="logo">
        <img class="img_logo_Principal" src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' alt="logo">
		<h1>CAMAGRU</h1>
</div>
<hr>
<form id="form-accueil" action="#" method="POST">
	<div class="log_accueil_but">
		Login:<br>
		<input id="log-accueil" type="text" name="login" value="<?php echo $this->_login ?>">
		<br>	
	</div>
	<div class="paswrd_accueil_but">
		Password:<br>
		<input id="paswrd_accueil_but" type="password" name="passwd" value="<?php echo $this->_passwd
        ?>">
		<br>
	</div>
	<div class="submit-accueil">
        <div class="button" id="submit-accueil" onclick="submitAccueil()">Login</div>
	</div>
</form>
    <p class="forgetPass">
        <a class="forgetPass" href="forgetId/">Forget Password or Account not Active ?</a>
    </p>
<hr>
<div class="registerDiv">
    <a class="registered" href="register/">Not yet registered ?</a>
</div>
<?php if (!empty($this->mess_error)){
    echo '<p class="form_error">'.$this->mess_error.'</p>';
} ?>

