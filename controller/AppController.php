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
            $this->_printPreview();
//			var_dump($_SESSION);
            // die($_SERVER['HTTP_X_REQUESTED_WITH']);
			    $this->render('appCamagru', 'app_layout');
		} else {
	        $this->redirection();
        }
	}

    public function uploadAjax(){
        // recupere le lien a afficher sur la page
        if (!empty($_POST['img64'])){
            $this->loadModel('Photo');
            $this->loadModel('User');

//          recupere le tab avec path + id
            $imgPrev = $this->_getDataImg();

//          Creer methode dans photo pour get l'id
//          Besoin de la derniere id inseree par pdo.
                return $this->json(200, [
                    "thumbnail" => $imgPrev
//                    ,
//                    "id" => $id
                ]);
        }
        return $this->json(400);
    }

    public function delAjax(){
        $this->json(200);
    }

    /**
     * Recupere l'image et l'enregistre dans la Db
     */
	private function _getDataImg(){
        $this->Photo->createDirectoryIfNotExist(REPO_PHOTO, 0755);
        $idUser = $this->User->getIdUser($_SESSION['login']);
		$this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS, 0755);
        $this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS.'min'.DS, 0755);

        if (!empty($_SESSION['filter'])){
            $filter = $_SESSION['filter'];
        } else {
            $filter = 'none';
        }
        $pathMin = $this->Photo->savePhotoTmpToDb($idUser, $_POST['img64'], REPO_PHOTO.DS.$idUser, $filter);
        $_POST['img64'] = "";
        return $pathMin;
	}

	private function _printPreview(){
        $idUser = $this->User->getIdUser($_SESSION['login']);
		if ($this->Photo->countPreviewImg($idUser)){
			$img = $this->Photo->getPreviewImg($idUser);
			$_SESSION['img'] = $img;
		}
	}
}