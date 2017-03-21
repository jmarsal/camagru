<?php
if (!isset($_SESSION)){
    session_start();
}

/**
 * Created by PhpStorm.
 * User: jbmar
 * Date: 20/03/2017
 * Time: 09:02
 */
class GalerieController extends Controller
{
    public function galerieCamagru(){
        if ((isset($_SESSION['log']) && $_SESSION['log'] == 1) && !empty
            ($_SESSION['login']) || !empty($_COOKIE['camagru-log'])){
            $this->loadModel('User');
            $this->loadModel('Photo');
            $this->loadModel('Post');

            $_SESSION['filter'] = "";
            $_SESSION['objFilter'] = "";
            $idLog = $this->User->getIdUser($_SESSION['login']);
            $this->Photo->deletePrevInDb($idLog);
            $_SESSION['galerie'] = $this->Post->getPhotosInDb();
            $_SESSION['interactions'] = $this->Post->getLikeCommentInDb();
            $this->render('galerieCamagru', 'galerie_layout');
            unset($_SESSION['galerie']);
            unset($_SESSION['interactions']);
        } else {
            $this->redirection();
        }
    }

    public function appCamagru(){
        $this->redirection('app', 'appCamagru');
    }

    public function delAjaxGalerie(){
        if (!empty($_POST['delImgGalerie'])){
            $this->loadModel('Photo');

            $this->Photo->destroyBigImgInGalerie($_POST['delImgGalerie']);
            return $this->json(200);
        } else {
            return $this->json(400);
        }
    }

    public function likeAjaxGalerie(){
        if (!empty($_POST['likeImgGalerie'])){
            $this->loadModel('Post');
            $this->loadModel('User');

            $idUser = $this->User->getIdUser($_SESSION['login']);
            if ($_SESSION['interactions'])
            return $this->json(200);
        } else {
            return $this->json(400);
        }
    }
}