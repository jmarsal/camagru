<?php

/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/2/17
 * Time: 2:09 PM
 */
class MailSender extends Mail
{
	public $trSeparator = "<tr>
								<td height=\"30\" style=\"font-size: 30px; line-height: 30px;\"> &nbsp;</td>
							</tr>";
	public $subject;
	public $title;
	public $message;
	private $_msg;
	private $_cle;
	private $_entete;

	public function __construct($email, $login, $subject, $title,  $message,
								$from, $cle = NULL)
	{
		$this->email = $email;
		$this->login = $login;
		$this->subject = $subject;
		$this->title = $title;
		$this->message = $message;
		$this->from = $from;


		if (isset($cle) && !empty($cle)){
			$this->_cle = $cle;
		}
		//----------------------------------
		// Construction de l'entête
		//----------------------------------
		$delimiteur = "-----=" . md5(uniqid(rand()));
		$this->_entete = "MIME-Version: 1.0\r\n";
		$this->_entete .= "Content-Type: multipart/related; boundary=\"$delimiteur\"\r\n";
		$this->_entete .= "\r\n";

		//--------------------------------------------------
		// Construction du message proprement dit
		//--------------------------------------------------
		$this->_msg = "Je vous informe que ceci est un message au format MIME 1.0 multipart/mixed.\r\n";

		//---------------------------------
		// 1ère partie du message
		// Le code HTML
		//---------------------------------
		$this->_msg .= "--$delimiteur\r\n";
		$this->_msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
		$this->_msg .= "Content-Transfer-Encoding:8bit\r\n";
		$this->_msg .= "\r\n";

		// ---------------------------
		// Content message
		// ---------------------------

		$this->_msg .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
		$this->_msg .= '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$this->_msg .= "<html xmlns:v=".'urn:shemas-microsoft-com:vml'.">";
		$this->_msg .= '<head'.'>';
		$this->_msg .=	'<meta http-equiv='.'"content-type" content="text/html; charset=UTF-8">';
		$this->_msg .=	'<meta name='.'"viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
		$this->_msg .=	'<link href='.'https://fonts.googleapis
		//.com/css?family=Cabin+Sketch|Cairo|Indie+Flower\' rel=\'stylesheet\'>';
		$this->_msg .=	'<link href='.'https://fonts.googleapis
		//.com/css?family=Raleway\' rel=\'stylesheet\'>"';
		$this->_msg .=	'</head'.'>';

		$this->_msg .=	'	<body leftmargin='.'"0" topmargin="0" marginwidth="0" marginheight="0">';
		$this->_msg .=	'		<table bgcolor='.'"#3c454d" cellpadding="0" cellspacing="0" border="0" width="100%">';
		$this->_msg .=	'			<tbody'.'>';
		$this->_msg .=	'				<tr'.'>';
		$this->_msg .=	'					<td background='.'"http://www.htmlcsscolor.com/preview/128x128/5E6C78.png" bgcolor="#3c454d" valign="top">';
		$this->_msg .=	'						<!--[if gte mso 9]>';
		$this->_msg .=	'						<v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;">';
		$this->_msg .=	'						<v:fill type="tile" src="http://www.htmlcsscolor.com/preview/128x128/5E6C78.png" color="#3c454d" />';
		$this->_msg .=	'						<v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">';
		$this->_msg .=	'						<![endif]-->';
		$this->_msg .=	'							<div'.'>';
		$this->_msg .=	'								<table align='.'"center" cellpadding="0" cellspacing="0" border="0" width="590">';
		$this->_msg .=	'									<tbody'.'>';
		$this->_msg .=											$this->trSeparator;
		$this->_msg .=	'										<tr'.'>';
		$this->_msg .=	'											<td align='.'"center" style="text-align: center;">';
		$this->_msg .=	'												<img src='.'"https://www.lycee-louis-vincent.fr/images/icons/puddingcam-logo.png" alt="logo" width="43" border="0">';
		$this->_msg .=	'											</td'.'>';
		$this->_msg .=	'										</tr'.'>';
		$this->_msg .=											$this->trSeparator;
		$this->_msg .=	'										<tr'.'>';
		$this->_msg .=	'											<td align='.'"center" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; font-size: 40px; color: #f3f3f3; mso-line-height-rule: exactly; line-height: 28px;">';
//		$_SESSION['msg'] = $this->_msg;

	}

	public function classicMail(){
//		A voir si besoin du $_SESSION
//		$this->_msg .= $_SESSION['msg'];
		$this->_msg .= 									$this->title.'
														<hr color="#F39237">
													</td>
												</tr>
												'.$this->trSeparator.'
												<tr>
													<td align="center" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; color: #DCDCDC; mso-line-height-rule: exactly; line-height: 26px;">
													'.$this->message.'
													</td>
												</tr>
												'.$this->trSeparator.'
												
												</tr>
												'.$this->trSeparator.'
											</tbody>
										</table>
									</div>
									<!--[if gte mso 9]>
									</v:textbox>
									</v:rect>
									<![endif]-->
								</td>
							</tr>
						</tbody>
					</table>
				</body>
			</html>';
		$this->_msg .= "\r\n\r\n";

		// --------------
		// Send
		// --------------
		$this->SendMail();

	}

