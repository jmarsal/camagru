<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 2:57 PM
 */
?>

<div class="logo">
    <img class="img_logo_Principal" src='<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>' alt="logo">
    <h1>CAMAGRU</h1>
</div>
<hr>
<form class="formForgetId" id="formForgetId" action="#" method="POST">
    <p class="questionUser">Vous avez perdu <br>votre mot de passe, login,<br>
        ou votre compte n'est pas actif ?
    </p>
    <div class="forget_but">
        Veuillez renseigner une adresse mail :<br><br>
        <input id="emailForgetId" type="text" name="email" autofocus><br>
    </div>
    <div class="button" id="buttonForgetId" onclick="submitForgetId()">Récuperer</div>
</form>
<hr>
<p class="back-accueil">
    <a class="link-back-accueil" href="../">Retour accueil</a>
</p>
<p class="notYetRegister">
    <a class="link-back-accueil" href="../register/">Not yet registered ?</a>
</p>
<div class="footer"></div>
