<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 2:57 PM
 */
?>

<div class="logo">
	<h1>CAMAGRU</h1>
	<img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
</div>
<hr>
<form action="#" method="POST">
	<p>Vous avez perdu <br>votre mot de passe ou login ?</p>
	<div class="forget_but">
		Veuillez renseigner votre Login ou adresse mail :<br><br>
		<input type="text" name="login"><br>
	</div>
	<p class="button2">
		<input type="submit" name="submit" value="Réinitialiser">
	</p>
</form>
<div id="popup" class="popup">
    <div class="logo-pop">
        <h1>CAMAGRU</h1>
        <img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
    </div>
    <hr>
    <div id="waiting" class="waiting">
        En attente de confirmation...
        <hr>
    </div>
    <div id="login" class="login">
        Bienvenue <?php echo 'Jibe' ?>
    </div>
    <div id="mail_confirm" class="mail_confirm">
        Un email de confirmation de compte viens de vous etre envoyer a l'adresse <div class ="mail"><?php echo 'jb.marsal@gmail.com' ?></div>
    </div>
    <div id="text" class="text">
        Merci de bien vouloir cliquer sur le lien d'activation se trouvant dans le mail.
    </div>
    <p class="button2" onclick="hidePopup()">
        <a class="button" href="">Fermer</a>
    </p>
</div>
<hr>
<p class="registered">
	<a class="registered" href="../">Retour accueil</a>
</p>
<a class="registered" href="../register/">Not yet registered ?</a>
<div class="footer"></div>



<div id="overlay" class="overlay"></div>
<script type="text/javascript">
    function showPopup(){
        document.getElementById("popup").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    }
    showPopup();
    function hidePopup(){
        document.getElementById("popup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }

</script>