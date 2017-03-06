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
<form action="#" method="POST">
    <p>Alors <?php echo ucfirst($_GET['log']) ?>...<br>
        on change de mot de passe ?</p>
	<div class="forget_but">
		Vas-y, tu peux entrer ton nouveau mot de passe :<br><br>
		<input type="password" name="newPass" value="<?php echo $this->newPasswd ?>">
        <br><br>
        Une deuxieme fois, histoire d'etre sur ! <img src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'reinitPass'.DS.'WInky.png' ?>" width="30px"> <br><br>
        <input type="password" name="repNewPass"><br>
	</div>
	<p class="button2">
		<input type="submit" name="submitRe" value="Enregistrer">
	</p>
</form>
<?php
if (!empty($this->mess_error)){
	echo '<p class="form_error">'.$this->mess_error.'</p>';
}
?>
    <hr>
    <p class="registered">
        <a class="registered" href="../">Retour accueil</a>
    </p>
    <div class="footer"></div>
