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
<form id="formForgetId" action="#" method="POST">
	<p>Vous avez perdu <br>votre mot de passe, login,<br>
        ou votre compte n'est pas actif ?</p>
	<div class="forget_but">
		Veuillez renseigner une adresse mail :<br><br>
		<input id="emailForgetId" type="text" name="email"><br>
	</div>
    <div class="button" id="buttonForgetId" onclick="submitForgetId()">Récuperer</div>
</form>
<?php
if (!empty($this->mess_error)){
	echo '<p class="errorForgetId">'.$this->mess_error.'</p>';
}
echo $this->popup;
?>
    <hr>
    <p class="back-accueil">
        <a class="registered" href="../">Retour accueil</a>
    </p>
    <a class="registered" href="../register/">Not yet registered ?</a>
    <div class="footer"></div>

<script type="text/javascript">
    function RedirectionJavascript(){
        var send = 1;
        <?php $_ENV['sendReinit']?> = send;
        document.getElementById("mess-redirection").style.display = "block";
        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";
        setTimeout(changePageForAccueil, 3000);
        function changePageForAccueil(){
            document.location.href="<?php echo BASE_URL ?>";
        }
    }
</script>
