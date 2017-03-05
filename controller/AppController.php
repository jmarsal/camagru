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
			$this->render('appCamagru', 'app_layout');
			$this->_getDataImg();
			$this->_printPreview();
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
			$this->Photo->createDirectoryIfNotExist(REPO_PHOTO, 0755);
            $this->Photo->createDirectoryIfNotExist(REPO_PHOTO.DS.'min', 0755);
			$this->Photo->savePhotoTmpToDb($idUser, $_POST['getSrc'], REPO_PHOTO);
			$_POST['getSrc'] = "";
		}
	}

	private function _printPreview(){
		if ($this->Photo->countPreviewImg()){
			$img = $this->Photo->getPreviewImg();
			$_SESSION['img'] = $img;
		}
	}
}