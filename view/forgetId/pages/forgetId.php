<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 2:57 PM
 */
?>

<div class="logo">
    <img class="img_logo_Principal" src="https://www.lycee-louis-vincent.fr/images/icons/puddingcam-logo.png" alt="logo">
    <h1>CAMAGRU</h1>
</div>
<hr>
<form action="#" method="POST">
	<p>Vous avez perdu <br>votre mot de passe, login,<br>
        ou votre compte n'est pas actif ?</p>
	<div class="forget_but">
		Veuillez renseigner une adresse mail :<br><br>
		<input type="text" name="email"><br>
	</div>
	<p class="button2">
		<input type="submit" name="submit" value="Récuperer">
	</p>
</form>
<?php
if (!empty($this->mess_error)){
	echo '<p class="form_error">'.$this->mess_error.'</p>';
}
echo $this->popup;
?>
    <hr>
    <p class="registered">
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
