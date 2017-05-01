<?php

class RegisterController extends Controller
{
	public $formOk = 0;
	public $mess_error = "";
	public $login = "";
	public $email = "";
	public $passwd = "";
	public $repPasswd = "";
	public $hashPasswd = "";
	public $popup;
	public $info;

	public function accueil(){
	    if (!empty($_POST['click']) && $_POST['click'] === 'click'){
            $this->loadModel('User');

            $this->info = $this->checkFormRegister();
            if (!empty($this->mess_error) && $this->mess_error !== 'true'){
                $this->info = "";
                return $this->json(200, [
                    "messError" => $this->mess_error,
                ]);
            } else {
                return $this->json(200, [
                    "info" => $this->info,
					"baseUrl" => BASE_URL
                ]);
            }
        }
        if (!empty($_POST['sendMail'])){
            $options = array(
                "login" => $_POST['infoLogin'],
                "email" => $_POST['infoMail'],
                'subject' => 'Inscription a CAMAGRU',
			    'message' => '',
			    'title' => '',
			    'from' => '',
                "cle" => $_POST['infoCle']
            );
            $mailReinit = new MailSender($options);
            $mailReinit->confirmSubscribeMail();
            return $this->json(200);
        }
        if (empty($_POST['click']) && empty($_POST['sendMail'])) {
            $this->render('pages/register', 'register_layout');
        }
	}

	//			Check le formulaire de la page register
	public function checkFormRegister(){
        if ($this->_getFormRegister()) {
            $this->formOk = 1;
            if (Mail::validEmail($this->email) !== TRUE){
                $this->mess_error = 'Veuillez renseigner une adresse email valide!';
                $this->formOk = 0;
            }
            if ($this->formOk == 1){
                if ($this->repPasswd !== $this->passwd){
                    $this->mess_error = 'Les deux champs de mot de passe ne sont pas identiques!';
                    $this->formOk = 0;
                }
                //Decommenter _sendMailRegister dans addUser
                if ($this->formOk == 1 && ($info = $this->User->addUser($this->login,
                        $this->email, $this->hashPasswd)) != FALSE){
                    $this->mess_error = "";
                    $this->popup = str_replace('^^email^^', $this->email,
                        str_replace('^^login^^', $this->login,
                            file_get_contents(ROOT.DS.'view'.DS .'register'.DS.'pages'.DS.'popupRegister.html')));
                    if (empty($info['login'])){
                        $this->mess_error = $info;
                        return false;
                    }
                    $info['popup'] = $this->popup;
                    return $info;
                }
            }
        }
	}

	private function _getFormRegister(){
		if (empty($_POST['login']) && empty($_POST['passwd'])){
			$this->mess_error = 'Veuillez saisir tous les champs !';
			return FALSE;
		} else if (!empty($_POST['login'])){
			$this->login = trim(htmlentities($_POST['login']));
		} else{
			$this->mess_error = 'Le champ Login est vide!';
			return FALSE;
		}
		if (!empty($_POST['email'])){
			$this->email = trim(htmlentities($_POST['email']));
		}else{
			$this->mess_error = 'Veuillez renseigner votre adresse email!';
			return FALSE;
		}
		if (!empty($_POST['passwd'])){
			$this->passwd = trim(htmlentities($_POST['passwd']));
			$this->hashPasswd = hash('sha256', trim(htmlentities($this->passwd)));
		} else {
			$this->mess_error = 'Veuillez renseigner un mot de passe!';
			return FALSE;
		}

		if (!empty($_POST['repPasswd'])){
			$this->repPasswd = trim(htmlentities($_POST['repPasswd']));
			$this->hashPasswd = hash('sha256', trim(htmlentities($this->repPasswd)));
		}else{
			$this->mess_error = 'Le champ de verification de mot de passe est vide!';
			return FALSE;
		}
		return TRUE;
	}

	public function validation(){
		$this->loadModel('User');

		if (isset($_GET['log'], $_GET['cle']) &&
			!empty($_GET['log']) && !empty($_GET['cle'])){
			$log = htmlentities(trim($_GET['log']));
			$cle = htmlentities(trim($_GET['cle']));
			if (($this->User->checkValueOfGetForValidation($log, $cle)) ===
				TRUE){
				$this->User->changeKeyUser($log);
				$this->User->changeActifUser($log);
				$this->redirection();
			}else{
				echo $this->mess_error = 'Le Login ne correspond pas a la cle de validation';
				die();
			}
		}else{
			echo $this->mess_error = 'Le Login et / ou la cle de validation sont vides';
			die();
		}
	}
}
?>