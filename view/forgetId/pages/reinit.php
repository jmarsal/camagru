<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 2:57 PM
 */
?>

<div class="logo-pop">
    <img class="img_logo_Principal" src="https://www.lycee-louis-vincent.fr/images/icons/puddingcam-logo.png" alt="logo">
    <h1>CAMAGRU</h1>
</div>
<hr>
<form id="reinitForm" class="reinitForm" action="#" method="POST">
    <p>Alors <?php echo ucfirst($_GET['log']) ?>...<br>
        on change de mot de passe ?</p>
	<div class="forget_but">
		Vas-y, tu peux entrer ton nouveau mot de passe :<br><br>
		<input type="password" name="newPass" value="<?php echo $this->newPasswd ?>">
        <br><br>
        Une deuxieme fois, histoire d'etre sur ! <img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'reinitPass'.DS.'WInky.png' ?>" width="30px"> <br><br>
        <input type="password" name="repNewPass"><br>
	</div>
	<div class="reinitButton">
		<input class="button" type="submit" name="submitRe"
               value="Enregistrer">
	</div>
	<?php
	if (!empty($this->mess_error)){
		echo '<p class="form_error">'.$this->mess_error.'</p>';
	}
	?>
    <hr>
    <p class="registered reinit">
        <a class="registered button" href="../">Retour accueil</a>
    </p>
</form>
<div class="footer"></div>
