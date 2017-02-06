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

	public function __construct($options)
	{
		$this->email = $options['email'];
		$this->login = $options['login'];
		$this->subject = $options['subject'];
		$this->title = $options['title'];
		$this->message = $options['message'];
		$this->from = $options['from'];
		$this->base_url = $_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
		$this->_delimiteur = "-----=".md5(uniqid(rand()));


		if (isset($options['cle']) && !empty($options['cle'])){
			$this->_cle = $options['cle'];
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
		date_default_timezone_set('UTC');
		$date = date('d F Y');
		if (empty($this->title)){
			$this->title = 'Newsletter du '.$date;
		}
		if (empty($this->from)){
			$this->from = 'newsletter@camagru.com';
		}
		$this->_msg .= str_replace('^^title^^', $this->title,
			file_get_contents("core/Mail/template/newsMail.html"));
		$this->_msg .= "\r\n\r\n";
		$this->SendMail();

	}

	public function confirmSubscribeMail(){
		if (empty($this->title)){
			$this->title = 'Bienvenue sur Camagru !';
		}
		if (empty($this->from)){
			$this->from = 'insciption@camagru.com';
		}
		$_link = $this->base_url . 'register/validation?log=' .
			urlencode($this->login) . '&cle=' . urlencode($this->_cle);
		$this->_msg .= str_replace('^^title^^', $this->title, str_replace('^^login^^',
			ucfirst
			($this->login) ,
			str_replace('^^link^^',
			$_link, file_get_contents
		("core/Mail/template/subscribeMail.html"))));

		$this->_msg .= "\r\n\r\n";
		$this->SendMail();
	}

	public function SendMail(){

		$destinataire = $this->email;
		$expediteur = $this->from;
		$reponse = $expediteur;
		$reply = "Reply-to: $reponse\r\nFrom: $expediteur\r\n" . $this->_entete;
//		echo $this->_msg;
		mail($destinataire,
			$this->subject,
			$this->_msg,
			$reply);
	}
}