	public function confirmSubscribeMail(){

		$_link = $this->base_url . 'register/validation?log=' .
			urlencode($this->login) . '&cle=' . urlencode($this->_cle);
//		$this->_msg .= $_SESSION['msg'];
		$this->_msg .= 									$this->title.'
														<hr color="#F39237">
													</td>
												</tr>
												'.$this->trSeparator.'
												<tr>
													<td align="center" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; color: #DCDCDC; mso-line-height-rule: exactly; line-height: 26px;">
													'.$this->message.'
													</td>
												</tr>
												'.$this->trSeparator.'
													<td align="center" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; color: #DCDCDC; mso-line-height-rule: exactly; line-height: 26px;">
															Pour activer ton compte, clique sur le lien ci dessous.
													</td>
												</tr>
												<tr>
													'.$this->trSeparator.'
												</tr>
												<tr>
													<td align="center">
														<table align="center" width="240px" cellspacing="0" cellpadding="0">
															<tbody>
																<tr>
																	<td align="center" height="60px" bgcolor="#F39237" style="border-radius: 30px; text-align: center; font-size: 18px; font-family: \'Cairo\', Helvetica, sans-serif; color: #f3f3f3; text-decoration: none;" valign="middle">
																		<a href="http://'.$_link.'" style="font-family: Cairo, Helvetica, sans-serif; text-align: center; font-size: 18px; color: #f3f3f3; text-decoration: none;line-height: 60px;display: block;height: 60px;">Valider mon compte</a>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												</tr>
												'.$this->trSeparator.'
											</tbody>
										</table>
									</div>
									<!--[if gte mso 9]>
									</v:textbox>
									</v:rect>
									<![endif]-->
								</td>
							</tr>
						</tbody>
					</table>
				</body>
			</html>';

		$this->_msg .= "\r\n\r\n";
		echo $this->_msg;
		$this->SendMail();
	}

	public function SendMail(){

		$destinataire = $this->email;
		$expediteur = $this->from;
		$reponse = $expediteur;
		$reply = "Reply-to: $reponse\r\nFrom: $expediteur\r\n" . $this->_entete;
		mail($destinataire,
			$this->subject,
			$this->_msg,
			$reply);
//		$_SESSION['msg'] = NULL;
	}
}







///**
// * Created by PhpStorm.
// * User: jmarsal
// * Date: 2/2/17
// * Time: 2:09 PM
// */
//class MailSender extends Mail
//{
//	public $base_url;
//	public $subject;
//	public $title;
//	public $message;
//	private $_msg;
//	private $_cle;
//	private $_entete;
//
//	public function __construct($email, $login, $subject, $title,  $message,
//$from, $cle = NULL)
//	{
//		$this->email = $email;
//		$this->login = $login;
//		$this->subject = $subject;
//		$this->title = $title;
//		$this->message = $message;
//		$this->from = $from;
//		$this->base_url = $_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
//
//
//		if (isset($cle) && !empty($cle)){
//			$this->_cle = $cle;
//		}
//		//----------------------------------
//		// Construction de l'entête
//		//----------------------------------
//		$delimiter = "-----=" . md5(uniqid(rand()));
//		$this->_entete = "MIME-Version: 1.0\r\n";
//		$this->_entete .= "Content-Type: multipart/related; boundary=\"$delimiter\"\r\n";
//		$this->_entete .= "\r\n";
//		//--------------------------------------------------
//		// Construction du message proprement dit
//		//--------------------------------------------------
//		$this->_msg = "Je vous informe que ceci est un message au format MIME 1.0 multipart/mixed.\r\n";
//		//---------------------------------
//		// 1ère partie du message
//		// Le code HTML
//		//---------------------------------
//		$this->_msg .= "--$delimiter\r\n";
//		$this->_msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
//		$this->_msg .= "Content-Transfer-Encoding:8bit\r\n";
//		$this->_msg .= "\r\n";
//
//		// ---------------------------
//		// Content message
//		// ---------------------------
////		$this->_msg .= file_get_contents('core/Mail/template/header.html');
////		$this->_msg .= file_get_contents('core/Mail/template/bodyStruct.html');
//
//
//		$this->_msg .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
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
//		$this->_msg .= "\r\n\r\n";
//
//
//	}
//
//	public function classicMail(){
//		$this->_msg .= 	str_replace('^^message^^', $this->message, str_replace
//		('^^title^^',
//			$this->title,
//			file_get_contents('core/Mail/template/bodyClassicMail.html')));
//
//		$this->_msg .= "\r\n\r\n";
//		$this->SendMail();
//	}
//
//	public function confirmSubscribeMail(){
//
////		$_link = $this->base_url . 'register/validation?log=' .
////			urlencode($this->login) . '&cle=' . urlencode($this->_cle);
////
////
////		$this->_msg .= 	str_replace('^^link^^', $_link,
////			str_replace('^^message^^', $this->message, str_replace
////		('^^title^^',
////			$this->title,
////				file_get_contents('core/Mail/template/bodySubscribeMail.html')
////			)));
////		$this->_msg .= "\r\n\r\n";
//
//		$this->SendMail();
//	}
//
//	public function SendMail(){
//
//		$destinataire = $this->email;
//		$expediteur = $this->from;
//		$reponse = $expediteur;
//		$reply = "Reply-to: $reponse\r\nFrom: $expediteur\r\n" . $this->_entete;
//		mail($destinataire,
//			$this->subject,
//			$this->_msg,
//			$reply);
//	}
//}