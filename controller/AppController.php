<?php
if (!isset($_SESSION)){
    session_start();
}
class AppController extends Controller
{
	public function appCamagru(){
	    if ((isset($_SESSION['log']) && $_SESSION['log'] == 1) && !empty
			($_SESSION['login'])||
            isset($_COOKIE['camagru-log']) && !empty($_COOKIE['camagru-log'])){
            if (isset($_POST['filter']) && !empty($_POST['filter'])) {
                $_SESSION['filter'] = $_POST['filter'];
            }
            $this->loadModel('Photo');
            $this->loadModel('User');
            $_SESSION['login'] = $_COOKIE['camagru-log'];
            $_SESSION['log'] = 1;
            $this->_getDataImg();
            $this->_printPreview();
//			var_dump($_SESSION);
			$this->render('appCamagru', 'app_layout');
		} else {
	        $this->redirection();
        }
	}

    /**
     * Recupere l'image et l'enregistre dans la Db
     */
	private function _getDataImg(){
        $this->Photo->createDirectoryIfNotExist(REPO_PHOTO, 0755);
        if (isset($_POST['getSrc']) && !empty($_POST['getSrc'])){
            $idUser = $this->User->getIdUser($_SESSION['login']);
			$this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS, 0755);
            $this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS.'min'.DS, 0755);
            if (isset($_SESSION['filter']) && !empty($_SESSION['filter'])){
                $filter = $_SESSION['filter'];
            } else {
                $filter = 'none';
            }
            $this->Photo->savePhotoTmpToDb($idUser, $_POST['getSrc'], REPO_PHOTO.DS.$idUser, $filter);
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