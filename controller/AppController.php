<?php
if (!isset($_SESSION)){
    session_start();
}
class AppController extends Controller
{
	public function appCamagru(){
	    if ((!empty($_SESSION['log']) && $_SESSION['log'] == 1) && !empty
			($_SESSION['login']) || !empty($_COOKIE['camagru-log'])){
            if (!empty($_POST['filter'])) {
                $_SESSION['filter'] = $_POST['filter'];
                var_dump($_SESSION['filter']);
            }
            if (!empty($_SESSION['img'])){
                foreach ($_SESSION['img'] as $v){
                    if (!isset($_SESSION[$v['id']]['namePhoto']) || empty($_SESSION[$v['id']]['namePhoto'])){
                        $_SESSION[$v['id']]['namePhoto'] = 'Nom pour votre Photo ?';
                    }
                }
            }
            $this->loadModel('Photo');
            $this->loadModel('User');

            setcookie('camagru-log', $_SESSION['login'], time() + 31556926);
            if (empty($_SESSION['login'])){
                $_SESSION['login'] = $_COOKIE['camagru-log'];
            }
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

    public function uploadPhotoAjax(){
        if (!empty($_POST['error']) || !empty($_POST['messFileImg'])){
            if (!empty($_POST['error'])){
                $_SESSION['errorOrFileUpload'] = $_POST['error'];
            } else {
                $_SESSION['errorOrFileUpload'] = $_POST['messFileImg'];
                $_SESSION['colorMessUpload'] = $_POST['color'];
            }
        }
        if (!empty($_POST['file']) && !empty($_POST['src'])) {
            $_SESSION['fileUpload'] = $_POST['file'];
            $_SESSION['srcUpload'] = $_POST['src'];
//            var_dump($_SESSION['srcUpload']);
            return $this->json(200);
        }
        return $this->json(400);
    }

    public function backCameraAjax(){
        if (!empty($_POST['back'])) {
            $_SESSION['srcUpload'] = "";
            $_SESSION['fileUpload'] = "";
            $_SESSION['colorMessUpload'] = "";
            $_SESSION['errorOrFileUpload'] = "";

            return $this->json(200);
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
            $_SESSION['objFilter'] = $_POST['objFilter'];
            return $this->json(200);
        }
        return $this->json(400);
    }

    public function galerieCamagru(){
        $this->redirection('galerie', 'galerieCamagru');
    }

    public function getNamePhoto() {
        if (!empty($_POST['namePhoto']) && !empty($_POST['id'])) {
            $this->loadModel('Photo');

            $name = htmlentities(trim($_POST['namePhoto']));
            $this->Photo->saveNamePhotoToDb($_POST['id'], $name);
            $_SESSION[$_POST["id"]."namePhoto"] = $name;

            return $this->json(200);
        }
        return $this->json(400);
    }

    /**
     * Recupere l'image et l'enregistre dans la Db
     */
	private function _getDataImg(){
        $this->Photo->createDirectoryIfNotExist(REPO_PHOTO, 0755);
        $idUser = $this->User->getIdUser($_SESSION['login']);
		$this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS, 0755);
        $this->Photo->createDirectoryIfNotExist(REPO_PHOTO.$idUser.DS.'min'.DS, 0755);

        if (isset($_SESSION['filter']) && $_SESSION['filter'] !== 'none'){
            $filter = $_SESSION['filter'];
        } else {
            $filter = 'none';
        }
        if (!empty($_SESSION['objFilter']) && $_SESSION['objFilter'] !== null){
            $filterObj = $_SESSION['objFilter'];
        } else {
            $filterObj = 'noneObj';
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