<?php

class Mail
{
	public $base_url;
	public $email;
	public $login;
	public $from;

	public function __construct($email, $login)
	{
		$this->email = $email;
		$this->login = $login;
		$this->base_url = $_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
	}

	/**
	 * Class MailCheckAdress
	 * @param $email l'adresse a verifier
	 * @return false si erreur
	 */
	function validEmail($email)
	{
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		} else {
			$domain = substr($email, $atIndex + 1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				// 				local part length exceeded
				$isValid = false;
			} else if ($domainLen < 1 || $domainLen > 255) {
				// 				domain part length exceeded
				$isValid = false;
			} else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
				// 				local part starts or ends with '.'
				$isValid = false;
			} else if (preg_match('/\\.\\./', $local)) {
				// 				local part has two consecutive dots
				$isValid = false;
			} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// 				character not valid in domain part
				$isValid = false;
			} else if (preg_match('/\\.\\./', $domain)) {
				// 				domain part has two consecutive dots
				$isValid = false;
			} else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
				// 		character not valid in local part unless
				// 		local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
				// 		domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;
	}

	// Envoi du mail de confirmation
//	static function sendMailConfirmation($email, $login, $cle)
//	{
//
//		$base_url = $_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
//		$subject = 'Inscription a CAMAGRU';
//		$link = $base_url . 'register/validation?log=' .
//			urlencode($login) . '&cle=' . urlencode($cle);
//
//		//----------------------------------
//		// Construction de l'entête
//		//----------------------------------
//		$delimiteur = "-----=" . md5(uniqid(rand()));
//		$this->entete = "MIME-Version: 1.0\r\n";
//		$this->entete .= "Content-Type: multipart/related; boundary=\"$delimiteur\"\r\n";
//		$this->entete .= "\r\n";
//
//		//--------------------------------------------------
//		// Construction du message proprement dit
//		//--------------------------------------------------
//		$msg = "Je vous informe que ceci est un message au format MIME 1.0 multipart/mixed.\r\n";
//
//		//---------------------------------
//		// 1ère partie du message
//		// Le code HTML
//		//---------------------------------
//		$msg .= "--$delimiteur\r\n";
//		$msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
//		$msg .= "Content-Transfer-Encoding:8bit\r\n";
//		$msg .= "\r\n";
//
//		// ---------------------------
//		// Content message
//		// ---------------------------
//
//		$msg .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
//				"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
//				 <html xmlns:v="urn:shemas-microsoft-com:vml">
//
//				<head>
//    			<meta http-equiv="content-type" content="text/html; charset=UTF-8">
//				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
//				<link href=\'https://fonts.googleapis.com/css?family=Cabin+Sketch|Cairo|Indie+Flower\' rel=\'stylesheet\'>
//				<link href=\'https://fonts.googleapis.com/css?family=Raleway\' rel=\'stylesheet\'>"
//				</head>
//
//				<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
//					<table bgcolor="#3c454d" cellpadding="0" cellspacing="0" border="0" width="100%">
//						<tbody>
//							<tr>
//								<td background="http://www.htmlcsscolor.com/preview/128x128/5E6C78.png" bgcolor="#3c454d" valign="top">
//								<!--[if gte mso 9]>
//								<v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;">
//								<v:fill type="tile" src="http://www.htmlcsscolor.com/preview/128x128/5E6C78.png" color="#3c454d" />
//								<v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
//								<![endif]-->
//									<div>
//										<table align="center" cellpadding="0" cellspacing="0" border="0" width="590">
//											<tbody>
//												<tr>
//													<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp;</td>
//												</tr>
//												<tr>
//													<td align="center" style="text-align: center;">
//														<img src="https://www.lycee-louis-vincent.fr/images/icons/puddingcam-logo.png" alt="logo" width="43" border="0">
//													</td>
//												</tr>
//												<tr>
//													<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp;</td>
//												</tr>
//												<tr>
//													<td align="center" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; font-size: 40px; color: #f3f3f3; mso-line-height-rule: exactly; line-height: 28px;">
//														Bienvenue sur Camagru !
//														<hr color="#F39237">
//													</td>
//												</tr>
//												<tr>
//													<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp;</td>
//												</tr>
//												<tr>
//													<td align="center" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; color: #DCDCDC; mso-line-height-rule: exactly; line-height: 26px;">
//													Bravo '.ucfirst($login).', tu as demander a t\'inscrire sur Camagru et je t\'en remercie. Plus qu\'une seule etape pour demarrer l\'experience!
//													</td>
//												</tr>
//												<tr>
//													<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp;</td>
//												</tr>
//												<tr>
//													<td align="center" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; color: #DCDCDC; mso-line-height-rule: exactly; line-height: 26px;">
//														Pour activer ton compte, clique sur le lien ci dessous.
//													</td>
//												</tr>
//												<tr>
//													<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp;</td>
//												</tr>
//												<tr>
//													<td align="center">
//														<table align="center" width="240px" cellspacing="0" cellpadding="0">
//															<tbody>
//																<tr>
//																	<td align="center" height="60px" bgcolor="#F39237" style="border-radius: 30px; text-align: center; font-size: 18px; font-family: \'Cairo\', Helvetica, sans-serif; color: #f3f3f3; text-decoration: none;" valign="middle">
//																		<a href="http://'.$link.'" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; font-size: 18px; color: #f3f3f3; text-decoration: none;line-height: 60px;display: block;height: 60px;">Valider mon compte</a>
//																	</td>
//																</tr>
//															</tbody>
//														</table>
//													</td>
//												</tr>
//												<tr>
//													<td height="30" style="font-size: 30px; line-height: 30px;"> &nbsp;</td>
//												</tr>
//											</tbody>
//										</table>
//									</div>
//									<!--[if gte mso 9]>
//									</v:textbox>
//									</v:rect>
//									<![endif]-->
//								</td>
//							</tr>
//						</tbody>
//					</table>
//				</body>
//			</html>';

//		$style = '<style>
//					.container{
//						font-family: "Cairo";
//					}
//
//					.logo {
//						padding-top: 5px;
//						display: inline-block;
//						position: relative;
//						width:100%;
//						margin-bottom: 6%;
//						}
//
//					h1{
//						text-align: center;
//						position: relative;
//						width: 100%;
//						background-color: indianred;
//						font-size: 3.5vw;
//					}
//
//					.img_logo{
//						vertical-align: middle;
//						margin-right: 3%;
//						width: 6%;
//					}
//				</style>
//				';
//		$msg .= "<html>
//					<head>
//						<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
//						<link href='https://fonts.googleapis.com/css?family=Cabin+Sketch|Cairo|Indie+Flower' rel='stylesheet'>
//						<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>"
//						.$style.
//					"</head>
//					<body>
//						<div class='container' align='center'>"
//							.$div_logo
//							.$h2."<br />"
//							.$content.'<br />'
//							.$link.
//						"</div>
//					</body>
//				</html>
//		$msg .= "\r\n\r\n";

		// --------------
		// Send
		// --------------

//		$destinataire = $email;
//		$expediteur = 'inscription@Camagru.com';
//		$reponse = $expediteur;
//		$reply = "Reply-to: $reponse\r\nFrom: $expediteur\r\n" . $this->entete;
//		mail($destinataire,
//			$subject,
//			$msg,
//			$reply);
//	}
}

?>
