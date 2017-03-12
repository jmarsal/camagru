<div class="logo">
    <img class="img_logo_Principal" src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' alt="logo">
    <h1>CAMAGRU</h1>
</div>
<hr>
<h4>Inscrivez-vous pour voir les photos de vos amis.</h4>
<form action="#" method="POST">
	<div class="log_register_but">
		Login:<br>
		<input type="text" name="login" value="<?php echo $this->login ?>">
		<br>
	</div>
	<div class="mail_register_but">
		email:<br>
		<input type="text" name="email" value="<?php echo $this->email ?>">
		<br>
	</div>
	<div class="paswrd_register_but">
		Password:<br>
		<input type="password" name="passwd" value="<?php echo $this->passwd
        ?>">
		<br>
	</div>
	<div class="repeat_paswrd_register_but">
		Repeat password:<br>
		<input type="password" name="repPasswd" value="<?php echo
        $this->repPasswd ?>">
		<br>
	</div>
	<div class="log_register_but">
		<input class="button" type="submit" name="submit" value="Inscription">
	</div>
</form>
<?php
    if (isset($this->mess_error) && !empty($this->mess_error) && $this->mess_error != 1){
	    echo '<p class="form_error">'.$this->mess_error.'</p>';
    }
    if (isset($_ENV['popup']) && $_ENV['popup'] = 1){
        echo $this->popup;
    }
?>
<hr>
<p class='a-connect'>Vous avez un compte ?</p>
<div class="log_register_but">
	<a class="button" href="../">Connection</a>
</div>
<div class="footer"></div>