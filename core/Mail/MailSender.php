<?php

/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/2/17
 * Time: 2:09 PM
 */
class MailSender
{
	public $base_url;
	public $subject;
	public $title;
	public $message;
	private $_msg;
	private $_cle;
	private $_entete;
	private $_delimiteur;

	public function __construct($email, $login, $subject, $title,  $message,
								$from, $cle = NULL)
	{
		$this->email = $email;
		$this->login = $login;
		$this->subject = $subject;
		$this->title = $title;
		$this->message = $message;
		$this->from = $from;
		$this->base_url = $_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
		$this->_delimiteur = "-----=".md5(uniqid(rand()));


		if (isset($cle) && !empty($cle)){
			$this->_cle = $cle;
		}

		//----------------------------------
		// Construction de l'entête
		//----------------------------------

		$this->_entete = "MIME-Version: 1.0\r\n";
		$this->_entete .= "Content-Type: multipart/related; boundary=\"$this->_delimiteur\"\r\n";
		$this->_entete .= "\r\n";

		//--------------------------------------------------
		// Construction du message proprement dit
		//--------------------------------------------------

		$this->_msg = "Je vous informe que ceci est un message au format MIME 1.0 multipart/mixed.\r\n";

		//---------------------------------
		// 1ère partie du message
		// Le code HTML
		//---------------------------------
		$this->_msg .= "--$this->_delimiteur\r\n";
		$this->_msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
		$this->_msg .= "Content-Transfer-Encoding:8bit\r\n";
		$this->_msg .= "\r\n";

	}

	public function newsMail(){

		$this->_msg .= file_get_contents("core/Mail/template/newsMail.html");
		$this->_msg .= "\r\n\r\n";
		$this->_msg .= "--$this->_delimiteur\r\n";
		$this->SendMail();

	}

	public function confirmSubscribeMail(){

		$_link = $this->base_url . 'register/validation?log=' .
			urlencode($this->login) . '&cle=' . urlencode($this->_cle);
		echo $_link;die();
		$this->_msg .= file_get_contents("core/Mail/template/subscribeMail.html");

		$this->_msg .= "\r\n\r\n";
		$this->_msg .= "--$this->_delimiteur\r\n";
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
	}
}