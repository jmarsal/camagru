<?php
	require_once("model/User.php");
	$user = new User;
//	$user->login = 'jibe';
//	$user->email="jb.marsal@gmail.com";
//	$user->hashPasswd ="13sh18ry4jury53j1s5ag4e6r8hs4s";
//	$user->formOk = 1;
?>forget_but
<div class="logo">
	<h1>CAMAGRU</h1>
	<img class="img_logo" src="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png' ?>" alt="logo">
</div>
<hr>
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
	<p class="button2">
		<input class ="button"type="submit" name="submit" value="Inscription">
	</p>
</form>
<?php
	if ($user->formOk === 1){
		if ($user->addUser($user->login, $user->email, $user->hashPasswd) ===
            TRUE){?>

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
                    Bienvenue <?php echo $user->login ?>
                </div>
                <div id="mail_confirm" class="mail_confirm">
                    Un email de confirmation de compte viens de vous etre envoyer a l'adresse <div class ="mail"><?php echo $user->email ?></div>
                </div>
                <div id="text" class="text">
                    Merci de bien vouloir cliquer sur le lien d'activation se trouvant dans le mail.
                </div>
                <p class="button2" onclick="hidePopup()">
                    <a class="button" href="">Fermer</a>
                </p>
            </div>
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
            <?php
		}
	}
	echo $user->mess_error;
//
?>
<hr>
<p class='a-connect'>Vous avez un compte ?</p>
<p class="button2">
	<a class="button" href="../">Connection</a>
</p>
<div class="footer"></div>