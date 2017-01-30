<?php
class Mail {

	// verifie que l'adresse email est valide
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
				// 				character not valid in local part unless
							// 				local part is quoted
							if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))){
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))){
				// 				domain not found in DNS
							$isValid = false;
			}
		}
		return $isValid;
	}

	// Envoi du mail de confirmation
	static function sendMailConfirmation($email, $login, $cle){
		
		// Préparation du mail contenant le lien d'activation
		$destinataire = $email;
		$sujet = "Activer votre compte" ;
		$entete = "From: inscription@Camagru.com" ;
 
		// Le lien d'activation est composé du login(log) et de la clé(cle)
		$message = 'Bienvenue '.$login.' sur CAMAGRU,
 
		Pour activer votre compte, veuillez cliquer sur le lien ci dessous
		ou copier/coller dans votre navigateur internet.
 
		http://http://localhost:8080/workspace/camagru/register/validation.php?log='.urlencode($login).'&cle='.urlencode($cle).'
 
 
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';

		mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail
	}
}

?>
