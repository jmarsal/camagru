<?php
class Mail {
	
	// 	verifie que l'adresse email est valide
	static function validEmail($email){
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex){
			$isValid = false;
		}
		else{
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64){
				// 				local part length exceeded
							$isValid = false;
			}
			else if ($domainLen < 1 || $domainLen > 255){
				// 				domain part length exceeded
							$isValid = false;
			}
			else if ($local[0] == '.' || $local[$localLen-1] == '.'){
				// 				local part starts or ends with '.'
							$isValid = false;
			}
			else if (preg_match('/\\.\\./', $local)){
				// 				local part has two consecutive dots
							$isValid = false;
			}
			else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
				// 				character not valid in domain part
							$isValid = false;
			}
			else if (preg_match('/\\.\\./', $domain)){
				// 				domain part has two consecutive dots
							$isValid = false;
			}
			else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))){
		// 		character not valid in local part unless
									// 		local part is quoted
									if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))){
			$isValid = false;
		}
	}
	if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))){
		// 		domain not found in DNS
									$isValid = false;
	}
}
return $isValid;
}

// Envoi du mail de confirmation
	static function sendMailConfirmation($email, $login, $cle){
		//----------------------------------
		// Construction de l'entête
		//----------------------------------
		$delimiteur = "-----=".md5(uniqid(rand()));
		$entete = "MIME-Version: 1.0\r\n";
		$entete .= "Content-Type: multipart/related; boundary=\"$delimiteur\"\r\n";
		$entete .= "\r\n";
		//--------------------------------------------------
		// Construction du message proprement dit
		//--------------------------------------------------
		$msg = "Je vous informe que ceci est un message au format MIME 1.0 multipart/mixed.\r\n";
		//---------------------------------
		// 1ère partie du message
		// Le code HTML
		//---------------------------------
		$msg .= "--$delimiteur\r\n";
		$msg .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
		$msg .= "Content-Transfer-Encoding:8bit\r\n";
		$msg .= "\r\n";
		$msg .= "<html><body>Image 1:<img src='http://".$_SERVER['HTTP_HOST']."webroot/images/logo/photo-camera.png'>";
		$msg .= "<br /><h1>Bienvenue ".$login." sur CAMAGRU</h1><br />";
		$msg .= "<p>Pour activer votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller dans votre navigateur internet.</p><br />";
		$msg .= '<a href="http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'].'validation?log='.urlencode($login).'&cle='.urlencode($cle).'>Cliquer pour activer</a>';
		$msg .= "</body></html>\r\n";
		$msg .= "\r\n";
		//---------------------------------
		// 2nde partie du message
		// Le 1er fichier (inline)
		//---------------------------------
		$msg .= "--$delimiteur\r\n";
		$msg .= "\r\n\r\n";

		$destinataire = $email;
		$expediteur   = 'inscription@Camagru.com';
		$reponse      = $expediteur;
		echo "Ce script envoie un mail au format HTML avec 1 image à $login";
		mail($destinataire,
		     'Inscription a CAMAGRU',
		     $msg,
		     "Reply-to: $reponse\r\nFrom: $expediteur\r\n".$entete);
	}
		// Préparation du mail contenant le lien d'activation
// 		$destinataire = $email;
// $sujet = "Activer votre compte" ;
// $entete = "From: inscription@Camagru.com" ;

// // Le lien d'activation est composé du login(log) et de la clé(cle)
// 		$message = 'Bienvenue '.$login.' sur CAMAGRU,

// Pour activer votre compte, veuillez cliquer sur le lien ci dessous
// 		ou copier/coller dans votre navigateur internet.

// http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'].'validation?log='.urlencode($login).'&cle='.urlencode($cle).'
// 		---------------
// 		Ceci est un mail automatique, Merci de ne pas y répondre.';

// mail($destinataire, $sujet, $message, $entete) ;
// Envoi du mail
}

?>
