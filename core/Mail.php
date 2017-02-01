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

		$base_url = $_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
		$logo = 'webroot/images/logo/photo-camera.png';
		$subject = 'Inscription a CAMAGRU';
		$div_logo = '<div class="logo">
						<h1><img class=" img_logo" src="cid:logo">CAMAGRU</h1>
					</div>';
		$h2 = '<h2>Bienvenue sur CAMAGRU '.ucfirst($login).' </h2>';
		$content = '<h3>Pour activer votre compte, veuillez cliquer sur le lien ci dessous.</h3>';
		$link = '<a href="http://'.$base_url.'validation?log='.urlencode($login).'&cle='.urlencode($cle).'">Cliquer pour activer</a>';

		$style = '<style>
					.container{
						font-family: "Cairo";
					}

					.logo {
						padding-top: 5px;
						display: inline-block;
						position: relative;
						width:100%;
						margin-bottom: 6%;
						}

					h1{
						text-align: center;
						position: relative;
						width: 100%;
						background-color: indianred; 
						font-size: 3.5vw;
					}

					.img_logo{
						vertical-align: middle;
						margin-right: 3%;
						width: 6%;
					}
				</style>
				';
		
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
		$msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
		$msg .= "Content-Transfer-Encoding:8bit\r\n";
		$msg .= "\r\n";

		// ---------------------------
		// Content message
		// ---------------------------
		$msg .= "<html>
					<head>
						<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
						<link href='https://fonts.googleapis.com/css?family=Cabin+Sketch|Cairo|Indie+Flower' rel='stylesheet'>
						<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>"
						.$style.
					"</head>
					<body>
						<div class='container' align='center'>"
							.$div_logo
							.$h2."<br />"
							.$content.'<br />'
							.$link.
						"</div>
					</body>
				</html>
				\r\n\r\n";
		
		//---------------------------------
		// 2nde partie du message
		// Le 1er fichier (inline)
		//---------------------------------
		$fichier = $logo;
		$fp = fopen($fichier, "r");
		$fichierattache = fread($fp, filesize($fichier));
		fclose($fp);
		$fichierattache = chunk_split(base64_encode($fichierattache));
		$msg .= "--$delimiteur\r\n";
		$msg .= "Content-Type: application/octet-stream; name=\"$fichier\"\r\n";
		$msg .= "Content-Transfer-Encoding: base64\r\n";
		$msg .= "Content-ID: <logo>\r\n";
		$msg .= "\r\n";
		$msg .= $fichierattache . "\r\n";
		$msg .= "\r\n\r\n";

		// --------------
		// Send
		// --------------
		$destinataire = $email;
		$expediteur   = 'inscription@Camagru.com';
		$reponse      = $expediteur;
		$reply = "Reply-to: $reponse\r\nFrom: $expediteur\r\n".$entete;
		mail($destinataire,
		     $subject,
		     $msg,
		     $reply);
	}
}

?>
