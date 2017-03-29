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
    public $cle = "";
    public $popup;
    public $newPasswd = "";

    public function accueil(){
        $this->loadModel('User');

        if (!empty($_POST['click']) && $_POST['click'] === 'click'){
            if (!empty($_POST['email'])){
                $info = $this->checkForgetId();
//                Je dois certainement renvoyer le mail par ici...
                if (!empty($this->mess_error)){
                    return $this->json(200, [
                        "messError" => $this->mess_error,
                    ]);
                } else {
                    return $this->json(200, [
                        "popup" => $info
                    ]);
                }
            }
        }
        if (!empty($_POST['sendMail']) && $_POST['sendMail'] === 'ok'){
            $options = array(
                    "login" => $_POST['infoLogin'],
                    "email" => $_POST['infoMail'],
                    "cle" => $_POST['infoCle']
            );
            $mailReinit = new MailSender($options);
            $mailReinit->reinitPassMail();
            return $this->json(200);
        }
        $this->render('pages/forgetId');
    }

	public function checkForgetId(){
		$linkImg = BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";

		if ($_POST['click'] === 'click' && !empty($_POST['email'])){
			$this->email = trim(htmlentities($_POST['email']));
			if (($options = $this->User->requestMail($this->email)) !==
                FALSE){
			    if ($options !== "Veuillez renseigner une adresse mail valide"){
                    $this->login = $options['login'];
                    $this->cle = $options['cle'];
//				Ne doit afficher la popup que si les champs sont charges...
					$this->popup = str_replace('^^email^^', $this->email,
						            str_replace('^^login^^', $this->login,
							        str_replace('^^logo^^',$linkImg,
								file_get_contents(ROOT.DS.'view'.DS.'forgetId'.DS.'pages'.DS.'popupForgetId.html'))));
					if (!empty($this->email) && !empty($this->login)){
					    $info = array(
                            "login" => $this->login,
                            "email" => $this->email,
                            "cle" => $this->cle,
                            "popup" => $this->popup
                        );
                        return $info;
					}
                }else{
			        $this->mess_error = $options;
                }
			}else if ($options === FALSE){
				$this->mess_error = 'Cette adresse mail ne correspond à aucun
			utilisateur!';
			}
		} else if ($_POST['click'] === 'click' && empty ($_POST['email'])){
			$this->mess_error = 'Veuillez renseigner une adresse mail !';
		}
	}

	public function reinit(){
		$this->loadModel('User');
		if (isset($_GET['log'], $_GET['cle']) &&
			!empty($_GET['log']) && !empty($_GET['cle'])){
			$log = htmlentities(trim($_GET['log']));
			$cle = htmlentities(trim($_GET['cle']));
			if (($this->User->checkValueOfGetForValidation($log, $cle)) ===
				TRUE){
//			    Si tout c'est bien passer, je change la key user et redirige
//              vers l'accueil...
				if (($this->reinitForm($log)) === TRUE){
					$this->User->changeKeyUser($log);
                    $this->redirection();
				}
			}else{
				$this->mess_error = 'Le Login ne correspond pas a la cle de validation';
				die();
			}
		}else{
			$this->mess_error = 'Le Login et / ou la cle de validation sont vides';
			die();
		}
		$this->render('pages/reinit');
	}

	public function reinitForm($log){
		if (isset($_POST['submitRe']) && $_POST['submitRe'] === 'Enregistrer' &&
			isset($_POST['newPass']) && !empty($_POST['newPass']) && isset
            ($_POST['repNewPass']) && !empty($_POST['repNewPass'])){
			if ($_POST['newPass'] === $_POST['repNewPass']){
				$this->newPasswd = hash('sha256', trim(htmlentities($_POST['repNewPass'])));
				$this->User->changeActifUser($log);
				$this->User->changePasswdUser($log, $this->newPasswd);
				return TRUE;
			}else{
				$this->newPasswd = trim(htmlentities($_POST['newPass']));
				$this->mess_error = 'Les deux champs de mot de passe ne sont pas identiques!';
				return FALSE;
			}
		}else if (isset($_POST['submitRe']) && $_POST['submitRe'] === 'Enregistrer'){
			if (!isset($_POST['newPass']) || empty($_POST['newPass'])){
				$this->mess_error = 'Veuillez renseigner un mot de passe!';
			}else{
			    $this->newPasswd = trim(htmlentities($_POST['newPass']));
				$this->mess_error = 'Le champ de verification de mot de passe est vide!';
			}
			return FALSE;
		}
	}
}