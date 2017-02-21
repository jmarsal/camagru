<div class="logo">
    <img class="img_logo_Principal" src="https://www.lycee-louis-vincent.fr/images/icons/puddingcam-logo.png" alt="logo">
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
	<p class="button2">
		<input class ="button"type="submit" name="submit" value="Inscription">
	</p>
</form>
<?php
    if (!empty($this->mess_error)){
	    echo '<p class="form_error">'.$this->mess_error.'</p>';
    }
    echo $this->popup;
?>
<hr>
<p class='a-connect'>Vous avez un compte ?</p>
<p class="button2">
	<a class="button" href="../">Connection</a>
</p>
<div class="footer"></div>