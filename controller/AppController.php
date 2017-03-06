<?php
if (!isset($_SESSION)){
    session_start();
}
class AppController extends Controller
{
	public function appCamagru(){
	    if ((isset($_SESSION['log']) && $_SESSION['log'] == 1) ||
            !empty($_COOKIE['camagru-log'])){
			$this->loadModel('Photo');
            $this->loadModel('User');
            $_SESSION['login'] = $_COOKIE['camagru-log'];
            $_SESSION['log'] = 1;
			$this->_getDataImg();
			$this->_printPreview();
			$this->render('appCamagru', 'app_layout');
		} else {
	        $this->redirection();
        }
	}

    /**
     * Recupere l'image et l'enregistre dans la Db
     */
	private function _getDataImg(){
		if (!empty($_POST)){
            $idUser = $this->User->getIdUser($_SESSION['login']);
			$this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS, 0755);
            $this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS.'min'.DS, 0755);
			$this->Photo->savePhotoTmpToDb($idUser, $_POST['getSrc'], REPO_PHOTO.DS.$idUser);
			$_POST['getSrc'] = "";
		}
	}

	private function _printPreview(){
        $idUser = $this->User->getIdUser($_SESSION['login']);
		if ($this->Photo->countPreviewImg($idUser)){
			$img = $this->Photo->getPreviewImg($idUser);
			$_SESSION['img'] = $img;
		}
	}
}