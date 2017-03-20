<?php
if (!isset($_SESSION)){
    session_start();
}
class AppController extends Controller
{
//    private $_tabImg = null;

	public function appCamagru(){
	    if ((isset($_SESSION['log']) && $_SESSION['log'] == 1) && !empty
			($_SESSION['login']) || !empty($_COOKIE['camagru-log'])){
            if (!empty($_POST['filter'])) {
                $_SESSION['filter'] = $_POST['filter'];
            }
            $this->loadModel('Photo');
            $this->loadModel('User');
            $_SESSION['login'] = $_COOKIE['camagru-log'];
            $_SESSION['log'] = 1;
            $this->_printPreview();
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
            $idMin = $imgPrev['idMin'];
            $idBig = $imgPrev['idBig'];
            $thumbnail = $imgPrev['path'];
            $_SESSION['tabImg'][$idMin]['idMin'] = $idMin;
            $_SESSION['tabImg'][$idMin]['idBig'] = $idBig;
            return $this->json(200, [
                "thumbnail" => $thumbnail,
                "idMin" => $idMin
            ]);
        }
        return $this->json(400);
    }

    public function delAjax(){
        if (!empty($_POST['delImg'])){
            if (!empty($_SESSION['tabImg'][$_POST['delImg']]['idMin'])){
                $this->loadModel('Photo');
                $this->Photo->destroyPhoto($_SESSION['tabImg'][$_POST['delImg']]);
                unset($_SESSION['tabImg'][$_POST['delImg']]);
               return $this->json(200);
            }
        }
        return $this->json(400);
    }

    public function enlargeAjax(){
        if (!empty($_POST['enlargeImg'])){
            $this->loadModel('Photo');
            $pathImg = $this->Photo->getImg($_SESSION['tabImg'][$_POST['enlargeImg']]['idBig']);

            return $this->json(200, [
                "idMin" => $_SESSION['tabImg'][$_POST['enlargeImg']]['idMin'],
                "idBig" => $pathImg
            ]);
        }
        return $this->json(400);
    }

    public function objFilterAjax(){
        if (!empty($_POST['objFilter'])) {
            $this->loadModel('Photo');
            $_SESSION['objFilter'] = $_POST['objFilter'];

            return $this->json(200);
        }
        return $this->json(400);
    }

    public function galerieCamagru(){
        $this->redirection('galerie', 'galerieCamagru');
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
        if (!empty($_SESSION['objFilter'])){
            $filterObj = $_SESSION['objFilter'];
        } else {
            $filterObj = null;
        }
        $tabPathId = $this->Photo->savePhotoTmpToDb($idUser, $_POST['img64'], REPO_PHOTO.DS.$idUser, $filter, $filterObj);
        $_POST['img64'] = "";
        return $tabPathId;
	}

	private function _printPreview(){
        $idUser = $this->User->getIdUser($_SESSION['login']);
		if ($this->Photo->countPreviewImg($idUser)){
			$img = $this->Photo->getPreviewImg($idUser);
			$_SESSION['img'] = $img;
		}
	}
}