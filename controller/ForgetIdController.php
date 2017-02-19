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
		if (isset($_POST['email'])) {
//			Check le formulaire de la page forgetId
			$this->checkForgetId();
		}
		$this->render('pages/forgetId');

		if (isset($_ENV['email']) && isset($_ENV['login']) &&
			!empty($_ENV['email']) && !empty($_ENV['login'])){
			?><script language="javascript" type="text/javascript">
                var compte = 5;
                function decompte()
                {
                    if(compte <= 1) {
                        pluriel = "";
                    } else {
                        pluriel = "s";
                    }
                    document.getElementById("compt").innerHTML = compte + " seconde" + pluriel;
                    if(compte == 0 || compte < 0) {
                        compte = 0;
                        clearInterval(timer);
                    }
                    compte--;
                }
                document.getElementById("compt").innerHTML = compte + " secondes";
                var timer = setInterval('decompte()',1000);
                showPopup();
                setTimeout(changePageForAccueil, 4000);
                function changePageForAccueil(){
                    document.location.href="<?php echo BASE_URL ?>";
                }
            </script><?php
			$options = array('email' => $_ENV['email'],
				'login' => $_ENV['login'],
				'subject' => '',
				'message' => '',
				'title' => '',
				'from' => '',
				'cle' => $_ENV['cle']);
			$reinitMail = new MailSender($options);
			$reinitMail->reinitPassMail();
		}
	}

	public function checkForgetId(){
		$linkImg = BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS.'photo-camera.png';

		if ($_POST['submit'] === 'Récuperer' && !empty
			($_POST['email'])){
			$this->email = trim(htmlentities($_POST['email']));
			if (($options = $this->User->requestMail($this->email)) !==
                FALSE){
                $this->login = $options['login'];
                $this->cle = $options['cle'];
			    if ($options !== "Veuillez renseigner une adresse mail valide"){
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
						$_ENV['cle'] = $this->cle;
					}
                }else{
			        $this->mess_error = $options;
                }
			}else if ($options === FALSE){
				$this->mess_error = 'Cette adresse mail ne correspond à aucun
			utilisateur!';
			}
		} else if (isset($_POST['email']) && $_POST['submit'] === 'Récuperer'
			&& empty ($_POST['email'])){
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
//              vers l'app...
				if (($this->reinitForm($log)) === TRUE){
					$this->User->changeKeyUser($log);
					$_SESSION['log'] = 1;
					$_SESSION['login'] = $log;
					$this->redirection('app', 'appCamagru'); // Pb de
//					header('location: '.BASE_URL.DS.'view'.DS.'app'.DS.'appCamagru.php');
//                  redirection ici !!!!!!!!!!!!
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
//				Ici changer mot de passe dans la bdd depuis le model User
				$this->User->changePasswdUser($log, $this->newPasswd);
				return TRUE;
			}else{
				$this->newPasswd = $_POST['newPass'];
				$this->mess_error = 'Les deux champs de mot de passe ne sont pas identiques!';
				return FALSE;
			}
		}else if (isset($_POST['submitRe']) && $_POST['submitRe'] === 'Enregistrer'){
			if (!isset($_POST['newPass']) || empty($_POST['newPass'])){
				$this->mess_error = 'Veuillez renseigner un mot de passe!';
			}else{
			    $this->newPasswd = $_POST['newPass'];
				$this->mess_error = 'Le champ de verification de mot de passe est vide!';
			}
			return FALSE;
		}
	}
}