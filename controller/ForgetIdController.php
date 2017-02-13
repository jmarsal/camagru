<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 3:00 PM
 */
class ForgetIdController extends Controller
{
	public $mess_error;
	public $login = "";
	public $email = "";
	public $popup;

	public function accueil(){
		$this->loadModel('User');
		if (isset($_POST['email'])) {
//			Check le formulaire de la page forgetId
			$this->checkForgetId();
		}
		$this->render('pages/forgetId');

		if (isset($_ENV['email']) && isset($_ENV['login']) &&
			!empty($_ENV['email']) && !empty($_ENV['login'])){
			?><script>showPopup();</script><?php
		}
	}

	public function checkForgetId(){
		$linkImg = BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png';

		if ($_POST['submit'] === 'Récuperer' && !empty
			($_POST['email'])){
			$this->email = trim(htmlentities($_POST['email']));
			if (($user_exist = $this->User->requestMail($this->email)) !==
                FALSE){
                $this->login = $user_exist;
			    if ($user_exist !== "Veuillez renseigner une adresse mail valide"){
//				Ne doit afficher la popup que si les champs sont charges...
					$this->popup = str_replace('^^email^^', $this->email,
						str_replace
						('^^login^^', $this->login,
							str_replace
							('^^logo^^',$linkImg,
								file_get_contents
								(ROOT.DS.'view'.DS
									.'forgetId'.DS.'pages'.DS.'popupForgetId.html')
							)));
					if (isset($this->email) && isset($this->login) &&
						!empty($this->email) && !empty($this->login)){
						$_ENV['login'] = $this->login;
						$_ENV['email'] = $this->email;
					}
                }else{
			        $this->mess_error = $user_exist;
                }
			}else if ($user_exist === FALSE){
				$this->mess_error = 'Cette adresse mail ne correspond à aucun
			utilisateur!';
			}
		} else if (isset($_POST['email']) && $_POST['submit'] === 'Récuperer'
			&& empty ($_POST['email'])){
			$this->mess_error = 'Veuillez renseigner une adresse mail !';
		}
	}
}