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
<?php
	if (isset($_POST['login']) && $_POST['submit'] === 'Réinitialiser' && !empty
	($_POST['login'])){
		$check = htmlentities($_POST['login']);
		if (Mail::validEmail($check)){
			$sql = "SELECT * FROM users
							WHERE email=?";
			$err = "mail";
		}else{
			$sql = "SELECT * FROM users
							WHERE login=?";
			$err = "login";
		}
		$con = new Model;
		try{
			$st = $con->db->prepare($sql);
			$d = array($check);
			$st->execute($d);
			$user_exist = $st->rowCount();
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
		if ($user_exist === 1){
			echo "trouve!";
		}else if ($err === "mail"){
			echo '<p class="form_error">Cette adresse mail ne correspond à aucun
			utilisateur!</p>';
		}else if ($err === 'login'){
			echo '<p class="form_error">Ce login ne correspond à aucun
			utilisateur!</p>';
		}
	}else if (isset($_POST['login']) && $_POST['submit'] === 'Réinitialiser'
		&& empty
		($_POST['login'])){
		echo "<p class=\"form_error\">Veuillez renseigner un login ou une adresse mail !</p>";
	}
?>
<hr>
<p class="registered">
	<a class="registered" href="../">Retour accueil</a>
</p>
<a class="registered" href="../register/">Not yet registered ?</a>
<div class="footer"></div>